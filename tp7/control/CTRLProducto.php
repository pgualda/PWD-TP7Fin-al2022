<?php
class CTRLProducto {
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //    echo "entramos a cargar objeto";        print_R($param);
        $obj = null;
        if(array_key_exists('pronombre',$param) && array_key_exists('prodetalle',$param) && array_key_exists('procantstock',$param))
        {
            

            
            $obj = new Producto();
            $obj-> setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null);
        }
        return $obj;
    }
   
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idproducto']))
        $resp = true;
        return $resp;
    }

    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $obj = new Producto();
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
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
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null and $obj->modificar()) {
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
            if (isset($param['idproducto']))
            $where .= " and idproducto='" . $param['idproducto'] . "'";
            if (isset($param['pronombre']))
            $where .= " and pronombre='" . $param['pronombre'] . "'";
            if (isset($param['prodetalle']))
            $where .= " and prodetalle like '%" . $param['prodetalle'] . "%'";
            if (isset($param['procantstock']))
            $where .= " and procantstock ='" . $param['procantstock'] . "'";
        }
        $arreglo = Producto::listar($where);
        return $arreglo;
    }

    public function hayStock($idprod,$cantidad){
        $resp = true;
        $where = " idproducto=".$idprod;
        $obj = Producto::listar($where);
        if($obj[0]->getprocantstock() < $cantidad){
            $resp = false;
        }
        return $resp;
    }

}
?>