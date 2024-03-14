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
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("home") ?>


<body>

    <?php headerBarPrincipal("home") ?>











    <div class="pt-20">

        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">

                    <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" data-lightbox="roadtrip" src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png">

                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">BRAND NAME</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Esto es un nombre xd</h1>
                        <div class="flex mb-4">

                            <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
                                <a class="text-gray-500">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                    </svg>
                                </a>
                                <a class="text-gray-500" href="https://twitter.com/">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                    </svg>
                                </a>
                                <a class="text-gray-500" href="https://google.com">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <p class="leading-relaxed">Esto es una description.</p>
                        <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                            hola y esto que choto eso?
                            sdsdsd.

                        </div>



                        <div class="flex flex-col lg:flex-row justify-between">

                            <div class="flex items-center lg:mt-0 mt-4">
                                <div class="mr-8 lg:mr-20">
                                    <p class="text-gray-600">Precio:</p>
                                    <p class="text-2xl font-medium text-gray-900">$34</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">En stock:</p>
                                    <p class="text-2xl font-medium text-gray-900">4</p>
                                </div>
                            </div>

                            <a class="flex mt-4 lg:mt-0 text-white bg-gradient-to-r from-purple-500 to-purple-600 border-0 py-2 px-6 focus:outline-none hover:bg-purple-600 rounded-md shadow-md">Comprar</a>



                        </div>




                    </div>
                </div>
            </div>
        </section>


    </div>









    <?Php scriptsPrincipal() ?>
</body>

</html>