<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama,' Kecamatan ',wi.nama),'-') AS almt_lengkap
FROM b_pelayanan pl
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));

$sAnam = "SELECT * 
FROM anamnese a
WHERE a.KUNJ_ID = '".$idKunj."' ORDER BY a.anamnese_id DESC LIMIT 1";
$qAnam = mysql_query($sAnam);
$rwAnam = mysql_fetch_array($qAnam);	

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
        <title>Medical Checkup Status Neurologi</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:100%;
	}
.textArea{ width:100%; height:40px;}
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
        <!--    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM MEDICAL CHECK UP STATUS UP BEDAH (WANITA)</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center">
                  <div id="form_in" style="display:none;">
                  
                  <table width="200" border="0">
  <tr>
    <td>
      
    <table cellspacing="0" cellpadding="">
      <tr>
        <td width="72" align="left" valign="top"><img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
          </table></td>
        <td colspan="9" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><span class="gb"><?=$dP['nama']?></span>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>P</span></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['tgl_lahir']?></span> /Usia: <span class="gb"><?=$dP['usia']?></span> Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;No.Registrasi:&nbsp;<?=$dP['no_reg']?></td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></span></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['almt_lengkap']?></span></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td></td>
        <td width="46"></td>
        <td width="126"></td>
        <td width="17"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="79"></td>
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
        <td colspan="6"><b>LAPORAN MEDICAL CHECK UP STATUS NEUROLOGI</b></td>
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
    </table></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="med_chckup_neurologi_act.php">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
    <table width="818" cellpadding="2" cellspacing="0" style="font:12px tahoma; border:1px solid #000;">
      <tr>
        <td>&nbsp;</td>
        <td style="font-weight:bold;">ANAMNESA</td>
        <td>&nbsp;</td>
        <td colspan="5"></td>
        <td width="16">&nbsp;</td>
      </tr>
      <tr>
        <td width="19"></td>
        <td width="147"></td>
        <td width="12"></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Keluhan</td>
        <td valign="top">:</td>
        <td colspan="5"><textarea name="txt_keluhan" disabled="disabled" cols="45" rows="5" class="textArea" id="txt_keluhan" ><? echo $rwAnam['KU'];?></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td style="font-weight:bold;">PEMERIKSAAN</td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td >Kesadaran</td>
        <td>:</td>
        <td colspan="5"><label for="txtSadar"></label>
          <input name="txtSadar" type="text" class="inputan" id="txtSadar" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Tanda-tanda rangsang selaput otak</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtJVP"></label>
          <textarea name="txtSelaput" cols="45" rows="5" class="textArea" id="txtSelaput" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Tanda -tanda peninggian tekanan intrakranial</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtParu"></label>
          <textarea name="txtIntra" cols="45" rows="5" class="textArea" id="txtIntra" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Syaraf - syaraf otak</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtJantung"></label>
          <textarea name="txtSyaraf" cols="45" rows="5" class="textArea" id="txtSyaraf" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Motorik</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtHati"></label>
          <textarea name="txtMotorik" cols="45" rows="5" class="textArea" id="txtMotorik" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Refleks Patologis</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtLimpa"></label>
          <textarea name="txtPatologis" cols="45" rows="5" class="textArea" id="txtPatologis" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Sensorik</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtLain"></label>
          <textarea name="txtSensorik" cols="45" rows="5" class="textArea" id="txtSensorik" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Otonom</td>
        <td valign="top">:</td>
        <td colspan="5"><label for="txtEdema"></label>
          <textarea name="txtOtonom" cols="45" rows="5" class="textArea" id="txtOtonom" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Luhur</td>
        <td valign="top">:</td>
        <td colspan="5"><textarea name="txtLuhur" cols="45" rows="5" class="textArea" id="txtLuhur" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top" >Lain -lain</td>
        <td valign="top">:</td>
        <td colspan="5"><textarea name="txtLain" cols="45" rows="5" class="textArea" id="txtLain" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top" >EEG</td>
        <td valign="top">:</td>
        <td colspan="5"><textarea name="txtEEG" cols="45" rows="5" class="textArea" id="txtEEG" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top" >Diagnosa</td>
        <td valign="top">:</td>
        <td colspan="5" valign="top"><table width="95%" border="0">
          <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['nama']?></td>
            </tr>
          <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top" >Anjuran</td>
        <td valign="top">:</td>
        <td colspan="5"><textarea name="txt_anjuran" cols="45" rows="5" class="textArea" id="txt_anjuran" ></textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td width="316"></td>
        <td colspan="4">Tanggal/Date  :<span class="gb">
          <?=tgl_ina(date('Y-m-d'));?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Pukul/Time     :<span class="gb">
          <?=date('h:i:s');?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Dokter yang memeriksa,</td>
        <td width="70"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="67"></td>
        <td width="67"></td>
        <td width="66"></td>
        <td></td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" align="center">(_________________________)</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" align="center">Nama &amp; Tanda Tangan</td>
        <td></td>
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
      </tr>
    </table></form></td>
  </tr>
  <tr>
  <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
  </td>
  </tr>
</table>
                    
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
<!--      <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
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
        function simpan(action){
			document.getElementById("txt_keluhan").disabled = false;
            if(ValidateForm('txt_anjuran,txt_keluhan','ind')){
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
			$('#txt_keluhan').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txtSadar').val(sisip[1]);
			$('#txtSelaput').val(sisip[2]);
			$('#txtIntra').val(sisip[3]);
			$('#txtSyaraf').val(sisip[4]);
			$('#txtMotorik').val(sisip[5]);
			$('#txtPatologis').val(sisip[6]);
			$('#txtSensorik').val(sisip[7]);
			$('#txtOtonom').val(sisip[8]);
			$('#txtLuhur').val(sisip[9]);
			$('#txtLain').val(sisip[10]);
			$('#txtEEG').val(sisip[11]);
			$('#txt_anjuran').val(sisip[12]);
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
			document.getElementById('form1').reset();
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
            a.loadURL("med_chckup_neurologi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Medical Check UP Status Neurologi");
        a.setColHeader("NO,No RM,Keluhan,TGL INPUT,PETUGAS");
        a.setIDColHeader(",keluhan,,,");
        a.setColWidth("50,150,300,150,150");
        a.setCellAlign("center,center,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("med_chckup_neurologi_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			document.getElementById("txt_keluhan").disabled = true;
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("med_chckup_neurologi.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
			//	}
		}
		
function centang(tes){
		 var checkbox = document.form1.elements['rd_grade'];
		
		 
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
		
	}
	
function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}

    </script>
    
</html>
