<?php
include_once("../../configuracion.php");
$data = data_submitted();
$respuesta=false;
$objCE = new CTRLCompraestado();
$enviarCE['idcompraestadotipo'] = 2;
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (isset($data['idcompra'])){
    
    //echo "<br>finalizo el carrito<br>";
    $obj = $objCE->buscar($data);
    //$fechaActual = time();
    $fechaActual = date('Y-m-d H:i:s');
    $nObj = end($obj);
    //echo "<br>finalizo el carrito<br>";

    $mod['idcompraestado'] = $nObj->getidcompraestado();
    $mod['idcompra'] = $data['idcompra'];
    $mod['idcompraestadotipo'] = 1;
    $mod['cefechafin'] = $fechaActual;
    
    var_dump($mod);

    $modif = new CTRLCompraestado();
    if($modif->modificacion($mod)){
        
        $enviarCE['idcompra'] = $data['idcompra'];
        $objCE->alta($enviarCE);
    }
}

header('Location: index.php');

?>