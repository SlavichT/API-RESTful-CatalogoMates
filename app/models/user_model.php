<?php

class UserModel
{
    private function connectDB()
    {
        $db = new PDO('mysql:host=localhost;' . 'dbname=catalogomates;charset=utf8', 'root', '');
        return $db;
    }

    public function getUserByUsername($username)
    {

        $db = $this->connectDB();
        $query = $db->prepare("SELECT * FROM usuario WHERE username = ?");
        $query->execute([$username]);

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
}
