<?php

Class MenuModel extends Conectar
{
    function __construct()
    {
        parent::__construct();
        $this->tablaDB='menu';
    }

//PROCEDIMIENTOS ALMACENADOS

    // Retorno opciones y subopciones del menu segun el rol
    public function getMenu()
    {
        $db=$this->db();
        $procedure='CALL `getMenu`(-1)';
        $query=$db->prepare($procedure);
        $query->execute();
        $datos=$query->fetchAll(PDO::FETCH_OBJ);
        return $datos;
    }
//FIN DE PROCEDIMIENTOS ALMACENADOS

}//Class

