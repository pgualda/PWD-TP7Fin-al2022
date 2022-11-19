<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php include_once "../../util/Estructura/header.php"; ?>

<?php
        $OBJSession=new CTRLSession;
        $OBJSession->cerrar();
        echo "<p>cerramos sesion".session_status()."</p>";
        echo("<script>location.href = '../home/index.php';</script>");

?>

<?php include_once "../../util/Estructura/footer.php"; ?>

</body>
</html>