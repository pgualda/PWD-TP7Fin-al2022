<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$OBJCompraestado=new CTRLCompraestado();

$objcompra = new CTRLCompra();
$list = $objcompra->buscar(null);
$arreglo_salida =  array();
foreach ($list as $elem ){
     
    $objcompraestado=new CTRLCompraestado();
    $listestado=$objcompraestado->buscarparaenviar($elem->getidcompra());

    if ($listestado != null) {

        $nuevoElem['idcompra'] = $elem->getidcompra();
        $nuevoElem["cofecha"]=$elem->getcofecha();
        $nuevoElem["idusuario"]=$elem->getobjusuario()->getidusuario();
        $nuevoElem["usnombre"]=$elem->getobjusuario()->getusnombre();
        array_push($arreglo_salida,$nuevoElem);
    }    
}
//debug
//echo "el json<br>";  
echo json_encode($arreglo_salida);
?>
