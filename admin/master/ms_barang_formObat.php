<style>
input,select,textarea{
padding:3px 4px;
border:1px solid #999999;
font:11px Verdana, Arial, Helvetica, sans-serif;
}
</style>
<script src="../js/jquery.form.js"></script>
<form id="form_obat" name="form_obat" method="POST" action="ms_barang_formObat_act.php">
<table width="638" border="0" cellpadding="1" cellspacing="1" class="txtinput" style="font:11px Verdana, Arial, Helvetica, sans-serif" align="center">
        <tr> 
          <td width="216">Kode Obat / Alkes </td>
          <td width="10">:</td>
          <td width="464" >
		  <input name="obat_id" id="obat_id" type="hidden" size="10" />
		  <input name="obat_kode" type="text" id="obat_kode" class="txtinput" size="10">
		  <input name="act2" id="act2" type="hidden">
		  </td>
        </tr>
        <tr> 
          <td>Nama Obat / Alkes </td>
          <td>:</td>
          <td ><input name="obat_nama" type="text" id="obat_nama" class="txtinput" size="38" ></td>
        </tr>
        <tr> 
          <td>Dosis</td>
          <td>:</td>
          <td ><input name="obat_dosis" type="text" id="obat_dosis" class="txtinput" size="50"></td>
        </tr>
        <tr> 
          <td>Satuan Kecil </td>
          <td>:</td>
          <td> <select name="obat_satuan_kecil" id="obat_satuan_kecil">
              <?php
			$qry = "select * from $rspelindo_db_apotek.a_satuan";
			$exe = mysql_query($qry);
			while($show= mysql_fetch_array ($exe)){
			?>
              <option value="<?=$show['SATUAN'];?>"><?php echo $show['SATUAN'];?></option>
              <? }?>
            </select> </td>
        </tr>
        <!--tr>
        <td>Isi Per-Kemasan Besar </td>
        <td>:</td>
        <td ><input name="isi_satuan_kecil" type="text" id="isi_satuan_kecil" class="txtinput" size="10" ></td>
      </tr-->
        <tr> 
          <td>Bentuk</td>
          <td>:</td>
          <td> <select name="obat_bentuk" id="obat_bentuk">
              <?
	  	$qry = "select * from $rspelindo_db_apotek.a_bentuk";
	  	$exe = mysql_query($qry);
	  	while($show= mysql_fetch_array ($exe)){
	  	?>
              <option value="<?=$show['BENTUK'];?>"> 
              <?=$show['BENTUK'];?>
              </option>
              <? }?>
            </select> </td>
        </tr>
        <tr> 
          <td><span onClick="tampil1();" style="color:#00F; cursor:pointer;"><u>Kelas Terapi</u></span></td>
          <td>:</td>
          <td > <input type="hidden" name="kls_id" id="kls_id" value="<?=$_POST[kls_id];?>"> 
            <input type="text" name="kls_nama" id="kls_nama" class="txtinput" value="<?=$_POST[kode_kls_induk];?>"readonly> 
            <input type="button" name="Button" value="..." class="txtcenter" title="Pilih Kelas" onClick="OpenWnd('../master/tree_kls_diobat.php?par=kls_id*kls_nama',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kls_id*-**|*kls_nama*-*')">          </td>
        </tr>
        <tr> 
          <td>Kategori Obat / Alkes </td>
          <td>:</td>
          <td> <select name="obat_kategori" id="obat_kategori" onChange="if (this.value==1 || this.value==2 ||this.value==4){document.forms[1].btnPaten.disabled='';}else{document.forms[1].id_paten.value='0';document.forms[1].kode_paten.value='';document.forms[1].btnPaten.disabled='disabled';}">
		  <?php 
		  $sql="SELECT * FROM $rspelindo_db_apotek.a_obat_kategori";
		  $rs=mysql_query($sql);
		  while ($rows=mysql_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['id']; ?>"><?php echo $rows['kategori']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Golongan</td>
          <td>:</td>
          <td> <select name="obat_golongan" id="obat_golongan">
          <option value="0">-</option>
		  <?php 
		  $sql="SELECT * FROM $rspelindo_db_apotek.a_obat_golongan";
		  $rs=mysql_query($sql);
		  while ($rows=mysql_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['kode']; ?>"><?php echo $rows['golongan']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Tipe Obat/Alkes </td>
          <td>:</td>
          <td><select name="habis_pakai" id="habis_pakai">
              <option value="1">Habis Pakai</option>
              <option value="0">Tidak Habis Pakai</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Jenis Obat</td>
          <td>:</td>
          <td><select name="jenis_obat" id="jenis_obat">
		  <?php 
		  $sql="SELECT * FROM $rspelindo_db_apotek.a_obat_jenis";
		  $rs=mysql_query($sql);
		  while ($rows=mysql_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>"><?php echo $rows['obat_jenis']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr style="display:none;">
          <td>Generik/Paten Sejenis </td>
          <td>:</td>
          <td ><input type="hidden" name="id_paten" id="id_paten" value="0"><input name="kode_paten" type="text" id="kode_paten" class="txtinput" size="38" readonly />
          <input type="button" name="btnPaten" value="..." class="txtcenter" title="Pilih Obat Paten-nya" onClick="OpenWnd('../master/ms_obat_paten.php?par=id_paten*kode_paten&id_paten='+document.forms[0].id_paten.value,750,350,'mspaten',true)"></td>
        </tr>
        <tr> 
          <td>Status Obat</td>
          <td>:</td>
          <td> <select name="obat_isaktif" id="obat_isaktif">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select> </td>
        </tr>
        <tr>
          <td height="30">&nbsp;</td>
          <td>&nbsp;</td>
          <td>
		  <input type="button" name="proses" id="proses" value="Simpan" onClick="cek_obat()"/> 
		  <input type="button" name="batal" id="batal" value="Batal" onClick="batal_obat()"/> </td>
        </tr>
</table>
</form>
<script>




function kode_baru()
{
	/*$.get("ms_barang_obatkode.php",function(data){
	$("#obat_kode").val(data);
	})*/
}
function tambah2()
{
	clear_form();
	kode_baru();
	$("#div_obat").slideDown(500);
	$("#div_obat2").slideUp(500);
	$("#act2").val('save');
}
function ubah2()
{
	$("#div_obat").slideDown(500);
	$("#div_obat2").slideUp(500);
	$("#act2").val('edit');
}
function hapus2()
{
	if (confirm('Apakah anda yakin?'))
	{
		$("#act2").val('delete');
		proses();
	}
}
function cek_obat()
{
	if (ValidateForm('obat_kode,obat_nama,obat_satuan_kecil,obat_bentuk','ind'))
	{
		proses();
	}
}
function batal_obat()
{
	$("#div_obat").slideUp(500);
	$("#div_obat2").slideDown(500);
}
function proses()
{
	
		//document.form1.submit();}
		$("#form_obat").ajaxSubmit
		({
		  //target: "#pesan",
		  success:function(msg)
		  {		
		  	//alert(msg)
			ri2.loadURL("ms_barangF_util.php?tipe=3");  
			batal_obat();
			clear_form();
				//hide_form();

		  },
		  //resetForm:true
		});
		return false;
}

function clear_form()
{
	$("#obat_id").val('');
	$("#obat_kode").val('');
	$("#obat_nama").val('');
	$("#obat_dosis").val('');
	$("#kls_id").val('');
	$("#act2").val('');
	$("#obat_isaktif").val(1);
}


</script>