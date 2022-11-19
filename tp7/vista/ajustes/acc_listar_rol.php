<?php 
include_once('../../configuracion.php');

/* $data = data_submitted();
$objControl = new CTRLUsuarioRol();
$list = $objControl->listarRolesNoActivos($data['id'],$data['rol']);
// var_dump($list);
$arreglo_salida =  array();
foreach ($list as $elem ){ */

$data = data_submitted();
$objControl = new CTRLUsuarioRol();
$list = $objControl->buscar(null);
// var_dump($list);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $nuevoElem['idrol'] = $elem->getobjrol()->getidrol();
    $nuevoElem["rodescripcion"]=$elem->getOBJrol()->getrodescripcion();
    $nuevoElem['idusuario'] = $elem->getOBJusuario()->getidusuario();
   
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida);
?>

<!-- 
setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']) -->