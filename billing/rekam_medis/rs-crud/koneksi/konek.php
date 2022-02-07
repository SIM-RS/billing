
<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
define ("HOST","localhost");
define ("DB_USER","root");
define ("DB_PASSWORD","");
define ("DB_NAME","rspelindo_billing");
define ("BASE_URL","http://localhost:7777/simrs-pelindo-fix/billing/rekam_medis/rs-crud/");


    $konek = mysql_connect(HOST, DB_USER, DB_PASSWORD);
    mysql_select_db(DB_NAME);

    if($konek){
        return $konek;
    } else {
      return FALSE;
    }

?>
