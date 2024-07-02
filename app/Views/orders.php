<?php
layout("principal/head");
layout("principal/headerBar");
layout("principal/scripts");
layout("principal/banner");
layout("store/sectionHeading");
layout("user/OrdersViewClass");
layout("store/features");
layout("store/cards");
layout("store/footer");
layout("store/CategoriesApp");
layout("principal/DataTable");
$data = ViewData::get();
$table = arrayToObject($data['table']);
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("Perfil") ?>

<body>

    <?php headerBarPrincipal("Perfil") ?>
    <br><br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="colum-12">
                <?php
                $OrdersView = new OrdersViewClass($data);
                $OrdersView->buildTable();
                $OrdersView->render();
                /* $dataTable = new DataTable($table->columns, $table->rows);
                $idTable = $dataTable->getId();
                $dataTable->render(); */
                ?>
            </div>
        </div>
    </div>

    <?php footerStore();  ?>



    <?Php scriptsPrincipal() ?>
    <script>
        new DataTable(<?php echo json_encode("#".$OrdersView->getIdTable()) ?>, {
            responsive: true
        });
    </script>
</body>

</html>