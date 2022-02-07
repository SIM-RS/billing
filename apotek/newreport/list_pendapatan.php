<?php 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_SESSION["ses_idunit"];
$idunit=$_REQUEST['idunit'];if ($idunit=="") $idunit=$idunit1;
$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
$rs=mysqli_query($konek,$sql);
$u=mysqli_fetch_array($rs);
$unit=$u['UNIT_NAME'];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p=" and a_kepemilikan.ID=$jns_pasien";
$statuspasien=$_REQUEST['statuspasien'];if($statuspasien=="" OR $statuspasien=="0") $statusp=""; else $statusp=" and (a_unit.status_inap=$statuspasien)";

$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="t1.tgl_asli ASC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$jenis_pendapatan = ($_REQUEST["jenis_pendapatan"] != "")? $_REQUEST["jenis_pendapatan"] : '0';

$links = "http://".$_SERVER[HTTP_HOST]."/simrs/apotek/admini/";
$sql = "select id_hak from a_hak_akses where tipeHak = 6 AND user_id = '".$_SESSION['iduser']."'";
$query = mysqli_query($konek,$sql);
$jml = mysqli_num_rows($query);
if($jml > 0){
	$dijaminview = 1;
} else {
	$dijaminview = 0;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik RS Pelindo</title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}


//ajax save and get data
	function getRequestObject2(){
		var o = null;
		if(window.XMLHttpRequest){
			o = new XMLHttpRequest();
		}else if(window.ActiveXObject){
			try{
				o = new ActiveXObject('Msxml2.XMLHTTP');
			}catch(e1){
				try{
					o = new ActiveXObject('Microsoft.XMLHTTP');
				}catch(e2){

				}
			}
		}
		return o;
	}

	function request2(method, adress, sendData, callback, act){
		var o = getRequestObject2();
		var async = (callback!==null);
		var balik = 0;
		if(method === 'GET'){
			if(sendData!=null){adress+="?"+sendData;}
			o.open(method, adress, async);
			o.send(null);
		}else if(method === 'POST'){
			o.open(method, adress, async);
			o.setRequestHeader('Content-Type' , 'application/x-www-form-urlencoded');
			o.send(sendData);
		}
		if(async){
			o.onreadystatechange = function (){
				if(o.readyState==4&&o.status==200){
					//document.getElementById("hasilT").innerHTML = o.responseText;
					if(callback!=undefined && typeof(callback)=='function'){
						callback(o.responseText);
					}
				}else if(o.readyState==4&&o.status!=200){
					//Error
					req[pos].xmlhttp.abort();
				}
			};
		}
		if(async){
			return ;
		} else {
			return o.responseText;
		}
	}

	//end ajax save and get data

