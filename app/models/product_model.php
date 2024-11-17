<?php
require_once('app/models/model.php');
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
    function getProducts($orderBy = 'id_mate', $forma_mate = null)
    {
        $db = $this->connectDB();

        $sql = 'SELECT  p.*, c.material_fabricacion  FROM producto p JOIN categoria c ON p.id_categoria_fk = c.id_categoria';
        if ($forma_mate != null) {
            $sql .= ' WHERE p.forma_mate = ?';
        }
        if ($orderBy) {
            switch ($orderBy) {
                    //orderBy ASCENDENTE
                case 'id_mate':
                    $sql .= ' ORDER BY id_mate';
                    break;

                case 'nombre_mate':
                    $sql .= ' ORDER BY nombre_mate';
                    break;

                case 'forma_mate':
                    $sql .= ' ORDER BY forma_mate';
                    break;

                case 'recubrimiento_mate':
                    $sql .= ' ORDER BY recubrimiento_mate';
                    break;

                case 'color_mate':
                    $sql .= ' ORDER BY color_mate';
                    break;

                case 'id_categoria_fk':
                    $sql .= ' ORDER BY id_categoria_fk';
                    break;

                case 'material_fabricacion':
                    $sql .= ' ORDER BY material_fabricacion';
                    break;

                    //orderBy DESCENDENTE

                case '-id_mate':
                    $sql .= ' ORDER BY id_mate DESC';
                    break;

                case '-nombre_mate':
                    $sql .= ' ORDER BY nombre_mate DESC';
                    break;

                case '-forma_mate':
                    $sql .= ' ORDER BY forma_mate DESC';
                    break;

                case '-recubrimiento_mate':
                    $sql .= ' ORDER BY recubrimiento_mate DESC';
                    break;

                case '-color_mate':
                    $sql .= ' ORDER BY color_mate DESC';
                    break;

                case '-id_categoria_fk':
                    $sql .= ' ORDER BY id_categoria_fk DESC';
                    break;

                case '-material_fabricacion':
                    $sql .= ' ORDER BY material_fabricacion DESC';
                    break;
            }

            $query = $db->prepare($sql);
            if ($forma_mate != null) {
                $query->bindParam(1, $forma_mate, PDO::PARAM_STR);
            }
            $query->execute();

            $products = $query->fetchAll(PDO::FETCH_OBJ);

            return $products;
        }
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
