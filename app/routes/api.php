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




    //Edits
    Route::post("/edit/category", function($request){
        controller("Admin/CategoriesController", "edit", $request);
    });

    Route::post("/edit/product", function($request){
        controller("Admin/ProductsController", "edit", $request);
    });

    Route::post("/edit/partner", function($request){
        controller("Admin/PartnersController", "edit", $request);
    });

    Route::post("/edit/user", function($request){
        controller("Admin/UserController", "edit", $request);
    });


    //creates
    Route::post("/create/category", function($request){
        controller("Admin/CategoriesController", "create", $request);
    });

    Route::post("/create/product", function($request){
        controller("Admin/ProductsController", "create", $request);
    });

    Route::post("/create/partner", function($request){
        controller("Admin/PartnersController", "create", $request);
    });

    Route::post("/create/user", function($request){
        controller("Admin/UserController", "create", $request);
    });




    //deletes
    Route::post("/delete/category", function($request){
        controller("Admin/CategoriesController", "delete", $request);
    });

    Route::post("/delete/product", function($request){
        controller("Admin/ProductsController", "delete", $request);
    });

    Route::post("/delete/partner", function($request){
        controller("Admin/PartnersController", "delete", $request);
    });

})->prefix("/api/v1");