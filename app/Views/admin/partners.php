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
    'name',
    'description',
    'img',
    'latitude',
    'longitude'
 ); 
$crud->setViewDataColumnsTable("partners");
$crud->setColumnForNumberRows();


 $crud->setLessInputInCreateButton([
    'img'
 ]);

//config de la imagen
$crud->loadIn(
    'img',
    '<img src="{{element}}" alt="Imagen de partner" class="img-thumbnail" style="max-width: 100px;">'
);
$crud->addOneMoreInputInCreateModal([
    "label" => "Imagen del Socio",
    'name' => "img",
    'type' => 'file'
 ]);

//Renderizado de botones
$crud->setViewAllRowTheTableOriginalInModal();
$crud->setCreateButton(
   "Creando un nuevo partner",
   "/api/v1/create/partner",
);
$crud->setEditButton(
   "Editar",
   "/api/v1/edit/partner",
   "Editanto el partner {{name}}",
);
$crud->setCancelButton(
    "Eliminar",
    "/api/v1/delete/partner",
    "Seguro que deseas eliminar el partner {{name}}",
    []
);
$crud->addColumWithRedirectionButton("Ir a ver", "Ver productos", "/admin/partner/{{id}}");
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