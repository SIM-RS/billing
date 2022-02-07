<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
require_once('../../Excell/Writer.php');
$date_now = gmdate('d-m-Y', mktime(date('H') + 7));
$jam = date("G:i");

$arrBln = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
$statusPcr = $_REQUEST['statusPcrPasien'];
$statusPasinSql = "";

if($statusPcr == 1){
    $statusPasinSql = " AND (hp.status_cek_pcr != '-' AND hp.status_cek_pcr is not null) AND kategori = 2";
}else{
    $statusPasinSql = " AND (hp.status_cek_pcr = '-' or hp.status_cek_pcr is null) AND kategori = 2";
}
$waktu = $_POST['cmbWaktu'];
$cetak = "";
if ($waktu == 'Harian') {
    $tglAwal = explode('-', $_REQUEST['tglAwal2']);
    $tglAwal2 = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
    $waktu = " and pl.tgl = '$tglAwal2' ";
    $Periode = "Tanggal " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2];
    $cetak = $Periode;
} else if ($waktu == 'Bulanan') {
    $bln = $_POST['cmbBln'];
    $thn = $_POST['cmbThn'];
    $waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
    $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    $tanggalAwal = '01/'.$bln.'/'.$thn;
    if($bln == "01" || $bln == "03" || $bln == "05" || $bln == "07" || $bln == "08" || $bln == "10" || $bln == "12"){
        $tanggalAkhir = "31/".$bln.'/'.$thn;
    }else if($bln == "03" || $bln == "04" || $bln == "06" || $bln == "09" || $bln == "11"){
        $tanggalAkhir = "30/".$bln.'/'.$thn;
    }else{
        if($thn % 100 == 0 && $thn % 400 == 0 && $thn % 4 == 0){
            $tanggalAkhir = "29/".$bln.'/'.$thn;
        }else{
            $tanggalAkhir = "28/".$bln.'/'.$thn;
        }
    }
    $cetak = $Periode;

} else {
    $tglAwal = explode('-', $_REQUEST['tglAwal']);
    $tglAwal2 = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
    //echo $arrBln[$tglAwal[1]];
    $tglAkhir = explode('-', $_REQUEST['tglAkhir']);
    $tglAkhir2 = $tglAkhir[2] . '-' . $tglAkhir[1] . '-' . $tglAkhir[0];
    $waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";

    $Periode = "Periode : " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2] . ' s/d ' . $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $tanggalAwal = $tglAwal[0] . ' ' . $arrBln[$tglAwal[1]] . ' ' . $tglAwal[2];
    $tanggalAkhir = $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $cetak = 'Tanggal ' . $tanggalAwal . ' s/d ' . $tanggalAkhir;
}

if ($_REQUEST['JnsLayanan'] == '0') {
    $Jnslay = " ";
} else {
    $Jnslay = "  WHERE id = '" . $_REQUEST['JnsLayanan'] . "' ";
}


$sqlUnit1 = "SELECT id,nama FROM b_ms_unit $Jnslay ";
$rsUnit1 = mysql_query($sqlUnit1);
$rwUnit1 = mysql_fetch_array($rsUnit1);
if ($_REQUEST['TmpLayanan'] != '0') {

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '" . $_REQUEST['TmpLayanan'] . "'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);

    if ($_REQUEST['JnsLayanan'] == '0') {
        $fUnit = " ";
    } else {
        $fUnit = "pl.unit_id=" . $_REQUEST['TmpLayanan'] . " ";
    }
} else {

    if ($_REQUEST['JnsLayanan'] == '0') {
        $fUnit = " ";
    } else {
        $fUnit = " AND u.parent_id=" . $_REQUEST['JnsLayanan'] . " ";
    }
}
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '" . $_REQUEST['user_act'] . "'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);

$stsPas = $_REQUEST['StatusPas'];
if ($stsPas != 0) {
    $fKso = " AND pl.kso_id = $stsPas ";
}
if($_POST['export']=='excel'){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}

function cnvtTanggal($data){
    $tanggal = explode('-',$data);
    return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
}

function wilayah($id){
    $sql = "SELECT nama FROM b_ms_wilayah WHERE id = {$id}";
    $query = mysql_fetch_assoc(mysql_query($sql));
    return $query['nama'];
}

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Laporan Lab Antigen.xls');
$worksheet = &$workbook->addWorksheet('Lab Pcr');
$worksheet->setLandscape();
$columnWidth = 10;

$worksheet->setColumn(0, 0, 35);
$worksheet->setColumn(0, 1, 35);
$worksheet->setColumn(0, 3, 35);

$worksheet->setColumn(0, 2, 20);
$worksheet->setColumn(0, 6, 20);
$worksheet->setColumn(0, 4, 20);
$worksheet->setColumn(0, 5, 10);

$worksheet->setColumn(0, 8, 20);
$worksheet->setColumn(0, 9, 20);
$worksheet->setColumn(0, 10, 20);
$worksheet->setColumn(0, 11, 20);
$worksheet->setColumn(0, 12, 20);
$worksheet->setColumn(0, 13, 20);

