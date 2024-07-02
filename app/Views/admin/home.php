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

$table = [
    "columns" => ["id", "name", "age", "email", "city"],
    "rows" => [
        ["id" => 1, "name" => "John", "age" => 25, "email" => "john@example.com", "city" => "New York"],
        ["id" => 2, "name" => "Emma", "age" => 30, "email" => "emma@example.com", "city" => "Los Angeles"],
        ["id" => 3, "name" => "Michael", "age" => 28, "email" => "michael@example.com", "city" => "Chicago"],
        ["id" => 4, "name" => "Sophia", "age" => 22, "email" => "sophia@example.com", "city" => "Houston"],
        ["id" => 5, "name" => "William", "age" => 35, "email" => "william@example.com", "city" => "Miami"]
    ]
];
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






                    <?Php

                    /* 
                    CRUD:
                    create: no
                    READ: Listo
                    Update: Listo
                    Delete: Listo


                        //read all
                          $crud = new Crud($allTable, $columsShowInTable <- por defecto todas)
                        //read all just row
                        $crud->setViewAllData() : mostrar toda la data de la fila


                          /update
                          $crud->setEditButton(arrar $columnsToEdit, string $action) : abrir modal para editar
                          
                          /delete
                          $crud->setDeleteButton(bool $justDesactive = false, string $column = "") : eliminar la fila, o desactivarla en el caso que este configurado asi (mostrar un modal de coonfirmacion)

                          //create
                          $crud->setCreateButton(array $columnsNeedsToCreate)

                    */
                        $crud = new Crud($table);
                        $crud->setColumnsShowInTable('id', 'name');
                        $crud->setViewDataColumnsTable("Esto es un titulo");
                        $crud->setViewAllRowTheTableOriginalInModal();
                        $crud->setEditButton(
                            "Editar", "action"
                        );
                        $crud->setCancelButton("Cancelar", "/action", "Seguro que deseas eliminar al usuario {{name}}", []);
                        $crud->setCreateButton("Titulo del modal", "/action", false);
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