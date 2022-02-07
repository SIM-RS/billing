<?php
session_start();
include("../sesi.php");
?>
<?php 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$inap=$_REQUEST['inap'];
$tipe=$_REQUEST['tipe'];
$all = $_REQUEST['all'];
$kso=$_REQUEST['kso'];
$nama=$_REQUEST['nama'];

if ($inap=="1" || $all == 'true'){
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(k.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(k.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP,mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id=$idKunj AND p.id=$idPel";
}else{
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id='$idKunj' AND p.id='$idPel'";
}
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$ksoid=$rw['kso_id'];
if ($inap=="1"){
	$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl),'%d-%m-%Y %H:%i') tgljam FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY p.id LIMIT 1";
	$rsInap=mysql_query($sql);
	if (mysql_num_rows($rsInap)>0){
		$rwInap=mysql_fetch_array($rsInap);
		$tglIn=$rwInap['tgljam'];
		$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_out,NOW()),'%d-%m-%Y %H:%i') tglP FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY tk.id DESC LIMIT 1";
		$rsInap=mysql_query($sql);
		$rwInap=mysql_fetch_array($rsInap);
		$tglOut=$rwInap['tglP'];
	}else{
		$tglIn=$rw['tgljam'];
		$sql="SELECT DATE_FORMAT(IFNULL(tgl_krs,tgl),'%d-%m-%Y %H:%i') tglP FROM b_pelayanan WHERE kunjungan_id='$idKunj' ORDER BY id DESC LIMIT 1";
		$rsInap=mysql_query($sql);
		$rwInap=mysql_fetch_array($rsInap);
		$tglOut=$rwInap['tglP'];
	}
}else{
	$tglIn=$rw['tgljam'];
	$tglOut=$rw['tglP'];
}

$sql="SELECT * FROM b_ms_kelas WHERE id=(SELECT kelas_id FROM b_pelayanan WHERE id='$idPel')";
//echo $sql."<br>";
$rs=mysql_query($sql);
$rw1=mysql_fetch_array($rs);

$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$idUser);
$rwUsr = mysql_fetch_array($qUsr);
$kls=$rw1['nama'];
//echo $kls."<br>";

