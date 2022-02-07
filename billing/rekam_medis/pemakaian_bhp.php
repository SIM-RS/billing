<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="850" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="120">&nbsp;</td>
    <td width="7">&nbsp;</td>
    <td width="711">&nbsp;</td>
  </tr>
  <tr style="display:none">
    <td>Nama Bahan </td>
    <td>:</td>
    <td>
	<input type="text" name="nama_bahan" id="nama_bahan" size="70" class="txtinput" onkeyup="suggestObat_bhp(event,this);" autocomplete="off"/>
	<input type="hidden" name="id_bhp" id="id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="penerimaan_id_bhp" id="penerimaan_id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="obat_id_bhp" id="obat_id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="unit_id_terima_bhp" id="unit_id_terima_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="kepemilikan_id_bhp" id="kepemilikan_id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="unit_id_bhp" id="unit_id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="kso_id_bhp" id="kso_id_bhp" size="10" class="txtinput"/>
	
	<input type="hidden" name="tggl_bhp" id="tggl_bhp" size="10" class="txtinput"/>
	<!--<input type="hidden" name="tggl_act_bhp" id="tggl_act_bhp" size="10" class="txtinput" />-->
	<input type="hidden" name="pelayanan_id_bhp" id="pelayanan_id_bhp" size="10" class="txtinput"/>
	<input type="hidden" name="no_pas" id="no_pas" size="10" class="txtinput"/>
	<input type="hidden" name="nama_pas" id="nama_pas" size="10" class="txtinput"/>
	<input type="hidden" name="alamat_pas" id="alamat_pas" size="10" class="txtinput"/>
	
	<input type="hidden" name="h_satuan" id="h_satuan" size="10" class="txtinput"/>
	<!--<input type="text" name="h_total" id="h_total" size="10" class="txtinput"/>-->
	<input type="hidden" name="user_act_bhp" id="user_act_bhp" size="10" class="txtinput"/>
	
    <div id="divobat_bhp" align="left" style="position:absolute; z-index:1; height: 230px; width:400px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>	</td>
  </tr>
  <tr style="display:none">
    <td>Jumlah</td>
    <td>:</td>
    <td><input type="text" name="jumlah_bhp" id="jumlah_bhp" size="10" class="txtinput" style="text-align:right;" /></td>
  </tr>
  <tr style="display:none">
    <td>Keterangan</td>
    <td>:</td>
    <td><input type="text" name="keterangan_bhp" id="keterangan_bhp" size="50" class="txtinput" /></td>
  </tr>
  <tr style="visibility:collapse">
    <td>Status</td>
    <td>:</td>
    <td><div id='show_status_bhp'><input name="status_bhp" type="checkbox" id="status_bhp" onclick="ganti_status_bhp(this.value)" value="0" />
    Aktif</div></td>
  </tr>
  <tr style="display:none">
    <td height="37">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" id="btnSimpan_bhp" name="btnSimpan_bhp" value="Tambah" onclick="simpan_bhp(this.value);" class="tblTambah"/>
				<input type="button" id="btnHapus_bhp" name="btnHapus_bhp" value="Hapus" onclick="hapus_bhp(this.value);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatal_bhp" name="btnBatal_bhp" value="Batal" onclick="batal_bhp()" class="tblBatal"/></td>
  </tr>
  
  <tr>
    <td colspan="3" align="center" style="height:auto;">
	<div id="gridbox_bhp" style="width:850px; height:165px; background-color:white; margin-bottom:10px;"></div><br />
	<div id="paging_bhp" style="width:850px;"></div>	</td>
  </tr>
</table>
<br />
                                        
</body>
</html>
