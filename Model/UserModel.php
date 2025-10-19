<?php
require_once './config.php';
class UserModel {
    protected $db;

    public function __construct() {
      $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
    }
 
    
  public function tieneUsuarioDB($userName) {
    $query = $this->db->prepare("SELECT nombre FROM usuario WHERE nombre =?");
     $query->execute([$userName]);
    $userN = $query->fetch(PDO::FETCH_OBJ);
    return $userN;
  }
    
    public function agregarUsuario($userName, $password) {
        $query = $this->db->prepare('INSERT INTO usuario (nombre,passwordd) VALUES(?,?)');
        $query->execute([$userName, $password]);
    }
    public function getUserByNombre($userName) {    
        $query = $this->db->prepare("SELECT * FROM usuario WHERE nombre = ?");
        $query->execute([$userName]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}