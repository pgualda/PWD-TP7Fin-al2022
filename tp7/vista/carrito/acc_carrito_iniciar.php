<?php
include_once("../../configuracion.php");
$data = data_submitted();
$respuesta=false;
$objC= new CTRLCompra();
$objCE = new CTRLCompraestado();
// $objCET = new CTRLCompraEstadoTipo();
$iniciarCE['idcompraestadotipo'] = 1;

//var_dump($iniciarCE);


if (isset($data['idusuario'])){
    //inicio la compra
    //echo "<br>inicio la compra y muestro data<br>";
    //var_dump($data);
    echo "<br>finalizo la compra<br>";

    if($objC->alta($data)){
        //echo "<br>ya pase el alta <br>";
        //var_dump($objC);
        // busco la ultima compra que genere con el usuario
        $arrCompras = $objC->buscar($data);
        $lastCar = end($arrCompras);

        $iniciarCE['idcompra'] = $lastCar->getidcompra();
        
        // doy de alta el compraestado
        //echo "<br>----los datos que le paso a compraestado-----<br>";

        //var_dump($iniciarCE);
        $objCE->alta($iniciarCE);
        //echo "<br>ya pase el objCE <br>";
        //var_dump($objC);

        $respuesta = true;
    }
}

header('Location: index.php');


?>