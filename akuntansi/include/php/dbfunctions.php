<?php

include_once "koneksi.php";

function buildInsertQuery($table, $data, $customValue = array()) {
    $columns = array();
    $values = array();
    foreach ($data as $key => $value) {
        $columns[] = $key;
        if (is_numeric($value)) {
            $values[] = $value;
        } else {
            $values[] = "'" . $value . "'";
        }
    }
    foreach($customValue as $key => $value) {
        $columns[] = $key;
        $values[] = $value;
    }
    
    $sql = "INSERT INTO {$table}(" . implode(',', $columns) . ") VALUES(" . implode(',', $values) . ")";
    
    return $sql;
}

function ds_insert($sql) {
    mysql_query($sql);
    
    //echo 'tes';
    
    return mysql_affected_rows();
}

?>
