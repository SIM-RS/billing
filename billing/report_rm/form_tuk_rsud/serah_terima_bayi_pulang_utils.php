<?php

include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*, ku.no_reg,
  mw.nama AS nm_desa,
  mw1.nama AS nm_kec,
  mw2.nama AS nm_kab,
  mw3.nama AS nm_prop,
  pk.nama AS pekerjaan,
  ag.agama AS agamanya, ku.no_reg,
  DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lhr,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,peg.nama AS dokter,
  CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
  ku.no_reg as no_reg2, pl.kso_id
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_wilayah w
 ON p.desa_id = w.id
LEFT JOIN b_ms_wilayah wi
 ON p.kec_id = wi.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_tindakan bmt ON pl.id = bmt.pelayanan_id 
LEFT JOIN b_ms_pegawai peg ON peg.id = bmt.user_act
LEFT JOIN b_kunjungan ku
    ON ku.id=pl.kunjungan_id
LEFT JOIN b_ms_wilayah mw
    ON mw.id=p.desa_id
LEFT JOIN b_ms_wilayah mw1
    ON mw1.id=p.kec_id
LEFT JOIN b_ms_wilayah mw2
    ON mw2.id=p.kab_id
LEFT JOIN b_ms_wilayah mw3
    ON mw3.id=p.prop_id
LEFT JOIN b_ms_agama ag
    ON ag.id=p.agama
LEFT JOIN b_ms_pekerjaan pk
    ON pk.id=ku.pekerjaan_id
WHERE pl.id='$idPel'";
$pasien=mysql_fetch_array(mysql_query($sqlP));
//echo $sqlP;
$sql = "SELECT p.nama FROM b_ms_pegawai p WHERE p.id = {$idUsr}";
$activeUser = mysql_fetch_array(mysql_query($sql));
?>