<?php

/* 
    [
        facebook => "http://facebook.com
    ]

*/
function imageWithText(string $img, string $title, string $description, array $socialMedia){
?>
    <div class="col-md-6">
        <div class="right-image">
            <img src="<?php echo $img ?>" alt="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="left-content">
            <h4><?php echo $title ?></h4>
            <p><?php echo $description ?></p>
            <ul class="social-icons">
                <?php foreach($socialMedia as $name => $link): ?>
                    <li><a href="<?php echo $link ?>"><i class="fa fa-<?php echo $name ?>"></i></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php
}
