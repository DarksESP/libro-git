<?php
   function sessionAuthMiddleware($res) {
    session_start(); // Inicia la sesión para poder leer $_SESSION
    
    if(isset($_SESSION['ID_USER'])) { // Verifica si hay un usuario logueado
        $res->user = new stdClass();  // Crea un objeto vacío para guardar la info del usuario
        $res->user->id = $_SESSION['ID_USER'];      // Guarda el ID del usuario
        $res->user->email = $_SESSION['USER_NAME']; // Guarda el email del usuario
        return; // Termina la función: usuario autenticado correctamente
    }
}
?>

