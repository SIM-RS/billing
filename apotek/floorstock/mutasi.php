<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];
$tgltrans1=$_REQUEST["tglkirim"];
$tgltrans=explode("-",$tgltrans1);
$tglkirim=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$tglprint=$tgltrans[0]."/".$tgltrans[1]."/".$tgltrans[2]." ".substr($tgl_ctk,strlen($tgl_ctk)-5,5);
$no_kirim=$_REQUEST["no_kirim"];
$no_kirim_print=$_REQUEST["no_kirim"];
$fdata=$_REQUEST["fdata"];
$unit_tujuan=$_REQUEST["unit_tujuan"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$sql="SELECT * FROM a_retur_biaya";
$rs=mysqli_query($konek,$sql);
$biaya_retur=0;
if ($rows=mysqli_fetch_array($rs)) $biaya_retur=$rows['biaya_potong'];

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$sql="SELECT * FROM a_penerimaan WHERE UNIT_ID_KIRIM=$idunit AND NOKIRIM='$no_kirim' AND TIPE_TRANS=1";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($jmldata<=0){
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				//echo "ID Obat=".$arfvalue[0]."-Jml=".$arfvalue[1]."<br>";
				
				$hrg = "select IFNULL(qty_stok,0) qty_stok ,IFNULL(nilai,0) nilai ,IFNULL(rata2,0) rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
				$hrg1 = mysqli_query($konek,$hrg);
				$hrg2 = mysqli_fetch_array($hrg1);
				$a_rata2 = $hrg2['rata2'];
					
				
				$sql="call gd_mutasi($idunit,$unit_tujuan,0,'$no_kirim',$arfvalue[0],$arfvalue[2],$arfvalue[2],$arfvalue[1],1,$iduser,1,'$tglkirim','$tglact',$a_rata2)";
				//echo $hrg."<br>";
				$rs=mysqli_query($konek,$sql);
			}
			$sql="SELECT * FROM a_penerimaan WHERE UNIT_ID_KIRIM=$idunit AND UNIT_ID_TERIMA=$unit_tujuan AND NOKIRIM='$no_kirim' AND TIPE_TRANS=1 ORDER BY ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			while ($rows=mysqli_fetch_array($rs)){
				$cid=$rows['ID'];
				$cobatid=$rows['OBAT_ID'];
				$ckpid=$rows['KEPEMILIKAN_ID'];
				$cqty=$rows['QTY_SATUAN'];
				//$sql="SELECT HARGA_BELI_SATUAN+(PROFIT*HARGA_BELI_SATUAN/100) AS harga FROM a_harga WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid";
				$sql="select FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga from a_harga where OBAT_ID=$cobatid and KEPEMILIKAN_ID=$ckpid";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$charga=0;
				if ($rows1=mysqli_fetch_array($rs1)) $charga=$rows1['harga'];
				/*$sql="SELECT * FROM a_penjualan WHERE PENERIMAAN_ID=$cid AND QTY_JUAL=$cqty AND RUANGAN='$unit_tujuan'";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				if (mysqli_num_rows($rs1)<=0){*/
					$sql="INSERT INTO a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN) VALUES($cid,$idunit,$iduser,0,0,0,'$tglkirim',NOW(),'','','','','','$unit_tujuan',0,0,$cqty,$cqty,$biaya_retur,$charga,$cqty*$charga,0,0,0,0,1,'')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				//}
			}
		}else{
			$rwKirim=mysqli_fetch_array($rs);
			if ($rwKirim['USER_ID_KIRIM']!=$iduser){
				$sql="select NOKIRIM from a_penerimaan where UNIT_ID_KIRIM=$idunit and month(TANGGAL)=$bulan and year(TANGGAL)=$th[2] and TIPE_TRANS=1 order by NOKIRIM desc limit 1";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);
				if ($rows1=mysqli_fetch_array($rs1)){
					$no_kirim=$rows1["NOKIRIM"];
					$ctmp=explode("/",$no_kirim);
					$dtmp=$ctmp[3]+1;
					$ctmp=$dtmp;
					for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
					$no_kirim="$kodeunit/MP/$th[2]-$th[1]/$ctmp";
				}else{
					$no_kirim="$kodeunit/MP/$th[2]-$th[1]/0001";
				}
				
				$no_kirim_print=$no_kirim;
				
				$arfdata=explode("**",$fdata);
				for ($i=0;$i<count($arfdata);$i++){
					$arfvalue=explode("|",$arfdata[$i]);
					//echo "ID Obat=".$arfvalue[0]."-Jml=".$arfvalue[1]."<br>";
					
					$hrg = "select IFNULL(qty_stok,0) qty_stok ,IFNULL(nilai,0) nilai ,IFNULL(rata2,0) rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
					$hrg1 = mysqli_query($konek,$hrg);
					$hrg2 = mysqli_fetch_array($hrg1);
					$a_rata2 = $hrg2['rata2'];
					
					$sql="call gd_mutasi($idunit,$unit_tujuan,0,'$no_kirim',$arfvalue[0],$arfvalue[2],$arfvalue[2],$arfvalue[1],1,$iduser,1,'$tglkirim','$tglact',$a_rata2)";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
				}
				$sql="SELECT * FROM a_penerimaan WHERE UNIT_ID_KIRIM=$idunit AND UNIT_ID_TERIMA=$unit_tujuan AND NOKIRIM='$no_kirim' AND TIPE_TRANS=1 ORDER BY ID";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				while ($rows=mysqli_fetch_array($rs)){
					$cid=$rows['ID'];
					$cobatid=$rows['OBAT_ID'];
					$ckpid=$rows['KEPEMILIKAN_ID'];
					$cqty=$rows['QTY_SATUAN'];
					//$sql="SELECT HARGA_BELI_SATUAN+(PROFIT*HARGA_BELI_SATUAN/100) AS harga FROM a_harga WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid";
					$sql="select FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga from a_harga where OBAT_ID=$cobatid and KEPEMILIKAN_ID=$ckpid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$charga=0;
					if ($rows1=mysqli_fetch_array($rs1)) $charga=$rows1['harga'];
					/*$sql="SELECT * FROM a_penjualan WHERE PENERIMAAN_ID=$cid AND QTY_JUAL=$cqty AND RUANGAN='$unit_tujuan'";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					if (mysqli_num_rows($rs1)<=0){*/
						$sql="INSERT INTO a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN) VALUES($cid,$idunit,$iduser,0,0,0,'$tglkirim',NOW(),'','','','','','$unit_tujuan',0,0,$cqty,$cqty,$biaya_retur,$charga,$cqty*$charga,0,0,0,0,1,'')";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					//}
				}
			}else{
				echo "<script>alert('No Pengiriman : $no_kirim Sudah Ada');</script>";
			}
		}
		/*echo "<script>location='?f=list_kirim_obat.php'</script>";
		exit();*/
		break;
}
//Aksi Save, Edit, Delete Berakhir ====================================
$sql="select NOKIRIM from a_penerimaan where UNIT_ID_KIRIM=$idunit and month(TANGGAL)=$bulan and year(TANGGAL)=$th[2] and TIPE_TRANS=1 order by NOKIRIM desc limit 1";
//echo $sql;
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$no_kirim=$rows1["NOKIRIM"];
	$ctmp=explode("/",$no_kirim);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_kirim="$kodeunit/MP/$th[2]-$th[1]/$ctmp";
}else{
	$no_kirim="$kodeunit/MP/$th[2]-$th[1]/0001";
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
			ReqAddr='../transaksi/obatlist_fs.php?aKepemilikan=0&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i;
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
	if (document.forms[0].no_kirim.value==""){
		alert('Isikan No Kirim Terlebih Dahulu !');
		document.forms[0].no_kirim.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtJml[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}

			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			cdata +=ctemp[0]+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].kp_asal[i].value+'|'+document.forms[0].txtHarga[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value.split('|');
		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtJml.focus();
			alert('Stok Obat Kurang !');
			return false;
		}

		cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].kp_asal.value+'|'+document.forms[0].txtHarga.value;
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
/*
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
*/

