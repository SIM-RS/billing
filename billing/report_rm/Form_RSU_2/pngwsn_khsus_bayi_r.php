<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$id=$_REQUEST['id'];
//$sqlP = "select * from b_ms_pengawasan_khusus_bayi where id='$id' ";
//$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser'"));
$sqlP="SELECT pn.*,ps.nama_ortu as nama2,pg.nama as nama3,ps.no_rm as norm,d.nama as unit,DATE_FORMAT(pn.tgl_lahir, '%d-%m-%Y') tgllahir, DATE_FORMAT(pn.tgl_jam, '%d-%m-%Y') tgl, DATE_FORMAT(pn.tgl_jam, '%H:%i:%s') jam
FROM b_ms_pengawasan_khusus_bayi pn
LEFT JOIN b_pelayanan p ON p.id=pn.pelayanan_id
LEFT JOIN b_ms_pasien ps ON ps.id=p.pasien_id
LEFT JOIN b_ms_pegawai pg ON pg.id=p.user_act
LEFT JOIN b_ms_unit d ON d.id=p.unit_id 
WHERE pn.id='$id';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
{
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));*/
?>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        
        <title>Form Pengawasan Khusus Bayi</title>
       
<title>Untitled Document</title>
</head>          
<body>

<table width="1009" border="0" cellpadding="2" cellspacing="0" style="border:1px solid #000000">
<tr>
<td width="605" colspan="-2">&nbsp;</td>
</tr>
  <tr>
    <td colspan="2"><table width="200" align="center" cellpadding="0" cellspacing="0">
      <col width="24" span="10" />
      <col width="30" />
      <col width="24" />
      <col width="30" />
      <col width="24" span="13" />
      <col width="31" />
      <tr>
        <td width="24" align="left" valign="top"><img src="pngwsn_khsus_bayi_clip_image002.png" alt="" width="317" height="61" />
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td width="24"></td>
              </tr>
          </table></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="30"></td>
        <td width="24"></td>
        <td width="30"></td>
        <td width="24" align="left" valign="top"><img src="pngwsn_khsus_bayi_clip_image004.png" alt="" width="345" height="51" />
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td width="24"></td>
              </tr>
          </table></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="31"></td>
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
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="2" align="center">
      <table width="660" class="tabel" style="border:1px solid #000;">
      <tr>
        <td width="92" style="border-bottom:.5pt solid black;">NAMA BAYI</td>
        <td width="194" style="border-bottom:.5pt solid black;">:
          <label></label>        <?=$dP['nama']?></td>
        <td width="154" style="border-bottom:.5pt solid black;">NAMA IBU</td>
        <td width="200" style="border-bottom:.5pt solid black;">: <?=$dP['nama2']?></td>
      </tr>
      <tr>
        <td style="border-bottom:.5pt solid black;">TGL LAHIR</td>
        <td style="border-bottom:.5pt solid black;">:          <?=$dP['tgllahir']?></td>
        <td style="border-bottom:.5pt solid black;">NO. REGISTRASI</td>
        <td style="border-bottom:.5pt solid black;">: </td>
      </tr>
      <tr>
        <td>RUANGAN</td>
        <td>: 
          <?=$dP['unit']?>
        </td>
        <td>NO. REKAM MEDIS</td>
        <td>: 
          <?=$dP['norm']?>
        </td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td height="53" colspan="2">
    <table width="968" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
      <col width="24" span="10" />
      <col width="30" />
      <col width="24" />
      <col width="30" />
      <col width="24" span="13" />
      <col width="31" />
      <tr align="center">
        <td height="24" colspan="3" valign="middle">TGL/JAM</td>
        <td height="24" colspan="2" valign="middle">KU</td>
        <td height="24" colspan="2" valign="middle">SUHU</td>
        <td height="24" colspan="2" valign="middle">NADI</td>
        <td height="24" colspan="2" valign="middle">PERNAFASAN</td>
        <td height="24" colspan="2" valign="middle">MINUM</td>
        <td height="24" colspan="2" valign="middle">INFUS</td>
        <td height="24" colspan="2" valign="middle">MT</td>
        <td height="24" colspan="2" valign="middle">BAB</td>
        <td height="24" colspan="2" valign="middle">BAK</td>
        <td height="24" colspan="4" valign="middle">KETERANGAN</td>
        <td width="75" height="24" colspan="2" valign="middle">PARAF PERAWAT</td>
      </tr>
      <tr>
        <td height="51" colspan="3" align="center" valign="middle"><label for="tgl_jam"><span>
          <?=$dP['tgl'];?> / <?=$dP['jam'];?>
        </span>
        </label></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['ku']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['suhu']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['nadi']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['pernafasan']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['minum']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['infus']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['mt']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['bab']?>
        </span></td>
        <td colspan="2" align="center" valign="middle"><span>
          <?=$dP['bak']?>
        </span></td>
        <td colspan="4" align="center" valign="middle"><span>
          <?=$dP['keterangan']?>
        </span></td>
        <td colspan="2" align="center" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="232" colspan="2">Medan, <?php echo date("j F Y")?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Doktor</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">( <strong><u><?=$dP['nama3']?></u></strong> )</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
      <input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="window.print()" />
    </div></td>
  </tr>
  </table>
