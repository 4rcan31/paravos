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
    
}