<?php

/* Gestion de los cursos */

require_once "conexionDB.php";

class cursos extends conexionDB {

    private $mensaje;

    function listarCursos() {
        $this->conectar();
        $query = $this->consulta("SELECT * FROM cursos;");
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        } else {
            $this->mensaje = "No hay cursos para mostrar";
        }
    }

    function listarAlumnosPorCurso($curso) {
        $this->conectar();
        $query = $this->consulta("SELECT U.nombre, U.apellido
            FROM usuarios AS U
            INNER JOIN cursos AS C
            ON C.nombre = U.curso
            WHERE U.categoria_usuario = 'alumno'
            AND C.nombre = '$curso';");
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        } else {
            $this->mensaje = "No hay alumnos para el curso seleccionado";
        }
    }

    function listarCursosActivos() {
        $this->conectar();
        $query = $this->consulta("SELECT *
            FROM cursos AS C
            WHERE C.activo = 1;");
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        } else {
            $this->mensaje = "No hay alumnos para el curso seleccionado";
        }
    }
    
    function listarCursosInactivos() {
        $this->conectar();
        $query = $this->consulta("SELECT *
            FROM cursos AS C
            WHERE C.activo = 0;");
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        } else {
            $this->mensaje = "No hay alumnos para el curso seleccionado";
        }
    }

}

?>