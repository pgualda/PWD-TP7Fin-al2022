<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php include_once "../../util/Estructura/header.php";
include_once "../../util/esPrivada.php";
?>
<div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Informe de compras" style="width:100%;max-width:350px;padding:30px 60px;">
        <form id="ff" method="post" action="acc_listacompra.php">
            <div style="margin-bottom:20px">
                <input id="fdd" name="fdd" value="2020-01-01" type="text" class="easyui-datebox" required="required" label="Desde" style="width:100%">
<!--            <input id="fdd" type="date" class="easyui-textbox" name="fdd" style="width:100%" data-options="label:'Desde:',required:true,value:new Date()">-->
            </div>
            <div style="margin-bottom:20px">
                <input id="fhh" name="fhh" value="2030-01-01" type="text" class="easyui-datebox" required="required" label="Hasta" style="width:100%">
            </div>
<!--            <div style="margin-bottom:20px">
                <select id="estado" class="easyui-combobox" name="estado" label="Estado:" style="width:100%">
                    <option value="1">Iniciadas</option>
                    <option value="2">Aceptadas</option>
                    <option value="3">Enviadas</option>
                    <option value="0">Todas</option>
                </select>
            </div> -->
        </form>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Consultar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" style="width:80px">Clear</a>
<!--            <input id="okoculto" type="submit" hidden></input> -->
        </div>
    </div>
</div>


<script type="text/javascript">

function submitForm(){
    // por si tuviera que formatear algun elemento
    $("#ff").submit();
}

</script> 

<?php include_once "../../util/Estructura/footer.php"; ?>

</body>
</html>