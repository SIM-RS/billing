<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`,  an.`TENSI`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'";
$dP=mysql_fetch_array(mysql_query($sqlP));

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
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>          
        <!-- end untuk ajax-->
        <title>SURAT PERSETUJUAN PEMERIKSAAN / PEMAKAIAN OBAT / ALAT KESEHATAN</title>
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
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
                <iframe height="193" width="168" name="gToday:normal:agenda.js"
        id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
        style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
    </iframe> 
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:blok;">
                <form name="form1" id="form1" action="resume_medis_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                <table width="805" border="0">
  <tr>
    <td width="799"><table cellspacing="0" cellpadding="0">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
      <tr>
        <td width="350" align="left" valign="top"><p align="center"><strong>PEMERINTAH KOTA MEDAN</strong></p>
          <p align="center"><strong>RUMAH SAKIT PELINDO I</strong></p>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
        </table></td>
        <td colspan="9" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116" style="border-bottom:1px solid #000;"><strong>Nama Pasien</strong></td>
            <td width="10" style="border-bottom:1px solid #000;"><strong>:</strong></td>
            <td width="174" style="border-bottom:1px solid #000;"><?=$dP['nama']?></td>
          </tr>
          <tr >
            <td><strong>No. R.M.</strong></td>
            <td>:</td>
            <td><?=$dP['no_rm']?></td>
          </tr>
          
          
        </table></td>
        </tr>
      <tr>
        <td></td>
        <td width="35"></td>
        <td width="95"></td>
        <td width="12"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="120"></td>
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
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="9" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="10" align="center"><p>&nbsp;</p>
          <table width="1000" style="border-collapse:collapse;border:1px solid #000;">
            <tr>
              <th width="5" scope="col">&nbsp;</th>
              <th width="35" scope="col">&nbsp;</th>
              <th width="46" scope="col">&nbsp;</th>
              <th width="142" scope="col">&nbsp;</th>
              <th width="12" scope="col">&nbsp;</th>
              <th width="98" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="35" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="77" scope="col">&nbsp;</th>
              <th width="76" scope="col">&nbsp;</th>
              <th width="25" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="13"><div align="center"><strong>SURAT PERSETUJUAN </strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="13"><div align="center"><strong>PEMERIKSAAN / PEMAKAIAN OBAT / ALAT KESEHATAN</strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="8">Saya yang bertada tangan dibawah ini :</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Nama</td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2"><input type="checkbox" name="pria" id="pria"/>
                <label for="pria">Laki-laki</label></td>
              <td colspan="2"><input type="checkbox" name="Wanita" id="Wanita"/>
                <label for="Wanita">Perempuan</label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Umur</td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">No. KTP</td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Alamat</td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Telepon</td>
              <td>:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="6">Dalam hal ini bertindak atas nama atau untuk mewakili :</td>
              <td colspan="2"><select name="a" id="a">
                <option>Diri Sendiri</option>
                <option>Suami</option>
                <option>Istri</option>
                <option>Anak</option>
                <option>Orang Tua</option>
                <option>Wali</option>
                <option>Keluarga</option>
                </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Nama</td>
              <td>:</td>
              <td colspan="3">
                <?=$dP['nama']?>
              </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2"><input type="checkbox" name="pria" id="pria" disabled="disabled" <? if($dP['sex']=='L'){echo 'checked="checked"';}?>/><label for="pria2">Laki-laki</label></td>
              <td colspan="2"><input type="checkbox" name="Wanita" id="Wanita" disabled="disabled" <? if($dP['sex']=='P'){echo 'checked="checked"';}?>/>
                <label for="Wanita2">Perempuan</label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">No. MR</td>
              <td>:</td>
              <td colspan="9">
                <?=$dP['no_rm']?>
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Umur</td>
              <td>:</td>
              <td colspan="9"><?=$dP['usia'];?>&nbsp;Tahun</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Kelas / Kamar</td>
              <td>:</td>
              <td colspan="9"><?=$dP['nm_kls'];?> / 
                <?=$dP['nm_unit'];?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Dokter Yang Merawat</td>
              <td>:</td>
              <td colspan="9"><?=$dP['dr_rujuk'];?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">Diagnosa</td>
              <td>:</td>
              <td colspan="9">
              	<?php 
				$sqlD="SELECT md.nama FROM b_diagnosa d
				LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
				LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
				WHERE d.pelayanan_id='$idPel';";//$idPel
				$exD=mysql_query($sqlD);
				while($dD=mysql_fetch_array($exD)){?>
         			<?=$dD['nama'].'<br>'?>
        		<?php }?>  
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="13">Telah memahami dan mengerti penjelasan mengenai tujuan, biaya dan perlunya pemeriksaan / pemakaian obat-obatan alat kesehatan.</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="13">Berdasarkan hal tersebut diatas sebagai pasien / penanggung jawab, menyatakan persetujuan atas dilaksanakanya :</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="13"><div id="inObat2">
                <table style="font:12px tahoma; border:1px solid #000;">
                  <tr>
                    <td width="777" align="center"><div id="inObat">
                      <table width="781" border="1" id="tblkegiatan" cellpadding="2" style="border-collapse:collapse;">
                        <tr>
                          <td colspan="7" align="right"><input type="button" name="button" id="button" value="Tambah" onclick="addRowToTable();return false;"/></td>
                        </tr>
                        <tr>
                          <td width="53" rowspan="2" align="center">No</td>
                          <td width="198" rowspan="2" align="center">Jenis Pemeriksaan / Pemakaian Obat / Alat Kesehatan</td>
                          <td width="109" rowspan="2" align="center">Biaya</td>
                          <td width="109" rowspan="2" align="center">Tanggal Disetujui</td>
                          <td colspan="2" align="center">Jam Pemberian</td>
                          <td width="34" rowspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="109" align="center">Pasien / Penanggung Jawab</td>
                          <td width="109" align="center">Perawat</td>
                          </tr>
                        <tr>
                          <td align="center">
                          <input type="text" size="1" value="1">
                           </td>
                          <td align="center"><input name="txt_kegiatan[]" type="text" id="txt_kegiatan[]" size="35" /></td>
                          <td align="center"><input name="txt_biaya[]" type="text" id="txt_biaya[]" size="25" /></td>
                          <td align="center">
                          <input name="tgl[]" type="text" id="tgl[]" size="20" onClick="gfPop.fPopCalendar(document.getElementById('tgl[]'),depRange);"/>
                          </td>
                          <td align="center"><input name="txt_p_jawab[]" type="text" id="txt_p_jawab[]" size="25" /></td>
                          <td align="center"><input name="txt_perawat[]" type="text" id="txt_perawat[]" size="20" /></td>
                          <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
                        </tr>
                      </table>
                    </div></td>
                  </tr>
                </table>
              </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
      <tr>
        <td height="2"></td>
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
    <td>&nbsp;</td>
  </tr>
</table>
                <p>&nbsp;</p>
                </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  </td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_anjuran','ind')){
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
			$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			$('#act').val('edit');
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
			$('#txtId').val('');
			$('#txt_anjuran').val('');
            $('#inObat').load("form_input_obat.php");
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
            a.loadURL("resum_medis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resum Medis");
        a.setColHeader("NO,NO RM,Anjuran,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("50,100,300,80,100");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("resum_medis_util.php?idPel=<?=$idPel?>");
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
		window.open("resume_medis.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
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
	
	
function removeRowFromTable(cRow)
{
	var tbl = document.getElementById('tblkegiatan');
	var jmlRow = tbl.rows.length;
	if (jmlRow > 4)
	{
		var i=cRow.parentNode.parentNode.rowIndex;
		//if (i>2){
		tbl.deleteRow(i);
		var lastRow = tbl.rows.length;
		for (var i=3;i<lastRow;i++)
		{
			var tds = tbl.rows[i].getElementsByTagName('td');
			//tds[0].innerHTML=i-2;
		}
	}
}

	
function addRowToTable()
	{
		//use browser sniffing to determine if IE or Opera (ugly, but required)
		var isIE = false;
		if(navigator.userAgent.indexOf('MSIE')>0){
			isIE = true;
		}
		//	alert(navigator.userAgent);
		//	alert(isIE);
		var tbl = document.getElementById('tblkegiatan');
		var lastRow = tbl.rows.length;
		// if there's no header row in the table, then iteration = lastRow + 1
		var iteration = lastRow;
		var row = tbl.insertRow(lastRow);
		//row.id = 'row'+(iteration-1);
		row.className = 'itemtableA';
		//row.setAttribute('class', 'itemtable');
		row.onmouseover = function(){this.className='itemtableAMOver';};
		row.onmouseout = function(){this.className='itemtableA';};
		
		var cellRight = row.insertCell(0);
		var el;
		var tree;
		var no=tbl.rows.length;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			
		}else{
			el = document.createElement('');
		}
		el.type = 'text';
		el.size=1;
		el.value = no-3;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);

		if("<?php echo $edit;?>" == true){
			//generate id
			if(!isIE){
				el = document.createElement('input');
				el.name = 'id';
				el.id = 'id';
			}else{
				el = document.createElement('<input name="id" id="id" />');
			}
			el.type = 'text';
			cellRight.className = 'tdisi';
			cellRight.appendChild(el);
		}

// right cell
		var cellRight = row.insertCell(1);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'txt_kegiatan[]';
			el.id = 'txt_kegiatan[]';
		}else{
			el = document.createElement('<input name="txt_kegiatan[]"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 35;
		

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(2);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'txt_biaya[]';
			el.id = 'txt_biaya[]';
		}else{
			el = document.createElement('<input name="txt_biaya[]"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 25;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(3);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'tgl[]';
			el.id = 'tgl[]';
			el.setAttribute('onClick',"gfPop.fPopCalendar(document.getElementById('tgl[]'),depRange)");
		}else{
			el = document.createElement('<input name="tgl[]" onClick="gfPop.fPopCalendar(document.getElementById("tgl[]"),depRange);"  id="tgl[]"/> size="20" type="text"');
		}
		el.type = 'text';
		el.value = '';
		el.size = 20;
		cellRight.className = 'tdisi';
		cellRight.appendChild(el);
		
// right cell
		var cellRight = row.insertCell(4);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'txt_p_jawab[]';
			el.id = 'txt_p_jawab[]';
		}else{
			el = document.createElement('<input name="txt_p_jawab[]"/>');
		}
		el.type = 'text';
		el.value = '';
		el.size = 25;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);

// right cell
		var cellRight = row.insertCell(5);
		var el;
		var tree;
		//generate obatid
		if(!isIE){
			el = document.createElement('input');
			el.name = 'txt_perawat[]';
			el.id = 'txt_perawat[]';
		}else{
			el = document.createElement('<input name="txt_perawat[]"/>');
		}
		
		el.type = 'text';
		el.value = '';
		el.size = 20;

		cellRight.className = 'tdisi';
		cellRight.appendChild(el);

// right cell
		
// right cell
			cellRight = row.insertCell(6);
			if(!isIE){
				el = document.createElement('img');
				el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
			}else{
				el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
			}
			el.src = '../../icon/del.gif';
			el.border = "0";
			el.width = "16";
			el.height = "16";
			el.className = 'proses';
			el.align = "absmiddle";
			el.title = "Klik Untuk Menghapus";

			//  cellRight.setAttribute('class', 'tdisi');
			cellRight.className = 'tdisi';
			cellRight.appendChild(el);

			//document.forms[0].txt_obat[iteration-3].focus();

			/*  // select cell
var cellRightSel = row.insertCell(2);
var sel = document.createElement('select');
sel.name = 'satuan';
sel.className = "txtinput";
//sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
cellRightSel.appendChild(sel);
			 */
	//document.getElementById('btnSimpan').disabled = true;
}

</script>

</html>
