<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>View Patient Record - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <section class="d-flex">
    <!-- Start: Sidebar With Icons -->
    @include('partials.dentist-sidebar')
    <!-- End: Sidebar With Icons -->


        <div class="bg-body flex-grow-1 p-3" id="main-content">
            <section class="mt-4">
                <div class="container">
                    <div class="row" style="height: 240px;">
                        <div class="col-12 ms-0">
                            <div class="card">
                                <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center" style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
                                    <h6 class="my-2">PATIENT'S RECORD</h6>
                                </div>
                                <div class="card-body">
                                    <h2 class="my-2 card-title"><strong>Viewing Record for:</strong></h2>
                                    <p class="fs-4 text-black-50 mb-2">{{ $patient->fullname() }}</p>
                                    <hr class="mt-2 mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Address:&nbsp;</strong>{{ $patient->address ?? 'N/A' }}</p>
                                            <p class="mb-3"><strong>Contact No: </strong>{{ $patient->contact_number ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col">
                                            <p><strong>Age: </strong>{{ $patient->age ?? 'N/A' }} years old</p>
                                            <p><strong>Gender: </strong>{{ ucfirst($patient->gender ?? 'N/A') }}</p>
                                        </div>
                                    </div>
                                    <div></div>
                                    <hr class="mt-4 mb-4">
                                    <div class="row">
                                        <div>
                                            <form method="GET" action="{{ route('dentist.patient.view-record', $patient->id) }}" style="display: none;" id="filterForm">
                                                <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
                                                <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
                                                <input type="hidden" name="date_filter" id="dateFilterInput" value="{{ request('date_filter') }}">
                                            </form>
                                            <div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search">
                                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                                                    </svg></span><input class="form-control" type="text" placeholder="Search appointments, treatments..." value="{{ request('search') }}" onkeyup="handleSearch(event)"><button class="btn btn-primary" type="button" onclick="performSearch()">Search</button></div>
                                        </div>
                                        <div class="col d-flex justify-content-end align-items-center gap-2 mt-2 mb-2">
                                            <div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">{{ request('status') ? ucfirst(request('status')) : 'Status' }}</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', '')">All Statuses</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'completed')">Completed</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'assigned')">Assigned</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'rescheduled')">Rescheduled</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('status', 'expired')">Expired</a>
                                                </div>
                                            </div>
                                            <div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">{{ request('date_filter') ? ucfirst(str_replace('_', ' ', request('date_filter'))) : 'Date' }}</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', '')">All Time</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_week')">This Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'last_30_days')">Last 30 Days</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_month')">This Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="setFilter('date_filter', 'this_year')">This Year</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-start text-black-50 mb-md-4 mb-lg-4 mb-xl-4 mb-xxl-3">This list shows your interactions with this patient.</p>
                                    @if($appointments && $appointments->count() > 0)
                                        @foreach($appointments as $appointment)
                                            <div class="card mb-2">
                                                <div class="card-header">
                                                    <h6 class="mb-0">{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}
                                                        @if (strtolower($appointment->status) === 'completed')
                                                            <span class="fs-6 text-black bg-success rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                                                        @elseif (strtolower($appointment->status) === 'withdrawn')
                                                            <span class="fs-6 text-white bg-danger rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                                                        @elseif (strtolower($appointment->status) === 'pending')
                                                            <span class="fs-6 text-warning border border-warning rounded-pill badge bg-transparent">{{ ucfirst($appointment->status) }}</span>
                                                        @elseif (strtolower($appointment->status) === 'assigned')
                                                            <span class="fs-6 text-black bg-warning rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                                                        @elseif (strtolower($appointment->status) === 'rescheduled')
                                                            <span class="fs-6 text-black bg-info rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                                                        @elseif (strtolower($appointment->status) === 'expired')
                                                            <span class="fs-6 text-white bg-secondary rounded-pill badge">{{ ucfirst($appointment->status) }}</span>
                                                        @else
                                                            <span class="fs-6 text-black bg-warning rounded-pill badge">{{ ucfirst($appointment->status ?? 'Unknown') }}</span>
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row gy-2">
                                                        <div class="col-12 col-md-4">
                                                            <h5 class="text-black-50 mb-1"><strong>Record of</strong></h5>
                                                            <p class="mb-1"><strong>{{ $appointment->appointee_name }}</strong></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black-50 mb-1"><strong>Treatment/Service</strong></h5>
                                                            <p class="mb-1"><strong>
                                                                @php
                                                                    $services = [];
                                                                    if ($appointment->services && $appointment->services->count()) {
                                                                        foreach ($appointment->services as $service) {
                                                                            $services[] = $service->service_name;
                                                                        }
                                                                    }
                                                                    if ($appointment->other_services) {
                                                                        $otherServices = explode(',', $appointment->other_services);
                                                                        $services = array_merge($services, array_map('trim', $otherServices));
                                                                    }
                                                                @endphp
                                                                {{ count($services) > 0 ? implode(', ', $services) : 'N/A' }}
                                                            </strong></p>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-black-50 mb-1"><strong>Patient Info</strong></h5>
                                                            <p class="mb-1"><strong>{{ ucfirst($patient->gender ?? 'N/A') }}, {{ $patient->age ?? 'N/A' }} years old, {{ $patient->contact_number ?? 'N/A' }}</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="card mb-2">
                                            <div class="card-body text-center">
                                                <p class="fw-bold mb-0">No appointment records found for this patient.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.min.js"></script>
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
    </script>
</body>

</html>