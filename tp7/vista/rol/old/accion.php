<?php
include_once("../../util/estructura/header.php");
$datos = data_submitted();
$resp = false;
$objTrans = new CTRLRol();
//print_r($datos);
    if (isset($datos['accion'])){
        $resp = $objTrans->abm($datos);
        if($resp){
            $mensaje = "La accion ".$datos['accion']." se realizo correctamente.";
        }else {
            $mensaje = "La accion ".$datos['accion']." no pudo concretarse.";
        }
        //echo $mensaje;
        echo("<script>location.href = './index.php?msg=$mensaje';</script>");
    }
?>