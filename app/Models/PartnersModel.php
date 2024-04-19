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

    public function getJustName(){
        return array_column(
            $this->query("SELECT name FROM partners")->fetchAll(), 
            'name');
    } 

    public function getIdByName(string $name){
        $this->prepare();
        $this->select(['id'])->from("partners")->where("name", $name);
        return $this->execute()->all()->id;
    }

    public function existByName(string $name){
        $this->prepare();
        $this->select(['name'])->from("partners")->where("name", $name);
        return $this->execute()->exists();
    }
}