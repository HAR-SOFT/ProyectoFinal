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
       
    public function ingresar() {
        if (isset($_REQUEST["ingresar"])) {
            $ci = $_REQUEST["ci"];
            $clave = md5($_REQUEST["clave"]);
            
            $this->login($ci, $clave);
            
            if (!$this->getMensajeManejador() == NULL) {
                $pagina = $this->load_template("inicio");
                $header = $this->load_page("vistas/html/headerInicio.html");
                $pagina = $this->replace_content('/Header/', $header, $pagina);
                $pagina = $this->replace_content('/Titulo/', "Bienvenido", $pagina);
                echo $this->getMensajeManejador();
            }
            else {
                session_start();
                $_SESSION["nombreUsuario"] = $this->getNombreUsuarioManejador();
                $_SESSION["apellidoUsuario"] = $this->getApellidoUsuarioManejador();
                $_SESSION["categoriaUsuario"] = $this->getCategoriaUsuarioManejador();
                switch (get_class($this->getUsuarioManejador())) {
                    case("alumno");
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/AlumnoTeorico.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
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
        unset($_SESSION["nombreUsuario"]);
        unset($_SESSION["apellidoUsuario"]);
        unset($_SESSION["categoriaUsuario"]);
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
        }
        $pagina = $this->load_template("inicio");
        $header = $this->load_page("vistas/html/headerLogueado.html");
        $contenido = $this->load_page("vistas/html/menuUsuario.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
        $pagina = $this->replace_content('/Titulo/', "Cambio de clave", $pagina);
        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
        $this->view_page($pagina);
    }

    
    public function menuAlumno() {
        session_start();
        
        $this->menuManejador();
        
        
        
        
        $sqlTema = $this->queryTema = "SELECT DISTINCT
                     ASCCTSE.nombre_tema,
                     dt.indice
                     FROM
                     asc_curso_tema_subtema_ejercicio AS ASCCTSE , dim_tema dt
                     WHERE
                     dt.nombre= ASCCTSE.nombre_tema
                     AND ASCCTSE.nombre_curso = 'ATI 2017 20-22'
                     order by dt.indice
                     ";

        //se ejecuta la consulta de temas
        $resultado = $this->ejecutarQuery($this->queryTema, $this->mensaje);

        //Se itera sobre los Temas
        foreach ($resultado as $menu => $menu_tema) {
            echo'<li class="active">'
            . '<a class="dropdown-toggle" data-toggle="dropdown"'
            . ' href="" aria-expanded="false"> '
            . '' . $menu_tema['nombre_tema'] . ''
            . '<span class="caret"></span></a>';


            // Se captura el nombre del tema  
            $tema = $menu_tema['nombre_tema'];


            $sqlSubTema = $this->query = " SELECT "
                    . "ASCCTSE.nombre_tema,"
                    . "ASCCTSE.nombre_subtema  "
                    . "FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE "
                    . "WHERE ASCCTSE.nombre_curso = 'ATI 2017 20-22'"
                    . "and ASCCTSE.nombre_tema = '$tema'";


            // Se ejecuta consulta de SubTemas
            // $resultado2 = $DB->consulta($sqlSubTema);

            $resultado2 = $this->ejecutarQuery($this->querySubtema, $this->mensaje);

            //si la consulta es distinto de NULL

            if (!$sqlSubTema == NULL) {

                echo'<ul class="dropdown-menu">';
                
                var_dump($resultado2);
               
                while ($sub_tema = mysqli_fetch_array($resultado2)){
                                     
                    echo ' <li><a href="http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=tema" >' . $sub_tema['nombre_subtema'] . '</a></li>';
                }

                echo '</ul></li>';
            } else {


                echo '</li>';
            }
        }


        echo '</ul>';
        
              
        
        $pagina = $this->load_template("Inicio");
        $header = $this->load_page("vistas/html/headerLogueado.html");
        $contenido = $this->load_page("vistas/html/alumnoTeorico.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
        $pagina = $this->replace_content('/Titulo/', "$tema", $pagina);
        $this->view_page($pagina);
        
        
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
