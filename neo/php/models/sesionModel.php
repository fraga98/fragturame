<?php

Class SesionModel extends Conectar
{
    function __construct(){
        parent::__construct();
    }

//GETS
    public function get()
    {
        try
        {
            $datos=$this->getAll('*','sesiones','','1=1');
            return $datos;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
            $db=null;
        }
    }

//CREACIONES

    public function logearAperturaSesion($datos)
    {
        try
        {
            $res=$this->crear('sesiones',$datos);
            return $res;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
            $db=null;
        }
    }

//MODIFICACIONES

    public function logearCierreSesion($idUsuario)
    {
        try
        {
            //Modifico en la fecha de inicio del usuario, de la sesion
            $where="ID_USUARIO=$idUsuario AND FECHA_INICIO=(SELECT MAX(FECHA_INICIO) FROM sesiones WHERE ID_USUARIO=$idUsuario)";
            $res=$this->modificar('sesiones',array('FECHA_CIERRE'=>FECHA_HORA_NOW),$where);
            return $res;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
            $db=null;
        }
    }

//ELIMINACIONES



}//Class
