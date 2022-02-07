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
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id 
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
        <title>CHECK LIST CATH FORM</title>
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
                <form name="form1" id="form1" action="6.check_list_cath_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table width="712" border="0" cellpadding="5" cellspacing="2" style="font:12px tahoma;">
  <tr>
    <td height="66" colspan="5"><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">: <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>: <?=$tgl;?></td>
        <td>Usia</td>
        <td>: <?=$umur;?> Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>: <?=$noRM;?></td>
        <td>No Registrasi </td>
        <td>: <?=$noreg;?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>: <?=$kamar;?> / <?=$kelas;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: <?=$alamat;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5">CHECK LIST PERSIAPAN PASIEN CATHETERISASI</td>
  </tr>
  <tr>
    <td width="98">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td colspan="2"><label for="tgl_list"></label>
      <input type="text" name="tgl_list" id="tgl_list" value="<?=date('d-m-Y');?>" onclick="gfPop.fPopCalendar(document.getElementById('tgl_list'),depRange);"/></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Dokter</td>
    <td colspan="2"><div style="display:none;"><label for="txt_dokter"></label>
      <input type="text" name="txt_dokter" id="txt_dokter" /></div><?=$dokter?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">Teknik Tindakan</td>
    <td colspan="2" valign="top"><textarea name="txt_tindakan" id="txt_tindakan" cols="45" rows="5"></textarea></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">Riwayat Penyakit</td>
    <td colspan="2"><div style="display:none;"><textarea name="txt_penyakit" id="txt_penyakit" cols="45" rows="5"></textarea></div><?=$identitas["RPS"]?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>TB</td>
    <td width="144"><div style="display:none;"><label for="txt_tb"></label>
      <input type="text" name="txt_tb" id="txt_tb" /></div><?=$identitas["TB"]?></td>
    <td width="281">BB 
      <div style="display:none;"><label for="txt_bb"></label>
      <input type="text" name="txt_bb" id="txt_bb" /></div><?=$identitas["BB"]?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="37"><b>Ya</b></td>
    <td width="90"><b>Tidak</b></td>
  </tr>
  <tr>
    <td colspan="3" height="30">1. Penderita dan keluarga dijelaskan tentang prosedur tindakan</td>
    <td ><input type="radio" name="list_1" id="list_1" value="1" />
      <label for="list_1"></label></td>
    <td><input type="radio" name="list_1" id="list_2" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">2. Surat Ijin Tindakan (Informed Consent)</td>
    <td><input type="radio" name="list_2" id="list_3" value="1" /></td>
    <td><input type="radio" name="list_2" id="list_4" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">3. Beritahu Petugas kasir dengan___________</td>
    <td><input type="radio" name="list_3" id="list_5" value="1" /></td>
    <td><input type="radio" name="list_3" id="list_6" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">4. Periksa EKG terbaru</td>
    <td><input type="radio" name="list_4" id="list_7" value="1" /></td>
    <td><input type="radio" name="list_4" id="list_8" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">5. Periksa Lab : Hematologi lengkap, GDS, Ureum, Kreatinin, BT, CT, INR, CCT, HBsAg, </td>
    <td><input type="radio" name="list_5" id="list_9" value="1" /></td>
    <td><input type="radio" name="list_5" id="list_10" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">&nbsp;&nbsp;&nbsp;Anti HIV, Anti HCV (Sesuai Instruksi dokter)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" height="30">6. Pasang IV line pada tangan kiri (RL/Nacl sesuai instruksi dokter</td>
    <td><input type="radio" name="list_6" id="list_11" value="1" /></td>
    <td><input type="radio" name="list_6" id="list_12" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">7. Puasa 2 jam untuk tindakan cath dan PTCA (Obat-obat tetap diberikan</td>
    <td><input type="radio" name="list_7" id="list_13" value="1" /></td>
    <td><input type="radio" name="list_7" id="list_14" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">8. Puasa 6 jam untuk tindakan DSA, TAE</td>
    <td><input type="radio" name="list_8" id="list_15" value="1" /></td>
    <td><input type="radio" name="list_8" id="list_16" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">9. Cukur pada lipatan paha kanan /kiri</td>
    <td><input type="radio" name="list_9" id="list_17" value="1" /></td>
    <td><input type="radio" name="list_9" id="list_18" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">10. Cukur pada pergelangan tangan kanan (Radial/ Brachial)</td>
    <td><input type="radio" name="list_10" id="list_19" value="1" /></td>
    <td><input type="radio" name="list_10" id="list_20" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">11. Cukur pada daerah dada kiri dan kanan untuk tindakan PPM</td>
    <td><input type="radio" name="list_11" id="list_21" value="1" /></td>
    <td><input type="radio" name="list_11" id="list_22" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">12. Daftarkan pasien pada petugas Cath-Lab/ ICCU dengan__</td>
    <td><input type="radio" name="list_12" id="list_23" value="1" /></td>
    <td><input type="radio" name="list_12" id="list_24" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">13. Pasien diturunkan sudah memakai baju tindakan</td>
    <td><input type="radio" name="list_13" id="list_25" value="1" /></td>
    <td><input type="radio" name="list_13" id="list_26" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">14. Sebelum diturunkan ke ruang cath lab, beritahu pasien untuk BAB atau BAK</td>
    <td><input type="radio" name="list_14" id="list_27" value="1" /></td>
    <td><input type="radio" name="list_14" id="list_28" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">15. File baru atau lama dan hasil penunjang lainnya disertakan</td>
    <td><input type="radio" name="list_15" id="list_29" value="1" /></td>
    <td><input type="radio" name="list_15" id="list_30" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">16. Pastikan  pasien tidak sedang menstruasi, bila ya konfirmasi ke dokter operator.</td>
    <td><input type="radio" name="list_16" id="list_31" value="1" /></td>
    <td><input type="radio" name="list_16" id="list_32" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">17. Tanyakan riwayat alergi.</td>
    <td><input type="radio" name="list_17" id="list_33" value="1" /></td>
    <td><input type="radio" name="list_17" id="list_34" value="0" /></td>
  </tr>
  <tr>
    <td colspan="3" height="30">18. Obat-obatan yang diberikan diruangan :</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" height="30"><label for="txt_obat"></label>
      <textarea name="txt_obat" id="txt_obat" cols="45" rows="5"></textarea></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Medan, <?=tgl_ina(date("Y-m-d"));?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Yang Menyerahkan </td>
    <td colspan="2" align="center">Yang Menerima </td>
  </tr>
  <tr>
    <td height="97" colspan="3" valign="bottom">(_____________)</td>
    <td colspan="2" align="center" valign="bottom">(_______________)</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Note : untuk tindakan PPM,pasien dipasang kateter/kondom </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
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

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_tindakan','ind')){
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
			$('#tgl_list').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txt_dokter').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_tindakan').val(a.cellsGetValue(a.getSelRow(),5));
			$('#txt_penyakit').val(sisip[1]);
			$('#txt_tb').val(sisip[2]);
			$('#txt_bb').val(sisip[3]);
			$('#txt_obat').val(sisip[5]);
			$('#act').val('edit');
			centang(sisip[4]);
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
            a.loadURL("6.check_list_cath_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Check List Cath");
        a.setColHeader("NO,NO RM,TGL List,Tindakan,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,");
        a.setColWidth("50,100,100,300,100,100");
        a.setCellAlign("center,center,center,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("6.check_list_cath_util.php?idPel=<?=$idPel?>");
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
		window.open("6.check_list_cath.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['list_1'];
		var list2 = document.form1.elements['list_2'];
		var list3 = document.form1.elements['list_3'];
		var list4 = document.form1.elements['list_4'];
		var list5 = document.form1.elements['list_5'];
		var list6 = document.form1.elements['list_6'];
		var list7 = document.form1.elements['list_7'];
		var list8 = document.form1.elements['list_8'];
		var list9 = document.form1.elements['list_9'];
		var list10 = document.form1.elements['list_10'];
		var list11 = document.form1.elements['list_11'];
		var list12 = document.form1.elements['list_12'];
		var list13 = document.form1.elements['list_13'];
		var list14 = document.form1.elements['list_14'];
		var list15 = document.form1.elements['list_15'];
		var list16 = document.form1.elements['list_16'];
		var list17 = document.form1.elements['list_17'];

		 
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
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 0 )
		{
		 for (i = 0; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 0 )
		{
		 for (i = 0; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
		if ( list5.length > 0 )
		{
		 for (i = 0; i < list5.length; i++)
			{
			  if (list5[i].value==list[4])
			  {
			   list5[i].checked = true;
			  }
		  }
		}
		if ( list6.length > 0 )
		{
		 for (i = 0; i < list6.length; i++)
			{
			  if (list6[i].value==list[5])
			  {
			   list6[i].checked = true;
			  }
		  }
		}
		if ( list7.length > 0 )
		{
		 for (i = 0; i < list7.length; i++)
			{
			  if (list7[i].value==list[6])
			  {
			   list7[i].checked = true;
			  }
		  }
		}
		if ( list8.length > 0 )
		{
		 for (i = 0; i < list8.length; i++)
			{
			  if (list8[i].value==list[7])
			  {
			   list8[i].checked = true;
			  }
		  }
		}
		if ( list9.length > 0 )
		{
		 for (i = 0; i < list9.length; i++)
			{
			  if (list9[i].value==list[8])
			  {
			   list9[i].checked = true;
			  }
		  }
		}
		if ( list10.length > 0 )
		{
		 for (i = 0; i < list10.length; i++)
			{
			  if (list10[i].value==list[9])
			  {
			   list10[i].checked = true;
			  }
		  }
		}
		if ( list11.length > 0 )
		{
		 for (i = 0; i < list11.length; i++)
			{
			  if (list11[i].value==list[10])
			  {
			   list11[i].checked = true;
			  }
		  }
		}
		if ( list12.length > 0 )
		{
		 for (i = 0; i < list12.length; i++)
			{
			  if (list12[i].value==list[11])
			  {
			   list12[i].checked = true;
			  }
		  }
		}
		if ( list13.length > 0 )
		{
		 for (i = 0; i < list13.length; i++)
			{
			  if (list13[i].value==list[12])
			  {
			   list13[i].checked = true;
			  }
		  }
		}
		if ( list14.length > 0 )
		{
		 for (i = 0; i < list14.length; i++)
			{
			  if (list14[i].value==list[13])
			  {
			   list14[i].checked = true;
			  }
		  }
		}
		if ( list15.length > 0 )
		{
		 for (i = 0; i < list15.length; i++)
			{
			  if (list15[i].value==list[14])
			  {
			   list15[i].checked = true;
			  }
		  }
		}
		if ( list16.length > 0 )
		{
		 for (i = 0; i < list16.length; i++)
			{
			  if (list16[i].value==list[15])
			  {
			   list16[i].checked = true;
			  }
		  }
		}
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list17.length; i++)
			{
			  if (list17[i].value==list[16])
			  {
			   list17[i].checked = true;
			  }
		  }
		}
	}
    </script>
    
</html>
