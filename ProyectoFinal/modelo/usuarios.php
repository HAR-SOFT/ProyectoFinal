<?php

/* Gestion de los usaurios */

require_once "conexionDB.php";

class usuarios extends conexionDB {
    
    private $mensaje;

    function listarUsuarios() {
        $this->conectar();
        $query = $this->consulta("SELECT * FROM usuarios;");
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        }
        else {
            $this->mensaje = "No hay usuarios para mostrar";
        }
    }
}

?>