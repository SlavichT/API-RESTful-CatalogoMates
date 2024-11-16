<?php

class categoryModel
{
    private function connectDB()
    {
        $db = new PDO('mysql:host=localhost;' . 'dbname=catalogomates;charset=utf8', 'root', '');
        return $db;
    }
    public function getCategories()
    {
        $db = $this->connectDB();

        $query = $db->prepare("SELECT * FROM categoria");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    public function getCategoryById($id_categoria_fk)
    {
        $db = $this->connectDB();

        $query = $db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $query->execute([$id_categoria_fk]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
