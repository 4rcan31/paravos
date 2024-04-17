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

        Route::post("/cancelar-pedido", function($request){
           controller("Store/OrdersController", "cancelOrder", $request);
        });
        
    })->middlewares(['AuthMiddleware@session']);


    Route::group(function(){

        Route::post("/category", function($request){
            controller("Admin/CategoriesController", "edit", $request);
        });

        Route::post("/product", function($request){
            res($request);
        });

    })->prefix("/edit");

    Route::group(function(){

        Route::post("/category", function($request){
            controller("Admin/CategoriesController", "create", $request);
        });

    })->prefix("/create");

    Route::group(function(){

        Route::post("/category", function($request){
            controller("Admin/CategoriesController", "delete", $request);
        });

    })->prefix("/delete");



})->prefix("/api/v1");