if ($kls=="" || $kls==" "){
	$kls="Non Kelas";
}
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('RincianTindakanKso_'.$rw['nmKso'].'_'.$rw['nmPas'].'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('RincianTindakan');
//$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 2);//blank
$worksheet->setColumn (1, 1, 3);//blank - Unit
$worksheet->setColumn (2, 2, 4);//blank - Dokter/Kamar
$worksheet->setColumn (3, 3, 50);//Tindakan
$worksheet->setColumn (4, 4, 12);//Tgl
$worksheet->setColumn (5, 5, 8);//Qty
$worksheet->setColumn (6, 6, 10);//Biaya
$worksheet->setColumn (7, 7, 8);//Qty
$worksheet->setColumn (8, 8, 10);//Biaya
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12,'align'=>'left'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'yellow','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'yellow','pattern'=>1,'numFormat'=>'#,##0'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'yellow','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatRB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatLNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'left'));
$regularFormatCNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center'));
$regularFormatRNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right'));
$gsTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'green','pattern'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 0, $pemkabRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->writeBlank($row, 7, $sheetTitleFormat);
$worksheet->writeBlank($row, 8, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,8);
$row += 1;
$worksheet->write($row, 0, $namaRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->writeBlank($row, 7, $sheetTitleFormat);
$worksheet->writeBlank($row, 8, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,8);
$row += 1;
$worksheet->write($row, 0, $alamatRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->writeBlank($row, 7, $sheetTitleFormat);
$worksheet->writeBlank($row, 8, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,8);
$row += 1;
$worksheet->write($row, 0, "Telepon ".$tlpRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->writeBlank($row, 7, $sheetTitleFormat);
$worksheet->writeBlank($row, 8, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,8);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 2;
$worksheet->write($row, $column, "No RM", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['no_rm'], $regularFormat);
$worksheet->write($row, $column+4, "Tgl Mulai", $regularFormat);
$worksheet->write($row, $column+5, " : ".$tglIn, $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row++;
$worksheet->write($row, $column, "Nama Pasien", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['nmPas'], $regularFormat);
$worksheet->write($row, $column+4, "Tgl Selesai", $regularFormat);
$worksheet->write($row, $column+5, " : ".$tglOut, $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row++;
$worksheet->write($row, $column, "Alamat", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['alamat'], $regularFormat);
$worksheet->write($row, $column+4, "Kelas", $regularFormat);
$worksheet->write($row, $column+5, " : ".$kls, $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row++;
$worksheet->write($row, $column, "Kel. / Desa", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['nmDesa'], $regularFormat);
$worksheet->write($row, $column+4, "", $regularFormat);
$worksheet->write($row, $column+5, "", $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row++;
$worksheet->write($row, $column, "RT / RW", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['rt']." / ".$rw['rw'], $regularFormat);
$worksheet->write($row, $column+4, "Status Pasien", $regularFormat);
$worksheet->write($row, $column+5, " : ".$rw['nmKso'], $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row++;
$worksheet->write($row, $column, "Jenis Kelamin", $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->mergeCells($row,$column,$row,$column+2);
$worksheet->write($row, $column+3, " : ".$rw['sex'], $regularFormat);
$worksheet->write($row, $column+4, "Hak Kelas", $regularFormat);
$worksheet->write($row, $column+5, " : ".$rw['kelas'], $regularFormat);
$worksheet->writeBlank($row, $column+6,$regularFormat);
$worksheet->mergeCells($row,$column+5,$row,$column+6);
$row += 2;

$worksheet->write($row, $column, "Tindakan", $columnTitleFormat);
$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
$worksheet->writeBlank($row, $column+3, $columnTitleFormat);
$worksheet->mergeCells($row,$column,$row,$column+3);
$worksheet->write($row, $column+4, "Tanggal", $columnTitleFormat);
$worksheet->write($row, $column+5, "Jumlah", $columnTitleFormat);
$worksheet->write($row, $column+6, "Biaya", $columnTitleFormat);
$worksheet->write($row, $column+7, "Dijamin KSO", $columnTitleFormat);
$worksheet->write($row, $column+8, "Iur Biaya", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

$idUnitAmbulan=0;
$idUnitJenazah=0;
$sql="SELECT * FROM b_ms_reference WHERE stref=26";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitAmbulan=$rwRef["nama"];
}
$sql="SELECT * FROM b_ms_reference WHERE stref=27";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitJenazah=$rwRef["nama"];
}

if ($tipe=="2") {
	$sql="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id,mu.inap FROM b_pelayanan p
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id
WHERE p.kunjungan_id='$idKunj' AND mu.kategori<>5 AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah ORDER BY p.id";
}elseif ($tipe=="1") {
    $sql="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id,mu.inap 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND mu.kategori<>5 AND p.jenis_kunjungan=3 AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah ORDER BY p.id";
}elseif ($tipe=="0") {
	$sql="SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id,mu.inap 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND mu.kategori<>5 AND p.jenis_kunjungan<>3 AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah ORDER BY p.id";
}
//echo $sql."<br>";
$rs=mysql_query($sql);
$sByr=0;
$sBiaya=0;
$sIurBiaya=0;
$sJaminKso=0;
while ($rows=mysql_fetch_array($rs)){
	$worksheet->writeBlank($row, $column, $regularFormat);
	$worksheet->write($row, $column+1, $rows['nmUnit'], $regularFormat);
	$worksheet->writeBlank($row, $column+2, $regularFormat);
	$worksheet->writeBlank($row, $column+3, $regularFormat);
	$worksheet->mergeCells($row,$column+1,$row,$column+3);
	$worksheet->writeBlank($row, $column+4, $regularFormat);
	$worksheet->writeBlank($row, $column+5, $regularFormat);
	$worksheet->writeBlank($row, $column+6,  $regularFormat);
	$row++;

	$cHari=0;
	$bKmr=0;
	$bKmrKSO=0;
	$bKmrIur=0;
	$sTot=0;
	$sTotKSO=0;
	$sTotIur=0;
	$bTot=0;
	$bTotKSO=0;
	$bTotIur=0;
	$sSdhBayar=0;
	$sSdhBayarKSO=0;
	$sKmrIur=0;
	
	if ($rows["inap"]==1){
		$sql="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr, mKls.nama nmKls,
	DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip)) biaya, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso, 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso) biaya_kso, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien, 
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien) biaya_px,tk.bayar, 
	IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)),
	IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))) cHari 
	FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
	INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id='$idKunj' AND mk.unit_id='".$rows['idUnit']."' AND p.id='".$rows['id']."' ORDER BY tk.tgl_in";

		$lblKamar="Kamar";
		$isUnit_ICU_HCU=0;
		$UnitId_ICU_HCU1=explode(",",$UnitId_ICU_HCU);
		for ($j=0;$j<count($UnitId_ICU_HCU1);$j++){
			if ($rows['idUnit']==$UnitId_ICU_HCU1[$j]){
				$lblKamar="Jasa RS & AHP Dasar";
				$isUnit_ICU_HCU=1;
			}
		}
		$kamarIdHCU1=explode(",",$kamarIdHCU);
		$rs1=mysql_query($sql);
		while ($rw1=mysql_fetch_array($rs1)){
			/*if ($rows['idUnit']==48 || $rows['idUnit']==112 || $rows['parent_id']==94){
				$lblKamar="Jasa RS & AHP Dasar";
			}*/
			
		//==============tambahan kamar hcu============
			if ($isUnit_ICU_HCU==0){
				$lblKamar="Kamar";
				for ($j=0;$j<count($kamarIdHCU1);$j++){
					if ($rw1['idKmr']==$kamarIdHCU1[$j]){
						$lblKamar="Jasa RS & AHP Dasar";
					}
				}
			}
		//==============tambahan kamar hcu============
			$bKmr+=$rw1['biaya'];
			$bKmrKSO+=$rw1['biaya_kso'];
			$sKmrIur=$rw1['biaya_px'];
			/*if ($ksoid==1){
				$sIurBiaya+=$rw1['biaya'];
				$bKmrIur+=$rw1['biaya'];
				$sKmrIur=$rw1['biaya'];
			}else{*/
				$sJaminKso+=$rw1['biaya_kso'];
				$sIurBiaya+=$sKmrIur;
				$bKmrIur+=$sKmrIur;
				/*if ($rw1['biaya']>$rw1['biaya_kso']){
					$sIurBiaya+=$rw1['biaya']-$rw1['biaya_kso'];
					$bKmrIur+=$rw1['biaya']-$rw1['biaya_kso'];
					$sKmrIur=$rw1['biaya']-$rw1['biaya_kso'];
				}else{
					$sKmrIur=0;
				}*/
			//}
			//echo $sJaminKso."<br>";
			$sByr+=$rw1['bayar'];
			$sSdhBayar+=$rw1['bayar'];
			$sSdhBayarKSO+=$rw1['bayar_kso'];
	
	
			$worksheet->writeBlank($row, $column, $regularFormat);
			$worksheet->writeBlank($row, $column+1, $regularFormat);
			$worksheet->writeBlank($row, $column+2, $regularFormat);
			$worksheet->write($row, $column+3, $lblKamar, $regularFormat);
			$worksheet->write($row, $column+4, $rw1['tgl_in'], $regularFormatC);
			$worksheet->write($row, $column+5, $rw1['cHari'], $regularFormatC);
			$worksheet->write($row, $column+6, $rw1['biaya'], $regularFormatR);
			$worksheet->write($row, $column+7, $rw1['biaya_kso'], $regularFormatR);
			$worksheet->write($row, $column+8, $sKmrIur, $regularFormatR);
			$row++;
		}
	}else{
		$sqlCekKamar="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id=".$rows['id'];
		$rsCekKamar=mysql_query($sqlCekKamar);
		if (mysql_num_rows($rsCekKamar)>0){
			$sqlDelKamar="DELETE FROM b_tindakan_kamar WHERE pelayanan_id=".$rows['id'];
			$rsDelKamar=mysql_query($sqlDelKamar);
		}
	}
	
	$sql="SELECT user_id,IFNULL(b_ms_pegawai.nama,'-') konsul FROM b_tindakan LEFT JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id WHERE b_tindakan.pelayanan_id='".$rows['id']."' GROUP BY b_tindakan.user_id";
	$rs1=mysql_query($sql);
	while ($rw1=mysql_fetch_array($rs1)){
		$worksheet->writeBlank($row, $column, $regularFormat);
		$worksheet->writeBlank($row, $column+1, $regularFormat);
		$worksheet->write($row, $column+2, $rw1['konsul'], $regularFormat);
		$worksheet->writeBlank($row, $column+3, $regularFormat);
		$worksheet->mergeCells($row,$column+2,$row,$column+3);
		$worksheet->writeBlank($row, $column+4, $regularFormat);
		$worksheet->writeBlank($row, $column+5, $regularFormat);
		$worksheet->writeBlank($row, $column+6,  $regularFormat);
		$worksheet->writeBlank($row, $column+7, $regularFormat);
		$worksheet->writeBlank($row, $column+8,  $regularFormat);
		$row++;
		
		/*if ($ksoid==1) {
				$sql="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM(t.biaya*t.qty) AS biaya, SUM(t.biaya*t.qty) AS iurbiaya,0 AS biaya_kso,SUM(t.bayar) bayar,SUM(t.qty) cTind 
FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt 
ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id 
WHERE t.pelayanan_id='".$rows['id']."' AND user_id='".$rw1['user_id']."' GROUP BY mt.nama ORDER BY t.id";
		}else {*/
				$sql="SELECT t.id,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind, SUM((t.biaya)*t.qty) AS biaya,SUM(t.biaya_kso*t.qty) AS biaya_kso,SUM(t.biaya_pasien*t.qty) AS iurbiaya,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayarKSO,SUM(t.qty) cTind FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
WHERE t.kunjungan_id=".$idKunj." AND t.pelayanan_id=".$rows['id']." AND user_id='".$rw1['user_id']."' GROUP BY mt.nama ORDER BY t.id";
		//}
		$rs2=mysql_query($sql);
		while ($rw2=mysql_fetch_array($rs2)){
			$sqlPegAnastesi="SELECT mp.nip,mp.nama FROM b_tindakan_dokter_anastesi bta INNER JOIN b_ms_pegawai mp ON bta.dokter_id=mp.id WHERE bta.tindakan_id=".$rw2["id"];
			$rsPegAnastesi=mysql_query($sqlPegAnastesi);
			$dokAnastesi="";
			while ($rwPegAnastesi=mysql_fetch_array($rsPegAnastesi)){
				$dokAnastesi .=$rwPegAnastesi["nama"].", ";
			}
			if ($dokAnastesi!="") $dokAnastesi=" - (".substr($dokAnastesi,0,strlen($dokAnastesi)-2).")"; 

			$sTot+=$rw2['biaya'];
			$sTotKSO+=$rw2['biaya_kso'];
			$sTotIur+=$rw2['iurbiaya'];
			$sByr+=$rw2['bayar'];
			$sSdhBayar+=$rw2['bayar'];
			$sSdhBayarKSO+=$rw2['bayarKSO'];
			//if ($ksoid==1){
			//	$sIurBiaya+=$rw2['iurbiaya'];
			//}else{
				$sJaminKso+=$rw2['biaya_kso'];
				$sIurBiaya+=$rw2['iurbiaya'];
			//}
			//echo $sJaminKso."<br>";

			$worksheet->writeBlank($row, $column, $regularFormat);
			$worksheet->writeBlank($row, $column+1, $regularFormat);
			$worksheet->writeBlank($row, $column+2, $regularFormat);
			$worksheet->write($row, $column+3, $rw2['nmTind'].$dokAnastesi, $regularFormat);
			$worksheet->write($row, $column+4, $rw2['tgl'], $regularFormatC);
			$worksheet->write($row, $column+5, $rw2['cTind'], $regularFormatC);
			$worksheet->write($row, $column+6, $rw2['biaya'], $regularFormatR);
			$worksheet->write($row, $column+7, $rw2['biaya_kso'], $regularFormatR);
			$worksheet->write($row, $column+8, $rw2['iurbiaya'], $regularFormatR);
			$row++;
		}
	}
	
	$bTot+=$sTot;
	$bTot+=$bKmr;
	$sBiaya+=$bTot;
	$bTotKSO+=$sTotKSO;
	$bTotKSO+=$bKmrKSO;
	$bTotIur+=$sTotIur;
	$bTotIur+=$bKmrIur;
	
	$worksheet->writeBlank($row, $column, $regularFormat);
	$worksheet->writeBlank($row, $column+1, $regularFormat);
	$worksheet->writeBlank($row, $column+2, $regularFormat);
	$worksheet->writeBlank($row, $column+3, $regularFormat);
	$worksheet->write($row, $column+4, "Sub Total ", $regularFormatRNoWrapB);
	$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, $bTot, $regularFormatRB);
	$worksheet->write($row, $column+7, $bTotKSO, $regularFormatRB);
	$worksheet->write($row, $column+8, $bTotIur, $regularFormatRB);
	$row++;
	
	$worksheet->writeBlank($row, $column, $regularFormat);
	$worksheet->writeBlank($row, $column+1, $regularFormat);
	$worksheet->writeBlank($row, $column+2, $regularFormat);
	$worksheet->writeBlank($row, $column+3, $regularFormat);
	$worksheet->write($row, $column+4, "Bayar ", $regularFormatRNoWrapB);
	$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, $sSdhBayar, $regularFormatRB);
	$worksheet->write($row, $column+7, $sSdhBayarKSO, $regularFormatRB);
	$worksheet->write($row, $column+8, $sSdhBayar, $regularFormatRB);
	$row++;
}

