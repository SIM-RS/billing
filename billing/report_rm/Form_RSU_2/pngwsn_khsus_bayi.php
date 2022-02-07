<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
$sql = "SELECT * FROM b_ms_pengawasan_khusus_bayi";

$query = mysql_query($sql);
while ($data = mysql_fetch_array ($query))
{
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));*/

}
$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  mp.sex,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex2,
  mk.nama kelas,
  md.nama AS diag,
  peg.nama AS dokter,
  kso.nama nmKso,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  DATE_FORMAT(mp.tgl_lahir, '%d %M %Y') tgl_lahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bmk.nama kelas,
  mp.nama_ortu,
  DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') AS tgl_lahir
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  LEFT JOIN b_ms_agama bagm
    ON bagm.id = mp.agama 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  LEFT JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
  LEFT JOIN b_ms_unit un 
    ON un.id = p.unit_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act 
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id
  LEFT JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  LEFT JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
  LEFT JOIN b_ms_kelas bmk
    ON bmk.id = p.kelas_id
WHERE k.id='$idKunj' AND p.id='$idPel'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);
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
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <title>Form Pengawasan Khusus Bayi</title>
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
<title>Untitled Document</title>
</head>          
<body>
<div align="center">
<table width="1188" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td colspan="5" align="center">
			<?php
           // include("../../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>            </td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table cellspacing="0" cellpadding="0" width="200">
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
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  </div>
  <div style="display:none;" align="center" id="input_data">
  <form id="form1" action="pngwsn_khsus_bayi_act.php">
  <table width="1188" border="0" align="center" cellpadding="2" cellspacing="0" >
  <tr>
    <td colspan="5" align="center">
      <table width="660" style="border:1px solid #000;" class="tabel">
      <tr>
        <td width="92" style="border-bottom:.5pt solid black;">NAMA BAYI</td>
        <td width="194" style="border-bottom:.5pt solid black;">:
          <label>
            <input type="hidden" size="2" name="act" id="act" value="tambah" />
            <input type="hidden" name="id" id="id" value="" />
            <input type="hidden" name="idPel" id="idPel" value="<?php echo $idPel; ?>" />
            <input type="hidden" name="idUser" id="idUser" value="<?php echo $idUser; ?>" />
      			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
      			<input type="hidden" name="idPasien" value="<?=$idPasien?>" />
            <input name="nama" type="hidden" id="nama" value="<?=$isi['nmPas']?>" /><input disabled="disabled" name="nama2" type="text" id="nama2" value="<?=$isi['nmPas']?>" />
            </label>        </td>
        <td width="154" style="border-bottom:.5pt solid black;">NAMA IBU</td>
        <td width="200" style="border-bottom:.5pt solid black;">:<?=$isi['nama_ortu']?></td>
      </tr>
      <tr>
        <td style="border-bottom:.5pt solid black;">TGL LAHIR</td>
        <td style="border-bottom:.5pt solid black;">:
          <input name="tgl_lahir" type="hidden" id="tgl_lahir" value="<?=$isi['tgl_lahir']?>" /><input disabled="disabled" name="tgl_lahir2" type="text" id="tgl_lahir2" value="<?=$isi['tgl_lahir']?>" /></td>
        <td style="border-bottom:.5pt solid black;">NO. REGISTRASI</td>
        <td style="border-bottom:.5pt solid black;">: </td>
      </tr>
      <tr>
        <td>RUANGAN</td>
        <td>: <?=$isi['kelas']?></td>
        <td>NO. REKAM MEDIS</td>
        <td>: <?=$isi['no_rm']?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5">
    <table width="800" border="1" align="center" cellpadding="0" cellspacing="0">
      <col width="24" span="10" />
      <col width="30" />
      <col width="24" />
      <col width="30" />
      <col width="24" span="13" />
      <col width="31" />
      <tr align="center">
        <td colspan="3">TGL/JAM</td>
        <td colspan="2">KU</td>
        <td colspan="2">SUHU</td>
        <td colspan="2">NADI</td>
        <td colspan="2">PERNAFASAN</td>
        <td colspan="2">MINUM</td>
        <td colspan="2">INFUS</td>
        <td colspan="2">MT</td>
        <td colspan="2">BAB</td>
        <td colspan="2">BAK</td>
        <td width="144" colspan="4">KETERANGAN</td>
        <!--<td colspan="2">PARAF PERAWAT</td>-->
      </tr>
      <tr>
        <td colspan="3" height="10" valign="top"><label for="tgl_jam"></label>
          <input name="tgl_jam" type="hidden" id="tgl_jam" size="12" value="<?=date('Y-m-d H:i:s');?>" /><input disabled="disabled" name="tgl_jam2" type="text" id="tgl_jam2" size="16" value="<?=date('d-m-Y H:i:s');?>" /></td>
        <td colspan="2" valign="top"><input name="ku" type="text" id="ku" value="" size="30" /></td>
        <td colspan="2" valign="top"><input name="suhu" type="text" id="suhu" value="" size="8" /></td>
        <td colspan="2" valign="top"><input name="nadi" type="text" id="nadi" value="" size="8" /></td>
        <td colspan="2" valign="top"><input name="pernafasan" type="text" id="pernafasan" value="" size="18" /></td>
        <td colspan="2" valign="top"><input name="minum" type="text" id="minum" value="" size="10" /></td>
        <td colspan="2" valign="top"><input name="infus" type="text" id="infus" value="" size="8" /></td>
        <td colspan="2" valign="top"><input name="mt" type="text" id="mt" value="" size="5" /></td>
        <td colspan="2" valign="top"><input name="bab" type="text" id="bab" value="" size="6" /></td>
        <td colspan="2" valign="top"><input name="bak" type="text" id="bak" value="" size="6" /></td>
        <td colspan="4" valign="top"><input name="keterangan" type="text" id="keterangan" value="" /></td>
        <!--<td colspan="2" valign="top"><input name="paraf" type="text" id="paraf" size="15" /></td>-->
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
    </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  </table>
  </form>
