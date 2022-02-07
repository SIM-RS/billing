<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, IFNULL(pg2.nama,'-') as dokternya, pg2.id as drnya, Ifnull(pg2.spesialisasi,'-') spec, (GROUP_CONCAT(md.nama)) as diag
FROM b_pelayanan pl
INNER JOIN b_kunjungan ku ON pl.kunjungan_id=ku.id
LEFT JOIN b_diagnosa di ON di.kunjungan_id=ku.id
LEFT JOIN b_ms_diagnosa md ON md.id=di.ms_diagnosa_id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_pegawai pg2 ON pg2.id=pl.dokter_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));//echo $sqlP;
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
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
        <title>Hasil Pemeriksaan Audiometri</title>
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
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility:hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="13">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="12" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="h_periksa_audiometri_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUser?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table width="775" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="153"><div align="right">Nama Pasien </div></td>
    <td width="9">:</td>
    <td width="299"><?=$dP['nama']?>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
  </tr>
  <tr>
    <td><div align="right">Tanggal Lahir </div></td>
    <td> : </td>
    <td><?=tglSQL($dP['tgl_lahir'])?> Usia : <?=$dP['usia']?></td>
  </tr>
  <tr>
    <td><div align="right">No. RM </div></td>
    <td>:</td>
    <td><?=$dP['no_rm']?></td>
  </tr>
  <tr>
    <td><div align="right">Ruang Rawat/Kelas </div></td>
    <td>:</td>
    <td><?=$dP['nm_unit'];?>&nbsp;/&nbsp;<?=$dP['nm_kls'];?></td>
  </tr>
  <tr>
    <td><div align="right">Alamat</div></td>
    <td>:</td>
    <td><?=$dP['alamat']?></td>
  </tr>
  <tr>
    <td colspan="13">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="13"><strong>Hasil Pemeriksaan Audiometri</strong></td>
  </tr>
  
  <tr style="border:1px solid">
    <td colspan="13"><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="44" />
      <col width="40" />
      <col width="132" />
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
		<td height="20">&nbsp;</td>
        <td height="20" colspan="2">Dokter Pengirim</td>
        <td height="20">:</td>
		<td height="20" colspan="8"><?=$dP['dokternya']?></td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20" colspan="2">Diagnosa / Keterangan Klinik</td>
        <td height="20">:</td>
		<td height="20" colspan="9"><?=$dP['diag'];?></td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="11"><textarea name="ket_klinis" cols="45" rows="5" class="textArea" id="ket_klinis"></textarea></td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20">Hasil</td>
        <td height="20" colspan="2" align="center">:</td>
		<td height="20" colspan="5">&nbsp;</td>
		<td height="20" colspan="3">AUDIOGRAM : </td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="8" rowspan="3"><textarea name="hasil" cols="45" rows="14" class="textArea" id="hasil"></textarea></td>
		<td height="20" colspan="3"><textarea name="audio" cols="45" rows="5" class="textArea" id="audio"></textarea></td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="3">SPEECH TEST : </td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="3"><textarea name="speech" cols="45" rows="5" class="textArea" id="speech"></textarea></td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20">Kesimpulan</td>
        <td height="20" align="center" colspan="2">:</td>
		<td height="20" align="center" colspan="5">&nbsp;</td>
		<td height="20" colspan="3">PEMERIKSAAN KHUSUS : </td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="8"><textarea name="kesimpulan" cols="45" rows="5" class="textArea" id="kesimpulan"></textarea></td>
		<td height="20" colspan="3"><textarea name="periksa_k" cols="45" rows="5" class="textArea" id="periksa_k"></textarea></td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20" colspan="12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="3" align="right">Saran :<input type="radio" name="saran" id="saran" value="1"/>HANTARAN TULANG</td>
        <td colspan="4"><input type="radio" name="kk" id="kk" value="1" />Kiri : Biru</td>
        <td colspan="5">&nbsp;</td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2" align="right"><input type="radio" name="saran" id="saran" value="2"/>
        HANTARAN UDARA</td>
        <td colspan="4"><input type="radio" name="kk" id="kk" value="2"/>Kanan : Merah</td>
        <td colspan="5">&nbsp;</td>
		<td>&nbsp;</td>
      </tr>
	<tr height="20">
        <td height="20" colspan="12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="3"></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Dokter Pelaksana : </td>
        <td colspan="3"><center><strong><select name="dokter_pelaksana" id="dokter_pelaksana">
                <?php 
				$q=mysql_query("SELECT id,nama,spesialisasi_id FROM b_ms_pegawai p WHERE p.spesialisasi_id != 0;");
				while($d=mysql_fetch_array($q)){
					
					echo "<option value='$d[id]'>$d[nama]</option>";
					}
				
				?>
                </select></strong></center></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12">&nbsp;</td>
        <td>&nbsp;</td>
	  <!--tr height="20">
        <td colspan="3">Dokter <strong>Pengganti</strong></td>
        <td colspan="9">:&nbsp;
		<select name="id_dokter_pengganti" id="id_dokter_pengganti" style="width:250px;">
		<?php $qee="select bmpg.id AS id_peg,bmpg.nama,bmpg.spesialisasi from b_ms_pegawai bmpg LEFT JOIN b_fom_alih_rawat fr ON bmpg.id=fr.id_dokter_pengganti where bmpg.spesialisasi_id<>0";
		$cc=mysql_query($qee);
		while($dr=mysql_fetch_array($cc))
		{
		?>
		<option value="<?=$dr['id_peg'];?>"><?=$dr['nama'];?>&nbsp;&nbsp;Spesialis : <?=$dr['spesialisasi']?></option>
		<?php }?>
		</select>&nbsp;&nbsp;
		</td>
		<td>&nbsp;</td>
      </tr-->
      <tr height="20">
        <td height="20" colspan="13">&nbsp;</td>
      </tr>
	  </table></td>
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
            if(ValidateForm('hasil')){
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
			$('#txtId').val(sisip[0]);
			$('#ket_klinis').val(sisip[1]);
			$('#hasil').val(sisip[2]);
			$('#audio').val(sisip[3]);
			$('#speech').val(sisip[4]);
			$('#kesimpulan').val(sisip[5]);
			$('#periksa_k').val(sisip[6]);
			centang(sisip[7],sisip[8]);
			$('#dokter_pelaksana').val(sisip[9]);
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
            a.loadURL("h_periksa_audiometri_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Hasil Pemeriksaan Audiometri");
        a.setColHeader("NO,NO RM,NAMA PASIEN,KET KLINIS,HASIL,AUDIOGRAM,SPEECH TEST,KESIMPULAN,PEMERIKSAAN KHUSUS,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,nm_pasien,,,,,,,,");
        a.setColWidth("50,100,100,100,100,100,100,100,100,100,100");
        a.setCellAlign("center,center,left,left,left,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("h_periksa_audiometri_util.php?idPel=<?=$idPel?>");
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
		window.open("h_periksa_audiometri.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUser?>","_blank");
				//}
		}
		
function centang(tes,tes2){
		 var checkbox = document.form1.elements['saran'];
		 var checkboxlp = document.form1.elements['kk'];
		 
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
    </script>
    
</html>
