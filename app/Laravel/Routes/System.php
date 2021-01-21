<?php

Route::get('sample', function () {
    return view('emails.collection-email');
});
/*,'domain' => env("FRONTEND_URL", "wineapp.localhost.com")*/
Route::group(['as' => "system.",
		 'namespace' => "System",
		 'middleware' => ["web"],
		 // 'domain' => env('SYSTEM_URL',''),
		 'prefix' => "admin"
		],function() {


Route::group(['as' => "auth."], function(){
		Route::get('login/{uri?}',['as' => "login",'uses' => "AuthController@login","middleware" => "system.guest"]);
		Route::post('login/{uri?}',['uses' => "AuthController@authenticate","middleware" => "system.guest"]);
		Route::get('register', [ 'as' => "register",'uses' => "AuthController@register","middleware" => "system.guest"]);
		Route::post('register', [ 'uses' => "AuthController@store","middleware" => "system.guest"]);
		Route::get('activate', [ 'as' => "activate",'uses' => "AuthController@activate","middleware" => "system.guest"]);
		Route::post('activate', [ 'uses' => "AuthController@activate_account","middleware" => "system.guest"]);
		Route::get('change-password', [ 'as' => "change_password",'uses' => "AuthController@change","middleware" => "system.guest"]);
		Route::post('change-password', [ 'uses' => "AuthController@setup_password","middleware" => "system.guest"]);
		Route::get('logout',['as' => "logout",'uses' => "AuthController@logout","middleware" => "system.auth"]);
		Route::any('get-municipalities',['as' => "get_municipalities", 'uses' => "AuthController@get_municipalities"]);
	});
	Route::group(['middleware' => "system.auth"],function(){

		Route::get('/',['as' => "dashboard",'uses' => "MainController@dashboard"]);

		Route::group(['as' => "transaction.",'prefix' => "transaction"], function(){
			Route::get('/',['as' => "index",'uses' => "TransactionController@index"]);
			Route::get('pending',['as' => "pending",'uses' => "TransactionController@pending"]);
			Route::get('ongoing',['as' => "ongoing",'uses' => "TransactionController@ongoing"]);
			Route::get('approved',['as' => "approved",'uses' => "TransactionController@approved"]);
			Route::get('declined',['as' => "declined",'uses' => "TransactionController@declined"]);
			Route::get('resent',['as' => "resent",'uses' => "TransactionController@resent"]);
			Route::get('create',['as' => "create",'uses' => "TransactionController@create"]);
			Route::post('create',['uses' => "TransactionController@store"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "TransactionController@show",'middleware' => "system.exist:transaction"]);
			Route::get('process/{id?}',['as' => "process",'uses' => "TransactionController@process",'middleware' => "system.exist:transaction"]);
			Route::get('requirements/{id?}',['as' => "requirements",'uses' => "TransactionController@process_requirements"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "TransactionController@destroy"]);
		});

		Route::group(['as' => "business_transaction.",'prefix' => "business-transaction"], function(){
			Route::get('/',['as' => "index",'uses' => "BusinessTransactionController@index"]);
			Route::get('pending',['as' => "pending",'uses' => "BusinessTransactionController@pending"]);
			Route::get('ongoing',['as' => "ongoing",'uses' => "BusinessTransactionController@ongoing"]);
			Route::get('approved',['as' => "approved",'uses' => "BusinessTransactionController@approved"]);
			Route::get('declined',['as' => "declined",'uses' => "BusinessTransactionController@declined"]);
			Route::get('resent',['as' => "resent",'uses' => "BusinessTransactionController@resent"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "BusinessTransactionController@show",'middleware' => "system.exist:business_transaction"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "BusinessTransactionController@edit",'middleware' => "system.exist:business_transaction"]);
			Route::post('update/{id?}',['as' => "update",'uses' => "BusinessTransactionController@update",'middleware' => "system.exist:business_transaction"]);
			Route::get('process/{id?}',['as' => "process",'uses' => "BusinessTransactionController@process",'middleware' => "system.exist:business_transaction"]);
			/*Route::post('bplo-approved/{id?}',['as' => "bplo_approved",'uses' => "BusinessTransactionController@bplo_approved"]);*/
			Route::post('save-collection',['as' => "save_collection",'uses' => "BusinessTransactionController@save_collection"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "BusinessTransactionController@destroy"]);
			Route::get('remarks/{id?}',['as' => "remarks",'uses' => "BusinessTransactionController@remarks",'middleware' => "system.exist:business_transaction"]);
			Route::get('validate/{id?}',['as' => "validate",'uses' => "BusinessTransactionController@bplo_validate",'middleware' => "system.exist:business_transaction"]);
			Route::get('assessment/{id?}',['as' => "assessment",'uses' => "BusinessTransactionController@assessment"]);
			Route::post('assessment/{id?}',['uses' => "BusinessTransactionController@get_assessment"]);
			Route::get('approved-assessment/{id?}',['as' => "approved_assessment",'uses' => "BusinessTransactionController@approved_assessment"]);
            Route::get('certificate/{id?}',['as' => "digital_cerficate",'uses' => "BusinessTransactionController@digital_cerficate"]);
			Route::get('update-department/{id?}',['as' => "update_department",'uses' => "BusinessTransactionController@update_department",'middleware' => "system.exist:business_transaction"]);
			Route::get('release/{id?}',['as' => "release",'uses' => "BusinessTransactionController@release",'middleware' => "system.exist:business_transaction"]);
			Route::get('read-all-notifs',['as' => "read_all_notifs",'uses' => "BusinessTransactionController@read_all_notifs"]);
			Route::get('bulk-assessment',['as' => "bulk_assessment",'uses' => "BusinessTransactionController@bulk_assessment"]);
			Route::get('bulk-decline',['as' => "bulk_decline",'uses' => "BusinessTransactionController@bulk_decline"]);
			Route::get('bulk-update',['as' => "bulk_update",'uses' => "BusinessTransactionController@bulk_update"]);

		});


		Route::group(['as' => "profile.",'prefix' => "profile"], function(){
			Route::get('/',['as' => "index",'uses' => "ProfileController@index"]);
			Route::get('edit',['as' => "edit",'uses' => "ProfileController@edit"]);
			Route::post('edit',['uses' => "ProfileController@update"]);
			Route::post('image',['as' => "image.edit",'uses' => "ProfileController@update_image"]);
			Route::get('password',['as' => "password.edit",'uses' => "ProfileController@edit_password"]);
			Route::post('password',['uses' => "ProfileController@update_password"]);
		});

		Route::group(['as' => "report.",'prefix' => "report"], function(){
			Route::get('/',['as' => "index",'uses' => "ReportController@index"]);
			Route::get('export',['as' => "export",'uses' => "ReportController@export"]);
			Route::get('pdf',['as' => "pdf",'uses' => "ReportController@pdf"]);
		});

		Route::group(['as' => "department.",'prefix' => "department"], function(){
			Route::get('/',['as' => "index",'uses' => "DepartmentController@index"]);
			Route::get('create',['as' => "create",'uses' => "DepartmentController@create"]);
			Route::post('create',['uses' => "DepartmentController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "DepartmentController@edit",'middleware' => "system.exist:department"]);
			Route::post('edit/{id?}',['uses' => "DepartmentController@update",'middleware' => "system.exist:department"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "DepartmentController@destroy",'middleware' => "system.exist:department"]);
			Route::get('upload',['as' => "upload",'uses' => "DepartmentController@upload"]);
			Route::post('upload',['uses' => "DepartmentController@upload_department"]);
		});
		Route::group(['as' => "other_customer.",'prefix' => "other-customer"], function(){
			Route::get('/',['as' => "index",'uses' => "OtherCustomerController@index"]);
			Route::get('create',['as' => "create",'uses' => "OtherCustomerController@create"]);
			Route::post('create',['uses' => "OtherCustomerController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "OtherCustomerController@edit",'middleware' => "system.exist:department"]);
			Route::post('edit/{id?}',['uses' => "OtherCustomerController@update",'middleware' => "system.exist:other_customer"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "OtherCustomerController@destroy",'middleware' => "system.exist:other_customer"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "OtherCustomerController@show",'middleware' => "system.exist:other_customer"]);
		});

		Route::group(['as' => "other_transaction.",'prefix' => "other-transaction"], function(){
			Route::get('/',['as' => "index",'uses' => "OtherTransactionController@index"]);
			Route::get('create/{id?}',['as' => "create",'uses' => "OtherTransactionController@create"]);
			Route::post('store',['as' => "store",'uses' => "OtherTransactionController@store"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "OtherTransactionController@show",'middleware' => "system.exist:other_transaction"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "OtherTransactionController@edit",'middleware' => "system.exist:other_transaction"]);
			Route::post('edit/{id?}',['uses' => "OtherTransactionController@update",'middleware' => "system.exist:other_transaction"]);
			Route::get('process/{id?}',['as' => "process",'uses' => "OtherTransactionController@process",'middleware' => "system.exist:other_transaction"]);
		});

		Route::group(['as' => "application_requirements.",'prefix' => "application-requirements"], function(){
			Route::get('/',['as' => "index",'uses' => "ApplicationRequirementController@index"]);
			Route::get('create',['as' => "create",'uses' => "ApplicationRequirementController@create"]);
			Route::post('create',['uses' => "ApplicationRequirementController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "ApplicationRequirementController@edit",'middleware' => "system.exist:requirements"]);
			Route::post('edit/{id?}',['uses' => "ApplicationRequirementController@update",'middleware' => "system.exist:requirements"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "ApplicationRequirementController@destroy",'middleware' => "system.exist:requirements"]);
			Route::get('upload',['as' => "upload",'uses' => "ApplicationRequirementController@upload"]);
			Route::post('upload',['uses' => "ApplicationRequirementController@upload_department"]);

		});

		Route::group(['as' => "regional_office.",'prefix' => "regional-office"], function(){
			Route::get('/',['as' => "index",'uses' => "RegionalOfficeController@index"]);
			Route::get('create',['as' => "create",'uses' => "RegionalOfficeController@create"]);
			Route::post('create',['uses' => "RegionalOfficeController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "RegionalOfficeController@edit",'middleware' => "system.exist:regional-office"]);
			Route::post('edit/{id?}',['uses' => "RegionalOfficeController@update",'middleware' => "system.exist:regional-office"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "RegionalOfficeController@destroy",'middleware' => "system.exist:regional-office"]);
			// Route::any('get-municipalities',['as' => "get_municipalities", 'uses' => "ZoneLocationController@get_municipalities"]);
			// Route::any('get-province',['as' => "get_provinces", 'uses' => "ZoneLocationController@get_provinces"]);
			// Route::any('get-region',['as' => "get_region", 'uses' => "ZoneLocationController@get_region"]);

		});

		Route::group(['as' => "application.",'prefix' => "application"], function(){
			Route::get('/',['as' => "index",'uses' => "ApplicationController@index"]);
			Route::get('create',['as' => "create",'uses' => "ApplicationController@create"]);
			Route::post('create',['uses' => "ApplicationController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "ApplicationController@edit",'middleware' => "system.exist:application"]);
			Route::post('edit/{id?}',['uses' => "ApplicationController@update",'middleware' => "system.exist:application"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "ApplicationController@destroy",'middleware' => "system.exist:application"]);
        });

        Route::group(['as' => "collection_fees.",'prefix' => "collection-of-fees"], function(){
			Route::get('/',['as' => "index",'uses' => "CollectionOfFeesController@index"]);
            Route::get('create',['as' => "create",'uses' => "CollectionOfFeesController@create"]);
            Route::post('create',['uses' => "CollectionOfFeesController@store"]);
            Route::get('edit/{id?}',['as' => "edit",'uses' => "CollectionOfFeesController@edit"]);
			Route::post('edit/{id?}',['uses' => "CollectionOfFeesController@update"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "CollectionOfFeesController@destroy"]);
        });


        Route::group(['as' => "bplo.",'prefix' => "bplo"], function(){
			Route::get('/',['as' => "index",'uses' => "BPLOController@index"]);
            Route::get('create',['as' => "create",'uses' => "BPLOController@create"]);
            Route::post('create',['uses' => "BPLOController@store"]);
            Route::get('edit/{id?}',['as' => "edit",'uses' => "BPLOController@edit"]);
			Route::post('edit/{id?}',['uses' => "BPLOController@update"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "BPLOController@destroy"]);
		});

		Route::group(['as' => "holiday.",'prefix' => "holiday"], function(){
			Route::get('/',['as' => "index",'uses' => "HolidayController@index"]);
            Route::get('create',['as' => "create",'uses' => "HolidayController@create"]);
            Route::post('create',['uses' => "HolidayController@store"]);
            Route::get('edit/{id?}',['as' => "edit",'uses' => "HolidayController@edit",'middleware' => "system.exist:holiday"]);
			Route::post('edit/{id?}',['uses' => "HolidayController@update",'middleware' => "system.exist:holiday"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "HolidayController@destroy",'middleware' => "system.exist:holiday"]);
		});

		Route::group(['as' => "processor.",'prefix' => "processor"], function(){
			Route::get('/',['as' => "index",'uses' => "ProcessorController@index"]);
			Route::get('create',['as' => "create",'uses' => "ProcessorController@create"]);
			Route::post('create',['uses' => "ProcessorController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "ProcessorController@edit",'middleware' => "system.exist:processor"]);
			Route::post('edit/{id?}',['uses' => "ProcessorController@update",'middleware' => "system.exist:processor"]);
			Route::get('reset/{id?}',['as' => "reset",'uses' => "ProcessorController@reset",'middleware' => "system.exist:processor"]);
			Route::post('reset/{id?}',['uses' => "ProcessorController@update_password",'middleware' => "system.exist:processor"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "ProcessorController@destroy",'middleware' => "system.exist:processor"]);
			Route::get('list',['as' => "list",'uses' => "ProcessorController@list"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "ProcessorController@show"]);
        });

        Route::group(['as' => "business_cv.",'prefix' => "business-cv"], function(){
			Route::get('/',['as' => "index",'uses' => "BusinessCVController@index"]);
            Route::get('create',['as' => "create",'uses' => "BusinessCVController@create"]);
            Route::post('create',['uses' => "BusinessCVController@store"]);
            Route::get('update-status/{id}',['as'=> 'update_status', 'uses' => "BusinessCVController@update_status"]);
            Route::get('show/{id}',['as'=> 'show', 'uses' => "BusinessCVController@show"]);
            Route::get('edit/{id?}',['as' => "edit",'uses' => "BusinessCVController@edit"]);
			Route::post('edit/{id?}',['uses' => "BusinessCVController@update"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "BusinessCVController@destroy"]);
		});
	});




});
