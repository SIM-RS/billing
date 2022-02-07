<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$ta=$_REQUEST['ta'];
$bulan=explode("|",$_REQUEST['bulan']);
$idunit=explode("|",$_REQUEST['idunit']);
header("Content-Type: application/msword");
header('Content-disposition: inline; filename="jurnal.doc"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Jurnal</title>
<style type="text/css">
.tblheaderkiri {
	border: 1px solid #000000;
}
.tblheader {
	border-top: 1px solid #000000;
	border-right: 1px solid #000000;
	border-bottom: 1px solid #000000;
	border-left: none;
}
.tdisi {
	border-top: none;
	border-right: 1px solid #000000;
	border-bottom: 1px solid #000000;
	border-left: none;
	font-size: 11px;
	/*text-align: left;*/
}
.tdisikiri {
	border-top: none;
	border-right: 1px solid #000000;
	border-bottom: 1px solid #000000;
	border-left: 1px solid #000000;
	font-size: 11px;
}
.headtable {
	font-size: 12px;
	font-weight: bold;
	background-color: #CCCCCC;
	text-align: center;
}
</style>
</head>
<body>
<div align="center">
<br>
  <table width="99%" border="0" cellpadding="0" cellspacing="0">
  	<tr>
		<td colspan="2">SISTEM KEUANGAN <?=$namaRS;?></td>
	</tr>
 	<tr>
<!-- 		<td width="80">UNIT/SATKER</td>
		<TD>: <?php echo strtoupper($idunit[1]); ?></TD>-->
	</tr> 
  	<tr>
		<td>LAPORAN  JURNAL <?php echo strtoupper($bulan[1])." ".$ta; ?></td>
	</tr>
  </table><BR>
  <table width="99%" border="0" cellpadding="2" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
	  <td id="no_trans" width="25" class="tblheader" onClick="ifPop.CallFr(this);">No.Trans</td>
      <td id="TGL" width="80" class="tblheader">Tgl</td>
     <!--<td id="kg_kode" width="80" class="tblheader">Kode Cost center</td> -->
	  <td id="NO_KW" width="80" class="tblheader">No. Bukti</td>
      <td id="MA_KODE" width="80" class="tblheader">Kode Rekening</td>
      <td id="URAIAN" width="200" class="tblheader">Uraian</td>
      <td id="DEBIT" width="100" class="tblheader">Debet</td>
      <td id="KREDIT" width="100" class="tblheader">Kredit</td>
    </tr>
	  <?php 
	  $sql="Select jurnal.*, ma_sak.MA_KODE, ma_sak.MA_NAMA, ma_sak.FK_MA From jurnal Inner Join ma_sak ON jurnal.FK_SAK = ma_sak.MA_ID where  month(tgl)=$bulan[0] and year(tgl)=$ta order by tr_id";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" align="center"><?php echo $i; ?></td>
	  <td class="tdisi" align="center"><?php echo $rows['NO_TRANS']; ?></td>
      <td class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
	  <td class="tdisi"><?php echo $rows['NO_KW']; ?></td>
      <td class="tdisi"><?php echo $rows['MA_KODE']; ?></td>
      <td class="tdisi"><?php echo $rows['URAIAN']; ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],0,",","."); ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['KREDIT'],0,",","."); ?></td>
    </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  $sql="select sum(debit) as stotd,sum(kredit) as stotk from jurnal where month(tgl)=$bulan[0] and year(tgl)=$ta";
	  $rs=mysqli_query($konek,$sql);
	  $stotd=0;
	  $stotk=0;	
	  if ($rows=mysqli_fetch_array($rs)){
	  	$stotd=$rows["stotd"];
		$stotk=$rows["stotk"];	
	  }
	  mysqli_free_result($rs);
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" colspan="6" align="right" height="20"><strong>Subtotal&nbsp;&nbsp;</strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotd,0,",","."); ?></strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotk,0,",","."); ?></strong></td>
    </tr>
  </table>
</div>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>