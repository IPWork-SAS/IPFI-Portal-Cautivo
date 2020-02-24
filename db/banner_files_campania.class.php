<?php
    include_once 'db.class.php';  
    include_once 'config.php';

    class BannerFilesCampania extends Orm {

        protected static    
            $database = BD_PARAMETERS['database']['name'],
            $table = 'banner_files_campania',
            $pk = 'id';            
       

        public function GetSRCBannerList($id_campania = '') {
            $arraySRCBanner = array();
            $sql = "SELECT * FROM :table WHERE id_campania = '$id_campania'";
            $filesBannerWeb = $this::sql($sql, Orm::FETCH_MANY);
            
            foreach ($filesBannerWeb as $key => $value) {
                $bannerFile = array();
                $srcImgWeb = '..'.$value->nombre_img_web;
                $bannerFile['srcImgWeb'] = $srcImgWeb;
                array_push($arraySRCBanner, (object)$bannerFile);
            }
            return $arraySRCBanner;
        }
    }