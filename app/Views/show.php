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
layout("store/ProductShow");
layout("principal/Modal");
$data = ViewData::get();
?>



<!DOCTYPE html>
<html>
<?php headPrincipal("Producto") ?>


<body>

    <?php headerBarPrincipal("Producto") ?>











    <?php
    $productData = [
        "image" => "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
        "descriptions" => [
            "short" => "Esto es una descripcion corta",
            "large" => "Esto es una descripcion larga xd"
        ],
        "button" => [
            "order" => [
                "string" => "Ordenar",
            ]
        ],
        "category" => "Esto es la categoria",
        "name" => "Esto es el nombre",
        "price" => "344",
        "stock" => "3"
    ];
    br(3);
    
    $dataUser = ($data['user']['data']);

    //prettyPrint($dataUser);

  

   // prettyPrint($dataUser->id);



    
    
    $modal = new Modal("Orden", route("/api/v1/order", false));
    $form = $modal->input("Nombre completo*", 'name', $dataUser->row->name ?? "");
    $form .= $modal->input("Correo electrónico", "email", $dataUser->row->email ?? "");
    $form .= $modal->input("Número de teléfono*", "phoneNumber", $dataUser->phones->principal->number_phone ?? "");
    $form .= $modal->input("Dirección de entrega*", "addressDelivery", $dataUser->address->principal->address_line ?? "");
    $form .= $modal->input("Referencia", "reference");
    $form .= $modal->input("Fecha de entrega*", "deliveryDate", "", "date");
    $form .= $modal->input("Hora aproximada de entrega*", "deliveryTime", "", "time");
    $form .= $modal->input("Cantidad*", "amount", "1", "number");
    $form .= $modal->textarea("Comentario", "comment", "");
    $form .= '<input type="hidden" name="idProduct" value="' . htmlspecialchars($data['id']) . '">';
    $form .= TokenCsrf::getInput();




    $modal->setHtmlToRender($form);
    $data['button']['order']['modalId'] = $modal->getId();

    $productShow = new ProductShow($data);
    $productShow->render();
    $modal->render();
    ?>


    <?Php scriptsPrincipal() ?>
</body>

</html>