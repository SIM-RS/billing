<?php 
include "../sesi.php";
include("../koneksi/konek.php");
$sekarang=gmdate('d-m-Y',mktime(date('H')+7));
$ta=$_REQUEST['ta'];
$bulan=explode("|",$_REQUEST['bulan']);
$idunit=explode("|",$_REQUEST['idunit']);
$cuser=$_REQUEST['cuser'];if ($cuser=="") $cuser="0";
//header("Content-Type: application/msword");
// header("Content-Type: application/excell");
// header('Content-disposition: inline; filename="jurnal.xls"');

//Convert tgl di URL menjadi YYYY-mm-dd ==============================
$tgl_s=$_REQUEST['tgl_s']; if ($tgl_s=='') $tgl_s=$sekarang;
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";

$tgl_d=$_REQUEST['tgl_d']; if ($tgl_d=='') $tgl_d=$sekarang;
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";

//$defaultsort="NO_TRANS DESC";
//$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

//===========================================================

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
  <table width="99%" border="0" cellpadding="2" cellspacing="0">
    <tr> 
      <td width="100%" align="center" colspan="9">SISTEM KEUANGAN <?=$namaRS;?></td>
    </tr>
    <tr> 
      <td width="100%" align="center" colspan="9">LAPORAN  JURNAL MULAI TANGGAL <?php echo $tgl_s; ?> s/d TANGGAL <?php echo $tgl_d; ?></td>
    </tr>
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td id="no_trans" width="25" class="tblheader" onClick="ifPop.CallFr(this);">No.Trans</td>
      <td id="TGL" width="80" class="tblheader">Tgl</td>
      <td id="NO_KW" width="80" class="tblheader">No. Bukti</td>
      <td id="MA_KODE" width="90" class="tblheader">Kode Rekening</td>
      <td id="URAIAN" width="200" class="tblheader">MA SAK</td>
      <td id="URAIAN" width="200" class="tblheader">Uraian</td>
      <td id="DEBIT" width="100" class="tblheader">Debet</td>
      <td id="KREDIT" width="100" class="tblheader">Kredit</td>
    </tr>
    <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  //if ($sorting=="") $sorting=$defaultsort;
	  if ($cuser=="0") $fuser=""; else $fuser=" AND FK_IDUSER=".$cuser;
	  $sqlQ="Select jurnal.*, ma_sak.MA_KODE, ma_sak.MA_KODE_VIEW, ma_sak.MA_NAMA, ma_sak.FK_MA, ma_sak.CC_RV_KSO_PBF_UMUM From jurnal Inner Join ma_sak ON jurnal.FK_SAK = ma_sak.MA_ID where TGL between '$tgl_se' and '$tgl_de'".$fuser.$filter." AND jurnal.flag = '$flag' order by TGL,TR_ID"; //decyber _jurnal_print
	//   echo $sqlQ."<br>flag".$flag;
	  $rs=mysql_query($sqlQ);
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$ccrvpbf=$rows['CC_RV_KSO_PBF_UMUM'];
		$ketcc="";
		$txtKodeMA=$rows['MA_KODE_VIEW'];
		switch ($ccrvpbf){
			case 1:
				$sql="SELECT * FROM ak_ms_unit WHERE tipe=1 AND id=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["nama"];
				$txtKodeMA.=$rwcc["kode"];
				break;
			case 2:
				$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["nama"];
				$txtKodeMA.=$rwcc["kode_ak"];
				break;
			case 3:
				$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["PBF_NAMA"];
				$txtKodeMA.=$rwcc["PBF_KODE_AK"];
				break;
			case 4:
				$sql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=".$rows['CC_RV_KSO_PBF_UMUM_ID'];
				$rscc=mysql_query($sql);
				$rwcc=mysql_fetch_array($rscc);
				$ketcc=" - ".$rwcc["namarekanan"];
				$txtKodeMA.=$rwcc["koderekanan"];
				break;
		}
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" align="center"><?php echo $i; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['NO_TRANS']; ?></td>
      <td class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
      <td class="tdisi"><?php echo $rows['NO_KW']; ?></td>
      <td class="tdisi"><?php echo "'".$txtKodeMA."'"; ?></td>
      <td class="tdisi"><?php echo $rows['MA_NAMA'].$ketcc; ?></td>
      <td class="tdisi"><?php echo $rows['URAIAN']; ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],2,",","."); ?></td>
      <td class="tdisi" align="right"><?php echo number_format($rows['KREDIT'],2,",","."); ?></td>
    </tr>
    <?php 
	  }
	  mysql_free_result($rs);
	  //$sql="select sum(debit) as stotd,sum(kredit) as stotk from jurnal where TGL between '$tgl_se' and '$tgl_de'";
	  $sql="select sum(debit) as stotd,sum(kredit) as stotk from ($sqlQ) as t1";
	  $rs=mysql_query($sql);
	  $stotd=0;
	  $stotk=0;
	  if ($rows=mysql_fetch_array($rs)){
	  	$stotd=$rows["stotd"];
		$stotk=$rows["stotk"];
	  }
	  mysql_free_result($rs);
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" colspan="7" align="right" height="20"><strong>Subtotal&nbsp;&nbsp;</strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotd,2,",","."); ?></strong></td>
      <td class="tdisi" align="right"><strong><?php echo number_format($stotk,2,",","."); ?></strong></td>
    </tr>
  </table>
</div>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>