<?php
    
    include_once 'db.class.php'; 
    include_once '../clases/utilidades.class.php'; 
  

    class Voucher extends Orm {

        protected static    
            $database = 'portal_oxohotel',
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
            if($voucher->num_usos == 0){
                $voucher->estado = 'En Uso';
                $voucher->save();
                return false;
            }
            else {
                return true;
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

        public function validateExistVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            if(isset($voucher)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function validateUsesVoucher($num_voucher = '') {
            $voucher = $this::retrieveByvoucher($num_voucher, Orm::FETCH_ONE); 
            if((isset($voucher))&&($voucher->num_usos == 0)){
                $voucher->estado = 'En Uso';
                $voucher->save();
                return true;
            }
            else {
                return false;
            }
        }


    }