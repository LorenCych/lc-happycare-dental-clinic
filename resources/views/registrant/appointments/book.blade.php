<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Book Appointment - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  <style>
    /* Time calendar grid styling */
    #dailyCalendar { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); 
      gap: 12px; 
      max-width: 100%; 
      margin-top: 10px; 
    }
    .calendar-slot { 
      min-height: 80px; 
      padding: 12px 8px; 
      border-radius: 8px; 
      border: 2px solid #dee2e6; 
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); 
      text-align: center; 
      cursor: pointer; 
      font-size: 1rem; 
      font-weight: 500;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.2s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .calendar-slot:hover:not(.past):not(.occupied) { 
      transform: translateY(-2px); 
      box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
      border-color: #0d6efd; 
    }
    .calendar-slot.occupied { 
      background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%); 
      border-color: #dc3545; 
      color: #721c24; 
      cursor: not-allowed; 
    }
    .calendar-slot.selected { 
      background: linear-gradient(135deg, #cfe2ff 0%, #9ec5fe 100%); 
      border-color: #0d6efd; 
      color: #084298;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
    .calendar-slot.past { 
      background: linear-gradient(135deg, #e9ecef 0%, #d3d3d4 100%); 
      color: #6c757d; 
      cursor: not-allowed; 
      opacity: 0.7;
    }
    .slot-time {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 4px;
    }
    .slot-info {
      font-size: 0.75rem;
      font-weight: 400;
      opacity: 0.8;
      margin-top: 4px;
      line-height: 1.2;
    }
    .calendar-slot.occupied .slot-info {
      color: #721c24;
      font-weight: 500;
    }
    .calendar-slot.past .slot-info {
      color: #6c757d;
    }
  </style>
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
              
              <!-- Daily timeline calendar -->
              <div class="row mb-3">
                <div class="col-12">
                  <h6 class="text-black-50">Availability for <span id="calendarDateDisplay"></span></h6>
                  <div id="dailyCalendar" aria-live="polite" role="list"></div>
                </div>
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
    // Get selected service IDs and map to names. Prefer showing 'Other' text if provided.
    let serviceNames = [];
    document.querySelectorAll('input[name="service_id[]"]:checked').forEach(function(checkbox) {
      let label = document.querySelector(`label[for='${checkbox.id}']`);
      if (label) {
        serviceNames.push(label.textContent.trim());
      }
    });
    let otherServices = document.getElementById('other_services') ? document.getElementById('other_services').value.trim() : '';
    // Build display array and avoid showing 'No Service Selected' when an "other" value exists
    let displayServices = [];
    if (serviceNames.length) displayServices = displayServices.concat(serviceNames);
    if (otherServices) displayServices.push(otherServices);
    let servicesText = displayServices.length ? displayServices.join(', ') : 'No Service Selected';
    document.getElementById('modalServices').textContent = servicesText;

    // Get full name
    let firstName = document.getElementById('firstname') ? document.getElementById('firstname').value : '';
    let middleName = document.getElementById('middlename') ? document.getElementById('middlename').value : '';
    let lastName = document.getElementById('lastname') ? document.getElementById('lastname').value : '';
    document.getElementById('modalFullName').textContent = `${firstName} ${middleName} ${lastName}`.trim();

    // Get date and time
    let date = document.querySelector('input[name="appointment_sched"]') ? document.querySelector('input[name="appointment_sched"]').value : '';
    let time = document.querySelector('input[name="appointment_time"]') ? document.querySelector('input[name="appointment_time"]').value : '';
    let scheduleText = 'Scheduled on: ';
    if (date && time) {
  // Format date as 'Month Day, Year' (e.g. November 13, 2025)
  const dt = new Date(date);
  const opts = { year: 'numeric', month: 'long', day: 'numeric' };
  const formattedDate = dt.toLocaleDateString(undefined, opts);
      // Format time as 12-hour with AM/PM
      const formattedTime = typeof formatTo12Hour === 'function' ? formatTo12Hour(time) : time;
      scheduleText += `${formattedDate} at ${formattedTime}`;
    } else {
      scheduleText += 'Not set';
    }
    document.getElementById('modalSchedule').textContent = scheduleText;
  });

  // Make modal 'Create Appointment' button submit the main form
  document.getElementById('submitAppointmentBtn').addEventListener('click', function() {
    document.getElementById('appointmentForm').submit();
  });

  // Date validation to prevent past dates
  const dateInput = document.querySelector('input[name="appointment_sched"]');
  if (dateInput) {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
    
    dateInput.addEventListener('change', function() {
      const timeField = document.getElementById('appointment_time');
      
      // If time is already selected, validate the combined date/time
      if (timeField && timeField.value) {
        const selectedDateTime = new Date(this.value + ' ' + timeField.value);
        const now = new Date();
        
        if (selectedDateTime <= now) {
          alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
          timeField.value = ''; // Clear the time
        }
      }
    });
  }

  // Daily calendar rendering
  const dailyCalendar = document.getElementById('dailyCalendar');
  const calendarDateDisplay = document.getElementById('calendarDateDisplay');
  const dayScheduleUrl = '{{ route("registrant.appointments.day-schedule") }}';

  function formatTimeHHMM(date) {
    const h = String(date.getHours()).padStart(2, '0');
    const m = String(date.getMinutes()).padStart(2, '0');
    return `${h}:${m}`;
  }

  // format 'HH:MM' -> 'h:mm AM/PM'
  function formatTo12Hour(hhmm) {
    const [hh, mm] = hhmm.split(':').map(Number);
    const period = hh >= 12 ? 'PM' : 'AM';
    const hour12 = ((hh + 11) % 12) + 1; // convert 0->12
    return `${hour12}:${String(mm).padStart(2,'0')} ${period}`;
  }

  async function renderDailyCalendar(dateStr) {
    if (!dailyCalendar) return;
    // show date as 'Month Day, Year' (e.g. November 13, 2025)
    if (dateStr) {
      const dt = new Date(dateStr);
      const opts = { year: 'numeric', month: 'long', day: 'numeric' };
      calendarDateDisplay.textContent = dt.toLocaleDateString(undefined, opts);
    } else {
      calendarDateDisplay.textContent = '';
    }
    dailyCalendar.innerHTML = '';

    // build slot list from 08:00 to 16:30 (30-min increments)
    const slots = [];
    for (let h = 8; h <= 16; h++) {
      slots.push(`${String(h).padStart(2,'0')}:00`);
      slots.push(`${String(h).padStart(2,'0')}:30`);
    }
    // include 17:00 as last slot
    slots.push('17:00');

    // fetch appointments for the day
    let slotOccupancy = {};
    try {
      const resp = await fetch(dayScheduleUrl + '?date=' + encodeURIComponent(dateStr), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      if (resp.ok) {
        const json = await resp.json();
        slotOccupancy = json.slot_occupancy || {};
      }
    } catch (err) {
      console.error('Day schedule fetch error', err);
    }

    const now = new Date();
    slots.forEach(slot => {
      const div = document.createElement('div');
      div.className = 'calendar-slot';
      div.setAttribute('role', 'button');
      div.dataset.time = slot;
      
      // Create time display
      const timeDiv = document.createElement('div');
      timeDiv.className = 'slot-time';
      timeDiv.textContent = formatTo12Hour(slot);
      
      // Create info display  
      const infoDiv = document.createElement('div');
      infoDiv.className = 'slot-info';
      
      // mark past slots (only when calendar date is today)
      let slotDateTime = null;
      if (dateStr) {
        slotDateTime = new Date(dateStr + ' ' + slot);
      }
      
      const slotData = slotOccupancy[slot];
      if (slotDateTime && slotDateTime <= now) {
        div.classList.add('past');
        div.title = 'Past time';
        infoDiv.textContent = 'Past';
      } else if (slotData && !slotData.available) {
        div.classList.add('occupied');
        div.title = `Occupied (${slotData.count}/3 appointments)`;
        infoDiv.textContent = `Full (${slotData.count}/3)`;
      } else {
        // Show appointment count for available slots
        const count = slotData ? slotData.count : 0;
        infoDiv.textContent = count === 0 ? 'Available' : `${count}/3 booked`;
        if (slotData && slotData.count > 0) {
          div.title = `Available (${slotData.count}/3 appointments)`;
        } else {
          div.title = 'Available - click to select';
        }
        
        div.addEventListener('click', function() {
          // prevent selecting past/occupied slots
          if (this.classList.contains('past') || this.classList.contains('occupied')) return;
          // set time input and highlight selected
          document.querySelectorAll('.calendar-slot.selected').forEach(s => s.classList.remove('selected'));
          this.classList.add('selected');
          const timeInput = document.getElementById('appointment_time');
          if (timeInput) timeInput.value = this.dataset.time;
        });
      }
      
      div.appendChild(timeDiv);
      div.appendChild(infoDiv);
      dailyCalendar.appendChild(div);
    });
  }

  // initial render
  if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    if (!dateInput.value) dateInput.value = today;
    renderDailyCalendar(dateInput.value);
    dateInput.addEventListener('change', function() {
      renderDailyCalendar(this.value);
    });
  }

  // Availability check function
  async function checkAppointmentAvailability() {
    const dateField = document.querySelector('input[name="appointment_sched"]');
    const timeField = document.getElementById('appointment_time');
    
    if (!dateField || !timeField || !dateField.value || !timeField.value) {
      return true; // If fields not filled, skip check
    }

    const appointmentDateTime = dateField.value + ' ' + timeField.value;
    
    try {
      const response = await fetch('{{ route("registrant.appointments.check-availability") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          appointment_datetime: appointmentDateTime
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
      // On error, allow booking to proceed
      return true;
    }
  }

  // Time validation for clinic hours (8:00 AM - 5:00 PM)
  const timeInput = document.getElementById('appointment_time');
  if (timeInput) {
    timeInput.addEventListener('change', async function() {
      const selectedTime = this.value;
      const [hours, minutes] = selectedTime.split(':').map(Number);
      const timeInMinutes = hours * 60 + minutes;
      const openTime = 8 * 60; // 8:00 AM in minutes
      const closeTime = 17 * 60; // 5:00 PM in minutes
      
      if (timeInMinutes < openTime || timeInMinutes > closeTime) {
        alert('Please select a time between 8:00 AM and 5:00 PM. Our clinic operates during these hours only.');
        this.value = ''; // Clear the invalid time
        this.focus(); // Focus back to the input
        return;
      }

      // Check if the selected date and time is in the past or current time
      const dateInput = document.querySelector('input[name="appointment_sched"]');
      if (dateInput && dateInput.value) {
        const selectedDate = dateInput.value;
        const selectedDateTime = new Date(selectedDate + ' ' + selectedTime);
        const now = new Date();
        
        if (selectedDateTime <= now) {
          alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
          this.value = ''; // Clear the invalid time
          this.focus();
          return;
        }

        // Check availability
        await checkAppointmentAvailability();
      }
    });
  }

  // Form submission validation
  document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
    const timeField = document.getElementById('appointment_time');
    const dateField = document.querySelector('input[name="appointment_sched"]');
    
    if (timeField && timeField.value && dateField && dateField.value) {
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

      // Check if the selected date and time is in the past or current time
      const selectedDateTime = new Date(dateField.value + ' ' + selectedTime);
      const now = new Date();
      
      if (selectedDateTime <= now) {
        e.preventDefault();
        alert('Appointment time cannot be in the past or current time. Please select a future date and time.');
        timeField.focus();
        return false;
      }

      // Check availability before submitting
      e.preventDefault(); // Prevent default submission
      const isAvailable = await checkAppointmentAvailability();
      
      if (isAvailable) {
        // If available, submit the form
        e.target.submit();
      } else {
        timeField.focus();
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