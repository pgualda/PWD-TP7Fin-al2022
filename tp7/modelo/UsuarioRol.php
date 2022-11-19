<?php

class UsuarioRol{
    
    //atributos
    
    private $OBJUsuario;
    private $OBJRol;
    private $mensajeoperacion;
    
    //metodo construct
    
    public function __construct() {
        $this->OBJUsuario = "";
        $this->OBJRol = "";
    }
    
    //funcion de setear
    
    public function setear ($OBJUsuario, $OBJRol){
        $this->setOBJUsuario ($OBJUsuario);
        $this->setOBJRol ($OBJRol);
    }
    
    //funciones de get y set
    
    public function getOBJUsuario() {
        return $this->OBJUsuario;
    }

    public function getOBJRol() {
        return $this->OBJRol;
    }

    public function getMensajeOperacion() {
        return $this->mensajeoperacion;
    }

    public function setOBJUsuario($OBJUsuario) {
        $this->OBJUsuario = $OBJUsuario;
    }

    public function setOBJRol($OBJRol) {
        $this->OBJRol = $OBJRol;
    }

    public function setMensajeOperacion($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    
    //funciones de cargar, insertar, modificar, eliminar y listar
    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM usuariorol WHERE idusuario = ".$this->getOBJUsuario()->getidusuario()." AND idrol = ".$this->getOBJRol()->getidrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $OBJUsuario = new Usuario();
                    $OBJUsuario->setidusuario($row['idusuario']);
                    $OBJUsuario->cargar();
                    $OBJRol = new Rol();
                    $OBJRol->setidrol($row['idrol']);
                    $OBJRol->cargar();
                    $this->setear($OBJUsuario, $OBJRol);
                }
            }
        } else {
            $this->setmensajeoperacion("Usuariorol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO `usuariorol` (`idusuario`, `idrol`)  VALUES(".$this->getOBJUsuario()->getidusuario().",".$this->getOBJRol()->getidrol().");";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuariorol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuariorol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        // a los efectos de compatibilidad, o alta o baja
        return false;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM usuariorol WHERE idusuario=".$this->getOBJUsuario()->getidusuario()." AND idrol =".$this->getOBJRol()->getidrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Usuariorol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuariorol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public function buscar($idusuario,$idrol){
        $resp = false;
        $base= new BaseDatos();
        $sql="SELECT * FROM usuariorol WHERE idusuario=".$idusuario." && idrol=".$idrol; 
        if($base->Iniciar()){
            if($base->Ejecutar($sql)){
                if($row = $base->Registro()){
                    $OBJUsuario=new Usuario;
                    $OBJUsuario->setidusuario($row['idusuario']);
                    $OBJUsuario->cargar();                    
                    $OBJRol=new Rol;
                    $OBJRol->setidrol($row['idrol']);
                    $OBJRol->cargar();                    

                    $this->setear($OBJUsuario,$OBJRol);
                    $resp = true;
                }
            }else {
                $this->setmensajeoperacion("usuariorol->buscar: ".$base->getError());
            }
        }else{
            $this->setmensajeoperacion("usuariorol->buscar: ".$base->getError());
        }
        return $resp;
    }


    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM usuariorol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new UsuarioRol();
                    $objUsuario = new Usuario();
                    $objUsuario->setidusuario($row['idusuario']);
                    $objUsuario->cargar();
                    $objRol = new Rol();
                    $objRol->setidrol($row['idrol']);
                    $objRol->cargar();
                    $obj->setear($objUsuario, $objRol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("Usuariorol->listar: ".$base->getError());
        }
        return $arreglo;
    }

}