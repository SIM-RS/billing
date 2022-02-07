<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','rspm@2016');
define('DB_PREFIX','rspelindo');
define('DB_NAME','billing');

class Connection {
    protected $konek;
    function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME){
        $this->konek = new mysqli($host, $user, $pass, DB_PREFIX . "_" . $db);
        if($this->konek->connect_error){
            throw new Exception("Connection ke database error", 1);
            return false;
        }
        return $this->konek;
    }

    function queryGet($sql){
        return $this->konek->query($sql);
    }
}
