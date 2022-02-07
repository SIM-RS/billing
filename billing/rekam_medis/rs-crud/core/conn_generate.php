<?php
function gen_conn($host, $dbUser, $dbName, $dbPassword, $urlBase)
{
  $string .= "
<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
define (\"HOST\",\"$host\");
define (\"DB_USER\",\"$dbUser\");
define (\"DB_PASSWORD\",\"$dbPassword\");
define (\"DB_NAME\",\"$dbName\");
define (\"BASE_URL\",\"$urlBase\");


    \$konek = mysql_connect(HOST, DB_USER, DB_PASSWORD);
    mysql_select_db(DB_NAME);

    if(\$konek){
        return \$konek;
    } else {
      return FALSE;
    }

?>
";
if (mkdir("../koneksi")) {
createFile($string, "../koneksi/konek.php");
}
}