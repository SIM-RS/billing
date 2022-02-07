<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.3.js"></script>
<title>Pendukung Tarif</title>
</head>

<body>
<div align="center">
<?php
    include("../koneksi/konek.php");
    include("../header1.php");

    $data = mysql_query("SELECT * FROM b_ms_tindakan");

?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM PENDUKUNG TARIF</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td colspan="3" align="center">Daftar Tindakan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

    <table width="1000" border="1" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  
    <?php while($row = mysql_fetch_assoc($data)): ?>
        <tr>
            <td><?= $row['nama'] ?></td>
            <td><input type="checkbox" value="1" onchange="slapTind(this, <?= $row['id'] ?>)"></td>
        </tr>
    <?php endwhile; ?>
  
  </table>

</div>

<script>

    function slapTind(id, value) {
        if (id.checked) {
            alert(value);
        } else {

        }
    }
    
</script>
</body>

</html>
