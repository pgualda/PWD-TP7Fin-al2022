<?php
class CTRLCompraestado {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        //  echo "entramos a cargar objeto";        print_R($param);
        $objCE = null;
        $objC = null;
        $objCET = null;
        //echo "<br>estoy antes de entrar al if de cargarobj<br>";
        if(array_key_exists('idcompraestadotipo',$param) && array_key_exists('idcompra',$param)) 
        {
            //echo "<br>dentro del if de cargarobj<br>";

            $objC = new Compra();
            $objC->setidcompra($param['idcompra']);
            $objC->cargar();

            //echo "<br>-----Compraestado compra <br>";
            //var_dump($objC);

            
            $objCET = new Compraestadotipo();
            $objCET->setIdCompraestadotipo($param['idcompraestadotipo']);
            $objCET->cargar();

            //echo "<br>-----Compraestado compraestaditipo<br>";
            //var_dump($objCET);
            $objCE = new Compraestado();

            if(array_key_exists('cefechafin',$param)){
                $objCE-> setear($param['idcompraestado'], $objC, $objCET,$param['cefechaini'],$param['cefechafin']);
            }else{
                $objCE-> setear(null, $objC, $objCET,null,null);
            }

            //echo "<br>-----Compraestado compraestado<br>";
            //var_dump($objCE);



        }else{
            //echo "<br>-- ni pude pasar ---<br>";

        }
        return $objCE;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idcompraestado']) ){
            $obj = new Compraestado();
            $obj->setear($param['idcompraestado'],null, null, null, null);
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
        if (isset($param['idcompraestado']))
            $resp = true;
            return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $obj = new Compraestado();
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
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompraestado']))
            $where .= " and idcompraestado='" . $param['idcompraestado'] . "'";
            if (isset($param['idcompra']))
            $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['idcompraestadotipo']))
            $where .= " and idcompraestadotipo ='" . $param['idcompraestadotipo'] . "'";
            if (isset($param['cefechaini']))
            $where .= " and cefechaini ='" . $param['cefechaini'] . "'";
            if (isset($param['cefechafin']))
            if (is_null($param['cefechafin'])) {
                $where .= " and cefechafin !=null";
            } else {
                $where .= " and cefechafin ='" . $param['cefechafin'] . "'";
            }
        }
        $arreglo = Compraestado::listar($where);
        return $arreglo;
    }

    public function buscarSiEstaCerrado($idcompra){
        $where = " idcompraestadotipo=1 and idcompra=".$idcompra." and cefechafin is not null";
        $arr = Compraestado::listar($where);
        return $arr;
    }

    public function buscarparaenviar($idcompra){
        $where = " idcompraestadotipo=2 and idcompra=".$idcompra." and cefechafin is null";
        $arr = Compraestado::listar($where);
        return $arr;
    }

    public function buscarestadoactual($idcompra){
        $where = " idcompra=".$idcompra." and cefechafin is null";
        $arr = Compraestado::listar($where);
        return $arr;
    }

    public function cambiaestado($idcompra,$nuevoestado){
    
        //si llego hasta aca, enel estado que este, no me importa, busco el ultimo
        $objcompraestado = new Compraestado();
        $where = " idcompra=".$idcompra." and cefechafin is null";
        $arr = Compraestado::listar($where);
        $respuesta=false;
        if ( isset($arr[0])) {
            // tengo un estado y a ese estado que tengo le pongo fecha fin
            $objuncompraestado=$arr[0];
            $param=['idcompra'=>$idcompra,
                         'idcompraestado'=>$objuncompraestado->getidcompraestado(),
                         'idcompraestadotipo'=>$objuncompraestado->getobjcompraestadotipo()->getidcompraestadotipo(), 
                         'cefechaini'=>$objuncompraestado->getcefechaini(),
                         'cefechafin'=>date("Y-m-d H:i:s")];
            if ($this->seteadosCamposClaves($param)){
                $obj = $this->cargarObjeto($param);
                if ($obj !=null && $obj->modificar()){
                   $respuesta=true;
                } 
            }      
        }  
        if ( !$respuesta ) {
           $mensaje = "Error actualizando estado actual"; 
        }
        if ($respuesta) {
            // despues inserta un reg con el nuevo estado "3" enviado
            $objestadotipo=new Compraestadotipo();
            $arr=$objestadotipo->listar(' idcompraestadotipo="4"');
            $objestadotipo=$arr[0];
            $param= [ 'idcompraestado'=>null,'cefechaini'=>date("Y-m-d H:i:s"),'cefechafin'=>null,
                    'idcompra'=>$idcompra,
                    'idcompraestadotipo'=>$arr[0]->getidcompraestadotipo()];
            $obj = new Compraestado();
            $obj = $this->cargarObjeto($param);
            if ($obj!=null and $obj->insertar()){
                $respuesta = true;
            }
        }                                       
        if (!$respuesta ) {
           $mensaje = "Error insertando nuevo estado"; 
        }
        return $respuesta;
    }            
}
?>

