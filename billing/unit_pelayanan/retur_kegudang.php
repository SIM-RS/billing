<?php
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
//======================Tanggalan==========================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$th[2];
$tgl_ctk=date('d/m/Y H:i');
$tglretur1=$_REQUEST["tglretur"];
$tglretur=explode("-",$tglretur1);
$tglretur=$tglretur[2]."-".$tglretur[1]."-".$tglretur[0];
$noretur=$_REQUEST["noretur"];
$noreturPrint=$noretur;
$idunit=$_REQUEST['cmbTmpLay'];
//$idunit_url=$_REQUEST['idunit']; if($_REQUEST['idunit']=="") $idunit_url=0; 
$txtAlasan=$_REQUEST['txtAlasan'];
$fdata=$_REQUEST["fdata"];
$id_gudang = 1;
$iduser = $_SESSION['userId'];

if($idunit!=''){
	$sunit = "select UNIT_ID,UNIT_NAME from $dbapotek.a_unit u where u.unit_billing = $idunit";
	$unitId = mysql_fetch_array(mysql_query($sunit));
	if($unitId['UNIT_ID'] != 0){
		$idunit = $unitId['UNIT_ID'];
	}
	$namaunit = $unitId['UNIT_NAME'];
}

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
switch ($act){
	case "save":
		//print_r($fdata);
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++)
		{
			$arfvalue=explode("|",$arfdata[$i]);
			//echo $arfvalue[0]."-".$arfvalue[1]."-".$arfvalue[2]."-".$arfvalue[3]."<br>";

			$sql="insert into $dbapotek.a_retur_togudang(NO_RETUR,TGL_RETUR,TGL_ACT,KEPEMILIKAN_ID,UNIT_ID,OBAT_ID,QTY,ALASAN,PENERIMAAN_ID)
			values('$noretur','$tglretur','$tglact',$arfvalue[3],$idunit,$arfvalue[0],$arfvalue[1],'$arfvalue[2]','$arfvalue[4]')";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			$sql="select SQL_NO_CACHE * from $dbapotek.a_retur_togudang where OBAT_ID=$arfvalue[0] and KEPEMILIKAN_ID=$arfvalue[3] and NO_RETUR='$noretur'";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			$idrtr=0;
			if ($rows1=mysql_fetch_array($rs1)) $idrtr=$rows1['ID_RETUR'];
			$sql="call $dbapotek.gd_mutasi($idunit,$id_gudang,$idrtr,'$noretur',$arfvalue[0],$arfvalue[3],$arfvalue[3],$arfvalue[1],7,$iduser,0,'$tglretur','$tglact')";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			//Karena obat dihapus, Kurangi Qty Stok pada penerimaan dg id_penerimaan yang ada=========
			//$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$arfvalue[1] where ID=$arfvalue[3]";
			//echo $sql."<br>";
			//$rs1=mysql_query($sql); 
		}
		break;
}
//==========Aksi Save, Edit, Delete Berakhir ========================, 
	/* $sql="select * from $dbapotek.a_retur_togudang WHERE UNIT_ID=$idunit AND MONTH(TGL_RETUR)=$bulan AND YEAR(TGL_RETUR)=$ta order by NO_RETUR desc limit 1";
	//echo $sql;
	$rs=mysql_query($sql);
	$noretur="$kodeunit/RTR/$th[2]-$th[1]/0001";
	if ($rows=mysql_fetch_array($rs)){
		$noretur=$rows["NO_RETUR"];
		$ctmp=explode("/",$noretur);
		$dtmp=$ctmp[3]+1;
		$ctmp=$dtmp;
		for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
		$noretur="$kodeunit/RTR/$th[2]-$th[1]/$ctmp";
	} */
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../apotik.css" type="text/css" />
<script language="javascript" src="jquery_n.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;
	//alert(keywords);
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
			Request('obatlist_hapus.php?idunit='+document.getElementById('cmbTmpLay').value+'&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			if ((ctemp[1]*1)<(document.forms[0].txtHapusStok[i].value*1)){
				document.forms[0].txtHapusStok[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}
			cdata +=ctemp[0]+'|'+document.forms[0].txtHapusStok[i].value+'|'+document.forms[0].txtAlasan[i].value+'|'+document.forms[0].kp_id[i].value+'|'+document.forms[0].pene_id[i].value+'**';
//pene_id			
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
	}else{
		ctemp=document.forms[0].obatid.value.split('|');
		if ((ctemp[1]*1)<(document.forms[0].txtHapusStok.value*1)){
			document.forms[0].txtHapusStok.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
		cdata=ctemp[0]+'|'+document.forms[0].txtHapusStok.value+'|'+document.forms[0].txtAlasan.value+'|'+document.forms[0].kp_id.value+'|'+document.forms[0].pene_id.value;
	}
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	document.getElementById('btnSimpan').disabled=true;
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
  	row.className = 'itemtable';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableMOver';};
	row.onmouseout = function(){this.className='itemtable';};
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(1);
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

  //pene_id
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'pene_id';
  }else{
  	el = document.createElement('<input name="pene_id"/>');
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
  el.size = 55;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);


  cellLeft = row.insertCell(4);
  textNode2 = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode2);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHapusStok';
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtHapusStok" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtJmlStok'+(iteration-1);
  el.size = 5;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
    // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtAlasan';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
  }else{
  	el = document.createElement('<input name="txtAlasan" onkeyup="AddRow(event,this)" />');
  }
  el.type = 'text';
  //el.id = 'txtJmlStok'+(iteration-1);
  el.size = 38;
  el.className = 'txtinput';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(7);
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
		document.forms[0].kp_id.value=cdata[6];
		document.forms[0].pene_id.value=cdata[7];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].idPenerimaan.value=cdata[6];
		document.forms[0].txtHapusStok.focus();
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
		document.forms[0].kp_id[(cdata[0]*1)-1].value=cdata[6];
		document.forms[0].pene_id[(cdata[0]*1)-1].value=cdata[7];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].idPenerimaan[(cdata[0]*1)-1].value=cdata[6];
		document.forms[0].txtHapusStok[(cdata[0]*1)-1].focus();
	}
	tds[2].innerHTML=cdata[3];
	tds[3].innerHTML=cdata[4];
	tds[4].innerHTML=cdata[5];

	document.getElementById('divobat').style.display='none';
}
</script>
<style type="text/css">
	#container{
		width:1000px;
		margin:0px auto;
		padding:0px;
		background:#EAF0F0;
	}
