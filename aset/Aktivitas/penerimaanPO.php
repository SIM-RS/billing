<?php
include '../koneksi/konek.php'; 
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs/aset/';
        </script>";
}
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
		<script type="text/javascript" src="jquery-1.7.1.js"></script>
        <script language="JavaScript" src="../theme/js/ajax.js"></script>
		


		<script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>
		<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
		<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Penerimaan PO :.</title>
    </head>

    <body>
        <div align="center">
		    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
  			</iframe>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
                        
            <?php
            include("../header.php");
            ?>
<div id="lap_SAP" class="popup" style="display:none;width:600px;">
<div id="gsap" style="width:600px; height:120px; background-color:white; overflow:hidden; padding:5px 5px 25px 25px; border:2px solid #CCCCCC;">
<div style="float:right; cursor:pointer" class="popup_closebox">
	<input type="button" value=" X " onClick="Popup.hide('lap_SAP');" />
</div>
<br>
 <fieldset>
            <legend align="center"><font style="font:bold 11px tahoma; text-align:center;">Isi NO dan Tanggal BA</font></legend><br />

<table width="500" cellpadding="0" cellspacing="0">
<tr>
  <td class="fontPegTab">No BA </td>
  <td>: <input type="text" id="no_ba" name="no_ba"></td>
</tr>
<tr>
	<td width="107" class="fontPegTab">Tgl BA </td>
	<td width="391">: <input type="text" id="tgl_ba" name="tgl_ba">&nbsp;<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl_ba'),depRange); " /></td>
</tr>
<tr>
	<td align="center" valign="bottom" height="20">
	  </td>
    <td align="left" valign="bottom" height="20">&nbsp;&nbsp;<button id="update22" name="update22" onClick="update22();">Update</button></td>
