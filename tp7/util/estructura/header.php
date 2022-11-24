<!doctype html>
<html lang="es">
<head>
  <title>Menu</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <!--  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
  <link rel="stylesheet" type="text/css" href="../../util/jquery-easyui-1.10.8/themes/black/easyui.css">
  <link rel="stylesheet" type="text/css" href="../../util/jquery-easyui-1.10.8/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="../../util/jquery-easyui-1.10.8/themes/color.css">
  <link rel="stylesheet" type="text/css" href="../../util/jquery-easyui-1.10.8/demo/demo.css">
  <script type="text/javascript" src="../../util/jquery-easyui-1.10.8/jquery.min.js"></script>
  <script type="text/javascript" src="../../util/jquery-easyui-1.10.8/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="../../util/js/core.js"></script>
  <script type="text/javascript" src="../../util/js/md5.js"></script>
	<style>
		body{
			background-color: #cccccc;
		}
	</style>

</head>
<body>

<!-- crea entorno para saber donde levantar las clases etc -->
<?php
	include_once('../../configuracion.php');
	$OBJSession=new CTRLSession;
//	if ( !$OBJSession->puedoentrar(__FILE__) ) {
//		echo "me rebota en el header";
//		$mensaje ="Esta opcion ".__FILE__." requiere permisos, logeese para acceder";
//		echo("<script>location.href = '../login/login.php?msg=".$mensaje."';</script>");
//	}
?>

