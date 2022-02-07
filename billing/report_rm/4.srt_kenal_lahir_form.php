<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.nama AS pasien,p.no_rm,p.no_ktp,p.`nama_suami_istri`,CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat,pk.nama AS pekerjaan
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_pekerjaan pk ON p.pekerjaan_id=pk.id
LEFT JOIN b_ms_wilayah w ON p.desa_id = w.id
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id
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

include "setting.php";

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

<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />
<link rel="stylesheet" type="text/css" href="../include/jquery/jquery-ui-timepicker-addon.css" />
<!--<script src="../js/jquery-1.8.3.js"></script>-->
<script src="../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../include/jquery/jquery-ui-timepicker-addon.js"></script>
<!--<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>-->

<script>
$(function() {
	$( "#tgl_kelahiran" ).datetimepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../images/cal.gif",
		buttonImageOnly: true,
		timeFormat: "HH:mm:ss"
	});
});
</script>
        
        <title>Surat Kenal Lahir</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:100px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
          <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
    </head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
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
                <form name="form1" id="form1" action="4.srt_kenal_lahir_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table width="894" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="6">RS PELINDO I </td>
  </tr>
  
  
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><div align="center" class="style1">SURAT KENAL LAHIR </div></td>
  </tr>
  <tr>
    <td colspan="6"><div align="center">No.&nbsp;<input type="text" id="nomor" name="nomor" /></div></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">Yang bertanda tangan dibawah ini : </td>
  </tr>
  <tr>
    <td width="48">&nbsp;</td>
    <td colspan="2">Nama</td>
    <td width="5">:</td>
    <td colspan="2">&nbsp;<input type="text" id="nama" name="nama" /></td>
  </tr>
  <tr>
    <td colspan="6">Menerangkan bahwa kami telah tolong/rawat* bayi : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Nama Bayi </td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="nama_bayi" name="nama_bayi" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Jenis Kelamin </td>
    <td>:</td>
    <td colspan="2">&nbsp;<label><input type="radio" id="jenis_kel" name="jenis_kel" value="1" />Pria</label><label><input type="radio" id="jenis_kel" name="jenis_kel" value="0" />Wanita</label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Anak dari :</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="21">&nbsp;</td>
    <td width="141">Ibu</td>
    <td>:</td>
    <td colspan="2"><?=$dP["pasien"]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No. Kartu Identitas </td>
    <td>:</td>
    <td colspan="2"><?=$dP["no_ktp"]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Ayah</td>
    <td>:</td>
    <td colspan="2"><?=$dP["nama_suami_istri"]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No. Kartu Identitas </td>
    <td>:</td>
    <td colspan="2"><?=$dP[""]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat Rumah </td>
    <td>:</td>
    <td colspan="2"><?=$dP["alamat"]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Pekerjaan</td>
    <td>:</td>
    <td colspan="2"><?=$dP["pekerjaan"]?></td>
  </tr>
  <tr>
    <td colspan="3">Nomor Registrasi pasien/ibu </td>
    <td>:</td>
    <td colspan="2"><?=$dP["no_rm"]?></td>
  </tr>
  
  <tr>
    <td colspan="3">Kelahiran ditolong pada </td>
    <td>:</td>
    <td width="74">a. Hari</td>
    <td width="579" rowspan="3">&nbsp;
      <input type="text" id="tgl_kelahiran" name="tgl_kelahiran" value="<?=date('d-m-y H:i:s')?>" /></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>b. Tanggal </td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>c. Jam </td>
    </tr>
  <tr>
    <td colspan="3">Proses Persalinan </td>
    <td>:</td>
    <td> Normal </td>
    <td>:&nbsp;<input type="text" id="salin_normal" name="salin_normal" /></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tindakan</td>
    <td>:&nbsp;<input type="text" id="salin_tindakan" name="salin_tindakan" /></td>
  </tr>
  <tr>
    <td colspan="3">Anak ke </td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="anak_ke" name="anak_ke" /></td>
  </tr>
  <tr>
    <td colspan="3">Kembar</td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="kembar" name="kembar" /></td>
  </tr>
  <tr>
    <td colspan="3">Panjang</td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="panjang" name="panjang" />&nbsp;cm</td>
  </tr>
  <tr>
    <td colspan="3">Berat badan </td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="berat" name="berat" />&nbsp;gram</td>
  </tr>
  <tr>
    <td colspan="3">Lingkar Kepala </td>
    <td>:</td>
    <td colspan="2">&nbsp;<input type="text" id="lingkar" name="lingkar" />&nbsp;cm</td>
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
jQuery(function(){
		jQuery("#panjang, #berat, #lingkar, #anak_ke, #kembar").keydown(function(e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ( jQuery.inArray(e.keyCode,[46,8,9,27,13,190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			} else {
				// Ensure that it is a number and stop the keypress
				if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
					e.preventDefault(); 
				}   
			}
		});
	});
	
		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('nomor,nama,nama_bayi','ind')){
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
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#nomor').val(a.cellsGetValue(a.getSelRow(),2));
			$('#nama').val(a.cellsGetValue(a.getSelRow(),3));
			$('#nama_bayi').val(a.cellsGetValue(a.getSelRow(),4));
			$('#tgl_kelahiran').val(a.cellsGetValue(a.getSelRow(),7));
			$('#salin_normal').val(sisip[3]);
			$('#salin_tindakan').val(sisip[4]);
			$('#anak_ke').val(sisip[5]);
			$('#kembar').val(sisip[6]);
			$('#panjang').val(sisip[7]);
			$('#berat').val(sisip[8]);
			$('#lingkar').val(sisip[9]);
			$('#act').val('edit');
			centang(sisip[1]);
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
            a.loadURL("4.srt_kenal_lahir_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Surat Kenal Lahir");
        a.setColHeader("NO,Nomor,Nama,Nama Bayi,Ibu,Ayah,Waktu Kelahiran,PENGGUNA");
        a.setIDColHeader(",nomor,nama,nama_bayi,,,,");
        a.setColWidth("50,150,150,150,100,150,150,100");
        a.setCellAlign("center,left,left,left,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("4.srt_kenal_lahir_util.php?idPel=<?=$idPel?>");
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
		window.open("4.srt_kenal_lahir.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['jenis_kel'];

		 
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

	}
    </script>
    
</html>
