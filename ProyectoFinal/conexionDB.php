<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cBase
{
    // <editor-fold defaultstate="collapsed" desc="atributos">
    private $conexion;
    var $error;
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="constructor">
    function __construct($servidor, $usuario, $password)
    {
        $this->conexion = mysqli_connect($servidor, $usuario, $password);
        if (!$this->conexion)
            die ("Error al conectarse al servidor");
    }
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="funcion seleccionBase">
    function seleccionBase($nombreBase)
    {
        $base = mysqli_select_db($this->conexion, $nombreBase);
//        if (!$base)
//            $this->error = "Error al seleccionar la base";
        return $base;
    }
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="funcion ejecutarConsulta">
    function ejecutarConsulta($consulta)
    {
        $resultado = mysqli_query($this->conexion, $consulta);
        $this->error = mysqli_error($this->conexion);
        return $resultado;
    }
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="funcion cantidadRegistros">
    // cantidad de registros de la consulta
    function cantidadRegistros($resultado)
    {
        $cant = mysqli_num_rows($resultado);
        return $cant;
    }
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="funcion retornarRegistros">
    //retorna a uno los registros de una consulta
    function retornarRegistros($resultado)
    {
        $reg = mysqli_fetch_array($resultado);
        return $reg;
    }
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="funcion cerrar la conexion">
    function cerrar()
    {
        mysqli_close($this->conexion);
    }
    // </editor-fold>

}

?>