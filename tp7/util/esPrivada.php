<?php
if ( !$OBJSession->puedoentrar(__FILE__) ) {
    $mensaje ="Esta opcion requiere permisos, logeese para acceder";
    echo $mensaje;
    echo "<script>location.href = '../login/login.php?msg=".$mensaje."';</script>";
}
?>