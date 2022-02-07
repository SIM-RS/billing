<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);

$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];

$tgltrans1=$_REQUEST["tgl_produksi"];
$tgltrans=explode("-",$tgltrans1);
$tgl_produksi=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];

convert_var($tgl2,$bulan,$tgl_produksi);

$no_produksi=$_REQUEST["no_produksi"];
$kp_id=$_REQUEST["kp_id"];
$fdata=$_REQUEST["fdata"];
$isview=$_REQUEST["isview"];
$fasal=$_REQUEST["fasal"];

convert_var($no_produksi,$kp_id,$fdata,$isview,$fasal);
//echo $fdata."<br>";
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
convert_var($page,$sorting,$filter,$act);
//echo $act;

switch ($act){
	case "save":
		$arfdata1=explode("*|*",$fdata);
		$arfdata_asal=explode("**",$arfdata1[0]);
		$arfdata=explode("**",$arfdata1[1]);
		for ($i=0;$i<count($arfdata);$i++){
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="INSERT INTO a_penerimaan(OBAT_ID,ID_LAMA,FK_MINTA_ID,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,USER_ID_TERIMA,NOKIRIM,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_STOK,QTY_RETUR,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,EXTRA_DISKON,DISKON_TOTAL,KET,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS) VALUES ($arfvalue[0],0,0,0,$idunit,$idunit,$kp_id,$iduser,$iduser,'$no_produksi','$no_produksi','$no_produksi',NOW(),'$tgl_produksi',null,0,'',null,0,'',0,$arfvalue[1],$arfvalue[1],0,$arfvalue[1]*$arfvalue[2],$arfvalue[2],0,0,0,'',0,0,4,1)";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
/*
			$sql="select ID from a_penerimaan where UNIT_ID_KIRIM=$idunit and UNIT_ID_TERIMA=$idunit and NOKIRIM='$no_produksi' and NOTERIMA='$no_produksi' order by ID desc limit 1";
			$rs=mysqli_query($konek,$sql);
			$idbaru=0;
			if ($rows=mysqli_fetch_array($rs)){
				$idbaru=$rows['ID'];
			}

			$sql="call sp_produksi($idunit,'$no_produksi',$arfvalue[0],$arfvalue[1],$arfvalue[2],$arfvalue[3],$arfvalue[4],$arfvalue[5],$iduser,'$tgl_produksi','$tglact')";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
*/
		}
		for ($i=0;$i<count($arfdata_asal);$i++){
			$arfvalue=explode("|",$arfdata_asal[$i]);
			$sql="call sp_produksi($idunit,'$no_produksi',$arfvalue[0],$kp_id,$arfvalue[1],$iduser,'$tgl_produksi','$tglact')";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
		//echo "<script>location='?f=list_produksi_obat.php'</script-->";
		//header("Location: ?f=list_minta_obat.php");
		//exit();
		break;
}
if ($kp_id=="") $kp_id=0;
$sql="select * from a_kepemilikan where ID=$kp_id";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$kp_nama=$rows['NAMA'];
}
//Aksi Save, Edit, Delete Berakhir ====================================
$sql="select * from a_penerimaan where UNIT_ID_KIRIM=$idunit and UNIT_ID_TERIMA=$idunit and NOKIRIM like '$kodeunit/PR/$th[2]-$th[1]/%' and month(TANGGAL)=$bulan and year(TANGGAL)=$th[2] order by NOKIRIM desc limit 1";
//echo $sql."<br>";
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$no_produksi1=$rows1["NOKIRIM"];
	$ctmp=explode("/",$no_produksi1);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_produksi1="$kodeunit/PR/$th[2]-$th[1]/$ctmp";
}else{
	$no_produksi1="$kodeunit/PR/$th[2]-$th[1]/0001";
}
//mysqli_free_result($rs1);
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
*/
var RowIdx;
var fKeyEnt;

