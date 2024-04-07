<?php
/* 

    Iconos: https://fontawesome.com/v5/search?o=r&m=free
*/

function sidebar(){
    ?>  
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> 
        <?php
        headSideBar();
        divider();
        HeadingNavItem('Estadisticas');
        navItem('DashBoard', 'fas fa-fw fa-tachometer-alt', 'admin/home');
        divider();
        HeadingNavItem('Tienda');
        navItem('Ordenes', 'fas fa-truck', '/panel/store');
        navItem('Productos', 'fas fa-shopping-bag', '/panel/store');
        navItem('Categorias', 'fas fa-tags', '/panel/store');

        divider();
        HeadingNavItem('Parners');
        navItem('Parners', 'fas fa-fw fa-users', '/panel/store');


        divider();
        HeadingNavItem('Usuarios');
        navItem('Usuarios', 'fas fa-fw fa-user-friends', '/panel/store');


        /* collapse("app name", 'Administración:', [
            'Dashboard' => 'panel/croquette',
            'jskdjskdj' => 'panel/croquette',
        ], 'fas fa-fw fa-dog');
        
        divider();
        HeadingNavItem('Utilidades');
        navItem(
            'Ordenes',
            'fas fa-fw fa-cash-register',
            'panel/orders'
        );
        navItem('Tienda', 'fas fa-fw fa-store', '/panel/store');
        navItem('ORdenes', 'fas fa-fw fa-store', '/panel/store');
        navItem('Logs', 'fas fa-fw fa-list', '/panel/logs');
        navItem('Configuracion', 'fas fa-fw fa-wrench', '/panel/settings');
        navItem('Profile', 'fas fa-fw fa-user', '/panel/profile');
        navItem('Estado Server', 'fas fa-fw fa-server', 'panel/statusservices');
        navItem('FAQ', 'fas fa-fw fa-question', 'panel/faq');
        navItem('doctemplate', 'fas fa-fw fa-test', 'panel/template'); */
        sidebarToggler();
        //sidebarMessage('Conecta a croquette', 'BOTON', 'TES');
        ?> 
    </ul> 
    <?php
}



function headSideBar(){
?>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php route('/panel/dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Para vos</div>
    </a>
<?php
}

function divider($more = ''){
    ?> <hr class="sidebar-divider <?php echo $more ?>"> <?php
}

function navItem($tiitle, $icon, $route, $active = ''){
    ?> 
          <li class="nav-item <?php echo $active ?>">
                <a class="nav-link" href="<?php route($route) ?>">
                    <i class="<?php echo $icon ?>"></i>
                    <span><?php echo $tiitle ?></span></a>
            </li>
    <?php
}

function HeadingNavItem($name){
    ?> 
    <div class="sidebar-heading">
        <?php echo $name ?>
    </div>
    <?php
}

function collapse($name, $subName, $links, $ico, $id = 1){
    $id = str_replace(' ', '', $name).token(10).$id;
?>
    <li class="nav-item">
        <a class="nav-link collapsed d-flex justify-content-between align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#<?php echo $id ?>"
            aria-expanded="false" aria-controls="<?php echo $id ?>">
            <div>
                <i class="<?php echo $ico ?>"></i>
                <span><?php echo $name ?></span>
            </div>
            <i class="fas fa-chevron-right"></i> <!-- Icono de colapsado/expandido al final -->
        </a>
        <div id="<?php echo $id ?>" class="collapse" aria-labelledby="<?php echo $id ?>">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo $subName ?></h6>
                <?php foreach($links as $name => $toRoute): ?>
                    <a class="collapse-item" href="<?php route($toRoute) ?>"><?php echo $name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </li>
<?php
}






function collapse2($name, $subName, $links, $ico, $id = 1){
    $id = str_replace(' ', '', $name).token(10).$id;
 ?> 
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $id ?>"
                    aria-expanded="true" aria-controls="<?php echo $id ?>">
                    <i class="<?php echo $ico ?>"></i>
                    <span><?php echo $name ?></span>
                </a>
                <div id="<?php echo $id ?>" class="collapse" aria-labelledby="<?php echo $id ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"><?php echo $subName ?></h6>
                        <?php foreach($links as $name => $toRoute): ?>
                            <a class="collapse-item" href="<?php route($toRoute) ?>"><?php echo $name ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>
 <?php
}

function sidebarToggler(){
    ?>  
    <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
    <?php
}

function sidebarMessage($message, $button, $link){
    ?> 
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?php echo routePublic('assets/images/panel/undraw_rocket.svg') ?>" alt="...">
                <p class="text-center mb-2"><?php echo $message ?></p>
                <a class="btn btn-success btn-sm" href="<?php echo $link ?>"><?php echo $button ?></a>
            </div>
    <?php
}


