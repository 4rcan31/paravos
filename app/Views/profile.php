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
layout("principal/profile");
$data = ViewData::get();
$user = $data['user'];
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("Perfil") ?>

<body>

    <?php headerBarPrincipal("Perfil") ?>

    <div class="bg-gray-100 ">
        <div class="container mx-auto py-8 ">
            <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4 mt-32">
                <div class="col-span-4 sm:col-span-3">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex flex-col items-center">
                            <!-- Aca creo que pudiera ir una imagen xd  -->
                            <h1 class="text-xl font-bold"><?php echo $user->name ?></h1>
                            <p class="text-gray-700"><?php echo $user->email ?></p>
                        </div>
                        <hr class="my-6 border-t border-gray-300">
                    </div>
                </div>



                <div class="col-span-4 sm:col-span-9">
                    <div class="bg-white shadow rounded-lg p-6">
                        <?php
                            $profile = new Profile($data);
                            $profile->emailCard();
                            $profile->name();
                            $profile->user();
                            $profile->createAcount();
                            $profile->numOrders();
                            $profile->render();
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php //footerStore(); //no entiendo por que el footer no se baja aca xd ?>

    <?Php scriptsPrincipal() ?>

</body>

</html>