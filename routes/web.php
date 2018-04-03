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

Auth::routes();

Route::get('/', function () {
    // return view('welcome');
    return redirect('dashboard');
});




Route::get('/dashboard', 'DashboardController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

//Customer Section
Route::resource('customer', 'CustomerController', ['except' => ['destroy']]);
Route::get('customer/data','CustomerController@data');

Route::post('customer/load-data', 'CustomerController@loadData');
Route::get('customer/open-finger/{id}', 'CustomerController@openFinger');
Route::get('customer/{id}/photo', 'CustomerController@photo');
Route::patch('customer/{id}/photo', 'CustomerController@photoUpdate');
Route::patch('customer/{id}/upload-photo', 'CustomerController@uploadPhoto');
Route::get('customer/{id}/fingerprint', 'CustomerController@fingerprint');
Route::get('customer/{id}/finger/update', 'CustomerController@fingerTable');
Route::patch('customer/{id}/retake', 'CustomerController@updateRetake');
Route::get('customer/{id}/sale-invoice', 'CustomerController@saleInvoice');
Route::patch('customer/{id}/add-service', 'CustomerController@addService');
Route::patch('customer/{id}/upgrade-package', 'CustomerController@upgradePackage');
Route::patch('customer/{id}/new-package', 'CustomerController@newPackage');

//Agency Section
Route::resource('agency', 'AgencyController', ['except' => ['destroy','show']]);

//Category Section
Route::resource('category','CategoryController', ['except' => ['destroy','show']]);

//Service Section
Route::resource('service','ServiceController', ['except' => ['destroy','show']]);
Route::get('service/{id}/print','ServiceController@print');

//Package Section
Route::resource('package','PackageController', ['except' => ['destroy','show']]);

//Association Section
Route::resource('association','AssociationController', ['except' => ['destroy','show']]);

//Country Section
Route::resource('country','CountryController', ['except' => ['destroy','show']]);

//Supply Section
Route::resource('supplies','SupplyController', ['except' => ['destroy','show']]);
Route::get('supplies/data','SupplyController@data');
Route::post('supplies/import','SupplyController@importData');


//Inventory Section

Route::get('inventory/filter/{type}','InventoryController@filter');

Route::get('inventory/data','InventoryController@data');

Route::get('inventory/receive','InventoryController@receive');
Route::post('inventory/receive/add','InventoryController@addReceiveItem');
Route::delete('inventory/receive/remove/{id}','InventoryController@removeReceiveItem');
Route::patch('inventory/receive/edit/{id}','InventoryController@editReceiveItem');

Route::get('inventory/return','InventoryController@return');
Route::post('inventory/return/add','InventoryController@addReturnItem');
Route::delete('inventory/return/remove/{id}','InventoryController@removeReturnItem');
Route::patch('inventory/return/edit/{id}','InventoryController@editReturnItem');

Route::resource('inventory','InventoryController', ['except' => ['destroy']]);



//Country Section
Route::resource('pricing-types','PricingTypeController', ['except' => ['destroy','show']]);

//Agency Pricing Section
Route::resource('agency-pricing','AgencyPricingController', ['except' => ['show']]);

//Sale Section
Route::patch('sale/payment/{trans}','SaleController@acceptPayment');
Route::get('sale/payment/{trans}/print','SaleController@printPayment');
Route::post('sale/discount/{trans}','SaleController@discount');
Route::post('sale/add-services/{trans}','SaleController@addService');
Route::resource('sale','SaleController', ['except' => ['destroy','create','edit']]);
Route::patch('sale/{id}/void','SaleController@voidSales');
Route::get('sale/{id}/transaction/{trans}','SaleController@list');

//Transaction Section

Route::resource('transaction','TransactionController', ['except' => ['destroy','create','edit']]);

//Lab Result Section

Route::resource('lab-result','LabResultController', ['except' => ['destroy','create']]);
Route::get('lab-result/{$id}/print','LabResultController@printResult');


Route::resource('xray-result','XrayController', ['except' => ['destroy','create']]);
Route::get('xray-result-radiologist','XrayController@radiologist');
Route::get('xray-result-radiologist/{id}/print','XrayController@radiologistPrint');

// Vaccing Section
Route::resource('vaccine','VaccineController', ['except' => ['destroy','create']]);


// Settings Section
Route::resource('settings','SettingController', ['except' => ['destroy','create']]);


//Transmittal Section
Route::get('transmittal/list','TransmittalController@list');
Route::resource('transmittal','TransmittalController', ['except' => ['destroy','create','edit']]);

Route::get('report/daily-sales', 'ReportController@dailySalesReport');
Route::get('report/agency-sales', 'ReportController@agencySalesReport');
Route::get('report/summary-sales', 'ReportController@summarySalesReport');
Route::get('report/transaction-summary', 'ReportController@transactionSummaryReport');
Route::get('report/status', 'ReportController@statusReport');
Route::get('report/consumed-prod', 'ReportController@consumedProd');
