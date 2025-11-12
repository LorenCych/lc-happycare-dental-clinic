<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    // NOTE
    // dentist_id pertains to the name variable present in the blade view
    // makes the request. Always ensure that the name varibale is same on the
    // varaiable contained in the $request->query(); line.

    /**
     * Send appointment notification email to patient
     */
    private function sendAppointmentNotification($appointment, $action, $dentist = null, $additionalData = [])
    {
        try {
            // Get the patient's user record
            $user = $appointment->user;
            if (!$user || !$user->email) {
                Log::warning("Cannot send appointment notification - user or email not found", [
                    'appointment_id' => $appointment->id,
                    'user_id' => $appointment->user_id
                ]);
                return false;
            }

            // Get dentist info if not provided
            if (!$dentist && $appointment->dentist_id) {
                $dentist = \App\Models\Admin::find($appointment->dentist_id);
            }

            // Prepare email data
            $emailData = [
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'appointee_name' => $appointment->appointee_name,
                'appointment_date' => \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y'),
                'appointment_time' => \Carbon\Carbon::parse($appointment->appointment_sched)->format('g:i A'),
                'appointment_id' => $appointment->id,
                'dentist_name' => $dentist ? $dentist->first_name . ' ' . $dentist->last_name : 'Our Dental Team',
                'dentist_contact' => $dentist && $dentist->contact_number ? $dentist->contact_number : null,
                'services' => $appointment->services->pluck('service_name')->join(', '),
                'action' => $action,
                'status' => ucfirst($appointment->status)
            ];

            // Add any additional data
            $emailData = array_merge($emailData, $additionalData);

            // Determine email subject and template based on action
            switch ($action) {
                case 'claimed':
                    $subject = 'Your Appointment Has Been Assigned - ' . $emailData['appointment_date'];
                    $template = 'emails.appointment-claimed';
                    break;
                case 'unassigned':
                    $subject = 'Appointment Update Required - ' . $emailData['appointment_date'];
                    $template = 'emails.appointment-unassigned';
                    break;
                case 'rescheduled':
                    $subject = 'Appointment Rescheduled - ' . $emailData['appointment_date'];
                    $template = 'emails.appointment-rescheduled';
                    break;
                case 'completed':
                    $subject = 'Appointment Completed - Thank You!';
                    $template = 'emails.appointment-completed';
                    break;
                case 'expired':
                    $subject = 'Appointment Status Update';
                    $template = 'emails.appointment-expired';
                    break;
                case 'rejected':
                    $subject = 'Appointment Update - ' . $emailData['appointment_date'];
                    $template = 'emails.appointment-rejected';
                    break;
                default:
                    $subject = 'Appointment Update';
                    $template = 'emails.appointment-generic';
            }

            // Send the email
            Mail::send($template, $emailData, function ($message) use ($user, $subject) {
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)
                       ->subject($subject)
                       ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info("Appointment notification sent successfully", [
                'appointment_id' => $appointment->id,
                'action' => $action,
                'recipient' => $user->email
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("Failed to send appointment notification", [
                'appointment_id' => $appointment->id,
                'action' => $action,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function viewUpcomingAppointments(Request $request)
    {
        $dentistId = $request->query('dentist_id');
        $dentist = null;
        $appointments = [];
        if ($dentistId) {
            $dentist = \App\Models\User::find($dentistId);
            if ($dentist) {
                $appointments = \App\Models\Appointment::where('dentist_id', $dentist->id)
                    ->where('appointment_sched', '>=', now())
                    ->where('status', '!=', 'withdrawn', '!=', 'rejected', '!=', 'completed', '!=', 'expired')
                    ->orderBy('appointment_sched', 'asc')
                    ->get();
            }
        }
        //return view('registrant.appointments.view-upcoming', compact('user', 'appointments'));
    }

    public function viewAppointmentHistory(Request $request)
    {
        $dentistId = $request->query('dentist_id');
        $dentist = null;
        $appointments = [];
        if ($dentistId) {
            $user = \App\Models\User::find($dentistId);
            if ($dentist) {
                $appointments = \App\Models\Appointment::where('dentist_id', $dentist->id)->get();
            }
        }
        //return view('registrant.appointments.view-history', compact('user', 'appointments'));
    }

    public function bookAppointment(Request $request)
    {
        $userId = $request->query('user_id');
        $user = null;
        if ($userId) {
            $user = \App\Models\User::find($userId);
        }
        //return view('registrant.appointments.book', compact('user'));
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
            //'dentist_id' => 'required|string|exists:admins,id',
            'status' => 'nullable|string|max:50',
        ]);

        $validated['status'] = 'pending';
        $serviceIds = $validated['service_id'];
        unset($validated['service_id']);

        $appointment = \App\Models\Appointment::create($validated);
        $appointment->services()->attach($serviceIds);

        //return redirect()->route('registrant.appointments.upcoming', ['user_id' => $validated['user_id']])->with('success', 'Appointment created successfully!');
    }

    public function withdraw(Request $request, $appointment)
    {
        $appointmentObj = \App\Models\Appointment::find($appointment);
        $dentistId = $appointmentObj ? $appointmentObj->dentist_id : null;
        if ($appointmentObj) {
            // You can soft delete, set status, or hard delete. Here, we'll set status to 'withdrawn'.
            $appointmentObj->status = 'withdrawn';
            $appointmentObj->save();
        }
        // Fetch user and upcoming appointments for redirect
        $dentist = $dentistId ? \App\Models\User::find($dentistId) : null;
        $appointments = [];
        if ($dentist) {
            $appointments = \App\Models\Appointment::where('dentist_id', $dentist->id)
                ->where('appointment_sched', '>=', now())
                ->where('status', '!=', 'withdrawn')
                ->orderBy('appointment_sched', 'asc')
                ->get();
        }
        //return view('registrant.appointments.view-upcoming', compact('user', 'appointments'));
    }

    public function viewAssignedAppointments(Request $request)
    {
        $dentistId = session('admin_id');
        $dentist = null;
        $appointments = collect();
        
        if ($dentistId) {
            $dentist = \App\Models\Admin::find($dentistId);
            if ($dentist) {
                $query = \App\Models\Appointment::with(['services', 'user'])
                    ->where('dentist_id', $dentist->id)
                    ->whereIn('status', ['assigned', 'rescheduled'])
                    ->where('appointment_sched', '>=', now());

                // Search functionality
                if ($request->filled('search')) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('appointee_name', 'ILIKE', "%{$searchTerm}%")
                          ->orWhere('other_services', 'ILIKE', "%{$searchTerm}%")
                          ->orWhereHas('services', function ($serviceQuery) use ($searchTerm) {
                              $serviceQuery->where('service_name', 'ILIKE', "%{$searchTerm}%");
                          });
                    });
                }

                // Date filter
                if ($request->filled('date_filter')) {
                    $dateFilter = $request->date_filter;
                    switch ($dateFilter) {
                        case 'today':
                            $query->whereDate('appointment_sched', now()->toDateString());
                            break;
                        case 'tomorrow':
                            $query->whereDate('appointment_sched', now()->addDay()->toDateString());
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
                } else {
                    // Default to current month if no date filter
                    $query->whereMonth('appointment_sched', now()->month)
                          ->whereYear('appointment_sched', now()->year);
                }

                $appointments = $query->orderBy('appointment_sched', 'asc')->get();
            }
        }
        
        return view('dentist.appointments.assigned-appointments', compact('dentist', 'appointments'));
    }


    public function viewUnassignedAppointments(Request $request)
    {
        $dentistId = session('admin_id');
        $dentist = null;
        $appointments = collect();

        if ($dentistId) {
            $dentist = \App\Models\Admin::find($dentistId);
            if ($dentist) {
                $query = \App\Models\Appointment::with(['services', 'user'])
                    ->where('dentist_id', null)
                    ->where('status', 'pending')
                    ->where('appointment_sched', '>=', now());

                // Search functionality
                if ($request->filled('search')) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('appointee_name', 'ILIKE', "%{$searchTerm}%")
                          ->orWhere('other_services', 'ILIKE', "%{$searchTerm}%")
                          ->orWhereHas('services', function ($serviceQuery) use ($searchTerm) {
                              $serviceQuery->where('service_name', 'ILIKE', "%{$searchTerm}%");
                          });
                    });
                }

                // Date filter
                if ($request->filled('date_filter')) {
                    $dateFilter = $request->date_filter;
                    switch ($dateFilter) {
                        case 'today':
                            $query->whereDate('appointment_sched', now()->toDateString());
                            break;
                        case 'tomorrow':
                            $query->whereDate('appointment_sched', now()->addDay()->toDateString());
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

                $appointments = $query->orderBy('appointment_sched', 'asc')->get();
            }
        }

        return view('dentist.appointments.unassigned-appointments', compact('dentist', 'appointments'));
    }

    public function claimAppointment($appointmentId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'This appointment cannot be claimed');
        }

        $dentist = \App\Models\Admin::find($dentistId);
        
        $appointment->dentist_id = $dentistId;
        $appointment->status = 'assigned';
        $appointment->save();

        // Send notification email
        $this->sendAppointmentNotification($appointment, 'claimed', $dentist);

        return redirect()->route('dentist.dashboard')->with('success', 'Appointment claimed successfully');
    }

    public function unassignAppointment($appointmentId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->dentist_id != $dentistId) {
            return redirect()->back()->with('error', 'You can only unassign your own appointments');
        }

        $dentist = \App\Models\Admin::find($dentistId);

        $appointment->dentist_id = null;
        $appointment->status = 'pending';
        $appointment->save();

        // Send notification email
        $this->sendAppointmentNotification($appointment, 'unassigned', $dentist);

        return redirect()->route('dentist.dashboard')->with('success', 'Appointment unassigned successfully');
    }

    public function rescheduleAppointment(Request $request, $appointmentId, $newDateTime)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->dentist_id != $dentistId) {
            return redirect()->back()->with('error', 'You can only reschedule your own appointments');
        }

        try {
            $dentist = \App\Models\Admin::find($dentistId);
            $originalDateTime = $appointment->appointment_sched;
            
            $appointment->appointment_sched = urldecode($newDateTime);
            $appointment->status = 'rescheduled';
            $appointment->save();

            // Send notification email with old and new times
            $this->sendAppointmentNotification($appointment, 'rescheduled', $dentist, [
                'original_date' => \Carbon\Carbon::parse($originalDateTime)->format('F j, Y'),
                'original_time' => \Carbon\Carbon::parse($originalDateTime)->format('g:i A'),
                'new_date' => \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y'),
                'new_time' => \Carbon\Carbon::parse($appointment->appointment_sched)->format('g:i A')
            ]);

            return redirect()->route('dentist.dashboard')->with('success', 'Appointment rescheduled successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reschedule appointment: ' . $e->getMessage());
        }
    }

    public function markAsCompleted($appointmentId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->dentist_id != $dentistId) {
            return redirect()->back()->with('error', 'You can only mark your own appointments as completed');
        }

        $dentist = \App\Models\Admin::find($dentistId);
        
        $appointment->status = 'completed';
        $appointment->save();

        // Send notification email
        $this->sendAppointmentNotification($appointment, 'completed', $dentist);

        return redirect()->back()->with('success', 'Appointment marked as completed successfully');
    }

    public function markAsExpired($appointmentId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->dentist_id != $dentistId) {
            return redirect()->back()->with('error', 'You can only mark your own appointments as expired');
        }

        $dentist = \App\Models\Admin::find($dentistId);
        
        $appointment->status = 'expired';
        $appointment->save();

        // Send notification email
        $this->sendAppointmentNotification($appointment, 'expired', $dentist);

        return redirect()->back()->with('success', 'Appointment marked as expired successfully');
    }

    public function rejectAppointment($appointmentId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->back()->with('error', 'Authentication required');
        }

        $appointment = \App\Models\Appointment::find($appointmentId);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        // Only allow rejection of pending appointments that are not assigned
        if ($appointment->status !== 'pending' || $appointment->dentist_id !== null) {
            return redirect()->back()->with('error', 'This appointment cannot be rejected');
        }

        $dentist = \App\Models\Admin::find($dentistId);
        
        $appointment->status = 'rejected';
        $appointment->save();

        // Send notification email
        $this->sendAppointmentNotification($appointment, 'rejected', $dentist);

        return redirect()->back()->with('success', 'Appointment rejected successfully');
    }

    public function viewPreviousAppointments(Request $request)
    {
        $dentistId = session('admin_id');
        $dentist = null;
        $appointments = collect();
        
        if ($dentistId) {
            $dentist = \App\Models\Admin::find($dentistId);
            if ($dentist) {
                $query = \App\Models\Appointment::with(['services', 'user'])
                    ->where('dentist_id', $dentist->id)
                    ->whereIn('status', ['completed', 'expired'])
                    ->where('appointment_sched', '<=', now());

                // Search functionality
                if ($request->filled('search')) {
                    $searchTerm = $request->search;
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('appointee_name', 'ILIKE', "%{$searchTerm}%")
                          ->orWhere('other_services', 'ILIKE', "%{$searchTerm}%")
                          ->orWhereHas('services', function ($serviceQuery) use ($searchTerm) {
                              $serviceQuery->where('service_name', 'ILIKE', "%{$searchTerm}%");
                          });
                    });
                }

                // Status filter
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                // Date filter
                if ($request->filled('date_filter')) {
                    $dateFilter = $request->date_filter;
                    switch ($dateFilter) {
                        case 'today':
                            $query->whereDate('appointment_sched', now()->toDateString());
                            break;
                        case 'yesterday':
                            $query->whereDate('appointment_sched', now()->subDay()->toDateString());
                            break;
                        case 'this_week':
                            $query->whereBetween('appointment_sched', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ]);
                            break;
                        case 'last_week':
                            $query->whereBetween('appointment_sched', [
                                now()->subWeek()->startOfWeek(),
                                now()->subWeek()->endOfWeek()
                            ]);
                            break;
                        case 'this_month':
                            $query->whereMonth('appointment_sched', now()->month)
                                  ->whereYear('appointment_sched', now()->year);
                            break;
                        case 'last_month':
                            $query->whereMonth('appointment_sched', now()->subMonth()->month)
                                  ->whereYear('appointment_sched', now()->subMonth()->year);
                            break;
                        case 'this_year':
                            $query->whereYear('appointment_sched', now()->year);
                            break;
                    }
                } else {
                    // Default to current month if no date filter
                    $query->whereMonth('appointment_sched', now()->month)
                          ->whereYear('appointment_sched', now()->year);
                }

                $appointments = $query->orderBy('appointment_sched', 'desc')->get();
            }
        }
        
        return view('dentist.appointments.previous-appointments', compact('dentist', 'appointments'));
    }

    public function viewPatientRecord($userId)
    {
        $dentistId = session('admin_id');
        if (!$dentistId) {
            return redirect()->route('home.admin-login')->with('error', 'Authentication required');
        }

        $dentist = \App\Models\Admin::find($dentistId);
        if (!$dentist) {
            return redirect()->route('home.admin-login')->with('error', 'Dentist not found');
        }

        // Get the patient/user
        $patient = \App\Models\User::find($userId);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found');
        }

        // Get all appointments for this patient where the logged-in dentist is assigned
        $appointments = \App\Models\Appointment::with(['services', 'user'])
            ->where('user_id', $userId)
            ->where('dentist_id', $dentistId)
            ->orderBy('appointment_sched', 'desc')
            ->get();

        // Apply search filter if provided
        if (request()->filled('search')) {
            $searchTerm = request('search');
            $appointments = $appointments->filter(function ($appointment) use ($searchTerm) {
                $searchLower = strtolower($searchTerm);
                
                // Search in services
                $servicesMatch = $appointment->services->contains(function ($service) use ($searchLower) {
                    return strpos(strtolower($service->service_name), $searchLower) !== false;
                });
                
                // Search in other services
                $otherServicesMatch = $appointment->other_services && 
                    strpos(strtolower($appointment->other_services), $searchLower) !== false;
                
                // Search in status
                $statusMatch = strpos(strtolower($appointment->status), $searchLower) !== false;
                
                return $servicesMatch || $otherServicesMatch || $statusMatch;
            });
        }

        // Apply date filter if provided
        if (request()->filled('date_filter')) {
            $dateFilter = request('date_filter');
            $appointments = $appointments->filter(function ($appointment) use ($dateFilter) {
                $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_sched);
                
                switch ($dateFilter) {
                    case 'today':
                        return $appointmentDate->isToday();
                    case 'this_week':
                        return $appointmentDate->isCurrentWeek();
                    case 'last_30_days':
                        return $appointmentDate->greaterThanOrEqualTo(now()->subDays(30));
                    case 'this_month':
                        return $appointmentDate->isCurrentMonth();
                    case 'this_year':
                        return $appointmentDate->isCurrentYear();
                    default:
                        return true;
                }
            });
        }

        // Apply status filter if provided
        if (request()->filled('status')) {
            $statusFilter = request('status');
            $appointments = $appointments->filter(function ($appointment) use ($statusFilter) {
                return strtolower($appointment->status) === strtolower($statusFilter);
            });
        }

        return view('dentist.patient.view-record', compact('dentist', 'patient', 'appointments'));
    }
}
