<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new CTRLCompraItem();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idcompraitem'] = $elem->getidcompraitem();
    $nuevoElem["idproducto"]=$elem->getobjproducto()->getidproducto();
    $nuevoElem["prodetalle"]=$elem->getobjproducto()->getprodetalle();
    $nuevoElem["idcompra"]=$elem->getobjcompra()->getidcompra();
    $nuevoElem["cicantidad"]=$elem->getcicantidad();
    
    array_push($arreglo_salida,$nuevoElem);
}

echo json_encode($arreglo_salida,null,2);
?>
