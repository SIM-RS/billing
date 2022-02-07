<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2, IF(
    p.alamat <> '',
    CONCAT(
      p.alamat,
      ' RT. ',
      p.rt,
      ' RW. ',
      p.rw,
      ' Desa ',
      bw.nama,
      ' Kecamatan ',
      wi.nama, ' ', wil.nama
    ),
    '-'
  ) AS almt_lengkap 
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
LEFT JOIN b_ms_wilayah bw ON p.desa_id = bw.id 
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id 
LEFT JOIN b_ms_wilayah wil ON wil.id = p.kab_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
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
             <script type="text/javascript" src="js/jquery.timeentry.js"></script>
                <script type="text/javascript">
$(function () 
{
	$('#txtJamMulai').timeEntry({show24Hours: true, showSeconds: true});
	$('#txtJamSelesai').timeEntry({show24Hours: true, showSeconds: true});
});
  var arrRange = depRange = [];
</script>
        <title>LAPORAN OPERASI</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:95%;
	}
.textArea{ width:98%; height:100px;}
body{background:#FFF;}
        </style>
    </head>
    <body>
        <div align="center">
            <?php
           // include("../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
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
      
    <table width="803" border="1" cellpadding="" cellspacing="0" style="border-collapse:collapse;font:12px tahoma;">
      <tr>
        <td width="481" align="center" valign="top"><img src="FORM_RSU_2/lap_med_chckup_stat_bdh_wnta_clip_image003.png" style="display:block" width="350" height="105" />
        <h3><b>LAPORAN OPERASI</b></h3>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
              </tr>
          </table></td>
        <td width="316" align="left" valign="top"><table width="100%" border="0" align="right" style="font:12px tahoma;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><span class="gb">
              <?=$dP['nama']?>
            </span>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>P</span></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><span class="gb">
              <?=$dP['tgl_lahir']?>
              </span> /Usia: <span class="gb">
                <?=$dP['usia']?>
              </span> Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><span class="gb">
              <?=$dP['no_rm']?>
            </span>&nbsp;No.Registrasi: <?=$dP['no_reg2']?></td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><span class="gb">
              <?=$dP['nm_unit'];?>
              /
              <?=$dP['nm_kls'];?>
            </span></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><span class="gb">
              <?=$dP['almt_lengkap']?>
            </span></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><p><strong>(Tempelkan Stiker Identitas Pasien)</strong></p></td>
            </tr>
        </table></td>
        </tr>
  <tr>
    <td colspan="2"><form id="form1" name="form1" method="post" action="18.laporan_operasi_act.php">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/> <table width="803" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td width="276" style="border-bottom:1px solid #000;">Tanggal Operasi : 
                <label for="txtTglOpr"></label>
                <input type="text" name="txtTglOpr" id="txtTglOpr" value="<?=date('d-m-Y')?>"  onclick="gfPop.fPopCalendar(document.getElementById('txtTglOpr'),depRange);"/></td>
              <td width="252" style="border-bottom:1px solid #000;">Dimulai Jam : 
                <label for="txtJamMulai"></label>
                <input type="text" name="txtJamMulai" id="txtJamMulai" value="<?=date('H:i:s')?>"/></td>
              <td width="261" style="border-bottom:1px solid #000;">Selesai Jam : 
                <label for="txtJamSelesai"></label>
                <input type="text" name="txtJamSelesai" id="txtJamSelesai" value="<?=date('H:i:s')?>"/></td>
            </tr>
            <tr>
              <td colspan="3"  style="border-bottom:1px solid #000;">Kamar Operasi : 
                <input type="radio" name="chkOpr" id="chkOpr1" value="1" />&nbsp;OK1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="chkOpr" id="chkOpr2" value="2" />&nbsp;OK2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="chkOpr" id="chkOpr3" value="3" />&nbsp;OK3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="chkOpr" id="chkOpr4" value="4" />&nbsp;OK4&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td  style="border-bottom:1px solid #000;">Diagnosa Pra Bedah</td>
              <td colspan="2"  style="border-bottom:1px solid #000;">: 
                <label for="txtPraBedah"></label>
                <input name="txtPraBedah" type="text" class="inputan" id="txtPraBedah" /></td>
              </tr>
            <tr>
              <td>Golongan Operasi</td>
              <td colspan="2">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="3">
              <input type="radio" name="chkGolOpr" id="chkGolOpr1" value="1" />&nbsp;&nbsp;&nbsp;Khusus&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkGolOpr" id="chkGolOpr2" value="2" />&nbsp;&nbsp;&nbsp;Besar&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkGolOpr" id="chkGolOpr3" value="3" />&nbsp;&nbsp;&nbsp;Sedang&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkGolOpr" id="chkGolOpr4" value="4" />&nbsp;&nbsp;&nbsp;kecil&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td>Jenis Operasi</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" >
              <input type="radio" name="chkJnsOpr" id="chkJnsOpr1" value="1" />&nbsp;&nbsp;&nbsp;Elektif&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkJnsOpr" id="chkJnsOpr2" value="2" />&nbsp;&nbsp;&nbsp;Cito&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td>Dokter Anastesi</td>
              <td colspan="2">: 
                <label for="cmbDokter"></label>
                <select name="cmbDokter" id="cmbDokter">
                <?php 
				$q=mysql_query("SELECT id,nama,spesialisasi_id,spesialisasi FROM b_ms_pegawai p WHERE p.spesialisasi_id != 0 AND p.spesialisasi LIKE '%anestesi%';");
				while($d=mysql_fetch_array($q)){
					
					echo "<option value='$d[id]'>$d[nama]</option>";
					}
				
				?>
                </select></td>
            </tr>
            <tr>
              <td>Anastesi:</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3">
              <input type="radio" name="chkAnas" id="chkAnas1" value="1" />&nbsp;&nbsp;&nbsp;Umum&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkAnas" id="chkAnas2" value="2" />&nbsp;&nbsp;&nbsp;Spinal&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkAnas" id="chkAnas3" value="3" />&nbsp;&nbsp;&nbsp;Lokal&nbsp;&nbsp;&nbsp;
              <input type="radio" name="chkAnas" id="chkAnas4" value="4" />&nbsp;&nbsp;&nbsp;Lain-Lain
          &nbsp;&nbsp;&nbsp;&nbsp;           <input type="text" name="txtLain" id="txtLain" />       </td>
              </tr>
            <tr>
              <td>Diagnosa Pasca Bedah</td>
              <td colspan="2">: 
                <label for="txtPasca"></label>
                <input name="txtPasca" type="text" class="inputan" id="txtPasca" /></td>
            </tr>
            
            <tr>
              <td valign="top" >Tindakan Bedah</td>
              <td colspan="2" align="left">&nbsp;<div style="width:20px; float:left"> I.</div>&nbsp;<input style="width:91%" name="txtTindakan[]" type="text" id="txtTindakan1" />
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;<div style="width:20px; float:left"> II.</div>&nbsp;<input style="width:91%" name="txtTindakan[]" type="text" id="txtTindakan2" />
                &nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;<div style="width:20px; float:left"> III.</div>&nbsp;<input style="width:91%" name="txtTindakan[]" type="text" id="txtTindakan3" />
                &nbsp;</td>
            </tr>
            <tr>
              <td style="border-bottom:1px solid #000;">&nbsp;</td>
              <td colspan="2" style="border-bottom:1px solid #000;">&nbsp;<div style="width:20px; float:left"> IV.</div>&nbsp;<input style="width:91%" name="txtTindakan[]" type="text" id="txtTindakan4" />
                &nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><strong>Uraian Pembedahan:</strong></td>
              </tr>
            <tr>
              <td colspan="3"  style="border-bottom:1px solid #000;">(Uraian mulai dari bagian tubuh yang dioperasi,cara,penemuan-penemuan,tindakan yang dilakukan,explorasi yang dilakukan, drain yang digunakan, indikasi dan tindakan macam dengan cara penjahitan dengan lengkap dan jelas).<br/>
                <label for="txtUraian"></label>
                <textarea name="txtUraian" cols="45" rows="5" class="textArea" id="txtUraian"></textarea></td>
            </tr>
            <tr>
              <td colspan="3">Jaringan yang dikirim ke Histopatologi</td>
            </tr>
            <tr>
              <td colspan="3"><input type="radio" name="chkJaringan" id="chkJaringan1" value="1" />&nbsp;&nbsp;Ya&nbsp;&nbsp; 
                  <input type="radio" name="chkJaringan" id="chkJaringan2" value="0" />&nbsp;&nbsp;Tidak&nbsp;&nbsp; 
                </td>
            </tr>
            <tr>
              <td colspan="2" valign="top">Macam Jaringan : 
                <label for="txtJaringan"></label>
                <input name="txtJaringan" type="text" id="txtJaringan"  style="width:70%;" /></td>
              <td>Tanggal: <?php echo tgl_ina(date("Y-m-d"))?><br/>Pukul: <?=date('h:i:s');?><br/>Dokter Ahli Bedah<br/></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td align="center">(_____________________________)</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td align="center">Nama dan Tanda Tangan</td>
            </tr>
          </table>   
    </form></td>
        </tr>
    </table>
    </td>
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
            if(ValidateForm('txtTglOpr,txtJamMulai','ind')){
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
			$('#txtTglOpr').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txtJamMulai').val(sisip[1]);
			$('#txtJamSelesai').val(sisip[2]);
			$('#txtPraBedah').val(sisip[3]);
			$('#cmbDokter').val(sisip[6]);
			$('#txtLain').val(sisip[8]);
			$('#txtPasca').val(sisip[9]);
			$('#txtTindakan1').val(sisip[10]);
			$('#txtTindakan2').val(sisip[11]);
			$('#txtTindakan3').val(sisip[12]);
			$('#txtTindakan4').val(sisip[13]);
			$('#txtUraian').val(sisip[14]);
			$('#txtJaringan').val(sisip[16]);
			centang('chkGolOpr',sisip[4]);
			centang('chkJnsOpr',sisip[5]);
			centang('chkAnas',sisip[7]);
			centang('chkJaringan',sisip[15]);
			centang('chkOpr',sisip[17]);
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
            a.loadURL("18.laporan_operasi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Laporan Operasi");
        a.setColHeader("NO,No RM,Tgl Operasi,Golongan Operasi,TGL INPUT,PETUGAS");
        a.setIDColHeader(",keluhan,,,,");
        a.setColWidth("50,150,150,150,150,150");
        a.setCellAlign("center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("18.laporan_operasi_util.php?idPel=<?=$idPel?>");
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
		window.open("18.laporan_operasi.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
			//	}
		}
		
function centang(obj,tes){
		 var checkbox = document.form1.elements[obj];
		
		 
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
