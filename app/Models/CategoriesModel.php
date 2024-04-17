<?php


class CategoriesModel extends BaseModel{

    public function get(){
        $this->prepare();
        $this->select(['*'])->from("categories");
        return $this->execute()->all('fetchAll');
    }

    public function getJustName(){
        return array_column(
            $this->query("SELECT name FROM categories")->fetchAll(), 
            'name');
    }

    public function updateNameById(string $name, string $idCategory) : int|string{
        $this->prepare();
        $this->update('categories', [
            'name' => $name,
        ])->where("id" ,$idCategory);
        return $this->execute()->lastId();
    }

    public function new(string $name) : int{
        $this->prepare();
        $this->insert("categories")->values([
            'name' => $name
        ]);
        return $this->execute()->lastId();
    }

    public function deleteById(string $idCategory) : int|string{
        $this->prepare();
        $this->delete("categories")->where(
            'id',
            $idCategory
        );
        return $this->execute()->lastId();
    }
}