function suggest(e,par,a){
var keywords=par.value;//alert(keywords);
var tbl;
	//alert(par.offsetLeft);
  if (a==1){
  	tbl = document.getElementById('tblJual');
  }else{
  	tbl = document.getElementById('tblHasil');
  }
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
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
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					if (a==1){
						fSetObat(document.getElementById(RowIdx).lang);
					}else{
						fSetObat1(document.getElementById(RowIdx).lang);
					}
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			if (a==1){
				Request('../transaksi/obatlist_produksi.php?aKeyword='+keywords+'&aKepemilikan='+document.forms[0].kp_id.value+'&idunit=<?php echo $idunit; ?>&no='+i+'&tipe=1' , 'divobat', '', 'GET' );
			}else{
				Request('../transaksi/obatlist_harga.php?aKeyword='+keywords+'&aKepemilikan='+document.forms[0].kp_id.value+'&no='+i , 'divobat', '', 'GET' );
			}
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].no_produksi.value==""){
		alert('Isikan No Produksi Terlebih Dahulu !');
		document.forms[0].no_produksi.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value;
			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			if ((document.forms[0].txtJml[i].value=="")||(document.forms[0].txtJml[i].value=="0")){
				alert('Masukkan Jumlah Bahan Produksi Terlebih Dahulu !');
				document.forms[0].txtJml[i].focus();
				return false;		
			}			
			cdata +=ctemp+'|'+document.forms[0].txtJml[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		if ((document.forms[0].txtJml.value=="")||(document.forms[0].txtJml.value=="0")){
			alert('Masukkan Jumlah Bahan Produksi Terlebih Dahulu !');
			document.forms[0].txtJml.focus();
			return false;		
		}			
		ctemp=document.forms[0].obatid.value;
		cdata +=ctemp+'|'+document.forms[0].txtJml.value;
		//cdata=ctemp+'|'+document.forms[0].kp_id.value+'|'+document.forms[0].txtJml.value;
	}
	ctemp='';
	if (document.forms[0].obatid1.length){
		for (var i=0;i<document.forms[0].obatid1.length;i++){
			if (document.forms[0].obatid1[i].value==""){
				alert('Pilih Obat Hasil Produksi Terlebih Dahulu !');
				document.forms[0].txtObat1[i].focus();
				return false;		
			}			
			if ((document.forms[0].harga[i].value=="")||(document.forms[0].harga[i].value=="0")){
				alert('Masukkam Harga Obat Hasil Produksi Terlebih Dahulu !');
				document.forms[0].harga[i].focus();
				return false;		
			}			
			if ((document.forms[0].txtJml1[i].value=="")||(document.forms[0].txtJml1[i].value=="0")){
				alert('Masukkam Jumlah Obat Hasil Produksi Terlebih Dahulu !');
				document.forms[0].txtJml1[i].focus();
				return false;		
			}
			ctemp +=document.forms[0].obatid1[i].value+'|'+document.forms[0].txtJml1[i].value+'|'+document.forms[0].harga[i].value+'**';		
		}
		if (ctemp!='') ctemp=ctemp.substr(0,ctemp.length-2);
	}else{
		if (document.forms[0].obatid1.value==""){
			alert('Pilih Obat Hasil Produksi Terlebih Dahulu !');
			document.forms[0].txtObat1.focus();
			return false;		
		}			
		if ((document.forms[0].harga.value=="")||(document.forms[0].harga.value=="0")){
			alert('Masukkam Harga Obat Hasil Produksi Terlebih Dahulu !');
			document.forms[0].harga.focus();
			return false;		
		}			
		if ((document.forms[0].txtJml1.value=="")||(document.forms[0].txtJml1.value=="0")){
			alert('Masukkam Jumlah Obat Hasil Produksi Terlebih Dahulu !');
			document.forms[0].txtJml1.focus();
			return false;		
		}			
		ctemp +=document.forms[0].obatid1.value+'|'+document.forms[0].txtJml1.value+'|'+document.forms[0].harga.value;		
	}
	cdata +='*|*'+ctemp;
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	document.forms[0].submit();
}

function fSetBatalFr(){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  //alert(jmlRow);
  if (jmlRow > 4){
	  for (var i=jmlRow;i>4;i--){
		tbl.deleteRow(i-1);
	  }
  }
	document.form1.txtObat.focus();
}

function HitungSubTot(par){
//var tbl = document.getElementById('tblJual');
var i=par.parentNode.parentNode.rowIndex;
	//alert(i);
	if (i==3){
		document.form1.txtSubTot.value=(document.form1.txtHarga.value*1)*(document.form1.txtJml.value*1);
	}else{
		document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
	}
	HitungTot();
}

function HitungTot(){
	if (document.form1.txtSubTot.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTot.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			cStot +=(document.form1.txtSubTot[i].value*1);
		}
		document.form1.subtotal.value=cStot;
		//alert(cStot);
	}else{
		document.form1.subtotal.value=document.form1.txtSubTot.value;
	}
		document.form1.tot_harga.value=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
}

