<?php

class Compra{

    //atributos 

    private $idcompra;
    private $cofecha;
    private $objusuario;
    private $mensajeOperacion;

    //metodo construct

    public function __construct() {
        $this->idcompra = "";
        $this->cofecha = NULL;
        $this->objusuario = new Usuario();
    }

    //funcion de setear

    public function setear ($idcompra,$cofecha,$objusuario){
        $this->setidcompra($idcompra);
        $this->setcofecha($cofecha);
        $this->setobjusuario($objusuario);
    }

    //funciones de get y set 

    public function getidcompra(){
        return $this->idcompra;
    }
    public function setidcompra($reemplazo){
        $this->idcompra = $reemplazo;
    }
    public function getcofecha(){
        return $this->cofecha;
    }
    public function setcofecha($reemplazo){
        $this->cofecha = $reemplazo;
    }
    public function getobjusuario(){
        return $this->objusuario;
    }
    public function setobjusuario($reemplazo){
        $this->objusuario = $reemplazo;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //funciones de cargar, insertar, modificar, eliminar y listar
    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compra WHERE idcompra = ".$this->getidcompra();
        
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objusuario = new Usuario();
                    $objusuario->setIdUsuario($row['idusuario']);
                    $objusuario->cargar();
                    //echo "<br>estoy en cargar es tru o fal<br>";
                    //var_dump($objusuario);

                    $this->setear($row['idcompra'], $row['cofecha'],$objusuario);
                }
            }
        } else {
            $this->setMensajeOperacion("Compra->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        // cofecha se genera fecha automatico por lo cual no hay que insertar
        $sql="INSERT INTO compra (`idusuario`)  VALUES(".$this->getobjusuario()->getidusuario().");";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompra($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compra->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE compra SET `idcompra`=`".$this->getidcompra()."`,`cofecha`=`".$this->getcofecha()."`,`idusuario`=`".$this->getobjusuario()->getIdUsuario()."` WHERE `idcompra`=`".$this->getidcompra()."`";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compra->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM `compra` WHERE idcompra=".$this->getidcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Compra->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compra ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Compra();
                    $objUser = new Usuario();
                    $objUser->setIdUsuario($row['idusuario']);
                    $objUser->cargar();
                    $obj->setear($row['idcompra'], $row['cofecha'], $objUser);

                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("Tabla->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


}
?>