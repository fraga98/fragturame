<?php

Class UsuarioModel extends Conectar
{
    function __construct()
    {
        parent::__construct();
        $this->tablaDB='usuarios';
    }

    public function obtenerInfoGeneral($parametros=null)
    {
    	try
        {
            $select='u.*,
                r.TIPO,
                c.EMAIL,c.TELEFONO,
                l.CALLE,l.NUMERO,l.LOCALIDAD,l.PROVINCIA,l.PAIS,l.ZONA,
                s.FECHA_INICIO, s.FECHA_CIERRE';
            $tablaDB='usuarios u';
            $join='LEFT JOIN roles r ON r.ID = u.ID_ROL
            LEFT JOIN sesiones s ON s.ID_USUARIO = u.ID
            LEFT JOIN contactos c ON c.ID_USUARIO = u.ID
            LEFT JOIN localidades l ON l.ID_USUARIO = u.ID';
            $where='c.EMAIL=? AND u.CONTRASENIA=?';
            $res=$this->getAll($select,$tablaDB,$join,$where,$parametros);
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

//RESPUESTA DATA TABLE
    public function respuestaDataTable()
    {
        try
        {
            $db=$this->db();
            $procedure="CALL listado_usuario('')";
            $query=$db->prepare($procedure);
            $query->execute();
            $datos=$query->fetchAll(PDO::FETCH_OBJ);
            return $datos;

            /*
            $select='u.*,
                r.TIPO,
                c.EMAIL,c.TELEFONO,
                l.CALLE,l.NUMERO,l.LOCALIDAD,l.PROVINCIA,l.PAIS,l.ZONA,
                MAX(s.FECHA_INICIO) AS INCIO_SESION,
                MAX(s.FECHA_CIERRE) AS CIERRE_SESION,
                IF(TIMESTAMPDIFF(HOUR, MAX(s.FECHA_INICIO), MAX(s.FECHA_CIERRE)) < 5, "Activo" , "Fuera de linea") AS ESTADO_SESION';
            $tablaDB='usuarios u';
            $join='LEFT JOIN roles r ON r.ID = u.ID_ROL
            LEFT JOIN sesiones s ON s.ID_USUARIO = u.ID
            LEFT JOIN contactos c ON c.ID_USUARIO = u.ID
            LEFT JOIN localidades l ON l.ID_USUARIO = u.ID';
            $where='1=1
            GROUP BY u.ID';
            $res=$this->getAll($select,$tablaDB,$join,$where);
            return $res;
            */
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
//FIN RESPUESTA DATA TABLE

//PROCEDIMIENTOS ALMACENADOS

    //Obtengo los datos del usuario indicado 'x ID' o de todos
    public function get()
    {
        $db=$this->db();
        $procedure='CALL getUsuario()';
        $query=$db->prepare($procedure);
        $query->execute();
        $datos=$query->fetch(PDO::FETCH_OBJ);
        return $datos;
    }
//FIN DE PROCEDIMIENTOS ALMACENADOS

}//Class

