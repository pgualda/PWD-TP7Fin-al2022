<?php 
include_once('../../configuracion.php');

$data = data_submitted();
$objControl = new CTRLUsuario();
$list = $objControl->ListarExUsers();
// var_dump($list);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $nuevoElem['idusuario'] = $elem->getidUsuario();
    $nuevoElem['usnombre'] = $elem->getusnombre();
    $nuevoElem['uspass'] = $elem->getuspass();
    $nuevoElem['usmail'] = $elem->getusmail();
    $nuevoElem['usdeshabilitado'] = $elem->getusdeshabilitado();
   
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida);
?>