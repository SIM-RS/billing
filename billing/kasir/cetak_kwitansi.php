<?
session_start();
include("../koneksi/konek.php");

$date_now=gmdate('d-m-Y',mktime(date('H')+7));

$queri="SELECT
  b.id,
  b.no_kwitansi,
  b.tanggal,
  a.nama,
  b.no_tagihan,
  b.tgl_tagihan,
  b.nilai_tagihan,
  b.nilai_dibayar,
  b.penerima,
  c.username AS petugas,
  b.ket_bayar
FROM b_bayar_kso b
  INNER JOIN b_ms_kso a
    ON b.kso_id = a.id
  INNER JOIN b_ms_pegawai c
    ON b.penerima = c.id WHERE b.no_kwitansi='".$_REQUEST['no']."'";

$ss=mysql_query($queri);
while($data=mysql_fetch_array($ss)){
?>
<title>Kwitansi</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<table border="0" cellpadding="2" cellspacing="2" align="left" class="kwi">
    <tr>
        <td width="60">&nbsp;</td>
        <td width="200">&nbsp;</td>
        <td width="67">&nbsp;</td>
        <td width="200">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" align="center" style="font-family: verdana">
            <b>
                RS PELINDO I KOTA MEDAN<br>
                -----------------------------------------------------------------------------<br>
            </b>
        </td>
    </tr>
	<tr><td colspan="4" align="center"><u>TANDA BUKTI PENERIMAAN KSO</u></td></tr>
	<tr>
	<td width="15%">No. Kwitansi</td>
	<td>:&nbsp;<?php echo strtolower($data['no_kwitansi']); ?></td>
	<td width="30%"></td>
	<td></td>
	</tr>
	<tr>
	<td width="15%">Tanggal</td><td>:&nbsp;<?php echo $date_now ?></td><td width="30%"></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;Petugas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $_SESSION['userName']; ?></td>
    </tr>
	<tr>
	<td colspan="4">===================================================================================</td>
	</tr>
	<tr>
	<td width="10%">&nbsp;</td><td>Bendahara Khusus Penerima</td><td width="30%" colspan="2"> : RS PELINDO I KOTA MEDAN </td>
	</tr>
	<tr>
	<td width="10%">&nbsp;</td>
	<td>Nama KSO</td><td width="30%" colspan="2"> : <?php echo $data['nama'] ?></td>
	</tr>
	<tr>
	<td width="10%">&nbsp;</td>
	<td>No. Tagihan</td><td width="30%" colspan="2"> : <?php echo $data['no_tagihan'];?></td>
	</tr>
    <tr>
	<td width="10%">&nbsp;</td>
	<td>Tanggal</td><td width="30%" colspan="2"> : <?php echo tglSQL($data['tgl_tagihan']);?></td>
	</tr>
    <tr>
	<td width="10%">&nbsp;</td>
	<td>Nilai</td><td width="30%" colspan="2"> : Rp. <? echo number_format($data['nilai_tagihan'],0,",",".");?></td>
	</tr>
    <tr>
	<td width="10%">&nbsp;</td><td>&nbsp;</td><td width="30%" colspan="2">&nbsp;&nbsp;(<?=kekata($data['nilai_tagihan'],0,",",".");?> Rupiah ) </td>
	</tr
    ><tr>
	<td width="10%">&nbsp;</td>
	<td>Telah DiBayar</td><td width="30%" colspan="2"> : Rp. <? echo number_format($data['nilai_dibayar'],0,",",".");?></td>
	</tr>
    <tr>
	<td width="10%">&nbsp;</td><td>&nbsp;</td><td width="30%" colspan="2">&nbsp;&nbsp;(<?=kekata($data['nilai_dibayar'],0,",",".");?> Rupiah ) </td>
	</tr
	><tr>
	<td width="10%">&nbsp;</td><td>Sebagai Pembayaran</td><td width="30%" colspan="2"> : <?php echo strtoupper($data['ket_bayar']);?></td>
	</tr>
	<tr>
	<td colspan="4">===================================================================================</td>
	</tr>
	<tr>
	<td colspan="4">
	<table width="100%" border="0" align="center" class="kwi">
	<tr align="center"><td style="border-right:1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;Penerima&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br><br></td>
	<td>Uang tersebut diatas diterima<br>Tuban Tgl. <?=gmdate('d/m/Y',mktime(date('H')+7));?><br><br><br><br><br><?php echo $kasir; ?></td>
	<td width="200" style="border-left:1px solid;">Penyetor<br><br><br><br><br><br></td></tr>
	</table>
	</td>
	</tr>
	<tr>
	<td colspan="4">===================================================================================</td>
	</tr>
	<tr>
	<td colspan="4">Jabatan dan Tanda Tangan Bendaharawan Penerima</td>
	</tr>
	<tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
	</table>
<?php
}
?>
	<script type="text/JavaScript">
	 function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
          
                window.print();
                window.close();
        }
		}
	</script>