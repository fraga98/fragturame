<?php

//FUNCION PARA REQUERIR ARCHIVOS
    function cargarArchivo($archivo,$datosVisual=array())
    {
        $estadoExisteArchivo=false;
        if(file_exists($archivo))
        {
            $estadoExisteArchivo=true;
            if(!empty($datosVisual))
            {
                extract($datosVisual);
            }
            require_once $archivo;
        }
        else
        {
            echo 'Archivo no incluido, ' .$archivo;
        }
        return $estadoExisteArchivo;
    }

//FUNCTION PARA RECIVIR EL DATO DEL GET O POST

    function getMethod($name,$set=null) //name="nombre"
    {
        if(isset($_POST[$name]))
        {
            return $_POST[$name];
        }
        if(isset($_GET[$name]))
        {
            return $_GET[$name];
        }
        if(isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        if($set!==null)
        {
            return $set;
        }
        return null;
    }

//FUNCION PARA CREAR UNA COOKIE

    //El path es para que la cookie este disponible en todo el sitio
    function crearCOOKIE($nombre,$valor,$path="/")
    {
        $nombreCookie = $nombre;
        $valorCookie = $valor;
        $tiempoExpiracion = time() + (30 * 24 * 60 * 60); // 30 días
        $pathC = $path;

        setcookie($nombreCookie, $valorCookie, $tiempoExpiracion, $pathC);
    }

//FUNCION PARA ELIMINAR UNA COOKIE

    function eliminarCOOKIE($nombre,$path="/")
    {
        $nombreCookie = $nombre;
        $tiempoExpiracion = time() - 3600; // Hora actual menos 1 hora (esto establece la cookie en el pasado)
        $pathC = "/";

        // Eliminar la cookie
        setcookie($nombreCookie, "", $tiempoExpiracion, $pathC);
    }


// FUNCION PARA CACHEAR DATOS

    function crearSetearArchivoCache($key, $data, $ttl=1000)
    {
        $cacheFile = __DIR__ . "../../cache/{$key}.cache";
        $dataToStore = array(
            'data' => $data,
            'expires' => time() + $ttl,
        );
        file_put_contents($cacheFile, serialize($dataToStore));
    }

    function getDatosCache($key)
    {
        $cacheFile = __DIR__ . "../../cache/{$key}.cache";
        if (file_exists($cacheFile))
        {
            $cachedData = unserialize(file_get_contents($cacheFile));
            if($cachedData['expires'] > time())
            {
                return $cachedData['data'];
            }
            else
            {
                unlink($cacheFile); // Elimina el archivo si ha expirado
            }
        }
        return null; // Cache miss
    }
