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


    for ($i = 2; $i <= $numRows; $i++) {
        //Insertamos los datos con los valores...

        $ci = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $apellido = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $email = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $telefono = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $celular = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        // $curso = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();


        $pass = md5($ci);

        $sql = "INSERT INTO `dim_usuarios`(`id_usuario`, `ci`, `nombre`, `apellido`, `sexo`, `email`, `clave`, `telefono`, `celular`, `curso`, `categoria_usuario`)"
                . "values(null,'$ci','$nombre','$apellido','$sexo','$email','$pass','$telefono','$celular', 'alumno')";

        $resultado = $DB->consulta($sql);

        if ($resultado == false) {

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

            echo '<tr>';
            echo '<td>' . $i . '</td>';
            echo '<td>' . $ci . '</td>';
            echo '<td>' . $nombre . '</td>';
            echo '<td>' . $apellido . '</td>';
            echo '<td>' . $sexo . '</td>';
            echo '<td>' . $email . '</td>';
            echo '<td>' . $telefono . '</td>';
            echo '<td>' . $celular . '</td>';
            // echo '<td>' . $curso . '</td>';
            echo '</tr>';
        }
    }
}

    //Cierro Archivo
    //fclose($handle);
