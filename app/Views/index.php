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
$data = ViewData::get();
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
                foreach($data as $product){
                    $product = arrayToObject($product);
                    product(
                        $product->name,
                        $product->url_img,
                        $product->description_short,
                        $product->price,
                        $product->category_id,
                        route("/show/".$product->id, false)
                    );
                }
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