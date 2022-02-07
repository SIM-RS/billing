<?php
include '../sesi.php';
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/';
                        </script>";

}
date_default_timezone_set("Asia/Jakarta");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
//$tgl=gmdate('d-m-Y',mktime(date('H')+7));
//$th=explode("-",$tgl);
//$bulan=$_REQUEST['bulan'];if ($bulan=="") //$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
//$tanggal = $_REQUEST['tgl'];
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: TAGIHAN :.</title>
    </head>

    <body>
        <div align="center">
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <?php
            include("../header.php");
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <!--tr>
									<td height="50" style="text-align:center; text-transform:uppercase; font-weight:bold; font-size:15px; color:#666666;">daftar tagihan jatuh tempo</td>
								</tr-->
								<tr>
									<td>
										<table width="100%" border="0" cellpadding="0" cellspacing="2">
											<tr>
												<td width="15%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">&nbsp;PERIODE BAYAR</td>
												<td width="65%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;">:&nbsp;&nbsp;&nbsp;<input name="tgl" type="text" class="txt" id="tgl" readonly value="<?php echo date("d-m-Y",strtotime($date_now)); ?>" size="15" maxlength="15" style="text-align:center" /><img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,filter);"></td>
												<td width="20%">&nbsp;</td>
											</tr>
											<tr>
												<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">&nbsp;SUPPLIER</td>
												<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">:&nbsp;&nbsp;&nbsp;<select id="cmbSup" name="cmbSup" onChange="filter()">
												<option value="0">SEMUA</option>
												<?php
														$qSup = "SELECT as_ms_rekanan.idrekanan as id, as_ms_rekanan.namarekanan as nama FROM as_ms_rekanan";
														$rsSup = mysql_query($qSup);
														while($rwSup = mysql_fetch_array($rsSup))
														{
												?>
												<option value="<?php echo $rwSup['id']?>" class="txtinput"><?php echo $rwSup['nama']?></option>
												<?php } ?>
												</select></td>
												<td style="text-align:right; padding-right:10px;"><input type="button" id="btnkwi" name="btnkwi" value="Kwitansi" onClick="klik()" style="background-color: #009900; color:#FFFFFF; cursor:pointer; color:#FFFFFF; border:1px solid #006600;" /></td>
											</tr>							
										</table>
									</td>
								</tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:950px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:950px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body><iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden"></iframe>
    <script type="text/javascript" language="javascript">
        var arrRange=depRange=[];
		function filter()
        {
            var idRekanan = document.getElementById("cmbSup").value;
            var tglTagihan = document.getElementById("tgl").value;
            //alert("utils.php?pilihan=tagihan&idRekanan="+idRekanan+"&tglTagihan="+tglTagihan);
            rek.loadURL("utils.php?pilihan=tagihan&idRekanan="+idRekanan+"&tglTagihan="+tglTagihan,"","GET");
        }
         function ambilData()
        {
            //alert(rek.cellsGetValue(rek.getSelRow(),2));
			/* var centang = rek.cellsGetValue(rek.getSelRow(),13);
			var noPo = rek.cellsGetValue(rek.getSelRow(),4);
			var actt;
			if(rek.obj.childNodes[0].childNodes[parseInt(rek.getSelRow())-1].childNodes[1].childNodes[0].checked){
				actt = 'tambahChk';
			}
			Request('utils.php?pilihan=false&act='+actt+'&noPo='+noPo,'','GET'); */
			
			
			//alert('utils.php?pilihan=false&act=tagihan&noPo='+noPo);
			var p="namarekanan*-*"+rek.cellsGetValue(rek.getSelRow(),2)+"*|*no_po*-*"+rek.cellsGetValue(rek.getSelRow(),4);
			var noPo = rek.cellsGetValue(rek.getSelRow(),4);
			//Request('utils.php?pilihan=false&act=tagihan&noPo='+noPo,'','GET');
			//rek.loadURL("utils.php?pilihan=tagihan&act=tagihan&noPo='+noPo+'&idRekanan="+document.getElementById("cmbSup").value+"&tglTagihan="+document.getElementById("tgl").value,"","GET");
            fSetValue(window,p);
			
        }
		
		function klik()
		{
			//var nomorPo = '';
			var supplier = rek.cellsGetValue(rek.getSelRow(),2);
			var noPo = rek.cellsGetValue(rek.getSelRow(),4);
			/* for(var i=0;i<rek.obj.childNodes[0].rows.length;i++){
				if(rek.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
					var getBaris=rek.getRowId(parseInt(i)+1).split("|");
					var barisId=getBaris[0];
					nomorPo+=barisId+',';	
				}
			}
			if(supplier == '' || noPo == '')
			{
				alert('Pilih dulu PO yang akan dicetak.');
				return;
			} */
			//var sisip=rek.getRowId(rek.getSelRow()).split("|");
			//alert('kwitansi.php?act=tagihan&supplier='+supplier+'&noPo='+noPo+'&kwi='+rek.cellsGetValue(rek.getSelRow(),13));
			//alert('utils.php?pilihan=tagihan&idRekanan='+document.getElementById("cmbSup").value+'&tglTagihan='+document.getElementById("tgl").value);
			window.open('kwitansi.php?supplier='+supplier+'&noPo='+noPo,'tmbh');
		//	rek.loadURL('utils.php?act=tagihan&pilihan=tagihan&idRekanan='+document.getElementById("cmbSup").value+'&tglTagihan='+document.getElementById("tgl").value+'&noPo='+noPo,'','GET');
			//Request('utils.php?act=tagihan&noPo='+noPo,'','GET');
		}

       /*  function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus PO "+rek.cellsGetValue(rek.getSelRow(),2))){
                rek.loadURL("utils.php?pilihan=po&act=hapus_po&id="+rowid,"","GET");
            }
        } */


        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                rek.loadURL("tagihan_util.php?pilihan=tagihan&filternm="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&idRekanan="+document.getElementById("cmbSup").value+"&tglTagihan="+document.getElementById("tgl").value,"","GET");
            }
			//alert ("utils.php?pilihan=tagihan&filternm="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&idRekanan="+document.getElementById("cmbSup").value+"&tglTagihan="+document.getElementById("tgl").value);
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Tagihan Jatuh Tempo :.");
        rek.setColHeader("NO,SUPPLIER/REKANAN,TGL PO,NO PO,TGL FAKTUR,NO FAKTUR,NO PENERIMAAN,TGL PENERIMAAN,NILAI DPP,NILAI PPN,JATUH TEMPO,KETERANGAN,KWI");
        //Jenis Barang,Jml Kemasan,Kemasan Diterima
        rek.setIDColHeader(",namarekanan,,,,no_faktur,,,,,,,,");
        //,tipebarang,qty_kemasan,qty_kemasan_terima
        rek.setColWidth("50,250,100,150,100,150,150,100,100,100,100,150,50");
        rek.setCellAlign("center,left,center,center,center,center,center,center,right,right,center,left,center");
		rek.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        //alert("utils.php?pilihan=tagihan&idRekanan="+document.getElementById('cmbSup').value+"&tglTagihan="+document.getElementById('tgl').value);
		rek.baseURL("tagihan_util.php?pilihan=tagihan&idRekanan="+document.getElementById("cmbSup").value+"&tglTagihan="+document.getElementById("tgl").value);
        rek.Init();
        //alert("utils.php?pilihan=po&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
    </script>
</html>