<?php
    include_once 'db.class.php';  
    include_once 'config.php';

    class UsersRadius extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'users_radius',
            $pk = 'id'; 

            public function SaveDataUserRadius($randomUser, $id_dato_campania) {

                $this->SetUserPassSession($randomUser);

                $utilidades = new Utilidades();
                $this->id_cliente = $id_dato_campania;
                $this->fecha_creacion = $utilidades->getDatetimeNow();
                $this->username = $randomUser;
                $this->password = $randomUser;             
    
                try {
                    $this->save();
                    return true;
                } catch (\Throwable $th) {
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
    }