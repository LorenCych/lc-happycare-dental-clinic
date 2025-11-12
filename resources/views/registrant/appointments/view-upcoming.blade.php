<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Upcoming Appointments - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
   <!-- Start: Sidebar With Menu -->
  @include('partials.registrant-sidebar')
  <!-- End: Sidebar With Menu -->
  
  <!-- Start: Navbar Centered Brand -->
  @include('partials.registrant-navbar')
  <!-- End: Navbar Centered Brand -->
  
  <section class="mt-4"><!-- Start: 1 Row 2 Columns -->
    <div class="container">
      <div class="row" style="height: 240px;">
        <div class="col-12 ms-0">
          <div class="card">
            <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
              style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
              <h6 class="my-2">UPCOMING APPOINTMENTS</h6>
            </div>
            <div class="card-body"><!-- Start: Filter Div -->
              <form method="GET" action="{{ route('registrant.appointments.upcoming') }}" id="filterForm">
                <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                <div class="row">
                  <div>
                    <div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg"
                          width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search">
                          <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                          </path>
                        </svg></span><input class="form-control" type="text" name="search" placeholder="Search appointments..." value="{{ request('search') }}"><button class="btn btn-primary"
                        type="submit">Search</button></div>
                  </div>
                  <div class="col d-flex justify-content-end align-items-center gap-2 mt-2 mb-2">
                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                        data-bs-toggle="dropdown" type="button">{{ request('status') ? ucfirst(request('status')) : 'Status' }}</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', '')">All Status</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'pending')">Pending</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'assigned')">Assigned</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'completed')">Completed</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'rescheduled')">Rescheduled</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'withdrawn')">Withdrawn</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'expired')">Expired</a>
                      </div>
                    </div>
                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                        data-bs-toggle="dropdown" type="button">{{ request('date_filter') ? ucfirst(str_replace('_', ' ', request('date_filter'))) : 'Date' }}</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', '')">All Dates</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'today')">Today</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'tomorrow')">Tomorrow</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_week')">This Week</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_month')">This Month</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_year')">This Year</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Hidden filter inputs -->
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="date_filter" value="{{ request('date_filter') }}">
              </form><!-- End: Filter Div -->
              @if ($appointments && $appointments->count())
                @foreach ($appointments as $appointment)
                  <div class="card">
                    <div class="card-header">
                      <h6 class="mb-0">
                       {{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}
                        @if (strtolower($appointment->status) === 'completed')
                          <span class="fs-6 text-black bg-success rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'withdrawn')
                          <span class="fs-6 text-white bg-danger rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'pending')
                         <span class="fs-6 text-warning border border-warning rounded-pill badge bg-transparent"> {{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'assigned')
                          <span class="fs-6 text-black bg-warning rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @else
                          <span class="fs-6 text-black bg-warning rounded-pill badge">{{ ucfirst($appointment->status ?? 'Unknown') }}</span>
                          {{-- Debug: Actual status = "{{ $appointment->status }}" --}}
                        @endif
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row gy-2">
                        <div class="col-12 col-md-4">
                          <h5 class="text-black-50 mb-1"><strong>Dental Specialist</strong></h5>
                          <p class="mb-1"><strong>{{ $appointment->dentist ? $appointment->dentist->fullname() : 'N/A' }}</strong></p>
                        </div>
                        <div class="col">
                          <h5 class="text-black-50 mb-1"><strong>Treatment/Service</strong></h5>
                          <p class="mb-1"><strong>
                            @php
                              $services = [];
                              if ($appointment->services && $appointment->services->count()) {
                                  $services = $appointment->services->pluck('service_name')->toArray();
                              }
                              if ($appointment->other_services) {
                                  $services[] = $appointment->other_services;
                              }
                            @endphp
                            {{ count($services) > 0 ? implode(', ', $services) : 'N/A' }}
                          </strong></p>
                        </div>
                        <div class="col">
                          <h5 class="text-black-50 mb-1"><strong>Patient</strong></h5>
                          <p class="mb-1"><strong>{{ $user ? $user->fullname() : 'N/A' }}</strong></p>
                        </div>
                        <div class="col-12">
                          <div class="d-flex justify-content-end align-items-center gap-2 pt-3">
                            <!-- Print Receipt Button -->
                            <a href="{{ route('registrant.appointments.print-receipt', ['appointmentId' => $appointment->id, 'user_id' => $user->id ?? '']) }}" 
                               class="btn btn-outline-warning btn-sm" 
                               target="_blank"
                               title="Print Appointment Receipt">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill me-1" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                              </svg>
                              Print Receipt
                            </a>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $appointment->id }}">Reschedule</button>
                            <!-- Withdraw Button triggers modal -->
                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $appointment->id }}">Withdraw Appointment</button>
                          </div>
                        </div>
                        <!-- Modal for Withdraw Confirmation -->
                        <div class="modal fade" id="withdrawModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel{{ $appointment->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="withdrawModalLabel{{ $appointment->id }}">Confirm Withdrawal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to withdraw this appointment scheduled for <strong>{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}</strong>?
                              </div>
                              <div class="modal-footer">
                               <form method="POST" action="{{ route('registrant.appointments.withdraw', ['appointment' => $appointment->id]) }}">
                                  @csrf
                                  <!-- Placeholder route, replace 'appointments.withdraw' with actual route name -->
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger">Confirm Withdraw</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Modal for Reschedule -->
                        <div class="modal fade" id="rescheduleModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="rescheduleModalLabel{{ $appointment->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="bg-primary modal-header">
                                <h5 class="modal-title" id="rescheduleModalLabel{{ $appointment->id }}">Reschedule Appointment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="{{ route('registrant.appointments.reschedule', ['appointment' => $appointment->id]) }}" id="rescheduleForm{{ $appointment->id }}">
                                @csrf
                                <div class="modal-body">
                                  <p class="mb-3">Current appointment: <strong>{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}</strong></p>
                                  
                                  <div class="row">
                                    <div class="col-md-6 mb-3">
                                      <label for="new_date{{ $appointment->id }}" class="form-label">New Date</label>
                                      <input type="date" class="form-control" id="new_date{{ $appointment->id }}" name="new_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                      <label for="new_time{{ $appointment->id }}" class="form-label">New Time</label>
                                      <input type="time" class="form-control" id="new_time{{ $appointment->id }}" name="new_time" min="08:00" max="17:00" required>
                                      <div class="form-text text-black-50">Clinic hours: 8:00 AM - 5:00 PM</div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-primary">Confirm Reschedule</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="mt-2 mb-2">
                @endforeach
              @else
                <div class="card mb-2">
                  <div class="card-body text-center">
                    <h5 class="mb-2">No upcoming appointments found.</h5>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div><!-- End: 1 Row 2 Columns -->
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
  <script>
    function setFilter(filterType, value) {
      // Set the hidden input value
      document.querySelector(`input[name="${filterType}"]`).value = value;
      
      // Submit the form
      document.getElementById('filterForm').submit();
    }

    // Time validation for reschedule forms
    document.addEventListener('DOMContentLoaded', function() {
      // Availability check function for reschedule
      async function checkRescheduleAvailability(appointmentId, dateValue, timeValue) {
        if (!dateValue || !timeValue) {
          return true;
        }

        const appointmentDateTime = dateValue + ' ' + timeValue;
        
        try {
          const response = await fetch('{{ route("registrant.appointments.check-availability") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              appointment_datetime: appointmentDateTime,
              current_appointment_id: appointmentId
            })
          });

          const data = await response.json();
          
          if (!data.available) {
            alert(data.message);
            return false;
          }
          
          return true;
        } catch (error) {
          console.error('Availability check error:', error);
          return true; // On error, allow rescheduling to proceed
        }
      }

      // Set minimum date to today for all reschedule date inputs
      const today = new Date().toISOString().split('T')[0];
      const dateInputs = document.querySelectorAll('input[id^="new_date"]');
      dateInputs.forEach(input => {
        input.setAttribute('min', today);
      });

      const rescheduleFormsSelectors = document.querySelectorAll('form[id^="rescheduleForm"]');
      
      rescheduleFormsSelectors.forEach(form => {
        form.addEventListener('submit', async function(e) {
          e.preventDefault(); // Prevent default submission initially
          
          const appointmentId = form.id.replace('rescheduleForm', '');
          const timeInput = document.getElementById('new_time' + appointmentId);
          const dateInput = document.getElementById('new_date' + appointmentId);
          
          if (timeInput && timeInput.value && dateInput && dateInput.value) {
            const selectedTime = timeInput.value;
            const [hours, minutes] = selectedTime.split(':').map(Number);
            const totalMinutes = hours * 60 + minutes;
            
            // Check if time is within clinic hours (8:00 AM to 5:00 PM)
            const clinicStart = 8 * 60; // 8:00 AM in minutes
            const clinicEnd = 17 * 60;  // 5:00 PM in minutes
            
            if (totalMinutes < clinicStart || totalMinutes > clinicEnd) {
              alert('Please select a time between 8:00 AM and 5:00 PM. Our clinic operates within these hours.');
              timeInput.focus();
              return false;
            }

            // Check if the selected date and time is in the past or current time
            const selectedDateTime = new Date(dateInput.value + ' ' + selectedTime);
            const now = new Date();
            
            if (selectedDateTime <= now) {
              alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
              timeInput.focus();
              return false;
            }

            // Check availability
            const isAvailable = await checkRescheduleAvailability(appointmentId, dateInput.value, timeInput.value);
            if (!isAvailable) {
              timeInput.focus();
              return false;
            }
          }
          
          // Check if date is not in the past
          if (dateInput && dateInput.value) {
            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to start of day for fair comparison
            
            if (selectedDate < today) {
              alert('Please select a future date for your appointment.');
              dateInput.focus();
              return false;
            }
          }

          // All validations passed, submit the form
          form.submit();
        });
      });

      // Add real-time validation for time inputs in reschedule modals
      const timeInputs = document.querySelectorAll('input[id^="new_time"]');
      timeInputs.forEach(timeInput => {
        timeInput.addEventListener('change', async function() {
          const appointmentId = this.id.replace('new_time', '');
          const dateInput = document.getElementById('new_date' + appointmentId);
          
          if (this.value) {
            const [hours, minutes] = this.value.split(':').map(Number);
            const totalMinutes = hours * 60 + minutes;
            const clinicStart = 8 * 60;
            const clinicEnd = 17 * 60;
            
            if (totalMinutes < clinicStart || totalMinutes > clinicEnd) {
              alert('Please select a time between 8:00 AM and 5:00 PM. Our clinic operates within these hours.');
              this.value = '';
              return;
            }

            // Check if combined date/time is in the past
            if (dateInput && dateInput.value) {
              const selectedDateTime = new Date(dateInput.value + ' ' + this.value);
              const now = new Date();
              
              if (selectedDateTime <= now) {
                alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
                this.value = '';
                return;
              }

              // Check availability
              await checkRescheduleAvailability(appointmentId, dateInput.value, this.value);
            }
          }
        });
      });

      // Add real-time validation for date inputs in reschedule modals
      const rescheduleDateInputs = document.querySelectorAll('input[id^="new_date"]');
      rescheduleDateInputs.forEach(dateInput => {
        dateInput.addEventListener('change', function() {
          const appointmentId = this.id.replace('new_date', '');
          const timeInput = document.getElementById('new_time' + appointmentId);
          
          // If time is already selected, validate combined date/time
          if (timeInput && timeInput.value) {
            const selectedDateTime = new Date(this.value + ' ' + timeInput.value);
            const now = new Date();
            
            if (selectedDateTime <= now) {
              alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
              timeInput.value = ''; // Clear the time
            }
          }
        });
      });
    });
  </script>
</body>

</html>