<?php 
    include_once('ruckus.class.php');
    include_once('extreme.class.php');
    include_once('ubiquiti.class.php');
    include_once('wing.class.php');
    

    class ValidadorURL {
        public $urlValida;
        public $macCliente;
        public $error;

        private $tecnologia;

        function __construct($requestURL)
        {
            $this->CheckURL($requestURL);
        }

        function CheckURL($requestURL) {
            $url = parse_url($requestURL);
            parse_str($url['query'], $params);
            //Por el momento solo existe Ruckus 
            if ($this->detectTechnology( $params)) {
                $this->urlValida = $this->SetParametersURL($params);
            } else {
                $this->urlValida = false;
                $this->error = 'error_technology';
            }
        }

        function detectTechnology($params) {
            if (isset($params)) {
                if (isset($params['nbiIP']) || isset($params['sip'])) {
                    $this->tecnologia = 'Ruckus';
                    return true;
                }
                else if (isset($params['hwc_ip'])) {
                    $this->tecnologia = 'Extreme';
                    return true;
                }
                else if (isset($params['ap'])) {
                    $this->tecnologia = 'Ubiquiti';
                    return true;
                }
                else if (isset($params['hs_server'])) {
                    $this->tecnologia = 'Wing';
                    return true;
                }
                else {
                    $this->tecnologia = 'No definida';
                    return false;
                }
            } else {
                return false;
            }
        }

        function SetParametersURL($params) {
            switch ($this->tecnologia) {
                case 'Ruckus':
                    $ap = new Ruckus();
                    $ap->init($params);  
                    if ($ap->dataValidation) {
                        $this->macCliente = $ap->mac_cliente;
                        return true;
                    } else {
                        $this->error = 'error_url';
                        return false;

                    }
                    break;
                case 'Extreme':
                        $ap = new Extreme();
                        $ap->init($params);  
                        if ($ap->dataValidation) {
                            $this->macCliente = $ap->mac_cliente;
                            return true;
                        } else {
                            $this->error = 'error_url';
                            return false;
    
                        }
                        break;
                case 'Wing':
                    $ap = new Wing();
                    $ap->init($params);  
                    if ($ap->dataValidation) {
                        $this->macCliente = $ap->mac_cliente;
                        return true;
                    } else {
                        $this->error = 'error_url';
                        return false;

                    }
                    break;
                case 'Ubiquiti':
                    $ap = new Ubiquiti();
                    $ap->init($params);  
                    if ($ap->dataValidation) {
                        $this->macCliente = $ap->mac_cliente;
                        return true;
                    } else {
                        $this->error = 'error_url';
                        return false;

                    }
                    break;                
                default:
                    $this->error = 'error_default';
                    return false;
                    break;
            }
        }
    }
?>