<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Book Appointment - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
  @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <!-- Start: Sidebar With Menu -->
  @include('partials.registrant-sidebar')
  <!-- End: Sidebar With Menu -->
  
  <!-- Start: Navbar Centered Brand -->
  @include('partials.registrant-navbar')
  <!-- End: Navbar Centered Brand -->

  <!-- Modal now just for review-->
  <div class="modal fade" role="dialog" tabindex="-1" id="modalReviewAppointment">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Appointment Review</h4><button class="btn-close" type="button" aria-label="Close"
            data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-4">
              <h5><strong id="modalServices">No Service Selected</strong></h5>
              <hr>
              <p class="fs-4 text-black-50 mb-2" id="modalFullName">{{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? '' }}</p>
              <p><strong id="modalSchedule">Scheduled on: Not set</strong></p>
            </div>
            <div class="col-md-6">
              <p><strong>Age: </strong>{{ $user->age ?? '' }} years old</p>
            </div>
            <div class="col-md-6">
              <p><strong>Gender: </strong>{{ $user->gender ?? '' }}</p>
            </div>
            <div class="col">
              <p><strong>Address:&nbsp;</strong>{{ $user->address ?? '' }}</p>
              <p class="mb-3"><strong>Contact No: </strong>{{ $user->contact_number ?? '' }}</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">Return</button>
          <button class="btn btn-primary" type="button" id="submitAppointmentBtn">Create Appointment</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Start: Application Form -->
  <section class="bg-body">
    <div class="container d-flex justify-content-center align-items-center py-5">
      <div
        class="text-center bg-white border rounded-3 border-primary w-auto ps-4 pe-4 pt-3 pt-sm-3 pt-md-3 pt-lg-3 pt-xl-3 pt-xxl-3 pb-4 pb-sm-2 pb-md-3 pb-lg-3 pb-xl-4 pb-xxl-4">
        <div class="row">
          <div class="col d-flex justify-content-center align-items-center">
            <div class="bs-icon-xl bs-icon-circle bs-icon-primary my-4 bs-icon"><svg xmlns="http://www.w3.org/2000/svg"
                width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-calendar2-week-fill">
                <path
                  d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z">
                </path>
              </svg></div>
          </div>
        </div>
        <h1 class="text-dark mb-3">Appointment Creation</h1>
        <p class="text-center text-black w-75 mx-auto">Please select the service/treatment you would like to have, and
          the date you prefer to schedule the appointment. For appointments with uncertain treatments, lyou can choose
          treatment.</p>
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">
            <form id="appointmentForm" method="POST" action="{{ route('registrant.appointments.create') }}">
              <!-- Error display for individual fields -->
              @error('appointee_name') <div class="text-danger">{{ $message }}</div> @enderror
              @error('appointment_sched') <div class="text-danger">{{ $message }}</div> @enderror
              @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
              @error('service_id') <div class="text-danger">{{ $message }}</div> @enderror
              @error('status') <div class="text-danger">{{ $message }}</div> @enderror
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
              <!-- Removed hidden service_id input, checkboxes will submit service_id[] -->
              <input type="hidden" name="dentist_id" value="">

              <hr>
              <p class="text-start text-black-50 mb-md-4 mb-lg-4 mb-xl-4 mb-xxl-3">Your name, age, gender, and contact
                details are tied to the details your provided during account creation, unless you already updated it. To
                edit your personal information,&nbsp;<a class="mt-0" href="{{ route('registrant.account.update-info', ['user_id' => $user->id]) }}">click here.</a></p>
            <h3 class="text-start text-black-50 mb-3">This Appointment is meant for:</h3>
<div class="row mb-3">
  <div class="col-12 col-sm-12 col-lg-4 col-xl-4">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="firstname">First name</label>
    <input class="border border-dark-subtle mb-2 form-control" type="text" id="firstname" name="first_name" placeholder="" required readonly value="{{ $user->first_name ?? 'None' }}">
  </div>
  <div class="col col-sm-12 col-lg-4 col-xl-4">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="middlename">Middle name</label>
    <input class="border border-dark-subtle mb-2 form-control" type="text" id="middlename" name="middle_name" placeholder="" readonly value="{{ $user->middle_name ?? '' }}">
  </div>
  <div class="col col-sm-12 col-lg-4 col-xl-4">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="lastname">Last name</label>
    <input class="border border-dark-subtle mb-2 form-control" type="text" id="lastname" name="last_name" placeholder="" required readonly value="{{ $user->last_name ?? '' }}">
  </div>
