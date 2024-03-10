<?php
class users extends Migration {
    

    /* 
        Los usuarios son clientes pero con una cuenta
    */
    public function up() {
        $this->create("users", function($table) {
            $this->prepare();
            $this->query('CREATE TABLE users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL UNIQUE,
                name VARCHAR(100) NOT NULL,
                user VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                remember_token VARCHAR(255),
                phone_number VARCHAR(255) DEFAULT NULL,
                address TEXT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
            import('Encrypt/hasher.php', false, '/core');
            $this->insert('users')->values([
                'email' => 'user@test.com',
                'password' => Hasher::make('123'),
                'name' => 'User Default',
                'user' => 'User Default'
            ]);
            $this->execute();
        });
    }
        
    public function down() {
        $this->dropIfExist("users");
    }
        
}