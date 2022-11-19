<?php header('Content-Type: text/html; charset=utf-8');
//header ("Cache-Control: no-cache, must-revalidate ");
$PROYECTO ='tp7';
//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";
// Variable que define la pagina de autenticacion del proyecto
$GLOBALS['ROOT']=$ROOT;
include_once("../../util/funciones.php");
?>
