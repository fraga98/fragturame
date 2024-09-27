<?php
Class Conectar
{
    private $host='';
    private $dbname='';
    private $username='';
    private $password='';

    function __construct()
    {
        $this->host=HOST;
        $this->dbname=DBNAME;
        $this->username=USERNAME;
        $this->password=PASSWORD;
    }

    public function db()
    {
        try
        {
            $host=$this->host;
            $dbname=$this->dbname;
            $username=$this->username;
            $password=$this->password;
            $conn=new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

//GENERICAS - CREAR - ELIMINAR - MODIF
    public function crear($tablaDB,$datosInset)
    {
        try
        {
            $db=$this->db();
            $campos=implode(',', array_keys($datosInset));
            $valores=array_values($datosInset);

            $sigPregunta='';
            foreach ($valores as $val)
            {
                $sigPregunta.='?,';
            }

            $signos=substr($sigPregunta,0,-1);
            $sql="INSERT INTO {$tablaDB} ({$campos}) VALUES ({$signos});";
            //var_dump($sql);
            /*
            echo '<pre>';
                var_dump($datosInset);
            echo'</pre>';
            */
            $query=$db->prepare($sql);
            $query->execute($valores);
            $afectado=$query->rowCount();
            if($afectado==1)
            {
                //last id
                return array('res_https'=>'success','lastId'=>$db->lastInsertId());
            }
            return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
        }
    }

    public function eliminar($tablaDB,$where)
    {
        try
        {
            if(!empty($tablaDB) && !empty($where))
            {
                $db=$this->db();
                $sql="DELETE FROM {$tablaDB} WHERE {$where}";
                $query=$db->prepare($sql);
                $query->execute();
                $afectado=$query->rowCount();
                if($afectado==1)
                {
                    return "success";
                }
            }
            else
            {
                return "Error 404";
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

    public function modificar($tablaDB,$datos=null,$where='1=1')
    {
        try
        {
            $db=$this->db();
            /*EJ
            $datos=array(
                'NOMBRE'=>'Santiago111',
                'APELLIDO'=>'AuxApellido'
            );
            */
            $consulta='UPDATE '.$tablaDB.' SET ';
            foreach ($datos as $campo => $val)
            {
                $consulta.= $campo . '=?,';
            }

            $sql=substr($consulta, 0,-1) . ' WHERE ' . $where;
            //var_dump($sql);
            $query=$db->prepare($sql);
            $query->execute(
                array_values($datos)
            );
            $afectado=$query->rowCount();
            if($afectado==1)
            {
                return "success";
            }
            if($afectado==0)
            {
                return "No se realizo la modificacion";
            }
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

    public function getAll($select='*',$tablaDB,$join='',$where='1=1',$valoresExecute=array())
    {
        try
        {
            $db=$this->db();
            $sql='SELECT '.$select.' FROM '.$tablaDB.' '.$join.'  WHERE '.$where;
            //var_dump($sql);
            $query=$db->prepare($sql);
            $query->execute(array_values($valoresExecute));
            $cantidad=$query->rowCount();
            $datos='';
            if($cantidad==1)
            {
                $datos=$query->fetch(PDO::FETCH_OBJ);
                $datos=array($datos);
            }
            else
            {
               $datos=$query->fetchAll(PDO::FETCH_OBJ);
            }
            return $datos;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        finally
        {
        }
    }

    //Elimina todos los registros sin condicion
    public function eliminarAll($tablaDB)
    {
        try
        {
            if(!empty($tablaDB))
            {
                $sql="DELETE FROM {$tablaDB}";
                $query=$db->prepare($sql);
                $query->execute();
                $afectado=$query->rowCount();
                if($afectado==1)
                {
                    return "success";
                }
            }
            else
            {
                return "Error 404";
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
