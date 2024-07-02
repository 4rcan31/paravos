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
$categories = $data['categories'];
$partners = $data['partners'];

//config de la tabla
$crud = new Crud($table);
$crud->setColumnsShowInTable(
   'name',
   'category_name',
   'price',
   'partner_name',
   'description_large',
   'description_short',
   'stock',
   'url_img'
); 
$crud->setViewDataColumnsTable("Productos de este partner");
$crud->setColumnForNumberRows();



//Config del boton edit y create
$crud->setLessInputInCreateButton([
   'category_name', 'url_img', 'partner_name' //son los inputs que no quiero poner
]);
$crud->addOneMoreInputInCreateModal([
   "label" => "Categorias*",
   'name' => "category",
   'type' => 'select',
   'input' => $categories
]);

$crud->addOneMoreInputInCreateModal([
   "label" => "Elija el partner de este producto*",
   'name' => "partner",
   'type' => 'select',
   'input' => $partners
]);


$crud->addOneMoreInputInCreateModal([
   "label" => "Imagen del producto",
   'name' => "img",
   'type' => 'file'
]);

//config de la imagen
$crud->loadIn(
    'url_img',
    '<img src="{{element}}" alt="Imagen de producto" class="img-thumbnail" style="max-width: 100px;">'
);


//Renderizado de botones
$crud->setViewAllRowTheTableOriginalInModal();
$crud->setCreateButton(
   "Creando un nuevo producto",
   "/api/v1/create/product",
   false
);
$crud->setEditButton(
   "Editar",
   "/api/v1/edit/product",
   "Editanto el producto {{name}}"
);
$crud->setCancelButton(
    "Eliminar",
    "/api/v1/delete/product",
    "Seguro que deseas eliminar al usuario {{name}}",
    []
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