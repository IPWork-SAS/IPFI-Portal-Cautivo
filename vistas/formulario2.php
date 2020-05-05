<?php 
    include_once '../db/campania.class.php';
    include_once '../db/files_campania.class.php';
    include_once '../db/styles_campania.php';
    include_once "../db/banner_files_campania.class.php";
    include_once "../clases/conexion.class.php";
    include_once '../db/terms_conditions_campania.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_REQUEST['i'])) {
        $_SESSION['i'] = $_REQUEST['i'];
        $lang = $_REQUEST['i'];
    } else {
        $lang = $_SESSION["i"]; 
    } 

    include_once("../lang/{$lang}.php");

    //Variable de seleccion de banner fotos = 1 y banner patrocinadores = 2
    
    $campania = new Campania();
    $datosCampania = $campania->GetDatosCampaña();  
    $id_campania = $campania->GetIdCampania();
    
    $fileCampania = new FilesCampania(); 
    $stylesCampania = new StylesCampania();
    $styles = $stylesCampania->GetStylesCampania($id_campania);
    $termConditions = new TermsConditionsCampania();
    $terms = $termConditions->GetTermsConditionsCampania($id_campania);
    $bannerFilesCampania = new BannerFilesCampania(); 
    $tipo_banner = $styles->type_banner; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />      
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$styles->title_portal ? $styles->title_portal : $lang['titulo_form'];?></title>   
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.css"> 
    <link rel="stylesheet" href="../vendor/flag-icon/flag-icon.min.css"> 
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../vendor/slick/slick-theme.css"/>  

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/formulario2.css">
    <link rel="stylesheet" href="../css/terminos_condiciones.css">
    <?php if($tipo_banner == 1) { ?>
        <link rel="stylesheet" href="../css/slider1.css"> 
    <?php } if($tipo_banner == 2) { ?>
        <link rel="stylesheet" href="../css/slider2.css">   
    <?php } else{ 
    ?>  
    
    <?php 
        }

    ?> 
     
    <link rel="stylesheet" href="../css/modal.css">
    
</head>
<style>
    /* Imagen de Fondo */
    html {
        background-image: url(<?=$fileCampania->GetSRCBackgroundImage($id_campania)?>);
    }  
    
    /* Tamaño Logo movil */
    .img-logo {
        width: 250px;
    }

    /* Tamaño Logo Web */ 
    @media (min-width: 992px) {
        .img-logo {
            width: 280px;            
        }     
    }

    
    /* Color del formulario */ 
    .formulario {    
        background: <?=$styles->container_form_color?>;
        color: <?=$styles->container_form_font_color?>;
    }

    /* Color de Fondo Y Letra del Boton */ 
    .btn-conect {
        color: <?=$styles->button_font_color?>;
        background-color: <?=$styles->button_background_color?>;
        border-color: <?=$styles->button_border_color?>;
    }

     /* Color de Fondo Y Letra del Boton on hover */ 
    .btn-conect:hover {
        background-color: <?=$styles->button_background_color?>;
        color: <?=$styles->button_font_color?>;
        filter: brightness(0.8);
    }

    .custom-control-label a {
        color:  #000;
    }

    /* Nuevos estilos formulario 2 desde BD */

   
<?php
    if($styles->static_form != 1){
    ?>
    body::before {
        z-index: -1;
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        /* IE Fallback */
        background-color:  <?=$styles->color_background?>;
        width: 100%;
        height: 100%;
    }

    .img-logo {
        width: <?=$styles->width_logo_movil?>;
    }

    /* Tamaño Logo Web */ 
    @media (min-width: 992px) {
        .img-logo {
            width: <?=$styles->width_logo_web?>;            
        }     
    }

    .flipInX {
        background: <?=$styles->container_form_color?>;
        color: <?=$styles->container_form_font_color?>;
        opacity:1!important;
    }

    .img-logo {
        width: <?=$styles->width_logo_web?>!important;
    }
    @media (max-width: 600px) { 
            .img-logo {  
            width: 105%!important;
            margin-top: 30px;
        }
    }
    .title {
        color: <?=$styles->color_title_portal?>  !important;
    }

    .form button{
        color: <?=$styles->button_font_color?>;
        background-color: <?=$styles->button_background_color?>;
    }
    .form button:hover{
        color: <?=$styles->button_font_color?>;
        background-color: <?=$styles->button_background_color?>;
        filter: brightness(0.8);
    }
    .custom-control-label a {
        color:  <?=$styles->container_form_font_color?>;
    }
        <?php
    }
?>
    
