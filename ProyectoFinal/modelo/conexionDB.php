<?php

/* Conexion a la base de datos y funciones minimas necesarias */

class conexionDB {

    private $conexion;
    var $error;

    public function conectar() {
        try {
            $this->conexion = mysqli_connect("localhost", "root", "", "e-mer");
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function seleccionDB($nombreDB) {
        try {
            $db = mysqli_select_db($this->conexion, $nombreDB);
            return $db;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function consulta($sql) {
        try {
            $resultado = mysqli_query($this->conexion, $sql);
            return $resultado;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function cantidadRegistros($resultado) {
//        var_dump(gettype($resultado));
        try {
            $cant = mysqli_num_rows($resultado);
            return $cant;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function retornarRegistros($resultado) {
        try {
            $reg = mysqli_fetch_array($resultado);
            return $reg;
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function cerrarDB() {
        try {
            mysqli_close($this->conexion);
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }
    
}

?>