<?php

require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';

require_once '../modelo/conexionDB.php';

$DB = new conexionDB();

$DB->conectar();


if (isset($_POST['submit'])) {

    $archivo = $_FILES['archivos-excel']['name'];

    $objPHPExcel = PHPEXCEL_IOFACTORY::load($archivo);

    $objPHPExcel->setActiveSheetIndex(0);

    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

    $dimension = $objPHPExcel->setActiveSheetIndex(0)->calculateWorksheetDimension();

    //var_dump($numRows);
    //var_dump($dimension);


    for ($i = 2; $i <= $numRows; $i++) {


        $ci = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $apellido = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $email = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $telefono = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $celular = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();

        $pass = md5($ci);

        $sql = "INSERT INTO `dim_usuario`(`id_usuario`, `ci`, `nombre`, `apellido`, `sexo`, `email`, `clave`, `telefono`, `celular`, `categoria_usuario`)"
                . "values(null,'$ci','$nombre','$apellido','$sexo','$email','$pass','$telefono','$celular', 'profesor')";

        // var_dump($sql);

        $resultado = $DB->consulta($sql);


        if ($resultado == false) {

            //$sql_nombre = "select * from dim_usuarios where nombre = $ci ";

            //if ($sql_nombre) {


                echo "el profesor con CI $ci de la fila $i ya existe en el sistema <br> ";
            

            /*
             * 



              //Se muestran las filas que no pudieron ser importadas
              echo '<table border = 1>
              <tr>
              <td>fila</td>
              <td>ci</td>
              <td>nombre</td>
              <td>apellido</td>
              <td>sexo</td>
              <td>email</td>
              <td>telefono</td>
              <td>celular</td>
              </tr>';
              echo '<br>';
              echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td>' . $ci . '</td>';
              echo '<td>' . $nombre . '</td>';
              echo '<td>' . $apellido . '</td>';
              echo '<td>' . $sexo . '</td>';
              echo '<td>' . $email . '</td>';
              echo '<td>' . $telefono . '</td>';
              echo '<td>' . $celular . '</td>';
              echo '</tr>';

             * 

             */
        }

      
    }
}

