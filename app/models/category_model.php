<?php

class categoryModel
{
    private function connectDB()
    {
        $db = new PDO('mysql:host=localhost;' . 'dbname=catalogomates;charset=utf8', 'root', '');
        return $db;
    }
    function getCategories()
    {
        $db = $this->connectDB();

        $query = $db->prepare("SELECT * FROM categoria");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }
}
