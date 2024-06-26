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
layout("principal/ImageWithText");
$data = ViewData::get();
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("aboutus") ?>

<body>
    <?php headerBarPrincipal("aboutus") ?>

    <?php bannerStatic("Nuestra empresa", "Sobre nosotros", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
    

    



    <div class="best-features about-features">
        <div class="container">
            <div class="row">
            <?php sectionHeading("Parners") ?>
                <?php 
                    foreach($data['partners'] as $partners){
                        echo cardmd4(
                            $partners->name,
                            $partners->img,
                            strlen($partners->description) > $data['maxcharacters'] ? 
                            substr($partners->description, 0, $data['maxcharacters'])."..." : 
                            $partners->description,
                            route("/partner/".$partners->id, false)
                        );
                        
                    }
                ?>
            </div>
        </div>
    </div>



    <div class="best-features about-features">
        <div class="container">
            <div class="row">
            <?php sectionHeading("Nosotros") ?>
            <?php imageWithText(
                "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
                "Esto es un titulo xd",
                "Esto es la descricion bla bla bla bla bla",
                [
                    'facebook' => "http://facebook.com",
                    "google" => "test"
                ]
                ); ?>
                
               
            </div>
        </div>
    </div>

    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>


</body>

</html>