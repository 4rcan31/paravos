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
layout("store/ProductShow");
$data = ViewData::get();
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("home") ?>


<body>

    <?php headerBarPrincipal("home") ?>











    <?php
    $productData = [
        "image" => "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
        "descriptions" => [
            "short" => "Esto es una descripcion corta",
            "large" => "Esto es una descripcion larga xd"
        ],
        "button" => [
            "order" => [
                "string" => "nobre botom",
                "redirect" => "http://google.com"
            ]
        ],
        "category" => "Esto es la categoria",
        "name" => "Esto es el nombre",
        "price" => "344",
        "stock" => "3"
    ];

    $productShow = new ProductShow($data);
    $productShow->render();

    ?>








    <?Php scriptsPrincipal() ?>
</body>

</html>