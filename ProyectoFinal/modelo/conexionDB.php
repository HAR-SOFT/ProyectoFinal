<?php

/* Conexion a la base de datos y funciones minimas necesarias */

class conexionDB {

    private $conexion;
    var $error;

    function conectar() {
        try {
            $this->conexion = mysqli_connect("localhost", "root", "", "e-mer");
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    function seleccionDB($nombreDB) {
        try {
            $db = mysqli_select_db($this->conexion, $nombreDB);
            return $db;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    function consulta($sql) {
        try {
            $resultado = mysqli_query($this->conexion, $sql);
            return $resultado;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    function cantidadRegistros($resultado) {
        try {
            $cant = mysqli_num_rows($resultado);
            return $cant;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    function retornarRegistros($resultado) {
        try {
            $reg = mysqli_fetch_array($resultado);
            return $reg;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    function cerrarDB() {
        try {
            mysqli_close($this->conexion);
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

}

?>