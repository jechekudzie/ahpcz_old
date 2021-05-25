<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {

    return view('auth.login');

})->middleware('auth')->middleware('guest');

Route::get('/upload', function () {

    return view('upload');

});


Route::get('/admin/emails','PractitionerContactsController@contacts');


Route::get('/admin', 'AdminController@index');

/*Start Of Utilities CRUD*/
//professions
Route::resource('/admin/professions', 'ProfessionsController');

//qualification_categories
Route::resource('/admin/qualification_categories', 'QualificationCategoriesController');

//registers_categories
Route::resource('/admin/register_categories', 'RegisterCategoriesController');

//renewal_categories
Route::resource('/admin/renewal_categories', 'RenewalCategoriesController');

//renewal_statuses
Route::resource('/admin/renewal_statuses', 'RenewalStatusesController');

//employment status and employment location
Route::resource('/admin/employment_statuses', 'EmploymentStatusController');
Route::resource('/admin/employment_locations', 'EmploymentLocationController');


//operational_statuses
Route::resource('/admin/operational_statuses', 'OperationalStatusesController');

//nationalities
Route::resource('/admin/nationalities', 'NationalitiesController');

//provinces
Route::resource('/admin/provinces', 'ProvincesController');

//cities
Route::resource('/admin/cities', 'CitiesController');

//practitioner registration_fees
Route::resource('/admin/registration_fees', 'RegistrationFeesController');

//practitioner renewal fees
Route::resource('/admin/renewal_fees', 'RenewalFeesController');
Route::resource('/admin/tires', 'TireController');
Route::get('/admin/tires/{tire}/delete', 'TireController@destroy');
Route::resource('/admin/profession_tires', 'ProfessionTireController');
Route::resource('/admin/rates', 'RatesController');
Route::get('/admin/rates/{rate}/delete', 'RatesController@destroy');
Route::resource('/admin/profession_tires', 'ProfessionTireController@destroy');
Route::post('/admin/profession_tires/delete', 'ProfessionTireController@destroy');
Route::post('/admin/profession_tires', 'ProfessionTireController@store');
Route::resource('/admin/renewal_criterias', 'RenewalCriteriaController');

Route::get('/admin/cpd_criterias/index', 'CpdCriteriaController@index');
Route::get('/admin/cpd_criterias/{cpd_criteria}/edit', 'CpdCriteriaController@edit');
Route::get('/admin/cpd_criterias/{profession}/create', 'CpdCriteriaController@create');
Route::post('/admin/cpd_criterias/store', 'CpdCriteriaController@store');
Route::patch('/admin/cpd_criterias/update', 'CpdCriteriaController@update');


//paynow
Route::post('/make_online_payment', 'PortalApiController@make_online_payment');
Route::get('/check_payment/{practitioner_id}', 'RenewalController@check_payment');
Route::get('/sessions/', 'RenewalController@sessions');


//student registration fees
Route::resource('/admin/student_registration_fees', 'StudentRegistrationFeesController');

//profession_prefixes
Route::resource('/admin/prefixes', 'PrefixesController');

//profession_cdpoints
Route::resource('/admin/cdpoints', 'CdPointsController');

//qualification_levels
Route::resource('/admin/qualification_levels', 'QualificationLevelsController');

//professions that the approvers approve
Route::resource('/admin/profession_approvers', 'ProfessionApproversController');

//professional_qualifications
Route::resource('/admin/professional_qualifications', 'ProfessionalQualificationsController');

//accredited_institutions
Route::resource('/admin/accredited_institutions', 'AccreditedInstitutionsController');

//discredited_institutions
Route::resource('/admin/discredited_institutions', 'DiscreditedInstitutionsController');

//accredited_qualification
Route::resource('/admin/accredited_qualifications', 'AccreditedQualificationsController');

//payments items
Route::resource('/admin/payment_items', 'PaymentItemsController');

Route::resource('/admin/payment_items/categories', 'PaymentItemsCategoryController');

Route::resource('/admin/payment_items/fees', 'PaymentItemsCategoryController');

//check submitted officer status
Route::get('/admin/submit_requirements/{practitionerRequirement}', 'SubmittedRequirementsController@store');
Route::delete('/admin/submit_requirements/{practitionerRequirement}', 'SubmittedRequirementsController@destroy');

//check submitted member status
Route::get('/admin/submit_requirements/{practitionerRequirement}/member', 'SubmittedRequirementsController@storeMember');
Route::delete('/admin/submit_requirements/{practitionerRequirement}/member', 'SubmittedRequirementsController@destroyMember');


//dynamic shortfalls
Route::get('/admin/shortfall/{practitionerRequirement}', 'SubmittedRequirementsController@mark');

