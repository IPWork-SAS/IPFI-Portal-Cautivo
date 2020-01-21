<?php
    include_once "../db/campania.class.php";
    include_once "../db/files_campania.class.php";
    include_once "../db/banner_files_campania.class.php";

    session_start();

    if (isset($_REQUEST['i'])) {
        $_SESSION['i'] = $_REQUEST['i'];
        $lang = $_REQUEST['i'];
    } else {
        $lang = $_SESSION["i"]; 
    }  

    include_once("../lang/{$lang}.php"); 

    $username = 'ipfiuser';
    $password = 'ipfiuser.2019';

    $sshTunnelStatus = $_SESSION['sshTunnelStatus'];
    $client_mac = $_SESSION['mac_cliente'];
    $uip = $_SESSION['ip_cliente'];
    $proxy = $_SESSION['proxy'];
    $url = $_SESSION['url'];

    $port = '9997';
    
    if ($_SESSION['sshTunnelStatus'] == '1') {
        $url = 'http://'.$_SESSION['zd_ip'].':'.$port.'/SubscriberPortal/hotspotlogin';
    } else {
        $url = 'http://'.$_SESSION['ip_ap'].':'.$port.'/SubscriberPortal/hotspotlogin';
    }   
    
    if(isset($_SESSION['mac_cliente'])) {
        $campania = new Campania();
        $nombre = strtoupper($campania->getNameUserByMac($_SESSION['mac_cliente']));
    } else {
        $nombre = 'a nuestra red WIFI';
    }

    $fileCampania = new FilesCampania();
    $bannerFilesCampania = new BannerFilesCampania(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$lang['titulo_website']?></title>   
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.css"> 
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.min.css"> 
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
  
     <!-- Agregamos el Slick -->
     <link rel="stylesheet" type="text/css" href="../vendor/slick/slick.css"/>
     <!-- // Add the new slick-theme.css if you want the default styling -->
     <link rel="stylesheet" type="text/css" href="../vendor/slick/slick-theme.css"/>  

     <link rel="stylesheet" href="../css/style.css">
     <link rel="stylesheet" href="../css/banner.css">
     <link rel="stylesheet" href="../css/terminos_condiciones.css">
     
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    

</head>
<style>
    html {
        background-image: url(<?=$fileCampania->GetSRCBackgroundImage()?>);
    }    
</style>
<body>
    <div class="selector-idioma">
        <?php if ($lang['lang'] == 'es'){ ?>
            <div class="icono-idioma">
                <a href="../vistas/banner.php?i=en"><img src="../vendor/flag-icon/flags/4x3/us.svg" alt=""></a>
                <span>EN</span>
            </div>
        <?php } else { ?>
            <div class="icono-idioma">
                <a href="../vistas/banner.php?i=es"><img src="../vendor/flag-icon/flags/4x3/es.svg" alt=""></a>
                <span>ES</span>
            </div>
        <?php } ?>
       
    </div>
    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 my-auto">
                <div class="card"> 
                    <div class="logo">
                        <img class="img-logo" src="<?=$fileCampania->GetSRCIconImageSRC()?>" alt="">
                        <p><?=$lang['bienvenido_usuario'].$nombre.'!'?></p>
                    </div>
                    <div class="container-carrusel">
                        <div class="slider carrousel">
                            <?php
                                foreach ($bannerFilesCampania->GetSRCBannerList() as $key => $value) {                                   
                                    echo '
                                        <div class="banner-img">
                                            <picture>
                                                <source srcset="'.$value->srcImgWeb.'" media="(min-width: 800px)" />                                
                                                <img src="'.$value->srcImgMovil.'" />
                                            </picture>                                            
                                        </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                    <form class="field-btn-conectar" action="<?= $url?>" method="POST">
                        <input type="hidden" name="url" value="<?= $url?>">
                        <input type="hidden" name="proxy" value="<?= $proxy?>">
                        <input type="hidden" name="uip" value="<?= $uip?>">
                        <input type="hidden" name="client_mac" value="<?= $client_mac?>">
                        <input type="hidden" name="username" value="<?= $username?>">
                        <input type="hidden" name="password" value="<?= $password?>">
                        <button class="btn btn-conectar" type="submit"><?=$lang['btn_continuar']?></button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="popup" id="popup">
        <div class="popup-inner">
            <div class="popup__text">
                <div id="incluirTerminosCondiciones" class="container_terminos"></div>
            </div>
            <a class="popup__close" href="#">X</a>
        </div>
    </div>
 
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/terminos_condiciones.js"></script> 
    <script src="../js/banner.js"></script>
    <script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript" src="../vendor/slick/slick.min.js"></script>
    
</body>
</html>