</div>

<div class="row mb-3">
  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="date">Age</label>
    <input class="border-dark-subtle form-control" type="text" id="date" required readonly value="{{ $user->age ?? '' }}">
  </div>
  <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="lastname-1">Gender</label>
    <input class="border-dark-subtle form-control" type="text" id="gender" required readonly value="{{ $user->gender ?? '' }}">
  </div>
</div>

<div class="row mb-3">
  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="address">Address</label>
    <input class="border-dark-subtle form-control" type="text" id="address" required readonly value="{{ $user->address ?? '' }}">
  </div>
  <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
    <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="contact">Contact Number</label>
    <input class="border-dark-subtle form-control" type="text" id="contact" required readonly value="{{ $user->contact_number ?? '' }}">
  </div>
</div>

<hr>
<h3 class="text-start text-black-50 mb-3">Purpose of Appointment</h3>
<div class="row mb-3">
  <div class="col-12">
    <label class="form-label d-flex justify-content-start" for="services">Select Services</label>
    
   <!-- Toggle Button -->
  <div class="row mb-3">
      <div class="col-12">
 <button class="btn btn-warning mb-2 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#serviceList" aria-expanded="false" aria-controls="serviceList">
     Choose Services
    </button>
      </div>
   
  </div>


<!-- Collapsible Checkbox List -->
<div class="collapse" id="serviceList">
  <div class="card card-body border-dark-subtle p-3">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2">
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="1" id="service_1">
          <label class="form-check-label" for="service_1">Checkup</label>
        </div>
      </div>
       <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="2" id="service_2">
          <label class="form-check-label" for="service_2">Teeth Cleaning</label>
        </div>
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="3" id="service_3">
          <label class="form-check-label" for="service_3">Tooth Extraction</label>
        </div>
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="4" id="service_4">
          <label class="form-check-label" for="service_4">Root Canal Treatment</label>
        </div>
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="5" id="service_5">
          <label class="form-check-label" for="service_5">Dental Fillings</label>
        </div>
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_id[]" value="6" id="service_6">
          <label class="form-check-label" for="service_6">Orthodontic Consultation</label>
        </div>
      </div>
    </div>
    
  </div>
