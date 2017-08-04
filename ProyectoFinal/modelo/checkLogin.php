<?php
session_start();
?>

<?php
require_once 'manejador.php';

$manejador= new manejador();

$username = $_POST['usuarioCI'];
$password = $_POST['usuarioPass'];
 
listarUsuarios();

$result = $DB->consulta($sql);


if ($result->num_rows > 0) {     
 }
 $row = $result->fetch_array(MYSQLI_ASSOC);
 if (password_verify($password, $row['clave'])) { 
 
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (10 * 60);

 } else { 
   echo "Username o Password estan incorrectos.";
 }
cerrarDB();
?>