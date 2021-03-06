<?php

/* Gestion de los cursos */

require_once "manejador.php";

class curso extends manejador {

    private $mensaje;
    
    private $nombre;
    private $anio;
    private $horario;
    private $profesor;
    private $colAlumnos;
    private $colTemas;

    public function __construct($mensaje, $nombre, $anio, $horario, $profesor, $colAlumnos, $colTemas) {
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->anio = $anio;
        $this->horario = $horario;
        $this->profesor = $profesor;
        $this->colAlumnos = $colAlumnos;
        $this->colTemas = $colTemas;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getProfesor() {
        return $this->profesor;
    }

    public function getColAlumnos() {
        return $this->colAlumnos;
    }

    public function getColTemas() {
        return $this->colTemas;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function setProfesor($profesor) {
        $this->profesor = $profesor;
    }

    public function setColAlumnos($colAlumnos) {
        $this->colAlumnos = $colAlumnos;
    }

    public function setColTemas($colTemas) {
        $this->colTemas = $colTemas;
    }

}

?>