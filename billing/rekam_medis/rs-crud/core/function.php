<?php

if (is_file("koneksi/konek.php")) {
  require_once "koneksi/konek.php";
} else if (is_file("../koneksi/konek.php")) {
  require_once "../koneksi/konek.php";
}
function Table()
{
  if (is_file("koneksi/konek.php")) {
    require_once "koneksi/konek.php";
  } else if (is_file("../koneksi/konek.php")) {
    require_once "../koneksi/konek.php";
  }
  $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "'";
  $exe = mysql_query($query);
  while ($table = mysql_fetch_array($exe)) {
    $fields[] = array('table_name' => $table['TABLE_NAME']);
  }
  return $fields;
}

function PrimaryField($table)
{
  if (is_file("koneksi/konek.php")) {
    require_once "koneksi/konek.php";
  } else if (is_file("../koneksi/konek.php")) {
    require_once "../koneksi/konek.php";
  }
  $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= '" . DB_NAME . "' AND TABLE_NAME='$table' AND COLUMN_KEY = 'PRI'";
  $exe = mysql_query($query);
  $pf = mysql_fetch_array($exe);
  return $pf['COLUMN_NAME'];
}

function NoPrimaryField($table)
{
  if (is_file("koneksi/konek.php")) {
    require_once "koneksi/konek.php";
  } else if (is_file("../koneksi/konek.php")) {
    require_once "../koneksi/konek.php";
  }
  $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='" . DB_NAME . "' AND TABLE_NAME='$table' AND COLUMN_KEY <> 'PRI'";
  $exe = mysql_query($query);
  while ($column = mysql_fetch_array($exe)) {
    $column_name[] = array('column_name' => $column['COLUMN_NAME']);
  }
  return $column_name;
}

function AllField($table)
{
  if (is_file("koneksi/konek.php")) {
    require_once "koneksi/konek.php";
  } else if (is_file("../koneksi/konek.php")) {
    require_once "../koneksi/konek.php";
  }
  $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='" . DB_NAME . "' AND TABLE_NAME='$table'";
  $exe = mysql_query($query);
  while ($column = mysql_fetch_array($exe)) {
    $column_name[] = array('column_name' => $column['COLUMN_NAME']);
  }
  return $column_name;
}

function createFile($string, $path)
{
  $create = fopen($path, "wb") or die("Unable to open file!");
  fwrite($create, $string);
  fclose($create);
  return $path;
}

function Replace($table, $nm_file, $car, $car_rep)
{

  $str = implode("", file("../" . $table . "/" . $nm_file . ".php"));
  $fo = fopen("../" . $table . "/" . $nm_file . ".php", 'wb');
  $str = str_replace($car, $car_rep, $str);
  fwrite($fo, $str, strlen($str));
}