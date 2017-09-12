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

    private function replace_content($in = '/Contenido/', $out, $pagina) {
        return preg_replace($in, $out, $pagina);
    }
    
    public function inicio() {
        $pagina = $this->load_template("inicio");
        $header = $this->load_page("vistas/html/headerInicio.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Contenido/', "Logo", $pagina);
        $pagina = $this->replace_content('/Titulo/', "Bienvenido", $pagina);
        $this->view_page($pagina);
    }
    
    public function modal($msjModal) {
        $modal = "<div class='modal' style='display: block;'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                    <h4 class='modal-title'>Atención:</h4>
                                </div>
                                <div class='modal-body'>
                                    <p>$msjModal</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>";
        
        echo $modal;
    }
    
    public function ingresar() {
        if (isset($_REQUEST["ingresar"])) {
            $ci = $_REQUEST["ci"];
            $clave = md5($_REQUEST["clave"]);
            
            $this->login($ci, $clave);
            
//            var_dump($this->getMensajeManejador());
            if (!$this->getMensajeManejador() == NULL) {
                $pagina = $this->load_template("inicio");
                $header = $this->load_page("vistas/html/headerInicio.html");
                $pagina = $this->replace_content('/Header/', $header, $pagina);
                $pagina = $this->replace_content('/Titulo/', "Bienvenido", $pagina);
                $this->modal($this->getMensajeManejador());
            }
            else {
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
                        //$header = $this->load_page("vistas/html/headerLogueado.html");
//                      $contenido = $this->load_page("vistas/html/AlumnoTeorico.html");
                       // $pagina = $this->replace_content('/Header/', $header, $pagina);         
                        $pagina = $this->replace_content('/Contenido/',$this->menuAlumno(), $pagina);
                        $pagina = $this->replace_content('/Titulo/', "Teórico curso", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        
                        
                        
                        break;
                    case("profesor");
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/Profesor.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
                        $pagina = $this->replace_content('/Titulo/', "Cursos Asignados", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    case("administrativo");
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/Administrativo.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
                        $pagina = $this->replace_content('/Titulo/', "Menú de Administrativo", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        break;
                }
            }
            
            $this->view_page($pagina);
        }
    }
    
    public function cerrarSesion() {
        session_start();
        unset($_SESSION["ciUsuario"]);
        unset($_SESSION["nombreUsuario"]);
        unset($_SESSION["apellidoUsuario"]);
        unset($_SESSION["claveUsuario"]);
        unset($_SESSION["categoriaUsuario"]);
        unset($_SESSION["cursoUsuario"]);
        session_destroy();
        
        $this->inicio();
    }
    
    public function cambiarClave() {
        session_start();
        $pagina = $this->load_template("inicio");
        $header = $this->load_page("vistas/html/headerLogueado.html");
        $contenido = $this->load_page("vistas/html/menuUsuario.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
        $pagina = $this->replace_content('/Titulo/', "Cambio de clave", $pagina);
        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
        $this->view_page($pagina);
    }
    
    public function cambioClave() {
        session_start();
        if (isset($_REQUEST["aceptar"])) {
            $claveActual = md5($_REQUEST["claveActual"]);
            $claveNueva = md5($_REQUEST["claveNueva"]);
            $claveNuevaRep = md5($_REQUEST["claveNuevaRep"]);
            
            if ($claveActual <> $_SESSION["claveUsuario"]) {
                $this->modal("Clave actual incorrecta.");
            }
            else {
                if ($claveNueva <> $claveNuevaRep) {
                    $this->modal("La clave nueva no coincide con la validación.");
                }
                else {
                    $this->cambiarClaveManejador($_SESSION["ciUsuario"], $claveNueva);
                }
            }
            
            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerLogueado.html");
            $contenido = $this->load_page("vistas/html/menuUsuario.html");
            $pagina = $this->replace_content('/Header/', $header, $pagina);
            $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
            $pagina = $this->replace_content('/Titulo/', "Cambio de clave", $pagina);
            $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                
            if (!$this->getMensajeManejador() == NULL) {
                $this->modal($this->getMensajeManejador());
            }
        }
        $this->view_page($pagina);
    }

    
    public function menuAlumno() {

// <!-- Columnas -->
        echo "<div>"
                . "<ul class='nav nav-pills nav-stacked'>"
                . "<li class='dropdown-menu'><a href='#'>Introduccion</a></li>";

        
        $tema = $this->listarTemasPorCurso($_SESSION["cursoUsuario"]);
        $subTemas = $this->listarSubTemasPorCursoYTema($_SESSION["cursoUsuario"], $tema);
        
        //itera sobre el Tema
         foreach ($tema as $menu => $menu_tema) {
            echo'<li class="active">'
            . '<a class="dropdown-toggle" data-toggle="dropdown"'
            . ' href="" aria-expanded="false"> '
            . '' . $menu_tema['nombre_tema'] . ''
            . '<span class="caret"></span></a>';
        
            //si es distinto de NULL
           

            if (!$subTemas == NULL) {

              echo'<ul class="dropdown-menu">';
                
              foreach ($subTemas as $sub => $sub_tema){
                                     
                    echo ' <li><a href="http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema" >' . $sub_tema['nombre_subtema'] . '</a></li>';
                }

                echo '</ul></li>';
            } else {


                echo '</li>';
            }
        }
        echo '</ul>';
        
        echo "</div>"
                . "<p></p>"
                . "<div>"
                . "<div class='container'>"
                . "<div class='item'>"
                . "<div class='jumbotron'>"
                . "<h1>Introduccion</h1>"
                . "<p>Modelo conceptual gráfico, usado para representar "
                . "estructuras que almacenan información.No contiene lenguaje "
                . "para representar operaciones de manipulación información. "
                . "Se utilizan Entidades, Conjuntos de Entidades y Relaciones</p>"
                . "<p align='right'>"
                . "<input type='button' class='btn btn-primary btn-lg' value='Practica tu mismo' onClick='' />"
                . "</p>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>";
          
            }

    public function verTema() {
        session_start();
        
        $this->temaManejador();
        
        $pagina = $this->load_template("Inicio");
        $header = $this->load_page("vistas/html/headerLogueado.html");
        $contenido = $this->load_page("vistas/html/alumnoTeorico.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
        $pagina = $this->replace_content('/Titulo/', "$tema", $pagina);
        $this->view_page($pagina);
        
    }
    
    
 
}

?>
