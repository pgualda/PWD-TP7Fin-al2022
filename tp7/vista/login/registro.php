<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro</title>
</head>

<body>
    <?php include_once "../../util/Estructura/header.php"; ?>
    <?php
    $datos = data_submitted();
    if (isset($datos['msg'])) {
        echo "<p>" . $datos['msg'] . "</p><br>";
    }
    ?>
        <div class="easyui-panel" title="Registro" style="width:600px;padding:10px;">

            <form id="fm" method="post" style="margin:0;padding:20px 50px" novalidate>
                <div style="margin-bottom:10px">
                    <input name="idusuario" id="idusuario" label="ID" style="width:100%" value="null" hidden>
                </div>
                <div style="margin-bottom:10px">
                    <label for="usnombre">Ingrese nombre</label>
                    <input name="usnombre" id="usnombre" class="easyui-textbox" data-options="required:true,validType:'length[3,10]',validateOnCreate:true,err:err" style="width:100%">
                </div>
                <div style="margin-bottom:10px">
                    <label for="usmail">Ingese email</label>
                    <input name="usmail" id="usmail" class="easyui-textbox" data-options="required:true,validType:'email',validateOnCreate:true,err:err" style="width:100%">
                </div>
                <div style="margin-bottom:10px" style="display:none">
                    <label for="uspass">Ingrese Contraseña</label>
                    <input name="uspass" id="uspass" class="easyui-textbox" type="password" data-options="validateOnCreate:true,required:true,validType:'length[6,10]'" style="width:100%;display:none;">
                </div>
                <div style="margin-bottom:10px" style="display:none">
                    <label for="uspass2">Reingrese contraseña</label>
                    <input name="uspass2" id="uspass2" class="easyui-textbox" type="password" required="required" data-options="validateOnCreate:true" validType="equals['#uspass']" style="width:100%;display:none;">
                </div>
                <div style="margin-bottom:20px" style="display:none">
                    <button class="easyui-linkbutton c6" id="enviar" iconCls="icon-ok"> Registrarme</button>

                    <button class="easyui-linkbutton" id="reset" type="reset">- Limpiar -</button>

                </div>
            </form>
    </div>

    <?php include_once "../../util/Estructura/footer.php"; ?>

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
        $(function() {
            $("#enviar").click(function() {
                var url = "acc_alta_user.php"; // El script a dónde se realizará la petición.
                $.ajax({
                    type: "POST",
                    url: url,
                    onSubmit: function() {
                        alert("hola")
                        return $(this).form('validate');
                    },
                    success: function(result) {
                        var result = eval('(' + result + ')');
                        alert(result)
                        if (!result.respuesta) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }
                });

               // return false; // Evitar ejecutar el submit del formulario.
            });
        });



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
    </script>

</body>

</html>