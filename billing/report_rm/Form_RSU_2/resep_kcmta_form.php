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
        <title>Form Resep Kacamata</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:40px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        </style>
    </head>
    <body>
        <div align="center">
            <?php
            //include("../../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
       <!--     <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESEP KACAMATA</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                
                <table width="200" border="0">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
      <tr>
        <td colspan="13" width="649" align="center"><b>RESEP KACA MATA</b></td>
      </tr>
      <tr>
        <td colspan="13" width="649" align="center" valign="top"><img width="480" height="149" src="resep_kcmta_clip_image007.png" alt="tes mata.jpg,tes mata.jpg" />
          </td>
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
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <form id="form1" name="form1" method="post" action="resep_kcmta_act.php">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
    <table cellspacing="0" cellpadding="3" style="font:12px tahoma; border-collapse:collapse;" border="1">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
      <tr class="header">
        <td colspan="2" width="67">&nbsp;</td>
        <td width="51" align="center">Spher</td>
        <td width="51" align="center">Cyl</td>
        <td width="51" align="center">Axis</td>
        <td width="51" align="center">Prism</td>
        <td width="51" align="center">Base</td>
        <td width="51" align="center">Spher</td>
        <td width="51" align="center">Cyl</td>
        <td width="51" align="center">Axis</td>
        <td width="51" align="center">Prism</td>
        <td width="51" align="center">Base</td>
        <td width="72" align="center">Jarak Pupil</td>
      </tr>
      <tr>
        <td colspan="2">Jauh</td>
        <td>
          <label for="j_spher"></label>
          <input name="j_spher" type="text" class="inputan" id="j_spher" value="<?=$_POST['j_spher']?>"/>
        </td>
        <td><input name="j_cyl" type="text" class="inputan" id="j_cyl" value="<?=$_POST['j_cyl']?>"/></td>
        <td><input name="j_axis" type="text" class="inputan" id="j_axis" value="<?=$_POST['j_axis']?>"/></td>
        <td><input name="j_prism" type="text" class="inputan" id="j_prism" value="<?=$_POST['j_prism']?>"/></td>
        <td><input name="j_base" type="text" class="inputan" id="j_base" value="<?=$_POST['j_base']?>"/></td>
        <td><input name="j_spher2" type="text" class="inputan" id="j_spher2" value="<?=$_POST['j_spher2']?>"/></td>
        <td><input name="j_cyl2" type="text" class="inputan" id="j_cyl2" value="<?=$_POST['j_cyl2']?>"/></td>
        <td><input name="j_axis2" type="text" class="inputan" id="j_axis2" value="<?=$_POST['j_axis2']?>"/></td>
        <td><input name="j_prism2" type="text" class="inputan" id="j_prism2" value="<?=$_POST['j_prism2']?>"/></td>
        <td><input name="j_base2" type="text" class="inputan" id="j_base2" value="<?=$_POST['j_base2']?>"/></td>
        <td><input name="j_pupil" type="text" class="inputan" id="j_pupil" value="<?=$_POST['j_pupil']?>"/></td>
      </tr>
      <tr>
        <td colspan="2">Dekat</td>
        <td><input name="d_spher" type="text" class="inputan" id="d_spher" value="<?=$_POST['d_spher']?>"/></td>
        <td><input name="d_cyl" type="text" class="inputan" id="d_cyl" value="<?=$_POST['d_cyl']?>"/></td>
        <td><input name="d_axis" type="text" class="inputan" id="d_axis" value="<?=$_POST['d_axis']?>"/></td>
        <td><input name="d_prism" type="text" class="inputan" id="d_prism" value="<?=$_POST['d_prism']?>"/></td>
        <td><input name="d_base" type="text" class="inputan" id="d_base" value="<?=$_POST['d_base']?>"/></td>
        <td><input name="d_spher2" type="text" class="inputan" id="d_spher2" value="<?=$_POST['d_spher2']?>"/></td>
        <td><input name="d_cyl2" type="text" class="inputan" id="d_cyl2" value="<?=$_POST['d_cyl2']?>"/></td>
        <td><input name="d_axis2" type="text" class="inputan" id="d_axis2" value="<?=$_POST['d_axis2']?>"/></td>
        <td><input name="d_prism2" type="text" class="inputan" id="d_prism2" value="<?=$_POST['d_prism2']?>"/></td>
        <td><input name="d_base2" type="text" class="inputan" id="d_base2" value="<?=$_POST['d_base2']?>"/></td>
        <td><input name="d_pupil" type="text" class="inputan" id="d_pupil" value="<?=$_POST['d_pupil']?>"/></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" style="font:12px tahoma;">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
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
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="57"></td>
        <td width="10"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td colspan="4" width="225">Medan,
          <?php echo tgl_ina(date("Y-m-d"))?>
        </td>
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
        <td colspan="4" align="center">Dokter,</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['nama']?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Umur</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['usia']?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['alamat']?></td>
        <td></td>
        <td></td>
        <td colspan="4" align="center">(……………………………………………)</td>
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
        <td colspan="4" align="center">Nama &amp; Tanda Tangan</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>  </td>
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
                       <?php }?> </td>
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
                    <td align="center" colspan="3">
                        <div id="gridbox" style="width:700px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:700px;"></div></td>
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
 <!--     <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
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
            if(ValidateForm('j_spher,j_cyl,j_axis,j_prism,j_base','ind')){
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
			 var p="txtId*-*"+sisip[0]+"*|*j_spher*-*"+sisip[1]+"*|*j_cyl*-*"+sisip[2]+"*|*j_axis*-*"+sisip[3]+"*|*j_prism*-*"+sisip[4]+"*|*j_base*-*"+sisip[5]+"*|*j_spher2*-*"+sisip[6]+"*|*j_cyl2*-*"+sisip[7]+"*|*j_axis2*-*"+sisip[8]+"*|*j_prism2*-*"+sisip[9]+"*|*j_base2*-*"+sisip[10]+"*|*j_pupil*-*"+sisip[11]+"*|*d_spher*-*"+sisip[12]+"*|*d_cyl*-*"+sisip[13]+"*|*d_axis*-*"+sisip[14]+"*|*d_prism*-*"+sisip[15]+"*|*d_base*-*"+sisip[16]+"*|*d_spher2*-*"+sisip[17]+"*|*d_cyl2*-*"+sisip[18]+"*|*d_axis2*-*"+sisip[19]+"*|*d_prism2*-*"+sisip[20]+"*|*d_base2*-*"+sisip[21]+"*|*d_pupil*-*"+sisip[22]+"";
            fSetValue(window,p);
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
            var p="txtId*-**|*j_spher*-**|*j_cyl*-**|*j_axis*-**|*j_prism*-**|*j_base*-**|*j_spher2*-**|*j_cyl2*-**|*j_axis2*-**|*j_prism2*-**|*j_base2*-**|*j_pupil*-**|*d_spher*-**|*d_cyl*-**|*d_axis*-**|*d_prism*-**|*d_base*-**|*d_spher2*-**|*d_cyl2*-**|*d_axis2*-**|*d_prism2*-**|*d_base2*-**|*d_pupil*-*";
            fSetValue(window,p);
	
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
            a.loadURL("resep_kcmta_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resep Kacamata");
        a.setColHeader("NO,NAMA,PENGINPUT,TGL");
        a.setIDColHeader(",,,tgl_act");
        a.setColWidth("80,200,200,80");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("resep_kcmta_util.php?idPel=<?=$idPel?>");
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
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("resep_kcmta.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
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
