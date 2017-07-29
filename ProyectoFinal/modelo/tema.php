<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class tema extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $letra;
    private $colEjercicios;
    private $indice;

    public function __construct($mensaje, $nombre, $letra, $colEjercicios, $indice) {
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->letra = $letra;
        $this->colEjercicios = $colEjercicios;
        $this->indice = $indice;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getLetra() {
        return $this->letra;
    }

    public function getColEjercicios() {
        return $this->colEjercicios;
    }

    public function getIndice() {
        return $this->indice;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setLetra($letra) {
        $this->letra = $letra;
    }

    public function setColEjercicios($colEjercicios) {
        $this->colEjercicios = $colEjercicios;
    }

    public function setIndice($indice) {
        $this->indice = $indice;
    }

}

?>