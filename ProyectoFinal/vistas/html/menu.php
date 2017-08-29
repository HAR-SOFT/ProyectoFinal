<?php
            include '../../modelo/conexionDB.php';

            $DB = new conexionDB();
            $DB->conectar();

            //consulta  para listar los temas
            $sqlTema = "SELECT DISTINCT
                     ASCCTSE.nombre_tema
                     FROM
                     asc_curso_tema_subtema_ejercicio AS ASCCTSE
                     WHERE
                     ASCCTSE.nombre_curso = 'ATI 2017 20-22'";

            //se ejecuta la consulta de temas
            $resultado = $DB->consulta($sqlTema);

            var_dump($resultado);
            
           //var_dump($resultado[1]);
            
           $tema = 'Atributos';

            //consulta para iterar segun el tema los subtemas
             $sqlSubTema = " SELECT "
                    . "ASCCTSE.nombre_tema,"
                    . "ASCCTSE.nombre_subtema  "
                    . "FROM asc_curso_tema_subtema_ejercicio AS ASCCTSE "
                    . "WHERE ASCCTSE.nombre_curso = 'ATI 2017 20-22'"
                    ;
                   
             

            //se ejecuta la consulta de los subtemas   
            $resultado2 = $DB->consulta($sqlSubTema);
            
            
           var_dump($resultado2);
           
           
           
           //se itera sobre los subtemas
            if ($resultado2 == NULL) {


                foreach ($resultado as $menu => $menu_tema) {
                    echo'<li class="active">'
                    . '<a class="dropdown-toggle" data-toggle="dropdown"'
                    . ' href="" aria-expanded="false"> '
                    . '' . $menu_tema['nombre_tema'] . ''
                    . '</a><span class="caret"></span>'
                    . '</li>';
                }
            } else {

                foreach ($resultado as $menu => $menu_tema) {
                    echo'<li class="active">'
                    . '<a class="dropdown-toggle" data-toggle="dropdown"'
                    . ' href="" aria-expanded="false"> '
                    . '' . $menu_tema['nombre_tema'] . ''
                    . '</a><span class="caret"></span>'
                    ;
                        
                    while ($sub_tema = mysqli_fetch_array($resultado2)) {

                        echo'
                         <li><a href="#" >' . $sub_tema['nombre_subtema'] . '</a></li>
                         ';

                        // echo' </li>';
                    }
                }


                echo '</li>';
                echo'</ul>';
            }



            echo'</ul>';
            //}
            //echo' </li>';
            ?>