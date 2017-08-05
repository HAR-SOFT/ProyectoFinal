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
        $this->query = "SELECT * "
                . "FROM dim_usuarios AS U"
                . "WHERE U.ci = '$ciUsuario'"
                . "AND U.clave = '$claveUsuario';";
        $this->mensaje = "CI o clave incorrecta";
        
        return $this->ejecutarQuery($this->query, $this->mensaje);
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
    
    function altaProfesor()
        //    $ciUsuario, $nombreUsuario, $apellidoUsuario, $sexoUsuario, $emailUsuario, $claveUsuario, $telefonoUsuario,$celularUsuario
            {
    
        $ciUsuario = $_POST('');
        $apellidoUsuario = 
        $sexoUsuario = 
        
        
       $claveUsuario= md5($ciUsuario);
       $this->query ="INSERT INTO dim_usuarios (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
               . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','profesor')";
     
      $this->mensaje = "Profesor no insertado";
      $resultado=$this->ejecutarQuery($this->query, $this->mensaje);
      return $resultado;
    }
    
    
     function altaAlumno($ciUsuario, $nombreUsuario, $apellidoUsuario, $sexoUsuario, $emailUsuario, $claveUsuario, $telefonoUsuario,$celularUsuario) {
    
       $claveUsuario= md5($ciUsuario);
       $this->query ="INSERT INTO dim_usuarios (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
               . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','alumno')";
     
      $this->mensaje = "Alumno no insertado";
      $resultado=$this->ejecutarQuery($this->query, $this->mensaje);
      return $resultado;
          }
}

?>