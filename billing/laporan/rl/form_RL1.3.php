<?php
session_start();
include("../../sesi.php");
?>
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = " AND DATE(b_pasien_keluar.tgl_act) = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = " AND MONTH(b_pasien_keluar.tgl_act) = '$bln' AND YEAR(b_pasien_keluar.tgl_act) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND DATE(b_pasien_keluar.tgl_act) BETWEEN '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }

    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
	
	$jnsLay = $_REQUEST['cmbJenisLayanan'];
	$tmpLay = $_REQUEST['cmbTempatLayanan'];
	
	$qJns = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id='".$jnsLay."'");
	$wJns = mysql_fetch_array($qJns);
	
	$qTmp = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id='".$tmpLay."'");
	$wTmp = mysql_fetch_array($qTmp);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FASILITAS TEMPAT TIDUR RAWAT INAP</title>
</head>
 <body>
<table width="70%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma;">
  <tr>
    <td width="10%" height="20"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="50%" height="20"><p>Formulir RL 1.3</p>
    <p>FASILITAS TEMPAT TIDUR RAWAT INAP</p></td>
    <td width="40%" height="20"><table width="100%" border="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td>&nbsp;</td>
        <td colspan="3"><i>Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td>&nbsp;</td>
        <td colspan="3"><i>Kementrian Kesehatan RI</i></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kode RS</td>
    <td>: <?php echo $kodeRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama RS</td>
    <td>: <?php echo $namaRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;<?php echo $Periode;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">RL 1.3 Fasilitas Tempat Tidur Rawat Inap </td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="1" style="border-collapse:collapse;">
	  <tr align="center">
        <td width="5%" rowspan="2">NO</td>
        <td width="40%" rowspan="2">JENIS PELAYANAN</td>
        <td >JUMLAH</td>
        <td colspan="6">PERINCIAN TEMPAT TIDUR PER-KELAS</td>
      </tr>
	  <tr align="center">
        <td width="5%">TT</td>
        <td width="5%">VVIP</td>
        <td width="5%">VIP</td>
        <td width="5%">I</td>
        <td width="5%">II</td>
        <td width="5%">III</td>
        <td width="5%">Kelas Khusus</td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
      </tr>
	  
<?php

//cmbTmpInap
//cmbJnsInap
	if($_REQUEST['cmbJnsInap']==0){
		$txtJenis = "Rawat Jalan :";
		if($_REQUEST['cmbTmpInap']==0){
			$txtTempat = "Semua";
			$fUnit = " AND b_pelayanan.jenis_kunjungan<>3 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " AND b_pelayanan.unit_id = '".$_REQUEST['cmbTmpInap']."'";
		}
	}
	else{
		$txtJenis = "Rawat Inap :";
		if($_REQUEST['cmbTmpInap']==0){
			$txtTempat = "Semua";
			$fUnit = " AND b_ms_unit.parent_id=27 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " AND b_ms_unit.id = '".$_REQUEST['cmbTmpInap']."'";
		}
	}
	/*						if($tmpLay==0){
							$fUnit = "b_ms_unit.parent_id = '".$jnsLay."'";
						}else{
							$fUnit = "b_ms_unit.id = '".$tmpLay."'";
						}
						/*$qUn = "SELECT * FROM b_ms_unit WHERE $fUnit AND aktif=1 ORDER BY nama";echo $qUn;
						$qUn2 = mysql_query($qUn);
						while($wUn = mysql_fetch_array($qUn2))
						{*/
						
		$sqlKmr = "SELECT 
  b_ms_unit.nama AS nm_unit,
  SUM(b_ms_kamar.jumlah_tt) AS jmltt,
  b_ms_kelas.nama AS nm_kelas,
  b_ms_kamar_tarip.unit_id AS id_k,
  SUM(b_ms_kelas.id)
