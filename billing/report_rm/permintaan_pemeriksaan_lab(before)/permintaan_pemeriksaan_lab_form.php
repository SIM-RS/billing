<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
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

include"setting.php";
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
	$('#jam_tiba').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_kaji').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_terima').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <title>PERMINTAAN PEMERIKSAAN LAB</title>
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
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<iframe width=174 height=189 name="gToday:normal:js/calender/agenda.js" id="gToday:normal:js/calender/agenda.js" src="js/calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" bordercolor="#FF0000" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:block;">
                <form name="form1" id="form1" action="permintaan_pemeriksaan_lab_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
<table width="1000" border="0" bordercolor="#000000" style="border-collapse:collapse; font:tahoma">
  <tr>
    <td><div align="right" class="style2"><strong>PELAYANAN 24 JAM </strong></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" style="font:12px tahoma">
      <tr>
        <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="61%" height="69"><span class="style2">RS PELINDO I </span></td>
        <td width="39%" rowspan="2"><table width="100%" border="0" style="border:1px solid #000000; font:10px tahoma">
          <tr>
            <td width="26%">Nama Pasien </td>
            <td width="2%">:</td>
            <td colspan="2"> <?=$nama;?> (<?=$sex;?>)</td>
            </tr>
          <tr>
            <td>Tanggal Lahir </td>
            <td>:</td>
            <td width="34%"><?=$tgl;?> </td>
            <td>Usia : 
              <?=$umur;?> 
              th </td>
            </tr>
          <tr>
            <td>No. RM </td>
            <td>:</td>
            <td><?=$noRM;?></td>
            <td>No. registrasi: </td>
            </tr>
          <tr>
            <td>Ruang Rawat / Kelas </td>
            <td>:</td>
            <td colspan="2"><?=$kamar;?> / <?=$kelas;?></td>
            </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="2"><?=$alamat;?></td>
            </tr>
          <tr>
            <td height="28" colspan="4"><div align="center"><strong>(Tempelkan Stiker Identitas Pasien) </strong></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN LABOLATORIUM </span></td>
      </tr>
    </table></td>
      </tr>
      <tr>
        <td>No. Formulir : <input type="text" name="txt_noForm" id="txt_noForm" /> </td>
      </tr>
      <tr>
        <td><table width="100%" border="1" style="border-collapse:collapse">
          <tr>
            <td><table width="100%" border="0" style="font:10px tahoma;border-collapse:collapse">
              <tr>
                <td width="50%" rowspan="3" style="border-right:1px solid #000000"><strong>Diagnosis / Keterangan Klinis : <?php echo $diag;?></strong></td>
                <td width="11%"><div align="right"><strong>Diterima Tanggal  </strong></div></td>				
				<td width="39%"> : 
				<label for="tgl_terima"></label>
<!--				<input type="text" name="tgl_terima" id="tgl_terima" onclick="gfPop.fPopCalendar(document.getElementById('tgl_terima'),depRange);" value="<?=date('d-m-Y')?>" /> -->
				<input class="textbox" type="text" id="tgl_terima" name="tgl_terima" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_terima);return false;" value="<?=date('d-m-Y')?>"/>
				</td>
              </tr>
              <tr>
                <td><div align="right"><strong>Jam</strong></div></td>
				<td>: <input name="jam_terima" type="text" class="input150" id="jam_terima" value="<?=date('H:i:s')?>" />
				</td>
				</tr>
              <tr>
                <td><div align="right"><strong>Petugas</strong></div></td>
				<td><strong>: <?php echo $dokter;?> </strong></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right" class="style3">FORM-LAB-01-00</div></td>
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
                    <td align="center" colspan="3">
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
            if(ValidateForm('txt_noForm','ind')){
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
			$('#txt_noForm').val(sisip[1]);
			$('#act').val('edit');
			centang(sisip[2]);
			alert(tes);

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
            a.loadURL("permintaan_pemeriksaan_lab_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Permintaan Pemeriksaan Laboratorium");
        a.setColHeader("NO,NO RM,NO FORMULIR,TGL TERIMA,JAM TERIMA,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("100,150,100,100,100,150,100");
        a.setCellAlign("center,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("permintaan_pemeriksaan_lab_util.php?idPel=<?=$idPel?>");
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
		window.open("permintaan_pemeriksaan_lab.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes)
{
		//var list=tes.split('*=*');
//		var list1 = document.form1.elements['radio[]'];
		var list2 = document.form1.elements['isi_chk[]'];
				 
/*		if ( list1.length > 0 )
		{
		 for (i = 0; i < 41; i++)
			{
			var val=list[0].split(',');	
			var listx = document.form1.elements['radio['+i+']'];
					//alert('radio['+i+']');
			for (j = 0; j < listx.length; j++)
				{
				if (listx[j].value==val[i])
			  		{
			   			listx[j].checked = true;
			  		}
				else
					{
						listx[j].checked = false;
					}	
				}
		  }
		}*/
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			var val=tes.split(',');
			  if (list2[i].value==val[i])
			  {
			   list2[i].checked = true;
			  }else{
					list2[i].checked = false;
					}
		  }
		}
	}
    </script>
    
</html>