//practitioner_applications
Route::resource('/admin/practitioner_applications', 'PractitionerApplicationsController');
Route::get('/admin/practitioner_applications/{practitioner}/{application}', 'PractitionerApplicationsController@viewApplication');

/*End Of Utilities CRUD*/
/*---------------------*/
/*Start Of Practitioner Registration*/
Route::resource('/admin/practitioners', 'PractitionersController');
Route::get('/admin/pending_approval', 'PractitionersController@pendingApproval');
Route::get('/admin/practitioners/renewal/create', 'PractitionersController@createForRenew');
Route::post('/admin/practitioners/renewal/store', 'PractitionersController@practitionerRenewStore');
Route::get('/admin/practitioners/{practitioner}/delete', 'PractitionersController@delete');
/*End Of Practitioner Registration*/

//practitioner_qualifications
Route::get('/admin/practitioners/qualifications/{practitioner}/create', 'PractitionerQualificationsController@create');
Route::post('/admin/practitioners/qualifications/{practitioner}/store', 'PractitionerQualificationsController@store');
Route::patch('/admin/practitioners/qualifications/{practitionerQualification}/update', 'PractitionerQualificationsController@update');
Route::get('/admin/practitioners/qualifications/{practitionerQualification}/show', 'PractitionerQualificationsController@show');
Route::get('/admin/practitioners/qualifications/{practitionerQualification}/edit', 'PractitionerQualificationsController@edit');
Route::get('/admin/practitioners/qualifications/{practitioner}/showprimary', 'PractitionerQualificationsController@showPrimary');
Route::get('/admin/practitioners/qualifications/{practitioner}/editprimary', 'PractitionerQualificationsController@editPrimary');
Route::patch('/admin/practitioners/qualifications/{practitioner}/storePrimary', 'PractitionerQualificationsController@storePrimary');


//practitioner contacts
Route::get('/admin/practitioners/contacts/{practitioner}/create', 'PractitionerContactsController@create');
Route::post('/admin/practitioners/contacts/{practitioner}/store', 'PractitionerContactsController@store');
Route::get('/admin/practitioners/contacts/{practitioner}/edit', 'PractitionerContactsController@edit');
Route::patch('/admin/practitioners/contacts/{practitionerContact}/update', 'PractitionerContactsController@update');


//practitioner documents
Route::get('/admin/practitioners/documents/{practitioner}/create', 'PractitionerDocumentsController@create');
Route::post('/admin/practitioners/documents/{practitioner}/store', 'PractitionerDocumentsController@store');
Route::get('/admin/practitioners/documents/{document}/edit', 'PractitionerDocumentsController@edit');
Route::patch('/admin/practitioners/documents/{document}/update', 'PractitionerDocumentsController@update');


//practitioner other application
Route::get('/admin/practitioners/apps/{practitioner}/create', 'OtherApplicationController@create');
Route::post('/admin/practitioners/apps/{practitioner}/store', 'OtherApplicationController@store');
Route::get('/admin/practitioners/apps/{otherApplication}/edit', 'OtherApplicationController@edit');
Route::patch('/admin/practitioners/apps/{otherApplication}/update', 'OtherApplicationController@update');
Route::get('/admin/practitioners/apps/{otherApplication}/show', 'OtherApplicationController@show');


//practitioner other application documents
Route::get('/admin/practitioners/docs/{otherApplication}/create', 'OtherDocumentsController@create');
Route::post('/admin/practitioners/docs/{otherApplication}/store', 'OtherDocumentsController@store');
Route::get('/admin/practitioners/docs/{otherApplication}/edit', 'OtherDocumentsController@edit');
Route::patch('/admin/practitioners/docs/{otherApplication}/update', 'OtherDocumentsController@update');


//practitioner employer
Route::get('/admin/practitioners/employer/{practitioner}/create', 'PractitionerEmployerController@create');
Route::post('/admin/practitioners/employer/{practitioner}/store', 'PractitionerEmployerController@store');
Route::get('/admin/practitioners/employer/{practitionerEmployer}/edit', 'PractitionerEmployerController@edit');
Route::patch('/admin/practitioners/employer/{practitionerEmployer}/update', 'PractitionerEmployerController@update');


//practitioner experience
Route::get('/admin/practitioners/experience/{practitioner}/create', 'PractitionerExperienceController@create');
Route::post('/admin/practitioners/experience/{practitioner}/store', 'PractitionerExperienceController@store');
Route::get('/admin/practitioners/experience/{practitionerExperience}/edit', 'PractitionerExperienceController@edit');
Route::patch('/admin/practitioners/experience/{practitionerExperience}/update', 'PractitionerExperienceController@update');
Route::get('/admin/practitioners/experience/{practitionerExperience}/show', 'PractitionerExperienceController@show');


