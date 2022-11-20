<?php 
include_once("../../util/estructura/header.php");
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

   <table id="dg" name="dg" title="Administrador de usuarios" class="easyui-datagrid" style="width:700px;height:500px;" 
   url="listar_usuario.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>
            <tr>
            <th field='idusuario' width="10px">ID</th> 
            <th field='usnombre' width="20px">Nombre</th>
            <th field='usmail' width="20px">Mail</th> 
            <th field='usdesahabilitado' width="20px">Deshabilitado</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUsuario()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUsuario()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUsuario()">Borrar</a>
    </div>

            
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="idusuario" id="idusuario"  class="easyui-textbox" label="ID" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="usnombre" id="usnombre"  class="easyui-textbox" required label="Nombre" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="usmail" id="usmail"  class="easyui-textbox" required label="Mail" style="width:100%">
            </div>
            <div style="margin-bottom:10px" style="display:none">
                <input name="uspass" id="uspass"  class="easyui-textbox" label="Clave" style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px">
                <input name="usdeshabilitado" id="usdeshabilitado"  class="easyui-textbox" label="Clave" style="width:100%;display:none;">
            </div>

        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
            var url;

            function newUsuario(){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Usuario');
                $('#fm').form('clear');
                url = 'alta_usuario.php';
            }

            function editUsuario(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
                    $('#fm').form('load',row);
                    url = 'edit_usuario.php?idusuario='+row.idusuario;
                    // debug OKA
                    // console.log(row.idusuario);

                }
            }

            function saveUsuario(){
            	//alert(" Accion");
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
//                        alert("Save Volvio Serviodr"+result);   
                        var result = eval('('+result+')');
//                        alert("Save Volvio Serviodr"+result.errorMsg);   

                        if (!result.respuesta){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                           
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload 
                        }
                    }
                });
            }
            
            function destroyUsuario(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar?', function(r){
                        if (r){
                            $.post('eliminar_usuario.php?idusuario='+row.idpusuario,{idusuario:row.idusuario},
                               function(result){
                              // 	 alert("Baja - Volvio Servidor"+result);   
                                 if (result.respuesta){
                                   	 
                                    $('#dg').datagrid('reload');    // reload the  data
                                } else {
                                    $.messager.show({    // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                  });
                                }
                            },'json');
                        }
                    });
                }
            }
    </script> 
</body>
</html>