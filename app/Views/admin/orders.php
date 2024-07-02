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
//prettyPrint($table); die;

//config de la tabla
$crud = new Crud($table);
$crud->setColumnsShowInTable(
    'name_delivery',
    'reference',
    'address',
    'approved_shipping',
    'payment_status',
    'tracking_number',
    'shipping_date',
    'delivery_time',
    'product_name',
    'product_image',
    'product_price',
    'notes',
    'payment_method',
    'order_email',
    'user_email',
    'user_is_client',
    'order_phone',
    'created_at'
);

$crud->setViewDataColumnsTable("partners");
$crud->setColumnForNumberRows();



//config de la imagen
$crud->loadIn(
    'product_image',
    '<img src="{{element}}" alt="Imagen de producto" class="img-thumbnail" style="max-width: 100px;">'
);

$crud->loadIn(
    "approved_shipping",
    "{{element}}",
    [
        [
            'if' => '$row["approved_shipping"] == 0',
            'then' => 'Orden no aprobada'
        ],
        [
            'if' => '$row["approved_shipping"] == 1',
            'then' => 'Orden Aprobada'
        ]
    ]
);


//Renderizado de botones
$crud->setViewAllRowTheTableOriginalInModal();
$crud->setCreateButton(
   "Creando un nuevo partner",
   "/api/v1/create/partner",
   true
);
$crud->setEditButton(
   "Editar",
   "/api/v1/edit/partner",
   "Editanto el partner ",
   true
);
$crud->setCancelButton(
    "Eliminar",
    "/api/v1/delete/partner",
    "Seguro que deseas eliminar el partner ",
    []
);
$crud->addColumWithRedirectionButton("Activar", "Aprobar pedido", "/admin/partner/{{id}}");

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