<?php

require "controlador/controlador_mvc.php";
 
$mvc = new controlador_mvc();

if (!isset($_REQUEST["action"])) {
    echo "Ingreso no valido";
}
else {
    switch ($_REQUEST["action"]) {
        case "inicio":
            $mvc->inicio();
            break;
        case "ingresar":
            $mvc->ingresar();
            break;
        case "cerrarsesion":
            $mvc->cerrarSesion();
            break;
        case "cambiarclave":
            $mvc->cambiarClave();
            break;
        case "cambioclave":
            $mvc->cambioClave();
            break;
        case "ejercicio":
            $mvc->ejercicio();
            break;
        case "redireccionar":
            $mvc->redireccionar();
            break;
        case "tema":
            $mvc->verTema();
            break;
        case "editarCurso":
            $mvc->editarCurso();
            break;
        case "alumnos":
            $mvc->alumnosBedelia();
            break;
        case "profesores":
            $mvc->profesoresBedelia();
            break;
        case "cursos":
            $mvc->cursosBedelia();
            break;
        case "agregarAlumno":
            $mvc->agregarAlumno();
            break;
        case "agregoAlumno":
            $mvc->agregoAlumno();
            break;
        case "agregarProfesor":
            $mvc->agregarProfesor();
            break;
        case "agregoProfesor":
            $mvc->agregoProfesor();
            break; 
         case "agregarCurso":
            $mvc->agregarCurso();
            break;
        case "agregoCurso":
            $mvc->agregoCurso();
            break;
        case "temarioCurso":
            $mvc->teoricoCurso();
            break;
    }
}


?>
