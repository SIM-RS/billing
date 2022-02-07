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
    <td colspan="3"><b>Rumah Sakit PELINDO I<br />
    JL.Stasiun, 92<br />
    (061) 6940120<br />
    Medan<br /><br /></b></td>
  </tr>
  <tr>
    <td colspan="3" align="center" height="70" valign="top" style="font-size:14px;">
	
	
	<table width="100%" border="0" cellpadding="3" cellspacing="0" style="border:1px solid #000000; font-family:Arial,sans-serif; font-size:12px;">
	  
	<?php
	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	$sqlPas="SELECT 
	DATE_FORMAT(b_bayar.disetor_tgl,'%d-%m-%Y') AS tgl,
	DATE_FORMAT(b_bayar.disetor_tgl,'%H:%i') AS jam,
	b_bayar.no_kwitansi AS kwi,
	b_bayar.slip_ke,
	b_ms_pasien.no_rm,
	b_ms_pasien.nama as pasien,
	sum(b_bayar.nilai) nilai,
	b_ms_pegawai.nama as penyetor,
	b_ms_pegawai.telp
	FROM
	b_bayar
	INNER JOIN b_kunjungan ON b_kunjungan.id = b_bayar.kunjungan_id
	INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
	INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.disetor_oleh
	WHERE DATE(b_bayar.disetor_tgl)='".$tglAwal2."' AND b_bayar.disetor_oleh='".$_REQUEST['kasir']."' AND b_bayar.disetor=1 {$filter}";
	//echo $sqlPas."<br>";
	$rsPas = mysql_query($sqlPas);
	$rspas1 = mysql_fetch_array($rsPas);
	$no = 1;
	$sub = 0;

	?>
			
        <tr>
          <td width="1%" >&nbsp;</td>
          <td width="22%" > Tanggal</td>
          <td width="3%" align="left" >:</td>
          <td width="30%" align="left" ><?php echo $rspas1['tgl'];?></td>
          <td width="15%" >No Selip </td>
          <td width="2%" >:</td>
          <td width="27%" ><span style="text-align:left"><?php echo $rspas1['slip_ke'];?></span></td>
        </tr>
		<tr >
		  <td >&nbsp;</td>
		  <td >Nama Bank </td>
		  <td align="left">:</td>
		  <td align="left">Bank Jatim </td>
		  <td >Sumber Dana </td>
		  <td >:</td>
		  <td >Tunai</td>
	    </tr>
		<tr >
		  <td >&nbsp;</td>
		  <td >No Rekening </td>
		  <td align="left">:</td>
		  <td align="left">2323422223</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
	    </tr>
		<tr >
		  <td >&nbsp;</td>
		  <td >Nama Pemilik rekening </td>
		  <td align="left">:</td>
		  <td align="left">RS PELINDO </td>
		  <td >Jumlah</td>
		  <td >:</td>
		  <td >Rp. <?php echo number_format($rspas1['nilai'],0,",",".");?>&nbsp;</td>
	    </tr>
		<tr >
		  <td >&nbsp;</td>
		  <td >Berita keterangan </td>
		  <td align="left">:</td>
		  <td align="left">Setoran Kasir <span style="text-align:left"><?php echo $rspas1['penyetor'];?></span></td>
		  <td >Terbilang</td>
		  <td >:</td>
		  <td rowspan="2" style="text-transform:capitalize;"><i><?=kekata($rspas1['nilai'],0,",",".");?> Rupiah</i> &nbsp;</td>
	    </tr>
		
		<tr>
		  <td >&nbsp;</td>
		  <td >Nama Penyetor </td>
		  <td align="left">:</td>
		  <td align="left"><span style="text-align:left"><?php echo $rspas1['penyetor'];?></span></td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
	    </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >Telepon</td>
          <td align="left">:</td>
          <td align="left"><span style="text-align:left"><?php echo $rspas1['telp'];?></span></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        
        <?php
				if ($filter!=""){
					$filter=explode("|",$filter);
					$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
				}
				$sqlPas="SELECT 
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
				WHERE DATE(b_bayar.disetor_tgl)='".$tglAwal2."' AND b_bayar.disetor_oleh='".$_REQUEST['kasir']."' AND b_bayar.disetor=1 {$filter}";
				//echo $sqlPas."<br>";
				$rsPas = mysql_query($sqlPas);
				$no = 1;
				$sub = 0;
				while($rwPas = mysql_fetch_array($rsPas))
				{
			?>
        
        <?php
					$no++;
					$sub = $sub + $rwPas['nilai'];
					}
			?>
      </table>    </td>
  </tr>
  <tr>
  	<td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td height="14">&nbsp;</td>
    <td height="14" colspan="2" align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr align="center">
  	<td width="392" height="30">&nbsp;</td>
    <td width="204" height="30"><p>&nbsp;</p>
      <p>Teller</p>
      <p>&nbsp;</p>
    <p>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p></td>
    <td width="204"><p>&nbsp;</p>
      <p>Penyetor</p>
      <p>&nbsp;</p>
    <p>(<span style="text-align:left"><?php echo $rspas1['penyetor'];?></span>)</p></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td colspan="2" align="right">&nbsp;</td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="3" height="50">
	 <tr id="trTombol">
       <td colspan="4" class="noline" align="center">
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
			<?php } ?>            </td>
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
