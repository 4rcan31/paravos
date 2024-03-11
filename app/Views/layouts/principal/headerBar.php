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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
                        <li class="nav-item <?php echo $currentPage === 'about' ? 'active' : ''; ?>">
                            <a class="nav-link" href="about.html">About Us</a>
                        </li>
                        <li class="nav-item <?php echo $currentPage === 'contact' ? 'active' : ''; ?>">
                            <a class="nav-link" href="contact.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php
}
?>

