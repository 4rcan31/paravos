<?php


Route::root(function($request){ // localhost:8080/
   view("index");
});

Route::get("/products", function(){
    view("products");
});



