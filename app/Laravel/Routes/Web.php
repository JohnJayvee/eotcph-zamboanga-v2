<?php

/*,'domain' => env("FRONTEND_URL", "wineapp.localhost.com")*/
Route::group(['as' => "web.",
		 'namespace' => "Web",
		 // 'domain' => env('SYSTEM_URL',''),
		],function() {


	Route::group(['prefix'=> "/",'as' => 'main.' ],function(){
        Route::get('/', [ 'as' => "index",'uses' => "MainController@index"]);
    });
	Route::get('coming-soon',['as' => "coming_soon",'uses' => "MainController@soon"]);
	Route::get('type',['as' => "get_application_type",'uses' => "MainController@get_application_type"]);
	Route::get('amount',['as' => "get_payment_fee",'uses' => "MainController@get_payment_fee"]);
	Route::get('collection',['as' => "get_collection_fee",'uses' => "MainController@get_collection_fee"]);
	Route::get('requirements',['as' => "get_requirements",'uses' => "MainController@get_requirements"]);
	Route::get('requirements_two',['as' => "get_requirements_two",'uses' => "MainController@get_requirements_two"]);
	Route::get('contact-us',['as' => "contact",'uses' => "MainController@contact"]);
	Route::any('logout',['as' => "logout",'uses' => "AuthController@destroy"]);

	Route::group(['middleware' => ["web","portal.guest"]], function(){
		Route::get('activate',['as' => "activate",'uses' => "AuthController@activate"]);
		Route::get('login/{redirect_uri?}',['as' => "login",'uses' => "AuthController@login"]);
        Route::post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
		Route::get('verify/{id?}',['as' => "verify",'uses' => "AuthController@verify"]);
        Route::post('verify/{id?}',['uses' => "AuthController@verified"]);

    /*  Route::get('forgot-password',['as' => "forgot_password",'uses' => "AuthController@forgot_pass"]);
        Route::post('change-password',['as' => "change_password",'uses' => "AuthController@change_password"]);*/
		Route::group(['prefix'=> "register",'as' => 'register.' ],function(){
            Route::get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
            Route::post('/', [ 'uses' => "AuthController@store"]);

            Route::get('/otp', [ 'as' => "otp", 'uses' => "AuthController@otpform"]);
            Route::post('/otp', [ 'as' => "otp", 'uses' => "AuthController@sendOTP"]);
            Route::post('/otp-submit', [ 'as' => "otp_submit", 'uses' => "AuthController@otp_submit"]);
        });
        Route::group(['prefix'=> "password",'as' => 'password.' ],function(){
            Route::get('email', ['as' => 'sendEmail', 'uses' => "AuthController@reset_mail_form"]);
            Route::post('reset-link', ['uses' => "AuthController@reset_email"]);
            Route::get('reset', ['uses' => "AuthController@reset_password_form"]);
            Route::post('reset', [ 'as' => "reset_password",'uses' => "AuthController@reset_password"]);
        });
	});

	Route::group(['middleware' => ["web","portal.auth"]], function(){

		Route::group(['as' => "profile.",'prefix' => "profile"], function(){
			Route::get('/',['as' => "index",'uses' => "ProfileController@index"]);
			Route::get('edit',['as' => "edit",'uses' => "ProfileController@edit"]);
			Route::post('edit',['uses' => "ProfileController@update"]);
			Route::post('image',['as' => "image.edit",'uses' => "ProfileController@update_image"]);
			Route::get('password',['as' => "password.edit",'uses' => "ProfileController@edit_password"]);
			Route::post('password',['uses' => "ProfileController@update_password"]);
		});

		Route::group(['prefix' => "transaction", 'as' => "transaction."], function () {
			Route::get('history',['as' => "history", 'uses' => "CustomerTransactionController@history"]);
			Route::get('ctc-history',['as' => "ctc_history", 'uses' => "CustomerTransactionController@ctc_history"]);
			Route::get('payment/{code?}',['as' => "payment", 'uses' => "CustomerTransactionController@payment"]);
			Route::get('show/{id?}',['as' => "show", 'uses' => "CustomerTransactionController@show"]);
			Route::get('ctc-show/{id?}',['as' => "ctc_show", 'uses' => "CustomerTransactionController@ctc_show"]);
			Route::get('create',['as' => "create", 'uses' => "CustomerTransactionController@create"]);
			Route::post('create',['uses' => "CustomerTransactionController@store"]);
			Route::post('other-store',['as' => "other_store", 'uses' => "CustomerTransactionController@other_store"]);
        });

        Route::group(['prefix' => "business", 'as' => "business."], function () {
			Route::get('/',['as' => "index",'uses' => "BusinessController@index"]);
			Route::get('create',['as' => "create",'uses' => "BusinessController@create"]);
			Route::post('create',['uses' => "BusinessController@store"]);
            Route::get('profile/{id?}',['as' => "profile",'uses' => "BusinessController@business_profile"]);
            Route::get('edit',['as' => "edit",'uses' => "BusinessController@business_edit"]);
			Route::post('edit',['as' => "update",'uses' => "BusinessController@business_update"]);
			Route::get('history/{id?}',['as' => "history",'uses' => "BusinessController@history"]);
            Route::get('application',['as' => "application",'uses' => "BusinessController@application"]);
            Route::get('delete/{id?}',['as' => "delete",'uses' => "BusinessController@delete", 'middleware' => "portal.exist:business"]);
            Route::group(['prefix' => "application", 'as' => "application."], function () {
                Route::get('create',['as' => "create",'uses' => "ApplicationController@create"]);
                Route::post('create',['uses' => "ApplicationController@store"]);

                Route::group(['as' => "business_permit.",'prefix' => "business-permit"],function(){
                    Route::get('/',['as' => "create",'uses' => "BusinessPermitController@create"]);
                    Route::post('/',['uses' => "BusinessPermitController@store"]);
                });

            });

        });
        Route::group(['prefix' => "business-payment", 'as' => "business_payment."], function () {
            Route::get('/{id?}',['as' => "index",'uses' => "BusinessPaymentController@index"]);
            Route::get('regulatory-payment/{id?}',['as' => "regulatory_payment", 'uses' => "BusinessPaymentController@regulatory_payment"]);
            Route::get('tax-fee/{id?}',['as' => "tax_fee", 'uses' => "BusinessPaymentController@tax_fee"]);
        	Route::get('payment/{id?}',['as' => "payment", 'uses' => "BusinessPaymentController@payment"]);
            Route::get('download/{id?}',['as' => "download_assessment",'uses' => "BusinessPaymentController@download_assessment"]);

        });
	});

	Route::get('pay/{code?}',['as' => "pay", 'uses' => "CustomerTransactionController@pay"]);
	Route::get('confirmation/{code?}',['as' => "confirmation",'uses' => "MainController@confirmation"]);
	Route::get('upload/{code?}',['as' => "upload",'uses' => "CustomerTransactionController@upload"]);
	Route::post('upload/{code?}',['uses' => "CustomerTransactionController@store_documents"]);
	Route::get('request-eor/{code?}',['as' => "request-eor", 'uses' => "CustomerTransactionController@request_eor"]);
	Route::get('show-pdf/{id?}',['as' => "show-pdf", 'uses' => "CustomerTransactionController@show_pdf"]);
	Route::get('physical-copy/{id?}',['as' => "physical-copy", 'uses' => "CustomerTransactionController@physical_pdf"]);
	Route::get('certificate/{id?}',['as' => "certificate", 'uses' => "CustomerTransactionController@certificate"]);
	Route::get('e-permit/{id?}',['as' => "e_permit",'uses' => "BusinessController@e_permit"]);
	Route::get('e-permit-view/{id?}',['as' => "e_permit_view",'uses' => "BusinessController@e_permit_view"]);


	Route::group(['prefix' => "digipep",'as' => "digipep."],function(){
		Route::any('success/{code}',['as' => "success",'uses' => "DigipepController@success"]);
		Route::any('cancel/{code}',['as' => "cancel",'uses' => "DigipepController@cancel"]);
		Route::any('failed/{code}',['as' => "failed",'uses' => "DigipepController@failed"]);
	});

		// Route::group(['prefix'=> "register",'as' => 'register.' ],function(){
  //           Route::get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
  //           Route::post('/', [ 'uses' => "AuthController@store"]);
	 //     });

        // Route::post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
        // Route::get('forgot-password',['as' => "forgot_password",'uses' => "AuthController@forgot_pass"]);
        // Route::post('change-password',['as' => "change_password",'uses' => "AuthController@change_password"]);

		// $this->group(['prefix'=> "register",'as' => 'register.' ],function(){
  //           $this->get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
  //           $this->post('/', [ 'uses' => "AuthController@store"]);
  //           $this->get('revert', [ 'as' => "revert",'uses' => "AuthController@revert"]);
  //       });



});
