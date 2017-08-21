<?php

require_once "conexionDB.php";
require_once "mer.php";
require_once "alumno.php";
require_once "administrativo.php";
require_once "profesor.php";

class manejador extends conexionDB {
    
    private $mensaje;
    private $query;
    private $usuario;
    
    public function __construct() {
        
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getQuery() {
        return $this->query;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    
    function ejecutarQuery($queryParametro, $msjParametro) {
        $this->conectar();
        $query = $this->consulta($queryParametro);
        $this->cerrarDB();
        if (!$this->cantidadRegistros($query) == 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }
            
            return $datos;
        }
        else {
//            $this->mensaje = $msjParametro;
            $this->mensaje = 
                    "<div class='modal' style='display: block;'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                    <h4 class='modal-title'>Atención:</h4>
                                </div>
                                <div class='modal-body'>
                                    <p>$msjParametro</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>";
        }
    }
    
    function listarCursos() {
        $this->query = "SELECT * FROM dim_curso;";
        $msjListarCursos = "No hay cursos para mostrar";
        
        return $this->ejecutarQuery($this->query, $msjListarCursos);
    }
    
    function listarAlumnosPorCurso($curso) {
        $this->query = "SELECT U.nombre, U.apellido"
            . " FROM dim_usuario AS U"
            . " INNER JOIN dim_curso AS C"
            . " ON C.nombre = U.curso"
            . " WHERE U.categoria_usuario = 'alumno'"
            . " AND C.nombre = '$curso';";
        $msjListarAlumnosPorCurso = "No hay alumnos para el curso seleccionado.";
        
        return $this->ejecutarQuery($this->query, $msjListarAlumnosPorCurso);
    }
    
    function buscarCursoDeUsuario($ciUsuario) {
        $this->query = "SELECT C.nombre"
            . " FROM dim_curso AS C"
            . " INNER JOIN asc_curso_usuario AS CU"
            . " ON C.nombre = CU.nombre_curso"
            . " WHERE C.estado = 1"
            . " AND CU.ci_usuario = $ciUsuario";
        $buscarCursoDeUsuario = "No tiene ningún curso activo asigando."
            . " Comuníquese con Bedelía.";
        
        return $this->ejecutarQuery($this->query, $buscarCursoDeUsuario);
    }
    
    function listarCursosActivos() {
        $this->query = "SELECT *"
            . " FROM dim_curso AS C"
            . " WHERE C.activo = 1;";
        $msjListarCursosActivos = "No hay cursos activos.";
        
        return $this->ejecutarQuery($this->query, $msjListarCursosActivos);
    }
    
    function listarCursosInactivos() {
        $this->query = "SELECT *"
            . " FROM dim_curso AS C"
            . " WHERE C.activo = 0;";
        $msjListarCursosInactivos = "No hay cursos inactivos.";
        
        return $this->ejecutarQuery($this->query, $msjListarCursosInactivos);
    }
    
    function listarUsuarios() {
        $this->query = "SELECT * FROM dim_usuario;";
        $msjListarUsuarios = "No hay usuarios para mostrar.";
        
        return $this->ejecutarQuery($this->query, $msjListarUsuarios);
    }
    
    function buscarUsuario($ciUsuario, $claveUsuario) {
        $this->query = "SELECT U.ci,"
                . " U.nombre,"
                . " U.apellido,"
                . " U.sexo,"
                . " U.email,"
                . " U.clave,"
                . " U.telefono,"
                . " U.celular,"
                . " U.categoria_usuario "
                . " FROM dim_usuario AS U"
                . " WHERE U.ci = '$ciUsuario'"
                . " AND U.clave = '$claveUsuario';";
        $msjBuscarUsuario = "CI o clave incorrecta.";
        
        return $this->ejecutarQuery($this->query, $msjBuscarUsuario);
    }
    
    function login($ciParam, $claveParam) {
        $ci = $ciParam;
        $clave = $claveParam;

        $resultado = $this->buscarUsuario($ci, $clave);

        if (!$resultado == NULL) {
            $cursoUsuario = $this->buscarCursoDeUsuario($ci);
            if (!$cursoUsuario == NULL) {
                $categroiaUsuario = $resultado[0]["categoria_usuario"];

                switch ($categroiaUsuario) {
                    case "Alumno";
                        $usuario = new alumno($resultado[0]["ci"], 
                                $resultado[0]["nombre"], 
                                $resultado[0]["apellido"], 
                                $resultado[0]["sexo"], 
                                $resultado[0]["email"], 
                                $resultado[0]["clave"], 
                                $resultado[0]["telefono"], 
                                $resultado[0]["celular"],
                                $cursoUsuario);
                        break;
                    case "Administrativo";
                        $usuario = new administrativo($resultado[0]["ci"], 
                                $resultado[0]["nombre"], 
                                $resultado[0]["apellido"], 
                                $resultado[0]["sexo"], 
                                $resultado[0]["email"], 
                                $resultado[0]["clave"], 
                                $resultado[0]["telefono"]);
                        break;
                    case "Profesor";
                        $usuario = new profesor($resultado[0]["ci"], 
                                $resultado[0]["nombre"], 
                                $resultado[0]["apellido"], 
                                $resultado[0]["sexo"], 
                                $resultado[0]["email"], 
                                $resultado[0]["clave"], 
                                $resultado[0]["telefono"], 
                                $resultado[0]["celular"]);
                        break;
                }

                session_start();
                $_SESSION["usuario"] = $usuario;
                $this->usuario = $usuario;
                
//                header("location: http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=ingresar");
            }
        }
    }
    
    function irInicioUsuario($usuario) {
        
    }
            
    function listarTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema"
            . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
            . " WHERE ASCCTSE.nombre = '$nombreCurso';";
        $msjListarTemasPorCurso = "No hay temas para el curso seleccionado.";
        
        return $this->ejecutarQuery($this->query, $msjListarTemasPorCurso);
    }
    
