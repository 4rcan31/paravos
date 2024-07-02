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
$data = ViewData::get();
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("home") ?>

<body>
    <?php headerBarPrincipal("products") ?>

    <?php bannerStatic("titulo", "subtitulo", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
    

    
    <?php 
        $categories = new CategoriesApp($data, "/products");
        $categories->render();
    ?>


    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>


</body>

</html>