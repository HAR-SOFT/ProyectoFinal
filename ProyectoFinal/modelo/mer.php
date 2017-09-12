<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class mer extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $colEntidades;
    private $colRelaciones;

    public function __construct($nombre, $colEntidades, $colRelaciones) {
        $this->nombre = $nombre;
        $this->colEntidades = $colEntidades;
        $this->colRelaciones = $colRelaciones;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getColEntidades() {
        return $this->colEntidades;
    }

    public function getColRelaciones() {
        return $this->colRelaciones;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setColEntidades($colEntidades) {
        $this->colEntidades = $colEntidades;
    }

    public function setColRelaciones($colRelaciones) {
        $this->colRelaciones = $colRelaciones;
    }
}

?>