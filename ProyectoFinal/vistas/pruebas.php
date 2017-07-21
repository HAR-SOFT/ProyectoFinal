<?PHP

require_once "../modelo/cursos.php";
$cursos = new cursos();
$resultado = $cursos->listarCursos();

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
