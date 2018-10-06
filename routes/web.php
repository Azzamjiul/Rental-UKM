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

Route::get('/', 'Auth\LoginController@showLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/inventaris', 'AdminController@inventaris')->name('inventaris');
Route::get('/log', 'AdminController@bukuBesar')->name('bukuBesar');
Route::get('/historis', 'AdminController@historis')->name('historis');
Route::get('/report', 'AdminController@report')->name('report');
Route::get('/report/kas/{tahun}/{bulan}/{kertas}', 'PdfController@getPdfKas');
Route::get('/report/kas/download/{tahun}/{bulan}/{kertas}', 'PdfController@downloadPdfKas');
Route::get('/report/invoices/{tahun}/{bulan}/{kertas}', 'PdfController@getPdfInvoices');
Route::get('/report/invoices/download/{tahun}/{bulan}/{kertas}', 'PdfController@downloadPdfInvoices');
Route::get('/historis/get-historis', 'AdminController@getHistory')->name('get.history');
Route::get('/log/get-kas', 'AdminController@getKas')->name('get.kas');
Route::get('/cek/inventaris', 'AdminController@cekInventaris')->name('cek.inventaris');
Route::get('/cek/inventaris/list/{tanggal_awal}/{tanggal_akhir}', 'AdminController@getInventaris')->name('get.gods');
Route::delete('/log/delete', 'AdminController@deleteKas')->name('log.deleteKas');
Route::post('/log/edit', 'AdminController@editKas')->name('log.editKas');
Route::post('/log/masuk', 'AdminController@pemasukan')->name('log.pemasukan');
Route::post('/log/keluar', 'AdminController@pengeluaran')->name('log.pengeluaran');
Route::post('/add/barang', 'AdminController@addProduct')->name('add.new.product');
Route::delete('/delete/barang', 'AdminController@deleteProduct')->name('delete.product');
Route::get('/find/barang', 'AdminController@findProduct')->name('find.product');
Route::put('/update/barang', 'AdminController@updateProduct')->name('update.product');

Route::get('/transaksi', 'AdminController@transaksiPage')->name('transaksi');
Route::post('/transaction', 'AdminController@newTransaction')->name('new.transaction');
Route::get('/lihat/nota/{id}/{kertas}', 'PdfController@getPdfInvoice');
Route::get('/lihat/nota-baru/{id}/{kertas}', 'PdfController@getPdfInvoicePelunasan');
Route::get('/lihat/nota-jual-baru/{id}/{kertas}', 'PdfController@getPdfInvoicePelunasanJual');

Route::get('/nota', function(){
  return view('pdf.invoice');
});
Route::get('/pengembalian', 'AdminController@pengembalianBarang');
Route::get('/pelunasan/pembelian', 'AdminController@getPembelian');
Route::get('/barang-yang-belum-dikembalikan', 'AdminController@getOnRentInvoices')->name('on.rent.invoices');
Route::get('/jual-belum-lunas', 'AdminController@getJualBelumLunas')->name('get.jual.belum.lunas');
Route::get('/items-on-rent', 'AdminController@getItemsOnRent')->name('get.items.on.rent');
Route::put('/return-products', 'AdminController@returnProduct')->name('return.products');
Route::put('/pay-fully', 'AdminController@payFully')->name('pay.fully');
Route::put('/pay-sell-fully', 'AdminController@payFullySell')->name('pay.sell.fully');
Route::get('/transaksi-jual-beli', 'AdminController@transaksiJualPage');
Route::post('/sell-item', 'AdminController@sellProducts')->name('new.transaction.sell');
Route::get('/download/nota/{id}/{kertas}', 'PdfController@downloadPdfInvoice');
Route::get('/download/nota-baru/{id}/{kertas}', 'PdfController@downloadPdfInvoicePelunasan');
Route::get('/download/nota-jual-baru/{id}/{kertas}', 'PdfController@downloadPdfInvoicePelunasanJual');


Route::get('/calendar/list', 'AdminController@cekCalendar')->name('cek.calendar');
Route::get('/calendar/list/events', 'AdminController@getEvents')->name('get.calendar.events');
Route::get('/calendar/list/events/{id}', 'AdminController@getEventsDetail')->name('get.events.details');

Route::post('/login/user', 'AdminController@login')->name('login.user');
Route::post('/register/user', 'AdminController@register')->name('register.user');
Route::get('/accounts', 'AdminController@accountsPage');
Route::get('/register', function(){
  return view('auth.register');
});
Route::get('/get/user', 'AdminController@getUserData');
Route::post('/new/user', 'AdminController@newUser');
Route::put('/update/user', 'AdminController@updateUser');
Route::delete('/delete/user', 'AdminController@deleteUser')->name('delete.user');
Route::get('/get/product-stocks', 'AdminController@getProductStocksforTransaction');
