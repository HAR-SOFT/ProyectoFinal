<?php

require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';

require_once '../modelo/conexionDB.php';

$DB = new conexionDB();

$DB->conectar();

$fecha = getdate();




if (isset($_POST['submit'])) {

    $archivo = $_FILES['archivos-excel']['name'];

    //$handle = $archivo;

    $objPHPExcel = PHPEXCEL_IOFACTORY::load($archivo);

    $objPHPExcel->setActiveSheetIndex(0);

    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


    for ($i = 2; $i <= $numRows; $i++) {
        //Insertamos los datos con los valores...

        $nombre = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $anio = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $horario = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $fecha_inicio = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $fecha_fin = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();

        
            $sql = "INSERT INTO `dim_cursos`(`id_curso`, `nombre`,`anio`, `horario`, `fecha_inicio`, `fecha_fin`,`estado`)"
                    . "values(null,'$nombre','$anio','$horario','$fecha_inicio','$fecha_fin',1)";


            // var_dump($sql);
            $resultado = $DB->consulta($sql);



            if ($resultado == false) {

                $sql_nombre = "select * from dim_cursos where nombre = $nombre and fecha_inicio = $fecha_inicio";
                
               

                if ($sql_nombre) {

               
                    echo "el curso $nombre con fecha de inicion $fecha_inicio de la fila $i ya existe en el sistema <br> ";
                }


                /*
                  echo '<table border = 1>
                  <tr>
                  <td>fila</td>
                  <td>nombre</td>
                  <td>año</td>
                  <td>horario</td>
                  <td>fecha_inicio</td>
                  <td>fecha_fin</td>

                  </tr>';

                  echo '<tr>';
                  echo '<td>' . $i . '</td>';
                  echo '<td>' . $nombre . '</td>';
                  echo '<td>' . $anio . '</td>';
                  echo '<td>' . $horario . '</td>';
                  echo '<td>' . $fecha_inicio . '</td>';
                  echo '<td>' . $fecha_fin . '</td>';

                  echo '</tr>';
                 * 
                  "* */
            
        }
    }
}

