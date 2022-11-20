<?php
class CTRLCompraItem {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //  echo "entramos a cargar objeto";        print_R($param);
        $objcompraitem = null;
        $objcom = null;
        $objprod = null;
        if(array_key_exists('idproducto',$param) && array_key_exists('idcompra',$param) && array_key_exists('cicantidad',$param)) 
        {
            $objcom = new Compra();
            $objcom->setidcompra($param['idcompra']);
            $objcom->cargar();
            
            $objprod = new Producto();
            $objprod->setidproducto($param['idproducto']);
            $objprod->cargar();

            $objcompraitem = new Compraitem();
            if(array_key_exists('idcompraitem',$param)){
                $objcompraitem-> setear($param['idcompraitem'], $objprod, $objcom, $param['cicantidad']);

            }else{
                $objcompraitem-> setear(null, $objprod, $objcom, $param['cicantidad']);

            }
        }
        return $objcompraitem;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idcompraitem']) ){
            $obj = new Compraitem();
            $obj->setear($param['idcompraitem'],null, null, null);
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
        if (isset($param['idcompraitem']))
            $resp = true;
            return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Compraitem();
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
// debug        
//        var_dump($param);
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
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompraitem']))
            $where .= " and idcompraitem='" . $param['idcompraitem'] . "'";
            if (isset($param['idproducto']))
            $where .= " and idproducto ='" . $param['idproducto'] . "'";
            if (isset($param['idcompra']))
            $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['cicantidad']))
            $where .= " and cicantidad ='" . $param['cicantidad'] . "'";
        }
        $arreglo = Compraitem::listar($where);
        return $arreglo;
    }

    public function listarPorIdCompra($data)
    {
        $OBJSession = new CTRLSession;
        $ctCom = new CTRLCompra();
        $user = $OBJSession->getidUsuario();
        $listar = $ctCom->buscar(['idusuario' => $user]);
        $ultimo = end($listar);
        $idcompra = $ultimo->getidcompra();

        $where = " idcompra=$idcompra ;";
        $arreglo = Compraitem::listar($where);
        return $arreglo;
    }
}
