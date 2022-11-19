<?php
class Usuario{

private $idusuario,$usnombre,$uspass,$usmail,$usdeshabilitado, $mensajeoperacion;

public function __construct(){
    $this->idusuario= "";
    $this->usnombre= "";
    $this->uspass= "";
    $this->usmail= "";
    $this->usdeshabilitado= "";
    $this->mensajeoperacion = "";
}

public function setear($idusuario,$usnombre,$uspass,$usmail,$usdeshabilitado){	
    $this->setidusuario($idusuario);
    $this->setusnombre($usnombre);
    $this->setuspass($uspass);
    $this->setusmail($usmail);
    $this->setusdeshabilitado($usdeshabilitado);
}

    /* Getters & Setters */
    public function setidusuario($idusuario){
        $this->idusuario=$idusuario;
    }
    public function getidusuario(){
        return $this->idusuario;
    }   
    public function setusnombre($usnombre){
        $this->usnombre=$usnombre;
    }
    public function getusnombre(){
        return $this->usnombre;
    }   

    public function setuspass($uspass){
        $this->uspass=$uspass;
    }
    public function getuspass(){
        return $this->uspass;
    }

    public function setusmail($usmail){
        $this->usmail=$usmail;
    }
    public function getusmail(){
        return $this->usmail;
    }   
    public function setusdeshabilitado($usdeshabilitado){
        $this->usdeshabilitado=$usdeshabilitado;
    }
    public function getusdeshabilitado(){
        return $this->usdeshabilitado;
    }   
    public function getmensajeoperacion(){
        return $this->mensajeoperacion; 
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }
    
    /* Metodos */
    public function buscar($idusuario){
        $resp = false;
        $base= new BaseDatos();
        $sql="SELECT * FROM usuario WHERE idusuario=".$idusuario;
        if($base->Iniciar()){
            if($base->Ejecutar($sql)){
                if($row = $base->Registro()){
                    $this->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    $resp = true;
                }
            }else {
                $this->setmensajeoperacion("usuario->buscar: ".$base->getError());
            }
        }else{
            $this->setmensajeoperacion("usuario->buscar: ".$base->getError());
        }
        return $resp;
    }

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getidusuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
//                    $OBJUsuariorol=new UsuarioRol; 
//                    $ARRusuariorol=$OBJUsuariorol->listar("idusuario='".$row('idusuario')."'");                    
                    $this->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                }
            }
        } else {
            $this->setmensajeoperacion("usuario->cargar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array(); 
        $base=new BaseDatos();
        $sql="SELECT * FROM usuario ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new usuario();
                    $obj->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("usuario->listar: ".$base->getError());
        }
    
        return $arreglo;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();

        $sql="INSERT INTO usuario(usnombre,uspass,usmail,usdeshabilitado) VALUES ('".$this->getusnombre()."','".$this->getuspass()."','".$this->getusmail()."','".$this->getusdeshabilitado()."')";
        if ($elid=$base->Ejecutar($sql)) {
            $this->setidusuario($elid);
            $resp = true;
        } else {
            $this->setmensajeoperacion("usuario->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE usuario SET usnombre='".$this->getusnombre()."',uspass='".$this->getuspass()."',usmail='".$this->getusmail()."',usdeshabilitado=". $this->getusdeshabilitado()." WHERE idusuario=".$this->getidusuario().";";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM usuario WHERE idusuario=".$this->getidusuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("persona->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("persona->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public function __toString(){
        return "nombre: ".$this->getusnombre()."\tidusuario: ". $this->getidusuario();
    }
}

?>