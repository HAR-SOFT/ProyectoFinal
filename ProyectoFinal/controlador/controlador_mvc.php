<?php

require_once "modelo/manejador.php";

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
                            $pagina = $this->replace_content("/Titulo/", "Menú de Administrativo", $pagina);
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
                        $pagina = $this->replace_content("/Titulo/", "Menú de Administrativo", $pagina);
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

                    if ($claveActual <> $_SESSION["claveUsuario"]) {
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

            $contenido = $contenido. utf8_encode($letra[0][0]) ;

            $contenido = $contenido. "</p>"
            . "</div>";

            $ejercicio = $this->ejerciciosTemaManejador($tema,$subtema,$_SESSION["cursoUsuario"]);

            if($ejercicio){
               foreach ($ejercicio as $ej){
                       $contenido = $contenido. "<div class='col-lg-3'>"
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

    public function editarCurso() {
        try{ 
            session_start();
            if (isset($_REQUEST["curso"])) {
                $curso = $_REQUEST["curso"];
                
                $ciUsuario = $_SESSION["ciUsuario"];
                
            $contenido = "<div class='col-lg-2' style='margin-left:10px;'>";
            
            $temas = $this->listarTemasPorCursoSeleccionado($ciUsuario, $curso);            
            //itera sobre los temas que tiene el curso seleccionado
            foreach($temas as $item) {   
               $contenido = $contenido."<div class=container' style='padding-top: 1em;'>"                    
               . "<button type='button' class='btn btn-primary btn-lg' ; text-align:left;'>".$item['nombre_tema']."<input type='checkbox' class='btn-primary' checked /></button>"
                       ." </div>";           
            }
            
            $temasSeleccionar = $this->listarTemasSinCursoProfesor();
            //itera sobre los temas que no tiene el curso seleccionado
            foreach($temasSeleccionar as $item2) {   
               $contenido = $contenido."<div class=container' style='padding-top: 1em;'>"
               . "<button type='button' class='btn btn-primary btn-lg'; text-align:left;'>".$item2['nombre_tema']."<input type='checkbox' /></button>"
                     
               ." </div>";           
            }
                        
            $contenido = $contenido." </div>"
            . " <div class='col-lg-2'>"
            . "<div class='container'>"
            . "<div class='item'>"
            . "<div class='jumbotron'>"
            . "<h1>Introduccion</h1>"
            ."<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                in voluptate velit esse cillum dolore eu fugiat nulla pariatur. t anim id est laborum.</p>"
            . "</div>"       
            . "</div>"   
            . "<h4>Seleccione los ejercicios</h4>"                    
            . "<div class=''>"
            . "<button type='button' style='position: relative;' class='btn-primary btn' data-color='success'>Perro Cucha <input type='checkbox' class='btn-primary' checked /></button>"
            . "<button type='submit' style='position: relative; align: right; margin-left: 800px;' class='btn btn-primary btn-lg' name='aceptar'>Aceptar</button>"
            . "</div>"
            . "</div>"
            . "</div>";
            
            
            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Editar Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);
            }
                     
            } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
         }
             
    }
             public function alumnosBedelia() {
        try {
            session_start();

            $contenido = "<div>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Alumnos</h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Nombre</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Curso</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por curso'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<button type='submit' class='btn btn-primary'>Filtrar</button>"
            . "</div>"
            . "</th>"
            . "</thead>";

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
                 . "<td></td>"
                 . "</tr>"
                 . "</tbody>";
            }

             echo "</table>";

             echo "<br>"
            ."<p align='left'>"
            ."<form action='../importarAlumnos.php' method='post' enctype='multipart/form-data'>"
            ."<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
            ."<input type='button'  value='Importar grupo alumnos' onclick='document.getElementById('selectedFile').click();' class='btn btn-primary btn-lg' />"
            ."<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
            ."<button type='submit' name = 'submit' class='btn btn-default btn-lg'>Volver</button>"
            ."</form>"
            ."<br>"
            ."</p>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarAlumno'><button type='submit' name = 'agregarAlumno' class='btn btn-primary btn-lg'>Agregar alumno</button></a>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoAlumno'><button type='submit' name = 'alumnosSinCurso' class='btn btn-primary btn-lg'>Alumnos sin Curso</button></a>";
         } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
         }

    }

    public function profesoresBedelia() {
         try {
             session_start();

             $contenido = "<div>"
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
             . "<input type='text' class='form-control' placeholder='Filtrar por nombre'>"
             . "</div>"
             . "</th>"
             . "<th><div class='form'>"
             . "<label class='control-label'>Cedula</label>"
             . "<div class='input'>"
             . "<input type='text' class='form-control' placeholder='Filtrar por cedula'>"
             . "</div>"
             . "</th>"
             . "<th><div class='form'>"
             . "<label class='control-label'>Curso</label>"
             . "<div class='input'>"
             . "<input type='text' class='form-control' placeholder='Filtrar por curso'>"
             . "</div>"
             . "</th>"
             . "<th>"
             . "<div class='form'>"
             . "<button type='submit' class='btn btn-primary'>Filtrar</button>"
             . "</div>"
             . "</th>"
             . "</thead>";

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
                    . "<td></td>"
                    . "</tr>"
                    . "</tbody>";
                }

            echo "</table>";

            echo "<br>"
            ."<p align='left'>"
            ."<form action='../importarAlumnos.php' method='post' enctype='multipart/form-data'>"
            ."<input type='file'name='archivos-excel' id='selectedFile' style='display:none;' class='btn btn-primary btn-lg'/>"
            ."<input type='button'  value='Importar grupo Profesores' onclick='document.getElementById('selectedFile').click();' class='btn btn-primary btn-lg' />"
            ."<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>Aceptar</button>"
            ."<button type='submit' name = 'submit' class='btn btn-default btn-lg'><a onclick='javascript:window.history.back();'>&laquo; Volver atrás</a></button>"
            ."</form>"
            ."<br>"
            ."</p>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarProfesor'><button type='submit' name = 'agregarProfesor' class='btn btn-primary btn-lg'>Agregar Profesor</a></button>"
            . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignarCursoProfesor'><button type='submit' name = 'asignarCursoProfesor' class='btn btn-primary btn-lg'>Profesores sin Curso</a></button>";

            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }


    public function cursosBedelia() {
        try {
             session_start();

            $contenido = "<div>"
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
            . "<input type='text' class='form-control' placeholder='Filtrar por curso'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Año</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por año'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Horario</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por horario'>"
            . "</div>"
            . "</th>". "<th><div class='form'>"
            . "<label class='control-label'>Profesor</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por profesor'>"
            . "</div>"
            . "</th>"
            . "<th>"
            . "<div class='form'>"
            . "<button type='submit' class='btn btn-primary'>Filtrar</button>"
            . "</div>"
            . "</th>"
            . "</thead>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Cursos", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            $resultado = $this->listarCursosBedelia();

            foreach ($resultado as $fila) {
                echo "<tbody>"
                . "<tr class='active'>"
                . "<td>" . $fila['curso'] . "</td>"
                . "<td>" . $fila['anio'] . "</td>"
                . "<td>" . $fila['horario'] . "</td>"
                . "<td>" . $fila['profesor'] . "</td>"
                . "<td></td>"
                . "</tr>"
                . "</tbody>";
            }
            echo "</table>";

             echo "<br>"
             . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarCurso'><button type='submit' name = 'agregarProfesor' class='btn btn-primary btn-lg'>Agregar Curso</a></button>";

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

    }


    public function agregarAlumno(){
        try {
            session_start();

            $contenido = "<div class='page-header' id='tables'>"
            ."<h1 style='color:#d3d3d3;' align='center'>Agregar Alumno</h1>"
            ."</div>"
            ."<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoAlumno'>"
            ."<fieldset>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputNombre' name='inputCI' placeholder='12345678' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputApellido' name='inputApellido' placeholder='Apellido' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label class='col-lg-2 control-label'>Sexo</label>"
            ."<div class='col-lg-10'>"
            ."<div class='radio'>"
            ."<label>"
            ."<input type='radio' name='sexo' id='sexo' value='M' checked=''>"
            ."Masculino"
            ."</label>"
            ."<label>"
            ."<input type='radio' name='sexo' id='sexo' value='F'>"
            ."Femenino"
            ."</label>"
            ."</div>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputMail' name='inputMail' placeholder='ejemplo@ejemplo.com'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            ."<div class='col-lg-8'>"
            ."<input type='number' class='form-control' id='inputTelefono' name='inputTelefono' placeholder='12345678'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Celular</label>"
            ."<div class='col-lg-8'>"
            ."<input type='number' class='form-control' id='inputCelular' name='inputCelular' placeholder='091234567'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            ."<div class='col-lg-8'>"
            ."<select class='form-control' id='select' name='asignarCurso'>";

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
            ."<br>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<div class='col-lg-10 col-lg-offset-2'>"
            ."<button type='reset' class='btn btn-default' name='btnCancel'>Cancelar</button>"
            ."<button type='submit' name = 'aceptar' class='btn btn-primary'>Aceptar</button>"
            ."</div>"
            ."</div>"
            ."</fieldset>"
            ."</form>";

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
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function agregarProfesor(){
         try {
            session_start();

            $contenido = "<div class='page-header' id='tables'>"
            ."<h1 style='color:#d3d3d3;' align='center'>Agregar Profesor</h1>"
            ."</div>"
            ."<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoProfesor'>"
            ."<fieldset>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Cedula</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputNombre' name='inputCI' placeholder='12345678' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Apellido</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputApellido' name='inputApellido' placeholder='Apellido' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label class='col-lg-2 control-label'>Sexo</label>"
            ."<div class='col-lg-10'>"
            ."<div class='radio'>"
            ."<label>"
            ."<input type='radio' name='sexo' id='sexo' value='M' checked=''>"
            ."Masculino"
            ."</label>"
            ."<label>"
            ."<input type='radio' name='sexo' id='sexo' value='F'>"
            ."Femenino"
            ."</label>"
            ."</div>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='email' class='col-lg-2 control-label'>e-mail</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputMail' name='inputMail' placeholder='ejemplo@ejemplo.com'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Telefono</label>"
            ."<div class='col-lg-8'>"
            ."<input type='number' class='form-control' id='inputTelefono' name='inputTelefono' placeholder='12345678'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Celular</label>"
            ."<div class='col-lg-8'>"
            ."<input type='number' class='form-control' id='inputCelular' name='inputCelular' placeholder='091234567'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='select' class='col-lg-2 control-label'>Asignar curso</label>"
            ."<div class='col-lg-8'>"
            ."<select class='form-control' id='select' name='asignarCurso'>";

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
            ."<br>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<div class='col-lg-10 col-lg-offset-2'>"
            ."<button type='reset' class='btn btn-default' name='btnCancel'>Cancelar</button>"
            ."<button type='submit' name = 'aceptar' class='btn btn-primary'>Aceptar</button>"
            ."</div>"
            ."</div>"
            ."</fieldset>"
            ."</form>";

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

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function agregarCurso(){
        try {
            session_start();

            $contenido = "<div class='page-header' id='tables'>"
            ."<h1 style='color:#d3d3d3;' align='center'>Agregar Curso</h1>"
            ."</div>"
            ."<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregoCurso'>"
            ."<fieldset>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Nombre</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputNombre' name='inputNombre' placeholder='Nombre' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Año</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputAnio' name='inputAnio' placeholder='2017' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Horario</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputHorario' name='inputHorario' placeholder='20-22' required>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Fecha de Inicio</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputFechaIni' name='inputFechaIni' placeholder='aaaa-mm-dd'>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<label for='text' class='col-lg-2 control-label'>Fecha de Fin</label>"
            ."<div class='col-lg-8'>"
            ."<input type='text' class='form-control' id='inputFechaFin' name='inputFechaFin' placeholder='aaaa-mm-dd' required>"
            ."</div>"
            ."</div>";

            $pagina = $this->load_template("inicio");
            $head = $this->load_page("vistas/html/headPrincipal.html");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "Agregar Curso", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

            echo""
            ."<br>"
            ."</div>"
            ."</div>"
            ."<div class='form-group'>"
            ."<div class='col-lg-10 col-lg-offset-2'>"
            ."<button type='reset' class='btn btn-default' name='btnCancel'>Cancelar</button>"
            ."<button type='submit' name = 'aceptar' class='btn btn-primary' type=reset' >Aceptar</button>"
            ."</div>"
            ."</div>"
            ."</fieldset>"
            ."</form>"
            ."</table>";

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function agregoCurso(){
        try {
            if (isset($_REQUEST['aceptar'])){
                $nombreCurso = $_REQUEST["inputNombre"];
                $anioCurso = $_REQUEST["inputAnio"];
                $horarioCurso = $_REQUEST["inputHorario"];
                $inicioCurso = $_REQUEST["inputFechaIni"];
                $finCurso = $_REQUEST["inputFechaFin"];

                $resultado = $this->altaCursoManejador($nombreCurso,
                                                       $anioCurso,
                                                       $horarioCurso,
                                                       $inicioCurso,
                                                       $finCurso);

                if($resultado){
                   $this->modal("Se agrego el Curso $nombreCurso");
                   $this->agregarCurso();
                } else {
                    $this->modal("No se ha podido agregar el Curso.");
                    $this->agregarCurso();
                }
            }

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignarCursoAlumnos(){
        try {
            session_start();

            $contenido = "<div>"
            ."<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoAlumnos'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Alumnos sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Nombre</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
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
            ."<button type='submit' name = 'asignarCursoAlumno' class='btn btn-primary btn-lg'>Asignar Curso</button>"
            ."<button type='submit' name = 'submit' class='btn btn-default btn-lg'>Volver</button>"
            ."<br>"
            ."</p>"
            . "<br>"
            ."</form>"
            ."</div>";
            }

        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignarCursoProfesores(){
         try {
            session_start();

            $contenido = "<div>"
            ."<form class='form-horizontal' method='post' action='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=asignoCursoProfesores'>"
            . "<div class='page-header' id='tables'>"
            . "<h1 style='color:#d3d3d3;' align='center'>Profesores sin Curso </h1>"
            . "</div>"
            . "<div>"
            . "<table id='tabla_resultado' class='table table-striped table-hover'>"
            . "<thead>"
            . "<tr class='danger'>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Nombre</label>"
            . "<div class='input'>"
            . "<input type=text' class='form-control' name='busqueda' id='busqueda' placeholder='Filtrar por nombre'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
            . "<label class='control-label'>Cedula</label>"
            . "<div class='input'>"
            . "<input type='text' class='form-control' placeholder='Filtrar por cedula'>"
            . "</div>"
            . "</th>"
            . "<th><div class='form'>"
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
            $pagina = $this->replace_content("/Titulo/", "Profesores Sin Curso", $pagina);
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

            $resultado = $this->listarProfesoresSinCurso();


            if (!$resultado){
                $this->modal("No existen Profesores sin Curso asginado");
                echo"<button type='submit' name = 'submit' class='btn btn-default btn-lg'>"
                . "<a onclick='javascript:window.history.back();'>&laquo; Volver atrás</a></button>";
            } else{
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
                }

                echo "</table>"
                . "<br>"
                ."<p align='left'>"
                ."<button type='submit' name = 'asignarCursoProfesor' class='btn btn-primary btn-lg'>Asignar Curso</button>"
                ."<button type='submit' name = 'submit' class='btn btn-default btn-lg'><a onclick='javascript:window.history.back();'>&laquo; Volver atrás</a></button>"
                ."<br>"
                ."</p>"
                ."<br>"
                ."</form>"
                ."</div>";

               }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignoCursoAlumnos(){
        try {
            if (isset($_REQUEST['asignarCursoAlumno'])){

            $check[] = '';
            $curso = $_REQUEST['asignarCurso'];
            $check[] = $_REQUEST['curso']? $_REQUEST['curso']: NULL;

            foreach ($check as $check1 => $check2){
                $longitud = count($check2);

                for($i=0 ;$i<$longitud ;$i++ ){
                    $valores = "'" .$curso."' ," .$check2[$i];
                    $this->asignarCursoUsuarios($valores);
                }
            }
            $this->asignarCursoAlumnos();

            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function asignoCursoProfesores(){
        try {
            if (isset($_REQUEST['asignarCursoProfesor'])){

            $curso = $_REQUEST['asignarCurso'];
            $check[] = $_REQUEST['curso']? $_REQUEST['curso']: NULL;

                foreach ($check as $check1 => $check2){
                    $longitud = count($check2);

                    for($i=0 ;$i<$longitud ;$i++ ){
                        $valores = "'" .$curso."' ," .$check2[$i];
                        $this->asignarCursoUsuarios($valores);
                    }
                }

                $this->asignarCursoProfesores();
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
            }

            $letraEjercicio =  $this->letraEjercicioTemaManejador($ejercicio);
            //var_dump($letraEjercicio[0][0]);
            $verLetra = $letraEjercicio[0][0];

            $contenido = "<div class='col-lg-2'>"
            . "<br><p></p><ul class='nav nav-pills nav-stacked'>"
            . "<li class='btn btn-default btn-lg '>$ejercicio</li>"
            . "<li>"
            . "<button type='button' class='btn btn-primary btn-group-justified' data-container='body' data-toggle='popover' data-placement='bottom'"
            . "data-content= '$verLetra'"
            . "data-original-title='' title=''>Letra ejercicio</button>"
            . "</li>"
            . "</ul>"
            . "</div>";

            $contenido = $contenido . $this->load_page("vistas/html/ejercicios/" . $ejercicio . ".html");

            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $head = $this->load_page("vistas/html/headEjercicio.html");
            $pagina = $this->replace_content("/HeadHTML/", $head, $pagina);
            $pagina = $this->replace_content("/Header/", $header, $pagina);
            $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
            $pagina = $this->replace_content("/Titulo/", "A Practicar", $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

            $this->view_page($pagina);

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
            
//            // guarda la solucion SOLO HAY QUE EJECUTARLA UNA VEZ
            //$this->guardarSolucionMer($nombreMer, '40269737', $nombreEjercicio);
                       
            $inputsString = explode(",", $_SESSION["inputs"]);
            $inputsArray = [];
            $tiposInputs = ["entidadComun", "entidadSuperTipo", "entidadSubTipo", "relacionComun", "restricciones"];
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
                    
                    if ($objeto === "restricciones" ) {
                        $arrayMer = array($nombreMer, "sol_alumno", $ci, $nombreEjercicio, $valor);
                    }
                    
                    if (strpos($objeto, "entidad") !== false && $atributoInput === "nombre") {
                        if (strpos($objeto, "Comun")) {
                            $arrayEntidades[$objeto] = array($valor, "comun",
                                    "null", "null", $nombreMer, $ci);
                        }
                    }
                    
                    if (strpos($atributoInput, "atributo") !== false) {
                        if (strpos($atributoInput, "Comun")) {
                            $arrayAtributos[$objeto."_".$i] = 
                                    array($valor, "comun", $arrayEntidades[$objeto][0],
                                        $nombreMer, $ci);
                        }
                    }
                    
                    if (strpos($objeto, "relacion") !== false && $atributoInput === "nombre") {
                        if (strpos($objeto, "Comun")) {
                            $arrayRelaciones[$objeto] = 
                                    array($valor, "comun", $entidadesRelacion[0],
                                        $entidadesRelacion[1], "null", 
                                        $nombreMer, $ci);
                        }
                    }

//                    var_dump($objeto);
//                    var_dump($atributoInput);

                    // armamos el array con clave-valor.
                    //array_push($inputsArray, array($objeto, array($atributoInput => $valor)));
                }
            }
            
            // insert de sol_mer
            //$insertMer = array($nombreMer, "sol_alumno", $ci, $nombreEjercicio,
            //     $restricciones);
            
//            $this->validarDatosMerManejador($nombreMer, $ci, $nombreEjercicio, 
//                    $inputsArray);
            
            //var_dump($inputsString);
            //var_dump($arrayMer);
            //var_dump($arrayEntidades);
            //var_dump($arrayAtributos);
            //var_dump($arrayRelaciones);
            
            $nombre_mer = $arrayMer[0];
            $ci_usuario = $arrayMer[2];
            $nombre_ejercicio = $arrayMer[3];
            
            $this->guardarSolucionMer($nombre_mer, $ci_usuario, $nombre_ejercicio);
            // entidad 1
            $nombre_entidad = $arrayEntidades['entidadComun1'][0];
            $tipo_entidad = $arrayEntidades['entidadComun1'][1];
            $entidad_supertipo = $arrayEntidades['entidadComun1'][2];
            $tipo_categorizacion = 'N/A';
            
            $this->guardarSolucionMerEntidad($nombre_entidad, $tipo_entidad, $entidad_supertipo, $tipo_categorizacion, $nombre_mer, $ci_usuario);
            //entidad 2
            $nombre_entidad2 = $arrayEntidades['entidadComun2'][0];
            $tipo_entidad = $arrayEntidades['entidadComun2'][1];
            $entidad_supertipo = $arrayEntidades['entidadComun2'][2];
            $tipo_categorizacion = 'N/A';
            
            $this->guardarSolucionMerEntidad($nombre_entidad2, $tipo_entidad, $entidad_supertipo, $tipo_categorizacion, $nombre_mer, $ci_usuario);
            
            $nombre_atributo = $arrayAtributos['entidadComun1_2'][0];
            $tipo_atributo = $arrayAtributos['entidadComun1_2'][1];            
            // atributo 1 entidad 1
            $this->guardarSolucionMerAtributo($nombre_atributo, $tipo_atributo, $nombre_entidad, $nombre_mer, $ci_usuario);
            //atributo 1 entidad2        
            $nombre_atributo = $arrayAtributos['entidadComun2_5'][0];
            $tipo_atributo = $arrayAtributos['entidadComun2_5'][1];
         
            $this->guardarSolucionMerAtributo($nombre_atributo, $tipo_atributo, $nombre_entidad2, $nombre_mer, $ci_usuario);
            //atributo 2 entidad2                        
            $nombre_atributo = $arrayAtributos['entidadComun2_6'][0];
            $tipo_atributo = $arrayAtributos['entidadComun2_6'][1];
            
            $this->guardarSolucionMerAtributo($nombre_atributo, $tipo_atributo, $nombre_entidad2, $nombre_mer, $ci_usuario);
            
            //Relacion 1
            $nombre_relacion = $arrayRelaciones['relacionComun1'][0];
            $nombre_entidadA = $nombre_entidad;
            $nombre_entidadB = $nombre_entidad2;
            $agregacion = $arrayRelaciones['relacionComun1'][4];        
            
            $this->guardarSolucionMerRelacion($nombre_relacion, $nombre_entidadA, $nombre_entidadB, $agregacion, $nombre_mer, $ci_usuario);
            
            echo 'se guardo correctamente el ejercicio';
//            var_dump($objetosRecorridos);
            
//            // entidad 1
//            $entidad1 = $inputsArray[1];
//            $atributo1_entidad1 = $inputsArray[5];
//           
//            // VER DE DONDE SACAR LOS DATOS DE $tipoEntidad , $entidadSupertipo,
//            // $atributoMultivaluado ,$agregacion , $tipoCategorizacion
//            
//            // // guardar entidades y atributos SE DEBE EJECUTAR TANTAS VECES COMO
//            //  ATRIBUTOS TENGA LA ENTIDAD
//            $this->guardarSolucionMerEntidad($entidad1, $tipoEntidad ,
//                                             $entidadSupertipo ,
//                                             $atributo1_entidad1 ,
//                                             $atributoMultivaluado ,$agregacion ,
//                                             $tipoCategorizacion ,  
//                                             $nombreEjercicio, $ci);
//            
//            // entidad 2
//            $entidad2 = $inputsArray[7];
//            $atributo1_entidad2 = $inputsArray[11];
//            $atributo2_entidad2 = $inputsArray[13];
//            
//            // relacion
//            $relacion1 = $inputsArray[15];
//            
//            // guardar relaciones SE DEBE EJECUTAR UNA VEZ POR RELACION
//            $this->guardarSolucionMerRelacion($relacion1, $entidad1, $entidad2,
//                                              $nombreEjercicio, $ci);
//            
//            $reestricciones = $inputsArray[17];// NO HAY CAMPO EN LA BD PARA ESTE DATO
            
        }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
//     public function validarEjercicio() {
//        try {
//            session_start();
//            
//            $nombreMer = $_SESSION["ejercicio"];
//            $ci = $_SESSION["ciUsuario"];
//            $nombreEjercicio = $_SESSION["ejercicio"];
//            
////            // guarda la solucion SOLO HAY QUE EJECUTARLA UNA VEZ
////            $this->guardarSolucionMer($nombreMer, $ci, $nombreEjercicio);
//                       
//            $inputsString = explode(",", $_SESSION["inputs"]);
//            $inputsArray = [];
//            
//            // armamos array principal con todos los inputs.
//            for ($i = 0; $i < sizeof($inputsString); $i++) {
//                // primero excluimos el atributo cardinalidad.
//                if (strpos($inputsString[$i], "cardinalidad") === false) {
//                    // nos fijamos si el nombre del input tiene el caracter separador.
//                    // si no lo tiene, entonces es el input de restricciones.
//                    if (strpos(explode(":", $inputsString[$i])[0], "_" ) !== false) {
//                        $tipoInput = explode("_", explode(":", $inputsString[$i])[0])[1];
//                    } else {
//                        $tipoInput = explode(":", $inputsString[$i])[0];
//                    }
//                    // nos fijamos que atributo es el del input.
//                    // si no lo tiene, entonces es el input de restricciones.
//                    if (strpos(explode(":", $inputsString[$i])[0], "_" ) !== false) {
//                        $atributoInput = explode("_", explode(":", $inputsString[$i])[0])[0];
//                    } else {
//                        $atributoInput = explode(":", $inputsString[$i])[0];
//                    }
//                    // asignamos el valor
//                    $valor = explode(":", $inputsString[$i])[1];
//
////                    var_dump($tipoInput);
////                    var_dump($atributoInput);
////                    var_dump($valor);
//
//                    // armamos el array con clave-valor.
//                    array_push($inputsArray, array($tipoInput, array($atributoInput => $valor)));
//                }
//            }
//            
////            $this->validarDatosMerManejador($nombreMer, $ci, $nombreEjercicio, 
////                    $inputsArray);
//            
//            var_dump($inputsArray);
//            
////            // entidad 1
////            $entidad1 = $inputsArray[1];
////            $atributo1_entidad1 = $inputsArray[5];
////           
////            // VER DE DONDE SACAR LOS DATOS DE $tipoEntidad , $entidadSupertipo,
////            // $atributoMultivaluado ,$agregacion , $tipoCategorizacion
////            
////            // // guardar entidades y atributos SE DEBE EJECUTAR TANTAS VECES COMO
////            //  ATRIBUTOS TENGA LA ENTIDAD
////            $this->guardarSolucionMerEntidad($entidad1, $tipoEntidad ,
////                                             $entidadSupertipo ,
////                                             $atributo1_entidad1 ,
////                                             $atributoMultivaluado ,$agregacion ,
////                                             $tipoCategorizacion ,  
////                                             $nombreEjercicio, $ci);
////            
////            // entidad 2
////            $entidad2 = $inputsArray[7];
////            $atributo1_entidad2 = $inputsArray[11];
////            $atributo2_entidad2 = $inputsArray[13];
////            
////            // relacion
////            $relacion1 = $inputsArray[15];
////            
////            // guardar relaciones SE DEBE EJECUTAR UNA VEZ POR RELACION
////            $this->guardarSolucionMerRelacion($relacion1, $entidad1, $entidad2,
////                                              $nombreEjercicio, $ci);
////            
////            $reestricciones = $inputsArray[17];// NO HAY CAMPO EN LA BD PARA ESTE DATO
//            
//        }catch (Exception $ex) {
//            echo "Excepción capturada: ", $ex->getMessage(), "\n";
//        }
//    }   
    
    public function guardarInputsEjercicio() {
        try {
            session_start();
            $nombreEjercicio = $_SESSION["ejercicio"];
            if (isset($_REQUEST["inputs"])) {
                $_SESSION["inputs"] = $_REQUEST["inputs"];                               
            }
            
            header("location: http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=validarEjercicio");
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
}
?>
