<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Dental Clinic Landing Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body><!-- Start: Navbar Centered Links -->
@include('partials.home-navbar')
  
@if (session('success'))
 <div class="alert alert-success text-center text-success mt-3 d-flex align-items-center justify-content-center gap-2">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger text-center mt-3">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<style>

.hr-or {
    display: flex;
    align-items: center;
    text-align: center;
    /* margin-bottom is now handled by mb-4 in HTML */
}

.hr-or::before,
.hr-or::after {
    content: '';        /* Required to make pseudo-elements visible */
    flex-grow: 1;       /* CRUCIAL: Makes the line take up available space */
    height: 1px;        /* The thickness of the line */
    background-color: #dee2e6; /* Light gray line color (like Bootstrap HR) */
    margin: 0 10px;     /* Space between the line and the 'OR' text */
}

.hr-or span {
    color: #6c757d; /* Darker gray color for the 'OR' text */
    padding: 0 10px; /* Space around the text to separate it from the lines */
    font-size: 0.9em;
    font-weight: 500;
}

</style>

  <!-- Start: Sign Up -->
  <section class="bg-body">
    <div class="container d-flex justify-content-center align-items-center py-3">
      <div
        class="text-center bg-white border rounded-3 border-primary ps-4 pe-4 pt-3 pt-sm-3 pt-md-3 pt-lg-3 pt-xl-3 pt-xxl-3 pb-4 pb-md-5 pb-xxl-3 pb-xl-3">
        <div class="row">
          <div class="col d-flex justify-content-center align-items-center">
            <div class="bs-icon-xl bs-icon-circle bs-icon-primary my-4 bs-icon"><svg xmlns="http://www.w3.org/2000/svg"
                width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                <path
                  d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z">
                </path>
              </svg></div>
          </div>
        </div>
        <h1 class="text-dark mb-3">Log In</h1>
        <p class="w-75 mb-md-5 mx-auto">Please enter your login information to proceed on making appointment.</p>
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">

            <form action="{{ route ('login.attempt') }}" method="POST" id="loginForm">
              @csrf
          <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
          for="username">Username</label>
          <input class="border border-dark-subtle mb-4 form-control" type="text"
               name="username" id="username" placeholder="Username">
          <div class="hr-or mb-4">  <span>OR</span>
          </div>

                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="emailadd">E-mail
                Address</label>
                <input class="border border-dark-subtle mb-4 form-control" type="email" id="emailadd"
                name="email" placeholder="JohnDoe@gmail.com" inputmode="email">
                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                for="password">Password</label>
                <input class="border border-dark-subtle mb-4 form-control"
                type="password" id="password" name="password" placeholder="Password" required minlength="8" maxlength="18">
              <div class="row mb-3">
                <div class="col">
                 <button class="btn btn-primary w-100 mt-3" type="submit">Login</button>
                </div>
              </div><a href="/signup">No account yet? Create one here!</a>
            </form>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <a class="text-decoration-none" href="{{ route('registrant.password.request') }}">
            <i class="fas fa-key me-1"></i>Forgot Password?
          </a>
          <a class="text-decoration-none" href="{{ route('home.admin-login') }}">
            <i class="fas fa-user-shield me-1"></i>Admin Login
          </a>
        </div>
      </div>
    </div>
  </section><!-- End: Sign Up -->
  <!-- Start: Footer -->
    @include('partials.home-footer')
  <!-- End: Footer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to input elements
        const usernameInput = document.getElementById('username'); 
        const emailInput = document.getElementById('emailadd'); 

        // Check if the elements exist before proceeding
        if (!usernameInput || !emailInput) {
            console.error("Username or email input elements were not found.");
            return;
        }

        // Function that controls the mutual exclusivity of username/email fields
        function toggleEmailDisabledState() {
            // Check if username field has any non-whitespace text
            const hasUsernameText = usernameInput.value.trim().length > 0;

            // If username has text, disable the email field and remove its required attribute
            emailInput.disabled = hasUsernameText;
            
            // Dynamically manage required attribute
            if (hasUsernameText) {
                emailInput.removeAttribute('required');
                emailInput.value = '';
                emailInput.classList.add('text-muted');
                emailInput.placeholder = 'Username selected - email disabled';
            } else {
                // Only require email if username is empty
                if (usernameInput.value.trim().length === 0) {
                    emailInput.setAttribute('required', '');
                }
                emailInput.classList.remove('text-muted');
                emailInput.placeholder = 'JohnDoe@gmail.com';
            }
        }

        function toggleUsernameDisabledState() {
            // Check if email field has any non-whitespace text
            const hasEmailText = emailInput.value.trim().length > 0;

            // If email has text, disable the username field and remove its required attribute
            usernameInput.disabled = hasEmailText;
            
            // Dynamically manage required attribute
            if (hasEmailText) {
                usernameInput.removeAttribute('required');
                usernameInput.value = '';
                usernameInput.classList.add('text-muted');
                usernameInput.placeholder = 'Email selected - username disabled';
            } else {
                // Only require username if email is empty
                if (emailInput.value.trim().length === 0) {
                    usernameInput.setAttribute('required', '');
                }
                usernameInput.classList.remove('text-muted');
                usernameInput.placeholder = 'Username';
            }
        }

        // Attach event listeners to both fields for mutual exclusivity
        usernameInput.addEventListener('input', toggleEmailDisabledState);
        emailInput.addEventListener('input', toggleUsernameDisabledState);

        // Set initial state - require at least one field
        usernameInput.setAttribute('required', '');
        emailInput.setAttribute('required', '');
        
        // Run the checks once on page load to set the initial state
        toggleEmailDisabledState();
        toggleUsernameDisabledState();

        // Form validation before submission
        const loginForm = document.querySelector('form');
        loginForm.addEventListener('submit', function(e) {
            const usernameValue = usernameInput.value.trim();
            const emailValue = emailInput.value.trim();
            const passwordValue = document.getElementById('password').value.trim();

            // Ensure at least one login method is provided
            if (!usernameValue && !emailValue) {
                e.preventDefault();
                alert('Please enter either a username or email address to login.');
                return false;
            }

            // Ensure password is provided
            if (!passwordValue) {
                e.preventDefault();
                alert('Please enter your password.');
                document.getElementById('password').focus();
                return false;
            }

            // Show loading state on login button
            const loginBtn = document.querySelector('button[type="submit"]');
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in...';
        });
    });
  </script>
</body>

</html>