//if ($ksoid==1){
	//$selisih=$sBiaya-$sJaminKso-$sByr-$keringanan-$titipan;
	$selisih=$sIurBiaya-$sByr-$keringanan-$titipan;
	if ($selisih<0) $selisih=0;
//}else{
//	$selisih=$sIurBiaya-$sByr;
//}

$worksheet->writeBlank($row, $column, $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->writeBlank($row, $column+3, $regularFormat);
$worksheet->write($row, $column+4, "Total Biaya ", $regularFormatRNoWrapB);
$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
$worksheet->mergeCells($row,$column+4,$row,$column+5);
$worksheet->write($row, $column+6, $sBiaya, $regularFormatRB);
$worksheet->write($row, $column+7, $sJaminKso, $regularFormatRB);
$worksheet->write($row, $column+8, $sIurBiaya, $regularFormatRB);
$row++;

$worksheet->writeBlank($row, $column, $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->writeBlank($row, $column+3, $regularFormat);
$worksheet->write($row, $column+4, "Dijamin KSO ", $regularFormatRNoWrapB);
$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
$worksheet->mergeCells($row,$column+4,$row,$column+5);
$worksheet->write($row, $column+6, $sJaminKso, $regularFormatRB);
/*$worksheet->write($row, $column+7, $sJaminKso, $regularFormatRB);
$worksheet->write($row, $column+8, $sJaminKso, $regularFormatRB);*/
$row++;

if ($keringanan>0) {
	$worksheet->writeBlank($row, $column, $regularFormat);
	$worksheet->writeBlank($row, $column+1, $regularFormat);
	$worksheet->writeBlank($row, $column+2, $regularFormat);
	$worksheet->writeBlank($row, $column+3, $regularFormat);
	$worksheet->write($row, $column+4, "Titipan ", $regularFormatRNoWrapB);
	$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, $titipan, $regularFormatRB);
	$row++;
}

if ($keringanan>0) {
	$worksheet->writeBlank($row, $column, $regularFormat);
	$worksheet->writeBlank($row, $column+1, $regularFormat);
	$worksheet->writeBlank($row, $column+2, $regularFormat);
	$worksheet->writeBlank($row, $column+3, $regularFormat);
	$worksheet->write($row, $column+4, "Keringanan ", $regularFormatRNoWrapB);
	$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
	$worksheet->mergeCells($row,$column+4,$row,$column+5);
	$worksheet->write($row, $column+6, $keringanan, $regularFormatRB);
	$row++;
}

$worksheet->writeBlank($row, $column, $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->writeBlank($row, $column+3, $regularFormat);
$worksheet->write($row, $column+4, "Total Bayar ", $regularFormatRNoWrapB);
$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
$worksheet->mergeCells($row,$column+4,$row,$column+5);
$worksheet->write($row, $column+6, $sByr, $regularFormatRB);
$row++;

$worksheet->writeBlank($row, $column, $regularFormat);
$worksheet->writeBlank($row, $column+1, $regularFormat);
$worksheet->writeBlank($row, $column+2, $regularFormat);
$worksheet->writeBlank($row, $column+3, $regularFormat);
$worksheet->write($row, $column+4, "Kurang ", $regularFormatRNoWrapB);
$worksheet->writeBlank($row, $column+5, $regularFormatRNoWrapB);
$worksheet->mergeCells($row,$column+4,$row,$column+5);
$worksheet->write($row, $column+6, $selisih, $regularFormatRB);

$workbook->close();
mysql_free_result($rs);
mysql_close($konek);
?>