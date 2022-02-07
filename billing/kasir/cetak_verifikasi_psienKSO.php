<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Setoran Kasir</title>
</head>

<body>
<?php
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	$filter=$_REQUEST["filter"];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tgl']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Cetak PENDAPATAN NON TUNAI <br />
        Tanggal <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]; ?></b></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="18%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Penyetor</td>
				<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Setor</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Jam</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">No.<br />Kwitansi</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="24%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Nilai</td>
			</tr>
			<?php
				if ($filter!=""){
					$filter=explode("|",$filter);
					$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
				}
				/*$sqlPas="SELECT 
				DATE_FORMAT(b_bayar.disetor_tgl,'%d-%m-%Y') AS tgl,
				DATE_FORMAT(b_bayar.disetor_tgl,'%H:%i') AS jam,
				b_bayar.no_kwitansi AS kwi,
				b_ms_pasien.no_rm,
				b_ms_pasien.nama as pasien,
				b_bayar.nilai,
				b_ms_pegawai.nama as penyetor
				FROM
				b_bayar
				INNER JOIN b_kunjungan ON b_kunjungan.id = b_bayar.kunjungan_id
				INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
				INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.disetor_oleh
				WHERE DATE(b_bayar.disetor_tgl)='".$tglAwal2."' AND b_bayar.disetor_oleh='".$_REQUEST['kasir']."' AND b_bayar.disetor=1 {$filter}";*/
				
				$sqlPas="SELECT id,pasien_id,DATE_FORMAT(disetor_tgl,'%d-%m-%Y') AS tgl,
				DATE_FORMAT(disetor_tgl,'%H:%i') AS jam,
				  DATE_FORMAT(tgl_pulang,'%d-%m-%Y') AS tgl_p,
				  no_rm,nama AS pasien,
				  unit,kso_id,
				  kso,
				  SUM(biaya) biayaRS,
				  SUM(biaya_kso) biayaKSO,
				  SUM(biaya_pasien) biayaPasien,
				  SUM(retribusi) retribusi,
				  SUM(bayar) bayar,
				  SUM(bayar_kso) bayarKso,
				  SUM(bayar_pasien) bayarPasien,
				  namapeg,
				  slip_ke
				FROM
				(SELECT ttind.* FROM
				(SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit,
				  t.id idTind,
				  t.kso_id,
				  kso.nama AS kso,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  0 retribusi,
				  t.bayar,
				  t.bayar_kso,
				  /*t.bayar_pasien*/
				  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
				  g.nama namapeg,
				  k.slip_ke
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN b_tindakan t
					ON p.id = t.pelayanan_id
				  INNER JOIN b_ms_kso kso
					ON t.kso_id = kso.id
				  LEFT JOIN b_bayar_tindakan bt 
					ON t.id = bt.tindakan_id
				  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
				WHERE k.pulang = 1 
				AND DATE(k.disetor_tgl)='".$tglAwal2."' AND k.disetor_oleh='".$_REQUEST['kasir']."' AND k.disetor=1
				GROUP BY t.id) AS ttind
				WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
				UNION
				SELECT tk.* FROM 
					(SELECT
					  k.id,
					  k.pasien_id,
					  k.disetor_tgl,
					  k.tgl_pulang,
					  mp.no_rm,
					  mp.nama,
					  mu.nama        AS unit_awal,
					  t.id idTind,
					  t.kso_id,
					  kso.nama       AS nmkso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip)    biaya,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
					  
IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi)    retribusi,
					  t.bayar,  
					  t.bayar_kso,
					  /*t.bayar_pasien*/
					  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
					  g.nama namapeg,
					  k.slip_ke
					FROM b_kunjungan k
					  INNER JOIN b_ms_pasien mp
						ON k.pasien_id = mp.id
					  INNER JOIN b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN b_pelayanan p
						ON k.id = p.kunjungan_id
					  INNER JOIN b_tindakan_kamar t
						ON p.id = t.pelayanan_id
					  INNER JOIN b_ms_kso kso
						ON t.kso_id = kso.id
					  LEFT JOIN b_bayar_tindakan bt 
						ON t.id = bt.tindakan_id
					  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
					WHERE k.pulang = 1 /*{$fkso} AND DATE(k.tgl_pulang) = '$tgl'*/ 
					AND	DATE(k.disetor_tgl)='".$tglAwal2."' AND k.disetor_oleh='".$_REQUEST['kasir']."' AND k.disetor=1
					GROUP BY t.id) AS tk 
				WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
				UNION
				SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit_awal,
				  t.id idTind,
				  kso.id AS kso_id,
				  kso.nama AS nmkso,
				SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
					  ) biaya,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
					  ) biaya_kso,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
					  ) biaya_pasien,
				  0 retribusi,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
				  0 AS bayarKso,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien,
				  g.nama namapeg,
				  k.slip_ke
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbapotek.a_penjualan t
					ON p.id = t.NO_KUNJUNGAN
				  INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN b_ms_kso kso
					ON m.kso_id_billing = kso.id
				  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
				WHERE k.pulang = 1 AND DATE(k.disetor_tgl)='".$tglAwal2."' AND k.disetor_oleh='".$_REQUEST['kasir']."' AND k.disetor=1
					AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = 0
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
				/* WHERE 1=1 AND ((SUM(biaya_kso)>0) OR (SUM(biaya_pasien)>SUM(bayar_pasien)))*/ 
				  {$filter}
				GROUP BY gab.id,gab.kso_id";
				//ORDER BY $sorting
				//echo $sqlPas."<br>";
				$rsPas = mysql_query($sqlPas);
				$no = 1;
				$sub = 0;
				while($rwPas = mysql_fetch_array($rsPas))
				{
			?>
			<tr>
				<td style="text-align:center;"><?php echo $no;?></td>
				<td style="text-align:left">&nbsp;<?php echo $rwPas['namapeg'];?></td>
				<td style="text-align:center"><?php echo $rwPas['tgl'];?></td>
				<td style="text-align:center"><?php echo $rwPas['jam'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kwi'];?></td>
				<td style="text-align:center"><?php echo $rwPas['no_rm'];?></td>
				<td style="text-transform:uppercase;">&nbsp;<?php echo $rwPas['pasien'];?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($rwPas['biayaKSO'],0,",",".");?></td>
			</tr>
			<?php
					$no++;
					$sub = $sub + $rwPas['biayaKSO'];
					}
			?>
			<tr>
				<td height="25" colspan="7" style="text-align:right; font-weight:bold; border-top:1px solid; ">TOTAL&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($sub,0,",",".");?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="2" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="2" height="50">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
			<?php 
			if($_POST['excel']!='excel'){
			?>
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
              <option value="0">Printer non-Kretekan</option>
              <option value="1">Printer Kretekan</option>
            </select>
			<br />
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
			<?php } ?>
            </td>
    </tr>
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

/*try{	
formatF4Portrait();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
function changeSize(par){
	if(par == 1){
		document.getElementById('tblPrint').width = 1200;
	}
	else{
		document.getElementById('tblPrint').width = 800;
	}
}

    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>
</html>