$worksheet->setColumn(0, 14, 26);
$worksheet->setColumn(0, 15, 20);
$worksheet->setColumn(0, 16, 20);
$worksheet->setColumn(0, 17, 20);
$worksheet->setColumn(0, 18, 20);
$worksheet->setColumn(0, 19, 20);
$worksheet->setColumn(0, 20, 20);
$worksheet->setColumn(0, 21, 20);
$worksheet->setColumn(0, 22, 26);
$worksheet->setColumn(0, 23, 26);
$worksheet->setColumn(0, 24, 20);
$worksheet->setColumn(0, 25, 30);
$worksheet->setColumn(0, 26, 20);






$sheetTitleFormat = &$workbook->addFormat(array('size' => 14, 'align' => 'center'));
$columnTitleFormat = &$workbook->addFormat(array('bold' => 1,'size' => 9, 'vAlign' => 'vcenter','align'=>'center','fontFamily'=>'Calibri','border'=>1));
$sTotFormatC = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'center', 'fgcolor' => 'grey', 'pattern' => 1));
$sTotFormatR = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'right', 'fgcolor' => 'grey', 'pattern' => 1));
$sTotFormatL = &$workbook->addFormat(array('bold' => 1, 'size' => 10, 'align' => 'left', 'fgcolor' => 'grey', 'pattern' => 1));
$regularFormat = &$workbook->addFormat(array('size' => 9, 'align' => 'left','fontFamily'=>'Calibri','border'=>1,'vAlign' => 'vcenter'));
$regularFormatC = &$workbook->addFormat(array('size' => 9, 'align' => 'center','border'=>1,'fontFamily'=>'Calibri','vAlign' => 'vcenter'));
$regularFormatCB = &$workbook->addFormat(array('size' => 9, 'align' => 'center','fontFamily'=>'Calibri','vAlign' => 'vcenter'));
$regularFormatR = &$workbook->addFormat(array('size' => 9, 'align' => 'center', 'textWrap' => 1,'border'=>1));
$regularFormatL = &$workbook->addFormat(array('size' => 9, 'align' => 'left',));

$regularFormatRF = &$workbook->addFormat(array('size' => 9, 'align' => 'right', 'textWrap' => 1, 'numFormat' => '#,##0'));
$column = 0;
$row    = 0;
$worksheet->write($row, 23, "Laporan Lab PCR RS Prima Husada Cipta Medan", $regularFormatL);
$worksheet->mergeCells($row, 23, $row, 27);


$row++;
$worksheet->mergeCells($row, 23, $row, 27);
$worksheet->write($row, 23, $cetak, $regularFormatL);
$row++;

$row++;
$worksheet->write($row, $column, "NO URUT (Reg Lab)", $columnTitleFormat);
$worksheet->write($row + 1, $column, "", $columnTitleFormat);
$worksheet->write($row + 2, $column, "", $columnTitleFormat);
$worksheet->write($row + 3, $column, "", $columnTitleFormat);

for($i = 0; $i < 27; $i++){
    $worksheet->write($row + 1, $column + $i, "", $columnTitleFormat);
    $worksheet->write($row + 2, $column + $i, "", $columnTitleFormat);
    $worksheet->write($row + 3, $column + $i, "", $columnTitleFormat);
}

$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "NAMA LENGKAP PASIEN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "WNI/WNA", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "NIK / NO.IDENTITAS (KTP/KK/PASPOR)", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 2, $column);

$column++;
$worksheet->write($row, $column, "NO REKAM MEDIS", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "TANGGAL LAHIR", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "UMUR (TAHUN)", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "JENIS KELAMIN (P/L)", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "ALAMAT TERDUGA/PASIEN COVID-19 (KTP / DOMISILI)", $columnTitleFormat);
$worksheet->write($row, $column+1, "", $columnTitleFormat);
$worksheet->write($row, $column+2, "", $columnTitleFormat);
$worksheet->write($row, $column+3, "", $columnTitleFormat);
$worksheet->write($row, $column+4, "", $columnTitleFormat);
$worksheet->write($row, $column+5, "", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 2, $column + 5);

$column+=6;
$worksheet->write($row, $column, "PETUGAS KESEHATAN (NAKES)", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "STATUS KEHAMILAN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "NO.HP PASIEN/KELUARGA", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "NO.HP DOKTER PENGIRIM", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "ASAL RS RUJUKAN COVID", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "ALASAN PEMERIKSAAN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "KRITERIA PASIEN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "JENIS SPESIMEN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "TANGGAL PENGAMBILAN SPESIMEN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "TANGGAL PEMERIKSAAN SPESIMEN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);

$column++;
$worksheet->write($row, $column, "PEMERIKSAAN KE", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);


$column++;
$worksheet->write($row, $column, "HASIL LAB(Pemeriksaan TCM COVID-19)", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);


$column++;
$worksheet->write($row, $column, "KETERANGAN", $columnTitleFormat);
$worksheet->mergeCells($row, $column, $row + 3, $column);


$row+=3;
$column = 0;

