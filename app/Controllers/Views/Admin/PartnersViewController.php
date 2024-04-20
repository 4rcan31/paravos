<?php

class PartnersViewController extends BaseController{


    public function partner() : PartnersModel{
        return model("PartnersModel");
    }

    public function show(){
        //prettyPrint($this->getTablePartners()); die;
        view("admin/partners", [
            "table" => $this->getTablePartners()
        ]);
    }


    public function getTablePartners(){
        $colums = $this->partner()->getColumnsPart();
         return [
             'columns' => $colums,
             'rows' => objectToArray($this->partner()->get())
         ];
     }
}