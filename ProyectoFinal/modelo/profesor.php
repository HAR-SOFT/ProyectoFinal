<?php

/* Gestion de los profesores */

require_once "conexionDB.php";
require_once "usuario.php";

class profesor extends usuario {

    private $mensaje;
    private $colCursos;
    
    public function __construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono, $celular, $colCursos) {
        parent::__construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono, $celular);
        $this->colCursos = $colCursos;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getColCursos() {
        return $this->colCursos;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setColCursos($colCursos) {
        $this->colCursos = $colCursos;
    }

}

?>