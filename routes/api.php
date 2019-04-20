<?php

use Illuminate\Http\Request;

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

/** 
 * API Version 1.0
 */

Route::group([
    'namespace'     => 'API\v1',
    'prefix'        => 'v1',
    'middleware'    => 'api',

], function () {
	/**
     * Authentication
     */
	Route::prefix('auth')->group(function () {
		Route::get('me',        		'AuthController@me');
		Route::post('register', 		'AuthController@register');
		Route::post('login', 			'AuthController@login');
		Route::post('changepassword',	'AuthController@changePassword');
	});

	Route::get('users',     			'UserController@index')->name('users.index');
	Route::get('users/{user}',  		'UserController@show')->name('users.show');

	/**
	 * Untuk update profile
	 */
	Route::post('users/update/{user}',	'UserController@update')->name('users.update');
	
	/**
	 * Untuk menampilkan product, di kelompokkan berdasarkan user {user} -> id user
	 */
	Route::get('users/product/{user}',  'UserController@product')->name('users.product');

	/**
	 * Untuk mendapatkan semua category
	 */
	Route::get('categories',     			'CategoryController@index')->name('category.index');

	/**
	 * Untuk mendapatkan semua subcategory
	 */
	Route::get('subcategories',     		'SubCategoryController@index')->name('subcategory.index');
	
	/**
	 * Untuk mendapatkan subcategory, di kelompokkan berdasarkan category {category} -> id category
	 */
	Route::get('subcategory/{category}', 	'SubCategoryController@show')->name('subcategory.show');

	/**
	 * Untuk menampilkan semua product
	 */
	Route::get('products',     	'ProductController@index')->name('product.index');
	Route::get('products/low',  'ProductController@low')->name('product.low');
	Route::get('products/high',  'ProductController@high')->name('product.high');
	
	/**
	 * Untuk menampilkan product, di kelompokkan berdasarkan subcategory {product} -> id sub_category
	 */
	Route::get('products/{product}',     			'ProductController@subcategory')->name('product.subcategory');

	Route::get('products/low/{product}',     			'ProductController@subcategory_low')->name('product.subcategory_low');
	Route::get('products/high/{product}',     			'ProductController@subcategory_high')->name('product.subcategory_high');
	
	/**
	 * Menampilkan detail product {product} -> id productnya
	 */
	Route::get('products/detail/{product}', 		'ProductController@show')->name('product.show');

	Route::post('booking/add', 				'BookingController@store')->name('booking.store');
	/**
	 * Menampilkan semua booking, di kelompokkan berdasarkan user id, {booking} -> id user_id
	 */
	Route::get('booking/{booking}', 		'BookingController@show')->name('booking.show');
	/**
	 * Menampilkan detail booking, {booking} -> id booking_id
	 */
	Route::get('booking/detail/{booking}', 	'BookingController@detail')->name('booking.detail');
	/**
	 * Untuk cencel booking
	 */
	Route::post('booking/detail/cancel', 	'BookingController@cancel')->name('booking.cancel');

	/**
	 * Untuk kirim message
	 */
	Route::post('message/add', 				'MessageController@store')->name('message.store');

	/**
	 * Untuk report product
	 */
	Route::post('product/report', 			'ReportController@store')->name('report.store');

	/**
	 * Untuk download surat perjanjian, {id} -> id transaksi
	 */
	Route::get('transaction/detail/pdf/{id}',		'TransactionController@getPdf')->name('transaction.getPdf');

	Route::get('transaction/{id}', 			'TransactionController@index')->name('transaction.index');

	/**
	 * Untuk melakukan transaction
	 */
	Route::post('transaction/store', 		'TransactionController@store')->name('transaction.store');

	/**
	 * untuk menampilkan detail transaction, {id} => id transaction
	 */
	Route::get('transaction/detail/{id}',	'TransactionController@show')->name('transaction.show');

	/**
	 * Untuk melakukan rating
	 */
	Route::post('rating/store', 			'RatingController@store')->name('rating.store');

});
