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
// var_dump(strpos($queryParametro, "UPDATE"));
        if (strpos($queryParametro, "INSERT" ) !== false) {
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
    
     public function ejecutarTransaccion($queryParametro, $msjParametro) {
        $this->conectar();
        $this->autocommit(FALSE);
        $query = $this->consulta($queryParametro);
        if ($query == true) {
            $this->commit();
        } else {
            $this->rollback();    
        }
        $this->cerrarDB();
        if ( (strpos($queryParametro, "INSERT" ) !== false or 
             (strpos($queryParametro, "UPDATE" ) !== false ))) {
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
    
    public function listarAlumnosSinCurso() {
        $this->query = "SELECT CONCAT(nombre,' ',apellido) as alumno ,"
                . "ci as ci , 'Sin Curso Asignado' as curso "
                . "FROM dim_usuario WHERE categoria_usuario = 'Alumno' "
                . "and ci NOT IN (select ci_usuario from asc_curso_usuario);";
        $msjlistarAlumnosSinCurso = "No hay alumnos para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjlistarAlumnosSinCurso);
    }
    
    public function listarProfesoresSinCurso() {
        $this->query = "SELECT CONCAT(nombre,' ',apellido) as profesor ,"
                . "ci as ci , 'Sin Curso Asignado' as curso "
                . "FROM dim_usuario WHERE categoria_usuario = 'Profesor' "
                . "and ci NOT IN (select ci_usuario from asc_curso_usuario);";
        $msjlistarProfesoresSinCurso = "No hay profesores para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjlistarProfesoresSinCurso);
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
                . " GROUP_CONCAT(DISTINCT asctse.nombre_ejercicio SEPARATOR ' - ') as ejercicio,"
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
                . " GROUP BY nombre_curso , horario ,estado;";
        $msjcursoAsingadosProfesor = "No tiene ningún curso activo asigando."
                . " Comuníquese con Bedelía.";

        return $this->ejecutarQuery($this->query, $msjcursoAsingadosProfesor);
    }
/*
    public function editarCursoManejador($nombreCurso) {
        $this->query = "SELECT "
                . " c.nombre_curso as nombre_curso,"
                . " dt.nombre as tema,"
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
        $msjeditarCurso = "No tiene ningún curso activo asigando."
                . " Comuníquese con Bedelía.";

        return $this->ejecutarQuery($this->query, $msjeditarCurso);
    }
   */     
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

    public function listarCursosBedelia() {
        $this->query = "SELECT dc.nombre as curso, "                      
                . " dc.anio as anio,"
                . " dc.horario as horario,"
                . " CONCAT(du.nombre,' ',du.apellido) as profesor" 
                . " from dim_curso dc,"  
                . " asc_curso_usuario ascu,"
                . " dim_usuario du"
                . " where dc.nombre = ascu.nombre_curso" 
                . " and du.ci = ascu.ci_usuario"
                . " and du.categoria_usuario = 'Profesor'"
                . " and dc.estado = 1;";
        $listarCursosBedelia = "No hay usuarios para mostrar.";

        return $this->ejecutarQuery($this->query, $listarCursosBedelia);
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
    
    public function listarTemasPorCursoSeleccionado($ciUsuario, $curso) {
        $this->query = "select dt.nombre as nombre_tema "
                . "from dim_tema dt  , "
                . "asc_curso_tema_subtema_ejercicio actse,dim_usuario dm"
                . " where dt.nombre =  actse.nombre_tema "
                . "and actse.nombre_curso = '$curso' "
                . "and dm.ci = '$ciUsuario';";
        $msjlistarTemasPorCursoSeleccionado = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjlistarTemasPorCursoSeleccionado);
    }

    public function listarTemasSinCursoProfesor() {
        $this->query = "SELECT nombre as nombre_tema "
                . "from dim_tema "
                . "where nombre NOT IN "
                . "(SELECT dt.nombre "
                . "from dim_tema dt  ,"
                . " asc_curso_tema_subtema_ejercicio actse,"
                . "dim_usuario dm where dt.nombre =  actse.nombre_tema "
                . "and actse.nombre_curso = 'ING2017'"
                . " and dm.ci = '12345679');";
        $msjlistarTemasPorCursoSeleccionado = "No hay temas para el curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjlistarTemasPorCursoSeleccionado);
    }

    public function listarSubTemasPorCursoYTema($nombreCurso, $tema) {
        switch(gettype($tema)) {
            case "array":
                $tema = $tema[0]['nombre_tema'];
                break;
            case "string":
                $tema = $tema;
                break;
        }
        $nombreCurso = $nombreCurso[0]["nombre_curso"];
        

        $this->query = " SELECT DISTINCT ASCCTSE.nombre_subtema  "
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
            $colEntidadesMer = $colEntidades;
            $colRelacionesMer = $colRelaciones;

            $mer = new mer($nombreMer, $colEntidadesMer, $colRelacionesMer);

            return $mer;
        }
    }
    
    public function cambiarClaveManejador($ci, $claveNuevaParam) {
        $this->query = "UPDATE"
                . " dim_usuario"
                . " SET clave = '$claveNuevaParam'"
                . " WHERE ci = '$ci';";
        $msjCambiarClaveManejador = "Clave actualizada correctamente.";

        return $this->ejecutarQuery($this->query, $msjCambiarClaveManejador);
    }
    
    public function altaCursoManejador($nombreCurso,$anioCurso,$horarioCurso,
                                      $inicioCurso,$finCurso) {        
        $this->query = "INSERT INTO dim_Curso"
                . " (id_curso,nombre,anio,horario,fecha_inicio,fecha_fin,"
                . " estado)"
                . " VALUE (null,'$nombreCurso','$anioCurso',"               
                . " '$horarioCurso', '$inicioCurso','$finCurso','1');";
        $msjaltaCursoManejador = "No se pudo agregar el Curso";
        
        return $this->ejecutarQuery($this->query, $msjaltaCursoManejador);
        
    }

    public function altaProfesorManejador($ciUsuario,$nombreUsuario,$apellidoUsuario,
                                        $sexoUsuario,$emailUsuario,$claveUsuario,
                                        $telefonoUsuario,$celularUsuario) {      
        $this->query = "INSERT INTO dim_usuario"
                . " (id_usuario,ci,nombre,apellido,sexo,email,clave,"
                . " telefono,celular,categoria_usuario)"
                . " VALUE (null,'$ciUsuario','$nombreUsuario',"
                . " '$apellidoUsuario','$sexoUsuario','$emailUsuario',"
                . " '$claveUsuario', '$telefonoUsuario','$celularUsuario','Profesor');";
        $msjaltaProfesorManejador = "No se pudo agregar el Profesor";
        
        return $this->ejecutarQuery($this->query, $msjaltaProfesorManejador);
        
    }

    public function altaAlumnoManejador($ciUsuario,$nombreUsuario,$apellidoUsuario,
                                        $sexoUsuario,$emailUsuario,$claveUsuario,
                                        $telefonoUsuario,$celularUsuario) {
        $this->query = "INSERT INTO dim_usuario"
                . " (id_usuario,ci,nombre,apellido,sexo,email,clave,"
                . " telefono,celular,categoria_usuario)"
                . " VALUE (null,'$ciUsuario','$nombreUsuario',"
                . " '$apellidoUsuario','$sexoUsuario','$emailUsuario',"
                . " '$claveUsuario', '$telefonoUsuario','$celularUsuario','Alumno');";
        
       $msjaltaAlumnoManejador = "No se pudo agregar el Alumno.";

       return $this->ejecutarQuery($this->query, $msjaltaAlumnoManejador);
        
    }

     public function asignarCursoUsuario($curso,$ci) {
       $cedula = $ci[0];
         
        $this->query = "INSERT INTO asc_curso_usuario "
                . "(nombre_curso , ci_usuario) VALUE "
                . "('$curso',$cedula);";
        $msjasignarCursoUsuario = "No se pudo ingresar al curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjasignarCursoUsuario);
    }
       
    
     public function asignarCursoUsuarios($valores) {                
        $this->query = "INSERT INTO asc_curso_usuario "
                . "(nombre_curso , ci_usuario)"
                . " VALUE ($valores);";
        $msjasignarCursoUsuarios = "No se pudo ingresar al curso seleccionado.";

        return $this->ejecutarQuery($this->query, $msjasignarCursoUsuarios);
    }
    
    public function temaManejador($tema, $subtema) {
        if($subtema == true) {
            $this->query = "SELECT"
                    . " dt.letra"
                    . " FROM"
                    . " dim_subtema dt"
                    . " WHERE"
                    . " dt.nombre = '$tema'";
        } else {
            $this->query = "SELECT"
                    . " dt.letra"
                    . " FROM"
                    . " dim_tema dt"
                    . " WHERE"
                    . " dt.nombre = '$tema'";
        }
        $msjtemaManejador = "No hay letra para ese tema";
        
        return $this->ejecutarQuery($this->query, $msjtemaManejador);
    }
    
    public function ejerciciosTemaManejador($tema, $subtema , $nombreCurso) {
        $nombreCurso = $nombreCurso[0]["nombre_curso"];
        if($subtema == true) {
            $this->query = "SELECT
                    acts.nombre_ejercicio as ejercicio 
                    FROM
                    asc_curso_tema_subtema_ejercicio acts
                    WHERE
                    acts.nombre_subtema = '$tema'
                    and acts.nombre_curso = '$nombreCurso'";

        } else {
            $this->query = "SELECT
                    acts.nombre_ejercicio as ejercicio
                    FROM
                    asc_curso_tema_subtema_ejercicio acts
                    WHERE
                    acts.nombre_tema = '$tema'
                    and acts.nombre_curso = '$nombreCurso'";
        }
        $msjejerciciostemaManejador = "No hay ejercicio para ese tema";
        
        return $this->ejecutarQuery($this->query, $msjejerciciostemaManejador);
    }
    
     public function letraEjercicioTemaManejador($ejercicio) {
        
            $this->query = "SELECT"
                    . " de.letra"
                    . " from dim_ejercicio de "
                    . "where de.nombre = '$ejercicio'";

        $msjletraEjercicioTemaManejador = "No hay ejercicio";
        
        return $this->ejecutarQuery($this->query, $msjletraEjercicioTemaManejador);
    }
    
//    public function validarDatosMerManejador($nombreMer, $ciUsuario, $nombreEjercicio, 
//            $inputsCapturados) {
//        $tiposInputs = ["entidadComun", "entidadSuperTipo", "entidadSubTipo", "relacionComun", "restriccion"];
//        $atributosInputs = ["nombre", "atributo", "restriccion"];
//        $arrayEntidades = [];
//        $arrayRelaciones = [];
//        $inputsRecorridos = [];
//        $atributosRecorridos = [];
//        $arrayRegistros = [];
//        
//        // hay que recorrer el array que se paso para ver de que son los datos
//        // e ir armando objetos.
//        
//        // se recorre segun el largo del array.
//        for ($i = 0; $i < sizeof($inputsCapturados); $i++) {
//            $input = $inputsCapturados[$i][0];
//            $atributo = $inputsCapturados[$i][1];
//            $claveAtributo = key($atributo);
//            $valorAtributo = implode(":", $atributo);
//            
//            // hacemos la recorrida segun la cantidad de tipo de inputs.
//            for ($x = 0; $x < sizeof($tiposInputs); $x++) {
//                // si lo que estamos recorriendo es de uno de los tipos de inputs.
//                if (strpos($input, $tiposInputs[$x]) !== false) {
//                    $tipoInput = $tiposInputs[$x];
//                    // si el input corresponde a una entidad, evaluamos que 
//                    // tipo de entidad es.
//                    if (strpos($tipoInput, "entidad") !== false ||
//                            strpos($tipoInput, "relacion") !== false) {
//                        if (strpos($tipoInput, "Comun") !== false) {
//                            $tipo = "comun";
//                        } else {
//                            if (strpos($tipoInput, "SuperTipo") !== false) {
//                                $tipo = "supertipo";
//                            } else {
//                                if (strpos($tipoInput, "SubTipo") !== false) {
//                                    $tipo = "subtipo";
//                                }
//                            }
//                        }
//                    }
//                    break;
//                }
//            }
//            // hacemos la recorrida segun la cantidad de tipo de atributos.
//            for ($z = 0; $z < sizeof($atributosInputs); $z++) {
//                // si lo que estamos recorriendo es de uno de los tipos de atributos.
//                if (strpos($claveAtributo, $atributosInputs[$z]) !== false) {
//                    $tipoAtributo = $atributosInputs[$z];
//                    break;
//                }
//            }
//            
//            switch ($tipoInput) {
//                case "entidadComun":
//                    // si este nombre de objeto, todavia no lo recorri.
//                    if (in_array($input, $inputsRecorridos) === false) {
//                        // agrego el nombre del objeto al array de los ya recorridos.
//                        array_push($inputsRecorridos, $input);
//                        // nos fijamos si el atributo es el nombre.
//                        if ($claveAtributo === "nombre") {
//                            $arrayRegistros[$input] = $valorAtributo . ", " . $tipo;
//                        }
//                    } else {
//                        $arrayRegistros[$input] = $arrayRegistros[$input] . ", " . $valorAtributo;
//                    }
////                case "relacionComun":
////                    $arrayRegistros[$input] = $valorAtributo . ", " . $tipo;
//            }
//        }
//        var_dump($arrayRegistros);
//    }
    
    public function validarDatosMerManejador($nombreMer, $ciUsuario, $nombreEjercicio, 
            $inputsCapturados) {
        $tiposInputs = ["entidadComun", "entidadSuperTipo", "entidadSubTipo", "relacionComun", "restriccion"];
        $atributosInputs = ["nombre", "atributo", "restriccion"];
        $arrayEntidades = [];
        $arrayRelaciones = [];
        $inputsRecorridos = [];
        $atributosRecorridos = [];
        $arrayRegistros = [];
        
        // hay que recorrer el array que se paso para ver de que son los datos
        // e ir armando objetos.
        
        // se recorre segun el largo del array.
        for ($i = 0; $i < sizeof($inputsCapturados); $i++) {
            $input = $inputsCapturados[$i][0];
            $atributo = $inputsCapturados[$i][1];
            $claveAtributo = key($atributo);
            $valorAtributo = implode(":", $atributo);
            
            // hacemos la recorrida segun la cantidad de tipo de inputs.
            for ($x = 0; $x < sizeof($tiposInputs); $x++) {
                // si lo que estamos recorriendo es de uno de los tipos de inputs.
                if (strpos($input, $tiposInputs[$x]) !== false) {
                    $tipoInput = $tiposInputs[$x];
                    // si el input corresponde a una entidad, evaluamos que 
                    // tipo de entidad es.
                    if (strpos($tipoInput, "entidad") !== false ||
                            strpos($tipoInput, "relacion") !== false) {
                        if (strpos($tipoInput, "Comun") !== false) {
                            $tipo = "comun";
                        } else {
                            if (strpos($tipoInput, "SuperTipo") !== false) {
                                $tipo = "supertipo";
                            } else {
                                if (strpos($tipoInput, "SubTipo") !== false) {
                                    $tipo = "subtipo";
                                }
                            }
                        }
                    }
                    break;
                }
            }
            // hacemos la recorrida segun la cantidad de tipo de atributos.
            for ($z = 0; $z < sizeof($atributosInputs); $z++) {
                // si lo que estamos recorriendo es de uno de los tipos de atributos.
                if (strpos($claveAtributo, $atributosInputs[$z]) !== false) {
                    $tipoAtributo = $atributosInputs[$z];
                    break;
                }
            }
            
            switch ($tipoInput) {
                case "entidadComun":
                    // si este nombre de objeto, todavia no lo recorri.
                    if (in_array($input, $inputsRecorridos) === false) {
                        // agrego el nombre del objeto al array de los ya recorridos.
                        array_push($inputsRecorridos, $input);
                        // nos fijamos si el atributo es el nombre.
                        if ($claveAtributo === "nombre") {
                            $arrayRegistros[$input] = $valorAtributo . ", " . $tipo;
                        }
                    } else {
                        $arrayRegistros[$input] = $arrayRegistros[$input] . " | " . $valorAtributo;
                    }
//                case "relacionComun":
//                    $arrayRegistros[$input] = $valorAtributo . ", " . $tipo;
            }
        } 
        var_dump($arrayRegistros);
    }
    
    //SOLO SE DEBE EJECUTAR UNA VEZ
    public function guardarSolucionMer($nombre_mer , $ci ,$nombre_ejercicio ){                                                             
        $this->query = "INSERT INTO sol_mer "
                . "(id_mer , nombre , tipo , ci_usuario , nombre_ejercicio)"
                . " VALUE "
                . "(null , '$nombre_mer' , 'sol_alumno' , '$ci' , '$nombre_ejercicio');";
        $msjSolucionMer = "No se ha cargado la solucion.";

        return $this->ejecutarTransaccion($this->query, $msjSolucionMer);                                 
    }

    public function guardarSolucionMerEntidad($nombre_entidad, $tipo_entidad ,
                                             $entidad_supertipo ,
                                             $tipo_categorizacion ,
                                             $nombre_mer ,$ci_usuario) {
        $this->query = "INSERT INTO sol_entidad "
                 . "(id_entidad , nombre ,tipo_entidad , entidad_supertipo ,"
                 . " tipo_categorizacion , nombre_mer , ci_usuario)"
                 . "VALUE"
                . "(null , '$nombre_entidad' , '$tipo_entidad' , "
                 . "'$entidad_supertipo' , '$tipo_categorizacion', "
                 . "'$nombre_mer' , '$ci_usuario');";
        
        $msjSolMerEntidad = "No se ha cargado la entidad.";
              
        return $this->ejecutarTransaccion($this->query, $msjSolMerEntidad); 
    }
    
    public function guardarSolucionMerAtributo($nombre_atributo, $tipo_atributo ,
                                             $nombre_entidad ,
                                             $nombre_mer ,
                                             $ci_usuario) {
        $this->query = "INSERT INTO sol_atributo "
                . "(id_atributo , nombre_atributo ,tipo_atributo , "
                . "nombre_entidad , nombre_mer , ci_usuario)"
                . "VALUE"
                . "(null , '$nombre_atributo' , '$tipo_atributo' ,"
                . " '$nombre_entidad',"
                . " '$nombre_mer' , '$ci_usuario');";
        
        $msjSolMerAtributo= "No se ha cargado la entidad.";
              
        return $this->ejecutarTransaccion($this->query, $msjSolMerAtributo);
            
    }
    
    public function guardarSolucionMerAgregacacion($nombre_agregacion, 
                                                   $nombre_entidad ,
                                                   $nombre_mer ,
                                                   $ci_usuario) {
        $this->query = "INSERT INTO sol_agregacion "
                . "(id_agregacion , nombre_atributo , nombre_entidad ,"
                . " nombre_mer , ci_usuario)"
                . "VALUE"
                . "(null , '$nombre_agregacion' , '$nombre_entidad',"
                . " '$nombre_mer' , '$ci_usuario');";
        
        $msjSolMerAgregacion = "No se ha cargado la entidad.";
              
        return $this->ejecutarTransaccion($this->query, $msjSolMerAgregacion);
           
    }

    public function guardarSolucionMerRelacion($nombre_relacion,$nombre_entidadA,
                                               $nombre_entidadB,$agregacion,
                                               $nombre_mer , $ci_usuario) {
        $this->query = "INSERT INTO sol_relacion "
                . "(id_relacion , nombre , nombre_entidadA , nombre_entidadB , "
                . "agregacion , nombre_mer , ci_usuario)"
                . "VALUE"
                . "(null , '$nombre_relacion' , '$nombre_entidadA' , "
                . "'$nombre_entidadB' , '$agregacion' , '$nombre_mer' ,"
                . " '$ci_usuario');";
                 
        $msjSolMerRelacion = "No se ha cargado la relacion.";

        return $this->ejecutarTransaccion($this->query, $msjSolMerRelacion); 
    }
    
}

?>
