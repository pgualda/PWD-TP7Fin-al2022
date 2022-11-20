<?php

class Menu{

    private $idmenu;
    private $menombre;
    private $medescripcion;
    private $objmenu;
    private $medeshabilitado;
    private $meurl;
    private $sinrolrequerido;
    private $mensajeOperacion;

    //metodo construct

    public function __construct(){
        $this->idmenu = "";
        $this->menombre = "";
        $this->medescripcion = "";
        $this->objmenu = NULL;
        $this->meurl ="";
        $this->medeshabilitado = NULL;
        $this->sinrolrequerido = "";
    }

    //funcion setear

    public function setear($idmenu,$menombre,$medescripcion,$objmenu,$medeshabilitado,$meurl,$sinrolrequerido){
        $this->setidmenu($idmenu);
        $this->setmenombre($menombre);
        $this->setmedescripcion($medescripcion);
        $this->setobjmenu($objmenu);
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
    public function getobjmenu(){
        return $this->objmenu;
    }
    public function setobjmenu($reemplazo){
        $this->objmenu = $reemplazo;
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
                    $objMenuPadre=null;
                    if ($row['idpadre']!=null or $row['idpadre']!='' ){
                        $objMenuPadre = new Menu();
                        $objMenuPadre->setidmenu($row['idpadre']);
                        $objMenuPadre->cargar();
                    }
                    $this->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objMenuPadre,$row['medeshabilitado'],$row['meurl'],$row['sinrolrequerido']); 
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
        $sql="INSERT INTO menu( menombre ,  medescripcion ,  idpadre ,  medeshabilitado,meurl,sinrolrequerido)  ";
        $sql.="VALUES('".$this->getmenombre()."','".$this->getmedescripcion()."',";
        if ($this->getobjmenu()!= null) {
            $sql.="'".$this->getobjmenu()->getidmenu()."',"; }
        else {
            $sql.="null,"; }
        if ($this->getmedeshabilitado()>0) {
            $sql.= "'".date("Y-m-d H:i:s")."',"; }
        else {
            $sql.="null,"; }
        $sql.=" '".$this->getmeurl()."',";  
        if ($this->getsinrolrequerido()>0) {
                $sql.= "1"; }
            else {
                $sql.="null"; }

        $sql.= ");";
//          $console="<script>console.log('entro al insertar')</script>";
//          echo $console;
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
        $sql="UPDATE menu SET menombre='".$this->getmenombre()."',medescripcion='".$this->getmedescripcion()."',meurl='".$this->getmeurl()."'";

        if ($this->getobjmenu() == null) {
            $sql.=",idpadre=NULL"; }
          else {
//$console="<script type='text/javascript'>console.log('" . var_dump( $this->getobjmenu() )."')</script>"; //debug
//echo $console;
            $sql.=",idpadre= ".$this->getobjmenu()->getidmenu();
         }

         if ($this->getmedeshabilitado()!=null) {
             $sql.= ",medeshabilitado='".$this->getmedeshabilitado()."'"; }
         else {
              $sql.=" ,medeshabilitado=null"; }

        if ($this->getsinrolrequerido() > 0) {
           $sql.= ", sinrolrequerido=1"; }
         else {
           $sql.=", sinrolrequerido=null"; }

        $sql.= " WHERE idmenu = ".$this->getidmenu();
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
                    $obj= new Menu();
                    $objMenuPadre =null;
                    if ($row['idpadre']!=null){
                        $objMenuPadre = new Menu();
                        $objMenuPadre->setidmenu($row['idpadre']);
                        $objMenuPadre->cargar();
                    }
                    $obj->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objMenuPadre,$row['medeshabilitado'],$row['meurl'],$row['sinrolrequerido']); 
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