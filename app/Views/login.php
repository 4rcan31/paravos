<?php
layout("principal/head");
layout("principal/headerBar");
layout("principal/scripts");
layout("principal/banner");
layout("store/sectionHeading");
layout("store/product");
layout("store/features");
layout("store/cards");
layout("store/footer");
layout("store/CategoriesApp");
layout("principal/MapsWithText");
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("login") ?>

<body class="bg-gray-100"> 

    <?php headerBarPrincipal("login") ?>

    <div class="flex items-center justify-center min-h-screen px-4"> 
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6"> 
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Iniciar Sesión</h2>
            <form action="<?php route("/api/v1/login") ?>" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                    <input type="text" id="username" name="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 py-2 px-3"> <!-- Aumentamos la altura del input y ajustamos el espaciado vertical -->
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-10 py-2 px-3"> <!-- Aumentamos la altura del input y ajustamos el espaciado vertical -->
                </div>
                <?php TokenCsrf::input(); ?>
                <div class="flex items-center justify-between"> 
                    <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 transition duration-200">Iniciar Sesión</button>
                </div>
            </form>
            <div class="mt-6 text-sm text-center"> 
                <p class="text-gray-600">¿No tienes una cuenta?</p>
                <a href="#" class="block mt-2 text-indigo-600 hover:text-indigo-800 transition duration-300">Registrarse</a>
                <div class="mt-4 border-t border-gray-200 pt-4">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-800 transition duration-300">¿Olvidaste tu contraseña?</a> 
                </div>
            </div>

        </div>
    </div>

    <?php footerStore(); ?>

    <?Php scriptsPrincipal() ?>

</body>

</html>

