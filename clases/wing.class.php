<?php

    class Wing {
        //Atributos
        private $hs_server ;
        private $Qv;
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
            $this->tecnologia = 'Wing';
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
            $this->mac_ap = 'No Obtenida';
            $this->ip_cliente = 'No Obtenida';
            if (!isset($params['hs_server'])) {
                $this->dataValidation = false;
                $this->hs_server = '';
            } else {
                $this->hs_server = $params['hs_server'];
            }  
            if (!isset($params['Qv'])) {
                $this->dataValidation = false;
                $this->Qv = '';
            } else {
                $this->Qv = $params['Qv'];
            }  
            if (!isset($params['client_ip'])) {
                $this->dataValidation = false;
                $this->ip_cliente = '';
            } else {
                $this->ip_cliente = $params['client_ip'];
            }  
            if (!isset($params['client_mac'])) {
                $this->dataValidation = false;
                $this->mac_cliente = '';
            } else {
                $this->mac_cliente = $params['client_mac'];
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
            $_SESSION['hs_server'] = $this->hs_server;
            $_SESSION['Qv'] = $this->Qv;
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