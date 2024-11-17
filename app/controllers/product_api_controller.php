<?php

require_once('app/models/product_model.php');
require_once('app/views/json_view.php');
require_once('app/models/category_model.php');


//El controlador "maneja" todo lo que pide el usuario, si el usuario pide ver la lista de items de la pagina, el controlador se lo solicitara al modelo
//El controlador interactua con el modelo o con la vista para que estas no se tengan que comunicar entre si

class productApiController
{
    private $model;
    private $view;
    private $categoryModel;

    public function __construct()
    {
        $this->model = new productModel();
        $this->categoryModel = new categoryModel();
        $this->view = new JSONView();
    }


    //Muestra nuestra lista de items

    //  api/producto
    public function getAll($req, $res)
    {
        $allowedColumns =
            [
                'id_mate',
                'nombre_mate',
                'forma_mate',
                'recubrimiento_mate',
                'color_mate',
                'id_categoria_fk',
                '-id_mate',
                '-nombre_mate',
                '-forma_mate',
                '-recubrimiento_mate',
                '-color_mate',
                '-id_categoria_fk',
                '-material_fabricacion',
            ];

        $orderBy = 'id_mate';

        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;

            if (!in_array($orderBy, $allowedColumns)) {
                return $this->view->response("El ordenamiento por '$orderBy' no es valido", 400);
            }
        }

        //FILTRO POR FORMA DE MATE: IMPERIAL , TORPEDO o CAMIONERO
        $forma_mate = null;
        $allowedMate =
            [
                'imperial',
                'torpedo',
                'camionero'
            ];
        if (isset($req->query->forma_mate)) {
            $forma_mate = strtolower($req->query->forma_mate);

            if (!in_array($forma_mate, $allowedMate)) {
                return $this->view->response("La forma de mate seleccionada '$forma_mate' no es valida", 400);
            }
        }

        $sort = null;
        if (isset($req->query->sort)) {
            $sort = $req->query->sort;
        }

        $limit = null;
        if (isset($req->query->limit)) {
            $limit = $req->query->limit;
        }

        $page = 1;
        if (isset($req->query->page)) {
            $page = $req->query->page;
        }

        $offset = ($page - 1) * $limit;

        $products = $this->model->getProducts($orderBy, $forma_mate, $sort, $limit, $offset);

        return $this->view->response($products);
    }

    // api/producto/:id
    public function get($req, $res)
    {
        //Obtenemos el ID del producto desde la ruta
        $id = $req->params->id;

        //Obtenemos el producto de la DB
        $product = $this->model->getProductById($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        //Mandamos el producto a la vista
        return $this->view->response($product);
    }

    // api/producto/:id (DELETE)
    public function deleteProduct($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = $req->params->id;

        $product = $this->model->getProductById($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        $this->model->deleteProductById($id);

        $this->view->response("El producto con el id=$id fue eliminado con exito");
    }


    // api/producto(POST)

    public function addProduct($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        //Valido los datos 
        if (!isset($req->body->nombre_mate) || !isset($req->body->forma_mate) || !isset($req->body->recubrimiento_mate) || !isset($req->body->imagen) || !isset($req->body->color_mate) || !isset($req->body->id_categoria_fk)) {
            return $this->view->response("Faltan completar datos", 400);
        }

        //Nos traemos toda la info del body mediante la request (esto nos traeria todo el contenido del producto que agregamos via POSTMAN)
        $nombre_mate = $req->body->nombre_mate;
        $forma_mate = $req->body->forma_mate;
        $recubrimiento_mate = $req->body->recubrimiento_mate;
        $imagen = $req->body->imagen;
        $color_mate = $req->body->color_mate;
        $id_categoria_fk = $req->body->id_categoria_fk; // En este campo debe seleccionarse un valor de 1 , 2 o 3 donde 1-> Calabaza , 2->Madera , 3->Vidrio

        $id = $this->model->addNewProduct($nombre_mate, $forma_mate, $recubrimiento_mate, $imagen, $color_mate, $id_categoria_fk);

        if (!$id) {
            return $this->view->response("Error al agregar un nuevo producto", 400);
        }

        $product = $this->model->getProductById($id);
        return $this->view->response($product, 201);
    }

    //api/producto/:id (PUT)
    public function updateProduct($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = intval($req->params->id);

        $product = $this->model->getProductById($id);


        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        if (empty($req->body->nombre_mate) || empty($req->body->forma_mate) || empty($req->body->recubrimiento_mate) || empty($req->body->imagen) || empty($req->body->color_mate) || empty($req->body->id_categoria_fk)) {
            return $this->view->response("Faltan completar datos", 400);
        }

        $nombre_mate = $req->body->nombre_mate;
        $forma_mate = $req->body->forma_mate;
        $recubrimiento_mate = $req->body->recubrimiento_mate;
        $imagen = $req->body->imagen;
        $color_mate = $req->body->color_mate;
        $id_categoria_fk = $req->body->id_categoria_fk;

        $category = $this->categoryModel->getCategoryById($id_categoria_fk);
        if (!$category) {
            return $this->view->response("La categoria con el id=$id_categoria_fk no existe", 404);
        }


        $this->model->updateItem($id, $nombre_mate, $forma_mate, $imagen, $recubrimiento_mate, $color_mate, $id_categoria_fk);

        $productUpdated = $this->model->getProductById($id);
        if (!$productUpdated) {
            return $this->view->response("No se puedo actualizar el producto con el id=$id", 400);
        }

        return $this->view->response($productUpdated, 200);
    }
}
