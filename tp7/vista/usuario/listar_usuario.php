<?php 
include_once('../../configuracion.php');
$data = data_submitted();
$objuser = new CTRLUsuario();
$list = $objuser->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    $nuevoElem['idusuario']=$elem->getidusuario();
    $nuevoElem["usnombre"]=$elem->getusnombre();
    $nuevoElem['usmail']=$elem->getusmail();
    $nuevoElem["usdeshabilitado"]=$elem->getusdeshabilitado();
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida,null,2);
?>
