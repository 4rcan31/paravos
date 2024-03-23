<?php



function scriptsPrincipal(){
  echo requiresStaticFiles([
    routePublic('vendor/jquery/jquery.min.js'),
    routePublic('vendor/bootstrap/js/bootstrap.bundle.min.js'),
    routePublic("assets/js/store.js"),
    routePublic('vendor/owl/owl.js'),
    routePublic('vendor/slick/slick.js'),   
    routePublic('vendor/isotope/isotope.js'),   
    routePublic('vendor/accordions/accordions.js'),   
  ]);
  Form::print(); 
  Form::setValuesInputs();
  Form::destroyData();
}