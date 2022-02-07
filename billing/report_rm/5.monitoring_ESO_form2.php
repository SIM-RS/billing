<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <title>Monitoring E.S.O</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:95%;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
    </head>
    <body>
        <div align="center">
            <?php
           // include("file:///Z|/simrs-tangerang/billing/header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
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
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="5.monitoring_ESO_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
               <table width="812" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><table width="407" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="117">Nama Pasien </td>
        <td width="8">:</td>
        <td width="260"><?=$dP['nama'];?> (<?=$dP['sex'];?> )</td>
      </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=tglSQL($dP['tgl_lahir'])?>  /Usia : <?=$dP['usia']?> th </td>
      </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$dP['no_rm']?> No. Registrasi :_________ </td>
      </tr>
      <tr>
        <td>Ruang rawat/Kelas </td>
        <td>:</td>
        <td><?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></td>
      </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$dP['alamat']?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="209">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="145">&nbsp;</td>
    <td width="183">&nbsp;</td>
    <td width="218">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal Lahir </td>
    <td>:</td>
    <td><?=tglSQL($dP['tgl_lahir'])?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>:</td>
    <td><input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" <?php if($dP['sex']=='L'){echo 'checked="checked"';}?> /> 
      Laki-laki </td>
    <td><input type="checkbox" name="checkbox2" value="checkbox" disabled="disabled" <?php if($dP['sex']=='P'){echo 'checked="checked"';}?>/> 
      Perempuan </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jika Perempuan </td>
    <td>:</td>
    <td><input type="radio" name="radJikPerem" value="Hamil" <?php if($dP['sex']=='L'){echo 'disabled="disabled"';}?> /> 
    Hamil </td>
    <td><input type="radio" name="radJikPerem" value="Tidak Hamil" <?php if($dP['sex']=='L'){echo 'disabled="disabled"';}?>/>
    Tidak Hamil </td>
    <td> <input type="radio" name="radJikPerem" value="Tidak Tahu" <?php if($dP['sex']=='L'){echo 'disabled="disabled"';}?>/>
      Tidak Tahu </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PENYAKIT UTAMA </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan</td>
    <td>:</td>
    <td><input type="radio" name="radSudah" value="Sembuh" />
      Sembuh</td>
    <td><input type="radio" name="radSudah" value="Alergi" />
      Alergi</td>
    <td><input type="radio" name="radSudah" value="Faktor Industri" />
      Faktor Industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="radSudah" value="Meninggal" />
      Meninggal</td>
    <td><input type="radio" name="radSudah" value="Kondisi Medis" />
      Kondisi Medis lainnya </td>
    <td><input type="radio" name="radSudah" value="Faktor Kimia" />
      Faktor Kimia dan Lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Penyakit/ kondisi lain yang menyertai : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="chPenyakit[0]" value="1" id="chPenyakit[]" />
      Gangguan Ginjal </td>
    <td><input type="checkbox" name="chPenyakit[1]" value="2" id="chPenyakit[]" />
      Alergi</td>
    <td><input type="checkbox" name="chPenyakit[2]" value="3" id="chPenyakit[]" />
      Faktor industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="chPenyakit[3]" value="4" id="chPenyakit[]" />
      Gangguan Hati </td>
    <td><input type="checkbox" name="chPenyakit[4]" value="5" id="chPenyakit[]" />
      Kondisi Medis lainnya </td>
    <td><input type="checkbox" name="chPenyakit[5]" value="6" id="chPenyakit[]" />
      Faktor Kimia dan lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">EFEK SAMPING OBAT (E.S.O) </td>
  </tr>
  <tr>
    <td colspan="5">Bentuk Manifestasi E.S.O yang terjadi: </td>
  </tr>
  <tr>
    <td colspan="5"><p>
      <label for="txt_manifes"></label>
      <textarea name="txt_manifes" cols="45" rows="5" class="textArea" id="txt_manifes"></textarea>
    </p>    </td>
  </tr>
  <tr>
    <td colspan="5">Saat / Tanggal mulai terjadi : </td>
  </tr>
  <tr>
    <td colspan="5"><textarea name="txt_mulai" cols="45" rows="5" class="textArea" id="txt_mulai"></textarea></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan E.S.O</td>
    <td>:</td>
    <td><input type="radio" name="rdSudahEso" value="Sembuh" />
      Sembuh</td>
    <td><input type="radio" name="rdSudahEso" value="Meninggal" />
      Meninggal</td>
    <td><input type="radio" name="rdSudahEso" value="Gejala Sisa" />
      Sembuh dengan gejala sisa </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="rdSudahEso" value="Belum Sembuh" />
      Belum sembuh </td>
    <td><input type="radio" name="rdSudahEso" value="Tidak Tahu" />
      Tidak Tahu </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Riwayat E.S.O yang pernah dialami : </td>
  </tr>
  <tr>
    <td colspan="5"><textarea name="txt_riwayat" cols="45" rows="5" class="textArea" id="txt_riwayat"></textarea></td>
  </tr>
  <tr>
    <td>OBAT</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><div id="inObat">
    <table width="869" border="1" cellpadding="3" style="border-collapse:collapse;" id="tblObat">
    <tr><td colspan="10" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="addRowToTable();return false;"/></td>
      </tr>
    <tr>
      <td width="20" rowspan="2" align="center">No</td>
      <td width="213" rowspan="2" align="center">Nama Obat </td>
      <td width="105" rowspan="2" align="center">Bentuk Sedian</td>
      <td width="126" rowspan="2" align="center">Obat Yang dicurigai</td>
      <td colspan="4" align="center">Pemberian</td>
      <td width="136" rowspan="2" align="center">Indikasi Penggunaan</td>
      <td width="16" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="33">&nbsp;</td>
      <td width="37">&nbsp;</td>
      <td width="40">&nbsp;</td>
      <td width="39">&nbsp;</td>
      </tr>
    <tr>
      <td align="center">1</td>
      <td align="center"><input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
      <td align="center"><input name="txt_sedia[]" type="text" class="inputan" id="txt_sedia[]" /></td>
      <td align="center"><input name="txt_curiga[]" type="text" class="inputan" id="txt_curiga[]" /></td>
      <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
      <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
      <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
      <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
      <td align="center"><input name="txt_indikasi[]" type="text" class="inputan" id="txt_indikasi[]" /></td>
      <td><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}" /></td>
    </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Keterangan tambahan : </td>
    <td rowspan="9" valign="top"><table width="218" height="208" border="0" style="border:1px solid #000000;">
      <tr>
        <td width="212">Medan, ________________ </td>
      </tr>
      <tr>
        <td><div align="center">Pelapor</div></td>
      </tr>
      <tr>
        <td height="112">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">(______________________)</div></td>
      </tr>
      <tr>
        <td height="21"><div align="center">Nama &amp; Tanda Tangan </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(misalnya kecepatan efek samping obat, reaksi setelah obat dihentikan, pengobatan yang diberikan untuk mengatasi E.S.O)</span> </td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="txt_ket" cols="45" rows="5" class="textArea" id="txt_ket"></textarea></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Data Labolatorium : </td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(Bila ada)</span> </td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="txt_lab" cols="45" rows="5" class="textArea" id="txt_lab"></textarea></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">*Diisi oleh bagian farmasi </td>
  </tr>
