<?php



function scriptsPrincipal(){
  echo requiresStaticFiles([
    routePublic('vendor/jquery/jquery.min.js'),
    routePublic('vendor/bootstrap/js/bootstrap.bundle.min.js'),
    routePublic('vendor/datatables/dataTables.js'),
    routePublic('vendor/datatables/dataTables.bootstrap5.js'),
    routePublic('vendor/datatables/dataTables.responsive.js'),
    routePublic('vendor/datatables/responsive.bootstrap5.js'),
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