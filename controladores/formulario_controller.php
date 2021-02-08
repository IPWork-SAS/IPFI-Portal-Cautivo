<?php 
    //Se llaman las librerias y clases necesarias
    include_once "../db/campania.class.php";
    include_once "../db/voucher.class.php";
    include_once "../db/habitacion.class.php";
    include_once "../clases/formulario.class.php";
    include_once "../clases/utilidades.class.php";   

     //Datos de que suministra el AP
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $lang = $_SESSION['i']; 
    include_once("../lang/{$lang}.php"); 

    $formulario = new Formulario($_REQUEST);
    
    $datosFormulario = $formulario->GetDataForm();

    
    if (!$datosFormulario->errorFormulario) {        
        if ($formulario->SaveDataForm()) {
            echo json_encode(['code'=>200]);
            exit;
        } else {            
            //Pendiente Mensaje cuando no guarde los datos
            echo json_encode(['code'=>404]);   
            exit;
        }
    } else {    
        echo json_encode([
            'code'=>404, 
            'errorHabitacion'=>isset($datosFormulario->errorHabitacion) ? $datosFormulario->errorHabitacion : false, 
            'errorNombre'=>isset($datosFormulario->errorNombre) ? $datosFormulario->errorNombre : false,
            'errorVoucher'=>isset($datosFormulario->errorVoucher) ? $datosFormulario->errorVoucher : false, 
            'errorApellidos'=>isset($datosFormulario->errorApellidos) ? $datosFormulario->errorApellidos: false,
            'errorEmail'=>isset($datosFormulario->errorEmail) ? $datosFormulario->errorEmail: false,
            'errorEdad'=>isset($datosFormulario->errorEdad) ? $datosFormulario->errorEdad: false,
            'errorTelefono'=>isset($datosFormulario->errorTelefono) ? $datosFormulario->errorTelefono: false,
            'errorGenero'=>isset($datosFormulario->errorGenero) ? $datosFormulario->errorGenero: false,
            'errorRazonVisita'=>isset($datosFormulario->errorRazonVisita) ? $datosFormulario->errorRazonVisita: false,
            'errorCheck' => isset($datosFormulario->errorCheck) ? $datosFormulario->errorCheck : false,
            'errorMSGHabitacion'=>!empty($datosFormulario->errorMSGHabitacion) ? $lang[$datosFormulario->errorMSGHabitacion] : '',
            'errorMSGVoucher'=>!empty($datosFormulario->errorMSGVoucher) ? $lang[$datosFormulario->errorMSGVoucher]: '',
            'errorMSGNombre'=>!empty($datosFormulario->errorMSGNombre) ? $lang[$datosFormulario->errorMSGNombre] : '',       
            'errorMSGApellidos'=>!empty($datosFormulario->errorMSGApellidos) ? $lang[$datosFormulario->errorMSGApellidos] : '',     
            'errorMSGEmail'=>!empty($datosFormulario->errorMSGEmail) ? $lang[$datosFormulario->errorMSGEmail] : '',     
            'errorMSGEdad'=>!empty($datosFormulario->errorMSGEdad) ? $lang[$datosFormulario->errorMSGEdad] : '', 
            'errorMSGTelefono'=>!empty($datosFormulario->errorMSGTelefono) ? $lang[$datosFormulario->errorMSGTelefono] : '', 
            'errorMSGGenero' => !empty($datosFormulario->errorMSGGenero) ?$lang[$datosFormulario->errorMSGGenero] : '',
            'errorMSGRazonVisita' => !empty($datosFormulario->errorMSGRazonVisita) ?$lang[$datosFormulario->errorMSGRazonVisita] : '',
            'errorMSGCheck' => !empty($datosFormulario->errorMSGCheck) ?$lang[$datosFormulario->errorMSGCheck] : ''           
        ]);
    }
?>
