<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idPasien=$_REQUEST['idPasien'];

$qPasien="select p.no_rm,p.nama,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='".$idPasien."'";
$rsPasien=mysql_query($qPasien);
$rwPasien=mysql_fetch_array($rsPasien);
?>
<html>
    <head>
        <title>Rekam Medis Pasien</title>
        <style>
            .withline{
                border:1px solid #000000;
            }
            .noline{
                border:none;
            }
            .tableHeader{
                font:10 bold;
                border:1px solid #000000;
                text-align:center;
            }
            .tableContent{
                font:10 sans-serif normal;
                border:1px solid #000000;
                padding-left:5px;
            }
        </style>
    </head>
    <body>
        <table width="1000" align="center" cellpadding=0 cellspacing=0>
            <tr>
                <td class="noline" colspan="2" style="font:12 sans-serif normal"><?=$namaRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"><?=$alamatRS?> </td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold">Telepon <?=$tlpRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"><?=$kotaRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" colspan="4" align="center" style="font:14 sans-serif bolder;">Rekam Medis Pasien</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    No Rekam Medis : <?php echo $rwPasien['no_rm'];?>
                </td>
                <td class="noline"></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    Nama Pasien : <?php echo $rwPasien['nama'];?>
                </td>
                <td class="noline"></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    Alamat : <?php echo $rwPasien['alamat']." RT.".$rwPasien['rt']." RW.".$rwPasien['rw']." Desa/Kel.".$rwPasien['desa']." Kec.".$rwPasien['kec']." Kab.".$rwPasien['kab'];?>
                </td>
                <td class="noline"></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" align="center" colspan="4">
                    <table class="withline" width="100%" cellpadding=0 cellspacing=0>
                        <tr>
                            <td width="3%" class="tableHeader"><strong>No</strong></td>
                            <td width="12%" class="tableHeader"><strong>Kunjungan</strong></td>
                            <td width="25%" class="tableHeader"><strong>Tindakan</strong></td>
                            <td width="20%" class="tableHeader"><strong>Diagnosa</strong></td>
                            <td width="20%" class="tableHeader"><strong>Obat</strong></td>
                            <td width="15%" class="tableHeader"><strong>Status Keluar</strong></td>
                        </tr>
                        <?php
                        $qKunj="select k.id,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."'";
                        $rsKunj=mysql_query($qKunj);
                        $no=1;
                        $tempUnit='';
                        $tempUnit2='';
                        $tempUnit3='';
                        $tempName = '';
                        while($rwKunj=mysql_fetch_array($rsKunj)) {
                            $tanggal=explode(" ",$rwKunj['tgl_act']);
                            ?>
                        <tr>
                            <td class="tableContent" align="center" valign="top"><?php echo $no;?></td>
                            <td class="tableContent" align="center" valign="top"><?php echo tglSQL($tanggal[0])." ".$tanggal[1];?>&nbsp;</td>
                            <td class="tableContent" align="left" valign="top"><?php
                                    $qTind="SELECT u.nama AS unit,mt.nama AS tindakan,IF(u_asal.kategori <> 1,n.nama,'') AS rujuk_dari
                                      ,IF(u_asal.kategori <> 1,p.tgl,'') AS tgl_rujuk
                                      ,IF(bp.nama IS NOT NULL,CONCAT('<br/>Dokter:&nbsp;',bp.nama),'') AS nm_dokter,
                                      IF(bp2.nama IS NOT NULL,CONCAT('<br/>Petugas:&nbsp;',bp2.nama,'<br/>'),'') AS nm_user,
									  IFNULL((SELECT kode_icd_9cm FROM b_tindakan_icd9cm WHERE b_tindakan_id=t1.id),' - ') kode_icd_9cm
                                            FROM (SELECT * FROM b_tindakan t WHERE t.kunjungan_id='".$rwKunj['id']."') AS t1
                                            INNER JOIN b_pelayanan p ON p.id=t1.pelayanan_id
                                            INNER JOIN b_ms_unit u ON u.id=p.unit_id
                                            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
                                            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id
                                            LEFT JOIN b_ms_unit u_asal ON p.unit_id_asal = u_asal.id
                                            LEFT JOIN b_ms_unit n ON n.id=p.unit_id_asal
                                            LEFT JOIN b_ms_pegawai bp ON bp.id = t1.user_id
                                            LEFT JOIN b_ms_pegawai bp2 ON bp2.id= t1.user_act
                                            ORDER BY unit
											";
                                    $rsTind=mysql_query($qTind);
                                    while($rwTind=mysql_fetch_array($rsTind)) {
                                        if($tempUnit!=$rwTind['unit']) {
                                            $tempUnit=$rwTind['unit'];
                                            ?>
                              </ul>
                                <ul style="list-style-position:inside;list-style-type:square;padding-left:2px;">
                                                <?php
                                                echo '<b>'.$rwTind['unit'].'</b>'.(($rwTind['rujuk_dari']!='')?" (Dirujuk dari: ".$rwTind['rujuk_dari']:'').(($rwTind['tgl_rujuk']!='')?" tanggal: ".tglSQL($rwTind['tgl_rujuk']).")":'')?>
                              <li><?php echo "<b>[".$rwTind["kode_icd_9cm"]."]</b> ".$rwTind['tindakan'];?><?php echo $rwTind['nm_dokter'];?><?php echo $rwTind['nm_user'];?></li>
                                                <?php
                                            }
                                            else {
                                                ?>
                                    <li><?php echo "<b>[".$rwTind["kode_icd_9cm"]."]</b> ".$rwTind['tindakan'];?><?php echo $rwTind['nm_dokter'];?><?php echo $rwTind['nm_user'];?></li>
                                                <?php
                                            }
                                        }
                                        $tempUnit = '';
                                        ?>
&nbsp;                            </td>
                            <td class="tableContent" align="left" valign="top">
                                    <?php
                                    $qDiag="select d.diagnosa_id,u.nama as unit,IFNULL(md.nama,d.diagnosa_manual) as diagnosa,IF(bp.nama IS NOT NULL,CONCAT('<br/>Dokter:&nbsp;',bp.nama),'') AS nm_dokter,
                                      IF(bp2.nama IS NOT NULL,CONCAT('<br/>Petugas:&nbsp;',bp2.nama,'<br/>'),'') AS nm_user,
									  IFNULL((SELECT md1.kode FROM b_diagnosa_rm rm INNER JOIN b_ms_diagnosa md1 ON rm.ms_diagnosa_id=md1.id WHERE rm.diagnosa_id=d.diagnosa_id),' - ') icd_10
									  from b_diagnosa d
                                    left join b_ms_diagnosa md on md.id=d.ms_diagnosa_id
                                    inner join b_pelayanan l on l.id=d.pelayanan_id
                                    inner join b_ms_unit u on u.id=l.unit_id
									LEFT JOIN b_ms_pegawai bp ON bp.id = d.user_id
                                    LEFT JOIN b_ms_pegawai bp2 ON bp2.id= d.user_act
                                    where l.kunjungan_id='".$rwKunj['id']."'
                                        order by unit";
									//echo $qDiag."<br>";
                                    $rsDiag=mysql_query($qDiag);
                                    while($rwDiag=mysql_fetch_array($rsDiag)) {
                                        if($tempUnit2!=$rwDiag['unit']) {
                                            $tempUnit2=$rwDiag['unit'];
                                            ?>
                            </ul><ul style="list-style-position:inside;list-style-type:square;padding-left:2px;">
                                        <?php
                                        echo '<b>'.$rwDiag['unit'].'</b>';
                                        ?>
                            <li><?php echo "<strong>[".$rwDiag['icd_10']."]</strong> ".$rwDiag['diagnosa'];?><?php echo $rwDiag['nm_dokter'];?><?php echo $rwDiag['nm_user'];?></li>
                                        <?php
                                    }
                                    else {
                                        ?>
                            <li><?php echo "<strong>[".$rwDiag['icd_10']."]</strong> ".$rwDiag['diagnosa'];?><?php echo $rwDiag['nm_dokter'];?><?php echo $rwDiag['nm_user'];?></li>
                                        <?php
                                    }
                                }
                                $tempUnit2 = '';
                                ?>
&nbsp;                    </td>
                          <td class="tableContent" align="left" valign="top">
                            <?php
                            $qObat = "SELECT $dbbilling.b_resep.obat_id, $dbbilling.b_resep.kunjungan_id, qty, $dbapotek.a_obat.OBAT_NAMA,ap.unit_name,
                                    (SELECT $dbbilling.u.nama FROM $dbbilling.b_ms_unit u inner join $dbbilling.b_pelayanan p on p.unit_id=u.id WHERE $dbbilling.b_resep.id_pelayanan = $dbbilling.p.id) AS unit
                                    FROM $dbbilling.b_resep
                                    INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID = $dbbilling.b_resep.obat_id
                                    inner join $dbapotek.a_unit ap on b_resep.apotek_id = ap.unit_id
                                    WHERE $dbbilling.b_resep.kunjungan_id = '".$rwKunj['id']."' order by unit,unit_name";
                            $rsObat = mysql_query($qObat);
                            while($rwObat = mysql_fetch_array($rsObat)) {
                                if($tempUnit3!=$rwObat['unit']) {
                                    $tempUnit3=$rwObat['unit'];
                                    ?>
                    </ul><ul style="list-style-position:inside; list-style-type:square; padding-left:2px;">
                        <?php
                        echo '<b>'.$rwObat['unit'].'</b>';
                        if(strcmp($tempName,$rwObat['unit_name']) != 0)
                            echo '<br><i>- '.$rwObat['unit_name'].'</i><br>';
                        ?>
                        <li style="padding-left: 10px"><?php echo $rwObat['OBAT_NAMA'].' (Jumlah : '.$rwObat['qty'].')';?></li>
                                <?php
                            }
                            else {
                                if(strcmp($tempName,$rwObat['unit_name']) != 0)
                                    echo '<br><i>- '.$rwObat['unit_name'].'</i><br>';
                                ?>
                    <li style="padding-left: 10px"><?php echo $rwObat['OBAT_NAMA'].' (Jumlah : '.$rwObat['qty'].')';?></li>
                                <?php
                            }
                        $tempName = $rwObat['unit_name'];
                        }
                        $tempUnit3 = '';
                        ?>
&nbsp;            </td>
            <td class="tableContent" align="left" valign="top">
                    <?php
                    $qKeluar="select p.cara_keluar,p.keadaan_keluar from b_pasien_keluar p
                                    where p.kunjungan_id='".$rwKunj['id']."'";
                    $rsKeluar=mysql_query($qKeluar);
                    while($rwKeluar=mysql_fetch_array($rsKeluar)) {
                        echo "cara keluar: ".$rwKeluar['cara_keluar']."<br> keadaan keluar: ".$rwKeluar['keadaan_keluar'];
                    }
                    ?>
&nbsp;            </td>
        </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</td>
</tr>
<tr>
    <td class="noline">&nbsp;</td>
    <td class="noline">&nbsp;</td>
    <td class="noline">&nbsp;</td>
    <td class="noline"></td>
</tr>
<tr id="trTombol">            
    <td colspan="4" class="noline" align="center">
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
    </td>
</tr>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak Rekam Medis ini?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>
<?php 
mysql_close($konek);
?>