<?php
session_start();
include("../koneksi/konek.php");
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
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!-- end untuk ajax-->
        
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <title>Penerimaan KSO</title>
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
            include("../header1.php");
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;DAFTAR PEMBAYARAN KSO</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <input id="txtId" type="hidden" name="txtId" size="10" class="txtinput"/>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%" align="right">Tanggal</td>
                    <td width="45%"><input id="tgl"  name="tgl" type="text" size="20" maxlength="20" style="text-align:left" value="<?php echo date('d-m-Y') ?>" readonly="true" class="txtcenter" />     
                  </td>
                  <td width="20%">
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">No. Kwitansi</td>
                    <td><input id="txtKwitansi" name="txtKwitansi" size="20"  class="txtinput"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">KSO</td>
                    <td>
                        <select id="cmbKSO" name="cmbKSO" onchange="" class="txtinput">
                        <?php $kueri="SELECT id,nama FROM b_ms_kso";
							$no=1;
							$t=mysql_query($kueri);
							while($kso=mysql_fetch_array($t)){
						?>
                            <option value="<?php echo $no ?>"><?php echo $kso['nama'] ?></option>
                            <?php $no++; } ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">No. Tagihan</td>
                    <td><input id="txtNo" name="txtNo" size="20"  class="txtinput"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tgl. Tagihan</td>
                    <td><input id="txtTgl" name="txtTgl" size="20"  class="txtinput" value="<?php echo date('d-m-Y');?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo date('d-m-Y');?>'}"/><input type="button" id="ButtonTgl" name="ButtonTgl" value=" V " tabindex="23" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,'');" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nilai Tagihan</td>
                    <td><input id="txtNilai" name="txtNilai" size="20"  class="txtinput"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nilai diBayar</td>
                    <td><input id="txtNilaiB" name="txtNilaiB" size="20"  class="txtinput"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Penerima</td>
                    <td><input id="txtPenerima" name="txtPenerima" size="20" readonly="readonly" class="txtinput" value="<?php  echo $_SESSION['userName']; ?>"/></td>
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
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus()"  disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                    </td>
                    <td align="right"><input name="btnPrint" id="btnPrint" type="button" class="tblCetak" value="&nbsp;&nbsp;&nbsp;Cetak" onclick="cetak();"/>&nbsp;</td>
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
                        <div id="gridbox" style="width:900px; height:270px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript">
	var arrRange=depRange=[];
        function simpan(action){
					
            var id=document.getElementById("txtId").value;
            var tgl=document.getElementById("tgl").value;
			var kwi=document.getElementById("txtKwitansi").value;
			var kso=document.getElementById("cmbKSO").value;
            var no=document.getElementById("txtNo").value;
            var tanggal=document.getElementById("txtTgl").value;
            var nilai=document.getElementById("txtNilai").value;
            var nilaiB=document.getElementById("txtNilaiB").value;
            var penerima=document.getElementById("txtPenerima").value;
            var ket=document.getElementById("txtKet").value;
			 		//alert("penerimaan_kso_utils.php?act=tambah&tgl="+tgl+"&kso="+kso+"&no="+no+"&tanggal="+tanggal+"&nilai="+nilai+"&nilaiB="+nilaiB+"&penerima="+penerima+"&ket="+ket);
                //alert("tmpt_layanan_utils.php?act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&cakupan="+cakupan+"&parentId="+parentId+"&parentKode="+parentKode+"&ket="+ket+"&ktgr="+ktgr+"&inap="+inap+"&aktif="+aktif);
              
		 a.loadURL("penerimaan_kso_utils.php?act="+action+"&id="+id+"&tgl="+tgl+"&kwi="+kwi+"&kso="+kso+"&no="+no+"&tanggal="+tanggal+"&nilai="+nilai+"&nilaiB="+nilaiB+"&penerima="+penerima+"&ket="+ket,"","GET"); 
		 batal();
        }
		
        function ambilData(){		
            var data = a.getRowId(a.getSelRow()).split('|');
			document.getElementById('txtId').value=data[0];
			document.getElementById('tgl').value=a.cellsGetValue(a.getSelRow(),3);
			document.getElementById('txtKwitansi').value=a.cellsGetValue(a.getSelRow(),2);
			document.getElementById('cmbKSO').value=a.cellsGetValue(a.getSelRow(),4);
			document.getElementById('txtNo').value=a.cellsGetValue(a.getSelRow(),5);
			document.getElementById("txtTgl").value=a.cellsGetValue(a.getSelRow(),6);
			document.getElementById("txtNilai").value=a.cellsGetValue(a.getSelRow(),7);
			document.getElementById("txtNilaiB").value=a.cellsGetValue(a.getSelRow(),8);
			document.getElementById("txtPenerima").value=a.cellsGetValue(a.getSelRow(),9);
			document.getElementById("txtKet").value=a.cellsGetValue(a.getSelRow(),10);
			
			document.getElementById('btnSimpan').value='Simpan';
			document.getElementById('btnHapus').disabled=false;
			//alert(document.getElementById("btnSimpan").value);
		}
		
		function cetak(){
            var noK = document.getElementById("txtKwitansi").value;
			window.open('cetak_kwitansi.php?no='+noK,'_blank');
		}
		
		function batal(){
			document.getElementById('tgl').value="<?php echo date('d-m-Y'); ?>";
			//document.getElementById('cmbKSO').value="";
			document.getElementById('txtKwitansi').value="";
			document.getElementById('txtNo').value="";
			document.getElementById("txtTgl").value="";
			document.getElementById("txtNilai").value="";
			document.getElementById("txtNilaiB").value="";
			document.getElementById("txtPenerima").value="<?php echo $_SESSION['userName'] ?>";
			document.getElementById("txtKet").value="";
			
			document.getElementById('btnSimpan').value='Tambah';
			document.getElementById('btnHapus').disabled=true;
		}
		
        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Unit "+a.cellsGetValue(a.getSelRow(),3))){
                a.loadURL("penerimaan_kso_utils.php?act=hapus&id="+rowid,"","GET");
            }
            batal();
        }
/*
        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }*/
        var a=new DSGridObject("gridbox");
        a.setHeader("DAFTAR PEMBAYARAN KSO");
        a.setColHeader("NO,KWITANSI,TANGGAL,NAMA KSO,NO TAGIHAN,TGL TAGIHAN,NILAI TAGIHAN,NILAI DIBAYAR,PENERIMA,KETERANGAN");
        a.setIDColHeader(",no_kwitansi,tanggal,nama,,,,,,");
        a.setColWidth("50,100,100,100,100,100,100,100,100,100");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
       // a.onLoaded(konfirmasi);
        a.baseURL("penerimaan_kso_utils.php");
        a.Init();
    </script>
</html>
