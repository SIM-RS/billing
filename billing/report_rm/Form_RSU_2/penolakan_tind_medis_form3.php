<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <title>Penolakan Tindakan Medis</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        </style>
    </head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="976" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center"><div id="form_in" style="display:block;">
                
                <table width="200">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="11" align="left" valign="top"><img src="penolakan_tind_medis_clip_image003.png" alt="" width="667" height="75" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"></td>
            </tr>
          </table></td>
        <td width="22"></td>
        <td width="182"></td>
        <td width="18"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="35"></td>
        <td width="132"></td>
        <td width="11"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <form id="form1" name="form1" method="post" action="penolakan_tind_medis_act.php">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
    <table cellspacing="0" cellpadding="2" style="font:12px tahoma; border:1px solid #000;">
      <col width="11" />
      <col width="22" />
      <col width="182" />
      <col width="18" />
      <col width="64" span="4" />
      <col width="35" />
      <col width="132" />
      <col width="11" />
      <tr>
        <td width="3">&nbsp;</td>
        <td width="13">&nbsp;</td>
        <td width="179">&nbsp;</td>
        <td width="9">&nbsp;</td>
        <td width="59">&nbsp;</td>
        <td width="59">&nbsp;</td>
        <td width="58">&nbsp;</td>
        <td width="50">&nbsp;</td>
        <td width="44">&nbsp;</td>
        <td width="150">&nbsp;</td>
        <td width="9">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Saya yang bertanda tangan    di bawah ini :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
        <td colspan="2">Nama</td>
        <td>:</td>
        <td colspan="6"><span class="gb">
          <input name="txt_nama" type="text" class="inputan" id="txt_nama" value="<?=$_POST['txt_nama']?>"/>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Umur / Kelamin</td>
        <td>:</td>
        <td colspan="6"><?=$dP['umur2']?> </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" valign="top">Alamat</td>
        <td valign="top">:</td>
        <td colspan="6">
          <textarea name="txt_alamat" cols="45" rows="5" class="textArea" id="txt_alamat" ><?=$_POST['txt_alamat']?>
          </textarea>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">&nbsp;</td>
        <td>Telp. </td>
        <td><span class="gb">
          <input name="txt_tlp" type="text" id="txt_tlp" value="<?=$_POST['txt_tlp']?>"/>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Bukti diri / KTP</td>
        <td>:</td>
        <td colspan="6"><span class="gb">
          <input name="txt_ktp" type="text" class="inputan" id="txt_ktp" value="<?=$_POST['txt_ktp']?>"/>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="6">Dengan ini menyatakan    dengan sesungguhnya telah menyatakan :</td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
        <td colspan="9" align="center"><b>PENOLAKAN</b></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
        <td colspan="4">Untuk dilakukan Tindakan    Medis berupa** :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9">
          <label for="txt_tind"></label>
          <textarea name="txt_tind" cols="45" rows="5" class="textArea" id="txt_tind" ><?=$_POST['txt_tind']?></textarea>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9" valign="middle">Terhadap diri saya <input type="radio" name="rad_thd" id="rad_thd" value="1" <?php if($_POST['rad_thd']==1){echo 'checked="checked"';}?>/>sendiri / <input type="radio" name="rad_thd" id="rad_thd" value="2"<?php if($_POST['rad_thd']==2){echo 'checked="checked"';}?>/>suami / <input type="radio" name="rad_thd" id="rad_thd" value="3"<?php if($_POST['rad_thd']==3){echo 'checked="checked"';}?>/>isteri / <input type="radio" name="rad_thd" id="rad_thd" value="4"<?php if($_POST['rad_thd']==4){echo 'checked="checked"';}?>/>Orang Tua / <input type="radio" name="rad_thd" id="rad_thd" value="5"<?php if($_POST['rad_thd']==5){echo 'checked="checked"';}?>/>ayah / <input type="radio" name="rad_thd" id="rad_thd" value="6"<?php if($_POST['rad_thd']==6){echo 'checked="checked"';}?>/>ibu / <input type="radio" name="rad_thd" id="rad_thd" value="7"<?php if($_POST['rad_thd']==7){echo 'checked="checked"';}?>/>Wali / <input type="radio" name="rad_thd" id="rad_thd" value="8"<?php if($_POST['rad_thd']==8){echo 'checked="checked"';}?>/>Anak saya *),    dengan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Nama</td>
        <td>:</td>
        <td colspan="6" class="gb"><label for="txt_nama"></label>
          <?=$dP['nama']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" >Umur / Kelamin</td>
        <td>:</td>
        <td colspan="6" class="gb"><?=$dP['usia'];?>
          Thn, <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" valign="top">Alamat</td>
        <td valign="top">:</td>
        <td colspan="6" class="gb"><?=$dP['alamat'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">&nbsp;</td>
        <td>Telp. </td>
        <td class="gb"><?=$dP['telp'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Bukti diri / KTP</td>
        <td>:</td>
        <td colspan="6" class="gb"><?=$dP['no_ktp'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Di  rawat di</td>
        <td>:</td>
        <td colspan="6" class="gb"><input name="txt_rawat" type="text" class="inputan" id="txt_rawat" style="display:none" value="<?=$_POST['txt_rawat']?>"/>
          <?=$dP['nm_unit'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">No. Rekam Medis</td>
        <td>:</td>
        <td colspan="6" class="gb"><input name="txt_rekam" type="text" class="inputan" id="txt_rekam" style="display:none" value="<?=$_POST['txt_rekam']?>"/>
          <?=$dP['no_rm'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
        <td colspan="8">Saya juga telah    menyatakan dengan sesungguhnya dengan tanpa paksaan bahwa saya :</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>a.</td>
        <td colspan="9" rowspan="2">Telah    diberikan informasi dan penjelasan serta peringatan akan bahaya, resiko serta    kemungkinan - kemungkinan yangtimbul apabila tidak    dilakukan tindakan medis berupa **</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="8"><textarea name="txt_resiko" cols="45" rows="5" class="textArea" id="txt_resiko" ><?=$_POST['txt_resiko']?></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>b.</td>
        <td colspan="6">Telah saya pahami    sepenuhnya informasi dan penjelasan yang diberikan dokter.</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>c.</td>
        <td colspan="9">Atas    tanggung jawab dan risiko saya sendiri tetap menolak untuk dilakukan tindakan    medis yang dianjurkan dokter.</td>
      </tr>
      <tr>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="4">Medan, <span class="gb">
          <?php echo tgl_ina(date("Y-m-d"))?>
          </span> Pkl <span class="gb">
            <?=date('h:i:s');?>
          </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Saksi - saksi</td>
        <td></td>
        <td colspan="3">Dokter</td>
        <td colspan="3" align="center">Yang membuat pernyataan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Tanda Tangan</td>
        <td></td>
        <td colspan="3">Tanda Tangan</td>
        <td colspan="3" align="center"> Tanda Tangan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>1.</td>
        <td class="gb">&nbsp;</td>
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
        <td></td>
        <td>(_____________________)</td>
        <td></td>
        <td colspan="3">(_____________________)</td>
        <td colspan="3" align="center">(_____________________)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>nama jelas &amp; tanda tangan</td>
        <td></td>
        <td colspan="3">nama jelas &amp; tanda tangan</td>
        <td colspan="3" align="center">nama jelas &amp; tanda tangan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2.</td>
        <td class="gb">&nbsp;</td>
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
        <td></td>
        <td>(_____________________)</td>
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
        <td></td>
        <td>nama jelas &amp; tanda tangan</td>
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
        <td colspan="10">*)    Coret yang tidak perlu        **) isi    dengan jenis tindakan medis yang akan dilakukan</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
  <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
  &nbsp;
<!--  <input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="return cetak()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>-->
  </td>
  </tr>
</table>
                
                </div></td>
                </tr>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                        <?php }?></td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript">
        function simpan(action){
            if(ValidateForm('txt_tind,txt_nama,txt_umur,txt_tlp,txt_alamat','ind')){
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
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			$('#txt_tind').val(a.cellsGetValue(a.getSelRow(),2));
			$('#txt_resiko').val(a.cellsGetValue(a.getSelRow(),12));
			$('#txt_alamat').val(a.cellsGetValue(a.getSelRow(),7));
            var p="txtId*-*"+sisip[0]+"*|*txt_nama*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txt_umur*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txt_tlp*-*"+a.cellsGetValue(a.getSelRow(),8)+"*|*txt_ktp*-*"+a.cellsGetValue(a.getSelRow(),9)+"*|*txt_rawat*-*"+a.cellsGetValue(a.getSelRow(),10)+"*|*txt_rekam*-*"+a.cellsGetValue(a.getSelRow(),11)+"*";
            fSetValue(window,p);
			centang(sisip[1],a.cellsGetValue(a.getSelRow(),6));
        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
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
            var rowid = document.getElementById("txtId").value;
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
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#txt_tind').val('');
			$('#txt_resiko').val('');
			$('#txt_alamat').val('');
            var p="txtId*-**|*txt_tind*-**|*txt_nama*-**|*txt_umur*-**|*txt_alamat*-**|*txt_tlp*-**|*txt_ktp*-**|*txt_rawat*-**|*txt_rekam*-**|*txt_resiko*-**";
            fSetValue(window,p);
			centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
           /* var tangkap=val.split("*|*");
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
            a.loadURL("penolakan_tind_medis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Penolakan Tindakan Medis");
        a.setColHeader("NO,TINDAKAN,TERHADAP,NAMA,UMUR,JK,ALAMAT,NO TLP,NO KTP,DI RAWAT,NO RM,RESIKO");
        a.setIDColHeader(",tindakan,,nama,umur,,,,,,,");
        a.setColWidth("50,250,80,250,50,50,300,100,100,100,100,250");
        a.setCellAlign("center,center,center,center,center,center,left,center,center,center,center,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("penolakan_tind_medis_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("penolakan_tind_medis.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes,tes2){
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
	}
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}
    </script>
    
</html>
