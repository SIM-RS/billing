<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
$idPel = ($_REQUEST['idPel'] != "" && isset($_REQUEST['idPel']) ? $_REQUEST['idPel'] : "0");
$idKunj = ($_REQUEST['idKunj'] != "" && isset($_REQUEST['idKunj']) ? $_REQUEST['idKunj'] : "0");
$id_hasil_rad = $_REQUEST['id_hasil_rad'];

$sqlPas = "SELECT 
no_rm,
lcase(mp.nama) nmPas,
mp.alamat, 
mp.rt,
mp.rw,
mp.sex,
mk.nama kelas,
GROUP_CONCAT(DISTINCT md.nama) as diag,
peg.nama as dokter,
kso.nama nmKso,
DATE_FORMAT(p.tgl,'%d-%m-%Y') tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, 
mp.desa_id,
mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, 
k.kso_id,
k.kso_kelas_id,
p.kelas_id,
un.nama nmUnit,
k.umur_thn th,
k.umur_bln bl,
peng.nama as pengirim,
p.ket
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
left join b_ms_unit un on un.id=p.unit_id_asal
LEFT join b_diagnosa diag on diag.pelayanan_id=p.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
LEFT join b_ms_pegawai peg on peg.id = diag.user_id
left join b_ms_pegawai peng on peng.id = p.dokter_id
WHERE p.id='$idPel'";

$rs1 = mysql_query($sqlPas);
mysql_error();
$rw = mysql_fetch_array($rs1);
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
  <title>.: Rincian Hasil Radiologi :.</title>
  <link rel="stylesheet" href="../theme/bs/bootstrap.min.css">
  <script src="../pembayaran/datatables/jQuery-3.3.1/jquery-3.3.1.js"></script>
  <script src="../theme/bs/bootstrap.min.js"></script>
</head>

<body>
  <style>
    table td {
      font-size: 16px;
      text-transform: capitalize;
    }
  </style>
  <div>&nbsp;</div>
  <table width="100%" border="0" style="border-collapse:collapse; font:14px tahoma black;" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th>
          <table width="100%">
            <tr>
              <th style="font:24px tahoma black;text-align:center !important;"><strong>RADIOLOGI RUMAH SAKIT PELINDO I<br />KOTA MEDAN</strong></th>
            </tr>
            <tr>
              <th style="text-align:center !important;">JL.Stasiun, 92, Belawan - Kota Medan<br />
                Telp.: 021 5997 0200 - 59997 0201, Fax : 021 5997 0202<br /></th>
            </tr>
          </table>
        </th>
      </tr>
      <tr>
        <th colspan="2">
          <table cellpadding="0" cellspacing="0">

          </table>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2">
          <table width="100%">
            <tr>
              <td width="25%">No. RM</td>
              <td width="1%">:</td>
              <td width="30%" style="text-transform:capitalize;"><?php echo $rw['no_rm'] ?></td>
              <td width="20%" style="text-transform:capitalize;">Ruangan</td>
              <td width="1%">:</td>
              <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmUnit']); ?></td>
            </tr>
            <tr>
              <td style="text-transform:capitalize;">Nama / Jenis Kelamin</td>
              <td width="1%">:</td>
              <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmPas'] . ' / ' . (strtolower($rw['sex']) == 'l' ? 'L' : 'P')); ?></td>
              <td style="text-transform:capitalize;">Tanggal</td>
              <td width="1%">:</td>
              <td style="text-transform:capitalize;"><?php echo $rw['tgljam'] ?></td>
            </tr>
            <tr>
              <td style="text-transform:capitalize;">Umur</td>
              <td width="1%">:</td>
              <td style="text-transform:capitalize"><?php echo $rw['th'] . ' tahun ' . $rw['bl'] . ' bulan'; ?></td>
              <td style="text-transform:capitalize;">Penjamin</td>
              <td>:</td>
              <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmKso']); ?></td>
            </tr>
            <tr>
              <td style="text-transform:capitalize;">Pengirim</td>
              <td width="1%">:</td>
              <td style="text-transform:capitalize;"><?php echo strtolower($rw['pengirim']); ?></td>
            </tr>
            <tr>
              <td valign="top" style="text-transform:capitalize;">Diagnosa</td>
              <td width="1%" valign="top">:</td>
              <td style="text-transform:capitalize;"><?php echo $rw['ket']; ?></td>
            </tr>
          </table>
        </td>
      <tr>
        <td colspan="2">
          <table width="100%">
            <tr>
              <td></td>
              <td>&nbsp;<br /></td>
            </tr>
            <tr>
              <td colspan="2"><?php echo 'Ts. Yth. ' . strtolower($rw['pengirim']) ?></td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;<br />&nbsp;<br /></td>
            </tr>
            <?php
            $sql = "SELECT 
				hr.*,
				mp.nama,
				DATE_FORMAT(hr.tgl_act,'%d-%m-%Y / %H:%i') as tgl_baca 
				from b_hasil_rad hr 
				left JOIN b_ms_pegawai mp 
			ON mp.id = hr.user_id 
			INNER JOIN b_pelayanan p ON hr.pelayanan_id=p.id
			WHERE hr.id = '" . $id_hasil_rad . "'";

            $rs = mysql_query($sql);
            $dt = mysql_fetch_array($rs);
            ?>
            <tr>
              <td colspan="2"><?php echo $dt['hasil'] ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;<br />
                Salam sejawat,<br /> &nbsp;<br /> &nbsp;<br /> &nbsp;<br /> <?php echo strtolower($dt['nama']) ?></td>
            </tr>
          </table>
        </td>
      </tr>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr id="trTombol">
        <td height="24" colspan="3" align="center" valign="top" class="noline">

          <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
          <input id="viewPacs" type="button" value="View Hasil Pacs" onClick="viewHasil('<?php echo $dt['norm']; ?>','<?php echo $dt['pacsid']; ?>');" />
          <button id="lihatGambar" type="button" data-toggle="modal" data-target="#exampleModal">
            Lihat Gambar
          </button>
          <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />

        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" style="font-style:italic">Tgl / waktu hasil baca dokter : <?php echo $dt['tgl_baca']; ?></td>
      </tr>
    </tfoot>
  </table>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">FOTO</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          $ext = pathinfo(strtolower($dt['nama_file']));
          ?>
          <img width="460px" height="460px" src="data:image/<?= $ext['extension'] ?>;base64,<?= base64_encode($dt['fcontent']) ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/JavaScript">
  function cetak(tombol){
    tombol.style.visibility='collapse';
    if(tombol.style.visibility=='collapse'){
        if(confirm('Anda Yakin Mau Mencetak Hasil Pemeriksaan ?')){
            setTimeout('window.print()','1000');
            setTimeout('window.close()','2000');
        }
        else{
            tombol.style.visibility='visible';
        }

    }
}

function viewHasil(norm,idpacs){
	var url = "<?php echo $base_addr_pacs; ?>"+norm+'/'+idpacs+'/preview.html';
	var h = "700";
	var w = "1010";
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	if(idpacs != ""){
		window.open(url,'','height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',titlebar=no,toolbar=no,location=no,status=no,menubar=no,resizable');
	} else {
		alert('Hasil Radiologi Tidak Memiliki Hasil Pacs!');
	}
}
</script>