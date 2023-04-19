<?php

use App\PractitionerQualification;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/practitioners/{practitioner}', 'Api\PractitionersController@show');

//dashboard
Route::get('/renewals/{practitioner}', 'Api\PaymentsController@renewals');//get all practitioner renewals
Route::get('/renewals/initiate_step_1/{practitioner}', 'Api\PaymentsController@initiate_step_1');//renewal criteria
Route::post('/renewals/step_1/{practitioner}', 'Api\PaymentsController@step_1');//get bill
Route::post('/renewals/step_3', 'Api\PaymentsController@step_3');//make payment
Route::post('/renewals/step_4', 'Api\PaymentsController@step_4');//submit cpd points
Route::post('/renewals/make_balance_payment', 'Api\PaymentsController@make_balance_payment');//submit cpd points
Route::get('/renewals/payments/{renewal}', 'Api\PaymentsController@renewal_payments');//submit cpd points

//applications and payments
Route::get('/applications/payment_item_categories', 'Api\ApplicationsController@payment_item_categories');//get all payment
Route::get('/applications/payment_items/{paymentItemCategory}', 'Api\ApplicationsController@payment_items');//get
Route::get('/applications/payment_item/{paymentItem}', 'Api\ApplicationsController@payment_item');//get
//make payment
Route::post('/applications/make_application_payment/', 'Api\ApplicationsController@make_application_payment');//get
Route::post('/applications/submit_documents/', 'Api\ApplicationsController@submit_documents');//get



//Website Registrations
//get all professions for front display
Route::get('/registrations/professions/', 'Api\RegistrationsController@professions');//get
Route::get('/registrations/requirements/', 'Api\RegistrationsController@requirements');//get
//professional qualification
Route::get('/admin/get_pq/{profession_id}', 'DynamicDataController@professionalQualifications');
Route::get('/admin/get_ai/{professional_qualification_id}', 'DynamicDataController@accreditedInstitutions');

//start registration process
Route::get('/registrations/application/', 'Api\RegistrationsController@application');//get
Route::post('/registrations/step_1', 'Api\RegistrationsController@step_1');//get
Route::post('/registrations/step_2', 'Api\RegistrationsController@step_2');//get
Route::post('/registrations/step_4', 'Api\RegistrationsController@step_4');//get
Route::get('/registrations/my_application/{practitioner}', 'Api\RegistrationsController@my_application');//get
Route::post('/registrations/find_my_application/', 'Api\RegistrationsController@find_my_application');//get
Route::get('/registrations/my_application/payment', 'Api\RegistrationsController@step_4');//get
Route::post('/registrations/registration_fee', 'Api\RegistrationsController@registration_fee');//get

//search
Route::post('/search', 'Api\SearchController@search');//get



//Custom APIs
//this route loads all the data required to get practitioner started
Route::get('/get_professions', 'PortalApiController@get_professions');
Route::post('/verify_ahpcz_account', 'PortalApiController@verify_ahpcz_account');
Route::post('/correct_data', 'PortalApiController@correct_data');
Route::get('/update_tracker/{practitioner}', 'PortalApiController@update_tracker');
Route::get('/update_information/create', 'PortalApiController@update_information_create');
Route::post('/update_information/store', 'PortalApiController@update_information_store');
Route::get('/renewal_criteria/{renewal_category_id}/{employment_status_id}/{employment_location_id}/{certificate_request}', 'PortalApiController@renewal_criteria');
Route::get('/create_renewal', 'PortalApiController@create_renewal');

Route::post('/make_payment', 'PortalApiController@make_payment');
Route::post('/make_online_payment', 'PortalApiController@make_online_payment');

Route::post('/make_restoration_payment', 'PortalApiController@make_restoration_payment');
Route::post('/make_online_restoration_payment', 'PortalApiController@make_online_restoration_payment');

//clear balance
Route::get('/renewal_payments/{renewal}/clear_balance', 'PortalApiController@clear_balance');
Route::post('/renewal_payments/{renewal}/clear_balance_payment', 'PortalApiController@clear_balance_payment');



Route::post('/testfile', 'PortalApiController@testfile');


Route::get('/get_qualification_data/{practitioner}', 'PortalApiController@get_qualification_data');
Route::get('/get_qualification/{id}', 'PortalApiController@get_qualification');
Route::post('/add_practitioner_qualification/{practitioner}', 'PortalApiController@add_practitioner_qualification');
Route::post('/edit_practitioner_qualification/{practitionerQualification}', 'PortalApiController@edit_practitioner_qualification');

Route::get('/verify_certificate/{practitioner}', 'PortalApiController@verify_certificate');







Route::post('/post_test', 'PortalApiController@post_test');

Route::get('/json/practitioners/{practitioner}', 'APIController@show');
Route::get('/profession_prefix/{prefix}', 'PortalApiController@profession_prefixes');
Route::get('/practitioner_create', 'APIController@create');

//1. get all practitioners API
Route::get('/json/practitioners', 'APIController@index');
//get one practitioner by practitioner->id and renewal status
Route::get('/json/practitioners/{practitioner}', 'APIController@show');
//get practitioner by registration_number and Id_number
Route::get('/json/practitioners/{registration_number}/{id_number}', 'APIController@byRegID');

//get practitioner by registration_number string and Id_number
Route::get('/json/practitioner_string/{registration_number}/{id_number}', 'APIController@byRegIdString');

Route::get('/json/testing/{registration_number}/{id_number}', 'APIController@test');

Route::get('/json/test', 'APIController@test');


Route::get('/practitioner/{reg_number}', 'PortalRegistrationController@test');
