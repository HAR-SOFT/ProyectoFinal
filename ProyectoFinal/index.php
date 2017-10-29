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
        case "verTema":
            $mvc->editarCursoTemaYLetra();
            break;
        case "editarCurso":
            $mvc->editarCursoMenu();
            break;
        case "verEjercicio":
            $mvc->editarCursoTemaYLetraEjercicio();
            break;
        case "asociarTema":
            $mvc->asociarTema();
            break;
         case "desasociarTema":
            $mvc->desasociarTema();
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
         case "asignarCursoAlumno":
            $mvc->asignarCursoAlumnos();
            break;
        case "asignarCursoProfesor":
            $mvc->asignarCursoProfesores();
            break;
        case "asignoCursoAlumnos":
            $mvc->asignoCursoAlumnos();
            break;
        case "asignoCursoProfesores":
            $mvc->asignoCursoProfesores();
            break;
        case "practicar":
            $mvc->practicar();
            break;
        case "validarEjercicio":
            $mvc->validarEjercicio();
            break;
        case "guardarInputsEjercicio":
            $mvc->guardarInputsEjercicio();
            break;
        case "filtrarAlumno":
            $mvc->filtrarAlumnos();
            break;
        case "filtrarProfesor":
            $mvc->filtrarProfesores();
            break;
        case "filtrarAlumnoSinCurso":
            $mvc->filtrarAlumnosSinCurso();
            break;
        case "filtrarProfesoresSinCurso":
            $mvc->filtrarProfesoresSinCurso();
            break;
        case "filtrarCurso":
            $mvc->filtrarCurso();
            break;
        case "importarAlumnos":
            $mvc->importarAlumnos();
            break;
        case "importarProfesores":
            $mvc->importarProfesores();
            break;
        case "eliminarRegistro":
            $mvc->eliminarRegistro();
            break;
        case "modificarRegistroAlumno":
            $mvc->modificarAlumno();
            break;
        case "modificoRegistroAlumno":
            $mvc->modificoRegistroAlumno();
            break;
        case "eliminarRegistroProfesor":
            $mvc->eliminarRegistroProfesor();
            break;
        case "modificarRegistroProfesor":
            $mvc->modificarRegistroProfesor();
            break;
        case "modificoRegistroProfesor":
            $mvc->modificoRegistroProfesor();
            break;
        case "modificarRegistroCurso":
            $mvc->modificarRegistroCurso();
            break;
        case "modificoRegistroCurso":
            $mvc->modificoRegistroCurso();
            break;
        case "verReporte":
            $mvc->verReporte();
            break; 
    }
}


?>