</body>
<script type="text/javascript">
/*function simpan()
{
	var nama = document.getElementById('nama').value;
	var ku = document.getElementById('ku').value;
	var suhu = document.getElementById('suhu').value;
	var nadi = document.getElementById ('nadi').value;
	var pernafasan = document.getElementById('pernafasan').value;
	var minum = document.getElementById('minum').value;
	var infus = document.getElementById('infus').value;
	var mt = document.getElementById('mt').value;
	var bab = document.getElementById('bab').value;
	var bak = document.getElementById('bak').value;
	var keterangan = document.getElementById('keterangan').value;
	
	if(nama=='')
	{
		alert('Mohon Isi Nama');
		document.getElementById('nama').focus();
	}
	else if(ku=='')
	{
		alert('Mohon Isi KU');
		document.getElementById('ku').focus();
	}
	else if(suhu=='')
	{
		alert('Mohon Isi Suhu');
		document.getElementById('suhu').focus();
	}
	else if(nadi=='')
	{
		alert('Mohon Isi Nadi');
		document.getElementById('nadi').focus();
	}
	else if(pernafasan=='')
	{
		alert('Mohon Isi Pernafasan');
		document.getElementById('pernafasan').focus();
	}
	else if(minum=='')
	{
		alert('Mohon Isi Minum');
		document.getElementById('minum').focus();
	}
	else if(infus=='')
	{
		alert('Mohon Isi Infus');
		document.getElementById('infus').focus();
	}
	else if(mt=='')
	{
		alert('Mohon Isi MT');
		document.getElementById('mt').focus();
	}
	else if(bab=='')
	{
		alert('Mohon Isi BAB');
		document.getElementById('bab').focus();
	}
	else if(bak=='')
	{
		alert('Mohon Isi BAK');
		document.getElementById('bak').focus();
	}
	else if(keterangan=='')
	{
		alert('Mohon Isi Keterangan');
		document.getElementById('keterangan').focus();
	}
		else
			{
	
				$("#form1").ajaxSubmit
				({
				  //target: "#pesan",
				  success:function(msg)
				  {
					alert (msg);
					if(msg=='Data Berhasil Disimpan')
					{
						$('#nama').val('');
						$('#ku').val('');
						$('#suhu').val('');
						$('#nadi').val('');
						$('#nama').val('');
						$('#pernafasan').val('');
						$('#minum').val('');
						$('#infus').val('');
						$('#mt').val('');
						$('#bab').val('');
						$('#bak').val('');
						$('#keterangan').val('');
						//$('#view').load('view_data_siswa.php');
						//hide_form_input_siswa();
					}
					/*else if (msg=='Data Siswa Berhasil Di Update')
					{
						$('#view').load('view_data_siswa.php');
						hide_form_input_siswa();
					}
					else (msg=='Data Agama Berhasil Di Delete')
					{
						$('#view').load('view_data_siswa.php');		
					}*/
				/*  },
				  //resetForm:true
				});
				return false;
			}
}*/



        function simpan(action){
            if(ValidateForm('nama,tgl_lahir,tgl_jam,ku,suhu,nadi,pernafasan,minum,infus,mt,bab,bak,keterangan')){
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
        
        /*function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }*/

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
			 var p="id*-*"+sisip[0]+"*|*nama*-*"+sisip[1]+"*|*tgl_lahir*-*"+sisip[2]+"*|*tgl_jam*-*"+sisip[3]+"*|*ku*-*"+sisip[4]+"*|*suhu*-*"+sisip[5]+"*|*nadi*-*"+sisip[6]+"*|*pernafasan*-*"+sisip[7]+"*|*minum*-*"+sisip[8]+"*|*infus*-*"+sisip[9]+"*|*mt*-*"+sisip[10]+"*|*bab*-*"+sisip[11]+"*|*bak*-*"+sisip[12]+"*|*keterangan*-*"+sisip[13]+"";
            fSetValue(window,p);
        }

        /*function hapus(){
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

        }*/
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#input_data').slideDown(1000);
		}
		
		function edit()
		{
            var rowid = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid=='')
				{
					alert("Pilih data terlebih dahulu");
				}
				else
				{
					$('#act').val('edit');
					$('#input_data').slideDown(1000);
					document.getElementById('id').value="";
				}

        }

        function batal()
		{
			$('#input_data').slideUp(1000);
			//$('#gridbox').reset();
        }
		
		/*function resetF(){
			$('#act').val('tambah');
            var p="txtId*-**|*j_spher*-**|*j_cyl*-**|*j_axis*-**|*j_prism*-**|*j_base*-**|*j_spher2*-**|*j_cyl2*-**|*j_axis2*-**|*j_prism2*-**|*j_base2*-**|*j_pupil*-**|*d_spher*-**|*d_cyl*-**|*d_axis*-**|*d_prism*-**|*d_base*-**|*d_spher2*-**|*d_cyl2*-**|*d_axis2*-**|*d_prism2*-**|*d_base2*-**|*d_pupil*-*";
            fSetValue(window,p);
	
			}*/


        /*function konfirmasi(key,val)
		{
            //alert(val);
            var tangkap=val.split("*|*");
            
            if(key=='Error')
			{
                if(proses=='hapus')
				{				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else
			{
                if(proses=='tambah')
				{
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan')
				{
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus')
				{
                    alert('Hapus Berhasil');
                }
            }

        }*/

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pngwsn_khsus_bayi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pengawasan Khusus Bayi");
        a.setColHeader("NO,NAMA BAYI,TANGGAL LAHIR,TGL/JAM,KU,SUHU,NADI,PERNAFASAN,MINUM,INFUS,MT,BAB,BAK,KETERANGAN");
        a.setIDColHeader(",,,,,,,,,,,,,");
        a.setColWidth("20,100,90,80,50,50,50,80,50,50,40,40,40,80");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pngwsn_khsus_bayi_util.php?id=<?=$id?>");
        a.Init();
		
		
		
		
		/*function cetak(){
		 var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{	
		window.open("resep_kcmta.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				}
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
	}*/
    </script>
</html>
