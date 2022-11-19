<?php 
include_once('../../configuracion.php');
$data = data_submitted();
$respuesta = false;
if (isset($data['idcompra']) and isset($data['idproducto'])and isset($data['cicantidad'])){
        $objC = new CTRLCompraItem();

        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = "La accion Añadir No pudo concretarse";

        }
}


$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>
