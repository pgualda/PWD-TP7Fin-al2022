<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
    <?php
    include_once "../../util/Estructura/header.php";
    $objRoles = new CTRLRol();
    $arrRoles = $objRoles->buscar(null);
    $combo = '<option></option>';
    foreach ($arrRoles as $rol) {
        $combo .= '<option value="' . $rol->getidrol() . '" > ' . $rol->getrodescripcion();
    }

    ?>


    <br>
    <div id="tt" class="easyui-tabs" style="width:960px;height:640px;">
        <div title="Ajustes Usuarios activos" style="padding:20px;display:none;">

            <!-- d a t a g r i d   u s u a r i o s   a c t i v o s -->

            <table id="dgusers" title="Usuarios activos" url="acc_listar_user.php" class="easyui-datagrid" style="width:800px;height:200px" toolbar="#tbuser" pagination="false" rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="idusuario" width="5px">ID</th>
                        <th field="usnombre" width="25px">Nombre</th>
                        <!--                         <th field="uspass" width="20px">pass</th> -->
                        <th field="usmail" width="35px">mail</th>
                        <!--                         <th field="usdeshabilitado" width="10px">deshab</th> -->
                    </tr>
                </thead>
            </table>

            <!-- d a t a g r i d   r o l e s   d e l   u s u a r i o -->

            <table id="dgRol" class="easyui-datagrid" style="width:700px;height:300px" url="acc_listar_rol.php" toolbar="#tbrol" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" data-options="method:'post',queryParams:{idusuario:''},title:'Roles'">
                <thead>
                    <tr>
                        <th field="idusuario" width="10px" hidden>ID</th>
                        <th field="idrol" width="10px">ID</th>
                        <th field="rodescripcion" width="20px">Nombre</th>
                    </tr>
                </thead>
            </table>

            <div id="tbuser">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addUser()">Nuevo usuario</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar usuario</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaUser()">Dar de baja</a>
            </div>

            <div id="tbrol">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addRol()">Agregar rol</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="quitRol()">Quitar rol</a>
            </div>
            <p id="idusersel">sin selecc</p>

        </div>

        <!-- d a t a g r i d   u s u a r i o s   i n a c t i v o s -->
        <div title="Usuarios inactivos" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">
            <table id="dgexuser" url="acc_listar_exuser.php" title="Deshabilitados" class="easyui-datagrid" style="width:700px;height:250px" toolbar="#tbexus" pagination="false" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="idusuario" width="10px">ID usuario</th>
                        <th field="usnombre" width="20px">Nombre</th>
                        <th field="usdeshabilitado" width="20px">Fecha</th>
                    </tr>
                </thead>
            </table>
            <!-- toolbar ex users -->
            <div id="tbexus">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="habUser()">Habilitar Usuario</a>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------------H  I  D  D  E  N ------------------------------------------------------------------ -->

    <!-- m o d a l  p a r a   u s u a r i o s -->
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
                <input name="uspass" id="uspass" class="easyui-textbox" type="password" required label="Clave" style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px" style="display:none">
                <input name="uspass2" id="uspass2" class="easyui-textbox" type="password" required label="Clave" style="width:100%;display:none;">
            </div>
        </form>
    </div>

    <!-- o p c i o n e s   m o d a l   u s u a r i o s -->
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <!-- m o d a l   p a r a   a s i g n a r   r o l e s -->
    <div id="dlgrol" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgrol-buttons'">
        <form id="fmrol" method="post" style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="idusuario2" id="idusuario2" hidden label="ID" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
            <select class="easyui-combobox"  id="idrol"  name="idrol" label="Seleccione Rol:" labelPosition="top" style="width:90%;">
            <?php
            echo $combo;
            ?>
            </select>
            </div>
        </form>
    </div>

    <!-- o p c i o n e s   m o d a l   r o l e s -->
    <div id="dlgrol-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="asigRoles()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgrol').dialog('close')" style="width:90px">Cancelar</a>
    </div>


    <script>
        var url;

        function selectrol() {
            alert('ok');
        }

        //          c a r g a   l o s   r o l e s   d e   l o s   u s u a r i o s 

        $('#dgusers').datagrid({
            onSelect: function(index, field, value) {
                var row = $('#dgusers').datagrid('getSelected');
                $('#idusersel').html(row.idusuario);
                $('#dgRol').datagrid('load', {
                    idusuario: row.idusuario
                });
            }
        });

        //          a  g  r  e  g  a  r     n  u  e  v  o    u  s  u  a  r  i  o

        function addUser() {

            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Usuario');
            $('#fm').form('clear');
            url = 'acc_alta_usuario.php';

        }

        //          m  o  d  a  l    a  s  i  g  n  a  r     r  o  l  e  s

        function addRol() {
            var row = $('#dgusers').datagrid('getSelected');
            row.idusuario2 = row.idusuario
            if (row) {
                $('#dlgrol').dialog('open').dialog('center').dialog('setTitle', 'seleccione un rol');
                $('#fmrol').form('load',row);
                url = 'acc_asignar_roles.php';
            }

        }

        //          a  s  i  g  n  a  r     r  o  l  e  s

        function asigRoles() {
            /* if (row) {
                $.post('acc_asignar_roles.php?idusuario=' + row.idusuario, {
                        idusuario: row.idusuario
                    },
                    function(result) {
                        //                               	 alert("Baja - Volvio Servidor"+result);   
                        if (result.respuesta) {
                            $('#dgRol').datagrid('reload'); // reload the  data
                        } else {
                            $.messager.show({ // show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }, 'json');
            } */
            $('#fmrol').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');
                        if (!result.respuesta){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlgrol').dialog('close');        // close the dialog
                            $('#dgRol').datagrid('reload');    // reload 
                        }
                }
            });
            


        }

        //          h  a  b  i  l  i  t  a  r     u  s  u  a  r  i  o

        function habUser() {
            var row = $('#dgexuser').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Desea dar de alta a este usuario?', function(r) {
                    if (r) {
                        $.post('acc_hab_user.php?idusuario=' + row.idusuario, {
                                idusuario: row.idusuario
                            },
                            function(result) {
                                //                               	 alert("Baja - Volvio Servidor"+result);   
                                if (result.respuesta) {
                                    $('#dgusers').datagrid('reload'); // reload the  data
                                    $('#dgexuser').datagrid('reload'); // reload the  data
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
        }

        //          d  e  s  h  a  b  i  l  i  t  a  r     u  s  u  a  r  i  o

        function bajaUser() {
            var row = $('#dgusers').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Desea dar de baja a este usuario?', function(r) {
                    if (r) {
                        $.post('acc_des_user.php?idusuario=' + row.idusuario, {
                                idusuario: row.idusuario
                            },
                            function(result) {
                                //                               	 alert("Baja - Volvio Servidor"+result);   
                                if (result.respuesta) {
                                    $('#dgusers').datagrid('reload'); // reload the  data
                                    $('#dgexuser').datagrid('reload'); // reload the  data
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
        }

        //          q  u  i  t  a  r     r  o  l 
        function quitRol() {
            var rowuser = $('#dgusers').datagrid('getSelected');
            var row = $('#dgRol').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar?', function(r) {
                    if (r) {
                        $.post('eliminar_rol.php?idusuario=' + rowuser.idusuario + '&idrol' + row.idrol, {
                                idusuario: rowuser.idusuario,
                                idrol: row.idrol
                            },
                            function(result) {
                                // alert("Baja - Volvio Servidor"+result);   
                                if (result.respuesta) {

                                    $('#dgRol').datagrid('reload'); // reload the  data
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
        }

    </script>
    </div>
    <?php include_once "../../util/Estructura/footer.php"; ?>
</body>

</html>