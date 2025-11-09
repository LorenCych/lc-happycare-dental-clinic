<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Manage Account - LC Happy Care Dental Clinic</title>
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
  
  <!-- Start: Sign Up -->
  <section class="bg-body">
    <div class="container d-flex justify-content-center align-items-center py-5">
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
        <h1 class="text-dark mb-3">Manage Account</h1>
        <p class="w-75 mb-md-5 mx-auto">Changes performed on corresponding fields will reflect after saving changes.
          Unchanged fields will retain their previous information.</p>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">
             <form action="{{ route('registrant.account.update') }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                for="username">Username</label>
                <input class="border border-dark-subtle mb-4 form-control" type="text"
                id="username" placeholder="Username" required="" name="set_username" value="{{ $user->username }}">
                
                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="emailadd">E-mail
                Address</label>
                <input class="border border-dark-subtle mb-4 form-control" type="text" id="emailadd"
                placeholder="JohnDoe@gmail.com" inputmode="email" name="set_email" required="" value="{{ $user->email }}">
                
                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="password">Set
                Password</label>
                <input class="border border-dark-subtle mb-4 form-control" type="password" id="password"
                placeholder="Confirm password" required="" name="set_password" minlength="12" maxlength="18">

                <label
                class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start"
                for="passwordconfirm">Confirm Password</label>
                <input class="border border-dark-subtle mb-4 form-control"
                type="password" id="passwordconfirm" placeholder="12-18 password length" name="set_password_confirmation" required="" minlength="12"
                maxlength="18">
              <hr>
              <div class="row mb-3 align-items-end"> 
    
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
        <button class="mb-1 btn btn-primary w-100 mt-3 mt-sm-4 mt-lg-2 mt-xl-0 mt-xxl-1" type="submit" id="saveChangesBtn">Save Changes</button>
    </div>
    
</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End: Sign Up -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sendCodeBtn = document.getElementById('sendCodeBtn');
        const sendCodeText = document.getElementById('sendCodeText');
        const sendCodeSpinner = document.getElementById('sendCodeSpinner');
        const codeStatus = document.getElementById('codeStatus');
        const verificationCodeInput = document.getElementById('verificationcode');
        const saveChangesBtn = document.getElementById('saveChangesBtn');
        
        let codeCountdown = 0;
        let countdownInterval = null;
        
        sendCodeBtn.addEventListener('click', function() {
            if (codeCountdown > 0) return; // Prevent spam clicks
            
            // Show loading state
            sendCodeBtn.disabled = true;
            sendCodeText.classList.add('d-none');
            sendCodeSpinner.classList.remove('d-none');
            codeStatus.textContent = 'Sending verification code...';
            codeStatus.className = 'form-text text-info';
            
            // Make AJAX request
            fetch('{{ route("registrant.account.send-verification-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: '{{ $user->id }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    codeStatus.textContent = 'Verification code sent to your email! Check your inbox and spam folder.';
                    codeStatus.className = 'form-text text-success';
                    
                    // Start countdown (60 seconds)
                    codeCountdown = 60;
                    updateCountdown();
                    countdownInterval = setInterval(updateCountdown, 1000);
                    
                    // Focus on input field
                    verificationCodeInput.focus();
                } else {
                    codeStatus.textContent = data.error || 'Failed to send verification code. Please try again.';
                    codeStatus.className = 'form-text text-danger';
                    resetSendButton();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                codeStatus.textContent = 'Network error. Please check your connection and try again.';
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
        
        // Validate verification code input (only numbers, max 6 digits)
        verificationCodeInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 6);
        });
        
        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const verificationCode = verificationCodeInput.value.trim();
            
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
            saveChangesBtn.disabled = true;
            saveChangesBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating Account...';
        });
    });
  </script>
</body>

</html>