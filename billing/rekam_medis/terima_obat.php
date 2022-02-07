<?php
session_start();
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
include("../sesi.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$no_bukti = $_REQUEST['param1'];
$idunit = $_REQUEST['param2'];
include("../koneksi/konek.php");

if($_REQUEST['proses']=="del")
{
	$sql="delete from dbapotek_tangerang.a_minta_obat where no_bukti='$no_bukti' and unit_id=$idunit";
	$rs=mysql_query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
        <title>Tempat Layanan</title>
    </head>
    <body>
    <div id="load1"></div>
        <div align="center">
            <?php
            include("../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM PENERIMAAN OBAT</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <!--<tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">Kode Induk</td>
                    <td width="45%">
                        <input id="txtParentKode"  name="txtParentKode" type="text" size="10" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter" />
                        <input type="button" class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('tmpt_layanan_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)" />
                        <input type="hidden" id="txtLevel" name="txtLevel" size="5" />
                        <input type="hidden" id="txtParentId" name="txtParentId" size="5" />
                        <input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />                    </td>
                    <td width="20%">                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">Kode</td>
                    <input id="txtId" type="hidden" name="txtId" size="10" class="txtinput"/>
                    <td width="45%"><input id="txtKode" name="txtKode" size="10" value="" class="txtinput"/>
                        &nbsp;Nama&nbsp;<input id="txtNama" name="txtNama" size="20"  class="txtinput"/>                    </td>
                    <td width="20%">                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="right">Kode RC Akuntansi</td>
                  <td><input id="txtKodeAk" name="txtKodeAk" size="10" value="" class="txtinput"/></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Keterangan</td>
                    <td><input id="txtKet" name="txtKet" size="20"  class="txtinput"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kategori</td>
                    <td>
                        <select id="txtKtgr" name="txtKtgr" onchange="setCakupan(this.value)" class="txtinput">
                            <option value="1">Loket</option>
                            <option value="2">Pelayanan</option>
                            <option value="3">Administrasi</option>
                            <option value="4">Kasir</option>
                            <option value="5">Farmasi/Apotek</option>
                        </select>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr id="tr_cakupan" style="display: none">
                    <td></td>
                    <td align="right">Cakupan Tagihan</td>
                    <td>
                        <select id="cakupan" name="cakupan" class="txtinput">
                        </select>                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Status inap</td>
                    <td>
                        <label><input type="radio" id="rdInap1" name="rdInap" value="1"/>Ya</label>
                        <label><input type="radio" id="rdInap0" name="rdInap" value="0" checked="checked" />Tidak</label>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Status</td>
                    <td>
                        <label><input type="checkbox" id="chAktif" name="chAktif" value="1" checked="checked" />aktif</label>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>                    </td>
                    <td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="window.location='tmpt_layanan_tree.php'" class="tblViewTree">Tampilan Tree</button></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>-->
                <tr>
                	<td align="left" colspan="2" style=" padding-left:50px;">
                    Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="lihat1()">
              <option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
              <option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
              <option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
              <option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
              <option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
              <option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
              <option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
              <option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
              <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
              <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
              <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
              <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
            </select>
            <span>Tahun : </span> 
            <select name="ta" id="ta" class="txtinput" onChange="lihat1()">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select>
            <span>Jenis Layanan : </span> 
            <select id="cmbJnsLay" class="txtinput" onChange="cekLab(this.value);cekInap(this.options[this.options.selectedIndex].lang);isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',evLang2);" >
					<?php
                                            $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
                                                    where ms_pegawai_id=".$_SESSION['userId'].") as t1
                                                    inner join b_ms_unit u on t1.unit_id=u.id
                                                    inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
                                            $rs=mysql_query($sql);
                                            while($rw=mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                                <?php
                                            }
                                            ?>
						</select>
               <span>Tempat Layanan : </span> 
               <select name="cmbTmpLay" id="cmbTmpLay" class="txtinput" lang="" onChange="this.lang=this.value;evLang2();">
			    </select>
                    </td>
                    <td align="right" colspan="2" style=" padding-left:10px;">
                    <button onclick="location='minta_terima_obat1.php'" type="button" style=" display:none;">
						<img width="16" border="0" align="absmiddle" height="16" src="../icon/add.gif">
 						Buat Permintaan Baru
					</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
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
      <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="../index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript">
        function simpan(action){
            if(ValidateForm('txtKodeAk,txtNama,rdInap1,rdInap0,chAktif','ind')){
                var id=document.getElementById("txtId").value;
                var kode=document.getElementById("txtKode").value;
                var kodeAk=document.getElementById("txtKodeAk").value;
                var nama=document.getElementById("txtNama").value;
                var level=document.getElementById("txtLevel").value;
                var parentId=document.getElementById("txtParentId").value;
                var parentKode=document.getElementById("txtParentKode").value;
                var ket=document.getElementById("txtKet").value;
                var ktgr=document.getElementById("txtKtgr").value;
                var cakupan = document.getElementById('cakupan').value;
				
				if (id==parentId && parentId!=""){
					alert("Unit Parent Tdk Boleh Unitnya Sendiri !");
					return false;
				}

                if(document.getElementById("rdInap1").checked==true && document.getElementById("rdInap0").checked==false){
                    var inap=document.getElementById("rdInap1").value;
                }
                else if(document.getElementById("rdInap0").checked==true && document.getElementById("rdInap1").checked==false){
                    var inap=document.getElementById("rdInap0").value;
                }
                if(document.getElementById("chAktif").checked==true){
                    var aktif=1;
                }
                else{
                    var aktif=0;
                }
                
                while (nama.indexOf('&')>0){
                    nama=nama.replace('&',String.fromCharCode(5));
                }
                //alert("tmpt_layanan_utils.php?act="+action+"&id="+id+"&kode="+kode+"&kodeAk="+kodeAk+"&nama="+nama+"&level="+level+"&cakupan="+cakupan+"&parentId="+parentId+"&parentKode="+parentKode+"&ket="+ket+"&ktgr="+ktgr+"&inap="+inap+"&aktif="+aktif);
                a.loadURL("tmpt_layanan_utils.php?act="+action+"&id="+id+"&kode="+kode+"&kodeAk="+kodeAk+"&nama="+nama+"&level="+level+"&cakupan="+cakupan+"&parentId="+parentId+"&parentKode="+parentKode+"&ket="+ket+"&ktgr="+ktgr+"&inap="+inap+"&aktif="+aktif,"","GET");
                batal();
            }
        }
		
		
		function lihat1()
		{
			var bln = document.getElementById('bulan').value;
			var th = document.getElementById('ta').value;
			var unit_id = document.getElementById('cmbTmpLay').value;
			a.loadURL("terima_obat_utils.php?th="+th+"&bln="+bln+"&unit_id="+unit_id,"","GET");
		}
		
		function hapus_minta(a1,b,c)
		{
			//alert(a+","+b+","+c); tmpt_layanan_utils.php
			if(confirm("Yakin Ingin Menghapus Data"))
			{
				if(a1==0)
				{
					a.loadURL("tmpt_layanan_utils.php?proses=del&param1="+b+"&param2="+c,"","GET");
					//batal();
					//location="minta_terima_obat.php?proses=del&param1="+b+"&param2="+c;
				}else{
					alert("Data Permintaan Tdk Boleh Dihapus, Karena Obat Sudah Dikirim !");
				}
			}
		}
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=0&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
            var kodeBaru=a.cellsGetValue(a.getSelRow(),2).substr(a.cellsGetValue(a.getSelRow(),5).length,a.cellsGetValue(a.getSelRow(),2).length);
            var sisip = a.getRowId(a.getSelRow()).split('|');
            var p="txtId*-*"+sisip[0]+"*|*txtKode*-*"+kodeBaru+"*|*txtKodeAk*-*"+sisip[3]+"*|*cakupan*-*"+sisip[1]+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+sisip[2]+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtKet*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*rdInap0*-*"+((a.cellsGetValue(a.getSelRow(),8)=='Ya')?'false':'true')+"*|*rdInap1*-*"+((a.cellsGetValue(a.getSelRow(),8)=='Ya')?'true':'false')+"*|*chAktif*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
            fSetValue(window,p);
                        
            if(a.cellsGetValue(a.getSelRow(),7)=="Loket"){
                document.getElementById('txtKtgr').value='1';
            }
            else if(a.cellsGetValue(a.getSelRow(),7)=="Pelayanan"){
                document.getElementById('txtKtgr').value='2';
            }
            else if(a.cellsGetValue(a.getSelRow(),7)=="Administrasi"){
                document.getElementById('txtKtgr').value='3';
            }
            else{
                document.getElementById('txtKtgr').value = '4';
            }
            setCakupan(document.getElementById('txtKtgr').value);
            kodeBaru='';
        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Unit "+a.cellsGetValue(a.getSelRow(),3))){
                a.loadURL("tmpt_layanan_utils.php?act=hapus&rowid="+rowid,"","GET");
            }
            batal();
        }

        function batal(){
            var p="txtId*-**|*txtKode*-**|*txtKodeAk*-**|*txtNama*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*txtKet*-**|*rdInap0*-*true*|*rdInap1*-*false*|*chAktif*-*true*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
            fSetValue(window,p);
        }


        function konfirmasi(key,val){
            //alert(val);
            var tangkap=val.split("*|*");
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
            }

        }
		
		isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('cmbJnsLay').value,'','',evLang);

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DAFTAR PENGIRIMAN OBAT DARI UNIT LAIN");
        a.setColHeader("NO,Tanggal,No Permintaan,No Kirim,Unit Pengirim,Status,Proses");
        a.setIDColHeader(",,kode,nama,level,,");
        a.setColWidth("50,100,150,100,100,100,100");
        a.setCellAlign("center,center,left,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("terima_obat_utils.php?th="+document.getElementById('ta').value+"&bln="+document.getElementById('bulan').value+"&unit_id="+document.getElementById('cmbTmpLay').value);
        a.Init();
		
		function evLang(){
			lihat1();
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
            //alert(inap);
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            cekInap(inap);
		if(inap == 1){
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
		}else{
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
		}

            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
			
            //unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            showGrid();
            isiCombo('cmbDok',unitId,'','cmbDokRujukUnit');
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'','cmbDokRujukRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
			isiCombo('cmbIsiDataRM',document.getElementById('cmbTmpLay').value,'','cmbIsiDataRM',evCmbDataRM);
			cekLab(document.getElementById('cmbJnsLay').value);
        }
		
		function evLang2(){
			lihat1();
			var selCmbDilayani=0;
			if (document.getElementById('cmbDilayani')) selCmbDilayani=document.getElementById('cmbDilayani').options.selectedIndex;
			if (selCmbDilayani>2) selCmbDilayani=0;
	    	//tentangTarik();
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			//alert(inap);
			if(inap == 1){
				document.getElementById('btnMRS').style.display = 'none';
				document.getElementById('UpdStatusPx').style.display = 'inline-table';
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
			}
			else{
				document.getElementById('btnMRS').style.display = 'inline-table';
				if (document.getElementById('cmbJnsLay').value==44){
					document.getElementById('UpdStatusPx').style.display = 'inline-table';
				}else{
					document.getElementById('UpdStatusPx').style.display = 'none';
				}
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
			}
			//alert(selCmbDilayani);
			document.getElementById('cmbDilayani').options.selectedIndex=selCmbDilayani;
			if('<?php echo isset($_POST['sentPar'])?>' == 0){
				document.getElementById('txtFilter').value = "";
			}
			else if('<?php echo isset($_POST['sentPar'])?>' == 1){
				var sentPar = "<?php echo $_POST['sentPar']?>".split('*|*');
				document.getElementById('cmbDilayani').value = sentPar[4];
			}
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            cekInap(inap);
            saring();
            isiCombo('cmbDok',unitId,'','cmbDokRujukUnit');
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'','cmbDokRujukRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
            isiCombo('cmbDok',unitId,'','cmbDokTind');
            isiCombo('cmbDok',unitId,'','cmbDokDiag');
            isiCombo('cmbDok',unitId,'','cmbDokResep');
			
			/*
			if(jenisUnitId==27){
			}
			*/
        }

function cekLab(a){
		if(a==57){
			/*mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
			//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat.php");
			mTab.setTabDisplay("true,true,true,true,true,3");
			document.getElementById('tab_laborat').style.display='block';
			document.getElementById('tab_radiologi').style.display='none';*/
		}
		else if(a==60){
			/*mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL RADIOLOGI");
			//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,radiologi.php");
			mTab.setTabDisplay("true,true,true,true,true,3");
			document.getElementById('tab_radiologi').style.display='block';
			document.getElementById('tab_laborat').style.display='none';*/
		}
		else{
			//mTab.setTabDisplay("true,true,true,true,false,0");
			//document.getElementById('tab_laborat').style.display='none';
			//document.getElementById('tab_radiologi').style.display='none';
		}
	}

function cekInap(label){
            //alert(label);
            if(label=='1'){
                /*document.getElementById('trTgl').style.visibility='collapse';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='inline';
                document.getElementById('btnMRS').disabled=true;
                document.getElementById('btnVer').style.display='inline';
				document.getElementById('btnDarah').style.display='inline';
                document.getElementById('btnRujukRS').disabled=false;*/
            }
            else{
                /*document.getElementById('trTgl').style.visibility='visible';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='none';
                document.getElementById('btnMRS').disabled=false;
                document.getElementById('btnVer').style.display='none';
				document.getElementById('btnDarah').style.display='none';
                document.getElementById('btnRujukRS').disabled=false;*/
            }
        }
		
    </script>
</html>
