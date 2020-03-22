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
    return view('welcome');
});

Route::get('/test', function () {
    return 'Welcome';
})->middleware('auth');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rooms/{roomType?}', 'ShowRoomsController')->name('rooms');
// Route::get('/test', function(){return 'Good';});

Route::middleware('auth')->group(function() {

    Route::prefix('/bookings')->group(function() {
        Route::get('/', 'BookingController@index')->name('bookings');
        Route::get('/create', 'BookingController@create')->name('bookings.create');
        Route::post('/', 'BookingController@store')->name('bookings.store');
        Route::prefix('/{booking}')->group(function() {
            Route::get('/', 'BookingController@show')->name('booking.show');
            Route::get('/edit', 'BookingController@edit')->name('booking.edit');
            Route::put('/', 'BookingController@update')->name('booking.update');
            Route::delete('/', 'BookingController@destroy')->name('booking.destroy');
        });

    });
    
    Route::prefix('/room_types')->group(function() {
        Route::get('/', 'RoomTypeController@index')->name('room_types');
        Route::get('/create', 'RoomTypeController@create')->name('room_types.create');
        Route::post('/', 'RoomTypeController@store')->name('room_types.store');
        Route::prefix('/{roomType}')->group(function() {
            Route::get('/', 'RoomTypeController@show')->name('roomType.show');
            Route::get('/edit', 'RoomTypeController@edit')->name('roomType.edit');
            Route::put('/', 'RoomTypeController@update')->name('roomType.update');
            Route::delete('/', 'RoomTypeController@destroy')->name('roomType.destroy');
        });

    });

});