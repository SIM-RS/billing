<?php

namespace app;

DEFINE("DB_HOST", "localhost");
DEFINE("DB_USER", "root");
DEFINE("DB_PASS", "rspm@2016");

DEFINE("DB_PREFIX", "rspelindo");
DEFINE("DB_NAME", "admin");

class Db {
    public $konek;

    function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME){
        $this->konek = new mysqli($host, $user, $pass, DB_PREFIX . "_" . $db);
        if($this->konek->connect_error){
            throw new Exception("Connection ke database error", 1);
            return false;
        }
        return $this;
    }

    public function insert($table, $data = array()){
        if(!count($data))
            throw new Exception("Data harus berisi.", 1);

        $string_field = "";
        $string_value = "";
        foreach($data as $key => $val){
            $string_field .= $key . ",";
            $string_value .= "'" . \htmlspecialchars($val) . "',";
        }
        $string_field = rtrim($string_field, ",");
        $string_value = rtrim($string_value, ",");

        $query = "INSERT INTO {$table}({$string_field}) VALUES($string_value)";
        if($this->konek->query($query) !== true){
            throw new Exception("Query insert gagal.", 1);
            return false;
        }
        return $this->konek->insert_id;
    }

    public function update($table, $data = array(), $where = ""){
        if(!count($data))
            throw new Exception("Data harus berisi.", 1);

        $string_set = "";
        $string_where = ($where != "" ? "WHERE " . $where : "");

        foreach($data as $key => $val){
            $string_set .= "{$key} = '" . \htmlspecialchars($val) . "',";
        }
        $string_set = rtrim($string_set, ",");

        $query = "UPDATE {$table} SET {$string_set} {$string_where}";

        if($this->konek->query($query) !== true){
            throw new Exception("Query update gagal.", 1);
            return false;
        }
        return true;
    }
}