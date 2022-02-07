<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
} 
//$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
$barang_opener="par=idbarang*kodebarang*namabarang";
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>
        <title>.: Laporan Kartu Stok :.</title>
    </head>

    <body>
        <div id="tree" style="display: none;"></div>
        <div align="center">
            <?php
            include '../header.php';
			include("popBrg.php");
            ?>
            <table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-top: 10px;" align="center">
                        <form id="form1" name="form1" action="KartuStok.php" method="post" target="Laporan Kartu Inventaris Barang">
                            <script>
                                        function showtree(){
                                            if(document.getElementById('treediv').style.display=='none'){
                                                document.getElementById('treediv').style.display='inline';
                                                }    
                                             else{
                                                document.getElementById('treediv').style.display='none';
                                                                                            
                                                                                             
                                             }                  
                                        }
                            </script>
                            <iframe scrolling="auto"  id="treediv" style="display: none;" width="1000" src="thing_tree.php?<?php echo $barang_opener; ?>"></iframe>
                            
                            <table id='tblJual' width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header">
                                        <strong><font size="2">Laporan Kartu Stok</font></strong>
                                    </td>
                                </tr>
								<tr>
                                    <td class="label">
                                        <strong>Barang</strong>
                                    </td>
                                    <td class="content" width="493">
                                    <input name="idbarang" type="hidden" class="txtunedited" id="idbarang"  size="16" maxlength="14" readonly/>
                                    <input name="kodebarang" type="text" class="txtunedited" id="kodebarang" size="16" maxlength="14" readonly/>
                                    <input name="namabarang" type="text" class="txtunedited" id="namabarang" size="30" maxlength="30" readonly/>
                <!--<img alt="tree" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('thing_tree.php?<?php echo $barang_opener; ?>',800,500,'msma',true);"> </td>-->
                <img alt="tree" width="18" title='Struktur tree kode barang'  style="cursor:pointer;visibility:<?=$visible;?>" border=0 src="../images/backsmall.gif" align="absbottom" onClick="lempar('<?php echo $barang_opener; ?>',this)">
                                </tr>
                                
                                <tr>
                                    <td class="label"><strong>Tanggal Perolehan</strong></td>
                                    <td class="content">
                                        <div id="a" >
                                            <input name="tglawal" type="text" class="txt" id="tglawal" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglawal'),depRange);" />
                                            <!--img alt="calender" name="imgtglawal" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglawal','dd-mm-yyyy',null,null,window.event);" /-->
                                            &nbsp;s/d&nbsp;
                                            <input name="tglakhir" type="text" class="txt" id="tglakhir" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglakhir'),depRange);" />
                                            <!--img alt="calender" name="imgtglakhir" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglakhir','dd-mm-yyyy',null,null,window.event);" /-->
                                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Format Laporan </strong></td>
                                    <td class="content"><select name="formatlap" class="txt" id="formatlap" tabindex="7">
                                            <option value="HTML">HTML</option>
                                            <option value="XLS">EXCEL</option>
                                            <option value="WORD">WORD</option>
                                        </select></td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" class="header2">
                                        <input name="submit" type="submit" id="submit" value="Tampilkan" onClick="if (document.getElementById('idbarang').value=='') {alert('Pilih Barang ');return false;}"/>
                                    </td>
                                </tr>
                            </table>
                            <input name="idunit" type="hidden" id="idunit" value="" />
                            <input name="namaunit" type="hidden" id="namaunit" value="" />
                            <input name="idlokasi" type="hidden" id="idlokasi" value="" />
                            <input name="kodelokasi" type="hidden" id="kodelokasi" value="" />
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];
		
	
    </script>
    <script>
	function lempar(a,par){
			var tbl = document.getElementById('tblJual');
			var jmlRow = tbl.rows.length;
			var i;
			if (jmlRow > 4){
				i=par.parentNode.parentNode.rowIndex-3;
			}else{
				i=0;
			}
			if('<?=$idbrng;?>'==''){
			var cekbrg='';
			for (var ipk=0;ipk<document.forms[0].idbarang.length;ipk++){
			if(ipk==0){
				cekbrg=document.forms[0].idbarang[ipk].value;
				}else{
				cekbrg+='**'+document.forms[0].idbarang[ipk].value;
				}
			
		}
		Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
		}else{
		Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
		}
		
		}
		var RowIdx3;
        var fKeyEnt3;
		function list1(e,par){
		var keywords=par.value;//alert(keywords);
		//alert(par.offsetLeft);
/*		var tbl = document.getElementById('tblJual');
		var jmlRow = tbl.rows.length;
		var i;
		if (jmlRow >= 4){
		i=par.parentNode.parentNode.rowIndex-1;
		}else{
		i=0;
		}
		var nomer=jmlRow-4;*/
		//var cmb1=document.getElementById('cmbfilter').value;
		/* 	if(cmb1!='') */
		
		//alert(jmlRow+'-'+i);
		if(keywords==""){
		document.getElementById('divobat').style.display='none';
		}else{
		var key;
		if(window.event) {
			key = window.event.keyCode;
		}
		else if(e.which) {
			key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			//alert(tblRow);
			if (tblRow>0){
				//alert(RowIdx3);
				if (key==38 && RowIdx3>0){
					RowIdx3=RowIdx3-1;
					document.getElementById(RowIdx3+1).className='itemtableReq';
					if (RowIdx3>0) document.getElementById(RowIdx3).className='itemtableMOverReq';
				}else if (key==40 && RowIdx3<tblRow){
					//RowIdx3=RowIdx3+1;
					//alert(tblRow);
					//alert(RowIdx3);
					if (RowIdx3>1) document.getElementById(RowIdx3-1).className='itemtableReq';
					document.getElementById(RowIdx3).className='itemtableMOverReq';
				}
			}
		}
		else if (key==13){
			if (RowIdx3>0){
				if (fKeyEnt3==false){
				alert (ValNamaBag(document.getElementById(RowIdx3).lang));
					ValNamaBag(document.getElementById(RowIdx3).lang);
				}else{
					fKeyEnt3=false;
				}
			}
		}
		else if (key!=27 && key!=37 && key!=39){
			RowIdx3=0;
			fKeyEnt3=false;
			if (document.getElementById('nmBarang').value.length>=3){
			Request('list_barangBon.php?aKeyword='+keywords+'&cmb='+document.getElementById('CmbStt').value, 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
			}
		}
		}
		}
		//valNamaBag(document.getElementById(RowIdx3).lang);
		function ValNamaBag(par){
		//alert(par);
			if(par!=""){
				var cdata=par.split("|");
				//alert (cdata[2]);
			    //var tbl = document.getElementById('tblJual');
				var tds;
				//alert('sdffsf');
					document.getElementById('idbarang').value=cdata[1];
					document.getElementById('kodebarang').value=cdata[2];
					document.getElementById('namabarang').value=cdata[3];
				//alert('kokok');
					//tds[1].innerHTML=cdata[4];
			}
		document.getElementById('divobat').style.display='none';
		Popup.hide('popList');
		}
	</script>
</html>
