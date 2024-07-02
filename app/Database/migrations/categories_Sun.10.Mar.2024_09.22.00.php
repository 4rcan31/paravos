<?php

class categories extends Migration{
    public function up(){
        $this->create("categories", function ($table) {
            $this->query('CREATE TABLE categories (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');

            $this->prepare();
            $this->insert('categories')->values([
                'id' => '1',
                'name' => "Electronicos",
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('categories')->values([
                'id' => '2',
                'name' => "Ropa",
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('categories')->values([
                'id' => '3',
                'name' => "Hogar",
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('categories')->values([
                'id' => '4',
                'name' => "Alimentos",
            ]);
            $this->execute();
        });
    }

    public function down(){
        $this->dropIfExist("categories");
    }
}

