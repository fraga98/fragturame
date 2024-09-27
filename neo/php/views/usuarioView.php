<?php
/*OPTIMIZACION */
if(ob_get_level()===0)
{
    ob_start("ob_gzhandler");
}
/*FIN DE OPTIMIZACION*/

    if(isset($_SESSION['session_bloquear_usuario'])&&$_SESSION['session_bloquear_usuario']==1) //si estan vacios siempre te redirije al dashboard
    {
        header('Location: ../index.php');
        exit();
    }
    else
    {
        /*
        $user_name=$_SESSION['user']->NOMBRE;
        $user_apellido=$_SESSION['user']->APELLIDO;
        $user_idRol=$_SESSION['user']->ID_ROL;
        */
    }
?>
    <!---->
    <section class="row ms-1 me-1 mt-3 mb-5">
        <?php //var_dump($PRUEBA_OBTENCION_DATO);?>
        <span id="contenedorBotoneriaTabla" class="d-flex justify-content-end mb-5">
            <button id="agregar" type="button" class="btn btn-primary btn-sm">
                <?php echo ICONO_AGREGAR.' ';?>Agregar
            </button>
        </span>
        <table id="mytable" class="w-100" border="1">
            <thead>
                <tr style="background-color:#081c26" class="text-white">
                    <th></th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>EMAIL</th>
                    <th>ROL</th>
                    <th>SESION</th>
                    <th>INICIO SESSION</th>
                    <th>BLOQUEO</th>
                    <th>FECHA CREACI&Oacute;N</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>


    <!--Aside derecho "info cliente"--
    <div id="asideDerecheroInfo" style="display: none;">
        <div class="w-100 d-flex justify-content-end" style="position:absolute; top:0; right:0; height: 100vh; background: rgba(0, 0, 0, 0.5)!important; align-items: center;">
            <div class="bg-white rounded me-3 p-3" style="height:90vh; width:400px;">
                <section class="bg-primary p-2">
                    1
                </section>
                <section class="d-flex rounded mt-2 p-2" style="border: 1px solid rgb(198, 198, 198);">
                     <i class="fa-solid fa-circle-up text-success" style="font-size:30px;"></i>
                </section>
                <ul class="d-flex">
                    <li class="me-4">Info</li>
                    <li>Grafico</li>
                </ul>
            </div>
        </div>
    </div>

    <!Modal generico--
    <div id="" class="modal-generico" style="display: none;">
          <div class="w-100 d-flex justify-content-center" style="position:absolute; top:0; right:0; height: 100vh; background: rgba(0, 0, 0, 0.5)!important; align-items: center;">
            Contenedor agregar usuario
            <section id="contenedorAgregarUsuario" class="bg-white rounded me-3 p-3" style="display:none; height:50vh; width:400px;">
                <h5 class="text-center">Agregar usuario</h5>
            </section>
            Contenedor modificar usuario
            <section id="contenedorModificarUsuario" class="bg-white rounded me-3 p-3" style="display:none; height:50vh; width:400px;">
                <h5 class="text-center">Modificar usuario</h5>
                <input type="text" name="nombre" value="<?php echo 'santiago' ?>"> NOMBRE
                <br>
                <input type="text" name="apellido" value="<?php echo 'santiago' ?>"> APELLIDO
            </section>
        </div>
    </div>
    -->
<script type="text/javascript">
$(document).ready(function()
{
//DATA TABLE
    //http://localhost/neo/php/usuario.php?type=4&accion=3 -> consultar a esta url

        $("#mytable").DataTable(
        {
            "processing": false,
            "serverSide": true,
            ajax: {
                url: "usuario.php?type=4&accion=3",
                dataSrc: 'aaData',
            },
            columns: [
                {data:'INFO_ALL'},
                {data:'NOMBRE' },
                {data:'APELLIDO' },
                {data:'EMAIL' },
                {data:'ROL' },
                {data:'SESION' },
                {data:'INICIO' },
                {data:'BLOQUEO' },
                {data:'FECHA_ALTA' },
                {data:'ACCIONES' },
            ]
        });

        //----------------------------------------------------------
        //ACCIONES
        //----------------------------------------------------------

            //CREAR
                $(document).on('click','#agregar',function()
                {
                    $('.modal-generico').fadeIn(300);
                    $('#contenedorAgregarUsuario').show();
                });

            //MODIFICAR
                $(document).on('click','#id_modificar_-1',function()
                {
                    $('.modal-generico').fadeIn(300);
                    $('#contenedorModificarUsuario').show();
                    var id=$(this).attr('data-pk-id');
                });

            //VER MAS
                $(document).on('click','#id_ver_-1',function()
                {
                    $('#asideDerecheroInfo').fadeIn(300);
                    var id=$(this).attr('data-pk-id');

                });

            //CERRAR MODAL
                $(document).on('click','#cerrarAsideDerecho',function()
                {
                    $('#asideDerecheroInfo').fadeOut(300);
                });
//FIN DE DATA TABLE
});
</script>


<?php
ob_end_flush();
?>
