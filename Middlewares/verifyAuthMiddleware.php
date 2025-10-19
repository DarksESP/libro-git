<?php
  function verifyAuthMiddleware($res) {
    if($res->user) {
        return; // Usuario logueado → permite continuar
    } else {
        header('Location: ' . BASE_URL . 'login'); // Redirige al login
        die(); // Detiene la ejecución para proteger la ruta
    }
}
?>