<!-- para ver otros elementos posibilidades etc ver ej en demo/menubotton/nav.html -->
<header>
	<?php
		echo '<div class="easyui-panel" style="padding:5px;">';
		echo '<a id="btn-home" href="../home/index.php" class="easyui-linkbutton c3" style="margin:3px;padding:3px;">FERRETERIA MAYORISTA</a>';

		$OBJMenu=new CTRLMenu;
        $OBJMenuRol=new CTRLMenuRol;

		$arreglomenu=$OBJMenu->buscar(["medeshabilitado"=>"null"]);
		$arreglomenuok=[];  
		foreach($arreglomenu as $OBJunmenu) {

            // si la opcion no requiere  rol la mando nomas -busco x idmenu en menurol-

			if ($OBJunmenu->getsinrolrequerido() != null) { //   } && $OBJMenuRol->buscar(["idmenu"=>$OBJunmenu->getidmenu()]) ==null) {
				array_push($arreglomenuok, $OBJunmenu);
			} else {
                // si hay rol activo y la opcion aparece
				if ($OBJSession->getRol() != null  && $OBJMenuRol->buscar(["idmenu"=>$OBJunmenu->getidmenu(),"idrol"=>$OBJSession->getRol()]) != NULL ) { 
					// o sea esta esa opcion de menu para ese rol
	                array_push($arreglomenuok, $OBJunmenu);
				}
			}
		}

        // listo tenemos los items activos ahora los mostramos segun nivles
        // filtra primero idpadre=NULL			
		foreach($arreglomenuok as $OBJunmenu) {

            if ( $OBJunmenu->getobjmenu() ==NULL ) {
				$url="#";
				if ($OBJunmenu->getmeurl() != NULL) {
					$url=$OBJunmenu->getmeurl();
				}
			   	echo "<a href='".$url."' class='easyui-menubutton c2' style='margin:3px;padding:3px;' data-options='menu:".'"#mm'.$OBJunmenu->getidmenu().'"'."'>".$OBJunmenu->getmenombre()."</a>";
			} 
		}  

		if($OBJSession->validar()){
			echo "<a class='easyui-linkbutton c2' id='btn-cerrar' href='../login/logout.php' style='margin:3px;padding:3px;float:right'>Cerrar sesion</a>";
		}

		echo "</div>"; // cerramos el div de las principales, siguen los hijos

        // barre de nuevo, cuando encuentra sin padre, hace un nuevo foreach SOLO de ese
		foreach($arreglomenuok as $OBJunmenu) {

			if ($OBJunmenu->getobjmenu()== NULL) {

 				echo "<div id='mm".$OBJunmenu->getidmenu()."' style='width:150px;'>";
				foreach($arreglomenuok as $OBJunmenuhijo) {

					if ($OBJunmenuhijo->getobjmenu() != NULL) {
						if ($OBJunmenuhijo->getobjmenu()->getidmenu() == $OBJunmenu->getidmenu()) {

							// la hora de inflar los nenes                   
	     				    $url="#";
	//						var_dump($OBJunmenuhijo);
							if ($OBJunmenuhijo->getmeurl() != null) {
								$url=$OBJunmenuhijo->getmeurl();
							}
							echo "	<div>";
							echo "<a href='".$url."' class='easyui-menubutton'
							      style='margin:3px;padding:3px; text-decoration:none;'
								  >".$OBJunmenuhijo->getmenombre()."</a>";
	// funcionando pero link comun						echo "      <a href='" . $url ."'>".$OBJunmenuhijo->getmenombre()."</a>";
							echo "	</div>";
						}	
					}	
				}
				echo "</div>"; // cierra el div dentro del padre
			} 
		}  
	?>
    <!-- el js x supuesto habria q separala en un punto .js -->
	<script type="text/javascript">
		(function($){
			function getParentMenu(rootMenu, menu){
				return findParent(rootMenu);

				function findParent(pmenu){
					var p = undefined;
					$(pmenu).find('.menu-item').each(function(){
						if (!p && this.submenu){
							if ($(this.submenu)[0] == $(menu)[0]){
								p = pmenu;
							} else {
								p = findParent(this.submenu);
							}
						}
					});
					return p;
				}
			}
			function getParentItem(pmenu, menu){
				var item = undefined;
				$(pmenu).find('.menu-item').each(function(){
					if ($(this.submenu)[0] == $(menu)[0]){
						item = $(this);
						return false;
					}
				});
				return item;
			}

			$.extend($.fn.menubutton.methods, {
				enableNav: function(enabled){
					var curr;
					$(document).unbind('.menubutton');
					if (enabled == undefined){enabled = true;}
					if (enabled){
						$(document).bind('keydown.menubutton', function(e){
							var currButton = $(this).find('.m-btn-active,.m-btn-plain-active,.l-btn:focus');
							if (!currButton.length){
								return;
							}

							if (!curr || curr.button != currButton[0]){
								curr = {
									menu: currButton.data('menubutton') ? $(currButton.menubutton('options').menu) : $(),
									button: currButton[0]
								};
							}
							var item = curr.menu.find('.menu-active');

							switch(e.keyCode){
								case 13:  // enter
									item.trigger('click');
									break;
								case 27:  // esc
									currButton.trigger('mouseleave');
									break;
								case 38:  // up
									var prev = !item.length ? curr.menu.find('.menu-item:last') : item.prevAll('.menu-item:first');
									prev.trigger('mouseenter');
									return false;
								case 40:  // down
									var next = !item.length ? curr.menu.find('.menu-item:first') : item.nextAll('.menu-item:first');
									next.trigger('mouseenter');
									return false;
								case 37:  // left
									var pmenu = getParentMenu(currButton.data('menubutton') ? $(currButton.menubutton('options').menu) : $(), curr.menu);
									if (pmenu){
										item.trigger('mouseleave');
										var pitem = getParentItem(pmenu, curr.menu);
										if (pitem){
											pitem.trigger('mouseenter');
										}
										curr.menu = pmenu;
									} else {
										var prev = currButton.prevAll('.l-btn:first');
										if (prev.length){
											currButton.trigger('mouseleave');
											prev.focus();
										}
									}
									return false;
								case 39:  // right
									if (item.length && item[0].submenu){
										curr.menu = $(item[0].submenu);
										curr.button = currButton[0];
										curr.menu.find('.menu-item:first').trigger('mouseenter');
									} else {
										var next = currButton.nextAll('.l-btn:first');
										if (next.length){
											currButton.trigger('mouseleave');
											next.focus();
										}
									}
									return false;
							}
						});						
					}
				}
			});
		})(jQuery);

		$(function(){
			$.fn.menubutton.methods.enableNav();
			$(document).keydown(function(e){
				if (e.altKey && e.keyCode == 87){
					$('#btn-home').focus();
				}
			})
		});
	</script>
</header>

</body>

</html>