    function listarTemasSubTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema, "
            . " ASCCTSE.nombre_subtema"
            . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
            . " WHERE ASCCTSE.nombre = '$nombreCurso';";
        $msjListarTemasSubTemasPorCurso = "No hay temas para el curso seleccionado.";
        
        return $this->ejecutarQuery($this->query, $msjListarTemasSubTemasPorCurso);
    }
    
    function armarMer($nombreMer) {
        $this->query = "SELECT M.nombre, "
            . " M.colEntidades,"
            . " M.colRelaciones,"
            . " M.colAgregaciones,"
            . " M.tipo,"
            . " M.nombreEjercicio"
            . " FROM sol_mer AS M"
            . " WHERE M.nombre = '$nombreMer';";
        $msjArmarMer = "No hay un MER con el nombre indicado.";
        
        $resultado = $this->ejecutarQuery($this->query, $msjArmarMer);
        
        if (!$resultado == NULL) {
            $nombreMer = $resultado[0][0];
            $colEntidadesMer = [$resultado[0][1]];
            $colRelacionesMer = [$resultado[0][2]];
            $colAgregacionesMer = [$resultado[0][3]];
            $tipoMer = $resultado[0][4];
            $nombreEjercicioMer = $resultado[0][5];
            
            $mer = new mer($nombreMer, $colEntidadesMer, $colRelacionesMer, $colAgregacionesMer, $tipoMer, $nombreEjercicioMer);
            
            return $mer;
        }
    }
    
    function altaProfesor()
            {
        
         $valor = $_POST('sexo');
    
        //Faltan los nombre de los inputs
        $ciUsuario = $_POST('inputCI');
        $nombreUsuario = $_POST('inputNombre');
        $apellidoUsuario = $_POST('inputApellido');
        $sexoUsuario = $_POST('$valor');
        $emailUsuario = $_POST('inputMail');
        $claveUsuario= md5($ciUsuario);
        $telefonoUsuario = $_POST('inputTelefono');
        $celularUsuario = $_POST('inputCelular');
        
 
       $this->query ="INSERT INTO dim_usuarios (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
               . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','profesor')";
     
      $this->mensaje = "Profesor no insertado";
      $resultado=$this->ejecutarQuery($this->query, $this->mensaje);
      return $resultado;
    }
    
    
     function altaAlumno() {
    
         
         $valor = $_POST('sexo');
          //Faltan los nombre de los inputs
        $ciUsuario = $_POST('inputCI');
        $nombreUsuario = $_POST('inputNombre');
        $apellidoUsuario = $_POST('inputApellido');
        $sexoUsuario = $_POST('$valor');
        $emailUsuario = $_POST('inputMail');
        $claveUsuario= md5($ciUsuario);
        $telefonoUsuario = $_POST('inputTelefono');
        $celularUsuario = $_POST('inputCelular');
               
       $this->query ="INSERT INTO dim_usuarios (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
               . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','alumno')";
     
      $this->mensaje = "Alumno no insertado";
      $resultado=$this->ejecutarQuery($this->query, $this->mensaje);
      return $resultado;
          }
}

?>
