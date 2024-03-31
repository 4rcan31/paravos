<?php


Route::group(function(){

    Route::post('/login', function ($request) {
        controller("Auth/Login", "login", $request);
    });

    Route::get("/logout/%type", function($request){
        controller("Auth/Login", "logout", $request);
    });

    Route::post("/order", function($request){
       controller("Store/OrdersController", 'makeOrder', $request);
    });

    Route::post("register", function($request){
        controller("Auth/Register", "register", $request);
    });

    Route::group(function(){
        Route::post('/updateName', function ($request){
            controller("User/ProfileController", "updateName", $request);
        });

        Route::post('/updateUser', function ($request){
            controller("User/ProfileController", "updateUser", $request);
        });
        
    })->middlewares(['AuthMiddleware@session']);


})->prefix("/api/v1");