</tr>
</table>
</fieldset>
</div>
</div>
            <table align="center" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">
                <tr>
                    <td height="20" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR PENERIMAAN PO</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="20%">BULAN
                        
                        <select name="bulan" class="txt" id="bulan" onChange="filter()">
                            <option value="1" class="txtinput"<?php if ($th[1]=="1") echo "selected";?>>Januari</option>
                            <option value="2" class="txtinput"<?php if ($th[1]=="2") echo "selected";?>>Pebruari</option>
                            <option value="3" class="txtinput"<?php if ($th[1]=="3") echo "selected";?>>Maret</option>
                            <option value="4" class="txtinput"<?php if ($th[1]=="4") echo "selected";?>>April</option>
                            <option value="5" class="txtinput"<?php if ($th[1]=="5") echo "selected";?>>Mei</option>
                            <option value="6" class="txtinput"<?php if ($th[1]=="6") echo "selected";?>>Juni</option>
                            <option value="7" class="txtinput"<?php if ($th[1]=="7") echo "selected";?>>Juli</option>
                            <option value="8" class="txtinput"<?php if ($th[1]=="8") echo "selected";?>>Agustus</option>
                            <option value="9" class="txtinput"<?php if ($th[1]=="9") echo "selected";?>>September</option>
                            <option value="10" class="txtinput"<?php if ($th[1]=="10") echo "selected";?>>Oktober</option>
                            <option value="11" class="txtinput"<?php if ($th[1]=="11") echo "selected";?>>Nopember</option>
                            <option value="12" class="txtinput"<?php if ($th[1]=="12") echo "selected";?>>Desember</option>
                        </select>
                        <select name="ta" class="txt" id="ta" onChange="filter()">
                            <?php
                            for ($i=($th[2]-5);$i<($th[2]+1);$i++){
                                ?>
                            <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="id" name="id" /><input type="hidden" id="no_po" name="no_po" />
                    </td>
                    <td width="60%" align="right">
                        <button id="rekap" disabled type="button" onClick="rekap()" style="cursor: pointer">
                            <img alt="add" src="../icon/article.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak Rekap
                        </button>
						<button id="btnPenerimaan" disabled type="button" onClick="lp_penerimaan()" style="cursor: pointer">
                            <img alt="add" src="../icon/article.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak Penerimaan
                        </button>
						<button id="btnLapPen" disabled type="button" onClick="laporan()" style="cursor: pointer">
                            <img alt="add" src="../icon/article.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak BAPB
                        </button>
						<button id="btnLunas" disabled type="button" onClick="lunas()" style="cursor: pointer">
                            <img alt="add" src="../icon/find.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Set Nomor BAPB
                        </button>
                        <button type="button" onClick="location='po_detail_lsg.php?act=add'" style="cursor: pointer">
                            <img alt="add" src="../icon/find.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Barang Langsung
                        </button>
                        <button type="button" onClick="location='penerimaanPO_detil.php?act=add'" style="cursor: pointer">
                            <img alt="add" src="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Penerimaan PO
                        </button>
                        <button type="button" style="cursor: pointer" onClick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu Penerimaan yang akan diedit.');return;}location='penerimaanPO_detil.php?act=edit&id='+document.getElementById('id').value;">
                            <img alt="add" src="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Edit Penerimaan
                        </button>
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
						<div id="total_po" style="width:900px; height:25px; padding:5px; text-align:right; padding-right:40px;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                <?php
                include '../footer.php';
                ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
	var arrRange=depRange=[];
		
		function update22()
		{
			var no_ba = document.getElementById("no_ba").value;
            var tgl_ba = document.getElementById("tgl_ba").value;
			var no_po = document.getElementById("no_po").value;
			
			var dataString = "no_ba="+no_ba+"&tgl_ba="+tgl_ba+"&no_po="+no_po; //alert(dataString);
			$.ajax({
			type: "POST",
			url: "update_ba_new.php",
			data: dataString,
			success: function(msg)
				{
					//alert(msg);
					
						Popup.hide('lap_SAP');
						filter();
						document.getElementById("no_ba").value = '';
						document.getElementById("tgl_ba").value = '';
						document.getElementById("no_po").value = '';
						//alert(data[1]);
					
					
				}
				});
		}
		
		function setNo()
		{
			var no_po = document.getElementById("no_po").value
			var dataString = "no_po="+no_po; //alert(dataString);
			$.ajax({
			type: "POST",
			url: "generate_no.php",
			data: dataString,
			success: function(msg)
				{
					 document.getElementById("no_ba").value = msg;
					
				}
				});
		}
		
        function rekap(){
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            window.open("rekap_penerimaan_gudang.php?bln="+bln+"&thn="+thn,"rekap");
        }
		
		function lp_penerimaan(){
            var id = document.getElementById("id").value;
            window.open("reportPenerimaan.php?id="+id,"lapPenerimaan");
        }
		
		function laporan(){
            var id = document.getElementById("id").value;
            window.open("reportBeritaAcara.php?id="+id,"lapPen");
        }
		
		function lunas()
		{
			var no_po = document.getElementById('no_po').value;
			
			
		Popup.showModal('lap_SAP',null,null,{'screenColor':'silver','screenOpacity':.6});
		return false;
	

			//setTimeout("isidata("+rkbu_id+")",300);
//			Popup.showModal('pop_setlunas.php',null,null,{'screenColor':'silver','screenOpacity':.6});
//			return false;
		}
    
        function filter()
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            //alert("penerimaanPO_util.php?bln="+bln+"&thn="+thn);
            po.loadURL("penerimaanPO_util.php?bln="+bln+"&thn="+thn,"","GET");
			//loading();
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox"){
                po.loadURL("penerimaanPO_util.php?pilihan=penerimaan_po&bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
            }
        }
		
        function ambilData()
        {
            var p="id*-*"+(po.cellsGetValue(po.getSelRow(),3)+'|'+po.cellsGetValue(po.getSelRow(),4)+'|'+po.cellsGetValue(po.getSelRow(),5)+'|'+po.cellsGetValue(po.getSelRow(),2));
            fSetValue(window,p);
			
			document.getElementById("no_po").value = po.cellsGetValue(po.getSelRow(),4);
			document.getElementById("no_ba").value = po.cellsGetValue(po.getSelRow(),6);
			/*if(po.cellsGetValue(po.getSelRow(),6) == "")
			{
				setNo();
			}*/
			document.getElementById("tgl_ba").value = po.cellsGetValue(po.getSelRow(),7);
			 
            document.getElementById("rekap").disabled=false;
			document.getElementById("btnPenerimaan").disabled=false;
			//document.getElementById("btnLapPen").disabled=false;
			document.getElementById("btnLunas").disabled=false;
        }

        var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR PENERIMAAN PO :.");
        po.setColHeader("NO,TANGGAL,NO GUDANG,NO PO,NO FAKTUR,NO BA, TGL BA,VENDOR,NILAI");
        po.setIDColHeader(",tgl_terima,msk.no_gudang, po.no_po,msk.no_faktur,po.no_ba,po.tgl_ba,rek.namarekanan,nilai");
        po.setColWidth("30,80,120,180,90,60,80,130,100");
        po.setCellAlign("center,center,center,center,center,center,center,center,right");
        po.setCellHeight(20);
		po.onLoaded(loading);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowClick","ambilData"); 
		       
        //alert("penerimaanPO_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("penerimaanPO_util.php?bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.Init();

		function trim(str){
			return str.replace(/^\s+|\s+$/g,'');
		}
		
		function IsiNoSPK(p){
			var tmpnospk=p.innerHTML;
			var noGdg,noPO;
			var nospk;
			
			noGdg=po.cellsGetValue(po.getSelRow(),3);
			noPO=po.cellsGetValue(po.getSelRow(),4);
			nospk = prompt('Masukkan No SPK', (tmpnospk=='..........')?'':tmpnospk);
			if (nospk!=null && trim(nospk)!=tmpnospk){
				if (trim(nospk)=='' && (tmpnospk=='..........' || tmpnospk=='')){
					alert("Masukkan No SPK / Nota Dinas Terlebih Dahulu !");
				}else{
					Request("spk_utils.php?act=UpdateSPK&noSPK="+trim(nospk)+"&noSPKLama="+tmpnospk+"&noGudang="+noGdg+"&noPO="+noPO,p.id,"","GET","NOLOAD");
				}
			}
		}
		
		function loading(){
			setTimeout("cek_total()",300);
		}
		function cek_total(){
			var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
			var dataString = "bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(); //alert(dataString);
			$.ajax({
			type: "POST",
			url: "cetak_total.php",
			data: dataString,
			success: function(msg)
				{
					//alert(msg);
					document.getElementById("total_po").innerHTML= '<b>Total Nilai</b> : Rp. '+msg;
				}
				});
		}
		
		//$('#no_ba').keydown(function (e) {
//			if (e.shiftKey || e.ctrlKey || e.altKey) { // if shift, ctrl or alt keys held down
//				e.preventDefault();         // Prevent character input
//			} else {
//				var n = e.keyCode;
//				if (!((n == 8)              // backspace
//				|| (n == 46)                // delete
//				|| (n >= 35 && n <= 40)     // arrow keys/home/end
//				|| (n >= 48 && n <= 57)     // numbers on keyboard
//				|| (n >= 96 && n <= 105))   // number on keypad
//				) {
//					e.preventDefault();     // Prevent character input
//				}
//			}
//		});
    </script>
</html>
