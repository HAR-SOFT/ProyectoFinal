<?php

require_once "conexionDB.php";
require_once "mer.php";
require_once "usuario.php";
require_once "alumno.php";
require_once "administrativo.php";
require_once "profesor.php";
require_once "../html/alumnoTeorico.php";

class manejador extends conexionDB {

    private $mensaje;
    private $query;
    private $usuario;
    private $nombreUsuario;
    private $apellidoUsuario;
    private $categoriaUsuario;
    private $tema;

    public function __construct() {
        
    }

    public function getMensajeManejador() {
        return $this->mensaje;
    }

    public function getQueryManejador() {
        return $this->query;
    }

    public function setMensajeManejador($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setQueryManejador($query) {
        $this->query = $query;
    }

    public function getUsuarioManejador() {
        return $this->usuario;
    }

    public function setUsuarioManejador($usuario) {
        $this->usuario = $usuario;
    }

    public function getNombreUsuarioManejador() {
        return $this->nombreUsuario;
    }

    public function getApellidoUsuarioManejador() {
        return $this->apellidoUsuario;
    }

    public function setNombreUsuarioManejador($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setApellidoUsuarioManejador($apellidoUsuario) {
        $this->apellidoUsuario = $apellidoUsuario;
    }

    public function getCategoriaUsuarioManejador() {
        return $this->categoriaUsuario;
    }

    public function setCategoriaUsuarioManejador($categoriaUsuario) {
        $this->categoriaUsuario = $categoriaUsuario;
    }

    public function ejecutarQuery($queryParametro, $msjParametro) {
        $this->conectar();
        $query = $this->consulta($queryParametro);
        $this->cerrarDB();
        if (!$this->cantidadRegistros($query) == 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($array = $this->retornarRegistros($query)) {
                $datos[] = $array;
            }

            return $datos;
        } else {
//            $this->mensaje = $msjParametro;
            $this->mensaje = "<div class='modal' style='display: block;'>
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

    public function listarCursos() {
        $this->query = "SELECT * FROM dim_curso;";
        $msjListarCursos = "No hay cursos para mostrar";

        return $this->ejecutarQuery($this->query, $msjListarCursos);
    }

    public function listarAlumnosPorCurso($curso) {
        $this->query = "SELECT U.nombre, U.apellido"
                . " FROM dim_usuario AS U"
                . " INNER JOIN dim_curso AS C"
                . " ON C.nombre = U.curso"
                . " WHERE U.categoria_usuario = 'alumno'"
                . " AND C.nombre = '$curso';";
        $msjListarAlumnosPorCurso = "No hay alumnos para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjListarAlumnosPorCurso);
    }

    public function buscarCursoDeUsuario($ciUsuario) {
        $this->query = "SELECT C.nombre_curso"
                . " FROM asc_curso_usuario AS C"
                . " WHERE C.ci_usuario = $ciUsuario";
        $buscarCursoDeUsuario = "No tiene ningún curso activo asigando."
                . " Comuníquese con Bedelía.";

        return $this->ejecutarQuery($this->query, $buscarCursoDeUsuario);
    }

    public function listarCursosActivos() {
        $this->query = "SELECT *"
                . " FROM dim_curso AS C"
                . " WHERE C.estado = 1;";
        $msjListarCursosActivos = "No hay cursos activos.";

        return $this->ejecutarQuery($this->query, $msjListarCursosActivos);
    }

    public function listarCursosInactivos() {
        $this->query = "SELECT *"
                . " FROM dim_curso AS C"
                . " WHERE C.estado = 0;";
        $msjListarCursosInactivos = "No hay cursos inactivos.";

        return $this->ejecutarQuery($this->query, $msjListarCursosInactivos);
    }

    public function listarUsuarios() {
        $this->query = "SELECT * FROM dim_usuario;";
        $msjListarUsuarios = "No hay usuarios para mostrar.";

        return $this->ejecutarQuery($this->query, $msjListarUsuarios);
    }

    public function buscarUsuario($ciUsuario, $claveUsuario) {
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

    public function login($ciParam, $claveParam) {
        $ci = $ciParam;
        $clave = $claveParam;

        $resultado = $this->buscarUsuario($ci, $clave);

        if (!$resultado == NULL) {
            $categroiaUsuario = $resultado[0]["categoria_usuario"];
            switch ($categroiaUsuario) {
                case "Alumno";
                    $cursoUsuario = $this->buscarCursoDeUsuario($ci);
                    if (!$cursoUsuario == NULL) {
                        $usuario = new alumno($resultado[0]["ci"], $resultado[0]["nombre"], $resultado[0]["apellido"], $resultado[0]["sexo"], $resultado[0]["email"], $resultado[0]["clave"], $resultado[0]["telefono"], $resultado[0]["celular"], $cursoUsuario);
                    }
                    break;
                case "Administrativo";
                    $usuario = new administrativo($resultado[0]["ci"], $resultado[0]["nombre"], $resultado[0]["apellido"], $resultado[0]["sexo"], $resultado[0]["email"], $resultado[0]["clave"], $resultado[0]["telefono"], $resultado[0]["celular"]);
                    break;
                case "Profesor";
                    $cursosProfesor = $this->buscarCursoDeUsuario($ci);
                    if (!$cursosProfesor == NULL) {
                        $usuario = new profesor($resultado[0]["ci"], $resultado[0]["nombre"], $resultado[0]["apellido"], $resultado[0]["sexo"], $resultado[0]["email"], $resultado[0]["clave"], $resultado[0]["telefono"], $resultado[0]["celular"], $cursosProfesor);
                    }
                    break;
            }

            if (!$this->mensaje) {
                $this->usuario = $usuario;
                $this->nombreUsuario = $usuario->getNombre();
                $this->apellidoUsuario = $usuario->getApellido();
                $this->categoriaUsuario = $categroiaUsuario;
            }
        }
    }

    public function listarTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema"
                . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
                . " WHERE ASCCTSE.nombre = '$nombreCurso';";
        $msjListarTemasPorCurso = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjListarTemasPorCurso);
    }

    public function listarTemasSubTemasPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema, "
                . " ASCCTSE.nombre_subtema"
                . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
                . " WHERE ASCCTSE.nombre_curso = '$nombreCurso';";
        $msjListarTemasSubTemasPorCurso = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjListarTemasSubTemasPorCurso);
    }

    public function armarMer($nombreMer) {
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

    public function altaProfesor() {

        $valor = $_POST('sexo');

        //Faltan los nombre de los inputs
        $ciUsuario = $_POST('inputCI');
        $nombreUsuario = $_POST('inputNombre');
        $apellidoUsuario = $_POST('inputApellido');
        $sexoUsuario = $_POST('$valor');
        $emailUsuario = $_POST('inputMail');
        $claveUsuario = md5($ciUsuario);
        $telefonoUsuario = $_POST('inputTelefono');
        $celularUsuario = $_POST('inputCelular');


        $this->query = "INSERT INTO dim_usuario (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
                . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','Profesor')";

        $this->mensaje = "Profesor no insertado";
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);
        return $resultado;
    }

    public function altaAlumno() {


        $valor = $_POST('sexo');
        //Faltan los nombre de los inputs
        $ciUsuario = $_POST('inputCI');
        $nombreUsuario = $_POST('inputNombre');
        $apellidoUsuario = $_POST('inputApellido');
        $sexoUsuario = $_POST('$valor');
        $emailUsuario = $_POST('inputMail');
        $claveUsuario = md5($ciUsuario);
        $telefonoUsuario = $_POST('inputTelefono');
        $celularUsuario = $_POST('inputCelular');

        $this->query = "INSERT INTO dim_usuario (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,celular,categoria_usuario) "
                . "VALUE ('null','$ciUsuario','$nombreUsuario', '$apellidoUsuario', '$sexoUsuario', '$emailUsuario', '$claveUsuario', '$telefonoUsuario','$celularUsuario','Alumno')";

        $this->mensaje = "Alumno no insertado";
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);
        return $resultado;
    }

    function menuManejador($nombreCurso) {

        
        //consulta para listar los Temas
         $this->queryTema = "SELECT DISTINCT
                     ASCCTSE.nombre_tema,
                     dt.indice
                     FROM
                     asc_curso_tema_subtema_ejercicio AS ASCCTSE , dim_tema dt
                     WHERE
                     dt.nombre= ASCCTSE.nombre_tema
                     AND ASCCTSE.nombre_curso = '$nombreCurso'
                     order by dt.indice
                     ";

        //se ejecuta la consulta de temas
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);

        
   

        
    }

    function temaManejador($tema) {

        $this->query = "SELECT
                     dt.letra
                     FROM
                     asc_curso_tema_subtema_ejercicio AS ASCCTSE , dim_tema dt
                     WHERE
                     dt.nombre= ASCCTSE.nombre_tema
                     AND ASCCTSE.nombre_curso = 'ATI 2017 20-22'
                     AND ASCCTSE.nombre_tema = '$tema'";

        $this->mensaje = "No hay letra para ese tema";
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);


        //var_dump($resultado);

        if ($resultado) {

            foreach ($resultado as $letra)
                echo $letra['letra'];
        } else {

            return $resultado;
        }
    }

}

?>
