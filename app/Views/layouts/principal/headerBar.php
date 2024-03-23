<?php
function headerBarPrincipal($currentPage)
{
?>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo route("/", false) ?>">
                    <h2>Para <em>Vos</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?php echo route("/", false) ?>">Home</a>
                        </li>
                        <li class="nav-item <?php echo $currentPage === 'products' ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?php echo route("/products", false) ?>">Productos</a>
                        </li>
                        <li class="nav-item <?php echo $currentPage === 'aboutus' ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?php echo route("/aboutus", false) ?>">About Us</a>
                        </li>
                        <li class="nav-item <?php echo $currentPage === 'contact' ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?php echo route("/contact", false) ?>">Contact Us</a>
                        </li>

                        <!-- Nuevo elemento para el perfil del usuario -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> <?php echo Sauth::exitsClientAutheticated() ? 'Perfil' : 'Login'; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if (Sauth::exitsClientAutheticated()) : ?>
                                    <a class="dropdown-item" href="<?php echo route("/myaccount", false) ?>">Mi Cuenta</a>
                                    <a class="dropdown-item" href="<?php echo route("/cart", false) ?>">Carrito</a>
                                    <a class="dropdown-item" href="<?php echo route("api/v1/logout/user", false) ?>">Cerrar Sesión</a>
                                <?php else : ?>
                                    <a class="dropdown-item" href="<?php echo route("/login", false) ?>">Login</a>
                                    <a class="dropdown-item" href="<?php echo route("/register", false) ?>">Register</a>
                                    <a class="dropdown-item" href="<?php echo route("/forgotpassword", false) ?>">Olvidé mi Contraseña</a>
                                <?php endif; ?>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php
}
?>
