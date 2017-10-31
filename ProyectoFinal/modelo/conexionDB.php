<?php

/* Conexion a la base de datos y funciones minimas necesarias */

class conexionDB {

    private $conexion;
    var $error;

    public function conectar() {
        try {
            $this->conexion = mysqli_connect("localhost", "root", "", "e-mer");
            $this->conexion->set_charset("utf8");
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
    
    public function autocommit($estado = false) {
        try {
            $this->conexion->autocommit($estado);
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }
    
    public function commit() {
        try {
            $this->conexion->commit();
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }
    
    public function rollback() {
        try {
            $this->conexion->rollback();
        } catch (Exception $ex) {
            echo "Excepción capturada: ",  $ex->getMessage(), "\n";
        }
    }

    public function cantidadRegistros($resultado) {
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