</div>

  <div class="col-12 mt-3">
    <label class="form-label d-flex justify-content-start" for="other_services">Others</label>
    <input class="border-dark-subtle form-control" type="text" id="other_services" name="other_services" placeholder="Specify if not listed (e.g., Teeth Whitening, Dental Crown, etc.)">
  </div>

              <hr>
              <h3 class="text-start text-black-50 mb-3">Set Date and Time</h3>
              <p class="text-start text-black-50 mb-md-4 mb-lg-4 mb-xl-4 mb-xxl-3">Available date and time are shown
                below. Unavailability of appointment dates are also shown here.</p>
              <div class="row mb-3">
                <div class="col-12 col-sm-12 col-lg-6 col-xl-6"><label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="verificationcode">Date</label><input class="border-dark-subtle form-control" type="date" name="appointment_sched" required></div>
                <div class="col-12 col-sm-12 col-lg-6 col-xl-6"><label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="appointment_time">Time</label><input class="border-dark-subtle form-control" type="time" id="appointment_time" name="appointment_time" min="08:00" max="17:00" required></div>
              </div>
              <div class="row gy-2 mt-4 mb-3">
                <div class="col-12 col-sm-12 col-lg-6 col-xl-6 d-flex flex-grow-0"><button class="btn btn-light w-100"
                    type="button" id="clearBtn">Clear</button></div>
        <div class="col-12 col-sm-12 col-lg-6 col-xl-6"><button class="btn btn-primary w-100 me-2" type="button"
          data-bs-target="#modalReviewAppointment" data-bs-toggle="modal" id="reviewAppointmentBtn">Review Appointment</button></div>
              </div>
              <div class="modal-footer">
  
  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End: Application Form -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('reviewAppointmentBtn').addEventListener('click', function() {
    // Get selected service IDs and map to names
    let serviceNames = [];
    document.querySelectorAll('input[name="service_id[]"]:checked').forEach(function(checkbox) {
      let label = document.querySelector(`label[for='${checkbox.id}']`);
      if (label) {
        serviceNames.push(label.textContent.trim());
      }
    });
    let otherServices = document.getElementById('other_services') ? document.getElementById('other_services').value : '';
    let servicesText = serviceNames.length ? serviceNames.join(', ') : 'No Service Selected';
    if (otherServices) {
      servicesText += (serviceNames.length ? ', ' : '') + otherServices;
    }
    if (!serviceNames.length && !otherServices) {
      servicesText = 'No Service Selected';
    }
    document.getElementById('modalServices').textContent = servicesText;

    // Get full name
    let firstName = document.getElementById('firstname') ? document.getElementById('firstname').value : '';
    let middleName = document.getElementById('middlename') ? document.getElementById('middlename').value : '';
    let lastName = document.getElementById('lastname') ? document.getElementById('lastname').value : '';
    document.getElementById('modalFullName').textContent = `${firstName} ${middleName} ${lastName}`.trim();

    // Get date and time
    let date = document.querySelector('input[type="date"]') ? document.querySelector('input[type="date"]').value : '';
    let time = document.querySelector('input[type="time"]') ? document.querySelector('input[type="time"]').value : '';
    let scheduleText = 'Scheduled on: ';
    if (date && time) {
      // Format date as Month Day, Year
      let d = new Date(date);
      let options = { year: 'numeric', month: 'long', day: 'numeric' };
      scheduleText += `${d.toLocaleDateString(undefined, options)} at ${time}`;
    } else {
      scheduleText += 'Not set';
    }
    document.getElementById('modalSchedule').textContent = scheduleText;
  });

  // Make modal 'Create Appointment' button submit the main form
  document.getElementById('submitAppointmentBtn').addEventListener('click', function() {
    document.getElementById('appointmentForm').submit();
  });

  // Time validation for clinic hours (8:00 AM - 5:00 PM)
  const timeInput = document.getElementById('appointment_time');
  if (timeInput) {
    timeInput.addEventListener('change', function() {
      const selectedTime = this.value;
      const [hours, minutes] = selectedTime.split(':').map(Number);
      const timeInMinutes = hours * 60 + minutes;
      const openTime = 8 * 60; // 8:00 AM in minutes
      const closeTime = 17 * 60; // 5:00 PM in minutes
      
      if (timeInMinutes < openTime || timeInMinutes > closeTime) {
        alert('Please select a time between 8:00 AM and 5:00 PM. Our clinic operates during these hours only.');
        this.value = ''; // Clear the invalid time
        this.focus(); // Focus back to the input
      }
    });
  }

  // Form submission validation
  document.getElementById('appointmentForm').addEventListener('submit', function(e) {
    const timeField = document.getElementById('appointment_time');
    if (timeField && timeField.value) {
      const selectedTime = timeField.value;
      const [hours, minutes] = selectedTime.split(':').map(Number);
      const timeInMinutes = hours * 60 + minutes;
      const openTime = 8 * 60; // 8:00 AM in minutes
      const closeTime = 17 * 60; // 5:00 PM in minutes
      
      if (timeInMinutes < openTime || timeInMinutes > closeTime) {
        e.preventDefault();
        alert('Please select a time between 8:00 AM and 5:00 PM before submitting.');
        timeField.focus();
        return false;
      }
    }
  });

  // Clear button functionality
  document.getElementById('clearBtn').addEventListener('click', function() {
    // Clear all service checkboxes
    document.querySelectorAll('input[name="service_id[]"]').forEach(function(checkbox) {
      checkbox.checked = false;
    });
    
    // Clear other services text field
    const otherServicesField = document.getElementById('other_services');
    if (otherServicesField) {
      otherServicesField.value = '';
    }
    
    // Clear date field
    const dateField = document.querySelector('input[name="appointment_sched"]');
    if (dateField) {
      dateField.value = '';
    }
    
    // Clear time field
    const timeField = document.querySelector('input[name="appointment_time"]');
    if (timeField) {
      timeField.value = '';
    }
    
    // Collapse the service list if it's open
    const serviceList = document.getElementById('serviceList');
    if (serviceList && serviceList.classList.contains('show')) {
      const collapseInstance = new bootstrap.Collapse(serviceList, {
        toggle: false
      });
      collapseInstance.hide();
    }
    
    // Optional: Show a brief feedback to user
    const clearBtn = document.getElementById('clearBtn');
    const originalText = clearBtn.textContent;
    clearBtn.textContent = 'Cleared!';
    clearBtn.classList.add('btn-success');
    clearBtn.classList.remove('btn-light');
    
    setTimeout(function() {
      clearBtn.textContent = originalText;
      clearBtn.classList.remove('btn-success');
      clearBtn.classList.add('btn-light');
    }, 1000);
  });
});
</script>
</body>

</html>