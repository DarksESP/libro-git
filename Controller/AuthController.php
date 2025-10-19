<?php
require_once './Model/UserModel.php';
require_once './View/AuthView.php';

class AuthController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }


    public function showSignUp()
    {
        //Creo la cuenta cuando venga en el POST

        if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
            $userName = $_POST['usuario'];
            $userPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

            if (empty($this->model->tieneUsuarioDB($userName))) {

                $this->model->agregarUsuario($userName, $userPassword);
                $this->view->showLogin();

            } else {
                $this->view->showSignUp("ESE MAIL YA FIGURA EN SISTEMA");
            }

        } else {
            $this->view->showSignUp();
        }

    }


    public function showLogin()
    {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_POST['usuario'])) {
                return $this->view->showLogin('FALTA COMPLETAR EL EMAIL');
            } else if (empty($_POST['password'])) {
                return $this->view->showLogin('FALTA COMPLETAR LA CONTRASEÑA');
            } else {
                $userName = $_POST['usuario'];
                $password = $_POST['password'];

                $userFromDB = $this->model->getUserByNombre($userName);

                if ($userFromDB && password_verify($password, $userFromDB->passwordd)) {
                    // Guardo en la sesión el ID del usuario
                    session_start();
                    $_SESSION['ID_USER'] = $userFromDB->id;
                    $_SESSION['USER_NAME'] = $userFromDB->nombre;


                    // Redirijo al home
                    //    header('Location: ' . BASE_URL);
                    echo "INICIO DE SESION EXITOSO";
                } else {

                    return $this->view->showLogin('DATOS INCORRECTOS');
                }
            }

        } else {
            $this->view->showLogin();
        }

    }




    public function showLogOut()
    {
        session_start(); // Va a buscar la cookie
        session_destroy(); // Borra la cookie que se buscó

        $this->view->showLogin("QUIERE INICIAR SESION?");
    }
}

