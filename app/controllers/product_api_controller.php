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
    public function getAll($request, $response)
    {
        $products = $this->model->getProducts();

        $this->view->response($products);
    }

    // api/producto/:id
    public function get($request, $response)
    {
        //Obtenemos el ID del producto desde la ruta
        $id = $request->params->id;

        //Obtenemos el producto de la DB
        $product = $this->model->getProductById($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        //Mandamos el producto a la vista
        return $this->view->response($product);
    }

    // api/producto/:id (DELETE)
    public function deleteProduct($request, $response)
    {
        $id = $request->params->id;

        $product = $this->model->getProductById($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        $this->model->deleteProductById($id);

        $this->view->response("El producto con el id=$id fue eliminado con exito");
    }


    // api/producto(POST)

    public function addProduct($request, $response)
    {
        //Valido los datos 
        if (!isset($request->body->nombre_mate) || !isset($request->body->forma_mate) || !isset($request->body->recubrimiento_mate) || !isset($request->body->imagen) || !isset($request->body->color_mate) || !isset($request->body->id_categoria_fk)) {
            return $this->view->response("Faltan completar datos", 400);
        }

        //Nos traemos toda la info del body mediante la request (esto nos traeria todo el contenido del producto que agregamos via POSTMAN)
        $nombre_mate = $request->body->nombre_mate;
        $forma_mate = $request->body->forma_mate;
        $recubrimiento_mate = $request->body->recubrimiento_mate;
        $imagen = $request->body->imagen;
        $color_mate = $request->body->color_mate;
        $id_categoria_fk = $request->body->id_categoria_fk; // En este campo debe seleccionarse un valor de 1 , 2 o 3 donde 1-> Calabaza , 2->Madera , 3->Vidrio

        $id = $this->model->addNewProduct($nombre_mate, $forma_mate, $recubrimiento_mate, $imagen, $color_mate, $id_categoria_fk);

        if (!$id) {
            return $this->view->response("Error al agregar un nuevo producto", 400);
        }

        $product = $this->model->getProductById($id);
        return $this->view->response($product, 201);
    }

    //api/producto/:id (PUT)
    public function updateProduct($request, $response)
    {
        $id = intval($request->params->id);

        $product = $this->model->getProductById($id);


        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        if (empty($request->body->nombre_mate) || empty($request->body->forma_mate) || empty($request->body->recubrimiento_mate) || empty($request->body->imagen) || empty($request->body->color_mate) || empty($request->body->id_categoria_fk)) {
            return $this->view->response("Faltan completar datos", 400);
        }

        $nombre_mate = $request->body->nombre_mate;
        $forma_mate = $request->body->forma_mate;
        $recubrimiento_mate = $request->body->recubrimiento_mate;
        $imagen = $request->body->imagen;
        $color_mate = $request->body->color_mate;
        $id_categoria_fk = $request->body->id_categoria_fk;

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
