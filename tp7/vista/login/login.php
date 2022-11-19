<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FERRETERIA MAYORISTA</title>
</head>

<body>
    <?php include_once "../../util/Estructura/header.php"; ?>
    <?php
    $datos = data_submitted();
    if (isset($datos['msg'])) {
        echo "<p>" . $datos['msg'] . "</p><br>";
    }
    ?>

    <div class="easyui-panel" title="Login" style="width:300px;padding:10px;">

        <form id="login" method="post" name="login" action="verlogin.php">
            <!-- enctype="multipart/form-data"> -->
            <table>
                <tr>
                    <td>Usuario:</td>
                    <td><input id="usnombre" name="usnombre" autofocus></input></td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td><input id="uspass" type="password" name="uspass"></input></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="ok" type="button" class="" value="Validar" onclick="formSubmit()">
<!--                         <input id="okoculto" type="submit" hidden></input> -->
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php include_once "../../util/Estructura/footer.php"; ?>

    <script type="text/javascript">




        function formSubmit() {
            document.getElementById("uspass").value = CryptoJS.MD5(document.getElementById("uspass").value).toString();
            document.getElementById("login").submit();
        }

        // Make sure this code gets executed after the DOM is loaded.
        document.addEventListener("keyup", event => {
            if (event.key !== "Enter") return; // Use `.key` instead.
            document.getElementById("ok").click(); // Things you want to do.
            event.preventDefault(); // No need to `return false;`.
        });

    </script>

</body>

</html>