</style>
</head>
<body onLoad="<?php if ($act!="save"){?>document.form1.txtObat.focus()<?php }?>">
<script>
	var arrRange=depRange=[];
	function PrintArea(idArea,fileTarget){
		var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
		winpopup.document.write(document.getElementById(idArea).innerHTML);
		winpopup.document.close();
		winpopup.print();
		winpopup.close();
	}
</script>
<?php
include("../koneksi/konek.php");
include("../header1.php");
?>
<div id="container">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM RETUR OBAT</td>
	</tr>
</table>
<?php if($act=='save') {?>
<!-- UNTUK DI PRINT OUT -->
	<div id="idArea" style="display:block;" align="center">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  
    <p align="center"><span class="jdltable">RETURN OBAT KE GUDANG</span></p>
			  
    <table width="28%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center" style="margin-bottom:20px; ">
		<tr> 
			<td width="112">Tanggal Return </td>
			<td width="187">: <?php echo $tglretur1; ?></td>
		</tr>
		<tr> 
			<td>Unit</td>
			<td>: <?php echo $namaunit; ?></td>
		</tr>
		<tr>
			<td>No. Return </td>
			<td>: <?php echo $noreturPrint; ?></td>
		</tr>
    </table>
			  
    <table width="910" border="0" cellpadding="1" cellspacing="0" align="center">
      <tr class="headtable"> 
        <td width="35" class="tblheaderkiri">No</td>
        <td width="313" class="tblheader">Nama Obat</td>
        <td width="100" class="tblheader">Satuan</td>
        <td width="90" class="tblheader">Kepemilikan</td>
        <td width="40" class="tblheader">Qty Return</td>
        <td width="300" class="tblheader">Alasan</td>
      </tr>
      <?php 
			  $sql="Select a_retur_togudang.OBAT_ID, a_retur_togudang.QTY, a_retur_togudang.ALASAN, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA 
			  From $dbapotek.a_retur_togudang 
			  inner join $dbapotek.a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID 
			  inner join $dbapotek.a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID 
			  where NO_RETUR='$noreturPrint' order by ID_RETUR";
			  //echo $sql."<br>";
			  $rs=mysql_query($sql);
			  $i=0;
			  while ($rows=mysql_fetch_array($rs)){
				$i++;
			  ?>
      <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['ALASAN']; ?></td>
      </tr>
      <?php 
			  }
			  mysql_free_result($rs);
			  ?>
    </table>
			  <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tgl_ctk." <b>- User:</b> ".$username; ?>
			  </p>
	</div>
	<p align="center">
		    <BUTTON style="margin-top:10px;" type="button" onClick='PrintArea("idArea","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Return </BUTTON>
		&nbsp;
    <BUTTON type="button" onClick="location='retur_obat.php';"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Ke 
    Daftar Return&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</p>
</div>
    <!-- PRINT OUT BERAKHIR -->
<?php }else{?>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
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
  <form name="form1" method="post" action="">
    <input name="act" id="act" type="hidden" value="save">
  	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	  <table width="99%" border="0">
	  	<tr>
			<td>
  <div id="input" style="display:block" align="center"> 
            <!--table width="35%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr>
                <td width="27%">No. Return</td>
                <td width="73%">:
                  <input name="noretur" type="text" id="noretur" size="25" maxlength="30" value="<?php echo $noretur;?>" class="txtinput" readonly="true" /></td>
                </tr>
              <tr>
                <td>Tanggal&nbsp; </td>
                <td>:
                  <input name="tglretur" type="text" id="tglretur" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" readonly="true" />
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tglretur,depRange);" /></td>
                </tr>
              <tr>
                <td>Jenis Layanan</td>
                <td>: <select id="cmbJnsLay" class="txtinput" onChange="isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',evLang2);" >
					<?php
                                            $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
                                                    where ms_pegawai_id=".$_SESSION['userId'].") as t1
                                                    inner join b_ms_unit u on t1.unit_id=u.id
                                                    inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
                                            $rs=mysql_query($sql);
                                            while($rw=mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                                <?php
                                            }
                                            ?>
					  </select></td> 
              </tr>
			  <tr>
                <td>Tempat Layanan</td>
                <td>: <select name="cmbTmpLay" id="cmbTmpLay" class="txtinput" lang="" onChange="this.lang=this.value;evLang2();">
			    </select></td> 
              </tr>
            </table-->
			<table width="45%" border="0" cellpadding="0" cellspacing="0" style="margin:10px 20px; font-size:12px;">
			<tr>
				<td>Tanggal&nbsp; </td>
				<td>:
				<input name="tglretur" type="text" id="tglretur" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" readonly="true" />
				<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tglretur,depRange);" /></td>
			</tr>
			<tr>
				<td>Jenis Layanan</td>
				<td>: <select id="cmbJnsLay" class="txtinput" onChange="isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',fnoretur);" >
					<?php
						$sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
								where ms_pegawai_id=".$_SESSION['userId'].") as t1
								inner join b_ms_unit u on t1.unit_id=u.id
								inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
						$rs=mysql_query($sql);
						while($rw=mysql_fetch_array($rs)) {
							?>
						<option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
							<?php
						}
						?>
				</select></td> 
			</tr>
			<tr>
				<td>Tempat Layanan</td>
				<td>: <select name="cmbTmpLay" id="cmbTmpLay" class="txtinput" lang="" onChange="this.lang=this.value; fnoretur();">
				</select></td> 
			</tr>
			<tr>
				<td width="30%">No. Return</td>
				<td width="70%">:
					<input name="noretur" type="text" id="noretur" size="25" maxlength="30" value="<?php echo $noretur;?>" class="txtinput" readonly="true" />
					<div id="noreturH" style="display:none;"></div>
				</td>
			</tr>
		</table>
  </div>
  <table id="tblJual" width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
  	<tr>
		<td colspan="8" align="center" class="jdltable"><hr></td>
	</tr>
  	<tr>
		      <td colspan="7" align="center" class="jdltable">RETURN OBAT KE GUDANG 
              </td>
		<td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
	</tr>
      <tr class="headtable">
        <td width="25" class="tblheaderkiri">No</td>
		      <td class="tblheader">Nama Obat</td>
		      <td width="90" class="tblheader">Kepemilikan</td>
		      <td width="90" class="tblheader">Satuan</td>
		      <td width="60" class="tblheader">Jml Stok </td>
		<td width="41" class="tblheader">Jml Retur Obat  </td>
		      <td class="tblheader">Alasan</td>
		<td class="tblheader" width="50">Proses</td>
      </tr>
	  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
		<td class="tdisikiri" width="25">1</td>
		<td class="tdisi" align="left"><input name="obatid" type="hidden" value=""><input name="kp_id" type="hidden" value=""><input name="pene_id" type="hidden" value="">
		  <input type="text" name="txtObat" id="txtObat" class="txtinput" size="55" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
		      <td class="tdisi" width="82">-</td>
		      <td class="tdisi" width="48">-</td>
		      <td class="tdisi" width="35">-</td>
		      <td class="tdisi" width="41"><input type="text" name="txtHapusStok" id="txtHapusStok" class="txtcenter" size="5" autocomplete="off" /></td>
		      <td class="tdisi" width="243"><input name="txtAlasan" class="txtinput" id="txtAlasan" size="38" onKeyUp="AddRow(event,this)"></td>
		      <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
	  </tr>
  </table>
  
    </table>
    <table width="82%" border="0" cellpadding="0" cellspacing="0">
      <tr> 
        <td width="100%" align="center"><p>
			<BUTTON id="btnSimpan" type="button" onClick="if (ValidateForm('tglretur,noretur,txtHapusStok,txtAlasan','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;&nbsp;&nbsp;</BUTTON>
            <BUTTON type="button" onClick="location='retur_obat.php';"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON> <br>
        </p>
		 </td>
      </tr>
    </table>
