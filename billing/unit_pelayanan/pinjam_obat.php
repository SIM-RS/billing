<?php
session_start();
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
// Get ID  =================================
$TmpLay = $_REQUEST["cmbTmpLay"];
if(!empty($TmpLay)){
	$sql= "select UNIT_KODE, UNIT_ID from $dbapotek.a_unit where unit_billing='$TmpLay'";
	$query = mysql_fetch_array(mysql_query($sql));
	$idunit = $query['UNIT_ID'];
	$kodeunit = $query['UNIT_KODE'];
}
$iduser = $_SESSION ['userId'];
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];
$tgltrans1=$_REQUEST["tglminta"];
$tgltrans=explode("-",$tgltrans1);
$tglminta=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$no_minta=$_REQUEST["no_minta"];
$no_mnt=$no_minta;
$fdata=$_REQUEST["fdata"];
//======================Tanggalan==========================
$idgudang=$_SESSION["ses_id_gudang"];
$kepemilikan_id=$_REQUEST["kepemilikan_id"];
$unit_tujuan=$_REQUEST["unit_tujuan"];
//echo $unit_tujuan;
$sql="select * from $dbapotek.a_unit where UNIT_ID='$unit_tujuan'";
//echo $sql;
$rs=mysql_query($sql);
$nmunit="";
if ($rows=mysql_fetch_array($rs)) $nmunit=$rows['UNIT_NAME'];
if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];
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
		$sql="select * from $dbapotek.a_pinjam_obat where unit_id=$idunit and month(tgl)=$bulan and year(tgl)=$th[2] order by peminjaman_id desc limit 1";
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)){
			$no_minta=$rows1["no_bukti"];
			$ctmp=explode("/",$no_minta);
			$dtmp=$ctmp[3]+1;
			$ctmp=$dtmp;
			for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
			$no_minta="$kodeunit/PI/$th[2]-$th[1]/$ctmp";
		}else{
			$no_minta="$kodeunit/PI/$th[2]-$th[1]/0001";
		}
		//echo "<br/>----------<br/>";
		$arfdata=explode("**",$fdata);
		if ($unit_tujuan==$idunit){
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$sql="insert into $dbapotek.a_pinjam_obat(unit_id,user_id,no_bukti,obat_id,kepemilikan_id,kepemilikan_id_asal,unit_tujuan,qty,qty_terima,tgl,tgl_act,status) values($idunit,$iduser,'$no_minta',$arfvalue[0],$arfvalue[3],$arfvalue[2],$unit_tujuan,$arfvalue[1],$arfvalue[1],'$tglminta','$tglact',2)";
				//echo $sql."<br>";
				//$rs=mysql_query($sql);
				echo $sql="select * from $dbapotek.a_pinjam_obat where no_bukti='$no_minta' and obat_id=$arfvalue[0] and kepemilikan_id=$arfvalue[3]";
				$rs=mysql_query($sql);
				if ($rows=mysql_fetch_array($rs)){
					$fk_minta=$rows['peminjaman_id'];
					$sql="call $dbapotek.gd_mutasi($idunit,$unit_tujuan,$fk_minta,'$no_minta',$arfvalue[0],$arfvalue[2],$arfvalue[3],$arfvalue[1],2,$iduser,1,'$tglminta','$tglact')";
					$rs1=mysql_query($sql);
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$sql="insert into $dbapotek.a_pinjam_obat(unit_id,user_id,no_bukti,obat_id,kepemilikan_id,kepemilikan_id_asal,unit_tujuan,qty,qty_terima,tgl,tgl_act,status) values($idunit,$iduser,'$no_minta',$arfvalue[0],$arfvalue[3],$arfvalue[2],$unit_tujuan,$arfvalue[1],0,'$tglminta','$tglact',0)";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
			}
		}
		break;
}

