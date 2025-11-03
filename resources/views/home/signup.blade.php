<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Sign Up - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body><!-- Start: Navbar Centered Links -->
@include('partials.home-navbar')
  
  <!-- Start: Sign Up -->
  <section class="bg-body">
    <div class="container d-flex justify-content-center align-items-center py-3">
      <div
        class="text-center bg-white border rounded-3 border-primary w-100 ps-4 pe-4 pt-3 pt-sm-3 pt-md-3 pt-lg-3 pt-xl-3 pt-xxl-3 pb-4 pb-md-5">
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
        <h1 class="text-dark mb-3">Sign Up</h1>
        <p class="w-75 mb-md-5 mx-auto">Please provide the following information to create your account.</p>
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">
             @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('registrant.account.create') }}" method="POST">
              @csrf
              <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                for="username">Username</label>
                <input class="border border-dark-subtle mb-4 form-control @error('username') is-invalid @enderror" type="text"
                id="username" name="username" placeholder="Username" value="{{ old('username') }}" required="">
                
                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="email">E-mail
                Address</label>
                <input class="border border-dark-subtle mb-4 form-control @error('email') is-invalid @enderror" type="text" id="email"
                name="email" placeholder="JohnDoe@gmail.com" inputmode="email" value="{{ old('email') }}" required="">
                
                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="password">Set
                Password</label>
                
                <input class="border border-dark-subtle mb-4 form-control" type="password" id="password"
                name="password" required="" minlength="12" maxlength="18">

              <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
              for="passwordconfirm">Confirm Password</label>
               <input class="border border-dark-subtle mb-4 form-control"
                type="password" id="passwordconfirm" name="password_confirmation" 
                placeholder="12-18 password length" required="" minlength="8" maxlength="18">

              <hr>

              <p class="text-start text-black-50 mb-md-4 mb-lg-4 mb-xl-4 mb-xxl-3">Please double-check your personal
                details before submitting to avoid any processing delays. You’ll still be able to edit them later if
                needed.</p>
              <div class="row mb-3">
                <div class="col-12 col-sm-12 col-lg-4 col-xl-4">     
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="firstname">First name</label>
                  <input class="border border-dark-subtle mb-2 form-control @error('first_name') is-invalid @enderror"
                    name="first_name" type="text" id="firstname" placeholder="" value="{{ old('first_name') }}" required="">
                  </div>
                <div class="col col-sm-12 col-lg-4 col-xl-4">
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="middlename">Middle name</label>
                    <input class="border border-dark-subtle mb-2 form-control @error('middle_name') is-invalid @enderror"
                    name="middle_name" type="text" id="middlename" placeholder="" value="{{ old('middle_name') }}"></div>
                <div class="col col-sm-12 col-lg-4 col-xl-4">
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="lastname">Last name</label>
                    <input class="border border-dark-subtle mb-2 form-control @error('last_name') is-invalid @enderror"
                    name="last_name" type="text" id="lastname" placeholder="" value="{{ old('last_name') }}" required=""></div>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="date">Birthdate</label>
                  <input class="border-dark-subtle form-control @error('birthday') is-invalid @enderror" id="date" type="date"
                    name="birthday" value="{{ old('birthday') }}" required=""></div>
                <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="gender">Gender</label>
                  <select class="border-dark-subtle form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required="">
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                  </select></div>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                  <label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="address">Address</label>
                    <input class="border-dark-subtle form-control @error('address') is-invalid @enderror" type="text" id="address"
                    name="address" value="{{ old('address') }}" required=""></div>
                <div class="col col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6"><label
                    class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                    for="contact">Contact Number</label><input class="border-dark-subtle form-control @error('contact_number') is-invalid @enderror" type="text"
                    id="contact" name="contact_number" value="{{ old('contact_number') }}" required=""></div>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-sm-12 col-lg-8 col-xl-8">
                  <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="verificationcode">
                    Verification code <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="border-dark-subtle form-control @error('verification_code') is-invalid @enderror" 
                           type="text" id="verificationcode" name="verification_code" 
                           inputmode="numeric" maxlength="6" placeholder="Enter 6-digit code" required>
                    <button class="btn btn-primary" type="button" id="sendCodeBtn">
                      <span id="sendCodeText">Send Code</span>
                      <span id="sendCodeSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                  </div>
                  @error('verification_code')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                  <div id="codeStatus" class="form-text"></div>
                </div>
                <div class="col col-sm-12 col-lg-4 col-xl-4 d-flex flex-column-reverse flex-sm-shrink-1 mt-md-1 pt-md-0">
                  <button type="submit" class="btn btn-primary w-100 mt-3 mt-sm-4 mt-lg-2 mt-xl-0 mt-xxl-1" id="signUpBtn">
                    Sign Up
                  </button>
                </div>
              </div><a class="mt-0" href="/login-user">Already have an account.</a>
            </form>
          </div>
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
        const sendCodeBtn = document.getElementById('sendCodeBtn');
        const sendCodeText = document.getElementById('sendCodeText');
        const sendCodeSpinner = document.getElementById('sendCodeSpinner');
        const codeStatus = document.getElementById('codeStatus');
        const verificationCodeInput = document.getElementById('verificationcode');
        const emailInput = document.getElementById('email');
        const signUpBtn = document.getElementById('signUpBtn');
        const signUpForm = document.querySelector('form');
        
        let codeCountdown = 0;
        let countdownInterval = null;
        
        sendCodeBtn.addEventListener('click', function() {
            if (codeCountdown > 0) return; // Prevent spam clicks
            
            // Validate email first
            const emailValue = emailInput.value.trim();
            if (!emailValue) {
                codeStatus.textContent = 'Please enter your email address first.';
                codeStatus.className = 'form-text text-danger';
                emailInput.focus();
                return;
            }
            
            if (!isValidEmail(emailValue)) {
                codeStatus.textContent = 'Please enter a valid email address.';
                codeStatus.className = 'form-text text-danger';
                emailInput.focus();
                return;
            }
            
            // Show loading state
            sendCodeBtn.disabled = true;
            sendCodeText.classList.add('d-none');
            sendCodeSpinner.classList.remove('d-none');
            codeStatus.textContent = 'Sending verification code...';
            codeStatus.className = 'form-text text-info';
            
            // Make AJAX request
            console.log('Sending verification code request to:', '{{ route("signup.send-verification-code") }}');
            console.log('Email:', emailValue);
            
            fetch('{{ str_replace('http://', 'https://', route("signup.send-verification-code")) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: emailValue
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    // Handle HTTP errors
                    return response.text().then(text => {
                        console.error('HTTP Error Response:', text);
                        throw new Error(`HTTP ${response.status}: ${text || response.statusText}`);
                    });
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                
                if (data.success) {
                    codeStatus.textContent = 'Welcome! Verification code sent to your email. Check your inbox and spam folder.';
                    codeStatus.className = 'form-text text-success';
                    
                    // Start countdown (60 seconds)
                    codeCountdown = 60;
                    updateCountdown();
                    countdownInterval = setInterval(updateCountdown, 1000);
                    
                    // Focus on verification code input
                    verificationCodeInput.focus();
                } else {
                    console.error('API Error:', data);
                    codeStatus.textContent = data.error || 'Failed to send verification code. Please try again.';
                    codeStatus.className = 'form-text text-danger';
                    resetSendButton();
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                
                // Provide more specific error messages
                let errorMessage = 'Failed to send verification code. ';
                
                if (error.message.includes('Failed to fetch')) {
                    errorMessage += 'Unable to connect to server. Please check your internet connection.';
                } else if (error.message.includes('NetworkError')) {
                    errorMessage += 'Network connection failed. Please try again.';
                } else if (error.message.includes('HTTP 404')) {
                    errorMessage += 'Service not found. Please contact support.';
                } else if (error.message.includes('HTTP 500')) {
                    errorMessage += 'Server error. Please try again in a moment.';
                } else if (error.message.includes('HTTP 422')) {
                    errorMessage += 'Invalid email format or missing information.';
                } else if (error.message.includes('HTTP 419')) {
                    errorMessage += 'Session expired. Please refresh the page and try again.';
                } else {
                    errorMessage += error.message || 'Please try again or contact support if the problem persists.';
                }
                
                codeStatus.textContent = errorMessage;
                codeStatus.className = 'form-text text-danger';
                resetSendButton();
            });
        });
        
        function updateCountdown() {
            if (codeCountdown <= 0) {
                clearInterval(countdownInterval);
                resetSendButton();
                codeStatus.textContent = 'You can request a new code now.';
                codeStatus.className = 'form-text text-muted';
                return;
            }
            
            sendCodeText.textContent = `Resend (${codeCountdown}s)`;
            codeCountdown--;
        }
        
        function resetSendButton() {
            sendCodeBtn.disabled = false;
            sendCodeText.classList.remove('d-none');
            sendCodeSpinner.classList.add('d-none');
            sendCodeText.textContent = 'Send Code';
        }
        
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Validate verification code input (only numbers, max 6 digits)
        verificationCodeInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 6);
        });
        
        // Real-time email validation
        emailInput.addEventListener('blur', function() {
            const emailValue = this.value.trim();
            if (emailValue && !isValidEmail(emailValue)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Form validation before submit
        signUpForm.addEventListener('submit', function(e) {
            const verificationCode = verificationCodeInput.value.trim();
            const emailValue = emailInput.value.trim();
            
            // Validate email
            if (!emailValue || !isValidEmail(emailValue)) {
                e.preventDefault();
                codeStatus.textContent = 'Please enter a valid email address.';
                codeStatus.className = 'form-text text-danger';
                emailInput.focus();
                return false;
            }
            
            // Validate verification code
            if (!verificationCode) {
                e.preventDefault();
                codeStatus.textContent = 'Please enter the verification code sent to your email.';
                codeStatus.className = 'form-text text-danger';
                verificationCodeInput.focus();
                return false;
            }
            
            if (verificationCode.length !== 6) {
                e.preventDefault();
                codeStatus.textContent = 'Verification code must be exactly 6 digits.';
                codeStatus.className = 'form-text text-danger';
                verificationCodeInput.focus();
                return false;
            }
            
            // Show loading state on submit
            signUpBtn.disabled = true;
            signUpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating Account...';
        });
        
        // Enable Send Code button only when email is filled
        emailInput.addEventListener('input', function() {
            const emailValue = this.value.trim();
            if (emailValue && isValidEmail(emailValue)) {
                sendCodeBtn.style.opacity = '1';
            } else {
                sendCodeBtn.style.opacity = '0.7';
            }
        });
        
        // Initial state - make Send Code button slightly transparent
        sendCodeBtn.style.opacity = '0.7';
    });
  </script>
</body>

</html>