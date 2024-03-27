<?php

class PartnersModel extends BaseModel{


    public function get(){
        $this->prepare();
        $this->select(["*"])->from("partners");
        return $this->execute()->all("fetchAll");
    }
}