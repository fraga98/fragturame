<?php

Class Sesion
{
	private $sesionModel='';

	function __construct()
	{
		$this->sesionModel=new SesionModel();
		if (session_status()===PHP_SESSION_NONE)
		{
    		session_start();
		}
	}

//METODOS

	public function logAperturaSesion($id)
	{
		$sesion=array(
			'ID_USUARIO'=>(int)$id,
			'FECHA_INICIO'=>FECHA_HORA_NOW,
			'FECHA_CIERRE'=>'',
		);

    	if(is_array($sesion))
    	{
    		$this->sesionModel->logearAperturaSesion($sesion);
    	}
    }

    public function logCierreSesion($idUsuario)
	{
		$this->sesionModel->logearCierreSesion($idUsuario);
    }
//FIN DE METODOS

}//Class

