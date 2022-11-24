<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FERRETERIA MAYORISTA</title>
</head>
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
                }
            }
        } else {
        ?>
            <h1 style="text-align: center;">Bienvenido a nuestro sistema de ventas!</h1>
            <a class='easyui-linkbutton c3' style='height:60px;margin:3px 28%;padding:3px;' href='javascript:void(0)' plain="true" onclick="newUsuario()">Registrarse</a>
            <a class='easyui-linkbutton c3' style='height:60px;margin:3px;padding:3px;' href='../login/login.php'>Iniciar sesion</a>

            <!--  m o d a l   p a r a   n u e v o   r e g i s t r o -->

            <div id="dlgnuevo" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-nuevo'">
                <form id="fmusuario" method="post" style="margin:0;padding:20px 50px" data-options="novalidate:true">
                    <div style="margin-bottom:10px">
                        <input name="idusuario" id="idusuario" label="ID" style="width:100%" value="null" hidden>
                    </div>
                    <div style="margin-bottom:10px">
                        <label for="usnombre">Ingrese nombre</label>
                        <input name="usnombre" id="usnombre" class="easyui-textbox" data-options="required:true,validType:'length[3,10]',validateOnCreate:false,err:err" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <label for="usmail">Ingese email</label>
                        <input name="usmail" id="usmail" class="easyui-textbox" data-options="required:true,validType:'email',validateOnCreate:false,err:err" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px" style="display:none">
                        <label for="uspass">Ingrese Contraseña</label>
                        <input name="uspass" id="uspass" class="easyui-textbox" type="password" data-options="validateOnCreate:false,required:true,validType:'length[6,10]',err:err" style="width:100%;display:none;" pattern="{6-10}">
                    </div>
                    <div style="margin-bottom:10px" style="display:none">
                        <label for="uspass2">Reingrese contraseña</label>
                        <input name="uspass2" id="uspass2" class="easyui-textbox" type="password" required="required" data-options="validateOnCreate:false,err:err" validType="equals['#uspass']" style="width:100%;display:none;">
                    </div>
                </form>
            </div>

            <!-- o p c i o n e s   m o d a l   p a r a   n u e v o   r e g i s t r o  -->

            <div id="dlg-buttons-nuevo">
                <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>

                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgnuevo').dialog('close')" style="width:90px">Cancelar</a>
            </div>


        <?php
        }
        if ($OBJSession->validar()) {
            $roll = $objusuario->buscar(['idrol' => $OBJSession->getRol()]);
        ?>
    </div>
    <h1>Bienvenido <?php echo $OBJSession->getusuario(); ?> </h1>
    <h3>Su rol actual: <?php echo $roll[0]->getOBJrol()->getrodescripcion(); ?></h3>

    <!-- M o d i f i c a r   d   a   t   o   s   p e r s o n a l e s -->
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
    <!-- o p c i o n e s   d e   d a t o s   p e r s o n a l e s -->
    <div id="toolbar2">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar Mail</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPass()">Cambiar Contraseña</a>
    </div>

    <!-- m o d a l   p a r a   m o d i f i c a r   d a t o s   p e r s o n a l e s -->
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
                <input name="uspass" id="uspass" type="password" data-options="validateOnCreate:true,required:true,validType:'length[6,10]'" label="Clave" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <label for="uspass2">reingrese pass:</label>
                <input name="uspass2" id="uspass2" type="password" required="required" data-options="validateOnCreate:true" validType="equals['#uspass']" style="width:100%;display:none;">
                <!-- 
                <input name="uspass2" id="uspass2" type="password" data-options="validateOnCreate:true" validType="equals['#uspass']" style="width:100%"> -->
            </div>
        </form>
    </div>

    <!-- o p c i o n e s   m o d a l  -->
    <div id="dlg-buttons">
        <a href="javascript:void(0)" id="enviar" type="submit" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>


<?php
        }
?>

</div>

<style scoped="scoped">
    .tb {
        width: 100%;
        margin: 0;
        padding: 5px 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .error-message {
        margin: 4px 0 0 0;
        padding: 0;
        color: red;
    }
</style>


<script type="text/javascript">
    /* Mostrar estado de validacion */

    function err(target, message) {
        var t = $(target);
        if (t.hasClass('textbox-text')) {
            t = t.parent();
        }
        var m = t.next('.error-message');
        if (!m.length) {
            m = $('<div class="error-message"></div>').insertAfter(t);
        }
        m.html(message);
    }

    $.extend($.fn.validatebox.defaults.rules, {
        equals: {
            validator: function(value, param) {
                return value == $(param[0]).val();
            },
            message: 'Las contraseñas no coinciden.'
        }
    });

    /* Setear rol */
    function setrol(idrol) {
        $.post('setrol.php?idrol=' + idrol);
        location.href = '../home/index.php';
    }

    /* funcion que llama y modifica dgDatos para poder cambiar el email*/
    function editUsuario() {
        var row = $('#dgDatos').datagrid('getSelected');

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

    /* funcion que llama y modifica dgDatos para editar contraseña */
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

    /* Funcion que modifica los datos  */
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
            //alert(hashpass)
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
                //alert("Save Volvio Serviodr" + result);
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


    function saveUsuario() {
        var idusuario = document.getElementById('idusuario').value;
        var usnombre = document.getElementById('usnombre').value;
        var usmail = document.getElementById('usmail').value;
        var uspass = document.getElementById('uspass').value;
        var uspass2 = document.getElementById('uspass2').value;
        var usdeshabilitado = "NULL";
        var hashpass = CryptoJS.MD5(uspass2);
        var ruta = 'idusuario=' + idusuario + '&usnombre=' + usnombre + '&uspass=' + hashpass + '&usmail=' + usmail + '&usdeshabilitado=' + usdeshabilitado;

        $.ajax({
            url: "acc_alta_usuario.php",
            type: 'POST',
            data: ruta,
            onSubmit: function() {
                return $('#fmusuario').form('validate');
            },
            success: function(result) {
                //alert("Save Volvio Serviodr" + result);
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
                        msg: "Se ha registrado nuevo usuario, Aguarde a que un Admin lo habilite"
                    })
                    $('#dlgnuevo').dialog('close'); // close the dialog
                }
            }
        });
    }


    function newUsuario() {
        $('#dlgnuevo').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Usuario');
        $('#fmusuario').form('clear');
        url = 'acc_alta_usuario.php';
    }


</script>

</body>
<?php include_once "../../util/Estructura/footer.php"; ?>

</html>