$qry="select * from $dbapotek.a_kepemilikan where AKTIF=1";
$exe=mysql_query($qry);
$sela="";
$i=0;
while($show=mysql_fetch_array($exe)){
	$sela .="sel.options[$i] = new Option('".$show['NAMA']."', '".$show['ID']."');";
	$i++;
}

//Aksi Save, Edit, Delete Berakhir ====================================
?>
<?php
//session_start();
$iduser=$_SESSION['userId'];
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->
<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->
<script>
var bln = '<?php echo date('m'); ?>';
var thn = '<?php echo date('Y'); ?>';
var arrRange=depRange=[];
</script>
<title>Daftar Peminjaman Obat</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
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
<div id="divobat" align="left" style="position:absolute; z-index:1; left:100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;DAFTAR PEMINJAMAN OBAT</td>
	</tr>
</table>
<table width="1000" cellpadding="0" cellspacing="0" class="tabel">
<tr>
	<td>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	  <table width="1000" border="0" class="tabel">
	  	<tr>
			<td>
  <div id="input" style="display:block" align="center"> 
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="tabel">
              <tr>
				<td>
					Jenis Layanan
				</td>
				<td width="125">
                :
					<select id="cmbJnsLay" class="txtinput" onChange="isiCombo1('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay','noLoad');" >
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
						</select>
                 </td>
              </tr>
              <tr>
                 <td>
					Tempat Layanan
				 </td>
				 <td>
                 :
				   <select name="cmbTmpLay" id="cmbTmpLay" class="txtinput" lang="" onChange="this.lang=this.value;evLang2();">
					</select>
				 </td>
			  </tr>
              <tr> 
                <td width="125">Tanggal&nbsp; </td>
                <td>: <input name="tglminta" type="text" id="tglminta" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tglminta,depRange);" /></td>
              </tr>
              <!--tr> 
                <td>No. Permintaan</td>
                <td>: 
                  <input name="no_minta" type="text" class="txtinput" id="no_minta" value="<?php //echo $no_minta; ?>" size="25" maxlength="30" readonly="true" ></td>
              </tr--->
              <tr>
                <td>Unit Tujuan </td>
                <td>:
			<select name="unit_tujuan" id="unit_tujuan">
            	<?
	  			$qry = "select * from $dbapotek.a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
				$exe = mysql_query($qry);
	  			while($show= mysql_fetch_array ($exe)){
	  			?>
              <option value="<?php echo $show['UNIT_ID']; ?>" class="txtinput"<?php if ($unit_tujuan==$show['UNIT_ID']) echo "selected";?>><? echo $show['UNIT_NAME'];?></option>
              	<? }?>
            </select>
			</td>
              </tr>
            </table>
  </div>
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="9" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="8" align="center" class="jdltable">DAFTAR PEMINJAMAN 
                OBAT </td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="100" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat</td>
              <td width="100" height="25" class="tblheader">Satuan</td>
              <td width="100" class="tblheader">Kepemilikan</td>
              <td width="100" class="tblheader">Kepemilikan (Asal)</td>
              <td width="40" class="tblheader">Stok</td>
              <td width="40" height="25" class="tblheader">Qty Pinjam</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td align="left" class="tdisi"> 
                <input name="obatid" type="hidden" value=""><input name="kp_asal" type="hidden" value="">
                <input type="text" name="txtObat" class="txtinput" size="63" onKeyUp="suggest(event,this);" autocomplete="off" />
			</td>
              <td class="tdisi">-</td>
              <td class="tdisi"> 
                <select name="kp_id" id="kp_id" class="txtinput">
                  <?
					  $qry="Select * from $dbapotek.a_kepemilikan where aktif=1";
					  $exe=mysql_query($qry);
					  while($show=mysql_fetch_array($exe)){ 
					?>
                  <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
                  <?=$show['NAMA'];?>
                  </option>
                  <? }?>
                </select>
              </td>
              <td class="tdisi">- </td>
              <td class="tdisi" width="40">