FROM
  b_ms_kamar 
  INNER JOIN b_ms_kamar_tarip
    ON b_ms_kamar_tarip.kamar_id=b_ms_kamar.id
  LEFT JOIN b_ms_kelas
    ON b_ms_kelas.id=b_ms_kamar_tarip.kelas_id
  LEFT JOIN b_ms_unit 
    ON b_ms_kamar_tarip.unit_id = b_ms_unit.id
  WHERE b_ms_unit.aktif=1 $fUnit
    GROUP BY b_ms_kamar.unit_id
    ORDER BY b_ms_kamar.kode;"; //echo $sqlKmr;
		$rsKmr = mysql_query($sqlKmr);
		$no = 1;
		$jml=0;
    $jmlutm=0;
    $jmlvip=0;
    $jml1=0;
    $jml2=0;
    $jml3=0;
    $jmlicu=0;
		while($rwKmr = mysql_fetch_array($rsKmr))
		{//b_ms_kamar.unit_id='".$wUn['id']."' AND 
?>
      <tr>
        <td align="center"><?php echo $no; ?></td>
        <td><?php echo $rwKmr['nm_unit'];?></td>
        <td align="center"><?php echo $rwKmr['jmltt'];?></td>
		
		<?php $sqlJKK = "SELECT 
  SUM(mk1.jumlah_tt) jmltts
  , mk.nama nama_mk
FROM
  b_ms_kelas mk 
  INNER JOIN b_ms_kamar_tarip mkt 
    ON mk.id = mkt.kelas_id
  LEFT JOIN b_ms_kamar mk1
    ON mk1.id = mkt.kamar_id 
WHERE mkt.unit_id = '".$rwKmr['id_k']."'
GROUP BY mk.id"; /*echo $sqlKmr."<br>";*/ //echo $sqlJKK;
		$qJKK = mysql_query($sqlJKK);
		$kelas=array(
			'UTAMA'=>0,
			'VIP'=>0,
			'1'=>0,
			'2'=>0,
			'3'=>0,
			'ICU'=>0
		);
		
		while($ambilJKK=mysql_fetch_array($qJKK))
		{
		 $jml+=$rwKmr['jmltt'];
		$kelas[$ambilJKK['nama_mk']]=$ambilJKK['jmltts'];
		 $jmlutm+=$kelas['UTAMA'];
		 $jmlvip+=$kelas['VIP'];
		 $jml1+=$kelas['1'];
		 $jml2+=$kelas['2'];
		 $jml3+=$kelas['3'];
		 $jmlicu+=$kelas['ICU'];
		}
		?>
        <td align="center"><?=$kelas['UTAMA'];?></td>
        <td align="center"><?=$kelas['VIP'];?></td>
        <td align="center"><?=$kelas['1'];?></td>
        <td align="center"><?=$kelas['2'];?></td>
        <td align="center"><?=$kelas['3'];?></td>
        <td align="center"><?=$kelas['ICU'];?></td>
      </tr>
      <?php
  		 $no++;
		 //}
		 }
	  ?>
	  <tr style="text-align:center;">
        <td colspan="2"> TOTAL </td>
        <td bgcolor="#999999"><?=$jml;?></td>
        <td bgcolor="#999999"><?=$jmlutm;?></td>
        <td bgcolor="#999999"><?=$jmlvip;?></td>
        <td bgcolor="#999999"><?=$jml1;?></td>
        <td bgcolor="#999999"><?=$jml2;?></td>
        <td bgcolor="#999999"><?=$jml3;?></td>
        <td bgcolor="#999999"><?=$jmlicu;?></td>
      </tr>
	  <!--tr>
        <td align="center">88</td>
        <td>Perinatologi/Bayi</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr-->
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr id="trTombol">
                <td class="noline" align="center" colspan="3">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
					<input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
    </tr>
</table>

</body>
        <script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';           
           
            if(tombol.style.visibility=='collapse'){
               
                /*try{
			mulaiPrint();
		}
		catch(e){*/
			window.print();
			//window.close();
		//}
                    
            }
        }
        </script>
</body>
</html>
