<?php
session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
$userId = $_SESSION['userId'];//echo $userId."<br>";

$tgl=gmdate('d-m-Y',mktime(date('H')+7));

if($_REQUEST['tanggal']==""){
	$tanggal = $tgl;
}else{
	$tanggal = $_REQUEST['tanggal'];
}
$tang = explode('-',$tanggal);
$tanggalan = $tang[2].'-'.$tang[1].'-'.$tang[0];//echo $tanggalan."<br>";
$waktu = "t.tgl='$tanggalan'";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Penerimaan :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" src="../jquery.js"></script>
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css"-->
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
    </head>
    <?php
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><!-- onload="viewTime()"-->
        <style type="text/css">
            .tbl
            { font-family:Arial, Helvetica, sans-serif; 
              font-size:12px;}
            </style>
            <script type="text/JavaScript">
                var arrRange = depRange = [];
            </script>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <div align="center">
        	<?php
            include("../header1.php");
            include("../koneksi/konek.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM VERIFIKASI SETORAN KASIR</td>
                    <td width="460" align="right">&nbsp;</td>
                </tr>
            </table>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                  <td valign="top" align="center">&nbsp;</td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                    <table width="980" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="jdltable" height="29" colspan="2">Verifikasi Setoran Kasir</td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tanggal</td>
                    <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
                </tr>
                <tr>
                    <td width="40%" style="padding-right:20px; text-align:right;" height="25">Penyetor</td>
                    <td>:&nbsp;<select id="cmbKasir" name="cmbKasir" class="txtinput" onChange="kirim()">
                        <option value="0">SEMUA</option>
                        <?php
							$sTmp = "SELECT
									DISTINCT
									d.id, 
									d.nama
									FROM b_bayar a 
									INNER JOIN b_ms_pegawai d ON d.id=a.disetor_oleh
									WHERE a.disetor = 1 AND DATE(a.disetor_tgl)='".tglSQL($tanggal)."'
									ORDER BY d.nama";
                            $qTmp = mysql_query($sTmp);
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<?php echo $wTmp['id'];?>"><?php echo $wTmp['nama'];?></option>
                        <?php	}	?>
                    </select></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:40px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('btnVerifikasi').disabled=false;}else{document.getElementById('btnVerifikasi').disabled=true;};kirim();">
                        <option value="0">BELUM VERIFIKASI</option>
                        <option value="1">SUDAH VERIFIKASI</option>
                    </select>                    </td>
                    <td height="30" align="right" style="padding-right:40px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Verifikasi</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                </tr>
                <tr>
                	<td colspan="2" align="right" style="padding-right:50px;">Total&nbsp;:&nbsp;<span id="spnTotal">0</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<!--input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /--></td>
                    <td colspan="6" align="right"><!--a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a-->&nbsp;</td></tr>
            </table>

        </div>
        </body>
<script>	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENERIMAAN BILLING OLEH KASIR");
	a1.setColHeader("NO,TGL SETOR,PENYETOR,NO KWITANSI,NO RM,PASIEN,KSO,NILAI,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setIDColHeader(",tgl_setor,nm_pegawai,no_kwitansi,no_rm,nama,kso,nilai,");
	a1.setColWidth("50,120,100,100,80,140,100,100,50");
	a1.setCellAlign("center,center,center,center,center,center,center,right,center,center,center");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	a1.baseURL("penerimaan_setoran_kasir_utils.php?tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	function konfirmasi(key,val){
		var tmp;
		if (document.getElementById('chkAll')){
			document.getElementById('chkAll').checked=false;
		}
		if (val!=undefined){
			tmp=val.split(String.fromCharCode(1));
			if(key=='Error'){
				if(tmp[0]=='verifikasi'){
					alert('Terjadi Error dlm Proses Verifikasi !');
				}
			}else{
				if(tmp[0]=='verifikasi'){
					alert('Proses Verifikasi Berhasil !');
				}
			}
			
			document.getElementById('spnTotal').innerHTML=tmp[1];	
		
		}
	}
		
	function goFilterAndSort(grd){
		var url;
		if (grd=="gridbox")
		{		
			url="penerimaan_setoran_kasir_utils.php?tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
		var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,9,cekbox);
		}
	}
	
	function LoadCmbKasir(){
		var url;
		url="penerimaan_setoran_kasir_utils.php?act=loadkasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		Request(url,'cmbKasir',"","GET",kirim,'noload');
	}
	
	function kirim(){
		var url;
		url="penerimaan_setoran_kasir_utils.php?tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		a1.loadURL(url,"","GET"); 
	}
	
	//=========================================
	function VerifikasiJurnal(){
		var x = document.getElementById('tgl').value.split("-");
		var tglx = x[2]+'-'+x[1]+'-'+x[0];
		
		var tmp='',idata='';
		var url;
		var url2;
		
		for (var i=0;i<a1.getMaxRow();i++)
		{
			if (a1.obj.childNodes[0].childNodes[i].childNodes[8].childNodes[0].checked)
			{
				idata=a1.getRowId(i+1);
				tmp+=idata+String.fromCharCode(5);
			}
		}
		
		if (tmp!="")
		{
			if(confirm("Verifikasi tidak bisa di batalkan!. Anda Yakin ?")){
				url="penerimaan_setoran_kasir_utils.php?act=verifikasi&idUser=<?=$userId;?>&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
				//alert(url);
				a1.loadURL(url,"","GET");
			}
		}
		else
		{
			alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
		}
	}
</script>

</html>