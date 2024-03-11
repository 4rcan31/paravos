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
?>
