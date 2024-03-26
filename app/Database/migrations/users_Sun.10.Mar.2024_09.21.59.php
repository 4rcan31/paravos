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
                email VARCHAR(255) NOT NULL UNIQUE, -- el email igual con un unknow@random.com cuando is_cliente sea true
                name VARCHAR(100) NOT NULL,
                user VARCHAR(255) NOT NULL,
                is_client BOOLEAN DEFAULT FALSE,
                password VARCHAR(255) NOT NULL, -- esto se creara con una contrasena ramdon
                remember_token VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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