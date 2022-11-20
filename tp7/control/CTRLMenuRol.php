<?php
class CTRLMenuRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    private function cargarObjeto($param){
        //verEstructura($param);
        $OBJMenuRol = null;
        $OBJRol = null;
        $OBJMenu = null;
        //print_r($param);
        if( array_key_exists('idrol',$param) and $param['idrol']!=null ){
            $OBJRol = new Rol();
            $OBJRol->setidrol($param['idrol']);
            $OBJRol->cargar();
        }
        if( array_key_exists('idmenu',$param) && $param['idmenu']!=null){
            $OBJMenu = new Menu();
            $OBJMenu->setidmenu($param['idmenu']);
            $OBJMenu->cargar();
        }   
        $OBJMenuRol = new MenuRol();
        $OBJMenuRol->setear($OBJMenu, $OBJRol);
        return $OBJMenuRol;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
         // todos los campos son claves asi q es lo mismo, lo dejamos para no cambiar el standart
         return $this->cargarObjeto($param);          
    }
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $resp = true; }
        return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $OBJMenuRol = $this->cargarObjeto($param);
        if ($OBJMenuRol!=null and $OBJMenuRol->insertar()){
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
            $OBJMenuRol = $this->cargarObjeto($param);
            if ($OBJMenuRol !=null and $OBJMenuRol->eliminar()){
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
        // simplemente return false para conservar el standart, pero o alta o baja
        return false;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu='".$param['idmenu']."'";
            if  (isset($param['idrol']))
                $where.=" and idrol ='".$param['idrol']."'";
        }
        $arreglo = MenuRol::listar($where, "");
        return $arreglo;
    }
}
?>