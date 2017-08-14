<?php

require_once "modelo/manejador.php";

class controlador_mvc {
    
    private $manejador;

    function load_template($title = "Sin Titulo") {
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
    

    function inicio() {
        $pagina = $this->load_template("inicio");
        $header = $this->load_page("vistas/html/headerInicio.html");
        $pagina = $this->replace_content('/Header/', $header, $pagina);
        $pagina = $this->replace_content('/Titulo/', "Bienvenido", $pagina);
        $this->view_page($pagina);
    }
    
    function ingresar() {
        if (isset($_REQUEST["ingresar"])) {
            $ci = $_REQUEST["ci"];
            $clave = md5($_REQUEST["clave"]);
            
            $this->manejador = new manejador();
            $this->manejador->login($ci, $clave);
            
            $pagina = $this->load_template("inicio");
            $header = $this->load_page("vistas/html/headerInicio.html");
            $pagina = $this->replace_content('/Header/', $header, $pagina);
            $pagina = $this->replace_content('/Titulo/', "Bienvenido", $pagina);
            
            if (!$this->manejador->getMensaje() == NULL) {
                $pagina = $this->replace_content("/Mensaje/", $this->manejador->getMensaje(), $pagina);
            }
            
            $this->view_page($pagina);
        }
    }
    
}

?>
