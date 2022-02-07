<?php
session_start();
include("../sesi.php");
?>
<?php
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	$idPel = $_REQUEST['idPel'];
	
	//$userId = $_SESSION['userId'];
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['userId']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
		$sql = "SELECT k.id AS kujId, p.id AS pasId, pl.id AS pelId, p.no_rm, p.nama, p.sex, k.umur_thn, p.alamat, DATE_FORMAT(p.tgl_lahir,'%d/%m/%Y') AS tgllahir, p.rt, p.rw, p.desa_id, p.kec_id, p.kab_id, p.nama_ortu, p.nama_suami_istri, DATE_FORMAT(tk.tgl_in,'%d/%m/%Y %H:%i') AS tglawal,
	(SELECT nama FROM b_ms_wilayah WHERE id = p.desa_id) AS desa,
	(SELECT nama FROM b_ms_wilayah WHERE id = p.kec_id) AS kec,
	(SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) AS kab,
	(SELECT agama FROM b_ms_agama  WHERE id = p.agama) AS agama,
	(SELECT nama FROM b_ms_kso WHERE id = k.kso_id) AS kso,
	(SELECT nama FROM b_ms_pendidikan WHERE id = p.pendidikan_id) AS pendidikan,
	(SELECT nama FROM b_ms_pekerjaan WHERE id = p.pekerjaan_id) AS pekerjaan,
	(SELECT nama FROM b_ms_unit WHERE id = pl.unit_id) AS tmptlay,
	(SELECT nama FROM b_ms_kelas WHERE id = pl.kelas_id) AS kelas,
	(SELECT parent_id FROM b_ms_unit WHERE id = pl.unit_id_asal) AS asalmasuk,
	(SELECT nama FROM b_ms_kamar WHERE id = tk.kamar_id) AS ruang,
	(SELECT nama FROM b_ms_kelas WHERE id = tk.kelas_id) AS kls
	FROM b_ms_pasien p
	INNER JOIN b_kunjungan k ON k.pasien_id = p.id
	INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
	LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = pl.id
			WHERE p.id = '".$_REQUEST['idPas']."' AND pl.id = '".$idPel."'
			GROUP BY p.id";
	$rs = mysql_query($sql);
	$rw = mysql_fetch_array($rs);
