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
*/

Route::get('/', function () {
    return redirect()->route("home");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'fo', 'middleware'=>['auth', 'role:front_office']], function ()
{
    Route::post('spm', ['as' => 'spm.diambil', 'uses' => 'PengambilSpmController@diambil']);    
    Route::get('satker', ['as' => 'fo.satker', 'uses' => 'FoSatkerController@index']);    
    Route::get('supplier', ['as' => 'fo.supplier', 'uses' => 'SupplierController@index']);
    Route::get('kontrak', ['as' => 'fo.kontrak', 'uses' => 'kontrakController@index']);    
    Route::get('filter', ['as' => 'fo.filter', 'uses' => 'FilterController@filter']);
    Route::get('telusuri', ['as' => 'fo.telusuri', 'uses' => 'FilterController@index']);
});

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function ()
{
    Route::resource('satker', 'SatkersController');    
    Route::resource('supplier', 'SupplierController');
    Route::resource('kontrak', 'KontrakController');
    Route::resource('pmrt', 'PmrtController');
    Route::get('filter', ['as' => 'admin.filter', 'uses' => 'FilterController@filter']);
    Route::get('telusuri', ['as' => 'admin.telusuri', 'uses' => 'FilterController@index']);
    Route::get('eksport', ['as' => 'spm.export', 'uses' => 'ExcelController@exportSpm']);
    Route::get('kontak/{id}', ['as' => 'spm.whatsapp', 'uses' => 'WaController@hubungi']);
});