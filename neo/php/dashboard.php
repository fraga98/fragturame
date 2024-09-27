<?php
require_once 'loadclases.php';

Class Dashboard
{
	//modelos
	private $dashboardModel='';
	function __construct()
	{
	}
//GET
//FIN GET
//VALIDACIONES
//FIN DE VALIDACIONES
//METODOS
//FIN DE METODOS
//CRUD
//FIN DE CRUD
}//Class

	if(class_exists('Dashboard'))
	{
		$dashboard=new Dashboard();
		$typeUrl=(int)getMethod('type');

		//Procesos
		if(is_numeric($typeUrl))
		{
			switch($typeUrl)
			{
				case VIEW:
					$datosVisual=array(
						'vista'=>'dashboardView.php', // contenido body
						'titulo'=>'Dashboard',
					);
					if(ob_get_level()===0)
					{
					    ob_start("ob_gzhandler");
					}
					cargarArchivo('views/cascaraView.php',$datosVisual);  // html - usuarios
					ob_end_flush();
					exit();
				break;
			}
		}
	}
