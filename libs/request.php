<?php

class Request
{
    public $body = null;   //               {nombre: 'Mate Original' , Tipo: 'Imperial'}
    public $params = null; //               /api/producto/:id
    public $query = null;  //               ?soloReseñados=true

    public function __construct()
    {
        try {
            $this->body = json_decode(file_get_contents('php://input'), true); //       Sirve para leer el body de una request
        } catch (Exception $e) {
            $this->body = null;
        }
        $this->query = (object) $_GET;
    }
}
