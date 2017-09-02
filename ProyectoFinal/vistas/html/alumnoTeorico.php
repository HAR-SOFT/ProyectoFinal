<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Bootstrap 3 responsive centered columns">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
            
            include '../../modelo/manejador.php';
            
            $manejador = new manejador();
            
            $manejador->menuManejador();
            
            
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
 
           

                     
                        
?>                    </p>
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
