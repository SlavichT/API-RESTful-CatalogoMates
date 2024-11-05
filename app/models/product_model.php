<?php

//El modelo es el encargado de realizar las tareas solicitadas por el controlador, por ejemplo: Listar items, detalle de items.
class productModel
{
    //Esta funcion nos abre la conexion con nuestra DB
    private function connectDB()
    {
        $db = new PDO('mysql:host=localhost;' . 'dbname=catalogomates;charset=utf8', 'root', '');
        return $db;
    }

    //Esta funcion nos trae de la base de datos TODOS nuestros productos junto a sus categorias
    function getProducts($orderBy = false)
    {
        $db = $this->connectDB();

        $sql = 'SELECT * FROM producto';

        if ($orderBy) {
            switch ($orderBy) {
                case 'id_mate':
                    $sql .= " ORDER BY id_mate ";
                    break;
            }
        }

        //Enviamos nuestra consulta correspondiente 
        // " p. * " = nos trae TODOS los productos de la tabla "producto". 
        // " c.material_fabricacion " = nos selecciona la columna especifica de la tabla "categoria" (en este caso con la abreviacion " c ")
        // " ON p.id_categoria_fk = c.id_categoria " = con esto definimos que nuestra columna "id_categoria_fk" es la foreign key de la columna "id_categoria".
        $query = $db->prepare("SELECT  p.*, c.material_fabricacion  FROM producto p JOIN categoria c ON p.id_categoria_fk = c.id_categoria");
        $query->execute();

        //Realizamos un 'fetchAll' para obtener TODOS nuestros productos
        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    function getProductById($id_mate)
    {
        $db = $this->connectDB();

        $query = $db->prepare("SELECT  p.*, c.material_fabricacion FROM producto p JOIN categoria c ON p.id_categoria_fk = c.id_categoria WHERE id_mate = ?");
        $query->execute([$id_mate]);

        //Realizamos en este caso un 'fetch' ya que solo necesitamos UN solo producto.
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }


    //Productos CON CATEGORIAS

    //Funcion para agregar un nuevo producto 

    //Traemos las categorias 

    function getCategories()
    {
        $db = $this->connectDB();

        $query = $db->prepare("SELECT * FROM categoria");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    function addNewProduct($nombre_mate, $forma_mate, $recubrimiento_mate, $imagen, $color_mate, $id_categoria_fk)
    {
        $db = $this->connectDB();

        $query = $db->prepare("INSERT INTO producto (nombre_mate, forma_mate, recubrimiento_mate, imagen, color_mate, id_categoria_fk) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$nombre_mate, $forma_mate, $recubrimiento_mate, $imagen, $color_mate, $id_categoria_fk]);
        $id_mate = $db->lastInsertId();
        return $id_mate;
    }

    //Boton ELIMINAR

    function deleteProductById($id_mate)
    {
        $db = $this->connectDB();

        $query = $db->prepare("DELETE FROM producto WHERE id_mate = ?");
        $query->execute([$id_mate]);
    }

    //Boton EDITAR

    function updateItem($id_mate, $nombre_mate, $forma_mate, $imagen, $recubrimiento_mate, $color_mate, $id_categoria_fk)
    {

        $db = $this->connectDB();

        $query = $db->prepare("UPDATE producto SET id_categoria_fk = ?, nombre_mate = ?, forma_mate = ?, imagen = ?, recubrimiento_mate = ?, color_mate = ? WHERE id_mate = ?");
        $query->execute([$id_categoria_fk, $nombre_mate, $forma_mate, $imagen, $recubrimiento_mate, $color_mate, $id_mate]);
    }
}
