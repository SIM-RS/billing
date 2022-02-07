<?php
//include("../sesi.php");
?>
<?php
include '../koneksi/konek.php';
$user_id = $_REQUEST['userId'];
$hid_kunjungan_id = $_REQUEST['hid_kunjungan_id'];

$sql="SELECT DATE_FORMAT(k.tgl_sjp,'%d-%m-%Y') tgl_sjp, DATE_FORMAT(k.tgl,'%d-%m-%Y') tgl, 
DATE_FORMAT(ps.tgl_lahir,'%d-%m-%Y') tgl_lahir, ps.no_rm, ps.nama, k.nama_peserta,k.status_penj, IF(ps.sex='L','Laki-laki','Perempuan') gender, 
k.no_anggota, k.no_sjp, u.nama AS unit,CONCAT(md.kode,' - ',md.nama) diag,mkp.kode_ppk 
FROM (SELECT * FROM b_kunjungan WHERE id='$hid_kunjungan_id') k INNER JOIN b_ms_pasien ps ON k.pasien_id = ps.id 
INNER JOIN b_ms_unit u ON k.unit_id = u.id LEFT JOIN b_ms_diagnosa md ON k.diag_awal=md.id LEFT JOIN b_ms_kso_pasien mkp ON ps.id=mkp.pasien_id";
//echo $sql."<br>";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
?>
<title>.: Surat Jaminan Pelayanan :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="padding-top:2px;padding-bottom:2px;">
	<tr>
		<td colspan="2" style="font-size:18px; font-weight:bold; text-align:center;">PT. (Persero) ASURANSI KESEHATAN INDONESIA<br>SURAT JAMINAN PELAYANAN (SJP)<br></td>
	</tr>
	<tr>
		<td style="padding-left:20px; font-weight:bold; font-size:18px;" width="65%">SJP-RJTL</td>
		<td width="35%" style="font-weight:bold; font-size:18px;">No. SJP : <?php echo $row['no_sjp'];?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="1000" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="20" align="center">1</td>
					<td width="170">Tanggal SJP</td>
					<td width="250" class="full">:&nbsp;<?php echo $row['tgl_sjp'];?></td>
					<td width="150" class="full">&nbsp;Nama Pasien</td>
					<td colspan="2" style="text-transform:uppercase" class="full">:&nbsp;<?php echo $row['nama_peserta'];?></td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>Nomor Rujukan</td>
					<td class="full">:&nbsp;<?php echo $row['no_rm'];?></td>
					<td>&nbsp;Nomor Kartu Askes</td>
					<td class="full">:&nbsp;<?php echo $row['no_anggota'];?></td>
					<td width="200" class="full">Status&nbsp;:&nbsp;<?php echo strtoupper($row['status_penj']);?></td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td>Tanggal Rujukan</td>
					<td class="full">:&nbsp;<?php echo $row['tgl'];?></td>
					<td>&nbsp;MR</td>
					<td colspan="2" class="full">:&nbsp;<?php echo $row['no_rm'];?></td>
				</tr>
				<tr>
					<td align="center">4</td>
					<td>Asal Rujukan/kode PPK</td>
					<td class="full">:&nbsp;<?php echo $row['kode_ppk'];?></td>
					<td>&nbsp;Jenis Kelamin</td>
					<td colspan="2" style="text-transform:uppercase" class="full">:&nbsp;<?php echo $row['gender'];?></td>
				</tr>
				<tr>
					<td align="center">5</td>
					<td>Diagnosa Puskesmas</td>
					<td rowspan="2" valign="top" class="full">:&nbsp;<?php echo $row['diag'];?></td>
				  <td>&nbsp;Tgl. Lahir</td>
					<td colspan="2" class="full">:&nbsp;<?php echo $row['tgl_lahir'];?></td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;Badan Usaha</td>
					<td colspan="2">:&nbsp;</td>
				</tr>
				<tr>
					<td height="15" align="center">6</td>
					<td>Tujuan Rujukan</td>
					<td class="full">:&nbsp;1) Poli : <?php echo $row['unit'];?></td>
					<td>&nbsp;Diagnosa R.S</td>
					<td colspan="2">:&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" align="center">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="19" align="center">7</td>
							  <td width="180">Pemeriksaan Paket</td>
							  <td width="143">:&nbsp;2) 
						      <input type="checkbox"> P2A</td>
							  <td width="137">&nbsp;3) 
						      <input type="checkbox"> P2B</td>
							  <td width="141">&nbsp;Pasien</td>
							  <td width="141">&nbsp;Petugas RS</td>
							  <td colspan="2">&nbsp;Petugas Askes</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp; 4) <input type="checkbox"> P2C</td>
								<td>&nbsp;5) <input type="checkbox"> P3</td>
								<td>1)&nbsp;...............................</td>
								<td>1)&nbsp;...............................</td>
								<td width="141">&nbsp;</td>
							  <td width="98">&nbsp;</td>
						  </tr>
							<tr>
								<td align="center">8</td>
								<td>Rujukan Intern Ke</td>
								<td>:&nbsp;6) Poli : </td>
								<td>&nbsp;</td>
								<td>2)&nbsp;...............................</td>
								<td>2)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp; 7) Poli : </td>
								<td>&nbsp;</td>
								<td>3)&nbsp;...............................</td>
								<td>3)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center">9</td>
								<td>&nbsp;Jaminan Pelayanan Luar Paket</td>
								<td>:&nbsp;8)</td>
								<td>&nbsp;</td>
								<td>4)&nbsp;...............................</td>
								<td>4)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp; 9)</td>
								<td>&nbsp;</td>
								<td>5)&nbsp;...............................</td>
								<td>5)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>6)&nbsp;...............................</td>
								<td>6)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>7)&nbsp;...............................</td>
								<td>7)&nbsp;...............................</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>8)&nbsp;...............................</td>
								<td>8)&nbsp;...............................</td>
								<td>8)&nbsp;...............................</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>9)&nbsp;...............................</td>
								<td>9)&nbsp;...............................</td>
								<td>9)&nbsp;...............................</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center">10</td>
								<td>&nbsp;Catatan Khusus</td>
								<td colspan="6">:&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="center">Verifikator PT. Askes</td>
								<td>&nbsp;</td>
								<td colspan="2" align="center">Petugas PT. Askes di RS</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td height="50" valign="bottom" align="center">( ............................. )</td>
								<td>&nbsp;</td>
								<td colspan="2" valign="bottom" align="center">( ............................... )</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="2" style="font-weight:bold;">&nbsp;BERKAS TIDAK DIBAWA PULANG</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr id="trTombol">
				    <td colspan="4" class="noline" align="center">
					   <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
					   <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
				    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/JavaScript">
	/*try{
	formatKartu();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	}*/
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            //if(confirm('Anda yakin mau mencetak Kartu Pasien ini?')){
                window.print();
                window.close();
            //}
            //else{
                //tombol.style.visibility='visible';
				//header.style.visibility='visible';
				//header1.style.visibility='visible';
            //}
	    /*try{
		    mulaiPrint();		  
	    }
	    catch(e){
		    window.print();
	    }
	    */
        }
    }
</script>
<?php
mysql_close($konek);
?>
