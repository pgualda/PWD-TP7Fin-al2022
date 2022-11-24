<?php
include_once("../../util/estructura/header.php");
include_once "../../util/esPrivada.php";
?>

<body>

    <table id="dg" title="Administrador de rols" class="easyui-datagrid" style="width:700px;height:250px" url="listar_rol.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idrol" width="10px">ID</th>
                <th field="rodescripcion" width="20px">Nombre</th>
            </tr>
        </thead>
    </table>

    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRol()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRol()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyRol()">Borrar</a>
    </div>

    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="idrol" id="idrol" class="easyui-textbox" label="ID" style="width:100%" readonly hidden>
            </div>
            <div style="margin-bottom:10px">
                <input name="rodescripcion" id="rodescripcion" class="easyui-textbox" required label="Descripcion" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRol()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
        var url;

        function newRol() {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Rol');
            $('#fm').form('clear');
            url = 'alta_rol.php';
        }

        function editRol() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Rol');
                $('#fm').form('load', row);
                url = 'edit_Rol.php?idrol=' + row.idrol;
                // debug OKA
                // console.log(row.idrol);

            }
        }

        function saveRol() {
            //alert(" Accion");
            $('#fm').form('submit', {
                url: url,
                onSubmit: function() {
                    return $(this).form('validate');
                },
                success: function(result) {
                    //                        alert("Save Volvio Serviodr"+result);   
                    var result = eval('(' + result + ')');
                    //                        alert("Save Volvio Serviodr"+result.errorMsg);   

                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {

                        $('#dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload 
                    }
                }
            });
        }

        function destroyRol() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar?', function(r) {
                    if (r) {
                        $.post('eliminar_rol.php?idrol=' + row.idprol, {
                                idrol: row.idrol
                            },
                            function(result) {
                                //                               	 alert("Baja - Volvio Servidor"+result);   
                                if (result.respuesta) {

                                    $('#dg').datagrid('reload'); // reload the  data
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
</body>

</html>