<?
include('../../koneksi/konek.php');
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`, pg.`id` AS id_user, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama, ' Kecamatan ',wi.nama),'-') AS almt_lengkap
FROM b_pelayanan pl
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id  
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.dokter_tujuan_id
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'"; //$idPel
$dP=mysql_fetch_array(mysql_query($sqlP));

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->
    
        <title>.: PERMINTAAN PELAYANAN GIZI :.</title>
        <style>
        body{background:#FFF;}
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
        </style>
    </head>

<body onload="biasa(false);tim(false);lunak(false);saring(false);cair(false);puasa(false);">
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="tampil_input" align="center" style="display:none;">
    <form id="form_gizi" name="form_gizi">
    	<input type="hidden" id="act" name="act" value="hapus" /> 
		<input type="hidden" id="id" name="id" />
        <table align="center" cellpadding="2" cellspacing="0" style="border-collapse:collapse; border:1px solid #000000;">
          <col width="40" />
          <col width="55" />
          <col width="64" span="9" />
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="6" rowspan="10">
              <table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
                <tr>
                  <td width="135"><strong>Nama Pasien</strong></td>
                  <td colspan="2">:
                    <?=$dP['nama'];?></td>
                  <td width="99">&nbsp;</td>
                  </tr>
                <tr>
                  <td><strong>Tanggal Lahir</strong></td>
                  <td width="68">:
                    <?=tglSQL($dP['tgl_lahir']);?></td>
                  <td width="76">Usia</td>
                  <td>:
                     <?=$dP['usia'];?>
                    Thn</td>
                </tr>
                <tr>
                  <td><strong>No. RM</strong></td>
                  <td>:
                    <?=$dP['no_rm'];?>                  </td>
                  <td>No Registrasi </td>
                  <td>:<?=$dP['no_reg'];?></td>
                </tr>
                <tr>
                    <td><strong>Ruang Rawat/Kelas</strong></td>
                    <td colspan="2">:
                      <?=$dP['nm_unit'];?>
                      / <?=$dP['nm_kls'];?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td colspan="3">:
                      <?=$dP['almt_lengkap'];?></td>
                </tr> 	
                <tr>
                    <td colspan="4"><center><strong>(Tempelkan Sticker Identitas Pasien)</strong></center></td>
                </tr>
                </table></td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td width="54">&nbsp;</td>
            <td width="88">&nbsp;</td>
            <td width="19">&nbsp;</td>
            <td width="19">&nbsp;</td>
            <td width="19">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><strong>PEMERINTAH KOTA    MEDAN</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><strong>RUMAH SAKIT PELINDO I</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><strong>PERMINTAAN&nbsp; PELAYANAN GIZI</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="12" style="border-top:#000 1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" valign="top"><strong>Alergi    / Pantangan Makanan   :</strong></td>
            <td colspan="7"><div style="display:none"><textarea name="pantangan" id="pantangan" cols="60" rows="5"></textarea></div>
            <?php 
				$sqlA="SELECT * from b_riwayat_alergi
				WHERE pasien_id='".$dP['id']."';";//$idPel
				$exA=mysql_query($sqlA);
				while($dA=mysql_fetch_array($exA)){?>
         			<?=$dA['riwayat_alergi'].'<br>'?>
        		<?php }?></td>
            <td width="8">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td colspan="7">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="51"></td>
            <td></td>
            <td width="188"></td>
            <td width="26"></td>
            <td width="230"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><strong>PERMINTAAN</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk1" value="Makan Pasien Baru"/></td>
            <td colspan="3">Makan Pasien Baru</td>
            <td></td>
            <td></td>
            <td width="30"><input type="checkbox" name="permintaan" id="chk2" value="Konsultasi Gizi"/></td>
            <td colspan="2">Konsultasi Gizi</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk3" value="Permintaan Makanan Tambahan Lainnya"/></td>
            <td colspan="5">Permintaan Makanan Tambahan Lainnya</td>
            <td width="30"><input type="checkbox" name="permintaan" id="chk4" value="Perubahan Diet"/></td>
            <td colspan="2">Perubahan Diet</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk5" value="Pasien Pindahan"/>
            <label for="a"></label></td>
            <td colspan="2">Pasien Pindahan</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="8"><strong>Dokter yang merawat : </strong><?=$dP['dr_rujuk'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><strong>BB    : </strong>
				<? 
					if($dP['BB']=="")
					{
						?>
                        <input name="bbN" type="text" id="bbN" size="10"  />
                        <?
					}else{
						echo $dP['BB'];
					}
				?>
             <strong>Kg</strong></td>
            <td>&nbsp;</td>
            <td colspan="3"><strong>TB :</strong>
        		<?
                	if($dP['TB']=="")
					{
						?>
                        <input name="tbN" type="text" id="tbN" size="10"  />
                        <?
					}else{
						echo $dP['TB'];
					}
				?> <strong>cm</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><strong>Diet : </strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_biasa" onclick="biasa(this.checked)"/></td>
            <td>Biasa&nbsp;</td>
            <td height="10" colspan="9"><label for="d"></label>
            <input name="text_biasa" type="text" id="text_biasa" size="50"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_tim" onclick="tim(this.checked)"/></td>
            <td>Tim</td>
            <td colspan="9"><input name="text_tim" type="text" id="text_tim" size="50" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_lunak" onclick="lunak(this.checked)"/></td>
            <td>Lunak</td>
            <td colspan="9"><input name="text_lunak" type="text" id="text_lunak" size="50" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_saring" onclick="saring(this.checked)"/></td>
            <td>Saring</td>
            <td colspan="9"><input name="text_saring" type="text" id="text_saring" size="50"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_cair" onclick="cair(this.checked)"/></td>
            <td>Cair</td>
            <td colspan="9"><input name="text_cair" type="text" id="text_cair" size="50"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_puasa" onclick="puasa(this.checked)"/></td>
            <td>Puasa</td>
            <td colspan="9"><input name="text_puasa" type="text" id="text_puasa" size="50" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_penunggu" value="x" /></td>
            <td colspan="4">Bebas Penunggu / Makan Penunggu</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><strong>DIAGNOSA    :</strong></td>
            <td colspan="9">
            	<?php 
				$sqlD="SELECT IFNULL(md.nama,d.diagnosa_manual) AS nama FROM b_diagnosa d
				LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
				LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
				WHERE d.kunjungan_id='$idKunj';";//$idPel
				$exD=mysql_query($sqlD);
				while($dD=mysql_fetch_array($exD)){?>
         			<?=$dD['nama'].'<br>'?>
        		<?php }?>  
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><strong>Keterangan    :</strong></td>
            <td colspan="9" rowspan="2"><textarea name="keterangan" id="keterangan" cols="60" rows="5"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Medan, <?=date('j ').getBulan(date('m')).date(' Y')?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Pukul    : <? echo date("h:i:s"); ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">Bagian Gizi Yang Menerima</td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Perawat Ruangan,</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">(Paraf dan Nama Jelas)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>(Paraf dan Nama Jelas)</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;
                <input type="button" name="simpen" id="simpen" class="tblTambah" value="Simpan" onclick="simpan2(this.form);document.getElementById('tampil_input').style.display='none'"/> 
              &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="bersihkan()" class="tblBatal"/>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" class="tblTambah" onclick="document.getElementById('tampil_input').style.display='block';document.getElementById('simpen').lang='simpan';document.getElementById('form_gizi').reset();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" class="tblTambah" onclick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu yang akan diedit.')}else{document.getElementById('tampil_input').style.display='block';return};ambilData();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>    
                     <?php }?>                 </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style=" height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style=""></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>

</div>
</body>
</html>

<script>


function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =rek.getRowId(rek.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("30.permintaanpelayanangizi_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}

function goFilterAndSort(abc){
	if (abc=="gridbox"){
		rek.loadURL("30.permintaanpelayanangizi_util.php?id_pelayanan=<?=$idPel?>&kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
} 

function ambilData(){
	document.getElementById('form_gizi').reset();
	var sisipan=rek.getRowId(rek.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	document.getElementById('pantangan').value=rek.cellsGetValue(rek.getSelRow(),3);
	
	var pilihan=rek.cellsGetValue(rek.getSelRow(),4).split(',');
	for(i=0;i<5;i++){
		if(pilihan[i]=='Makan Pasien Baru'){
			document.getElementById('chk1').checked=true;
		}else if(pilihan[i]=='Konsultasi Gizi'){
			document.getElementById('chk2').checked=true;
		}else if(pilihan[i]=='Permintaan Makanan Tambahan Lainnya'){
			document.getElementById('chk3').checked=true;		
		}else if(pilihan[i]=='Perubahan Diet'){
			document.getElementById('chk4').checked=true;		
		}else if(pilihan[i]=='Pasien Pindahan'){
			document.getElementById('chk5').checked=true;		
		}
	}
	
	$('#text_biasa').val(sisipan[1]);
	if($('#text_biasa').val()!=''){
		document.getElementById('chk_biasa').checked=true;
		document.getElementById('text_biasa').disabled = false;
	}else{
		document.getElementById('text_biasa').disabled = true;
	}
	
	$('#text_tim').val(sisipan[2]);
	if($('#text_tim').val()!=''){
		document.getElementById('chk_tim').checked=true;
		document.getElementById('text_tim').disabled = false;
	}else{
		document.getElementById('text_biasa').disabled = true;
	}
	
	$('#text_lunak').val(sisipan[3]);
	if($('#text_lunak').val()!=''){
		document.getElementById('chk_lunak').checked=true;
		document.getElementById('text_lunak').disabled = false;
	}else{
		document.getElementById('text_lunak').disabled = true;
	}
	
	$('#text_saring').val(sisipan[4]);
	if($('#text_saring').val()!=''){
		document.getElementById('chk_saring').checked=true;
		document.getElementById('text_saring').disabled = false;
	}else{
		document.getElementById('text_saring').disabled = true;
	}
	
	$('#text_cair').val(sisipan[5]);
	if($('#text_cair').val()!=''){
		document.getElementById('chk_cair').checked=true;
		document.getElementById('text_cair').disabled = false;
	}else{
		document.getElementById('text_cair').disabled = true;
	}
	
	$('#text_puasa').val(sisipan[6]);
	if($('#text_puasa').val()!=''){
		document.getElementById('chk_puasa').checked=true;
		document.getElementById('text_puasa').disabled = false;
	}else{
		document.getElementById('text_puasa').disabled = true;
	}
	
	var x = sisipan[7];
	if(x ==1){
		document.getElementById('chk_penunggu').checked = true;
	}else if(x==0){
		document.getElementById('chk_penunggu').checked = false;
	}
	
	var bbN = "<? echo $dP['BB'];?>";
	var tbN = "<? echo $dP['TB'];?>";
	if(bbN=="" && tbN=="")
	{
		document.getElementById("bbN").value = sisipan[9];
		document.getElementById("tbN").value = sisipan[10];
		//alert(bbN+"\n"+tbN);
		//return false;
	}
	
	$('#keterangan').val(sisipan[8]);
	document.getElementById('simpen').lang='update';

for(i=0;i<form.permintaan.length;i++){
		if(form.permintaan[i].checked){
			pilihan = pilihan + form.permintaan[i].value + ',';
		}
	}	
}



function bersihkan(){
	document.getElementById('form_gizi').reset();
	document.getElementById('tampil_input').style.display='none';
}


function biasa(status){
	status=!status;
	document.form_gizi.text_biasa.disabled = status;
	document.getElementById('text_biasa').value='';
}
function tim(status){
	status=!status;
	document.form_gizi.text_tim.disabled = status;
	document.getElementById('text_tim').value='';
}
function lunak(status){
	status=!status;
	document.form_gizi.text_lunak.disabled = status;
	document.getElementById('text_lunak').value='';
}
function saring(status){
	status=!status;
	document.form_gizi.text_saring.disabled = status;
	document.getElementById('text_saring').value='';
}
function cair(status){
	status=!status;
	document.form_gizi.text_cair.disabled = status;
	document.getElementById('text_cair').value='';
}
function puasa(status){
	status=!status;
	document.form_gizi.text_puasa.disabled = status;
	document.getElementById('text_puasa').value='';
}
function penunggu(status){
	status=!status;
	var tunggu = document.getElementById('chk_penunggu').value;
	//alert(tunggu);
}


 var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Permintaan Pelayanan Gizi :.");
        rek.setColHeader("NO,NAMA PASIEN,ALERGI/PANTANGAN,PERMINTAAN,KETERANGAN,TGL INPUT, PENGGUNA");
        rek.setIDColHeader(",nama,pantangan,permintaan,keterangan,tanggal,dr_rujuk");
        rek.setColWidth("30,100,170,200,200,100,100"); //830
        rek.setCellAlign("center,left,center,center,center,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("30.permintaanpelayanangizi_util.php?id_pelayanan=<?=$idPel?>&kode=true&saring=");
        rek.Init();
		
var pilihan='';
function simpan2(form){
	
	for(i=0;i<form.permintaan.length;i++){
		if(form.permintaan[i].checked){
			pilihan = pilihan + form.permintaan[i].value + ',';
		}
	}
	
	//alert(pilihan);
	
	var bbN = "<? echo $dP['BB'];?>";
	var tbN = "<? echo $dP['TB'];?>";
	
	if(bbN=="" && tbN=="")
	{
		bbN = document.getElementById("bbN").value;
		tbN = document.getElementById("tbN").value;
		//alert(bbN+"\n"+tbN);
		//return false;
	}
	
	//alert("berhenti");
	//return false;
	
	var pantangan = $('#pantangan').val();
	var biasa = $('#text_biasa').val();
	var tim = $('#text_tim').val();
	var lunak = $('#text_lunak').val();
	var saring = $('#text_saring').val();
	var cair = $('#text_cair').val();
	var puasa = $('#text_puasa').val();
	//var penunggu =  $('#chk_penunggu').val();
	var keterangan = $('#keterangan').val();
	
	var xx =document.getElementById('chk_penunggu').checked;
	if(xx==true){
		var penunggu =1;
	}else{
		var penunggu =0;
	}
	
	
	
	//alert(pilihan);
	var id = $('#id').val();
	var act = document.getElementById('simpen').lang;
	
	//alert("30.permintaanpelayanangizi_util.php?kode="+true+"&act="+act+"&id="+id+"&pantangan="+pantangan+"&permintaan="+pilihan+"&biasa="+biasa+"&tim="+tim+"&lunak="+lunak+"&saring="+saring+"&cair="+cair+"&puasa="+puasa+"&penunggu="+penunggu+"&keterangan="+keterangan+"&id_pelayanan="+'<?=$idPel ;?>'+"&id_user="+'<?=$dP['id_user'];?>');	
	
	rek.loadURL("30.permintaanpelayanangizi_util.php?kode="+true+"&act="+act+"&id="+id+"&pantangan="+pantangan+"&permintaan="+pilihan+"&biasa="+biasa+"&tim="+tim+"&lunak="+lunak+"&saring="+saring+"&cair="+cair+"&puasa="+puasa+"&penunggu="+penunggu+"&keterangan="+keterangan+"&bbN="+bbN+"&tbN="+tbN+"&id_pelayanan="+'<?=$idPel ;?>'+"&id_user="+'<?=$dP['id_user'];?>','','GET');
	
	bersihkan();
	pilihan='';
}		

function hapus(){
	if(document.getElementById('id').value == '' || document.getElementById('id').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ?'))
			var act =document.getElementById('simpen').lang='hapus';
			var id = $('#id').val();
			alert("30.permintaanpelayanangizi_util.php?kode="+true+"&act="+act+"&id="+id,'','GET');
			rek.loadURL("30.permintaanpelayanangizi_util.php?kode="+true+"&act="+act+"&id="+id+"&id_pelayanan="+'<?=$idPel; ?>','','GET');
			
	}
} 

</script>