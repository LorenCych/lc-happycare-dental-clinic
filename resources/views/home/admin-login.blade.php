<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Admin Login - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  
  <style>
    .hr-or {
        display: flex;
        align-items: center;
        text-align: center;
    }

    .hr-or::before,
    .hr-or::after {
        content: '';
        flex-grow: 1;
        height: 1px;
        background-color: #dee2e6;
        margin: 0 10px;
    }

    .hr-or span {
        color: #6c757d;
        padding: 0 10px;
        font-size: 0.9em;
        font-weight: 500;
    }
  </style>
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


  <!-- Start: Sign Up -->
    <section class="bg-body">
        <div class="container d-flex justify-content-center align-items-center py-5">
            <div class="text-center bg-white border rounded-3 border-primary ps-4 pe-4 pt-3 pt-sm-3 pt-md-3 pt-lg-3 pt-xl-3 pt-xxl-3 pb-4 pb-md-5">
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        <div class="bs-icon-xl bs-icon-circle my-4 bs-icon" style="background: #23272a;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person-bounding-box">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"></path>
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"></path>
                            </svg></div>
                    </div>
                </div>
                <h1 class="text-dark mb-3">Admin Login</h1>
                <p class="w-75 mb-md-5 mx-auto">Please enter your username or email address and password to access the admin dashboard.</p>
                <div class="justify-content-center row">
                    <div class="col-lg-7 col-xl-8 col-md-8 col-sm-9">
                        <form action="{{ route('dentist.login') }}" method="POST">
                            @csrf
                            <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="username">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input class="border border-dark-subtle mb-4 form-control @error('username') is-invalid @enderror" 
                                   type="text" name="username" id="username" placeholder="Enter admin username" 
                                   value="{{ old('username') }}" minlength="3">
                            @error('username')
                            <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                            @enderror

                            <div class="hr-or mb-4">
                                <span>OR</span>
                            </div>

                            <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="emailadd">
                                E-mail Address <span class="text-danger">*</span>
                            </label>
                            <input class="border border-dark-subtle mb-4 form-control @error('email') is-invalid @enderror" 
                                   type="email" name="email" id="emailadd" placeholder="admin@example.com" 
                                   inputmode="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                            @enderror
                            
                            <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="password">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input class="border border-dark-subtle mb-4 form-control @error('password') is-invalid @enderror" 
                                   type="password" name="password" id="password" placeholder="Enter password" 
                                   required minlength="8" maxlength="18">
                            @error('password')
                            <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                            @enderror
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary w-100 mt-3" type="submit" id="loginBtn">
                                        <i class="fas fa-sign-in-alt me-2"></i>Admin Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-black-50 w-75 mb-2 mx-auto">To create your admin account, please coordinate with a registered admin-dentist. Only existing admin-dentists can initiate account creation from their dashboard.</p>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('dentist.password.request') }}">
                        <i class="fas fa-key me-1"></i>Forgot Password?
                    </a>
                    <a class="small" href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-1"></i>Back to Login
                    </a>
                </div>
            </div>         
        </div>
    </section>
  <!-- Start: Footer -->
    @include('partials.home-footer')
  <!-- End: Footer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to form elements
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('emailadd');
        const passwordInput = document.getElementById('password');
        const loginForm = document.querySelector('form');
        const loginBtn = document.querySelector('button[type="submit"]');

        // Check if elements exist
        if (!usernameInput || !emailInput || !passwordInput || !loginForm || !loginBtn) {
            console.error("Required form elements not found.");
            return;
        }

        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Function that controls the mutual exclusivity of username/email fields
        function toggleEmailDisabledState() {
            const hasUsernameText = usernameInput.value.trim().length > 0;

            emailInput.disabled = hasUsernameText;
            
            if (hasUsernameText) {
                emailInput.value = '';
                emailInput.classList.add('text-muted');
                emailInput.placeholder = 'Username selected - email disabled';
                emailInput.classList.remove('is-valid', 'is-invalid');
            } else {
                emailInput.classList.remove('text-muted');
                emailInput.placeholder = 'admin@example.com';
            }
        }

        function toggleUsernameDisabledState() {
            const hasEmailText = emailInput.value.trim().length > 0;

            usernameInput.disabled = hasEmailText;
            
            if (hasEmailText) {
                usernameInput.value = '';
                usernameInput.classList.add('text-muted');
                usernameInput.placeholder = 'Email selected - username disabled';
                usernameInput.classList.remove('is-valid', 'is-invalid');
            } else {
                usernameInput.classList.remove('text-muted');
                usernameInput.placeholder = 'Enter admin username';
            }
        }

        // Real-time input validation with visual feedback
        function validateUsername() {
            if (usernameInput.disabled) return true;
            
            const usernameValue = usernameInput.value.trim();
            
            if (usernameValue.length === 0) {
                usernameInput.classList.remove('is-valid', 'is-invalid');
                return false;
            } else if (usernameValue.length < 3) {
                usernameInput.classList.remove('is-valid');
                usernameInput.classList.add('is-invalid');
                return false;
            } else {
                usernameInput.classList.remove('is-invalid');
                usernameInput.classList.add('is-valid');
                return true;
            }
        }

        function validateEmail() {
            if (emailInput.disabled) return true;
            
            const emailValue = emailInput.value.trim();
            
            if (emailValue.length === 0) {
                emailInput.classList.remove('is-valid', 'is-invalid');
                return false;
            } else if (!isValidEmail(emailValue)) {
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
                return false;
            } else {
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                return true;
            }
        }

        function validatePassword() {
            const passwordValue = passwordInput.value.trim();
            
            if (passwordValue.length === 0) {
                passwordInput.classList.remove('is-valid', 'is-invalid');
                return false;
            } else if (passwordValue.length < 8) {
                passwordInput.classList.remove('is-valid');
                passwordInput.classList.add('is-invalid');
                return false;
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                return true;
            }
        }

        // Add event listeners for mutual exclusivity
        usernameInput.addEventListener('input', function() {
            toggleEmailDisabledState();
            validateUsername();
        });
        
        emailInput.addEventListener('input', function() {
            toggleUsernameDisabledState();
            validateEmail();
        });

        // Add validation listeners
        usernameInput.addEventListener('blur', validateUsername);
        emailInput.addEventListener('blur', validateEmail);
        passwordInput.addEventListener('input', validatePassword);
        passwordInput.addEventListener('blur', validatePassword);

        // Form submission validation and loading state
        loginForm.addEventListener('submit', function(e) {
            const usernameValue = usernameInput.value.trim();
            const emailValue = emailInput.value.trim();
            const passwordValue = passwordInput.value.trim();

            // Clear previous validation states
            usernameInput.classList.remove('is-invalid');
            emailInput.classList.remove('is-invalid');
            passwordInput.classList.remove('is-invalid');

            let hasErrors = false;

            // Ensure at least one login method is provided
            if (!usernameValue && !emailValue) {
                e.preventDefault();
                if (!usernameInput.disabled) {
                    usernameInput.classList.add('is-invalid');
                    usernameInput.focus();
                } else if (!emailInput.disabled) {
                    emailInput.classList.add('is-invalid');
                    emailInput.focus();
                }
                hasErrors = true;
            }

            // Validate username if provided
            if (usernameValue && usernameValue.length < 3) {
                e.preventDefault();
                usernameInput.classList.add('is-invalid');
                if (!hasErrors) usernameInput.focus();
                hasErrors = true;
            }

            // Validate email if provided
            if (emailValue && !isValidEmail(emailValue)) {
                e.preventDefault();
                emailInput.classList.add('is-invalid');
                if (!hasErrors) emailInput.focus();
                hasErrors = true;
            }

            // Validate password
            if (!passwordValue) {
                e.preventDefault();
                passwordInput.classList.add('is-invalid');
                if (!hasErrors) passwordInput.focus();
                hasErrors = true;
            } else if (passwordValue.length < 8 || passwordValue.length > 18) {
                e.preventDefault();
                passwordInput.classList.add('is-invalid');
                if (!hasErrors) passwordInput.focus();
                hasErrors = true;
            }

            // Show error message if validation fails
            if (hasErrors) {
                let errorDiv = document.querySelector('.admin-login-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger admin-login-error mt-3';
                    loginForm.appendChild(errorDiv);
                }
                errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Please enter either username or email, and a valid password.';
                return false;
            }

            // Remove any existing error messages
            const existingError = document.querySelector('.admin-login-error');
            if (existingError) {
                existingError.remove();
            }

            // Show loading state on successful validation
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Authenticating...';
        });

        // Enhanced UX: Enter key navigation
        usernameInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (emailInput.disabled) {
                    passwordInput.focus();
                } else {
                    emailInput.focus();
                }
            }
        });

        emailInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                passwordInput.focus();
            }
        });

        passwordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                loginForm.submit();
            }
        });

        // Initialize mutual exclusivity on page load
        toggleEmailDisabledState();
        toggleUsernameDisabledState();

        // Auto-focus username field on page load
        usernameInput.focus();
    });
  </script>
</body>

</html>