</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
function PrintArea(idArea,fileTarget){
var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars');
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
function PrintArea1(idArea,fileTarget){
//var g;
var winpopup=window.open(fileTarget,'winpopup','height=5,width=10,resizable,scrollbars');
/*	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	g=winpopup.document.getElementById("idprint").innerHTML;*/
	//setTimeout("alert(document.getElementById('mdata').value);document.getElementById('mdata').value='';alert(document.getElementById('mdata').value);",5000);
	//winpopup.print();
	winpopup.close();
}
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
  	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="mdata" id="mdata" type="hidden" value="">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="view" style="display:block"> 
      <p><span class="jdltable">DAFTAR PENDAPATAN 
        <select name="idunit" id="idunit" class="txtinput" onchange="location='?f=../newreport/list_pendapatan.php&idunit='+this.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jenis_pendapatan='+jenis_pendapatan.value">
          <option value="0" class="txtinput"<?php if ($idunit=="0") echo "selected";?>>ALL UNIT</option>
		  <?
		  $qry="select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			//if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
          <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) echo "selected";?>> 
          <?php echo $show['UNIT_NAME'];?></option>
          <? }?>
        </select>
        </span> 
      <table width="53%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="127">Tanggal Periode</td>
          <td colspan="2">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jenis_pendapatan='+jenis_pendapatan.value" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
            </input>&nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jenis_pendapatan='+jenis_pendapatan.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" >
            </input> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>
		  </td>
		  <!--td>
			<button type="button" onclick="location='?f=../newreport/list_pendapatan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<!-- +'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value>
				<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button>
		  </td-->
        </tr>
		<tr>
			<td>Tipe Transaksi</td>
			<td colspan="2">:
				<select name="jenis_pendapatan" id="jenis_pendapatan">
					<option value="0" <?php echo ($jenis_pendapatan == '0')? "selected" : ""; ?>>Semua</option>
					<option value="1" <?php echo ($jenis_pendapatan == '1')? "selected" : ""; ?>>Penjualan</option>
					<option value="2" <?php echo ($jenis_pendapatan == '2')? "selected" : ""; ?>>Retur</option>
				</select>
				&nbsp;<button type="button" onclick="location='?f=../newreport/list_pendapatan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jenis_pendapatan='+jenis_pendapatan.value"> 
					<!-- +'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value -->
					<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp;Lihat
				</button>
			</td>
		</tr>
        <!--tr> 
          <td width="127">Kepemilikan</td>
          <td width="177">: 
            <select name="jns_pasien" id="jns_pasien" class="txtinput" onchange="location='?f=../apotik/list_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value">
              <option value="0" class="txtinput">All Pasien</option>
              <?
			  	$jp="ALL PASIEN";
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 order by ID";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
              <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($jns_pasien==$show['ID']) {echo "selected";$jp=$show['NAMA'];}?>><?php echo $show['NAMA']; ?></option>
              <? }?>
            </select> </td>
          <td width="179" > <button type="button" onclick="location='?f=../apotik/list_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr>
          <td>Jenis Pasien</td>
          <td>:
            <select name="statuspasien" id="statuspasien" class="txtinput" onchange="location='?f=../apotik/list_penjualan.php&idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value">
            <?php 
			$sp="ALL PASIEN";
			?>
              <option value="0" class="txtinput">All Pasien</option>
              <option value="1" class="txtinput"<?php if ($statuspasien=="1") {echo "selected";$sp="RAWAT INAP";}?>>Rawat Inap</option>
              <option value="2" class="txtinput"<?php if ($statuspasien=="2") {echo "selected";$sp="RAWAT JALAN";}?>>Rawat Jalan</option>
              <option value="3" class="txtinput"<?php if ($statuspasien=="3") {echo "selected";$sp="IGD";}?>>Inst. Gawat Darurat</option>
            </select></td>
          <td >&nbsp;</td>
        </tr-->
      </table>
      <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="tgl_act" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Tgl. Trans</td>
          <td id="no_transaksi" width="80" class="tblheader" onclick="ifPop.CallFr(this);">No. Trans</td>
          <!--td id="USER" width="53" class="tblheader" onclick="ifPop.CallFr(this);">No Resep </td-->
          <td id="NO_PASIEN" width="60" class="tblheader" onclick="ifPop.CallFr(this);">No RM</td>
          <td id="NAMA_PASIEN" class="tblheader" onclick="ifPop.CallFr(this);">Nama Pasien</td>
          <!--td width="50" class="tblheader" id="ac.nama" onclick="ifPop.CallFr(this);">Cara Bayar</td-->
          <td id="NAMA" width="120" class="tblheader" onclick="ifPop.CallFr(this);">KSO</td>
          <td id="UNIT_NAME" width="100" class="tblheader" onclick="ifPop.CallFr(this);">Ruangan<br>(Poli)</td>
          <!--td width="60" class="tblheader" id="SHIFT" onclick="ifPop.CallFr(this);">Netto</td-->
          <td id="nilai" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
		  <?php if($jenis_pendapatan == '0'){ ?>
		  <td id="ket" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Tipe Trans</td>
		  <?php } ?>
		  <td id="shift" width="60" class="tblheader" onclick="ifPop.CallFr(this);">Shift</td>
		  <td id="username" width="60" class="tblheader" onclick="ifPop.CallFr(this);">Petugas</td>
          <td width="36" class="tblheader">Detil</td>
		<?php if($dijaminview == 1){?>
          <td width="36" class="tblheader">Dijamin</td>
		<?php } ?>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
    <?php 
		if ($filter!=""){
			$jfilter=$filter;
			$tfilter=explode("*-*",$filter);
			$filter="";
			for ($k=0;$k<count($tfilter);$k++){
				$ifilter=explode("|",$tfilter[$k]);
				$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
				//echo $filter."<br>";
			}
		}
		if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se;
		
		if ($idunit=="0"){
			$tmpunit="";
		}else{
			$tmpunit=" ap.UNIT_ID = '{$idunit}' AND ";
		}
		
		$sql_penjualan = "SELECT DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl_act, ap.NO_PENJUALAN no_transaksi, ap.NAMA_PASIEN, 
							  ap.NO_PASIEN, IFNULL(u.UNIT_NAME,'-') UNIT_NAME, SUM((ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))*ap.QTY_JUAL) nilai, 
							  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'penjualan' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, ap.TGL_ACT tgl_asli, ap.SHIFT shift, ap.DIJAMIN, ap.NO_KUNJUNGAN, ap.CARA_BAYAR, ap.SUDAH_BAYAR, ap.PPN_NILAI
							FROM a_penjualan ap
							LEFT JOIN a_unit u
							   ON u.UNIT_ID = ap.RUANGAN
							INNER JOIN a_user us
							   ON us.kode_user = ap.USER_ID
							INNER JOIN a_mitra m
							   ON m.IDMITRA = ap.KSO_ID
							WHERE {$tmpunit} ap.TGL_ACT BETWEEN '$tgl_1 00:00:00' AND '$tgl_2 23:59:59'
							GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_PASIEN";
		$sql_retur = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_act, rp.no_retur no_transaksi, ap.NAMA_PASIEN, 
						  ap.NO_PASIEN, IFNULL(u.UNIT_NAME,'-') UNIT_NAME, SUM(rp.nilai) nilai,
						  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'retur' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, rp.tgl_retur tgl_asli, rp.shift_retur shift, 9 DIJAMIN, ap.NO_KUNJUNGAN, ap.CARA_BAYAR, ap.SUDAH_BAYAR, ap.PPN_NILAI
						FROM a_penjualan ap
						INNER JOIN a_return_penjualan rp
						   ON rp.idpenjualan = ap.ID
						LEFT JOIN a_unit u
						   ON u.UNIT_ID = ap.RUANGAN
						INNER JOIN a_user us
						   ON us.kode_user = rp.userid_retur
						INNER JOIN a_mitra m
						   ON m.IDMITRA = ap.KSO_ID
						WHERE {$tmpunit} rp.tgl_retur BETWEEN '$tgl_1 00:00:00' AND '$tgl_2 23:59:59'
						GROUP BY rp.no_retur";
		
		if($jenis_pendapatan == '0'){
			$sql_all = $sql_penjualan." UNION ".$sql_retur;
		} else if($jenis_pendapatan == '1'){
			$sql_all = $sql_penjualan;
		} else if($jenis_pendapatan == '2'){
			$sql_all = $sql_retur;
		} 
		$sql = "SELECT t1.* FROM({$sql_all}) t1 where 0 = 0 {$filter} ORDER BY t1.ket, {$sorting}";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql) or die(mysqli_error($konek));
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$i=($page-1)*$perpage;
		while ($rows=mysqli_fetch_array($rs)){
			$i++;
			$jRetur=$rows['jRetur'];
			$tCaraBayar=$rows['CARA_BAYAR'];
	?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl_act']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_transaksi']; ?></td>
          <!--td class="tdisi" align="center">&nbsp;<?php echo $rows['NO_RESEP']; ?></td-->
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['NAMA_PASIEN']; ?></td>
          <!--td class="tdisi"><?php echo $rows['cbayar']; ?></td-->
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <!--td class="tdisi" align="center"><?php echo $rows['SHIFT']; ?></td-->
          <!--td class="tdisi" align="center"><?php echo number_format($rows['HARGA_NETTO'],0,",","."); ?></td-->
          <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",","."); ?>&nbsp;</td>
		  <?php if($jenis_pendapatan == '0'){ ?>
		  <td class="tdisi" align="center"><?php echo ucfirst($rows['ket']); ?></td>
		  <?php } ?>
		  <td class="tdisi" align="center"><?php echo $rows['shift']; ?></td>
		  <td class="tdisi" align="center"><?php echo $rows['username']; ?></td>
          <td class="tdisi" align="center">
			<?php 
				$param = $rows['no_transaksi']."|".$rows['UNIT_ID']."|".$rows['NO_PASIEN']."|".$rows['TGL']."|".$rows['USER_ID']."|".$rows['NO_PENJUALAN'];
			?>
			<div onclick="cetakDet('<?php echo $rows['ket']; ?>','<?php echo $param; ?>')" ><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Melihat Detail Penjualan" style="cursor:pointer"></div>
			<!--a href="../newreport/kwi_pendapatan.php?no_penjualan=<?php echo $rows['NO_PENJUALAN'];?>&sunit=<?php echo $rows['UNIT_ID']; ?>&no_pasien=<?php echo $rows['NO_PASIEN']; ?>&tgl=<?php echo $rows['TGL']; ?>&iduser_jual=<?php echo $rows['USER_ID'];?><?php if ($jRetur==0) echo '&viewdel=true';?>" onclick="NewWindow(this.href,'name','600','500','yes');return false"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Melihat Detail Penjualan"></a-->
		  </td>
		<?php if($dijaminview == 1){?>
		  <td class="tdisi" align="center" >
			<?php if($rows['ket'] == 'penjualan' && $rows['CARA_BAYAR'] == '2'){ // $rows['KSO_ID'] != 2 &&
				//UNIT_ID,USER_ID,NO_KUNJUNGAN,NO_PASIEN,no_transaksi,TGL,DIJAMIN
				if($rows['SUDAH_BAYAR'] == '1'){
					$disBle = 'disabled';
				} else {
					$disBle = "";
				}
				$vdijamin = $rows['UNIT_ID']."|".$rows['USER_ID']."|".$rows['NO_KUNJUNGAN']."|".$rows['NO_PASIEN']."|".$rows['no_transaksi']."|".$rows['TGL'];
				$cdijamin = '';
				if($rows['DIJAMIN'] == '1'){
					$cdijamin = 'checked';
				}
			?>
				<input type="checkbox" name="dijamin" id="dijamin<?php echo $vdijamin; ?>" <?php echo $disBle; ?> value="<?php echo $vdijamin; ?>" <?php echo $cdijamin; ?> onclick="gantiJamin(this.value,this.checked,this.id)" />
			<?php } else { echo "-"; } ?>
		<?php } ?>
		  </td>
        </tr>
        <?php
	 //$hartot=$hartot+$rows['HARGA_TOTAL'];
	  }
	  mysqli_free_result($rs);
	  $sql2="select sum(t1.HARGA_TOTAL) as HARTOT from (".$sql.")as t1";
	  //$hs=mysqli_query($konek,$sql2);
	  $hartot=0;
	  //$show=mysqli_fetch_array($hs);
	  $hartot=$show['HARTOT'];
	  $sql2="SELECT COUNT(t2.NO_RESEP) AS jml_resep FROM (SELECT DISTINCT t1.NO_RESEP FROM (".$sql.") AS t1) AS t2";
	  //$rs=mysqli_query($konek,$sql2);
	  $totresep=0;
	 // if ($rows=mysqli_fetch_array($rs))	$totresep=$rows['jml_resep'];  
	  ?>
        <!--tr class="itemtable"> 
          <td class="tdisikiri" align="right" colspan="3">Resep Total &nbsp; </td>
          <td class="tdisi" align="right"><?php echo number_format($totresep,0,",","."); ?></td>
          <td class="tdisi" align="right" colspan="7">Jumlah Total &nbsp; </td>
          <td class="tdisi" align="right">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
          <td colspan="2" width="2" class="tdisi">&nbsp;</td>
        </tr-->
      </table>
	</div>
    <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <!--td align="center" colspan="2"><BUTTON type="button" onclick="PrintArea1('idArea','http://localhost:10000/rsud-sda.prn?rpt=kw|004255|4|1267582|2009-10-30|ULFA');" <?php //if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON></td-->
	 <td align="center" colspan="2">
		<BUTTON onclick='NewWindow("../newreport/laporan_pendapatan_view.php?idunit=<?php echo $idunit; ?>&tgl_d=<?php echo $tgl_1; ?>&tgl_s=<?php echo $tgl_2; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&jenis_pendapatan=<?php echo $jenis_pendapatan; ?>","Laporan Pendapatan Farmasi",1280,600,"yes");' type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Pendapatan</BUTTON>
		&nbsp;
		<!--BUTTON type="button" onClick="BukaWndExcell();" <?php if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td-->
	  </tr>
	</table>
  	</form>
