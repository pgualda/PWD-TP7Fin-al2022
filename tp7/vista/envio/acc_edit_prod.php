<?php
include_once('../../configuracion.php');
$data = data_submitted();
$respuesta = false;
if (isset($data['idcompraitem'])){
    $objC = new CTRLCompraItem();

    $respuesta = $objC->modificacion($data);
    if (!$respuesta){
        $mensaje = " La accion  MODIFICACION No pudo concretarse";
    } /* else {
        $respuesta =true;
    }  */   
}
// debug
//echo "<script>console.log('Console:' " . $respuesta . " );</script>";
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
 echo json_encode($retorno);
?>
