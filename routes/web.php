<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
 * 
| CONTROLLER WHATSAPP ADA DI FILTER COY...!!!
*/

Route::get('/', function () {
    return redirect()->route("home");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'fo', 'middleware'=>['auth', 'role:front_office']], function () {
    Route::get('satker', ['as' => 'fo.satker', 'uses' => 'FoSatkerController@index']);
    
    Route::get('supplier', ['as' => 'supplier', 'uses' => 'FoSupplierController@getIndex']);
    Route::get('supplier/get-supplier', ['as' => 'get.supplier', 'uses' => 'FoSupplierController@getQuery']);
    Route::get('supplier/tindakan/{id}', ['as' => 'get.supplier.tandai', 'uses' => 'FoSupplierController@getAmbil']);
    
    Route::get('kontrak', ['as' => 'kontrak', 'uses' => 'FoKontrakController@getIndex']);
    Route::get('kontrak/get-kontrak', ['as' => 'get.kontrak', 'uses' => 'FoKontrakController@getQuery']);
    Route::get('kontrak/tindakan/{id}', ['as' => 'get.kontrak.tandai', 'uses' => 'FoKontrakController@getAmbil']);
    
    Route::get('filter', ['as' => 'fo.filter', 'uses' => 'FoFilterController@form']);
    Route::get('telusuri', ['as' => 'fo.telusuri', 'uses' => 'FoFilterController@telusuri']);
    
    Route::get('show', ['as' => 'supplier.ajax', 'uses' => 'FoFilterController@supplierAjax']);
    Route::get('show1', ['as' => 'kontrak.ajax', 'uses' => 'FoFilterController@kontrakAjax']);
});

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function () {
    Route::resource('satker', 'SatkersController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('kontrak', 'KontrakController');
    
    Route::post('import/supplier', ['as' => 'import.supplier', 'uses' => 'ExcelController@importExcel']);
    
    Route::get('filter', ['as' => 'filter', 'uses' => 'FilterController@filter']);
        // Filter index form
    Route::get('telusuri', ['as' => 'get.filter', 'uses' => 'FilterController@index']);
        // Filter logic
    
    Route::get('eksport', ['as' => 'supplier.export', 'uses' => 'ExcelController@exportSupplier']);
    Route::get('eksport1', ['as' => 'kontrak.export', 'uses' => 'ExcelController@exportKontrak']);
    Route::get('kontak/{id}', ['as' => 'supplier.whatsapp', 'uses' => 'FilterController@waSupplier']);
    Route::get('kontak1/{id}', ['as' => 'kontrak.whatsapp', 'uses' => 'FilterController@waKontrak']);
});