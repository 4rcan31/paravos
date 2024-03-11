<?php 



class exampleModel extends BaseModel{
    

    public function getUserById($id){
        $this->prepare();
        $this->select(['*'])->from('user')->where('id', $id);
        $this->execute()->all();
    }

    /* 
        user@cliente.com
        123

        
        user@cliente.com:admin
        233434
    
    */

    public function getAllUsers(){
        return $this->query("SELECT password from users")->fetchAll();
    }
}