</div>
</body>
<script>
var req;
function gantiJamin(nilai,parcek,id){
	var param = 0;
	if(parcek == true){
		param = 1;
	} else {
		param = 0;
	}
	//alert(id);
	//UNIT_ID,USER_ID,NO_KUNJUNGAN,NO_PASIEN,no_transaksi,TGL
	
	var key = nilai.split('|');
	var unit_id = key[0];
	var userJual = key[1];
	var no_kunj = key[2];
	var noRM = key[3];
	var noJual = key[4];
	var tgl_act = key[5];
	
	var act = 'dijaminUbah';
	var idUser 	= '<?php echo $_SESSION['iduser']; ?>';
	var url 	= '../newreport/dijamin_utils.php';
	var data 	= 'act='+act+'&idUser='+idUser+'&userJual='+userJual+'&no_penjualan='+noJual+'&no_pasien='+noRM+'&no_kunjungan='+no_kunj+'&unit_id='+unit_id+'&tgl_act='+tgl_act+'&dijamin='+param;
	//alert(data);
	request2("GET", url, data, function(hasil){
		//alert(hasil);
		data = hasil.split('|');
		alert(data[1]);
		if(data[0] == "gagal"){
			var dijamin = true;
			if(param == 1){
				dijamin = false;
			}
			document.getElementById(id).checked = dijamin;
			location.reload();
			return false;
		} else if(data[0] == "sukses"){
			location.reload();
		}
	}, act);
}