function HitungSubTot(par){
//var tbl = document.getElementById('tblJual');
var i=par.parentNode.parentNode.rowIndex;
var p;
var q,r;
	//alert(i);
	if (i==3){
		if (document.form1.txtJml.length){
			if (document.form1.txtJml[i-3].value==""){
				return false;
			}
			q=document.form1.txtHarga[i-3].value;
			r=document.form1.txtJml[i-3].value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
	/*		while (r.indexOf(".")>-1){
				r=r.replace(".","");
			}
	*/
			p=parseFloat(q)*parseFloat(r);
			//p=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
			document.form1.txtSubTot[i-3].value=FormatNumberFloor(parseInt(p.toString()),".");
			//document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
		}else{
			if (document.form1.txtJml.value==""){
				return false;
			}
			q=document.form1.txtHarga.value;
			r=document.form1.txtJml.value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
	/*		while (r.indexOf(".")>-1){
				r=r.replace(".","");
			}
	*/
			p=parseFloat(q)*parseFloat(r);
			document.form1.txtSubTot.value=FormatNumberFloor(parseInt(p.toString()),".");
			//document.form1.txtSubTot.value=(document.form1.txtHarga.value*1)*(document.form1.txtJml.value*1).toPrecision(2);
		}
	}else{
		if (document.form1.txtJml[i-3].value==""){
			return false;
		}
		q=document.form1.txtHarga[i-3].value;
		r=document.form1.txtJml[i-3].value;
		while (q.indexOf(".")>-1){
			q=q.replace(".","");
		}
/*		while (r.indexOf(".")>-1){
			r=r.replace(".","");
		}
*/
		p=parseFloat(q)*parseFloat(r);
		//p=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
		document.form1.txtSubTot[i-3].value=FormatNumberFloor(parseInt(p.toString()),".");
		//document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
	}
	HitungTot();
}
/*
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
*/

