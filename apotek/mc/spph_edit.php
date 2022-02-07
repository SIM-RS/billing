<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	//header("Location: ../../index.php");
	//exit();
}
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$nospph=$_REQUEST['no_spph'];
$tgl_spph=$_REQUEST['tgl_spph'];
$tglspph=explode("/",$tgl_spph);
$tglspph=$tglspph[2]."-".$tglspph[1]."-".$tglspph[0];
$pbf_id=$_REQUEST['pbf_id'];
$pbf=$_REQUEST['pbf'];
$kp_nama=$_REQUEST['kp_nama'];
$kp_id=$_REQUEST['kp_id'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$fdata=$_REQUEST["fdata"];
//======================Tanggalan==========================
$idgudang=$_SESSION["ses_id_gudang"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$pid="";
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++){
			$arfvalue=explode("|",$arfdata[$i]);
			$pid .=$arfvalue[0].",";
			$sql="select * from a_spph where no_spph='$nospph' and obat_id=$arfvalue[0]";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
			if($rows=mysqli_fetch_array($rs)){
/* 				$qty=$rows['qty_kemasan'];
				$pagu=$rows['pagu'];
				$kemasan=$rows['kemasan'];
				if(($qty<>$arfvalue[1])||($pagu<>$arfvalue[2])||($kemasan<>$arfvalue[3])){
 */					$upd="update a_spph set pbf_id=$pbf_id,kepemilikan_id=$kp_id,qty_kemasan='$arfvalue[1]',pagu=$arfvalue[2],kemasan='$arfvalue[3]',ket='$arfvalue[5]',bisa=$arfvalue[4] where no_spph='$nospph' and obat_id=$arfvalue[0]";
					//echo $upd;
					$hs=mysqli_query($konek,$upd);
// 				}
			}else{
				$sql="insert into a_spph(pbf_id,obat_id,kepemilikan_id,user_id,no_spph,qty_kemasan,kemasan,pagu,ket,bisa,tgl,tgl_act) values($pbf_id,$arfvalue[0],$kp_id,$iduser,'$nospph',$arfvalue[1],'$arfvalue[3]',$arfvalue[2],'$arfvalue[5]',$arfvalue[4],'$tglspph','$tglact')";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
			}
		}
		if ($pid!=""){
			$pid=substr($pid,0,strlen($pid)-1);
/*			$sql="delete from a_spph where no_spph='$nospph' and obat_id not in ($pid)";
			$rs=mysqli_query($konek,$sql);*/
			$sql="delete from a_spph where no_spph='$nospph' and obat_id not in ($pid)";
			$rs=mysqli_query($konek,$sql);
		}
		break;
/* 	case "edit":
		$sql="update a_unit set UNIT_NAME='$unit_name',UNIT_TIPE='$unit_tipe',UNIT_ISAKTIF=$unit_isaktif where UNIT_ID=$unit_id";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_unit where UNIT_ID=$unit_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break; */
}
/*
$qry="select * from a_kepemilikan where AKTIF=1";
$exe=mysqli_query($konek,$qry);
$sela="";
$i=0;
while($show=mysqli_fetch_array($exe)){
	$sela .="sel.options[$i] = new Option('".$show['NAMA']."', '".$show['ID']."');";
	$i++;
}
*/
$qry="select * from a_satuan order by SATUAN";
$exe=mysqli_query($konek,$qry);
$sel="";
$i=0;
while($show=mysqli_fetch_array($exe)){
	$sel .="sel.options[$i] = new Option('".$show['SATUAN']."', '".$show['SATUAN']."');";
	$i++;
}
//Aksi Save, Edit, Delete Berakhir ====================================
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script>
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
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
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
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
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/obatlist.php?aKepemilikan=0&idunit=<?php echo $idgudang; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].no_spph.value==""){
		alert('Isikan No SPPH Terlebih Dahulu !');
		document.forms[0].no_spph.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			cdata +=ctemp[0]+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].txtPagu[i].value+'|'+document.forms[0].satuan[i].value+'|'+document.forms[0].chkjadi[i].value+'|'+document.forms[0].txtKet[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value.split('|');
		cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].txtPagu.value+'|'+document.forms[0].satuan.value+'|'+document.forms[0].chkjadi.value+'|'+document.forms[0].txtKet.value;
	}
	//alert(cdata);
	document.forms[0].pbf.value=document.forms[0].pbf_id.options[document.forms[0].pbf_id.selectedIndex].label;
	document.forms[0].kp_nama.value=document.forms[0].kp_id.options[document.forms[0].kp_id.selectedIndex].label;
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
	if (document.form1.txtSubTotal.length){
		document.form1.txtSubTotal[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtPagu[i-3].value*1);
	}else{
		document.form1.txtSubTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtPagu.value*1);
	}
	HitungTot();
}

