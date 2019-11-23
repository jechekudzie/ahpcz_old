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

//check submitted officer statys
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
Route::get('/admin/practitioners/renewals/{practitioner}/create', 'RenewalController@create');
Route::get('/admin/practitioners/renewals/{renewal}/payments_list', 'RenewalController@index');
Route::get('/admin/practitioners/renewals/{renewal}/create_payment', 'RenewalController@createPayment');
Route::post('/admin/practitioners/renewals/{renewal}/make_payment', 'RenewalController@makePayment');
Route::get('/admin/practitioners/renewals/{practitioner}/practitionerBalances', 'RenewalController@practitionerBalances');

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


//update payment method, renewal category
Route::get('/admin/practitioners/payment_requirement/{practitioner}/update', 'PractitionerUpdateController@paymentMethodsUpdate');
Route::patch('/admin/practitioners/payment_requirement/{practitioner}/payments_renewal', 'RenewalController@paymentsRequirementUpdate');
Route::patch('/admin/practitioners/payment_requirement/{practitioner}/payments_registration', 'RegistrationController@paymentsRequirementUpdate');

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
Route::get('/admin/practitioners/{$notification}/read', 'PractitionerUpdateController@viewNotification');

//practitioner certificates
Route::get('/admin/practitioners/certificate/index', 'PractitionerCertificateController@index');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

//System Users
Route::resource('/admin/users', 'SystemUsersController');


/*
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/


Route::get('/admin/other/{practitioner}', 'PractitionersController@other');
