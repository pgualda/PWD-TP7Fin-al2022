<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
</style>

    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php 
include_once "../../util/Estructura/header.php"; 
$data = data_submitted();

//var_dump($data);
// tenemos los parametros, la fecha en texto (fdd y fhh) y el estado (0=todos)
$fdd=$data['fdd'];
$fhh=$data['fhh'];
//$estado=$data['estado'];
$objctrlcompra=new CTRLCompra();
$listacompra=$objctrlcompra->buscarddhh($fdd,$fhh);

// ver si hace falta formatear fecha
//$fecha = strtotime($objunacompra->getcofecha()); 
//$fechaformat = date("d M Y", $fecha);
$fdfdd = date("d-m-Y", strtotime($fdd));
$fdfhh= date("d-m-Y", strtotime($fhh));
$titulo="Listado de compras desde el ".$fdfdd." hasta el ".$fdfhh; 

if ( count($listacompra)>0){

?>
<div>
    <table id="compra">
        <caption>  <h3><?php echo $titulo;?></h3> </caption>
        <tr class="">
        <td><b>Id compra</b></td>
        <td><b>Fecha</b></td>
        <td><b>Cliente</b></td>
        <td><b>Estado</b></td>
        <td><b> </b></td>
        <td></td></tr>
        <?php	

        foreach ($listacompra as $objunacompra) {

            // obtiene estado de una compra
            $objctrlcompraestado=new CTRLCompraEstado();
            $buscaestado=$objctrlcompraestado->buscarestadoactual($objunacompra->getidcompra());
            // el estado actual puede ser solo uno
            $descestado="";
            $estadotipo="";
            $fechatoecho="";
            if ( isset($buscaestado[0])) {  
               $fecestado=$buscaestado[0]->getcefechaini();
               $fecha = strtotime($fecestado); 
               $fechatoecho = date("d M Y", $fecha);
               $descestado=$buscaestado[0]->getobjcompraestadotipo()->getcetdescripcion();
               $estadotipo=$buscaestado[0]->getobjcompraestadotipo()->getidcompraestadotipo();
            }  
            echo '<tr><td>'.$objunacompra->getidcompra().'</td>';
            $fecha = strtotime($objunacompra->getcofecha()); 
            $fechaformat = date("d M Y", $fecha);
            echo '<td>'.$fechaformat.'</td>';
            echo '<td>'.$objunacompra->getOBJUsuario()->getusnombre().'</td>';
            echo '<td>'.$descestado." ".$fechatoecho.'</td>';
            echo "<td>";  
            if ( $estadotipo == "3") {
//              $qrcode_text=$objQr->decode($directorio.$archivo);
//              echo "<div class='col-lg-2 col-md-3 col-sm-4  mb-3'>";
//              echo "<button type='button' id='btnmodal' class='' data-toggle='modal' data-target='#exampleModal' data-nom='".$directorio.$archivo."' data-txtqr='".$qrcode_text."'>";
              //$icono='data-options="iconCls:'."'icon-cut'"."'";
              echo "<a href='javascript:void(0)' id='cambiaestado' class='easyui-linkbutton c5' 
                     style='width:90px; height:20px; text-decoration:none' data-idcompra='".$objunacompra->getidcompra()."'>Cancelar</a>";
 
            }
            echo '</td>';
        }
        ?>
    </table>
    <a href="index.php" class="easyui-linkbutton c8" style="width:80px; margin:10px;">Volver</a>
</div>

<script >
/*	$(document).on("click", "#cambiaestado",function () {
        var idcompra =$(this).data('idcompra');

	}) */
$('#cambiaestado').click(function() {
            var idcompra=$(this).data('idcompra');
            if (idcompra) {
                $.messager.confirm('Confirm', 'Esta seguro que desea cancelar?', function(r) {
                    if (r) {
                        $.post('acc_cancelar.php?idcompra=' + idcompra, 
                            function(result) {
                                if (result.respuesta) {
                                  $("#compra").load(location.href + " #compra")
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                    }
                });
            }
} ) // cierra funcion y click

</script>



<?php
} else {

echo "<br><h2>sin datos para el periodo</h2>";
}

include_once "../../util/Estructura/footer.php";
?>

</body>
</html>