<?php	
	include '../../koneksi/konek.php';
	$idKunjCheckList = $_REQUEST['idKunjCheckList'];
	$idPelCheckList = $_REQUEST['idPelCheckList'];
	$idUserCheckList = $_REQUEST['idUserCheckList'];
	
	$sqlEdit = "SELECT * FROM b_list_pasien_pulang WHERE pelayanan_id = '{$idPelCheckList}' AND kunjungan_id = '{$idKunjCheckList}' ";
	$rowEdit = mysql_fetch_array(mysql_query($sqlEdit));
	$cekEdit = mysql_num_rows(mysql_query($sqlEdit));
	
	$adminPulang = explode(',',$rowEdit['administrasi']);
	$ruangPulang = explode(',',$rowEdit['fasilitas']);
	
?>
<table width=800 border=0 align=center style='border:collapse:collapse; background:#FFF;'>
	<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />
	<tr>
		<td style='font:bold 16px tahoma; text-align:center; padding-top:10px;'>
			<div align=center>CHECK LIST PASIEN PULANG</div>
			<div style='position:absolute; margin-top:-30px; margin-left:770px;'>
				<img alt="close" src="../icon/x.png" width="32" onclick="closeDivCheckList()" style="float:right; cursor:pointer" />
			</div>
		</td>
	</tr>
	<tr>
		<td align=center style='padding-bottom:10px;'>
			<form id="checkListPasien" name="checkListPasien" action="list_pasien_pulang/action_list_pasien_pulang.php" method="post">
				<table width=100% cellspacing=0 cellpadding=0 style='border:.5pt solid windowtext; border-collapse:collapse; font:12px tahoma;'>
					<tr>
						<td colspan=6 align=center style='font-weight:bold; padding-top:5pt; padding-bottom:5pt;'>PASIEN PULANG</td>
					</tr>
					<tr>
						<td class=head colspan=2>ADMINISTRASI</td>
						<td class=head colspan=4>PENGECEKAN FASILITAS RUANGAN :</td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="IJIN" name="ADMIN[1]" value="1" <?=($adminPulang[0]==1)?'checked':''?> /></td>
						<td width=40%><label style="cursor:pointer;" for="IJIN">Ijin pulang dari dokter yang merawat</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="BED" name="RUANG[1]" value="1" <?=($ruangPulang[0]==1)?'checked':''?> /></td>
						<td width=20%><label style="cursor:pointer;" for="BED">Bed</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="RUBBER" name="RUANG[9]" value="1" <?=($ruangPulang[8]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="RUBBER">Rubber Sheet</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="INPUT" name="ADMIN[2]" value="1" <?=($adminPulang[1]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="INPUT">Input ke komputer: pasien rencana pulang</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="TV" name="RUANG[2]" value="1" <?=($ruangPulang[1]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="TV">TV/VCD/ Remote</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="DRAW" name="RUANG[10]" value="1" <?=($ruangPulang[9]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="DRAW">Draw Sheet</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="STOCK" name="ADMIN[3]" value="1" <?=($adminPulang[2]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="STOCK">Stock order diet</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="NURSE" name="RUANG[3]" value="1" <?=($ruangPulang[2]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="NURSE">Nurse Call</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="BLANKETST" name="RUANG[11]" value="1" <?=($ruangPulang[10]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="BLANKETST">Blanket Sheet</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="RETURE" name="ADMIN[4]" value="1" <?=($adminPulang[3]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="RETURE">Reture obat jika ada</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="TELP" name="RUANG[4]" value="1" <?=($ruangPulang[3]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="TELP">Telepon/internet</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="BLANKET" name="RUANG[12]" value="1" <?=($ruangPulang[11]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="BLANKET">Blanket</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="OBAT" name="ADMIN[5]" value="1" <?=($adminPulang[4]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="OBAT">Menyiapkan obat pulang</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="AC" name="RUANG[5]" value="1" <?=($ruangPulang[4]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="AC">AC</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="PILLOW" name="RUANG[13]" value="1" <?=($ruangPulang[12]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="PILLOW">Pillow</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="SURAT" name="ADMIN[6]" value="1" <?=($adminPulang[5]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="SURAT">Surat keterangan sakit</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="WC" name="RUANG[6]" value="1" <?=($ruangPulang[5]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="WC">Kamar Mandi, WC</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="PILLOWSP" name="RUANG[14]" value="1" <?=($ruangPulang[13]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="PILLOWSP">Pillowslip</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="RESUME" name="ADMIN[7]" value="1" <?=($adminPulang[6]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="RESUME">Resume pasien pulang</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="KULKAS" name="RUANG[7]" value="1" <?=($ruangPulang[6]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="KULKAS">Kulkas</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="PAJAMA" name="RUANG[15]" value="1" <?=($ruangPulang[14]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="PAJAMA">Pajama/Gown</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="KARTU" name="ADMIN[8]" value="1" <?=($adminPulang[7]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="KARTU">Kartu lunas pembayaran</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="LARGE" name="RUANG[8]" value="1" <?=($ruangPulang[7]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="LARGE">Large sheet</label></td>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="SOFA" name="RUANG[16]" value="1" <?=($ruangPulang[15]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="SOFA">Sofa/Furniture</label></td>
					</tr>
					<tr>
						<td class=isi><input type="checkbox" style="cursor:pointer;" id="ANTAR" name="ADMIN[9]" value="1" <?=($adminPulang[8]==1)?'checked':''?> /></td>
						<td><label style="cursor:pointer;" for="ANTAR">Mengantar pasien keluar RS</label></td>
						<td colspan=4></td>
					</tr>
					<tr>
						<td class=isi colspan=6>
							<span style='position:absolute;'>Keterangan</span>
							<textarea name="ketListPulang" id="ketListPulang" cols="80" rows="2" style='margin-left:70px;'><?=$rowEdit['keterangan']?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan=6 style='padding-top:5pt; padding-bottom:5pt; text-align:center; font-weight:bold;'>
							<a href="#" style='text-decoration:none;' onclick="SetAllCheckBoxes('checkListPasien', true);return false">Check ALL</a>
							&nbsp;/&nbsp;
							<a href="#" style='text-decoration:none;' onclick="SetAllCheckBoxes('checkListPasien', false);return false">Uncheck ALL</a>
						</td>
					</tr>
					<tr>
						<td colspan=6 style='padding-bottom:5pt; text-align:center; font-weight:bold;'>
							<input type="hidden" name="idKunjCheckList" id="idKunjCheckList" value="<?=$idKunjCheckList?>"/>
							<input type="hidden" name="idPelCheckList" id="idPelCheckList" value="<?=$idPelCheckList?>"/>
							<input type="hidden" name="idUserCheckList" id="idUserCheckList" value="<?=$idUserCheckList?>"/>
							<input type="hidden" id="actCheckList" name="actCheckList" value="<?=($cekEdit == 0)?'save':'edit'?>" />
							<input type="button" value="<?=($cekEdit == 0)?'Save':'Update'?>" onclick="prosesCheckList()" />&nbsp;
							<input type="button" value="Cancel" onclick="closeDivCheckList()" />&nbsp;
							<input type="button" value="Cetak" onclick="reportCheckList()" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>