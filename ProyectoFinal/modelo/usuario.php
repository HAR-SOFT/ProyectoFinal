<?php

/* Gestion de los usuarios */

require_once "conexionDB.php";

abstract class usuario extends conexionDB {

    private $ci;
    private $nombre;
    private $apellido;
    private $sexo;
    private $email;
    private $clave;
    private $telefono;
    private $celular;
    
    public function __construct($ci, $nombre, $apellido, $sexo, $email, $clave, $telefono, $celular) {
        $this->ci = $ci;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->sexo = $sexo;
        $this->email = $email;
        $this->clave = $clave;
        $this->telefono = $telefono;
        $this->celular = $celular;
    }

    public function getCi() {
        return $this->ci;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
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

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
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

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

}

?>