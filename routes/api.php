<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ForgotPasswordController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\admin\ProfileController as AdminProfileController;
use App\Http\Controllers\manager\ProfileController as ManagerProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum','role:user']], function(){
    Route::get('/profile',[ProfileController::class, 'index'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/products', [productController::class, 'index']);
    Route::get('/productsPage', [productController::class, 'home']);
    Route::post('/products', [productController::class, 'store']);
    Route::get('/products/{id}', [productController::class, 'show']);
    Route::put('/products/update/{id}', [productController::class, 'update']);
    Route::delete('/products/delete/{id}', [productController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function(){
   Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
   Route::post('/admin/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:manager']], function(){
   Route::get('/manager/profile', [ManagerProfileController::class, 'index'])->name('manager.profile');
   Route::post('/manager/logout', [AuthController::class, 'logout']);
});

Route::apiResource('users', UserController::class);




Route::get('/products', [productController::class, 'index']);
Route::post('/products', [productController::class, 'store']);
Route::get('/products/{id}', [productController::class, 'show']);
Route::put('/products/update/{id}', [productController::class, 'update']);
Route::delete('/products/delete/{id}', [productController::class, 'destroy']);




Route::middleware(['auth:sanctum'])->group(function(){
    Route::delete('/delete/{id}', [clientController::class, 'destroy']);
    Route::post('/ClientChangePassword', [clientController::class, 'change_password']);
    Route::post('/ClientResetPassword', [clientController::class, 'reset']);
    Route::post('/clientLogout', [clientController::class, 'logout']);
    Route::get('/send-Verify-Email/{email}', [clientController::class, 'sendVerifyMail']);
   
});



Route::post('/ClientSignup', [clientController::class, 'signup']);
Route::post('/ClientLogin', [clientController::class, 'login']);
Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);






