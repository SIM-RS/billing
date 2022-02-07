<?php
session_start();
include("../../sesi.php");
?>
<?php 
include("../../koneksi/konek.php");

$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayananM']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);

//DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP
if($_REQUEST['cmbTempatLayananM']==0){
	$rwUnit22 = "";
}
else{
	$rwUnit22 = "- ".$rwUnit2['nama'];
}

//conf date
 $date_now=gmdate('d-m-Y',mktime(date('H')+7));
		$jam = date("G:i");
		$thn = $_REQUEST['cmbThn'];
       $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
		$waktu = $_REQUEST['cmbWaktu'];
    if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and d.tgl = '$tglAwal2' ";
		$Periode = " ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_REQUEST['cmbBln'];
		$thn = $_REQUEST['cmbThn'];
		$waktu = " and month(d.tgl) = '$bln' and year(d.tgl) = '$thn' ";
		$Periode = " $arrBln[$bln]  $thn";
		
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
		
		$Periode = " ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	$kso = $_REQUEST['StatusPas'];
	if($kso==0){
		$fKso = "";
	}else{
		$fKso = " AND k.kso_id = '".$kso."'";
	}
	
	$unit = $_REQUEST['cmbTempatLayananM'];
	if($unit==0){
		$fUnit = " p.jenis_kunjungan=3 ";
	}else{
		$fUnit = " p.unit_id = '".$unit."'";
	}

//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('RL4a.xls');

$worksheet=&$workbook->addWorksheet('Rekam_Medik');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 10);
	$worksheet->setColumn (1, 1, 10);
	$worksheet->setColumn (2, 2, 50);
	$worksheet->setColumn (3, 3, 50);
	$worksheet->setColumn (4, 4, 5);
	$worksheet->setColumn (5, 5, 5);
	$worksheet->setColumn (6, 6, 5);
	$worksheet->setColumn (7, 7, 5);
	$worksheet->setColumn (8, 8, 5);
	$worksheet->setColumn (9, 9, 5);
	$worksheet->setColumn (10, 10, 5);
	$worksheet->setColumn (11, 11, 5);
	$worksheet->setColumn (12, 12, 5);
	$worksheet->setColumn (13, 13, 5);
	$worksheet->setColumn (14, 14, 5);
	$worksheet->setColumn (15, 15, 5);
	$worksheet->setColumn (16, 16, 5);
	$worksheet->setColumn (17, 17, 5);
	$worksheet->setColumn (18, 18, 5);
	$worksheet->setColumn (19, 19, 5);
	$worksheet->setColumn (20, 20, 5);
	$worksheet->setColumn (21, 21, 5);
	$worksheet->setColumn (22, 22, 25);
	$worksheet->setColumn (23, 23, 25);
	$worksheet->setColumn (24, 24, 25);
	$worksheet->setColumn (25, 25, 25);
	
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12,'align'=>'center','bold'=>1));
$sheetTitleFormatL =& $workbook->addFormat(array('size'=>11,'align'=>'left'));
$sheetTitleFormatR =& $workbook->addFormat(array('size'=>11,'align'=>'right'));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>11,'align'=>'center','bold'=>1,'top'=>1,'bottom'=>1,'left'=>1,'right'=>1));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','height'=>25,'vAlign'=>'vcenter'));
$columnTitleFormatNo =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','height'=>25,'vAlign'=>'vcenter','bgColor'=>'red','color'=>'white'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));

$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$garisAtas =& $workbook->addFormat(array('size'=>8,'align'=>'left','top'=>1));
$textBold1 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$textBold2 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$textBold3 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));

$textBiasa1 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left'));
$textBiasa2 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'center'));
$textBiasa3 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','padding-left'=>'5'));
$textBiasa4 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));
$textBiasa5 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','padding-right'=>'5'));
$textBiasa6 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));
$textBiasa7 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','numFormat'=>'#,##0','top'=>1));
$textBiasa8 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','numFormat'=>'#,##0'));

$column = 0;
$row = 0;

$worksheet->write($row, 22, "Ditjen Bina Upaya Kesehatan Kementrian Kesehatan RI",$UnitTitleFormatC);
$worksheet->write($row+1, 1, "Formulir RL 4A",$UnitTitleFormatL);
$worksheet->write($row+2,1, "DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP ".$rwUnit22."",$UnitTitleFormatL);
$worksheet->mergeCells($row,22,$row+2,25);
$row+=4;
$worksheet->write($row,0, "Kode RS",$UnitTitleFormatL);
$worksheet->write($row,1, ": 3515015",$UnitTitleFormatL);
$worksheet->write($row+1,0, "Nama RS",$UnitTitleFormatL);
$worksheet->write($row+1,1, ": ".$namaRS,$UnitTitleFormatL);
$worksheet->write($row+2,0, "Tahun",$UnitTitleFormatL);
$worksheet->write($row+2,1, ": ".$Periode."",$UnitTitleFormatL);

