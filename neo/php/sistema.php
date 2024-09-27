<?php
Class Sistema
{
	private $sistemaModel='';

	function __construct()
	{
		$this->sistemaModel=new SistemaModel();
	}

//GET
	public function getSistema()
	{
		$res=$this->sistemaModel->get();
		return $res;
	}
//FIN DE GET

//METODOS

	//Si tenes mas de cinco bloqueos, se pone un estado en 1 y te bloquea la pagina, retorna el numero de intentos hasta el momento
	public function intentosLogin()
	{
		$this->sistemaModel->intentosLogin();
	}

	//Si el usuario se logea, se restablecen los datos
	public function restablecerDatos()
	{
		$this->sistemaModel->restablecerDatos();
	}

//FIN DE METODOS
}
