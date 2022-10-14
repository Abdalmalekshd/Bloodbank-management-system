<?php

use App\Http\Controllers\Gp\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('welcome', function () {
    return view('interfaces\welcome');
});



Route::group(['prefix' => 'bloodbank', 'namespace' => 'App\Http\Controllers\Gp'], function () {

    ##Begin Sign up Route##
    Route::get('signup', 'SignupController@sign');
    Route::post('Create-Account', 'SignupController@signup')->name('signup');
    ##End Sign up Route##

    ##Begin Login Route##
    // Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login'])->name('/login');

    Route::get('login', 'LoginController@login')->name('login');
    Route::post('home', 'LoginController@check')->name('bloodbank/login');

    ##End Login Route##

    ##Begin User Routes##
    Route::get('user', 'UserController@user')->name('user')->middleware('auth:web');
    Route::post('don', 'UserController@adddon')->name('don');
    // Route::get('user', 'UserController@user')->name('user');
    Route::post('ben', 'UserController@addben')->name('ben');
    // Route::get('user', 'UserController@user')->name('user');

    Route::post('exem', 'UserController@addexem')->name('exem');

    ##End User Routes##



    ####Begin Admin Routes####

    Route::get('Adminlogin', 'AdminLoginController@login')->name('admin');
    Route::post('Adminhome', 'AdminLoginController@check')->name('bloodbank/Admin/login');

    Route::group(['middleware' => ('auth:admin')], function () {

        Route::get('home', 'HomeController@getallbloods')->name('Home');

        ##Begin Donors Routes##


        Route::get('donationorders', 'DonorsController@getAlldonororders')->name('reqdonationsorder');

        Route::get('delete_donor/{order_id}', 'DonorsController@Deletedonorder')->name('Delete.order');

        Route::get('editdon/{id}', 'DonorsController@Edit')->name('donor.edit');

        Route::post('updatedon', 'DonorsController@updatedonor')->name('order.don.update');


        Route::get('appdonorder/{id}', 'DonorsController@approveorder')->name('order.don.approved');

        Route::get('donors', 'DonorsController@getAlldonors')->name('donor');

        ##End Donors routes##

        ##Begin Benifet Routes##
        Route::get('benifetorders', 'BenifetController@getAllbenifetorders')->name('reqbenifets');

        Route::get('delete_benifet/{order_id}', 'BenifetController@DeleteBenfietorder')->name('Delete.benifet');



        Route::get('editben/{id}', 'BenifetController@edit')->name('benifet.edit');

        Route::post('updateben', 'BenifetController@updatebenifet')->name('order.ben.update');

        Route::get('appbenorder/{id}', 'BenifetController@approvebenifetorder')->name('order.ben.approved');

        Route::get('benifets', 'BenifetController@getAllbenifets')->name('benifet');

        ##End Benifet routes##



        ##Begin Exemption Routes##

        Route::get('exemptionorders', 'ExemptionController@getAllexemptionorders')->name('reqexemp');

        Route::get('delete_exemptions/{order_id}', 'ExemptionController@DeleteExemptionOrder')->name('Delete.Exemption');




        Route::get('editexem/{id}', 'ExemptionController@Edit')->name('exemption.edit');

        Route::post('updatexem', 'ExemptionController@updateexemption')->name('order.exe.update');

        Route::get('appexeorder/{id}', 'ExemptionController@approveExemotionOrder')->name('order.exe.approved');


        Route::get('exemptions', 'ExemptionController@getAllexemptions')->name('exemption');

        ##End Exemption Routes##

        ####End Admin Routes####

    });


    Route::get('/logout', 'LoginController@logout')->name('logout');
});
