<?php

Route::group(function(){

    Route::get("/home", function(){
        view("admin/home");
    });

})->prefix("/admin");