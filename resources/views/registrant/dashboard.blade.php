<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Dashboard - LC Happy Care Dental Clinic</title>
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

  <div class="toast-container position-fixed top-0 end-0 flex-row-reverse justify-content-start align-content-end">
    <div class="toast fade text-end hide" role="alert" id="toastNotificattion">
      <div class="toast-header"><img class="img-fluid me-2"><strong class="text-black-50 me-auto">Notification
          Title</strong><small class="text-black-50">10 min ago</small><button class="btn-close ms-2 mb-1 close"
          type="button" aria-label="Close" data-bs-dismiss="toast"></button></div>
      <div class="toast-body" role="alert">
        <p class="text-start">Your action has been saved successfully. Wait for more updates in your dashboard, contact,
          or email information.&nbsp;</p>
      </div>
    </div>
  </div>
  <section class="mt-4"><!-- Start: 1 Row 2 Columns -->
    <div class="container">
      <div class="row" style="height: 240px;">
        <div class="col-md-7 col-lg-8 col-xl-6">
          <div class="card mb-3">
            <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
              style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
              <h6 class="my-2">LC HAPPY CARE DENTAL CLINIC</h6>
            </div>
            <div class="card-body">
              <div class="card-text">
                <h1 class="mb-1">Welcome, {{ $user->first_name }}!</h1>
                <p class="text-black-50">Profile Information</p>
              </div>
              <div class="row gx-2 gy-1"><!-- Start: Name -->
                <div class="col-6 col-md-12 col-lg-5 col-xxl-6">
                  <p class="text-black-50 mb-0"><strong>Name</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ $user->fullname() }}</strong></p>
                </div><!-- End: Name --><!-- Start: Contact -->
                <div class="col-6 col-xxl-6 offset-lg-0">
                  <p class="text-black-50 mb-0"><strong>Contact</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ $user->contact_number }}</strong></p>
                </div><!-- End: Contact --><!-- Start: Age -->
                <div class="col-6 col-sm-4 col-md-5 col-lg-3 col-xl-3 col-xxl-2">
                  <p class="text-black-50 mb-0"><strong>Age</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ $user->age }}</strong></p>
                </div><!-- End: Age --><!-- Start: Gender -->
                <div class="col col-md-6 col-lg-2 col-xl-2 col-xxl-4">
                  <p class="text-black-50 mb-0"><strong>Gender</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ $user->gender }}</strong></p>
                </div><!-- End: Gender --><!-- Start: Address -->
                <div class="col-6 col-md-6 col-xxl-6">
                  <p class="text-black-50 mb-0"><strong>Address</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ $user->address }}</strong></p>
                </div><!-- End: Address -->
              </div>
              <hr class="mt-2 mb-2">
              <p class="text-black-50 mb-2 card-subtitle">Ensure your provided information are up-to-date.</p>
              <div class="row gy-2">
                <div class="col col-lg-4"><a href="{{ route('registrant.account.update-info', ['user_id' => $user->id]) }}">Update Profile Info</a></div>
                <div class="col col-lg-3 col-xxl-3 ps-2 pe-1"><a href="{{ route('registrant.account.manage', ['user_id' => $user->id]) }}">Manage
                    Account</a></div>
                <div class="col-12 col-lg-5 col-xl-5 col-xxl-5"><a href="{{ route('registrant.appointments.book', ['user_id' => $user->id]) }}">Create New
                    Appointment</a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 col-lg-4 col-xl-6">

<?php
      // Get all upcoming appointments
      $upcomingAppointments = \App\Models\Appointment::where('user_id', $user->id)
        ->where('appointment_sched', '>', now())
        ->where('status', '!=', 'withdrawn')
        ->orderBy('appointment_sched', 'asc')
        ->get();

      // Get the next one and count
      $upcomingAppointment = $upcomingAppointments->first();
      $upcomingCount = $upcomingAppointments->count();
?>

