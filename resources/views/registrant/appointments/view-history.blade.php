<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Appointment History - LC Happy Care Dental Clinic</title>
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
              <h6 class="my-2">APPOINTMENT HISTORY</h6>
            </div>
            <div class="card-body"><!-- Start: Filter Div -->
              <form method="GET" action="{{ route('registrant.appointments.history') }}" id="filterForm">
                <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                <div class="row">
                  <div>
                    <div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg"
                          width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search">
                          <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                          </path>
                        </svg></span><input class="form-control" type="text" name="search" placeholder="Search appointment history..." value="{{ request('search') }}"><button class="btn btn-primary"
                        type="submit">Search</button></div>
                  </div>
                  <div class="col d-flex justify-content-end align-items-center gap-2 mt-2 mb-2">
                    <div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                        data-bs-toggle="dropdown" type="button">{{ request('status') ? ucfirst(request('status')) : 'Filter' }}</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', '')">All Status</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'pending')">Pending</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'assigned')">Assigned</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'completed')">Completed</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'withdrawn')">Withdrawn</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'rescheduled')">Rescheduled</a>
                      </div>
                    </div>
                    <div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                        data-bs-toggle="dropdown" type="button">{{ request('date_range') ? ucfirst(str_replace('_', ' ', request('date_range'))) : 'Last 30 Days' }}</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_range', '')">All Time</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_range', 'last_7_days')">Last 7 Days</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_range', 'last_30_days')">Last 30 Days</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_range', 'last_6_months')">Last 6 Months</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_range', 'this_year')">This Year</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Hidden filter inputs -->
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="date_range" value="{{ request('date_range') }}">
              </form><!-- End: Filter Div -->
              @if ($appointments && $appointments->count())
                @foreach ($appointments as $appointment)
                  <div class="card">
                    <div class="card-header">
                      <h6 class="mb-0">
                        {{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}:
                       @if (strtolower($appointment->status) === 'completed')
                          <span class="fs-6 text-white bg-success rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                          @elseif (strtolower($appointment->status) === 'rejected')
                          <span class="fs-6 text-danger border border-danger rounded-pill badge bg-transparent">{{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'withdrawn')
                          <span class="fs-6 text-white bg-danger rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'pending')
                         <span class="fs-6 text-warning border border-warning rounded-pill badge bg-transparent"> {{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'assigned')
                          <span class="fs-6 text-success border border-success rounded-pill badge bg-transparent">{{ ucfirst($appointment->status) }}</span>
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
                    <h5 class="mb-2">No appointment history found.</h5>
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
  </script>
</body>

</html>