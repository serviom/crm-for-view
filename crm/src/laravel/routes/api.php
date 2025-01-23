<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('telephony/getCallsList', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@getCallsList');
Route::get('telephony/createEmployee', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@createEmployee');
Route::get('telephony/activateEmployee', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@activateEmployee');
Route::get('telephony/deleteEmployee', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@deleteEmployee');
Route::get('telephony/listEmployee', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@listEmployee');
Route::get('telephony/listGroup', 'App\Http\Controllers\Api\V1\BackingServices\TelephonyController@listGroup');

Route::prefix('v1')->group(function () {
    Route::namespace('App\Http\Controllers')->group(function () {

        //Auth
        Route::prefix('auth')->group(function () {
            Route::namespace('Auth\Email')->group(function () {
                Route::post('login', 'AuthController@login');

                Route::group(['middleware' => 'jwt'], function(){

                    Route::post('logout', 'AuthController@logout');
                    Route::post('me', 'AuthController@me');
                    Route::get('refresh', 'AuthController@refresh');
                });
            });

        });

        Route::namespace('Api\V1')->group(function () {
            Route::post('/telegram', 'TelegramController@webhook')->name('telegram-webhook');
        });

        //JWT
        Route::group(['middleware' => 'jwt'], function(){
            Route::namespace('Api\V1')->group(function () {

                Route::post('/telegram/set-webhook', 'TelegramController@setWebhook');
                Route::post('/telegram/connect', 'TelegramController@connect');
                Route::post('/telegram/disconnect', 'TelegramController@disconnect');
                Route::post('/telegram/send', 'TelegramController@sendMessage');

       
                //Handbook
                Route::get('handbook/{table}', 'HandbookController@getHandbook');
                Route::get('handbook/{table}/{id}', 'HandbookController@getHandbookItem');
                Route::post('handbook/{table}/save', 'HandbookController@saveHandbookItem');
                Route::delete('handbook/{table}/{id}', 'HandbookController@removeHandbookItem');

                //Profile
                Route::get('profile', 'ProfileController@show');
                Route::post('profile', 'ProfileController@update');
                Route::delete('profile/avatar', 'ProfileController@deleteAvatar');

                //User
                Route::get('users/all-roles', 'UsersController@allRolesList');
                Route::resource('users', 'UsersController');
                Route::post('users/restore/{id}', 'UsersController@restore');
                Route::get('user-log-list', 'UsersController@logList');

                //Roles
                Route::resource('roles', 'RolesController');

                //Permissions
                Route::prefix('permissions')->group(function () {
                    Route::get('', 'RolesController@getPermissions');
                });

                //Clients
                Route::post('clients/check-phone', 'ClientsController@checkPhoneNumber');
                Route::post('clients/all', 'ClientsController@allClientsList');
                Route::get('clients/all-users', 'ClientsController@allUsersList');
                Route::get('clients/all-events', 'ClientsController@allEventsList');
                Route::resource('clients', 'ClientsController');
                Route::post('client-log-list', 'ClientsController@getLogList');
                Route::post('clients/{id}/comment', 'ClientsController@addComment');
                Route::post('clients/comments', 'ClientsController@comments');

                //Orders
                Route::get('order/{id}', 'OrderController@show');
                Route::post('orders', 'OrderController@index');
                Route::post('order/save', 'OrderController@save');
                Route::post('order/cancel', 'OrderController@cancel');
                Route::post('order/{id}/comment', 'OrderController@addOrderComment');
                Route::post('order/comments', 'OrderController@comments');
                Route::delete('order/{id}', 'OrderController@remove');
                Route::get('dynprops', 'OrderController@dynprops');

                //Offers
                Route::get('offers/{id}', 'OffersController@index');
                Route::post('offers/create', 'OffersController@store');
                Route::post('offers/update', 'OffersController@update');

                //Order Audio
                Route::get('order-audious/{id}', 'OrderAudioController@index');
                Route::get('order-audio/{id}', 'OrderAudioController@show');
                Route::post('order-audio/create', 'OrderAudioController@store');
                Route::post('order-audio/upload', 'OrderAudioController@upload');
                Route::put('order-audio/upload/{id}', 'OrderAudioController@update');
                Route::post('order-audio/{id}', 'OrderAudioController@remove');

                //Events
                Route::get('reminder', 'EventController@reminder');
                Route::post('event/close', 'EventController@closeEvent');
                Route::post('event/restore', 'EventController@restoreEvent');

                //Dashboard
                Route::get('dashboard', 'DashboardController@index');

                //Statistics
                Route::get('statistics/{type}', 'StatisticsController@getStatistics');

         
            });
        });


    });
});
