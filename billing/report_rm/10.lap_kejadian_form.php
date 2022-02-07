<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
//$sql = "SELECT * FROM b_ms_pengawasan_khusus_bayi";
$sql="SELECT * FROM b_ms_laporan_kejadian";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../unit_pelayanan/iframe.js"></script>
        <!-- end untuk ajax-->
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        
<script type="text/javascript" src="js/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        
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
<title>LAPORAN KEJADIAN</title></head>
<?
include "setting.php";
?>
<body>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<div align="center">
<table width="699" border="0" style="font:bold 12px tahoma;">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Tim Keselamatan Pasien </td>
  </tr>
  <tr>
    <td width="343">RS PELINDO I </td>
    <td width="98">Unit / Ruangan </td>
    <td width="244">: <?=$kamar;?> Kelas <?=$kelas;?></td>
  </tr>
</table>
<br />
<table width="700" border="0" style="font:bold 12px tahoma;">
  <tr>
    <td width="694" align="center">RAHASIA, TIDAK BOLEH DIFOTOCOPY,DILAPORKAN 2 X 24 JAM</td>
  </tr>
</table>
<br />
<table width="700" border="0" style="font:bold 18px tahoma;">
  <tr>
    <td width="694" align="center">LAPORAN KEJADIAN </td>
  </tr>
