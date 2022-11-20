<?php
$Titulo = " Gestion de Usuarios";
include_once("../../util/estructura/header.php");
$datos = data_submitted();

$obj= new CTRLMenu();
$lista = $obj->buscar(null);

?>

    <table id="dg" title="Administrador de item menu" class="easyui-datagrid" style="width:900px;height:300px"
        url="listar_menu.php" toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idmenu" width="50">#</th>  
                <th field="menombre" width="50">Nombre</th>
                <th field="medescripcion" width="50">descripcion</th>
                <th field="idpadre" width="50">id padre</th>
                <th field="medeshabilitado" width="50"> Deshabilitado</th>
                <th field="meurl" width="50">meurl</th>
                <th field="sinrolrequerido" width="50">Opcion publica</th>
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
                <input name="medeshabilitado" id="medeshabilitado"  class="easyui-textbox" label="Deshabilitado" style="width:100%;display:none;">
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
<!-- aca vienen los roles -->
        <table id="dgrol" class="easyui-datagrid" style="width:700px;height:300px" 
         url="listar_rol.php"
         toolbar="#toolbarrol" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"
         data-options="method:'post',queryParams:{idmenu:''},title:'Roles'">

            <thead>
                <tr>
<!--                    <th field="mridmenu" width="10" >Id menu</th> -->
                    <th field="idrol" width="10">Id rol</th>
                    <th field="rodescripcion" width="10">Descripcion rol</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarrol">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="agregamenurol()">Agregar rol</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="borrarmenurol()">Borrar rol</a>
        </div>

                    
    <div id="altarol" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="altarolform" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Agregar roles a opciones de Menu</h3>
<!--            <div style="margin-bottom:10px">
                <input name="mridmenu" id="mridmenu"  class="easyui-textbox" label="ID menu" style="width:100%" readonly>
            </div> -->
            <div style="margin-bottom:10px">
                <input name="idmenu" id="idmenu"  class="easyui-textbox" label="ID menu" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="idrol" id="idrol"  class="easyui-textbox" required="true" label="Rol" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="javascript:$('#mridmen').val('#idmenusel');savemenurol()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#altarol').dialog('close')" style="width:90px">Cancelar</a>
    </div>


<p id="idmenusel">sin selecc-de momento sin uso</p>

<script type="text/javascript">
            var url;
            function selectrol() {
                alert('ok');
            }
            $('#dg').datagrid({
        	    onSelect: function(index,field,value){
                    var row = $('#dg').datagrid('getSelected');
                    $('#idmenu').html(row.idmenu);
                    $('#idmenusel').html(row.idmenu);
                    $('#dgrol').datagrid('load',{ idmenu:row.idmenu});
            	}
            });
            function newMenu(){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menu');
                $('#fm').form('clear');
                url = 'alta_menu.php';
            }
            function agregamenurol(){
                var row = $('#dg').datagrid('getSelected');
                $('#altarol').dialog('open').dialog('center').dialog('setTitle','Nuevo Menu Rol');
                $('#altarolform').form('load',row);
                url = 'alta_menurol.php';
            }
            function editMenu(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Menu');
                    $('#fm').form('load',row);
                    url = 'edit_menu.php?idmenu='+row.idmenu;
                }
            }
            function saveMenu(){
            	// menuuuuuuuuuuuuuuuuuu menuuuuuuuuuuuuuu
                $('#fm').form('submit',{
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
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload 
                            $('#dgrol').datagrid('reload');    // reload 
                        }
                    }
                });
            }
            function savemenurol(){
                // menu rooooollllllllll menu rolllllllllll
                $('#altarolform').form('submit',{
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
                            $('#altarol').dialog('close');        // close the dialog
                            $('#dgrol').datagrid('reload');    // reload 
                        }
                    }
                });
            }
            function destroyMenu(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar?', function(r){
                        if (r){
                            $.post('eliminar_menu.php?idmenu='+row.idpmenu,{idmenu:row.idmenu},
                               function(result){
//                               	 alert("Baja - Volvio Servidor"+result);   
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
            function borrarmenurol(){
                var rowmenu = $('#dg').datagrid('getSelected');
                var row = $('#dgrol').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm','Seguro que desea eliminar?', function(r){
                        if (r){
                            $.post('eliminar_menurol.php?idmenu='+rowmenu.idmenu+'&idrol'+row.idrol,{idmenu:rowmenu.idmenu,idrol:row.idrol},
                               function(result){
//                               	 alert("Baja - Volvio Servidor"+result);   
                                 if (result.respuesta){
                                   	 
                                    $('#dgrol').datagrid('reload');    // reload the  data
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