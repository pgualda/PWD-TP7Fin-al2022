<?php
include_once "../../configuracion.php";
$data = data_submitted();

if (isset($data['idusuario'])){
    $objC = new CTRLUsuarioRol();
    //$respuesta = $objC->deshabilitar($data['idusuario']);
    var_dump($data);
    if (!$respuesta){
        $mensaje = " La accion HABILITAR No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>