<?php

function cardmd12(string $title, string $description, string $button = "") {
    ?>
    <div class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h4><?php echo htmlspecialchars($title) ?></h4>
                                <p><?php echo htmlspecialchars($description) ?></p>
                            </div>
                            <?php if (!empty($button)) : ?>
                                <div class="col-md-4">
                                    <a href="#" class="filled-button"><?php echo htmlspecialchars($button) ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function cardmd4($name, $img, $description, $redirection = "#")
{
    // Escapamos los caracteres especiales en la URL de redirección y la imagen
    $redirectUrl = htmlspecialchars($redirection);
    $imgSrc = htmlspecialchars($img);
    // Creamos el HTML de la carta de producto
    $html = '
    <div class="col-md-4 col-md-4">
        <div class="product-item">
            <a href="' . $redirectUrl . '"><img src="' . $imgSrc . '" alt=""></a>
            <div class="down-content">
                <a href="' . $redirectUrl . '">
                    <h4>' . htmlspecialchars($name) . '</h4>
                </a>
                <p>' . htmlspecialchars($description) . '</p>
            </div>
        </div>
    </div>';
    // Retornamos el HTML generado
    return $html;
}

?>
