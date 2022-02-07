<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include '../koneksi/konek.php';
$sql="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id IN (10,45,46)";
$rs=mysql_query($sql);
$disableHapus="true";
if ((mysql_num_rows($rs)>0) && ($backdate!="0")){
	$disableHapus="false";
}
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <head>
        <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon" />
        <title>Form Cetak Kartu Pasien</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
    </head>
    <body>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            //include "../header1.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tr>
                    <td width="504" height="30" style="padding-left:20px;">&nbsp;FORM CETAK KARTU PASIEN</td>
					<?php 
					$qAkses = "SELECT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42)";
					$rsAkses = mysql_query($qAkses);
					if(mysql_num_rows($rsAkses)>1){
					?>
                    <td width="460" align="right"><input id="txtIdPasien" name="txtIdPasien" type="hidden"/></td>
					<?php }?>
                    <td width="36">
                        <a href="../index.php">
                            <img alt="close" src="../icon/x.png" style="cursor: pointer" width="32" />                        </a>
                    </td>
                </tr>
            </table>
            <!--div id="div_tes"></div-->
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                  <td height="29">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="25" height="29">&nbsp;</td>
                    <td>Tgl Kunjungan &nbsp;</td>
                    <td>
					:
					  <input type="text" class="txtcenterreg" name="TglKunj" readonly id="TglKunj" size="11" tabindex="22" value="<?php echo $date_now;?>"/>
                        <input type="button" id="ButtonTglKunj" name="ButtonTglKunj" value=" V " tabindex="23" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglKunj'),depRange,saring);" />					</td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Loket</td>
                  <td>: 
                    <select id="asal" name="asal" onChange="saring()" class="txtinputreg">
                  </select>                  </td>
                </tr>

                
                <tr>
                  <td></td>
                  <td width="107">&nbsp;</td>
                  <td width="868">&nbsp;
                  <input id="kartuB" name="kartuB" type="button" value="Cetak Barcode" onClick="kartuB()" style="cursor:pointer" /></td>
                </tr>
                <tr>
                  <td></td>
                  <td>&nbsp;</td>
                  <td colspan="4"><div id="divKunjLagi" style="display:none;"><input type="button" id="btnKunjUlang" name="btnKunjUlang" value="DiKunjungkan Lagi" onClick="SetKunjungLagi();" class="tblBtn"/></div></td>
                </tr>
                <tr>
                    <td colspan="7" height="235" align="center">
                        <div id="gridbox" style="width:950px; height:350px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:950px;"></div>                    </td>
                </tr>
            </table>
        </div> 
    </body>
    <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];
        var RowIdx;
        var fKeyEnt;
        var cari=0;
        var keyword='';
        var abc = 0;
        var prev_stat = '';
		var KunjAktif=false;
		var cIdPas=cIdKunj=cUnit="";
        //variabel untuk ambil data
        var glob_jnsLay = glob_tmpLay = glob_kelas = glob_ret = glob_kamar = glob_dilayani = glob_asal = '';
		
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            var all = '';
            if(id == 'userLog'){
                //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId)
                all = '&all=1';
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+all,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
		
		function decUser(){
			//alert(document.getElementById('asal').value);
			
            isiCombo('userLog',document.getElementById('asal').value,'0','userLog',saring);
			if(document.getElementById('asal').value=='108'){
				//isiCombo('StatusPasJamkesmas','','','StatusPas');
			}else if(document.getElementById('asal').value=='110'){
				//isiCombo('StatusPasAskes','','','StatusPas');
			}			
			else{
				//isiCombo('StatusPas');
			}
        }
		
		function refreshGrid(){
			//alert('referes');
            goFilterAndSort('gridbox');
            setTimeout('refreshGrid()', '120000');
        }
		
		function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                //alert("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                a.loadURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog=0&asal="+document.getElementById('asal').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }
        }
		
		
		function ambilData(multi)
        {
			//alert('asdasdasd');
			
            var sisipan=a.getRowId(a.getSelRow()).split("|");
			//alert(sisipan);
            //var p="txtIdPasien*-*"+sisipan[1]+"*|*txtIdKunj*-*"+sisipan[0]+"*|*NoRm*-*"+sisipan[2];
			document.getElementById("txtIdPasien").value = sisipan[1];
            //saat ambil data set aslMasuk,jika aslMasuk == 3/datang sendiri jnsLayanan tidak memunculkan rawat inap,actionnya perlu delay,masih bingung
            //alert(p);
            //fSetValue(window,p);
            //alert('glob_jnsLay = sisipan[22] -> '+sisipan[22]+'<br>glob_tmpLay = sisipan[23] -> '+sisipan[23]+'<br>glob_kelas = sisipan[24] -> '+sisipan[24]+'<br>glob_ret = sisipan[32] -> '+sisipan[32]);

			//cIdPas=sisipan[1];
			//
//            //glob_kamar = sisipan;
//            isiCombo('cmbKec',sisipan[10],sisipan[9]);
//            isiCombo('cmbDesa',sisipan[9],sisipan[8]);
//            document.getElementById('prev_retribusi').value = sisipan[32];
//            //isiCombo('cmbKelas','',sisipan[33],'HakKelas');
//            /*document.getElementById('kartu').disabled = false;
//            if (sisipan[34]=='0'){
//                document.getElementById('cetak').disabled = false;
//				document.getElementById('spInap').disabled = true;
//            }else{
//                document.getElementById('cetak').disabled = true;
//				document.getElementById('spInap').disabled = false;
//            }
//            document.getElementById('cetakForm').disabled = false;*/
//            if(document.getElementById('asal').value=='108'){
//                document.getElementById('skpJamkesda').disabled = false;
//			 	document.getElementById('UpdStatusPx').disabled = false;
//			 	Request("registrasi_utils.php?act=jamkeskah&idKunj="+cIdKunj,'skpDiv','','GET',skpCek);
//            }
//			//alert(prev_inap);
//            if(document.getElementById('prev_inap').value=='1'){
//               // document.getElementById('spInap').disabled = false;
//            }else{
//			   // document.getElementById('spInap').disabled = true;
//			}
//			
//            setPenjamin(sisipan[25]);
//			
//			/*ditampilkan tombol SKP JAMKESDA INAP jika penjamin adalah JAMKESMAS*/
//			if(sisipan[25]=='38' || sisipan[25]=='39' || sisipan[25]=='46' || sisipan[25]=='64'){
//				document.getElementById('skpJamkesdaKmr').disabled = false;
//				document.getElementById('skpJamkesda').disabled = false;
//			}else{
//				document.getElementById('skpJamkesdaKmr').disabled = true;
//				document.getElementById('skpJamkesda').disabled = true;
//			}
//			if(sisipan[25]=='53'){
//				document.getElementById('sjpJampersal').disabled = false;
//			}else{
//				document.getElementById('sjpJampersal').disabled = true;
//			}
//			
//            SetDisable(1);
        }
		
		function konfirmasi(key,val){
            /*var sisip;
			//alert(val);
            if(key=='Error'){
                if(val=='tambah')
                    alert('Tambah Gagal');
                else if(val=='simpan')
                    alert('Simpan Gagal');
                else if(val=='hapus')
                    alert('Hapus Gagal');
                else if(val=='SudahAda')
                    alert('Pasien Sudah Berkunjung ke Unit Tersebut !');
					
				batal();
            }else if(val!=undefined && val!=""){
				sisip=val.split("|");
				if(sisip[0]=='tambah' || sisip[0]=='simpan' || sisip[0]=='hapus'){
					if(sisip[0]=='tambah'){
						alert('Tambah Berhasil');
					}
					else if(sisip[0]=='simpan')
						alert('Simpan Berhasil');
					else if(sisip[0]=='hapus')
						alert('Hapus Berhasil');
						
					batal();
					
					if(sisip[0]!='hapus'){
						cIdKunj=sisip[1];
						cIdPas=sisip[2];
						cUnit = sisip[3];
						document.getElementById("hid_kunjungan_id").value=cIdKunj;
						if (document.getElementById("StatusPas").value=="4"){
							document.getElementById("sjpAskes").disabled = false;
							document.getElementById("sjpAskes_isi").disabled = false;
						}else{
							document.getElementById("sjpAskes").disabled = true;
							document.getElementById("sjpAskes_isi").disabled = true;
						}
						if (sisip[4]=="1"){
							document.getElementById("spInap").disabled = false;
						}else{
							document.getElementById("spInap").disabled = true;
						}
					}else{
						cIdKunj="";
						cIdPas="";
						cUnit = "";
						document.getElementById("hid_kunjungan_id").value="";
						document.getElementById("sjpAskes").disabled = true;
						document.getElementById("sjpAskes_isi").disabled = true;
						document.getElementById("spInap").disabled = true;
					}
				}
            }
*/
            if(abc==0){
                isiCombo('asalLoket','<?php echo $userId; ?>','','asal',saring);
                refreshGrid();
            }

            abc=1;
        }

		
		function saring(){
		//alert(document.getElementById('userLog').value);
		//alert("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog=0s&asal="+document.getElementById('asal').value);
          a.loadURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog=0&asal="+document.getElementById('asal').value,"","GET");
        }
		
		function kartuB()
        {
			if(document.getElementById("txtIdPasien").value=="")
			{
				alert("Pilih pasien terlebih dahulu");
			}			
			else
			{
            	window.open('cetakKartuBarcode.php?idPas='+document.getElementById("txtIdPasien").value,'_blank');
			}
        }

        var a=new DSGridObject("gridbox");
        a.setHeader("DATA KUNJUNGAN PASIEN");
        a.setColHeader("NO,NO RM,NAMA,PENJAMIN,TEMPAT LAYANAN,KELAS,ALAMAT");
        a.setIDColHeader(",no_rm,nama,nama_kso,tempat_layanan,kelas,alamat");
        a.setColWidth("30,70,200,180,150,80,260");
        a.setCellAlign("center,center,left,center,center,center,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value);
        a.Init();		
    </script>
</html>
<?php 
mysql_close($konek);
?>