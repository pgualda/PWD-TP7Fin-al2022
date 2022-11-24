<body>
    <?php
    include_once("../../util/estructura/header.php");
    include_once "../../util/esPrivada.php";

    $datos = data_submitted();
    $compra = new CTRLCompra();
    $user = $OBJSession->getidUsuario();
    $carrEnProc = null;
    $listar = $compra->buscar(['idusuario' => $user]);
    if(array_key_exists(0,$listar)){
        $ultimo = end($listar);
        $idcompra = $ultimo->getidcompra();
        $carrEnProc = $compra->buscarCarrOpen($idcompra);
    }
    if ($carrEnProc == null) {
            echo "<h4>No hay carrito iniciado</h4>";
    ?>
            <a href="acc_carrito_iniciar.php?idusuario=<?php echo $user; ?>" id="ania" class="easyui-linkbutton" iconCls="icon-add" plain="true" style="height:50px">Iniciar Carrito</a>
        <?php
    } else {
        ?>
            <a href="acc_carrito_finalizar.php?idcompra=<?php echo $idcompra; ?>" class="easyui-linkbutton" iconCls="icon-save" plain="true" style="height:50px">
                <h3>Finalizar Carrito</h3>
            </a>
    <?php
        }
    ?>

    <h2>Carrito de compras</h2>
    <h3>Seleccione los productos que desea cargar al carrito.</h3>

    <!-- Lista de productos -->
    <table id="dg" title="Productos" class="easyui-datagrid" style="width:700px;height:250px" url="acc_listar_prod.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idproducto" width="10">ID</th>
                <th field="pronombre" width="20">Codigo</th>
                <th field="prodetalle" width="140">Producto Detalle</th>
                <th field="procantstock" width="10">st</th>
            </tr>
        </thead>
    </table>

    <br>
    <!-- carrito -->
    <?php
    if ($carrEnProc == null) {
        echo "<br> <h1> Este usuario no ha iniciado carrito </h1>";
    } else {
    ?>
        <table id="dgcarr" title="Carrito" class="easyui-datagrid" style="width:700px;height:250px" toolbar="#toolbarCarr" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="idproducto" width="10">idprod</th>
                    <th field="prodetalle" width="80">Producto Detalle</th>
                    <th field="cicantidad" width="15">Cantidad</th>
                </tr>
            </thead>
        </table>

        <!-- Barra de opciones del carrito -->
        <div id="toolbarCarr">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">editar cantidad</a>
            <a href="javascript:void(0)" id="quitar" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">quitar producto</a>
        </div>

        <!-- Barra de opciones de listar producto -->
        <div id="toolbar">
            <a href="javascript:void(0)" id="ania" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="aniadirProd()">Añadir al carrito </a>
            <input class="easyui-searchbox" data-options="searcher:doSearch" onkeyup="doSearch()">
        </div>
    <?php
    }
    ?>

    <!-- Modal  -->
    <div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Producto</h3>
            <input name="idcompra" id="idcompra" hidden type="text" value="<?php echo $ultimo->getidcompra(); ?>">

            <input name="idcompraitem" id="idcompraitem" hidden type="text">

            <div style="margin-bottom:10px">
                <input name="idproducto" id="idproducto" class="easyui-textbox" required="false" label="idproducto:" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="prodetalle" id="prodetalle" class="easyui-textbox" required="false" label="prodetalle:" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="cicantidad" id="cicantidad" class="easyui-textbox" type="number" required="true" label="cantidad" style="width:100%">
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
        
        $('#dgcarr').datagrid({
            url: 'acc_listar_carrito.php'
        });

        function editMenu() {
            var row = $('#dgcarr').datagrid('getSelected');

            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar cantidad');
                $('#fm').form('load', row);
                $("#cicantidad").next('span').find('input').focus();
                url = 'acc_edit_prod.php?idcompraitem=' + row.idcompraitem +
                    '&idproducto=' + row.idproducto + '&idcompra=' + row.idcompra + '&cicantidad=' + row.cicantidad;
                //alert(url);
            }
        }

        function aniadirProd() {
            //alert("holaa")
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Añadir Producto');
                $('#fm').form('load', row);
                $("#cicantidad").next('span').find('input').focus();

                url = 'acc_add_prod.php?idproducto=' + row.idproducto + '&idcompra=' + <?php echo $ultimo->getidcompra(); ?>;
                //alert(url);
            }

        }

        function saveMenu() {
            $('#fm').form('submit', {
                url: url,
                onSubmit: function() {
                    return $(this).form('validate');
                },
                success: function(result) {
                    var result = eval('(' + result + ')');
                    //alert("Volvio Serviodr");
                    if (!result.respuesta) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload 
                        $('#dgcarr').datagrid('reload');
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

        function doSearch(val) {
            // con una condicion ternaria me ahorro de hacer un if else;
            val !== "" ? val = val : val = " ";
    
            var $dg = $('#dg'),
                prevQueryParams = $dg.datagrid('options')['queryParams'],
                newQueryParams = $.extend(prevQueryParams, {
                    prodetalle: val
                });
            $dg.datagrid('load', newQueryParams);
        }

        document.addEventListener("keyup", event => {
            if (event.key !== "q") return; // Use `.key` instead.
            document.getElementById("quitar").click(); // Things you want to do.
            event.preventDefault(); // No need to `return false;`.
        });
        document.addEventListener("keyup", event => {
            if (event.key !== "e") return; // Use `.key` instead.
            document.getElementById("ania").click(); // Things you want to do.
            event.preventDefault(); // No need to `return false;`.
        });
    </script>
</body>

</html>