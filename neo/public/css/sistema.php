<?php
//La idea de poner php aca es que cargue el recurso que necesite cada visual y que el archivo sea mas ligero de cargar
    $url=$_SERVER['REQUEST_URI'];
    $url=parse_url($url)['path'];
    $url=pathinfo($url);
    $apartado=$url['filename'];
?>
<style>
/*GENERICO*/
    *{margin:0px;font-display:swap;}
    h1,h2,h3,h4,h5,h6,b{color:black !important;}
    ul{list-style:none;}
    li{font-size:12px;}
    svg{color:#d0d0d0;height:13px;color:#525252;}
    .border-color{border:1px solid #0000000f;}
    .ocultar-contenedor{display:none;}
/*TEMPLATE*/
    /*DATA TABLE*/
        table{border:none;}
        table thead tr .sorting{font-size:11px;text-align:center !important;border:none;padding:5px!important;}
        th,td{border:none !important;}
        table tbody{font-size:11px;text-align:center;}
        #mytable_length,#mytable_filter{font-size:10px;margin-bottom:20px;text-align:center;}
        #mytable_length [name="mytable_length"]{height:20px;text-align:center;}
        #mytable_filter [type="search"]{height:20px;}
        #mytable_info{font-size:10px;}
        #mytable_paginate{font-size:10px;margin-top:20px;}
    /*ASIDE*/
        .aside{border-right:2px solid #0000000f;}
        .ul-sub-opciones-menu{margin-left:-10px;display:none;}
/*VISUALES*/
    /*DASHBOARD*/
        <?php if($apartado=='indexView'): ?>
            *{color:#383838;}
        <?php endif;?>
    /*USUARIOS*/
        <?php if($apartado=='usuario'):?>
        <?php endif;?>
/*RESPONSIVE*/
    @media(max-width:575.98px){.responsive-login-img{display:none;}}
    @media(max-width:767.98px){.responsive-login-img{display:none;}}
    @media(max-width:991.98px){}
    @media(max-width:1199.98px){}
    @media(max-width:1399.98px){}
</style>
