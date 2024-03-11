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
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("home") ?>

<body>
    <?php headerBarPrincipal("products") ?>

    <?php bannerStatic("titulo", "subtitulo", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
    

    
    <?php 
        $categories = new CategoriesApp([
            "Electrónicos" => [
                [
                    "name" => "Audífonos",
                    "description" => "Audífonos de alta calidad con sonido envolvente.",
                    "img" => "http://ejemplo.com/audifonos.jpg",
                    "price" => "49.99",
                    "showpage" => "http://ejemplo.com/productos/audifonos"
                ],
                [
                    "name" => "Smartphone",
                    "description" => "Teléfono inteligente con cámara de alta resolución y procesador rápido.",
                    "img" => "http://ejemplo.com/smartphone.jpg",
                    "price" => "299.99",
                    "showpage" => "http://ejemplo.com/productos/smartphone"
                ]
            ],
            "Ropa" => [
                [
                    "name" => "Camiseta",
                    "description" => "Camiseta de algodón suave y cómoda.",
                    "img" => "http://ejemplo.com/camiseta.jpg",
                    "price" => "19.99",
                    "showpage" => "http://ejemplo.com/productos/camiseta"
                ],
                [
                    "name" => "Pantalones",
                    "description" => "Pantalones vaqueros de diseño moderno y ajuste perfecto.",
                    "img" => "http://ejemplo.com/pantalones.jpg",
                    "price" => "39.99",
                    "showpage" => "http://ejemplo.com/productos/pantalones"
                ]
            ]
        ]);
        
        $categories->build();

        echo $categories->get();
    ?>


    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>
</body>

</html>