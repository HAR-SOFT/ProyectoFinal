<?php

require_once "conexionDB.php";

class manejador extends conexionDB {
    
    private $mensaje;
    private $query;

    function listar($queryParametro, $mensajeParametro) {
        $this->conectar();
        $query = $this->consulta($queryParametro);
        $this->cerrarDB();
        if ($this->cantidadRegistros($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        }
        else {
            return $mensajeParametro;
        }
    }
    
    function listarCursos() {
        $this->query = "SELECT * FROM dim_cursos;";
        $this->mensaje = "No hay cursos para mostrar";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarAlumnosPorCurso($curso) {
        $this->query = "SELECT U.nombre, U.apellido
            FROM dim_usuarios AS U
            INNER JOIN dim_cursos AS C
            ON C.nombre = U.curso
            WHERE U.categoria_usuario = 'alumno'
            AND C.nombre = '$curso';";
        $this->mensaje = "No hay alumnos para el curso seleccionado";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarCursosActivos() {
        $this->query = "SELECT *
            FROM dim_cursos AS C
            WHERE C.activo = 1;";
        $this->mensaje = "No hay cursos activos";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarCursosInactivos() {
        $this->query = "SELECT *
            FROM dim_cursos AS C
            WHERE C.activo = 0;";
        $this->mensaje = "No hay cursos inactivos";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarUsuarios() {
        $this->query = "SELECT * FROM dim_usuarios;";
        $this->mensaje = "No hay usuarios para mostrar";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema
            FROM asc_cursos_temas_subtemas_ejercicio AS ASCCTSE
            WHERE ASCCTSE.nombre = '$nombreCurso';";
        $this->mensaje = "No hay temas para el curso seleccionado";
        
        return $this->listar($this->query, $this->mensaje);
    }
    
    function listarTemasSubTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema, 
            ASCCTSE.nombre_subtema
            FROM asc_cursos_temas_subtemas_ejercicio AS ASCCTSE
            WHERE ASCCTSE.nombre = '$nombreCurso';";
        $this->mensaje = "No hay temas para el curso seleccionado";
        
        return $this->listar($this->query, $this->mensaje);
    }
}

?>