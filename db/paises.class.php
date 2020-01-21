<?php
    include 'db.class.php';    

    class Paises extends Orm {

        protected static    
            $database = 'portal_oxohotel',
            $table = 'paises',
            $pk = 'id';
    }