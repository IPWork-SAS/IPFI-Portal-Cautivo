<?php
    include_once 'db.class.php';    
    include_once '../clases/utilidades.class.php';
    include_once 'config.php';

    class Campania extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = BD_PARAMETERS['database']['campania'],
            $pk = 'id';           


        public function validarMac($mac = '') {
            return $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
        }

        public function getNameUserByMac($mac = '') {
            $user = $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
            if(isset($user)) {
                return $user->nombre;
            } else  {
                return '';
            }            
        }

        public function GetVoucherUserByMac($mac = '') {
            $user = $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
            if(isset($user)) {
                return $user->num_voucher;
            } else  {
                return '';
            } 
        }

        public function SaveDataClient($dataClient) {

            $utilidades = new Utilidades();
            $this->id_evento = 2;
            $this->fecha_creacion = $utilidades->getDatetimeNow();

            if(isset($dataClient['nombre'])) {
                $this->nombre = $dataClient['nombre'];
            }
            if(isset($dataClient['apellidos'])) {
                $this->apellidos = $dataClient['apellidos'];
            }
            if(isset($dataClient['email'])) {
                $this->email = $dataClient['email'];
            }
            if(isset($dataClient['edad'])) {
                $this->edad = $dataClient['edad'];
            }
            if(isset($dataClient['telefono'])) {
                $this->telefono = $dataClient['telefono'];
            }
            if(isset($dataClient['genero'])) {
                $this->genero = $dataClient['genero'];
            }
            if(isset($dataClient['num_habitacion'])) {
                $this->num_habitacion = $dataClient['num_habitacion'];
            }
            if(isset($dataClient['num_voucher'])) {
                $this->num_voucher = $dataClient['num_voucher'];
            }
            if(isset($dataClient['os'])) {
                $this->os = $dataClient['os'];
            }
            if(isset($dataClient['ip_ap'])) {
                $this->ip_ap = $dataClient['ip_ap'];
            }
            if(isset($dataClient['mac_ap'])) {
                $this->mac_ap = $dataClient['mac_ap'];
            }
            if(isset($dataClient['mac_cliente'])) {
                $this->mac_cliente = $dataClient['mac_cliente'];
            }
            if(isset($dataClient['ip_cliente'])) {
                $this->ip_cliente = $dataClient['ip_cliente'];
            }
            if(isset($dataClient['ssid'])) {
                $this->ssid = $dataClient['ssid'];
            }

            try {
                $this->save();
                return true;
            } catch (\Throwable $th) {
                var_dump($th);
                exit;
                return false;
            }
        }

        public function getUserByMac($mac = '') {
            return $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
        } 

        /*Valida si el usuario se ha registrado*/
        public function ValidateExistClientByMac($mac = '') {
            $user = $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
            if(isset($user)) {
                return true;
            } else  {
                return false;
            } 
        }

        public function EsCampañaConVoucher() {
            $voucherColumn = $this::sql("SHOW COLUMNS FROM :table where field like 'num_voucher'", Orm::FETCH_ONE);
            if(isset($voucherColumn)) {
                return true;
            } else {
                return false;
            }
        }

        public function GetDatosCampaña() {
            $columnasCampania = $this::sql("select COLUMN_NAME from information_schema.COLUMNS where TABLE_NAME=':table'", Orm::FETCH_MANY);
            $datosCampania = array();
            foreach ($columnasCampania as $value) {
                $datosCampania[$value->COLUMN_NAME] = $value->COLUMN_NAME;
            } 
            return $datosCampania;
        }

        public function GetIdCampania() {
            $campania = $this::sql("SELECT* FROM campania where campania = ':table'");
            if(isset($campania)) {
                return $campania;
            } else {
                return '0';
            }
        }
    }