function HitungTot(){
var q;
	if (document.form1.txtSubTot.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTot.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			q=document.form1.txtSubTot[i].value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
			cStot +=parseInt(q);
		}
		//document.form1.subtotal.value=FormatNumberFloor(cStot,".");
		//alert(cStot);
	}else{
		q=document.form1.txtSubTot.value;
		while (q.indexOf(".")>-1){
			q=q.replace(".","");
		}
		//document.form1.subtotal.value=FormatNumberFloor(parseInt(q),".");
		cStot=parseInt(q);
	}
	//cStot=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
	//document.form1.tot_harga.value=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
	document.form1.tot_harga.value=FormatNumberFloor(cStot,".");
	
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
  el.size = 60;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  cellRight = row.insertCell(4);
  textNode = document.createTextNode('-');
  cellRight.className = 'tdisi';
  cellRight.appendChild(textNode);
  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
	el.setAttribute('readonly', "true");
  	el.name = 'txtStok';
  }else{
  	el = document.createElement('<input name="txtStok" readonly="true" />');
  }
  el.type = 'text';
  el.size = 3;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 3;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHarga';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtHarga" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 12;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtSubTot';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtSubTot" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 15;
  el.className = 'txtright';
  
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
		document.forms[0].txtHarga.value=cdata[9];
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
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
		document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[9];
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[6];
	tds[3].innerHTML=cdata[3];
	tds[4].innerHTML=cdata[8];

	document.getElementById('divobat').style.display='none';
}
</script>
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglprint.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>

