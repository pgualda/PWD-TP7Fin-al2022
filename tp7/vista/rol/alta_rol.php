<?php 
include_once('../../configuracion.php');
$data = data_submitted();
$respuesta = false;
if (isset($data['rodescripcion'])){
        $objC = new CTRLRol();

        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = "La accion ALTA No pudo concretarse";
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>
