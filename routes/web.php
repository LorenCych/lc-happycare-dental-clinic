<?php

use App\Http\Controllers\Registrant\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registrant\RegistrantController;
use App\Http\Controllers\Registrant\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dentist\AppointmentController as DentistAppointmentController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirect /home to root for consistency
Route::redirect('/home', '/');

Route::get('/aboutus', function () {
    return view('home.aboutus');
})->name('home.about');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/services', function () {
    return view('home.services');
})->name('home.services');

// ✅ Add the named 'login' route that Laravel expects
Route::get('/login-user', function () {
    return view('home.login');
})->name('login');

Route::get('/signup', function () {
    return view('home.signup');
})->name('registrant.signup');

Route::get('/process', function () {
    return view('home.process');
})->name('home.process');

// Contact form route
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// ✅ Account creation route (public - no auth needed)
Route::post('/registrant/account/create', [AccountController::class, 'create'])->name('registrant.account.create');
Route::post('/signup/send-verification-code', [AccountController::class, 'sendSignupVerificationCode'])->name('signup.send-verification-code');
Route::get('/signup/test', function() {
    return response()->json(['message' => 'Signup routes are working', 'timestamp' => now()]);
})->name('signup.test');

// Login route
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

//Route::get('/registrant/dashboard', [RegistrantController::class, 'index'])->name('registrant.dashboard');

// Minimal dashboard route for static view test
Route::get('/test-dashboard', function () {
    return view('registrant.dashboard');
});

