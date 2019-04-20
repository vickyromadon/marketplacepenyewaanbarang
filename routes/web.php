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

/**
 * Routing Member
 */
Route::prefix('/')->namespace('Member')->group(function () {
	Route::get('test', "HomeController@test");
	
	Route::match(['get','post'],'mail_confirmation/{link}', "UserController@email_confirmation")->name('mail_confirmation');
	
	Route::middleware(['auth', 'member'])->group(function (){
    	Route::get('user/unconfirm/{action?}', 	"UserController@unconfirm")->name('member.user.unconfirm');
    	Route::get('user/not_active', 			"UserController@not_active")->name('member.user.not_active');
    });

	Route::get('/',					'MemberController@index')->name('member.index');
	Route::get('main_categories',	'MemberController@main_categories')->name('member.main_categories');
	Route::get('howitworks', 		'MemberController@howitworks')->name('member.howitworks');
	Route::get('termsofuse', 		'MemberController@termsofuse')->name('member.termsofuse');
	Route::get('privacypolicy', 	'MemberController@privacypolicy')->name('member.privacypolicy');
	Route::get('faqs', 				'MemberController@faqs')->name('member.faqs');
	Route::get('location', 			'MemberController@location')->name('member.location');

	// Login
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// Registration
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');

	// Forgot Password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

	// Reset Password
	// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
	
	// message
	Route::match(['get', 'post'], 'message', 	'MessageController@index')->name('member.message.index');

	// category
	Route::get('category/{category}', 			'CategoryController@index')->name('member.category.index');

	Route::match(['get', 'post'], 'search', 	'CategoryController@search')->name('member.category.search');	

	// product
	Route::get('product/{product}', 			'ProductController@index')->name('member.product.index');
	
	// product owner
	Route::get('product/detail/owner/{id}', 			'ProductController@owner')->name('member.product.owner');
		
	Route::group(['middleware' => ['auth', 'member', 'check_status']], function(){
		Route::get('home', 			'HomeController@home')->name('home');
		
		// Profile
		Route::get('profile/{id}',	'ProfileController@index')->name('member.profile.index');
		Route::get('profile/change/{id}', 	'ProfileController@update')->name('member.profile.update');
		// setting
   		Route::post('profile/change/setting/{id}', 	'ProfileController@setting')->name('member.profile.setting');
   		// change password
   		Route::post('profile/change/password/{id}', 'ProfileController@password')->name('member.profile.password');
   		// change foto profile
		Route::post('profile/change/avatar/{id}', 	'ProfileController@avatar')->name('member.profile.avatar');
		// change bank
		Route::post('profile/change/bank/{id}', 	'ProfileController@bank')->name('member.profile.bank');
		// change bank
		Route::post('profile/change/identity_card/{id}', 	'ProfileController@identity_card')->name('member.profile.identity_card');

		// report
		Route::post('product/report', 'ReportController@store')->name('member.report.store');

		// booking
		Route::post('product/booking', 'BookingController@store')->name('member.booking.store');

		// history
		Route::get('history',					'HistoryController@index')->name('member.history.index');
		Route::get('history/detail/{id}',		'HistoryController@show')->name('member.history.show');
		Route::post('history/detail/request', 	'HistoryController@request')->name('member.history.request');
		Route::post('history/detail/cancel', 	'HistoryController@cancel')->name('member.history.cancel');

		// transaction
		Route::get('transaction', 					'TransactionController@index')->name('member.transaction.index');
		Route::post('transaction/add', 				'TransactionController@store')->name('member.transaction.store');
		Route::get('transaction/detail/{id}',		'TransactionController@show')->name('member.transaction.show');
		Route::match(['get', 'post'], 'transaction/detail/pdf/{id}',	'TransactionController@getPdf')->name('member.transaction.getPdf');
		Route::post('transaction/detail/payment_confirmation/{id}', 	'TransactionController@payment_confirmation')->name('member.transaction.payment_confirmation');
		Route::post('transaction/detail/guaranty/{id}', 				'TransactionController@guaranty')->name('member.transaction.guaranty');
		Route::post('transaction/detail/confirm_address', 				'TransactionController@confirm_address')->name('member.transaction.confirm_address');
		Route::post('transaction/detail/rating', 						'TransactionController@rating')->name('member.transaction.rating');

		// Delivery
		Route::get('delivery',					'DeliveryController@index')->name('member.delivery.index');
		Route::get('delivery/detail/{id}',		'DeliveryController@show')->name('member.delivery.show');
		Route::post('delivery/detail/arrived',	'DeliveryController@arrived')->name('member.delivery.arrived');

		// Reversion
		Route::get('reversion',						'ReversionController@index')->name('member.reversion.index');
		Route::get('reversion/detail/{id}',			'ReversionController@show')->name('member.reversion.show');
		Route::post('reversion/detail/reversion', 	'ReversionController@reversion')->name('member.reversion.reversion');

		//rating
		Route::post('product/rating/add', 	'RatingController@store')->name('member.rating.store');

		// refund
		Route::get('refund',				'RefundController@index')->name('member.refund.index');
		Route::get('refund/detail/{id}',	'RefundController@show')->name('member.refund.show');

		// location
		Route::match(['get', 'post'], 'location_product', 'LocationController@index')->name('member.location.index');

		//mae
		Route::get('mae', 'MaeController@index')->name('member.mae.index');

		// story
		Route::get('story', 'StoryController@index')->name('member.story.index');
	});
});

