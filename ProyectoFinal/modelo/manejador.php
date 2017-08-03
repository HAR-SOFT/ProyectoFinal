<?php

require_once "conexionDB.php";
require_once "mer.php";

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
    
    function buscarUsuario($ciUsuario, $claveUsuario) {
        $this->query = "SELECT * "
                . "FROM dim_usuarios AS U"
                . "WHERE U.ci = '$ciUsuario'"
                . "AND U.clave = '$claveUsuario';";
        $this->mensaje = "CI o clave incorrecta";
        
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
    
    function armarMer($nombreMer) {
        $this->query = "SELECT M.nombre, 
            M.colEntidades,
            M.colRelaciones,
            M.colAgregaciones,
            M.tipo,
            M.nombreEjercicio
            FROM sol_mer AS M
            WHERE M.nombre = '$nombreMer';";
        $this->mensaje = "No hay un MER con el nombre indicado";
        $resultado = $this->listar($this->query, $this->mensaje);
        
        /*for($i = 0, $size = count($people); $i < $size; ++$i) {
            $people[$i]['salt'] = mt_rand(000000, 999999);
        }*/
        
        return count($resultado[0]);
    }
    

}

?>