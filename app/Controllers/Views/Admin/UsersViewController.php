<?php

class UsersViewController extends BaseController{

    public function users() : UsersModel{
        return model("usersModel");
    }

    public function show(){
       view("admin/users", [
        "table" => $this->getTable()
       ]);
    }




    public function getTable(){
        $colums = $this->users()->getColumns("users");
         return [
             'columns' => $colums,
             'rows' => objectToArray($this->users()->get())
         ];
     }
}