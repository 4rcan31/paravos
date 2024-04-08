<?php




function scriptsPanel(){
  echo requiresStaticFiles([
    routePublic('vendor/jquery/jquery.min.js'),
    routePublic('vendor/bootstrap/js/bootstrap.bundle.min.js'),
    routePublic('vendor/jquery-easing/jquery.easing.min.js'),
    routePublic('assets/js/sb-admin-2.min.js'),
    routePublic('vendor/chart.js/Chart.min.js'),
    routePublic('assets/js/demo/chart-area-demo.js'),
    routePublic('assets/js/demo/chart-pie-demo.js'),
    routePublic('vendor/datatables/jquery.dataTables.min.js'),
    routePublic('vendor/datatables/dataTables.bootstrap4.min.js')
  ]);
  Form::print(); 
  Form::setValuesInputs();
  Form::destroyData();
}
