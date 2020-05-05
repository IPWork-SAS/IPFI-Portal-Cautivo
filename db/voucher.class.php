<?php
    
    include_once 'db.class.php'; 
    include_once '../clases/utilidades.class.php'; 
    include_once 'config.php';

    class Voucher extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'vouchers',
            $pk = 'id_voucher';

        public function ValidateUsedVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            //Se valida si tiene una fecha valida
            if (!$this->ValidateDateVoucher($voucher)) {
                return false;
            } 

            //Se valida si el voucher supero el limite de usos
            if (!$this->ValidateNumberUsagesVoucher($voucher)) {
                return false;
            }

            return true;
        }

        function ValidateNumberUsagesVoucher($voucher) {
            if($voucher->id_caducidad != 4) {
                if($voucher->num_usos == 0){
                    $voucher->estado = 'En Uso';
                    $voucher->save();
                    return false;
                } else {
                    return true;
                }  
            }
        }

        function ValidateDateVoucher($voucher) {
            $fecha_inicio = date('Y-m-d', strtotime($voucher->fecha_inicio));
            $fecha_fin = date('Y-m-d', strtotime($voucher->fecha_fin));
            $utilidades = new Utilidades();
            $fecha_hoy = $utilidades->getDatetimeNow(); 
            
            if (($fecha_hoy >= $fecha_inicio) && ($fecha_hoy <= $fecha_fin)){
                return true;
            }
            else{
                return false; 
            }   
        }
        
        public function ValidateVoucherExpiration($num_voucher = '') {        
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 

            $fecha_inicio = date('Y-m-d', strtotime($voucher->fecha_inicio));
            $fecha_fin = date('Y-m-d', strtotime($voucher->fecha_fin));
            $utilidades = new Utilidades();
            $fecha_hoy = $utilidades->getDatetimeNow(); 

            if (($fecha_hoy >= $fecha_inicio) && ($fecha_hoy <= $fecha_fin)){
                return true;
            }
            else{
                return false; 
            }          
        }

        public function validateExistVoucher($num_voucher = '', $id_campania = '') {
            $sql = "SELECT * FROM :table WHERE voucher = '$num_voucher' AND id_campania = '$id_campania'";
            $voucher = $this::sql($sql, Orm::FETCH_ONE);             
            if (isset($voucher)) {
                if($voucher->id_caducidad == 4){
                    $sql = "SELECT * FROM :table WHERE (voucher = '$num_voucher' AND estado = 'Disponible') AND id_campania = '$id_campania'";
                    $password = $this::sql($sql, Orm::FETCH_ONE); 
                    if(isset($password)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else{
                    $sql = "SELECT * FROM :table WHERE voucher = '$num_voucher' AND id_campania = '$id_campania'";
                    $voucher = $this::sql($sql, Orm::FETCH_ONE); 
                    if(isset($voucher)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            } else {
                return false;
            }         
        }

        public function validateUsesVoucher($num_voucher = '', $campania = array()) {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE);
            if((isset($voucher) && $voucher->id_caducidad != 4) && (($voucher->num_usos == $voucher->total_num_usos))){
                $voucher->estado = 'Sin Usos Disponibles';
                $voucher->save();
                return true;
            }
            else {
                return false;
            }
        }

        public function UpdateVoucherState($num_voucher = '', $campania) {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE);
            if($voucher->id_caducidad != 4){
                if($voucher->num_usos == $voucher->total_num_usos){
                    $voucher->num_usos = $voucher->total_num_usos;
                }
                
                if(($voucher->num_usos >= 0 && $voucher->num_usos != $voucher->total_num_usos)){
                    if($voucher->id_caducidad == 3 && $voucher->estado == 'Sin Uso'){
                        $daysActive = $voucher->dias_disponibles;
                        $hoursActive = $voucher->horas_disponibles;
                        $minutesActive = $voucher->minutos_disponibles;
                        
                        date_default_timezone_set('America/Bogota');
                    
                        $fecha_finCampania = date('Y-m-d 00:00:00', strtotime($campania->fecha_fin));
        
                        $startDateActive = date("Y-m-d H:i:s");
                        $endDateActive = date('Y-m-d H:i:s',strtotime("+$daysActive day +$hoursActive hour +$minutesActive minutes",strtotime($startDateActive)));
        
                        if($endDateActive > $fecha_finCampania){
                            $voucher->fecha_inicio = $startDateActive;
                            $voucher->fecha_fin = $fecha_finCampania;
                            $voucher->num_usos = $voucher->num_usos+1;
                            $voucher->estado = 'En Uso';
                            $voucher->save();
                        }
                        if($endDateActive <= $fecha_finCampania){
                            $voucher->fecha_inicio = $startDateActive;
                            $voucher->fecha_fin = $endDateActive;
                            $voucher->num_usos = $voucher->num_usos+1;
                            $voucher->estado = 'En Uso';
                            $voucher->save();
                        }
                        
                    } else{
                        $voucher->num_usos = $voucher->num_usos+1;
                        $voucher->estado = 'En Uso';
                        $voucher->save();
                    }
                }
            }
        }
    }