<?php 
include("../koneksi/konek.php");
?>

<html>
<head>
<title>Auto Complete</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">

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
			Request('../transaksi/obatlist_minta.php?aKeyword='+keywords+'&idunit='+document.forms[0].unit_tujuan.value+'&aKepemilikan='+document.forms[0].kpid.value+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
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
  el.size = 103;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
 
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 7;
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
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
	}else{

		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[4];
	tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body onLoad="document.form1.txtObat.focus()">

<div id="divobat" align="left" style="position:absolute; z-index:1; left: 10px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>


<form name="form1" method="post" action="">
<?php if (($act=="save")||($isview=="true")){?>

        <table width="99%" border="0" cellpadding="1" cellspacing="0">
          <?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.permintaan_id,am.qty,am.qty_terima,NAMA,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_kirim from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID left join (select ap.* from a_penerimaan ap inner join a_minta_obat ami on ap.FK_MINTA_ID=ami.permintaan_id where ami.no_bukti='$no_minta_cetak' and ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=1) as t1 on am.permintaan_id=t1.FK_MINTA_ID where am.unit_id=$idunit and am.no_bukti='$no_minta_cetak'".$filter." group by am.permintaan_id order by ".$sorting;
		  //echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$jmldata=mysqli_num_rows($rs);
			if ($page=="" || $page=="0") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";
			//echo $sql."<br>";
		  $rs=mysqli_query($konek,$sql);
		  $i=0;
		  //$i=($page-1)*$perpage;
		  while ($rows=mysqli_fetch_array($rs)){
			$i++;
			$cpermintaan_id=$rows['permintaan_id'];
			$iterima=$rows['qty_terima'];
			$cqty_kirim=$rows['qty_kirim'];
			$sql="";
			$arfhapus="act*-*delete*|*idminta*-*".$rows['permintaan_id'];
		  ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
            <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
            <td class="tdisi" align="center"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="<?php if ($cqty_kirim<=0){?>if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}<?php }else{?>alert('Obat Yang Diminta Sudah Dikirim, Jadi Tidak Boleh Dihapus !');<?php }?>"></td>
          </tr>
          <?php 
		  }
		  mysqli_free_result($rs);
		  ?>
        </table>

</div>
<?php }else{?>

	  <table width="99%" border="1">
	  	<tr>
			<td>
  			<div id="input" style="display:block" align="center"> 
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
             
              <tr>
                <td>Kepemilikan</td>
                <td>:
                  <select name="kpid" id="kpid">
                    <?php
					$qry = "SELECT * FROM a_kepemilikan WHERE AKTIF=1";
					$exe = mysqli_query($konek,$qry);
					while($show= mysqli_fetch_array($exe)){
					?>
                    <option value="<?php echo $show['ID'];?>"><?php echo $show['NAMA'];?></option>
                    <?php }?>
                  </select></td>
              </tr>
              <tr> 
                <td>Unit Tujuan</td>
                <td>: 
                  <select name="unit_tujuan" id="unit_tujuan">
                    <?php
					$qry = "SELECT * FROM a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE<>4 AND UNIT_ID<>$idunit AND UNIT_ISAKTIF=1";
					$exe = mysqli_query($konek,$qry);
					while($show= mysqli_fetch_array($exe)){
					?>
                    <option value="<?php echo $show['UNIT_ID'];?>"><?php echo $show['UNIT_NAME'];?></option>
                    <?php }?>
                  </select></td>
              </tr>
            </table>
  </div>
  
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="6" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="5" align="center" class="jdltable"> PERMINTAAN OBAT</td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="100" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat</td>
              <td width="100" height="25" class="tblheader">Satuan</td>
              <td width="50" height="25" class="tblheader">Qty</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
                <input type="text" name="txtObat" class="txtinput" size="103" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
              <td class="tdisi">-</td>
              <td class="tdisi" width="40"> <input type="text" name="txtJml" class="txtcenter" size="7" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
     
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON id="btnSimpan" type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=../apotik/list_minta_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
<?php } ?>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>