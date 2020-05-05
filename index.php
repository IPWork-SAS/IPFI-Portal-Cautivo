<?php
    include_once('./controladores/validacion_controller.php');
    include_once('./clases/validadorURL.class.php');
    include_once('./clases/validadorCliente.class.php');
    include_once('./clases/utilidades.class.php');
    include_once('./clases/conexion.class.php');
    include_once 'config.php';
    

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    } 

    session_destroy();

    $tipo_formulario = BD_PARAMETERS['database']['type_form'];

    
    $utilidades = new Utilidades();
    $utilidades->DetectLanguage();

    $validacionURL = new ValidadorURL($_SERVER['REQUEST_URI']); 
    if ($validacionURL->urlValida) {
        $validarCliente = new ValidadorCliente($validacionURL->macCliente);
        if ($validarCliente->clienteValido) {
            if($validarCliente->clienteNuevo) {
                switch ($tipo_formulario) {
                    case 1:
                        header('Location: vistas/formulario1.php');
                        break;
                    case 2:
                        header('Location: vistas/formulario2.php');
                        break;
                    case 3:
                        header('Location: vistas/formulario3.php');
                        break;                    
                    default:
                        header('Location: vistas/formulario1.php');
                        break;
                }                
            } else {
                //Aca se realiza la conexion automatica o se muestra una pantalla de publicidad
                // $conexion = new Conexion();
                // header('Location: '.$conexion->BuildUrlConection());
                header('Location: vistas/banner.php');
            }
        } else {
            header('Location: vistas/error.php?e='.$validarCliente->error);  
        }
    } else {
        header('Location: vistas/error.php?e='.$validacionURl->error);  
    }
?>  