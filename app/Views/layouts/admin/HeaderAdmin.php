<?php


function headPanel($title){
?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo $title ?></title>
        <?php requiresStaticFiles([
            routePublic('vendor/fontawesome-free/css/all.min.css'),
            routePublic('assets/css/sb-admin-2.min.css'),
            routePublic('vendor/datatables/dataTables.bootstrap5.css'),
        ]) ?>
    </head>
<?php
}
