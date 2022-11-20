<?php
class CTRLSession{ 

    public function __construct(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
           session_start();
        }
    }
    
    public function iniciar($usnombre,$uspass) {
       $resp=FALSE;
       $OBJUsuario=new Usuario;
       $arreglo=$OBJUsuario->listar("usnombre ='".$usnombre."' AND uspass='".$uspass."' AND ISNULL(usdeshabilitado)");
       foreach ($arreglo as $OBJunusuario) {
          $_SESSION["usnombre"]=$usnombre;
          $_SESSION["idusuario"]=$OBJunusuario->getidusuario();
          $_SESSION["rolactivo"]=null; // levanta con null el rol / sin rol - 

          // levanta el rol
          $OBJUsuarioRol=new UsuarioRol();
          if ($arreglo2=$OBJUsuarioRol->listar("idusuario='".$OBJunusuario->getidusuario()."'")) { 
             $OBJunusuariorol=$arreglo2[0];
             $_SESSION["rolactivo"]=$OBJunusuariorol->getOBJRol()->getidrol(); // levanta el primero
          }  
          $resp=TRUE; // login oka
       }
       return $resp;
    }

    // si la session tiene usuario correcto (x ende password sino no podria haber entrado)
    public function validar() {
        $resp = FALSE;
        if ( isset($_SESSION["usnombre"])) {
           $resp=TRUE;
        }
        return $resp;
    }

    public function activa() {
		$resp=false;
		if (session_status()=== PHP_SESSION_ACTIVE) {
			$resp=true;
		}
		return $resp;
    }

    public function getUsuario(){
        return $_SESSION['usnombre'];
    }
    public function getidUsuario(){
        return $_SESSION['idusuario'];
    }

    public function getRol(){
        $resp=null;
        if (isset($_SESSION['rolactivo'])) {
            $resp=$_SESSION['rolactivo']; 
        }
        return $resp;
    }

    public function setRol($idrol){
        $resp=null;
        if (isset($idrol)) {
            $_SESSION['rolactivo']=$idrol; 
        }
        return $resp;
    }

    public function cerrar(){
		if ($this->activa()) {
        	session_unset();
            session_destroy();
		}
	}

    public function puedoentrar($desdedonde) {

        // primero levantamos el rol
        //$objsession=new CTRLSession();
        //despues el nombre de archivo con el directorio
        $archivo=$desdedonde;
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
        // verifica solo si tiene rol
        $ok=false;
  //      echo "a ver q tengo,".$archivo." x ahora en false:".$idmenu." sin rol ".$sinrol. "rol activo".$this->getRol()."<br>";
        if ($sinrol != null) {
//            echo "valido sin rol";
            $ok=true;
        } else {
            // ya tenemos la id del menu ahora vamos a ver si dentro de los roles que tiene esta el activo o es rolless
            $objmenurol=new Menurol();
            if ($this->getRol() != null  && $objmenurol->listar("idmenu='".$idmenu."' and idrol='".$this->getRol()."'") != NULL ) { 
//                echo "valido con rol";
                $ok=true;
            }
        }
        // despues return x ahora echo
         return $ok;
    }         
}
?>