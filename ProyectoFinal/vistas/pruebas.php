<?PHP

require_once "../modelo/manejador.php";
$manejador = new manejador();
$resultado = $manejador->listarCursos();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">      
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Login</title>
    </head>
    <body>
        <?PHP
            echo $resultado[0]["nombre"];
        ?>
    </body>
</html>
