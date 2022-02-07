<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$tgla="01-".$th[1]."-".$th[2];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$id=$_REQUEST['id'];
$no_penjualan=$_REQUEST['no_penjualan'];
$no_pasien=$_REQUEST['no_pasien'];//if($no_pasien=="") $no_pasien=0;
$nama_pasien=$_REQUEST['nama_pasien']; //if($nama_pasien=="") $nama_pasien=0;
$nama_pasien1=str_replace("\'","'",$nama_pasien);
$nama_pasien1=str_replace('\"','"',$nama_pasien1);//echo "pos=".strpos($nama_pasien1,"'")."<br>";
$no_retur=$_REQUEST['no_retur'];
$obat_id=$_REQUEST['obat_id'];
if($_GET['pbf']==""){$pbf_id=0;}else{$pbf_id=$_GET['pbf'];}
$no_retur=$_REQUEST['no_retur'];
$tgl_s=$_REQUEST['tgl_s'];
	$s=explode("-",$tgl_s);
	$tgl_se=trim($s[2])."-".trim($s[1])."-".trim($s[0]);
$tgl_d=$_REQUEST['tgl_d'];
	$d=explode("-",$tgl_d);
	$tgl_de=trim($d[2])."-".trim($d[1])."-".trim($d[0]);
$qty_satuan=$_REQUEST['qty_satuan'];
$idPel=$_REQUEST['idPel'];
$status=1;
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

//print_r($qty_satuan);

switch ($act){
	case "save":
	for ($i = 0; $i < count($qty_satuan); $i++){
	 	//echo $qty_satuan[$i]."<BR>";
		$sql="SELECT SQL_NO_CACHE a.* FROM a_penjualan a INNER JOIN a_penerimaan b ON a.PENERIMAAN_ID=b.ID WHERE a.UNIT_ID=$idunit AND a.NO_PENJUALAN='$no_penjualan[$i]' AND b.OBAT_ID=$obat_id[$i] AND a.QTY_JUAL>a.QTY_RETUR AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de' ORDER BY ID DESC";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$cjml=$qty_satuan[$i];
		//echo $cjml."<br />";
		$ok="false";
		while (($rows=mysqli_fetch_array($rs))&&($ok=="false")){
			$deff = mysqli_fetch_array(mysqli_query($konek,"select ".$rows["QTY_JUAL"]."-".$rows["QTY_RETUR"]." cqty"));
			$cqty=$deff['cqty'];//($rows["QTY_JUAL"])-($rows["QTY_RETUR"]);
			$cidp=$rows["ID"];
			$pidp=$rows["PENERIMAAN_ID"];
			//echo $rows["QTY_JUAL"]."-".$rows["QTY_RETUR"]."<br />";
			//echo "$cqty dohkah<br />";
			if ($cqty>=$cjml){
				//echo "$cqty >= $cjml <br/>";
				$ok="true";
				$charga=floor(((100-$rows["BIAYA_RETUR"])/100)*$rows["HARGA_SATUAN"]*$cjml);
				$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK+$cjml WHERE ID=$pidp";
				//echo $sql." | 1<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="update a_penjualan SET USER_ID_RETUR=$iduser,NO_RETUR='$no_retur',TGL_RETUR='$tgl_act',SHIFT_RETUR=$shift, QTY_RETUR=QTY_RETUR+$cjml,QTY=QTY-$cjml WHERE ID=$cidp";
				//echo "<br />".$sql." | 1<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="INSERT INTO a_return_penjualan(idpenjualan,userid_retur,no_retur,shift_retur,tgl_retur,qty_retur,nilai) VALUES($cidp,$iduser,'$no_retur',$shift,'$tgl_act',$cjml,$charga)";
				//echo "<br />".$sql." | 1<br>";
						$rs1=mysqli_query($konek,$sql);
			} else {
				//echo "$cjml-$cqty adadad<br />";
				$deff = mysqli_fetch_array(mysqli_query($konek,"select ".$cjml."-".$cqty." cqty"));
				//echo "select ".$cjml."-".$cqty." cqty aaaaaa<br />";
				$cjml = $deff['cqty']; //(($cjml)-($cqty));
				//echo $cjml." adadadadadad<br>";
				$charga=floor(((100-$rows["BIAYA_RETUR"])/100)*$rows["HARGA_SATUAN"]*$cqty);
				$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK+$cqty WHERE ID=$pidp";
				//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="update a_penjualan SET USER_ID_RETUR=$iduser,NO_RETUR='$no_retur',TGL_RETUR='$tgl_act',SHIFT_RETUR=$shift, QTY_RETUR=QTY_RETUR+$cqty,QTY=QTY-$cqty WHERE ID=$cidp";
				//echo "<br />".$sql."<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="INSERT INTO a_return_penjualan(idpenjualan,userid_retur,no_retur,shift_retur,tgl_retur,qty_retur,nilai) VALUES($cidp,$iduser,'$no_retur',$shift,'$tgl_act',$cqty,$charga)";
				//echo "<br />".$sql."<br>";
						$rs1=mysqli_query($konek,$sql);
			}				
		}
	}
	break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par,opt){
var keywords=par.value;//alert(keywords);
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
			var tblRow=document.getElementById('pasienlist_penj').rows.length;
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
			if ((fKeyEnt==false) && (keywords.length>2)){
				RowIdx=0;
				fKeyEnt=true;
				Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt, 'divobat', '', 'GET' );
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			}else{
				if (RowIdx>0){
					if (fKeyEnt==true){
						fSetObat(document.getElementById(RowIdx).lang);
						fKeyEnt=false;
					//}else{
					//	fKeyEnt=false;
					}
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			//RowIdx=0;
			fKeyEnt=false;
			/*Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt, 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';*/
		}
	}
}

