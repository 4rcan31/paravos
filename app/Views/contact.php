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
layout("store/CategoriesApp");
layout("principal/MapsWithText");
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("contact") ?>

<body>
    <?php headerBarPrincipal("contact") ?>

    <?php bannerStatic("Contactanos", "Sobre nosotros", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>


    <div class="find-us">
        <div class="container">
            <div class="row">
                <?php sectionHeading("Nuestra ubicacion") ?>
                <?Php MapsWithText("ubicationlink", "titulo", "description", [
                    'facebook' => "test"
                ]) ?>


            </div>
        </div>
    </div>


    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>


</body>

</html>