<?php 
include_once "../../configuracion.php";
$data = data_submitted();

/* foreach ($data as $ele) {
    echo "<script>console.log('".$ele."')</script>";
} */

$objcompraitem = new CTRLCompraitem();
$list = $objcompraitem->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){

    $nuevoElem["idcompraitem"]=$elem->getIdCompraitem();
    $nuevoElem["idproducto"]=$elem->getObjProducto()->getidproducto();
    $nuevoElem["prodetalle"]=$elem->getObjProducto()->getprodetalle();
    $nuevoElem['idcompra'] = $elem->getObjCompra()->getidcompra();
    $nuevoElem["cicantidad"]=$elem->getCiCantidad();
    array_push($arreglo_salida,$nuevoElem);
}

echo json_encode($arreglo_salida);
?>