$row+=3;
//====================Header Field====================//
$worksheet->write($row, $column, "No.Urut", $columnTitleFormat);
$worksheet->write($row+1, $column, "", $columnTitleFormat);
$worksheet->write($row+2, $column, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column,$row+2,$column);
$worksheet->write($row, $column+1, "No.DTD", $columnTitleFormat);
$worksheet->write($row+1, $column+1, "", $columnTitleFormat);
$worksheet->write($row+2, $column+1, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+1,$row+2,$column+1);
$worksheet->write($row, $column+2, "No. Daftar Terperinci", $columnTitleFormat);
$worksheet->write($row+1, $column+2, "", $columnTitleFormat);
$worksheet->write($row+2, $column+2, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+2,$row+2,$column+2);
$worksheet->write($row, $column+3, "Golongan Sebab Penyakit", $columnTitleFormat);
$worksheet->write($row+1, $column+3, "", $columnTitleFormat);
$worksheet->write($row+2, $column+3, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+3,$row+2,$column+3);
$worksheet->write($row, $column+4, "Jumlah Pasien Hidup dan Mati Menurut Golongan Umum dan Jenis Kelamin", $columnTitleFormat);
$worksheet->mergeCells($row,$column+4,$row,$column+21);
$worksheet->write($row, $column+5, "", $columnTitleFormat);
$worksheet->write($row, $column+6, "", $columnTitleFormat);
$worksheet->write($row, $column+7, "", $columnTitleFormat);
$worksheet->write($row, $column+8, "", $columnTitleFormat);
$worksheet->write($row, $column+9, "", $columnTitleFormat);
$worksheet->write($row, $column+10, "", $columnTitleFormat);
$worksheet->write($row, $column+11, "", $columnTitleFormat);
$worksheet->write($row, $column+12, "", $columnTitleFormat);
$worksheet->write($row, $column+13, "", $columnTitleFormat);
$worksheet->write($row, $column+14, "", $columnTitleFormat);
$worksheet->write($row, $column+15, "", $columnTitleFormat);
$worksheet->write($row, $column+16, "", $columnTitleFormat);
$worksheet->write($row, $column+17, "", $columnTitleFormat);
$worksheet->write($row, $column+18, "", $columnTitleFormat);
$worksheet->write($row, $column+19, "", $columnTitleFormat);
$worksheet->write($row, $column+20, "", $columnTitleFormat);
$worksheet->write($row, $column+21, "", $columnTitleFormat);

$worksheet->write($row+1, $column+4, "0-6 hr", $columnTitleFormat);
$worksheet->write($row+1, $column+5, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+4,$row+1,$column+5);
$worksheet->write($row+1, $column+6, "7-18 hr", $columnTitleFormat);
$worksheet->write($row+1, $column+7, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+6,$row+1,$column+7);
$worksheet->write($row+1, $column+8, "28hr - 1th", $columnTitleFormat);
$worksheet->write($row+1, $column+9, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+8,$row+1,$column+9);
$worksheet->write($row+1, $column+10, "1-4 th", $columnTitleFormat);
$worksheet->write($row+1, $column+11, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+10,$row+1,$column+11);
$worksheet->write($row+1, $column+12, "5-14 th", $columnTitleFormat);
$worksheet->write($row+1, $column+13, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+12,$row+1,$column+13);
$worksheet->write($row+1, $column+14, "15-24 th", $columnTitleFormat);
$worksheet->write($row+1, $column+15, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+14,$row+1,$column+15);
$worksheet->write($row+1, $column+16, "25-44 th", $columnTitleFormat);
$worksheet->write($row+1, $column+17, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+16,$row+1,$column+17);
$worksheet->write($row+1, $column+18, "45-64 th", $columnTitleFormat);
$worksheet->write($row+1, $column+19, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+18,$row+1,$column+19);
$worksheet->write($row+1, $column+20, ">65 th", $columnTitleFormat);
$worksheet->write($row+1, $column+21, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+20,$row+1,$column+21);

$worksheet->write($row+2, $column+4, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+5, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+6, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+7, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+8, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+9, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+10, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+11, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+12, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+13, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+14, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+15, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+16, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+17, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+18, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+19, "P", $columnTitleFormat);
$worksheet->write($row+2, $column+20, "L", $columnTitleFormat);
$worksheet->write($row+2, $column+21, "P", $columnTitleFormat);

