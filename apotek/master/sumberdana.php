<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

$tgl=date('d');
$bln=date('m');
$thn=date('Y');
$tgl_d2 = date('d-m-Y');
$tgl_d = explode('-',$tgl_d2);

//$diff=date_diff($date2,$date1);

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
/*
$interval can be:
yyyy - Number of full years
q - Number of full quarters
m - Number of full months
y - Difference between day numbers
(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
d - Number of full days
w - Number of full weekdays
ww - Number of full weeks
h - Number of full hours
n - Number of full minutes
s - Number of full seconds (default)
*/
	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds
	switch($interval) {
		case 'yyyy': // Number of full years
			$years_difference = floor($difference / 31536000);
			if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
			$years_difference--;
			}
			if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
			$years_difference++;
			}
			$datediff = $years_difference;
			break;
		case "q": // Number of full quarters
			$quarters_difference = floor($difference / 8035200);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$quarters_difference--;
			$datediff = $quarters_difference;
			break;
		case "m": // Number of full months
			$months_difference = floor($difference / 2678400);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$months_difference--;
			$datediff = $months_difference;
			break;
		case 'y': // Difference between day numbers
			$datediff = date("z", $dateto) - date("z", $datefrom);
			break;
		case "d": // Number of full days
			$datediff = floor($difference / 86400);
			break;
		case "w": // Number of full weekdays
			$days_difference = floor($difference / 86400);
			$weeks_difference = floor($days_difference / 7); // Complete weeks
			$first_day = date("w", $datefrom);
			$days_remainder = floor($days_difference % 7);
			$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
			if ($odd_days > 7) { // Sunday
				$days_remainder--;
			}
			if ($odd_days > 6) { // Saturday
				$days_remainder--;
			}
			$datediff = ($weeks_difference * 5) + $days_remainder;
			break;
		case "ww": // Number of full weeks
			$datediff = floor($difference / 604800);
			break;
		case "h": // Number of full hours
			$datediff = floor($difference / 3600);
			break;
		case "n": // Number of full minutes
			$datediff = floor($difference / 60);
			break;
		default: // Number of full seconds (default)
			$datediff = $difference;
			break;
	}
	return $datediff;
} 

//update berlaku sumber dana
$sUP = "UPDATE a_sumber_dana sd
		SET
		   sd.berlaku = IF((DATEDIFF(sd.tgl_berlaku,NOW()))<0,0,1)
		WHERE admin = 0 OR berlaku = 1 AND aktif = 1";
$qUP = mysqli_query($konek,$sUP) or die ("Gagal Auto Update - ".mysqli_error($konek));

$cek=$_REQUEST['cek'];
$act=$_REQUEST['act'];
convert_var($cek,$act);

if(isset($cek)){
	if($cek=="cek"){
		$iduser = $_REQUEST['iduser'];
		$tgl_berlaku = $tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
		$nilai = $_REQUEST['nilai'];
		$id = $_REQUEST['id'];
		convert_var($iduser,$nilai,$id);
		
		$sql = "update a_sumber_dana
				set ket = IFNULL(CONCAT(ket, ',', '{$tgl_berlaku}'), {$tgl_berlaku}),
					tgl_berlaku = '{$tgl_berlaku}', 
					berlaku = '{$nilai}',
					admin = 1,
					user_act = '{$iduser}'
				where id = {$id}";
		$query = mysqli_query($konek,$sql);
		if(mysqli_errno($konek)>0){
			die("Update Masa Berlaku Gagal - ".mysqli_error($konek));
		} else {
			die("Update Masa Berlaku Berhasil");
		}
	}
}

