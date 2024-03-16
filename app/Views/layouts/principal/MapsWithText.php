<?php

function MapsWithText(string $ubication, string $title, string $description, array $socialMedia){
    ?> 
    
    <div class="col-md-8">
            <!-- How to change your own map point
              1. Go to Google Maps
              2. Click on your location point
              3. Click "Share" and choose "Embed map" tab
              4. Copy only URL and paste it within the src="" field below
            -->
            <div id="map">
              <iframe src="<?php echo $ubication ?>" width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-md-4">
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
