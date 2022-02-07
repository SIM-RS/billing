<?php
	include ("../koneksi/konek.php");
	$idKunj = $_REQUEST['idKunj'];
	$idPel = $_REQUEST['idPel'];
	$idUser = $_REQUEST['idUser'];

	$act = 'Save';
	
	$sqlcek = "select * from b_list_terima_pasien where kunjungan_id = '$idKunj' AND pelayanan_id = '$idPel'";
	$cek = mysql_num_rows(mysql_query($sqlcek));
	
	if($cek >= 1){
		$isi = mysql_fetch_array(mysql_query($sqlcek));
		$idlist = $isi['id'];
		$PIRI = explode(',',$isi['PIRI']);
		$KRK = explode(',',$isi['KRK']);
		$tatib = explode(',',$isi['tatib']);
		$fasilitas = explode(',',$isi['fasilitas']);
		$houseping = $isi['houseping'];
		$jdw_mkn = $isi['jdw_mkn'];
		$act = 'Update';
	}
?>
		<style type="text/css">
			#flistterima table{
				border-collapse:collapse;
			}
			#flistterima table label{
				display:block;
				padding-left:10px;
			}
			#flistterima tr:hover{
				background:#ececec;
			}
		</style>
		<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />
		<img alt="close" src="../icon/x.png" width="32" onclick="closeDivCheckListTerima()" style="float:right;cursor: pointer" />
		<fieldset>			
			<legend align="left">
				<b>CHECK LIST PENERIMAAN PASIEN</b> [<input type="checkbox" name="checkall" id="checkall" value="1" onclick="checkAllterima('flistterima',true)"/><label for="checkall">Check All</label> ] [ <?php if($_REQUEST['report']!=1){?><a href="#" style="text-decoration:none;" onclick="checkAllterima('flistterima',false); return false;">Uncheck All</a><?php }else{?><a href="#" style="text-decoration:none;">Uncheck All</a><?php }?> ]
			</legend>
			<form action="../report_rm/9.action_lpp.php" method="POST" id="flistterima" name="flistterima">
			<div style="float:left; width:48%; padding:5px; display:block;">
				<input type="hidden" name="idKunj" id="idKunj" value="<?=$idKunj?>"/>
				<input type="hidden" name="idPel" id="idPel" value="<?=$idPel?>"/>
				<input type="hidden" name="inap" id="inap" value="<?=$inap?>"/>
				<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>"/>
				<input type="hidden" name="idlist" id="idlist" value="<?=$idlist?>"/>
				<input type="hidden" name="act" id="act" value="<?=$act?>"/>
				<table style="line-height:1.5em; width:100%;">
					<tr>
						<td colspan="2" style="border:1px solid #000; padding:5px;">Pemberian Informasi Rawat Inap</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="PIRI[1]" id="PIRI1" value="1" <?=($PIRI[0]==1)?'checked':'';?>/></td>
						<td>
							<label for="PIRI1">Informasi tentang hak dan kewajiban pasien<br/>
							(lembar informasi hak dan kewajiban pasien  dapat dibaca pada masing-masing ruangan pasien)</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="PIRI[2]" id="PIRI2" value="1" <?=($PIRI[1]==1)?'checked':'';?>/></td>
						<td>
							<label for="PIRI2">Informasi tentang perawat yang merawat hari ini<br/>
							(Keterangan nama perawat yang bertugas terletak pada dinding dekat tempat tidur pasien)</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="PIRI[3]" id="PIRI3" value="1" <?=($PIRI[2]==1)?'checked':'';?>/></td>
						<td>
							<label for="PIRI3">Informasi tentang catatan perkembangan kondisi pasien, dan rencana asuhan keperawatan/ asuhan Kebidanan</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="PIRI[4]" id="PIRI4" value="1" <?=($PIRI[3]==1)?'checked':'';?>/></td>
						<td>
							<label for="PIRI4">Informasi tentang waktu konsultasi</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="PIRI[5]" id="PIRI5" value="1" <?=($PIRI[4]==1)?'checked':'';?>/></td>
						<td>
							<label for="PIRI5">Informasi tentang persiapan pasien pulang</label>
						</td>
					</tr>	
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>					
					<tr>
						<td colspan="2" style="border:1px solid #000; padding:5px;">Kegiatan Rutin Keperwatan</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="KRK[1]" id="KRK1" value="1" <?=($KRK[0]==1)?'checked':'';?>/></td>
						<td>
							<label for="KRK1">Waktu pemberian obat sesuai jadwal</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="KRK[2]" id="KRK2" value="1" <?=($KRK[1]==1)?'checked':'';?>/></td>
						<td>
							<label for="KRK2">Check infus setiap 2 jam (bila terpasang infus) sesuai dengan kondisi pasien</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="KRK[3]" id="KRK3" value="1" <?=($KRK[2]==1)?'checked':'';?>/></td>
						<td>
							<label for="KRK3">Observasi tanda-tanda vital 3 x sehari atau sesuai kondisi pasien</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="KRK[4]" id="KRK4" value="1" <?=($KRK[3]==1)?'checked':'';?>/></td>
						<td>
							<label for="KRK4">Jadwal memandikan pasien 2 x sehari jam 05.00 WIB dan Jam 16.00 WIB</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="KRK[5]" id="KRK5" value="1" <?=($KRK[4]==1)?'checked':'';?>/></td>
						<td>
							<label for="KRK5">Jadwal ganti linen kelas 1,2,3, 3 kali seminggu (sarung bantal dan stick taken setiap hari) untuk VIP, VVIP, dan President Suite diganti setiap hari</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td width="10px" valign="center" style="border:1px solid #000; border-right:0px;"><input type="checkbox" name="jdw_mkn" id="jdw_mkn" value="1" <?=($jdw_mkn==1)?'checked':'';?>/></td>
						<td style="border:1px solid #000; border-left:0px;"><label for="jdw_mkn">Jadwal makan, Snack dan adanya menu pilihan untuk kelas 1, VIP, VVIP, dan President Suite</td>
					</tr>
				</table>
			</div>
			<div style="float:right; width:48%; padding:5px; display:block;">
				<table style="line-height:1.5em; width:100%;">
					<tr>
						<td colspan="2" style="border:1px solid #000; padding:5px;">Tata tertib ruang rawat inap, antara lain:</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[1]" id="tatib1" value="1" <?=($tatib[0]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib1">Jam berkunjung keluarga :<br />			  	  	
							Pagi : 11.00 - 13.00 WIB <br />
							Sore : 18.00 - 20.00 WIB</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[2]" id="tatib2" value="1" <?=($tatib[1]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib2">Selama dalam masa perawatan, pasien harus menggunakan gelang identitas pasien</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[3]" id="tatib3" value="1" <?=($tatib[2]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib3">Dilarang merokok dilingkungan Rumah Sakit</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[4]" id="tatib4" value="1" <?=($tatib[3]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib4">Keluarga/penunggu pasien tidak diperkenakan duduk diatas tempat tidur</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[5]" id="tatib5" value="1" <?=($tatib[4]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib5">Tidak diperkenankan membawa dan menyimpan barang berharga, alat elektronik, tikar, kasur, bantal dll (Resiko kehilangan ditanggung pasien/keluarga)</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="tatib[6]" id="tatib6" value="1" <?=($tatib[5]==1)?'checked':'';?>/></td>
						<td>
							<label for="tatib6">Setiap pasien mendapatkan kartu penunggu (1 orang) kecuali VIP, VVIP, President Suite, khususnya ruangan bayi dan perinatologi tidak diperkenankanmenunggu didalam ruangan</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td width="10px" valign="center" style="border:1px solid #000; border-right:0px;"><input type="checkbox" name="houseping" id="houseping" value="1" <?=($houseping==1)?'checked':'';?>/></td>
						<td style="border:1px solid #000; border-left:0px;"><label for="houseping">Kegiatan rutin house keeping: kebersihan ruangan (menyapu, mengepel, membuang sampah, mengantar koran)</label></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" style="border:1px solid #000; padding:5px;">Mengorientasikan fasilitas ruangan dan cara penggunaannya fasilitas kamar seperti:</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="fasilitas[1]" id="fasilitas1" value="1" <?=($fasilitas[0]==1)?'checked':'';?>/></td>
						<td>
							<label for="fasilitas1">Cara pemakaian tempat tidur, telepon dan remote TV, lampu tidur, lemari pakaian</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="fasilitas[2]" id="fasilitas2" value="1" <?=($fasilitas[1]==1)?'checked':'';?>/></td>
						<td>
							<label for="fasilitas2">Cara penggunaan bel pasien dan bel keadaan darurat dikamar mandi dan kamar pasien</label>
						</td>
					</tr>
					<tr>
						<td width="10px" valign="center"><input type="checkbox" name="fasilitas[3]" id="fasilitas3" value="1" <?=($fasilitas[2]==1)?'checked':'';?>/></td>
						<td>
							<label for="fasilitas3">Cara penggunaan shower dikamar mandi (air panas dan dingin)</label>
						</td>
					</tr>
				</table>
			</div>
			<div style="clear:both;"></div>
			<center style="margin-top:5px;">
				<?php
                    if($_REQUEST['report']!=1){
					?><input type="button" value="<?=$act?>" name="simpanlist" id="simpanlist" onclick="prosesListTerima()" />
				<button name="batallist" id="batallist" onclick="closeDivCheckListTerima(); return false;">Batal</button><?php }?>
				<button name="cetak" id="cetak" onclick="cetakListTerima(); return false;">Cetak</button>
			</center>
			</form>
		</fieldset>
