<?php


Route::root(function($request){ // localhost:8080/
   controller("ViewsStore", "home");
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


