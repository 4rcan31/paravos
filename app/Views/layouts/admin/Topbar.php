<?php
function topBar(){
    ?> <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"> <?php
        buttonResponsive();
        topbarSearch();
        ?>  <ul class="navbar-nav ml-auto"> <?php
            searchDropdownXS();
            ?> <li class="nav-item dropdown no-arrow mx-1"> <?php
                NumNotifications(2);
                ?> <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown"> <?php
                    dropDownHeader('Alert center');
                    newAlert('December', "Esto es una alerta", 'warn');
                    newAlert("tes time", 'Esto es una prueba en monedas', 'money');
                ?> </div> <?php
            ?> </li> <?php
            dividerTopBar();
            userInformation("name", "avatar", 
                            route('panel/profile', false),
                            route('panel/settings', false),
                            route('panel/logs', false));
        ?>  </ul> <?php
    ?> </nav> <?php
}



function buttonResponsive(){
    ?> 
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
    <?php
}


function topbarSearch(){
    ?> 
                         <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
    <?php
}

function searchDropdownXS(){
    ?> 
                       <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

    <?php
}


function NumNotifications($num){
    ?>
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter"><?php echo $num ?>+</span>
        </a>
    <?php
}

function dropDownHeader($title){
    ?>
        <h6 class="dropdown-header">
            <?php echo $title ?>
        </h6>
    <?php
}


function newAlert($tiitle, $message, $ico, $redirecto = '#'){
    $ico2 = 'bg-primary';
    $typeIcons = [
        'document' => 'fas fa-file-alt text-white',
        'money' => 'fas fa-donate text-white',
        'warn' => 'fas fa-exclamation-triangle text-white'
    ];
    isset($typeIcons[$ico]) ? $ico = $typeIcons[$ico] : $ico = $ico;
    if($ico == 'warn'){
        $ico2 = 'bg-warning';
    }else if($ico == "money"){
        $ico2 = 'bg-success';
    }
    ?>
    <a class="dropdown-item d-flex align-items-center" href="<?php echo $redirecto ?>">
        <div class="mr-3">
            <div class="icon-circle <?php echo $ico2 ?>">
                <i class="<?php echo $ico; ?>"></i>
            </div>
        </div>
        <div>
            <div class="small text-gray-500"><?php echo $tiitle ?></div>
            <span class="font-weight-bold"><?php echo $message ?></span>
        </div>
    </a>
    <?php
}



function numMessage($num){
    ?>
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
        <span class="badge badge-danger badge-counter"><?php echo $num ?></span>
    </a>
    <?php
}

function newMessage($message, $time, $route, $redirecto = '#'){
    ?> 
     <a class="dropdown-item d-flex align-items-center" href="<?php echo $redirecto ?>">
            <div class="dropdown-list-image mr-3">
                <img class="rounded-circle" src="<?php echo routePublic($route) ?>"
                    alt="...">
                <div class="status-indicator bg-success"></div>
            </div>
            <div class="font-weight-bold">
                <div class="text-truncate"><?php echo $message ?></div>
                <div class="small text-gray-500"><?php echo $time ?></div>
            </div>
        </a>
    <?php
}


// TODO: en el futuro pone run avatar en la base de datos para admin
function userInformation($nameUser, $avatar, $profileLInk, $settisLink, $logLink, $logoutLink = '#'){
    ?> 
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div style="text-align: center;">
                <img class="img-profile rounded-circle mb-2" src="<?php echo "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png" ?>" alt="Profile Picture">
                <span class="d-block text-gray-600 small"><?php echo $nameUser ?></span>
            </div>
        </a>
        <!-- Dropdown - User Information -->
        <ul class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="<?php echo $profileLInk ?>">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a></li>
            <li><a class="dropdown-item" href="<?php echo $settisLink ?>">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Settings
            </a></li>
            <li><a class="dropdown-item" href="<?php echo $logLink ?>">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                Activity Log
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo $logoutLink ?>" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a></li>
        </ul>
    </li>
    <?php
}






function dividerTopBar(){
    ?>    <div class="topbar-divider d-none d-sm-block"></div> <?php
}
/* function navItemAlert($numNotifactions, $tiitle, $data){
    ?>  
    <li class="nav-item dropdown no-arrow mx-1"> 
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><?php echo $numNotifactions ?>+</span>
                            </a>
    <?php
        listNavItemAlert($tiitle, $data);
    ?> </li> <?php
}


function listNavItemAlert($tiitle, $data){
    $typeIcons = [
        'document' => 'fas fa-file-alt text-white',
        'money' => 'fas fa-donate text-white',
        'warning' => 'fas fa-exclamation-triangle text-white'
    ];
    ?> 
                               <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    <?php echo $tiitle ?>
                                </h6>
                                <?php foreach($data as $items): ?>
                                <a class="dropdown-item d-flex align-items-center" href="<?php $items[3] ?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="<?php echo $typeIcons[$items[2]] ?>"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo $items[0]; ?></div>
                                        <span class="font-weight-bold"><?php echo $items[1] ?></span>
                                    </div>
                                </a>
                                <?php endforeach; ?>
    <?php
}

function showAll($message, $redirecto = "#"){
 ?> 
    <a class="dropdown-item text-center small text-gray-500" href="<?php echo $redirecto ?>"><?php echo $message ?></a> 
  </div>
 <?php
} */