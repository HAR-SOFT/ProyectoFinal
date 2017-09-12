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
                        $header = $this->load_page("vistas/html/headerLogueado.html"); 
                        //$contenido = $this->load_page("vistas/html/AlumnoTeorico.html");                    
                        //$pagina = $this->replace_content('/Header/',$header , $pagina);                            
                        $contenido = $this->menuAlumno();                        
                        $pagina = $this->replace_content('/Contenido/',$contenido ,$pagina);
                        $pagina = $this->replace_content('/Titulo/', "Teórico curso", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        break;
                    
                    case("profesor");
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/Profesor.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $this->cursosProfesor(), $pagina);
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

   function menuAlumno() {

// <!-- Columnas -->
        echo "<div class='col-lg-2'>"
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
        
      // <!-- Columnas -->
        echo "<div class='col-lg-2'>"
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
                
                . "<div>"
                . "<div class='container'>"
                . "<div class='item'>"
                . "<div class='jumbotron'>"
                . "<h2>";echo $sub_tema['nombre_subtema'] ."</h2>"
                . "<p>";
                    
                $this->temaManejador($sub_tema['nombre_subtema']);
                
                
        
           echo "</p>"
                . "<p align='right'>"
                . "<input type='button' class='btn btn-primary btn-lg' value='Practica tu mismo' onClick='' />"
                . "</p>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"; 

                        
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html"); 
                        //$contenido = $this->load_page("vistas/html/AlumnoTeorico.html");                    
                        $pagina = $this->replace_content('/Header/',$header , $pagina);                            
                        //$contenido = $this->menuAlumno();                        
                        //$pagina = $this->replace_content('/Contenido/',$contenido ,$pagina);
                        $pagina = $this->replace_content('/Titulo/', $sub_tema['nombre_subtema'], $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        $this->view_page($pagina);
       
        
    }
    
    
    public function cursosProfesor(){
    
    
        echo'<div class="item">
        <table class="table table-striped table-hover ">
            <thead>
                <tr class="danger">
                    <th>
                        <div class="form">
                            <label class="control-label">Curso</label>
                        </div>    
                    </th>
                    <th>
                        <div class="form">
                            <label class="control-label">Horario</label>
                        </div>
                    </th>
                    <th>
                        <div class="form">
                            <label class="control-label">Tema</label>
                        </div>
                    </th>
                    <th>
                        <div class="form">
                            <label class="control-label">Estado</label>
                        </div>
                    </th>
                    <th>
                        <div class="form">
                            <label class="control-label">Editar Curso</label>
                        </div>
                    </th>
                </tr>
            </thead>';
        
        
    $ciUsuario =  $_SESSION["ciUsuario"];  
    $resultado = $this->cursoAsingadosProfesor($ciUsuario);
             
    
    foreach ($resultado as $fila)
        
              echo
             '<tbody>
                <tr class="info">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                                  

                <tr class="active">                
                    <td>'.$fila['nombre_curso'].'</td>
                    <td>'.$fila['horario'].'</td>
                    <td>'.$fila['tema'].'</td>
                    <td>'.$fila['estado'].'</td>
                    <td><a href="http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso">editar</a></td>
                </tr>
              </tbody>';
              
       
        
    }
    
 
    
      public function editarCurso(){
       //session_start();
         
    //$curso =  'ATI2017';
   
    $resultado=$this->editarCurso('ATI2017');
    
    foreach ($resultado as $fila){
        
        
         echo
             '<tbody>
                <tr class="info">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                                  

                <tr class="active">                
                    <td>'.$fila['nombre_curso'].'</td>
                    <td>'.$fila['horario'].'</td>
                    <td>'.$fila['tema'].'</td>
                    <td>'.$fila['estado'].'</td>
                    <td><a href="http://localhost/ProyectoFinal/ProyectoFinal/index.php?action=editarCurso">editar</a></td>
                </tr>
              </tbody>';
               
    }
   
             
}



  
public function alumnosBedelia(){
    
    session_start();
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/menuAlumnoTeorico.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
                        $pagina = $this->replace_content('/Titulo/', "Alumnos", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        
                        $this->view_page($pagina);
    
   echo' 
    <div>
        <div class="page-header" id="tables">
            <h1 style="color:#d3d3d3;" align="center">Alumnos</h1>
        </div>
        <div>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr class="danger">
                        <th><div class="form">
                                <label class="control-label">Nombre</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por nombre">
                                </div>
                        </th>
                        <th><div class="form">
                                <label class="control-label">Cedula</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por cedula">
                                </div>
                        </th>
                        <th><div class="form">
                                <label class="control-label">Curso</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por carrera">
                                </div>
                        </th>
                        <th>
                            <div class="form">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                        </th>
                </thead>';
    
    $resultado = $this->listarUsuariosYCurso();
             
    foreach ($resultado as $fila) {
        
              echo
             '<tbody>
                <tr class="info">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                     <tr class="active">                
                     <td>'.$fila['alumno'].'</td>
                     <td>'.$fila['ci'].'</td>
                     <td>'.$fila['curso'].'</td>
                     <td></td>
                   
                </tr>
              </tbody>';
             
      
    }
     
echo '</table>';
     
 }

  
   function profesoreBedelia(){
       
       
       session_start();
                        $pagina = $this->load_template("inicio");
                        $header = $this->load_page("vistas/html/headerLogueado.html");
                        $contenido = $this->load_page("vistas/html/menuProfesorTeorico.html");
                        $pagina = $this->replace_content('/Header/', $header, $pagina);
                        $pagina = $this->replace_content('/Contenido/', $contenido, $pagina);
                        $pagina = $this->replace_content('/Titulo/', "Profesores", $pagina);
                        $pagina = $this->replace_content('/NombreUsuario/', $_SESSION["nombreUsuario"]. " ". $_SESSION["apellidoUsuario"], $pagina);
                        
                        $this->view_page($pagina);
       
       
     
     echo'<div>
        <div class="page-header" id="tables">
            <h1 style="color:#d3d3d3;" align="center">Profesores</h1>
        </div>
        <div class="item">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr class="danger">
                        <th><div class="form">
                                <label class="control-label">Nombre</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por nombre">
                                </div>
                        </th>
                        <th><div class="form">
                                <label class="control-label">Cedula</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por cedula">
                                </div>
                        </th>
                        <th><div class="form">
                                <label class="control-label">Carrera</label>
                                <div class="input">
                                    <input type="text" class="form-control" placeholder="Filtrar por carrera">
                                </div>
                        </th>
                        <th>
                            <div class="form">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                        </th>
                </thead>';
               $resultado = $this->listarProfesosYCurso();
             
    
    foreach ($resultado as $fila)
        
              echo
             '<tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                                  

                <tr class="active">                
                    <td>'.$fila['profesor'].'</td>
                    <td>'.$fila['ci'].'</td>
                    <td>'.$fila['curso'].'</td>
                    <td></td>
                   
                </tr>
              </tbody>
             </table>
             </div>';
      
         
     
 }



}
  

?>
