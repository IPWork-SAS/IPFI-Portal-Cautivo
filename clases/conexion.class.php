<?php 
    include_once '../clases/ruckus.class.php';

    class Conexion {
        public $form_connection;        

        function __construct()
        {
        }

        function BuildFormConnection() {
            switch ($this->DetectTechnology()) {
                case 'Ruckus':
                    $ruckus = new Ruckus();
                    return $ruckus->GetFormConnection();                
                default:
                    return 'action="" method="POST">';
                    break;
            }
        }

        function BuildUrlConection() {
            switch ($this->DetectTechnology()) {
                case 'Ruckus':
                    $ruckus = new Ruckus();
                    return $ruckus->GetUrlConnection();                
                default:
                    return 'http://8.8.8.8';
                    break;
            }   
        }

        function DetectTechnology() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return $_SESSION['tecnologia'];
        }      
    }
?>