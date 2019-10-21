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
use Illuminate\Support\Facades\Auth;



//Old
Route::post("login","Api\AuthController@login");
Route::post("register","Api\AuthController@register");
Route::post("social_auth","Api\Auth\SocialAuthController@socialAuth");

// Route::post("register","Api\Auth\RegisterController@register");
// Route::post("login","Api\Auth\LoginController@login");

Route::get("clients/stakeholder","Api\StakeholderController@index");
    
// Route::get("clients/users",function(){
//     dd(Auth::user()->name);
// })->middleware("auth:api");

Route::resource("category","Api\CategoryController");
Route::resource("card","Api\CardController");
Route::get("{title}/category","Api\CategoryController@getCategoryTitle");
Route::resource("subcategory","Api\SubcategoryController");
Route::get("filter/{slug}","Api\SubcategoryController@getFilter");

Route::get('/push',"Api\ToolController@sendPush");
Route::get('/push2',"Api\ToolController@sendPush2");


Route::middleware(['auth:api'])->group(function () {
    Route::get('/order',"Api\OrderController@index");
    Route::post('/order',"Api\OrderController@store");
    Route::put('/order/{id}',"Api\OrderController@update");
    Route::put('/payment/{id}',"Api\OrderController@payment");

    Route::get('/order-supplier',"Api\OrderController@orderSupplier");

    Route::get('/order/detail/{order_id}',"Api\OrderController@getOrderDetail");

    Route::get('/photos',"Api\ProductController@getPhotos");
    
    Route::get('/photos/{stakeholder}',"Api\ProductController@getPhotosStakeholder");

    Route::get('/user',"Api\UserController@index");
    Route::post('/google',"Api\UserController@refreshToken");
    Route::post('/user/update-photo',"Api\UserController@updatePhoto");
    Route::put('/user',"Api\UserController@update");
    Route::patch('/user/{id}',"Api\UserController@updateName");

    Route::resource("product","Api\ProductController");
    Route::get("product-stakeholder/{id}/{subcategory_id}","Api\ProductController@getProductStakeholder");
    Route::get("product-stakeholder","Api\ProductController@getProductStakeholderAll");
    

    Route::resource("comment","Api\CommentController");    
    Route::get("comment-stakeholder/{id}","Api\CommentController@getCommentStakeholder");

    Route::resource("stakeholder","Api\StakeholderController");

    Route::put("stakeholder/{id}/description","Api\StakeholderController@editDescription");

    Route::post('/upload-photo',"Api\StakeholderController@updatePhoto");
    Route::get("stakeholder/{category_id}/editAll","Api\StakeholderController@editAll");
    Route::patch("like-stakeholder/{id}","Api\StakeholderController@likeStakeholder");

    Route::get("study","Api\StakeholderInfoExtraController@getStudies");
    Route::post("study","Api\StakeholderInfoExtraController@storeStudy");
    Route::put("study-experience/{id}","Api\StakeholderInfoExtraController@update");

    Route::get("experience","Api\StakeholderInfoExtraController@getExperience");
    Route::post("experience","Api\StakeholderInfoExtraController@storeExperience");
});

