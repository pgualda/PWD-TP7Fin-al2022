<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FERRETERIA MAYORISTA</title>
</head>

<body>
    <?php include_once "../../util/Estructura/header.php";     ?>

    <div class="easyui-panel" style="padding:5px;">
        <?php
        $OBJSession = new CTRLSession;
        if ($OBJSession->validar()) {
            //ahora mostramos usuario y rol
            //  echo "Usuario:" . $OBJSession->getUsuario();
            //            echo " - Rol activo:".$OBJSession->getRol();
            //            echo " - id:".$OBJSession->getidUsuario();

            // <!-- aca ponemos botones para q muestre roles existentes distintos al activo ->$_COOKIE

            $objusuario = new CTRLUsuarioRol();
            $listaroles = $objusuario->buscar(['idusuario' => $OBJSession->getidusuario()]);
            foreach ($listaroles as $objunrol) {
                //$datosRoles = array($)
                if ($objunrol->getOBJRol()->getidrol() != $OBJSession->getRol()) {
                    echo "<a class='easyui-linkbutton c3' href='javascript:void(0)' style='margin:3px;padding:3px;' onclick='setrol(" . $objunrol->getOBJRol()->getidrol() . ")'>Selecciona rol " . $objunrol->getOBJRol()->getrodescripcion() . "</a>";
                    $defRol = null ? $defRol = "Sin rol asignado" : $defRol = $objunrol->getOBJRol()->getrodescripcion();
                }
            }
            // echo "<a class='easyui-linkbutton c2' id='btn-cerrar' href='../login/logout.php' style='margin:3px;padding:3px;'>Cerrar sesion</a>";
        } else {
        ?>
            <a class='easyui-linkbutton c2' style='margin:3px;padding:3px;' href='../usuario/nuevousuario.php'>Generar un usuario de cliente -debera ser validado-</a>
            <a class='easyui-linkbutton c2' style='margin:3px;padding:3px;' href='../login/login.php'>Logearse</a>

        <?php
        }
        if ($OBJSession->validar()) {
            $roll = $objusuario->buscar(['idrol' => $OBJSession->getRol()]);
        ?>
    </div>
    <h1>Bienvenido <?php echo $OBJSession->getusuario(); ?> </h1>
    <h3>Su rol actual: <?php echo $roll[0]->getOBJrol()->getrodescripcion(); ?></h3>

    <!-- Aca deberia ir el boton de modificar datos personales -->

    <table id="dgDatos" title="Mis datos" class="easyui-datagrid" style="width:800px;height:150px" url="acc_listar_misdatos.php" toolbar="#toolbar2" pagination="false" rownumbers="false" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idusuario" width="5px" hidden>ID</th>
                <th field="usnombre" width="25px">Nombre</th>
                <th field="uspass" width="20px" HIDDEN>pass</th>
                <th field="usmail" width="35px">mail</th>
                <!-- <th field="usdeshabilitado" width="10px">deshab</th> -->
            </tr>
        </thead>
    </table>

    <div id="toolbar2">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar Mail</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPass()">Cambiar Contraseña</a>
    </div>

    <!-- modal -->
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px" style="display:none">
                <input name="idusuario" id="idusuario" label="ID" HIDDEN style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px">
                <input name="usnombre" id="usnombre" label="Nombre" HIDDEN style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px">
                <input name="usmail" id="usmail" required label="Mail" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <label for="uspass">Ingrese nueva pass:</label>
                <input name="uspass" id="uspass" required type="password" label="Clave" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <label for="uspass2">reingrese pass:</label>
                <input name="uspass2" id="uspass2" required type="password" style="width:100%">
            </div>
        </form>
    </div>

    <!-- opciones modal -->
    <div id="dlg-buttons">
        <a href="javascript:void(0)" id="enviar" type="submit" class="easyui-linkbutton c6" iconCls="icon-ok" onsubmit="" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

<?php
        }
?>

</div>
<script type="text/javascript">

    function setrol(idrol) {
        $.post('setrol.php?idrol=' + idrol);
        location.href = '../home/index.php';
    }

    function editUsuario() {
        var row = $('#dgDatos').datagrid('getSelected');
        var a = "NULL"

        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar correo');
            $('#fm').form('clear');

            $('#usmail').addClass('easyui-textbox')
            $('#usmail').show()
            $('#uspass').removeClass('easyui-textbox')
            $('#uspass').hide()
            $('#uspass2').removeClass('easyui-textbox')
            $('#uspass2').hide()
            $('#fm').form('load', row);
            $('label').hide()
            $("#usmail").focus();
            // debug OKA
            // console.log(row.idusuario);
        }
    }


    function editPass() {
        var row = $('#dgDatos').datagrid('getSelected');

        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Cambiar Password');
            $('#fm').form('clear');

            $('#uspass').addClass('easyui-textbox')
            $('#uspass').show()
            $('#uspass2').addClass('easyui-textbox')
            $('#uspass2').show()
            $('#usmail').removeClass('easyui-textbox')
            $('#usmail').hide()
            $('#fm').form('load', row);
            $('#uspass').val("");
            $('label').show()
            $('#uspass').focus()
            // debug OKA
            // console.log(row.idusuario);

        }
    }

    $('#enviar').click(function(e) {
        e.preventDefault();
        var idusuario = document.getElementById('idusuario').value;
        var usnombre = document.getElementById('usnombre').value;
        var usmail = document.getElementById('usmail').value;
        var uspass = document.getElementById('uspass').value;
        var uspass2 = document.getElementById('uspass2').value;
        var usdeshabilitado = "NULL";
        var ruta;
        if (uspass2 == "") {
            ruta = 'idusuario=' + idusuario + '&usnombre=' + usnombre + '&uspass=' + uspass + '&usmail=' + usmail + '&usdeshabilitado=' + usdeshabilitado
        } else {
            var hashpass = CryptoJS.MD5(uspass2);
            alert(hashpass)
            ruta = 'idusuario=' + idusuario + '&usnombre=' + usnombre + '&uspass=' + hashpass + '&usmail=' + usmail + '&usdeshabilitado=' + usdeshabilitado
        }
        //var ruta = ruta = 'idusuario=' + idusuario + '&usnombre=' + usnombre + '&uspass=' + uspass + '&usmail=' + usmail;

        $.ajax({
            url: "edit_usuario.php",
            type: 'POST',
            data: ruta,
            onSubmit: function() {
                return $('#fm').form('validate');
            },
            success: function(result) {
                alert("Save Volvio Serviodr" + result);
                var result = eval('(' + result + ')');
                //alert("Save Volvio Serviodr" + result.errorMsg);

                if (!result.respuesta) {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                } else {
                    $.messager.show({
                        title: 'Correcto',
                        msg: "Se ha actualizado el dato"
                    })
                    $('#dlg').dialog('close'); // close the dialog
                    $('#dgDatos').datagrid('reload'); // reload 
                }
            }
        })

    })
</script>
<?php include_once "../../util/Estructura/footer.php"; ?>

</body>

</html>