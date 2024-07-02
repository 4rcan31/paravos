<?php

class phones extends Migration {
        
    public function up() {
        $this->create("phones", function($table) {
            $this->query('CREATE TABLE phones (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT,
                is_principal BOOLEAN DEFAULT FALSE,
                number_phone VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )');


            $this->prepare();
            $this->insert("phones")->values([
                "user_id" => 1,
                "is_principal" => true,
                "number_phone" => "7737-3234"
            ]); 
            $this->execute();
        });
    }
        
    public function down() {
        $this->dropIfExist("phones");
    }
        
}
