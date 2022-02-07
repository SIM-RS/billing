<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, a.TENSI as tekanan_darah, a.suhu as suhu2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ket_pem_ulang_transfusi where id='$_REQUEST[id]'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
        <script language="javascript">
		function convertToRupiah(angka){
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return rupiah.split('',rupiah.length-1).reverse().join('');
		}
		function rupiah(){
		var nominal= document.getElementById("nominal").value;
		var rupiah = convertToRupiah(nominal);
		document.getElementById("nominal").value = rupiah;
		}
		function convertToRupiah2(angka){
		var rupiah2 = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah2 += angkarev.substr(i,3)+'.';
		return rupiah2.split('',rupiah2.length-1).reverse().join('');
		}
		function rupiah2(){
		var nominal2= document.getElementById("nominal2").value;
		var rupiah2 = convertToRupiah2(nominal2);
		document.getElementById("nominal2").value = rupiah2;
		}
		</script>
        <title>Laporan Medical Check Up</title>
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
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div align="center" id="form_in" style="display:block;">
<form name="form1" id="form1" action="laporan_medical_checkup_faal_paru_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="760" style="font:bold 15px tahoma;">RS PELINDO I</td>
  </tr>
  <tr>
    <td align="center" style="font:bold 15px tahoma;">KETERANGAN PEMERIKSAAN ULANG TRANSFUSI DARAH</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
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
        <td height="20" width="1">&nbsp;</td>
        <td width="52"></td>
        <td width="24"></td>
        <td width="134"></td>
        <td width="16"></td>
        <td width="60"></td>
        <td width="47"></td>
        <td width="96"></td>
        <td width="9"></td>
        <td width="88"></td>
        <td width="45"></td>
        <td width="54"></td>
        <td width="51"></td>
        <td width="25"></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12">Tindakan transfusi darah sebagai upaya pegobatan mengandung resiko penularan berbagai penyakit, antara lain Hepatitis virus B dan Hepatitis virus C yang dapat menyebabkan radang hati menahun sampai kanker hati, serta HIV yang menyebabkan AIDS.</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12">Sehubungan dengan hal tersebut diatas RS PELINDO I mengusulkan dan menyediakan pemeriksaan ulang untuk mendeteksi kemungkinan adanya ketiga jenis virus itu dalam darah/komponen darah melalu pemeriksaan HBsAg, Anti HCV dan Anti HIV. Pemeriksaan ulang ini diharapkan dapat memperkecil resiko tertular ketiga penyakit tersebut, tetapi tetap tidak menjamin timbulnya penyakit dikarenakan adanya &quot;Window Period&quot;. Biaya Pemeriksaan Ulang sebesar Rp. <?=$dG['nominal'];?> per kantong darah/komponen darah. Harga darah/komponen darah itu sebesar Rp. <?=$dG['nominal2'];?> per kantong (sesuai ketentuan UTD PMI Medan) biaya tersebut tetap dibabankan kepada pasien, walaupun oleh suatu sebab, darah yang dipesan tidak ditransfusikan.</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12">Silahkan anda menandatangani keterangan ini sebagai tanda persetujuan anda terhadap tindakan pemeriksaan ulang HBsAg, Anti HIV.</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td style="border-top:1px solid #000" colspan="12">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">Yang bertanda tangan di bawah ini:</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Nama</td>
        <td colspan="6">:
          <label for="textfield"></label>
          <?=$dG['name'];?></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Alamat</td>
        <td colspan="10">:
          <label for="textfield"></label>
          <?=$dG['address'];?></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Hubungan dengan pasien</td>
        <td colspan="10">:
          <label for="textfield"></label>
          <label for="select"></label>
          <?=$dG['hubungan'];?></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">Menyatakan :</td>
        <td colspan="3"><input disabled="disabled" type="radio" name="radio[0]" id="radio[]" value="1" <? if ($dG['menyatakan']=='1') { echo "checked='checked'";}?>/>
          <label for="radio">Memohon / Menyetujui</label></td>
        <td colspan="5"><input disabled="disabled" type="radio" name="radio[0]" id="radio[]" value="2" <? if ($dG['menyatakan']=='2') { echo "checked='checked'";}?>/>
          <label for="radio2">Tidak Memohon / Tidak Menyetujui</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="7">Pemeriksaan ulang HBsAg, Anti HCV, dan Anti HIV</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">Yang akan dilakukan terhadap:</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Nama</td>
        <td colspan="6">:
          <label for="textfield">
            <?=$dP['nama'];?>
          </label></td>
        <td>Umur</td>
        <td colspan="3">: 
          <?=$dP['usia'];?> Tahun</td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">No. Med. Rec</td>
        <td colspan="10">:
          <label for="textfield"></label>
          <?=$dP['no_rm'];?></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Jenis Kelamin</td>
        <td colspan="10">:
          <label for="textfield"></label>
          <label for="select"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></label></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Aamat</td>
        <td colspan="10">:
          <label for="textfield"></label>
          <?=$dP['alamat'];?></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">Persetujuan ini dibuat dengan kesadaran penuh akan segala resiko yang akan terjadi dan biaya yang ditimbulkannya.</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">Medan, <?php echo date("j F Y")?></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4" >&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Pemohon:</td>
        <td></td>
        <td colspan="3">Mengetahui:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">&nbsp;</td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">(
          <strong><?=$dG['name'];?></strong>
          )<br />Nama Jelas</td>
        <td colspan="4">(<strong>
          <?=$dP['dr_rujuk'];?>
          </strong>)<br />Nama Jelas</td>
        <td colspan="4">()<br />/Jabatan</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">&nbsp;</td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      
      <div align="center"><button onclick="window.print()" type="button">Print</button>&nbsp;
	<button onclick="window.close()" type="button">Close</button></div>
      
      </td>
  </tr>
  
