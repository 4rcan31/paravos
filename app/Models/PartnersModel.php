<?php

class PartnersModel extends BaseModel{


    public function get(){
        $this->prepare();
        $this->select(["*"])->from("partners");
        return $this->execute()->all("fetchAll");
    }

    public function existsPartnerById(string $id) : bool{
        $this->prepare();
        $this->select(['*'])->from("partners")->where("id", $id);
        return $this->execute()->exists();
    }

    public function getPartnerById(int $id) : object{
        $this->prepare();
        $this->select(['*'])->from("partners")->where("id", $id);
        return $this->execute()->all();
    } 
}