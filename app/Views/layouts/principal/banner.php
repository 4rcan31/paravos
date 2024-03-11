<?Php


function bannerPrincipal()
{
?>

    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
            <?php newItem("Titulo", "sub titulo", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
            <?php newItem("Titulo2", "sub titulo", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
            <?php newItem("Titulo2", "sub titulo", "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png") ?>
        </div>
    </div>
<?Php
}


function newItem($title, $subTitle, $url = "#")
{
?>
    <div class="banner-item" data-bg-image="<?php echo htmlspecialchars($url) ?>">
        <div class="text-content">
            <h4><?php echo htmlspecialchars($subTitle) ?></h4>
            <h2><?php echo htmlspecialchars($title) ?></h2>
        </div>
    </div>
<?php
}


function bannerStatic($title, $subTitle, $img)
{
?>
    <div class="page-heading header-text"  data-bg-image="<?php echo htmlspecialchars($img) ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4><?php echo htmlspecialchars($subTitle) ?></h4>
                        <h2><?php echo htmlspecialchars($title) ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
