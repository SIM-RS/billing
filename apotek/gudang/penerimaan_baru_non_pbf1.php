<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_gdg=$_REQUEST['no_gdg'];
$no_po=$_REQUEST['no_po'];
$kp_nama=$_REQUEST['kp_nama'];
$kp_id=$_REQUEST['kepemilikan_id'];
$no_faktur=$_REQUEST['no_faktur'];
$h_j_tempo=0;
$tgl_gdg=$_REQUEST['tgl_gdg'];
if ($tgl_gdg=="") $tgl_gdg=$tgl;
$th=explode("-",$tgl_gdg);
$tgl2="$th[2]-$th[1]-$th[0]";

//$isview=$_REQUEST['isview'];
$h_tot=$_REQUEST['h_tot'];
$disk_tot=$_REQUEST['disk_tot'];
$h_diskon=$_REQUEST['h_diskon'];
$ppn=$_REQUEST['ppn'];
$total=$_REQUEST['total'];
$jenis=$_REQUEST['jenis'];
$asal_perolehan=$_REQUEST['asal_perolehan'];
$pbf_id=$_REQUEST['pbf_id'];
$pbf=$_REQUEST['pbf'];
if ($jenis=="1"){
	$asal_perolehan="";
	$cperolehan="Konsinyasi";
}elseif ($jenis=="3"){
	$asal_perolehan="";
	$cperolehan="Return PBF";
}else{
	$pbf_id=0;
	$pbf=$asal_perolehan;
	$cperolehan="Hibah/Bantuan";
}
$updt_harga=$_REQUEST['updt_harga'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_po.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "save":
		$msgupdt="";
		$aharga=$_REQUEST['aharga'];
		$fdata=$_REQUEST['fdata'];
		
		$sql="select * from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA='$no_gdg'";
		$rs=mysqli_query($konek,$sql);
		$tmpuser="";
		if ($rows=mysqli_fetch_array($rs)){
			$tmpuser=$rows["USER_ID_TERIMA"];
			if ($tmpuser!=$iduser){
				$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
				$rs1=mysqli_query($konek,$sql);
				if ($rows1=mysqli_fetch_array($rs1)){
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
		
		if ($tmpuser!=$iduser){
			$arfdata=explode("**",$fdata);
			$sql="SELECT DATE_ADD('$tgl2', INTERVAL $h_j_tempo DAY) as tgl";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)) $tgl_j_tempo=$rows['tgl'];
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$tgl_exp=explode('-',$arfvalue[2]);
				$tgl_exp=$tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0];
				$sql="insert into a_penerimaan(OBAT_ID,FK_MINTA_ID,PBF_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_TERIMA,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,HARGA_KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,KET,NILAI_PAJAK,UPDT_H_NETTO,JENIS,TIPE_TRANS,STATUS) values($arfvalue[0],0,$pbf_id,$idunit,$kp_id,$iduser,'$no_gdg','$no_faktur','$tgl_act','$tgl2','$tgl_j_tempo',$h_j_tempo,'','$tgl_exp',$arfvalue[3],'$arfvalue[4]',$arfvalue[5],$arfvalue[6],$arfvalue[7],'$arfvalue[8]',$arfvalue[7],$h_tot,$arfvalue[9],$arfvalue[11],$disk_tot,'$asal_perolehan',$ppn,$updt_harga,$jenis,0,1)";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$status=0;
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($act!="save"){
	$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_gdg=$rows["NOTERIMA"];
		$arno_gdg=explode("/",$no_gdg);
		$tmp=$arno_gdg[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
	}else{
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/0001";
	}
}
	
$qry="select * from a_satuan order by SATUAN";
$exe=mysqli_query($konek,$qry);
$sel="";
$i=0;
while($show=mysqli_fetch_array($exe)){
	$sel .="sel.options[$i] = new Option('".$show['SATUAN']."', '".$show['SATUAN']."');";
	$i++;
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1200,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>

<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblpenerimaan');
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
			Request('../transaksi/obatlist_po_nonpbf.php?aKepemilikan=0&idunit=<?php echo $idgudang; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
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
  var tbl = document.getElementById('tblpenerimaan');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtable';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableMOver';};
	row.onmouseout = function(){this.className='itemtable';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(1);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obat_id';
  }else{
  	el = document.createElement('<input name="obat_id"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  //cellRight.className = 'tdisi';
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
/*
  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');
*/
  cellLeft = row.insertCell(2);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'expired';
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="expired" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 11;
  el.maxlength=10;
  el.className = 'txtcenter';
  
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(el);
  //cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(3);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_kemasan';
	el.setAttribute('OnKeyUp', "HitungQtySatuan(this);HitungSubTotal(this);HitungDiskon(this,1);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="qty_kemasan" onkeyup="HitungQtySatuan(this);HitungSubTotal(this);HitungDiskon(this,1);" autocomplete="off" />');
  }
  el.type = 'text';
  el.value="0";
  //el.id = 'txtObat'+(iteration-1);
  el.size = 3;
  el.className = 'txtcenter';
  
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(el);
  //cellLeft.appendChild(textNode);
  
  cellLeft = row.insertCell(4);
  sel = document.createElement('select');
  sel.name = 'kemasan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sel; ?>
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(sel);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'h_kemasan';
	el.setAttribute('OnKeyUp', "HitungSubTotal(this);HitungHargaSatuan(this);HitungDiskon(this,1);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="h_kemasan" onkeyup="HitungSubTotal(this);HitungHargaSatuan(this);HitungDiskon(this,1);" autocomplete="off" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 8;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_per_kemasan';
	el.setAttribute('OnKeyUp', "HitungQtySatuan(this);HitungHargaSatuan(this);AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="qty_per_kemasan" onkeyup="HitungQtySatuan(this);HitungHargaSatuan(this);AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 3;
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_satuan';
	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="qty_satuan" readonly="true" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 5;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'satuan';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="satuan" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtSubTot'+(iteration-1);
  el.size = 7;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(9);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'h_satuan';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="h_satuan" readonly="true" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 7;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(10);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'sub_tot';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="sub_tot" readonly="true" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 8;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(11);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'diskon';
	el.setAttribute('OnKeyUp', "HitungDiskon(this,1);AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="diskon" onkeyup="HitungDiskon(this,1);AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 3;
  el.value="0";
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(12);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'diskon_rp';
	el.setAttribute('OnKeyUp', "HitungDiskon(this,2);AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="diskon_rp" onkeyup="HitungDiskon(this,2);AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 7;
  el.value="0";
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(13);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'dpp';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="dpp" readonly="true" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 7;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(14);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'dpp_ppn';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="dpp_ppn" readonly="true" />');
  }
  el.type = 'text';
  el.value="0";
  el.size = 8;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(15);
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
function removeRowFromTable(cRow)
{
  var tbl = document.getElementById('tblpenerimaan');
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
  }
}
function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblpenerimaan');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obat_id.value=cdata[1];
		document.forms[0].txtObat.value=cdata[2];
		document.forms[0].satuan.value=cdata[3];
		tds = tbl.rows[1].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].expired.focus();
	}else{
		var w;
		for (var x=0;x<document.forms[0].obat_id.length-1;x++){
			w=document.forms[0].obat_id[x].value;
			//alert(cdata[1]+'-'+w[0]);
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		document.forms[0].obat_id[(cdata[0]*1)-1].value=cdata[1];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[3];
		tds = tbl.rows[(cdata[0]*1)].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].expired[(cdata[0]*1)-1].focus();
	}
	//tds[1].innerHTML=cdata[6];
	//tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}

function HitungQtySatuan(par){
var i=par.parentNode.parentNode.rowIndex;
	//alert(i);
	if (document.form1.txtObat.length){
		document.form1.qty_satuan[i-1].value=(document.form1.qty_kemasan[i-1].value*1)*(document.form1.qty_per_kemasan[i-1].value*1);
	}else{
		document.form1.qty_satuan.value=(document.form1.qty_kemasan.value*1)*(document.form1.qty_per_kemasan.value*1);
	}
}

function HitungSubTotal(par){
var i=par.parentNode.parentNode.rowIndex;
	if (document.form1.txtObat.length){
		document.form1.sub_tot[i-1].value=(document.form1.qty_kemasan[i-1].value*1)*(document.form1.h_kemasan[i-1].value*1);
	}else{
		document.form1.sub_tot.value=(document.form1.qty_kemasan.value*1)*(document.form1.h_kemasan.value*1);
	}
	HitunghTot();
}

function HitungHargaSatuan(par){
var i=par.parentNode.parentNode.rowIndex;
var tmp;
	if (document.form1.txtObat.length){
		if (document.form1.qty_per_kemasan[i-1].value=="" || document.form1.qty_per_kemasan[i-1].value=="0"){
			document.form1.h_satuan[i-1].value=0;
		}else{
			tmp=(document.form1.h_kemasan[i-1].value*1)/(document.form1.qty_per_kemasan[i-1].value*1);
			document.form1.h_satuan[i-1].value=tmp.toFixed(2)*1;
		}
	}else{
		if (document.form1.qty_per_kemasan.value=="" || document.form1.qty_per_kemasan.value=="0"){
			document.form1.h_satuan.value=0;
		}else{
			tmp=(document.form1.h_kemasan.value*1)/(document.form1.qty_per_kemasan.value*1);
			document.form1.h_satuan.value=tmp.toFixed(2)*1;
		}
	}
}

function HitunghTot(){
var tmp=0;
	if (document.form1.txtObat.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			tmp +=(document.form1.sub_tot[i].value*1);
		}
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.sub_tot.value*1);
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}
	tmp=tmp-(document.form1.disk_tot.value*1);
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.plus_ppn.value=="1"){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitunghDiskonTot(){
var tmp=0;
	if (document.form1.txtObat.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			tmp +=(document.form1.diskon_rp[i].value*1);
		}
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.diskon_rp.value*1);
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}
	tmp=(document.form1.h_tot.value*1)-tmp;
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.plus_ppn.value=="1"){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitungDiskon(par,j){
var i=par.parentNode.parentNode.rowIndex;
var tmp;
	//alert('diskon');
	if (document.form1.txtObat.length){
		if (j==1){
			tmp=((document.form1.sub_tot[i-1].value*1)*(document.form1.diskon[i-1].value*1))/100;
			document.form1.diskon_rp[i-1].value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp[i-1].value*1)*100/(document.form1.sub_tot[i-1].value*1));
			document.form1.diskon[i-1].value=tmp.toFixed(2)*1;
		}
		if (document.form1.plus_ppn.value=="1"){
			document.form1.dpp_ppn[i-1].value=document.form1.sub_tot[i-1].value;
			tmp=(document.form1.sub_tot[i-1].value*1)*100/110;
			document.form1.dpp[i-1].value=tmp.toFixed(2)*1;
		}else{
			tmp=(document.form1.sub_tot[i-1].value*1)-(document.form1.diskon_rp[i-1].value*1);
			document.form1.dpp[i-1].value=tmp.toFixed(2)*1;
			tmp=(document.form1.sub_tot[i-1].value*1)-(document.form1.diskon_rp[i-1].value*1)+(((document.form1.sub_tot[i-1].value*1)-(document.form1.diskon_rp[i-1].value*1))/10);
			document.form1.dpp_ppn[i-1].value=tmp.toFixed(2)*1;
		}
	}else{
		if (j==1){
			tmp=((document.form1.sub_tot.value*1)*(document.form1.diskon.value*1))/100;
			document.form1.diskon_rp.value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp.value*1)*100/(document.form1.sub_tot.value*1));
			document.form1.diskon.value=tmp.toFixed(2)*1;
		}
		if (document.form1.plus_ppn.value=="1"){
			document.form1.dpp_ppn.value=document.form1.sub_tot.value;
			tmp=(document.form1.sub_tot.value*1)*100/110;
			document.form1.dpp.value=tmp.toFixed(2)*1;
		}else{
			tmp=(document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1);
			document.form1.dpp.value=tmp.toFixed(2)*1;
			tmp=(document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1)+(((document.form1.sub_tot.value*1)-(document.form1.diskon_rp.value*1))/10);
			document.form1.dpp_ppn.value=tmp.toFixed(2)*1;
		}
	}
	HitunghDiskonTot();
}

