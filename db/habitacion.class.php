<?php
    include_once 'db.class.php';    

    class Habitacion extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'habitaciones',
            $pk = 'id';

        public function validateHabitacion($habitacion = '') {
            $habitacion = $this::retrieveBynum_habitacion($habitacion, Orm::FETCH_ONE);
         
            if(isset($habitacion)) {
                return true;
            } else  {
                return false;
            }            
        }

    }