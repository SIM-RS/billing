<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<link type="text/css" rel="stylesheet" href="../default.css"/>
<title>.: Penerimaan Baru :.</title>
</head>

<body>
<!--?php
	//UNIT_ID_TERIMA=$idunit and 
		$sql="SELECT * from a_penerimaan where NOTERIMA='$no_gdg'";
		$rs=mysql_query($sql);
		$tmpuser="";
		if ($rows=mysql_fetch_array($rs)){
			$tmpuser=$rows["USER_ID_TERIMA"];
			if ($tmpuser!=$iduser){
				$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$no_gdg=$rows1["NOTERIMA"];
					$arno_gdg=explode("/",$no_gdg);
					$tmp=$arno_gdg[3]+1;
					$ctmp=$tmp;
					for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
					$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
				}else{
					$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/0001";
				}
			}
		}
?-->
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
	<div align="center">
		<?php
			include("../header.php");
			include("../koneksi/konek.php");
			$date_now=gmdate('d-m-Y',mktime(date('H')+7));
      	?>
		<table border="0" width="1000" cellpadding="0" cellspacing="2" bgcolor="#FFFBF0">
			<tr>
				<td colspan="10" height="20">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" style="font-size:16px;" colspan="10">PENERIMAAN PO</td>
			</tr>
			<tr>
				<td colspan="10">&nbsp;</td>
			</tr>
			<tr>
				<td width="5%">&nbsp;</td>
				<td width="10%">&nbsp;No Penerimaan</td>
				<td width="18%">&nbsp;:&nbsp;<input id="txtNoPen" name="txtNoPen" size="24" /></td>
				<td width="5%">&nbsp;</td>
				<td width="10%">&nbsp;Harga Total</td>
				<td width="17%">&nbsp;:&nbsp;<input id="txtHrgTtl" name="txtHrgTtl" size="24"/></td>
				<td width="5%">&nbsp;</td>
				<td width="8%">&nbsp;PPN (10%)</td>
				<td width="17%">&nbsp;:&nbsp;<input id="txtPPN" name="txtPPN" size="24" /></td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td width="5%">&nbsp;</td>
				<td width="10%">&nbsp;Tgl Penerimaan</td>
				<td width="18%">&nbsp;:&nbsp;<input id="txtTgl" name="txtTgl" width="16" value="<?php echo $date_now;?>" class="txtcenter"/>&nbsp;<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);" /></td>
				<td width="5%">&nbsp;</td>
				<td width="10%">&nbsp;Diskon Total</td>
				<td width="17%">&nbsp;:&nbsp;<input id="txtDiskon" name="txtDiskon" size="24" /></td>
				<td width="5%">&nbsp;</td>
				<td width="8%">&nbsp;TOTAL</td>
			  	<td width="17%">&nbsp;:&nbsp;<input id="txtTotal" name="txtTotal" size="24" /></td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;No PO</td>
				<td>&nbsp;:&nbsp;<select name="cmbNoPo" id="cmbNoPo" onChange="set()">
              		<option value="" class="txtinput">Pilih PO</option>
              			<?
							  $qry="SELECT po.no_po, rek.namarekanan FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id ORDER BY po.no_po";
							  $exe=mysql_query($qry);
							  while($show=mysql_fetch_array($exe)){ 
						?>
              		<option value="<?php echo $show['no_po']; ?>" ><?php echo $show['no_po']." - ".$show['namarekanan'];?></option>
              			<? }?>
            		</select></td>
				<td>&nbsp;</td>
				<td>&nbsp;Harga Diskon</td>
				<td>&nbsp;:&nbsp;<input id="txtHarga" name="txtHarga" size="24" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;Jatuh Tempo</td>
				<td>&nbsp;:&nbsp;<input id="txtTempo" name="txtTempo" width="12" value="21" />&nbsp;Hari</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;No Faktur</td>
				<td>&nbsp;:&nbsp;<input id="txtFaktur" name="txtFaktur" size="24" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;Supplier</td>
				<td>&nbsp;:&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="10">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="8" align="center">
					<div id="gridbox" style="width:900px; height:250px; background-color:white; overflow:hidden;"></div>
                    <div id="paging" style="width:900px;"></div>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="4" align="right"><BUTTON type="button" onClick="if (ValidateForm('no_faktur','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</BUTTON>&nbsp;</td>
				<td colspan="4" align="left">&nbsp;<BUTTON type="reset" onClick="location='penerimaanPO.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="10"><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
			</tr>
		</table>
	</div>
</body>
<script type="text/javascript" language="javascript">
		function set()
		{
			var nopo = document.getElementById('cmbNoPo').value;
			//alert("utils.php?pilihan=penerimaanbaru&nopo="+nopo);
			baru.loadURL("utils.php?pilihan=penerimaanbaru&nopo="+nopo,"","GET");
		}
		
		function goFilterAndSort(grd)
        {
            //bln = document.getElementById("bulan").value;
            if (grd=="gridbox"){
                baru.loadURL("utils.php?pilihan=penerimaanbaru&filter="+baru.getFilter()+"&sorting="+baru.getSorting()+"&page="+baru.getPage(),"","GET");
            }
        }

        function filter(value){
            baru.loadURL("utils.php?pilihan=penerimaanbaru","","GET");
        }

        var baru=new DSGridObject("gridbox");
        baru.setHeader(".: DAFTAR PENERIMAAN BARU :.");
        baru.setColHeader("No,,Nama Obat,Expired Data,Qty Kemasan,Kemasan,Harga Kemasan,Isi/Kemasan,Qty Satuan,Satuan,Harga Satuan,Sub Total,Disk(%),Diskon(Rp)");
        //po.setIDColHeader("kodebarang,namabarang,,,,");
        baru.setColWidth("50,25,150,75,75,75,75,75,75,75,75,75,75,75");
        baru.setCellAlign("center,center,left,center,center,center,center,center,center,center,center,center,center,center");
        baru.setCellHeight(20);
        baru.setImgPath("../icon");
        baru.setIDPaging("paging");
        baru.attachEvent("onRowClick");
        baru.baseURL("utils.php?pilihan=penerimaanbaru");
        baru.Init();
    </script>
</html>