function replaceall(str,replace,with_this)
{
	var str_hasil ="";
	var temp;

	for(var i=0;i<str.length;i++) // not need to be equal. it causes the last change: undefined..
	{
		if (str[i] == replace)
		{
			temp = with_this;
		}
		else
		{
			temp = str[i];
		}

		str_hasil += temp;
	}

	return str_hasil;
}

function fSetObat(par){
	var tpar=par;
	var cdata;
	var tbl = document.getElementById('tblJual');
	var tds;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	cdata=tpar.split("*|*");
	document.forms[0].nama_pasien.value=cdata[1];
	document.forms[0].no_pasien.value=cdata[2];
	document.forms[0].pelayananID.value=cdata[3];
	document.forms[0].tgl_s.value=cdata[5];
	document.getElementById('isianTpel').innerHTML=cdata[4];
	document.getElementById('divobat').style.display='none';
}

function fHitungRetur(par){
	var tbl = document.getElementById('tblRetur');
	var tds,i,p,q,s;
	i=par.parentNode.parentNode.rowIndex;
	tds = tbl.rows[i].getElementsByTagName('td');
	p=tds[4].innerHTML;
	/* p=p.replace(".","");
	p=p.replace(",","."); */
	p = replaceall(p,'.','');
	p = replaceall(p,',','.');
	s=tds[3].innerHTML;
	//alert(p+'|'+s+'|'+par.value);
	tds[10].innerHTML=FormatNum(parseInt(p)*parseFloat(par.value)*((100-parseFloat(s))/100),0);
	q=0;
	for (var k=1;k<tbl.rows.length-1;k++){
		tds = tbl.rows[k].getElementsByTagName('td');
		q=q+parseFloat(tds[10].innerHTML);
	}
	tds = tbl.rows[tbl.rows.length-1].getElementsByTagName('td');
	tds[0].innerHTML="Total = "+FormatNum(q,0);
}

function fChecked(par){
var tbl = document.getElementById('tblRetur');
var i = par.parentNode.parentNode.rowIndex;
var tds = tbl.rows[i].getElementsByTagName('td');
var q;
	tds[10].innerHTML='0';
	document.getElementById('qty_satuan'+(i-1).toString()).value='0';
	q=0;
	for (var k=1;k<tbl.rows.length-1;k++){
		tds = tbl.rows[k].getElementsByTagName('td');
		q=q+parseFloat(tds[10].innerHTML);
	}
	tds = tbl.rows[tbl.rows.length-1].getElementsByTagName('td');
	tds[0].innerHTML="Total = "+FormatNum(q,0);
}

