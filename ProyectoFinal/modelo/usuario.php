<?php

/* Gestion de los usuarios */

require_once "conexionDB.php";

abstract class usuario extends conexionDB {

    private $nombre;
    private $ci;
    private $sexo;
    private $email;
    private $clave;
    
    public function __construct($nombre, $ci, $sexo, $email, $clave) {
        $this->nombre = $nombre;
        $this->ci = $ci;
        $this->sexo = $sexo;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCi() {
        return $this->ci;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

}

?>