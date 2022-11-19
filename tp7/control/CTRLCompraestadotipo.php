<?php
class CTRLCompraEstadoTipo {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //  echo "entramos a cargar objeto";        print_R($param);
        $objCET = null;
        if(array_key_exists('idcompraestadotipo',$param) && array_key_exists('cetdetalle',$param)){
            $objCET = new Compraestadotipo();
            $objCET->setear($param['idcompraestadotipo'],$param['cetdescripcion'],$param['cetdetalle']);
        } 
        
        return $objCET;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idcompraestadotipo']) ){
            $obj = new Compraestadotipo();
            $obj->setear($param['idcompraestadotipo'],null, null);
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
        if (isset($param['idcompraestadotipo']))
            $resp = true;
            return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Compraestadotipo();
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
            if (isset($param['idcompraestadotipo']))
            $where .= " and idcompraestadotipo='" . $param['idcompraestadotipo'] . "'";
            if (isset($param['cetdescripcion']))
            $where .= " and cetdescripcion ='" . $param['cetdescripcion'] . "'";
            if (isset($param['cetdetalle']))
            $where .= " and cetdetalle ='" . $param['cetdetalle'] . "'";
        }
        $arreglo = Compraestadotipo::listar($where);
        return $arreglo;
    }
}
