<?php
    session_start();
   
    if (isset($_REQUEST['i'])) {
        $_SESSION['i'] = $_REQUEST['i'];
        $lang = $_REQUEST['i'];
    } else {
        $lang = $_SESSION["i"]; 
    }  

    include_once("../lang/{$lang}.php"); 
    
    if (isset($_REQUEST['e']) && $_REQUEST['e'] != "") {
        $error_message_url = $_REQUEST['e'];
        $error_message = $lang[$error_message_url];
    } else {
        $error_message = $lang['error_default'];
    }
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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/error.css">
</head>
<body>
    <div class="selector-idioma">
        <?php if ($lang['lang'] == 'es'){ ?>
            <div class="icono-idioma">
                <a href="../vistas/error.php?i=en&e=<?=$error_message_url?>"><img src="../vendor/flag-icon/flags/4x3/us.svg" alt=""></a>
                <span>EN</span>
            </div>
        <?php } else { ?>
            <div class="icono-idioma">
                <a href="../vistas/error.php?i=es&e=<?=$error_message_url?>"><img src="../vendor/flag-icon/flags/4x3/es.svg" alt=""></a>
                <span>ES</span>
            </div>
        <?php } ?>       
    </div>
    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 my-auto">
                <div class="card"> 
                    <div class="logo">
                        <img class="img-logo" src="../img/logo.png" alt="">
                        <p><?=$error_message?></p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    
 
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>    
</body>
</html>