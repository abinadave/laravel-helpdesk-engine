<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PsgcController;
use App\Http\Controllers\FormBarangayController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\IndividualVaccinationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BlockedUserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\DynamicFormValueController;
use App\Http\Controllers\DynamicFormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

#Public Routes
Route::get('/public', function(){
    return "Successfully entered this api route now!";
});

Route::post('/register', [AuthController::class, 'register']);

#Authentication Route, via Email and password
Route::post('/login', [AuthController::class, 'login']);
#Authenticate via Username & Password
Route::post('/login/attempt', [AuthController::class, 'attemptLogin']);

#Psgc Routes, lib mun, brgy, provinces
Route::get('/psgc/provinces', [PsgcController::class, 'provinces']);
Route::post('/psgc/lgu', [PsgcController::class, 'lgus']);
Route::post('/psgc/brgy', [PsgcController::class, 'brgys']);

#User Registration
Route::post('/user/submit_registration_form', [UserController::class, 'insert']);
Route::post('/user/registration/check_email_duplicates', [UserController::class, 'checkemailDuplicate']);

#Sanctum Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::get('/users', [UserController::class, 'testApiRoute']);
   Route::post('/logout', [AuthController::class, 'logout']);
   #Test Authenticated Route for API TOKEN
   Route::post('/authenticated/test_token', [AuthController::class, 'testApiToken']);
   Route::post('/psgc/get_psgc_of_user', [PsgcController::class, 'getUserPsgcViews']);
   Route::post('/form_barangay/form1_submit', [FormBarangayController::class, 'submitForm1']);
   Route::get('/vaccine/get_all_vaccine_brands', [VaccineController::class, 'getAllVaccineBrands']);
   Route::post('/individual_vaccination/insert', [IndividualVaccinationController::class, 'insert']);
   Route::post('/individual_vaccination/fetch_per_brgy', [IndividualVaccinationController::class, 'fetchByProvCityMunBrgy']);
   Route::post('/form_barangay/fetch_monthly_barangay_inventory_of_vaccinated_population', [FormBarangayController::class, 'fetchByLocation']);
   
   #UserManagement APIs
   Route::get('/user/paginate', [UserController::class, 'fetchPaginate']);
   Route::put('/user/confirm', [UserController::class, 'confirmAccount']);
   Route::put('/user/update', [UserController::class, 'updateUser']);
   Route::put('/user/block_user', [BlockedUserController::class, 'blockUserByUserId']);
   Route::put('/user/unblock_user', [BlockedUserController::class, 'unblockUserById']);

   #Roles
   Route::post('/user/roles/fetch_user_roles_by_user_id', [RoleController::class, 'fetchAddedRolesByUserId']);
   Route::get('/user/role/fetch_all_roles', [RoleController::class, 'fetchAllRoles']);
   Route::post('/user/roles/fetch_roles_of_a_user', [RoleController::class, 'fetchRolesOfSpecificUserById']);
   
   #Add Role
   Route::post('/user/role/add_role_to_user', [RoleController::class, 'addRoleToUser']);
   
   #forms
   Route::get('/forms/get_form_by_form_id/{id}', [FormController::class, 'fetchFormById']);

   #dynamic form values
   Route::post('/dynamic/form/values/insert',[DynamicFormValueController::class, 'insert']);
   Route::get('/dynamic/form/fetch_by_prov_citymun_brgy', [DynamicFormController::class, 'fetchByProvCityMunBrgy']);
   Route::post('/dynamic/form/values/fetch_dynamic_form_values_by_form_ids', [DynamicFormValueController::class, 'fetchByDynamicFormsId']);

   #Dynamic form
   Route::post('/dynamic_form/insert', [DynamicFormController::class, 'insertDynamicForm']);
   Route::post('/dynamic_form/validate', [DynamicFormController::class, 'validateBeforeInsert']);
});





