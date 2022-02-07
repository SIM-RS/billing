<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_retur=$_REQUEST['no_retur'];
$tgl_retur=$_REQUEST['tgl_retur'];
$tgl_retur=explode("-",$tgl_retur);
$tgl_retur=$tgl_retur[2]."-".$tgl_retur[1]."-".$tgl_retur[0];
$pbf=$_REQUEST['pbf'];
$fdata=$_REQUEST['fdata'];
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="RETUR_ID desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

switch ($act){
	case "save":
		$arfdata=explode("**",$fdata);
		for ($i = 0; $i < count($arfdata); $i++)
		{
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="UPDATE a_penerimaan SET QTY_RETUR=QTY_RETUR+$arfvalue[4] WHERE ID=$arfvalue[0]";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$sql="select SQL_NO_CACHE UUID() AS cuid,ID,QTY_STOK from a_penerimaan where OBAT_ID=$arfvalue[1] and KEPEMILIKAN_ID=$arfvalue[2] and UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1 ORDER BY ID";
			$rs=mysqli_query($konek,$sql);
			$done=0;
			$jml=$arfvalue[4];
			while (($rows=mysqli_fetch_array($rs))&&($done==0)){
				$qtystok=$rows['QTY_STOK'];
				$cid=$rows['ID'];
				//$cqtytrans=$qtystok;
				if ($qtystok>=$jml){
					$done=1;
					$cqtytrans=$jml;
					$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK-$jml WHERE ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}else{
					$sql="UPDATE a_penerimaan SET QTY_STOK=0 WHERE ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$jml=$jml-$qtystok;
				}
/*				$sql="SELECT IF (SUM(QTY_STOK) IS NULL,0,SUM(QTY_STOK)) AS stok_after,IF (SUM(QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)+(QTY_STOK*HARGA_BELI_SATUAN/10)) IS NULL,0,SUM(QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)+(QTY_STOK*HARGA_BELI_SATUAN/10))) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfvalue[1] AND KEPEMILIKAN_ID=$arfvalue[2] AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1";
				$rs1=mysqli_query($konek,$sql);
				$cstok=0;
				$cnilai=0;
				if ($rows1=mysqli_fetch_array($rs1)){
					$cstok=$rows1['stok_after'];
					$cnilai=$rows1['ntot'];
				}
				$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,NILAI_TOTAL) VALUES ($arfvalue[1],$arfvalue[2],$idunit,'$tgl_retur',NOW(),'$no_retur',$cstok+$cqtytrans,-1 * $cqtytrans,0,$cstok,CONCAT('Return Pbf : ','$no_retur',' - ','$arfvalue[3]'),$iduser,$cid,9,$cnilai)";
				$rs1=mysqli_query($konek,$sql);
				//$cstok=$cstok+$qty;
				$jml=$jml-$qtystok;*/
			}
			$sql="INSERT INTO a_penerimaan_retur(PENERIMAAN_ID,PBF_ID,OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,USER_ID,NO_RETUR,NO_FAKTUR,TGL,TGL_ACT,QTY,KET) 
VALUES($arfvalue[0],$pbf,$arfvalue[1],$arfvalue[2],$idunit,$iduser,'$no_retur','$arfvalue[3]','$tgl_retur',NOW(),$arfvalue[4],'$arfvalue[5]')";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);			
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select NO_RETUR from a_penerimaan_retur where MONTH(a_penerimaan_retur.TGL)=$bulan AND YEAR(a_penerimaan_retur.TGL)=$th[2] order by NO_RETUR desc limit 1";
//echo $sql;
$rs=mysqli_query($konek,$sql);
$no_retur1="$kodeunit/RTR/$th[2]-$th[1]/0001";
if ($show=mysqli_fetch_array($rs)){
	$no_retur1=$show["NO_RETUR"];
	$arno_retur=explode("/",$no_retur1);
	$tmp=$arno_retur[3]+1;
	$ctmp=$tmp;
	for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
	$no_retur1="$kodeunit/RTR/$th[2]-$th[1]/$ctmp";
}
mysqli_free_result($rs);

?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
var RowIdx;
var fKeyEnt;
var keyCari;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 2){
  	i=par.parentNode.parentNode.rowIndex;
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
			if (tblRow>1){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<(tblRow-1)){
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
			Request('../transaksi/obatlistreturpbf.php?aPbf='+document.forms[0].pbf.value+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
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
  	row.className = 'itemtable';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableMOver';};
	row.onmouseout = function(){this.className='itemtable';};
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  // left cell
  cellLeft = row.insertCell(1);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  // left cell
  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(3);
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
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 51;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(4);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(5);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(6);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qtys';
  }else{
  	el = document.createElement('<input name="qtys" />');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtReturn';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtReturn" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtKet';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtKet" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 32;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(9);
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
  
  document.forms[0].txtObat[iteration-1].focus();
}

function removeRowFromTable(cRow){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 2){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=1;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i;
	  }
	  HitungTot();
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1]+'|'+cdata[2]+'|'+cdata[3]+'|'+cdata[7];
		document.forms[0].txtObat.value=cdata[5];
		document.forms[0].qtys.value=cdata[12];
		tds = tbl.rows[1].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=FormatNum(cdata[4],2);
		document.forms[0].txtReturn.focus();
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
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1]+'|'+cdata[2]+'|'+cdata[3]+'|'+cdata[7];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[5];
		document.forms[0].qtys[(cdata[0]*1)-1].value=cdata[12];
		tds = tbl.rows[(cdata[0]*1)].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=FormatNum(cdata[4],2);
		document.forms[0].txtReturn[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[4];
	tds[2].innerHTML=cdata[7];
	tds[4].innerHTML=cdata[6];
	tds[5].innerHTML=cdata[8];
	tds[6].innerHTML=cdata[9];
	document.getElementById('divobat').style.display='none';
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
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
  <div id="input" style="display:block">
<p class="jdltable">Return Obat Ke PBF </p>
	  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="fdata" id="fdata" type="hidden" value="">
      
      <table width="99%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td height="25">Nama PBF </td>
          <td>:</td>
          <td> <select name="pbf" id="pbf" onChange="fPbfChange();">
              <?php
			//$sql="select distinct a_penerimaan.PBF_ID,PBF_NAMA from a_penerimaan,a_pbf where UNIT_ID_KIRIM=0 and a_pbf.PBF_ID=a_penerimaan.PBF_ID order by PBF_NAMA";
			$sql="SELECT * FROM a_pbf WHERE PBF_ISAKTIF=1 ORDER BY PBF_NAMA";
			$exe=mysqli_query($konek,$sql);
			$i=0;
			while($rows=mysqli_fetch_array($exe)){
			?>
              <option value="<?php echo $rows['PBF_ID'];?>" class="txtinput"><?php echo $rows['PBF_NAMA'];?></option>
              <? } ?>
            </select> </td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="79">No. Return</td>
          <td width="11">:</td>
          <td width="283"> <input name="no_retur" class="txtinput" id="no_retur" value="<?php echo $no_retur1;?>" size="25" maxlength="30" readonly="true"> 
          </td>
          <td width="298">&nbsp;</td>
        </tr>
        <tr> 
          <td height="25">Tgl Return</td>
          <td>:</td>
          <td ><input name="tgl_retur" type="text" id="tgl_retur" size="11" maxlength="10" readonly="true" value="<?php echo $tglSkrg;?>" class="txtcenter" /> 
            <input type="button" name="ButtonTgl" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_retur,depRange);" /></td>
          <td align="right" >
<input name="button" type="button" onClick="addRowToTable();" value="+" />
          </td>
        </tr>
        <tr> 
          <td colspan="4"><table id="tblJual" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="headtable"> 
                <td width="30" class="tblheaderkiri">No</td>
                <td width="80" class="tblheader">Tgl Terima</td>
                <td width="130" class="tblheader">No Faktur</td>
                <td class="tblheader">Nama Obat </td>
                <td width="90" class="tblheader">Kepemilikan</td>
                <td width="50" class="tblheader">Qty Terima</td>
                <td width="50" class="tblheader">Qty Sdh Return</td>
                <td width="50" class="tblheader">Qty Mau Return</td>
                <td width="200" class="tblheader">Keterangan</td>
                <td width="30" class="tblheader">Pilih</td>
              </tr>
              <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                <td class="tdisikiri">1</td>
                <td class="tdisi">-</td>
                <td class="tdisi">-</td>
                <td align="left" class="tdisi"><input name="obatid" type="hidden" value=""> 
                  <input type="text" name="txtObat" id="txtObat" class="txtinput" size="51" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
                <td class="tdisi">-</td>
                <td class="tdisi">-</td>
                <td class="tdisi">-</td>
                <td class="tdisi"><input name="qtys" type="hidden" value=""> <input name="txtReturn" type="text" class="txtcenter" size="5" onKeyUp="AddRow(event,this)" autocomplete="off"></td>
                <td class="tdisi"><input type="text" name="txtKet" class="txtinput" size="32" onKeyUp="AddRow(event,this);" autocomplete="off" /></td>
                <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
              </tr>
            </table></td>
        </tr>
      </table>
  <p><BUTTON type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
         <BUTTON type="reset" onClick="location='?f=../transaksi/obat_kepbf.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
    </form>
</div>
</div>
</body>
<script>
function fSubmit(){
var cdata="";
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			if ((document.forms[0].txtReturn[i].value=="")||(document.forms[0].txtReturn[i].value=="0")){
				document.forms[0].txtReturn[i].focus();
				alert("Isikan Jumlah Obat Yg Mau Direturn !");
				return false;
			}else if ((document.forms[0].txtReturn[i].value*1)>(document.forms[0].qtys[i].value*1)){
				document.forms[0].txtReturn[i].focus();
				alert("Jumlah Obat Yg Mau Direturn Terlalu Banyak !");
				return false;
			}
			cdata +=document.forms[0].obatid[i].value+"|"+document.forms[0].txtReturn[i].value+"|"+document.forms[0].txtKet[i].value+"**";
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Obat Yg Mau Direturn !");
			return false;
		}
	}else{
		if ((document.forms[0].txtReturn.value=="")||(document.forms[0].txtReturn.value=="0")){
			document.forms[0].txtReturn.focus();
			alert("Isikan Jumlah Obat Yg Mau Direturn !");
			return false;
		}else if ((document.forms[0].txtReturn.value*1)>(document.forms[0].qtys.value*1)){
			document.forms[0].txtReturn.focus();
			alert("Jumlah Obat Yg Mau Direturn Terlalu Banyak !");
			return false;
		}
		cdata=document.forms[0].obatid.value+"|"+document.forms[0].txtReturn.value+"|"+document.forms[0].txtKet.value;
	}
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	document.forms[0].submit();
}

function fPbfChange(){
var cdata="";
	if (document.forms[0].txtReturn.length){
		for (var i=0;i<document.forms[0].txtReturn.length;i++){
			if (document.forms[0].obat_id.value!="") cdata +=document.forms[0].obat_id.value;	
		}
	}
	if (cdata!=""){
		window.location='?f=../transaksi/detil_retur.php';
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>