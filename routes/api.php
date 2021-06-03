<?php

use Illuminate\Http\Request;
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


// user login route
Route::post('/user/login',['uses'=>'Api\LoginController@login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' =>'auth:api','namespace' => 'Api'], function () {
 

    // categories 
    Route::post('/create/category','CategoryController@store');
    Route::get('/get/categories','CategoryController@getCategories');
    Route::get('delete/category/{task_id}','CategoryController@Delete');

    // product 
    Route::post('/create/product','ProductController@store');
    Route::get('/get/products','ProductController@getProducts');
    Route::get('/get/single/{id}','ProductController@getSingleproduct');

    // GET Trending

    Route::get('/get/trending','ProductController@getTrendingproduct');

    // search Route

    Route::post('/search','SearchController@search');

});
