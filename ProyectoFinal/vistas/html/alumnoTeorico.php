<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Bootstrap 3 responsive centered columns">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/bootstrap1.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <title>Alumno</title>
    </head>
    <body>
        <!-- header -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-nav">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Hamburguesa</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-collapse">
                        <a class="navbar-brand" href="file:///C:/wamp64/www/ProyectoFinal/ProyectoFinal/2.html">e-MER</a>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="http://ude.edu.uy/">UDE</a></li>
                        <li><a href="http://200.58.144.114">Moodle UDE Ingenieria</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Nombre Usuario</b> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Cambiar password</a></li>
                                <li class="divider"></li>
                                <li><a href="file:///C:/wamp64/www/ProyectoFinal/ProyectoFinal/index.html">Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        </nav>
    </div>

    <!-- Columnas -->
    <div class="col-lg-2">
        <ul class="nav nav-pills nav-stacked">
            <li class="dropdown-menu"><a href="#">Introduccion</a></li>


            <?php
            include '../../modelo/conexionDB.php';

            $DB = new conexionDB();
            $DB->conectar();

            //consulta  para listar los temas
            $sql1 = "SELECT DISTINCT
                     ASCCTSE.nombre_tema
                     FROM
                     asc_curso_tema_subtema_ejercicio AS ASCCTSE
                     WHERE
                     ASCCTSE.nombre_curso = 'ATI 2017 20-22'";

            //se ejecuta la consulta
            $resultado = $DB->consulta($sql1);

            //se itera sobre los temas  
            foreach ($resultado as $menu => $menu_tema) {
                echo'<li class="active">'
                . '<a class="dropdown-toggle" data-toggle="dropdown"'
                . ' href="" aria-expanded="false"> '
                . '' . $menu_tema['nombre_tema'] . ''
                . '</a><span class="caret"></span>';

                //se captura el nombre del tema
                $tema = $menu_tema['nombre_tema'];

                //consulta para iterar segun el tema los subtemas
                $sql2 = " SELECT ASCCTSE.nombre_subtema  "
                        . "FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE "
                        . "WHERE ASCCTSE.nombre_curso = 'ATI 2017 20-22'"
                        . "and ASCCTSE.nombre_tema = '$tema'";

                //se ejecuta la consulta de los subtemas   
                $resultado2 = $DB->consulta($sql2);

                //se itera sobre los subtemas

                while ($sub_tema = mysqli_fetch_array($resultado2)) {

                    //foreach ($row as $sub_tema) {
                    echo'<ul class="dropdown-menu">
                         <li><a href="#" >' . $sub_tema['nombre_subtema'] . '</a></li>
                         </ul>';

                    echo' </li>';
                }
            }
            //}
            echo' </li>';
            ?>
    </div>
    <!--  -->
    <!--  -->
    <p></p>
    <div class="col-lg-2">
        <div class="container">
            <div class="item">
                <div class="jumbotron">
                    <h1>Introduccion</h1>
                    <p>M.E.R<br>

                                         
  <?php


    if (isset($boton)) {
        
        
        echo" Modelo conceptual gráfico, usado para representar 
              estructuras que almacenan información.No contiene lenguaje 
              para representar operaciones de manipulación información.
              Se utilizan Entidades, Conjuntos de Entidades y Relaciones";
    }    
        else{

    var_dump($tema);

    $sql = " select dt.letra
            from dim_tema dt
            where dt.nombre = '$tema'";

    var_dump($sql);

    $resultado = $DB->consulta($sql);

    $tema_seleccionado = $DB->retornarRegistros($resultado);

    echo $tema_seleccionado['letra'];
    
}
?>




                    </p>
                    <p align="right">
                        <input type="button" class="btn btn-primary btn-lg" value="Practica tu mismo" onClick="" />
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-1.11.1.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>
