<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class mer extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $colEntidades;
    private $colRelaciones;
    private $colAgregaciones;
    private $tipo;
    private $nombreEjercicio;

    public function __construct($nombre, $colEntidades, $colRelaciones, $colAgregaciones, $enum, $nombreEjercicio) {
        $this->nombre = $nombre;
        $this->colEntidades = $colEntidades;
        $this->colRelaciones = $colRelaciones;
        $this->colAgregaciones = $colAgregaciones;
        $this->enum = $enum;
        $this->nombreEjercicio = $nombreEjercicio;
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

    public function getColAgregaciones() {
        return $this->colAgregaciones;
    }

    public function getEnum() {
        return $this->enum;
    }

    public function getNombreEjercicio() {
        return $this->nombreEjercicio;
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

    public function setColAgregaciones($colAgregaciones) {
        $this->colAgregaciones = $colAgregaciones;
    }

    public function setEnum($enum) {
        $this->enum = $enum;
    }

    public function setNombreEjercicio($nombreEjercicio) {
        $this->nombreEjercicio = $nombreEjercicio;
    }



}

?>