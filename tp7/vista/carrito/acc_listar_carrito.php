<?php 
include_once "../../configuracion.php";
$data = data_submitted();

/* $OBJSession=new CTRLSession;
$ctCom = new CTRLCompra();
$user = $OBJSession->getidUsuario();
$listar = $ctCom->buscar(['idusuario' => $user]);
$ultimo = end($listar);
$idcompra = $ultimo->getidcompra(); */
        

$objControl = new CTRLCompraItem();
$list = $objControl->listarPorIdCompra($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idcompraitem'] = $elem->getidcompraitem();
    $nuevoElem["idproducto"]=$elem->getobjproducto()->getidproducto();
    $nuevoElem["prodetalle"]=$elem->getobjproducto()->getprodetalle();
    $nuevoElem["idcompra"]=$elem->getobjcompra()->getidcompra();
    $nuevoElem["cicantidad"]=$elem->getcicantidad();

    //echo $data['idcompra'];
    /* if($nuevoElem['idcompra'] == $data['idcompra']){
        //echo "holaaa!";
    } */
    array_push($arreglo_salida,$nuevoElem);
    
}

echo json_encode($arreglo_salida);

//var_dump($data);
?>