</table>
</form>
</div>

<div id="tampil_data" align="center"></div>
</body>
<script type="text/javascript">

		function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('keterangan')){
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
			$('#id').val(sisip[0]);
			$('#keterangan').val(sisip[1]);
			$('#means1').val(sisip[2]);
			$('#means2').val(sisip[3]);
			$('#means3').val(sisip[4]);
			$('#means4').val(sisip[5]);
			$('#means5').val(sisip[6]);
			$('#means6').val(sisip[7]);
			$('#means7').val(sisip[8]);
			$('#means8').val(sisip[9]);
			$('#pr1').val(sisip[10]);
			$('#pr2').val(sisip[11]);
			$('#pr3').val(sisip[12]);
			$('#pr4').val(sisip[13]);
			$('#pr5').val(sisip[14]);
			$('#pr6').val(sisip[15]);
			$('#pr7').val(sisip[16]);
			$('#pr8').val(sisip[17]);
			$('#p1').val(sisip[18]);
			$('#p2').val(sisip[19]);
			$('#p3').val(sisip[20]);
			$('#p4').val(sisip[21]);
			$('#p5').val(sisip[22]);
			$('#p6').val(sisip[23]);
			$('#p7').val(sisip[24]);
			$('#p8').val(sisip[25]);
			$('#kesan').val(sisip[26]);
			$('#anjuran').val(sisip[27]);
			centang(sisip[28]);
			centang2(sisip[29]);
			//cek(sisip[4]);
			/*$('#txt_biokimia_eval').val(sisip[4]);
			$('#txt_fisik').val(sisip[5]);
			$('#txt_fisik_eval').val(sisip[6]);
			$('#txt_gizi').val(sisip[7]);
			$('#txt_gizi_eval').val(sisip[8]);
			$('#txt_RwytPersonal').val(sisip[9]);
			$('#txt_RwytPersonal_eval').val(sisip[10]);
			$('#txt_diagnosa').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txt_intervensi').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_monev').val(a.cellsGetValue(a.getSelRow(),5));*/
			$('#act').val('edit');
        }

        function hapus(){
            var rowid = document.getElementById("id").value;
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
            var rowid = document.getElementById("id").value;
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
			//resetF();
			$('#form_in').slideUp(1000,function(){
		//toggle();
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
            a.loadURL("laporan_medical_checkup_faal_paru_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Laporan Medical Check Up Pemeriksaan Faal Paru");
        a.setColHeader("NO,NO RM,KETERANGAN,KESAN,ANJURAN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,300,100,100");
        a.setCellAlign("center,center,left,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("laporan_medical_checkup_faal_paru_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("laporan_medical_checkup_faal_paru_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
		
		function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}
		
		function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
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
    </script>
</html>
