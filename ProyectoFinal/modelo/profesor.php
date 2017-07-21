<?php

/* Gestion de los usuarios */

require_once "conexionDB.php";

abstract class profesor extends usuario {

    private $mensaje;
    
    private $colCursos;
    
    public function __construct($nombre, $ci, $sexo, $email, $clave, $colCursos) {
        parent::__construct($nombre, $ci, $sexo, $email, $clave);
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