/**
 * Routing Owner
 */
Route::prefix('owner')->namespace('Owner')->group(function () {
	Route::get('test', "HomeController@test");

	Route::match(['get','post'],'mail_confirmation/{link}', "UserController@email_confirmation")->name('owner.mail_confirmation');
	
	Route::middleware(['auth:owner', 'owner'])->group(function (){
    	Route::get('user/unconfirm/{action?}', 	"UserController@unconfirm")->name('owner.user.unconfirm');
    	Route::get('user/not_active', 			"UserController@not_active")->name('owner.user.not_active');
    });

	// Login
	Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('owner.login');
	Route::post('logout',	'Auth\LoginController@logout')->name('owner.logout');

	// Registration
	Route::match(['get', 'post'], 'register', 'Auth\RegisterController@register')->name('owner.register');

	// Forgot Password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('owner.password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('owner.password.email');

	// Reset Password
	// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('owner.password.reset');
	// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
	
	Route::group(['middleware' => ['auth:owner', 'owner', 'check_status']], function(){
		Route::get('/', 'HomeController@index')->name('owner.home.index');

		// profile
   		Route::get('{id}/profile', 	'HomeController@profile')->name('owner.home.profile');
   		// setting
   		Route::post('profile/{id}/setting', 	'HomeController@setting')->name('owner.home.setting');
   		// change password
   		Route::post('profile/{id}/password', 	'HomeController@password')->name('owner.home.password');
   		// change foto profile
		Route::post('profile/{id}/avatar', 		'HomeController@avatar')->name('owner.home.avatar');
		// change identity card
		Route::post('profile/{id}/identity_card', 		'HomeController@identity_card')->name('owner.home.identity_card');   		

   		// bank
   		Route::match(['get', 'post'], 'bank', 	'BankController@index')->name('owner.bank.index');
   		Route::post('bank/add',					'BankController@store')->name('owner.bank.store');
   		Route::put('bank/{bank}',				'BankController@update')->name('owner.bank.update');
   		Route::delete('bank/{bank}',			'BankController@destroy')->name('owner.bank.destroy');

   		// product
   		Route::match(['get', 'post'], 'product',	'ProductController@index')->name('owner.product.index');
   		Route::match(['get', 'post'], 'product/add','ProductController@store')->name('owner.product.store');
		Route::match(['get', 'post'], 'product/update/{product} ', 	'ProductController@update')->name('owner.product.update');
   		Route::delete('product/{product}',			'ProductController@destroy')->name('owner.product.destroy');
   		Route::get('product/{product}',				'ProductController@show')->name('owner.product.show');
   		Route::post('product/upload/{product}',		'ProductController@upload')->name('owner.product.upload');
		Route::match(['get', 'post'], 'product/upload/{id}',	'ProductController@upload')->name('owner.product.upload');

		// booking
   		Route::match(['get', 'post'], 'booking', 	'BookingController@index')->name('owner.booking.index');
   		Route::get('booking/{id}',					'BookingController@show')->name('owner.booking.show');
   		Route::post('booking/approve', 				'BookingController@approve')->name('owner.booking.approve');
   		Route::post('booking/reject', 				'BookingController@reject')->name('owner.booking.reject');

   		// transaction
   		Route::match(['get', 'post'], 'transaction', 	'TransactionController@index')->name('owner.transaction.index');
   		Route::get('transaction/{id}',					'TransactionController@show')->name('owner.transaction.show');
   		Route::post('transaction/verify', 				'TransactionController@verify')->name('owner.transaction.verify');
   		Route::post('transaction/reject', 				'TransactionController@reject')->name('owner.transaction.reject');
   		Route::post('transaction/cancel', 				'TransactionController@cancel')->name('owner.transaction.cancel');

   		// payment confirmation
   		Route::match(['get', 'post'], 'payment_confirmation', 	'PaymentConfirmationController@index')->name('owner.payment_confirmation.index');
   		Route::get('payment_confirmation/{id}',					'PaymentConfirmationController@show')->name('owner.payment_confirmation.show');
   		Route::post('payment_confirmation/approve', 			'PaymentConfirmationController@approve')->name('owner.payment_confirmation.approve');

   		// Delivery
   		Route::match(['get', 'post'], 'delivery', 	'DeliveryController@index')->name('owner.delivery.index');
   		Route::get('delivery/{id}',					'DeliveryController@show')->name('owner.delivery.show');
   		Route::post('delivery/delivery',			'DeliveryController@delivery')->name('owner.delivery.delivery');

   		// Reversion
   		Route::match(['get', 'post'], 'reversion', 	'ReversionController@index')->name('owner.reversion.index');
   		Route::get('reversion/{id}',				'ReversionController@show')->name('owner.reversion.show');
   		Route::post('reversion/arrive',				'ReversionController@arrive')->name('owner.reversion.arrive');
   		Route::post('reversion/refund',				'ReversionController@refund')->name('owner.reversion.refund');

   		// Refund
   		Route::match(['get', 'post'], 'refund', 	'RefundController@index')->name('owner.refund.index');
   		Route::get('refund/{id}',					'RefundController@show')->name('owner.refund.show');
   		Route::post('refund/verify',					'RefundController@verify')->name('owner.refund.verify');

   		// cod
   		Route::match(['get', 'post'], 'cod', 		'CodController@index')->name('owner.cod.index');
   		Route::get('cod/{id}',						'CodController@show')->name('owner.cod.show');
   		Route::post('cod/verify', 					'CodController@verify')->name('owner.cod.verify');
   		Route::post('cod/reject', 					'CodController@reject')->name('owner.cod.reject');
   		Route::post('cod/cancel', 					'CodController@cancel')->name('owner.cod.cancel');
	});
});

