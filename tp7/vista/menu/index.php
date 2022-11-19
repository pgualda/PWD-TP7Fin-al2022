<?php
$Titulo = " Gestion de Usuarios";
include_once("../../util/estructura/header.php");
$datos = data_submitted();

$obj= new CTRLMenu();
$lista = $obj->buscar(null);
if ( !$OBJSession->puedoentrar(__FILE__) ) {
    $mensaje ="Esta opcion requiere permisos, logeese para acceder";
    echo $mensaje;
    echo "<script>location.href = '../login/login.php?msg=".$mensaje."';</script>";
}


?>
<h3>ABM - Menu</h3>




<table id="dg" title="Administrador de item menu" class="easyui-datagrid" style="width:700px;height:500px"
    url="listar_menu.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">

            <thead>
            <tr>
            <th field="idmenu" width="50">#</th>
            <th field="menombre" width="50">Nombre</th>
            <th field="medescripcion" width="50">descripcion</th>
            <th field="idpadre" width="50">id padre</th>
            <th field="medeshabilitado" width="50"> medeshabilitado</th>
            <th field="meurl" width="50">meurl</th>
            <th field="sinrolrequerido" width="50">sinrolrequerido</th>
          
            </tr>
            </thead>
            </table>
            <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">Nuevo Menu </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Editar Menu</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">Baja Menu</a>
            </div>
            
            <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
            <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Menu Informacion</h3>
            <div style="margin-bottom:10px">
                <input name="idmenu" id="idmenu"  class="easyui-textbox" label="ID" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="menombre" id="menombre"  class="easyui-textbox" required="true" label="nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="medescripcion" id="medescripcion"  class="easyui-textbox" required="true" label="descripcion:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="idpadre" id="idpadre"  class="easyui-textbox"  label="idpadre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="medeshabilitado" id="medeshabilitado"  class="easyui-textbox" label="habilitado" style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px">
                <input name="meurl" id="meurl"  class="easyui-textbox" label="meurl" style="width:100%;display:none;">
            </div>
            <div style="margin-bottom:10px">
                <input name="sinrolrequerido" id="sinrolrequerido"  class="easyui-textbox" label="sinrolrequerido" style="width:100%;display:none;">
            </div>
             
            </form>
            </div>
            <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
            </div>
            <script type="text/javascript">
            var url;
            function newMenu(){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Usuario');
                $('#fm').form('clear');
                url = 'alta_menu.php';
            }
            function editMenu(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
                    $('#fm').form('load',row);
                    url = 'edit_menu.php?idmenu='+row.idmenu;
                    //alert(row.idmenu)
                    //console.log(row.idmenu);
                }
            }
            function saveMenu(){
            	alert(" Accion");
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');

                        alert("tamos chelo");   
                        if (!result.respuesta){
                            $.messager.show({
                                title: 'TE QUIVPCASTE MAqINAAAAA',
                                msg: result.errorMsg
                            });
                        } else {
                           
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload 
                        }
                    }
                });
            }
            function destroyMenu(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar el menu?', function(r){
                        if (r){
                            $.post('eliminar_menu.php?idmenu='+row.idpmenu,{idmenu:row.idmenu},
                               function(result){
                               	 alert("tamos chelo");   
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
<?php

include_once("../../util/estructura/footer.php");
?>