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
}
?>