<?php
layout("admin/HeaderAdmin");
layout("admin/ScriptsAdmin");
layout("admin/Components");
layout("admin/Footer");
layout("admin/Logout");
layout("admin/Sidebar");
layout("admin/Topbar");

layout("admin/Crud");
$data = ViewData::get();
$table = $data['table'];
//config de la tabla
$crud = new Crud($table);
$crud->setColumnsShowInTable(
   'email',
   'name',
   'user',
   'is_client',
   'created_at',
   'updated_at',
); 
$crud->setViewDataColumnsTable("Usuarios");
$crud->setColumnForNumberRows();



//Config del boton edit y create
$crud->setLessInputInCreateButton([
    'updated_at', 'created_at', 'is_client', 'user' //son los inputs que no quiero poner
]);

$crud->addOneMoreInputInCreateModal([
    "label" => "password",
    "name" => "password",
    "type" => "password"
]);

$crud->addOneMoreInputInCreateModal([
    "label" => "Confirmacion de password",
    "name" => "password_confirm",
    "type" => "password"
]);

$crud->addOneMoreInputInCreateModal([
    "label" => "user",
    "name" => "user"
]);
//Renderizado de botones
$crud->setViewAllRowTheTableOriginalInModal();
$crud->setCreateButton(
   "Creando un nuevo producto",
   "/api/v1/create/user",
   false
);
$crud->setEditButton(
   "Editar",
   "/api/v1/edit/user",
   "Editanto el usuario {{email}}"
);
$crud->setCancelButton(
    "Desactivar",
    "/api/v1/delete/user",
    "Seguro que deseas desactivar al usuario {{email}}",
    [],
    'Desactivando',
    "Desactivar"
);
$crud->build();
?>


<!DOCTYPE html>
<html lang="en">

<?php headPanel('Products') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php sidebar(); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php topBar(); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                        $crud->render();
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php footerPanel(); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <?php scrollToTopButton() ?>

    <!-- Logout Modal-->
    <?php modalLogout() ?>

    <?php scriptsPanel() ?>
    <?php $crud->dataTable()->redenderPaginationTableAfterLoadScriptJs(); ?>

</body>

</html>