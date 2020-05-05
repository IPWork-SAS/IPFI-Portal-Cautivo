<?php 
    include_once('utilidades.class.php');
    include_once('../db/voucher.class.php');
    include_once('../db/habitacion.class.php');
    include_once('../db/campania.class.php');
    include_once('../clases/radius.class.php');

    class Formulario {
        
        private $dataFormulario;
        private $dataWIFI;
        private $arrayElementsForm;

        private $utilidades;

        function __construct($formRequest)
        { 
            $this->InitializeVariables();   
            $this->SetFormElements($formRequest);
            $this->SetDataWifi();
        }

        public function GetDataForm() {
            return (object)$this->dataFormulario;
        }

        public function GetDataWIFI() {
            return (object)$this->dataWIFI;
        }

        public function SaveDataForm() {
            $dataClient = $this->GetDataCLient();           
            $campania = new Campania();
            $voucher = new Voucher();
            
            if(isset($dataClient['num_voucher'])) {
                $voucher->UpdateVoucherState($dataClient['num_voucher'], $campania->GetCampania());                
            }
            //Se guardan los datos de la campaña en BD
            if($campania->SaveDataClient($dataClient)){
                $radius = new Radius();    
                if (!$this->ExistUserRadius($dataClient)) {
                    if($radius->AddUser($campania)) {
                        return true;
                    } else {
                        return false;
                    } 
                } else {
                    return true;
                } 
            } else {
                return false;
            }        
        }

        function ExistUserRadius($dataClient) {
            $campania = new Campania();
            //Hack para cuando el voucher es unico entonces se valida por mac y no por voucher o email
            return $campania->ValidateExistUserRadiusByMac($dataClient['mac_cliente']);
            // if (array_key_exists('num_voucher', $dataClient)) {                
            //     return $campania->ValidateExistUserRadiusByVoucher($dataClient['num_voucher']);
            // } else if (array_key_exists('email', $dataClient)) {
            //     return $campania->ValidateExistUserRadiusByEmail($dataClient['email']);
            // } 
            // else {
            //     return false;
            // }
        }
        
        function GetDataCLient() {
            $dataCLient = array();
            foreach ($this->arrayElementsForm as $formElement) {
                $dataClient[$formElement] = $this->dataFormulario[$formElement];
            }

            foreach ($this->dataWIFI as $key => $value) {
                $dataClient[$key] = $value;
            }

            return $dataClient;
        }

        function SetDataWifi() {
             //Datos de que suministra el AP
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $this->dataWIFI['ip_ap'] = isset($_SESSION['ip_ap']) ? trim($_SESSION['ip_ap']) : '';   
            $this->dataWIFI['mac_ap'] = isset($_SESSION['mac_ap']) ? trim($_SESSION['mac_ap']) : '';  
            $this->dataWIFI['mac_cliente'] = isset($_SESSION['mac_cliente']) ? trim($_SESSION['mac_cliente']) : '';  
            $this->dataWIFI['ip_cliente'] = isset($_SESSION['ip_cliente']) ? trim($_SESSION['ip_cliente']) : '';  
            $this->dataWIFI['ssid'] = isset($_SESSION['ssid']) ? trim($_SESSION['ssid']) : '';
        }

        function InitializeVariables() {
            $this->utilidades = new Utilidades();
            $this->dataFormulario = array();
            $this->dataWIFI = array();
            $this->arrayElementsForm = array();
            $this->dataFormulario['errorFormulario'] = false;  
        }

        function SetFormElements($formRequest) {   
            foreach ($formRequest as $key => $value) {
                if ($key == 'nombre') {
                    array_push($this->arrayElementsForm, $key);
                    $nombre = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->ValidateNombre($nombre);
                }
                if ($key == 'apellidos') {
                    array_push($this->arrayElementsForm, $key);
                    $apellidos = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->ValidateApellidos($apellidos);
                }
                if ($key == 'num_habitacion') {
                    array_push($this->arrayElementsForm, $key);
                    $num_habitacion = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->dataFormulario['apellidos'] = $apellidos;
                    $this->ValidateHabitacion($num_habitacion);
                }
                if ($key == 'num_voucher') {
                    array_push($this->arrayElementsForm, $key);
                    $num_voucher = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->dataFormulario['num_voucher'] = $num_voucher;
                    $this->ValidateVoucher($num_voucher);
                }
                if ($key == 'razon_visita') {
                    array_push($this->arrayElementsForm, $key);
                    $razon_visita = $value;
                    $this->dataFormulario['razon_visita'] = $razon_visita;
                    $this->ValidateRazonVisita($razon_visita);
                }
                if ($key == 'email') {
                    array_push($this->arrayElementsForm, $key);
                    $email = strtolower($this->utilidades->removeAccents(trim($value)));
                    $this->dataFormulario['email'] = $email;
                    $this->ValidateEmail($email);
                }
                if ($key == 'edad') {
                    array_push($this->arrayElementsForm, $key);
                    $edad = $value;
                    $this->dataFormulario['edad'] = $edad;
                    $this->ValidateEdad($edad);
                }
                if ($key == 'telefono') {
                    array_push($this->arrayElementsForm, $key);
                    $telefono = $value;
                    $this->dataFormulario['telefono'] = $telefono;
                    $this->ValidateTelefono($telefono);
                }
                if ($key == 'genero') {
                    array_push($this->arrayElementsForm, $key);
                    $genero = $value;
                    $this->dataFormulario['genero'] = $genero;
                    $this->ValidateGenero($genero);
                }
                if ($key == 'os') {  
                    array_push($this->arrayElementsForm, $key);                  
                    $os = $value;
                    $this->dataFormulario['os'] = $os;
                    $this->ValidateSistemaOperativo($os);
                }
                //Datos que se omiten al guardar la informacion
                if ($key == 'check') {
                    $check = $value;
                    $this->ValidateTerminosCondiciones($check);
                }
            }  
        }

        function ValidateNombre($nombre) { 
            if (empty($nombre)) {
                $this->dataFormulario['errorMSGNombre']  = 'error_nombre_vacio';
                $this->dataFormulario['errorNombre'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if(!preg_match("/^[a-zA-Z'-]/", $nombre)) {
                    $this->dataFormulario['errorMSGNombre'] = 'error_nombre_estructura';
                    $this->dataFormulario['errorNombre'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (strlen($nombre) < 3) {
                    $this->dataFormulario['errorMSGNombre'] = 'error_nombre_longitud';
                    $this->dataFormulario['errorNombre'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGNombre'] = '';
                    $this->dataFormulario['errorNombre'] = false;;   
                }
            }            

            $this->dataFormulario['nombre'] = $nombre;            
        }
    
        function ValidateApellidos($apellido) {        
            if (empty($apellido)) {
                $this->dataFormulario['errorMSGApellidos'] = 'error_apellido_vacio';
                $this->dataFormulario['errorApellidos'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if(!preg_match("/^[a-zA-Z'-]/", $apellido)) {
                    $this->dataFormulario['errorMSGApellidos']= 'error_apellido_estructura';
                    $this->dataFormulario['errorApellidos'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (strlen($apellido) < 3) {
                    $this->dataFormulario['errorMSGApellidos'] = 'error_apellido_longitud';
                    $this->dataFormulario['errorApellidos'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGApellidos'] = '';
                    $this->dataFormulario['errorApellidos'] = false;
                }   
            }          

            $this->dataFormulario['apellidos'] = $apellido;
        }
    
        function ValidateHabitacion($num_habitacion) {
            $habitacion = new Habitacion();

            if(empty($num_habitacion)) {
                $this->dataFormulario['errorMSGHabitacion'] =  'error_num_habitacion_vacio';
                $this->dataFormulario['errorHabitacion'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if (!$habitacion->validateHabitacion($num_habitacion)) {
                    $this->dataFormulario['errorMSGHabitacion'] = 'error_num_habitacion';
                    $this->dataFormulario['errorHabitacion'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGHabitacion'] = '';
                    $this->dataFormulario['errorHabitacion'] = false;
                }
            }            

            $this->dataFormulario['num_habitacion'] = $num_habitacion;
        } 
    
        function ValidateVoucher($num_voucher) {            
            $voucher = new Voucher();
            $campania = new Campania();        
            if(empty($num_voucher)) {
                $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_vacio';
                $this->dataFormulario['errorVoucher'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if (!$voucher->validateExistVoucher($num_voucher, $campania->GetIdCampania())) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_existencia';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if ($voucher->validateUsesVoucher($num_voucher)) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_usos';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (!$voucher->ValidateVoucherExpiration($num_voucher)) {
                    $this->dataFormulario['errorMSGVoucher'] =  'error_voucher_expiration';
                    $this->dataFormulario['errorVoucher'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGVoucher'] = '';
                    $this->dataFormulario['errorVoucher'] = false;
                }  
            }           

            $this->dataFormulario['num_voucher'] = $num_voucher;             
        }

        function ValidateEmail($email) {                  
            if(empty($email)) {
                $this->dataFormulario['errorMSGEmail'] =  'error_email_vacio';
                $this->dataFormulario['errorEmail'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->dataFormulario['errorMSGEmail'] =  'error_email_estructura';
                    $this->dataFormulario['errorEmail'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGEmail'] = '';
                    $this->dataFormulario['errorEmail'] = false;
                }  
            }           

            $this->dataFormulario['email'] = $email;             
        }

        function ValidateTelefono($telefono) {                  
            if(empty($telefono)) {
                $this->dataFormulario['errorMSGTelefono'] =  'error_telefono_vacio';
                $this->dataFormulario['errorTelefono'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if (strlen($telefono) < 10) {
                    $this->dataFormulario['errorMSGTelefono'] =  'error_telefono_min_longitud';
                    $this->dataFormulario['errorTelefono'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else if (strlen($telefono) > 13) {
                    $this->dataFormulario['errorMSGTelefono'] =  'error_telefono_max_longitud';
                    $this->dataFormulario['errorTelefono'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGTelefono'] = '';
                    $this->dataFormulario['errorTelefono'] = false;
                }  
            }          

            $this->dataFormulario['telefono'] = $telefono;             
        }

        function ValidateEdad($edad) {                  
            if(empty($edad)) {
                $this->dataFormulario['errorMSGEdad'] =  'error_edad_vacio';
                $this->dataFormulario['errorEdad'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                if ((int)($edad) < 18) {
                    $this->dataFormulario['errorMSGEdad'] =  'error_edad_min';
                    $this->dataFormulario['errorEdad'] = true;
                    $this->dataFormulario['errorFormulario'] = true;
                } else {
                    $this->dataFormulario['errorMSGEdad'] = '';
                    $this->dataFormulario['errorEdad'] = false;
                }  
            }         

            $this->dataFormulario['edad'] = $edad;             
        }

        function ValidateGenero($genero) {                  
            if(empty($genero)) {
                $this->dataFormulario['errorMSGGenero'] =  'error_genero_vacio';
                $this->dataFormulario['errorGenero'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                $this->dataFormulario['errorMSGGenero'] = '';
                $this->dataFormulario['errorGenero'] = false; 
            }         

            $this->dataFormulario['genero'] = $genero;             
        }

        
        function ValidateRazonVisita($razon_visita) {                  
            if(empty($razon_visita)) {
                $this->dataFormulario['errorMSGRazonVisita'] =  'error_razon_visita_vacio';
                $this->dataFormulario['errorRazonVisita'] = true;
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                $this->dataFormulario['errorMSGRazonVisita'] = '';
                $this->dataFormulario['errorRazonVisita'] = false; 
            }         

            $this->dataFormulario['razon_visita'] = $razon_visita;             
        }

    
        function ValidateTerminosCondiciones($check) {      
            if ($check == 'false') {
                $this->dataFormulario['errorMSGCheck'] =  'error_terminos_condiciones';
                $this->dataFormulario['errorCheck']  = true; 
                $this->dataFormulario['errorFormulario'] = true;
            } else {
                $this->dataFormulario['errorMSGCheck'] =  '';
                $this->dataFormulario['errorCheck']  = false; 
            }

            $this->dataFormulario['check'] = $check;            
        }
    
        function ValidateSistemaOperativo($os) {
            if ($os == '') {
                $this->dataFormulario['os'] = 'Otro';   
            }
        }
    }

   
?>