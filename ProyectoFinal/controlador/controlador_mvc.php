<?php

require_once "modelo/manejador.php";
require_once 'lib/excel/Classes/PHPExcel/IOFactory.php';
require('lib/fpdf/fpdf.php');
class controlador_mvc extends manejador {

    private $mensaje;
    private $usuario;
    private $ciUsuario;
    private $nombreUsuario;
    private $apellidoUsuario;
    private $claveActualUsuario;
    private $categoriaUsuario;
    private $cursoUsuario;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getCiUsuario() {
        return $this->ciUsuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getApellidoUsuario() {
        return $this->apellidoUsuario;
    }

    public function getClaveActualUsuario() {
        return $this->claveActualUsuario;
    }

    public function getCategoriaUsuario() {
        return $this->categoriaUsuario;
    }

    public function getCursoUsuario() {
        return $this->cursoUsuario;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCiUsuario($ciUsuario) {
        $this->ciUsuario = $ciUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setApellidoUsuario($apellidoUsuario) {
        $this->apellidoUsuario = $apellidoUsuario;
    }

    public function setClaveActualUsuario($claveActualUsuario) {
        $this->claveActualUsuario = $claveActualUsuario;
    }

    public function setCategoriaUsuario($categoriaUsuario) {
        $this->categoriaUsuario = $categoriaUsuario;
    }

    public function setCursoUsuario($cursoUsuario) {
        $this->cursoUsuario = $cursoUsuario;
    }


    public function load_template($title = "Sin Titulo") {
        $pagina = $this->load_page("vistas/plantilla.php");
        return $pagina;
    }

    private function load_page($page) {
        return file_get_contents($page);
    }

    private function view_page($html) {
        echo $html;
    }

    private function replace_content($in = "/Contenido/", $out, $pagina) {
        return preg_replace($in, $out, $pagina);
    }

    public function inicio() {
        try {
            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerInicio.html");
            $contenido = $this->load_page("vistas/html/index.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Bienvenido", $pagina);
            $this->view_page($pagina);
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function modal($msjModal) {
        try {
            $modal =
            "<div id='source-modal' class='modal' style='display: block;'>"
            . "<div class='modal-dialog'>"
            . "<div class='modal-content'>"
            . "<div class='modal-header'>"
            . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true' onclick='closeModal()'>&times;</button>"
            . "<h4 class='modal-title'>Atención:</h4>"
            . "</div>"
            . "<div class='modal-body'>"
            . "<p>$msjModal</p>"
            . "</div>"
            . "<div class='modal-footer'>"
            . "<button type='button' class='btn btn-default' data-dismiss='modal' onclick='closeModal()'>Cerrar</button>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";

            echo $modal;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function ingresar() {
        try {
            if (isset($_REQUEST["ingresar"])) {
                $ci = $_REQUEST["ci"];
                $clave = md5($_REQUEST["clave"]);

                $this->login($ci, $clave);

                if (!$this->getMensajeManejador() == NULL) {
                    $pagina = $this->load_template("inicio");
                    $head = $this->load_page("vistas/html/headPrincipal.html");
                    $header = $this->load_page("vistas/html/headerInicio.html");
                    $contenido = $this->load_page("vistas/html/index.html");
                    $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "Bienvenido", $pagina);
                    $pagina = $this->replace_content("/none/", "block", $pagina);
                    $this->modal($this->getMensajeManejador());
                } else {
                    session_start();

                    $_SESSION["ciUsuario"] = $this->getCiUsuarioManejador();
                    $_SESSION["nombreUsuario"] = $this->getNombreUsuarioManejador();
                    $_SESSION["apellidoUsuario"] = $this->getApellidoUsuarioManejador();
                    $_SESSION["claveActualUsuario"] = $this->getClaveActualUsuarioManejador();
                    $_SESSION["categoriaUsuario"] = $this->getCategoriaUsuarioManejador();
                    $_SESSION["cursoUsuario"] = $this->getCursoUsuarioManejador();
                    $_SESSION["usuario"] = $this->getUsuarioManejador();

                    switch (get_class($_SESSION["usuario"])) {
                        case("alumno");
                            $pagina = $this->load_template("inicio");
                            $head = $this->load_page("vistas/html/headPrincipal.html");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                            $pagina = $this->replace_content("/Header/", $header, $pagina);
                            $pagina = $this->replace_content("/Contenido/", $this->menuTemasCursoYLetra(), $pagina);
                            $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
                            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                            break;
                        case("profesor");
                            $pagina = $this->load_template("inicio");
                            $head = $this->load_page("vistas/html/headPrincipal.html");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                            $pagina = $this->replace_content("/Header/", $header, $pagina);
                            $pagina = $this->replace_content("/Contenido/", $this->cursosProfesor(), $pagina);
                            $pagina = $this->replace_content("/Titulo/", "Cursos Asignados", $pagina);
                            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                            break;
                        case("administrativo");
                            $pagina = $this->load_template("inicio");
                            $head = $this->load_page("vistas/html/headPrincipal.html");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $contenido = $this->load_page("vistas/html/Administrativo.html");
                            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                            $pagina = $this->replace_content("/Header/", $header, $pagina);
                            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                            $pagina = $this->replace_content("/Titulo/", "Menu de Administrativo", $pagina);
                            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                            break;
                    }
                }

                $this->view_page($pagina);
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function redireccionar() {
        try {
            session_start();

            if (!isset($_SESSION["ciUsuario"])) {
                $this->inicio();
            } else {
                $pagina = $this->load_template("inicio");
                switch (get_class($_SESSION["usuario"])) {
                    case("alumno");
                        $head = $this->load_page("vistas/html/headPrincipal.html");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                        $pagina = $this->replace_content("/Header/", $header, $pagina);
                        $pagina = $this->replace_content("/Contenido/", $this->menuTemasCursoYLetra(), $pagina);
                        $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
                        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    case("profesor");
                        $head = $this->load_page("vistas/html/headPrincipal.html");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                        $pagina = $this->replace_content("/Header/", $header, $pagina);
                        $pagina = $this->replace_content("/Contenido/", $this->cursosProfesor(), $pagina);
                        $pagina = $this->replace_content("/Titulo/", "Cursos Asignados", $pagina);
                        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    case("administrativo");
                        $head = $this->load_page("vistas/html/headPrincipal.html");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/Administrativo.html");
                        $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                        $pagina = $this->replace_content("/Header/", $header, $pagina);
                        $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                        $pagina = $this->replace_content("/Titulo/", "Menu de Administrativo", $pagina);
                        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                        break;
                }

                $this->view_page($pagina);
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function cerrarSesion() {
        try {
            session_start();

            unset($_SESSION["ciUsuario"]);
            unset($_SESSION["nombreUsuario"]);
            unset($_SESSION["apellidoUsuario"]);
            unset($_SESSION["claveActualUsuario"]);
            unset($_SESSION["categoriaUsuario"]);
            unset($_SESSION["cursoUsuario"]);
            unset($_SESSION["usuario"]);
            unset($_SESSION["ejercicio"]);
            unset($_SESSION["inputs"]);
            unset($_SESSION["mensajeValidacion"]);
            unset($_SESSION["inicioEjercicio"]);
            unset($_SESSION["finEjercicio"]);

            session_destroy();

            $this->inicio();
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function cambiarClave() {
        try {
            session_start();

            if (!isset($_SESSION["ciUsuario"])) {
                $this->inicio();
            } else {
                $pagina = $this->load_template("inicio");
                $head = $this->load_page("vistas/html/headPrincipal.html");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $contenido = $this->load_page("vistas/html/menuUsuario.html");
                $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                $pagina = $this->replace_content("/Header/", $header, $pagina);
                $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                $pagina = $this->replace_content("/Titulo/", "Cambio de clave", $pagina);
                $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                $this->view_page($pagina);
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function cambioClave() {
        try {
            session_start();

            if (!isset($_SESSION["ciUsuario"])) {
                $this->inicio();
            } else {
                if (isset($_REQUEST["aceptar"])) {
                    $claveActual = md5($_REQUEST["claveActual"]);
                    $claveNueva = md5($_REQUEST["claveNueva"]);
                    $claveNuevaRep = md5($_REQUEST["claveNuevaRep"]);

                    if ($claveActual <> $_SESSION["claveActualUsuario"]) {
                        $this->modal("Clave actual incorrecta.");
                    } else {
                        if ($claveNueva <> $claveNuevaRep) {
                            $this->modal("La clave nueva no coincide con la validación.");
                        } else {
                            $this->cambiarClaveManejador($_SESSION["ciUsuario"], $claveNueva);
                        }
                    }

                    $pagina = $this->load_template("inicio");
                    $head = $this->load_page("vistas/html/headPrincipal.html");
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/menuUsuario.html");
                    $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "Cambio de clave", $pagina);
                    $pagina = $this->replace_content("/none/", "block", $pagina);
                    $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

                    if (!$this->getMensajeManejador() == NULL) {
                        $this->modal($this->getMensajeManejador());
                    }
                }
                $this->view_page($pagina);
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function ejercicio() {
        try {
//            $mer = $this->armarMerSolucionSistema("PerroCucha");
//            var_dump($this->armarMerSolucionSistema("PerroCucha"));
            session_start();

//            if (!isset($_SESSION["ciUsuario"])) {
//                $this->inicio();
//            } else {
                if (!$this->getMensajeManejador() == NULL) {
                    $pagina = $this->load_template("inicio");
                    $head = $this->load_page("vistas/html/headEjercicio.html");
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/ejercicios/PerroCucha.html");
                    $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "Ejercicio", $pagina);
                    $pagina = $this->replace_content("/none/", "block", $pagina);
                    $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                    $this->modal($this->getMensajeManejador());
                } else {
                    $pagina = $this->load_template("inicio");
                    $head = $this->load_page("vistas/html/headEjercicio.html");
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/ejercicios/PerroCucha.html");
                    $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "Ejercicio", $pagina);
                    $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                }
                $this->view_page($pagina);
//            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function validarSolucion() {
        try {

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function menuTemasCurso() {
        try {
            $contenido = "<br><div class='col-lg-2'>"
            . "<div class='container' style='padding-top: 1em; margin-top: -18px; margin-left:-13px;'>"
            . "<div class='btn'>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=Introduccion'>"
            . "<button type='button' class='btn btn-default btn-lg' style='width: 200px; text-align:left;'>Introduccion</button>"
            . "</a></div></div>";

            $tema = $this->listarTemasPorCurso($_SESSION["cursoUsuario"]);

            for ($i = 0; $i < sizeof($tema); $i++) {
                $nombreTema = $tema[$i]["nombre_tema"];
                $subTemas = $this->listarSubTemasPorCursoYTema($_SESSION["cursoUsuario"], $nombreTema);
                //si hay subtemas

                if (!$subTemas[0][0] == NULL) {
                    $contenido = $contenido. "<div class='container' style='padding-top: 1em; margin-top: -9px;'>"
                    . "<div class=''>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=$nombreTema'>"
                    . "<button type='button' class='btn btn-primary btn-lg' style='width: 180px; text-align:left;'>$nombreTema</button></a>"
                    . "<div class='btn-group'>"
                    . "<button type='button' class='btn btn-default-btn dropdown-toggle btn-lg' data-toggle='dropdown' style='height:55px; text-align:center; padding:3px;'>"
                    . "<span class='caret'></span>"
                    . "</button>";

                    $contenido = $contenido. "<ul class='dropdown-menu'>";

                    for ($x = 0; $x < sizeof($subTemas); $x++) {
                        $subTemaAVer = $subTemas[$x][0];
                        $contenido = $contenido. "<li><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&subtema=$subTemaAVer'>"
                        . $subTemaAVer . "</a></li>";
                    }

                    $contenido = $contenido. "</ul></div></div></div>";

                } else {
                    $contenido = $contenido. "<div class='container' style='padding-top: 1em; margin-top: -9px;'>"
                    . "<div class='btn-md'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=$nombreTema'>"
                    . "<button type='button' class='btn btn-primary btn-lg' style='width: 198px; text-align:left;'>$nombreTema</button></a>"
                    . "</div></div>";
                }
            }

            $contenido = $contenido. "</div>";

            return $contenido;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function menuTemasCursoYLetra() {
        try {
            if (isset($_REQUEST["tema"])) {
                $tema = $_REQUEST["tema"];
                $subtema = false;
            }
            else {
                if (isset($_REQUEST["subtema"])) {
                    $tema = $_REQUEST["subtema"];
                    $subtema = true;
                }
                else {
                    $tema = "Introduccion";
                    $subtema = false;
                }
            }

            $contenido = $this->menuTemasCurso();

            $contenido = $contenido. "<br><p></p><div class='col-lg-2'>"
            . "<div class='container'>"
            . "<div class='item'>"
            . "<div class='jumbotron'>"
            . "<h2>";
            $contenido = $contenido. $tema ."</h2>"
            . "<p>";

            $letra = $this->temaManejador($tema,$subtema);

            $contenido = $contenido. $letra[0][0];
                                 
            $contenido = $contenido. "</p>"
            . "</div>";

            $ejercicio = $this->ejerciciosTemaManejador($tema,$subtema,$_SESSION["cursoUsuario"]);

            if($ejercicio){
               foreach ($ejercicio as $ej){
                       $contenido = $contenido. "<div class='col-lg-4'>"
                       . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=practicar&ejercicio=$ej[0]'><button type='submit' class='btn btn-default-lg btn-lg' name='practica'>Ejercicio $ej[0]</button></a>"
                       . "</div>";
               };
            //$contenido = $contenido. "</div>";
            };
            $contenido = $contenido. "</div>";

            return $contenido;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function teoricoCurso() {
        session_start();

        if (!isset($_SESSION["ciUsuario"])) {
            $this->inicio();
        } else {
            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $this->menuTemasCursoYLetra(), $pagina);
            $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
            
//            var_dump($_SESSION["mensajeValidacion"]);
            if (isset($_SESSION["mensajeValidacion"]) && 
                    $_SESSION["mensajeValidacion"] === "Felicitaciones, MER realizado correctamente!") {
                $this->modal($_SESSION["mensajeValidacion"]);
                $pagina = $this->replace_content("/none/", "block", $pagina);
                unset($_SESSION["mensajeValidacion"]);
            }

            $this->view_page($pagina);
        }
    }

    public function cursosProfesor() {
        try {
            echo "<div class='item'>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th>"
            . "<div class='form'>"
            . "<label class='control-label'>Curso</label>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<label class='control-label'>Horario</label>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<label class='control-label'>Tema</label>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<label class='control-label'>Estado</label>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<label class='control-label'>Editar Curso</label>"
            . "</div>"
            . "</th>"
            . "</tr>"
            . "</thead>";

            $ciUsuario = $_SESSION["ciUsuario"];
            $resultado = $this->cursoAsingadosProfesor($ciUsuario);

            foreach ($resultado as $fila) {
                $cursoSeleccionado =  $fila['nombre_curso'];
                echo "<tbody>"
                . "<tr class='info'>"
                . "<td></td>"
                . "<td></td>"
                . "<td></td>"
                . "<td></td>"
                . "<td></td>"
                . "</tr>"
                . "<tr class='active'>"
                . "<td>" . $fila['nombre_curso'] . "</td>"
                . "<td>" . $fila['horario'] . "</td>"
                . "<td>" . $fila['tema'] . "</td>"
                . "<td>" . $fila['estado'] . "</td>" 
                . "<td><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso&curso=$cursoSeleccionado'>editar</a></td>"
                . "</tr>"
                . "</tbody>";
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function editarCursoMenu() {
        try{ 
            session_start();
            if (isset($_REQUEST["curso"])) {
                $curso = $_REQUEST["curso"];
                $ciUsuario = $_SESSION["ciUsuario"];
                $tema = "Introduccion";
                $subtema = false;
                              
                $contenido =
                "<br><div class='col-lg-2'>"
                . "<div class=container'>"                               
                . "<button  class='btn btn-default btn-lg' style='width: 180px; text-align:left;'>Introduccion</button>"
                . "</div>";
                //lista los temas que hay en e curso $curso         
                $temas = $this->listarTemasPorCursoSeleccionado($ciUsuario, $curso);
                if($temas == NULL){
                    ;
                }
                else{
                    //itera sobre los temas que tiene el curso seleccionado
                    foreach($temas as $item) {   
                        $nombreTema = $item['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>" 
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"                   
                        . "<button type='button' class='btn btn-default btn-lg'style='width: 180px ; text-align:left;'>".
                           $item['nombre_tema']."</button></a>"
                        ." </div>";           
                    }
                }
                $temasSeleccionar = $this->listarTemasSinCursoProfesor($ciUsuario, $curso);
                //var_dump($temasSeleccionar);
                if($temasSeleccionar == NULL){
                    
                }
                else{
                    //itera sobre los temas que no tiene el curso seleccionado
                    foreach($temasSeleccionar as $item2) { 
                        $nombreTema = $item2['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>"
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"         
                        . "<button type='button' class='btn btn-primary btn-lg' style='width: 180px ; text-align:left;'>"
                           .$item2['nombre_tema']."</button></a>"                     
                        ." </div>";                      
                    }              
                }              
                $contenido = $contenido. "</div>"
                . "<div class='col-lg-2'>"
                . "<div class='container'>"
                . "<div class='item'>"
                . "<div class='jumbotron'>"
                . "<h2>";
                        
                $contenido = $contenido. $tema ."</h2>"
                . "<p>";

                $letra = $this->temaManejador($tema,$subtema);
                $contenido = $contenido. $letra[0][0]. "<br>"
                . "</div>"
                . "</div>";        
    
                $contenido = $contenido. "</div>"
                . "<div class='container'>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verReporte&ci=$ciUsuario&curso=$curso'>"
                . "<button type='button' class='btn btn-primary btn-lg' style='position: relative; float: right;' name='reporte'>Ver reporte</button>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>"
                . "<button type='button' class='btn btn-primary btn-lg' style='position: relative; float: right; margin-right:10px;' name='volver'>Volver</button></a>"
                . "</div>"
                . "</div>"
                . "</div>";
                          
                $pagina = $this->load_template("inicio");
                $head = $this->load_page("vistas/html/headPrincipal.html");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                $pagina = $this->replace_content("/Header/", $header, $pagina);
                $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                $pagina = $this->replace_content("/Titulo/", "Editar curso", $pagina);
                $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

                $this->view_page($pagina);
            
            }                                                           
        } catch (Exception $ex) {
            echo "Excepcion capturada: ", $ex->getMessage(), "\n";
        }             
    }
       
    public function editarCursoTemaYLetra() {
        try {
            session_start();
            if (isset($_REQUEST["tema"]) and isset($_REQUEST["curso"])) {
                $curso = $_REQUEST["curso"];
                $tema = $_REQUEST["tema"];
                $subtema = false;
                $nombreTema = 'Introduccion';
                               
                $ciUsuario = $_SESSION["ciUsuario"];
                              
                $contenido = 
                "<br><div class='col-lg-2'>"
                . "<div class=container'>"                
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso&curso=$curso'>"
                . "<button type='button' class='btn btn-default btn-lg' style='width: 180px; text-align:left;'>Introduccion</button>"
                . "</a></div>";
                           
                $temas = $this->listarTemasPorCursoSeleccionado($ciUsuario, $curso);
                if($temas == NULL){
                    ;
                }
                else{
                    //itera sobre los temas que tiene el curso seleccionado
                    foreach($temas as $item) {   
                        $nombreTema = $item['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>" 
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"                   
                        . "<button type='button' class='btn btn-default btn-lg' style='width: 180px ; text-align:left;'>".
                           $item['nombre_tema']."</button></a>"
                        ." </div>";           
                    }
                }    
                $temasSeleccionar = $this->listarTemasSinCursoProfesor($ciUsuario, $curso);
                if($temasSeleccionar == NULL){
                    ;
                }
                else{
                    //itera sobre los temas que no tiene el curso seleccionado
                    foreach($temasSeleccionar as $item2) { 
                        $nombreTema = $item2['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>"
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"         
                        . "<button type='button' class='btn btn-primary btn-lg' style='width: 180px ; text-align:left;'>"
                           .$item2['nombre_tema']."</button></a>"                     
                        ." </div>";                    
                    }  
                }             
                $contenido = $contenido. "</div>"
                . "<div class='col-lg-2'>"
                . "<div class='container'>"
                . "<div class='item'>"
                . "<div class='jumbotron'>"
                . "<h2>";
                $contenido = $contenido. $tema ."</h2>"
                . "<p>";
                $letra = $this->temaManejador($tema,$subtema);

                $contenido = $contenido. $letra[0][0]. "</p>"."</div>";

                $ejercicio = $this->ejerciciosEditarCurso($tema,$subtema,$curso);

                if($ejercicio == !NULL){
                    foreach ($ejercicio as $ej){
                          $contenido = $contenido. "<div class='col-lg-4'>"
                          . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verEjercicio&tema=$tema&curso=$curso&ejercicio=$ej[0]'>"
                          . "<button type='button' class='btn btn-default-lg btn-lg' name='ejercicio'>Ejercicio $ej[0]</button></a>"
                          . "</div>";
                    }
                } 
                else {
                    $ejercicio = $this->ejerciciosEditarCursoSinAsociar($tema);
                    if($ejercicio == !NULL)
                        foreach ($ejercicio as $ej){
                          $contenido = $contenido. "<div class='col-lg-4'>"
                          . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verEjercicio&tema=$tema&curso=$curso&ejercicio=$ej[0]'>"
                          . "<button type='button' class='btn btn-default-lg btn-lg' name='ejercicio'>Ejercicio $ej[0]</button></a>"
                          . "</div>";
                        }
                        else {
                            ;
                        }
                }
                $contenido = $contenido. "<br><br><br>"
                . "<div class='container'>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asociarTema&curso=$curso&tema=$tema' >"
                . "<button type='submit' class='btn btn-primary btn-lg' style='position: relative; margin-right:10px; float: right;' name='guardar'>Agregar</button></a>&nbsp;"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=desasociarTema&curso=$curso&tema=$tema'>"
                . "<button type='submit' class='btn btn-primary btn-lg' style='position: relative; margin-right:10px; float: right;' name='guardar'>Eliminar</button></a>&nbsp;"
                . "</form>"        
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>"
                . "<button type='button' class='btn btn-primary btn-lg' style='position: relative; margin-right:10px; float: right;'name='volver'>Volver</button></a>"                            
                . "</div>";
                               
                $pagina = $this->load_template("inicio");
                $head = $this->load_page("vistas/html/headPrincipal.html");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                $pagina = $this->replace_content("/Header/", $header, $pagina);
                $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                $pagina = $this->replace_content("/Titulo/", "Editar curso", $pagina);
                $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
            
                $this->view_page($pagina);
                       
           }      
           
        } catch (Exception $ex) {
            echo "Excepcion capturada: ", $ex->getMessage(), "\n";
        }
    }
     
    public function editarCursoTemaYLetraEjercicio() {
        try {
            session_start();
            if (isset($_REQUEST["ejercicio"]) and isset($_REQUEST["curso"]) and  
                isset($_REQUEST["tema"])) {
                $tema = $_REQUEST["tema"];
                $subtema = false;
                $nombreTema = 'Introduccion';
                $curso = $_REQUEST["curso"];
                $ejercicioSeleccionado = $_REQUEST["ejercicio"];
                                
                $ciUsuario = $_SESSION["ciUsuario"];
                              
                $contenido =
                "<br><div class='col-lg-2'>"
                . "<div class=container'>"                
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"
                . "<button type='button' class='btn btn-default btn-lg' style='width: 180px; text-align:left;'>Introduccion</button>"
                . "</a></div>";
                           
                $temas = $this->listarTemasPorCursoSeleccionado($ciUsuario, $curso);
                if($temas == NULL){
                    ;
                }
                else{
                    //itera sobre los temas que tiene el curso seleccionado
                    foreach($temas as $item) {   
                        $nombreTema = $item['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>" 
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"                   
                        . "<button type='button' class='btn btn-default btn-lg' style='width: 180px ; text-align:left;'>".
                           $item['nombre_tema']."</button></a>"
                        ." </div>";           
                    }
                }
                $temasSeleccionar = $this->listarTemasSinCursoProfesor($ciUsuario, $curso);
                if($temasSeleccionar == NULL){
                    ;
                }
                else{
                    //itera sobre los temas que no tiene el curso seleccionado
                    foreach($temasSeleccionar as $item2) { 
                        $nombreTema = $item2['nombre_tema'];
                        $contenido = $contenido."<div class=container' style='padding-top: 1em;'>"
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verTema&curso=$curso&tema=$nombreTema'>"         
                        . "<button type='button' class='btn btn-primary btn-lg' style='width: 180px ; text-align:left;'>"
                           .$item2['nombre_tema']."</button></a>"                     
                        ." </div>";                    
                    }  
                }                 
                $contenido = $contenido. "</div>"
                . "<div class='col-lg-2'>"
                . "<div class='container'>"
                . "<div class='item'>"
                . "<div class='jumbotron'>"
                . "<h2>";
                $contenido = $contenido. $ejercicioSeleccionado ."</h2>"
                . "<p>";
                $letra = $this->ejercicioManejador($ejercicioSeleccionado);

                $contenido = $contenido. $letra[0][0] ;

                $contenido = $contenido. "</p>"
                . "</div>"
                . "</div>";
                
                $ejercicio = $this->ejerciciosEditarCurso($tema,$subtema,$curso);

                if($ejercicio == !NULL){
                    foreach ($ejercicio as $ej){
                        $contenido = $contenido. "<div class='col-lg-3'>"
                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verEjercicio&tema=$tema&curso=$curso&ejercicio=$ej[0]'>"
                        . "<button type='button' class='btn btn-default-lg btn-lg' name=$ej[0]>Ejercicio $ej[0]</button></a>"
                        . "</div>";
                    }              
                }
                else{
                    $ejercicio = $this->ejerciciosEditarCursoSinAsociar($tema);
                    foreach ($ejercicio as $ej){
                          $contenido = $contenido. "<div class='col-lg-3'>"
                          . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=verEjercicio&tema=$tema&curso=$curso&ejercicio=$ej[0]'>"
                          . "<button type='button' class='btn btn-default-lg btn-lg' name='ejercicio'>Ejercicio $ej[0]</button></a>"
                          . "</div>";
                    }
                    
                }
                
                $contenido = $contenido. "<br><br><br>"
                . "<div class='container'>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asociarTema&curso=$curso&tema=$tema'>"
                . "<button type='submit' style='position: relative; align: right; margin-left: 838px' class='btn btn-primary btn-lg' name='guardar'>Agregar</button></a>&nbsp;"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=desasociarTema&curso=$curso&tema=$tema'>"
                . "<button type='submit'class='btn btn-primary btn-lg' name='guardar'>Eliminar</button></a>&nbsp;"         
                . "</form>"                            
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>"
                . "<button type='button' class='btn btn-primary btn-lg' name='volver'>Volver</button></a>"   
                . "</div>"
                . "</div>";
                                 
            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Editar curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
            
            $this->view_page($pagina);
            
            }            
           
        } catch (Exception $ex) {
            echo "Excepcion capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function asociarTema() {
        try {
            //session_start();
            if(isset($_REQUEST["tema"])){
                    $tema  = $_REQUEST["tema"];                
                    $curso = $_REQUEST["curso"];               

                    $existe = $this->comprobarTema($curso, $tema);
                    if( ($existe[0]['nombre_tema']) == $tema ){
                       $this->modal("El Tema " .$tema. " ya se encuentra "
                               . "asociado al Curso " .$curso );  
                       $this->editarCursoMenu();   
                    }
                    else{
                    $resultado = $this->verTemaSeleccionadoProfesor($tema);
                        if($resultado == !NULL){
                            for($i = 0 ; $i < sizeof($resultado) ; $i++){                   
                                $tema = $resultado[$i]['tema'];
                                $subtema = $resultado[$i]['subtema'];
                                $nombre_ejercicio = $resultado[$i]['nombre_ejercicio'];               
                                $resultadoInsert = $this->insertCursoProfesor($curso,
                                                                      $tema,
                                                                      $subtema, 
                                                                      $nombre_ejercicio);                         
                                }
                            $this->modal("Se ha agregado el Tema " .$tema. " al Curso " .$curso );  
                            $this->editarCursoMenu();  
                        }                                                                  
                        else {                                              
                            $this->modal("No se ha podido agregar el Tema " .$tema. " al Curso " .$curso );  
                            $this->editarCursoMenu();                   
                        }                                  
                    }   
            }
            
        } catch (Exception $ex) {
            echo "Excepcion capturada: ", $ex->getMessage(), "\n";
        }

    }
    
    public function desasociarTema() {
        try {
            //session_start();
            if(isset($_REQUEST["tema"])){
                    $tema  = $_REQUEST["tema"];                
                    $curso = $_REQUEST["curso"];               
                    
                    $existe = $this->comprobarTema($curso,$tema);

                        if( ($existe[0]['nombre_tema']) == $tema){   
                            $resultado = $this->verTemaSeleccionadoProfesor($tema);
                            if($resultado == !NULL){
                                for($i = 0 ; $i < sizeof($resultado) ; $i++){                   
                                    $tema = $resultado[$i]['tema'];              
                                    $resultadoDelete = $this->deleteCursoProfesor($curso,
                                                                      $tema);                     
                                }
                                $this->modal("Se ha eliminado el Tema " .$tema. " del Curso " .$curso );  
                                $this->editarCursoMenu();                       
                            }
                        }
                        else {                   
                            $this->modal("El Tema " .$tema. " no se puede borrar "
                               . "porque no se encuentra asociado al Curso " .$curso );  
                            $this->editarCursoMenu();              
                        }
            }
            else {                                              
                    $this->modal("No se ha podido eliminar el Tema " .$tema. " al Curso " .$curso );  
                    $this->editarCursoMenu();                       
            }
    
        } catch (Exception $ex) {
            echo "Excepcion capturada: ", $ex->getMessage(), "\n";
        }

    }
    
    public function alumnosBedelia() {
        try {
            session_start();

            $contenido = "<div class = 'container'>"
            . "<form method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarAlumno'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Alumnos</h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div>"            
            . "<label class='control-label'>Nombre</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='number' name = 'numero' value='' maxlength='8' class='form-control' placeholder='Filtrar por Cedula'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Curso</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtCur' class='form-control' placeholder='Filtrar por curso'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<th>"                 
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
            . "</div>"
            . "</th>"
            . "</thead>"
            . "</form>" ;

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Alumnos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarUsuariosYCurso();

            foreach ($resultado as $fila) {
                echo "<tbody>"
                 . "<tr class='active'>"
                 . "<td>" . $fila['alumno'] . "</td>"
                 . "<td>" . $fila['ci'] . "</td>"
                 . "<td>" . $fila['curso'] . "</td>"
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=eliminarRegistro&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'eliminarRegistro' class='btn btn-primary'>Eliminar</button></a>"."</td>" 
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificarRegistroAlumno&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"                    
                 . "</tr>"
                 . "</tbody>";
            }

             echo "</table>";
             $onclick = "document.getElementById('selectedFile').click();";

             echo "<br>"
            . "<p align='left'>"
            . "<form action= 'http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=importarAlumnos' method='post' enctype='multipart/form-data'>"
            . "<input type='file' name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
            . "<input type='button' value='Importar grupo alumnos' onclick=" . $onclick ." class='btn btn-primary btn-lg' />&nbsp"
            //. "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=importarAlumnos'>"            
            . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
            . "</form>"
            . "</p><p align='left'>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarAlumno'><button type='button' name = 'agregarAlumno' class='btn btn-primary btn-lg'>Agregar alumno</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoAlumno'><button type='button' name = 'alumnosSinCurso' class='btn btn-primary btn-lg'>Alumnos sin curso</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</p>";
         } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
           }

    }

    public function profesoresBedelia() {
         try {
             session_start();

             $contenido = "<div class = 'container'>"
             . "<form method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarProfesor'>"        
             . "<div class='page-header' id='tables'>"
             . "<h1 style='color:#d3d3d3;' align='center'>Profesores</h1>"
             . "</div>"
             . "<div class='item'>"
             . "<table class='table table-striped table-hover'>"
             . "<thead>"
             . "<tr class='danger'>"
             . "<th><div class='form'>"
             . "<label class='control-label'>Nombre</label>"
             . "<div class='input'>"
             . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
             . "</div>"
             . "</th>"
             . "<th><div class='form'>"
             . "<label class='control-label'>Cedula</label>"
             . "<div class='input'>"
             . "<input type='number' name = 'numero' value='' maxlength='8' class='form-control' placeholder='Filtrar por cedula'>"
             . "</div>"
             . "</th>"
             . "<th><div class='form'>"
             . "<label class='control-label'>Curso</label>"
             . "<div class='input'>"
             . "<input type='text' name = 'filtCur' class='form-control' placeholder='Filtrar por curso'>"
             . "</div>"
             . "</th>"
             . "<th>"
             . "<th>"
             . "<div class='form'>"
             . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>" 
             . "</div>"
             . "</th>"
             . "</thead>"
             . "</form>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Profesores", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarProfesosYCurso();

            if(!$resultado){
                $this->modal("No existen Profesores con Curso asginado");
            } else {
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['profesor'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] . "</td>"
                   . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=eliminarRegistroProfesor&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'eliminarRegistro' class='btn btn-primary'>Eliminar</button></a>"."</td>" 
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificarRegistroProfesor&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"                    
                 . "</tr>"
                 . "</tbody>";
                }

            echo "</table>";
            $onclick = "document.getElementById('selectedFile').click();";

            echo "<br>"
            . "<p align='left'>"
            . "<form action= 'http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=importarProfesores' method='post' enctype='multipart/form-data'>"
            . "<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
            . "<input type='button'  value='Importar grupo profesores' onclick=" . $onclick ." class='btn btn-primary btn-lg' />&nbsp"
            . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
            . "</form>"
            . "</p><p align='left'>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarProfesor'><button type='button' name = 'agregarProfesor' class='btn btn-primary btn-lg'>Agregar profesor</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoProfesor'><button type='button' name = 'asignarCursoProfesor' class='btn btn-primary btn-lg'>Profesores sin curso</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</p>";

            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function cursosBedelia() {
        try {
             session_start();

            $contenido = "<div class = 'container'>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarCurso'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Cursos</h1>"
            . "</div>"
            . "<div class='item'>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Curso</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtCur' class='form-control' placeholder='Filtrar por curso'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Año</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtAno' class='form-control' placeholder='Filtrar por año'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Horario</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtHor' class='form-control' placeholder='Filtrar por horario'>"
            . "</div>"
            . "</th>". "<th><div>"
            . "<label class='control-label'>Profesor</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por profesor'>"
            . "</div>"
            . "</th>"
            . "<th>"
            
            . "<div>"
             . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>" 
            . "</div>"
            . "</th>"
            . "</thead>"       
            . "</form>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Cursos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);
                        $resultado = $this->listarCursosActivos();

            $resultado = $this->listarCursosBedelia();
            
             if(!$resultado){
                $this->modal("No existen registros");
            } 
            else {

            foreach ($resultado as $fila) {
                echo "<tbody>"
                . "<tr class='active'>"
                . "<td>" . $fila['curso'] . "</td>"
                . "<td>" . $fila['anio'] . "</td>"
                . "<td>" . $fila['horario'] . "</td>"
                . "<td>" . $fila['profesor'] . "</td>"
                . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?"
                        . "action=modificarRegistroCurso&curso=$fila[curso]&anio=$fila[anio]&horario=$fila[horario]&profesor=$fila[profesor]'>
                <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"               
                . "</tr>"
                . "</tbody>";
            }
            }
            echo "</table>";

             echo "<br>"
             . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarCurso'>"
             . "<button type='button' name = 'agregarCurso' class='btn btn-primary btn-lg'>Agregar curso</button></a>"
             . "&nbsp" 
             . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
             . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" ; 
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }

   public function agregarAlumno(){
        try {
            session_start();

            $contenido = "<div class='container'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Agregar Alumno</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoAlumno'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputNombre' name='inputCI' placeholder='12345678' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputApellido' name='inputApellido' placeholder='Apellido' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label class='col-lg-2 control-label'>Sexo</label>"
            . "<div class='col-lg-10'>"
            . "<div class='radio'>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='M' checked=''>"
            . "Masculino"
            . "</label>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='F'>"
            . "Femenino"
            . "</label>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            . "<div class='col-lg-8'>"
            . "<input type='email' class='form-control' id='inputMail' name='inputMail' placeholder='ejemplo@ejemplo.com'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputTelefono' name='inputTelefono' placeholder='12345678' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Celular</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputCelular' name='inputCelular' placeholder='091234567' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Agregar Alumnos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarCursosActivos();

            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['nombre']. '">' . $fila['nombre'] . '</OPTION>';
            }

            echo"</select>"
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<div class='col-lg-10 col-lg-offset-2'>"
            . "<button type='reset' class='btn btn-default btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg'>Aceptar</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</div>"
            . "</div>"
            . "</fieldset>"
            . "</form>";

            echo "</table>";

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }

    public function agregoAlumno(){
        try {
            if (isset($_REQUEST['aceptar'])){

                $ciUsuario = $_REQUEST["inputCI"];
                $nombreUsuario = $_REQUEST["inputNombre"];
                $apellidoUsuario = $_REQUEST["inputApellido"];
                $sexoUsuario = $_REQUEST["sexo"];
                $emailUsuario = $_REQUEST["inputMail"];
                $claveUsuario = md5($ciUsuario);
                $telefonoUsuario = $_REQUEST["inputTelefono"];
                $celularUsuario = $_REQUEST["inputCelular"];
                $curso = $_REQUEST["asignarCurso"];

                $comprobacion = $this->comprobarCedula($ciUsuario);
                               
                if($comprobacion[0]['cedula'] !== $ciUsuario){
                $resultado = $this->altaAlumnoManejador($ciUsuario,
                                                        $nombreUsuario,
                                                        $apellidoUsuario,
                                                        $sexoUsuario,
                                                        $emailUsuario,
                                                        $claveUsuario,
                                                        $telefonoUsuario,
                                                        $celularUsuario);

                if(!$resultado){
                    $asignar = $this->asignarCursoUsuario($curso, $ciUsuario);
                   
                        if(!$asignar) {
                          $this->modal("Se agrego el Alumno $nombreUsuario "
                                    . "$apellidoUsuario y se asocio al Curso "
                                    . "$curso.");
                         $this->agregarAlumno();
                        }else{
                          $this->modal("No se ha podido asociar el Alumno "
                                    . "$nombreUsuario $apellidoUsuario al $curso.");
                          $this->agregarAlumno();
                        }

                } else {
                    $this->modal("No se ha podido ingresar el Alumno "
                                  . "$nombreUsuario $apellidoUsuario al sistema.");
                    $this->agregarAlumno();
                }
                
                }
                else{
                    
                     $this->modal("La Cedula Nro. $ciUsuario ya existe en el Sistema ");                                
                     $this->agregarAlumno();
                }
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

   public function agregarProfesor(){
         try {
            session_start();

            $contenido = "<div class='container'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Agregar Profesor</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoProfesor'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputNombre' name='inputCI' placeholder='12345678' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputApellido' name='inputApellido' placeholder='Apellido' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label class='col-lg-2 control-label'>Sexo</label>"
            . "<div class='col-lg-10'>"
            . "<div class='radio'>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='M' checked=''>"
            . "Masculino"
            . "</label>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='F'>"
            . "Femenino"
            . "</label>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            . "<div class='col-lg-8'>"
            . "<input type='email' class='form-control' id='inputMail' name='inputMail' placeholder='ejemplo@ejemplo.com'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputTelefono' name='inputTelefono' placeholder='12345678' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Celular</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputCelular' name='inputCelular' placeholder='091234567' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Agregar Profesor", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarCursosActivos();

            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['nombre']. '">' . $fila['nombre'] . '</OPTION>';
            }

            echo"</select>"
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<div class='col-lg-10 col-lg-offset-2'>"
            . "<button type='reset' class='btn btn-default  btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg' >Aceptar</button>&nbsp"
            . "</form>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"         
            . "</div>"
            . "</div>"
            . "</fieldset>";


            echo "</table>";
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }
    

    public function agregoProfesor(){
        try {
            if (isset($_REQUEST['aceptar'])){

            $ciUsuario = $_REQUEST["inputCI"];
            $nombreUsuario = $_REQUEST["inputNombre"];
            $apellidoUsuario = $_REQUEST["inputApellido"];
            $sexoUsuario = $_REQUEST["sexo"];
            $emailUsuario = $_REQUEST["inputMail"];
            $claveUsuario = md5($ciUsuario);
            $telefonoUsuario = $_REQUEST["inputTelefono"];
            $celularUsuario = $_REQUEST["inputCelular"];
            $curso = $_REQUEST["asignarCurso"];

                            $comprobacion = $this->comprobarCedula($ciUsuario);
                               
                if($comprobacion[0]['cedula'] !== $ciUsuario){
            $resultado = $this->altaProfesorManejador($ciUsuario,
                                                      $nombreUsuario,
                                                      $apellidoUsuario,
                                                      $sexoUsuario,
                                                      $emailUsuario,
                                                      $claveUsuario,
                                                      $telefonoUsuario,
                                                      $celularUsuario);

                if(!$resultado){
                    $asignar = $this->asignarCursoUsuario($curso, $ciUsuario);
                    if(!$asignar) {
                        $this->modal("Se agrego el Profesor $nombreUsuario "
                                  . "$apellidoUsuario y se asocio al Curso "
                                  . "$curso.");
                        $this->agregarProfesor();
                    } else {
                        $this->modal("No se ha podido asociar el Profesor "
                                   . "$nombreUsuario $apellidoUsuario al $curso.");
                        $this->agregarProfesor();
                    }
                } else {
                $this->modal("No se ha podido ingresar el Profesor "
                             . "$nombreUsuario $apellidoUsuario al sistema.");
                $this->agregarProfesor();
                }
                }
                else{
                    
                     $this->modal("La Cedula Nro. $ciUsuario ya existe en el Sistema ");                                
                     $this->agregarAlumno();
                }

        }
        
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

        public function agregarCurso(){
        try {
            session_start();
             
            $contenido = "<div class='container'>"
            . "<div class = 'page-header' id='tables'>"        
            . "<h1 style='color:#d3d3d3;' align='center'>Agregar Curso</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoCurso'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Año</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' min='2017' max = '2030' class='form-control' id='inputAnio' name='inputAnio' placeholder='2017' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Horario</label>"
            . "<div class='col-lg-8'>"
            . "<input type='time' class='form-control' id='inputHorario' name='inputHorario' placeholder='20-22' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Fecha de Inicio</label>"
            . "<div class='col-lg-8'>"
            . "<input type='date' min='2017-01-01' class='form-control' id='inputFechaIni' name='inputFechaIni' placeholder='aaaa-mm-dd' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Fecha de Fin</label>"
            . "<div class='col-lg-8'>"
            . "<input type='date' class='form-control' id='inputFechaFin' name='inputFechaFin' placeholder='aaaa-mm-dd' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar Profesor</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarProfesor'>"        ;

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Agregar Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);
            
           $resultado = $this->listarProfesores();
            
            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['profesor']. '">' . $fila['profesor'] . '</OPTION>';
                                 
            }
            echo"</select>"            
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div>"
            . "<div class='col-lg-30 col-lg-offset-3'>"
            . "<button type='reset' class='btn btn-default btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg' >Aceptar</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</form>"             
            . "</div>"
            . "</div>"
            . "</fieldset>"
            . "</table>";

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function agregoCurso(){
        try {
            if (isset($_REQUEST['aceptar'])){
                $nombreCurso = $_REQUEST["inputNombre"];
                $anioCurso = $_REQUEST["inputAnio"];   //date("Y-m-d")
                $horarioCurso = $_REQUEST["inputHorario"];
                $inicioCurso = $_REQUEST["inputFechaIni"];
                $finCurso = $_REQUEST["inputFechaFin"];
                
                $horarioCurso = str_replace(":","-",$horarioCurso);

                $comprobarNombreCurso = $this->comprobarNombreCurso($nombreCurso);
                
                if($comprobarNombreCurso[0]['nombre'] == $nombreCurso){
                    
                    $this->agregarCurso();
                    $this->modal("Ya existe un Curso con el nombre $nombreCurso.");
                    
                }
                else {
                    $resultado = $this->altaCursoManejador($nombreCurso,
                                                       $anioCurso,
                                                       $horarioCurso,
                                                       $inicioCurso,
                                                       $finCurso);
                    $profesor = $_REQUEST["asignarProfesor"];
                
                    $consulta = $this->listarProfesoresPorNombre($profesor);
  
                    $ci = $consulta[0][2];

                    $valores = "'".$nombreCurso."' ," .$ci;

                    $asignarProfesor = $this->asignarCursoUsuarios($valores);
                     
                    $asignacionTemas = $this->asociacionCursoTemaSubtemaEjercicio($nombreCurso);               
                    if($resultado == NULL){
                        $this->modal("Se agrego el Curso $nombreCurso y se asigno "
                                   . "el Profesor $profesor");
                        $this->agregarCurso();              
                    }
                  }
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }


    public function asignarCursoProfesores(){
         try {
            session_start();

             $contenido = "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarProfesoresSinCurso'>"
            . "<div class = 'container' >"            
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Profesores sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div>"
            . "<label class='control-label'>Nombre</label>"
            . "<div>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'numero' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
            . "</div>"
            . "</th>"        
            . "</form>"        
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoProfesores'>"        
            . "<th><div>"
            . "<label for='select' class='control-label'>Seleccionar curso</label>"
            . "<label for='select' class='col-lg-2 control-label'></label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Profesores Sin Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $cursos = $this->listarCursosSinProfesor();

            foreach ($cursos as $filaCurso ) {
                echo'<OPTION VALUE="' . $filaCurso['nombre']. '">' . $filaCurso['nombre'] . '</OPTION>';
            }
            echo"</select>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "</th>"
            . "</thead>";

            $resultado = $this->listarProfesoresSinCurso();


            if (!$resultado){
                $this->modal("No existen Profesores sin Curso asginado");
                                echo "</table>"
            . "<br>"
            . "<p align='left'>"
            . "</form>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
            . "<br>"
            . "</p>"
            . "<br>"
            . "</div>";
              
            } else{
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['profesor'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] ."</td>"
                    . "<td><input type='radio' name='curso[]' value = ". $fila['ci'] ." </td>"
                    . "<td></td>"
                    . "</tr>"
                    . "</tbody>";
                }

                echo "</table>"
                . "<br>"
                . "<p align='left'>"
                . "<button type='submit' name = 'asignarCursoProfesor' class='btn btn-primary btn-lg'>Asignar Curso</button>&nbsp"
                . "</form>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
                . "<br>"
                . "</p>"
                . "<br>"
                . "</div>";

               }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }


    public function practicar() {
        try{
            session_start();

            if (isset($_REQUEST["ejercicio"])) {
                $ejercicio = $_REQUEST["ejercicio"];
                $_SESSION["ejercicio"] = $ejercicio;
            } else {
                $ejercicio = $_SESSION["ejercicio"];
            }

            $letraEjercicio =  $this->letraEjercicioTemaManejador($ejercicio);
            //var_dump($letraEjercicio[0][0]);
            $verLetra = $letraEjercicio[0][0];

            $contenido = "<div class='col-lg-3'>"
            . "<br><p></p><ul class='nav nav-pills nav-stacked'>"
            . "<li class='btn btn-default btn-lg '>$ejercicio</li>"
            . "<li>"
            . "<button type='button' class='btn btn-primary btn-group-justified' data-container='body' data-toggle='popover' data-placement='bottom'"
            . "data-content= '$verLetra'"
            . "data-original-title='' title=''>Letra ejercicio</button>"
            . "</li>"
            . "</ul>"
            . "</div>"
            . "<div id='source-modal' class='modal' style='display: none;'>"
            . "<div class='modal-dialog'>"
            . "<div class='modal-content'>"
            . "<div class='modal-header'>"
            . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true' onclick='closeModal()'>&times;</button>"
            . "<h4 class='modal-title'>Atención:</h4>"
            . "</div>"
            . "<div class='modal-body'>"
            . "<p id='mensajeModal'></p>"
            . "</div>"
            . "<div class='modal-footer'>"
            . "<button type='button' class='btn btn-default' data-dismiss='modal' onclick='closeModal()'>Cerrar</button>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";

            $contenido = $contenido . $this->load_page("vistas/html/ejercicios/" . $ejercicio . ".html");
            
            if (isset($_SESSION["mensajeValidacion"])) {
                if ($_SESSION["mensajeValidacion"] === "Felicitaciones, MER realizado correctamente!") {
                    header("location: http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=Introduccion");
                } else {
    //                var_dump($_SESSION["mensajeValidacion"]);
                    $contenido = $contenido . "<script type='text/javascript'>"
    //                            . "alert('" . $_SESSION['mensajeValidacion'] . "');"
                                . "modal('" . $_SESSION["mensajeValidacion"] . "');"
                                . "</script>";
                }
            }
            
            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $head = $this->load_page("vistas/html/headEjercicio.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "A Practicar", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);
            
//            unset($_SESSION["mensajeValidacion"]);
            unset($_SESSION["inputs"]);
            unset($_SESSION["inicioEjercicio"]);
            unset($_SESSION["finEjercicio"]);

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function guardarInputsEjercicio() {
        try {
            session_start();
            $nombreEjercicio = $_SESSION["ejercicio"];
            if (isset($_REQUEST["inputs"])) {
                $_SESSION["inputs"] = $_REQUEST["inputs"];
                $_SESSION["inicioEjercicio"] = $_REQUEST["inicioEjercicio"];
                $_SESSION["finEjercicio"] = $_REQUEST["finEjercicio"];
            }
            
            header("location: http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=validarEjercicio");
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function validarEjercicio() {
        try {
            session_start();
            
            $nombreMer = $_SESSION["ejercicio"];
            $ci = $_SESSION["ciUsuario"];
            $nombreEjercicio = $_SESSION["ejercicio"];
                       
            $inputsString = explode(",", $_SESSION["inputs"]);
            $inputsArray = [];
            $tiposInputs = ["entidadComun", "entidadDebil", "entidadSuperTipo", "entidadSubTipo", "relacionComun", "restricciones"];
            $atributosInputs = ["nombre", "atributo", "restricciones"];
            $objetosRecorridos = [];
            
            // armamos array principal con todos los inputs.
            for ($i = 0; $i < sizeof($inputsString); $i++) {
                // primero excluimos el atributo cardinalidad.
                if (strpos($inputsString[$i], "cardinalidad") === false) {
                    // nos fijamos si el nombre del input tiene el caracter separador.
                    // si no lo tiene, entonces es el input de restricciones.
                    if (strpos(explode(":", $inputsString[$i])[0], "_" ) !== false) {
                        $objeto = explode("_", explode(":", $inputsString[$i])[0])[1];
                        // caso de una relacion. Hay que separar las entidades que la componen.
                        if (strpos($objeto, "-")) {
                            // Las entidades de la relacion.
                            $entidadesRelacion = array(explode("-", $objeto)[1],
                                explode("-", $objeto)[2]);
                            // la relacion
                            $objeto = explode("-", $objeto)[0];
                        } else {
                            // caso de los atributos complejos
                            // o de categorizacion
                            if (strpos($objeto, "|") !== false) {
                                // si es atributo
                                if (strpos($objeto, "atributo") !== false) {
                                    $atributoComp[explode("|", $objeto)[0]] = 
                                            array(explode("|", $objeto)[0],
                                            explode("|", $objeto)[1]);
                                    $objeto = explode("|", $objeto)[0];
                                } else {
                                    // si es entidad
                                    if (strpos($objeto, "entidad") !== false) {
                                        $categorizacion[explode("|", $objeto)[0]] = 
                                                array(explode("|", $objeto)[0],
                                                explode("|", $objeto)[1]);
                                        $objeto = explode("|", $objeto)[0];
                                    }
                                }
                            }
                        }
                    } else {
                        $objeto = explode(":", $inputsString[$i])[0];
                    }
                    // nos fijamos que atributo es el del input.
                    // si no lo tiene, entonces es el input de restricciones.
                    if (strpos(explode(":", $inputsString[$i])[0], "_" ) !== false) {
                        $atributoInput = explode("_", explode(":", $inputsString[$i])[0])[0];
                    } else {
                        $atributoInput = explode(":", $inputsString[$i])[0];
                    }
                    // asignamos el valor
                    $valor = explode(":", $inputsString[$i])[1];
                    
                    // armamos el array del Mer
                    if ($objeto === "restricciones" ) {
                        $arrayMer = array($nombreMer, "sol_alumno", $ci, $nombreEjercicio, $valor);
                    }
                    
                    // armamos el array de las Entidades
                    if (strpos($objeto, "entidad") !== false && $atributoInput === "nombre") {
                        if (strpos($objeto, "Comun")) {
                            $arrayEntidades[$objeto] = array($valor, "comun",
                                    NULL, "N/A", $nombreMer, $ci);
                        } else {
                            if (strpos($objeto, "Debil") !== false) {
                                $arrayEntidades[$objeto] = array($valor, "debil",
                                        NULL, "N/A", $nombreMer, $ci);
                            } else {
                                if (strpos($objeto, "Cat") !== false) {
                                    if (strpos($objeto, "Comp") !== false) {
                                        $arrayEntidades[$objeto] = array($valor, "supertipo",
                                                NULL, "completa", $nombreMer, $ci);
                                    } else {
                                        if (strpos($objeto, "Dis") !== false) {
                                            $arrayEntidades[$objeto] = array($valor, "supertipo",
                                                    NULL, "disjunta", $nombreMer, $ci);
                                        }
                                    }
                                } else {
                                    if (strpos($objeto, "Sub") !== false) {
                                        $tipoCategorizacion = $categorizacion[$objeto][1];
                                        if (strpos($tipoCategorizacion, "Comp") !== false) {
                                            $tipoCategorizacion = "completa";
                                            $arrayEntidades[$objeto] = array($valor, "subtipo",
                                                $arrayEntidades[$categorizacion[$objeto][1]][0], 
                                                $tipoCategorizacion, $nombreMer, $ci);
                                        } else {
                                            if (strpos($tipoCategorizacion, "Dis") !== false) {
                                                $tipoCategorizacion = "disjunta";
                                                $arrayEntidades[$objeto] = array($valor, "subtipo",
                                                    $arrayEntidades[$categorizacion[$objeto][1]][0], 
                                                    $tipoCategorizacion, $nombreMer, $ci);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // armamos el array de los Atributos
                    if (strpos($atributoInput, "atributo") !== false) {
                        if (strpos($atributoInput, "Comun")) {
                            // nos fijamos si se seteo la variable de atributos
                            // complejos
                            if (!isset($atributoComp)) {
                                // si se trata del atributo de una entidad
                                if (strpos($objeto, "entidad") !== false) {
                                    $entidadDeAtributo = $arrayEntidades[$objeto][0];
                                    $relacionDeAtributo = NULL;
                                // sino, es el atributo de una relacion
                                } else {
                                    $entidadDeAtributo = NULL;
                                    $relacionDeAtributo = $arrayRelaciones[$objeto][0];
                                }
                                $arrayAtributos[$objeto."_".$atributoInput."_".$i] = 
                                    array($valor, "comun", NULL, $entidadDeAtributo, 
                                        $relacionDeAtributo, $nombreMer, $ci);
                            // si esta seteada la varibale de atributos complejos
                            } else {
                                foreach ($arrayAtributos as $key => $value) {
                                    $tipoAtributo = $value[1];
                                    if ($tipoAtributo === "complejo") {
                                        // si esta creado el array del atributo
                                        // complejo pero sin atributo multivaluado
                                        if ($arrayAtributos[$key][2] === NULL) {
                                            $arrayAtributos[$key][2] = $valor;
                                        } else {
                                            // Si esta creado y ya tiene un atributo
                                            // multivaluado, entonces es un nuevo
                                            // registro
                                            $arrayAtributos[$objeto."_".$atributoInput."_".$i] = 
                                                    $arrayAtributos[$key];
                                            $arrayAtributos[$objeto."_".$atributoInput."_".$i][2] =
                                                    $valor;
                                        }
                                    }
                                }
                                unset($atributoComp);
                            }
                            
                        } else {
                            if (strpos($atributoInput, "Comp")) {
                                $arrayAtributos[$objeto."_".$atributoInput."_".$i] = 
                                        array($valor, "complejo", NULL, $arrayEntidades[$objeto][0],
                                            NULL, $nombreMer, $ci);
                            } else {
                                if (strpos($atributoInput, "Det")) {
                                    $arrayAtributos[$objeto."_".$atributoInput."_".$i] = 
                                            array($valor, "determinante", NULL, $arrayEntidades[$objeto][0],
                                                NULL, $nombreMer, $ci);
                                }
                            }
                        }
                    }
                    
                    // armamos el array de las Relaciones
                    if (strpos($objeto, "relacion") !== false && $atributoInput === "nombre") {
                        if (strpos($objeto, "Comun")) {
                            $arrayRelaciones[$objeto] = 
                                    array($valor, "comun", $arrayEntidades[$entidadesRelacion[0]][0],
                                        $arrayEntidades[$entidadesRelacion[1]][0], NULL, 
                                        $nombreMer, $ci);
                        } else {
                            if (strpos($objeto, "Auto")) {
                                $arrayRelaciones[$objeto] = 
                                        array($valor, "comun", $arrayEntidades[$entidadesRelacion[0]][0],
                                            $arrayEntidades[$entidadesRelacion[1]][0], NULL, 
                                            $nombreMer, $ci);
                            }
                        }
                    }
                }
            }
            
//            var_dump($inputsString);
//            var_dump($arrayMer);
//            var_dump($arrayEntidades);
//            var_dump($arrayAtributos);
//            var_dump($arrayRelaciones);
            
            $nombre_mer = $arrayMer[0];
            $ci_usuario = $arrayMer[2];
            $nombre_ejercicio = $arrayMer[3];
            $restriccion = ($arrayMer[4] === "") ? null : $arrayMer[4];
            $inicioEjercicio = $_SESSION["inicioEjercicio"];
            $finEjercicio = $_SESSION["finEjercicio"];
            
            // Verificar si el alumno ya tiene una solucion para el ejercicio
            $buscarEjercicioAlumno = $this->buscarEjercicioAlumno($ci_usuario, $nombre_ejercicio);
            
            // Si el alumno todavia no tiene solucion hecha para este ejercicio
            if ($this->getMensajeManejador() === "No se ha encontrado el ejercicio para ese usuario.") {
                // Percistimos sol_mer.
                $this->guardarSolucionMer($nombre_mer, $ci_usuario, 
                        $nombre_ejercicio, $restriccion, $inicioEjercicio,
                        $finEjercicio);

                // Percistimos sol_entidad.
                foreach ($arrayEntidades as $key => $value) {
                    if (sizeof($arrayEntidades[$key]) === 6) {
                        $nombre_entidad = $value[0];
                        $tipo_entidad = $value[1];
                        $entidad_supertipo = $value[2];
                        $tipo_categorizacion = $value[3];
                    } else {
                        $nombre_entidad = $value[0];
                        $tipo_entidad = $value[1];
                        $entidad_supertipo = $value[2];
                        $tipo_categorizacion = "N/A";
                    }
                    $this->guardarSolucionMerEntidad($nombre_entidad, $tipo_entidad,
                            $entidad_supertipo, $tipo_categorizacion, $nombre_mer,
                            $ci_usuario);
                }

                // Percistimos sol_atributo.
                foreach ($arrayAtributos as $key => $value) {
                    if (sizeof($arrayAtributos[$key]) === 6) {
                        $nombre_atributo = $value[0];
                        $tipo_atributo = $value[1];
                        $nombre_atributo_multivaluado = NULL;
                        $nombre_entidad = $value[2];
                        $nombre_relacion = $value[3];
                    } else {
                        $nombre_atributo = $value[0];
                        $tipo_atributo = $value[1];
                        $nombre_atributo_multivaluado = 
                               $arrayAtributos[$key][2];
                        $nombre_entidad = $value[3];
                        $nombre_relacion = $value[4];
                    }
                    $this->guardarSolucionMerAtributo($nombre_atributo,
                            $tipo_atributo, $nombre_atributo_multivaluado, 
                            $nombre_entidad, $nombre_relacion, $nombre_mer,
                            $ci_usuario);
                }

                // Percistimos sol_relacion.
                foreach ($arrayRelaciones as $key => $value) {
                    $nombre_relacion = $value[0];
                    $nombre_entidadA = $value[2];
                    $nombre_entidadB = $value[3];
                    $agregacion = "";
                    $this->guardarSolucionMerRelacion($nombre_relacion,
                            $nombre_entidadA, $nombre_entidadB, $agregacion,
                            $nombre_mer, $ci_usuario);
                }
            } else {
                // Eliminamos el MER anterior del alumno.
                $this->deleteSolucionMerAtributo($ci_usuario, $nombre_mer);
                $this->deleteSolucionMerAgregacion($ci_usuario, $nombre_mer);
                $this->deleteSolucionMerRelacion($ci_usuario, $nombre_mer);
                $this->deleteSolucionMerEntidad($ci_usuario, $nombre_mer);
                $this->deleteSolucionMer($ci_usuario, $nombre_mer);
                
                // Percistimos sol_mer.
                $this->guardarSolucionMer($nombre_mer, $ci_usuario, 
                        $nombre_ejercicio, $restriccion, $inicioEjercicio,
                        $finEjercicio);

                // Percistimos sol_entidad.
                foreach ($arrayEntidades as $key => $value) {
                    if (sizeof($arrayEntidades[$key]) === 6) {
                        $nombre_entidad = $value[0];
                        $tipo_entidad = $value[1];
                        $entidad_supertipo = $value[2];
                        $tipo_categorizacion = $value[3];
                    } else {
                        $nombre_entidad = $value[0];
                        $tipo_entidad = $value[1];
                        $entidad_supertipo = $value[2];
                        $tipo_categorizacion = "N/A";
                    }
                    $this->guardarSolucionMerEntidad($nombre_entidad, $tipo_entidad,
                            $entidad_supertipo, $tipo_categorizacion, $nombre_mer,
                            $ci_usuario);
                }

                // Percistimos sol_atributo.
                foreach ($arrayAtributos as $key => $value) {
                    if (sizeof($arrayAtributos[$key]) === 6) {
                        $nombre_atributo = $value[0];
                        $tipo_atributo = $value[1];
                        $nombre_atributo_multivaluado = NULL;
                        $nombre_entidad = $value[2];
                        $nombre_relacion = $value[3];
                    } else {
                        $nombre_atributo = $value[0];
                        $tipo_atributo = $value[1];
                        $nombre_atributo_multivaluado = 
                               $arrayAtributos[$key][2];
                        $nombre_entidad = $value[3];
                        $nombre_relacion = $value[4];
                    }
                    $this->guardarSolucionMerAtributo($nombre_atributo,
                            $tipo_atributo, $nombre_atributo_multivaluado, 
                            $nombre_entidad, $nombre_relacion, $nombre_mer,
                            $ci_usuario);
                }

                // Percistimos sol_relacion.
                foreach ($arrayRelaciones as $key => $value) {
                    $nombre_relacion = $value[0];
                    $nombre_entidadA = $value[2];
                    $nombre_entidadB = $value[3];
                    $agregacion = "";
                    $this->guardarSolucionMerRelacion($nombre_relacion,
                            $nombre_entidadA, $nombre_entidadB, $agregacion,
                            $nombre_mer, $ci_usuario);
                }
            }
            
            // Solucion del sistema para el ejercicio
            $solucionSistema = $this->armarMerSolucionSistema($nombreEjercicio);
            $solucionSistemaMer = $solucionSistema["MER"];
            $solucionSistemaEntidades = $solucionSistema["Entidades"];
            $solucionSistemaAtributos = $solucionSistema["Atributos"];
            $solucionSistemaRelaciones = $solucionSistema["Relaciones"];
            
            // Del MER no hay nada para validar.
            // Validar Entidades
            foreach ($arrayEntidades as $key => $value) {
                $entidadAlumno = trim(strtolower($value[0]));
                $tipoEntidadAlumno = $value[1];
                $entidadSuperTipoAlumno = ($value[2] === null || 
                        $value[2] === "" || $value[2] === "null" ? null :
                        trim(strtolower($value[2])));
                $tipoCategorizacionAlumno = $value[3];
                foreach ($solucionSistemaEntidades as $key => $value) {
                    $entidadSistema = trim(strtolower($value[0]));
                    $tipoEntidadSistema = $value[1];
                    $entidadSuperTipoSistema = ($value[2] === null || 
                        $value[2] === "" || $value[2] === "null" ? null :
                        trim(strtolower($value[2])));
                    $tipoCategorizacionSistema = $value[3];
                    if ($entidadAlumno === $entidadSistema && 
                            $tipoEntidadAlumno === $tipoEntidadSistema && 
                            $entidadSuperTipoAlumno === $entidadSuperTipoSistema && 
                            $tipoCategorizacionAlumno === $tipoCategorizacionSistema) {
                        $entidadValidada = true;
                        break;
                    } else {
                        $entidadValidada = false;
                    }
                }
                if ($entidadValidada === false) {
                    break;
                }
                if ($entidadValidada === false) {
                    break;
                }
            }
            if ($entidadValidada === false) {
                $mensajeValidacion = "Debe corregir lo siguiente: " . $entidadAlumno;
            } else {
                // Validar Atributos
                foreach ($arrayAtributos as $key => $value) {
                    $atributoAlumno = trim(strtolower($value[0]));
                    $tipoAtributoAlumno = $value[1];
                    $nombreAtrMultAlumno = ($value[2] === null || 
                        $value[2] === "" || $value[2] === "null" ? null :
                        trim(strtolower($value[2])));
                    $nombreEntidadAlumno = ($value[3] === null || 
                        $value[3] === "" || $value[3] === "null" ? null :
                        trim(strtolower($value[3])));
                    $nombreRelacionAlumno = ($value[4] === null || 
                        $value[4] === "" || $value[4] === "null" ? null :
                        trim(strtolower($value[4])));
                    foreach ($solucionSistemaAtributos as $key => $value) {
                        $atributoSistema = trim(strtolower($value[0]));
                        $tipoAtributoSistema = $value[1];
                        $nombreAtrMultSistema = ($value[2] === null || 
                            $value[2] === "" || $value[2] === "null" ? null :
                            trim(strtolower($value[2])));
                        $nombreEntidadSistema = ($value[3] === null || 
                            $value[3] === "" || $value[3] === "null" ? null :
                            trim(strtolower($value[3])));
                        $nombreRelacionSistema = ($value[4] === null || 
                            $value[4] === "" || $value[4] === "null" ? null :
                            trim(strtolower($value[4])));
                        if ($atributoAlumno === $atributoSistema &&
                                $tipoAtributoAlumno === $tipoAtributoSistema &&
                                $nombreAtrMultAlumno === $nombreAtrMultSistema && 
                                $nombreEntidadAlumno === $nombreEntidadSistema && 
                                $nombreRelacionAlumno === $nombreRelacionSistema) {
                            $atributoValidado = true;
                            break;
                        } else {
                            $atributoValidado = false;
                        }
                    }
                    if ($atributoValidado === false) {
                        break;
                    }
                    if ($atributoValidado === false) {
                        break;
                    }
                }
                if ($atributoValidado === false) {
                    $mensajeValidacion = "Debe corregir lo siguiente: " . $atributoAlumno;
                } else {
                    // Validar Relaciones
                    foreach ($arrayRelaciones as $key => $value) {
                        $relacionAlumno = trim(strtolower($value[0]));
                        foreach ($solucionSistemaRelaciones as $key => $value) {
                            $relacionSistema = trim(strtolower($value[0]));
                            if ($relacionAlumno === $relacionSistema) {
                                $relacionValidada = true;
                                break;
                            } else {
                                $relacionValidada = false;
                            }
                        }
                        if ($relacionValidada === false) {
                            break;
                        }
                    }
                    if ($relacionValidada === false) {
                        $mensajeValidacion = "Debe corregir lo siguiente: " . $relacionAlumno;
                    } else {
                        $mensajeValidacion = "Felicitaciones, MER realizado correctamente!";
                    }
                }
            }
            
            $_SESSION["mensajeValidacion"] = $mensajeValidacion;
            
            header("location: http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=practicar&ejercicio=" . $_SESSION["ejercicio"] . "");
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignarCursoAlumnos(){
        try {
            session_start();

            $contenido = "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarAlumnoSinCurso'>"
            . "<div class = 'container'>"            
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Alumnos sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div>"
            . "<label class='control-label'>Nombre</label>"
            . "<div>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'numero' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
            . "</div>"
            . "</th>"        
            . "</form>"        
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoAlumnos'>"        
            . "<th><div>"
            . "<label  for='select' class='control-label'>Seleccionar curso</label>"
            ."<label for='select' class='col-lg-2 control-label'></label>"
            ."<div class='col-lg-8'>"
            ."<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Alumnos Sin Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $cursos = $this->listarCursosActivos();

            foreach ($cursos as $filaCurso ) {
               echo'<OPTION VALUE="' . $filaCurso['nombre']. '">' . $filaCurso['nombre'] . '</OPTION>';
            }
             echo"</select>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "</th>"
            . "</thead>";

            $resultado = $this->listarAlumnosSinCurso();

            if(!$resultado){
                
                $this->modal("No existen Alumnos sin Curso asignado");
                echo "</table>"
            . "<br>"
            ."<p align='left'>"
            ."</form>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
            ."<br>"
            ."</p>"
            . "<br>"
            ."</div>";
             
                
            } else {
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['alumno'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] ."</td>"
                    . "<td><input type='checkbox' name='curso[]' value = ". $fila['ci'] ." </td>"
                    . "<td></td>"
                    . "</tr>"
                    . "</tbody>";
                }

            echo "</table>"
            . "<br>"
            ."<p align='left'>"
            ."<button type='submit' name = 'asignarCursoAlumno' class='btn btn-primary btn-lg'>Asignar Curso</button>&nbsp"
            ."</form>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
            ."<br>"
            ."</p>"
            . "<br>"
            ."</div>";
            }

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignoCursoAlumnos(){
        try {
             
            if (isset($_REQUEST['asignarCursoAlumno'])){
                 
                if (isset($_REQUEST['curso'])){
                    $curso = $_REQUEST['asignarCurso'];
                    $check[] = $_REQUEST['curso'] ? $_REQUEST['curso']:NULL;
                    foreach ($check as $check1 => $check2){
                        $longitud = count($check2);             
                        for($i=0 ;$i<$longitud ;$i++ ){
                            $valores = "'" .$curso."' ," .$check2[$i];
                            $this->asignarCursoUsuarios($valores);
                            
                        }
                         $this->asignarCursoAlumnos();
                    }

                }
                else{   
                     $this->asignarCursoAlumnos();
                    $this->modal("Debe seleccionar al menos un alumno"); 
                    
                }                     
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignoCursoProfesores(){
        try {
          
            if (isset($_REQUEST['asignarCursoProfesor'])){
                 if (isset($_REQUEST['curso'])){               
                    $curso = $_REQUEST['asignarCurso'];
                    $check[] = $_REQUEST['curso']? $_REQUEST['curso']: NULL;

                    foreach ($check as $check1 => $check2){
                        $longitud = count($check2);

                        for($i=0 ;$i<$longitud ;$i++ ){
                            $valores = "'" .$curso."' ," .$check2[$i];
                            $this->asignarCursoUsuarios($valores);
                        }
                          $this->asignarCursoProfesores();
                    }

                }            
                else{   
                      $this->asignarCursoProfesores();
                    $this->modal("Debe seleccionar un profesor"); 
                    
                }   
            }                  
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function filtrarAlumnos() {
        //chota
        try {
            session_start();            
            if (!isset($_POST["filtrar"])) {
                 $nombre = $_REQUEST["filtNom"];
                 $apellido = $_REQUEST["filtNom"];
                 $ci = $_REQUEST["numero"];
                 $curso = $_REQUEST["filtCur"];
 
                $contenido = "<div class='container'>"
                . "<form method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarAlumno'>"
                . "<div class='page-header' id='tables'>"
                . "<h1 style='color:#d3d3d3;' align='center'>Alumnos</h1>"
                . "</div>"
                . "<div>"
                . "<table class='table table-striped table-hover'>"
                . "<thead>"
                . "<tr class='danger'>"
                . "<th><div>"            
                . "<label class='control-label'>Nombre</label>"
                . "<div class='input'>"
                . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
                . "</div>"
                . "</th>"
                . "<th><div>"
                . "<label class='control-label'>Cedula</label>"
                . "<div class='input'>"
                . "<input type='number' name = 'numero' value='' maxlength='8' class='form-control' placeholder='Filtrar por cedula'>"
                . "</div>"
                . "</th>"
                . "<th><div>"
                . "<label class='control-label'>Curso</label>"
                . "<div class='input'>"
                . "<input type='text' name = 'filtCur' value=''class='form-control' placeholder='Filtrar por curso'>"
                . "</div>"
                . "</th>"
                . "<th>"
                . "<th>"
                . "<div>"
                . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
                . "</div>"
                . "</th>"
                . "</thead>"
                . "</form>" ;

                $pagina = $this->load_template("inicio");
                $head = $this->load_page("vistas/html/headPrincipal.html");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                $pagina = $this->replace_content("/Header/", $header, $pagina);
                $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                $pagina = $this->replace_content("/Titulo/", "Profesores", $pagina);
                $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

                $this->view_page($pagina);
                $resultado = $this->filtrarManejadorAlumnos($nombre,$apellido,$ci,$curso);
                if($resultado == !NULL){
            foreach ($resultado as $fila) {
                echo "<tbody>"
                 . "<tr class='active'>"
                 . "<td>" . $fila['alumno'] . "</td>"
                 . "<td>" . $fila['ci'] . "</td>"
                 . "<td>" . $fila['curso'] . "</td>"
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=eliminarRegistro&curso=$fila[curso]&ci=$fila[ci]'>
                   <button type='button' name = 'eliminarRegistro' class='btn btn-primary'>Eliminar</button></a>"."</td>" 
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificarRegistroAlumno&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"                    
                 . "</tr>"
                 . "</tbody>";
            }

             echo "</table>";
             $onclick = "document.getElementById('selectedFile').click();";

             echo "<br>"
            . "<p align='left'>"
            . "<form action='/ProyectoFinal/ProyectoFinal/vistas/importarAlumnos.php' method='post' enctype='multipart/form-data'>"
            . "<input type='file' name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
            . "<input type='button' value='Importar grupo alumnos' onclick=" . $onclick ." class='btn btn-primary btn-lg' />&nbsp"
            . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
            . "</form>"
            . "</p><p align='left'>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarAlumno'><button type='button' name = 'agregarAlumno' class='btn btn-primary btn-lg'>Agregar alumno</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoAlumno'><button type='button' name = 'alumnosSinCurso' class='btn btn-primary btn-lg'>Alumnos sin curso</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</p>";
                }
                else{
                
                    $this->modal("No existen registros para la busqueda seleccionada");
                    echo "</table>";

                    echo "<br>"
                    . "<p align='left'>"
                    . "<form action='../importarAumnos.php' method='post' enctype='multipart/form-data'>"
                    . "<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
                    . "<input type='button'  value='Importar grupo profesores' onclick='document.getElementById('selectedFile').click();' class='btn btn-primary btn-lg' />&nbsp"
                    . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
                    . "</form>"
                    . "</p><p align='left'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarAlumnos'><button type='button' name = 'agregarAlumno' class='btn btn-primary btn-lg'>Agregar alumno</button></a>&nbsp"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoAlumno'><button type='button' name = 'alumnosSinCurso' class='btn btn-primary btn-lg'>Alumnos sin curso</button></a>&nbsp"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                    . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
                    . "</p>";
                
                }                  
            }
 
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
           }

    }
    
    public function filtrarProfesores() {
        try {
            session_start();            
            if (!isset($_POST["filtrar"])) {
                 $nombre = $_REQUEST["filtNom"];
                 $apellido = $_REQUEST["filtNom"];
                 $ci = $_REQUEST["numero"];
                 $curso = $_REQUEST["filtCur"];
 
                $contenido = "<div class='container'>"
                . "<form method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarProfesor'>"
                . "<div class='page-header' id='tables'>"
                . "<h1 style='color:#d3d3d3;' align='center'>Profesores</h1>"
                . "</div>"
                . "<div>"
                . "<table class='table table-striped table-hover'>"
                . "<thead>"
                . "<tr class='danger'>"
                . "<th><div>"            
                . "<label class='control-label'>Nombre</label>"
                . "<div class='input'>"
                . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
                . "</div>"
                . "</th>"
                . "<th><div>"
                . "<label class='control-label'>Cedula</label>"
                . "<div class='input'>"
                . "<input type='number' name = 'numero' value='' maxlength='8' class='form-control' placeholder='Filtrar por cedula'>"
                . "</div>"
                . "</th>"
                . "<th><div>"
                . "<label class='control-label'>Curso</label>"
                . "<div class='input'>"
                . "<input type='text' name = 'filtCur' value=''class='form-control' placeholder='Filtrar por curso'>"
                . "</div>"
                . "</th>"
                . "<th>"
                . "<th>"        
                . "<div>"
                . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
                . "</div>"
                . "</th>"
                . "</thead>"
                . "</form>" ;

                $pagina = $this->load_template("inicio");
                $head = $this->load_page("vistas/html/headPrincipal.html");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
                $pagina = $this->replace_content("/Header/", $header, $pagina);
                $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                $pagina = $this->replace_content("/Titulo/", "Profesores", $pagina);
                $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

                $this->view_page($pagina);
                $resultado = $this->filtrarManejadorProfesores($nombre,$apellido,$ci,$curso);
                if($resultado == !NULL){
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['profesor'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] . "</td>"
                   . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=eliminarRegistro&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'eliminarRegistro' class='btn btn-primary'>Eliminar</button></a>"."</td>" 
                 . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificarRegistroProfesor&curso=$fila[curso]&ci=$fila[ci]'>
                  <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"                    
                 . "</tr>"
                 . "</tbody>";
                }

            echo "</table>";

                echo "<br>"
                . "<p align='left'>"
                . "<form action='../importarProfesores.php' method='post' enctype='multipart/form-data'>"
                . "<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
                . "<input type='button'  value='Importar grupo profesores' onclick='document.getElementById('selectedFile').click();' class='btn btn-primary btn-lg' />&nbsp"
                . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
                . "</form>"
                . "</p><p align='left'>"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarProfesor'><button type='button' name = 'agregarProfesores' class='btn btn-primary btn-lg'>Agregar profesor</button></a>&nbsp"
                . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoProfesor'><button type='button' name = 'ProfesoresSinCurso' class='btn btn-primary btn-lg'>Profesores sin curso</button></a>&nbsp"
                                        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
                . "</p>";
                }
                else{
                
                    $this->modal("No existen registros para la busqueda seleccionada");
                    echo "</table>";

                    echo "<br>"
                    . "<p align='left'>"
                    . "<form action='../importarProfesores.php' method='post' enctype='multipart/form-data'>"
                    . "<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
                    . "<input type='button'  value='Importar grupo profesores' onclick='document.getElementById('selectedFile').click();' class='btn btn-primary btn-lg' />&nbsp"
                    . "<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
                    . "</form>"
                    . "</p><p align='left'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarProfesor'><button type='button' name = 'agregarProfesores' class='btn btn-primary btn-lg'>Agregar profesor</button></a>&nbsp"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoProfesor'><button type='button' name = 'ProfesoresSinCurso' class='btn btn-primary btn-lg'>Profesores sin Curso</button></a>&nbsp"
                                            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                    . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
                    . "</p>";
                
                }                  
            }
 
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
           }

    }
    
    public function filtrarAlumnosSinCurso(){
        try {
            session_start();
            if (!isset($_POST["filtrar"])) {
                 $nombre = $_REQUEST["filtNom"];
                 $apellido = $_REQUEST["filtNom"];
                 $ci = $_REQUEST["numero"];
                 $curso =''; 

            $contenido = "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarAlumnoSinCurso'>"
             ."<div class='container'>"            
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Alumnos sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div>"
            . "<label class='control-label'>Nombre</label>"
            . "<div>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'numero' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
            . "</div>"
            . "</th>"        
            . "</form>"        
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoAlumnos'>"        
            . "<th><div>"
            . "<label for='select' class='control-label'>Seleccionar curso</label>"
            . "<label for='select' class='col-lg-2 control-label'></label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";


            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Alumnos Sin Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $cursos = $this->listarCursosActivos();

            foreach ($cursos as $filaCurso ) {
               echo'<OPTION VALUE="' . $filaCurso['nombre']. '">' . $filaCurso['nombre'] . '</OPTION>';
            }
             echo"</select>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "</th>"
            . "</thead>";

            $resultado = $this->filtrarAlumnosSinCursoManejador($nombre , $apellido , $ci);
            if(!$resultado){
                $this->modal("No existen Alumnos sin Curso asignado");
                echo "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                .  "<tbody>"
                . "</table><br>"
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" ;
            } else {
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['alumno'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] ."</td>"
                    . "<td><input type='checkbox' name='curso[]' value = ". $fila['ci'] ." </td>"
                    . "<td></td>"
                    . "</tr>"
                    . "</tbody>";
                }

            echo "</table>"
            . "<br>"
            ."<p align='left'>"
            ."<button type='submit' name = 'asignarCursoAlumno' class='btn btn-primary btn-lg'>Asignar Curso</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
            ."</form>"
            ."<br>"
            ."</p>"
            . "<br>"
            ."</div>";
          
            }

            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function filtrarProfesoresSinCurso(){
        try {
            session_start();
            if (!isset($_POST["filtrar"])) {
                 $nombre = $_REQUEST["filtNom"];
                 $apellido = $_REQUEST["filtNom"];
                 $ci = $_REQUEST["numero"];
                 $curso =''; 

            $contenido = "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarProfesoresSinCurso'>"
            . "<div class = 'container'>"            
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Profesores sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div>"
            . "<label class='control-label'>Nombre</label>"
            . "<div>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'numero' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>"       
            . "</div>"
            . "</th>"        
            . "</form>"        
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoAlumnos'>"        
            . "<th><div>"
            . "<label for='select' class='control-label'>Seleccionar curso</label>"
            . "<label for='select' class='col-lg-2 control-label'></label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";


            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Alumnos Sin Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $cursos = $this->listarCursosActivos();

            foreach ($cursos as $filaCurso ) {
               echo'<OPTION VALUE="' . $filaCurso['nombre']. '">' . $filaCurso['nombre'] . '</OPTION>';
            }
             echo"</select>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "</th>"
            . "</thead>";

            $resultado = $this->filtrarProfesoresSinCursoManejador($nombre , $apellido , $ci);
            if(!$resultado){
                $this->modal("No existen Profesores sin Curso asignado");
                echo "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
                . "<tbody>"
                . "</table><br>"
                . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" ;
                
            } else {
                foreach ($resultado as $fila) {
                    echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['profesor'] . "</td>"
                    . "<td>" . $fila['ci'] . "</td>"
                    . "<td>" . $fila['curso'] ."</td>"
                    . "<td><input type='checkbox' name='curso[]' value = ". $fila['ci'] ." </td>"
                    . "<td></td>"
                    . "</tr>"
                    . "</tbody>";
                                echo "</table>"
            . "<br>"
            . "<p align='left'>"
            . "<button type='submit' name = 'asignarCursoAlumno' class='btn btn-primary btn-lg'>Asignar Curso</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" 
            . "</form>"
            . "<br>"
            . "</p>"
            . "<br>"
            . "</div>";
                }

            }

            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function filtrarCurso() {
        try {
             session_start();
              if (!isset($_POST["filtrar"])) {
                 $nombre = $_REQUEST["filtNom"];
                 $apellido = $_REQUEST["filtNom"];
                 $anio = $_REQUEST["filtAno"];
                 $horario = $_REQUEST["filtHor"];
                 $curso = $_REQUEST["filtCur"];; 

            $contenido = "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=filtrarCurso'>"
            . "<div class = 'container'>" 
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Cursos</h1>"
            . "</div>"
            . "<div class='item'>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Curso</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtCur' class='form-control' placeholder='Filtrar por curso'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Año</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtAno' class='form-control' placeholder='Filtrar por año'>"
            . "</div>"
            . "</th>"
            . "<th><div>"
            . "<label class='control-label'>Horario</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtHor' class='form-control' placeholder='Filtrar por horario'>"
            . "</div>"
            . "</th>". "<th><div>"
            . "<label class='control-label'>Profesor</label>"
            . "<div class='input'>"
            . "<input type='text' name = 'filtNom' class='form-control' placeholder='Filtrar por profesor'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div>"
            . "<input type='submit' name 'filtrar' value = 'FILTRAR' class='btn btn-primary'></button>" 
            . "</div>"
            . "</th>"
            . "</thead>"
            . "</form>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Cursos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->filtrarManejadorCursos($nombre ,$apellido , $anio ,$horario ,$curso);
            if(!$resultado == NULL){
                foreach ($resultado as $fila) {
                     echo "<tbody>"
                    . "<tr class='active'>"
                    . "<td>" . $fila['curso'] . "</td>"
                    . "<td>" . $fila['anio'] . "</td>"
                    . "<td>" . $fila['horario'] . "</td>"
                    . "<td>" . $fila['profesor'] . "</td>"
                    . "<td>". "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?"
                    . "action=modificarRegistroCurso&curso=$fila[curso]&anio=$fila[anio]&horario=$fila[horario]&profesor=$fila[profesor]'>
                    <button type='button' name = 'modificarRegistro' class='btn btn-primary'>Modificar</button></a>"."</td>"               
                    . "</tr>"
                    . "</tbody>";
                }
            echo "</table>";

            echo "<br>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarCurso'>"
            . "<button type='button' name = 'agregarCurso' class='btn btn-primary btn-lg'>Agregar curso</button></a>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>"          
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" ; 
        
            }
        else{
             $this->modal("No existen registros para la busqueda seleccionada");
             echo "</table>";
             echo "<br>"
             . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarCurso'>"
             . "<button type='button' name = 'agregarCurso' class='btn btn-primary btn-lg'>Agregar curso</button></a> &nbsp"
             . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>"          
             . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>" ; 
            
        }
        
        }
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
        
    }    

    public function importarAlumnos(){
        try {      
 
            //session_start();
            $this->alumnosBedelia();
            $DB = new conexionDB();        
            $DB->conectar();
            
            $archivo = $_FILES['archivos-excel']['name'];
            $destino = 'bak_'.$archivo;
            
            if(!strpos($archivo, 'xlsx')  || ($archivo == NULL)  ){
                
                 $this->modal(" Debe seleccionar un archivo correcto ");             
            }
            else{                  
                                    
                $objPHPExcel = $objReader->load('bak_'.$archivo);

                $objPHPExcel = PHPEXCEL_IOFACTORY::load($archivo);
                
                $objPHPExcel->setActiveSheetIndex(0);

                $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                for ($i = 2; $i <= $numRows; $i++) {
                //Insertamos los datos con los valores...

                    $ci = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                    $nombre = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                    $apellido = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                    $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                    $email = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                    $telefono = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                    $celular = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();       
                    $pass = md5($ci);


                
                    $resultado = $this->importarAlumnosManejador($ci ,$nombre , $apellido ,
                                                        $sexo ,$email ,
                                                        $pass ,$telefono , $celular); 
                    
                        if ($resultado == !false){     
                       
                              //$this->modal(" No se ha podido realizar la importacion") ;
                        }
                        else{
                           
                            //$this->modal("Se ha realizado correctamente la "
                            //        . "importacion del Alumno: <br>"
                            //        . " $ci $nombre <br>") ;                  
                        }          
                }
                        
             }      
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function importarProfesores(){
        try {      
 
            //session_start();
            $this->profesoresBedelia();
            $DB = new conexionDB();        
            $DB->conectar();
            
            $archivo = $_FILES['archivos-excel']['name'];
            $destino = 'bak_'.$archivo;
            
            if(!strpos($archivo, 'xlsx')  || ($archivo == NULL)  ){
                
                 $this->modal(" Debe seleccionar un archivo correcto ");             
            }
            else{                  
                                    
                $objPHPExcel = $objReader->load('bak_'.$archivo);

                $objPHPExcel = PHPEXCEL_IOFACTORY::load($archivo);
                
                $objPHPExcel->setActiveSheetIndex(0);

                $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                for ($i = 2; $i <= $numRows; $i++) {
                //Insertamos los datos con los valores...

                    $ci = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                    $nombre = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                    $apellido = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                    $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                    $email = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                    $telefono = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                    $celular = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();       
                    $pass = md5($ci);


                
                    $resultado = $this->importarProfesoresManejador($ci ,$nombre , $apellido ,
                                                        $sexo ,$email ,
                                                        $pass ,$telefono , $celular); 
                    
                        if ($resultado == !false){     
                       
                              //$this->modal(" No se ha podido realizar la importacion") ;
                        }
                        else{
                           
                            //$this->modal("Se ha realizado correctamente la "
                            //        . "importacion del Alumno: <br>"
                            //        . " $ci $nombre <br>") ;                  
                        }          
                }
                        
             }      
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function eliminarRegistroProfesor(){
        try {       
             
            if (isset($_REQUEST["ci"])){
             
                if(isset($_REQUEST['curso'])){
                                                      
                    $ci_usuario = $_REQUEST["ci"];
                    $curso = $_REQUEST["curso"];

                    $asociacion = $this->eliminarRegistroAsociacionManejador($curso,$ci_usuario);
               
                    $resultado = $this->eliminarRegistroManejador($ci_usuario);
                                         
                    $this->profesoresBedelia(); 
                    $this->modal(" Registro eliminado correctamente") ;
                                                            
                }
                        
                }                     
                else{
                     $this->profesoresBedelia(); 
                     $this->modal(" No se ha podido eliminar el registro") ;
                }  
       
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function eliminarRegistro(){
        try {       
             
            if (isset($_REQUEST["ci"])){
             
                if(isset($_REQUEST['curso'])){
                                                      
                    $ci_usuario = $_REQUEST["ci"];
                    $curso = $_REQUEST["curso"];

                    $asociacion = $this->eliminarRegistroAsociacionManejador($curso,$ci_usuario);
               
                    $resultado = $this->eliminarRegistroManejador($ci_usuario);
                                         
                    $this->alumnosBedelia(); 
                    $this->modal(" Registro eliminado correctamente") ;
                                                            
                }
                        
                }                     
                else{
                     //$this->alumnosBedelia();
                     $this->modal(" No se ha podido eliminar el registro") ;
                }  
       
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function modificarAlumno(){
        try {
            session_start();

            if (isset($_REQUEST["ci"])){
                
                if(isset($_REQUEST['curso'])){
                                                      
                    $ci_usuario = $_REQUEST["ci"];
                    $curso = $_REQUEST["curso"];
                    
            $resultado = $this->recuperarDatos($ci_usuario); 
            
            $contenido = "<div class='container'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Modificar Datos Alumno</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificoRegistroAlumno'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputCi' readonly='readonly'  value = ". $ci_usuario ." name='inputCI'  required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' value = ". $resultado[0]['nombre'] ."  name='inputNombre'  required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputApellido' value = ". $resultado[0]['apellido']  ."  name='inputApellido' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label class='col-lg-2 control-label'>Sexo</label>"
            . "<div class='col-lg-10'>"
            . "<div class='radio'>"
            . "<label>";
                 if($resultado[0]['sexo'] == 'M'){
                    $contenido = $contenido ."<input type='radio' name='sexo'  id='sexo' value='M' checked=''>"
                    . "Masculino"
                    . "</label>"
                    . "<label>"
                    . "<input type='radio' name='sexo' id='sexo' value='F'>"
                    . "Femenino"
                    . "</label>";
               }
                else {
                        $contenido = $contenido . "<input type='radio' name='sexo'  id='sexo' value='M' >"
            . "Masculino"
            . "</label>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='F' checked=''>"
            . "Femenino"
            . "</label>";
                                               
               }   
            $contenido = $contenido ."</div>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            . "<div class='col-lg-8'>"
            . "<input type='email' class='form-control' id='inputMail' value = ". $resultado[0]['email']  ."  name='inputMail' >"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputTelefono' value = ". $resultado[0]['telefono']  ." name='inputTelefono' >"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Celular</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputCelular' value = ".$resultado[0]['celular']  ." name='inputCelular'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Modificar Datos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarCursosActivos();

            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['nombre']. '">' . $fila['nombre'] . '</OPTION>';
            }

            echo"</select>"
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<div class='col-lg-10 col-lg-offset-2'>"
            . "<button type='reset' class='btn btn-default btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg'>Aceptar</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</div>"
            . "</div>"
            . "</fieldset>"
            . "</form>";

            echo "</table>";
         }
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }

    
    public function modificarRegistroProfesor(){
        try {
            session_start();

            if (isset($_REQUEST["ci"])){
                
                if(isset($_REQUEST['curso'])){
                                                      
                    $ci_usuario = $_REQUEST["ci"];
                    $curso = $_REQUEST["curso"];
                    
            $resultado = $this->recuperarDatos($ci_usuario); 
            
            $contenido = "<div class='container'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Modificar Datos Profesor</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificoRegistroProfesor'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputCi' readonly='readonly'  value = ". $ci_usuario ." name='inputCI'  required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' value = ". $resultado[0]['nombre'] ."  name='inputNombre'  required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputApellido' value = ". $resultado[0]['apellido']  ."  name='inputApellido' required>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label class='col-lg-2 control-label'>Sexo</label>"
            . "<div class='col-lg-10'>"
            . "<div class='radio'>"
            . "<label>";
                 if($resultado[0]['sexo'] == 'M'){
                    $contenido = $contenido . "<input type='radio' name='sexo'  id='sexo' value='M' checked=''>"
                    . "Masculino"
                    . "</label>"
                    . "<label>"
                    . "<input type='radio' name='sexo' id='sexo' value='F'>"
                    . "Femenino"
                    . "</label>";
               }
                else {
                        $contenido = $contenido . "<input type='radio' name='sexo'  id='sexo' value='M' >"
            . "Masculino"
            . "</label>"
            . "<label>"
            . "<input type='radio' name='sexo' id='sexo' value='F' checked=''>"
            . "Femenino"
            . "</label>";
                                               
               }   
            $contenido = $contenido ."</div>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            . "<div class='col-lg-8'>"
            . "<input type='email' class='form-control' id='inputMail' value = ". $resultado[0]['email']  ."  name='inputMail' >"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputTelefono' value = ". $resultado[0]['telefono']  ." name='inputTelefono' >"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Celular</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' class='form-control' id='inputCelular' value = ".$resultado[0]['celular']  ." name='inputCelular'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='asignarCurso'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Modificar Datos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarCursosActivos();

            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['nombre']. '">' . $fila['nombre'] . '</OPTION>';
            }

            echo"</select>"
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<div class='col-lg-10 col-lg-offset-2'>"
            . "<button type='reset' class='btn btn-default btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg'>Aceptar</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</div>"
            . "</div>"
            . "</fieldset>"
            . "</form>";

            echo "</table>";
         }
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }
       
    public function modificoRegistroAlumno(){
        try {
            if (isset($_REQUEST['aceptar'])){

                $ciUsuario = $_REQUEST["inputCI"];
                $nombreUsuario = $_REQUEST["inputNombre"];
                $apellidoUsuario = $_REQUEST["inputApellido"];
                $sexoUsuario = $_REQUEST["sexo"];
                $emailUsuario = $_REQUEST["inputMail"];                
                $telefonoUsuario = $_REQUEST['inputTelefono'];
                $celularUsuario = $_REQUEST["inputCelular"];
                $curso = $_REQUEST["asignarCurso"];

            
                $modficacionUsuario = $this->modificoRegistroManejador($nombreUsuario, 
                                                                $apellidoUsuario, 
                                                                $sexoUsuario,
                                                                $emailUsuario,                                                               
                                                                $telefonoUsuario,
                                                                $celularUsuario,
                                                                $ciUsuario);
                
                 $modficacionCurso = $this->modificoAsociacionCurso($curso, $ciUsuario);                                  
                
                if($modficacionUsuario == NULL){
                         $this->alumnosBedelia();
                         $this->modal("Registro actualizado correctamente");
                         
                }else{
                          $this->alumnosBedelia();
                          $this->modal("No se ha podido actualizar el registro");
                          
                }
               
            }else{
                          $this->alumnosBedelia();
                          $this->modal("En este momento no se puede actualizar"
                                       . "  el registro");
                          
                }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function modificoRegistroProfesor(){
        try {
            if (isset($_REQUEST['aceptar'])){

                $ciUsuario = $_REQUEST["inputCI"];
                $nombreUsuario = $_REQUEST["inputNombre"];
                $apellidoUsuario = $_REQUEST["inputApellido"];
                $sexoUsuario = $_REQUEST["sexo"];
                $emailUsuario = $_REQUEST["inputMail"];                
                $telefonoUsuario = $_REQUEST['inputTelefono'];
                $celularUsuario = $_REQUEST["inputCelular"];
                $curso = $_REQUEST["asignarCurso"];

            
                $modficacionUsuario = $this->modificoRegistroManejador($nombreUsuario, 
                                                                $apellidoUsuario, 
                                                                $sexoUsuario,
                                                                $emailUsuario,                                                               
                                                                $telefonoUsuario,
                                                                $celularUsuario,
                                                                $ciUsuario);
                
                $modficacionCurso = $this->modificoAsociacionCurso($curso, $ciUsuario);
                
                                                  
                
                if($modficacionUsuario == null){
                         $this->profesoresBedelia();
                         $this->modal("Registro actualizado correctamente");
                         
                }else{
                          $this->profesoresBedelia();
                          $this->modal("No se ha podido actualizar el registro");
                          
                }
               
            }else{
                          $this->profesoresBedelia();
                          $this->modal("En este momento no se puede actualizar"
                                       . "  el registro");
                          
                }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
   
    public function modificarRegistroCurso(){
        try {
            session_start();
                       
            if (isset($_REQUEST["curso"])){

                    $curso = $_REQUEST["curso"];
                    $anio = $_REQUEST["anio"];
                    $horario = $_REQUEST["horario"];
                    $profesor = $_REQUEST["profesor"];
            
            $resultado = $this->listarCursosPorNombreHorarioProfesorAnio($curso,
                                                                         $horario,                                                                                           
                                                                         $anio);  
            $id = $resultado[0]['id_curso'];
            $horarioCurso = str_replace("-",":",$resultado[0]['horario']);
            
            $contenido = "<div class='container'>"
            . "<div class = 'page-header' id='tables'>"        
            . "<h1 style='color:#d3d3d3;' align='center'>Modificar Datos Curso</h1>"
            . "</div>"
            . "<form class='form-horizontal' method='post' "
            . "action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=modificoRegistroCurso&id=$id'>"
            . "<fieldset>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            . "<div class='col-lg-8'>"
            . "<input type='text' class='form-control' id='inputNombre' readonly='readonly'  value = ".$resultado[0]['nombre']." name='inputNombre' placeholder='Nombre'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Año</label>"
            . "<div class='col-lg-8'>"
            . "<input type='number' min='2017' max = '2030' class='form-control'value = ".$resultado[0]['anio']." id='inputAnio' name='inputAnio'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Horario</label>"
            . "<div class='col-lg-8'>"
            . "<input type='time' class='form-control' id='inputHorario' value = ".$horarioCurso." name='inputHorario'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Fecha de Inicio</label>"
            . "<div class='col-lg-8'>"
            . "<input type='date' min='2017-01-01' class='form-control' value = ".$resultado[0]['fecha_inicio']." id='inputFechaIni' name='inputFechaIni'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='text' class='col-lg-2 control-label'>Fecha de Fin</label>"
            . "<div class='col-lg-8'>"
            . "<input type='date' class='form-control' id='inputFechaFin' value = ".$resultado[0]['fecha_fin']." name='inputFechaFin'>"
            . "</div>"
            . "</div>"
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Estado</label>"                   
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select' name='estado'>"      
            . "<OPTION VALUE='1'> Activo </OPTION>" 
            . "<OPTION VALUE='0'> Inactivo </OPTION>" 
            . "</select>"
            . "</div>" 
            . "</div>"     
            . "<div class='form-group'>"
            . "<label for='select' class='col-lg-2 control-label'>Asignar Profesor</label>"
            . "<div class='col-lg-8'>"
            . "<select class='form-control' id='select2' name='asignarProfesor'>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Agregar Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);
            
            $resultado = $this->listarProfesores();
            
            foreach ($resultado as $fila ) {
                echo'<OPTION VALUE="' . $fila['profesor']. '">' . $fila['profesor'] . '</OPTION>';
                                 
            }
            echo"</select>"            
            . "<br>"
            . "</div>"
            . "</div>"
            . "<div>"
            . "<div class='col-lg-30 col-lg-offset-3'>"
            . "<button type='reset' class='btn btn-default btn-lg' name='btnCancel'>Cancelar</button>&nbsp"
            . "<button type='submit' name = 'aceptar' class='btn btn-primary btn-lg' >Aceptar</button>&nbsp"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=redireccionar'>" 
            . "<button type='button' name = 'volver' class='btn btn-default btn-lg'>Volver</button></a>"
            . "</form>"             
            . "</div>"
            . "</div>"
            . "</fieldset>"
            . "</table>";
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function modificoRegistroCurso(){
        try {
            if (isset($_REQUEST['aceptar'])){
                $idCurso = $_REQUEST["id"];
                $nombreCurso = $_REQUEST["inputNombre"];
                $anioCurso = $_REQUEST["inputAnio"];
                $horarioCurso = $_REQUEST["inputHorario"];                
                $fechaInicio = $_REQUEST['inputFechaIni'];
                $fechaFin = $_REQUEST["inputFechaFin"];
                $estado = $_REQUEST["estado"];
                $profesor = $_REQUEST["asignarProfesor"];
            
                $asociacion = $this->listarProfesoresPorNombre($profesor);               
                $ciUsuario =  $asociacion[0][2];
                $modficacionCursoProfesor = $this->modificoAsociacionCursoProfesor($nombreCurso, $ciUsuario);
                
                $horarioCurso = str_replace(":","-",$horarioCurso);
                
                $modficacionCurso = $this->modificoCurso($idCurso,
                                                         $nombreCurso, 
                                                         $anioCurso, 
                                                         $horarioCurso,
                                                         $fechaInicio,                                                               
                                                         $fechaFin,
                                                         $estado);
                                                                                                 
                if($modficacionCurso == null){
                         $this->cursosBedelia();
                         $this->modal("Registro actualizado correctamente");
                         
                }else{
                          $this->cursosBedelia();
                          $this->modal("No se ha podido actualizar el registro");
                          
                }               
            }
            else{
                          $this->cursosBedelia();
                          $this->modal("En este momento no se puede actualizar"
                                       . "  el registro");
                          
                }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function verReporte(){
        
        $ci = $_REQUEST["ci"];
        $curso = $_REQUEST["curso"];
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image('vistas/img/Logo.png', 8, 8, 16, 15, 'PNG');
        $pdf->Cell(0, 35, 'e-MER', 0);
        $pdf->Cell(18, 10, '', 0);
        $pdf->Cell(150, 10, '   ', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(70, 8, '', 0);
        $pdf->Cell(100, 8, 'EJERCICIOS POR ALUMNO', 0);
        $pdf->Ln(23);
        $pdf->Line(0, 47, 260-50, 47); 
        $pdf->SetFont('Arial','B', 9);
        $pdf->Cell(38, 8, 'ALUMNO', 0);
        $pdf->Cell(58, 8, 'TEMA', 0);
        $pdf->Cell(45, 8, 'FECHA', 0);
        $pdf->Cell(0, 8, 'DEDICACION EN MINUTOS', 0);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Line(0, 56, 260-50, 56);

        $resultado = $this->verReporteManejador($ci, $curso);
        
        if ($resultado !== null) {
            foreach ($resultado as $datos) {
                $pdf->Cell(38, 8, $datos['alumno'], 0);
                $pdf->Cell(58, 8, $datos['tema'], 0);
                $pdf->Cell(67, 8, $datos['fecha'], 0);
                $pdf->Cell(30, 8, $datos['dedicacion_en_minutos'], 0);
                $pdf->Ln(8);
            }
        }
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(114, 8, '', 0);
        //$pdf->Cell(100, -190, 'Fecha: ' . date('d-m-Y') . '', 0);
        $pdf->Output();
        
    }

}

?>
