<?php
    // Establecer la duración del caché
    $cacheDuration= 31536000; // 1 año en segundos
    // Establecer cabeceras de cache
    header('Cache-Control: public, max-age=$cacheDuration');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheDuration) . ' GMT');

    $url=$_SERVER['REQUEST_URI'];
    $url=parse_url($url)['path'];
    $url=pathinfo($url);
    $apartado=(isset($url['filename'])) ? $url['filename'] : null;
    $recursos="
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='cache-control' content='public, max-age=86400'>
        <!--Boots-->
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
        <!-- ECHARTS <script src='https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js'></script>-->
        <!-- FONTAWESOME <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>-->
        <!-- CSS de DataTables-->
        <link rel='stylesheet' href='https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css'>
        <!-- jQuery -->
        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
    if($apartado!='dashboard' && $apartado!=null)
    {
        $recursos.="<!-- JS de DataTables --><script src='https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'></script>";
    }

    if(!empty($recursos))
    {
        echo $recursos;
        //MI CSS - PROPIO DEL SISTEMA
        if(file_exists('../public/css/sistema.php'))
        {
            require_once '../public/css/sistema.php';
        }
        else
        {
            //Si estoy en el index del sistema
            if(file_exists('../../public/css/sistema.php'))
            {
                require_once '../../public/css/sistema.php';
            }
        }
    }


//SESION DEL USUARIO
/*
if(empty($_SESSION['user'])) //si estan vacios siempre te redirije al dashboard
{
    header('Location: ../index.php');
    exit();
}
else
{
    $user_name=$_SESSION['user']->NOMBRE;
    $user_apellido=$_SESSION['user']->APELLIDO;
    $user_idRol=$_SESSION['user']->ID_ROL;
}
*/
