<?php
Class Visual
{
    private $menuModel='';

    function __construct()
    {
        $this->menuModel= new MenuModel();
    }

//MENU ASIDE
    public function getMenuAside()
    {
        //Cacheo de datos!!!
        $datosMenu=getDatosCache('menuDatos');
        if(empty($datosMenu))
        {
            //si esta vacio, obtengo los datos y lo guardo en el archivo de cacheo !
            $datosMenu=$this->menuModel->getMenu();
            if (!empty($datosMenu))
            {
                crearSetearArchivoCache('menuDatos', $datosMenu, 1000);
            }
        }

        $armadoMenu=array();
        if(isset($datosMenu))
        {
            foreach ($datosMenu as $valor)
            {
                $opcion=(isset($valor->OPCION)) ? $valor->OPCION : '';
                $url=(isset($valor->URL) )? $valor->URL: '';
                $subOpciones=(isset($valor->JSON_SUB_OPCION)) ? $valor->JSON_SUB_OPCION : null;
                $armadoMenu[$opcion]=array(
                    'url'=>$url,
                    'subopciones'=>$subOpciones
                );
            }
        }
        unset($datosMenu);
        return $armadoMenu;
    }
}//Class
