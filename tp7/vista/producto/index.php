<?php 
include_once("../../util/estructura/header.php");
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

<table id="dg" title="Administrador de productos" class="easyui-datagrid" style="width:700px;height:500px"
    url="listar_producto.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            <th field="idproducto" width="10px">ID</th> 
            <th field="pronombre" width="20px">Nombre</th>
            <th field="prodetalle" width="40px">Descrip.</th>
            <th field="procantstock" width="10px">STock</th>
            </tr>
        </thead>
    </table>

   <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProducto()">Nuevo</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProducto()">Editar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyProducto()">Borrar</a>
    </div>
            
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input name="idproducto" id="idproducto"  class="easyui-textbox" label="ID" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="pronombre" id="pronombre" type="number" class="easyui-textbox" required="true" label="Cod.Int." style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input  name="prodetalle" id="prodetalle"  class="easyui-textbox" required="true" label="Detalle" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input class="easyui-textbox" name="procantstock" label="Cant.Stock">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProducto()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
            var url;
            function newProducto(){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menu');
                $('#fm').form('clear');
                url = 'alta_producto.php';
            }
            function editProducto(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
                    $('#fm').form('load',row);
                    url = 'edit_Producto.php?accion=mod&idproducto='+row.idproducto;
                }
            }
            function saveProducto(){
            	//alert(" Accion");
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');
//                        alert("Volvio Serviodr"+result);   

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
            function destroyProducto(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar?', function(r){
                        if (r){
                            $.post('eliminar_producto.php?producto='+row.idproducto,{idproducto:row.idproducto},
                               function(result){
//                               	 alert("Volvio Serviodr");   
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