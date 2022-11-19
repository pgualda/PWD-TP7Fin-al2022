<style>
        #compra {
          border-collapse: collapse;
          width: 100%;
        }

        #compra td, #compra th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #compra tr:nth-child(even){background-color: #f2f2f2;}

        #compra tr:hover {background-color: #ddd;}

        #compra th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
        }
</style>
<title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php 
include_once "../../util/Estructura/header.php"; 
$data = data_submitted();

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
              echo "<a href='javascript:void(0)' id='cambiaestado' class='' 
                     style='width:90px; text-decoration:none' data-idcompra='".$objunacompra->getidcompra()."'>Cancelar</a>";
 
            }
            echo '</td>';
        }
        ?>
    </table>
    <a href="index.php" class="easyui-linkbutton c8" style="width:80px; margin:10px;">Volver</a>
</div>

<script >
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
