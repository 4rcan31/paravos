<?php



Jenu::command('command1', function () {
    Jenu::print("Esto es el comando 1 y fue ejecutado por el comando 2");
});


Jenu::command('command2', function ($args) {

    Jenu::print('Este es el comando 2 y sera ejecutado por el comando 3');
    Jenu::execute('command1');
    Jenu::print("El comando 2 acaba de ejecutar al comando 1");
});


Jenu::command('command3', function () {
    Jenu::print("Este es el comando 3 y ejecutara al comando 2, y el comando 2 ejecutara al comando 1");
    Jenu::execute('command2');
    Jenu::print("El comando 3 acaba de ejecutar al comando 2");
});

Jenu::command("diff", function () {
    // Definimos las columnas
    $columns = [
        "id", "product_id", "user_id", "address", "reference", "approved_shipping",
        "email", "phone", "payment_status", "tracking_number", "shipping_date",
        "delivery_time", "notes", "payment_method", "order_status", "created_at",
        "product_name", "product_description_large", "product_description_short",
        "product_image", "product_stock", "product_price", "user_email",
        "user_name", "user_username", "user_is_client", "order_email", "order_phone"
    ];

    // Definimos los datos
    $rows = [
        [
            "id" => 1, "product_id" => 2, "product_name" => "Apple Watch Series 7",
            "product_description_large" => "El último modelo de reloj inteligente de Apple con nuevas funciones de salud y fitness.",
            "product_description_short" => "Apple Watch Series 7", "product_image" => "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
            "product_stock" => 18, "product_price" => "399.00", "user_id" => 1,
            "user_email" => "user@test.com", "user_name" => "User Default",
            "user_username" => "User Default", "user_is_client" => 0, "address" => "Example City, Example State, El Salvador, plaza mundo",
            "reference" => "", "approved_shipping" => 0, "order_email" => "user@test.com",
            "order_phone" => "7737-3234", "payment_status" => "Pendiente",
            "tracking_number" => "bab8a3f6", "shipping_date" => "2024-06-20",
            "delivery_time" => "20:18:00", "notes" => NULL, "payment_method" => "Efectivo",
            "order_status" => "Pendiente", "created_at" => "2024-06-19 20:16:51"
        ]
    ];

    // Extraer las claves de la primera fila
    $rowKeys = array_keys($rows[0]);

    // Identificar las columnas que están en 'columns' pero no en las claves de las filas
    $extraColumns = array_diff($columns, $rowKeys);

    // Mostrar las columnas extra
    print_r($extraColumns);
});