</head>
<body onLoad="document.form1.txtObat.focus()">
<?php if($act=="save"){?>
		<!-- Print out -->
<div id="printOut" style="display:none" align="center">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
    <tr>
		<td>
			<p align="center" class="jdltable">PENGELUARAN OBAT KE RUANGAN (POLI)</p>
            
        <table width="30%" border="0" cellpadding="0" cellspacing="0" class="txtinput" align="center">
          <tr> 
                <td width="97">Tanggal&nbsp; </td>
                
            <td>: <?php echo $tgl;?> </td>
              </tr>
              <tr> 
                <td>No. Kirim </td>
                <td>:<?php echo $no_kirim_print; ?></td>
              </tr>
              <tr> 
                <td>Poli Tujuan </td>
				<?php
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID='$unit_tujuan'";
				//echo $qry;
				$exe = mysqli_query($konek,$qry);
	  			$show= mysqli_fetch_array($exe);
	  			?>
                <td>: <?php echo $show['UNIT_NAME'];?></td>
              </tr>
            </table>
          
        <table id="tblJualSave" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr> 
            <td colspan="9" align="center" class="jdltable"></td>
          </tr>
          <tr class="headtable"> 
            <td width="25" height="25" class="tblheaderkiri">No</td>
            <td width="100" height="25" class="tblheader">Kode Obat</td>
            <td height="25" class="tblheader">Nama Obat</td>
            <td width="90" height="25" class="tblheader">Satuan</td>
            <td width="90" class="tblheader">Kepemilikan</td>
            <td width="40" height="25" class="tblheader">Jml</td>
            <td width="90" class="tblheader">Nilai</td>
          </tr>
          <?php 
 	$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,a_unit.UNIT_NAME,ap.NOKIRIM,sum(ap.QTY_SATUAN) as qty,ap.KEPEMILIKAN_ID,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,NAMA,SUM(p.QTY_JUAL*p.HARGA_SATUAN) AS nilai from a_penerimaan ap inner join a_obat ao on ap.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on ap.kepemilikan_id=ak.ID Inner Join a_unit ON ap.UNIT_ID_TERIMA = a_unit.UNIT_ID INNER JOIN a_penjualan p ON ap.ID=p.PENERIMAAN_ID where ap.NOKIRIM='$no_kirim_print' AND ap.UNIT_ID_KIRIM=$idunit AND a_unit.UNIT_TIPE=3 group by ap.OBAT_ID,ap.NOKIRIM,ap.KEPEMILIKAN_ID order by ap.TANGGAL,ap.NOKIRIM";
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  $totnilai=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$totnilai+=$rows['nilai'];
	  ?>
          <tr class="itemtable"> 
            <td class="tdisikiri" align="center" style="font-size:12px"><?php echo $i; ?></td>
            <td class="tdisi" align="center"  style="font-size:12px">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
            <td class="tdisi" align="center"  style="font-size:12px">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi" align="center"  style="font-size:12px">&nbsp;<?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
            <td class="tdisi" align="center"  style="font-size:12px">&nbsp;<?php echo $rows['NAMA']; ?></td>
            <td class="tdisi" align="center"  style="font-size:12px">&nbsp;<?php echo $rows['qty']; ?></td>
            <td class="tdisi" align="right"  style="font-size:12px">&nbsp;<?php echo number_format($rows['nilai'],0,",","."); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="6" style="font-size:12px">Total&nbsp;</td>
            <td align="right"  style="font-size:12px"><?php echo number_format($totnilai,0,",","."); ?>&nbsp;</td>
          </tr>
        </table>
	  </td>
	</tr>
</table>
</div>	
	<!-- Print out berakhir -->
<!--div align="center">
	<p align="center">Pengeluaran Obat dari Floor Stok dengan No Kirim : <-?php echo $no_kirim_print; ?> Sudah Terkirim </p>
	<p align="center">
	<BUTTON type="button" onClick="PrintArea('printOut','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Pengeluaran&nbsp;&nbsp;</BUTTON>&nbsp;
	    <BUTTON type="button" onClick="location='?f=list_kirim_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Pengeluaran&nbsp;&nbsp;</BUTTON>
	</p>
</div-->

<?php } ?>
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
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

		<div id="input" style="display:block" align="center"> 
            
      <table border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
                <td width="85">Tanggal&nbsp; </td>
                
          <td>: 
            <input name="tglkirim" type="text" id="tglkirim" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tglkirim,depRange);" />
          </td>
              </tr>
              <tr> 
                <td>No. Kirim </td>
                <td>: 
                  <input name="no_kirim" type="text" class="txtinput" id="no_kirim" value="<?php echo $no_kirim; ?>" size="25" maxlength="30"  ></td>
              </tr>
              <tr> 
                <td>Poli Tujuan </td>
                <td>: 
                  <select name="unit_tujuan" id="unit_tujuan">
                    <?
	  			$qry = "select * from a_unit where UNIT_TIPE IN (3,2) and UNIT_ID<>$idunit and UNIT_ISAKTIF=1";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
	  			?>
                    <option value="<?=$show['UNIT_ID'];?>"> 
                    <?=$show['UNIT_NAME'];?>
                    </option>
                    <? }?>
                  </select> </td>
              </tr>
            </table>
  </div>
          
    <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr> 
        <td colspan="10" align="center" class="jdltable"><hr></td>
      </tr>
      <tr> 
        <td colspan="9" align="center" class="jdltable">PENGELUARAN OBAT KE RUANGAN 
          (POLI) </td>
        <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
      </tr>
      <tr class="headtable"> 
        <td width="25" height="25" class="tblheaderkiri">No</td>
        <td width="100" height="25" class="tblheader">Kode Obat</td>
        <td height="25" class="tblheader">Nama Obat</td>
        <td width="90" height="25" class="tblheader">Satuan</td>
        <td width="80" class="tblheader">Kepemilikan</td>
        <td width="30" class="tblheader">Stok</td>
        <td width="30" height="25" class="tblheader">Jml</td>
        <td width="50" class="tblheader">Hrg Satuan</td>
        <td width="70" class="tblheader">Sub Total</td>
        <td width="30" height="25" class="tblheader">Proses</td>
      </tr>
      <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
        <td class="tdisikiri">1</td>
        <td class="tdisi">-</td>
        <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
          <input name="kp_asal" type="hidden" value=""> <input type="text" name="txtObat" class="txtinput" size="60" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
        <td class="tdisi">-</td>
        <td class="tdisi">- </td>
        <td class="tdisi"><input name="txtStok" type="text" class="txtcenter" id="txtStok" readonly="true" size="3" /></td>
        <td class="tdisi"><input type="text" name="txtJml" class="txtcenter" size="3" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
        <td class="tdisi"><input type="text" name="txtHarga" class="txtright" readonly="true" size="12" /></td>
        <td class="tdisi"><input type="text" name="txtSubTot" class="txtright" readonly="true" size="15" /></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
      </tr>
    </table>
    <table width="99%" border="0" cellpadding="0" cellspacing="0" align="center" class="txtinput">
      <tr> 
        <td width="730">&nbsp;</td>
		<td width="97">TOTAL HARGA</td>
        <td> 
          <input name="tot_harga" type="text" id="tot_harga" size="15" value="0" class="txtright" readonly="true" />
        </td>
      </tr>
	</table>
		<p align="center">
            
      <BUTTON id="btnSimpan" type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kirim</BUTTON>
      &nbsp;<BUTTON type="button" onClick="PrintArea('printOut','#')"<?php if($act!="save") echo " disabled";?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Pengeluaran&nbsp;&nbsp;</BUTTON>&nbsp;
            <BUTTON type="reset" onClick="location='?f=list_kirim_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </p>
</form>
</div>
<?php //}?>
</body>
</html>
<?php 
mysqli_close($konek);
?>