<input name="txtStok" type="text" class="txtcenter" id="txtStok" readonly="true" size="5" /></td>
              <td class="tdisi" width="40">
<input type="text" name="txtJml" class="txtcenter" size="5" onKeyUp="AddRow(event,this)" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='../unit_pelayanan/list_pinjam_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
        </p>
</form>
</div>
	</td>
   </tr>
</table>
</div>
</body>
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
function isiCombo1(id,val,defaultId,targetId,evloaded){
	//alert(id+"-1 \n"+val+"-2 \n"+defaultId+"-3 \n"+targetId+"-4 \n"+evloaded);

            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            if(document.getElementById(targetId)==undefined){
                alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
            }else{
                Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
            }
}

var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
var ReqAddr;
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
	var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if ((keywords=="")){
		document.getElementById('divobat').style.display='none';
	}else{
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
			ReqAddr='../transaksi/obatlist_pinjam.php?aKepemilikan=0&idunit='+document.forms[0].unit_tujuan.value+'&aKeyword='+keywords+'&no='+i;
			//alert(ReqAddr);
			Request(ReqAddr , 'divobat', '', 'GET' );			
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	/* if (document.forms[0].no_minta.value==""){
		alert('Isikan No Permintaan Terlebih Dahulu !');
		document.forms[0].no_minta.focus();
		return false;		
	} */
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtObat[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}

			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			cdata +=ctemp[0]+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].kp_asal[i].value+'|'+document.forms[0].kp_id[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
/*		for (var i=0;i<document.forms[0].obatid.length-1;i++){
			for (var j=i+1;j<document.forms[0].obatid.length-1;j++){
				
			}
			//alert(document.forms[0].obatid[i].value+'-'+document.forms[0].txtJml[i].value+'-'+document.forms[0].txtHarga[i].value);		
		}
*/
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value.split('|');
		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}

		cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].kp_asal.value+'|'+document.forms[0].kp_id.value;
	}
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
  
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kp_asal';
  }else{
  	el = document.createElement('<input name="kp_asal"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
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
  el.size = 63;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  // select cell
  cellRight = row.insertCell(4);
  var sel;
  if(!isIE){
  	sel = document.createElement('select');
  	sel.name = 'kp_id';
  }else{
  	sel = document.createElement('<select name="kp_id" />');
  }	
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sela; ?>
  cellRight.className = 'tdisi';
  cellRight.appendChild(sel);
  // select cell
  cellRight = row.insertCell(5);
  textNode = document.createTextNode('-');
  cellRight.className = 'tdisi';
  cellRight.appendChild(textNode);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
	el.setAttribute('readonly', "true");
  	el.name = 'txtStok';
  }else{
  	el = document.createElement('<input name="txtStok" readonly="true" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';
  
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
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1]+'|'+cdata[5];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		document.forms[0].txtStok.value=cdata[5];
		document.forms[0].kp_asal.value=cdata[7];
		document.forms[0].kp_id.focus();
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
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		document.forms[0].txtStok[(cdata[0]*1)-1].value=cdata[5];
		document.forms[0].kp_asal[(cdata[0]*1)-1].value=cdata[7];
		document.forms[0].kp_id[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[6];
	tds[3].innerHTML=cdata[3];
	tds[5].innerHTML=cdata[8];

	document.getElementById('divobat').style.display='none';
}

function ShowStok(par){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
	alert(document.forms[0].obatid[i-1].value);
  }else{
  	i=0;	
	alert(document.forms[0].obatid.value);
  }
}

function ShowStokKey(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==38 || key==40){
		ShowStok(par);
	}
}

Request('../combo_utils.php?id=cmbTmpLay&value=<?php echo $_SESSION['userId'];?>,'+ document.getElementById('cmbJnsLay').value,'cmbTmpLay','','GET','','noLoad');

</script>
</html>
<?php 
mysql_close($konek);
?>