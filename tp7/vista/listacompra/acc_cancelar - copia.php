<?php 
include_once "../../configuracion.php";
$data = data_submitted();

$objcompraestado = new CTRLCompraestado();
$respuesta=$objcompraestado->cambiaestado($data['idcompra'],"4"); 

if (!$respuesta) {
    $mensaje="error actualizando estado";
}

if ($respuesta) {
    $objcompraitem=new CTRLCompraitem();
    $list = $objcompraitem->buscar($data);
    foreach ($list as $elem ){
            $respuesta=false;
            $idproducto=$elem->getObjProducto()->getidproducto();
            $cicantidad=$elem->getCiCantidad();
            $pronombre=null; $prodetalle=null; $procantstock=null;
            $objproducto=new CTRLProducto();
            $arreglo=$objproducto->buscar(['idproducto'=>$idproducto]);
            foreach($arreglo as $objunproducto) {
                $respuesta=$objproducto->modificacion(['idproducto'=>$idproducto,
                                                    'pronombre'=>$objunproducto->getpronombre(),
                                                    'prodetalle'=>$objunproducto->getprodetalle(),
                                                    'procantstock'=>$objunproducto->getprocantstock()+$cicantidad]);
            }                                                    
            if ( !$respuesta ) {
               $mensaje = "Error actualizando articulos"; 
            }
    }    
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
echo json_encode($retorno);
?> 
