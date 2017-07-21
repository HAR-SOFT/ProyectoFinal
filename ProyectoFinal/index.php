<?php

require "controlador/controlador_mvc.php";

//se instancia al controlador 
$mvc = new controlador_mvc();

if ($_GET['action'] == "prueba") { //muestra el modulo del buscador
    $mvc->prueba();
/*} else if ($_GET['action'] == 'history') { //muestra  el modulo "historia de Bolivia"
    $mvc->historia();
} else if (isset($_POST['carrera']) && isset($_POST['cantidad'])) {//muestra el buscador y los resultados
    $mvc->buscar($_POST['carrera'], $_POST['cantidad']);
} else { //Si no existe GET o POST -> muestra la pagina principal
    $mvc->principal();*/
}
?>