if(isset($act)){
	$id=$_REQUEST['id'];
	$nama = $_REQUEST['nama'];
	$tahun = $_REQUEST['tahun'];
	$tgl_b=$_REQUEST['tgl_berlaku'];
	$aktif = $_REQUEST['aktif'];
	convert_var($id,$nama,$tahun,$tgl_b,$aktif);
	
	$tgl_berlaku2 = explode('-',$tgl_b);
	$tgl_berlaku = ($tgl_b!="")? $tgl_berlaku2[2]."-".$tgl_berlaku2[1]."-".$tgl_berlaku2[0] : $tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
	
	
	
	$diff = datediff('d', $tgl_d2, $tgl_berlaku, false);
	$berlaku = ($diff<0)?0:1;
	$gagal = 0;
	
	if($act == 'edit'):
		$cekS = "SELECT DISTINCT DATE_FORMAT(ap.TGL_TERIMA_ACT,'%d-%m-%Y') tgl
				  FROM a_penerimaan ap
				  WHERE ap.SUMBER_DANA = {$id}
				  ORDER BY ap.TGL_TERIMA_ACT DESC
				  LIMIT 1";
		$cekQ = mysqli_query($konek,$cekS);
		$cekD = mysqli_fetch_array($cekQ);
		
		$diff2 = datediff('d', $cekD['tgl'], $tgl_berlaku, false);
		if($diff2 < 0){
			$gagal = 1;
		}
		
		$sql = "update a_sumber_dana
				set nama = '{$nama}', 
					tahun = '{$tahun}', 
					tgl_berlaku = '{$tgl_berlaku}', 
					berlaku = '{$berlaku}', 
					aktif = '{$aktif}',
					admin = 0,
					user_act = '{$iduser}'
				where id = {$id}";
	elseif($act == 'del'):
		$sql = "delete from a_sumber_dana where id = {$id}";
	else :
		$sql = "insert into a_sumber_dana (nama, tahun, tgl_berlaku, berlaku, aktif) 
				values('{$nama}','{$tahun}','{$tgl_berlaku}','{$berlaku}','{$aktif}')";
	endif;
	
	if($gagal <> 1){
		mysqli_query($konek,$sql) or die(mysqli_error($konek));
	} else {
?>
	<script type="text/javascript">
		alert("Data Tidak Dapat di Ubah!");
	</script>
<?
	}
}

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tahun desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($page,$sorting,$filter);
//===============================


