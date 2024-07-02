<?php
layout("admin/HeaderAdmin");
layout("admin/ScriptsAdmin");
layout("admin/Components");
layout("admin/Footer");
layout("admin/Logout");
layout("admin/Sidebar");
layout("admin/Topbar");
layout("principal/Modal");
layout("admin/Crud");
$data = ViewData::get();
$table = $data['table'];
?>


<!DOCTYPE html>
<html lang="en">

<?php headPanel('Home') ?>

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
                    $crud = new Crud($table);
                    $crud->setColumnsShowInTable('name');
                    $crud->setViewDataColumnsTable("Categorias");
                    $crud->setColumnForNumberRows();
                    $crud->setViewAllRowTheTableOriginalInModal();
                    $crud->setEditButton(
                        "Editar",
                        "/api/v1/edit/category"
                    );
                    $crud->setCancelButton(
                        "Eliminar",
                        "/api/v1/delete/category",
                        "Seguro que deseas eliminar al usuario {{name}}",
                        []
                    );
                    $crud->setCreateButton(
                        "Titulo del modal",
                        "/api/v1/create/category",
                        false
                    );
                    $crud->build();
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