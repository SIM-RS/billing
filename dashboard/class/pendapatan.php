<?php
class Pendapatan extends Connection{
    private $database = 'billing';

    function __construct()
    {
        return parent::__construct();
    }

    function getDataPendapatan($sql){
        return parent::queryGet($sql);
    }

    function tglIndo($tgl,$type = 0){
        $tanggal = explode('-',$tgl);
        if($type == 0) return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
        else return $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
    }
}

?>