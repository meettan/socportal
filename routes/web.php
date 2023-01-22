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
Route::get('/privacypolicy',[App\Http\Controllers\UserController::class,'privacypolicy'])->name('privacypolicy');
Route::get('/refundpolicy',[App\Http\Controllers\UserController::class,'refundpolicy'])->name('refundpolicy');
Route::get('/termcondition',[App\Http\Controllers\UserController::class,'termcondition'])->name('termcondition');
Route::post('/login',[App\Http\Controllers\UserController::class,'login'])->name('loginConfrim');
Route::get('/reload-captcha', [App\Http\Controllers\UserController::class, 'reloadCaptcha']);
Route::get('/register', [App\Http\Controllers\UserController::class,'register'])->name('register');
Route::post('/validatesocdetail',[App\Http\Controllers\UserController::class,'validatesocdetail']);
Route::get('/panvalidate', [App\Http\Controllers\UserController::class, 'panvalidate']);
Route::get('/registerse/{id?}', [App\Http\Controllers\UserController::class,'register_second'])->name('registerse');
Route::post('/registercomplete',[App\Http\Controllers\UserController::class,'registercomplete']);
Route::get('/basic_email',[App\Http\Controllers\UserController::class,'basic_email'])->name('basic_email');
Route::get('/forgotpassword',[App\Http\Controllers\UserController::class,'forgotpassword'])->name('forgotpassword');
Route::get('/setuppassword',[App\Http\Controllers\UserController::class,'setuppassword'])->name('setuppassword');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'dashboard'])->name('dashboard');
Route::get('/profile', [App\Http\Controllers\DashboardController::class,'profile'])->name('profile');
Route::post('/profile_update', [App\Http\Controllers\DashboardController::class,'profile_update'])->name('profile_update');
Route::post('/password_update', [App\Http\Controllers\DashboardController::class,'password_update'])->name('password_update');

Route::get('/report', [App\Http\Controllers\UserController::class,'report'])->name('report');
Route::get('/receipt', [App\Http\Controllers\UserController::class,'receipt'])->name('receipt');
Route::any('/drcrnote', [App\Http\Controllers\CreditnoteController::class,'drcrnote'])->name('drcrnote');
Route::get('/drnoteReport', [App\Http\Controllers\CreditnoteController::class,'drnoteReport'])->name('drnoteReport');
Route::any('/advancefilter', [App\Http\Controllers\AdvanceController::class,'advancefilter'])->name('advancefilter');
Route::get('/socadvReport', [App\Http\Controllers\AdvanceController::class,'socadvReport'])->name('socadvReport');
Route::any('/socpayment', [App\Http\Controllers\MoneyreceiptController::class,'socpayment'])->name('socpayment');
Route::get('/moneyrecpt', [App\Http\Controllers\MoneyreceiptController::class,'moneyrecpt'])->name('moneyrecpt');
Route::any('/salesfilter', [App\Http\Controllers\SaleController::class,'salesfilter'])->name('salesfilter');
Route::get('/print_receipt', [App\Http\Controllers\SaleController::class,'print_receipt'])->name('print_receipt');
Route::get('/saleinvoice_rep', [App\Http\Controllers\SaleController::class,'saleinvoice_rep'])->name('saleinvoice_rep');
Route::post('/socledgerrep', [App\Http\Controllers\SocietyController::class,'socledgerrep'])->name('socledgerrep');
Route::any('socledger', 'SocietyController@socledger')->name('socledger');
Route::any('purrep', 'SocietyController@purrep')->name('purrep');

//  Payment detail  route start
Route::get('/payment', [App\Http\Controllers\PaymentController::class,'payment'])->name('payment');
Route::any('/advpayment', [App\Http\Controllers\PaymentController::class,'advpayment'])->name('advpayment');
Route::any('/invpayment', [App\Http\Controllers\PaymentController::class,'invpayment'])->name('invpayment');


Route::post('/pay' ,[App\Http\Controllers\PaymentController::class,'pay'])->name('pay');

// start payment success and error roure
Route::any('advredirectToPayU',  [App\Http\Controllers\PaymentController::class,'advredirectToPayU'])->name('advredirectToPayU');
Route::any('redirectToPayU',  [App\Http\Controllers\PaymentController::class,'redirectToPayU'])->name('redirectToPayU');
Route::any('error', [App\Http\Controllers\PayuMoneyController::class,'error'])->name('error');
Route::any('success', [App\Http\Controllers\PayuMoneyController::class,'success'])->name('success');
Route::any('cancel', [App\Http\Controllers\PayuMoneyController::class,'cancel'])->name('cancel');
// end payment success and error roure


// Route::get('/pay' ,[App\Http\Controllers\PaymentController::class,'pay'])->name('pay');
Route::post('/paymentrequest' ,[App\Http\Controllers\PaymentController::class,'paymentrequest'])->name('paymentrequest');
Route::get('/paywithroza' ,[App\Http\Controllers\PaymentController::class,'paywithroza'])->name('paywithroza');
Route::get('/paymentlist' ,[App\Http\Controllers\PaymentController::class,'paymentlist'])->name('paymentlist');
// Route::get('/success' ,[App\Http\Controllers\PaymentController::class,'success'])->name('success');
// Route::get('/error/{payment_id?}' ,[App\Http\Controllers\PaymentController::class,'error'])->name('error');
Route::get('/failedresponse' ,[App\Http\Controllers\PaymentController::class,'failedresponse'])->name('failedresponse');
Route::get('/paymentdetail', [App\Http\Controllers\PaymentController::class,'paymentdetail'])->name('paymentdetail');


Route::post('/invpayform', [App\Http\Controllers\PaymentController::class,'invpayform'])->name('invpayform');



Route::post('/invpaymentrequest', [App\Http\Controllers\PaymentController::class,'invpaymentrequest'])->name('invpaymentrequest');

Route::get('/payhistory' ,[App\Http\Controllers\PaymentController::class,'payhistory'])->name('payhistory');


// Payment detail  route End

//   Payment Web response  

Route::get('/settlementdetails/{id?}' ,[App\Http\Controllers\HdfcresponseController::class,'settlementdetails'])->name('settlementdetails');
//Route::get('/settlementdetails' ,[App\Http\Controllers\HdfcresponseController::class,'settlementdetails'])->name('settlementdetails');
//



Route::get('/logout', 'UserController@logout')->name('logout');
