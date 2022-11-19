<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php include_once "../../util/Estructura/header.php"; 

$datos = data_submitted();
$resp = false;
if (isset($datos['usnombre']) && isset($datos['uspass'])){
        $OBJSession = new CTRLSession();
        $resp = $OBJSession->iniciar($datos['usnombre'],$datos['uspass']);
        if($resp) {
            echo("<script>location.href = '../home/index.php';</script>");
        } else {
            $mensaje ="Error, vuelva a intentarlo";
            echo("<script>location.href = './login.php?msg=".$mensaje."';</script>");
        }
}

include_once "../../util/Estructura/footer.php"; ?>

</body>
</html>
