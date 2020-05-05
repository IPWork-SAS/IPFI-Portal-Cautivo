<?php

    class Extreme {
        //Atributos
        private $hwc_ip ;
        private $hwc_port;
        private $ip_ap;
        private $mac_ap;
        private $ip_cliente;
        private $ssid;
        private $tecnologia;
        private $accesPointTechology;
        
        public $dataValidation; 
        public $mac_cliente;     


        function __construct() {              
        }

        function init($params) {
            $this->tecnologia = 'Extreme';
            switch ($this->CheckAPTechnology($params)) {
                case 'default':
                    if($this->ValidateDefaultParametersURL($params)) {
                        $this->SetParametersDefaultSession();
                    } 
                    break;               
                default:
                    $this->dataValidation = false;
                    break;
            }  
        }

        function CheckAPTechnology($params) {
            //Se deben investigar los diferentes tipos de AP Extreme que existen y sus configuraciones
            $this->accesPointTechology = "default";
            return $this->accesPointTechology;
        }

        function ValidateDefaultParametersURL($params) {
            $this->dataValidation = true;
            $this->ip_ap = 'No Obtenida';
            $this->ip_cliente = 'No Obtenida';
            if (!isset($params['hwc_ip'])) {
                $this->dataValidation = false;
                $this->hwc_ip = '';
            } else {
                $this->hwc_ip = $params['hwc_ip'];
            }  
            if (!isset($params['hwc_port'])) {
                $this->dataValidation = false;
                $this->hwc_port = '';
            } else {
                $this->hwc_port = $params['hwc_port'];
            }  
            if (!isset($params['apmac'])) {
                $this->dataValidation = false;
                $this->mac_ap = '';
            } else {
                $this->mac_ap = $params['apmac'];
            }  
            if (!isset($params['mac'])) {
                $this->dataValidation = false;
                $this->mac_cliente = '';
            } else {
                $this->mac_cliente = $params['mac'];
            }                
            if (!isset($params['ssid'])) {
                $this->dataValidation = false;
                $this->ssid = '';
            } else {
                $this->ssid = $params['ssid'];
            } 
            
            return $this->dataValidation;
        }

    
        function SetParametersDefaultSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }           
       
            $_SESSION['tecnologia'] = $this->tecnologia;
            $_SESSION['tipo_tecnologia'] = $this->accesPointTechology;
            $_SESSION['hwc_ip'] = $this->hwc_ip;
            $_SESSION['hwc_port'] = $this->hwc_port;
            $_SESSION['ip_ap'] = $this->ip_ap;
            $_SESSION['mac_ap'] = $this->mac_ap;
            $_SESSION['mac_cliente'] = $this->mac_cliente;
            $_SESSION['ip_cliente'] = $this->ip_cliente;
            $_SESSION['ssid'] = $this->ssid;
        }

        function GetFormConnection() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }    
            $tipo_tecnologia = $_SESSION['tipo_tecnologia']; 

            switch ($tipo_tecnologia) {
                case 'default':
                    //falta definir este mecanismo
                    return '';
                default:
                    return '';
                    break;
            }       
        }

        function Connect() {

        }
    }
?>