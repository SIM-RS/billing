<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$unit_opener="par=idunit*kodeunit*namaunit*idlokasi2*kodelokasi*namalokasi";
$unit_opener_mutasi="par=idunit_mut*kodeunit_mut*namaunit_mut*idlokasi_mut*kodelokasi_mut*namalokasi_mut";
$barang_opener="par=idbarang*kodebarang*namabarang";
$idunit = $_POST["idunit"];
$kodeunit = $_POST['kodeunit'];
$kodelokasi = $_POST['kodelokasi'];
$idlokasi = $_POST["idlokasi"];
$unit_id = $_GET["unit"];
$lokasi_id = $_GET["lokasi"];
$namaunit = $_GET['namaunit'];
$namalokasi = $_GET['namalokasi'];
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: DATA INVENTARIS :.</title>
    </head>
    
    <body>
    <?php /*
    <div id="div_popup" align="center" class="popup">
    <div id="div_popup1" align="center" class="poppy">
        <form id="form1" name="form1" action="" method="post">
            <table width="400" border="0" class="" cellpadding="0" cellspacing="0" style="margin-top: 50%; margin-left: 50%">
                <tr>
                    <td colspan="2" class="header" align="center">
                        .: Form Mutasi Barang :.
                    </td>
                </tr>
                <tr>
                    <td class="label" width="150">&nbsp;
                        Unit Lama
                        <input type="hidden" id="idunit_lama" />
                    </td>
                    <td class="content" width="250">&nbsp;
                        <span id="span_kodeunit"></span>
                        &nbsp;-&nbsp;
                        <span id="span_namaunit"></span>
                    </td>
                </tr>
                <tr>
                    <td class="label" width="150">&nbsp;
                        Ruangan Lama
                        <input type="hidden" id="idruang_lama" />
                    </td>
                    <td class="content" width="250">&nbsp;
                        <span id="span_koderuang"></span>
                        &nbsp;-&nbsp;
                        <span id="span_namaruang"></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">&nbsp;
                        Unit &amp; Ruangan Tujuan
                        <input type="hidden" id="idunit_mut" name="idunit_mut" />
                        <input type="hidden" id="idlokasi_mut" name="idlokasi_mut" />
                    </td>
                    <td class="content">&nbsp;
                        <input name="kodeunit_mut" type="hidden" class="txtunedited" readonly id="kodeunit_mut" tabindex="2" size="10" maxlength="15"/>
                        <input type="text" id="namaunit_mut" name="namaunit_mut"  class="txtunedited" readonly />
                        <img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('unit_tree_inventaris.php?<?php echo $unit_opener_mutasi; ?>',800,500,'Tree Unit',true)" />
                        -
                        <input name="namalokasi_mut" type="text" class="txtunedited" readonly id="namalokasi_mut" readonly />
			<input name="kodelokasi_mut" type="hidden" class="txtunedited" readonly id="kodelokasi_mut" tabindex="3" size="10" maxlength="10" readonly />
                        &nbsp;<img alt="search" title='daftar ruangan' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="OpenWnd('lv_ruang_inventaris.php?<?php echo $unit_opener_mutasi; ?>&idunit='+document.getElementById('idunit_mut').value+'&namaunit='+document.getElementById('namaunit_mut').value,410,300,'Daftar Ruangan',true)" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="header2">DIISI OLEH </td>
                </tr>
                <tr>
                    <td valign="top" class="label">&nbsp;
                        Nama
                    </td>
                    <td class="content">&nbsp;
                        <input name="namapetugas" type="text" class="txt" id="namapetugas" size="30" maxlength="50" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="label">&nbsp;
                        Jabatan
                    </td>
                    <td class="content">&nbsp;
                        <input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" size="30" maxlength="50" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="label">&nbsp;
                        Catatan
                    </td>
                    <td class="content">&nbsp;
                        <textarea name="catpetugas" cols="30" class="txt" rows="3" id="catpetugas"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">&nbsp;
                        Tanggal Mutasi
                    </td>
                    <td class="content">&nbsp;
                        <input name="tglmutasi" readonly type="text" class="txt" id="tglmutasi" size="20" maxlength="15" />
                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglmutasi'),depRange);" />
                        <font color="#666666"><em>(dd-mm-yyyy)</em></font>
                    </td>
                </tr>
                <tr>
                    <td class="footer" align="right" colspan="2">
                        <input type="hidden" id="destination" name="destination" />
                        <input type="button" value="Confirm" onClick="todo('conf_mutasi','div_popup',document.getElementById('destination').value)" /> &nbsp;
                        <input type="button" value="Cancel" onClick="todo('cancel','div_popup',document.getElementById('destination').value)" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="div_cover" class="cover" align="center">
    </div>
    </div>
    */ 
    ?>
    <!--end of pop up-->
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
        id="gToday:normal:agenda.js"
        src="../theme/popcjs.php" scrolling="no"
        frameborder="1"
        style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
        <div align="center">
            <?php
            include("../header.php");
	    //include ('popup_mutasi.php');
            ?>
	    <form name="form1" id="form1" method="post" action="" onSubmit="save()">
            <table align="center" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px;">
                <tr>
                    <td height="20" colspan="4">&nbsp;</td>
                </tr>
                <!--tr>
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR BARANG BELUM DITEMPATKAN </td>
                </tr-->
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
				<tr style="font-weight:bold;">
					<td>&nbsp;</td>
					<td height="28" colspan="2">
			                        
					
					</td>
					<td>&nbsp;</td>
				</tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                  	<td align="left">&nbsp;
                  	
					<input name="idunit" type="hidden" id="idunit" value="<?php echo  $unit_id; ?>">
						&nbsp;Lokasi :
					<input name="idlokasi2" type="hidden" id="idlokasi2" value="<?php echo  $lokasi_id; ?>" />
					<input name="namalokasi" type="text" class="txtunedited" id="namalokasi" readonly value="<?php echo  $namalokasi; ?>">
					<input name="kodelokasi" type="hidden" class="txtunedited" readonly id="kodelokasi" value="<?php echo  $rows["kodelokasi"]; ?>" size="10" maxlength="10" >
					&nbsp;<img alt="search" title='daftar ruangan' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="OpenWnd('tree_lokasi.php?par=idlokasi2*kodelokasi*namalokasi*kosongkan',800,500,'msma',true);">
               &nbsp;
                  	  </td>
                    <td width="19%" align="right">
			<button disabled="disabled" type="button" id="view" onClick="window.open('laporan_inventaris.php?unit='+idunit.value+'&lokasi='+idlokasi2.value)" style="cursor: pointer">
			<img alt="add" src="../icon/published.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
			Cetak KIR</button> 
			<input type="hidden" id="txtId" name="txtId" />
			<input type="hidden" id="txtKode" name="txtKode" />
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
                        <div id="gridbox" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                </tr>
                <tr>
                    <td colspan="4">
                <?php
                include '../footer.php';
                ?>                    </td>
                </tr>
            </table>
	    </form>
        </div>
    </body>
		
          <input type="hidden" name="act" value="<?php echo $act;?>">       
          <input name="idbarang" type="hidden" id="idbarang" value="<?php echo  $rows['idbarang']; ?>">
	  
	  
