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
        case "tema":
            $mvc->verTema();
            break;
    }
}


?>
