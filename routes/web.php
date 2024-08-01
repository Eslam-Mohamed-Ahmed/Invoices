<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesArchiveController;

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
});


Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class , 'index'])->name('home');


Route::resource('/home/sections'     , SectionsController::class);
Route::resource('/home/products'     , ProductsController::class);
Route::resource('/home/invoices' , InvoicesController::class);
Route::resource('/home/invoices_archive' , InvoicesArchiveController::class);

Route::get('/section/{id}'        , [InvoicesController::class , 'getproducts']);

Route::get('View_file/{Invoices_number}/{file_name}'        , [InvoicesDetailsController::class , 'open_file']);
Route::get('download/{Invoices_number}/{file_name}'        , [InvoicesDetailsController::class , 'get_file']);
Route::delete('delete_file' , [InvoicesDetailsController::class ,'destroy'])->name('delete_file');

Route::get('InvoicesDetails/{id}'    , [InvoicesDetailsController::class , 'show']);

Route::resource('invoiceAttachments' , InvoicesAttachmentsController::class );

// Route::post('/home/invoices' , [InvoicesController::class , 'destroy']);
// Route::post('/home/invoices' , [InvoicesController::class , 'update'])->name('update_invoice');
Route::post('/invoices/store' , [InvoicesController::class , 'store']);
Route::get('/home/invoices/edit_invoice/{id}', [InvoicesController::class , 'edit']);
Route::get('/home/invoices_paid', [InvoicesController::class , 'invoicesPaid']);
Route::get('/home/invoices_unpaid', [InvoicesController::class , 'invoicesUnPaid']);
Route::get('/home/invoices_partial', [InvoicesController::class , 'invoicesPartial']);
Route::get('/home/print_invoice/{id}' , [InvoicesController::class , 'print_invoice']);

Route::get('/Status_show/{id}', [InvoicesController::class ,'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class ,'StatusUpdate'])->name('Status_Update');

Route::resource('/home/sections/destroy' , SectionsController::class );
Route::resource('/home/sections/store'   , SectionsController::class );

Route::resource('/products/store'        , ProductsController::class );
Route::resource('/products/update'       , ProductsController::class );
Route::resource('/home/products/destroy' , ProductsController::class );



Route::get('/{page}'             , [AdminController::class]);