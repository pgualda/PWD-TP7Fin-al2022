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
    
    
   /*  if ( !$OBJSession->puedoentrar(__FILE__) ) {
        $mensaje ="Esta opcion requiere permisos, logeese para acceder";
        echo $mensaje;
        echo "<script>location.href = '../login/login.php?msg=".$mensaje."';</script>";
    }
     */
    
    
    ?>

    <div class="easyui-panel" style="padding:5px;">
        <?php
        $OBJSession = new CTRLSession;

        echo "<br>-----<br>";
        /* estoy validado */
        /* estoy validado */
        /* estoy validado */
        if ($OBJSession->validar()) {

            echo "<a class='easyui-linkbutton c2' id='btn-cerrar' href='../login/logout.php' style='margin:3px;padding:3px;float: right'>Cerrar sesion</a>";

            //ahora mostramos usuario y rol
            echo "Nombre usuario:" . $OBJSession->getUsuario();
            echo " - Rol activo:" . $OBJSession->getRol();
            echo " - idusuario:" . $OBJSession->getidUsuario();
        ?>
    </div>

    <br>
    <div id="tt" class="easyui-tabs" style="width:800px;height:500px;">
        <div title="Datos Personales" style="padding:20px;display:none;">


            <table id="dgDatos" title="Mis datos" class="easyui-datagrid" style="width:800px;height:200px" toolbar="#toolbar2" pagination="false" rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="idusuario" width="5px">ID</th>
                        <th field="usnombre" width="25px">Nombre</th>
                        <th field="uspass" width="20px">pass</th>
                        <th field="usmail" width="35px">mail</th>
                        <th field="usdeshabilitado" width="10px">deshab</th>
                    </tr>
                </thead>
            </table>

            <div id="toolbar2">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="editUsuario()">Editar Datos</a>
    </div>


        </div>
        <div title="Cambiar Rol" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">

            <!-- datagrid rol -->
            <h3>Rol Activo: <?php echo $OBJSession->getRol(); ?></h3>
            <table id="dgRol" title="Cambiar rol" class="easyui-datagrid" style="width:700px;height:250px" toolbar="#toolbar" pagination="false" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="idrol" width="10px">ID</th>
                        <th field="rodescripcion" width="20px">Nombre</th>
                        <th field="idusuario" width="20px">idusuario</th>
                    </tr>
                </thead>
            </table>


        </div>
    </div>



    <!-- toolbar -->
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRol()">Seleccionar rol</a>
    </div>

    <!-- modal -->
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="idusuario" id="idusuario" class="easyui-textbox" label="ID" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="usnombre" id="usnombre" class="easyui-textbox" required label="Nombre" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="usmail" id="usmail" class="easyui-textbox" required label="Mail" style="width:100%">
            </div>
            <div style="margin-bottom:10px" style="display:none">
                <input name="uspass" id="uspass" class="easyui-textbox" type="password" label="Clave" style="width:100%;display:none;">
            </div>
            
        </form>
    </div>

    <!-- opciones modal -->
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>



<?php
            /* No estoy validado */
            /* No estoy validado */
            /* No estoy validado */
        } else {
            echo " - Rol activo:" . $OBJSession->getRol();
?>
    <a class='easyui-linkbutton c2' style='margin:3px;padding:3px;' href='../home/'>Usted anda perdido vuelva al inicio</a>


<?php
        }
?>


<script>
    var url;

    // filtro para carrito por idusuario del usuario
    var val = <?php echo $OBJSession->getidUsuario(); ?>;
    $('#dgDatos').datagrid({
        url: 'acc_listar_user.php',
        queryParams: {
            idusuario: 1
        }
    });

    // filtro para carrito por idusuario del usuario
    var val2 = <?php echo $OBJSession->getidUsuario(); ?>;
    var rol = <?php echo $OBJSession->getRol(); ?>;
    $('#dgRol').datagrid({
        url: 'acc_listar_rol.php',
        queryParams: {
            idusuario: val2,
            idrol: rol
        }
    });

    function editUsuario() {
        var row = $('#dgDatos').datagrid('getSelected');

        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Usuario');
            $('#fm').form('load', row);
            url = 'edit_usuario.php?idusuario=' + row.idusuario + '&usnombre=' + row.usnombre +'&uspass='+ row.uspass +'&usmail=' + row.usmail ;
            // debug OKA
            // console.log(row.idusuario);

        }
    }

    function saveUsuario() {
        //alert(" Accion");
        $('#fm').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                alert("Save Volvio Serviodr"+result);   
                var result = eval('(' + result + ')');
                alert("Save Volvio Serviodr"+result.errorMsg);   

                if (!result.respuesta) {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                } else {
                    $('#dlg').dialog('close'); // close the dialog
                    $('#dgDatos').datagrid('reload'); // reload 
                }
            }
        });
    }







    
</script>


</div>
<?php include_once "../../util/Estructura/footer.php"; ?>
</body>

</html>