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

$id=$_REQUEST['id'];

$sql="SELECT * FROM `b_permintaan_pelayanan_gizi` WHERE id ='$id'";
$data=mysql_fetch_array(mysql_query($sql));	
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

<body onload="permintaan();diet();">
<iframe height="72" width="130" name="sort"
    id="sort"
    src="dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="tampil_input" align="center" style="display:block">
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
            <td colspan="7"><div style="display:none"><textarea name="pantangan" id="pantangan" cols="60" rows="5" disabled="disabled"><? echo $data['pantangan']; ?></textarea></div>
            <?php 
				$sqlA="SELECT * from b_riwayat_alergi
				WHERE pasien_id='".$dP['id']."';";//$idPel
				$exA=mysql_query($sqlA);
				while($dA=mysql_fetch_array($exA)){?>
         			<?=$dA['riwayat_alergi'].'<br>'?>
        		<?php }?>
            </td>
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
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk1" value="Makan Pasien Baru" disabled="disabled"/></td>
            <td colspan="3">Makan Pasien Baru</td>
            <td></td>
            <td></td>
            <td width="30"><input type="checkbox" name="permintaan" id="chk2" value="Konsultasi Gizi" disabled="disabled"/></td>
            <td colspan="2">Konsultasi Gizi</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk3" value="Permintaan Makanan Tambahan Lainnya" disabled="disabled"/></td>
            <td colspan="5">Permintaan Makanan Tambahan Lainnya</td>
            <td width="30"><input type="checkbox" name="permintaan" id="chk4" value="Perubahan Diet" disabled="disabled"/></td>
            <td colspan="2">Perubahan Diet</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="permintaan" id="chk5" value="Pasien Pindahan" disabled="disabled"/>
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
            <td colspan="2"><strong>BB    : </strong><?=$data['bb']; ?> <strong>Kg</strong></td>
            <td>&nbsp;</td>
            <td colspan="3"><strong>TB :</strong>
        <?=$data['tb'];  ?> <strong>cm</strong></td>
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
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_biasa" onclick="biasa(this.checked)" disabled="disabled"/></td>
            <td>Biasa&nbsp;</td>
            <td height="10" colspan="9"><label for="d"></label>
            <input name="text_biasa" type="text" id="text_biasa" size="50" value="<? echo $data['d_biasa'];?>" disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_tim" onclick="tim(this.checked)" disabled="disabled"/></td>
            <td>Tim</td>
            <td colspan="9"><input name="text_tim" type="text" id="text_tim" size="50" value="<? echo $data['d_tim']; ?>" disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_lunak" onclick="lunak(this.checked)" disabled="disabled"/></td>
            <td>Lunak</td>
            <td colspan="9"><input name="text_lunak" type="text" id="text_lunak" size="50" value="<? echo $data['d_lunak']; ?>" disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_saring" onclick="saring(this.checked)" disabled="disabled"/></td>
            <td>Saring</td>
            <td colspan="9"><input name="text_saring" type="text" id="text_saring" size="50" value="<? echo $data['d_saring']; ?>" disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_cair" onclick="cair(this.checked)" disabled="disabled"/></td>
            <td>Cair</td>
            <td colspan="9"><input name="text_cair" type="text" id="text_cair" size="50" value="<? echo $data['d_cair']; ?>" disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_puasa" onclick="puasa(this.checked)" disabled="disabled"/></td>
            <td>Puasa</td>
            <td colspan="9"><input name="text_puasa" type="text" id="text_puasa" size="50" value="<? echo $data['d_puasa']; ?>"  disabled="disabled"/></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><input type="checkbox" name="chk_diet" id="chk_penunggu" value="x" disabled="disabled"/></td>
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
            <td colspan="9" rowspan="2"><textarea name="keterangan" id="keterangan" cols="60" rows="5" disabled="disabled"><? echo $data['keterangan']; ?></textarea></td>
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
            <td>Medan, <?php echo date("j")." ".getBulan(date("m"))." ".date("Y")?></td>
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
</div><br />
<br />
 <div align="center">&nbsp;
  <input type="submit" name="button" id="button" value="Cetak" onclick="cetak1() " />
</div>
<br />

</body>
</html>
<script>
function cetak1()
{
	document.getElementById("button").style.display = 'none';
	window.print();
	document.getElementById("button").style.display = 'table-row';
}

function permintaan(){
	var pilihan='<? echo $data['permintaan']?>'.split(',');
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
}

function diet(){
	$('#text_biasa').val();
	if($('#text_biasa').val()!=''){
		document.getElementById('chk_biasa').checked=true;
	}
	$('#text_tim').val();
	if($('#text_tim').val()!=''){
		document.getElementById('chk_tim').checked=true;
	}
	$('#text_lunak').val();
	if($('#text_lunak').val()!=''){
		document.getElementById('chk_lunak').checked=true;
	}
	$('#text_saring').val();
	if($('#text_saring').val()!=''){
		document.getElementById('chk_saring').checked=true;
	}
	$('#text_cair').val();
	if($('#text_cair').val()!=''){
		document.getElementById('chk_cair').checked=true;
	}
	$('#text_puasa').val();
	if($('#text_puasa').val()!=''){
		document.getElementById('chk_puasa').checked=true;
	}
	var penunggu ='<? echo $data['d_penunggu']?>';
	//alert(penunggu);
	if(penunggu==1){
		document.getElementById('chk_penunggu').checked=true;
	}else{
		document.getElementById('chk_penunggu').checked=false;
	}
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
</script>