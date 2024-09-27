<?php
//CONFIGURACION GENERAL
    ini_set('memory_limit','-1');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    //errores
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
//CONFIGURACION BASE DE DATOS, CONEXION
    define('HOST','localhost');
    define('DBNAME','neo');
    define('USERNAME','root');
    define('PASSWORD','');
//NOW
    $now=date('Y:m:d H:i:s');
    define('FECHA_HORA_NOW',$now);
//SERVIDOR
    $servidor=$_SERVER['HTTP_HOST'];
//ROLES
    define('ROL_SUPER_ADMINISTADOR',1);
    define('ROL_ADMINISTADOR',2);
    define('ROL_VENTAS',3);
    define('ROL_SUPERVISOR',4);
    define('ROL_SIMPLE',5);
//SISTEMA
    define('INTENTOS_MAXIMOS_LOGIN',5);
    define('ESTADO_BLOQUEAR_LOGIN',1);
//ICONOS VISUALES - son htms
    define('ICONO_AGREGAR',"<i class='fa-solid fa-circle-plus'></i>");
    define('ICONO_ELIMINAR',"
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-trash' viewBox='0 0 16 16'>
      <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
      <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
    </svg>
    ");
    define('ICONO_MODIFICAR',"
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-pencil-square' viewBox='0 0 16 16'>
        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
    </svg>
    ");
    define('ICONO_BLOQUEAR',"
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-lock-fill' viewBox='0 0 16 16'>
        <path d='M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2'/>
    </svg>"
    );
    define('ICONO_DESBLOQUEAR',"
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-unlock' viewBox='0 0 16 16'>
      <path d='M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2M3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z'/>
    </svg>"
    );
    define('ICONO_INFO',"<i class='fa-regular fa-circle-question'></i>");
    define('ICONO_CERRAR',"<i class='fa-solid fa-xmark'></i>");
    define('ICONO_CHECK_SUCCESS',"<i class='fa-solid fa-circle-check'></i>");
//URLS DEL SISTEMA
      //ACCIONES GENERICAS PARA TODAS LAS VISTAS
        define('CREAR',1);
        define('ELIMINAR',2);
        define('LISTAR',3);
        define('MODIFICAR',4);
        define('BLOQUEAR',5);
        define('DESBLOQUEAR',6);
        //LA USAN TODAS LAS VISTAS
            define('VIEW',-1); // todas las visuales arrancan en -1 !
        //DASHBOARD
            //..
        //USUARIO
            define('LOGIN',1);
            define('LOGOUT',2);
            define('ACTUALIZAR_PASSWORD',3);
            define('ACCIONES_USUARIO',4);
            define('LISTADO_DATA_TABLE',5);
            define('AJUSTES',6);
            define('TRANSACCION',7);
            define('GESTIONAR_SEGURIDAD',8);
            define('SOPORTE',9);
//PERFILES
    define('PERFIL_USUARIO_ELIMINAR',1);
