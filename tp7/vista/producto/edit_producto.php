<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['idproducto'])){
    $objC = new CTRLPRoducto();
    $respuesta = $objC->modificacion($data);
    
    if (!$respuesta){

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
        
    }else {
        $respuesta =true; 
    }
     
}
$retorno['respuesta'] = $respuesta;
if (isset($sms_error)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>