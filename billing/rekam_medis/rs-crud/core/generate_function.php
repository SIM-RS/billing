<?php
function gen_func($table)
{
  $pf = PrimaryField($table);
  $string .= "<?php
require_once '../../koneksi/konek.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

\$idKunj=mysql_real_escape_string(\$_REQUEST['idKunj']);
\$idPel=mysql_real_escape_string(\$_REQUEST['idPel']);


\$sql = mysql_fetch_assoc(mysql_query(\"SELECT pasien_id FROM b_kunjungan WHERE id = '\$idKunj'\"));

\$idPasien= \$sql['pasien_id'];
\$idUser=mysql_real_escape_string(\$_REQUEST['idUser']);

function GetAll(\$idKunj,\$idPasien){
  

  \$query = \"SELECT * FROM " . $table . " WHERE id_kunjungan = '\$idKunj' AND id_pasien ='\$idPasien'\";
  \$exe = mysql_query(\$query);
  while(\$data = mysql_fetch_array(\$exe)){
    \$datas[] = array(";
  $fields = AllField($table);
  foreach ($fields as $fieldName) {
    $string .= "'" . $fieldName['column_name'] . "' => \$data['" . $fieldName['column_name'] . "'],\n\t\t";
  }
  $string .= "
    );
  }
  return \$datas;
}
";
  $string .= "
function GetOne(\$id){
 
  \$query = \"SELECT * FROM  `$table` WHERE  `$pf` =  '\$id'\";
  \$exe = mysql_query(\$query);
  while(\$data = mysql_fetch_array(\$exe)){
    \$datas[] = array(";
  $fields = AllField($table);
  foreach ($fields as $fieldName) {
    $string .= "'" . $fieldName['column_name'] . "' => \$data['" . $fieldName['column_name'] . "'], \n\t\t";
  }
  $string .= "
    );
  }
return \$datas;
}
";
  $string .= "
function Insert(){
   

\$idKunj=mysql_real_escape_string(\$_REQUEST['idKunj']);
\$idPel=mysql_real_escape_string(\$_REQUEST['idPel']);
\$idPasien=mysql_real_escape_string(\$_REQUEST['idPasien']);
\$idUser=mysql_real_escape_string(\$_REQUEST['idUser']);
  ";
  $nopf = NoPrimaryField($table);
  foreach ($nopf as $fieldName) {
    $string .= "\$" . $fieldName['column_name'] . "= mysql_real_escape_string(\$_POST['" . $fieldName['column_name'] . "']); \n\t\t";
  }
  $string .= "
  \$query = \"INSERT INTO `$table` (";
  foreach ($fields as $fieldName) {
    $string .= "`" . $fieldName['column_name'] . "`,";
  }
  $string .= ")
VALUES (NULL,";
  foreach ($nopf as $fieldName) {
    $string .= "'\$" . $fieldName['column_name'] . "',";
  }
  $string .= ")\";
\$exe = mysql_query(\$query);
  if(\$exe){
    // kalau berhasil
    \$_SESSION['message'] = \" Data Telah disimpan \";
    \$_SESSION['mType'] = \"success \";
      
    header(\"Location: index.php?idKunj=\$id_kunjungan&idPel=\$id_pelayanan&idPasien=\$id_pasien&idUser=\$id_user\");
  }
  else{
    \$_SESSION['message'] = \" Data Gagal disimpan \";
    \$_SESSION['mType'] = \"danger \";
    
  header(\"Location: index.php?idKunj=\$id_kunjungan&idPel=\$id_pelayanan&idPasien=\$id_pasien&idUser=\$id_user\");
  }
}";
  $string .= "
function Update(\$id){
   

  \$idKunj=mysql_real_escape_string(\$_REQUEST['idKunj']);
\$idPel=mysql_real_escape_string(\$_REQUEST['idPel']);
\$idPasien=mysql_real_escape_string(\$_REQUEST['idPasien']);
\$idUser=mysql_real_escape_string(\$_REQUEST['idUser']);

  ";
  $nopf = NoPrimaryField($table);
  foreach ($nopf as $fieldName) {
    $string .= "\$" . $fieldName['column_name'] . "=mysql_real_escape_string(\$_POST['" . $fieldName['column_name'] . "']); \n\t\t";
  }
  $string .= "
  \$query = \"UPDATE `$table` SET ";
  foreach ($nopf as $fieldName) {
    $string .= "`" . $fieldName['column_name'] . "` = '\$" . $fieldName['column_name'] . "',";
  }
  $string .= "WHERE  `$pf` =  '\$id'";
  $string .= "\";
\$exe = mysql_query(\$query);
  if(\$exe){
    // kalau berhasil
    \$_SESSION['message'] = \" Data Telah diubah \";
    \$_SESSION['mType'] = \"success \";
    
   header(\"Location: index.php?idKunj=\$id_kunjungan&idPel=\$id_pelayanan&idPasien=\$id_pasien&idUser=\$id_user\");
  }
  else{
    \$_SESSION['message'] = \" Data Gagal diubah \";
    \$_SESSION['mType'] = \"danger \";
    
   header(\"Location: index.php?idKunj=\$id_kunjungan&idPel=\$id_pelayanan&idPasien=\$id_pasien&idUser=\$id_user\");
  }
}";
  $string .= "
function Delete(\$id){
   
 \$idKunj=mysql_real_escape_string(\$_REQUEST['idKunj']);
\$idPel=mysql_real_escape_string(\$_REQUEST['idPel']);
\$idPasien=mysql_real_escape_string(\$_REQUEST['idPasien']);
\$idUser=mysql_real_escape_string(\$_REQUEST['idUser']);

  \$query = \"DELETE FROM `$table` WHERE `$pf` = '\$id'\";
  \$exe = mysql_query(\$query);
    if(\$exe){
      // kalau berhasil
      \$_SESSION['message'] = \" Data Telah dihapus \";
      \$_SESSION['mType'] = \"success \";
       
      header(\"Location: index.php?idKunj=\$idKunj&idPel=\$idPel&idPasien=\$idPasien&idUser=\$idUser\");
    }
    else{
      \$_SESSION['message'] = \" Data Gagal dihapus \";
      \$_SESSION['mType'] = \"danger \";

      header(\"Location: index.php?idKunj=\$idKunj&idPel=\$idPel&idPasien=\$idPasien&idUser=\$idUser\");
    }
}


";
  $string .= "

function hari_ini(){
  \$hari = date (\"D\");
 
  switch(\$hari){
    case 'Sun':
      \$hari_ini = \"Minggu\";
    break;
 
    case 'Mon':     
      \$hari_ini = \"Senin\";
    break;
 
    case 'Tue':
      \$hari_ini = \"Selasa\";
    break;
 
    case 'Wed':
      \$hari_ini = \"Rabu\";
    break;
 
    case 'Thu':
      \$hari_ini = \"Kamis\";
    break;
 
    case 'Fri':
      \$hari_ini = \"Jumat\";
    break;
 
    case 'Sat':
      \$hari_ini = \"Sabtu\";
    break;
    
    default:
      \$hari_ini = \"Tidak di ketahui\";   
    break;
  }
 
  return \"\" . \$hari_ini . \"\";
 
}


";
  $string .= "
if(isset(\$_POST['insert'])){
  Insert();
}
else if(isset(\$_POST['update'])){
  Update(mysql_real_escape_string(\$_POST['$pf']));
}
else if(isset(\$_POST['delete'])){
  Delete(mysql_real_escape_string(\$_POST['$pf']));
}
?>
";

mkdir("../" . $table);
createFile($string, "../" . $table . "/func.php");
Replace($table, "func", ",)", ")");
Replace($table, "func", ",WHERE", " WHERE");
}