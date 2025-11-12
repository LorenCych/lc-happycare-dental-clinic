<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Previous Appointments - LC Happy Care Dental Clinic</title>
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
                  <h6 class="my-2">{{ $dentist->first_name }}'s Previous Appointments</h6>
                </div>
                <div class="card-body"><!-- Start: Filter Div -->
                  <div>
                    <div class="row">
                      <div>
                        <form method="GET" action="{{ route('dentist.appointments.previous') }}" style="display: none;" id="filterForm">
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
                            data-bs-toggle="dropdown" type="button">{{ request('status') ? ucfirst(request('status')) : 'Status' }}</button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', '')">All Status</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'completed')">Completed</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'expired')">Expired</a>
                          </div>
                        </div>
                        <div class="dropdown">
                          <button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                            data-bs-toggle="dropdown" type="button">{{ request('date_filter') ? ucfirst(str_replace('_', ' ', request('date_filter'))) : 'Date' }}</button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', '')">All Dates</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'today')">Today</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'yesterday')">Yesterday</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_week')">This Week</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'last_week')">Last Week</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_month')">This Month</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'last_month')">Last Month</a>
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
                          <span class="fs-6 text-white bg-success rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @elseif (strtolower($appointment->status) === 'expired')
                          <span class="fs-6 text-white bg-danger rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                        @else
                          <span class="fs-6 text-black bg-secondary rounded-pill badge">{{ ucfirst($appointment->status ?? 'Unknown') }}</span>
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
                             {{-- No actions available for previous appointments --}}
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="card mb-2">
                      <div class="card-body text-center">
                        <p class="fw-bold mb-0">No previous appointments found matching your criteria.</p>
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

  {{-- No modals needed for previous appointments --}}

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

    // No additional functionality needed for previous appointments
  </script>
</body>

</html>