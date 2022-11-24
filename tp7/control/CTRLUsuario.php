<?php
class CTRLUsuario {
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param) {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        //    echo "entramos a cargar objeto";        print_R($param);
        $obj = null;
        if ( array_key_exists('usnombre',$param) ) {
            $obj = new Usuario();
            //$obj-> setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);

            if(array_key_exists('usdeshabilitado',$param)){
                //$obj-> setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
                $obj-> setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], date('Y-m-d H:i:s'));

            }else{
                $obj-> setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], NULL);
            }
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
        if( isset($param['idusuario']) ){
            $obj = new Usuario();
            $obj->setear($param['idusuario'],null, null, null, null);
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
        if (isset($param['idusuario'])) {
            $resp = true; }
        return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Usuario();
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
            $obj->setusdeshabilitado("NULL");
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
            if  (isset($param['idusuario']))
                $where.=" and idusuario='".$param['idusuario']."'";
            if  (isset($param['usnombre']))
                $where.=" and usnombre ='".$param['usnombre']."'";
            if  (isset($param['uspass']))
                $where.=" and uspass ='".$param['uspass']."'";
            if  (isset($param['usmail']))
                $where.=" and usmail ='".$param['usmail']."'";
            if  (isset($param['usdeshabilitado']))
                $where.=" and usdeshabilitado ='".$param['usdeshabilitado']."'";
        }
        $arreglo = Usuario::listar($where);
        return $arreglo;
    }

    public function misDatos(){
        $OBJSession = new CTRLSession;
        $user = $OBJSession->getidUsuario();
        $where = " idusuario = $user ";
        $arr = Usuario::listar($where);
        return $arr;
    }

    public function listarUsuariosActivos(){
        $where = " usdeshabilitado is NULL";
        $arr = Usuario::listar($where);
        return $arr;
    }

    public function ListarExUsers(){
        $where = " usdeshabilitado is NOT NULL";
        $arr = Usuario::listar($where);
        return $arr;
    }
    
    public function habilitar($idusuario){
        $where = " idusuario=$idusuario";
        $objUsuario = Usuario::listar($where);
        $obj = $objUsuario[0];
        $obj->setusdeshabilitado("NULL");
        $resp = false;
        if($obj !=null and $obj->modificar()){
            $resp = true;
        }
        
        return $resp;
    }

    public function deshabilitar($idusuario){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $where = " idusuario=$idusuario";
        $objUsuario = Usuario::listar($where);
        $obj = $objUsuario[0];
        $fechaActual = date('Y-m-d H:i:s');
        $obj->setusdeshabilitado("'$fechaActual'");
        $resp = false;
        if($obj !=null and $obj->modificar()){
            $resp = true;
        }
        
        return $resp;
    }

    public function yaExiste($nombre){
        $resp = true;
        $where = " usnombre='".$nombre."'";
        $obj = Usuario::listar($where);
        if(array_key_exists(0,$obj)){
            $resp = false;
        }
        return $resp;
    }
}
?>