//practitioner renewals payments
//we redirect to the page where we get to create the new renewal
Route::get('/admin/practitioner_renewals/{practitioner}/create', 'RenewalController@create');
//display all the renewal payments for a specific period
Route::get('/admin/practitioner_renewals/{renewal}/index', 'RenewalController@index');

//
Route::get('/admin/practitioner_renewals/{renewal}/initiate_renewal_verification', 'RenewalController@initiate_renewal_verification');
Route::get('/admin/practitioner_renewals/{renewal}/initiate_renewal_sign_off', 'RenewalController@initiate_renewal_sign_off');
Route::post('/admin/practitioner_renewals/{renewal}/verify_renewal', 'RenewalController@verify_renewal');
Route::post('/admin/practitioner_renewals/{renewal}/sign_off', 'RenewalController@sign_off');

Route::get('/admin/practitioners/renewals/{renewal}/create_payment', 'RenewalController@createPayment');
Route::post('/admin/practitioners/renewals/{renewal}/make_payment', 'RenewalController@makePayment');
Route::get('/admin/practitioners/renewals/{practitioner}/practitionerBalances', 'RenewalController@practitionerBalances');


//update payment method, renewal category
Route::get('/admin/practitioner_payment_info/{practitioner}/create', 'PractitionerPaymentInfoController@create');
Route::post('/admin/practitioner_payment_info/{practitioner}/store', 'PractitionerPaymentInfoController@store');

Route::get('/admin/practitioners/payment_requirement/{practitioner}/update', 'PractitionerUpdateController@paymentMethodsUpdate');
Route::patch('/admin/practitioners/payment_requirement/{practitioner}/payments_renewal', 'RenewalController@paymentsRequirementUpdate');
Route::patch('/admin/practitioners/payment_requirement/{practitioner}/payments_registration', 'RegistrationController@paymentsRequirementUpdate');



//get invoice
Route::get('/admin/practitioners/renewals/{practitioner}/checkPaymentStatusRegistration', 'RegistrationController@checkPaymentStatus');
Route::get('/admin/practitioners/renewals/{practitioner}/checkPaymentStatusRenewal', 'RenewalController@checkPaymentStatus');
Route::get('/admin/practitioners/renewals/{practitioner}/invoiceBalances', 'RenewalController@invoiceBalances');
Route::get('/admin/practitioners/renewals/{practitioner}/invoiceRenewal', 'RenewalController@invoiceRenewal');

//Print Invoices
Route::get('/admin/invoices/{practitioner}', 'InvoicesController@viewInvoice');
//Route::get('/admin/invoices/download', 'InvoicesController@downloadInvoice');
Route::post('/admin/practitioners/renewals/{practitioner}/store', 'RenewalController@store');
Route::get('/admin/practitioners/renewals/{renewal}/show', 'RenewalController@show');


//renewals and restoration
Route::get('/check_restoration_penalties/{practitioner}', 'RenewalController@check_restoration_penalties');
Route::post('/manual_restoration_penalties/{practitioner}', 'RenewalController@manual_restoration_penalties');
Route::post('/make_restoration_payment', 'RenewalController@make_restoration_payment');


Route::get('/admin/practitioners/{practitioner}/cdpoints', 'RenewalController@cdpoints');
Route::post('/admin/practitioners/{practitioner}/storeCdpoints', 'RenewalController@storeCdpoints');
Route::get('/admin/practitioners/{practitioner}/createPlacement', 'RenewalController@createPlacement');
Route::post('/admin/practitioners/{practitioner}/storePlacement', 'RenewalController@storePlacement');


//practitioner registration
Route::get('/admin/practitioners/registration/{practitioner}/registration', 'RegistrationController@create');
Route::post('/admin/practitioners/registration/{practitioner}/store', 'RegistrationController@store');


/* get data controler */
Route::get('/admin/get_districts/{province_id}', 'DynamicDataController@districts');
Route::get('/admin/get_districts_edit/{province_id}', 'DynamicDataController@districtsEdit');

//generate practitioner registration number
Route::get('/admin/practitioners/generate_reg/{profession_id}/{practitioner}', 'GenerateRegistrationNumber@create');

//professional qualification
Route::get('/admin/get_pq/{profession_id}', 'DynamicDataController@professionalQualifications');

Route::get('/admin/get_pq/{profession_id}/{pq_id}', 'DynamicDataController@professionalQualificationsEdit');
//
Route::get('/admin/get_ai/{professional_qualification_id}', 'DynamicDataController@accreditedInstitutions');
Route::get('/admin/get_ai/{professional_qualification_id}/{accreInst_id}', 'DynamicDataController@accreditedInstitutionsEdit');

