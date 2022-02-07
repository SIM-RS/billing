<?php
session_start();
include("../../sesi.php");
?>
<?php
	if($_REQUEST['export']=='excel'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap RL. 4b.xls"');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RL. 4B</title>
<style type="text/css" >
<?
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	$thn = $_REQUEST['cmbThn'];
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and d.tgl = '$tglAwal2' ";
		$Periode = "".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(d.tgl) = '$bln' and year(d.tgl) = '$thn' ";
		$Periode = "$arrBln[$bln] $thn";
		
	}
	else if($waktu == 'Tahunan'){
		$thn = $_POST['cmbThn'];
		$waktu = " and year(d.tgl) = '$thn' ";
		$Periode = "".$thn;
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and d.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$unit = $_REQUEST['cmbTempatLayananM'];
	if($unit==0){
		$fUnit = " p.jenis_kunjungan=2 ";
	}else{
		$fUnit = " p.unit_id = '".$unit."'";
	}
?>

table#header{
	border-collapse:collapse;
	width:100%;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
}
	
#table {
	text-align:center;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
}

table th{
	background-color:#CCC;
	}
	
#nomor,input{
	background-color:#0F3;
}

#adaborder{
	border:dotted;
}

</style>
</head>

<body>
<?php
        include("../../koneksi/konek.php");
		
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayananM']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
?>
<table id="header">
<tr>
<td width="7%" rowspan="2"> <img src="logo bhakti husada.jpg" width="50" height="50" align="right" /> </td>
<td width="73%">Formulir RL 4B</td>
<td width="20%" id="adaborder">Ditjen Bina Upaya Kesehatan Kementrian Kesehatan RI</td>
<?php 
if($_REQUEST['cmbTempatLayananM']==0){
	$rwUnit22 = "";
}
else{
	$rwUnit22 = "- ".$rwUnit2['nama'];
}
?>
</tr>
<tr><td>DATA KEADAAN MORBIDITAS PASIEN RAWAT DARURAT <?php echo $rwUnit22; ?></td></tr>

</table>
<hr />
&nbsp;