function fSubmit(){
var tbl = document.getElementById('tblRetur');
var tds,i,p,q,s;
var chk=false;
	//alert(document.forms[0].pilihobat.length);
	if (document.forms[0].pilihobat.length){
		for (i=0;i<document.forms[0].pilihobat.length;i++){
			if (document.forms[0].pilihobat[i].checked){
				chk=true;
				tds = tbl.rows[i+1].getElementsByTagName('td');
				p=tds[9].innerHTML;
				//alert(p);
				/* p = replaceall(p,'.','');
				p = replaceall(p,',','.'); */
				dd = document.getElementById('qty_satuan'+i.toString()).value;
				if (parseFloat(dd)>parseFloat(p)){
					alert('Jumlah Item Obat Yang diReturn Lebih Besar dr Sisa Stock');
					document.getElementById('qty_satuan'+i.toString()).focus();
					return false;
				}
			}
		}
	}else{
		if (document.forms[0].pilihobat.checked){
			chk=true;
			tds = tbl.rows[1].getElementsByTagName('td');
			p=tds[9].innerHTML;
			/* p = replaceall(p,'.','');
			p = replaceall(p,',','.'); */
			dd = document.getElementById('qty_satuan0').value;
			if (parseFloat(dd)>parseFloat(p)){
				alert('Jumlah Item Obat Yang diReturn Lebih Besar dr Sisa Stock');
				return false;
			}
		}
	}
	//alert(parseFloat(dd)+">"+parseFloat(p));
	if (chk){
		//alert('Submit');
		document.getElementById('btnReturn').disabled=true;
		document.forms[0].submit();
	}else{
		alert('Pilih Item Obat Yang diReturn Terlebih Dahulu !');
		return false;
	}
}
</script>
<script>
var arrRange=depRange=[];
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
<?php 
$cstr="";
for ($i = 0; $i < count($no_penjualan); $i++)
{
	//echo strpos($cstr,$no_penjualan[$i])."<br>";
	//echo $cstr."--".$no_penjualan[$i]."<br>";
	if (strpos($cstr,$no_penjualan[$i])<=0) $cstr .="|".$no_penjualan[$i];
}
?>
<style type="text/css">
.style1 { font-family: "Courier New", Courier, monospace; font-size:14px; }
</style>
	<?php if($act=="save"){?>
	
<p align="center"> <b>Retur Penjualan Dengan No.Retur <?php echo $no_retur; ?> 
  telah dilakukan</b><br>
  <br>
<select name="cetak" id="cetak" onChange="">
	<?php
	$cstr=substr($cstr,1,strlen($cstr)-1);
	$no_penjualan=explode("|",$cstr);
	for ($i = 0; $i < count($no_penjualan); $i++){
		if ($no_pasien!=""){
			$sql="SELECT DISTINCT TGL FROM a_penjualan WHERE NO_PENJUALAN='$no_penjualan[$i]' AND UNIT_ID=$idunit AND NO_PASIEN='$no_pasien' AND TGL BETWEEN '$tgl_se' AND '$tgl_de'";
		}else{
			$sql="SELECT DISTINCT TGL FROM a_penjualan WHERE NO_PENJUALAN='$no_penjualan[$i]' AND UNIT_ID=$idunit AND TGL BETWEEN '$tgl_se' AND '$tgl_de'";
		}
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $tglrtr=$rows1['TGL']; else $tglrtr="0000-00-00";
	?>
	<option value="<?php echo $no_penjualan[$i];?>" lang="<?php echo $tglrtr; ?>"><?php echo $no_penjualan[$i];?></option>
	<?php } ?>
</select>
<BUTTON type="button" onClick="NewWindow('../report/kwi_retur.php?no_penjualan='+cetak.value+'&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $no_pasien; ?>&tgl='+cetak.options[cetak.selectedIndex].lang,'name','560','500','yes');return false"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak Retur</BUTTON>
<BUTTON type="button" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;</BUTTON>
</p>
<?php 
//==Jika Dalam keadaan Disimpan berakhir===	
}else{
	$sql="select NO_RETUR from a_penjualan where NO_RETUR<>0 order by NO_RETUR desc limit 1";
	$rs=mysqli_query($konek,$sql);
	$rows=mysqli_fetch_array($rs);
	$nortr="000001";
	$cek=mysqli_num_rows($rs);
	//echo "$cek<br>";
	if ($cek>0) {
		$nortr=(int)$rows['NO_RETUR']+1;
		$noretur=(string)$nortr;
		if (strlen($noretur)<6){
			for ($i=0;$i<(6-strlen($noretur));$i++) $nortr="0".$nortr;
		}
	}

?>
<style type="text/css">
	#kiri, #kanan{
		float:left;
		width:55%;
		padding:10px;
		font-size:12px;
	}
	#kanan{
		width:40%;
	}
	#kanan table{
		font-size:12px;
		font-weight:bold;
	}
	#kanan table td{
		padding:3px;
	}
	#clear{
		clear:both;
	}
	.inputan{
		border:0px;
		background:#EAF0F0;
		font-weight:bold;
		letter-spacing:2px;
	}
