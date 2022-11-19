<?php

class Compraitem{

    // atributo

    private $idCompraitem;
    private $objProducto;
    private $objCompra;
    private $ciCantidad;
    private $mensajeOperacion;

    // metodo construct

    public function __construct(){
        $this->idcompraitem = "";
        $this->objProducto = new Producto();
        $this->objCompra = new Compra();
        $this->cicantidad = "";
    }

    // funcion setear 

    public function setear($idCompraitem,$objProducto,$objCompra,$ciCantidad){
        $this->setIdCompraitem($idCompraitem);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
        $this->setCiCantidad($ciCantidad);
    }

    // funciones get y set

    public function getIdCompraitem(){
        return $this->idCompraitem ;
    }
    public function setIdCompraitem($nuevoParam){
        $this->idCompraitem = $nuevoParam;
    }
    public function getObjProducto(){
        return $this->objProducto ;
    }
    public function setObjProducto($nuevoParam){
        $this->objProducto = $nuevoParam;
    }
    public function getObjCompra(){
        return $this->objCompra ;
    }
    public function setObjCompra($nuevoParam){
        $this->objCompra = $nuevoParam;
    }
    public function getCiCantidad(){
        return $this->ciCantidad ;
    }
    public function setCiCantidad($nuevoParam){
        $this->ciCantidad = $nuevoParam;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion ;
    }
    public function setMensajeOperacion($nuevoParam){
        $this->mensajeOperacion = $nuevoParam;
    }
 
    //funciones de cargar, insertar, modificar, eliminar y listar

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem WHERE idcompraitem = ".$this->getIdCompraitem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $obCompra = new Producto();
                    $obCompra->setIdProducto($row['idproducto']);
                    $obCompra->cargar();

                    $obComEstTip = new Compra();
                    $obComEstTip->setIdCompra($row['idcompra']);
                    $obComEstTip->cargar();

                    $this->setear($row['idcompraitem'], $obCompra, $obComEstTip, $row['cicantidad']);
                }
            }
        } else {
            $this->setMensajeOperacion("Compraitem->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO `compraitem` (`idproducto`, `idcompra`, `cicantidad`)  VALUES('".$this->getObjProducto()->getIdProducto()."','".$this->getObjCompra()->getIdCompra()."','".$this->getCiCantidad()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraitem($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compraitem->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compraitem->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE compraitem SET idproducto='".$this->getObjProducto()->getIdProducto()."',idcompra=".$this->getObjCompra()->getIdCompra().",cicantidad='".$this->getCiCantidad()."' WHERE idcompraitem=".$this->getIdCompraitem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compraitem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compraitem->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraitem WHERE idcompraitem=".$this->getIdCompraitem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Compraitem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compraitem->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obComEs= new Compraitem();

                    $obCom = new Producto();
                    $obCom->setIdProducto($row['idproducto']);
                    $obCom->cargar();

                    $obComEsTi = new Compra();
                    $obComEsTi->setIdCompra($row['idcompra']);
                    $obComEsTi->cargar();

                    $obComEs->setear($row['idcompraitem'], $obCom, $obComEsTi, $row['cicantidad']);
                    array_push($arreglo, $obComEs);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("Compraitem->listar: ".$base->getError());
        }
 
        return $arreglo;
    }    


}