function AddRow(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable();
//	}else{
//		HitungSubTot(par);
	}
}

function AddRow1(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable1();
//	}else{
//		HitungSubTot(par);
	}
}

// Last updated 2006-02-21
function addRowToTable()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  cellLeft = row.insertCell(1);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(2);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid';
  }else{
  	el = document.createElement('<input name="obatid"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
/*  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kp_asal';
  }else{
  	el = document.createElement('<input name="kp_asal"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
*/
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this,1);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event,this,1);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 112;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
/*
  // select cell
  cellLeft = row.insertCell(4);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
*/
  // right cell
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('OnKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat[iteration-3].focus();

  // select cell
/*  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow';
  sel.id = 'selRow'+iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

// Last updated 2006-02-21
function addRowToTable1()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblHasil');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  cellLeft = row.insertCell(1);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(2);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid1';
  }else{
  	el = document.createElement('<input name="obatid1"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
/*
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kp_id';
  }else{
  	el = document.createElement('<input name="kp_id"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
*/
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat1';
	el.setAttribute('OnKeyUp', "suggest(event,this,2);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat1" onKeyUp="suggest(event,this,2);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 101;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
/*
  cellLeft = row.insertCell(4);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
*/
  // right cell
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml1';
	el.setAttribute('onKeyUp', "AddRow1(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml1" onKeyUp="AddRow1(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'harga';
	el.setAttribute('onKeyUp', "AddRow1(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="harga" onKeyUp="AddRow1(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 7;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable1(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable1(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat1[iteration-3].focus();

  // select cell
/*  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow';
  sel.id = 'selRow'+iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

function keyPressTest(e, obj){
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}

function removeRowFromTable(cRow){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 4){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=3;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-2;
	  }
	  //HitungTot();
  }
}

function removeRowFromTable1(cRow){
  var tbl = document.getElementById('tblHasil');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 4){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=3;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-2;
	  }
	  //HitungTot();
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1];
		//document.forms[0].kp_asal.value=cdata[7];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
	}else{
		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value;
			//alert(cdata[1]+'-'+w);
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
		//document.forms[0].kp_asal[(cdata[0]*1)-1].value=cdata[7];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[6];
	tds[3].innerHTML=cdata[3];
	//tds[4].innerHTML=cdata[8];

	document.getElementById('divobat').style.display='none';
}

function fSetObat1(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblHasil');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid1.value=cdata[1];
		//document.forms[0].kp_id.value=cdata[5];
		document.forms[0].txtObat1.value=cdata[2];
		document.forms[0].harga.value=cdata[7];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml1.focus();
	}else{
/*		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value;
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
*/
		document.forms[0].obatid1[(cdata[0]*1)-1].value=cdata[1];
		//document.forms[0].kp_id[(cdata[0]*1)-1].value=cdata[5];
		document.forms[0].txtObat1[(cdata[0]*1)-1].value=cdata[2];
		document.forms[0].harga[(cdata[0]*1)-1].value=cdata[7];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml1[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[4];
	tds[3].innerHTML=cdata[3];
	//tds[4].innerHTML=cdata[6];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body onLoad="document.form1.txtObat.focus()">
<script>
var arrRange=depRange=[];
function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=800,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:35px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<?php if ($act=="save"){?>
<div align="center" id="idArea" style="display:none">
	<div align="center">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr> ` 
      <td colspan="2" align="center" class=""><span class="jdltable">PRODUKSI OBAT</span></td>
    </tr>
    <tr> 
      <td width="103" class="txtinput">Tgl Produksi&nbsp;</td>
      <td width="441" class="txtinput">: <?php echo $tgltrans1;?></td>
    </tr>
    <tr> 
      <td width="103" class="txtinput">No. Produksi</td>
      <td class="txtinput">: <?php echo $no_produksi;?></td>
    </tr>
    <tr>
      <td class="txtinput">Kepemilikan</td>
      <td class="txtinput">: <?php echo $kp_nama;?></td>
    </tr>
  </table>
			  
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td width="80" class="tblheader" id="OBAT_KODE" >Kode Obat</td>
      <td id="OBAT_NAMA" class="tblheader">Bahan Produksi</td>
      <td width="80" class="tblheader" id="OBAT_SATUAN_KECIL">Satuan</td>
      <td width="40" class="tblheader" id="qty">Qty</td>
      <td width="60" class="tblheader" id="qty">Harga Satuan</td>
      <td width="70" class="tblheader" id="qty">Subtotal</td>
    </tr>
    <?php
	$sq="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,apr.qty_lama,ap.HARGA_BELI_SATUAN,apr.qty_lama*ap.HARGA_BELI_SATUAN as stotal from a_produksi apr inner join a_penerimaan ap on apr.id_lama=ap.ID inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID where apr.no_produksi='$no_produksi'";
	//echo $sq;
	$qr=mysqli_query($konek,$sq);
	$p=0;
	while($show=mysqli_fetch_array($qr)){
	$p++;
	?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td align="center" class="tdisikiri"><? echo $p?></td>
      <td align="center" class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
      <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
      <td align="center" class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
      <td align="center" class="tdisi"><?php echo $show['qty_lama']; ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],2,",","."); ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['stotal'],2,",","."); ?></td>
    </tr>
    <? } ?>
  </table>
  <br>
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td width="80" class="tblheader">Kode Obat</td>
      <td id="OBAT_NAMA" class="tblheader">Hasil Produksi</td>
      <td width="80" class="tblheader">Satuan</td>
      <td width="40" class="tblheader">Qty</td>
      <td width="60" class="tblheader">Harga Satuan</td>
      <td width="70" class="tblheader">Subtotal</td>
    </tr>
    <?php
	$sq="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.QTY_SATUAN,ap.HARGA_BELI_SATUAN,ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN as stotal from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID where ap.NOKIRIM='$no_produksi'";
	//echo $sq;
	$qr=mysqli_query($konek,$sq);
	$p=0;
	while($show=mysqli_fetch_array($qr)){
	$p++;
	?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td align="center" class="tdisikiri"><? echo $p?></td>
      <td align="center" class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
      <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
      <td align="center" class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
      <td align="center" class="tdisi"><?php echo $show['QTY_SATUAN']; ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],2,",","."); ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['stotal'],2,",","."); ?></td>
    </tr>
    <? } ?>
  </table>
  </div>
</div>
<?php }?>
<?php if ($isview=="true"){?>
<div align="center" id="idArea" style="display:block">
	<div align="center">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr> ` 
      <td colspan="2" align="center" class=""><span class="jdltable">PRODUKSI OBAT / BHP</span></td>
    </tr>
    <tr> 
      <td width="103" class="txtinput">Tgl Produksi&nbsp;</td>
      <td width="441" class="txtinput">: <?php echo $tgltrans1;?></td>
    </tr>
    <tr> 
      <td width="103" class="txtinput">No. Produksi</td>
      <td class="txtinput">: <?php echo $no_produksi;?></td>
    </tr>
    <tr>
      <td class="txtinput">Kepemilikan</td>
      <td class="txtinput">: <?php echo $kp_nama;?></td>
    </tr>
  </table>
			  
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td width="80" class="tblheader" id="OBAT_KODE" >Kode Obat</td>
      <td id="OBAT_NAMA" class="tblheader">Bahan Produksi</td>
      <td width="80" class="tblheader" id="OBAT_SATUAN_KECIL">Satuan</td>
      <td width="40" class="tblheader" id="qty">Qty</td>
      <td width="80" class="tblheader" id="qty">Harga Satuan</td>
      <td width="100" class="tblheader" id="qty">Subtotal</td>
    </tr>
    <?php
	$sq="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,apr.qty_lama,ap.HARGA_BELI_SATUAN,apr.qty_lama*ap.HARGA_BELI_SATUAN as stotal from a_produksi apr inner join a_penerimaan ap on apr.id_lama=ap.ID inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID where apr.no_produksi='$no_produksi'";
	//echo $sq;
	$qr=mysqli_query($konek,$sq);
	$p=0;
	while($show=mysqli_fetch_array($qr)){
	$p++;
	?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" align="center"><? echo $p?></td>
      <td class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
      <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
      <td class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
      <td class="tdisi"><?php echo $show['qty_lama']; ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],2,",","."); ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['stotal'],2,",","."); ?></td>
    </tr>
    <? } ?>
  </table>
  <br>
  <table width="98%" border="0" cellpadding="1" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td width="80" class="tblheader">Kode Obat</td>
      <td id="OBAT_NAMA" class="tblheader">Hasil Produksi</td>
      <td width="80" class="tblheader">Satuan</td>
      <td width="40" class="tblheader">Qty</td>
      <td width="80" class="tblheader">Harga Satuan</td>
      <td width="100" class="tblheader">Subtotal</td>
    </tr>
    <?php
	$sq="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.QTY_SATUAN,ap.HARGA_BELI_SATUAN,ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN as stotal from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID where ap.NOKIRIM='$no_produksi'";
	//echo $sq;
	$qr=mysqli_query($konek,$sq);
	$p=0;
	while($show=mysqli_fetch_array($qr)){
	$p++;
	?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri" align="center"><? echo $p?></td>
      <td class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
      <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
      <td class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
      <td class="tdisi"><?php echo $show['QTY_SATUAN']; ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],2,",","."); ?></td>
      <td align="right" class="tdisi"><?php echo number_format($show['stotal'],2,",","."); ?></td>
    </tr>
    <? } ?>
  </table>
  </div>
</div>
	<p align="center">
		<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Produksi&nbsp;</BUTTON>&nbsp;
		<BUTTON type="button" onClick="<?php if ($fasal=="rpt"){?>location='?f=list_produksi.php'<?php }else{?>location='?f=../produksi/list_produksi_obat.php'<?php }?>"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	  </p>
<?php }else{?>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	  <table width="99%" border="1">
	  	<tr>
			<td>
  <div id="input" style="display:block" align="center"> 
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td width="125">Unit&nbsp; </td>
                <td>: <?php echo $namaunit; ?></td>
              </tr>
              <tr> 
                <td width="125">Tanggal&nbsp; </td>
                <td>: 
                  <input name="tgl_produksi" type="text" id="tgl_produksi" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_produksi,depRange);" /></td>
              </tr>
              <tr> 
                <td>No. Produksi</td>
                <td>: 
                  <input name="no_produksi" type="text" class="txtinput" id="no_produksi" value="<?php echo $no_produksi1; ?>" size="25" maxlength="30" readonly="true"></td>
              </tr>
              <tr>
                <td>Kepemilikan</td>
                <td>: 
                  <select name="kp_id" id="kp_id" class="txtinput">
                    <?
					  $qry="Select * from a_kepemilikan where aktif=1";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                    <option value="<?php echo $show['ID'];?>" class="txtinput"><?php echo $show['NAMA'];?></option>
                    <? }?>
                  </select></td>
              </tr>
            </table>
  </div>
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="6" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="5" align="center" class="jdltable">DAFTAR BAHAN PRODUKSI 
                OBAT / BHP</td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="80" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat Asal</td>
              <td width="80" height="25" class="tblheader">Satuan</td>
              <td width="40" height="25" class="tblheader">Qty</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
                <input type="text" name="txtObat" class="txtinput" size="112" onKeyUp="suggest(event,this,1);" autocomplete="off" /></td>
              <td class="tdisi">-</td>
              <td class="tdisi" width="40"> <input type="text" name="txtJml" class="txtcenter" size="5" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
          <table id="tblHasil" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="7" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="6" align="center" class="jdltable">DAFTAR HASIL PRODUKSI 
                OBAT / BHP</td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable1();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="80" height="25" class="tblheader">Kode Obat</td>
              <td class="tblheader">Nama Obat Produksi</td>
              <td width="80" class="tblheader">Satuan</td>
              <td width="40" class="tblheader">Qty</td>
              <td width="60" class="tblheader">Harga Satuan</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi"> <input name="obatid1" type="hidden" value=""> 
                <input type="text" name="txtObat1" class="txtinput" size="101" onKeyUp="suggest(event,this,2);" autocomplete="off" /></td>
              <td class="tdisi" width="80">-</td>
              <td class="tdisi" width="40"><input type="text" name="txtJml1" class="txtcenter" size="5" onKeyUp="AddRow1(event,this)" autocomplete="off" /></td>
              <td class="tdisi" width="40"><input name="harga" type="text" class="txtright" id="harga" onKeyUp="AddRow1(event,this)" size="7" autocomplete="off" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable1(this);}"></td>
            </tr>
          </table>
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=../produksi/list_produksi_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="PrintArea('idArea','#')"<?php if ($act!="save") echo " disabled";?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Produksi&nbsp;</BUTTON>
		  </p>
</form>
</div>
<?php }?>
</body>
</html>
<?php 
mysqli_close($konek);
?>