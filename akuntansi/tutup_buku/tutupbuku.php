<?php 
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);
$cunit=$_REQUEST["cunit"];
$idunit=explode("|",$cunit);
$iunit=$idunit[1];
$idunit=$idunit[0];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];
if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}else{
	$bulan=explode("|",$bulan);
}

$act=$_REQUEST['act'];
//echo $act;
/*switch ($act){
	case "save":
		$sql="";
		//echo $sql."<br>";
		//$rs1=mysql_query($sql);
		break;
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Transaksi Jurnal</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center">
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
  <input name="cunit" id="cunit" type="hidden" value="<?php echo $cunit; ?>">
<div id="input" style="display:block">
<?php if ($act=="save"){?>
	<br>
	  <div id="wait"><span class="jdltable">Proses Tutup Buku :</span> <img src="../icon/wait.gif" /></div>
	  <?php 
	  	if ($bulan[0]==12){
			$nbulan=1;
			$nta=$ta+1;
		}else{
			$nbulan=$bulan[0]+1;
			$nta=$ta;
		}
		
		$sql="DELETE FROM saldo WHERE bulan=$nbulan AND tahun=$nta";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		
	  	$sql="select fk_sak,CC_RV_KSO_PBF_UMUM_ID,if(sum(debit) is null,0,sum(debit)) as debit,if(sum(kredit) is null,0,sum(kredit)) as kredit from jurnal where month(tgl)=$bulan[0] and year(tgl)=$ta group by fk_sak,CC_RV_KSO_PBF_UMUM_ID";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$cidma="";
		while ($rows=mysql_fetch_array($rs)){
			$idma=$rows['fk_sak'];
			//$cidma .=$idma.",";
			$CC_RV_KSO_PBF_UMUM_ID=$rows['CC_RV_KSO_PBF_UMUM_ID'];
			$stotd=$rows['debit'];
			$stotk=$rows['kredit'];
			$sql="select saldo_awal from saldo where fk_maid=$idma and CC_RV_KSO_PBF_UMUM_ID='$CC_RV_KSO_PBF_UMUM_ID' and bulan=$bulan[0] and tahun=$ta";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$saldo_awal=$rows1['saldo_awal'];
			}else{
				$saldo_awal=0;
			}
			$saldo_akhir=$saldo_awal+$stotd-$stotk;
			$sql="select saldo_awal from saldo where fk_maid=$idma and CC_RV_KSO_PBF_UMUM_ID='$CC_RV_KSO_PBF_UMUM_ID' and bulan=$nbulan and tahun=$nta";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$sql="update saldo set saldo_awal=$saldo_akhir where fk_maid=$idma and CC_RV_KSO_PBF_UMUM_ID='$CC_RV_KSO_PBF_UMUM_ID' and bulan=$nbulan and tahun=$nta";
				//echo $sql."<br>";
			}else{
				$sql="insert into saldo(FK_MAID,CC_RV_KSO_PBF_UMUM_ID,BULAN,TAHUN,SALDO_AWAL) values($idma,'$CC_RV_KSO_PBF_UMUM_ID',$nbulan,$nta,$saldo_akhir)";
				//echo $sql."<br>";
			}
			$rs1=mysql_query($sql);
		}
		/*if ($cidma!="") $cidma=substr($cidma,0,strlen($cidma)-1); else $cidma="0";
		$sql="select * from saldo where bulan=$bulan[0] and tahun=$ta and fk_maid not in ($cidma)";*/
		$sql="SELECT t1.*,t2.SALDO_ID FROM (SELECT * FROM saldo WHERE bulan=$bulan[0] AND tahun=$ta) AS t1 
LEFT JOIN (SELECT * FROM saldo WHERE bulan=$nbulan AND tahun=$nta) AS t2 ON t1.FK_MAID=t2.FK_MAID AND t1.CC_RV_KSO_PBF_UMUM_ID=t2.CC_RV_KSO_PBF_UMUM_ID
WHERE t2.SALDO_ID IS NULL";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		while ($rows=mysql_fetch_array($rs)){
			$idma=$rows['FK_MAID'];
			$CC_RV_KSO_PBF_UMUM_ID=$rows['CC_RV_KSO_PBF_UMUM_ID'];
			$saldo_akhir=$rows['SALDO_AWAL'];
			$sql="select saldo_awal from saldo where fk_maid=$idma and CC_RV_KSO_PBF_UMUM_ID='$CC_RV_KSO_PBF_UMUM_ID' and bulan=$nbulan and tahun=$nta";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$sql="update saldo set saldo_awal=$saldo_akhir where fk_maid=$idma and CC_RV_KSO_PBF_UMUM_ID='$CC_RV_KSO_PBF_UMUM_ID' and bulan=$nbulan and tahun=$nta";			
			}else{
				$sql="insert into saldo(FK_MAID,CC_RV_KSO_PBF_UMUM_ID,BULAN,TAHUN,SALDO_AWAL) values($idma,'$CC_RV_KSO_PBF_UMUM_ID',$nbulan,$nta,$saldo_akhir)";			
			}
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
		}
		mysql_free_result($rs);
	  ?>
	  <script>
	  	document.getElementById("wait").innerHTML="<b>Proses Tutup Buku : <?php echo $bulan[1].' '.$ta; ?> Selesai</b>";
	  </script>
<?php }else{?>
	  <p class="jdltable">Proses Tutup Buku Keuangan</p>
      <table width="300" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php echo $iunit; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>Bulan</td>
          <td width="10">:</td>
          <td><select name="bulan" id="bulan">
              <option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
              <option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
              <option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
              <option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
              <option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
              <option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
              <option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
              <option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
              <option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
              <option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
              <option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
              <option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td width="10">:</td>
          <td><select name="ta" id="ta">
		  	<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
			<?php }?>
            </select> </td>
        </tr>
      </table>
<p>
        <BUTTON type="button" onClick="document.form1.submit();"><IMG SRC="../icon/ok.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Proses</strong></BUTTON>
<?php }?>
</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>