<?php
class CTRLRol{ 
 
/*    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;
    } */
    /** 
     *  cargar Objeto 
     * @param array $param
     * @return Rol
    */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('rodescripcion',$param)){
            $obj = new Rol();
            $obj->setear($param['idrol'], $param['rodescripcion']);
        }
// debug
$console=$obj->getrodescripcion()." ".$obj->getidrol();
echo "<script>console.log('Console: " . $console . "' );</script>";

        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idrol']) ){
            $obj = new Rol();
            $obj->setear($param['idrol'], null);
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
        if (isset($param['idrol']))
            $resp = true;
        return $resp;
    }
 
    /**
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $obj = $this->cargarObjeto($param);
// debug
//        $console=$obj->getrodescripcion();
//       echo "<script>console.log('Console: " . $console . "' );</script>";
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
            if ($obj!=null and $obj->eliminar()){
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
// debug NO LLEGA A ENTRAR PARECE
//$console="entra en modificacion";
//echo "<script>console.log('Console: " . $console . "' );</script>";
     if ($this->seteadosCamposClaves($param)){
            $obj = $this->cargarObjeto($param);
            if($obj!=null and $obj->modificar()){
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
            if  (isset($param['idrol']))
                $where.=" and idrol ='".$param['idrol']."'";
        }
        $arreglo = Rol::listar($where);  
        return $arreglo;
        
    }
  
}
?>