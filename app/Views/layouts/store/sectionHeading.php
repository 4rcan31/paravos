<?php

function sectionHeading($title, $button = "", $redirection = "#"){
    ?>
    <div class="col-md-12">
        <div class="section-heading">
            <h2><?php echo htmlspecialchars($title) ?></h2>
            <?php if (!empty($button)) : ?>
                <a href="<?php echo htmlspecialchars($redirection) ?>"><?php echo htmlspecialchars($button) ?> <i class="fa fa-angle-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>
