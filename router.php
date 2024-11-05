<?php

//Codigos de respuesta
//1xx: Informational            -> Información

//2xx: Success                  -> Salió todo bien

//200 OK                -> La solicitud fue exitosa
//201 Created           -> Se crea un recurso
//202 Accepted          -> Se acepta la solicitud pero no se realizó todavia (suele usarse en request grandes)

//3xx: Redirection              -> Cuando redigirimos hacia otra parte de la pagina manda un '3xx'
//301 Moved Permanently -> Cuando se cambia de URL algo
//302 Found             -> Se encuentra el recurso pero la URL fue cambiada temporalmente

//4xx: Client error             -> Errores de peticion / Errores del cliente
//400 Bad Request       -> La solicitud esta mal
//401 Unauthorized      -> Se necesita autenticacion para obtener la respuesta
//403 Forbidden         -> El cliente no posee los permisos necesarios para realizar cierta accion
//404 Not Found         -> No se encuentra algo
//410 Gone              -> Existió algo pero ya no esta mas

//5xx: Server error                 -> El servidor falló.
//500 Internal Server Error -> Llegó la peticion pero falló al llegar al servidor
//503 Service Unavailable   -> La peticion nunca llego al servidor ya que el mismo se encontraba apagado, no se encontró la IP, etc.

require_once('libs/router.php');
require_once('app/controllers/product_api_controller.php');
$router = new Router();

//                                              EJEMPLO
//                   endpoint                verbo                controller                 metodo
//$router->addRoute('producto'            , 'GET' ,       'ProductApiController',         'getAll');


$router->addRoute('producto', 'GET',       'ProductApiController',         'getAll');
$router->addRoute('producto/:id', 'GET',       'ProductApiController',         'get');


// producto/12
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