<table width="51%">
<tr>
<td>Kode RS</td>
<td><input type="text" id="textKodeRS" name="textKodeRS" value="3515015 " style="text-align:center;" readonly size="50" />
</tr>
<tr>
<td>Nama RS</td>
<td><input type="text" id="textNamaRS" name="textNamaRS" value="<?=$namaRS?>" style="text-align:center;" readonly size="50"/>
</tr>
<tr>
<td>Tahun</td>
<td><input type="text" id="textTahun" name="textTahun" value="<?= $Periode; ?>" style="text-align:center;" readonly  size="50"/>
</tr>
</table>
&nbsp;
<div id="table">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
  <tr>
    <th scope="col" rowspan="3">No. Urut</th>
    <th scope="col" rowspan="3">No. DTD</th>
    <th scope="col" rowspan="3">No. Daftar Terperinci</th>
    <th scope="col" rowspan="3">Golongan Sebab Penyakit</th>
    <th scope="col" colspan="18">Jumlah Pasien Kasus Menurut Golongan Umum dan Sex</th>
    <th scope="col" colspan="2">Kasus Baru Menurut Jenis Kelamin</th>
    <th scope="col" rowspan="3">Jumlah Kasus Baru (23+24)</th>
    <th scope="col" rowspan="3">Jumlah Kunjungan</th>    
  </tr>
  <tr>
    <th colspan="2">0-6 hr</th>
    <th colspan="2">7-18 hr</th>
    <th colspan="2">28hr - 1th</th>
    <th colspan="2">1-4 th</th>
    <th colspan="2">5-14 th</th>
    <th colspan="2">15-24 th</th>
    <th colspan="2">25-44 th</th>
    <th colspan="2">45-64 th</th>
    <th colspan="2">>65 th</th>
    <th rowspan="2">LK</th>
    <th rowspan="2">PR</th>   
  </tr>
  <tr>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>
    <th>L</th>
    <th>P</th>    
  </tr>
  <tr id="nomor">
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>
    <td>10</td>
    <td>11</td>
    <td>12</td>
    <td>13</td>
    <td>14</td>
    <td>15</td>
    <td>16</td>
    <td>17</td>
    <td>18</td>
    <td>19</td>
    <td>20</td>
    <td>21</td>
    <td>22</td>
    <td>23</td>
    <td>24</td>
    <td>25</td>
    <td>26</td>
  </tr>
   <?php
	if($_REQUEST['chkKecelakaan']=='on'){
  		$sql = "select dg_kode,dg_group,dg_nama from b_ms_diagnosa_gol where dg_tipe=1 order by dg_kode";
    }
    else{
  		$sql = "select dg_kode,dg_group,dg_nama from b_ms_diagnosa_gol where dg_tipe=0 order by dg_kode";
    }
	$rsql = mysql_query($sql);
	$no=0;
	
	$tL1=0;
	$tL2=0;
	$tL3=0;
	$tL4=0;
	$tL5=0;
	$tL6=0;
	$tL7=0;
	$tL8=0;
	$tL9=0;
	
	$tP1=0;
	$tP2=0;
	$tP3=0;
	$tP4=0;
	$tP5=0;
	$tP6=0;
	$tP7=0;
	$tP8=0;
	$tP9=0;
	
	$tLk=0;
	$tPr=0;
	
	$tKunj=0;
	while($rwx = mysql_fetch_array($rsql)){
				
				
			$sql="SELECT COUNT(d.diagnosa_id) jml,k.kel_umur,mp.sex
FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN b_diagnosa d ON p.id=d.pelayanan_id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
INNER JOIN (select id from b_ms_diagnosa where dg_kode='$rwx[dg_kode]') md ON md.id=d.ms_diagnosa_id
WHERE $fUnit 
$waktu AND d.kasus_baru=1 AND d.primer=1 GROUP BY k.kel_umur,mp.sex";
				//echo $sql."<br>";
			$rs = mysql_query($sql);
			
			$L1=0;
			$L2=0;
			$L3=0;
			$L4=0;
			$L5=0;
			$L6=0;
			$L7=0;
			$L8=0;
			$L9=0;
			
			$P1=0;
			$P2=0;
			$P3=0;
			$P4=0;
			$P5=0;
			$P6=0;
			$P7=0;
			$P8=0;
			$P9=0;
			
			$lk=0;
			$pr=0;
			$mati=0;
			
			while($rw = mysql_fetch_array($rs)){
					if($rw['kel_umur']==236) ($rw['sex']=='L')? $L1=$rw['jml']:$P1=$rw['jml'];
					if($rw['kel_umur']==206) ($rw['sex']=='L')? $L2=$rw['jml']:$P2=$rw['jml'];
					if($rw['kel_umur']==207) ($rw['sex']=='L')? $L3=$rw['jml']:$P3=$rw['jml'];
					if($rw['kel_umur']==208) ($rw['sex']=='L')? $L4=$rw['jml']:$P4=$rw['jml'];
					if($rw['kel_umur']==209) ($rw['sex']=='L')? $L5=$rw['jml']:$P5=$rw['jml'];
					if($rw['kel_umur']==210) ($rw['sex']=='L')? $L6=$rw['jml']:$P6=$rw['jml'];
					if($rw['kel_umur']==211) ($rw['sex']=='L')? $L7=$rw['jml']:$P7=$rw['jml'];
					if($rw['kel_umur']==212) ($rw['sex']=='L')? $L8=$rw['jml']:$P8=$rw['jml'];
					if($rw['kel_umur']==213) ($rw['sex']=='L')? $L9=$rw['jml']:$P9=$rw['jml'];
					
					$lk=$L1 + $L2 + $L3  + $L4 + $L5 + $L6 + $L7 + $L8 + $L9;
					$pr=$P1 + $P2 + $P3  + $P4 + $P5 + $P6 + $P7 + $P8 + $P9;
					
			}
			$tL1=$tL1+$L1;
			$tL2=$tL2+$L2;
			$tL3=$tL3+$L3;
			$tL4=$tL4+$L4;
			$tL5=$tL5+$L5;
			$tL6=$tL6+$L6;
			$tL7=$tL7+$L7;
			$tL8=$tL8+$L8;
			$tL9=$tL9+$L9;
			
			$tP1=$tP1+$P1;
			$tP2=$tP2+$P2;
			$tP3=$tP3+$P3;
			$tP4=$tP4+$P4;
			$tP5=$tP5+$P5;
			$tP6=$tP6+$P6;
			$tP7=$tP7+$P7;
			$tP8=$tP8+$P8;
			$tP9=$tP9+$P9;
			
			$tLk=$tL1+$tL2+$tL3+$tL4+$tL5+$tL6+$tL7+$tL8+$tL9;
			$tPr=$tP1+$tP2+$tP3+$tP4+$tP5+$tP6+$tP7+$tP8+$tP9;
			
			$kasus_baru="SELECT COUNT(d.diagnosa_id) jml
FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN b_diagnosa d ON p.id=d.pelayanan_id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
INNER JOIN (SELECT id FROM b_ms_diagnosa WHERE dg_kode='$rwx[dg_kode]') md ON md.id=d.ms_diagnosa_id
WHERE $fUnit 
$waktu $fKso AND d.primer=1";
				//echo $sql."<br>";
			$kueri = mysql_query($kasus_baru);
			$baru = mysql_fetch_array($kueri);
			$jum_kunj=0;
			if($baru['jml']=='0'){
				$jum_kunj='';
			}
			else{
				$jum_kunj=$baru['jml'];
				$tKunj=$tKunj+$jum_kunj;
			}
	?>
		<tr>
			<td >&nbsp;<?php $no=$no+1; echo $no;?></td>
			<td align="left"><?php echo ($rwx['dg_kode']=='')? ' ' : $rwx['dg_kode'];?></td>
			<td align="left"><?php echo ($rwx['dg_group']=='')? ' ' : $rwx['dg_group'];?></td>
			<td align="left"><?php echo ($rwx['dg_nama']=='')? ' ' : $rwx['dg_nama'];?></td>
			<td><?php echo  ($L1==0)? '': $L1;?></td>
			<td><?php echo  ($P1==0)? '': $P1;?></td>
			<td><?php echo  ($L2==0)? '': $L2;?></td>
			<td><?php echo  ($P2==0)? '': $P2;?></td>
			<td><?php echo  ($L3==0)? '': $L3;?></td>
			<td><?php echo  ($P3==0)? '': $P3;?></td>
			<td><?php echo  ($L4==0)? '': $L4;?></td>
			<td><?php echo  ($P4==0)? '': $P4;?></td>
			<td><?php echo  ($L5==0)? '': $L5;?></td>
			<td><?php echo  ($P5==0)? '': $P5;?></td>
			<td><?php echo  ($L6==0)? '': $L6;?></td>
			<td><?php echo  ($P6==0)? '': $P6;?></td>
			<td><?php echo  ($L7==0)? '': $L7;?></td>
			<td><?php echo  ($P7==0)? '': $P7;?></td>
			<td><?php echo  ($L8==0)? '': $L8;?></td>
			<td><?php echo  ($P8==0)? '': $P8;?></td>
			<td><?php echo  ($L9==0)? '': $L9;?></td>
			<td><?php echo  ($P9==0)? '': $P9;?></td>
			<td><?php if($lk==0) echo ''; else echo $lk;?></td>
			<td><?php if($pr==0) echo ''; else echo $pr;?></td>
			<td><?php if($lk+$pr==0) echo ''; else echo $lk+$pr;?></td>
			<td><?php echo $jum_kunj;?></td>
			
		</tr>
	<?php	
	}
	?>
    	<tr>
			<td colspan="4" align="right" style="font-weight:bold;">Total :&nbsp;</td>
			<td><?php if($tL1==0) echo ''; else echo $tL1; ?></td>
			<td><?php if($tP1==0) echo ''; else echo $tP1; ?></td>
			<td><?php if($tL2==0) echo ''; else echo $tL2; ?></td>
			<td><?php if($tP2==0) echo ''; else echo $tP2; ?></td>
			<td><?php if($tL3==0) echo ''; else echo $tL3; ?></td>
			<td><?php if($tP3==0) echo ''; else echo $tP3; ?></td>
			<td><?php if($tL4==0) echo ''; else echo $tL4; ?></td>
			<td><?php if($tP4==0) echo ''; else echo $tP4; ?></td>
			<td><?php if($tL5==0) echo ''; else echo $tL5; ?></td>
			<td><?php if($tP5==0) echo ''; else echo $tP5; ?></td>
			<td><?php if($tL6==0) echo ''; else echo $tL6; ?></td>
			<td><?php if($tP6==0) echo ''; else echo $tP6; ?></td>
			<td><?php if($tL7==0) echo ''; else echo $tL7; ?></td>
			<td><?php if($tP7==0) echo ''; else echo $tP7; ?></td>
			<td><?php if($tL8==0) echo ''; else echo $tL8; ?></td>
			<td><?php if($tP8==0) echo ''; else echo $tP8; ?></td>
			<td><?php if($tL9==0) echo ''; else echo $tL9; ?></td>
			<td><?php if($tP9==0) echo ''; else echo $tP9; ?></td>
			<td><?php if($tLk==0) echo ''; else echo $tLk; ?></td>
			<td><?php if($tPr==0) echo ''; else echo $tPr; ?></td>
			<td><?php if($tLk+$tPr==0) echo ''; else echo $tLk+$tPr; ?></td>
			<td><?php if($tKunj==0) echo ''; else echo $tKunj; ?></td>
			
		</tr>