?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<SCRIPT language="JavaScript" src="../theme/js/tip.js"></SCRIPT>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script type="text/javascript">
	var arrRange=depRange=[];
	
	//ajax save and get data
	var rowKe = "";
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
	function request2(method, adress, sendData, callback, nilai, act, idCek){
		//alert(rowKe);
		var o = getRequestObject2();
		var async = (callback!==null);
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
					//alert(numRow);
					if(act == 'cek'){
						alert(o.responseText);
						
						var hasil = o.responseText
						var hasil2 = hasil.split(" - ");
						if(nilai == '1'){
							var cek = false;
						} else {
							var cek = true;
						}
						if(hasil2[0] == "Update Masa Berlaku Gagal"){
							document.getElementById("setExp"+idCek).checked = cek;
						}
						location.reload();
					}
					//document.getElementById("hasilSementara").innerHTML = o.responseText;
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
	
	function setBerlaku(cek,id,idcek){
		var stat = "Yakin merubah menjadi 'Berlaku'?";
		var tmpCek = false;
		var nilai = 1;
		if(cek==false){
			stat = "Yakin merubah menjadi 'Tidak Berlaku'?";
			nilai = 0;
		}
		if(confirm(stat)){
			var act = "cek";
			var urlBook = "../master/sumberdana.php";
			var data = "cek="+act+"&id="+id+"&nilai="+nilai+"&iduser=<?=$iduser?>";
			request2("GET", urlBook, data, "", nilai, act, idcek);
		} else {
			if(cek == false){
				tmpCek = true;
			}
			document.getElementById("setExp"+idcek).checked = tmpCek;
		}
	}
</script>
</head>
<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
	<div id="input" style="display:none">
		<form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="">
			<input name="id" id="id" type="hidden" value="">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<p class="jdltable">NEW SUMBER DANA</p>
			<table width="550" border="0" cellpadding="1" cellspacing="1" class="txtinput">
				<tr> 
					<td width="150">Sumber Dana</td>
					<td>:</td>
					<td><input name="nama" type="text" id="nama" class="txtinput" size="30"></td>
				</tr>
				<tr> 
					<td width="150">Tahun Anggaran</td>
					<td>:</td>
					<td>
						<select name="tahun" id="tahun" style="width:55px;">
							<?php
								for($i=($thn-5);$i<$thn+5;$i++){
									echo $thn;
									$sel = ($i == $thn)?'selected':'';
									echo "<option value='{$i}' {$sel} >{$i}</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr> 
					<td width="150">Masa Berlaku</td>
					<td>:</td>
					<td>
						<input name="tgl_berlaku" type="text" id="tgl_berlaku" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_d2; ?>"> 
						<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_berlaku,depRange);" /> 
					</td>
				</tr>
				<tr> 
					<td width="150">Aktif</td>
					<td>:</td>
					<td>
						<select name="aktif" id="aktif">
							<option value="1">Aktif</option>
							<option value="0">Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td>
						<BUTTON type="button" onClick="if (ValidateForm('nama','ind')){document.form1.submit();}">
							<img src="../icon/save.gif" border="0" width="16" height="16" align="absmiddle">
							&nbsp;Simpan
						</BUTTON>
						<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'id*-**|*nama*-**|*tahun*-*<?=$thn?>*|*tgl_berlaku*-*<?=$tgl_d2?>*|*aktif*-*');">
							<IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">
							&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;
						</BUTTON>
					</td>
				</tr>
			</table>
		</form>
	</div><br/><br/>
	
	<div id="listma" style="display:block">
		<span class="jdltable">DAFTAR OBAT</span><br/><br/>
		<div align="right" style="width: 550px;">
			<button onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-**|*id*-**|*nama*-**|*tahun*-*<?=$thn?>*|*tgl_berlaku*-*<?=$tgl_d2?>*|*aktif*-*')" type="button">
				<img width="16" height="16" border="0" align="absmiddle" src="../icon/add.gif">
				Tambah
			</button>
		</div>
		<style type="text/css">
			#dataSD {
				border-collapse:collapse;
			}
			#dataSD td{
				border:1px solid #000;
				padding:3px;
			}
			#dataSD .noborder{
				border:0px;
			}
		</style>
		<table width="550" border="0" cellpadding="1" cellspacing="0" id="dataSD">
			<tr class="headtable">
				<td id="id" width="30" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
				<td class="tblheader" width="500" id="nama" onClick="ifPop.CallFr(this);">Sumber Dana</td>
				<td class="tblheader" width="500" id="tahun" onClick="ifPop.CallFr(this);">Tahun</td>
				<td class="tblheader" width="500" id="" onClick="ifPop.CallFr(this);">Tanggal Berlaku</td>
				<td class="tblheader" width="500" id="" onClick="ifPop.CallFr(this);">Berlaku</td>
				<td class="tblheader" width="500" id="" onClick="ifPop.CallFr(this);">Aktif</td>
				<td class="tblheader" width="20" colspan="2">Proses</td>
			</tr>
			<?php 
			if ($filter!=""){
				$tfilter=explode("*-*",$filter);
				$filter="";
				for ($k=0;$k<count($tfilter);$k++){
					$ifilter=explode("|",$tfilter[$k]);
					$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
				}
			}
			if ($sorting=="") $sorting=$defaultsort;
			$sql = "select * from (select id, nama, tahun, DATE_FORMAT(tgl_berlaku, '%d-%m-%Y') tgl_berlaku, berlaku, 
					IF(aktif=1,'Aktif','Tidak Aktif') aktif
					from a_sumber_dana) t1 where 1 ".$filter." ORDER BY ".$sorting;
			$rs=mysqli_query($konek,$sql);
			echo mysqli_error($konek);
			$jmldata=mysqli_num_rows($rs);
			if ($page=="") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";

			$rs=mysqli_query($konek,$sql);
			$i=($page-1)*$perpage;
			$arfvalue="";
			$jj = 1;
			while ($rows=mysqli_fetch_array($rs)){
				$i++;
				$tgl_berlaku = ($rows['tgl_berlaku']!="")?$rows['tgl_berlaku']:$tgl_d2;
				$arfvalue="act*-*edit*|*id*-*".$rows['id']."*|*nama*-*".$rows['nama']."*|*tahun*-*".$rows['tahun']."*|*tgl_berlaku*-*".$tgl_berlaku."*|*aktif*-*".$rows['aktif'];
				$arfvalue=str_replace('"',chr(3),$arfvalue);
				$arfvalue=str_replace("'",chr(5),$arfvalue);
				$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
				?>
				<input type="hidden" id="arf<?php echo $i; ?>" value="<?php echo $arfvalue; ?>" />
				<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
					<td ><?php echo $i; ?></td>
					<td align="left"><?php echo $rows['nama']; ?></td>
					<td align="center"><?php echo $rows['tahun']; ?></td>
					<td align="center"><?php echo $rows['tgl_berlaku']; ?></td>
					<td align="center"><input type="checkbox" onClick="setBerlaku(this.checked,<?=$rows['id']?>,<?=$jj?>)" id="setExp<?=$jj++?>" <?=($rows['berlaku']=='1')?'checked':''?> /></td>
					<td align="center"><?php echo $rows['aktif']; ?></td>
					<td width="22" colspan="2" >
						<img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block'; fSetValue(window,document.getElementById('arf<?php echo $i; ?>').value);">
					</td>
					<!--td width="22" >
						<img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'act*-*del*|*id*-*<?php echo $rows['id']; ?>');document.form1.submit();}">
					</td-->
				</tr>
				<?php 
			}
			mysqli_free_result($rs);
			?>
			<tr class="noborder">  
				<td colspan="8" class="noborder">
					<table width="100%">
						<tr>
							<td align="left" class="textpaging noborder">
								Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?>
							</td>
							<td align="right" class="noborder">
								<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
								<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
								<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>