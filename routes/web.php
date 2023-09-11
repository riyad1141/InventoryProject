<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// User api
Route::post("/UserRegistration",[UserController::class,'UserRegistration']);
Route::post("/UserLogin",[UserController::class,'UserLogin']);
Route::post("/SendOtpCode",[UserController::class,'SendOtpCode']);
Route::post("/VerifyOtp",[UserController::class,'VerifyOtp']);
Route::post("/PasswordReset",[UserController::class,'PasswordReset'])->middleware([TokenVerificationMiddleware::class]);


// User Page
Route::get("/LoginPage",[UserController::class,'LoginPage']);
Route::get("/RegistrationPage",[UserController::class,'RegistrationPage']);
Route::get("/SendOtpPage",[UserController::class,'SendOtpPage']);
Route::get("/VerifyOtpPage",[UserController::class,'VerifyOtpPage']);
Route::get("/ResetPasswordPage",[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);

// Dashboard Page
Route::get("/DashboardPage",[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/Summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/ProfilePage",[DashboardController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/Logout",[UserController::class,'Logout'])->middleware([TokenVerificationMiddleware::class]);
// User Profile
Route::get("/UserProfile",[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/UpdateProfile",[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);

// Category Api
Route::get("/CategoryPage",[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CategoryCreate",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CategoryUpdate",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CategoryDelete",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/CategoryList",[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CategoryByID",[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);

// Customer Api
Route::get("/CustomerPage",[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CustomerCreate",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CustomerUpdate",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CustomerDelete",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CustomerById",[CustomerController::class,'CustomerById'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/CustomerList",[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);

// Customer Api
Route::get("/ProductPage",[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/ProductList",[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/CreateProduct",[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/UpdateProduct",[ProductController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/ProductDelete",[ProductController::class,'ProductDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/ProductById",[ProductController::class,'ProductById'])->middleware([TokenVerificationMiddleware::class]);

// Invoice Api
Route::get("/SalePage",[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/InvoicePage",[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/InvoiceCreate",[InvoiceController::class,'InvoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/InvoiceDelete",[InvoiceController::class,'InvoiceDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/InvoiceSelect",[InvoiceController::class,'InvoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/InvoiceDetails",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);


// Report Page
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);
