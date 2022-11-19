<?php
class CTRLUsuarioRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    private function cargarObjeto($param){
        //verEstructura($param);
        $OBJUsuarioRol = null;
        $OBJRol = null;
        $OBJUsuario = null;
        //print_r($param);
        if( array_key_exists('idrol',$param) and $param['idrol']!=null ){
            $OBJRol = new Rol();
            $OBJRol->setidrol($param['idrol']);
            $OBJRol->cargar();
        }
        if( array_key_exists('idusuario',$param) && $param['idusuario']!=null){
            $OBJUsuario = new Usuario();
            $OBJUsuario->setidusuario($param['idusuario']);
            $OBJUsuario->cargar();
        }   
        $OBJUsuarioRol = new UsuarioRol();
        $OBJUsuarioRol->setear($OBJUsuario, $OBJRol);
        return $OBJUsuarioRol;
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
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $resp = true; }
        return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $OBJUsuarioRol = $this->cargarObjeto($param);
        if ($OBJUsuarioRol!=null and $OBJUsuarioRol->insertar()){
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
            $OBJUsuarioRol = $this->cargarObjeto($param);
            if ($OBJUsuarioRol !=null and $OBJUsuarioRol->eliminar()){
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
        // print_R ($param);
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario='".$param['idusuario']."'";
            if  (isset($param['idrol']))
                $where.=" and idrol ='".$param['idrol']."'";
        }
        $arreglo = UsuarioRol::listar($where, "");
        return $arreglo;
    }

    
}
?>