<body bgcolor="transparance">
<?
include("../../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$getIdPasien = $_REQUEST['getIdPasien'];
$in = $_REQUEST['in'];
$kh = $_REQUEST['kh'];
$valLab = $_REQUEST['valLab'];
$kon1 = $_REQUEST['kon1'];
$userId = $_REQUEST['userId'];
$idPel = $_REQUEST['idPel'];
$idKunj = $_REQUEST['idKunj'];
?>
<table width="100%" border="0">
        <?php $sqlT="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$idPel."') as gab";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['nama']?></td>
          </tr>
        <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table>
<!--<span style="color:#F00"></span>-->
</body>