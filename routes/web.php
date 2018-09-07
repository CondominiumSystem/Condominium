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
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('Persons','PersonsController');
    Route::resource('Properties','PropertiesController');
    Route::resource('Payments','PaymentsController');
    Route::resource('Reports','ReportsController');

	Route::get('/Persons/{id}/destroy', [
					'uses' => 'PersonsController@destroy',
					'as' => 'Persons.destroy'
			]
	);
    Route::get('/Persons/{id}/properties', [
					'uses' => 'PersonsController@properties',
					'as' => 'Persons.properties'		]
	);

    Route::get('/Properties/{id}/create', [
                    'uses' => 'PropertiesController@create',
                    'as' => 'Properties.create'
            ]
    );
    Route::get('Properties/{Property}/{Person}/edit',[
        'uses' => 'PropertiesController@edit',
        'as' => 'Properties.edit'
    ]
    );
    Route::get('/Properties/{id}/destroy', [
					'uses' => 'PropertiesController@destroy',
					'as' => 'Properties.destroy'
			]
	);

    Route::get('/ReportsPayments', [
                    'uses' => 'ReportsController@getPaymentsIndex',
                    'as' => 'Reports.payments'
            ]
    );

    Route::get('/ReportsPaymentsData', [
                    'uses' => 'ReportsController@paymentsData',
                    'as' => 'Reports.paymentsData'
            ]
    );
    Route::get('/Persons/{id}/destroy', [
					'uses' => 'PersonsController@destroy',
					'as' => 'Persons.destroy'
			]
	);

    Route::get('/PortfolioReceivable', [
                    'uses' => 'ReportsController@getPortfolioReceivableIndex',
                    'as' => 'Reports.portfolioReceivable'
            ]
    );

    Route::get('/PortfolioReceivableData', [
                    'uses' => 'ReportsController@portfolioReceivableData',
                    'as' => 'Reports.portfolioReceivableData'
            ]
    );

    Route::get('/NewReportPayments', [
					'uses' => 'ReportsController@getIndex',
					'as' => 'ReportsController.getIndex'
			]
	);
    Route::get('/Cecilia', [
                    'uses' => 'CeciController@getTutorial',
                    'as' => 'CeciController.getTutorial'
            ]
    );




    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});


//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
