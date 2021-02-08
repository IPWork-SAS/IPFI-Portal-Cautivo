<?php
<<<<<<< HEAD
    include_once 'db.class.php';
    include_once 'config.php';    
=======
    include_once 'db.class.php'; 
    include_once 'config.php';   
>>>>>>> 6729c67a4d2e1aa7d26aececb3ca353cb40946e8

    class Habitacion extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'habitaciones',
            $pk = 'id';

        public function validateHabitacion($habitacion = '') {
            $id_locacion = BD_PARAMETERS['database']['id_locacion'];
            $habitacion = $this::sql("SELECT* FROM :table WHERE num_habitacion = '$habitacion' and id_locacion = '$id_locacion'", Orm::FETCH_ONE);
         
            if(isset($habitacion)) {
                return true;
            } else  {
                return false;
            }            
        }

    }