<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Unassigned Appointments - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
    <section class="d-flex">
           @include('partials.dentist-sidebar')
        <div class="bg-body flex-grow-1 p-3" id="main-content">
            <section class="mt-4">
                <div class="container">
                    <div class="row" style="height: 240px;">
                        <div class="col-12 ms-0">
                            <div class="card">
                                <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center" style="background: rgb(44,49,52);">
                                    <h6 class="text-primary my-2">UNASSIGNED APPOINTMENTS</h6>
                                </div>
                                <div class="card-body"><!-- Start: Filter Div -->
                                  <div>
                                    <div class="row">
                                      <div>
                                        <form method="GET" action="{{ route('dentist.appointments.unassigned') }}" style="display: none;" id="filterForm">
                                          <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
                                          <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
                                          <input type="hidden" name="date_filter" id="dateFilterInput" value="{{ request('date_filter') }}">
                                        </form>
                                        <div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg"
                                              width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search">
                                              <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                                              </path>
                                            </svg></span><input class="form-control text-black" type="text" value="{{ request('search') }}" onkeyup="handleSearch(event)"><button class="btn btn-primary"
                                            type="button" onclick="performSearch()">Search</button></div>
                                      </div>
                                      <div class="col d-flex justify-content-end align-items-center gap-2 mt-2 mb-2">
                                        <div class="dropdown">
                                          <button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false"
                                            data-bs-toggle="dropdown" type="button">{{ request('date_filter') ? ucfirst(str_replace('_', ' ', request('date_filter'))) : 'Date Filter' }}</button>
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
                                              <p class="mb-1"><strong>{{ $appointment->appointee_name }}</strong></p>
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
                                                  {{ $appointment->appointee_name }}, 
                                                  {{ $appointment->user->age ?? 'N/A' }} years old, 
                                                  {{ $appointment->user->contact_number ?? 'N/A' }}, 
                                                  {{ $appointment->user->address ?? 'N/A' }}
                                                @else
                                                  {{ $appointment->appointee_name ?? 'N/A' }}
                                                @endif
                                              </strong></p>
                                            </div>
                                            <div class="col-12">
                                              <div class="d-flex justify-content-end gap-2">
                                                @php
                                                  $admin = session('dentist') ?? \App\Models\Admin::find(session('admin_id'));
                                                @endphp
                                                
                                                @if ($admin && $admin->role_level != 3)
                                                <form method="POST" action="{{ route('dentist.appointments.claim', $appointment->id) }}" style="display: inline;">
                                                  @csrf
                                                  <button class="btn btn-success btn-sm" type="submit" onclick="return confirm('Claim this appointment?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-check-circle">
                                                      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                      <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                    </svg>
                                                    Accept
                                                  </button>
                                                </form>
                                                <form method="POST" action="{{ route('dentist.appointments.reject', $appointment->id) }}" style="display: inline;">
                                                  @csrf
                                                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Reject this appointment?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-x-circle">
                                                      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                    </svg>
                                                    Reject
                                                  </button>
                                                </form>
                                                @else
                                                <p class="text-blacck-50 small mb-0">View-only access</p>
                                                @endif
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endforeach
                                  @else
                                    <div class="card mb-2">
                                      <div class="card-body text-center">
                                        <p class="fw-bold mb-0">No unassigned appointments found matching your criteria.</p>
                                      </div>
                                    </div>
                                  @endif
                                  <hr class="mt-2 mb-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
    
    <script>
      function setFilter(filterType, filterValue) {
        // Update the appropriate hidden input based on the filter type
        if (filterType === 'date_filter') {
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
    </script>
</body>

</html>