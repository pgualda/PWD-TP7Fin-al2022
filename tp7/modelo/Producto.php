<?php

class Producto{

    //atributos 

    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $mensajeOperacion;

    //metodo construct

    public function __construct() {
        $this->idproducto = "";
        $this->pronombre = "";
        $this->prodetalle = "";
        $this->procantstock = "";
    }

    //funcion setear

    public function setear ($idproducto,$pronombre,$prodetalle,$procantstock){
        $this->setidproducto($idproducto);
        $this->setpronombre($pronombre);
        $this->setprodetalle($prodetalle);
        $this->setprocantstock($procantstock);
    }

    // Funciones Get y SEt

    public function getidproducto(){
        return $this->idproducto;
    }
    public function setidproducto($reemplazo){
        $this->idproducto = $reemplazo;
    }
    public function getpronombre(){
        return $this->pronombre;
    }
    public function setpronombre($reemplazo){
        $this->pronombre = $reemplazo;
    }
    public function getprodetalle(){
        return $this->prodetalle;
    }
    public function setprodetalle($reemplazo){
        $this->prodetalle = $reemplazo;
    }
    public function getprocantstock(){
        return $this->procantstock;
    }
    public function setprocantstock($reemplazo){
        $this->procantstock = $reemplazo;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($reemplazo){
        $this->mensajeOperacion = $reemplazo;
    }
    

    // Las 4 funciones

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM producto WHERE idproducto = ".$this->getidproducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                }
            }
        } else {
            $this->setMensajeOperacion("Producto->listar: ".$base->getError());
        }
        return $resp;
    }    

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
//        $sql="INSERT INTO rol(rodescripcion) VALUES ('".$this->getrodescripcion()."')";
        $sql="INSERT INTO producto(pronombre, prodetalle, procantstock)  VALUES('".$this->getpronombre()."','".$this->getprodetalle()."','".$this->getprocantstock()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidproducto($elid);
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
        $sql="UPDATE producto SET pronombre='".$this->getpronombre()."',prodetalle='".$this->getprodetalle()."',procantstock='".$this->getprocantstock()."' WHERE idproducto=".$this->getidproducto();
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
        $sql="DELETE FROM producto WHERE idproducto=".$this->getidproducto();
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
        $sql="SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("Producto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


}



?>