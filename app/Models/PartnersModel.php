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

    public function existById(string $id){
        $this->prepare();
        $this->select(['id'])->from("partners")->where("id", $id);
        return $this->execute()->exists();
    }

    public function getColumnsPart(){
        return $this->getColumns("partners");
    }

    public function new(string $name, string $description, string $img, string $latitude, string $longitude) : int{
        $this->prepare();
        $this->insert("partners")->values([
            "name" => $name,
            'img' => $img,
            "description" => $description,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
        return $this->execute()->lastId();
    }

    public function getUrlImgById(string $id) : string{
        $this->prepare();
        $this->select(['img'])->from("partners")->where("id", $id);
        return $this->execute()->all()->img;
    }


    public function updatePartner(string $id, string $name, string $description, string $img, string $latitude, string $longitude) : int{
        $this->prepare();
        $this->update("partners", [
            "name" => $name,
            'img' => $img,
            "description" => $description,
            'latitude' => $latitude,
            'longitude' => $longitude
        ])->where('id', $id);
        return $this->execute()->lastId();
    }

    public function deleteById(string $id){
        $this->prepare();
        $this->delete("partners")->where('id', $id);
        return $this->execute();
    }

    
}