</style>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 700px; width:495px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center"> 
  <div id="input" style="display:block">
      <p class="jdltable">Detil Retur Penjualan </p>
	 <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="retur_penjualan_id" id="retur_penjualan_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="outer">
		<div id="kiri">
			<table width="100%" border="0" align="center" style="margin-left:45px;" cellpadding="0" cellspacing="0" class="txtinput">
				<tr>
					<td width="100">Nama Pasien</td>
					<td width="12">:</td>
					<td colspan="2"><input name="nama_pasien" size="38" id="nama_pasien"<?php if (strpos($nama_pasien1,'"')>0) echo "value='".$nama_pasien1."'"; else echo 'value="'.$nama_pasien1.'"'; ?> class="txtinput" onKeyUp="suggest(event,this,1);" autocomplete="off"></td>
				</tr>
				  <tr>
					<td height="25">No. Retur </td>
					<td>:</td>
					<td colspan="2" ><input name="no_retur" id="no_retur" value="<? echo "$nortr"; ?>" class="txtinput" type="text" readonly="true"></td>
				</tr>
				  <tr>
					<td height="25">No. Rekam Medis </td>
					<td>:</td>
					<td colspan="2" ><input name="no_pasien" id="no_pasien" value="<?php echo $no_pasien; ?>" class="txtinput" type="text" onKeyUp="suggest(event,this,2);" autocomplete="off"></td>
				</tr>
				  <tr>
					<td height="25">Data mulai tgl </td>
					<td>:</td>
					<td width="320" >
					<input name="tgl_s" id="tgl" size="11" maxlength="10" readonly="true" value="<?php if($_GET['tgl_s']<>"") echo $tgl_s;else echo $tgla;?>" class="txtcenter" />
					<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
					&nbsp; s/d &nbsp;
					<input name="tgl_d" id="tgl" size="11" maxlength="10" readonly="true" value="<?php if($_GET['tgl_d']<>"") echo $tgl_d;else echo $tglSkrg;?>" class="txtcenter" />
					<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
					</td>
				</tr>
				  <tr>
					<td></td>
					<td></td>
					<td>
					  <input type="button" value="&raquo; PROSES" name="checkbox" onClick="location='?f=../transaksi/detil_retur_penjualan.php&nama_pasien='+nama_pasien.value+'&no_pasien='+no_pasien.value+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&idPel='+pelayananID.value+'&unit='+isianTpel.innerHTML">
					</td>
				</tr>
			</table>
		</div>
		<div id="kanan" align="left">
			<table>
				<tr>
					<td>No. Kunjungan</td>
					<td>:</td>
					<td><input type="text" class="inputan" value="<?php echo $_REQUEST['idPel']?>" name="pelayananID" id="pelayananID" size="25" readonly /></td>
				</tr>
				<tr>
					<td>Tempat Pelayanan</td>
					<td>:</td>
					<td id="isianTpel"><?php echo $_REQUEST['unit']?></td>
				</tr>
			</table>
		</div>
	</div>	  
	<div id="clear"></div>
      <table id="tblRetur" width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="headtable"> 
          <td width="80" height="25" class="tblheaderkiri" id="TGL" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td width="80" class="tblheader" id="NO_PENJUALAN" onClick="ifPop.CallFr(this);">No. 
            Penjualan </td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td width="100" class="tblheader">Biaya 
            Return (%)</td>
          <td width="80" class="tblheader">Harga 
            Satuan </td>
          <td width="40" class="tblheader">Qty 
            Jual </td>
          <td width="40" class="tblheader">Qty 
            Sdh Return</td>
          <td colspan="2" class="tblheader">Qty 
            Return </td>
          <td width="47" class="tblheader">Qty 
          </td>
          <td width="90" class="tblheader">Subtotal 
            Return</td>
          <!--td><input name="checkSedoyo" type="checkbox" value="" onClick="fCheckAll(checkSedoyo,pilihobat)"></td-->
        </tr>
        <?php
			if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  		}
	  		if ($sorting=="") $sorting=$defaultsort;
		   $sql="SELECT a.TGL,a.NO_PENJUALAN,b.OBAT_ID,a.JENIS_PASIEN_ID,a.BIAYA_RETUR,a.HARGA_SATUAN,SUM(a.QTY_JUAL) AS QTY_JUAL,SUM(a.QTY_RETUR) AS QTY_RETUR,
				SUM(a.QTY_JUAL)-SUM(a.QTY_RETUR) AS QTY,c.OBAT_ID,c.OBAT_NAMA 
				FROM a_penjualan a INNER JOIN a_penerimaan b ON a.PENERIMAAN_ID = b.ID INNER JOIN a_obat c 
				ON b.OBAT_ID = c.OBAT_ID WHERE a.NO_PASIEN ='$no_pasien' AND a.UNIT_ID=$idunit 
				AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de'".$filter." AND a.NO_KUNJUNGAN = '{$idPel}' GROUP BY c.OBAT_ID,a.NO_PENJUALAN,c.OBAT_NAMA ORDER BY ".$sorting;
		   //echo $sql."<br>";
		   $exe=mysqli_query($konek,$sql);
		   $i=0;
		   while ($show=mysqli_fetch_array($exe)){
			   $ngitung=$i++;
			   //$cbiaya=$show["BIAYA_RETUR"];
           ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <input type="hidden" name="id[]" id="id<?php echo $ngitung; ?>" value="<?php echo $show['ID'];?>" disabled="disabled">
          <td class="tdisikiri"><?php echo date("d/m/Y",strtotime($show['TGL'])); ?></td>
          <td class="tdisi"><?php echo $show['NO_PENJUALAN']; ?></td>
          <input type="hidden" name="no_penjualan[]" id="no_penjualan<?php echo $ngitung; ?>" value="<?php echo $show['NO_PENJUALAN'];?>" disabled="disabled">
          <td class="tdisi"><?php echo $show['OBAT_NAMA'];?> <input type="hidden" name="obat_id[]" id="obat_id<?php echo $ngitung; ?>" value="<?php echo $show['OBAT_ID'];?>" disabled="disabled"></td>
          <td class="tdisi"><?php echo $show['BIAYA_RETUR']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($show['HARGA_SATUAN'],0,",","."); ?></td>
          <td class="tdisi"><?php echo $show['QTY_JUAL'];?></td>
          <td class="tdisi"><?php echo $show['QTY_RETUR'];?></td>
          <td width="47" align="right" class="tdisi"><input name="qty_satuan[]" size="5" class="txtcenter" id="qty_satuan<?=$ngitung?>" value="0" disabled="disabled" onKeyUp="fHitungRetur(this)" autocomplete="off"></td>
          <td width="40" class="tdisi"><input name="pilihobat" type="checkbox" value="" onClick="if (this.checked==true){document.getElementById('id<?=$ngitung;?>').disabled='';document.getElementById('no_penjualan<?=$ngitung;?>').disabled='';document.getElementById('obat_id<?=$ngitung;?>').disabled='';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='';}else{fChecked(this);document.getElementById('id<?=$ngitung;?>').disabled='disabled'; document.getElementById('no_penjualan<?=$ngitung;?>').disabled='disabled';document.getElementById('obat_id<?=$ngitung;?>').disabled='disabled';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='disabled';}"> 
          </td>
          <td class="tdisi"><?php echo $show['QTY'];?></td>
          <td class="tdisi" align="right" style="padding-right:5px;">0</td>
        </tr>
        <? 
			$hartot=$hartot+($show['HARGA_SATUAN']*$show['QTY_RETUR']);
			//echo "<br>".$hartot."<br>";
			}
			?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" colspan="11" align="right" style="padding-right:5px;"> 
            <b>Total = 0</b> </td>
        </tr>
      </table>
      <p align="center">
        <!--BUTTON type="button" onClick="if(ValidateForm('nama_pasien','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;</BUTTON-->
        <BUTTON id="btnReturn" type="button" onClick="if(ValidateForm('nama_pasien','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;</BUTTON>
         <BUTTON type="reset" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
    </form>
  </div>
</div>
<?php } 
mysqli_close($konek);
?>