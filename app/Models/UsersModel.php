<?php

class UsersModel extends BaseModel{


    public function existByEmail(string $email){
        $this->prepare(); 
        $this->select(['email'])->from('users')->where('email', $email);
        return $this->execute()->exists();
    }

    public function getByEmail($email){
        $this->prepare();
        $this->select(['*'])->from('users')->where('email', $email);
        return $this->execute()->all();
    }


    public function getById(string $id){
        $this->prepare();
        $this->select(['*'])->from('users')->where('id', $id);
        return $this->execute()->all();
    }
    
    public function getContactInfoById(string $id, string $table, bool $principal = false){
        $query = "SELECT * FROM $table WHERE user_id = ?";
        if($principal){
            $query .= ' AND is_principal = 1';
        }
        return $this->query($query, [$id])->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllById(string $id){
       return [
        "row" => $this->getById($id),
        "phones" => [
            "data" => $this->getContactInfoById($id, 'phones'),
            "principal" => $this->getContactInfoById($id, 'phones', true)[0] ?? null
        ],
        "address" => [
            "data" => $this->getContactInfoById($id, 'addresses'),
            "principal" => $this->getContactInfoById($id, 'addresses', true)[0] ?? null
        ]
       ];
    }

    public function new(string $email, string $name, string $user, bool $isClient, string $password){
        $this->prepare();
        $this->insert("users")->values([
            "email" => $email,
            "name" => $name,
            "user" => $user,
            "is_client" => $isClient,
            "password" => $password
        ]);
        return $this->execute()->lastId();
    }
    
    public function existsByEmailInUserWithAcount(string $email){
        $this->prepare();
        $this->select(['*'])->from("users")->where("email", $email)->and("is_client", false);
        return $this->execute()->exists(); 
    }

    public function updateName(string $id, string $name){
        $this->prepare();
        $this->update("users", [
            "name" => $name
        ])->where("id", $id);
        return $this->execute()->lastId();
    }

    public function updateUser(string $id, string $user){
        $this->prepare();
        $this->update("users", [
            "user" => $user
        ])->where("id", $id);
        return $this->execute()->lastId();
    }

    public function get(){
        $this->prepare();
        $this->select(["*"])->from("users");
        return $this->execute()->all('fetchAll');
    }

    public function updateFields(string $id, array $fields){
        $this->prepare();
        $this->update('users', $fields)->where('id', $id);
        return $this->execute()->lastId();
    }
}