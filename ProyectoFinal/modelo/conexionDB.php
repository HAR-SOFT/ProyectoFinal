<?php

/* Conexion a la base de datos y funciones minimas necesarias */

class conexionDB {

    private $conexion;
    var $error;

    function conectar() {
        if (!isset($this->conexion)) {
            $this->conexion = (mysqli_connect("localhost", "root", "", "e-mer")) or die(mysqli_error());
        }
    }

    function seleccionDB($nombreDB) {
        $db = mysqli_select_db($this->conexion, $nombreDB);
        return $db;
    }

    function consulta($sql) {
        $resultado = mysqli_query($this->conexion, $sql);
        if (!$resultado) {
            echo 'MySQL Error: ' . mysqli_error();
            exit;
        }
        return $resultado;
    }

    /* function ejecutarConsulta($consulta) {
      $resultado = mysqli_query($this->conexion, $consulta);
      $this->error = mysqli_error($this->conexion);
      return $resultado;
      } */

    function cantidadRegistros($resultado) {
        $cant = mysqli_num_rows($resultado);
        return $cant;
    }

    function retornarRegistros($resultado) {
        $reg = mysqli_fetch_array($resultado);
        return $reg;
    }

    function cerrarDB() {
        mysqli_close($this->conexion);
    }

}

?>