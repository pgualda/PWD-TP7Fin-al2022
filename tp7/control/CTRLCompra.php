<?php

class CTRLCompra {
    
    public $mensaje = "";
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //    echo "entramos a cargar objeto";        print_R($param);
        $objUsuario = null;
        $obj = null;

        if(array_key_exists('idusuario',$param)) 
        {
            $objUsuario=new Usuario();
            $objUsuario->setidusuario($param['idusuario']);
            $objUsuario->cargar();
            //var_dump($objUsuario);
            //echo "<br><br>";


            $obj = new Compra();
            $obj->setear(null, null, $objUsuario);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idcompra']) ){
            $obj = new Compra();
            $obj->setear($param['idcompra'],null, null);
        }
        return $obj;
    }
   
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idcompra']))
            $resp = true;
            return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Compra();
        $obj = $this->cargarObjeto($param);
        if ($obj!=null and $obj->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjetoConClave($param);
            if ($obj !=null and $obj->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjeto($param);
            if($obj !=null and $obj->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idcompra']))
                $where.=" and idcompra='".$param['idcompra']."'";
            if  (isset($param['cofecha']))
                $where.=" and cofecha ='".$param['cofecha']."'";
            if  (isset($param['idusuario']))
                $where.=" and idusuario ='".$param['idusuario']."'";
        }
        $arreglo = Compra::listar($where);
        return $arreglo;
    }


    public function buscarCarrOpen($idcompra){
        $where = " idcompra in(SELECT idcompra FROM compraestado WHERE idcompraestadotipo=1 and idcompra='".$idcompra."' and cefechafin is null) ";
        $carrito = Compra::listar($where);
        return $carrito;
    }

    public function buscarddhh($fdd,$fhh){
        // formatea a fecha
        $d = new DateTime($fdd);
        $fdd = $d->format('Y-m-d'); 
//        echo $fdd;

        $d = new DateTime($fhh);
        $fhh = $d->format('Y-m-d'); 
//        echo $fhh;

        $where = " DATE_FORMAT(cofecha, '%Y-%m-%d')>='".$fdd."' and DATE_FORMAT(cofecha, '%Y-%m-%d')<='".$fhh."'";
        $lista = Compra::listar($where);
        return $lista;
    }

}
?>