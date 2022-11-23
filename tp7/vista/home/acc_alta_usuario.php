<?php
include_once('../../configuracion.php');
$data = data_submitted();
$respuesta = false;
// debug
//foreach ($data as $ele) {
//$console="antes del if idrol:".$ele; }
//echo "<script>console.log('Console: " . $console . "' );</script>";
if (strlen($data['usnombre']) > 3 ){
    
    if (isset($data['usnombre'])) {
        $objC = new CTRLUsuario();
        
        if(!$objC->yaExiste($data['usnombre'])){
            $mensaje = "Este usuario ya esta en uso";
        }else{
            $respuesta = $objC->alta($data);
            if (!$respuesta) {
                $mensaje = "La accion ALTA No pudo concretarse";
            } else{
                $respuesta = true;
            }
        }
        
    }
    
    
}else{ 
    $mensaje = "El usuario debe contener mas de 3 caracteres";
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
?>
