<?php
//apartado actual
$url=$_SERVER['REQUEST_URI'];
$url=parse_url($url)['path'];
$url=pathinfo($url);
$apartado=(isset($url['filename'])) ? $url['filename'] : null;

$estiloMarcadOpcion='';

?>
<nav>
    <span class="d-block text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" fill="currentColor" class="bi bi-amd" style="height:100px;color:#081c26;" viewBox="0 0 16 16">
            <path d="m.334 0 4.358 4.359h7.15v7.15l4.358 4.358V0zM.2 9.72l4.487-4.488v6.281h6.28L6.48 16H.2z"/>
        </svg>
    </span>
    <ul>
        <?php
        if($apartado==='dashboard')
        {
             $estiloMarcadOpcion='background:#e6e6e65e;';
        }
        ?>
        <li><a href="dashboard.php?type=-1" style="<?php echo $estiloMarcadOpcion ?>" class="nav-link mt-4 p-1">Dashboard</a></li>
        <!--<li><a href="usuario.php?type=-1" class="nav-link mt-4">Usuarios</a></li>-->
    <?php
    //Visual
        //OBTENGO LA INFO DEL MENU
        $estadoExisteArchivo=cargarArchivo('visual.php');
        if($estadoExisteArchivo)
        {
            $visual=new Visual();
            $datosMenu=$visual->getMenuAside();
        }

        if(isset($datosMenu))
        {
            $urlOpcPrincipal='';
            $subOpciones='';
            $decrementar=-1;
            $estiloMarcadOpcion='';
            foreach ($datosMenu as $opcion => $datos)
            {
                $urlOpcPrincipal=htmlspecialchars($datos['url']);
                $subOpciones=$datos['subopciones'];

                //Si esta en la opcion de la url pinta la opcion actual
                if($opcion===$apartado)
                {
                    $estiloMarcadOpcion='background:#e6e6e65e;';
                }
        ?>
            <li id='btnOpcionMenu_<?php echo $decrementar ?>' data-indice="<?php echo $decrementar ?>" class="rounded p-1 mt-4" style="<?php echo $estiloMarcadOpcion ?>">
                <a href="<?php echo $urlOpcPrincipal ?>" class="nav-link">
                    <?php
                    echo $opcion;
                    if($subOpciones!=null)
                    {
                    ?>
                        <!--Icono de apertura-->
                        <svg  id='iconoAperturaOpc_<?php echo $decrementar ?>' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                        <!--Icono de cierre-->
                        <svg id='iconoCierreOpc_<?php echo $decrementar ?>' class="bi bi-caret-up-fill ocultar-contenedor" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                        </svg>
                    <?php
                    }
                    ?>
                </a>
                <ul id="contenedorSubOpcion_<?php echo $decrementar ?>"  class='ul-sub-opciones-menu'>
                    <?php
                    if($subOpciones!=null)
                    {
                        $subOpcion=json_decode($subOpciones, true);
                        if(is_array($subOpcion))
                        {
                            foreach ($subOpcion as $sub)
                            {
                                $opcSub=(isset($sub['opcion'])) ? $sub['opcion'] : '';
                                $urlSub=(isset($sub['url'])) ? htmlspecialchars($sub['url']) : '#';
                    ?>
                                <li class="mt-3"><a href="<?php echo $urlSub ?>" class="nav-link"><?php echo $opcSub ?></a></li>
                    <?php
                            }
                        }
                    }
                    $decrementar--;
                    ?>
                </ul>
    <?php
        }
    }
    ?>
            </li>
        <li><a href="usuario.php?type=2" class="nav-link mt-4 bg-white text-center">Salir</a></li>
    </ul>
</nav>

<?php unset($datosMenu)?>

<script type="text/javascript">
    $(document).ready(function()
    {
    //MENU
    //Desplazar opcion del menu
        var ultimoIndiceOpcionSeleccionado=null;
        $(document).on('click', "[id^='btnOpcionMenu_']", function()
        {
            var indice=$(this).attr('data-indice');
            if(ultimoIndiceOpcionSeleccionado !== null)
            {
                $('#contenedorSubOpcion_' + ultimoIndiceOpcionSeleccionado).fadeOut(30);
                $('#iconoAperturaOpc_'+ultimoIndiceOpcionSeleccionado).show();
                $('#iconoCierreOpc_'+ultimoIndiceOpcionSeleccionado).hide();
            }
            $('#contenedorSubOpcion_' + indice).fadeIn();
            $('#iconoAperturaOpc_'+indice).hide();
            $('#iconoCierreOpc_'+indice).show();
            ultimoIndiceOpcionSeleccionado=indice;
        });
    //Cerrar opciones desplazadas del menu
        $(document).on('click', "[id^='iconoCierreOpc_']", function()
        {
            var id=this.id;
            var indice = id.split('_').pop();
            console.log(indice);
            $('#iconoCierreOpc_'+indice).hide();
            $('#iconoAperturaOpc_'+indice).show();
            $('#contenedorSubOpcion_' + indice).fadeOut(30);
        });
    //FIN MENU
    });
</script>

