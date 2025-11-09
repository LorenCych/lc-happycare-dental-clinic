<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Update Information - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
  @if ($errors->any())
    <div class="container mt-3">
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

    <!-- Start: Sidebar With Menu -->
  @include('partials.registrant-sidebar')
  <!-- End: Sidebar With Menu -->
  
  <!-- Start: Navbar Centered Brand -->
  @include('partials.registrant-navbar')
  <!-- End: Navbar Centered Brand -->
  
  <!-- Start: Application Form -->
  <section class="bg-body">
    <div class="container d-flex justify-content-center align-items-center py-5">
      <div
        class="text-center bg-white border rounded-3 border-primary w-auto ps-4 pe-4 pt-3 pt-sm-3 pt-md-3 pt-lg-3 pt-xl-3 pt-xxl-3 pb-4 pb-sm-2 pb-md-3 pb-lg-3 pb-xl-4 pb-xxl-4">
        <div class="row">
          <div class="col d-flex justify-content-center align-items-center">
            <div class="bs-icon-xl bs-icon-circle bs-icon-primary my-4 bs-icon"><svg xmlns="http://www.w3.org/2000/svg"
                width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person-fill-gear">
                <path
                  d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0">
                </path>
              </svg></div>
          </div>
        </div>
        <h1 class="text-dark mb-3">Update Information</h1>
        <p class="text-center text-black w-75 mx-auto">The provided information will be used as the <strong>Appointee's
            information</strong>&nbsp;for every future appointments created. Please ensure to provide the latest
          information especially if another person will be set up for an appointment.</p>
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">
            <form id="updateInfoForm" action="{{ route('registrant.account.save-appointee-info') }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{ old('user_id', $user ? $user->id : '') }}">
              <hr>
              <h3 class="text-start text-black-50 mb-3">Appointee's Information</h3>
              <div class="row mb-3">
                <div class="col-12 col-sm-12 col-lg-4 col-xl-4">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="firstname">First name</label>
                  <input class="border border-dark-subtle mb-2 form-control" type="text" id="firstname" name="first_name" value="{{ old('first_name', $user ? $user->first_name : '') }}" required>
                </div>
                <div class="col col-sm-12 col-lg-4 col-xl-4">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="middlename">Middle name</label>
                  <input class="border border-dark-subtle mb-2 form-control" type="text" id="middlename" name="middle_name" value="{{ old('middle_name', $user ? $user->middle_name : '') }}">
                </div>
                <div class="col col-sm-12 col-lg-4 col-xl-4">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="lastname">Last name</label>
                  <input class="border border-dark-subtle mb-2 form-control" type="text" id="lastname" name="last_name" value="{{ old('last_name', $user ? $user->last_name : '') }}" required>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="date">Birthday</label>
                  <input class="border-dark-subtle form-control" type="date" id="date" name="birthday" value="{{ old('birthday', $user ? $user->birthday : '') }}">
                </div>
                <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="gender">Gender</label>
                  <select class="border-dark-subtle form-select" id="gender" name="gender" required>
                    <option value="Male" {{ old('gender', $user ? $user->gender : '') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $user ? $user->gender : '') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $user ? $user->gender : '') == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="address">Address</label>
                  <input class="border-dark-subtle form-control" type="text" id="address" name="address" value="{{ old('address', $user ? $user->address : '') }}" required>
                </div>
                <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="contact">Contact Number</label>
                  <input class="border-dark-subtle form-control" type="text" id="contact" name="contact_number" value="{{ old('contact_number', $user ? $user->contact_number : '') }}" required>
                </div>
              </div>
              <div class="row gy-2 mt-4 mb-3">
        <div class="col-12 col-sm-12 col-lg-6 col-xl-6 d-flex flex-grow-0"><button class="btn btn-light w-100"
          type="button" id="clearBtn">Clear</button></div>
        <div class="col-12 col-sm-12 col-lg-6 col-xl-6"><button class="btn btn-primary w-100 me-2" type="button" data-bs-target="#modalUpdatedInfo" data-bs-toggle="modal">Review Changes</button></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End: Application Form -->
  <div class="modal fade" role="dialog" tabindex="-1" id="modalUpdatedInfo">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Appointment Review</h4><button class="btn-close" type="button" aria-label="Close"
            data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-4">
              <p class="fs-4 text-black-50 mb-2"><strong>John Doe D. Dela Cruz</strong></p>
              <hr>
            </div>
            <div class="col-md-6">
              <p><strong>Age: </strong>21 years old</p>
            </div>
            <div class="col-md-6">
              <p><strong>Gender: </strong>Male</p>
            </div>
            <div class="col">
              <p><strong>Address:&nbsp;</strong>123 St. Something, Somewhere, Maybe At Once</p>
              <p class="mb-3"><strong>Contact No: </strong>01234567890</p>
            </div>
          </div>
        </div>
          <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Return</button>
              <button class="btn btn-primary" type="button" id="saveChangesBtn">Save Changes</button></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const reviewBtn = document.querySelector('button[data-bs-target="#modalUpdatedInfo"]');
  reviewBtn.addEventListener('click', function () {
    // ...existing code for modal population...
  });

  // Make Save Changes button submit the main form explicitly
  document.getElementById('saveChangesBtn').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('updateInfoForm').submit();
  });

  // Clear button functionality
  document.getElementById('clearBtn').addEventListener('click', function() {
    // Clear all form fields
    document.getElementById('firstname').value = '';
    document.getElementById('middlename').value = '';
    document.getElementById('lastname').value = '';
    document.getElementById('date').value = '';
    document.getElementById('gender').selectedIndex = 0; // Reset to first option
    document.getElementById('address').value = '';
    document.getElementById('contact').value = '';
    
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const reviewBtn = document.querySelector('button[data-bs-target="#modalUpdatedInfo"]');
  reviewBtn.addEventListener('click', function () {
    // Get input values
    const firstName = document.getElementById('firstname').value;
    const middleName = document.getElementById('middlename').value;
    const lastName = document.getElementById('lastname').value;
    const birthday = document.getElementById('date').value;
    const gender = document.getElementById('gender').value;
    const address = document.getElementById('address').value;
    const contact = document.getElementById('contact').value;

    // Calculate age from birthday
    let ageText = '';
    if (birthday) {
      const birthDate = new Date(birthday);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      ageText = age + ' years old';
    } else {
      ageText = 'N/A';
    }

    // Update modal fields
    document.querySelector('#modalUpdatedInfo .fs-4').textContent = firstName + (middleName ? ' ' + middleName : '') + ' ' + lastName;
    document.querySelector('#modalUpdatedInfo .col-md-6:nth-child(2) p').innerHTML = '<strong>Age: </strong>' + ageText;
    document.querySelector('#modalUpdatedInfo .col-md-6:nth-child(3) p').innerHTML = '<strong>Gender: </strong>' + gender;
    document.querySelector('#modalUpdatedInfo .col p:nth-child(1)').innerHTML = '<strong>Address:&nbsp;</strong>' + address;
    document.querySelector('#modalUpdatedInfo .col p.mb-3').innerHTML = '<strong>Contact No: </strong>' + contact;
  });
});
</script>
</body>

</html>