<?PHP

require_once "../modelo/manejador.php";
$manejador = new manejador();
$resultado = $manejador->armarMer("PerroCucha");

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
            echo $resultado;
        ?>
    </body>
</html>
