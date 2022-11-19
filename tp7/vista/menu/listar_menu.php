<?php 
include_once('../../configuracion.php');

$data = data_submitted();
$objControl = new CTRLMenu();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $nuevoElem['idmenu'] = $elem->getidmenu();
    $nuevoElem["menombre"]=$elem->getmenombre();
    $nuevoElem["medescripcion"]=$elem->getmedescripcion();
    $nuevoElem["idpadre"]=$elem->getidpadre();
    $nuevoElem["medeshabilitado"]=$elem->getmedeshabilitado();
    $nuevoElem["meurl"]=$elem->getmeurl();
    $nuevoElem["sinrolrequerido"]=$elem->getsinrolrequerido();
   
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida,null,2);
?>