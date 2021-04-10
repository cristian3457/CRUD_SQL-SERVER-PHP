<?php 

$serverName = 'DESKTOP-RCE8SSU\SQLEXPRESS';
$connectionInfo = array("Database"=>"prueba_usuarios", "UID"=>"prueba3", "PWD"=>"12345Ea*", "CharacterSet"=>"UTF-8");
$con = sqlsrv_connect( $serverName, $connectionInfo);

if( $con ){
    // echo 'conexión exitosa';
}else{
    echo 'fallo en la conexión';
    die( print_r( sqlsrv_errors(), true));
}
?>

