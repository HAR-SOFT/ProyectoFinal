<?php

require_once "conexionDB.php";
require_once "mer.php";
require_once "usuario.php";
require_once "alumno.php";
require_once "administrativo.php";
require_once "profesor.php";

class manejador extends conexionDB {

    private $mensaje;
    private $query;
    private $usuario;
    private $ciUsuario;
    private $nombreUsuario;
    private $apellidoUsuario;
    private $claveActualUsuario;
    private $categoriaUsuario;
    private $cursoUsuario;

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

    public function getCiUsuarioManejador() {
        return $this->ciUsuario;
    }

    public function getClaveActualUsuarioManejador() {
        return $this->claveActualUsuario;
    }

    public function setCiUsuarioManejador($ciUsuario) {
        $this->ciUsuario = $ciUsuario;
    }

    public function setClaveActualUsuarioManejador($claveActualUsuario) {
        $this->claveActualUsuario = $claveActualUsuario;
    }

    public function getCursoUsuarioManejador() {
        return $this->cursoUsuario;
    }

    public function setCursoUsuarioManejador($cursoUsuario) {
        $this->cursoUsuario = $cursoUsuario;
    }

    public function ejecutarQuery($queryParametro, $msjParametro) {
        $this->conectar();
        $query = $this->consulta($queryParametro);
        $this->cerrarDB();
//        var_dump(strpos($queryParametro, "UPDATE"));
        if (strpos($queryParametro, "UPDATE") !== false) {
            $this->mensaje = $msjParametro;
        } else {
            if (!$this->cantidadRegistros($query) == 0) {
                while ($array = $this->retornarRegistros($query)) {
                    $datos[] = $array;
                }

                return $datos;
            } else {
                $this->mensaje = $msjParametro;
            }
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
                . " AND C.nombre = '$curso'";
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

    public function cursoAsingadosProfesor($ciUsuario) {
        $this->query = "SELECT DISTINCT "
                . " curso.id_curso as id_curso,"
                . " c.nombre_curso as nombre_curso,"
                . " curso.horario as horario,"
                . " GROUP_CONCAT(DISTINCT dt.nombre SEPARATOR ' - ') as tema,"
                . " asctse.nombre_ejercicio as ejercicio,"
                . " if(curso.estado = 1 , 'activo' , 'finalizado') as estado"
                . " FROM"
                . " asc_curso_usuario AS c,"
                . " dim_curso AS curso,"
                . " asc_curso_tema_subtema_ejercicio AS asctse,"
                . " dim_tema AS dt"
                . " WHERE c.ci_usuario = '$ciUsuario'"
                . " AND c.nombre_curso = asctse.nombre_curso"
                . " AND dt.nombre = asctse.nombre_tema"
                . " AND curso.nombre = c.nombre_curso"
                . " GROUP BY nombre_curso , horario ,ejercicio,estado;";
        $cursoAsingadosProfesor = "No tiene ningún curso activo asigando."
                . " Comuníquese con Bedelía.";

        return $this->ejecutarQuery($this->query, $cursoAsingadosProfesor);
    }

    public function editarCursoManejador($nombreCurso) {
        $this->query = "SELECT "
                . " curso.id_curso as id_curso,"
                . " c.nombre_curso as nombre_curso,"
                . " dt.nombre as tema,"
                . " asctse.nombre_subtema as nombre_subtema,"
                . " asctse.nombre_ejercicio as ejercicio"
                . " FROM"
                . " asc_curso_usuario AS c,"
                . " dim_curso AS curso,"
                . " asc_curso_tema_subtema_ejercicio AS asctse,"
                . " dim_tema AS dt"
                . " WHERE curso.nombre = '$nombreCurso'"
                . " AND c.nombre_curso = asctse.nombre_curso"
                . " AND dt.nombre = asctse.nombre_tema"
                . " AND curso.nombre = c.nombre_curso"
                . " group by nombre_curso , tema ,nombre_subtema, ejercicio";
        $editarCurso = "No tiene ningún curso activo asigando."
                . " Comuníquese con Bedelía.";

        return $this->ejecutarQuery($this->query, $editarCurso);
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

    public function listarUsuariosYCurso() {
        $this->query = "SELECT du.ci as ci ,"
                . " concat(du.nombre,' ',du.apellido) as alumno ,"
                . " acu.nombre_curso as curso"
                . " FROM dim_usuario du , asc_curso_usuario acu , dim_curso dc"
                . " where du.categoria_usuario = 'Alumno'"
                . " and du.ci = acu.ci_usuario"
                . " and acu.nombre_curso = dc.nombre"
                . " and dc.estado = 1;";
        $listarUsuariosYCurso = "No hay usuarios para mostrar.";

        return $this->ejecutarQuery($this->query, $listarUsuariosYCurso);
    }

    public function listarProfesosYCurso() {
        $this->query = "SELECT du.ci as ci , "
                . " concat(du.nombre,' ',du.apellido) as profesor ,"
                . " acu.nombre_curso as curso"
                . " FROM dim_usuario du , asc_curso_usuario acu , dim_curso dc"
                . " where du.categoria_usuario = 'Profesor'"
                . " and du.ci = acu.ci_usuario"
                . " and acu.nombre_curso = dc.nombre"
                . " and dc.estado = 1;";
        $listarProfesosYCurso = "No hay usuarios para mostrar.";

        return $this->ejecutarQuery($this->query, $listarProfesosYCurso);
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
                        $usuario = new alumno($resultado[0]["ci"], 
                                $resultado[0]["nombre"], 
                                $resultado[0]["apellido"], 
                                $resultado[0]["sexo"], 
                                $resultado[0]["email"], 
                                $resultado[0]["clave"], 
                                $resultado[0]["telefono"], 
                                $resultado[0]["celular"], 
                                $cursoUsuario);
                        $this->cursoUsuario = $cursoUsuario;
                    }
                    break;
                case "Administrativo";
                    $usuario = new administrativo($resultado[0]["ci"], 
                            $resultado[0]["nombre"], 
                            $resultado[0]["apellido"], 
                            $resultado[0]["sexo"], 
                            $resultado[0]["email"], 
                            $resultado[0]["clave"], 
                            $resultado[0]["telefono"], 
                            $resultado[0]["celular"]);
                    break;
                case "Profesor";
                    $cursosProfesor = $this->buscarCursoDeUsuario($ci);
                    if (!$cursosProfesor == NULL) {
                        $usuario = new profesor($resultado[0]["ci"], 
                                $resultado[0]["nombre"], 
                                $resultado[0]["apellido"], 
                                $resultado[0]["sexo"], 
                                $resultado[0]["email"], 
                                $resultado[0]["clave"], 
                                $resultado[0]["telefono"], 
                                $resultado[0]["celular"], 
                                $cursosProfesor);
                        $this->cursoUsuario = $cursosProfesor;
                    }
                    break;
            }

            if (!$this->mensaje) {
                $this->usuario = $usuario;
                $this->ciUsuario = $usuario->getCi();
                $this->nombreUsuario = $usuario->getNombre();
                $this->apellidoUsuario = $usuario->getApellido();
                $this->claveActualUsuario = $usuario->getClave();
                $this->categoriaUsuario = $categroiaUsuario;
            }
        }
    }

//
    public function listarTemasPorCurso($nombreCurso) {
        $nombreCurso = $nombreCurso[0]["nombre_curso"];

        $this->query = "SELECT DISTINCT ASCCTSE.nombre_tema"
                . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
                . " WHERE ASCCTSE.nombre_curso = '$nombreCurso'";
        $msjListarTemasPorCurso = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjListarTemasPorCurso);
    }

    public function listarSubTemasPorCursoYTema($nombreCurso, $tema) {
        $nombreCurso = $nombreCurso[0]["nombre_curso"];
        $tema = $tema[0]['nombre_tema'];

        $this->query = " SELECT ASCCTSE.nombre_subtema  "
                . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE "
                . " WHERE ASCCTSE.nombre_curso = '$nombreCurso'"
                . " and ASCCTSE.nombre_tema = '$tema'";
        $msjlistarSubTemasPorCursoYTema = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjlistarSubTemasPorCursoYTema);
    }
    
    public function listarTemasSubTemasEjercicioPorCurso($nombreCurso) {
        $this->query = "SELECT ASCCTSE.nombre_tema, "
                . " ASCCTSE.nombre_subtema,"
                . " ASCCTSE.nombre_ejercicio"
                . " FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE"
                . " WHERE ASCCTSE.nombre_curso = '$nombreCurso';";
        $msjListarTemasSubTemasPorCurso = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjListarTemasSubTemasPorCurso);
    }
    
    public function armarMerSolucionSistema($nombreEjercicio) {
        $this->query = "SELECT M.nombre "
                . " FROM sol_mer AS M"
                . " WHERE M.nombre_ejercicio = '$nombreEjercicio'"
                . " AND M.tipo = 'sol_sistema';";
        $msjArmarMer = "No hay un MER para el ejercicio indicado. Comuníquese con Bedelía.";

        $resutado = $this->ejecutarQuery($this->query, $msjArmarMer);
        $nombreMer = $resutado[0]["nombre"];
        
        if (isset($nombreMer)) {
            $this->query = "SELECT E.nombre, "
                    . " E.tipo_entidad, "
                    . " E.entidad_supertipo, "
                    . " E.atributo_simple, "
                    . " E.atributo_multivaluado, "
                    . " E.agregacion, "
                    . " E.nombre_mer, "
                    . " E.tipo_categorizacion "
                    . " FROM sol_entidad AS E"
                    . " WHERE E.nombre_mer = '$nombreMer'";
            $msjArmarMer = "No hay un MER para el ejercicio indicado.";

            $colEntidades = $this->ejecutarQuery($this->query, $msjArmarMer);
        }
        
        if (isset($colEntidades)) {
            $this->query = "SELECT R.nombre, "
                    . " R.nombre_entidadA, "
                    . " R.nombre_entidadB, "
                    . " R.cardinalidadA, "
                    . " R.cardinalidadB, "
                    . " R.nombre_atributo_simple, "
                    . " R.nombre_mer "
                    . " FROM sol_relacion AS R"
                    . " WHERE R.nombre_mer = '$nombreMer'";
            $msjArmarMer = "No hay un MER para el ejercicio indicado.";

            $colRelaciones = $this->ejecutarQuery($this->query, $msjArmarMer);
        }
        
        if (!$this->mensaje) {
            $nombreMer = $nombreMer;
            $colEntidadesMer = $colEntidades[0];
            $colRelacionesMer = $colRelaciones[0];

            $mer = new mer($nombreMer, $colEntidadesMer, $colRelacionesMer);

            return $mer;
        }
    }
    
    public function guardarMerSolucionAlumno($nombreMer, $ci, $nombreEjercicio) {
        $this->query = "UPDATE"
        . " dim_usuario"
        . " SET clave = '$claveNuevaParam'"
        . " WHERE ci = '$ci';";
        $msjCambiarClaveManejador = "Clave actualizada correctamente.";

        return $this->ejecutarQuery($this->query, $msjCambiarClaveManejador);
    }
    
    public function cambiarClaveManejador($ci, $claveNuevaParam) {
        $this->query = "UPDATE"
                . " dim_usuario"
                . " SET clave = '$claveNuevaParam'"
                . " WHERE ci = '$ci';";
        $msjCambiarClaveManejador = "Clave actualizada correctamente.";

        return $this->ejecutarQuery($this->query, $msjCambiarClaveManejador);
    }

    public function altaProfesor() {
        $valor = $_POST("sexo");

        //Faltan los nombre de los inputs
        $ciUsuario = $_POST("inputCI");
        $nombreUsuario = $_POST("inputNombre");
        $apellidoUsuario = $_POST("inputApellido");
        $sexoUsuario = $_POST("$valor");
        $emailUsuario = $_POST("inputMail");
        $claveUsuario = md5($ciUsuario);
        $telefonoUsuario = $_POST("inputTelefono");
        $celularUsuario = $_POST("inputCelular");

        $this->query = "INSERT INTO dim_usuario"
                . " (id_usuario,ci,nombre,apellido,sexo,email,clave,telefono,"
                . " celular,categoria_usuario)"
                . " VALUE ('null','$ciUsuario','$nombreUsuario', "
                . " '$apellidoUsuario', '$sexoUsuario', '$emailUsuario',"
                . " '$claveUsuario', '$telefonoUsuario','$celularUsuario','Profesor')";
        $this->mensaje = "Profesor no insertado";
        
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);
        return $resultado;
    }

    public function altaAlumno() {
        $valor = $_POST("sexo");
        //Faltan los nombre de los inputs
        $ciUsuario = $_POST("inputCI");
        $nombreUsuario = $_POST("inputNombre");
        $apellidoUsuario = $_POST("inputApellido");
        $sexoUsuario = $_POST("$valor");
        $emailUsuario = $_POST("inputMail");
        $claveUsuario = md5($ciUsuario);
        $telefonoUsuario = $_POST("inputTelefono");
        $celularUsuario = $_POST("inputCelular");

        $this->query = "INSERT INTO dim_usuario"
                . " (id_usuario,ci,nombre,apellido,sexo,email,clave,"
                . " telefono,celular,categoria_usuario)"
                . " VALUE ('null','$ciUsuario','$nombreUsuario',"
                . " '$apellidoUsuario', '$sexoUsuario', '$emailUsuario',"
                . " '$claveUsuario', '$telefonoUsuario','$celularUsuario','Alumno')";
        $this->mensaje = "Alumno no insertado";
        
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);
        return $resultado;
    }

    public function temaManejador($tema) {
        $this->query = "SELECT"
                . " dt.letra"
                . " FROM"
                . " dim_subtema dt"
                . " WHERE"
                . " dt.nombre = '$tema'";
        $this->mensaje = "No hay letra para ese tema";
        
        $resultado = $this->ejecutarQuery($this->query, $this->mensaje);

        if ($resultado) {
            foreach ($resultado as $letra)
                echo $letra["letra"];
        } else {
            return $resultado;
        }
    }

}

?>
