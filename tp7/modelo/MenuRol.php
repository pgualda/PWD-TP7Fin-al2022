<?php

class MenuRol{
    
    //atributos
    
    private $OBJMenu;
    private $OBJRol;
    private $mensajeOperacion;
    
    //metodo construct
    
    public function __construct() {
        $this->OBJMenu = new Menu();
        $this->OBJRol = new Rol();
    }
    
    //funcion de setear
    
    public function setear ($OBJMenu, $OBJRol){
        $this->setOBJMenu ($OBJMenu);
        $this->setOBJRol ($OBJRol);
    }
    
    //funciones de get y set
    
    public function getOBJMenu() {
        return $this->OBJMenu;
    }

    public function getOBJRol() {
        return $this->OBJRol;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setOBJMenu($OBJMenu) {
        $this->OBJMenu = $OBJMenu;
    }

    public function setOBJRol($OBJRol) {
        $this->OBJRol = $OBJRol;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    
    //funciones de cargar, insertar, modificar, eliminar y listar
    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM menurol WHERE idmenu = ".$this->getOBJMenu()->getidmenu()." AND idrol = ".$this->getOBJRol()->getidrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $OBJMen = new Menu();
                    $OBJMen->setidmenu($row['idmenu']);
                    $OBJMen->cargar();
                    $OBJRol = new Rol();
                    $OBJRol->setidrol($row['idrol']);
                    $OBJRol->cargar();
                    $this->setear($OBJMen, $OBJRol);
                }
            }
        } else {
            $this->setmensajeoperacion("Menurol->listar: ".$base->getError());
        }
        return $resp;
    
        
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO `menurol` (`idmenu`, `idrol`)  VALUES(".$this->getOBJMenu()->getidmenu().",".$this->getOBJRol()->getidrol().");";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Menurol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menurol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        /* $base=new BaseDatos();
        $sql="UPDATE Menurol SET `idusuario`=".$this->getOBJUsuario().",`idrol`=".$this->getOBJRol()." WHERE idusuario=".$this->getOBJUsuario()." AND idrol=".$this->getOBJRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Menurol->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menurol->modificar: ".$base->getError());
        } */
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM menurol WHERE idmenu=".$this->getOBJMenu()->getidmenu()." AND idrol =".$this->getOBJRol()->getidrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Menurol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menurol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM menurol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $OBJ= new MenuRol();
                    $OBJUsuario = new Menu();
                    $OBJUsuario->setidmenu($row['idmenu']);
                    $OBJUsuario->cargar();
                    $OBJRol = new Rol();
                    $OBJRol->setidrol($row['idrol']);
                    $OBJRol->cargar();
                    $OBJ->setear($OBJUsuario, $OBJRol);
                    array_push($arreglo, $OBJ);
                }
               
            }
            
        } else {
            self::setmensajeoperacion("Menurol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
    
    
}

?>