<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Create Admin Account - LC Happy Care Dental Clinic</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
</head>

<body>
    <section class="d-flex">
        @include('partials.dentist-sidebar')
        <div class="bg-body flex-grow-1 p-3" id="main-content">
            <section class="mt-4">
                <div class="container">
                    <div class="row" style="height: 240px;">
                        <div class="col-12 ms-0">
                            <h2 class="mb-0">Admin Account Creation</h2>
                            <hr class="mt-2 mb-2">
                            <p class="text-black-50">Create admin accounts and assign role level to give them permissions on specialized actions.</p>
                            
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="text-center text-white d-xxl-flex justify-content-xxl-center align-items-xxl-center" style="background: linear-gradient(-160deg, #daa400 31%, var(--bs-warning) 91%), var(--bs-dark);">
                                    <h6 class="my-2">ACCOUNT CREATION FORM</h6>
                                </div>
                                <div class="card-body">
                                    <div class="col-xl-12">
                                        <form action="{{ route('dentist.admin.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-sm-6"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="username">Username</label><input class="border border-dark-subtle mb-4 form-control" type="text" id="username" name="username" placeholder="Username" required></div>
                                                <div class="col-12 col-sm-6"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="email">E-mail</label><input class="border border-dark-subtle mb-4 form-control" type="email" id="email" name="email" placeholder="JohnDoe@gmail.com" required></div>
                                                <div class="col-12"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="adminrolelvl">Role Level</label><select class="border-dark-subtle form-select mb-4" id="adminrolelvl" name="role_level" required>
                                                        <option value="1">Role 1: Admin Level</option>
                                                        <option value="2">Role 2: Dentist Level</option>
                                                        <option value="3">Role 3: Assistant Level</option>
                                                    </select></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="password">Set Password</label><input class="border border-dark-subtle mb-4 form-control" type="password" id="password" name="password" placeholder="12-18 password length" required minlength="12" maxlength="18"></div>
                                                <div class="col-12 col-md-6"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="passwordconfirm">Confirm Password</label><input class="border border-dark-subtle mb-4 form-control" type="password" id="passwordconfirm" name="password_confirmation" placeholder="Confirm password" required minlength="12" maxlength="18"></div>
                                            </div>
                                            <hr>
                                            <p class="text-start text-black-50 mb-md-4 mb-lg-4 mb-xl-4 mb-xxl-3">Please double-check your personal details before submitting to avoid any processing delays. You’ll still be able to edit them later if needed.</p>
                                            <div class="row mb-3">
                                                <div class="col-12 col-sm-12 col-lg-4 col-xl-4"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="firstname">First name</label><input class="border border-dark-subtle mb-2 form-control" type="text" id="firstname" name="first_name" placeholder="" required></div>
                                                <div class="col-12 col-sm-6 col-lg-4 col-xl-4"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="middlename">Middle name</label><input class="border border-dark-subtle mb-2 form-control" type="text" id="middlename" name="middle_name" placeholder=""></div>
                                                <div class="col-12 col-sm-6 col-lg-4 col-xl-4"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="lastname">Last name</label><input class="border border-dark-subtle mb-2 form-control" type="text" id="lastname" name="last_name" placeholder="" required></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><label class="form-label d-flex d-sm-flex justify-content-start justify-content-sm-start" for="contact">Contact Number</label><input class="border-dark-subtle form-control mb-4" type="text" id="contact" name="contact_number" required></div>
                                                <div class="col d-flex flex-column-reverse justify-content-start mt-0"><button class="btn btn-primary w-100 mt-3 mt-sm-4 mt-lg-2 mt-xl-0 mt-xxl-1" type="submit">Create Admin Account</button></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.min.js"></script>
</body>

</html>