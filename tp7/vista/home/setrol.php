<?php 
include_once "../../configuracion.php";
$data = data_submitted();

$objctrlsession = new CTRLSession();
$objctrlsession->setrol($data['idrol']);

echo json_encode("");
?>
