<?php 
include_once('../../configuracion.php');

$data = data_submitted();
$objControl = new CTRLMenu();
$list = $objControl->buscar($data);
//echo json_encode($list,null,2);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $nuevoElem['idmenu'] = $elem->getidmenu();
    $nuevoElem["menombre"]=$elem->getmenombre();
    $nuevoElem["medescripcion"]=$elem->getmedescripcion();
    if ($elem->getobjmenu() != NULL) {
        $nuevoElem["idpadre"]=$elem->getobjmenu()->getidmenu(); }
      else {
        $nuevoElem["idpadre"]=null;
    }  
    $nuevoElem["medeshabilitado"]=$elem->getmedeshabilitado();
    $nuevoElem["meurl"]=$elem->getmeurl();
    $nuevoElem["sinrolrequerido"]=$elem->getsinrolrequerido();
   
    array_push($arreglo_salida,$nuevoElem);
}
echo json_encode($arreglo_salida,null,2);
?>