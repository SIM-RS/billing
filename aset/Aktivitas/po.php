<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/';
                        </script>";
}
date_default_timezone_set("Asia/Jakarta");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
		<script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>
		<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
        <title>.: PO :.</title>
    </head>

    <body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
        <div align="center">
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <?php
            include("../header.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
			$tgl_pertama = date("01-m-Y")
           // $tgl=explode("-",$date_now);
          //  $tgl1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                    <td height="30" valign="bottom" align="right">
									<div style="float:left; width:350px; margin-left:-25px;">
									
										Periode :  <input id="tgl1" name="tgl1" value="<?php echo $tgl_pertama;//$date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                                    <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl1'),depRange,filter);" />
											&nbsp;s/d&nbsp;
											<input id="tgl2" name="tgl2" value="<?php echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                                    <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange,filter);" />									  </div>
									 <button type="button" onClick="location='brg_langsungPO.php'" style="cursor: pointer">
                            <img alt="add" src="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Buat PO Penerimaan Langsung                        </button> 
									<button type="button" onClick="Cetak_PO();" style="cursor: pointer">
                            <img alt="add" src="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak Daftar PO                        </button>
                         
                        <button type="button" onClick="Cetak_dPO();" style="cursor: pointer">
                            <img alt="add" src="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Cetak Details PO                        </button>
						<button type="button" onClick="set_spk();" style="cursor: pointer">
                            <img alt="add" src="../icon/find.png" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Set No SPK                       </button><br>
										<input type="hidden" id="txtId" name="txtId" />
                                        <input type="hidden" id="no_po" name="no_po" />
										<input type="hidden" id="tipe" name="tipe"/>
										<input type="hidden" id="tgl_pox" name="tgl_pox"/>
										<input type="hidden" id="exp_nya" name="exp_nya"/>
										<input type="hidden" id="diterima_full" name="diterima_full"/>
										<input type="hidden" id="total_record" name="total_record"/>
									</td>
                                </tr>
                                <tr>
                                  <td align="right">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right">
									<input type="hidden" name="id_pox" id="id_pox" size="5">
										<img alt="tambah" src="../images/tambah.png" style="cursor: pointer" onClick="location='po_detil_add.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" src="../images/edit.gif" style="cursor: pointer" onClick="edit()" />&nbsp;&nbsp;
                                        <img alt="hapus" src="../images/hapus.gif" style="cursor: pointer" id="btnHapusPO" name="btnHapus" onClick="hapus()"; />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:950px; height:300px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:950px;"></div>                                    </td>
                                </tr>
                            </table>
                            <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
		
		
		
<div id="pop_spk" class="popup" style="display:none;width:600px;">
<div id="gsap" style="width:600px; height:120px; background-color:white; overflow:hidden; padding:5px 5px 25px 25px; border:2px solid #CCCCCC;">
<div style="float:right; cursor:pointer" class="popup_closebox">
	<input type="button" value=" X " onClick="Popup.hide('pop_spk');" />
</div>
<br>
 <fieldset>
            <legend align="center"><font style="font:bold 11px tahoma; text-align:center;">Masukkan No SPK</font></legend><br />

<table width="500" cellpadding="0" cellspacing="0">
<tr>
  <td class="fontPegTab">No SPK </td>
  <td>: <input type="text" id="no_spkx" name="no_spkx">&nbsp;&nbsp;<button id="update22" name="update22" onClick="kasih_spk();">Update</button></td>
</tr>
<tr>
  <td class="fontPegTab">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
</fieldset>
</div>
</div>
    </body>
    
    <script type="text/javascript" language="javascript">
    
    var arrRange=depRange=[];

	function Cetak_PO(){	    
	    var tgl1=document.getElementById('tgl1').value;
	    var tgl2=document.getElementById('tgl2').value;
	    if(tgl1=='' || tgl2==''){
		alert("Silakan pilih data terlebih dahulu!");
	    }else{
		window.open('po_cetak.php?tgl1='+tgl1+'&tgl2='+tgl2,'Cetak_PO');
	    }
	}
	
	var sisipan;
	function Cetak_dPO()
	{
		if(document.getElementById('txtId').value=='')
		{
				alert('Pilih data Dahulu');
				return;			
		}
		else
		{
			var pilih = rek.cellsGetValue(rek.getSelRow(),3);
			pilih = pilih.split('.');
			var oo=rek.getRowId(rek.getSelRow()).split("|")
			window.open('cetak_po.php?jns='+pilih[0]+'&pemb='+oo[3]+'&veri='+oo[4]+'&tgl='+rek.cellsGetValue(rek.getSelRow(),2)+'&nomor='+rek.cellsGetValue(rek.getSelRow(),3)+'&supplier='+sisipan[2]+'&tgl_kirim='+rek.cellsGetValue(rek.getSelRow(),2)+'&jdl='+rek.cellsGetValue(rek.getSelRow(),4)+'&no_po='+rek.cellsGetValue(rek.getSelRow(),3));   
					//alert (rek.cellsGetValue(rek.getSelRow(),4));
					//window.open('cetak_po.php?jns='+rek.cellsGetValue(rek.getSelRow(),3)+'&tgl='+rek.cellsGetValue(rek.getSelRow(),2)+'&nomor='+rek.cellsGetValue(rek.getSelRow(),4)+'&supplier='+sisipan[2]+'&tgl_kirim='+rek.cellsGetValue(rek.getSelRow(),2)+'&jdl='+rek.cellsGetValue(rek.getSelRow(),5)+'&no_po='+rek.cellsGetValue(rek.getSelRow(),4));   
		}
	}
	
	var tanggalPo='';
    function ambilData()
	{
		
		sisipan=rek.getRowId(rek.getSelRow()).split("|");//alert(sisipan);
		document.getElementById('id_pox').value=sisipan[0];
		
		document.getElementById('total_record').value=sisipan[9];
		document.getElementById('diterima_full').value=sisipan[8];
		document.getElementById('no_spkx').value=sisipan[7];
		document.getElementById('exp_nya').value=sisipan[6];
		document.getElementById('tgl_pox').value=sisipan[5];
		var tipe=document.getElementById('tipe').value=sisipan[1];
		tanggalPo=sisipan[5];
		var p="txtId*-*"+(rek.getRowId(rek.getSelRow()))+"*|*no_po*-*"+rek.cellsGetValue(rek.getSelRow(),3);
		fSetValue(window,p);
	}

	function edit()
	{
		var diterima_full = document.getElementById('diterima_full').value;
		var total_record = document.getElementById('total_record').value;
		if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null)
		{
			alert('Pilih dulu PO yang akan diedit.');return;
		}
		else if(diterima_full==total_record)
		{
			alert('PO tidak bisa diedit, barang sudah diterima semua');return;
		}
		location='po_detil_edit.php?act=edit&no_po='+document.getElementById('no_po').value+'&tglPo='+tanggalPo+'&tipe='+document.getElementById('tipe').value+'&tgl_expnya='+document.getElementById('exp_nya').value;
	}
	function hapus()
	{
		var id_pox = document.getElementById('id_pox').value;
		var no_po = rek.cellsGetValue(rek.getSelRow(),3);
		var tgl1=document.getElementById('tgl1').value;
		var tgl2=document.getElementById('tgl2').value;
		
		if(id_pox=="")
		{
			alert('Pilih Baris yang akan dihapus!')
		}
		else
		{
			if(confirm("Anda yakin menghapus PO "+no_po+" ?"))
			{
				//alert ("po_util.php?act=hapus_po&no_po="+rek.cellsGetValue(rek.getSelRow(),3));
				rek.loadURL("po_util.php?act=hapus_po&no_po="+no_po+"&tglPo="+tanggalPo+"&tgl1="+tgl1+"&tgl2="+tgl2,"","GET");
				document.getElementById('id_pox').value="";
			}
		}
	}

	function ErrDel(prm1,prm2)
	{
	    if (prm2=='ErrDel') alert ('Semua/sebagian data PO sudah diterima. PO tidak boleh dihapus !');
	}
	
	function filter()
	{
		var tgl1=document.getElementById('tgl1').value;
		var tgl2=document.getElementById('tgl2').value;
	  // alert(tgl1+"----"+tgl2);
	    rek.loadURL("po_util.php?tgl1="+document.getElementById('tgl1').value+"&tgl2="+document.getElementById('tgl2').value,'','GET');
   //alert("po_util.php?tgl1="+document.getElementById('tgl1').value+"&tgl2="+document.getElementById('tgl2').value);
	}
	
	function goFilterAndSort(pilihan)
	{
		if (pilihan=="gridbox")
		{
			rek.loadURL("po_util.php?filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&tgl1="+document.getElementById('tgl1').value+"&tgl2="+document.getElementById('tgl2').value,"","GET");
		}
		//alert ("po_util.php?filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage()+"&tgl1="+document.getElementById('tgl1').value+"&tgl2="+document.getElementById('tgl2').value);
	}

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data PO :.");
        rek.setColHeader("No,Tanggal,No Pengadaan,Judul Pengadaan,Rekanan,No SPK,Exp Kirim,Biaya,Tipe Penerimaan,Status");
		rek.setIDColHeader(",tgl_po,no_po,judul,vendor_id,no_spk,,biaya,po_akhir");
        rek.setColWidth("30,80,200,230,150,100,150,100,120,100");
        rek.setCellAlign("center,center,center,left,left,center,center,right,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
	rek.onLoaded(ErrDel);
        //rek.baseURL("utils.php?pilihan=po&bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
	rek.baseURL("po_util.php?tgl1="+document.getElementById('tgl1').value+"&tgl2="+document.getElementById('tgl2').value);
        rek.Init();
        //alert("po_util.php?bln="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value);
		
	function set_spk()
	{

		if(document.getElementById('txtId').value=='')
		{
				alert('Pilih data Dahulu');
				return;			
		}
		else
		{
			
			Popup.showModal('pop_spk',null,null,{'screenColor':'silver','screenOpacity':.6});
			document.getElementById('no_spkx').focus();
			return false;
			 
		}
	}
	
	function kasih_spk()
	{
			var no_po = document.getElementById("no_po").value;
			var tgl_po = document.getElementById('tgl_pox').value;
			var no_spk = document.getElementById('no_spkx').value;
			var dataString = "no_po="+no_po+"&tgl_po="+tgl_po+"&no_spk="+no_spk; //alert(dataString);
			$.ajax({
			type: "POST",
			url: "generate_no_spk.php",
			data: dataString,
			success: function(msg)
				{
					//alert(msg)
					Popup.hide('pop_spk');
					goFilterAndSort("gridbox");
				}
			});
	}
    </script>
</html>