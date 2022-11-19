<?php
class Rol {

private $idrol, $rodescrion, $mensajeoperacion;


public function __construct(){
    $this->idrol= "";
    $this->rodescripcion = "";
}

public function setear($idrol,$rodescripcion){	
    $this->setidrol($idrol);
    $this->setrodescripcion($rodescripcion);
}

    /* Getters & Setters */
    public function setidrol($idrol){
        $this->idrol=$idrol;
    }
    public function getidrol(){
        return $this->idrol;
    }   
    public function setrodescripcion($rodescripcion){
        $this->rodescripcion=$rodescripcion;
    }
    public function getrodescripcion(){
        return $this->rodescripcion;
    }
    public function getmensajeoperacion(){
        return $this->mensajeoperacion; 
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }
    
    /* Metodos */
    public function buscar($idrol){
        $resp = false;
        $base= new BaseDatos();
        $sql="SELECT * FROM rol WHERE idrol=".$idrol;
        if($base->Iniciar()){
            if($base->Ejecutar($sql)){
                if($row = $base->Registro()){
                    $this->setear($row['idrol'], $row['rodescripcion']);
                    $resp = true;
                }
            }else {
                $this->setmensajeoperacion("Tabla->buscar: ".$base->getError());
            }
        }else{
            $this->setmensajeoperacion("Tabla->buscar: ".$base->getError());
        }
        return $resp;
    }

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM rol WHERE idrol = ".$this->getidrol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);                       
                }
            }
        } else {
            $this->setmensajeoperacion("persona->cargar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM rol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new Rol();
                    $obj->setear($row['idrol'], $row['rodescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("persona->listar: ".$base->getError());
        }
    
        return $arreglo;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO rol(rodescripcion) VALUES ('".$this->getrodescripcion()."')";
        if ($base->Iniciar()) {
            if ($idrol=$base->Ejecutar($sql)) {
               $this->setidrol($idrol);
               $resp = true;
            } else {
                $this->setmensajeoperacion("rol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->insertar: ".$base->getError());
        }
        return $resp;
    }    
        
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE rol SET rodescripcion='".$this->getrodescripcion()."' WHERE idrol=".$this->getidrol();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("rol->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM rol WHERE idrol=".$this->getidrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("rol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public function __toString(){
        return "idrol: ". $this->getidrol()."\trol descrip: ".$this->getrodescripcion();
    }
    
}


?>