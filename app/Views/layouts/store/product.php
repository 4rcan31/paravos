<?php

function product($name, $img, $description, $price, $categorie = "", $redirection = "#", $numStart = 0, $numReviews = 0) {
    $redirectUrl = htmlspecialchars($redirection);
    $priceFormatted = "$" . htmlspecialchars($price);

    $starsHtml = "";
    if ($numStart != 0) {
        $starsHtml = '<ul class="stars">';
        for ($i = 0; $i < $numStart; $i++) {
            $starsHtml .= '<li><i class="fa fa-star"></i></li>';
        }
        $starsHtml .= "</ul>";
    }

    $reviewsHtml = ($numReviews == 0) ? "" : "Reviews ($numReviews)";

    ?>

    <div class="col-md-4 col-md-4 all <?php echo $categorie ?>">
        <div class="product-item">
            <a href="<?php echo $redirectUrl ?>"><img src="<?php echo htmlspecialchars($img) ?>" alt=""></a>
            <div class="down-content">
                <a href="<?php echo $redirectUrl ?>">
                    <h4><?php echo htmlspecialchars($name) ?></h4>
                </a>
                <h6><?php echo $priceFormatted ?></h6>
                <p><?php echo htmlspecialchars($description) ?></p>
                <?php echo $starsHtml ?>
                <span><?php echo $reviewsHtml ?></span>
            </div>
        </div>
    </div>

<?php
}
?>
