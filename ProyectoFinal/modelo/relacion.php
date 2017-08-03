<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class relacion extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $entidadA;
    private $entidadB;
    private $cardinalidadA;
    private $cardinalidadB;
    private $colAtributosSimples;
    
    public function __construct($mensaje, $nombre, $entidadA, $entidadB, $cardinalidadA, $cardinalidadB, $colAtributosSimples) {
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->entidadA = $entidadA;
        $this->entidadB = $entidadB;
        $this->cardinalidadA = $cardinalidadA;
        $this->cardinalidadB = $cardinalidadB;
        $this->colAtributosSimples = $colAtributosSimples;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEntidadA() {
        return $this->entidadA;
    }

    public function getEntidadB() {
        return $this->entidadB;
    }

    public function getCardinalidadA() {
        return $this->cardinalidadA;
    }

    public function getCardinalidadB() {
        return $this->cardinalidadB;
    }

    public function getColAtributosSimples() {
        return $this->colAtributosSimples;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEntidadA($entidadA) {
        $this->entidadA = $entidadA;
    }

    public function setEntidadB($entidadB) {
        $this->entidadB = $entidadB;
    }

    public function setCardinalidadA($cardinalidadA) {
        $this->cardinalidadA = $cardinalidadA;
    }

    public function setCardinalidadB($cardinalidadB) {
        $this->cardinalidadB = $cardinalidadB;
    }

    public function setColAtributosSimples($colAtributosSimples) {
        $this->colAtributosSimples = $colAtributosSimples;
    }

    
}

?>