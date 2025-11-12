<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Assigned Appointments - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  <style>
    .patient-name-link {
      color: #daa520;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    .patient-name-link:hover {
      color: #0066cc;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <section class="d-flex"><!-- Start: Sidebar With Icons -->
     @include('partials.dentist-sidebar')
    <!-- End: Sidebar With Icons --><!-- Start: view -->
    <div class="bg-body flex-grow-1 p-3" id="main-content">
      <section class="mt-4"><!-- Start: 1 Row 2 Columns -->
        <div class="container">
          <div class="row" style="height: 240px;">
            <div class="col-12 ms-0">
              <div class="card">
                <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
                  style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
                  <h6 class="my-2">{{ $dentist->first_name }}'s Upcoming Appointments</h6>
                </div>
                <div class="card-body"><!-- Start: Filter Div -->
                  <div>
                    <div class="row">
                      <div>
                        <form method="GET" action="{{ route('dentist.appointments.assigned') }}" style="display: none;" id="filterForm">
                          <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
                          <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
                          <input type="hidden" name="date_filter" id="dateFilterInput" value="{{ request('date_filter') }}">
                        </form>
                        <div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg"
                              width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search">
                              <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                              </path>
                            </svg></span><input class="form-control" type="text" placeholder="Search appointments, patients, treatments..." value="{{ request('search') }}" onkeyup="handleSearch(event)"><button class="btn btn-primary"
                            type="button" onclick="performSearch()">Search</button></div>
                      </div>
                      <div class="col d-flex justify-content-end align-items-center gap-2 mt-2 mb-2">
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
                  </div><!-- End: Filter Div -->
                  @if($appointments && $appointments->count() > 0)
                    @foreach($appointments as $appointment)
                      <div class="card mb-2">
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
                              <h5 class="text-black-50 mb-1"><strong>Patient</strong></h5>
                              <p class="mb-1">
                                @if($appointment->user_id)
                                  <a href="{{ route('dentist.patient.view-record', $appointment->user_id) }}" class="patient-name-link">
                                    <strong>{{ $appointment->appointee_name }}</strong>
                                  </a>
                                @else
                                  <strong>{{ $appointment->appointee_name }}</strong>
                                @endif
                              </p>
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
                              <h5 class="text-black-50 mb-1"><strong>Patient Info</strong></h5>
                              <p class="mb-1"><strong>
                                @if($appointment->user)
                                  {{ $appointment->user->gender ?? 'N/A' }}, 
                                  {{ $appointment->user->age ?? 'N/A' }} years old, 
                                  {{ $appointment->user->contact_number ?? 'N/A' }}, 
                                  {{ $appointment->user->address ?? 'N/A' }}
                                @else
                                  {{ $appointment->appointee_name ?? 'N/A' }}
                                @endif

                               
                              </strong></p>
                            </div>
                             @if ((strtolower($appointment->status) !== 'withdrawn' && strtolower($appointment->status) !== 'completed') && $appointment->dentist_id === $dentist->id)
                             <div class="d-flex justify-content-end">
                                                <div class="me-2">
                                                    <p class="text-black-50 m-0">Mark as:</p>
                                                      <form method="POST" action="{{ route('dentist.appointments.completed', $appointment->id) }}" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit" onclick="return confirm('Mark this appointment as completed?')">
                                                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-check2 fs-5 me-1 mt-0 mb-1">
                                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
                                                          </svg>Completed
                                                        </button>
                                                      </form>
                                                      <form method="POST" action="{{ route('dentist.appointments.expired', $appointment->id) }}" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Mark this appointment as expired?')">
                                                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-x fs-5 me-1 mt-0 mb-1">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                                                          </svg>Expired
                                                        </button>
                                                      </form>
                                                </div>
                                                <div>
                                                    <p class="text-black-50 m-0">Other Actions:</p>
                                                      <button class="btn btn-primary btn-sm" type="button" onclick="openRescheduleModal('{{ $appointment->id }}', '{{ $appointment->appointee_name }}', '{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('Y-m-d\TH:i') }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-clock-history fs-5 me-1 mt-0 mb-1">
                                                          <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483m.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535m-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"></path>
                                                          <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"></path>
                                                          <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"></path>
                                                        </svg>Reschedule
                                                      </button>
                                                      <form method="POST" action="{{ route('dentist.appointments.unassign', $appointment->id) }}" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-dark btn-sm" type="submit" onclick="return confirm('Drop this appointment? It will be returned to unassigned appointments.')">
                                                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="fs-5 me-1 mt-0 mb-1">
                                                            <path d="M8 11C7.44772 11 7 11.4477 7 12C7 12.5523 7.44772 13 8 13H16C16.5523 13 17 12.5523 17 12C17 11.4477 16.5523 11 16 11H8Z" fill="currentColor"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="currentColor"></path>
                                                          </svg>Drop
                                                        </button>
                                                      </form>
                                                </div>
                                            </div>
                                @endif
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="card mb-2">
                      <div class="card-body text-center">
                        <p class="fw-bold mb-0">No appointments found matching your criteria.</p>
                      </div>
                    </div>
                  @endif
                  <hr class="mt-2 mb-2">
                </div>
              </div>
            </div>
          </div>
        </div><!-- End: 1 Row 2 Columns -->
      </section>
    </div><!-- End: view -->
  </section>

  <!-- Reschedule Modal -->
  <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="rescheduleForm" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Patient:</label>
              <p id="patientName" class="fw-bold"></p>
            </div>
            <div class="mb-3">
              <label for="newDateTime" class="form-label">New Date & Time:</label>
              <input type="datetime-local" class="form-control" id="newDateTime" name="newDateTime" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="submitReschedule()">Reschedule</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
  
  <script>
    function setFilter(filterType, filterValue) {
      // Update the appropriate hidden input based on the filter type
      if (filterType === 'status') {
        document.getElementById('statusInput').value = filterValue;
      } else if (filterType === 'date_filter') {
        document.getElementById('dateFilterInput').value = filterValue;
      }
      
      // Submit the form
      document.getElementById('filterForm').submit();
    }
    
    function handleSearch(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        performSearch();
      }
    }
    
    function performSearch() {
      const searchValue = document.querySelector('.input-group input[type="text"]').value;
      document.getElementById('searchInput').value = searchValue;
      document.getElementById('filterForm').submit();
    }

    // Reschedule functionality
    let currentAppointmentId = null;

    function openRescheduleModal(appointmentId, patientName, currentDateTime) {
      currentAppointmentId = appointmentId;
      document.getElementById('patientName').textContent = patientName;
      document.getElementById('newDateTime').value = currentDateTime;
      
      const modal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
      modal.show();
    }

    function submitReschedule() {
      if (!currentAppointmentId) return;
      
      const newDateTime = document.getElementById('newDateTime').value;
      if (!newDateTime) {
        alert('Please select a new date and time');
        return;
      }
      
      // Create and submit the form
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/dentist/appointments/${currentAppointmentId}/reschedule/${encodeURIComponent(newDateTime)}`;
      
      // Add CSRF token
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = '{{ csrf_token() }}';
      form.appendChild(csrfInput);
      
      document.body.appendChild(form);
      form.submit();
    }
  </script>
</body>

</html>