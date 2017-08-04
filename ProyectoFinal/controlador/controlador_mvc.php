<?php

require_once "modelo/curso.php";

class controlador_mvc {

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

    private function replace_content($in = '/\#CONTENIDO\#/ms', $out, $pagina) {
        return preg_replace($in, $out, $pagina);
    }

    function prueba() {
        $pagina = $this->load_template("Prueba");
        $html = $this->load_page("vistas/header.php");
        $pagina = $this->replace_content('/\#Header\#/ms', $html, $pagina);
        $this->view_page($pagina);
    }
    
    function login(){}

    /* function buscar($carrera, $cantidad) {
      $universitario = new universitario();
      //carga la plantilla
      $pagina = $this->load_template('- Resultados de la busqueda -');
      //carga html del buscador
      $buscador = $this->load_page('app/views/default/modules/m.buscador.php');
      //obtiene  los registros de la base de datos
      ob_start();
      //realiza consulta al modelo
      $tsArray = $universitario->universitarios($carrera, $cantidad);
      if ($tsArray != '') {//si existen registros carga el modulo  en memoria y rellena con los datos
      $titulo = 'Resultado de busqueda por "' . $carrera . '" ';
      //carga la tabla de la seccion de VIEW
      include 'app/views/default/modules/m.table_univ.php';
      $table = ob_get_clean();
      //realiza el parseado
      $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $buscador . $table, $pagina);
      } else {//si no existen datos -> muestra mensaje de error
      $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $buscador . '<h1>No existen resultados</h1>', $pagina);
      }
      $this->view_page($pagina);
      }

      function principal() {
      $pagina = $this->load_template('Pagina Principal MVC');
      $html = $this->load_page('app/views/default/modules/m.principal.php');
      $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
      $this->view_page($pagina);
      }

      function historia() {
      $pagina = $this->load_template('History of Bolivia');
      $html = $this->load_page('app/views/default/modules/m.historia.php');
      $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
      $this->view_page($pagina);
      }

      function buscador() {
      $pagina = $this->load_template('Busqueda de registros');
      $buscador = $this->load_page('app/views/default/modules/m.buscador.php');
      $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $buscador, $pagina);
      $this->view_page($pagina);
      } */

}
?>
