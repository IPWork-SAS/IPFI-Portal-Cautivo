<?php 
   
    class Conexion {
        public $form_connection;
        private $tecnologia;

        function __construct()
        {
            $this->DetectTechnology();
            $this->BuildFormConnection();
        }

        function BuildFormConnection() {
            switch ($this->DetectTechnology()) {
                case 'Ruckus':
                    $this->BuildFormRuckus();
                    break;
                
                default:
                    $this->form_connection = '';
                    break;
            }
        }

        function DetectTechnology() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            return $_SESSION['tecnologia'];
        }

        function BuildFormRuckus() {
            $ruckus = new Ruckus();
        }
    }
?>