/**
 * Routing Admin
 */
Route::prefix(env('ADMIN_PREFIX', 'admin'))->namespace('Admin')->group(function () {
	Route::match(['get', 'post'], 'login',	'Auth\LoginController@login')->name('admin.login');
	Route::post('logout', 					'Auth\LoginController@logout')->name('admin.logout');

	// Forgot Password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

	Route::group(['middleware' => ['auth:admin']], function(){
   		Route::get('/', 	'HomeController@index')->name('admin.home.index');
   		
   		// profile
   		Route::get('{id}/profile', 	'HomeController@profile')->name('admin.home.profile');
   		
   		// setting
   		Route::post('profile/{id}/setting', 	'HomeController@setting')->name('admin.home.setting');
   		
   		// change password
   		Route::post('profile/{id}/password', 	'HomeController@password')->name('admin.home.password');

   		// bank
   		Route::match(['get', 'post'], 'bank', 	'BankController@index')->name('bank.index');
   		Route::post('bank/add',					'BankController@store')->name('bank.store');
		Route::resource('bank',					'BankController', ['only' => [
						'update', 'destroy',
		]]);

		// managemen members
		Route::match(['get', 'post'], 'members', 	'MembersController@index')->name('members.index');
		Route::resource('members',					'MembersController', ['only' => [
						'update', 'show',
		]]);
		Route::post('members/not_active',				'MembersController@not_active')->name('members.not_active');
		Route::post('members/identity_card/approve', 	'MembersController@approve')->name('members.approve');
		Route::post('members/identity_card/reject', 	'MembersController@reject')->name('members.reject');

		// managemen owners
		Route::match(['get', 'post'], 'owners', 	'OwnersController@index')->name('owners.index');
		Route::resource('owners',					'OwnersController', ['only' => [
						'update', 'show', 
		]]);
		Route::post('owners/not_active',			'OwnersController@not_active')->name('owners.not_active');
		Route::post('owners/identity_card/approve', 'OwnersController@approve')->name('owners.approve');
		Route::post('owners/identity_card/reject', 	'OwnersController@reject')->name('owners.reject');

		// faq	
		Route::match(['get', 'post'], 'faq', 	'FaqController@index')->name('faq.index');
		Route::post('faq/add',					'FaqController@store')->name('faq.store');
		Route::resource('faq',					'FaqController', ['only' => [
						'update', 'destroy', 'show',
		]]);

		// message
		Route::match(['get', 'post'], 'message', 	'MessageController@index')->name('message.index');
		Route::resource('message',					'MessageController', ['only' => [
						'show',
		]]);

		// company profile
		Route::get('company_profile', 						'CompanyProfileController@index')->name('company_profile.index');
		Route::post('company_profile/add/contact', 			'CompanyProfileController@contact')->name('company_profile.contact');
   		Route::post('company_profile/add/description', 		'CompanyProfileController@description')->name('company_profile.description');
   		Route::post('company_profile/add/terms_of_use', 	'CompanyProfileController@terms_of_use')->name('company_profile.terms_of_use');
   		Route::post('company_profile/add/privacy_policy',	'CompanyProfileController@privacy_policy')->name('company_profile.privacy_policy');
   		Route::post('company_profile/add/location',			'CompanyProfileController@location')->name('company_profile.location');

   		// category
   		Route::match(['get', 'post'], 'category', 	'CategoryController@index')->name('category.index');
   		Route::post('category/add',					'CategoryController@store')->name('category.store');
		Route::resource('category',					'CategoryController', ['only' => [
						'update', 'destroy'
		]]);

		// sub_category
   		Route::match(['get', 'post'], 'sub_category', 	'SubCategoryController@index')->name('sub_category.index');
   		Route::post('sub_category/add',					'SubCategoryController@store')->name('sub_category.store');
		Route::resource('sub_category',					'SubCategoryController', ['only' => [
						'update', 'destroy'
		]]);

		// product
		Route::match(['get', 'post'], 'product', 	'ProductController@index')->name('product.index');
		Route::resource('product',					'ProductController', ['only' => [
						'update', 'show'
		]]);

		// courier
   		Route::match(['get', 'post'], 'courier',	'CourierController@index')->name('courier.index');
   		Route::post('courier/add',					'CourierController@store')->name('courier.store');
   		Route::resource('courier',					'CourierController', ['only' => [
						'update', 'destroy'
		]]);

		// payment confirmation
   		Route::match(['get', 'post'], 'payment_confirmation',	'PaymentConfirmationController@index')->name('payment_confirmation.index');
   		Route::resource('payment_confirmation',					'PaymentConfirmationController', ['only' => [
						'show'
		]]);
		Route::post('payment_confirmation/verify', 			'PaymentConfirmationController@verify')->name('payment_confirmation.verify');
		Route::post('payment_confirmation/reject', 				'PaymentConfirmationController@reject')->name('payment_confirmation.reject');

		// refund
   		Route::match(['get', 'post'], 'refund',	'RefundController@index')->name('refund.index');
   		Route::resource('refund',				'RefundController', ['only' => [
						'show'
		]]);
   		Route::post('refund/finished', 			'RefundController@finished')->name('refund.finished');

   		// transaction cod
   		Route::match(['get', 'post'], 'transaction_cod',	'CodController@index')->name('transaction_cod.index');
   		Route::resource('transaction_cod',					'CodController', ['only' => [
						'show'
		]]);

   		// transaction rekber
   		Route::match(['get', 'post'], 'transaction_rekber',	'RekberController@index')->name('transaction_rekber.index');
   		Route::resource('transaction_rekber',				'RekberController', ['only' => [
						'show'
		]]);
   	});
});