</style>
<body>
    <div class="selector-idioma">
        <?php if ($lang['lang'] == 'es'){ ?>
            <div class="icono-idioma">
                <a href="../vistas/formulario.php?i=en"><img src="../vendor/flag-icon/flags/4x3/us.svg" alt=""></a>
                <span>EN</span>
            </div>
        <?php } else { ?>
            <div class="icono-idioma">
                <a href="../vistas/formulario.php?i=es"><img src="../vendor/flag-icon/flags/4x3/es.svg" alt=""></a>
                <span>ES</span>
            </div>
        <?php } ?>
    </div>

    <?php 
        if($styles->weather_widget == 1){
    ?>
        <div class="content-weather">
            <div class="img-weather">
                <div class="info-weather">
                    <div id="temperatureGroup">
                        <span id="wTemp"></span><span>&deg;C</span>
                    </div>
                    <div id="wSummary"></div>
                    <!-- <div id="geoLoc"></div> -->
                </div>
            </div>
        </div>
    <?php
        }else{
            
        }
    ?>

    <?php if($tipo_banner == 1) { ?>
        <div id="modal-container">
            <div class="modal-background">
                <div class="slideshow" id='slideshow' >
                    <?php
                        foreach ($bannerFilesCampania->GetSRCBannerList($id_campania) as $key => $value) {                                   
                            echo '
                                <img src="'.$value->srcImgWeb.'" alt=""/>
                            ';
                        }
                    ?>
                </div>   
            </div>
        </div>
    <?php } if($tipo_banner == 2) { ?>
        <div id="modal-container">
            <div class="modal-background">
                <div class="slideshow" id='slideshow' >
                    <?php
                        foreach ($bannerFilesCampania->GetSRCBannerList($id_campania) as $key => $value) {                                   
                            echo '
                                <img src="'.$value->srcImgWeb.'" height="200" width="450" alt=""/>
                            ';
                        }
                    ?>
                </div> 
            </div>
        </div>
    <?php } else {
    ?>

    <?php 
        }
    ?>

    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 my-auto">
                <div class="card"> 
                    <div class="logo">                        
                        <img class="img-logo" src="<?=$fileCampania->GetSRCIconImageSRC($id_campania)?>" alt="">
                    </div>
                    <div class="form animated flipInX">
                        <h2 class="title" ><?=$styles->title_portal ? $styles->title_portal : $lang['titulo_form'];?></h2>
                        <form action="">
                            <?php
                            // Se valida que exista el campo nombre y apellidos en los datos de la campania, si existe se muestra el contenido html. 
                            if((isset($datosCampania['nombre']) && isset($datosCampania['apellidos'])) && (isset($datosCampania['estado_nombre']) || isset($datosCampania['estado_apellidos']))) {
                                echo '
                                    <div class="form-group" name="form_group_nombre" id="form_group_nombre">
                                        <input type="text" required autocomplete="off" onkeyup="dropInvalidCharactersNombre();" id="nombre" name="nombre" onfocus="restaurarInputNombre()" placeholder="'.$lang['nombre_form'].'">
                                        <div class="container-error-span">
                                            <span id="errorMSGNombre"></span>
                                        </div>
                                    </div>
                                    <div class="form-group" name="form_group_apellidos" id="form_group_apellidos">
                                        <input type="text" autocomplete="off" required onkeyup="dropInvalidCharactersApellidos();" id="apellidos" name="apellidos" onfocus="restaurarInputApellidos()" placeholder="'.$lang['apellidos_form'].'">
                                        <div class="container-error-span">
                                            <span id="errorMSGApellidos"></span>
                                        </div>                                        
                                    </div>
                                ';
                            } 
                            
                             // Se valida que exista el campo email en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['email']) && isset($datosCampania['estado_email'])) {
                                echo '
                                <div class="form-group" id="form_group_email"  name="form_group_email">
                                    <input type="email" required id="email" name="email" onfocus="restaurarInputEmail()" placeholder="'.$lang['email_form'].'">
                                    <div class="container-error-span">
                                        <span id="errorMSGEmail"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo telefono en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['telefono']) && isset($datosCampania['estado_telefono'])) {
                                echo '
                                <div class="form-group" id="form_group_telefono"  name="form_group_telefono">
                                    <input type="tel" onkeyup="dropInvalidCharactersTelefono()"  id="telefono" name="telefono" onfocus="restaurarInputTelefono()" placeholder="'.$lang['celular_form'].'" required>
                                    <div class="container-error-span">    
                                        <span id="errorMSGTelefono"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo telefono en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['edad']) && isset($datosCampania['estado_edad'])) {
                                echo '
                                <div class="form-group" id="form_group_edad"  name="form_group_edad">
                                    <input type="text" onkeyup="dropInvalidCharactersAge()" id="edad" name="edad" onfocus="restaurarInputEdad()" placeholder="'.$lang['edad_form'].'" maxlength = "2" required>
                                    <div class="container-error-span">
                                        <span id="errorMSGEdad"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo genero en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['genero']) && isset($datosCampania['estado_genero'])) {
                                echo '
                                <div class="form-group" id="form_group_genero"  name="form_group_genero">
                                    <select id="genero"  name="genero" required onfocus="restaurarInputGenero()">
                                        <option selected value="">'.$lang['seleccion_genero_form'].'</option>
                                        <option value="Hombre">'.$lang['masculino_genero_form'].'</option>
                                        <option value="Mujer">'.$lang['femenino_genero_form'].'</option>
                                        <option value="Otro">'.$lang['otro_genero_form'].'</option>
                                    </select>
                                    <div class="container-error-span">
                                        <span id="errorMSGGenero"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo numero de habitacion en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_habitacion']) && isset($datosCampania['estado_num_habitacion'])) {
                                echo '
                                <div class="form-group" id="form_group_habitacion"  name="form_group_habitacion">
                                    <input type="text" required autocomplete="off" onkeyup="dropInvalidCharactersHabitacion()" id="num_habitacion" name="num_habitacion" onfocus="restaurarInputHabitacion()" placeholder="'.$lang['num_habitacion_form'].'">
                                    <div class="container-error-span">
                                        <span id="errorMSGHabitacion"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo voucher en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_voucher']) && isset($datosCampania['estado_num_voucher'])) {
                                echo '
                                <div class="form-group" id="form_group_voucher" name="form_group_voucher">
                                    <input type="text" required autocomplete="off" id="num_voucher" name="num_voucher" onfocus="restaurarInputVoucher()" placeholder="'.$lang['voucher_form'].'">
                                    <div class="container-error-span">
                                        <span id="errorMSGVoucher"></span>
                                    </div>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo voucher en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['razon_visita']) && isset($datosCampania['estado_razon_visita'])) {
                                echo '
                                <div class="form-group" id="form_group_razon_visita"  name="form_group_razon_visita">
                                    <select id="razon_visita"  name="razon_visita" required onfocus="restaurarInputRazonVisita()">
                                        <option selected value="">'.$lang['seleccion_razon_visita_form'].'</option>
                                        <option value="Vacaciones">'.$lang['vacaciones_razon_visita_form'].'</option>
                                        <option value="Trabajo">'.$lang['trabajo_razon_visita_form'].'</option>
                                        <option value="Congreso">'.$lang['congreso_razon_visita_form'].'</option>
                                        <option value="Convencion">'.$lang['convencion_razon_visita_form'].'</option>
                                        <option value="Otro">'.$lang['otro_razon_visita_form'].'</option>
                                    </select>
                                    <div class="container-error-span">
                                        <span id="errorMSGRazonVisita"></span>
                                    </div>
                                </div>
                                ';
                            }
                        ?>

                        <div class="form-group check-terminos" id="form_group_check" name="form_group_check">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="customSwitches" required onclick="restaurarInputCheck()">
                                <label class="custom-control-label" for="customSwitches">
                                    <a href="#popup"><?= $lang['terminos_link'];?></a>
                                </label>
                            </div>
                            <span id="errorMSGCheck"></span>
                        </div>
                            
                        <button type="submit" id="submit"><?= $lang['btn_continuar'];?></button>
                      </form>
                    </div>
                    <div class="footer">
                        <div class="page-footer font-small">
                            <!-- Copyright -->
                            <div class="footer-copyright text-center py-3">
                                Powered by <a href="https://ipwork.com.co/"> IPwork</a> (C) Copyright 2020
                            </div>
                            <!-- Copyright -->
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div> 
    
    <div class="popup" id="popup">
        <div class="popup-inner">
            <div class="popup__text">
                <div id="incluirTerminosCondiciones_es" class="container_terminos">
                        <div class="logo_terminos">
                            <img src="<?=$fileCampania->GetSRCIconImageSRC($id_campania)?>" alt="">
                        </div>
                        <?php 
                            if ($lang['lang'] == 'es') {
                                echo $terms->terms_conditions_es;
                            } else {
                                echo $terms->terms_conditions_en;
                            }
                        ?>
                </div>              
            </div>
            <a class="popup__close" href="#">X</a>
        </div>
    </div>
 
    <script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../vendor/slick/slick.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/formulario.js"></script>
    <script type="text/javascript" src="../js/modal.js"></script>
    <?php 
        if($styles->weather_widget == 1){
    ?>
        <script type="text/javascript" src="../js/weather.js"></script>
    <?php
        }else{
            
        }
    ?>
    <?php if($tipo_banner == 1) { ?>
        <script src="../js/slider1.js"></script> 
    <?php } else { ?>
        <script src="../js/slider2.js"></script>
    <?php } ?>  
</body>
</html>