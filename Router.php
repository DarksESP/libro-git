<?php
require_once './Controller/controller.php';
require_once './Controller/AuthController.php';
require_once './Middlewares/sessionAuthMiddleware.php';
require_once './Middlewares/verifyAuthMiddleware.php';
require_once './libs/Response.php';
$action = 'juegos';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['action'])) {
        $action = $_POST['action'];
    }
} else if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'inicio';
}

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new Response();





$params = explode("/", $action);

switch (strtolower($params[0])) {
    case "inicio":
        $controller = new Controller();
        $controller->showInicio();
        break;
    case "juegos":
        if ((!empty($params[1])) && (is_numeric($params[1]))) {
            $controller = new Controller();
            $controller->showJuego($params[1]);
            break;
        } else {
            $controller = new Controller();
            $controller->showJuegos();
            break;

        }

    case "consolas":
        if (!empty($params[1]) && is_numeric($params[1])) {
            $controller = new Controller();
            $controller->showJuegoByConsola($params[1]);
            break;
        } else {
            $controller = new Controller();
            $controller->showJuegos();
        }


    case "agregar":
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if ($params[1] == "juego") {
            $controller = new Controller();
            $controller->showFormAgregar();
            break;


        }

    case "eliminar":
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if (!empty($params[1]) && is_numeric($params[1])) {
            $controller = new Controller();
            $controller->eliminarJuego($params[1]);
            break;
        }
    case "editar":
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
       if (!empty ($params[1]) && is_numeric($params[1])) {

           $controller = new Controller();
           $controller->showFormEditar($params[1]);
           break;
       }

       else {
        $controller = new Controller ();
        $controller->showJuegos();
        break;
       }

     

       
       
     

    case "signup":
        $controller = new AuthController();
        $controller->showSignUp();
        break;

    case "login":
        $controller = new AuthController();
        $controller->showLogin();
        break;

    case "logout":
        $controller = new AuthController();
        $controller->showLogOut();
        break;






    default:
        $controller = new Controller();
        $controller->showInicio();
        break;

}

?>