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
