<?php

require_once "modelo/manejador.php";

class controlador_mvc extends manejador {

    private $mensaje;
    private $usuario;
    private $nombreUsuario;
    private $apellidoUsuario;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getApellidoUsuario() {
        return $this->apellidoUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setApellidoUsuario($apellidoUsuario) {
        $this->apellidoUsuario = $apellidoUsuario;
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
            $header = $this->load_page("vistas/html/headerInicio.html");
            $contenido = $this->load_page("vistas/html/index.html");
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

                //var_dump($this->getMensajeManejador());
                if (!$this->getMensajeManejador() == NULL) {
                    $pagina = $this->load_template("inicio");
                    $header = $this->load_page("vistas/html/headerInicio.html");
                    $contenido = $this->load_page("vistas/html/index.html");
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
                    $_SESSION["claveUsuario"] = $this->getClaveActualUsuarioManejador();
                    $_SESSION["categoriaUsuario"] = $this->getCategoriaUsuarioManejador();
                    $_SESSION["cursoUsuario"] = $this->getCursoUsuarioManejador();
                    switch (get_class($this->getUsuarioManejador())) {
                        case("alumno");
                            $pagina = $this->load_template("inicio");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $pagina = $this->replace_content("/Header/", $header, $pagina);
                            $pagina = $this->replace_content("/Contenido/", $this->armarTemarioCurso($inicio = true), $pagina);
                            $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
                            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                            break;
                        case("profesor");
                            $pagina = $this->load_template("inicio");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $pagina = $this->replace_content("/Header/", $header, $pagina);
                            $pagina = $this->replace_content("/Contenido/", $this->cursosProfesor(), $pagina);
                            $pagina = $this->replace_content("/Titulo/", "Cursos Asignados", $pagina);
                            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                            break;
                        case("administrativo");
                            $pagina = $this->load_template("inicio");
                            $header = $this->load_page("vistas/html/headerLogueado.html");
                            $contenido = $this->load_page("vistas/html/Administrativo.html");
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

            if (!$_SESSION) {
                $this->inicio();
            } else {
                $pagina = $this->load_template("inicio");
                switch ($_SESSION["categoriaUsuario"]) {
                    case("Alumno");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $pagina = $this->replace_content("/Header/", $header, $pagina);
                        $pagina = $this->replace_content("/Contenido/", $this->menuAlumno(), $pagina);
                        $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
                        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    case("Profesor");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $pagina = $this->replace_content("/Header/", $header, $pagina);
                        $pagina = $this->replace_content("/Contenido/", $this->cursosProfesor(), $pagina);
                        $pagina = $this->replace_content("/Titulo/", "Cursos Asignados", $pagina);
                        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    case("Administrativo");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/Administrativo.html");
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
            unset($_SESSION["claveUsuario"]);
            unset($_SESSION["categoriaUsuario"]);
            unset($_SESSION["cursoUsuario"]);
            session_destroy();

            $this->inicio();
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function cambiarClave() {
        try {
            session_start();

            if (!$_SESSION) {
                $this->inicio();
            } else {
                $pagina = $this->load_template("inicio");
                $header = $this->load_page("vistas/html/headerLogueado.html");
                $contenido = $this->load_page("vistas/html/menuUsuario.html");
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

            if (!$_SESSION) {
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
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/menuUsuario.html");
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
            $mer = $this->armarMerSolucionSistema("PerroCucha");
            //var_dump($this->armarMerSolucionSistema("PerroCucha"));
            session_start();

            if (!$_SESSION) {
                $this->inicio();
            } else {
                if (!$this->getMensajeManejador() == NULL) {
                    $pagina = $this->load_template("inicio");
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/AlumnoTeorico.html");
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "Teórico curso", $pagina);
                    $pagina = $this->replace_content("/none/", "block", $pagina);
                    $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                    $this->modal($this->getMensajeManejador());
                } else {
                    $pagina = $this->load_template("inicio");
                    $header = $this->load_page("vistas/html/headerLogueado.html");
                    $contenido = $this->load_page("vistas/html/AlumnoPractico.html");
                    $pagina = $this->replace_content("/Header/", $header, $pagina);
                    $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
                    $pagina = $this->replace_content("/Titulo/", "A practicar", $pagina);
                    $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);
                }
                $this->view_page($pagina);
            }
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
    
    public function menuTemasCurso($inicio) {
        try {
            $contenido = "<div class='col-lg-2'>"
            . "<ul class='nav nav-pills nav-stacked'>"
            . "<li class='dropdown-menu'><a href='#'>Introduccion</a></li>";
            
            if(!$inicio == true) {
                session_start();
            }
            
            $tema = $this->listarTemasPorCurso($_SESSION["cursoUsuario"]);
            
            for ($i = 0; $i < sizeof($tema); $i++) {
                $nombreTema = $tema[$i]["nombre_tema"];
                $subTemas = $this->listarSubTemasPorCursoYTema($_SESSION["cursoUsuario"], $nombreTema);
                //si hay subtemas
 
                if (!$subTemas[0][0] == NULL) {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a class='dropdown-toggle' data-toggle='dropdown'"
                    . " href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=$nombreTema' aria-expanded='false'>"
                    . $nombreTema
                    . "<span class='caret'></span></a>";

                    $contenido = $contenido. "<ul class='dropdown-menu'>";

                    for ($x = 0; $x < sizeof($subTemas); $x++) {
                        $subTemaAVer = $subTemas[$x][0];
                        $contenido = $contenido. "<li><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&subtema=$subTemaAVer'>" 
                        . $subTemaAVer . "</a></li>";
                    }

                    $contenido = $contenido. "</ul></li>";
                } else {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=temarioCurso&tema=$nombreTema'>"
                    . $nombreTema
                    . "</a>"
                    . "</li>";
                }
            }
            
            $contenido = $contenido. "</ul></div>";
            
            return $contenido;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function armarTemarioCurso($inicio = false) {
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
            
            $contenido = $this->menuTemasCurso($inicio);

            $contenido = $contenido. "<div class='col-lg-2'>"
            . "<div class='container'>"
            . "<div class='item'>"
            . "<div class='jumbotron'>"
            . "<h2>";
            $contenido = $contenido. $tema ."</h2>"
            . "<p>";

            $letra = $this->temaManejador($tema, $subtema);

            $contenido = $contenido. $letra[0][0];

            $contenido = $contenido. "</p>"
            . "</div>"
            . "<div class='form' align='right'>"
            . "<button type='submit' class='btn btn-primary btn-lg' name='practica'>Practica tu mismo</button>"
            . "</div>"
            . "</div>"
            . "</div>";

            return $contenido;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function menuAlumno() {
        try {
            $contenido = "<div class='col-lg-2'>"
            . "<ul class='nav nav-pills nav-stacked'>"
            . "<li class='dropdown-menu'><a href='#'>Introduccion</a></li>";
            
            $tema = $this->listarTemasPorCurso($_SESSION["cursoUsuario"]);
            
            for ($i = 0; $i < sizeof($tema); $i++) {
                $nombreTema = $tema[$i]["nombre_tema"];
                $subTemas = $this->listarSubTemasPorCursoYTema($_SESSION["cursoUsuario"], $nombreTema);
                //si hay subtemas
                if (!$subTemas[0][0] == NULL) {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a class='dropdown-toggle' data-toggle='dropdown'"
                    . " href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema' aria-expanded='false'>"
                    . $nombreTema
                    . "<span class='caret'></span></a>";

                    $contenido = $contenido. "<ul class='dropdown-menu'>";

                    foreach ($subTemas as $sub => $sub_tema) {
                        $contenido = $contenido. "<li><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema'>" 
                        . $sub_tema['nombre_subtema'] . "</a></li>";
                    }

                    $contenido = $contenido. "</ul></li>";
                } else {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema'>"
                    . $nombreTema
                    . "</a>"
                    . "</li>";
                }
            }
            
            $contenido = $contenido. "</ul></div><p></p>";
            $contenido = $contenido. "<div class='col-lg-2'>"
            . "<div class='container'>"
            . "<div class='item'>"
            . "<div class='jumbotron'>"
            . "<h1>Introduccion</h1>"
            . "<p>Modelo conceptual gráfico, usado para representar "
            . "estructuras que almacenan información.No contiene lenguaje "
            . "para representar operaciones de manipulación información. "
            . "Se utilizan Entidades, Conjuntos de Entidades y Relaciones</p>"
            . "</div>"
            . "<div class='form' align='right'>"
            . "<button type='submit' class='btn btn-primary btn-lg' name='practica'>Practica tu mismo</button>"
            . "</div>"
            . "</div>"
            . "</div>";
            
            return $contenido;
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function armarTema() {
        try {
            session_start();
          // <!-- Columnas -->
            $contenido = "<div class='col-lg-2'>"
                    . "<ul class='nav nav-pills nav-stacked'>"
                    . "<li class='dropdown-menu'><a href='#'>Introduccion</a></li>";

            $tema = $this->listarTemasPorCurso($_SESSION["cursoUsuario"]);
            
            for ($i = 0; $i < sizeof($tema); $i++) {
                $nombreTema = $tema[$i]["nombre_tema"];
                $subTemas = $this->listarSubTemasPorCursoYTema($_SESSION["cursoUsuario"], $nombreTema);
                //si hay subtemas
                if (!$subTemas[0][0] == NULL) {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a class='dropdown-toggle' data-toggle='dropdown'"
                    . " href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema' aria-expanded='false'>"
                    . $nombreTema
                    . "<span class='caret'></span></a>";

                    $contenido = $contenido. "<ul class='dropdown-menu'>";

                    foreach ($subTemas as $sub => $sub_tema) {
                        $contenido = $contenido. "<li><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema'>" 
                        . $sub_tema['nombre_subtema'] . "</a></li>";
                    }

                    $contenido = $contenido. "</ul></li>";
                } else {
                    $contenido = $contenido. "<li class='active'>"
                    . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema'>"
                    . $nombreTema
                    . "</a>"
                    . "</li>";
                }
            }
            
            $contenido = $contenido. "</ul></div><p></p>";
            $contenido = $contenido. "<div class='col-lg-2'>"
            . "<div class='container'>"
            . "<div class='item'>"
            . "<div class='jumbotron'>"
            . "<h2>";
            $contenido = $contenido. $sub_tema['nombre_subtema'] ."</h2>"
            . "<p>";
            
            $letra = $this->temaManejador($sub_tema["nombre_subtema"])[0][0];

            $contenido = $contenido. $letra;

            $contenido = $contenido. "</p>"
            . "</div>"
            . "<div class='form' align='right'>"
            . "<button type='submit' class='btn btn-primary btn-lg' name='practica'>Practica tu mismo</button>"
            . "</div>"
            . "</div>"
            . "</div>"; 
            
            return array($contenido, $sub_tema['nombre_subtema']);
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }
    
    public function verTema() {
        try {
            $retornoArmarTema = $this->armarTema();
            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerLogueado.html");                    
            $pagina = $this->replace_content("/Header/",$header , $pagina);                            
            $pagina = $this->replace_content("/Titulo/", $retornoArmarTema[1], $pagina);
            $pagina = $this->replace_content("/Contenido/", $retornoArmarTema[0], $pagina);
            $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
            $this->view_page($pagina);
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
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
                . "<td><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso'>editar</a></td>"
                . "</tr>"
                . "</tbody>";
            }
        } catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }
    }

    public function editarCurso() {
        //session_start();
        //$curso =  'ATI2017';

        $resultado = $this->editarCurso("ATI2017");

        foreach ($resultado as $fila) {
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
            . "<td><a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso'>editar</a></td>"
            . "</tr>"
            . "</tbody>";
        }
    }

    public function alumnosBedelia() {
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
        . "<input type='text' class='form-control' placeholder='Filtrar por carrera'>"
        . "</div>"
        . "</th>"
        . "<th>"
        . "<div class='form'>"
        . "<button type='submit' class='btn btn-primary'>Filtrar</button>"
        . "</div>"
        . "</th>"
        . "</thead>";
        
        $pagina = $this->load_template("inicio");
        $header = $this->load_page("vistas/html/headerLogueado.html");
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
        ."<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>"
        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarAlumno'>Agregar alumno</a></button>";     
        
    }

    public function profesoresBedelia() {
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
        $header = $this->load_page("vistas/html/headerLogueado.html");
        $pagina = $this->replace_content("/Header/", $header, $pagina);
        $pagina = $this->replace_content("/Contenido/", $contenido, $pagina);
        $pagina = $this->replace_content("/Titulo/", "Profesores", $pagina);
        $pagina = $this->replace_content("/NombreUsuario/", $_SESSION["nombreUsuario"] . " " . $_SESSION["apellidoUsuario"], $pagina);

        $this->view_page($pagina);

        $resultado = $this->listarProfesosYCurso();

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
        ."<button type='submit' name = 'submit' class='btn btn-default btn-lg'>Volver</button>"
        ."</form>"
        ."<br>"
        ."</p>"        
        ."<button type='submit' name = 'submit' class='btn btn-primary btn-lg'>"
        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarProfesor'>Agregar Profesor</a></button>";     
        
        
    }
    
    
    public function cursosBedelia() {
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
        $header = $this->load_page("vistas/html/headerLogueado.html");
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
        ."<button type='submit' name = 'submit' class='btn btn-primary btn-lg' type='reset'>"
        . "<a href='http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=agregarCurso'>Agregar Curso</a></button>"; 
            
        }
        
        
        public function agregarAlumno(){            
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
            $header = $this->load_page("vistas/html/headerLogueado.html");
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
            
            
        
    }
    
    
    public function agregoAlumno(){
                                                    
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
                
            }else {
                $this->modal("No se ha podido ingresar el Alumno "
                                  . "$nombreUsuario $apellidoUsuario al sistema.");
                 $this->agregarAlumno();
            }
                          
            }

}
        public function agregarProfesor(){            
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
            $header = $this->load_page("vistas/html/headerLogueado.html");
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
        
        }
       
    public function agregoProfesor(){
                                                    
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
                    }else{
                       $this->modal("No se ha podido asociar el Profesor "
                                  . "$nombreUsuario $apellidoUsuario al $curso.");            
                      $this->agregarProfesor();
                    }        
                
            }else {
                $this->modal("No se ha podido ingresar el Profesor "
                                  . "$nombreUsuario $apellidoUsuario al sistema.");
                 $this->agregarProfesor();
            }
               
            
            }
    }
    
    public function agregarCurso(){            
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
            ."</div>"      ;  
                                           
            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerLogueado.html");
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
            ."</form>";
            
            echo "</table>";          
        
        }
       
    public function agregoCurso(){
                                                    
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
            
            if(!$resultado){                             
                $this->modal("Se agrego el Curso $nombreCurso");
                $this->agregarCurso();
            }else{
                $this->modal("No se ha podido agregar el Curso.");                                              
                $this->agregarCurso();
            }        
                                          
            
            }
    }
    
    
}
?>