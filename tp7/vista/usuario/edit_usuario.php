<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
// debug
//foreach ($data as $ele) {
//$console="antes del if idrol:".$ele; }
//echo "<script>console.log('Console: " . $console . "' );</script>";

if (isset($data['idusuario'])){
    $objC = new CTRLUsuario();
    $respuesta = $objC->modificacion($data);
// debug
//$console="entra en el if de idrol oka".$respuesta;
//echo "<script>console.log('Console: " . $console . "' );</script>";
    
    if (!$respuesta){
        $mensaje = " La accion  MODIFICACION No pudo concretarse";
    } else {
        $respuesta =true;
    }    
}
// debug
//$console="salio del edit_rol.php".$respuesta;
//echo "<script>console.log('Console: " . $console . "' );</script>";

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
 echo json_encode($retorno);
?>

