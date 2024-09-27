<?php 
require_once 'loadclases.php';

Class Usuario
{
	//modelos
	private $usuarioModel='';
	private $menuModel='';
	//clases
	private $sesion='';
	private $sistema='';

	function __construct()
	{
		//modelos
        $this->usuarioModel= new UsuarioModel();
        //clases
       	$this->sesion= new Sesion();
       	$this->sistema= new Sistema();
        //$this->respuesta= new Respuesta();
        //$this->rol= new Rol();
	}

//GET
	public function getUser($parametros=null)
	{
		$res=$this->usuarioModel->obtenerInfoGeneral($parametros);
		return $res;
	}
//FIN GET

//VALIDACIONES
	private function validoLogin($datosFORM)
	{
		$errores=array();
		if(empty($datosFORM['email']))
		{
			$errores['email']='Campo email vacio';
		}
		if(empty($datosFORM['password']))
		{
			$errores['password']='Campo password vacio';
		}
		return (count($errores)==0) ? 'success' : $errores;
	}
//FIN DE VALIDACIONES

//METODOS
	public function login($datosFORM)
	{
		//Valido datos de entrada
		$validacion=$this->validoLogin($datosFORM);

		if($validacion=='success')
		{
			$datosDB=$this->getUser($datosFORM);
			$datosDB=$datosDB[0];

			//&& $datosSistema->BLOQUEAR_LOGIN == 0
			if(($datosDB->EMAIL==$datosFORM['email']&&$datosDB->CONTRASENIA==$datosFORM['password']) && $datosDB->BLOQUEAR==0)
	        {
	            $rol=$datosDB->ID_ROL;
	            $url="";

	            if($rol==ROL_SUPER_ADMINISTADOR)
	            {
	                $_SESSION['user']=$datosDB;
	                $_SESSION['session_id']=session_id();
	                $_SESSION['session_bloquear_usuario']=0;
	                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	                $url='dashboard.php?type=-1';
	            }

	            //En la tabla sistema los datos quedan vacio, como nulos
	            	$this->sistema->restablecerDatos();
	        	//Log sesion del usuario
	        		$this->sesion->logAperturaSesion($datosDB->ID);
	        	//Elimino cookies de validacion
	        		foreach ($_COOKIE as $nombreCookie => $valor)
					{
						if(preg_match('/^cookie-validacion-/',$nombreCookie))
						{
							eliminarCookie($nombreCookie);
						}
					}
				//Eliminino las cookies - 'muchos intentos en elsistema'
		            if(isset($_COOKIE['cookie-stop-login']) && isset($_COOKIE['cookie-fecha-stop-login']))
		            {
						eliminarCookie('cookie-stop-login');
						eliminarCookie('cookie-fecha-stop-login');
		            }
		        //Elimino la cookie de usuario bloqueado
		            eliminarCookie('cookie-usuario-bloqueado');

	        	unset($datosDB);
	        	unset($datosFORM);
	        	header('Location: ' . $url);
	        }
	        else if($datosDB->BLOQUEAR==1)
	        {
	        	//Entra cuando el usuario se encuentra bloqueado
					crearCookie('cookie-usuario-bloqueado','Usuario Bloqueado','/');
				//Elimino cookies de validacion
	        		foreach ($_COOKIE as $nombreCookie => $valor)
					{
						if(preg_match('/^cookie-validacion-/',$nombreCookie))
						{
							eliminarCookie($nombreCookie);
						}
					}
				header('Location: ../index.php');
				exit();
	        }
	        else
	        {
	        	header('Location: ../index.php');
	        	/*
		        	//Si existen 3 intentos en base de datos, es para recuperar contraseñia, 5 intentos oculto el boton de login !
		    		$INTENTOS_MODIFICAR_PASSWORD_LOGIN=3;
		    		$INTENTOS_BLOQUEAR_LOGIN=5;

		           	$datosSistema=$Sistema_object->intentosLogin();

		            if($datosSistema->INTENTOS_LOGIN==3) //Modificar password
		            {
		            	crearCookie('login-recordad-password',true,'/');
		                header('Location: ../view/olvidarpassword.php');
		            }
		            else if($datosSistema->INTENTOS_LOGIN==$INTENTOS_BLOQUEAR_LOGIN && $datosSistema->BLOQUEAR_LOGIN)
		            {
		                $fechaLimiteIntentosLogin=$datosSistema->FECHA_STOP_LOGIN;

		                crearCookie('stop-login',true,'/');
		                crearCookie('fecha-stop-login', $fechaLimiteIntentosLogin,'/');
		                header('Location: ../index.php');
		            }
		            else
		            {
		            	 header('Location: ../index.php');
		            }
	            */
	        }
		}
		else
		{
			//Entra cuando existe un error en la validacion, email y password
				foreach ($_COOKIE as $nombreCookie => $valor)
				{
					if(preg_match('/^cookie-validacion-/',$nombreCookie))
					{
						eliminarCookie($nombreCookie);
					}
				}
			//creo las nuevas cookies
				$validacion=$this->validoLogin($datosFORM);
				foreach ($validacion as $campo => $msj)
				{
					crearCookie('cookie-validacion-'.$campo,$msj,'/');
				}
			//Elimino la cookie de usuario bloqueado
		        eliminarCookie('cookie-usuario-bloqueado');

			header('Location: ../index.php');
		}
	}

	public function logout($idUsuario)
	{
		session_start();
		session_unset();
		session_destroy();

		//Log sesion del usuario
		$this->sesion->logCierreSesion($idUsuario);
		header('Location: ../index.php');
		exit();
	}

	//Recuperar Password
	public function actualizarPassword($datosFORM)
	{
		$emailFormulario=$datosFORM['email'];
		$passwordNueva=$datosFORM['password'];

		$datosDB=$this->getUser(array('email'=>$emailFormulario));

		if($datosDB!=false)
		{
			$emailActual=$datosDB->EMAIL;
			if($emailActual==$emailFormulario)
			{
				$idUsuario=$datosDB->ID;
				$condicion='ID='.$idUsuario;

				$this->modificar('usuarios',array('CONTRASENIA'=>$passwordNueva),$condicion);
				header('Location: ../index.php');
			}
		}
		else
		{
			var_dump("Error no se encuentra registrado con el email indicado");
		}
	}

//FIN DE METODOS
//CRUD
	//http://localhost/neo/php/usuario.php?type=4&accion=1
	public function creacion()
	{

		//Estos datos tienen que venir de un array de jquey
		$res=false;
		$usuario=array(
			'ID_ROL'=>1,
			'USUARIO_ALTA'=> id_user_session,
			'NOMBRE'=>'Santiago',
			'APELLIDO'=>'Fraga',
			'DNI'=>'3211233',
			'CONTRASENIA'=>'123456+',
			'SEXO'=>'M',
			'FECHA_NACIMIENTO'=>FECHA_HORA_NOW,
			'FECHA_CREACION'=>FECHA_HORA_NOW,
			'FECHA_MODIFICACION'=>'',
		);
		if(is_array($usuario))
		{
			$lastId=$this->usuarioModel->crear('usuarios',$usuario);
			if(is_numeric($lastId))
			{
				$ubicacion=array(
		            'ID_USUARIO'=>(int)$lastId['lastId'],
		            'ID_EMPRESA'=>1,
		            'ID_PROVEEDOR'=>0,
		            'ID_CLIENTE'=>0,
		            'CALLE'=>'Alfredo Palacios',
		            'NUMERO'=>'7898',
		            'LOCALIDAD'=>'Lanus',
		            'PROVINCIA'=>'Buenos Aires',
		            'PAIS'=>'Argentina',
		            'ZONA'=>'Sur'
		        );

				$contacto=array(
					'ID_USUARIO'=>(int)$lastId['lastId'],
					'ID_EMPRESA'=>'',
					'ID_PROVEEDOR'=>'',
					'ID_CLIENTE'=>'',
					'TELEFONO'=>'112718759',
					'EMAIL'=>'soporte@gmail.com'
		        );

		        $this->usuarioModel->crear('localidades',$ubicacion);
		        $this->usuarioModel->crear('contactos',$contacto);
		        $res=true;
		    }
		}
	    return $res;
	}

	//http://localhost/neo/php/usuario.php?type=4&accion=2&id=100
	public function eliminacion($id)
	{
		if(!empty($id) && is_numeric($id))
		{
			$this->usuarioModel->eliminar('usuarios','ID='.$id);
			echo "<script> window.history.back();</script>";
			exit();
		}
		else
		{
			//echo $this->Respuesta_object->getRespuestaHTTPS();
		}
	}

	//http://localhost/neo/php/usuario.php?type=4&action=3&id=-1
	public function modificacion($id)
	{
		if(!empty($id) && is_numeric($id))
		{
		}
		else
		{
			//echo $this->Respuesta_object->getRespuestaHTTPS();
		}
	}

	public function bloquear($id)
	{
		if($id!=null)
		{
			if(SESSION_ID_USUARIO==$id)
			{
				$_SESSION['session_bloquear_usuario']=1; // Si bloqueo al usuario la sesion setea este valor
			}
			$this->usuarioModel->modificar('usuarios',array('BLOQUEAR'=>1),'ID='.$id);
			echo "<script> window.history.back();</script>";
			exit();
		}
	}

	public function desbloquear($id)
	{
		if($id!=null)
		{
			$res=$this->usuarioModel->modificar('usuarios',array('BLOQUEAR'=>(int)0),'ID='.$id);
			echo "<script> window.history.back();</script>";
			exit();
		}
	}

	//http://localhost/neo/php/usuario.php?type=4&accion=3
	public function listado()
	{
		//Cacheo de datos
		$datos=getDatosCache('listadoUsuario'); // Obtengo los datos del cache
		if(empty($datos))
		{
			$datos=$this->usuarioModel->respuestaDataTable();
			crearSetearArchivoCache('listadoUsuario', $datos, 1000);
		}

		$data=array();
		foreach ($datos as $valor)
		{
			$acciones='';
			$id=$valor->ID;
			$bloqueado=$valor->BLOQUEAR;
			$estadoSesion=$valor->ESTADO_SESION;

			//Acciones
				//eliminar
					$enlaceEliminar='../php/usuario.php?type=4&accion=2&id='.$id;
				//modificacion
				//bloquear y desbloquear
					$disabledBtnBloquear='';
					$enlaceBloqueado=(!$bloqueado)? '../php/usuario.php?type=4&accion=5&id='.$id : '../php/usuario.php?type=4&accion=6&id='.$id;
					$iconoBloqueado=($bloqueado)? ICONO_BLOQUEAR : ICONO_DESBLOQUEAR;
					//El id de session no se puede bloquear a el mismo !
					/*
					if(SESSION_ID_USUARIO==$id)
					{
						$disabledBtnBloquear='disabled';
						$enlaceBloqueado='#';
					}
					*/
			$acciones.="<a class='p-2' href='$enlaceEliminar'>".ICONO_ELIMINAR."</a>";
			$acciones.='<a href="#" id="id_modificar_-1" class="me-2">'.ICONO_MODIFICAR.'</a>';
			$acciones.='<a '.$disabledBtnBloquear.' href='.$enlaceBloqueado.'>'.$iconoBloqueado.'</a>';

			$colorEstado='<span class="text-center"><label style="width: 8px;height: 8px;background: #00ff10;border-radius: 50%;"></label></span>';
			if($estadoSesion=='Fuera de linea')
			{
				$colorEstado='<span class="text-center"><label style="width: 8px;height: 8px;background: red;border-radius: 50%;"></label></span>';
			}

			$data[]=array(
				'INFO_ALL'=>"<a id='id_ver_{$id}' data-pk-id='{$id}' href='#'>".ICONO_INFO."</a>",
				'NOMBRE'=>$valor->NOMBRE,
				'APELLIDO'=>$valor->APELLIDO,
				'EMAIL'=>$valor->EMAIL,
				'ROL'=>$valor->TIPO,
				'SESION'=>$colorEstado,
				'INICIO'=>$valor->INCIO_SESION,
				'BLOQUEO'=>($bloqueado)? 'Bloqueado' : 'Desbloqueado',
				'FECHA_ALTA'=>'-',
				'ACCIONES'=> $acciones
			);
		}
		$res=array("aaData"=>$data);
		echo json_encode($res);
	}

//FIN DE CRUD
}//Class

	if(class_exists('Usuario'))
	{
		$usuario=new Usuario();
		$typeUrl=(int)getMethod('type');

		//Procesos
		if(is_numeric($typeUrl))
		{
			switch($typeUrl)
			{
				case VIEW://-1
					//Body parte visual !!!
					$datosVisual=array(
						'vista'=>'usuarioView.php', // contenido body
						'titulo'=>'Usuario',
					);
					cargarArchivo('views/cascaraView.php',$datosVisual);  // html - usuarios
					exit();
				break;
				case LOGIN:
					$usuario->login($_POST);
				break;
				case LOGOUT:
					$idUsuario=$_SESSION['user']->ID;
					$usuario->logout($idUsuario);
				break;
				case ACTUALIZAR_PASSWORD:
					$usuario->actualizarPassword($_POST);
				break;
				case ACCIONES_USUARIO:
					$accion=getMethod('accion');
					$idUsuarioUrl=(int)getMethod('id'); // id url
					switch($accion)
					{
						case CREAR:
							$usuario->creacion($idUsuarioUrl);
							break;
						case ELIMINAR:
							$usuario->eliminacion($idUsuarioUrl);
						break;
						case LISTAR:
							$usuario->listado($idUsuarioUrl);
						break;
						case MODIFICAR:
							$usuario->modificacion($idUsuarioUrl);
						break;
						case BLOQUEAR:
							$usuario->bloquear($idUsuarioUrl);
						break;
						case DESBLOQUEAR:
							$usuario->desbloquear($idUsuarioUrl);
						break;
						default:
							echo "404 page not found!!";
						break;
					}
				break;
				case AJUSTES:
					echo 'Realiza ajustes en el sistema';
				break;
				case TRANSACCION:
					echo 'Mercado Pago';
				break;
				case GESTIONAR_SEGURIDAD:
					echo 'Perfiles y acciones segun los roles';
				break;
				case SOPORTE:
					echo 'Deja en base detos alguna descripcion para consultar con el creador del sistema';
				break;
				default:
					echo "404 page not found!!";
				break;
			}
		}
		else
		{
			echo "404 page not found!!";
		}
	}

/*
// CODIGO PARA GENERAR UN CODIGO PARA EL LOGIN
if(isset($_POST['checkseguridad']))
{
	//Codigo para generar un archivo en el navegador del cliente
    $file='../codeseguridad.html';
    // Verifica si el archivo existe
    if (file_exists($file))
    {
        // Configura las cabeceras para la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        // Lee el archivo y envíalo al navegador
        readfile($file);
        exit();
    }
    else
    {
        echo "El archivo no existe.";
    }
}
*/
