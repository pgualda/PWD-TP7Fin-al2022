<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FERRETERIA MAYORISTA</title>
</head>
<body>
<?php include_once "../../util/Estructura/header.php"; 
// por ahora llamo la funcion a manopla
// loprimero q pruebo es si es opcion publica tendria q dejarme

// primero levantamos el rol
$objsession=new CTRLSession();

//despues el nombre de archivo con el directorio
$archivo=__FILE__;
$archivo=str_replace("\\","-",$archivo);

// como estamos en el control podemos llamar al modelo
$objmenu=new Menu();
$lista=$objmenu->listar(); // levando todo el menu y macheo inverso

$idmenu=0;
$sinrol=null;
foreach($lista as $objunmenu) {
   $meurl=$objunmenu->getmeurl();
   // reemplaza en los dos lugares todas las barras con -
   $meurl=substr($meurl,3); 
   $meurl=str_replace("/","-",$meurl);
   if ($meurl != null) {
//       echo "not null".$meurl."<br>";
       if (strpos($archivo,$meurl) > 0 ) {
//           echo "encuentra".$meurl."<br>";
            $idmenu=$objunmenu->getidmenu();
            $sinrol=$objunmenu->getsinrolrequerido();  
       }
   }
   //echo $meurl." - ".$archivo." - ".strpos($archivo,$meurl)."<br>";
}
//echo $idmenu;
// verifica solo si tiene rol
$ok=false;
if ($sinrol != null) {
    $ok=true;
} else {
    // ya tenemos la id del menu ahora vamos a ver si dentro de los roles que tiene esta el activo o es rolless
    $objmenurol=new Menurol();
    if ($objsession->getRol() != null  && $objmenurol->listar("idmenu='".$idmenu."' and idrol='".$OBJSession->getRol()."'") != NULL ) { 
       $ok=true;
    }
}
// despues return x ahora echo
echo $ok
?>
