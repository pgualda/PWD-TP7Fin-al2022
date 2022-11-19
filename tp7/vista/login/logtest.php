<?php
/**
 * Created by JetBrains PhpStorm.
 * User: GAA
 * Date: 9/26/12
 * Time: 3:59 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php
    session_start();
    if(isset($_SESSION["userlogin"])){
        session_unset();
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php include_once "../../util/Estructura/header.php"; ?>

   <script type="text/javascript">

        function checklogin(){
            $('#fm').form('submit',{
                url: 'verlogin.php',
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.success){
                        window.location = "../inicio/index.php";
                    } else {
                        $.messager.alert('Error',result.msg,'error');
                        $('#fm').form('clear');
                    }
                }
            });
        }

    </script>
</head>

<div id="d2" class="easyui-dialog" title="Login Sale management system" style="width:400px;height:200px;padding:10px"
     data-options="buttons:'#dlg-buttons',resizable:false,align:'center',iconCls:'icon-user-lock',draggable:false">
    <form id="fm" method="post" novalidate>
        <table>
            <tr>
                <td>
                    <img src="images/usercomputer.png" width="100"/>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                User name
                            </td>
                            <td>
                                <input class="easyui-validatebox" type="text" name="username" data-options="required:true" style="width:150px;"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Password
                            </td>
                            <td>
                                <input class="easyui-validatebox" type="password" name="password" data-options="required:true" style="width:150px;"></input>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" onclick="checklogin()">Login</a>
    <a href="#" class="easyui-linkbutton" onclick="javascript:$('#d2').dialog('close')">Close</a>
</div>

</body>
</html>