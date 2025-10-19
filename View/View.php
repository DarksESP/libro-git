<?php

class View{
   
   public function __construct(){
    
   }

public function showInicio() {
     require_once './Templates/head.phtml';
     require_once './Templates/inicio.phtml';
     require_once './Templates/footer.phtml';
}


   
   public function showJuegos($juegos, $consolas) {
    require_once './Templates/head.phtml';
    require_once './Templates/formAgregar.phtml';
   require_once './Templates/juegos.phtml';
   require_once './Templates/footer.phtml';
}

public function showJuego($juego, $consolas) {

   require_once './Templates/head.phtml';
   require_once './Templates/juego.phtml';
   require_once './Templates/footer.phtml';
}


public function showFormEditar($id, $consolas) {
   require_once './Templates/head.phtml';
   require_once './Templates/formEditar.phtml';
   require_once './Templates/footer.phtml';
}
 public function showMensaje($mensaje){
      require_once './Templates/head.phtml';
      require_once './Templates/showMensaje.phtml';
   }

   
}
?>