function HitungTot(){
	if (document.form1.txtSubTotal.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTotal.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			cStot +=(document.form1.txtSubTotal[i].value*1);
		}
		document.getElementById('total').innerHTML=cStot;
		//alert(cStot);
	}else{
		document.getElementById('total').innerHTML=document.form1.txtSubTotal.value;
	}
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
	}else{
		HitungSubTot(par);
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
  
  var cellRight = row.insertCell(1);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'chkjadi';
	el.setAttribute('checked', "checked");
	el.setAttribute('onClick', "if (this.checked) this.value='1'; else this.value='0';");
  }else{
  	el = document.createElement('<input name="chkjadi" checked onClick="if (this.checked) this.value=\'1\'; else this.value=\'0\';" />');
  }
  el.type = 'checkbox';
  el.value = '1';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  // right cell
  cellRight = row.insertCell(2);
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

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid_lama';
  }else{
  	el = document.createElement('<input name="obatid_lama"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 45;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(3);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtKet';
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtKet" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 39;
  el.maxlength = 75;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  // select cell
  var cellRightSel = row.insertCell(4);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sel; ?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.className = 'tdisi';
  cellRightSel.appendChild(sel);
  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 6;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtPagu';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtPagu" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 10;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtSubTotal';
	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtSubTotal" readonly="true" />');
  }
  el.type = 'text';
  el.size = 12;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
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

/*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sel; ?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
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
function removeRowFromTable(cRow)
{
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

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1]+'|'+cdata[5];
		document.forms[0].txtObat.value=cdata[2];
		//tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].satuan.focus();
	}else{
		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value.split('|');
			//alert(cdata[1]+'-'+w[0]);
			if (cdata[1]==w[0]){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1]+'|'+cdata[5];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		//tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].satuan[(cdata[0]*1)-1].focus();
	}
	//tds[1].innerHTML=cdata[6];
	//tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
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
<div align="center">
<body onLoad="HitungTot();">
<script>
var arrRange=depRange=[];
</script>
<?php //include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="470">
<?php 
if ($act=="save"){
?>
			<div id="listma" style="display:none">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" align="center">
              <tr> 
                <td><b><?=$pemkabRS;?></b></td>
              </tr>
              <tr> 
                <td><b><?=$namaRS;?></b></td>
              </tr>
              <tr> 
                <td class="txtcenter">Alamat : <?=$alamatRS;?>, Kode Pos : <?=$kode_posRS;?>, Telp : <?=$tlpRS;?>, Fax : <?=$faxRS;?>, email : <?=$emailRS;?></td>
              </tr>
              <tr> 
                <td><hr></td>
              </tr>
            </table>
        <p align="center"><span class="jdltable">SURAT PERMINTAAN PENAWARAN HARGA</span> 
        <table border="0" cellpadding="1" cellspacing="0" class="txtinput">
          <tr> 
            <td width="89">Tgl SPPH</td>
            <td>: <?php echo $tgl_spph; ?></td>
          </tr>
          <tr> 
            <td width="89">No SPPH</td>
            <td>: <?php echo $nospph; ?></td>
          </tr>
          <tr> 
            <td>Kepemilikan</td>
            <td>: <?php echo $kp_nama; ?></td>
          </tr>
          <tr> 
            <td width="89">PBF</td>
            <td>: 
              <?php  echo $pbf; ?>
            </td>
          </tr>
        </table>
              
        <table width="99%" border="0" cellpadding="1" cellspacing="0">
          <tr class="headtable"> 
            <td width="30" height="25" class="tblheaderkiri">No</td>
            <td id="OBAT_KODE" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
              Obat</td>
            <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
              Obat</td>
            <td id="OBAT_SATUAN_KECIL" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan 
              Besar </td>
            <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
            <!--td class="tblheader" width="30">Proses</td-->
          </tr>
          <?php 
			  $sql="select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$nospph' order by spph_id";
			  //echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$i=0;
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
					  ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td align="center" class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
            <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['kemasan']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty_kemasan']; ?></td>
          </tr>
          <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
        </table>
		  <p class="txtinput"  style="padding-right:10px; text-align:right">
		  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tglctk." <b>- User:</b> ".$username; ?>
		  </p><br><br><br><br><br>
              <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>
			  </p>
		</div>
		<div id="listma1" style="display:none">
		<link rel="stylesheet" href="../theme/print.css" type="text/css" />
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" align="center">
              <tr> 
                <td><b><?=$pemkabRS;?></b></td>
              </tr>
              <tr> 
                <td><b><?=$namaRS;?></b></td>
              </tr>
              <tr> 
                <td class="txtcenter">Alamat : <?=$alamatRS;?>, Kode Pos : <?=$kode_posRS;?>, Telp : <?=$tlpRS;?>, Fax : <?=$faxRS;?>, email : <?=$emailRS;?></td>
              </tr>
              <tr> 
                <td><hr></td>
              </tr>
            </table>
        <p align="center"><span class="jdltable">PERENCANAAN PENGADAAN OBAT</span> 
        <table border="0" cellpadding="1" cellspacing="0" class="txtinput">
          <tr> 
            <td width="89">Tgl SPPH</td>
            <td>: <?php echo $tgl_spph; ?></td>
          </tr>
          <tr> 
            <td width="89">No SPPH</td>
            <td>: <?php echo $nospph; ?></td>
          </tr>
          <tr> 
            <td>Kepemilikan</td>
            <td>: <?php echo $kp_nama; ?></td>
          </tr>
          <tr> 
            <td width="89">PBF</td>
            <td>: 
              <?php  echo $pbf; ?>
            </td>
          </tr>
        </table>
              
        <table width="99%" border="0" cellpadding="1" cellspacing="0">
          <tr class="headtable"> 
            <td width="30" height="25" class="tblheaderkiri">No</td>
            <td id="OBAT_KODE" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
              Obat</td>
            <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
              Obat</td>
            <td id="OBAT_SATUAN_KECIL" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan 
              Besar </td>
            <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
            <td id="qty" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Pagu</td>
            <td id="qty" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Sub 
              Total </td>
            <!--td class="tblheader" width="30">Proses</td-->
          </tr>
          <?php 
			  $sql="select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$nospph' order by spph_id";
			  //echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$i=0;
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
					  ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td align="center" class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
            <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['kemasan']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty_kemasan']; ?></td>
            <td class="tdisi" align="right"><?php echo number_format($rows['pagu'],0,",","."); ?></td>
            <td class="tdisi" align="right"><?php echo number_format($rows['stotal'],0,",","."); ?></td>
          </tr>
          <?php 
			  }
			  $sql="select sum(t1.stotal) as total from (select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$nospph') as t1";
			  $rs=mysqli_query($konek,$sql);
			  $total=0;
			  if ($rows=mysqli_fetch_array($rs)) $total=$rows['total'];
			  mysqli_free_result($rs);
			  ?>
          <tr onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="6" align="center" class="txtright" style="font-size:12px;">Total 
              : </td>
            <td align="right" class="txtright" style="font-size:12px;"><?php echo number_format($total,0,",","."); ?></td>
          </tr>
        </table>
		  <p class="txtinput"  style="padding-right:10px; text-align:right">
		  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tglctk." <b>- User:</b> ".$username; ?>
		  </p><br><br><br><br><br>
              <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>
			  </p>
		</div>
	<br>
	<p><span class="jdltable">SPPH Dgn No SPPH : <?php echo $nospph; ?> Sudah Terupdate</span>
	<p align="center">
	  <BUTTON type="button" onClick="PrintArea('listma','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak SPPH&nbsp;&nbsp;</BUTTON>
	  <BUTTON type="button" onClick="PrintArea('listma1','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Perencanaan&nbsp;&nbsp;</BUTTON>
	  <BUTTON type="button" onClick="location='?f=../mc/spph.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Ke Daftar SPPH&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</p>
<?php
}else{
?>
		<div align="center">
		  <form name="form1" method="post" action="">
		  <input name="act" id="act" type="hidden" value="save">
		  <input name="fdata" id="fdata" type="hidden" value="">
		  <input id="tgl_spph" name="tgl_spph" type="hidden" value="<?php echo $tgl_spph; ?>">
		  <input id="no_spph" name="no_spph" type="hidden" value="<?php echo $nospph; ?>">
		  <!--input id="kp_id" name="kp_id" type="hidden" value="<?php //echo $kp_id; ?>"-->
		  <input id="kp_nama" name="kp_nama" type="hidden" value="<?php echo $kp_nama; ?>">
		  <!--input id="pbf_id" name="pbf_id" type="hidden" value="<?php //echo $pbf_id; ?>"-->
		  <input id="pbf" name="pbf" type="hidden" value="<?php echo $pbf; ?>">
			<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
			<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			  <table width="99%" border="1">
				<tr>
					<td>
		  			<div id="input" style="display:block" align="center"> 
					
                  <table border="0" cellpadding="0" cellspacing="0" class="txtinput">
                    <tr> 
                      <td width="82">Tanggal&nbsp; </td>
                      <td>: <?php echo $tgl_spph;?></td>
                    </tr>
                    <tr> 
                      <td>No. SPPH</td>
                      <td>: <?php echo $nospph; ?></td>
                    </tr>
                    <tr>
                      <td>Kepemilikan</td>
                      <td>: 
                        <select name="kp_id" class="txtinput" id="kp_id">
                          <?
							  $qry="select * from a_kepemilikan where AKTIF=1";
							  $exe=mysqli_query($konek,$qry);
							  while($show=mysqli_fetch_array($exe)){ 
							?>
                          <option value="<?php echo $show['ID']; ?>"<?php if ($kp_id==$show['ID']) echo " selected";?> label="<?php echo $show['NAMA']; ?>" class="txtinput"><?php echo $show['NAMA']; ?></option>
                          <? }?>
                        </select></td>
                    </tr>
                    <tr> 
                      <td>PBF</td>
                      <td>: 
                        <select name="pbf_id" id="pbf_id" class="txtinput">
                          <?
							  $qry="select PBF_NAMA, PBF_ID from a_pbf where PBF_ISAKTIF=1 group by PBF_NAMA order by PBF_NAMA";
							  $exe=mysqli_query($konek,$qry);
							  while($show=mysqli_fetch_array($exe)){ 
							?>
                          <option value="<?php echo $show['PBF_ID']; ?>"<?php if ($pbf_id==$show['PBF_ID']) echo " selected"; ?> label="<?php echo $show['PBF_NAMA']; ?>" class="txtinput"><?php echo $show['PBF_NAMA']; ?></option>
                          <? }?>
                        </select></td>
                    </tr>
                  </table>
		  </div>
				  
                <table id="tblJual" width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr> 
                    <td colspan="9" align="center" class="jdltable"><hr></td>
                  </tr>
                  <tr> 
                    <td colspan="8" align="center" class="jdltable">SURAT PERMINTAAN 
                      PENAWARAN HARGA OBAT </td>
                    <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
                  </tr>
                  <tr class="headtable"> 
                    <td width="25" height="25" class="tblheaderkiri">No</td>
                    <td width="35" height="25" class="tblheader">Jadi</td>
                    <td height="25" class="tblheader">Nama Obat</td>
                    <td width="250" class="tblheader">Keterangan</td>
                    <td width="90" height="25" class="tblheader">Kemasan Besar</td>
                    <td width="40" height="25" class="tblheader">Jml</td>
                    <td class="tblheader">Pagu</td>
                    <td class="tblheader">Sub Total</td>
                    <td width="30" height="25" class="tblheader">Proses</td>
                  </tr>
                  <?php
				  $sql="select s.*,(s.qty_kemasan * s.pagu) as stotal,o.OBAT_NAMA,o.OBAT_KODE from a_spph s inner join a_obat o on o.OBAT_ID=s.obat_id where no_spph='$nospph'"; 
				  //echo $sql;
				  $rs=mysqli_query($konek,$sql);
				  $exe=mysqli_num_rows($rs);
				  $a=0;
				  while($rows=mysqli_fetch_array($rs)){
				  $a++;
				  $kemasan=$rows['kemasan'];
				  ?>
                  <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                    <td class="tdisikiri" width="5"><? echo $a ?></td>
                    <td class="tdisi" align="center"><input type="checkbox" name="chkjadi" value="<?php echo $rows['bisa']; ?>"<?php if ($rows['bisa']==1) echo " checked";?> onClick="if (this.checked) this.value='1'; else this.value='0';"></td>
                    <td class="tdisi" align="left"><input name="obatid" type="hidden" value="<? echo $rows['obat_id']; ?>"><input name="obatid_lama" type="hidden" value="<? echo $rows['obat_id']; ?>">
                      <input value="<? echo $rows['OBAT_NAMA']; ?>" type="text" name="txtObat" class="txtinput" size="45" onKeyUp="suggest(event,this);" autocomplete="off" /> 
                    </td>
                    <td class="tdisi" align="left"><input value="<? echo $rows['ket']; ?>" type="text" name="txtKet" class="txtinput" size="39" maxlength="75" autocomplete="off" /></td>
                    <td align="center" class="tdisi"> <select name="satuan" class="txtinput">
                        <?
							  $qry="select * from a_satuan order by SATUAN";
							  $exe=mysqli_query($konek,$qry);
							  while($show=mysqli_fetch_array($exe)){ 
							?>
                        <option value="<?php echo $show['SATUAN']; ?>" class="txtinput"<?php if($kemasan==$show['SATUAN']) echo "selected"; ?>><? echo $show['SATUAN']; ?></option>
                        <? }?>
                      </select> </td>
                    <td class="tdisi"><input value="<? echo $rows['qty_kemasan'] ?>" type="text" name="txtJml" class="txtcenter" size="6" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
                    <td class="tdisi"><input value="<? echo $rows['pagu'] ?>" name="txtPagu" type="text" class="txtright" id="txtPagu" onKeyUp="AddRow(event,this)" size="10" autocomplete="off" /></td>
                    <td class="tdisi"><input value="<? echo $rows['stotal'] ?>" name="txtSubTotal" type="text" class="txtright" size="12" readonly="true" /></td>
                    <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
                  </tr>
                  <?php } ?>
                </table>
				</td>
			</tr>
		</table>
		  <table width="91%" align="center">
            <tr> 
              <td width="88%" class="txtright">Total :</td>
              <td id="total" width="11%" align="right" class="txtright">0</td>
              <td width="1%">&nbsp;</td>
            </tr>
          </table>
				<p align="center">
					<BUTTON type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
					&nbsp;<BUTTON type="reset" onClick="location='?f=../mc/spph.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
				  </p>
		</form>
		</div>
<?php 
}
?>	
	</td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>