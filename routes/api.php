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

Route::post('/auth','AuthenticateController@authenticate');

Route::middleware(['jwt.auth'])->group(function(){
    Route::prefix('schools')->group(function(){
   
        Route::post('/', 'SchoolController@create');
        Route::post('/{id}/subscribe', 'SchoolController@subscribe');
        // Route::post('/{id}/subscriptions', 'SchoolController@subscribe');
    
        Route::post('/{id}/unsubscribe', 'SchoolController@unsubscribe');
        
    
        Route::post('/{id}/posts', 'SchoolController@createPost');
    
    });
    
    Route::prefix('/subscribed-schools')->group(function(){
        Route::get('/', 'SubscriptionController@index');
    });
    
    Route::get('posts','PostController@index');
        
});
