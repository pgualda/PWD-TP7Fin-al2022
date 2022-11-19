<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new CTRLProducto();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idproducto'] = $elem->getidproducto();
    $nuevoElem["pronombre"]=$elem->getpronombre();
    $nuevoElem["prodetalle"]=$elem->getprodetalle();
    $nuevoElem["procantstock"]=$elem->getprocantstock();
    
    array_push($arreglo_salida,$nuevoElem);
}

echo json_encode($arreglo_salida);
?>
