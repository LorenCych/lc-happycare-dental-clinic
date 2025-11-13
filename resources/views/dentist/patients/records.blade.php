<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Patient Records - LC Happy Care Dental Clinic</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
    <!-- Start: Sidebar With Menu -->
    @include('partials.dentist-sidebar')
    <!-- End: Sidebar With Menu -->
    
    <!-- Start: Navbar Centered Brand -->
    @include('partials.dentist-navbar')
    <!-- End: Navbar Centered Brand -->

    <section class="d-flex" id="main-content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="text-primary mb-1">Patient Records</h2>
                            <p class="text-black-50 mb-0">Alphabetically ordered list of patients assigned to you</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 text-black-50">Total Patients: <strong>{{ $patientRecords->count() }}</strong></p>
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('dentist.patients.records') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Search by patient name..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('dentist.patients.records') }}" class="btn btn-outline-secondary">
                                            Clear
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Patient Records Cards -->
                    @if($patientRecords->count() > 0)
                        <div class="row">
                            @foreach($patientRecords as $record)
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" 
                                                     style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;">
                                                    {{ strtoupper(substr($record['user']->first_name, 0, 1) . substr($record['user']->last_name, 0, 1)) }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-1">
                                                        <a href="{{ route('dentist.patient.view-record', ['userId' => $record['user']->id]) }}" 
                                                           class="text-decoration-none">
                                                            {{ $record['full_name'] }}
                                                        </a>
                                                    </p>
                                                    <p class="text-black-50 mb-0 small">
                                                        Age: {{ $record['user']->age ?? 'N/A' }} • 
                                                        Gender: {{ $record['user']->gender ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <p class="text-black-50 small mb-1">Contact Information:</p>
                                                <p class="mb-1 small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-telephone me-1" viewBox="0 0 16 16">
                                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122L9.98 10.97a6.676 6.676 0 0 1-3.257-.902 6.676 6.676 0 0 1-.902-3.257l.542-1.805a.678.678 0 0 0-.122-.58L3.654 1.328z"/>
                                                    </svg>
                                                    {{ $record['user']->contact_number ?? 'N/A' }}
                                                </p>
                                                <p class="mb-0 small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-geo-alt me-1" viewBox="0 0 16 16">
                                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                    {{ Str::limit($record['user']->address ?? 'N/A', 30) }}
                                                </p>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <p class="mb-0 text-black-50 small">Total Appointments</p>
                                                    <h6 class="text-primary mb-0">{{ $record['total_appointments'] }}</h6>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-0 text-black-50 small">Last Visit</p>
                                                    <h6 class="mb-0">
                                                        {{ \Carbon\Carbon::parse($record['last_appointment']->appointment_sched)->format('M j, Y') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent text-center">
                                            <a href="{{ route('dentist.patient.view-record', ['userId' => $record['user']->id]) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye me-1" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                </svg>
                                                View Full Record
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-slash text-black-50 mb-3" viewBox="0 0 16 16">
                                <path d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                            </svg>
                            <h5 class="text-black-50">No Patient Records Found</h5>
                            <p class="text-black-50">
                                @if(request('search'))
                                    No patients match your search criteria.
                                @else
                                    No patients have been assigned to you yet.
                                @endif
                            </p>
                            @if(request('search'))
                                <a href="{{ route('dentist.patients.records') }}" class="btn btn-outline-primary">View All Patients</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
</body>

</html>