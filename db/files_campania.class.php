<?php
    include_once 'db.class.php';    
    include_once 'config.php';

    class FilesCampania extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'files_campania',
            $pk = 'id'; 
            
        public function GetSRCBackgroundImage() {
            $fileBackground = $this::retrieveByid_tipo_archivo_multimedia('1', Orm::FETCH_ONE);
            return 'data:'.$fileBackground->mime.';base64,'.base64_encode($fileBackground->datos).'';
        }

        public function GetSRCIconImageSRC() {
            $fileIcon = $this::retrieveByid_tipo_archivo_multimedia('2', Orm::FETCH_ONE);
            return 'data:'.$fileIcon->mime.';base64,'.base64_encode($fileIcon->datos).'';
        }

        public function GetSRCFavicon() {
            $fileFavicon = $this::retrieveByid_tipo_archivo_multimedia('3', Orm::FETCH_ONE);
            return 'data:'.$fileFavicon->mime.';base64,'.base64_encode($fileFavicon->datos).'';
        }
    }