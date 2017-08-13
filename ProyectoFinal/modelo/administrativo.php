<?php

/* Gestion del administrativo */

require_once "conexionDB.php";
require_once "usuario.php";

class administrativo extends usuario {

    private $mensaje;
    
    public function __construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono) {
        parent::__construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono);
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

}

?>