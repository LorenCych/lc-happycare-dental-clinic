<?php

namespace App\Http\Controllers\Registrant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Send SMS notification using IPROG SMS API
     */
    private function sendSmsNotification($phoneNumber, $message)
    {
        try {
            $apiToken = env('IPROG_SMS_API_TOKEN');
            
            // Debug logging
            Log::info('SMS API: Attempting to send SMS', [
                'phone' => $phoneNumber,
                'message_length' => strlen($message),
                'api_token_set' => !empty($apiToken),
                'api_token_preview' => $apiToken ? substr($apiToken, 0, 8) . '...' : 'NOT SET'
            ]);
            
            // Build URL with query parameters (as per IPROG API format)
            $params = [
                'api_token' => $apiToken,
                'message' => $message,
                'phone_number' => $phoneNumber
            ];
            
            $url = 'https://sms.iprogtech.com/api/v1/sms_messages?' . http_build_query($params);
            
            Log::info('SMS API: Sending POST request to ' . substr($url, 0, strpos($url, '?') + 15) . '...');
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            // Enhanced logging
            Log::info('SMS API: Response received', [
                'http_code' => $httpCode,
                'response' => $response,
                'curl_error' => $curlError,
                'phone' => $phoneNumber
            ]);
            
            if ($response === false) {
                Log::error('SMS API: cURL request failed', ['curl_error' => $curlError]);
                return false;
            }
            
            if ($httpCode === 200) {
                Log::info('SMS sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $response
                ]);
                return true;
            } else {
                Log::error('SMS API: HTTP error', [
                    'http_code' => $httpCode,
                    'response' => $response,
                    'phone' => $phoneNumber
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error('SMS API: Exception occurred', [
                'message' => $e->getMessage(),
                'phone' => $phoneNumber,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    //
    public function viewUpcomingAppointments(Request $request)
    {
        $userId = $request->query('user_id') ?? $request->get('user_id');
        $user = null;
        $appointments = [];
        
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                // Build query with base conditions
                $query = \App\Models\Appointment::where('user_id', $user->id)
                    ->where('appointment_sched', '>=', now())
                    ->with(['services', 'dentist']);

                // Apply status filter
                if ($request->has('status') && $request->status != '') {
                    $query->where('status', $request->status);
                } else {
                    // Default: exclude withdrawn unless specifically requested
                    $query->where('status', '!=', 'withdrawn');
                }

                // Apply date filter
                if ($request->has('date_filter') && $request->date_filter != '') {
                    switch ($request->date_filter) {
                        case 'today':
                            $query->whereDate('appointment_sched', today());
                            break;
                        case 'tomorrow':
                            $query->whereDate('appointment_sched', today()->addDay());
                            break;
                        case 'this_week':
                            $query->whereBetween('appointment_sched', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ]);
                            break;
                        case 'this_month':
                            $query->whereMonth('appointment_sched', now()->month)
                                  ->whereYear('appointment_sched', now()->year);
                            break;
                        case 'this_year':
                            $query->whereYear('appointment_sched', now()->year);
                            break;
                    }
                }

                // Apply search filter
                if ($request->has('search') && $request->search != '') {
                    $searchTerm = $request->search;
                    $query->where(function($q) use ($searchTerm) {
                        $q->where('appointee_name', 'ILIKE', '%' . $searchTerm . '%')
                          ->orWhere('other_services', 'ILIKE', '%' . $searchTerm . '%')
                          ->orWhereHas('services', function($serviceQuery) use ($searchTerm) {
                              $serviceQuery->where('service_name', 'ILIKE', '%' . $searchTerm . '%');
                          })
                          ->orWhereHas('dentist', function($dentistQuery) use ($searchTerm) {
                              $dentistQuery->where('first_name', 'ILIKE', '%' . $searchTerm . '%')
                                          ->orWhere('last_name', 'ILIKE', '%' . $searchTerm . '%')
                                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) ILIKE ?", ['%' . $searchTerm . '%']);
                          });
                    });
                }

                // Get filtered appointments
                $appointments = $query->orderBy('appointment_sched', 'asc')->get();
            }
        }
        
        return view('registrant.appointments.view-upcoming', compact('user', 'appointments'));
    }

    public function viewAppointmentHistory(Request $request)
    {
        $userId = $request->query('user_id') ?? $request->get('user_id');
        $user = null;
        $appointments = [];
        
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                // Build query with base conditions (all appointments, including past ones)
                $query = \App\Models\Appointment::where('user_id', $user->id)
                    ->with(['services', 'dentist']);

                // Apply status filter
                if ($request->has('status') && $request->status != '') {
                    $query->where('status', $request->status);
                }

                // Apply date range filter
                if ($request->has('date_range') && $request->date_range != '') {
                    switch ($request->date_range) {
                        case 'last_7_days':
                            $query->where('appointment_sched', '>=', now()->subDays(7));
                            break;
                        case 'last_30_days':
                            $query->where('appointment_sched', '>=', now()->subDays(30));
                            break;
                        case 'last_6_months':
                            $query->where('appointment_sched', '>=', now()->subMonths(6));
                            break;
                        case 'this_year':
                            $query->whereYear('appointment_sched', now()->year);
                            break;
                    }
                }

                // Apply search filter
                if ($request->has('search') && $request->search != '') {
                    $searchTerm = $request->search;
                    $query->where(function($q) use ($searchTerm) {
                        $q->where('appointee_name', 'ILIKE', '%' . $searchTerm . '%')
                          ->orWhere('other_services', 'ILIKE', '%' . $searchTerm . '%')
                          ->orWhereHas('services', function($serviceQuery) use ($searchTerm) {
                              $serviceQuery->where('service_name', 'ILIKE', '%' . $searchTerm . '%');
                          })
                          ->orWhereHas('dentist', function($dentistQuery) use ($searchTerm) {
                              $dentistQuery->where('first_name', 'ILIKE', '%' . $searchTerm . '%')
                                          ->orWhere('last_name', 'ILIKE', '%' . $searchTerm . '%')
                                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) ILIKE ?", ['%' . $searchTerm . '%']);
                          });
                    });
                }

                // Get filtered appointments ordered by most recent first
                $appointments = $query->orderBy('appointment_sched', 'desc')->get();
            }
        }
        
        return view('registrant.appointments.view-history', compact('user', 'appointments'));
    }

    public function bookAppointment(Request $request)
    {
        $userId = $request->query('user_id');
        $user = null;
        if ($userId) {
            $user = \App\Models\User::find($userId);
        }
        return view('registrant.appointments.book', compact('user'));
    }


    public function create(Request $request)
    {
        // Merge first, middle, and last name into appointee_name before validation
        $first = $request->input('first_name') ?? '';
        $middle = $request->input('middle_name') ? ' ' . $request->input('middle_name') : '';
        $last = $request->input('last_name') ? ' ' . $request->input('last_name') : '';
        $request->merge([
            'appointee_name' => trim($first . $middle . $last),
        ]);
        // Combine date and time from form into appointment_sched
        $date = $request->input('appointment_sched');
        $time = $request->input('appointment_time');
        $request->merge([
            'appointment_sched' => $date && $time ? ($date . ' ' . $time) : $date,
        ]);

        $validated = $request->validate([
            'appointee_name' => 'required|string|max:255',
            'appointment_sched' => 'required|date',
            'user_id' => 'required|string|exists:users,id',
            'service_id' => 'required|array',
            'service_id.*' => 'string|exists:services,id',
            'other_services' => 'nullable|string|max:500',
            //'dentist_id' => 'required|string|exists:admins,id',
            'status' => 'nullable|string|max:50',
        ]);

        // Validate clinic hours (8:00 AM - 5:00 PM)
        $appointmentDateTime = \Carbon\Carbon::parse($validated['appointment_sched']);
        $appointmentHour = $appointmentDateTime->hour;
        $appointmentMinute = $appointmentDateTime->minute;
        $timeInMinutes = $appointmentHour * 60 + $appointmentMinute;
        
        if ($timeInMinutes < 480 || $timeInMinutes > 1020) { // 8:00 AM = 480 minutes, 5:00 PM = 1020 minutes
            return back()->withErrors(['appointment_time' => 'Appointment time must be between 8:00 AM and 5:00 PM (clinic hours).'])->withInput();
        }

        // Validate appointment is not in the past
        if ($appointmentDateTime->isPast() || $appointmentDateTime->equalTo(now())) {
            return back()->withErrors(['appointment_time' => 'Appointment time cannot be in the past or current time. Please select a future date and time.'])->withInput();
        }

        // Check if time slot is available (server-side validation)
        $timeSlotBuffer = 30; // minutes
        $startWindow = $appointmentDateTime->copy()->subMinutes($timeSlotBuffer);
        $endWindow = $appointmentDateTime->copy()->addMinutes($timeSlotBuffer);
        
        $conflictingAppointments = \App\Models\Appointment::whereBetween('appointment_sched', [$startWindow, $endWindow])
            ->whereIn('status', ['pending', 'approved', 'confirmed'])
            ->count();
        
        $maxConcurrentAppointments = 3;
        if ($conflictingAppointments >= $maxConcurrentAppointments) {
            return back()->withErrors(['appointment_time' => 'This time slot is currently busy. Please choose a different time.'])->withInput();
        }

        $validated['status'] = 'pending';
        $serviceIds = $validated['service_id'];
        unset($validated['service_id']);

        $appointment = \App\Models\Appointment::create($validated);
        $appointment->services()->attach($serviceIds);

        // Send SMS notification to patient
        $user = \App\Models\User::find($validated['user_id']);
        
        Log::info('Appointment created, checking SMS notification', [
            'user_id' => $validated['user_id'],
            'user_found' => !is_null($user),
            'user_phone' => $user ? $user->contact_number : 'N/A'
        ]);
        
        if ($user && $user->contact_number) {
            // Format the appointment details for SMS
            $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_sched)->format('M j, Y \a\t g:i A');
            
            // Get services list
            $services = [];
            if ($appointment->services && $appointment->services->count()) {
                $services = $appointment->services->pluck('service_name')->toArray();
            }
            if ($appointment->other_services) {
                $services[] = $appointment->other_services;
            }
            $servicesList = count($services) > 0 ? implode(', ', $services) : 'General consultation';
            
            // Create SMS message
            $message = sprintf(
                "Hi %s %s! Your dental appointment has been successfully booked for %s. Services: %s. LC Happy Care Dental Clinic - Sampaguita St., Bagumbayan, Roxas, Oriental Mindoro. Thank you!",
                $user->first_name,
                $user->last_name,
                $appointmentDate,
                $servicesList
            );
            
            Log::info('Prepared SMS message', [
                'phone' => $user->contact_number,
                'message' => $message
            ]);
            
            // Send SMS (don't let SMS failure affect appointment creation)
            $smsResult = $this->sendSmsNotification($user->contact_number, $message);
            
            Log::info('SMS sending completed', ['success' => $smsResult]);
        } else {
            Log::warning('SMS not sent - missing user or phone number', [
                'user_exists' => !is_null($user),
                'phone_exists' => $user ? !empty($user->contact_number) : false
            ]);
        }

        return redirect()->route('registrant.appointments.upcoming', ['user_id' => $validated['user_id']])->with('success', 'Appointment created successfully!');
    }

    public function withdraw(Request $request, $appointment)
    {
        $appointmentObj = \App\Models\Appointment::find($appointment);
        $userId = $appointmentObj ? $appointmentObj->user_id : null;
        if ($appointmentObj) {
            // You can soft delete, set status, or hard delete. Here, we'll set status to 'withdrawn'.
            $appointmentObj->status = 'withdrawn';
            $appointmentObj->dentist_id = null;
            $appointmentObj->save();
        }
        // Fetch user and upcoming appointments for redirect
        $user = $userId ? \App\Models\User::find($userId) : null;
        $appointments = [];
        if ($user) {
            $appointments = \App\Models\Appointment::where('user_id', $user->id)
                ->where('appointment_sched', '>=', now())
                ->where('status', '!=', 'withdrawn')
                ->orderBy('appointment_sched', 'asc')
                ->get();
        }
        return view('registrant.appointments.view-upcoming', compact('user', 'appointments'));
    }

    public function reschedule(Request $request, $appointment)
    {
        $appointmentObj = \App\Models\Appointment::find($appointment);
        
        if (!$appointmentObj) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        // Validate the request
        $validated = $request->validate([
            'new_date' => 'required|date|after_or_equal:today',
            'new_time' => 'required|date_format:H:i',
        ]);

        // Combine new date and time
        $newDateTime = $validated['new_date'] . ' ' . $validated['new_time'];
        $appointmentDateTime = \Carbon\Carbon::parse($newDateTime);

        // Validate clinic hours (8:00 AM - 5:00 PM)
        $appointmentHour = $appointmentDateTime->hour;
        $appointmentMinute = $appointmentDateTime->minute;
        $timeInMinutes = $appointmentHour * 60 + $appointmentMinute;
        
        if ($timeInMinutes < 480 || $timeInMinutes > 1020) { // 8:00 AM = 480 minutes, 5:00 PM = 1020 minutes
            return back()->withErrors(['new_time' => 'Appointment time must be between 8:00 AM and 5:00 PM (clinic hours).'])->withInput();
        }

        // Validate appointment is not in the past
        if ($appointmentDateTime->isPast() || $appointmentDateTime->equalTo(now())) {
            return back()->withErrors(['new_time' => 'Appointment time cannot be in the past or current time. Please select a future date and time.'])->withInput();
        }

        // Check if time slot is available (server-side validation)
        $timeSlotBuffer = 30; // minutes
        $startWindow = $appointmentDateTime->copy()->subMinutes($timeSlotBuffer);
        $endWindow = $appointmentDateTime->copy()->addMinutes($timeSlotBuffer);
        
        $conflictingAppointments = \App\Models\Appointment::whereBetween('appointment_sched', [$startWindow, $endWindow])
            ->whereIn('status', ['pending', 'approved', 'confirmed'])
            ->where('id', '!=', $appointment) // Exclude current appointment
            ->count();
        
        $maxConcurrentAppointments = 3;
        if ($conflictingAppointments >= $maxConcurrentAppointments) {
            return back()->withErrors(['new_time' => 'This time slot is currently busy. Please choose a different time.'])->withInput();
        }

        // Store the old schedule for logging/notification
        $oldSchedule = $appointmentObj->appointment_sched;
        
        // Update the appointment
        $appointmentObj->appointment_sched = $newDateTime;
        $appointmentObj->status = 'pending'; // Reset to pending for re-approval
        $appointmentObj->dentist_id = null; // Clear assigned dentist since schedule changed
        $appointmentObj->save();

        // Send SMS notification to patient about reschedule
        $user = \App\Models\User::find($appointmentObj->user_id);
        
        if ($user && $user->contact_number) {
            $oldDate = \Carbon\Carbon::parse($oldSchedule)->format('M j, Y \a\t g:i A');
            $newDate = $appointmentDateTime->format('M j, Y \a\t g:i A');
            
            $message = sprintf(
                "Hi %s %s! Your dental appointment has been rescheduled from %s to %s. LC Happy Care Dental Clinic - Sampaguita St., Bagumbayan, Roxas, Oriental Mindoro. Thank you!",
                $user->first_name,
                $user->last_name,
                $oldDate,
                $newDate
            );
            
            // Send SMS (don't let SMS failure affect reschedule)
            $this->sendSmsNotification($user->contact_number, $message);
        }

        return redirect()->route('registrant.appointments.upcoming', ['user_id' => $appointmentObj->user_id])
            ->with('success', 'Appointment successfully rescheduled!');
    }

    public function printReceipt(Request $request, $appointmentId)
    {
        // Find the appointment with related data
        $appointment = \App\Models\Appointment::with(['user', 'services', 'dentist'])
            ->findOrFail($appointmentId);
        
        // Security check: ensure the user can only print their own receipts
        $userId = $request->query('user_id') ?? $request->get('user_id');
        if (!$userId || $appointment->user_id != $userId) {
            abort(403, 'Unauthorized access to appointment receipt.');
        }
        
        // Generate PDF
        $pdf = Pdf::loadView('receipts.appointment-receipt', compact('appointment'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Arial'
            ]);
        
        // Generate filename
        $filename = sprintf(
            'appointment-receipt-%s-%s.pdf',
            $appointment->id,
            now()->format('Y-m-d')
        );
        
        // Return PDF for download
        return $pdf->download($filename);
    }

    /**
     * Check if appointment time slot is available
     */
    public function checkAvailability(Request $request)
    {
        try {
            $validated = $request->validate([
                'appointment_datetime' => 'required|date',
                'current_appointment_id' => 'nullable|string', // For rescheduling - exclude current appointment
            ]);

            $appointmentDateTime = \Carbon\Carbon::parse($validated['appointment_datetime']);
            
            // Define time slot window (e.g., appointments within 30 minutes are considered conflicting)
            $timeSlotBuffer = 30; // minutes
            $startWindow = $appointmentDateTime->copy()->subMinutes($timeSlotBuffer);
            $endWindow = $appointmentDateTime->copy()->addMinutes($timeSlotBuffer);

            // Query for conflicting appointments
            $query = \App\Models\Appointment::where(function($q) use ($startWindow, $endWindow) {
                $q->whereBetween('appointment_sched', [$startWindow, $endWindow]);
            })
            ->whereIn('status', ['pending', 'approved', 'confirmed']); // Only check active appointments

            // Exclude current appointment if rescheduling
            if (!empty($validated['current_appointment_id'])) {
                $query->where('id', '!=', $validated['current_appointment_id']);
            }

            $conflictingAppointments = $query->count();

            // Consider a slot "busy" if there are 3 or more appointments within the time window
            $maxConcurrentAppointments = 3;
            $isAvailable = $conflictingAppointments < $maxConcurrentAppointments;

            return response()->json([
                'available' => $isAvailable,
                'conflicting_count' => $conflictingAppointments,
                'max_allowed' => $maxConcurrentAppointments,
                'message' => $isAvailable 
                    ? 'Time slot is available.' 
                    : "This time slot is currently busy. There are already {$conflictingAppointments} appointments scheduled around this time. Please choose a different time.",
                'suggested_times' => !$isAvailable ? $this->suggestAlternativeTimes($appointmentDateTime) : []
            ]);

        } catch (\Exception $e) {
            Log::error('Availability check failed: ' . $e->getMessage());
            return response()->json([
                'available' => true, // Default to available on error to not block users
                'error' => 'Unable to check availability at this time.',
                'message' => 'Availability check unavailable. You may proceed with booking.'
            ], 500);
        }
    }

    /**
     * Suggest alternative appointment times
     */
    private function suggestAlternativeTimes($requestedDateTime)
    {
        $suggestions = [];
        $baseDate = $requestedDateTime->copy();
        
        // Suggest 3 alternative times on the same day
        $timesToCheck = [
            $baseDate->copy()->addHours(1),
            $baseDate->copy()->addHours(2),
            $baseDate->copy()->subHours(1),
        ];

        foreach ($timesToCheck as $time) {
            // Check if time is within clinic hours (8 AM - 5 PM)
            $hour = $time->hour;
            if ($hour >= 8 && $hour < 17 && $time->isFuture()) {
                $suggestions[] = $time->format('Y-m-d H:i:s');
            }
        }

        return array_slice($suggestions, 0, 3); // Return up to 3 suggestions
    }
}
