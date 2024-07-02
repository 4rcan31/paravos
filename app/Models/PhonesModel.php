<?php

class PhonesModel extends BaseModel{

    public function existsByNumberInUserWithAoutAcount(string $phone) : bool {
        $this->prepare();
        $stmt = $this->query("SELECT COUNT(phones.number_phone) AS total_phones
        FROM users
        JOIN phones ON users.id = phones.user_id
        WHERE users.is_client = true AND number_phone = ?", [$phone]);
        $totalPhones = $stmt->fetchColumn();
        return $totalPhones > 0; 
    }
    

    public function getUserIdByNumber(string $phone) : int{
        $this->prepare();
        $this->select(['user_id'])->from("phones")->where("number_phone", $phone);
        $result = $this->execute()->all();
        return $result ? $result->user_id : -1;
    }

    public function new(string $userId, string $number, bool $isPrincipal = false){
        $this->prepare();
        $this->insert("phones")->values([
            "user_id" => $userId,
            "is_principal" => $isPrincipal,
            "number_phone" => $number,
        ]);
        return $this->execute()->lastId();
    }
}