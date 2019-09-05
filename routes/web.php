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
});

Route::group(['middleware',['web','cekuser:["ADMIN"]']],
function(){
    Route::get('/kategori/data','KategoriController@listData')->name('kategori.data');
    Route::resource('kategori','KategoriController');
});

Route::group(['middleware',['web','cekuser:["ADMIN"]']],
function(){
    Route::get('/produk/data','ProdukController@listData')->name('produk.data');
    Route::delete('/produk/delete-batch','ProdukController@deleteBatch')->name("produk.delete-batch");
    Route::post('/produk/cetak','ProdukController@cetakbarcode')->name("produk.cetak");
    Route::resource('produk','ProdukController');
});

Route::group(['middleware',['web','cekuser:["ADMIN"]']],
function(){
    Route::get('/supplier/data','SupplierController@listData')->name("supplier.data");
    Route::resource('supplier','SupplierController');
});
Route::group(['middleware',['web','cekuser:["ADMIN"]']],
function(){
    Route::get('/member/data','MemberController@listData')->name("member.data");
    Route::delete("/member/delete-batch","MemberController@deleteBatch")->name("member.delete-batch");
    Route::post("/member/cetak","MemberController@printCard");
    Route::resource("member","MemberController");
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');