// Protected routes (authentication required)
// Registrant routes are now public
Route::prefix('registrant')->name('registrant.')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Registrant\AccountController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [\App\Http\Controllers\Registrant\RegistrantController::class, 'index'])->name('dashboard');
    Route::get('/help', [\App\Http\Controllers\Registrant\RegistrantController::class, 'help'])->name('help');

    // Account management routes
    Route::get('/account/manage', [\App\Http\Controllers\Registrant\AccountController::class, 'manage'])->name('account.manage');
    Route::get('/account/update-info', [\App\Http\Controllers\Registrant\AccountController::class, 'updateInfo'])->name('account.update-info');

    // POST route for updating profile info
    Route::post('/account/update', [\App\Http\Controllers\Registrant\AccountController::class, 'update'])->name('account.update');
    Route::post('/account/send-verification-code', [\App\Http\Controllers\Registrant\AccountController::class, 'sendVerificationCode'])->name('account.send-verification-code');
    Route::post('/account/save-appointee-info', [\App\Http\Controllers\Registrant\AccountController::class, 'saveAppointeeInfo'])->name('account.save-appointee-info');
    // Appointment routes
    Route::get('/appointments/upcoming', [\App\Http\Controllers\Registrant\AppointmentController::class, 'viewUpcomingAppointments'])->name('appointments.upcoming');
    Route::get('/appointments/history', [\App\Http\Controllers\Registrant\AppointmentController::class, 'viewAppointmentHistory'])->name('appointments.history');
    Route::get('/appointments/book', [\App\Http\Controllers\Registrant\AppointmentController::class, 'bookAppointment'])->name('appointments.book');
    Route::post('/appointments/create', [\App\Http\Controllers\Registrant\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/{appointment}/withdraw', [\App\Http\Controllers\Registrant\AppointmentController::class, 'withdraw'])->name('appointments.withdraw');
    Route::post('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Registrant\AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    Route::get('/appointments/{appointmentId}/print-receipt', [\App\Http\Controllers\Registrant\AppointmentController::class, 'printReceipt'])->name('appointments.print-receipt');
});


Route::get('/dentist/dashboard', [App\Http\Controllers\Dentist\AccountController::class, 'dashboard'])->name('dentist.dashboard');

// Temporary simple dashboard test
Route::get('/dentist/dashboard-test', function () {
    $adminId = session('admin_id');
    if (!$adminId) {
        return "No admin session found. Session contents: " . json_encode(session()->all());
    }
    
    $admin = App\Models\Admin::find($adminId);
    if (!$admin) {
        return "Admin not found in database with ID: " . $adminId;
    }
    
    return "Dashboard would load for admin: " . $admin->username . " (ID: " . $admin->id . ")";
})->name('dentist.dashboard.test');
Route::get('/admin/login', [App\Http\Controllers\Dentist\AccountController::class, 'showLoginForm'])->name('home.admin-login');
Route::get('/dentist/appointments/assigned', [DentistAppointmentController::class, 'viewAssignedAppointments'])->name('dentist.appointments.assigned');
Route::get('/dentist/appointments/unassigned', [DentistAppointmentController::class, 'viewUnassignedAppointments'])->name('dentist.appointments.unassigned');
Route::get('/dentist/appointments/previous', [DentistAppointmentController::class, 'viewPreviousAppointments'])->name('dentist.appointments.previous');
Route::post('/admin/login', [App\Http\Controllers\Dentist\AccountController::class, 'login'])->name('dentist.login');
Route::post('/dentist/appointments/{appointment}/claim', [DentistAppointmentController::class, 'claimAppointment'])->name('dentist.appointments.claim');
Route::post('/dentist/appointments/{appointment}/unassign', [DentistAppointmentController::class, 'unassignAppointment'])->name('dentist.appointments.unassign');
Route::post('/dentist/logout', [App\Http\Controllers\Dentist\AccountController::class, 'logout'])->name('dentist.logout');
Route::post('/dentist/appointments/{appointmentId}/reschedule/{newDateTime}', [DentistAppointmentController::class, 'rescheduleAppointment'])->name('dentist.appointments.reschedule');
Route::post('/dentist/appointments/{appointment}/completed', [DentistAppointmentController::class, 'markAsCompleted'])->name('dentist.appointments.completed');
Route::post('/dentist/appointments/{appointment}/expired', [DentistAppointmentController::class, 'markAsExpired'])->name('dentist.appointments.expired');
Route::post('/dentist/appointments/{appointment}/reject', [DentistAppointmentController::class, 'rejectAppointment'])->name('dentist.appointments.reject');

//Patient Record View
Route::get('/dentist/patient/{userId}/view-record', [DentistAppointmentController::class, 'viewPatientRecord'])->name('dentist.patient.view-record');

//Admin Creation Routes
Route::get('/dentist/account/create', [App\Http\Controllers\Dentist\AdminController::class, 'create'])->name('dentist.admin.create');
Route::post('/dentist/account/create', [App\Http\Controllers\Dentist\AdminController::class, 'store'])->name('dentist.admin.store');

//Admin Account Management
Route::get('/dentist/account/manage', [App\Http\Controllers\Dentist\AdminController::class, 'manage'])->name('dentist.account.manage');
Route::post('/dentist/account/update', [App\Http\Controllers\Dentist\AdminController::class, 'update'])->name('dentist.account.update');

//Password Reset Routes - Dentist
Route::get('/dentist/forgot-password', [App\Http\Controllers\Dentist\PasswordResetController::class, 'showForgotForm'])->name('dentist.password.request');
Route::post('/dentist/forgot-password', [App\Http\Controllers\Dentist\PasswordResetController::class, 'sendResetLink'])->name('dentist.password.email');
Route::get('/dentist/reset-password', [App\Http\Controllers\Dentist\PasswordResetController::class, 'showResetForm'])->name('dentist.password.reset');
Route::post('/dentist/reset-password', [App\Http\Controllers\Dentist\PasswordResetController::class, 'resetPassword'])->name('dentist.password.update');

//Password Reset Routes - Registrant/Patient
Route::get('/forgot-password', [App\Http\Controllers\Registrant\PasswordResetController::class, 'showForgotForm'])->name('registrant.password.request');
Route::post('/forgot-password', [App\Http\Controllers\Registrant\PasswordResetController::class, 'sendResetLink'])->name('registrant.password.email');
Route::get('/reset-password', [App\Http\Controllers\Registrant\PasswordResetController::class, 'showResetForm'])->name('registrant.password.reset');
Route::post('/reset-password', [App\Http\Controllers\Registrant\PasswordResetController::class, 'resetPassword'])->name('registrant.password.update');

// Add this to routes/web.php
Route::get('/test-session-write', function () {
    try {
        $sessionId = Str::random(40);

        // Try direct insert into sessions table
        DB::table('sessions')->insert([
            'id' => $sessionId,
            'user_id' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent() ?? 'Test Agent',
            'payload' => 'test payload',
            'last_activity' => time()
        ]);

        // Try to retrieve what we just inserted
        $session = DB::table('sessions')->where('id', $sessionId)->first();

        return [
            'status' => 'Session write successful!',
            'inserted' => $session ? true : false,
            'session_data' => $session
        ];
    } catch (\Exception $e) {
        Log::error('Session write failed: ' . $e->getMessage());

        return [
            'status' => 'Session write failed!',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});

//debug route
Route::get('/debug-auth', function () {
    return [
        'is_authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'session_id' => session()->getId(),
        'session_contents' => session()->all()
    ];
});

//debug admin session
Route::get('/debug-admin-session', function () {
    return [
        'admin_id' => session('admin_id'),
        'admin_username' => session('admin_username'),
        'admin_email' => session('admin_email'),
        'session_id' => session()->getId(),
        'session_all' => session()->all(),
        'session_driver' => config('session.driver'),
        'admin_exists' => session('admin_id') ? App\Models\Admin::find(session('admin_id')) : null
    ];
});

// Test admin login simple
Route::get('/test-admin-login', function () {
    // Simulate a successful login
    session([
        'admin_id' => 'test-admin-id',
        'admin_username' => 'test-admin',
        'test_time' => now()
    ]);
    
    return [
        'message' => 'Test session set',
        'session_data' => session()->all()
    ];
});

Route::get('/test-admin-check', function () {
    return [
        'admin_id' => session('admin_id'),
        'session_all' => session()->all(),
        'can_access_dashboard' => session('admin_id') ? 'YES' : 'NO'
    ];
});

Route::get(
    '/test-db-config',
    function () {
        return [
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_HOST' => env('DB_HOST'),
            'DB_PORT' => env('DB_PORT'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
            'DB_PASSWORD' => env('DB_PASSWORD') ? 'SET' : 'NOT SET',
            'config_host' => config('database.connections.pgsql.host'),
            'config_database' => config('database.connections.pgsql.database'),
            'config_username' => config('database.connections.pgsql.username'),
        ];
    }
);

Route::get('/test-db-write', function () {
    try {
        // Test if we can write to database
        DB::table('users')->insert([
            'username' => 'test_' . time(),
            'email' => 'test_' . time() . '@test.com',
            'password' => bcrypt('testpassword'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'birthday' => '1990-01-01',
            'age' => 33,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return 'Database write successful!';
    } catch (\Exception $e) {
        return 'Database write failed: ' . $e->getMessage();
    }
});
