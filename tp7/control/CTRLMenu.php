<?php

class CTRLMenu {
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //    echo "entramos a  cargar objeto";        print_R($param);
        $obj = null;
        if (array_key_exists('menombre',$param) &&
            array_key_exists('medescripcion',$param) &&
            array_key_exists('idpadre',$param) &&
            array_key_exists('medeshabilitado',$param) &&
            array_key_exists('sinrolrequerido',$param) ) {

            //    var_dump($param['medeshabilitado']);
            //    var_dump($param['sinrolrequerido']);
         
            $medeshabilitado=$param['medeshabilitado'] > 0 ? date("Y-m-d H:i:s") : null;
            $sinrolrequerido=$param['sinrolrequerido'] > 0 ? 1 : null;
            $obj = new Menu();
            $objmenu = null;
            if (isset($param['idpadre'])){
                if ($param['idpadre'] != null) {
                    $objmenu = new Menu();
                    $objmenu->setIdmenu($param['idpadre']);
                    $objmenu->cargar();
                }
            }
            //var_dump($medeshabilitado);
            //var_dump($sinrolrequerido);
            
            $obj-> setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objmenu,
            $medeshabilitado,$param['meurl'],$sinrolrequerido);
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
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setear($param['idmenu'],null, null, null, null,null,null);
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
        if (isset($param['idmenu'])) {
            $resp = true; }
        return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Menu();
// eccho
//        var_dump($param);
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
        if ($param != null){
            if  (isset($param['idmenu'])) {
                $where.=" and idmenu='".$param['idmenu']."'"; }
            if  (isset($param['menombre'])) {
                $where.=" and menombre ='".$param['menombre']."'"; }
            if  (isset($param['meurl'])) {
                 $where.=" and meurl ='".$param['meurl']."'"; }
            if  (isset($param['idpadre'])) {
                 $where.=" and idpadre ='".$param['idpadre']."'"; }
            if  (isset($param['medeshabilitado'])) {
                if ($param['medeshabilitado'] == "null")  {
                    $where.=" and IFNULL(medeshabilitado='',TRUE)";
                } else {   
                    $where.=" and medeshabilitado='".$param['medeshabilitado']."'";
                }  
            }
            if  (isset($param['sinrolrequerido'])) {
                 $where.=" and sinrolrequerido ='".$param['sinrolrequerido']."'"; }
        }
        $arreglo = Menu::listar($where);
        return $arreglo;
    }

}
?>