</div>
  <div align="center" id="tampil_data">
  <table width="1188" border="0" align="center" cellpadding="2" cellspacing="0">
  
  
  <tr>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php
                    if($_REQUEST['report']!=1){
					?><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/><?php }?></td>
    <td width="12%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="center"><div id="gridbox" style="width:1000px; height:300px; background-color:white; overflow:hidden;"></div>      
      <div id="paging" style="width:700px;"></div></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="78%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  </td>
  </tr>
</table>
</div>
</body>
<script type="text/javascript">
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

        
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#input_data').slideDown(1000,function(){
		toggle();
		});
			//$('#tampil_data').slideUp(1000);
			$('#act').val('tambah');
		}
		
		function edit()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk di update");
				}
				else
				{
					$('#act').val('edit');
					$('#input_data').slideDown(1000,function(){
		toggle();
		});
					
				}
        }
		
		function hapus()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk dihapus");
				}
				else if(confirm("Anda yakin menghapus data ini ?"))
				{
					$('#act').val('hapus');
					$("#form1").ajaxSubmit(
							{
					  success:function(msg)
							{
						alert(msg);
						goFilterAndSort();
						
					  		},
						});
				}
				else
				{
					document.getElementById('id').value="";
				}
        }

        function batal()
		{
			$('#input_data').slideUp(1000,function(){
		toggle();
		});
			//$('#tampil_data').slideDown(1000);
			document.getElementById('id').value="";
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
            a.loadURL("pngwsn_khsus_bayi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pengawasan Khusus Bayi");
        a.setColHeader("NO,NAMA BAYI,TANGGAL LAHIR,TGL/JAM,KU,SUHU,NADI,PERNAFASAN,MINUM,INFUS,MT,BAB,BAK,KETERANGAN,PENGGUNA");
        a.setIDColHeader(",,,,,,,,,,,,,");
        a.setColWidth("20,100,90,120,100,40,40,80,60,40,30,30,30,120,100");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pngwsn_khsus_bayi_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
		function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			}
			//else
//			{	
				window.open("pngwsn_khsus_bayi_r.php?id="+id+"&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			//}
			
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
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>
