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


})->prefix("/api/v1");