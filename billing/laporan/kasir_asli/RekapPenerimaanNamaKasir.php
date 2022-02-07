<?php
	session_start();
	include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rekapitulasi Penerimaan Berdasarkan Nama Kasir</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
	$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
	$selisih=$tgl2-$tgl1;
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['jnsLay']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['tmptLay']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Rekapitulasi Penerimaan Berdasarkan Nama Kasir<br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  
  <tr>
    <td align="right">Yang Mencetak:&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td>&nbsp;</td>
			<td colspan="3" align="left">&nbsp;PENERIMAAN/TANGGAL</td>
		  </tr>
		  <tr>
			<td width="100" style="border-bottom:1px solid;">&nbsp;<b>KASIR</b></td>
			<?php
				$bln=$tglAwal[1];
				$th=$tglAwal[2];
				for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
				{ 
					if($th%4==0 and $th%100!=0)
						$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
					else
						$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
					if($i==$tglAwal[0])
						$hari=$i;
					else
						$hari=$hari+1;		
					if($hari>$arrHari[$bln])
					{
						$hari=$hari-$arrHari[$bln];
						$bln=$bln+1;
					}
					if($bln>12)
					{
						$bln=$bln-12;
						$th=$th+1;
					}
			?>
			<td width="80" align="right" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;"><b><?php echo $hari?></b>&nbsp;</td>
			<?php 
				}
			?>
			<td width="80" align="right" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid;"><b>Total</b>&nbsp;</td>
		  </tr>
			<?php 
				if($_REQUEST['nmKsr']!=0){
					$fKsr = "b_ms_pegawai.id = '".$_REQUEST['nmKsr']."'";
				}else{
					$fKsr = "b_ms_unit.id = '".$_REQUEST['cmbKasir2']."'";
				}
				$qKsr = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai_unit
				INNER JOIN b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id
				INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_ms_pegawai_unit.ms_pegawai_id
				WHERE $fKsr
				GROUP BY b_ms_pegawai.id
				ORDER BY b_ms_pegawai.nama";
				$rsKsr = mysql_query($qKsr);
				/* $qKsr = mysql_query("SELECT b_bayar.user_act,b_ms_pegawai.nama FROM b_bayar INNER JOIN b_ms_pegawai ON b_bayar.user_act=b_ms_pegawai.id WHERE tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' GROUP BY b_bayar.user_act ORDER BY b_ms_pegawai.nama"); */
				while($rwKsr = mysql_fetch_array($rsKsr))
				{
			?>
		  <tr>
			<td style="border-bottom:1px solid; border-left:1px solid; text-transform:uppercase;">&nbsp;<?php echo $rwKsr['nama']?></td>
			<?php
					$bln=$tglAwal[1];
					$th=$tglAwal[2];
					$tot = 0;
					for($i=$tglAwal[0];$i<=($tglAwal[0]+$selisih);$i++)
					{ 
						if($th%4==0 and $th%100!=0)
							$arrHari=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
						else
							$arrHari=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
						if($i==$tglAwal[0])
							$hari=$i;
						else
							$hari=$hari+1;		
						if($hari>$arrHari[$bln])
						{
							$hari=$hari-$arrHari[$bln];
							$bln=$bln+1;
						}
						if($bln>12)
						{
							$bln=$bln-12;
							$th=$th+1;
						}
						$qNilai= mysql_query("SELECT if(nilai is null,0,nilai) nilai FROM b_bayar WHERE user_act=".$rwKsr['id']." AND tgl=CONCAT_WS('-','$th','$bln','$hari')");
						$rwNilai=mysql_fetch_array($qNilai);
			?>
			<td align="right" style="border-bottom:1px solid; border-left:1px solid;"><?php if($rwNilai['nilai']=='') echo 0; else echo number_format($rwNilai['nilai'],0,",",".")?>&nbsp;</td>
			<?php 
				$tot=$tot+$rwNilai['nilai'];
					}
			?>
			<td align="right" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid;"><?php echo number_format($tot,0,",",".")?>&nbsp;</td>
		  </tr>  
			<? 
				}
			?>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</table>	</td>
  </tr>
</table>
</body>
</html>