$worksheet->write($row, $column + 8, "KTP/Domisili", $columnTitleFormat);
$worksheet->write($row, $column + 9, "Provinsi", $columnTitleFormat);
$worksheet->write($row, $column + 10, "Kabupaten/Kota", $columnTitleFormat);
$worksheet->write($row, $column + 11, "Kecamatan", $columnTitleFormat);
$worksheet->write($row, $column + 12, "Kelurahan", $columnTitleFormat);
$worksheet->write($row, $column + 13, "Alamat Lengkap", $columnTitleFormat);

$row++;
$column = 0;
for($i = 0; $i < 27; $i++){
    $no = $i + 1;
    $worksheet->write($row, $column + $i, "($no)", $regularFormatC);
}

$row++;

    $sqlPas = "SELECT
                    hp.id AS id_hasil,
                    p.id AS id_pasien,
                    p.*,
                    k.umur_thn,
                    hp.*,
                    pl.kso_id
                FROM
                    b_hasil_pcr hp
                    INNER JOIN b_ms_pasien p ON p.id = hp.id_pasien
                    LEFT JOIN b_kunjungan k ON k.id = hp.id_kunjungan
                    LEFT JOIN b_pelayanan pl ON pl.id = hp.id_pelayanan
                    LEFT JOIN b_ms_kso_pasien kp ON kp.pasien_id = hp.id_pasien 
                WHERE
            $fUnit $waktu $statusPasinSql 
                ORDER BY p.nama asc";
        
        $rsPas = mysql_query($sqlPas);
        $column = 0;
        while($rwPas = mysql_fetch_array($rsPas))
        {   
            $count = mysql_num_rows(mysql_query("SELECT id_pasien FROM b_hasil_pcr WHERE id_pasien = {$rwPas['id_pasien']}"));

                $worksheet->write($row, $column+0, $rwPas['no_registrasi_lab'], $regularFormatC);
                $worksheet->write($row, $column+1, $rwPas['nama'], $regularFormat);
                $worksheet->write($row, $column+2, $rwPas['id_kw'] == 1 ? 'WNI' : 'WNA', $regularFormatC);
                $worksheet->write($row, $column+3, $rwPas['no_ktp'], $regularFormatC);
                $worksheet->write($row, $column+4, $rwPas['no_rm'], $regularFormatC);
                $worksheet->write($row, $column+5, cnvtTanggal($rwPas['tgl_lahir']), $regularFormatC);
                $worksheet->write($row, $column+6, $rwPas['umur_thn'], $regularFormatC);
                $worksheet->write($row, $column+7, $rwPas['sex'], $regularFormatC);
                $worksheet->write($row, $column+8, $rwPas['ktp_domisili'], $regularFormatC);
                $worksheet->write($row, $column+9, wilayah($rwPas['prop_id']), $regularFormatC);
                $worksheet->write($row, $column+10, wilayah($rwPas['kab_id']), $regularFormatC);
                $worksheet->write($row, $column+11, wilayah($rwPas['kec_id']), $regularFormatC);
                $worksheet->write($row, $column+12, wilayah($rwPas['desa_id']), $regularFormatC);
                $worksheet->write($row, $column+13, $rwPas['alamat'], $regularFormatR);
                $worksheet->write($row, $column+14, $rwPas['petugas_kesehatan'], $regularFormatC);
                $worksheet->write($row, $column+15, $rwPas['status_hamil'], $regularFormatC);
                $worksheet->write($row, $column+16, $rwPas['telp'], $regularFormatC);
                $worksheet->write($row, $column+17, $rwPas['dokter_pengirim'].' ('.$rwPas['no_hp_dokter_pengirim'].')', $regularFormatC);
                $worksheet->write($row, $column+18, $rwPas['kso_id'] == 63 ? "KLINIK PRATAMA KRAKATAU" : "RS PHCM", $regularFormatC);
                $worksheet->write($row, $column+19, $rwPas['alasan_pemeriksaan'], $regularFormatC);
                $worksheet->write($row, $column+20, $rwPas['kriteria_pasien'], $regularFormatC);
                $worksheet->write($row, $column+21, $rwPas['jenis_spesimen'], $regularFormatC);
                $worksheet->write($row, $column+22,cnvtTanggal($rwPas['tanggal_swab']), $regularFormatC);
                $worksheet->write($row, $column+23, cnvtTanggal($rwPas['tanggal_pemeriksaan']), $regularFormatC);
                $worksheet->write($row, $column+24, $count, $regularFormatC);
                if($rwPas['status_cek_pcr'] == '' or $rwPas['status_cek_pcr'] == '-'){
                    $worksheet->write($row, $column+25, '', $regularFormatC);   
                }else{
                    $worksheet->write($row, $column+25, ($rwPas['status_cek_pcr'] == 'POSITIF SARS-COV-2' ? "POSITIF" : "NEGATIF"), $regularFormatC);
                }
                $worksheet->write($row, $column+26, $rwPas['keterangan'], $regularFormatR);
                $row++;
        }
$row+=7;
$worksheet->write($row,25,"Medan," . date('d M Y'),$regularFormatCB);
$row++;
$worksheet->write($row,25,"diketahui oleh :",$regularFormatCB);
$row+=4;
$worksheet->write($row,25,"dr Rizki",$regularFormatCB);

$workbook->close();
?>