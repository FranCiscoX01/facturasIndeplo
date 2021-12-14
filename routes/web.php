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

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    // Costumers
    Route::get('/home', 'CostumerController@index')->name('home'); // table of costumers
    Route::get('/costumer/create', 'CostumerController@create')->name('costumer.create');
    Route::post('/costumer/store', 'CostumerController@store');
    Route::get('/costumer/show', 'CostumerController@show');
    Route::get('/costumer/edit/{id}', 'CostumerController@edit');
    Route::put('/costumer/update', 'CostumerController@update');
    Route::put('/costumer/change-status', 'CostumerController@changeStatus');

    // Sections - Articulos
    Route::get('/section', 'SectionController@index')->name('section'); // table of sections
    Route::get('/section/create', 'SectionController@create')->name('section.create');
    Route::post('/section/store', 'SectionController@store');
    Route::put('/section/change-status', 'SectionController@changeStatus');
    Route::get('/section/edit/{id}', 'SectionController@edit');
    Route::post('/section/update', 'SectionController@update')->name('section.update');

    // Orders
    Route::get('/order', 'OrderController@index')->name('order'); // table of orders
    Route::get('/order/show', 'OrderController@show');
    Route::get('/order/create', 'OrderController@create')->name('order.create');
    Route::get('/order/getSection/{id}', 'OrderController@getSectionByID');
    Route::post('/order/store', 'OrderController@store');
    Route::put('/order/change-status', 'OrderController@changeStatus');
    Route::get('/order/edit/{id}', 'OrderController@edit');
    Route::get('/order/get-details/{id}', 'OrderController@getOrderDetails');
    Route::get('/order/get-costumers-sections/', 'OrderController@getCostumerSections');
    Route::get('/order/delete-order-item/{id}', 'OrderController@deleteOrderItem');
    Route::post('/order/update', 'OrderController@update');

    // Invoice
    Route::get('/invoice', 'InvoiceController@index')->name('invoice'); // table of invoices
    Route::get('/invoice/get-invoices', 'InvoiceController@getAllInvoices');
    Route::get('/invoice/create', 'InvoiceController@create')->name('invoice.create');
    Route::get('/invoice/get-orders', 'InvoiceController@getAllOrders');
    Route::post('/invoice/upload', 'InvoiceController@uploadFile');
    Route::post('/invoice/deleteVoucher', 'InvoiceController@deleteVoucher');
    Route::post('/invoice/store', 'InvoiceController@store');
    Route::put('/invoice/change-status', 'InvoiceController@changeStatus');
    Route::get('/invoice/donwload-voucher/{file}', 'InvoiceController@getDownload');
    Route::get('/invoice/edit/{id}', 'InvoiceController@edit');
    Route::get('/invoice/get-invoice/{id}', 'InvoiceController@getInvoiceById');
    Route::post('/invoice/update', 'InvoiceController@update');
});
