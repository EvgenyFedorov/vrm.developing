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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', 'HomeController@index')->name('home');

Route::post('/api/auth', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/access-denied', 'User\\UserController@accessDenied')->name('home');

Route::group(array('prefix' => '/', 'middleware' => 'auth'), function (){

    Route::get('/', [
        'uses' => 'User\\Partner\\CabinetUsersController@redirect',
        'middleware' => 'auth'
    ]);

    Route::group(array('prefix' => 'logs', 'middleware' => 'auth'), function (){

        Route::get('', [
            'uses' => 'User\\Partner\\CabinetLogsController@index',
            'middleware' => 'auth'
        ]);

        Route::group(array('prefix' => 'create', 'middleware' => 'auth'), function (){

            Route::get('', [
                'uses' => 'User\\Partner\\CabinetLogsController@create',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'store', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetLogsController@store',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'update', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::post('', [
                    'uses' => 'User\\Partner\\CabinetLogsController@update',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'enable', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetLogsController@enableLog',
                'middleware' => 'auth'
            ]);

        });

    });


    Route::group(array('prefix' => 'users', 'middleware' => 'auth'), function (){

        Route::get('', [
            'uses' => 'User\\Partner\\CabinetUsersController@index',
            'middleware' => 'auth'
        ]);

        Route::group(array('prefix' => 'create', 'middleware' => 'auth'), function (){

            Route::get('', [
                'uses' => 'User\\Partner\\CabinetUsersController@create',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'store', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetUsersController@store',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'edit', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::get('', [
                    'uses' => 'User\\Partner\\CabinetUsersController@edit',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'update', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::post('', [
                    'uses' => 'User\\Partner\\CabinetUsersController@update',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'enable', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetUsersController@enableUser',
                'middleware' => 'auth'
            ]);

        });

    });

    Route::group(array('prefix' => 'mobiles', 'middleware' => 'auth'), function (){

        Route::get('', [
            'uses' => 'User\\Partner\\CabinetMobilesController@index',
            'middleware' => 'auth'
        ]);

        Route::group(array('prefix' => 'create', 'middleware' => 'auth'), function (){

            Route::get('', [
                'uses' => 'User\\Partner\\CabinetMobilesController@create',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'store', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetMobilesController@store',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'edit', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::get('', [
                    'uses' => 'User\\Partner\\CabinetMobilesController@edit',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'update', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::post('', [
                    'uses' => 'User\\Partner\\CabinetMobilesController@update',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'enable', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetMobilesController@enableProgram',
                'middleware' => 'auth'
            ]);

        });

    });

    Route::group(array('prefix' => 'films', 'middleware' => 'auth'), function (){

        Route::get('', [
            'uses' => 'User\\Partner\\CabinetFilmsController@index',
            'middleware' => 'auth'
        ]);

        Route::group(array('prefix' => 'create', 'middleware' => 'auth'), function (){

            Route::get('', [
                'uses' => 'User\\Partner\\CabinetFilmsController@create',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'store', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetFilmsController@store',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'edit', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::get('', [
                    'uses' => 'User\\Partner\\CabinetFilmsController@edit',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'update', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::post('', [
                    'uses' => 'User\\Partner\\CabinetFilmsController@update',
                    'middleware' => 'auth'
                ]);

            });

        });

    });

    Route::group(array('prefix' => 'seances', 'middleware' => 'auth'), function (){

        Route::get('', [
            'uses' => 'User\\Partner\\CabinetSeancesController@index',
            'middleware' => 'auth'
        ]);

        Route::group(array('prefix' => 'create', 'middleware' => 'auth'), function (){

            Route::get('', [
                'uses' => 'User\\Partner\\CabinetSeancesController@create',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'store', 'middleware' => 'auth'), function (){

            Route::post('', [
                'uses' => 'User\\Partner\\CabinetSeancesController@store',
                'middleware' => 'auth'
            ]);

        });

        Route::group(array('prefix' => 'edit', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::get('', [
                    'uses' => 'User\\Partner\\CabinetSeancesController@edit',
                    'middleware' => 'auth'
                ]);

            });

        });

        Route::group(array('prefix' => 'update', 'middleware' => 'auth'), function (){

            Route::group(array('prefix' => '{id}', 'middleware' => 'auth'), function (){

                Route::post('play', [
                    'uses' => 'User\\Partner\\CabinetSeancesController@updatePlay',
                    'middleware' => 'auth'
                ]);

                Route::post('pause', [
                    'uses' => 'User\\Partner\\CabinetSeancesController@updatePause',
                    'middleware' => 'auth'
                ]);

            });

        });

    });

});