</table>
<br/>
<div align="center">
				<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak();"/>&nbsp;&nbsp;&nbsp;
				<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>&nbsp;&nbsp;&nbsp;
                <input id="btnExcell" type="button" value="Export ke Excell" onClick="eksport();"/>
</div>
</div>
</body>
<script type="text/JavaScript">
function cetak(){
	var tombol=document.getElementById('trTombol').style.visibility='collapse';
	if(tombol=='collapse'){
		window.print();
		window.close(); 
	}
}

function eksport(){
	window.open('rl4c_xls.php?cmbWaktu=<?php echo $_REQUEST['cmbWaktu']; ?>&tglAwal2=<?php echo $_REQUEST['tglAwal2']; ?>&tglAwal=<?php echo $_REQUEST['tglAwal']; ?>&tglAkhir=<?php echo $_REQUEST['tglAkhir']; ?>&cmbBln=<?php echo $_REQUEST['cmbBln']; ?>&cmbThn=<?php echo $_REQUEST['cmbThn']; ?>&statusPas=<?php echo $_REQUEST['statusPas'];?>&chkKecelakaan=<?php echo $_REQUEST['chkKecelakaan'];?>&cmbTempatLayananM=<?php echo $_REQUEST['cmbTempatLayananM']; ?>');
}
</script>
</html>