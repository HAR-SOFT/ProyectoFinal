<?php
try {
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';

require_once '../modelo/conexionDB.php';

$DB = new conexionDB();

$DB->conectar();

    if (isset($_POST['submit'])) {    
        $archivo = $_FILES['archivos-excel']['name'];
    
        if($archivo == NULL){        
            echo "Debe seleccionar un archivo";        
        }
        else{

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
        
                $pass = md5($ci);

                $sql = "INSERT INTO `dim_usuario`"
                        . "(`id_usuario`, `ci`, `nombre`, `apellido`,"
                        . " `sexo`, `email`, `clave`, `telefono`, `celular`,"
                        . " `categoria_usuario`)"
                        . "values(null,'$ci','$nombre','$apellido','$sexo',"
                        . "'$email','$pass','$telefono','$celular', 'alumno')";

                
                $resultado = $DB->consulta($sql);
                var_dump($sql);
                var_dump($resultado);
     
                if ($resultado == false){
            
                     echo "No se han podido Importar el alumno $ci <br>";
                }
                else{
                     echo "Se han importado los siguienres registros $ci $nombre $apellido <br>";
                    
                }
           
            }
        }

    }
           
    }catch (Exception $ex) {
            echo "Excepción capturada: ", $ex->getMessage(), "\n";
        }

