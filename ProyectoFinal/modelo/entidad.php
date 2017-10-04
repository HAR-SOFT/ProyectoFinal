<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class entidad extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $colAtributosSimples;
    private $colAtributosMultivaluados;
    private $nombreMer;

    public function __construct($nombre, $colAtributosSimples, $colAtributosMultivaluados, $nombreMer) {
        $this->nombre = $nombre;
        $this->colAtributosSimples = $colAtributosSimples;
        $this->colAtributosMultivaluados = $colAtributosMultivaluados;
        $this->nombreMer = $nombreMer;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getColAtributosSimples() {
        return $this->colAtributosSimples;
    }

    public function getColAtributosMultivaluados() {
        return $this->colAtributosMultivaluados;
    }

    public function getNombreMer() {
        return $this->nombreMer;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setColAtributosSimples($colAtributosSimples) {
        $this->colAtributosSimples = $colAtributosSimples;
    }

    public function setColAtributosMultivaluados($colAtributosMultivaluados) {
        $this->colAtributosMultivaluados = $colAtributosMultivaluados;
    }

    public function setNombreMer($nombreMer) {
        $this->nombreMer = $nombreMer;
    }


    
}

?>