function cetakDet(tipe,par){
	param = par.split('|');
	switch(tipe){
		case "penjualan":
			NewWindow('../newreport/kwi_jual.php?no_penjualan='+param[0]+'&sunit='+param[1]+'&no_pasien='+param[2]+'&tgl='+param[3]+'&iduser_jual='+param[4],'Nota Penjualan',580,500,'yes');
			break;
		case "retur":
			NewWindow('../newreport/kwi_retur_new.php?no_retur='+param[0]+'&no_penjualan='+param[5]+'&sunit='+param[1]+'&no_pasien='+param[2]+'&tgl='+param[3]+'&iduser_jual='+param[4],'Nota Penjualan',580,500,'yes');
			break;
	}
}
function PrintSvc(vMethod,vUrl){
	req = new newRequest(1);
  if (req.xmlhttp) {
	//alert('start');
    req.available = 0;
    //req.xmlhttp.open(vMethod , vUrl, false);
	req.xmlhttp.open('GET' , '../transaksi/updtelement1.php?kid=3', true);
	req.xmlhttp.onreadystatechange = function() {
	 // if (typeof(req) != 'undefined' && 
	//	req.available == 0 && 
	  if (req.xmlhttp.readyState == 4) {
		  if (req.xmlhttp.status == 200 || req.xmlhttp.status == 304) {
		  		alert(req.xmlhttp.responseText);
				//GetId(obj).innerHTML = req.xmlhttp.responseText;
				//cdata=req.xmlhttp.responseText;
				//if (cdata!="OK"){
				//	alert('reply salah');
					//PrintArea("idArea","#");
				//}
		  } else {
				req.xmlhttp.abort();
				alert('tdk ada servis');
				//PrintArea("idArea","#");*/
		  }
		  req.available = 1;
	  //}else{
	  //	alert('tdk ada servis');
	  }
	}
	
	if (window.XMLHttpRequest) {
	  req.xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  req.xmlhttp.send();
	}
  }
  return false;
}

function newRequest(available) {
	this.available = available;
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}
}

function BukaWndExcell(){
var tgld=tgl_d.value;
var tgls=tgl_s.value;
var idunit1=idunit.value;
var jpasien=jns_pasien.value;
var spasien=statuspasien.value;
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../apotik/list_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien+'&statuspasien='+spasien+'&jp=<?php echo $jp; ?>&sp=<?php echo $sp; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&jenis_pendapatan=<?php echo $jenis_pendapatan; ?>',600,450,'childwnd',true);
}

</script>
</html>
<?php 
mysqli_close($konek);
?>