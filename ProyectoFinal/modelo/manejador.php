<?php

require_once "conexionDB.php";
require_once "mer.php";

class manejador extends conexionDB {
    
    private $mensaje;
    private $query;

    function ejecutarQuery($queryParametro, $mensajeParametro) {
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
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function listarAlumnosPorCurso($curso) {
        $this->query = "SELECT U.nombre, U.apellido
            FROM dim_usuarios AS U
            INNER JOIN dim_cursos AS C
            ON C.nombre = U.curso
            WHERE U.categoria_usuario = 'alumno'
            AND C.nombre = '$curso';";
        $this->mensaje = "No hay alumnos para el curso seleccionado";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function listarCursosActivos() {
        $this->query = "SELECT *
            FROM dim_cursos AS C
            WHERE C.activo = 1;";
        $this->mensaje = "No hay cursos activos";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function listarCursosInactivos() {
        $this->query = "SELECT *
            FROM dim_cursos AS C
            WHERE C.activo = 0;";
        $this->mensaje = "No hay cursos inactivos";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function listarUsuarios() {
        $this->query = "SELECT * FROM dim_usuarios;";
        $this->mensaje = "No hay usuarios para mostrar";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function buscarUsuario($ciUsuario, $claveUsuario) {
        $this->query = "SELECT U.ci,"
                . "U.nombre,"
                . "U.apellido,"
                . "U.sexo,"
                . "U.email,"
                . "U.clave,"
                . "U.telefono,"
                . "U.celular,"
                . "U.categoria_usuario "
                . "FROM dim_usuarios AS U"
                . "WHERE U.ci = '$ciUsuario'"
                . "AND U.clave = '$claveUsuario';";
        $this->mensaje = "CI o clave incorrecta";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function login() {
        $ci = $_POST["ci"];
        $clave = $_POST["clave"];
        
        $resultado = $this->buscarUsuario($ci, $clave);
        
        if (gettype($resultado) == "array") {
            
        }
    }
    
    function listarTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema
            FROM asc_cursos_temas_subtemas_ejercicio AS ASCCTSE
            WHERE ASCCTSE.nombre = '$nombreCurso';";
        $this->mensaje = "No hay temas para el curso seleccionado";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
    }
    
    function listarTemasSubTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema, 
            ASCCTSE.nombre_subtema
            FROM asc_cursos_temas_subtemas_ejercicio AS ASCCTSE
            WHERE ASCCTSE.nombre = '$nombreCurso';";
        $this->mensaje = "No hay temas para el curso seleccionado";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
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
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);
        
        if ($resultado <> $this->mensaje) {
            $nombreMer = $resultado[0][0];
            $colEntidadesMer = [$resultado[0][1]];
            $colRelacionesMer = [$resultado[0][2]];
            $colAgregacionesMer = [$resultado[0][3]];
            $tipoMer = $resultado[0][4];
            $nombreEjercicioMer = $resultado[0][5];
            
            $mer = new mer($nombreMer, $colEntidadesMer, $colRelacionesMer, $colAgregacionesMer, $tipoMer, $nombreEjercicioMer);
            
            return $mer;
        }
        else {
            return $resultado;
        }
    }
    
}

?>