<?php if($_REQUEST['report']==1){?>
<script> 
	jQuery('#checkall').attr("disabled", "true");
	jQuery('#PIRI1').attr("disabled", "true");
	jQuery('#PIRI2').attr("disabled", "true");
	jQuery('#PIRI3').attr("disabled", "true");
	jQuery('#PIRI4').attr("disabled", "true");
	jQuery('#PIRI5').attr("disabled", "true");
	jQuery('#KRK1').attr("disabled", "true");
	jQuery('#KRK2').attr("disabled", "true");
	jQuery('#KRK3').attr("disabled", "true");
	jQuery('#KRK4').attr("disabled", "true");
	jQuery('#KRK5').attr("disabled", "true");
	jQuery('#jdw_mkn').attr("disabled", "true");
	jQuery('#tatib1').attr("disabled", "true");
	jQuery('#tatib2').attr("disabled", "true");
	jQuery('#tatib3').attr("disabled", "true");
	jQuery('#tatib4').attr("disabled", "true");
	jQuery('#tatib5').attr("disabled", "true");
	jQuery('#tatib6').attr("disabled", "true");
	jQuery('#houseping').attr("disabled", "true");
	jQuery('#fasilitas1').attr("disabled", "true");
	jQuery('#fasilitas2').attr("disabled", "true");
	jQuery('#fasilitas3').attr("disabled", "true");
</script>
<?php }?>