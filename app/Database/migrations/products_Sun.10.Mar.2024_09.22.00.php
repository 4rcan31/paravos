<?php

class products extends Migration{

    public function up(){
        $this->create("products", function ($table) {
            $this->query('CREATE TABLE products (
                id INT PRIMARY KEY AUTO_INCREMENT,
                category_id INT,
                partners_id INT,
                name VARCHAR(255) NOT NULL,
                description_large TEXT,
                description_short TEXT,
                url_img TEXT,
                stock INT DEFAULT 1,
                price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id),
                FOREIGN KEY (partners_id) REFERENCES partners(id)
            )');

            // Productos de la categoría "Electronicos"
            $this->prepare();
            $this->insert('products')->values([
                'name' => "Samsung Galaxy S21 Ultra",
                'partners_id' => 1,
                'description_large' => "El último smartphone de gama alta de Samsung con una cámara potente y pantalla impresionante.",
                'description_short' => "Smartphone Samsung Galaxy S21 Ultra",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 1199,
                'stock' => 15,
                'category_id' => 1
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('products')->values([
                'name' => "Apple Watch Series 7",
                'partners_id' => 1,
                'description_large' => "El último modelo de reloj inteligente de Apple con nuevas funciones de salud y fitness.",
                'description_short' => "Apple Watch Series 7",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 399,
                'stock' => 20,
                'category_id' => 1
            ]);
            $this->execute();

            // Productos de la categoría "Ropa"
            $this->prepare();
            $this->insert('products')->values([
                'name' => "Levi's 501 Original Fit Jeans",
                'partners_id' => 1,
                'description_large' => "Los jeans icónicos de Levi's con un ajuste clásico y duradero.",
                'description_short' => "Jeans Levi's 501 Original Fit",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 59.99,
                'stock' => 30,
                'category_id' => 2
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('products')->values([
                'name' => "Nike Air Force 1",
                'partners_id' => 1,
                'description_large' => "Zapatillas clásicas de Nike con estilo versátil y comodidad duradera.",
                'description_short' => "Zapatillas Nike Air Force 1",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 90,
                'stock' => 25,
                'category_id' => 2
            ]);
            $this->execute();

            // Productos de la categoría "Hogar"
            $this->prepare();
            $this->insert('products')->values([
                'name' => "KitchenAid Artisan Stand Mixer",
                'partners_id' => 1,
                'description_large' => "Batidora de pie KitchenAid Artisan con diseño elegante y potencia excepcional para tus recetas.",
                'description_short' => "Batidora KitchenAid Artisan",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 399,
                'stock' => 10,
                'category_id' => 3
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('products')->values([
                'name' => "Dyson V11 Absolute Vacuum Cleaner",
                'partners_id' => 1,
                'description_large' => "Aspiradora sin cable Dyson V11 Absolute con succión potente y tecnología inteligente.",
                'description_short' => "Aspiradora Dyson V11 Absolute",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 699,
                'stock' => 8,
                'category_id' => 3
            ]);
            $this->execute();

            // Productos de la categoría "Alimentos"
            $this->prepare();
            $this->insert('products')->values([
                'name' => "Nutella Hazelnut Spread",
                'partners_id' => 1,
                'description_large' => "Untable de avellanas Nutella con sabor dulce y delicioso para disfrutar en cualquier momento.",
                'description_short' => "Nutella Untable de Avellanas",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 3.99,
                'stock' => 40,
                'category_id' => 4
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('products')->values([
                'name' => "McCormick Gourmet Organic Cinnamon",
                'partners_id' => 1,
                'description_large' => "Canela orgánica de McCormick Gourmet para dar sabor y aroma a tus platos favoritos.",
                'description_short' => "Canela McCormick Gourmet",
                'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                'price' => 4.99,
                'stock' => 35,
                'category_id' => 4
            ]);
            $this->execute();
        });
    }

    public function down(){
        $this->dropIfExist("products");
    }
}
