<?php
include_once("../../util/estructura/header.php");
include_once "../../util/esPrivada.php";
$datos = data_submitted();
?>


<body>
<!--    <h3>Envio de compras aceptadas</h3> -->
<!--    <p>Seleccion una operacion y si es necesario edite las cantidades</p> -->

    <!-- Lista de compras aceptadas sin enviar, revisar en envio_listar_compra.php para q vengan solo correctos -->
    <div id="dgdiv">
        <table id="dg" title="Compras a enviar" class="easyui-datagrid" style="width:700px;height:400px"
         url="envio_listar_compra.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="idcompra" width="20">ID Compra</th>
                    <th field="cofecha" width="40">Fecha</th>
                    <th field="idusuario" width="20">ID Usuario</th>
                    <th field="usnombre" width="40">Nombre</th> <!-- uso el nombre del campo en la base, aunque este en otra tabla -->
                </tr>
            </thead>
        </table>

        <div id="toolbar">
            <a href="javascript:void(0)" id="ania" class="easyui-linkbutton" iconCls="icon-add" plain="true"
             onclick="envio_agrega_compra()">Selecciona compra</a>
        </div>

    </div>

    <div id="dgitemdiv" hidden>
        <div id="datoscompra" style="margin:10px">
            <span id="compraselect">sin compra seleccionada</span>
            <span id="idcompra" hidden></span>
             <a href="javascript:void(0)" class="easyui-linkbutton c8" onclick="enviapedido()">Envia pedido</a>
             <a href="javascript:void(0)" class="easyui-linkbutton c8" onclick="cancelaenvio()">Cancela envio</a>
        </div>

        <table id="dgitem" class="easyui-datagrid" style="width:700px;height:360px" 
         url="envio_listar_item.php"
         toolbar="#toolbarCarr" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true"
         data-options="method:'post',queryParams:{idcompra:''},title:'Carrito'">

            <thead>
                <tr>
                    <th field="idcompraitem" width="10" hidden>Nro Item</th>
                    <th field="idproducto" width="10" hidden>Id Producto</th>
                    <th field="prodetalle" width="50">Descripcion</th>
                    <th field="idcompra" width="10" hidden>Id compra</th>
                    <th field="cicantidad" width="10">Cantidad</th>
                </tr>
            </thead>
        </table>

        <div id="toolbarCarr">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editCantidad()">editar cantidad</a>
        </div>
    </div>

    <!-- Modal  -->
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Producto</h3>
            <input name="idcompra" id="idcompra" hidden type="text"> <!-- tengo q asignar desde la llamada -->
            <input name="idcompraitem" id="idcompraitem" hidden type="text">
            <div style="margin-bottom:10px">
                <input name="idproducto" id="idproducto" class="easyui-textbox" required="false" label="ID producto:" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="prodetalle" id="prodetalle" class="easyui-textbox" required="false" label="Descripcion:" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="cicantidad" id="cicantidad" class="easyui-textbox" required="true" label="cantidad" style="width:100%" >
            </div>
        </form>
    </div>

    <!-- opciones del modal -->

    <div id="dlg-buttons">
        <a href="javascript:void(0)" id="finall" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript">
        var url;

        function envio_agrega_compra() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#compraselect').html("Compra: "+row.idcompra+" fecha:"+row.cofecha+" cliente:"+row.usnombre);
                $('#datoscompra').attr("hidden",false);
                // oculta la selccion de la compra y muestra para procesar
                $('#dgdiv').attr("hidden",true);
                $('#dgitemdiv').attr("hidden",false);
                // hace el resto 
                $('#idcompra').html(row.idcompra);
                $('#dgitem').datagrid('load',{ idcompra:$('#dg').datagrid('getSelected').idcompra});
                $('#dgitem').datagrid({fitColumns:true}); // importante para q rearme las columnas
            }    
        } 

        // hacer lo mismo luego enviar el pedido
        function cancelaenvio() {
            $('#dgdiv').attr("hidden",false);
            $('#dgitemdiv').attr("hidden",true);
            $('#idcompra').html('');
            $('#dg').datagrid({fitColumns:true}); // importante para q rearme las columnas
        }    


        function enviapedido() {
            var idcompra=$('#idcompra').html();
            if (idcompra) {
                $.messager.confirm('Confirm', 'Esta seguro que desea enviar el pedido?', function(r) {
                    if (r) {
                        $.post('envio_envio.php?idcompra=' + idcompra, 
                            function(result) {
                                if (result.respuesta) {
                                    // oculta items y vuelve a activar seleccion de pedidos
                                    $('#dgdiv').attr("hidden",false);
                                    $('#dgitemdiv').attr("hidden",true);
                                    $('#idcompra').html('');
                                    $('#dg').datagrid({fitColumns:true}); // importante para q rearme las columnas
                                    $('#dg').datagrid('reload'); // reload the  data compra
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


        function editCantidad() {
            var row = $('#dgitem').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar cantidad');
                $('#fm').form('load', row);
                $("#cicantidad").next('span').find('input').focus();
                url = 'acc_edit_prod.php?idcompraitem=' + row.idcompraitem 
                + '&idproducto=' + row.idproducto + '&idcompra=' + row.idcompra + '&cicantidad=' + row.cicantidad; 
            }

        }

        function saveMenu() {
            $('#fm').form('submit', {
                url: url,
                onSubmit: function() {
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload 
                        $('#dgitem').datagrid('reload');
                    }
                }
            });
        }


        function destroyMenu() {
            var row = $('#dgcarr').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Seguro que desea eliminar el producto del carrito?', function(r) {
                    if (r) {
                        $.post('acc_del_prod.php?idcompraitem=' + row.idcompraitem, {
                                idmenu: row.id
                            },
                            function(result) {
                                //alert("Volvio Serviodr");
                                if (result.respuesta) {

                                    $('#dgcarr').datagrid('reload'); // reload the  data
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

/*        document.addEventListener("keyup", event => {
            if (event.key !== "q") return; // Use `.key` instead.
            document.getElementById("quitar").click(); // Things you want to do.
            event.preventDefault(); // No need to `return false;`.
        });
        document.addEventListener("keyup", event => {
            if (event.key !== "e") return; // Use `.key` instead.
            document.getElementById("ania").click(); // Things you want to do.
            event.preventDefault(); // No need to `return false;`.
        }); */
    </script>
    <?php include_once "../../util/Estructura/footer.php"; ?>
</body>

</html>