@if ($upcomingAppointment)
   <div class="card mb-3">
            <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
              style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
              <h6 class="my-2">UPCOMING APPOINTMENT</h6>
            </div>
            <div class="card-body">
              <div class="card-text">
                <h5 class="mb-1"><strong>
                  @php
                    $services = [];
                    if ($upcomingAppointment->services && $upcomingAppointment->services->count()) {
                        $services = $upcomingAppointment->services->pluck('service_name')->toArray();
                    }
                    if ($upcomingAppointment->other_services) {
                        $services[] = $upcomingAppointment->other_services;
                    }
                  @endphp
                  {{ count($services) > 0 ? implode(', ', $services) : 'N/A' }}
                </strong></h5>
                <p>{{ $upcomingAppointment->dentist ? $upcomingAppointment->dentist->fullname() : 'Awaiting dentist assignment' }}</p>
              </div>
              <div class="row">
                <div class="col col-7">
                  <p class="text-black-50 mb-0"><strong>SCHEDULE</strong></p>
                <p class="mt-1 mb-0"><strong>{{ \Carbon\Carbon::parse($upcomingAppointment->appointment_sched)->format('F j, Y') }}</strong></p>
                </div>
                <div class="col col-xxl-5">
                  <p class="text-black-50 mb-0"><strong>TIME</strong></p>
                  <p class="mt-1 mb-0"><strong>{{ \Carbon\Carbon::parse($upcomingAppointment->appointment_sched)->format('g:i A') }}</strong></p>
                </div>
              </div>
              <hr class="mt-2 mb-2">

              @if ($upcomingCount > 1)
                <p class="text-black-50 mb-2 card-subtitle">You have {{ $upcomingCount - 1 }} more upcoming appointments. Click below to view and manage them.</p>
              @else
                <p class="text-black-50 mb-2 card-subtitle">All upcoming appointments will appear here.</p>
              @endif

              <a class="card-link" href="{{ route('registrant.appointments.upcoming', ['user_id' => $user->id]) }}">View and Manage</a>
            </div>
          </div>
@else
 <div class="card mb-3">
        <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
            style="background: linear-gradient(-160deg, #6c757d 31%, #343a40 91%), var(--bs-dark);">
            <h6 class="my-2">UPCOMING APPOINTMENT</h6>
        </div>
        <div class="card-body text-center">
            <div class="card-text">
                <h5 class="mb-2"><strong>No Appointments Scheduled</strong></h5>
                <p class="text-black-50">You currently have no upcoming appointments.</p>
            </div>
            <hr class="mt-2 mb-3">
            <p class="text-black-50 mb-2 card-subtitle">Once scheduled, your appointments will appear here.</p>
            <a class="btn btn-outline-warning" href="{{ route('registrant.appointments.book', ['user_id' => $user->id]) }}">Schedule Now</a>
        </div>
    </div>
@endif
         
        </div>
        <div class="col-12 ms-0">
          <div class="card">
            <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center"
              style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
              <h6 class="my-2">APPOINTMENT HISTORY</h6>
            </div>
            <div class="card-body">
              @if ($appointments && $appointments->count())
                @foreach ($appointments->sortByDesc('appointment_sched')->take(5) as $appointment)
                  <div class="card mb-2">
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
                    </div>
                    <div class="card-body">
                      <div class="row gy-2">
                        <div class="col-12 col-md-4">
                          <h5 class="text-black-50 mb-1"><strong>Dental Specialist</strong></h5>
                          <p class="mb-1"><strong>{{ $appointment->dentist ? $appointment->dentist->fullname() : 'No Assigned Dentist' }}</strong></p>
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
                          <p class="mb-1"><strong>{{ $appointment->appointee_name }}</strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="card mb-2">
                  <div class="card-header">
                    <h6 class="mb-0">No appointment history found.</h6>
                  </div>
                </div>
              @endif
              <hr class="mt-2 mb-2">
              <p class="text-black-50 mb-2 card-subtitle">Only your 5 latest appointments will be shown here.</p><a class="card-link"
                href="{{ route('registrant.appointments.history', ['user_id' => $user->id]) }}">View Full History</a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End: 1 Row 2 Columns -->
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
</body>

</html>