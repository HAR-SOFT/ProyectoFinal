<?php

/* Gestion de los temas */

require_once "conexionDB.php";

class atributo_simple extends conexionDB {

    private $mensaje;
    
    private $nombre;
    private $esPK;
    private $nombreEntidad;
    private $nombreEntidadSuperTipo;
    private $nombreEntidadSubTipo;
    
    public function __construct($mensaje, $nombre, $esPK, $nombreEntidad, $nombreEntidadSuperTipo, $nombreEntidadSubTipo) {
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->esPK = $esPK;
        $this->nombreEntidad = $nombreEntidad;
        $this->nombreEntidadSuperTipo = $nombreEntidadSuperTipo;
        $this->nombreEntidadSubTipo = $nombreEntidadSubTipo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEsPK() {
        return $this->esPK;
    }

    public function getNombreEntidad() {
        return $this->nombreEntidad;
    }

    public function getNombreEntidadSuperTipo() {
        return $this->nombreEntidadSuperTipo;
    }

    public function getNombreEntidadSubTipo() {
        return $this->nombreEntidadSubTipo;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEsPK($esPK) {
        $this->esPK = $esPK;
    }

    public function setNombreEntidad($nombreEntidad) {
        $this->nombreEntidad = $nombreEntidad;
    }

    public function setNombreEntidadSuperTipo($nombreEntidadSuperTipo) {
        $this->nombreEntidadSuperTipo = $nombreEntidadSuperTipo;
    }

    public function setNombreEntidadSubTipo($nombreEntidadSubTipo) {
        $this->nombreEntidadSubTipo = $nombreEntidadSubTipo;
    }


    
}

?>