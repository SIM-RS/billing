<?php
function gen_print($table)
{
  $nopf = NoPrimaryField($table);
  $pf   = PrimaryField($table);
  $string = "
<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title> \$table </title>
    <link rel=\"icon\" href=\"../favicon.png\">
    <link rel=\"stylesheet\" href=\"../bootstrap-4.5.2-dist/css/bootstrap.min.css\" >
   <script src=\"../js/jquery-3.5.1.slim.js\"></script>
          <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/bootstrap.min.css\"> 
        <script src=\"../js/bootstrap.min.js\"></script>
        <link rel=\"icon\" href=\"../favicon.png\">
    <script src=\"../bootstrap-4.5.2-dist/js/jquery.min.js\"></script>
    <script src=\"../bootstrap-4.5.2-dist/js/bootstrap.min.js\"></script>
   <style type=\"text/css\">
      @media print{
  #print{
    display: none;
  }
      }
    </style>
  </head>


<body>
  <div  style=\" width: 1000px;  margin: auto;\">


<?php

\$qPasien=\"select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='\".\$idPasien.\"' \";
\$rsPasien=mysql_query(\$qPasien);
\$rwPasien=mysql_fetch_array(\$rsPasien);
?>
<img src=\"../logors1.png\" style=\"width: 4,91 cm; height:1,97 cm; \">


<div class=\"box-pasien\" style=\"float: right; padding-right: 0px;\">
    <p align='right' style=\"margin: 0px;\">RM /PHCM</p>
    <table style=\" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;\" cellpadding=\"2\">

        <tr>
            <td class=\"noline\" style=\"font:12 sans-serif bolder;\">
                <b> NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo \$rwPasien['nama']; ?></b>
            </td>
            <td class=\"noline\"></td>
            <td class=\"noline\">&nbsp;</td>
            <td class=\"noline\">&nbsp;</td>
        </tr>
        <tr>
            <td class=\"noline\" style=\"font:12 sans-serif bolder;\">
                <b>Tgl.Lahir &nbsp;: <?php echo \$rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo \$rwPasien['sex']; ?> </b>
            </td>
            <td class=\"noline\"></td>
            <td class=\"noline\">&nbsp;</td>
            <td class=\"noline\">&nbsp;</td>
        </tr>
        <tr>
            <td class=\"noline\" style=\"font:12 sans-serif bolder;\">
                <b> No.RM &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo \$rwPasien['no_rm']; ?></b>
            </td>
            <td class=\"noline\"></td>
            <td class=\"noline\">&nbsp;</td>
            <td class=\"noline\">&nbsp;</td>
        </tr>

    </table>
</div>
<br>

<hr style=\" margin:0px; padding:0px; margin-top:17px;\">
<hr style=\"border: 1px solid black; margin:0px; padding:0px; margin-top:2px;\">
  <center>
   <br>
  <center><h5>FORMULIR $table</h5></center>
   
  <div class='container'>
    <table class='table  table-bordered'>
    <thead>
      <tr>
      <th>No</th>
    ";
  foreach ($nopf as $th) {
    $string .= "<th>" . $th['column_name'] . "</th> \n";
  }
  $string .= "
     
      </tr>
      </thead>
      <tbody>
    <?php
  
      \$no = 1;
 \$getone = GetOne(\$_REQUEST['id']);
      \$no = 1;
      if(isset(\$getone)){
      foreach(\$getone as \$data){
        echo \"<tr>\";
        echo \"<td>\".\$no++.\"</td>\"; \n";
  foreach ($nopf as $field) {
    $string .= "echo \"<td>\".\$data['" . $field['column_name'] . "'].\"</td>\"; \n";
  }
  $string .= "
      
  }
}
      ?>
      ";

  $string .= "

    </tbody>
    </table>
      <BR>
    <center>
  <div class='btn-group'>
    <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
       <a id='print' href=\"javascript:history.back()\" class=\"btn btn-primary \" style=\"text-decoration: none; color: white;\">Kembali</a>
  </div>
</center>
  </div>

  </body>
</html>



";
  createFile($string, "../" . $table . "/print.php");
}
