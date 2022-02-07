<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','rspm@2016');
define('DB_PREFIX','rspelindo');
define('DB_NAME','ppm');

class Connection{

    protected $konek;
    function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME){
        $this->konek = new mysqli($host, $user, $pass, DB_PREFIX . "_" . $db);
        if($this->konek->connect_error){
            throw new Exception("Connection ke database error", 1);
            return false;
        }
        return $this->konek;
    }

    function rawQuery($sql){
        return $this->konek->query($sql);
    }

    function pesan($pesan,$link){
        echo '<script>';
            echo 'alert("'.$pesan.'")';
            echo 'window.location = "'.$link.'"';
        echo '</script>';
    }

    function tgl($tgl){
        $tanggal = explode('-',$tgl);
        return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
    }

}

?>