</div>
	  
    <script type="text/javascript" language="javascript">
	var arrRange=depRange=[];
	function todo(act,form,dest)
	{
	    var rowid = document.getElementById("txtId").value;
	    var unit = document.getElementById('idunit').value;
	    var lokasi = document.getElementById('idlokasi2').value;
	    var namaunit = document.getElementById('namaunit').value;
	    var kodelokasi = document.getElementById('kodelokasi').value;
	    var namalokasi = document.getElementById('namalokasi').value;
	    switch(act){
		case 'hapus':
		    
		    if(confirm("Anda yakin menghapus KIB "+dest+" "+grid.cellsGetValue(grid.getSelRow(),4))){
			var alasan = prompt("Alasan penghapusan: ");
			//alert(alasan);
			grid.loadURL("utils_seri.php?pilihan="+dest+"&act=hapus_"+dest+"&rowid="+rowid+"&alasan="+alasan,"","GET");
			
		    }
		    break;
		case 'mutasi':
		    document.getElementById('span_kodeunit').innerHTML = grid.cellsGetValue(grid.getSelRow(),2);
		    document.getElementById('idunit_lama').value = unit;
		    document.getElementById('span_namaunit').innerHTML = namaunit;
		    document.getElementById('idruang_lama').value = lokasi;
		    document.getElementById('span_koderuang').innerHTML = kodelokasi;
		    document.getElementById('span_namaruang').innerHTML = namalokasi;
		    document.getElementById('destination').value = dest;
		    document.getElementById(form).style.display = 'block';
		    break;
		case 'conf_mutasi':
		    /* var idunit = document.getElementById('idunit_mut').value;
		    var idlokasi = document.getElementById('idlokasi_mut').value;
		    if(idunit == '' || idunit == null || idlokasi == '' || idlokasi == null){
			alert("Unit harus diisi.");
			return;
		    } */
		    var idunit_old = document.getElementById('idunit_lama').value;
		    var idlokasi_old = document.getElementById('idruang_lama').value;
		    if(idlokasi == idlokasi_old){
			alert("Lokasi tujuan sama dengan lokasi asal, tentukan lokasi lain.");
			return;
		    }
		    var namapetugas = document.getElementById('namapetugas').value;
		    var jabatanpetugas = document.getElementById('jabatanpetugas').value;
		    var catpetugas = document.getElementById('catpetugas').value;
		    var tglmutasi = document.getElementById('tglmutasi').value;
		    //alert("utils_seri.php?pilihan="+dest+"&act=mutasi_"+dest+"&rowid="+rowid+"&idunit="+idunit+"&idlokasi="+idlokasi+"&namapetugas="+namapetugas+"&jabatanpetugas="+jabatanpetugas+"&catpetugas="+catpetugas+"&tglmutasi="+tglmutasi);
		    grid.loadURL("utils_seri.php?pilihan="+dest+"&act=mutasi_"+dest+"&rowid="+rowid+"&idlokasi="+idlokasi+"&namapetugas="+namapetugas+"&jabatanpetugas="+jabatanpetugas+"&catpetugas="+catpetugas+"&tglmutasi="+tglmutasi,"","GET");
		    todo('cancel',form,dest);
		    break;
		case 'cancel':
		    document.getElementById(form).style.display = 'none';
		   document.getElementById('idunit_lama').value = '';
		    document.getElementById('idruang_lama').value = '';
		    document.getElementById('kodeunit_mut').value = '';
		    document.getElementById('namaunit_mut').value = '';
		    document.getElementById('idunit_mut').value = '';
		    document.getElementById('idlokasi_mut').value = '';
		    document.getElementById('kodelokasi_mut').value = '';
		    document.getElementById('namapetugas').value = '';
		    document.getElementById('jabatanpetugas').value = '';
		    document.getElementById('catpetugas').value = '';
		    document.getElementById('tglmutasi').value = '';
		    break;
	    }
	    tampilkan();
	}

    
	function edit(){
	    if((document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null)
	       &&
	       (document.getElementById('txtKode').value == '' || document.getElementById('txtKode').value == null)
	       ){
		alert('Pilih barang terlebih dahulu.');
		return;
	    }
	    var kode = document.getElementById('txtKode').value.split(".");
        //alert(kode);
	    var page ='';
	    switch(kode[0]){
		case '01':
		    page = 'detailTanah.php';
		    break;
		case '02':
		    page = 'detailMesin.php';
		    break;
		case '03':
		    page = 'detailGedung.php';
		    break;
		case '04':
		    page = 'detailJalan.php';
		    break;
		case '05':
		    page = 'detailAset.php';
		    break;
		case '06':
		    page = 'detailKonstruksi.php';
		    break;
	    }
	    //var unit = document.getElementById('idunit').value;
	    var lokasi = document.getElementById('idlokasi2').value;
	    var namaunit = document.getElementById('namaunit').value;
	    var namalokasi = document.getElementById('namalokasi').value;
	    location=page+'?act=view&id_kib='+document.getElementById('txtId').value+'&from=dataInventaris.php&unit='+unit+'&lokasi='+lokasi+'&namaunit='+namaunit+'&namalokasi='+namalokasi+'&baris='+grid.getSelRow();
	}
	function mutasi(){
	    if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){
		alert('Pilih barang terlebih dahulu.');
		return;
	    }
	    var kode = document.getElementById('txtKode').value.split(".");
	    var page ='';
	    switch(kode[0]){
		case '01':
		    page = 'tanah';
		    break;
		case '02':
		    page = 'mesin';
		    break;
		case '03':
		    page = 'gedung';
		    break;
		case '04':
		    page = 'jalan';
		    break;
		case '05':
		    page = 'aset';
		    break;
		case '06':
		    page = 'konstruksi';
		    break;
	    }
	    todo('mutasi','div_popup',page);
	}
	function hapus(){
	    if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){
		alert('Pilih barang terlebih dahulu.');
		return;
	    }
	    var kode = document.getElementById('txtKode').value.split(".");
	    var page ='';
	    switch(kode[0]){
		case '01':
		    page = 'tanah';
		    break;
		case '02':
		    page = 'mesin';
		    break;
		case '03':
		    page = 'gedung';
		    break;
		case '04':
		    page = 'jalan';
		    break;
		case '05':
		    page = 'aset';
		    break;
		case '06':
		    page = 'konstruksi';
		    break;
	    }
	    todo('hapus','div_popup',page);
	}
	function tampilkan(){	    
	  //  var unit = document.getElementById('idunit').value;
	    var lokasi = document.getElementById('idlokasi2').value;
	    
	   // var kodeUnit = document.getElementById('kodeunit').value;
	   //alert("utils.php?pilihan=dataInventaris&lokasi="+lokasi);
	    grid.loadURL("utils.php?pilihan=dataInventaris&lokasi="+lokasi,"","GET");
        //alert("utils.php?pilihan=dataInventaris&unit="+unit+"&lokasi="+lokasi);
	}
        function filter()
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            //alert("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn);
            grid.loadURL("utils.php?pilihan=dataInventaris&bln="+bln+"&thn="+thn,"","GET");
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox"){
                grid.loadURL("utils.php?pilihan=dataInventaris&bln="+bln+"&thn="+thn+"&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
                
            }
        }
	var tmp;
	var sisip;
        function ambilData()
        {	    
       // alert(grid.getRowId(grid.getSelRow()));
	    var fromId = grid.getRowId(grid.getSelRow()).split("*");
	    tmp = fromId[0].split("|");
	    sisip = fromId[1].split("|");
	    document.getElementById('idlokasi2').value=sisip[1];
	    document.getElementById('namalokasi').value=sisip[2];
	    document.getElementById('idunit').value=sisip[0];
            var p = "txtId*-*"+tmp[0]+"|"+tmp[1]+"*|*txtKode*-*"+grid.cellsGetValue(grid.getSelRow(),2);
            fSetValue(window,p);
        }	
	//var unit = document.getElementById('idunit').value;
	var lokasi = document.getElementById('idlokasi2').value;
	//if(unit==''){ unit = 0;}
        var grid=new DSGridObject("gridbox");
        grid.setHeader(".: DATA INVENTARIS :.");
        grid.setColHeader("NO,NAMA UNIT,KODE BARANG,SERI,NAMA BARANG,KONDISI,TAHUN PEROLEHAN,ASAL USUL,NILAI PEROLEHAN,NILAI BUKU");
        grid.setColWidth("35,200,110,50,230,90,80,90,90,80");
        grid.setCellAlign("center,left,LEFT,center,left,center,center,center,right,right");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","ambilData");	
       // alert("utils.php?pilihan=dataInventaris&unit="+unit+"&lokasi="+lokasi);
        grid.baseURL("utils.php?pilihan=dataInventaris&lokasi="+lokasi);
        grid.Init();	
		//alert("utils.php?pilihan=dataInventaris&lokasi="+lokasi);
    </script>
</html>
