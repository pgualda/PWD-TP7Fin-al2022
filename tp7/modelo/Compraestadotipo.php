<?php

class Compraestadotipo{

    //atributos 

    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;
    private $mensajeOperacion;

    //metodo construct

    public function __construct(){
        $this->idcompraestadotipo = "";
        $this->cetdescripcion = "";
        $this->cetdetalle = "";
    }

    //funcion setear

    public function setear($idcompraestadotipo,$cetdescripcion,$cetdetalle){
        $this->setidcompraestadotipo($idcompraestadotipo);
        $this->setcetdescripcion($cetdescripcion);
        $this->setcetdetalle($cetdetalle);
    }

    // Funciones Get y SEt

    public function getidcompraestadotipo(){
        return $this->idcompraestadotipo;
    }
    public function setidcompraestadotipo($reemplazo){
        $this->idcompraestadotipo = $reemplazo;
    }
    public function getcetdescripcion(){
        return $this->cetdescripcion;
    }
    public function setcetdescripcion($reemplazo){
        $this->cetdescripcion = $reemplazo;
    }
    public function getcetdetalle(){
        return $this->cetdetalle;
    }
    public function setcetdetalle($reemplazo){
        $this->cetdetalle = $reemplazo;
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
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = ".$this->getidcompraestadotipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                }
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO `compraestadotipo` (`cetdescripcion`, `cetdetalle`)  VALUES('".$this->getcetdescripcion()."','".$this->getcetdetalle()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidcompraestadotipo($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE `compraestadotipo` SET `cetdescripcion`=`".$this->getcetdescripcion()."`,`cetdetalle`=`".$this->getcetdetalle()."` WHERE `idcompraestadotipo`=`".$this->getidcompraestadotipo()."`";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraestadotipo WHERE idcompraestadotipo=".$this->getidcompraestadotipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestadotipo->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Compraestadotipo();
                    $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


}
?>