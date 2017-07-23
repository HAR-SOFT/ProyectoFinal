<?php

/* Gestion del administrativo */

require_once "conexionDB.php";
require_once "usuario.php";

class administrativo extends usuario {

    private $mensaje;
    
    public function __construct($nombre, $ci, $sexo, $email, $clave) {
        parent::__construct($nombre, $ci, $sexo, $email, $clave);
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

}

?>