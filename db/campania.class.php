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
            if(!empty($user)) {
                return $user->nombre;
            } else  {
                return '';
            }            
        }

        public function GetVoucherUserByMac($mac = '') {
            $user = $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
            if(!empty($user)) {
                return $user->num_voucher;
            } else  {
                return '';
            } 
        }

        public function SaveDataClient($dataClient) {

            $utilidades = new Utilidades();
            $this->id_evento = $this->GetIdCampania();
            $this->fecha_creacion = $utilidades->getDatetimeNow();

            if(!empty($dataClient['nombre'])) {
                $this->nombre = $dataClient['nombre'];
            }
            if(!empty($dataClient['apellidos'])) {
                $this->apellidos = $dataClient['apellidos'];
            }
            if(!empty($dataClient['email'])) {
                $this->email = $dataClient['email'];
            }
            if(!empty($dataClient['edad'])) {
                $this->edad = $dataClient['edad'];
            }
            if(!empty($dataClient['telefono'])) {
                $this->telefono = $dataClient['telefono'];
            }
            if(!empty($dataClient['genero'])) {
                $this->genero = $dataClient['genero'];
            }
            if(!empty($dataClient['num_habitacion'])) {
                $this->num_habitacion = $dataClient['num_habitacion'];
            }
            if(!empty($dataClient['num_voucher'])) {
                $this->num_voucher = $dataClient['num_voucher'];                
            }
            if(!empty($dataClient['os'])) {
                $this->os = $dataClient['os'];
            }
            if(!empty($dataClient['ip_ap'])) {
                $this->ip_ap = $dataClient['ip_ap'];
            }
            if(!empty($dataClient['mac_ap'])) {
                $this->mac_ap = $dataClient['mac_ap'];
            }
            if(!empty($dataClient['mac_cliente'])) {
                $this->mac_cliente = $dataClient['mac_cliente'];
            }
            if(!empty($dataClient['ip_cliente'])) {
                $this->ip_cliente = $dataClient['ip_cliente'];
            }
            if(!empty($dataClient['ssid'])) {
                $this->ssid = $dataClient['ssid'];
            }
            if(!empty($dataClient['razon_visita'])) {
                $this->razon_visita = $dataClient['razon_visita'];
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

        public function GetUserByMac($mac = '') {
            return $this::retrieveBymac_cliente($mac, Orm::FETCH_ONE);
        } 

        public function ValidateExistUserRadiusByVoucher($voucher) {
            $id_campania = BD_PARAMETERS['database']['id_campania'];
            $user = $this::sql("SELECT* FROM :table a inner join users_radius b on a.id = b.id_cliente WHERE a.num_voucher = '$voucher' and b.id_campania = '$id_campania'", Orm::FETCH_ONE);
            if (!empty($user)) {
                $this->SetUserPassSession($user->username);
                return true;
            } else {
                return false;
            }
        }

        public function ValidateExistUserRadiusByEmail($email) {
            $id_campania = BD_PARAMETERS['database']['id_campania'];
            $user = $this::sql("SELECT* FROM :table a inner join users_radius b on a.id = b.id_cliente WHERE a.email = '$email' and b.id_campania = '$id_campania'", Orm::FETCH_ONE);
            if (!empty($user)) {
                $this->SetUserPassSession($user->username);
                return true;
            } else {
                return false;
            }
        }

        public function ValidateExistUserRadiusByMac($mac_cliente) {
            $id_campania = BD_PARAMETERS['database']['id_campania'];
            $user = $this::sql("SELECT* FROM :table a inner join users_radius b on a.id = b.id_cliente WHERE a.email = '$mac_cliente' and b.id_campania = '$id_campania'", Orm::FETCH_ONE);
            if (!empty($user)) {
                $this->SetUserPassSession($user->username);
                return true;
            } else {
                return false;
            }
        }

        function SetUserPassSession($randomNumber) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['username'] = $randomNumber;
            $_SESSION['password'] = $randomNumber;
        }

        /*Valida si el usuario se ha registrado*/
        public function ValidateExistClientByMac($mac = '') {
            $user = $this::retrieveBymac_cliente($mac, Orm::FETCH_MANY); 
            $userEnd = end($user); 

            if(!empty($userEnd)) {
                $hoy = date_create('now');
                $fecha_creacion = date_create($userEnd->fecha_creacion);
                $intervalo = date_diff($hoy, $fecha_creacion);
                // var_dump($intervalo);
                // exit;
                if($intervalo->m >= 1) {
                    return false;
                } else {
                    return true;
                }
            } else  {
                return false;
            } 
        }

        public function EsCampañaConVoucher() {
            $voucherColumn = $this::sql("SHOW COLUMNS FROM :table where field like 'num_voucher'", Orm::FETCH_ONE);
            if(!empty($voucherColumn)) {
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
            $campania = $this::sql("SELECT* FROM campania where campania = ':table'", Orm::FETCH_ONE);
            if(!empty($campania)) {
                return $campania->id;
            } else {
                return '0';
            }
        }

        public function GetCampania() {
            $campania = $this::sql("SELECT* FROM campania where campania = ':table'", Orm::FETCH_ONE);
            if(!empty($campania)) {
                return $campania;
            } else {
                return '0';
            }
        }

        public function GetUserRadius($mac_cliente) {
            $id_campania = BD_PARAMETERS['database']['id_campania'];
            $sql = "SELECT* FROM :table a inner join users_radius b on a.id = b.id_cliente where a.mac_cliente = '$mac_cliente' and b.id_campania = '$id_campania'";
            $usuario = $this::sql($sql, Orm::FETCH_MANY);
            $userEnd = end($usuario); 
            if (!empty($userEnd)) {
                return $userEnd->username;
            } else {
                return '';
            }
        }
    }