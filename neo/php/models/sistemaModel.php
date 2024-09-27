<?php
Class SistemaModel extends Conectar
{
    function __construct(){
        parent::__construct();
    }

//GETS

    public function get()
    {
        try
        {
            $datos=$this->getAll('*','sistema','','1=1');
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


//ELIMINACIONES

//METODOS
    public function intentosLogin()
    {
        try
        {
            $db=$this->db();
            $datos=$this->get();
            $now=date('Y:m:d H:i:s');
            if(isset($datos) && $datos->INTENTOS_LOGIN <= INTENTOS_MAXIMOS_LOGIN)
            {
                $intentos=$datos->INTENTOS_LOGIN + 1;
                $sql='UPDATE `sistema` SET INTENTOS_LOGIN='.$intentos . ' WHERE ID=1';
                $query=$db->prepare($sql);
                $query->execute();
            }
            else
            {
                $sql='UPDATE `sistema` SET BLOQUEAR_LOGIN='. ESTADO_BLOQUEAR_LOGIN . ',FECHA_STOP_LOGIN=now() WHERE ID=1';
                $query=$db->prepare($sql);
                $query->execute();
            }

            return $datos;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
            $db=null;
            unset($datos);
        }
    }

    //Se llama en usuario.php, metodo login(). Si se logea correctamente la tabla sistema queda vacia
    public function restablecerDatos()
    {
        try
        {
            $datos=array(
                'INTENTOS_LOGIN'=>null,
                'BLOQUEAR_LOGIN'=>null,
                'FECHA_STOP_LOGIN'=>null
            );
            if(is_array($datos))
            {
                $this->modificar('sistema',$datos,'ID=1');
            }
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
