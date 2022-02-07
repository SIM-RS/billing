<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`,  an.`TENSI`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'";
$dP=mysql_fetch_array(mysql_query($sqlP));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
    <link type="text/css" rel="stylesheet" href="../js/jquery.timeentry.css" />
    <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <!-- untuk ajax-->
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
    <script type="text/javascript" src="../../jquery.js"></script>
    <script type="text/javascript" src="../../jquery.form.js"></script>
    <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
    <script type="text/javascript" src="../js/jquery.timeentry.min.js"></script>
    <!-- end untuk ajax-->
    
    <title>XXX</title>
    
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
    
	<style type="text/css">
		<!--
		.style2 {font-size: 10px}
		-->
    </style>
    
    <link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.8.4.custom.css" />
    <link rel="stylesheet" type="text/css" href="../../css/form.css" />
    <!--<link rel="stylesheet" type="text/css" href="../include/jquery/jquery-ui-timepicker-addon.css" />
    <script src="../js/jquery-1.8.3.js"></script>-->
    <script src="../../include/jquery/ui/jquery.ui.core.js"></script>
    <script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
    <script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
    <script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
    <script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>


<script type="text/JavaScript">
	var arrRange = depRange = [];
	function tanggalan(){			
		$(function() {
			$( ".tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../images/cal.gif",
			buttonImageOnly: true
			});	
		});
	}
	
	function jam(){			
		$(function () {
		$('.jam').timeEntry({show24Hours: true, showSeconds: true});
		});
	}
</script>

</head>

    <body onload="tanggalan()">
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
                <iframe height="193" width="168" name="gToday:normal:agenda.js"
        id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
        style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
    </iframe> 
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
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
                  <td colspan="3" align="center"><div id="form_in" style="display:blok;">
                <form name="form1" id="form1" action="resume_medis_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                <table width="805" border="0">
  <tr>
    <td width="799"><table width="900" cellpadding="0" cellspacing="0">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
      <tr>
        <td width="350" align="left" valign="top"><p align="center"><strong>PEMERINTAH KOTA MEDAN</strong></p>
          <p align="center"><strong>RUMAH SAKIT PELINDO I</strong></p>
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
        </table></td>
        <td colspan="9" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116" style="border-bottom:1px solid #000;"><strong>Nama Pasien</strong></td>
            <td width="10" style="border-bottom:1px solid #000;"><strong>:</strong></td>
            <td width="174" style="border-bottom:1px solid #000;"><?=$dP['nama']?></td>
          </tr>
          <tr >
            <td><strong>No. R.M.</strong></td>
            <td>:</td>
            <td><?=$dP['no_rm']?></td>
          </tr>
          
          
        </table></td>
        </tr>
      <tr>
        <td></td>
        <td width="35"></td>
        <td width="95"></td>
        <td width="12"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="120"></td>
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
        <td align="center">&nbsp;</td>
        <td colspan="9" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="10" align="center">
                        <table border=1 align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
            <tr bgcolor=#ababab>
              <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
              </tr>
            <tr bgcolor=#ababab>
              <td width="18" rowspan="2" align="center" bgcolor="#FFFFFF">NO</td>
              <td width="150" rowspan="2" align="center" bgcolor="#FFFFFF">Jenis Pemeriksaan/Pemakaian Obat/Alat Kesehatan</td>
              <td width="144" rowspan="2" align="center" bgcolor="#FFFFFF">Biaya</td>
              <td width="117" rowspan="2" align="center" bgcolor="#FFFFFF">Tanggal Disetujui</td>
              <td colspan="2" align="center" bgcolor="#FFFFFF">JAM PEMBERIAN</td>
              <td width="52" rowspan="2" align="center" bgcolor="#FFFFFF">Hapus</td>
            </tr>
            <tr bgcolor=#ababab>
            <td width="144" align="center" bgcolor="#FFFFFF">Pasien/Penanggung Jawab</td>
             <td width="146" align="center" bgcolor="#FFFFFF">Perawat</td>
            </tr>
            <tr>
            <td>
            	1
            </td>
            <td><input type='text' name='jenis[]' id=''></td>
            <td><input type='text' name='biaya[]' id=''></td>
            <td><input type='text' class="tgl" name='tgl[]' size="10"></td>
            <td><input type="text" id="p_jawab" name='p_jawab'></td>
         	<td><input type="text" id="perawat" name='perawat'></td>
            <td><input type='button' value='Delete' onclick='del()' /></td>
            </tr>
            </table>
        </td>
        </tr>
      <tr>
        <td height="2"></td>
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
    <td>&nbsp;</td>
  </tr>
</table>
                <p>&nbsp;</p>
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
            if(ValidateForm('txt_anjuran','ind')){
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
			$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#inObat').load("form_input_obat.php?id="+sisip[0]);
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
			$('#txt_anjuran').val('');
            $('#inObat').load("form_input_obat.php");
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
            a.loadURL("resum_medis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resum Medis");
        a.setColHeader("NO,NO RM,Anjuran,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("50,100,300,80,100");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("resum_medis_util.php?idPel=<?=$idPel?>");
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
		window.open("resume_medis.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
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
	
var idrow = 3;	
function tambahrow(){
	
    var x=document.getElementById('datatable').insertRow(idrow);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	
	
    td1.innerHTML="<input type='text' class='tgl' name='tgl[]' id='tgl"+idx+"'>";tanggalan();
	td2.innerHTML="<select id='hari' name='hari[]'><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select>";
    td3.innerHTML="<input type='text' class='jam' name='jam[]' id='jam"+idx+"'>";jam();
    td4.innerHTML="<input type='text' id='dokter' name='dokter[]'>";
	//url='tes.php';	
	td5.innerHTML="<input type='button' value='Delete' onclick='del()' />";
    idrow++;
}

function del(){
    if(idrow>3){
		//alert(idrow);
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}	

</script>

</html>
