
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes (no role-based access)
Route::group(['middleware' => ['delete']], function () {
    Route::get('/', function () {
        return view('admin.login');
    });
});

// public routes
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('/send-email', [LoginController::class, 'SendEmail'])->name('admin.SendEmail');
Route::get('forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('forgot-password', [LoginController::class, 'sendResetLink'])->name('forgot.password.post');
Route::post('verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');
Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('reset.password');

// Routes accessible by admin and super_admin
Route::group(['middleware' => ['admin:admin|super admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [LoginController::class, 'AdminDashboard'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});

// Routes only accessible by super_admin
Route::group(['middleware' => ['admin:super admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/user-create', [UserController::class, 'UserCreate'])->name('user.create');
        Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user-list', [UserController::class, 'list'])->name('user.list');
        Route::get('/update-status', [UserController::class, 'updateStatus'])->name('update.status');
    });
});




