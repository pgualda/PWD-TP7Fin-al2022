<?php
include_once "../../configuracion.php";
$data = data_submitted();
if (isset($data['idusuario'])){
    $objC = new CTRLUsuario();
    $respuesta = $objC->baja($data);
    if (!$respuesta){
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>