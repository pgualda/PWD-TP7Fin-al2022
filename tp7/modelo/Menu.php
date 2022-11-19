<?php

class Menu{

    private $idmenu;
    private $menombre;
    private $medescripcion;
    private $idpadre;
    private $medeshabilitado;
    private $meurl;
    private $sinrolrequerido;
    private $mensajeOperacion;

    //metodo construct

    public function __construct(){
        $this->idmenu = "";
        $this->menombre = "";
        $this->medescripcion = "";
        $this->idpadre = "";
        $this->meurl ="";
        $this->medeshabilitado = NULL;
        $this->sinrolrequerido = "";
    }

    //funcion setear

    public function setear($idmenu,$menombre,$medescripcion,$idpadre,$medeshabilitado,$meurl,$sinrolrequerido){
        $this->setidmenu($idmenu);
        $this->setmenombre($menombre);
        $this->setmedescripcion($medescripcion);
        $this->setidpadre($idpadre);
        $this->setmedeshabilitado($medeshabilitado);
        $this->setmeurl($meurl);
        $this->setsinrolrequerido($sinrolrequerido);
    }

    // Funciones Get y SEt

    public function getidmenu(){
        return $this->idmenu;
    }
    public function setidmenu($reemplazo){
        $this->idmenu = $reemplazo;
    }
    public function getmenombre(){
        return $this->menombre;
    }
    public function setmenombre($reemplazo){
        $this->menombre = $reemplazo;
    }
    public function getmedescripcion(){
        return $this->medescripcion;
    }
    public function setmedescripcion($reemplazo){
        $this->medescripcion = $reemplazo;
    }
    public function getidpadre(){
        return $this->idpadre;
    }
    public function setidpadre($reemplazo){
        $this->idpadre = $reemplazo;
    }  //--------------------------------------
    public function getmedeshabilitado(){
        return $this->medeshabilitado;
    }
    public function setmedeshabilitado($reemplazo){
        $this->medeshabilitado = $reemplazo;
    }  //-------------------------------------------
    public function getmeurl(){
        return $this->meurl;
    }
    public function setmeurl($reemplazo){
        $this->meurl = $reemplazo;
    }  //-------------------------------------------
    public function getsinrolrequerido(){
        return $this->sinrolrequerido;
    }
    public function setsinrolrequerido($reemplazo){
        $this->sinrolrequerido = $reemplazo;
    }
    //--------------------------------------
    public function setMensajeOperacion($reemplazo){
        $this->mensajeOperacion = $reemplazo;
    }
    
    // Las 4 funciones

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM menu WHERE idmenu = ".$this->getidmenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'],$row['idpadre'], $row['medeshabilitado'],$row['meurl'],$row['sinrolrequerido']);
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO `menu` (`menombre`, `medescripcion`, `idpadre`, `medeshabilitado`,'meurl','sinrolrequerido')  VALUES('".$this->getmenombre()."','".$this->getmedescripcion()."','".$this->getidpadre()."','".$this->getmedeshabilitado()."','".$this->getmeurl()."','".$this->getsinrolrequerido()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setidmenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE menu SET `menombre`='".$this->getmenombre()."',`medescripcion`=".$this->getmedescripcion()."',`idpadre`='". $this->getidpadre() ."',`medeshabilitado`='". $this->getmedeshabilitado() ."',`meurl`='". $this->getmeurl()."','sinrolrequerido'=".$this->getsinrolrequerido()."' WHERE idmenu=".$this->getidmenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM menu WHERE idmenu=".$this->getidmenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $OBJ= new Menu();
                    $OBJ->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['medeshabilitado'],$row['meurl'],$row['sinrolrequerido']);
                    array_push($arreglo, $OBJ);
                }
            }
        } else {
            self::setMensajeOperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $arreglo;
    }

}
?>