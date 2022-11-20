<?php 
include_once('../../configuracion.php');

$data = data_submitted();
$objControl = new CTRLMenuRol();
$list = $objControl->buscar($data);
//echo json_encode($list,null,2);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $nuevoElem['mridmenu'] = $elem->getobjmenu()->getidmenu();
    $nuevoElem["idrol"]=$elem->getobjrol()->getidrol();
    $nuevoElem["rodescripcion"]=$elem->getobjrol()->getrodescripcion();
   
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida,null,2);
?>