<form id="persetujuan_transfusi" name="persetujuan_transfusi" action="action.php" method="post">
	<table width=100% cellspacing=5 cellpadding=0 style='font-size:13px;'>
		<tr>
			<td width=200>&nbsp;</td>
			<td width=230 style='padding-left:5px;'>Produk darah yang akan ditransfusikan : </td>
			<td>
				<input type="radio" id="setuju" name="status" value="1" checked />
				<label for="setuju">Setuju</label>
				<input type="radio" id="tidaksetuju" name="status" value="0" />
				<label for="tidaksetuju">Tidak Setuju</label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan=2 style='padding-left:5px;'>
				Saksi Pertama
				<span style='padding-left:30px;'>
					<input type="text" id="saksi_satu" name="saksi_satu" />
				</span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan=2 style='padding-left:5px;'>
				Saksi Kedua
				<span style='padding-left:43px;'>
					<input type="text" id="saksi_dua" name="saksi_dua" />
				</span>
			</td>
		</tr>
		<tr>
			<td colspan=3 align=center>
				<input type="hidden" id="idKunj" name="idKunj" value="<?=$_REQUEST['idKunj']?>" />
				<input type="hidden" id="idPel" name="idPel" value="<?=$_REQUEST['idPel']?>" />
				<input type="hidden" id="idUsr" name="idUsr" value="<?=$_REQUEST['idUsr']?>" />
				<input type="hidden" id="act" name="act" value="save" />
                <input type="hidden" id="act2" name="act2" value="save" />
				<input type="hidden" id="transfusi_id" name="transfusi_id" />
				<?php
                    if($_REQUEST['report']!=1){
					?><input type="button" id="btnTambah" value="Tambah" onclick="prosesTransfusi()" /><?php }?>
				&nbsp;&nbsp;
				<input type="button" value="Batal" onclick="resetForm()" />
			</td>
		</tr>
	</table>
</form>