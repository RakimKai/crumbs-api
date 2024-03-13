<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/group/index',[GroupController::class,'getAll']);

Route::group(['middleware'=>['auth:sanctum']],function(){

    Route::group(['prefix'=>'user'],function(){
        Route::post('/logout',[UserController::class,'logout']);
        Route::post('',[UserController::class,'update']);
        Route::get('',[UserController::class,'get']);
    });

    Route::group(['prefix'=>'group'],function(){
        Route::post('',[GroupController::class,'store']);
        Route::post('/join/{id}',[GroupController::class,'join']);
        Route::get('/{id}',[GroupController::class,'get']);
        Route::delete('/{id}',[GroupController::class,'delete']);
    });
    
    Route::group(['prefix'=>'post'],function(){
        Route::post('',[PostController::class,'store']);
        Route::post('/{id}',[PostController::class,'update']);
        Route::get('/{id}',[PostController::class,'get']);
        Route::delete('/{id}',[PostController::class,'delete']);
        Route::get('/index/{id}',[PostController::class,'getAll']);
    });
});