//Dynamic data
Route::get('/admin/discredited_institutions/search/{text}', 'DynamicDataController@search');
Route::get('/dynamic/onload/{province_id}/{my_id}', 'DynamicDataController@districtEdit');
Route::get('/renewal/payment_item_category_id/{payment_item_category_id}', 'DynamicDataController@paymentItem');
//getting the fee in paymentItems where id = payment_item_id
Route::get('/renewal/payment_items/{payment_item_id}/{renewal}', 'DynamicDataController@paymentItemFee');
//get professional qualification where profession is passed

//Application approvals
Route::get('/admin/practitioners/approval/{practitioner}/approve', 'PractitionerUpdateController@approve');
Route::get('/admin/practitioners/approval/{practitioner}/disapprove', 'PractitionerUpdateController@disapprove');

//post approval
Route::post('/admin/practitioners/approval/{practitioner}/officer', 'PractitionerUpdateController@registrationOfficerApproval');
Route::post('/admin/practitioners/approval/{practitioner}/accountant', 'PractitionerUpdateController@accountantApproval');
Route::post('/admin/practitioners/approval/{practitioner}/member', 'PractitionerUpdateController@memberApproval');
Route::post('/admin/practitioners/approval/{practitioner}/registrar', 'PractitionerUpdateController@registrarApproval');

//post disapproval
Route::post('/admin/practitioners/disapproval/{practitioner}/officer', 'PractitionerUpdateController@registrationOfficerDisApproval');
Route::post('/admin/practitioners/disapproval/{practitioner}/accountant', 'PractitionerUpdateController@accountantDisApproval');
Route::post('/admin/practitioners/disapproval/{practitioner}/member', 'PractitionerUpdateController@memberDisApproval');
Route::post('/admin/practitioners/disapproval/{practitioner}/registrar', 'PractitionerUpdateController@registrarDisApproval');

//read notifications mark as read
Route::get('/admin/practitioners/read/{practitioner}/{notification_id}', 'PractitionerUpdateController@viewNotification');

//get the notifications and open in as a message page, put a link there to go app if possible
Route::get('/admin/notification/inbox', 'MessagesController@inbox');
Route::get('/admin/{notification}/read', 'MessagesController@read');
Route::post('/admin/notification/reply', 'MessagesController@reply');
Route::get('/admin/notification/unread', 'MessagesController@unread');
Route::get('/admin/notification/compose', 'MessagesController@compose');
Route::post('/admin/notification/send', 'MessagesController@send');

//practitioner certificates
Route::get('/certificate/{renewal}', 'CertificateController@certificate');

Route::get('/admin/practitioners/certificate/index', 'PractitionerCertificateController@index');
Route::get('/admin/practitioners/certificate/pending', 'PractitionerCertificateController@pending');
Route::get('/admin/practitioners/certificate/collection/{renewal}', 'PractitionerCertificateController@collection');
Route::patch('/admin/practitioners/certificate/signoff/{renewal}', 'PractitionerCertificateController@signOff');
Route::patch('/admin/practitioners/certificate/collect/{renewal}', 'PractitionerCertificateController@collect');

//portal permission
Route::get('/admin/practitioners/{practitioner}/{id}/verify_create', 'AdminController@create');
Route::post('/admin/practitioners/verify', 'AdminController@portal_permissions');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

//System Users
Route::resource('/admin/users', 'SystemUsersController');


/*
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

//Tables routes
Route::get('/fetchingAllUnit', 'PractitionersController@fetchingAllUnit');
Route::get('/search_unit', 'PractitionersController@search_unit_by_key');



Route::get('/admin/other/{practitioner}', 'PractitionersController@other');

//APIS
//1. get all practitioners API
Route::get('/json/practitioners', 'APIController@index');
//get one practitioner by practitioner->id and renewal status
Route::get('/json/practitioners/{practitioner}', 'APIController@show');
//post practitioner ID
Route::post('/json/practitioners/post', 'APIController@postPractitioner');



//get practitioner by registration_number and Id_number
Route::get('/json/practitioners/{registration_number}/{id_number}', 'APIController@byRegID');

//get practitioner by registration_number string and Id_number
Route::get('/json/practitioner_string/{registration_number}/{id_number}', 'APIController@byRegIdString');

Route::get('/json/testing/{registration_number}/{id_number}', 'APIController@test');

// this is a test point where data is pre-initialized
Route::get('/json/test', 'APIController@testBoth');
Route::get('/testme', 'PractitionersController@testme');

//portal teste
Route::get('/update_qualification', 'APIController@update_qualification');
Route::get('/update_practitioner_payment_info', 'APIController@update_practitioner_payment_info');


