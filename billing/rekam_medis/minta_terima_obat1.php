<?php
session_start();
header("content-type: text/html; charset=iso-8859-1");
ini_set("session.gc_maxlifetime", "18000");
include("../sesi.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$iduser = $_SESSION["iduser"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script language="javascript" src="jquery_n.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
        <title>Tempat Layanan</title>
    </head>
    <body>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
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
                    <td height="30">&nbsp;FORM PERMINTAAN OBAT</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr align="center" valign="top">
      				<!--td width="5" height="450">&nbsp;</td-->
					<td align="center" colspan="" height="450"><?php include("minta_obat.php");?></td>
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
                </tr>-->
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
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        isiCombo('cakupan','','','cakupan','');
		isiCombo1('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('cmbJnsLay').value,'','',evLang);


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

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("UNIT PELAYANAN");
        a.setColHeader("NO,KODE,NAMA,LEVEL,PARENT KODE,KETERANGAN,KATEGORI,STATUS INAP,STATUS AKTIF");
        a.setIDColHeader(",,kode,nama,level,,,,");
        a.setColWidth("50,100,200,50,100,100,100,100,100");
        a.setCellAlign("center,center,left,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("tmpt_layanan_utils.php");
        a.Init();
    </script>
</html>
