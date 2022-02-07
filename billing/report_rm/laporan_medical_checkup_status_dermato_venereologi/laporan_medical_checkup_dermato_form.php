<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, a.TENSI as tekanan_darah, a.suhu as suhu2,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_, ku.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_kunjungan ku
    ON ku.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <title>Laporan Medical Check Up</title>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
</head>
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div align="center" id="form_in" style="display:none;">
<form name="form1" id="form1" action="laporan_medical_checkup_dermato_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="760"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
&nbsp;Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>No Registrasi </td>
        <td>: <?=$dP['no_reg2'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="2">:
          <?=$dP['alamat_'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">LAPORAN MEDICAL CHECK UP</td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">STATUS DERMATO - VENEREOLOGI</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="37" />
      <tr height="20">
        <td height="20" width="20">&nbsp;</td>
        <td width="54"></td>
        <td width="16"></td>
        <td width="118"></td>
        <td width="16"></td>
        <td width="60"></td>
        <td width="48"></td>
        <td width="94"></td>
        <td width="4"></td>
        <td colspan="2"></td>
        <td width="57"></td>
        <td width="41"></td>
        <td width="50"></td>
        <td width="43"></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>ANAMNESE</strong></td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Keluhan</td>
        <td valign="top">:</td>
        <td colspan="9" ><textarea name="keluhan" cols="50" rows="2" id="keluhan"></textarea></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="9" >&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td style="border-left:1px solid#000" colspan="5" ><strong> &nbsp;Status Perkawinan</strong></td>
        <td></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Riwayat Alergi</td>
        <td valign="top">:</td>
        <td colspan="3" ><label for="alergi"></label>
          <input name="alergi" type="text" id="alergi" size="30" /></td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td style="border-left:1px solid#000" width="57" >&nbsp;Anak</td>
        <td colspan="2" >-Hidup</td>
        <td colspan="3" >:
          <label for="anak_h"></label>
          <input name="anak_h" type="text" id="anak_h" size="10" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Penyakit Kulit</td>
        <td valign="top">:</td>
        <td colspan="3" ><input name="p_kulit" type="text" id="p_kulit" size="30" /></td>
        <td style="border-left:1px solid#000" >&nbsp;</td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td colspan="2" >-Meninggal</td>
        <td colspan="3" >:
          <label for="anak_h"></label>
          <input name="anak_m" type="text" id="anak_m" size="10" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Kelainan Rambut</td>
        <td valign="top">:</td>
        <td colspan="3" ><input name="k_rambut" type="text" id="k_rambut" size="30" /></td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td style="border-left:1px solid#000"><strong>&nbsp;Abortus</strong></td>
        <td colspan="2" >-Hamil</td>
        <td colspan="3" >:
          <label for="anak_h"></label>
          <input name="hamil" type="text" id="hamil" size="10" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Disuri</td>
        <td valign="top">:</td>
        <td colspan="3" ><input name="disuri" type="text" id="disuri" size="30" /></td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td colspan="2" >-Hamil ke</td>
        <td colspan="3" >:
          <label for="anak_h"></label>
          <input name="hamil_ke" type="text" id="hamil_ke" size="10" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Discharge</td>
        <td valign="top">:</td>
        <td colspan="3" ><input name="discharge" type="text" id="discharge" size="30" /></td>
        <td style="border-left:1px solid#000" >&nbsp;</td>
        <td style="border-left:1px solid#000" colspan="3" >&nbsp;P.M.S yang pernah</td>
        <td colspan="3" >:
          <input name="pms" type="text" id="pms" size="15" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Lain-Lain</td>
        <td valign="top">:</td>
        <td colspan="3" ><input name="lain" type="text" id="lain" size="30" /></td>
        <td style="border-left:1px solid#000">&nbsp;</td>
        <td style="border-left:1px solid#000" colspan="3" >&nbsp;C.S</td>
        <td colspan="3" >:
          <input name="cs" type="text" id="cs" size="15" /></td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="3" >&nbsp;</td>
        <td colspan="3" >&nbsp;</td>
        </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top"><strong>PEMERIKSAAN</strong></td>
        <td valign="top">&nbsp;</td>
        <td colspan="9" >&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Kulit</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="kulit" type="text" id="kulit" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Kel. Getah Bening</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="getah" type="text" id="getah" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Saraf Superfisial</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="saraf" type="text" id="saraf" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Rambut</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="rambut" type="text" id="rambut" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Kuku</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="kuku" type="text" id="kuku" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Genetalia externa</td>
        <td valign="top">:</td>
        <td colspan="9" ><input name="gene" type="text" id="gene" size="40" /></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">DIAGNOSA</td>
        <td valign="top">:</td>
        <td colspan="9" ><table width="100%" border="0">
          <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td ><?=$dD['nama']?></td>
            </tr>
          <?php }?>
          <tr>
            <td >&nbsp;</td>
            </tr>
          </table></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Anjuran</td>
        <td valign="top">:</td>
        <td colspan="9" ><textarea name="anjuran" cols="50" rows="2" id="anjuran"></textarea></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tanggal/<em>Date</em></td>
        <td>:</td>
        <td colspan="4"><?=date('j ').getBulan(date('m')).date(' Y')?></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Jam/<em>Time</em></td>
        <td>:</td>
        <td colspan="3">
          <?=date('h:i:s');?></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td colspan="2" align="left">Dokter,</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
        <td colspan="5" align="center">(<strong>
          <?=$dP['dr_rujuk'];?>
        </strong>)</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
        <td colspan="5" align="center">Name and signature</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    
    <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                
    </td>
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
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                   <?php }?> </td>
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
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
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
<script type="text/javascript">

		function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('keluhan')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        /*function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }*/

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#id').val(sisip[0]);
			$('#keluhan').val(sisip[1]);
			$('#alergi').val(sisip[2]);
			$('#p_kulit').val(sisip[3]);
			//cek(sisip[3]);
			$('#k_rambut').val(sisip[4]);
			$('#disuri').val(sisip[5]);
			$('#discharge').val(sisip[6]);
			$('#lain').val(sisip[7]);
			$('#anak_h').val(sisip[8]);
			$('#anak_m').val(sisip[9]);
			$('#hamil').val(sisip[10]);
			$('#hamil_ke').val(sisip[11]);
			$('#pms').val(sisip[12]);
			$('#cs').val(sisip[13]);
			$('#kulit').val(sisip[14]);
			$('#getah').val(sisip[15]);
			$('#saraf').val(sisip[16]);
			$('#rambut').val(sisip[17]);
			$('#kuku').val(sisip[18]);
			$('#gene').val(sisip[19]);
			$('#anjuran').val(sisip[20]);
			
			/*$('#txt_biokimia_eval').val(sisip[4]);
			$('#txt_fisik').val(sisip[5]);
			$('#txt_fisik_eval').val(sisip[6]);
			$('#txt_gizi').val(sisip[7]);
			$('#txt_gizi_eval').val(sisip[8]);
			$('#txt_RwytPersonal').val(sisip[9]);
			$('#txt_RwytPersonal_eval').val(sisip[10]);
			$('#txt_diagnosa').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txt_intervensi').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_monev').val(a.cellsGetValue(a.getSelRow(),5));*/
			$('#act').val('edit');
        }

        function hapus(){
            var rowid = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var rowid = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#form_in').slideDown(1000,function(){
	toggle();
		});
				}

        }

        function batal(){
			//resetF();
			$('#form_in').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#id').val('');
			document.form1.reset();
           
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("laporan_medical_checkup_dermato_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Laporan Medical Check Up Status Dermato - Venereologi");
        a.setColHeader("NO,NO RM,KELUHAN,RIWAYAT ALERGI,ANJURAN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,300,100,100");
        a.setCellAlign("center,center,left,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("laporan_medical_checkup_dermato_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("laporan_medical_checkup_dermato_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
		
		function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}
		
		function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
		
/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
    </script>
</html>
