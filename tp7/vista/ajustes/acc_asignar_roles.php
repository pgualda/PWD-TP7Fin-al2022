<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$data['idusuario'] = $data['idusuario2'];
//var_dump($data);
if (isset($data['idusuario'])){
    $objC = new CTRLUsuarioRol();

    if(!$objC->YaLoTengo($data['idusuario'],$data['idrol'])){
        $mensaje = "El usuario ya posee este rol";
    }else{

        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = " La accion HABILITAR No pudo concretarse";
        }

    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>