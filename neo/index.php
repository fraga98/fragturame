<?php
    require_once "php/utilidades/funciones.php";
    require_once "php/utilidades/constantes.php";
    require_once "php/utilidades/conexion.php";

    session_start();
    session_destroy();
?>
</style>
<!DOCTYPE html>

<html lang="es">

    <!--head-->
    <?php require_once 'php/views/templates/head.php';?>
    <body>
        <!--Login-->
        <div class="container-fluid">
            <div class="row vh-100" style="background-color:#081c26;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 d-flex justify-content-center" style="background-color:#081c26;">
                    <form class="col-10" action="php/usuario.php?type=1" method="POST" style="align-content: center; margin-top: -100px;">
                        <div id="contenedorValidaciones" class="text-danger mb-5 p-1">
                            <?php
                            //Mensajes de Validacion
                            foreach($_COOKIE as $campo => $msj)
                            {
                                if(preg_match('/^cookie-validacion-/',$campo))
                                {
                                    echo '* '. $msj.'<br>';
                                }
                            }
                            //Mensaje de usuario bloqueado
                            if(isset($_COOKIE['cookie-usuario-bloqueado']))
                            {
                                  echo '* '. $_COOKIE['cookie-usuario-bloqueado'].'<br>';
                            }
                            ?>
                        </div>
                        <svg class="text-white mb-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-amd" viewBox="0 0 20 16">
                            <path d="m.334 0 4.358 4.359h7.15v7.15l4.358 4.358V0zM.2 9.72l4.487-4.488v6.281h6.28L6.48 16H.2z"/>
                        </svg>
                        <h1 class="text-white">Welcome...</h1>
                        <h5 class="text-white">Logear credenciales</h5>
                        <div class="form-group mt-5">
                            <label for="email" class="text-white">Email</label>
                            <input id="email" type="email" name="email" class="form-control border border-white inputs mt-1" aria-describedby="emailHelp" placeholder="Ingrese email..." value="softwabot@gmail.com">
                            <?php if(getMethod('email') && getMethod('error')): ?>
                                <small class="form-text text-danger ps-2">Campo email vacio</small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password" class="text-white">Password</label>
                            <input id="password" type="password" name="password" class="form-control border border-white inputs mt-1" aria-describedby="passwordHelp" placeholder="Ingrese password..." value="123456+">
                            <?php if(getMethod('password') && getMethod('error')): ?>
                                <small class="form-text text-danger ps-2">Campo password vacio</small>
                            <?php endif; ?>
                        </div>
                        <div class="form-check mt-3 d-flex justify-content-end">
                            <input class="form-check-input" type="checkbox" name="checkseguridad" value="1">
                            <label class="form-check-label text-white ps-2" for="flexCheckDefault">Remember me</label>
                        </div>
                        <!--Modificar password-->
                        <div class="text-end">
                            <a href="<?php echo URL_VIEW_USUARIO_RECORDAR_PASSWORD ?>" style="text-decoration: none;font-size: 12px;">Recordar Password</a>
                        </div>
                        <!---->
                        <button type="submit" class="col-12 btn btn-primary mt-5 <?php echo $ocultarBtnLogin ?>">Login</button>
                    </form>
                </div>
                <div class="responsive-login-img col-9" style="">
                </div>
            </div>
        </div>

    </body>
</html>

<style type="text/css">
    /*PRINCIPALES*/
    *{margin:0;}

    .inputs{
        background: #081c26 !important;
        color: white !important;
        font-size: 15px;
    }
/*FIN DE PRINCIPALES*/
/*RESPONSIVE*/
    @media (max-width: 575.98px){
    }
    @media (max-width: 767.98px){

    }
    @media (max-width: 991.98px){
        .responsive-login-img{
            display: none;
        }
    }
    @media(max-width: 1199.98px){

    }
    @media(max-width: 1399.98px){
    }
/*FIN DEL RESPONSIVE*/
