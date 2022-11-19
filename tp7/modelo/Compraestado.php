<?php

class Compraestado{

    private $idcompraestado;
    private $objcompra;
    private $objcompraestadotipo;
    private $cefechaini;
    private $cefechafin;
    private $mensajeOperacion;

    //metodo construct

    public function __construct(){
        $this->idcompraestado = "";
        $this->objcompra = new Compra();
        $this->objcompraestadotipo = new Compraestadotipo();
        $this->cefechaini = NULL;
        $this->cefechafin = NULL;
    }

    // funcion setear

    public function setear($idcompraestado,$objcompra,$objcompraestadotipo,$cefechaini,$cefechafin){
        $this->setidcompraestado($idcompraestado);
        $this->setobjcompra($objcompra);
        $this->setobjcompraestadotipo($objcompraestadotipo);
        $this->setcefechaini($cefechaini);
        $this->setcefechafin($cefechafin);
    }

    // Funciones Get y SEt

    public function getidcompraestado(){
        return $this->idcompraestado;
    }
    public function setidcompraestado($reemplazo){
        $this->idcompraestado = $reemplazo;
    }
    public function getobjcompra(){
        return $this->objcompra;
    }
    public function setobjcompra($reemplazo){
        $this->objcompra = $reemplazo;
    }
    public function getobjcompraestadotipo(){
        return $this->objcompraestadotipo;
    }
    public function setobjcompraestadotipo($reemplazo){
        $this->objcompraestadotipo = $reemplazo;
    }
    public function getcefechaini(){
        return $this->cefechaini;
    }
    public function setcefechaini($reemplazo){
        $this->cefechaini = $reemplazo;
    }
    public function getcefechafin(){
        return $this->cefechafin;
    }
    public function setcefechafin($reemplazo){
        $this->cefechafin = $reemplazo;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($reemplazo){
        $this->mensajeOperacion = $reemplazo;
    }
    
    // Las 4 Funciones

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestado WHERE idcompraestado = ".$this->getidcompraestado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $obCompra = new Compra();
                    $obCompra->setidcompra($row['idcompra']);
                    $obCompra->cargar();

                    $obComEstTip = new Compraestadotipo();
                    $obComEstTip->setidcompraestadotipo($row['idcompraestadotipo']);
                    $obComEstTip->cargar();

                    $this->setear($row['idcompraestado'], $obCompra, $obComEstTip, $row['cefechaini'], $row['cefechafin']);
                }
            }
        } else {
            $this->setMensajeOperacion("Compraestado->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO compraestado (`idcompra`, `idcompraestadotipo`)  VALUES(".$this->getobjcompra()->getidcompra().",".$this->getobjcompraestadotipo()->getidcompraestadotipo().");";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraestado($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE `compraestado` SET `idcompra`=".$this->getobjcompra()->getidcompra().",`idcompraestadotipo`=".$this->getobjcompraestadotipo()->getidcompraestadotipo().",`cefechafin`='".$this->getcefechafin()."' WHERE `idcompraestado`=".$this->getidcompraestado().";";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraestado WHERE idcompraestado=".$this->getidcompraestado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestado ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obComEs= new Compraestado();

                    $obCom = new Compra();
                    $obCom->setIdCompra($row['idcompra']);
                    $obCom->cargar();

                    $obComEsTi = new Compraestadotipo();
                    $obComEsTi->setidcompraestadotipo($row['idcompraestadotipo']);
                    $obComEsTi->cargar();

                    $obComEs->setear($row['idcompraestado'], $obCom, $obComEsTi, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obComEs);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("Producto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

}
?>