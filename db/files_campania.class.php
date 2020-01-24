<?php
    include_once 'db.class.php';  
    include_once 'config.php';

    class FilesCampania extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'files_campania',
            $pk = 'id'; 
            
        public function GetSRCBackgroundImage($id_campania = '') {
            $sql = "SELECT * FROM :table WHERE id_tipo_archivo_multimedia = '1' AND id_campania = '$id_campania'";
            $fileBackground = $this::sql($sql, Orm::FETCH_ONE);
            return 'data:'.$fileBackground->mime.';base64,'.base64_encode($fileBackground->datos).'';
        }

        public function GetSRCIconImageSRC($id_campania = '') {
            $sql = "SELECT * FROM :table WHERE id_tipo_archivo_multimedia = '2' AND id_campania = '$id_campania'";
            $fileIcon = $this::sql("$sql", Orm::FETCH_ONE);
            return 'data:'.$fileIcon->mime.';base64,'.base64_encode($fileIcon->datos).'';
        }

        public function GetSRCFavicon($id_campania = '') {
            $sql = "SELECT * FROM :table WHERE id_tipo_archivo_multimedia = '3' AND id_campania = '$id_campania'";
            $fileFavicon = $this::sql("$sql", Orm::FETCH_ONE);
            return 'data:'.$fileFavicon->mime.';base64,'.base64_encode($fileFavicon->datos).'';
        }
    }