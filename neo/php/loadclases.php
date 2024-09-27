<?php
    require_once 'utilidades/funciones.php';

    $url=$_SERVER['REQUEST_URI'];
    $url=parse_url($url)['path'];
    $url=pathinfo($url);
    $apartado=$url['filename'];

    $directorio=scandir('../php');
    $dirs=array();
    foreach ($directorio as $dir)
    {
        if($dir!='.'&&$dir!='..'&&$dir!='utilidades'&&$dir!='models'&&$dir!='loadclases.php')
        {
            $path=pathinfo($dir);
            $file=$path['filename'];
            $dirs[$file]=$dir;
        }
    }

    if(isset($dirs[$apartado]))
    {
        //utilidades
            cargarArchivo('utilidades/constantes.php');
            cargarArchivo('utilidades/conexion.php');
            cargarArchivo('utilidades/validaciones.php');
            //cargarArchivo('respuesta.php');
        //sesion
            cargarArchivo('sesion.php');
            cargarArchivo('models/sesionModel.php');
            $sesion=new Sesion();

            /*
            if(isset($_SESSION))
            {
                define('SESSION_ID_USUARIO', $_SESSION['user']->ID);
                define('SESSION_NOMBRE_USUARIO', $_SESSION['user']->NOMBRE);
                define('SESSION_APELLIDO_USUARIO', $_SESSION['user']->APELLIDO);
                define('SESSION_TOKEN', $_SESSION['csrf_token']);
            }
            */

        //Modelo - lo utilizo para el menu
            cargarArchivo('models/menuModel.php');

        //Que necesita cada apartado
            switch ($apartado)
            {
                case 'dashboard':
                break;
                case 'usuario':
                    //modelos
                    $archivoModelo='models/'.$apartado.'Model.php';
                    cargarArchivo($archivoModelo);
                    cargarArchivo('models/sistemaModel.php');
                    //clases
                    cargarArchivo('sistema.php');
                    //cargarArchivo('rol.php');
                break;
                case 'producto':
                break;
                default:
                    echo 'Not found page 404';
                break;
            }
    }