$worksheet->write($row, $column+22, "Pasien Keluar ( Hidup dan Mati ) \n Menurut Jenis Kelamin", $columnTitleFormat);
$worksheet->write($row, $column+23, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+22,$row,$column+23);
$worksheet->write($row+1, $column+22, "LK", $columnTitleFormat);
$worksheet->write($row+2, $column+22, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+22,$row+2,$column+22);
$worksheet->write($row+1, $column+23, "PR", $columnTitleFormat);
$worksheet->write($row+2, $column+23, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+23,$row+2,$column+23);
$worksheet->write($row+2, $column+23, "", $columnTitleFormat);
$worksheet->mergeCells($row+1,$column+23,$row+2,$column+23);
$worksheet->write($row, $column+24, "Jumlah Kasus Baru (23+24)", $columnTitleFormat);
$worksheet->write($row+1, $column+24, "", $columnTitleFormat);
$worksheet->write($row+2, $column+24, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+24,$row+2,$column+24);
$worksheet->write($row, $column+25, "Jumlah Pasien Keluar Mati", $columnTitleFormat);
$worksheet->write($row+1, $column+25, "", $columnTitleFormat);
$worksheet->write($row+2, $column+25, "", $columnTitleFormat);
$worksheet->mergeCells($row,$column+25,$row+2,$column+25);

$row += 3;
$worksheet->write($row, $column, "1", $columnTitleFormatNo);
$worksheet->write($row, $column+1, "2", $columnTitleFormatNo);
$worksheet->write($row, $column+2, "3", $columnTitleFormatNo);
$worksheet->write($row, $column+3, "4", $columnTitleFormatNo);
$worksheet->write($row, $column+4, "5", $columnTitleFormatNo);
$worksheet->write($row, $column+5, "6", $columnTitleFormatNo);
$worksheet->write($row, $column+6, "7", $columnTitleFormatNo);
$worksheet->write($row, $column+7, "8", $columnTitleFormatNo);
$worksheet->write($row, $column+8, "9", $columnTitleFormatNo);
$worksheet->write($row, $column+9, "10", $columnTitleFormatNo);
$worksheet->write($row, $column+10, "11", $columnTitleFormatNo);
$worksheet->write($row, $column+11, "12", $columnTitleFormatNo);
$worksheet->write($row, $column+12, "13", $columnTitleFormatNo);
$worksheet->write($row, $column+13, "14", $columnTitleFormatNo);
$worksheet->write($row, $column+14, "15", $columnTitleFormatNo);
$worksheet->write($row, $column+15, "16", $columnTitleFormatNo);
$worksheet->write($row, $column+16, "17", $columnTitleFormatNo);
$worksheet->write($row, $column+17, "18", $columnTitleFormatNo);
$worksheet->write($row, $column+18, "19", $columnTitleFormatNo);
$worksheet->write($row, $column+19, "20", $columnTitleFormatNo);
$worksheet->write($row, $column+20, "21", $columnTitleFormatNo);
$worksheet->write($row, $column+21, "22", $columnTitleFormatNo);
$worksheet->write($row, $column+22, "23", $columnTitleFormatNo);
$worksheet->write($row, $column+23, "24", $columnTitleFormatNo);
$worksheet->write($row, $column+24, "25", $columnTitleFormatNo);
$worksheet->write($row, $column+25, "26", $columnTitleFormatNo);

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
	
	$tMati=0;
	$no=1;
	while($rwx = mysql_fetch_array($rsql)){
	$row+=1;
	$jm=0;
	$sql="SELECT COUNT(d.diagnosa_id) jml,k.kel_umur,mp.sex,
SUM(IFNULL((SELECT 1 FROM b_pasien_keluar WHERE kunjungan_id=d.kunjungan_id AND cara_keluar='Meninggal'),0)) mati 
FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN b_diagnosa_rm d ON p.id=d.pelayanan_id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
INNER JOIN (select id from b_ms_diagnosa where dg_kode='$rwx[dg_kode]') md ON md.id=d.ms_diagnosa_id
WHERE $fUnit 
$waktu $fKso AND d.kasus_baru=1 AND d.primer=1 GROUP BY k.kel_umur,mp.sex";


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
					
					$mati=$rw['mati'];
					
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
			
			$tMati=$tMati+$mati;
			
			$tLk=$tL1+$tL2+$tL3+$tL4+$tL5+$tL6+$tL7+$tL8+$tL9;
			$tPr=$tP1+$tP2+$tP3+$tP4+$tP5+$tP6+$tP7+$tP8+$tP9;
			
$worksheet->write($row, $column, $no, $textBiasa2);
$worksheet->write($row, $column+1,($rwx['dg_kode']=='')? ' ' : $rwx['dg_kode'], $textBiasa1);
$worksheet->write($row, $column+2,($rwx['dg_group']=='')? ' ' : $rwx['dg_group'], $textBiasa1);
$worksheet->write($row, $column+3, ($rwx['dg_nama']=='')? ' ' : $rwx['dg_nama'], $textBiasa1);
$worksheet->write($row, $column+4, ($L1==0)? '': $L1, $textBiasa2);
$worksheet->write($row, $column+5, ($P1==0)? '': $P1, $textBiasa2);
$worksheet->write($row, $column+6, ($L2==0)? '': $L2, $textBiasa2);
$worksheet->write($row, $column+7, ($P2==0)? '': $P2, $textBiasa2);
$worksheet->write($row, $column+8, ($L3==0)? '': $L3, $textBiasa2);
$worksheet->write($row, $column+9, ($P3==0)? '': $P3, $textBiasa2);
$worksheet->write($row, $column+10,($L4==0)? '': $L4, $textBiasa2);
$worksheet->write($row, $column+11, ($P4==0)? '': $P4, $textBiasa2);
$worksheet->write($row, $column+12, ($L5==0)? '': $L5, $textBiasa2);
$worksheet->write($row, $column+13, ($P5==0)? '': $P5, $textBiasa2);
$worksheet->write($row, $column+14,  ($L6==0)? '': $L6, $textBiasa2);
$worksheet->write($row, $column+15,  ($P6==0)? '': $P6, $textBiasa2);
$worksheet->write($row, $column+16, ($L7==0)? '': $L7, $textBiasa2);
$worksheet->write($row, $column+17, ($P7==0)? '': $P7, $textBiasa2);
$worksheet->write($row, $column+18,  ($L8==0)? '': $L8, $textBiasa2);
$worksheet->write($row, $column+19, ($P8==0)? '': $P8, $textBiasa2);
$worksheet->write($row, $column+20, ($L9==0)? '': $L9, $textBiasa2);
$worksheet->write($row, $column+21, ($P9==0)? '': $P9, $textBiasa2);
$worksheet->write($row, $column+22, ($lk==0)? '': $lk, $textBiasa2);
$worksheet->write($row, $column+23, ($pr==0)? '': $pr, $textBiasa2);
$worksheet->write($row, $column+24, ($lk + $pr==0)? '': $lk + $pr, $textBiasa2);
$worksheet->write($row, $column+25, ($mati==0)? '': $mati, $textBiasa2);
	
		$no++;
	}