</form>
	<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
		<tr>
			<td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
			<td></td>
			<td align="right">
				<a href="../index.php">
					<input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
				</a>&nbsp;
			</td>
		</tr>
	</table>
</div>
<?php }?>
</div>
<script type="text/javascript">
	isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('cmbJnsLay').value,'','cmbTmpLay',fnoretur);

	function fnoretur(){
		//alert('coba');
		var unit = jQuery('#cmbTmpLay').val();
		var tgl_retur = jQuery('#tglretur').val().split('-');
		//alert("noretur_utils.php?th="+tgl_retur[2]+'&bln='+tgl_retur[1]+'&unitId='+unit);
		jQuery('#noreturH').load("noretur_utils.php?th="+tgl_retur[2]+'&bln='+tgl_retur[1]+'&unitId='+unit, function() {
			var noretur = jQuery('#noreturH').html();
			jQuery('#noretur').val(noretur);
        });
	}
	
	function evLang2(){
			jQuery("#load1").load("getMinta.php?idunit="+jQuery("#cmbTmpLay").val()+"&th2="+<? echo $th[2];?>+"&th1="+<? echo $th[1];?>+"&bulan="+<? echo $bulan;?>);
			var selCmbDilayani=0;
			if (document.getElementById('cmbDilayani')) selCmbDilayani=document.getElementById('cmbDilayani').options.selectedIndex;
			if (selCmbDilayani>2) selCmbDilayani=0;
	    	//tentangTarik();
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			//alert(inap);
			if(inap == 1){
				document.getElementById('btnMRS').style.display = 'none';
				document.getElementById('UpdStatusPx').style.display = 'inline-table';
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
			}
			else{
				document.getElementById('btnMRS').style.display = 'inline-table';
				if (document.getElementById('cmbJnsLay').value==44){
					document.getElementById('UpdStatusPx').style.display = 'inline-table';
				}else{
					document.getElementById('UpdStatusPx').style.display = 'none';
				}
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
			}
			//alert(selCmbDilayani);
			document.getElementById('cmbDilayani').options.selectedIndex=selCmbDilayani;
			if('<?php echo isset($_POST['sentPar'])?>' == 0){
				document.getElementById('txtFilter').value = "";
			}
			else if('<?php echo isset($_POST['sentPar'])?>' == 1){
				var sentPar = "<?php echo $_POST['sentPar']?>".split('*|*');
				document.getElementById('cmbDilayani').value = sentPar[4];
			}
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            cekInap(inap);
            saring();
            isiCombo('cmbDok',unitId,'','cmbDokRujukUnit');
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'','cmbDokRujukRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
            isiCombo('cmbDok',unitId,'','cmbDokTind');
            isiCombo('cmbDok',unitId,'','cmbDokDiag');
            isiCombo('cmbDok',unitId,'','cmbDokResep');
			
			/*
			if(jenisUnitId==27){
			}
			*/
        }


	function isiCombo(id,val,defaultId,targetId,evloaded){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?all=0&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
	}
</script>
</body>
</html>
<?php 
mysql_close($konek);
?>