function fSubmit(){
var cdata='';
var x;
//	alert(document.form1.chkItem.length);
	if (document.form1.txtObat.length){
		for (var i=0;i<document.form1.txtObat.length;i++){
			if (document.form1.expired[i].value==''){
				alert('Isikan Expired Date Dari Item Obat !');
				document.form1.expired[i].focus();
				return false;
			}
			if ((document.form1.qty_per_kemasan[i].value=='')||(document.form1.qty_per_kemasan[i].value=='0')){
				alert('Isi Per Kemasan Dari Item Obat, Salah !');
				document.form1.qty_per_kemasan[i].focus();
				return false;
			}
			cdata +=document.form1.obat_id[i].value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired[i].value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'**';
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.expired.value==''){
			alert("Isikan Expired Date Dari Item Obat !");
			document.form1.expired.focus();
			return false;
		}
		if ((document.form1.qty_per_kemasan.value=='')||(document.form1.qty_per_kemasan.value=='0')){
			alert('Isi Per Kemasan Dari Item Obat, Salah !');
			document.form1.qty_per_kemasan.focus();
			return false;
		}
		
		cdata +=document.form1.obat_id.value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.expired.value+'|'+document.form1.qty_kemasan.value+'|'+document.form1.kemasan.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.qty_per_kemasan.value+'|'+document.form1.qty_satuan.value+'|'+document.form1.satuan.value+'|'+document.form1.h_satuan.value+'|'+document.form1.sub_tot.value+'|'+document.form1.diskon.value+'|'+document.form1.diskon_rp.value;
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.form1.submit();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<body>
<?php if ($act=="save"){?>
<div align="center">
<!-- Print Out -->
	<div id="printArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
       
		<tr> 
          <td width="115">No Penerimaan</td>
          <td width="260">: <?php echo $no_gdg; ?>
            </td>
          <td width="93">Harga Total</td>
          <td width="224">: <?php echo number_format($h_tot,2,",","."); ?>
            </td>
          <td width="113">PPN (10%)</td>
          <td width="214">: <?php echo number_format($ppn,2,",","."); ?>
            </td>
        </tr>
        <tr> 
          <td width="115">Tgl Penerimaan</td>
          <td>: <?php echo $tgl_gdg; ?>
                      </td>
          <td>Diskon Total</td>
          <td>: <?php echo number_format($disk_tot,2,",","."); ?>
           </td>
          <td>T O T A L</td>
          <td>: <?php echo number_format($total,2,",","."); ?>
            </td>
        </tr>
        <tr> 
          <td>No PO</td>
          <td>: <?php echo $no_po; ?></td>
          
        <td>Harga Diskon</td>
          <td>: <?php echo number_format($h_diskon,2,",","."); ?>
            </td>
          <td>Cara Perolehan</td>
          
        <td>: <?php echo $cperolehan; ?></td>
        </tr>
        <tr> 
          <td>No Faktur/No Bukti</td>
          <td>: <?php echo $no_faktur; ?>
            </td>
          <td>Asal Perolehan</td>
          <td>: <?php echo $pbf; ?></td>
          
        <td>Kepemilikan</td>
          
        <td>: <?php echo $kp_nama; ?></td>
        </tr>
      </table>
	  
    <table id="tblpenerimaan" width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="60" class="tblheader">Kode Obat</td>
        <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
        <td id="qty_kemasan" width="30" class="tblheader">Expired Date</td>
        <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
        <td id="kemasan" width="60" class="tblheader">Kemasan</td>
        <td width="40" class="tblheader">Harga Kemasan </td>
        <td width="40" class="tblheader">Isi / Ke masan</td>
        <td width="40" class="tblheader">Qty Satuan </td>
        <td width="60" class="tblheader">Satuan</td>
        <td width="50" class="tblheader">Harga Satuan </td>
        <td width="60" class="tblheader">Sub Total </td>
        <td width="30" class="tblheader">Disk (%) </td>
        <td width="50" class="tblheader">Diskon (Rp) </td>
      	<td width="61" class="tblheader">DPP</td>
      	<td width="61" class="tblheader">DPP+PPN</td>
      </tr>
      <?php 
	  $sql="select a_p.*,date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID where a_p.NOTERIMA='$no_gdg' AND a_p.NOBUKTI='$no_faktur' order by a_p.ID";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  $i=0;
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
		if ($ppn>0){
			$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
			$dpp_ppn=$dpp+($dpp/10);
		}else{
			$dpp_ppn=$rows['subtotal'];
			$dpp=$dpp_ppn*100/110;
		}
	  ?>
      <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>"> 
          <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>"> 
          <?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['tgl2']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $qty_kemasan; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['KEMASAN']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['SATUAN']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['subtotal'],2,",","."); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['DISKON']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp,2,",","."); ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($dpp_ppn,2,",","."); ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
	</div>
	<!--vPrint Out Selesai -->
  <p align="center">Penerimaan Gudang Dgn No Penerimaan : <?php echo $no_gdg; ?> 
    Sudah Disimpan</p>
	<?php if ($msgupdt!="") echo "<span class='txtinput'>".$msgupdt."Harga Penerimaan Baru Lebih Besar dari Master Harga, Tapi Tdk Bisa Diupdate karena di-Lock<br></span>"; ?>
	<p align="center">
	<BUTTON type="button" onClick='PrintArea("printArea","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Penerimaan&nbsp;&nbsp;</BUTTON>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=penerimaan.php&tipe=2'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Penerimaan&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>
</div>
<?php }else{?>
<script>
var arrRange=depRange=[];
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
<div align="center">
  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf" id="pbf" type="hidden" value="">
	<input name="kp_nama" id="kp_nama" type="hidden" value="REGULER">
	<input name="plus_ppn" id="plus_ppn" type="hidden" value="0">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="listma" style="display:block">
	  <p><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="107">No Penerimaan</td>
          <td width="250">: 
            <input name="no_gdg" type="text" id="no_gdg" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_gdg; ?>">          </td>
          <td width="90">Harga Total</td>
          <td width="10" align="center">:</td>
          <td width="200"><input name="h_tot" type="text" class="txtright" id="h_tot" value="<?php echo $h_tot; ?>" size="15" readonly="true">          </td>
          <td width="90">PPN (10%)</td>
          <td width="115">: 
            <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo $ppn; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td width="107">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_gdg" type="text" id="tgl_gdg" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_gdg; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_gdg,depRange);" />          </td>
          <td>Diskon Total</td>
          <td align="center">:</td>
          <td><input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo $diskon_tot; ?>" size="15" readonly="true"></td>
          <td>T O T A L</td>
          <td>: 
            <input name="total" type="text" class="txtright" id="total" value="<?php echo $total; ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td>No PO          </td>
          <td>: -</td>
          <td>Harga Diskon</td>
          <td align="center">:</td>
          <td><input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo $h_diskon; ?>" size="15" readonly="true"></td>
          <td>Cara Perolehan</td>
          <td>:<input name="h_j_tempo" type="hidden" class="txtcenter" id="h_j_tempo" value="0" size="3" maxlength="2">
          <select id="jenis" name="jenis" onChange="if (this.value=='1' || this.value=='3'){document.getElementById('asal_perolehan').style.display='none';document.getElementById('pbf_id').style.display='block';}else{document.getElementById('asal_perolehan').style.display='block';document.getElementById('pbf_id').style.display='none';}">
          	<option value="1">Konsinyasi</option>
            <option value="2">Hibah/Bantuan</option>
            <option value="3">Return PBF</option>
          </select></td>
        </tr>
        <tr> 
          <td>No Faktur/No Bukti</td>
          <td>: 
            <input name="no_faktur" type="text" id="no_faktur" size="25" maxlength="30" class="txtinput" autocomplete="off"></td>
          <td>Asal Perolehan</td>
          <td align="center">:</td>
          <td><input name="asal_perolehan" type="text" id="asal_perolehan" size="35" class="txtinput" autocomplete="off" style="display:none;"><select name="pbf_id" id="pbf_id" class="txtinput" onChange="document.getElementById('pbf').value=this.options[this.options.selectedIndex].label">
		  <?
              $qry="select PBF_NAMA, PBF_ID from a_pbf where PBF_ISAKTIF=1 group by PBF_NAMA order by PBF_NAMA";
              $exe=mysqli_query($konek,$qry);
              while($show=mysqli_fetch_array($exe)){ 
            ?>
          <option value="<?php echo $show['PBF_ID']; ?>" label="<?php echo $show['PBF_NAMA']; ?>" class="txtinput"><?php echo $show['PBF_NAMA']; ?></option>
          <? }?>
          </select></td>
          <td>Kepemilikan</td>
          <td>: <select id="kepemilikan_id" name="kepemilikan_id" onChange="document.getElementById('kp_nama').value=this.options[this.options.selectedIndex].label;">
          <?php 
		  	$sql="select * from a_kepemilikan where aktif=1 order by id";
			$rs=mysqli_query($konek,$sql);
			while ($rows=mysqli_fetch_array($rs)){
		  ?>
          	<option value="<?php echo $rows['ID']; ?>" label="<?php echo $rows['NAMA']; ?>"><?php echo $rows['NAMA']; ?></option>
          <?php }?>
          </select></td>
        </tr>
      </table>
	  <table id="tblpenerimaan" width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_NAMA" width="200" class="tblheader">Nama Obat</td>
          <td id="qty_kemasan" width="70" class="tblheader">Expired Date</td>
          <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
          <td id="kemasan" width="50" class="tblheader">Kemasan</td>
          <td width="40" class="tblheader">Harga Kemasan </td>
          <td width="40" class="tblheader">Isi / Ke masan</td>
          <td width="40" class="tblheader">Qty Satuan </td>
          <td width="50" class="tblheader">Satuan</td>
          <td width="50" class="tblheader">Harga Satuan </td>
          <td width="60" class="tblheader">Sub Total </td>
          <td width="30" class="tblheader">Disk (%) </td>
          <td width="50" class="tblheader">Diskon (Rp) </td>
          <td width="50" class="tblheader">DPP</td>
          <td width="50" class="tblheader">DPP+PPN</td>
          <td width="50" class="tblheader"><input type="button" value="+" onClick="addRowToTable();" /></td>
        </tr>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri">1</td>
          <td class="tdisi" align="left"> 
            <input name="obat_id" type="hidden" value="">
            <input type="text" name="txtObat" class="txtinput" size="45" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
          <td class="tdisi" align="center"><input name="expired" type="text" class="txtcenter" value="" size="11" maxlength="10" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_kemasan" type="text" class="txtcenter" size="3" value="0" onKeyUp="HitungQtySatuan(this);HitungSubTotal(this);HitungDiskon(this,1);" autocomplete="off"></td>
          <td class="tdisi" align="center"><select name="kemasan" class="txtinput">
                        <?
							  $qry="select * from a_satuan order by SATUAN";
							  $exe=mysqli_query($konek,$qry);
							  while($show=mysqli_fetch_array($exe)){ 
							?>
                        <option value="<?php echo $show['SATUAN']; ?>" class="txtinput"><?php echo $show['SATUAN']; ?></option>
                        <? }?>
                      </select></td>
          <td class="tdisi" align="right"><input name="h_kemasan" type="text" class="txtright" onKeyUp="HitungSubTotal(this);HitungHargaSatuan(this);HitungDiskon(this,1);" value="0" size="8" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_per_kemasan" type="text" class="txtcenter" onKeyUp="HitungQtySatuan(this);HitungHargaSatuan(this);AddRow(event,this);" value="0" size="3" autocomplete="off"></td>
          <td class="tdisi" align="center"><input name="qty_satuan" type="text" class="txtcenter" onKeyUp="" value="0" size="5" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="center"> <input name="satuan" value="" type="text" size="7" readonly class="txtcenter"></td>
          <td class="tdisi" align="right"><input name="h_satuan" type="text" class="txtright" onKeyUp="" value="0" size="7" autocomplete="off" readonly="true"></td>
          <td class="tdisi" align="right"><input name="sub_tot" type="text" class="txtright" onKeyUp="" value="0" size="8" readonly="true"></td>
          <td class="tdisi" align="center"><input name="diskon" type="text" class="txtcenter" onKeyUp="HitungDiskon(this,1);AddRow(event,this);" value="0" size="3" autocomplete="off"></td>
          <td class="tdisi" align="right"><input name="diskon_rp" type="text" class="txtright" onKeyUp="HitungDiskon(this,2);AddRow(event,this);" value="0" size="7" autocomplete="off"></td>
          <td class="tdisi" align="right"><input name="dpp" type="text" class="txtright" value="0" size="7" readonly></td>
          <td class="tdisi" align="right"><input name="dpp_ppn" type="text" class="txtright" value="0" size="8" readonly></td>
          <td class="tdisi" align="center"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
        </tr>
      </table>
	</div>
		<p align="center">
	  <BUTTON type="button" onClick="if (document.getElementById('jenis').value=='1' || document.getElementById('jenis').value=='3'){if (ValidateForm('no_faktur','ind')){fSubmit();}}else{if (ValidateForm('no_faktur,asal_perolehan','ind')){fSubmit();}}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</BUTTON>
			&nbsp;<BUTTON type="reset" onClick="location='?f=penerimaan.php&tipe=2'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
		  </p>
</form>
</div>
<?php 
}
?>
<script>
	document.getElementById('pbf').value=document.getElementById('pbf_id').options[document.getElementById('pbf_id').options.selectedIndex].label;
</script>
</body>

</html>
<?php 
mysqli_close($konek);
?>