</table>
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  <?php }?></td>
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
            if(ValidateForm('txt_manifes','ind')){
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
			$('#txt_manifes').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txt_ket').val(sisip[7]);
			$('#txt_lab').val(sisip[8]);
			$('#txt_mulai').val(sisip[4]);
			$('#txt_riwayat').val(sisip[5]);
			centang(sisip[1],sisip[2],sisip[3],sisip[6])
			$('#inObat').load("Form_RSU_2/form_input_obat.php?type=ESO&id="+sisip[0]);
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
			document.getElementById("form1").reset();
            $('#inObat').load("Form_RSU_2/form_input_obat.php?type=ESO");
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
            a.loadURL("5.monitoring_ESO_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resum Medis");
        a.setColHeader("NO,NO RM,Manifestasi E.S.O,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("50,100,300,80,100");
        a.setCellAlign("center,center,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("5.monitoring_ESO_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{	
		window.open("5.monitoring_ESO.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				}
		}
		
function centang(tes,tes1,tes2,tes3){
		 var checkbox = document.form1.elements['radJikPerem'];
		 var checkbox1 = document.form1.elements['radSudah'];
		 var checkbox2 = document.form1.elements['chPenyakit[]'];
		 var checkbox3 = document.form1.elements['rdSudahEso'];
		 
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
		if ( checkbox1.length > 0 )
		{
		 for (i = 0; i < checkbox1.length; i++)
			{
			  if (checkbox1[i].value==tes1)
			  {
			   checkbox1[i].checked = true;
			  }
		  }
		}
		
		var tes2x =tes2.split(',');
		if ( checkbox2.length > 0 )
		{
		 for (i = 0; i < checkbox2.length; i++)
			{
			  if (checkbox2[i].value==tes2x[i])
			  {
			   checkbox2[i].checked = true;
			  }
		  }
		}
		
		if ( checkbox3.length > 0 )
		{
		 for (i = 0; i < checkbox3.length; i++)
			{
			  if (checkbox3[i].value==tes3)
			  {
			   checkbox3[i].checked = true;
			  }
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
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/
			var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);
			
            // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_obat[]';
                el.id = 'txt_obat[]';
            }else{
                el = document.createElement('<input name="txt_obat[]"/>');
            }
            el.type = 'text';
            el.className = 'inputan';
            el.value = '';

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
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_sedia[]';
                el.id = 'txt_sedia[]';
            }else{
                el = document.createElement('<input name="txt_sedia[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_curiga[]';
                el.id = 'txt_curiga[]';
            }else{
                el = document.createElement('<input name="txt_curiga[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam1[]';
                el.id = 'txt_jam1[]';
            }else{
                el = document.createElement('<input name="txt_jam1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam2[]';
                el.id = 'txt_jam2[]';
            }else{
                el = document.createElement('<input name="txt_jam2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam3[]';
                el.id = 'txt_jam3[]';
            }else{
                el = document.createElement('<input name="txt_jam3[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam4[]';
                el.id = 'txt_jam4[]';
            }else{
                el = document.createElement('<input name="txt_jam4[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_indikasi[]';
                el.id = 'txt_indikasi[]';
            }else{
                el = document.createElement('<input name="txt_indikasi[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(9);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../icon/del.gif';
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
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
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
                tds[0].innerHTML=i-2;
            }
        }
    }
    </script>
    
</html>
