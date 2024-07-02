<?php
layout("principal/head");
layout("principal/headerBar");
layout("principal/scripts");
layout("principal/banner");
layout("store/sectionHeading");
layout("store/product");
layout("store/features");
layout("store/cards");
layout("store/footer");
layout("principal/ImageWithText");
layout("principal/MapsWithText");
layout("principal/Maps");
$data = ViewData::get();


?>



<!DOCTYPE html>
<html>
<?php headPrincipal("contact") ?>

<body>
    <?php headerBarPrincipal("contact");

    $latitude = 57.633791;
    $longitude = 92.795435;
    
    ?>

    <?php bannerStatic("Contactanos", "Sobre nosotros", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>


    <div class="best-features about-features">
        <div class="container">
            <div class="row">
                <?php sectionHeading("Estas leyendo sobre: ".$data->name) ?>
                <?php imageWithText(
                    $data->img,
                    $data->name,
                    $data->description,
                    [] //por el momento sin redes xd
                ); ?>


            </div>

   


        </div>
    </div>

    

    <div class="find-us">
        <div class="container">
            <div class="row">
                <?php sectionHeading("Nuestra ubicacion") ?>
                <?Php MapsWithText(
                    generateGoogleMapsURI($data->latitude, $data->longitude)) ?>
            </div>
        </div>
    </div>


    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>


</body>

</html>