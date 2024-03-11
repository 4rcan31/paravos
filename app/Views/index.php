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
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("home") ?>

<body>
    <?php headerBarPrincipal("home") ?>

    <?php bannerPrincipal() ?>



    <!-- Aca se tienen que llamar los ultimos 6 productos publicados nada mas -->
    <div class="latest-products">
        <div class="container">
            <div class="row">

                <?php sectionHeading("Ultimos productos", "Ver todos los productos", route("/products", false)) ?>

                <?php
                product("Audifonos", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png", "Son audifnos", "45.5");
                product("hahkasjkasj", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png", "Son audifnos", "45.5");
                ?>

            </div>
        </div>
    </div>


    <div class="best-features">
        <div class="container">
            <div class="row">
                <?php sectionHeading("Fectures") ?>
                <?php features(); ?>
            </div>
        </div>
    </div>
    

    <?Php cardmd12("Titulo card", "Description", "Boton") ?>
    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>
</body>

</html>