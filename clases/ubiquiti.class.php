<?php

    class Ubiquiti {
        //Atributos
        private $unifiServer;
        private $unifiUser;
        private $unifiPass;
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
            $this->tecnologia = 'Ubiquiti';
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
            //estos datos no se si se pueden obtener de la URL y si ese usuario es el de radius deberia serlo
            $this->unifiServer = 'https://10.152.1.15:8443';
            $this->unifiUser = 'IPwork';
            $this->unifiPass = 'IPwork2019';
            if (!isset($params['ap'])) {
                $this->dataValidation = false;
                $this->mac_ap = '';
            } else {
                $this->mac_ap = $params['ap'];
            }   
            if (!isset($params['id'])) {
                $this->dataValidation = false;
                $this->mac_cliente = '';
            } else {
                $this->mac_cliente = $params['id'];
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
            $_SESSION['unifiServer'] = $this->unifiServer;
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