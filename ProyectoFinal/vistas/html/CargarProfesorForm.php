<?php





?>



<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Bootstrap 3 responsive centered columns">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/bootstrap1.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <title>Cargar Profesor</title>
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


        
            <div class="page-header" id="tables">
                <h1 style="color:#d3d3d3;" align="center">Cargar Profesor</h1>
            </div>
            <form class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">Cedula</label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" id="inputCI" name="inputCI" placeholder="Cedula 12345678">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">Nombre</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">Apellido</label>
                        <div class="col-lg-8">
                            <input type="email" class="form-control" id="inputApellido" name="inputApellido" placeholder="Apellido">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Sexo</label>
                        <div class="col-lg-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsMasculino" id="hombre" value="sexo" checked="">
                                    Masculino
                                </label>
                                <label>
                                    <input type="radio" name="optionsFemenino" id="mujer" value="sexo">
                                    Femenino
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">e-mail</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="inputMail" name="inputMail" placeholder="ejemplo@ejemplo.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">Telefono</label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" id="inputTelefono" name="inputTelefono" placeholder="12345678">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-lg-2 control-label">Celular</label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" id="inputCelular" name="inputCelular" placeholder="091234567">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label">Asignar curso</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="select" name="asignarCurso">

                                
<?php
//include '../../modelo/conexionDB.php';
include '../../modelo/manejador.php';

$manejador = new manejador();

$resultado = $manejador->listarCursosActivos();

var_dump($resultado);
 

foreach ($resultado as $row )    
{
    echo'<OPTION VALUE="' . $row['nombre']. '">' . $row['nombre'] . '</OPTION>';
  
    
}
?>
                              

                            </select>
                            <br>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">


                            <button type="reset" class="btn btn-default" name="btnCancel">Cancelar</button>


                            <form action='../importarAlumnos.php' method='post' enctype="multipart/form-data">

                                <button type="submit" class="btn btn-primary" name="btnAgregar">Agregar</button>

                            </form>



                        </div>
                    </div>
                </fieldset>
            </form>
        

        <script src="../js/jquery-1.11.1.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/app.js"></script>
    </body>
</html>