$row+=1;
$worksheet->write($row, $column, "Total", $textBiasa2);
$worksheet->mergeCells($row,$column,$row,$column+3);
$worksheet->write($row, $column+4, ($tL1==0)? '': $tL1, $textBiasa2);
$worksheet->write($row, $column+5, ($tP1==0)? '': $tP1, $textBiasa2);
$worksheet->write($row, $column+6, ($tL2==0)? '': $tL2, $textBiasa2);
$worksheet->write($row, $column+7, ($tP2==0)? '': $tP2, $textBiasa2);
$worksheet->write($row, $column+8, ($tL3==0)? '': $tL3, $textBiasa2);
$worksheet->write($row, $column+9, ($tP3==0)? '': $tP3, $textBiasa2);
$worksheet->write($row, $column+10, ($tL4==0)? '': $tL4, $textBiasa2);
$worksheet->write($row, $column+11, ($tP4==0)? '': $tP4, $textBiasa2);
$worksheet->write($row, $column+12, ($tL5==0)? '': $tL5, $textBiasa2);
$worksheet->write($row, $column+13, ($tP5==0)? '': $tP5, $textBiasa2);
$worksheet->write($row, $column+14, ($tL6==0)? '': $tL6, $textBiasa2);
$worksheet->write($row, $column+15, ($tP6==0)? '': $tP6, $textBiasa2);
$worksheet->write($row, $column+16, ($tL7==0)? '': $tL7, $textBiasa2);
$worksheet->write($row, $column+17, ($tP7==0)? '': $tP7, $textBiasa2);
$worksheet->write($row, $column+18, ($tL8==0)? '': $tL8, $textBiasa2);
$worksheet->write($row, $column+19, ($tP8==0)? '': $tP8, $textBiasa2);
$worksheet->write($row, $column+20, ($tL9==0)? '': $tL9, $textBiasa2);
$worksheet->write($row, $column+21, ($tP9==0)? '': $tP9, $textBiasa2);
$worksheet->write($row, $column+22, ($tLk==0)? '': $tLk, $textBiasa2);
$worksheet->write($row, $column+23, ($tPr==0)? '': $tPr, $textBiasa2);
$worksheet->write($row, $column+24, ($tLk + $tPr==0)? '': $tLk + $tPr, $textBiasa2);
$worksheet->write($row, $column+25, ($tMati==0)? '': $tMati, $textBiasa2);
	
$workbook->close();
mysql_close();
?>