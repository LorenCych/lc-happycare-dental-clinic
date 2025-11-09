<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Dentist Dashboard - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <!-- Reschedule Appointment Modal -->
  <div class="modal fade" role="dialog" tabindex="-1" id="modalRescheduleAppointment">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Reschedule Appointment</h4>
          <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-12">
              <h5><strong id="modalTreatmentName">Treatment: <span></span></strong></h5>
              <hr>
              <p class="fs-4 text-black-50 mb-2" id="modalPatientName">Patient: <span></span></p>
              <p><strong id="modalCurrentSchedule">Current Schedule: <span></span></strong></p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="newDate" class="form-label">New Date</label>
              <input type="date" class="form-control" id="newDate" name="newDate" required>
            </div>
            <div class="col-md-6">
              <label for="newTime" class="form-label">New Time</label>
              <input type="time" class="form-control" id="newTime" name="newTime" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="button" id="submitRescheduleBtn">Reschedule</button>
        </div>
      </div>
    </div>
  </div>

  <section class="d-flex"><!-- Start: Sidebar With Icons -->
    @include('partials.dentist-sidebar')
    <!-- End: Sidebar With Icons -->
    <div class="bg-body flex-grow-1 p-3" id="main-content">

      @if ($admin && $admin->role_level == 1)
      <h2>Admin - Dentist's Dashboard</h2>
      @elseif ($admin && $admin->role_level == 2)
      <h2>Dentist's Dashboard</h2>
      @elseif ($admin && $admin->role_level == 3)
      <h2>Assistant's Dashboard</h2>
      @endif
      
      <!-- Flash Messages -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Access Denied!</strong> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          {{ session('warning') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          {{ session('info') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">Welcome, {{ $admin->first_name }} {{ $admin->last_name }}</h5>
          <h6 class="text-black-50 mb-2 card-subtitle">Manage your appointments and modify patient's treatment from
            here.</h6>
          <div class="container position-relative h-100 mt-7" style="top: -50px;">
            <div class="row gy-5 gy-lg-0 row-cols-1 row-cols-md-2 row-cols-lg-3">
              <div class="col">
                <div class="card h-100">
                  <div class="card-body p-4 pt-5">
                    <div
                      class="bs-icon-lg bs-icon-circle bs-icon-primary position-absolute d-flex flex-shrink-0 justify-content-center align-items-center mb-3 bs-icon"
                      style="top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        fill="currentColor" viewBox="0 0 16 16" class="bi bi-calendar-plus-fill">
                        <path
                          d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M8.5 8.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5a.5.5 0 0 1 1 0">
                        </path>
                      </svg></div>
                    <h2 class="card-title">{{ \App\Models\Appointment::where('dentist_id', $admin->id)->where('appointment_sched', '>=', now())->whereIn('status', ['assigned', 'rescheduled'])->count() }}</h2>
                    <h5 class="text-dark card-title">Upcoming Appointments</h5>
                  </div>
                  <div class="card-footer p-4 py-3" style="background: rgb(44,49,52);"></div>
                </div>
              </div>
              <div class="col">
                <div class="card h-100">
                  <div class="card-body p-4 pt-5">
                    <div
                      class="bs-icon-lg bs-icon-circle bs-icon-primary position-absolute d-flex flex-shrink-0 justify-content-center align-items-center mb-3 bs-icon"
                      style="top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        fill="currentColor" viewBox="0 0 16 16" class="bi bi-people-fill">
                        <path
                          d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5">
                        </path>
                      </svg></div>
                    <h2 class="card-title">{{ \App\Models\Appointment::where('dentist_id', $admin->id)->where('appointment_sched', '>=', now())->whereIn('status', ['assigned', 'rescheduled'])->distinct('user_id')->count('user_id') }}</h2>
                    <h5 class="text-dark card-title">Patients</h5>
                  </div>
                  <div class="card-footer p-4 py-3" style="background: rgb(44,49,52);"></div>
                </div>
              </div>
              <div class="col">
                <div class="card h-100">
                  <div class="card-body p-4 pt-5">
                    <div
                      class="bs-icon-lg bs-icon-circle bs-icon-primary position-absolute d-flex flex-shrink-0 justify-content-center align-items-center mb-3 bs-icon"
                      style="top: -30px;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        fill="currentColor" viewBox="0 0 16 16" class="bi bi-journal-bookmark-fill">
                        <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z">
                        </path>
                        <path
                          d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2">
                        </path>
                        <path
                          d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z">
                        </path>
                      </svg></div>
                    @php
                      $appointments = \App\Models\Appointment::where('dentist_id', $admin->id)
                        ->where('appointment_sched', '>=', now())
                        ->whereIn('status', ['assigned', 'rescheduled'])
                        ->with('services')
                        ->get();
                      
                      $allTreatments = collect();
                      
                      foreach ($appointments as $appointment) {
                        // Add regular services
                        if ($appointment->services && $appointment->services->count()) {
                          foreach ($appointment->services as $service) {
                            $allTreatments->push(strtolower(trim($service->service_name)));
                          }
                        }
                        
                        // Add other services (comma-separated)
                        if ($appointment->other_services) {
                          $otherServices = explode(',', $appointment->other_services);
                          foreach ($otherServices as $service) {
                            $trimmedService = strtolower(trim($service));
                            if (!empty($trimmedService)) {
                              $allTreatments->push($trimmedService);
                            }
                          }
                        }
                      }
                      
                      $uniqueTreatmentCount = $allTreatments->unique()->count();
                    @endphp
                    <h2 class="card-title">{{ $uniqueTreatmentCount }}</h2>
                    <h5 class="text-dark card-title">Treatments</h5>
                  </div>
                  <div class="card-footer p-4 py-3" style="background: rgb(44,49,52);"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
      $assignedAppointment = \App\Models\Appointment::where('dentist_id', $admin->id)
        ->where('appointment_sched', '>=', now())
        ->whereIn('status', ['assigned', 'rescheduled'])
        ->orderBy('appointment_sched', 'asc')
        ->get();
?>

  @if ($admin->role_level != 3)
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Upcoming Appointments</h5>
          <h6 class="text-black-50 mb-2 card-subtitle">Here are your assigned appointments.</h6>
          <div class="table-responsive" style="max-height: 313px;">
            <table class="table table-striped table-hover table-borderless">
              <thead>
                <tr>
                  <th class="text-truncate bg-primary">Schedule</th>
                  <th class="bg-primary">Treatment</th>
                  <th class="bg-primary">Patient</th>
                  <th class="bg-primary">Status</th>
                  <th class="text-center bg-primary">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($assignedAppointment as $appointment)
                  <tr>
                  <td class="text-truncate">{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}</td>
                  <td>
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
                  </td>
                  <td>{{ $appointment->appointee_name }}</td>
                  <td>{{ $appointment->status }}</td>
                  <td class="text-center">
                    <button class="btn btn-link me-2 p-0 reschedule-link" 
                       data-bs-toggle="modal" data-bs-target="#modalRescheduleAppointment"
                       data-appointment-id="{{ $appointment->id }}" 
                       data-treatment="@php
                         $services = [];
                         if ($appointment->services && $appointment->services->count()) {
                             $services = $appointment->services->pluck('service_name')->toArray();
                         }
                         if ($appointment->other_services) {
                             $services[] = $appointment->other_services;
                         }
                         echo count($services) > 0 ? implode(', ', $services) : 'N/A';
                       @endphp"
                       data-patient="{{ $appointment->appointee_name }}" 
                       data-schedule="{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}">
                       Reschedule
                    </button>

                     <form action="{{ route('dentist.appointments.unassign', $appointment->id) }}" method="POST" style="display:inline;">
                       @csrf
                       <button type="submit" class="btn btn-link me-2 p-0">Drop</button>
                     </form>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><a class="card-link" href="{{ route('dentist.appointments.assigned') }}">View and Manage</a>
        </div>
      </div>
  @else
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Access Restricted</h5>
          <h6 class="text-black-50 mb-2 card-subtitle">You don't have permission to view upcoming appointments.</h6>
          <p class="text-muted">Contact your administrator for access.</p>
        </div>
      </div>
  @endif

<?php
      $unassignedAppointment = \App\Models\Appointment::where('status', 'pending')
        ->where('dentist_id', null)
        ->where('status', 'pending')
        ->where('appointment_sched', '>=', now())
        ->orderBy('appointment_sched', 'asc')
        ->get();
?>

      <div class="card mt-2">
        <div class="card-body">
          <h5 class="card-title">Unassigned Appointments</h5>
          <h6 class="text-black-50 mb-2 card-subtitle">Here are the appointments that are yet to be approved and
            assigned to dentists.</h6>
          <div class="table-responsive" style="max-height: 313px;">
            <table class="table table-striped table-hover table-borderless">
              <thead class="table-dark">
                <tr>
                  <th>Schedule</th>
                  <th>Treatment</th>
                  <th>Patient</th>
                  <th>Status</th>
                    @if ($admin->role_level != 3)
                  <th class="text-center">Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>

@foreach ($unassignedAppointment as $appointment)
<tr>
    <td class="text-truncate">{{ \Carbon\Carbon::parse($appointment->appointment_sched)->format('F j, Y - g:i A') }}</td>
    <td>
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
    </td>
    <td>{{ $appointment->appointee_name }}</td>
    <td>{{ $appointment->status }}</td>

      @if ($admin->role_level != 3)
    <td class="text-center">
        <form action="{{ route('dentist.appointments.claim', $appointment->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-link me-2 p-0">Accept Appointment</button>
        </form>
         <form action="{{ route('dentist.appointments.reject', $appointment->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-link me-2 p-0" onclick="return confirm('Are you sure you want to reject this appointment?')">Reject</button>
        </form>
    </td>
      @endif
</tr>
@endforeach
              </tbody>
            </table>
          </div><a class="card-link" href="{{ route('dentist.appointments.unassigned') }}">View Details</a>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalRescheduleAppointment');
    const treatmentName = document.querySelector('#modalTreatmentName span');
    const patientName = document.querySelector('#modalPatientName span');
    const currentSchedule = document.querySelector('#modalCurrentSchedule span');
    let appointmentId = null;

    document.querySelectorAll('.reschedule-link').forEach(function (link) {
      link.addEventListener('click', function () {
        treatmentName.textContent = link.getAttribute('data-treatment');
        patientName.textContent = link.getAttribute('data-patient');
        currentSchedule.textContent = link.getAttribute('data-schedule');
        appointmentId = link.getAttribute('data-appointment-id');
        // Optionally clear previous date/time selections
        document.getElementById('newDate').value = '';
        document.getElementById('newTime').value = '';
      });
    });

   document.getElementById('submitRescheduleBtn').onclick = function () {
    const date = document.getElementById('newDate').value;
    const time = document.getElementById('newTime').value;
    if (!date || !time) {
      alert('Please select both date and time.');
      return;
    }
    const newDateTime = date + ' ' + time;

    // Create a form and submit via POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/dentist/appointments/' + appointmentId + '/reschedule/' + encodeURIComponent(newDateTime);

    // Add CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = '_token';
      input.value = csrfToken;
      form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
  };
  });
  </script>
</body>

</html>