</table>
</div>
<br />
<div id="form_input" style="display:none" align="center">
<form id="form1" action="10.lap_kejadian_act.php">
<table width="700" border="0" style="font:12px tahoma;">
  <tr>
    <td width="31" align="center"><b>1</b></td>
    <td colspan="3"><b>Identitas Pasien</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="28">&nbsp;</td>
    <td width="136">&nbsp;</td>
    <td width="487">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Nama</td>
    <td>: <?=$nama;?> Umur : <?=$umur;?> Th &nbsp;&nbsp;Reg/RM : <?=$noRM;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Jenis Kelamin</td>
    <td>: <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($sex=='L') { echo "checked='checked'";}?> /> 
      Laki-laki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox"  <? if($sex=='P') { echo "checked='checked'";}?>/> 
      Perempuan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat</td>
    <td>:  <?=$alamat;?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tanggal Masuk RS </td>
    <td>: <?=$tglawalKunj;?> Jam : <?=$jamawalKunj;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Diagnosa Medis</td>
    <td>: <?=$diag;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dokter yang merawat </td>
    <td>: <?=$dokter;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center"><b>2</b></td>
    <td colspan="2"><b>Pokok Masalah (Kejadian)</b></td>
    <td>: 
      <label>
      <input type="hidden" size="2" name="act" id="act" value="tambah" />
      <input type="hidden" name="id" id="id" value="" />
      <input type="hidden" name="idPel" id="idPel" value="<?php echo $idPel; ?>" />
      <input name="pokok_masalah" type="text" id="pokok_masalah" size="40" />
      </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><strong>3</strong></td>
    <td colspan="2" valign="top"><b>Kronologis Kejadian</b></td>
    <td valign="top">:      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="258" colspan="3" valign="top"><label>
      <textarea name="kronologis" cols="70" rows="15" id="kronologis"></textarea>
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><b>4</b></td>
    <td colspan="2"><b>Jenis Kejadian</b></td>
    <td>: 
      <label>
      <select name="jenis_kejadian" id="jenis_kejadian">
      <option value="">--Pilih--</option>
        <option>Kejadian Nyaris Cedera/KNC (Near Miss)</option>
        <option>Kejadian tidak diharapkan/ KTD (Adverse Event)</option>
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>5</strong></td>
    <td colspan="2"><b>Pelapor Kejadian 
        <label></label>
    </b></td>
    <td><b>
      :
      <select name="pelapor" id="pelapor">
      <option value="">--Pilih--</option>
        <option>Pasien</option>
        <option>Karyawan</option>
        <option>Pengunjung</option>
        <option>Pendamoing</option>
      </select>
    </b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>6</strong></td>
    <td colspan="2"><b>Kejadian Mengenai</b></td>
    <td>: 
      <label>
      <select name="kejadian_mengenai" id="kejadian_mengenai">
      <option value="">--Pilih--</option>
        <option>Pasien</option>
        <option>Karyawan</option>
        <option>Pengunjung</option>
        <option>Pendamoing</option>
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>7</strong></td>
    <td colspan="3"><b>Tanggal dan Waktu Kejadian :</b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">Tanggal :  
      <label>
      <input type="text" name="tgl" id="tgl" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" />
      </label>
      Waktu : 
      <label>
      <input type="text" name="jam" id="jam" />
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>8</strong></td>
    <td colspan="2"><b>Tempat Kejadian :</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">Unit kerja  : 
      <label>
      <input type="text" name="unit_kerja" id="unit_kerja" />
      </label> 
      Lokasi Kejadian: 
      <label>
      <input type="text" name="lokasi_kejadian" id="lokasi_kejadian" />
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>9</strong></td>
    <td colspan="2"><b>Akibat Kejadian</b></td>
    <td>: 
      <label>
      <select name="akibat_kejadian" id="akibat_kejadian">
      <option value="">--Pilih--</option>
        <option>Kematian</option>
        <option>Perlu Perawatan RS</option>
        <option>Timbul Cidera</option>
        <option>Perpanjang Perawatan</option>
        <option>Timbul Kecacatan</option>
        <option>Lain-Lain</option>
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>10</strong></td>
    <td colspan="3"><b>Apakah kejadian yang sama pernah terjadi ditempat ini</b> :
      <select name="kejadian_sama" id="kejadian_sama">
        <option value="">--Pilih--</option>
        <option onclick="kejadian();">Ya</option>
        <option onclick="kejadian();">Tidak</option>
      </select></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td  colspan="3">
   	<div id="status" style="display:none">Jika Ya, sudah berapa kali ? <input style="display:inline" name="jumlah_kejadian" type="text" size="2" id="jumlah_kejadian"/>Kali</div>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>11</strong></td>
    <td colspan="3"><b>Tindakan yang dilakukan segera setelah kejadian dan hasilnya :</b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><label>
      <textarea name="tindakan" cols="70" rows="5" id="tindakan"></textarea>
    </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">tindakan dilakukan oleh:_______________(Dokter umum, Spesialis, Perawat/Lainnya)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><table width="572" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="121" height="30">Penerima Laporan </td>
        <td width="163">:____________</td>
        <td width="103">Pengirim Laporan </td>
        <td width="157">:_______________</td>
      </tr>
      <tr>
        <td height="30">Tanda Tangan </td>
        <td>:____________</td>
        <td>Tanda Tangan</td>
        <td>:_______________</td>
      </tr>
      <tr>
        <td height="30">Tanggal Menerima </td>
        <td>:____________</td>
        <td>Tanggal Melapor </td>
        <td>:_______________</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">*</td>
    <td colspan="3"><b>Grading Resiko Kejadian</b> : 
      <label>
      <select name="grading_resiko" id="grading_resiko">
      <option value="">--Pilih--</option>
        <option>Biru</option>
        <option>Hijau</option>
        <option>Kuning</option>
        <option>Merah</option>
      </select>
      </label></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">*</td>
    <td colspan="3">Diisi oleh atasan pelapor</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
      &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
    </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
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
    <td width="24%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="center"><div id="gridbox" style="width:700px; height:300px; background-color:white; overflow:hidden;"></div>      
      <div id="paging" style="width:700px;"></div></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="54%">&nbsp;</td>
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
            if(ValidateForm('pokok_masalah,kronologis,jenis_kejadian,pelapor,kejadian_mengenai,tgl,jam,unit_kerja,lokasi_kejadian,akibat_kejadian,kejadian_sama,tindakan,grading_resiko')){
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
			 var p="id*-*"+sisip[0]+"*|*pokok_masalah*-*"+sisip[1]+"*|*kronologis*-*"+sisip[2]+"*|*jenis_kejadian*-*"+sisip[3]+"*|*pelapor*-*"+sisip[4]+"*|*kejadian_mengenai*-*"+sisip[5]+"*|*tgl*-*"+sisip[6]+"*|*jam*-*"+sisip[7]+"*|*unit_kerja*-*"+sisip[8]+"*|*lokasi_kejadian*-*"+sisip[9]+"*|*akibat_kejadian*-*"+sisip[10]+"*|*kejadian_sama*-*"+sisip[11]+"*|*jumlah_kejadian*-*"+sisip[12]+"*|*tindakan*-*"+sisip[13]+"*|*grading_resiko*-*"+sisip[14]+"";
			 
			 $('#kronologis').val(sisip[2]);
			 $('#tindakan').val(sisip[13]);
			 
            fSetValue(window,p);
        }
		
		function kejadian()
		{
			var kejadian_sama = document.getElementById('kejadian_sama').value;
			if(kejadian_sama=="Ya")
			{
				$('#status').slideDown(600);
				
			}
			else
			{
				$('#status').slideUp(600);
				document.getElementById('jumlah_kejadian').value="";
			}
			//document.getElementById('act').value = "edit";
			
		}
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#form_input').slideDown(1000,function(){
				toggle();
			});
			$('#tampil_data').slideUp(1000);
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
					$('#form_input').slideDown(1000,function(){
						toggle();
					});
					kejadian();
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
			$('#form_input').slideUp(1000,function(){
		//toggle();
		});
			$('#tampil_data').slideDown(1000);
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
            a.loadURL("10.lap_kejadian_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Laporan Kejadian");
        a.setColHeader("NO,POKOK MASALAH,KRONOLOGIS,JENIS KEJADIAN,PELAPOR,MENGENAI,TANGGAL DAN WAKTU,UNIT KERJA,LOKASI KEJADIAN,AKIBAT KEJADIAN,STATUS,JUMLAH KEJADIAN,TINDAKAN,GRADING RESIKO");
        a.setIDColHeader(",,,,,,,,,,,,,");
        a.setColWidth("20,130,200,120,70,70,80,100,100,80,50,60,120,40");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("10.lap_kejadian_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
		function cetak()
		{
			var rowid = document.getElementById("id").value;
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(id=='')
//			{
//				alert("Pilih data terlebih dahulu untuk di cetak");
//			}
//			else
//			{	
				window.open("10.lap_kejadian.php?id="+rowid+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
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
