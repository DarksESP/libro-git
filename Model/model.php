<?php
require_once './config.php';
class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->_deploy();
    }
    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
        CREATE TABLE usuario (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        );

        CREATE TABLE consola (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL
        );

        CREATE TABLE juego (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            id_consola INT,
            FOREIGN KEY (id_consola) REFERENCES consola(id)
        );
        END;

            $this->db->exec($sql);
        }
    }



    public function getJuegos()
    {
        $query = $this->db->prepare('SELECT * FROM juego');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getJuego($id)
    {
        $query = $this->db->prepare('SELECT * FROM juego WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getJuegosByConsola($consola)
    {
        $query = $this->db->prepare("SELECT * FROM juego WHERE id_consola= ?");
        $query->execute([$consola]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }



    public function getConsolas()
    {
        $query = $this->db->prepare('SELECT * FROM consola');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
  private function uploadImage($image){
   
        $target = './img/juego/' . uniqid() . "." . strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));  
        move_uploaded_file($image['tmp_name'], $target);
        return $target;
    }



    public function agregarJuego($nombre, $id_consola,$genero, $imagen = null)
    {
         $pathImg = null;
        if ($imagen) {
            $pathImg = $this->uploadImage($imagen);

        }
        $query = $this->db->prepare("INSERT INTO juego (nombre, id_consola, genero, imagen) VALUES (?,?, ?,?)");
        $nombre1 = strtoupper($nombre);
        $genero1 = strtoupper($genero);

       

        $query->execute([$nombre1, $id_consola, $genero1, $pathImg]);
    }

    public function eliminarJuego($id)
    {
        $query = $this->db->prepare("DELETE FROM juego WHERE id = ? ");
        $query->execute([$id]);
    }

    public function editarJuego($nombre, $id_consola, $genero, $id_juego, $imagen = null)
    {
         $pathImg = null;
        if ($imagen) {
            $pathImg = $this->uploadImage($imagen);
            $query = $this->db->prepare("UPDATE juego SET nombre = ?, id_consola = ?, genero =?, imagen =?  WHERE id = ?");
            $nombre1 = strtoupper($nombre);
             $genero1 = strtoupper($genero);
            $query->execute([$nombre1, $id_consola,$genero1, $pathImg, $id_juego]);

        }

        else {
            $query= $this->db->prepare("UPDATE juego SET nombre=? , id_consola= ?, genero =?  WHERE id =?");
             $nombre1 = strtoupper($nombre);
              $genero1 = strtoupper($genero);
            $query->execute([$nombre1, $id_consola,$genero1, $id_juego]);

        }
    }

    public function getUsuarioByEmail($email)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
        $query->execute([$email]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function registrarUsuario($email, $password)
    {
        if (!empty($this->getUsuarioByEmail($email))) {
            $query = $this->db->prepare("INSERT INTO usuario ($email, $password) VALUES (?,?)");
            $query->execute([$email, $password]);


        } else {
            echo "Acceso denegado";
        }



    }
}

?>