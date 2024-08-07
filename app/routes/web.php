<?php


Route::root(function(){ // localhost:8080/
    controller("Views/HomeViewController", "show");
});


Route::get("/products/%pages", function($request){
    controller("Views/ProductsViewController", "products", $request);
});


//Esto en realidad no deberia de hacerce de esta forma
//pero es que el enrutador ya es demasiado complejo como para estarlo
// tocando 
Route::get("/products", function(){
    Redirect::to("/products/1");
});

Route::get("/show/%id", function($request){
    controller("Views/ShowProductViewController", "show", $request);
});

Route::get("/show", function($request){
   Redirect::to("/products/1");
});


Route::get("/partner/%id", function($request){
    controller("Views/ShowPartnerViewController", "show", $request);
});

Route::get("/partner", function(){
    Redirect::to("/aboutus");
});


Route::get("/aboutus", function(){
    controller("Views/AboutusController", "view");
});

Route::get('/contact', function(){
    view('contact');
});


Route::get("/login", function(){
    view('login');
});

Route::get("/register", function(){
    view("register");
});

Route::group(function(){

    Route::get("/home", function(){
        view("admin/home");
    });

    Route::get("/categories", function(){
        controller("Views/Admin/CategoriesViewController", 'show');
    });

    Route::get("/products", function(){
        controller("Views/Admin/ProductsViewController", 'show');
    });

    Route::get("/partners", function(){
        controller("Views/Admin/PartnersViewController", "show");
    });

    Route::get("/partner/%id", function($request){
        controller("Views/Admin/ShowProductsByPartners", "show", $request);
    });

    Route::get("/users", function(){
        controller("Views/Admin/UsersViewController", "show");
    });

    Route::get("/orders", function(){
        controller("Views/Admin/OrdersViewController", "show");
    });

})->prefix("/admin")->middlewares(['AuthMiddleware@sessionAsAdmin']);

/* 
    Esto esta bien raro, ya que con php -S localhost functiona, pero
    en apache creo que no funciona como deberia xd
*/
Route::get("/profile", function(){
    controller("Views/ProfileViewController", "show");
})->middlewares(['AuthMiddleware@sessionAsUser']);


Route::get('/orders', function(){
    controller("Views/OrdersCardViewController", 'show');
})->middlewares(['AuthMiddleware@sessionAsUser']);

Route::get("/hola", function($request){
    view("index");
});

Route::error(403, function(){
    Redirect::to("/");
});