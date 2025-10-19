<?php

require_once './View/View.php';
require_once './Model/model.php';

class Controller
{

    private $view;
    private $model;


    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function showInicio()
    {
        $this->view->showInicio();
    }

    public function showJuegos()
    {
        $juegos = $this->model->getJuegos();
        $consolas = $this->model->getConsolas();
        $this->view->showJuegos($juegos, $consolas);
    }


    public function showJuego($id)
    {
        $juego = $this->model->getJuego($id);
        if (empty($juego)) {
            $this->view->showMensaje("NO EXISTE UN JUEGO DE ID $id en la base de datos");
        } else {
            $consolas = $this->model->getConsolas();
            $this->view->showJuego($juego, $consolas);

        }
    }

    public function showJuegoByConsola($consola)
    {
        $juegos = $this->model->getJuegosByConsola($consola);
        $consolas = $this->model->getConsolas();
        $this->view->showJuegos($juegos, $consolas);
    }




    public function showFormAgregar()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (
                !isset($_POST['nombre']) || empty($_POST['nombre'])
                || (!isset($_POST['id_consola']) || empty($_POST['id_consola']))
                || (!isset($_POST['genero']) || empty($_POST['genero']))
                || (!isset($_POST['action']) || empty($_POST['action']) || $_POST['action'] != "agregar/juego")
            ) {
                $this->view->showMensaje('ingrese los datos correctamente');

            } else {
                $nombre = $_POST['nombre'];
                $consola = $_POST['id_consola'];
                $genero =  $_POST['genero'];


                if ( !empty($_FILES['imagen']['name']) &&
                    (
                        $_FILES['imagen']['type'] == "image/jpg" ||
                        $_FILES['imagen']['type'] == "image/jpeg" ||
                        $_FILES['imagen']['type'] == "image/png"
                    )
                ) {
                    $this->model->agregarJuego($nombre, $consola, $genero, $_FILES['imagen']);
                } else {


                    $this->model->agregarJuego($nombre, $consola, $genero);
                    $this->view->showMensaje('error al procesar la imagen');
                }
             

                $this->showJuegos();
            }

        } else {
            $this->showJuegos();
        }

    }

    public function eliminarJuego($id)
    {
        $this->model->eliminarJuego($id);
        $this->showJuegos();
    }

    public function showFormEditar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            $consolas = $this->model->getConsolas();
            $this->view->showFormEditar($id, $consolas);

        }



        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (
                !isset($_POST['nombre']) || empty($_POST['nombre']) || !isset($_POST['genero']) || empty($_POST['genero']) || !isset($_POST['id_juego']) || empty($_POST['id_juego'])
                || (!isset($_POST['id_consola']) || empty($_POST['id_consola']))
                || (!isset($_POST['action']) || empty($_POST['action']) || $_POST['action'] != "editar/$id")
            ) {
                $this->view->showMensaje('ingrese los datos correctamente');

            } else {
                $nombre = $_POST['nombre'];
                $consola = $_POST['id_consola'];
                $id_juego = $_POST['id_juego'];
                $genero = $_POST['genero'];


                
                if ( !empty($_FILES['imagen']['name']) &&
                    (
                        $_FILES['imagen']['type'] == "image/jpg" ||
                        $_FILES['imagen']['type'] == "image/jpeg" ||
                        $_FILES['imagen']['type'] == "image/png"
                    )
                ) {
                    $this->model->editarJuego($nombre, $consola, $genero, $id_juego, $_FILES['imagen']);
                } 

                else {
                   


                    $this->model->editarJuego($nombre, $consola, $genero, $id_juego);
                    $this->view->showMensaje('error al procesar la imagen');
                
             
                }
             

                $this->showJuegos();
            }

        }
    }

   
}
?>