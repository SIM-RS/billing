<?php
session_start();
include('../../koneksi/konek.php');
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$inap=$_REQUEST['inap'];			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RENCANA HARIAN</title>
<style type="text/css">
<!--
body {
	font-family: Tahoma;
	font-size: 12px;
}
.judul1 {
	font-size: 17px;
	font-weight: bold;
}
.judul2 {
	font-size: 15px;
	font-weight: bold;
}

.sticker {
	line-height:20px;
	padding: 8px;
	border: 1px solid;
	font-size:9px;
	position:absolute;
	left: 608px;
	top: 17px;
}
-->
</style>
</head>

<body>
<td height="50" width="139"><div align="left">TANGGAL :  <?php echo date("d F Y");?></div></td>
<br/>
<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="35">
    <td colspan="6"><table border="1" cellpadding="0" cellspacing="0">
      <col width="100" />
      <col width="100" />
      <col width="100" />
      <col width="100" />
      <col width="100" span="2" />
	  <thead>
      <tr height="35">
       <!-- <td height="44" width="112"><div align="center">ID</div></td>-->
        <td width="130"><div align="center">Dinas Pagi PP/NIC</div></td>
        <td width="130"><div align="center">Room</div></td>
        <td width="130"><div align="center">Dinas Sore PP/NIC</div></td>
        <td width="130"><div align="center">Room</div></td>
        <td width="130"><div align="center">Dinas Malam PP/NIC</div></td>
        <td width="130"><div align="center">Room</div></td>
      </tr>
      </thead>
      <tbody class="rncana_prwat">
		<?php
		$sq = mysql_query("select * from b_rencana_harian_perawat where pelayanan_id='".$idPel."' and kunjungan_id='".$idKunj."' and user_id='".$idUsr."' ")or die(mysql_error());
		//$query = mysql_query($sql);
		while($rows = mysql_fetch_assoc($sq)){
		//while($row = mysql_fetch_array($sql)){
			?>
            <tr>
            	<!--<td align="center"><?php echo $rows['id']; ?></td>-->
                <td align="center"><?php if($rows['dinas']=='1'){ echo $_SESSION['nm_pegawai'];}else{echo "-";} ?>&nbsp;</td>
				<td align="center"><?php if($rows['dinas']=='1'){ echo $rows['kamar'];}else{echo "-";} ?>&nbsp;</td>
				<td align="center"><?php if($rows['dinas']=='2'){ echo $_SESSION['nm_pegawai'];}else{echo "-";} ?>&nbsp;</td>
				<td align="center"><?php if($rows['dinas']=='2'){ echo $rows['kamar'];}else{echo "-";} ?>&nbsp;</td>
				<td align="center"><?php if($rows['dinas']=='3'){ echo $_SESSION['nm_pegawai'];}else{echo "-";} ?>&nbsp;</td>
				<td align="center"><?php if($rows['dinas']=='3'){ echo $rows['kamar'];}else{echo "-";} ?>&nbsp;</td>
			</tr>
		  <?php
		}
		?>
	  </tbody>
</table><br /> <br />
		<table width="1072" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
<thead>
        <tr align="center">
          <td width="67">Kamar / TT</td>
          <td width="90">Nama Pasien</td>
          <td width="174">Diagnosa Medis / Diagnosa inap</td>
          <td width="92">Infuse</td>
          <td width="144">Rencana Pagi</td>
          <td width="144">Rencana Sore</td>
          <td width="144">Rencana Malam</td>
        </tr>
</thead>
        <tbody class="rencana_pasien">
        <?php
		$sq2 = mysql_query("select * from b_rencana_harian_perawat where pelayanan_id='".$idPel."' and kunjungan_id='".$idKunj."' and user_id='".$idUsr."' ")or die(mysql_error());
		//$query = mysql_query($sql);
		while($rows2 = mysql_fetch_assoc($sq2)){
		//while($row = mysql_fetch_array($sql)){
			?>
        <tr>
          <td align="center"><?php echo $rows2['kamar'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['nmpasien'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['diagnosmedis'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['infuse'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['rncanapagi'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['rncanasore'];?>&nbsp;</td>
          <td align="center"><?php echo $rows2['rncanamlm'];?>&nbsp;</td>
        </tr>
        <?php
		}
		?>
        </tbody>
      </table>
	</tr>
      <tr>
      <td align="center" colspan="6">&nbsp;</td>
      </tr>
      <tr id="trTombol">
      <td align="center" colspan="6"><button onclick="cetak(document.getElementById('trTombol'));" type="button">Cetak</button></td>
      </tr>
    </table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }
</script>
