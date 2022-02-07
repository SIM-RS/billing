<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$idma=$_REQUEST['idma'];if ($idma=="") $idma="0";
$kode_ma=$_REQUEST['kode_ma'];if ($kode_ma=="") $kode_ma="";
$ta=$_REQUEST['ta'];
$bulan=explode("|",$_REQUEST['bulan']);
$idunit=explode("|",$_REQUEST['idunit']);
$tgl1="01/".(($bulan[0]<10)?"0".$bulan[0]:$bulan[0])."/".$ta;

$saldoawal=0;
$sql="select * from saldo where fk_maid=$idma and fk_idunit=$idunit[0] and bulan=$bulan[0] and tahun=$ta";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$saldoawal=$rows['saldo_awal'];
}
$tot=0;
$stotd=0;
$stotk=0;
$totd=0;
$totk=0;
$sql="select isnull(sum(debit),0) as debit,isnull(sum(kredit),0) as kredit from jurnal inner join ma on jurnal.fk_idma=ma.ma_id where fk_idunit=$idunit[0] and ma_kode like '$kode_ma%' and month(tgl)=$bulan[0] and year(tgl)=$ta";
//echo $sql;
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$stotd=$rows['debit'];
	$stotk=$rows['kredit'];
}
$tot=$saldoawal+$stotd-$stotk;
if ($tot>0){
	$totd=$tot;
}else{
	$totk=$tot * (-1);
}
header("Content-Type: application/msword");
header('Content-disposition: inline; filename="buku_besar.doc"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Buku Besar</title>
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
<?php 
$sql="select * from ma where ma_id=$idma";
$rs1=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs1)){
	$kode_ma=$rows["MA_KODE"];
	$ma=$rows["MA_NAMA"];
}
?>
      <table width="99%" border="0" cellpadding="2" cellspacing="0">
        <tr> 
          <td colspan="3">SISTEM KEUANGAN <?=$namaRS;?></td>
        </tr>
        <tr> 
          <td width="150">UNIT / SATKER</td>
          <td width="10">:</td>
          <td><?php echo strtoupper($idunit[1]); ?></td>
        </tr>
        <tr> 
          <td>LAPORAN</td>
          <td>:</td>
          
      <td><?php echo "BUKU BESAR ".strtoupper($bulan[1])." ".$ta; ?></td>
        </tr>
        <tr> 
          <td>MATA ANGGARAN</td>
          <td>:</td>
          <td><?php echo $kode_ma." - ".$ma; ?>
          </td>
        </tr>
      </table><br>
  <table width="99%" border="0" cellpadding="2" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl</td>
      <td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Cost Center</td>
	  <td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">No Kwitansi</td>
      <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
      <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
      <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Debet</td>
      <td id="KREDIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Kredit</td>
    </tr>
    <tr> 
      <td class="tdisikiri" align="center">1</td>
      <td class="tdisi" align="center"><?php echo $tgl1; ?></td>
      <td class="tdisi" align="center">-</td>
	  <td class="tdisi" align="center">-</td>
      <td class="tdisi"><?php echo $ma_kode; ?></td>
      <td class="tdisi"><strong>Saldo Awal</strong></td>
      <td class="tdisi" align="right"><strong><?php echo ($saldoawal>0)?number_format($saldoawal,0,",","."):"0"; ?></strong></td>
      <td class="tdisi" align="right"><strong><?php echo ($saldoawal>0)?"0":number_format(($saldo*-1),0,",","."); ?></strong></td>
    </tr>
	  <?php 
	$sql="select j.*,convert(varchar, tgl, 103) as tgl1,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join cost on fk_cost=cost_id where fk_idunit=$idunit[0] and month(j.tgl)=$bulan[0] and year(j.tgl)=$ta and ma_kode like '$kode_ma%' order by j.tr_id"
	;
	//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=1;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" align="center"><?php echo $i; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['kg_kode']; ?></td>
	  <td class="tdisi" align="center"><?php echo $rows['NO_KW']; ?></td>
      <td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
      <td class="tdisi"><?php echo $rows['URAIAN']; ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],0,",","."); ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['KREDIT'],0,",","."); ?></td>
    </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  <?php if ($page==$totpage){?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td colspan="6" class="tdisikiri" align="right"><strong>Subtotal&nbsp;&nbsp;</strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotd,0,",","."); ?></strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotk,0,",","."); ?></strong></td>
    </tr>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td colspan="6" class="tdisikiri" align="right"><strong>Saldo Akhir&nbsp;&nbsp;</strong></td>
      <td class="tdisi" align="right"><strong><?php echo (($totd>0)?number_format($totd,0,",","."):(($totd==0)?"0":"&nbsp;")); ?></strong></td>
      <td class="tdisi" align="right"><strong><?php echo (($totk>0)?number_format($totk,0,",","."):"&nbsp;"); ?></strong></td>
    </tr>
	  <?php }?>
  </table>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>