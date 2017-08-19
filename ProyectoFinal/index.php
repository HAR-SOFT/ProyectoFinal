<?php

require "controlador/controlador_mvc.php";
 
$mvc = new controlador_mvc();

if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case "inicio";
            $mvc->inicio();
            break;
        case "ingresar";
            $mvc->ingresar();
            break;
    }
}
else {
    echo "Ingreso no valido";
}


?>