?><title>Data Pasien MRS</title>
<div align="left">
	<table width="700" border="0" cellpadding="2" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
		<tr>
			<td colspan="5"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
		</tr>
		<tr>
			<td colspan="5" style="border-bottom:2px solid; font-size:12px;" height="30" align="center"><b>DATA PASIEN MRS</b></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td width="30%">&nbsp;</td>
			<td width="10%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="30%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;No. RM</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['no_rm'];?></b></td>
			<td>&nbsp;</td>
			<td>&nbsp;Tgl MRS</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['tglawal'];?></b></td>
		</tr>
		<tr>
			<td>&nbsp;Nama Pasien</td>
			<td style="text-transform:uppercase">&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['nama'];?></b></td>
			<td>&nbsp;</td>
			<td>&nbsp;Status Pasien</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['kso'];?></b></td>
		</tr>
		<tr>
			<td>&nbsp;Jenis Kelamin</td>
			<td colspan="2">&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['sex'];?></b>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;Umur&nbsp;:&nbsp;<b><?php echo $rw['umur_thn'];?></b>&nbsp;Tahun</td>
			<td>&nbsp;Tempat Layanan</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['tmptlay'];?></b></td>
		</tr>
		<tr>
			<td>&nbsp;Tanggal Lahir</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['tgllahir'];?></b></td>
			<td>&nbsp;</td>
			<td>&nbsp;Kelas</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php echo $rw['kelas'];?></b></td>
		</tr>
		<tr>
			<td>&nbsp;Alamat</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['alamat'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;Asal Masuk</td>
			<td>&nbsp;:&nbsp;&nbsp;<b><?php if($rw['asalmasuk'] == 1) echo "POLI RS"; else $rw['namaasalmasuk'];?></b></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;RT/RW&nbsp;:&nbsp;<?php echo $rw['rt'];?> / <?php echo $rw['rw'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="padding-left:5px;">
				<table border="0" cellpadding="2" cellspacing="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
					<tr>
						<td width="30%">&nbsp;Kelurahan/Desa</td>
						<td width="70%">:&nbsp;<?php echo $rw['desa'];?></td>
					</tr>
					<tr>
						<td>&nbsp;Kecamatan</td>
						<td>:&nbsp;<?php echo $rw['kec'];?></td>
					</tr>
					<tr>
						<td>&nbsp;Kabupaten/Kota</td>
						<td>:&nbsp;<?php echo $rw['kab'];?></td>
					</tr>
		</table>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;Diagnosa</td>
			<td>&nbsp;</td>
		</tr>
		<?php
					$sqlDiag = "SELECT md.kode,md.nama, k.pasien_id, k.id
							FROM b_ms_diagnosa md
							INNER JOIN b_diagnosa d ON d.ms_diagnosa_id = md.id
							INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
							INNER JOIN b_kunjungan k ON k.id = pl.kunjungan_id
							WHERE k.id = '".$_REQUEST['idKunj']."'";
					$rsDiag = mysql_query($sqlDiag);
					while($rwDiag = mysql_fetch_array($rsDiag))
					{
			?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<!--td colspan="2" style="padding-left:50px;">&nbsp;&nbsp;&nbsp;&middot;&nbsp;<?php echo $rwDiag['kode']." - ".$rwDiag['nama'];?></td-->
			<td colspan="2" style="padding-left:50px;">&nbsp;&nbsp;&nbsp;&middot;&nbsp;<?php echo $rwDiag['nama'];?></td>
		</tr>
		<?php
				}
			?>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;Agama</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['agama'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;Tgl Masuk</td>
			<td>&nbsp;:&nbsp;&nbsp;<span style="border-bottom:1px solid; padding-left:30px;">&nbsp;</span>/<span style="border-bottom:1px solid; padding-left:30px;">&nbsp;</span>/<span style="border-bottom:1px solid; padding-left:60px;">&nbsp;</span></td>
		</tr>
		<tr>
			<td>&nbsp;Pendidikan</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['pendidikan'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;Ke Ruang</td>
			<td>&nbsp;:&nbsp;&nbsp;<span style="border-bottom:1px solid; padding-left:170px;">&nbsp;</span></td>
		</tr>
		<tr>
			<td>&nbsp;Pekerjaan</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['pekerjaan'];?></td>
			<td colspan="3">&nbsp;</td>
			<!--<td>&nbsp;Kelas</td>
			<td>&nbsp;:&nbsp;&nbsp;<b>1 / 2 / 3 / VIP</b>&nbsp;<span style="border-bottom:1px solid; padding-left:100px;">&nbsp;</span></td>-->
		</tr>
		<tr>
			<td>&nbsp;Status</td>
			<td>&nbsp;:&nbsp;&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;Nama Ortu</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['nama_ortu'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;Nama Suami</td>
			<td>&nbsp;:&nbsp;&nbsp;<?php echo $rw['nama_suami_istri'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right; padding-right:10px; font-weight:bold">Tgl Cetak&nbsp;:&nbsp;<?php echo $date_now;?>&nbsp;Jam&nbsp;<?php echo $jam;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
			<td colspan="2" style="text-align:right; padding-left:10px; font-weight:bold">Yang Mencetak,</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td height="30">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
			<td colspan="2" style="text-align:right; padding-right:10px; text-transform:uppercase"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
		</tr>
		 <tr id="trTombol">
                <td colspan="5" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
		</tr>
	</table>
</div>
 <script language="JavaScript" type="text/JavaScript">
        /*try{
	formatTagihan();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	}*/
        
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