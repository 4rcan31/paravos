<?php
class staff extends Migration {
        
    public function up() {
        $this->create("staff", function($table) {
            $this->prepare();
            $this->query('CREATE TABLE staff (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL UNIQUE,
                name VARCHAR(100) NOT NULL,
                user VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                remember_token VARCHAR(255),
                phone_number VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
            import('Encrypt/hasher.php', false, '/core');
            $this->insert('staff')->values([
                'email' => 'Admin@test.com',
                'password' => Hasher::make('123'),
                'name' => 'Staff Default',
                'user' => 'Staff Default'
            ]);
            $this->execute();
        });
    }
        
    public function down() {
        $this->dropIfExist("staff");
    }
        
}