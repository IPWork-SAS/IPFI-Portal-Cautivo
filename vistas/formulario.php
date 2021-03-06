<?php 
    include_once '../db/campania.class.php';
    include_once '../db/files_campania.class.php';
    include_once '../db/styles_campania.php';
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

    $campania = new Campania();

    if(isset($_SESSION['mac_cliente'])) {        
       if ($campania->ValidateExistClientByMac($_SESSION['mac_cliente'])) {
            header('Location: banner.php');
       }
    } 

    include_once("../lang/{$lang}.php");
    
    
    $datosCampania = $campania->GetDatosCampaña();  
    $id_campania = $campania->GetIdCampania();
    
    $fileCampania = new FilesCampania(); 
    $stylesCampania = new StylesCampania();
    $styles = $stylesCampania->GetStylesCampania($id_campania);
    $termConditions = new TermsConditionsCampania();
    $terms = $termConditions->GetTermsConditionsCampania($id_campania);
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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/formulario.css">
    <link rel="stylesheet" href="../css/terminos_condiciones.css">

    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    
</head>
<style>
    html {
        background-image: url(<?=$fileCampania->GetSRCBackgroundImage($id_campania)?>);
    }  
    
    .img-logo {
        width: <?=$styles->width_logo_movil?>;
        margin: <?=$styles->margin_logo_movil?>;
    }

    .title {
<<<<<<< HEAD
        color: <?=$styles->color_title_portal?>  !important;
=======
        color: <?=$styles->color_title_portal?> !important;
>>>>>>> 6729c67a4d2e1aa7d26aececb3ca353cb40946e8
    }

    @media (min-width: 992px) {
        .img-logo {
            width: <?=$styles->width_logo_web?>;
            margin: <?=$styles->margin_logo_web?>;
        }     
    }

    .formulario {    
        background: <?=$styles->container_form_color?>;
        color: <?=$styles->container_form_font_color?>;
    }

    .btn-conect {
        color: <?=$styles->button_font_color?>;
        background-color: <?=$styles->button_background_color?>;
        border-color: <?=$styles->button_border_color?>;
    }

    .btn-conect:hover {
        background-color: <?=$styles->button_hover_background_color?>;
        color: <?=$styles->button_hover_font_color?>;
    }

    .custom-control-input:checked~.custom-control-label::before {
        border-color: <?=$styles->checkbox_terms_border_color?>;
        background-color: <?=$styles->checkbox_terms_background_color?>;
    }   
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

    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 my-auto">
                <div class="card"> 
                    <div class="logo">                        
                        <img class="img-logo" src="<?=$fileCampania->GetSRCIconImageSRC($id_campania)?>" alt="">
                        <p class="title"><?=$styles->title_portal ? $styles->title_portal : $lang['titulo_form'];?></p>
                    </div>
                    <form class="formulario"  action="">
                        <input type="hidden" name="os" id="os"> 
                        <input type="hidden" name="lang" id="lang" value="<?=$lang['lang']?>"> 
                        
                        <?php 
                            // Se valida que exista el campo nombre y apellidos en los datos de la campania, si existe se muestra el contenido html. 
                            if((isset($datosCampania['nombre']) && isset($datosCampania['apellidos'])) && (isset($datosCampania['estado_nombre']) || isset($datosCampania['estado_apellidos']))) {
                                echo '
                                <div class="form-row">
                                    <div class="form-group col-md-6" name="form_group_nombre" id="form_group_nombre">
                                        <input type="text" required autocomplete="off" onkeyup="dropInvalidCharactersNombre();" class="form-control form-control-sm" id="nombre" name="nombre" onfocus="restaurarInputNombre()" placeholder="'.$lang['nombre_form'].'">
                                        <span id="errorMSGNombre"></span>
                                    </div>
                                    <div class="form-group col-md-6" name="form_group_apellidos" id="form_group_apellidos">
                                        <input type="text" autocomplete="off" required onkeyup="dropInvalidCharactersApellidos();" class="form-control form-control-sm" id="apellidos" name="apellidos" onfocus="restaurarInputApellidos()" placeholder="'.$lang['apellidos_form'].'">
                                        <span id="errorMSGApellidos"></span>
                                    </div>
                                </div>
                                ';
                            } 
                            // Se valida que exista el campo email en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['email']) && isset($datosCampania['estado_email'])) {
                                echo '
                                <div class="form-group" id="form_group_email"  name="form_group_email">
                                    <input type="email" required class="form-control form-control-sm" id="email" name="email" onfocus="restaurarInputEmail()" placeholder="'.$lang['email_form'].'">
                                    <span id="errorMSGEmail"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo telefono en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['telefono']) && isset($datosCampania['estado_telefono'])) {
                                echo '
                                <div class="form-group" id="form_group_telefono"  name="form_group_telefono">
                                <input type="tel" onkeyup="dropInvalidCharactersTelefono()"  class="form-control form-control-sm" id="telefono" name="telefono" onfocus="restaurarInputTelefono()" placeholder="'.$lang['celular_form'].'" required>
                                    <span id="errorMSGTelefono"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo telefono en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['edad']) && isset($datosCampania['estado_edad'])) {
                                echo '
                                <div class="form-group" id="form_group_edad"  name="form_group_edad">
                                    <input type="text" onkeyup="dropInvalidCharactersAge()" class="form-control form-control-sm" id="edad" name="edad" onfocus="restaurarInputEdad()" placeholder="'.$lang['edad_form'].'" maxlength = "2" required>
                                    <span id="errorMSGEdad"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo genero en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['genero']) && isset($datosCampania['estado_genero'])) {
                                echo '
                                <div class="form-group" id="form_group_genero"  name="form_group_genero">
                                    <select id="genero"  name="genero" class="form-control form-control-sm" required onfocus="restaurarInputGenero()">
                                        <option selected value="">'.$lang['seleccion_genero_form'].'</option>
                                        <option value="Hombre">'.$lang['masculino_genero_form'].'</option>
                                        <option value="Mujer">'.$lang['femenino_genero_form'].'</option>
                                        <option value="Otro">'.$lang['otro_genero_form'].'</option>
                                    </select>
                                    <span id="errorMSGGenero"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo numero de habitacion en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_habitacion']) && isset($datosCampania['estado_num_habitacion'])) {
                                echo '
                                <div class="form-group" id="form_group_habitacion"  name="form_group_habitacion">
                                    <input type="text" required autocomplete="off" onkeyup="dropInvalidCharactersHabitacion()" class="form-control form-control-sm" id="num_habitacion" name="num_habitacion" onfocus="restaurarInputHabitacion()" placeholder="'.$lang['num_habitacion_form'].'">
                                    <span id="errorMSGHabitacion"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo voucher en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['num_voucher']) && isset($datosCampania['estado_num_voucher'])) {
                                echo '
                                <div class="form-group" id="form_group_voucher" name="form_group_voucher">
                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="num_voucher" name="num_voucher" onfocus="restaurarInputVoucher()" placeholder="'.$lang['voucher_form'].'">
                                    <span id="errorMSGVoucher"></span>
                                </div>
                                ';
                            }
                            // Se valida que exista el campo voucher en los datos de la campania, si existe se muestra el contenido html. 
                            if (isset($datosCampania['razon_visita']) && isset($datosCampania['estado_razon_visita'])) {
                                echo '
                                <div class="form-group" id="form_group_razon_visita"  name="form_group_razon_visita">
                                    <select id="razon_visita"  name="razon_visita" class="form-control form-control-sm" required onfocus="restaurarInputRazonVisita()">
                                        <option selected value="">'.$lang['seleccion_razon_visita_form'].'</option>
                                        <option value="Vacaciones">'.$lang['vacaciones_razon_visita_form'].'</option>
                                        <option value="Trabajo">'.$lang['trabajo_razon_visita_form'].'</option>
                                        <option value="Congreso">'.$lang['congreso_razon_visita_form'].'</option>
                                        <option value="Convencion">'.$lang['convencion_razon_visita_form'].'</option>
                                        <option value="Otro">'.$lang['otro_razon_visita_form'].'</option>
                                    </select>
                                    <span id="errorMSGRazonVisita"></span>
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

                        <div class="form-btn">
                            <button type="submit" id="submit" class="btn btn-conect"><?= $lang['btn_continuar'];?></button>
                        </div>                           
                    </form>
                    <div class="footer">
                        <div class="page-footer font-small">
                            <!-- Copyright -->
                            <div class="footer-copyright text-center py-3">
                                Powered by <a href="https://ipwork.com.co/"> IPwork</a> (C) Copyright 2019
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
 
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/formulario.js"></script>

</body>
</html>