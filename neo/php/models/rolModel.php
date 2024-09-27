<?php

Class UsuarioModel extends Conectar
{
    function __construct()
    {
        parent::__construct();
        $this->tablaDB='usuarios';
    }

    public function obtenerInfoGeneral()
    {
    	try
        {
            $res=$this->getAll('*','roles','','1=1',array());
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
}//Class
