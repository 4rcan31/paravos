<?php

class StaffModel extends BaseModel{

    public function getByEmail($email){
        $this->prepare();
        $this->select(['*'])->from('staff')->where('email', $email);
        return $this->execute()->all();
    }

    public function existByEmail(string $email){
        $this->prepare(); 
        $this->select(['email'])->from('staff')->where('email', $email);
        return $this->execute()->exists();
    }
}