<?php

require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';

require_once '../modelo/conexionDB.php';

require '../controlador/controlador_mvc.php';;

$DB = new conexionDB();

$DB->conectar();

$controler = new controlador_mvc();


if (isset($_POST['submit'])) {

    echo 'hola';
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

        $sql = "INSERT INTO `dim_usuario`(`id_usuario`, `ci`, `nombre`, `apellido`, `sexo`, `email`, `clave`, `telefono`, `celular`, `categoria_usuario`)"
                . "values(null,'$ci','$nombre','$apellido','$sexo','$email','$pass','$telefono','$celular', 'alumno')";

        //var_dump($sql);
        $msjParametro = '';
        $controler->ejecutarQuery($sql, $msjParametro);//$resultado = $DB->consulta($sql);
     
        if ($resultado == false){
            
            $controler->modal("No se han podido Importar el alumno $ci");
        }
    
        
        }
    }else{
        
        echo "else";
    }


    //Cierro Archivo
    //fclose($handle);
