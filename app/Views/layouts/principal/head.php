<?php


function headPrincipal($title){
    ?> 
       <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

        <title><?php echo $title ?></title>
        <?php requiresStaticFiles([
            routePublic('vendor/tailwind/tailwind.min.css'),
            routePublic('vendor/bootstrap/css/bootstrap.min.css'),
            routePublic('assets/fonts/fontawesome.css'),
            routePublic('assets/css/store.css'),
            routePublic('vendor/owl/owl.css'),
        ]);   requireCore(); ?>
       </head> 
    <?php
}