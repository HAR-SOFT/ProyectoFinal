<?php

/* Gestion de los alumnos */

require_once "conexionDB.php";
require_once "usuario.php";

class alumno extends usuario {

    private $mensaje;
    
    private $cursoActual;
    
    public function __construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono, $cursoActual) {
        parent::__construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono);
        $this->cursoActual = $cursoActual;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getCursoActual() {
        return $this->cursoActual;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setCursoActual($cursoActual) {
        $this->cursoActual = $cursoActual;
    }


}

?>