<?php
use Illuminate\Support\Facades\Route;

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
    // return view('login');
    return redirect()->route('login');
});

Route::get('/login',[App\Http\Controllers\UserController::class,'Show'])->name('login');
Route::post('/login',[App\Http\Controllers\UserController::class,'login'])->name('loginConfrim');
Route::get('/reload-captcha', [App\Http\Controllers\UserController::class, 'reloadCaptcha']);
Route::get('/register', [App\Http\Controllers\UserController::class,'register'])->name('register');
Route::post('/validatesocdetail',[App\Http\Controllers\UserController::class,'validatesocdetail']);
Route::get('/registerse/{id?}', [App\Http\Controllers\UserController::class,'register_second'])->name('registerse');
Route::post('/registercomplete',[App\Http\Controllers\UserController::class,'registercomplete']);
Route::get('/dashboard', [App\Http\Controllers\UserController::class,'dashboard'])->name('dashboard');

Route::get('/report', [App\Http\Controllers\UserController::class,'report'])->name('report');
Route::get('/receipt', [App\Http\Controllers\UserController::class,'receipt'])->name('receipt');
Route::any('/drcrnote', [App\Http\Controllers\CreditnoteController::class,'drcrnote'])->name('drcrnote');
Route::get('/drnoteReport', [App\Http\Controllers\CreditnoteController::class,'drnoteReport'])->name('drnoteReport');
Route::any('/advancefilter', [App\Http\Controllers\AdvanceController::class,'advancefilter'])->name('advancefilter');
Route::get('/socadvReport', [App\Http\Controllers\AdvanceController::class,'socadvReport'])->name('socadvReport');
Route::any('/socpayment', [App\Http\Controllers\MoneyreceiptController::class,'socpayment'])->name('socpayment');
Route::get('/moneyrecpt', [App\Http\Controllers\MoneyreceiptController::class,'moneyrecpt'])->name('moneyrecpt');
Route::get('/salesfilter', [App\Http\Controllers\SaleController::class,'salesfilter'])->name('salesfilter');
Route::get('/print_receipt', [App\Http\Controllers\SaleController::class,'print_receipt'])->name('print_receipt');
Route::post('/socledgerrep', [App\Http\Controllers\SocietyController::class,'socledgerrep'])->name('socledgerrep');
Route::any('socledger', 'SocietyController@socledger')->name('socledger');
Route::any('purrep', 'SocietyController@purrep')->name('purrep');
Route::get('/logout', 'UserController@logout')->name('logout');
