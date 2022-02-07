<?php
//include("../sesi.php");
?>
<title>Surat Keabsahan Peserta (SKP) JAMKESDA</title>
<?php
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("H:i:s");

$userId = $_REQUEST['userId'];
$kunjId = $_REQUEST['idKunj'];

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
$petugas=$rwPeg['nama'];

if($_REQUEST['kamar'] == 'true'){
    $qPeserta="SELECT p.no_rm,p.nama,p.no_ktp,k.alamat,k.rt,k.rw,p.tgl_lahir,if(pl.jenis_layanan=94,'ICU','RAWAT INAP') AS jenis
    ,IF(p.sex='L','Laki-laki','Perempuan') AS sex,no_sjp,
    s.nama AS identitas,s.id as id_kso,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglkunj 
    FROM b_kunjungan k
    inner join b_pelayanan pl on k.id = pl.kunjungan_id
    INNER JOIN b_ms_pasien p ON k.pasien_id=p.id
    INNER JOIN b_ms_unit u ON pl.jenis_layanan=u.id
    INNER JOIN b_ms_kso s ON k.kso_id=s.id
    inner join b_tindakan_kamar tk on tk.pelayanan_id = pl.id
    WHERE k.id='$kunjId' order by pl.id limit 1";
    //,u.nama AS jenis
}
else{
    $qPeserta="SELECT p.no_rm,p.nama,p.no_ktp,k.alamat,k.rt,k.rw,p.tgl_lahir,u.nama AS jenis,IF(p.sex='L','Laki-laki','Perempuan') AS sex,no_sjp,
    s.nama AS identitas,s.id as id_kso,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglkunj FROM b_kunjungan k 
    INNER JOIN b_ms_pasien p ON k.pasien_id=p.id
    INNER JOIN b_ms_unit u ON k.jenis_layanan=u.id
    INNER JOIN b_ms_kso s ON k.kso_id=s.id
    WHERE k.id='$kunjId'";
}

$rsPeserta=mysql_query($qPeserta);
$rwPeserta=mysql_fetch_array($rsPeserta);
$penjamin=$rwPeserta['identitas'];

if ($rwPeserta['id_kso'] == 53){
	$sql = "SELECT * FROM validasi WHERE id=3";
	$rsPetugas = mysql_query($sql);
	$rwPetugas = mysql_fetch_array($rsPetugas);
	$petugas=$rwPetugas["nama"]."<br>NIP. ".$rwPetugas["nip"];
	//$nip=$rwPetugas["nip"];
}


$jdl="SURAT KEABSAHAN PESERTA (SKP)<br/>$penjamin<br/>".$namaRS."<br/>Berlaku : 1 (satu) X Kunjungan";
if ($_REQUEST['jampersal'] == 'true'){
	$jdl="SURAT JAMINAN PERSALINAN (JAMPERSAL)<br/>".$namaRS."<br/>
            Berlaku : 1 (satu) X Kunjungan";
}
?>
<table width="1250" border="0" cellpadding="0" cellspacing="0" align="left">
    <tr>
        <td colspan="6" align="center" style="padding-bottom:50px">
            <strong style="font-size:18px"><?php echo $jdl; ?></strong>
        </td>
    </tr>
    <?php 
	if ($rwPeserta['id_kso'] == 53){
	?>
    <tr>
        <td width="170">Nomor KTP/Identitas</td>
        <td>:</td>
        <td width="500" align="left"><?php echo '&nbsp;'.$rwPeserta['no_ktp'];?></td>
        <td width="170">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="400">&nbsp;</td>
    </tr>
	<?php
	}
	?>
    <tr>
        <td width="170">Nomor MR</td>
        <td>:</td>
        <td width="500" align="left"><?php echo '&nbsp;'.$rwPeserta['no_rm'];?></td>
        <td width="170">No. SKP</td>
        <td>:</td>
        <td width="400"><?php echo '&nbsp;'.$rwPeserta['no_sjp'];?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php echo '&nbsp;'.$rwPeserta['nama'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo '&nbsp;'.$rwPeserta['alamat'].", RT.".$rwPeserta['rt'].", RW.".$rwPeserta['rw'];?></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo '&nbsp;'.$rwPeserta['sex'];?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo '&nbsp;'.tglSQL($rwPeserta['tgl_lahir']);?></td>
        <td>Jenis Pasien</td>
        <td>:</td>
        <td><?php echo '&nbsp;'.$rwPeserta['identitas'];?></td>
    </tr>
    <tr>
        <td valign="top">Jenis Kunjungan</td>
        <td valign="top">:</td>
        <td valign="top"><?php if ($rwPeserta['id_kso'] == 53){
			echo "<ol>
            	<li>Rawat Jalan</li>
            	<li>Rawat Inap</li>
            	</ol>";
		}else{echo '&nbsp;'.$rwPeserta['jenis'];}?></td>
		<?php
		if($rwPeserta['id_kso'] == 39){
			echo "<td valign='top'>Identitas Kunjungan</td>
        		<td valign='top'>:</td>
        		<td><ol>
            	<li>JAMKESDA</li>
            	<li>SKTM KEBIJAKAN</li>
            	<li>Lain-lain</li>
            	</ol>
        		</td>";
		}elseif($rwPeserta['id_kso'] == 53){
			echo "<td valign='top'>Asal Kunjungan</td>
        		<td valign='top'>:</td>
        		<td><ol>
            	<li>Bidan</li>
            	<li>Puskesmas</li>
            	</ol>
        		</td>";
		}
		?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
    <tr>
        <td align="center" valign="bottom"><strong>Keluarga/Penderita</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;<?=$kotaRS?>, <?php echo $date_now;?> <br/> <?php if ($rwPeserta['id_kso'] == 53) echo "Mengetahui"; else echo "Petugas PPATRS";?></td>
    </tr>
    <tr>
        <td style="padding-bottom:20px">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" ><?php echo $petugas;?></td>
    </tr>
    <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
                window.print();
                window.close();
        }
    }
</script>
<?php 
mysql_close($konek);
?>