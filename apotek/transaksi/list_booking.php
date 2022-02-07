<?php 
session_start();
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
/* $tgltrans1=$_REQUEST["tgltrans"];
$tgltrans=explode("-",$tgltrans1);
$thtr=$tgltrans[2];
$tgltrans=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0]; */
$tgltrans1 = ($_REQUEST["tgltrans1"])?$_REQUEST["tgltrans1"]:$tgl;
$tgltrans2 = ($_REQUEST["tgltrans2"])?$_REQUEST["tgltrans2"]:$tgl;
$ftgl = "AND t1.tgl BETWEEN '{$tgltrans1}' AND '{$tgltrans2}'";


//======================Tanggalan==========================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t1.tgl_act DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act = $_REQUEST['act']; // Jenis Aksi
$bookID = $_REQUEST['bookID'];
$unitID = ($_REQUEST['unitID']=='')? $idunit : $_REQUEST['unitID'];
//echo $unitID;
switch($act){
	case "hapus":
		$sLog = "INSERT INTO dbapotek.a_booking_obat_log
					(bookID, no_kunjungan, nama_pasien, obat_id, qty, detail, tgltrans, user_act, tgl_act, unit_id, user_del, tgl_del)
				SELECT bookID, no_kunjungan, nama_pasien, obat_id, qty, detail, tgltrans, user_act, tgl_act, unit_id, '".$_SESSION["iduser"]."', NOW()
				FROM dbapotek.a_booking_obat
				WHERE bookId = '{$bookID}'";
		$qLog = mysqli_query($konek,$sLog);
		
		$sql = "DELETE
				FROM a_booking_obat
				WHERE bookID = '{$bookID}'";
		mysqli_query($konek,$sql);
		//echo $sql;
		if (mysqli_errno()>0){
			echo "<script type='text/javascript'>alert(\"Data gagal dihapus! (".mysqli_error($konek).")\")</script>";
		} else {
			echo "<script type='text/javascript'>alert('Data berhasil dihapus!')</script>";
		}
		break;
}

?>
<style type="text/css">
	#list_booking{
		font-size:12px;
		margin-top:10px;
		max-width:98.5%;
		display:block;
		padding:5px;
	}
	#list_booking table{
		border-collapse:collapse;
	}
	#list_booking table td{
		border:1px solid #000;
		padding:5px;
	}
	#list_booking table .noborder{
		border:0px;
	}
	#list_booking h1{
		font-size:16px;
	}
	#formB{
		text-align:left;
		display:block;
		width:89%;
		margin-bottom:10px;
	}
	#labelB{
		width:120px;
		padding-right:10px;
		display:inline-block;
	}
</style>
<script type="text/javascript">
	var arrRange=depRange=[];
	
	function hapusBook(idBook){
		document.forms[0].bookID.value = idBook;
		document.forms[0].act.value = "hapus";
		if(confirm('Yakin data akan dihapus?')){
			//alert(document.forms[0].bookID.value);
			document.forms[0].submit();
		} else {
			document.forms[0].bookID.value = '';
			document.forms[0].act.value = '';
		}
	}
	
	function lihatB(){
		document.forms[0].bookID.value = '';
		document.forms[0].act.value = '';
		document.forms[0].page.value = '';
		document.forms[0].filter.value = '';
		document.forms[0].sorting.value = '';
		document.forms[0].submit();
	}
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
<div id="list_booking">
	<h1>Daftar Booking Penjualan Obat</h1>
	<form name="form1" method="post" action="">
		<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
		<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
		<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
		<input type="hidden" id="bookID" name="bookID" value="<?php echo $rows['bookID']?>" />
		<input type="hidden" id="act" name="act" />
		<div id="formB">
			<div id="labelB">Unit</div>:
			<?php
				if($idunit == 1){
					$disable = "";
				} else {
					$disable = "disabled";
				}
			?>
			<select name="unitID" id="unitID" <?php echo $disable;?> >
				<?php
					$sunit = "select UNIT_ID, UNIT_NAME from a_unit where UNIT_TIPE = 2 AND UNIT_ISAKTIF = 1";
					//echo $sunit;
					$qunit = mysqli_query($konek,$sunit);
					while($dunit = mysqli_fetch_object($qunit)){
						if($unitID == $dunit->UNIT_ID){
							$select = "selected";
						} else {
							$select = "";
						}
						echo "<option value='".$dunit->UNIT_ID."' {$select} >".$dunit->UNIT_NAME."</option>";
						$select = "";
					}
				?>
			</select>
			<br />
			<!--div id="labelB">Rentang Waktu</div>: 
			<input name="tgltrans1" type="text" id="tgltrans1" size="11" maxlength="10" value="<?php //echo $tgltrans1;?>" class="txtcenter" readonly="true" />
			<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgltrans1,depRange);" /> 
			s/d 
			<input name="tgltrans2" type="text" id="tgltrans2" size="11" maxlength="10" value="<?php //echo $tgltrans2;?>" class="txtcenter" readonly="true" />
			<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgltrans2,depRange);" /> 
			<br />
			<div id="labelB" style="color:#D7E4EE;">Proses</div> <button style="margin-top:5px; margin-left:4px;" name="lihatB" id="lihatB" onclick="lihatB();">Lihat Data</button-->
		</div>
		<table style="width:90%;">
			<tr class="headtable"> 
				<td width="30" height="25" class="tblheaderkiri">No</td>
				<td id="tgl_act" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
				<td id="nama" width="140" class="tblheader" onClick="ifPop.CallFr(this);">Nama Pasien</td>
				<td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Obat</td>
				<td id="OBAT_NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
				<td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">QTY</td>
				<td width="100" class="tblheader" id="UNIT_NAME" onClick="ifPop.CallFr(this);">Unit</td>
				<td width="80" class="tblheader" id="username" onClick="ifPop.CallFr(this);">Petugas</td>
				<!--td id="" width="60" class="tblheader" onClick="">Status</td-->
				<!--td class="tblheader" width="30">Proses</td-->
			</tr>
			<?php
				if ($filter!=""){
					$filter=explode("|",$filter);
					$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
				}
				if ($sorting=="") $sorting=$defaultsort;
				if($unitID){
					$funit = "AND t1.unit_id = {$unitID}";
				}
				$sql = "SELECT * 
						FROM
						  (SELECT 
							bo.bookID, /*IFNULL(mp.nama, */bo.nama_pasien/*)*/ nama, bo.no_kunjungan, o.OBAT_KODE, o.OBAT_NAMA, bo.obat_id,
							bo.qty, /*IFNULL(mp.nama, 1) stat,*/ bo.tgltrans, DATE_FORMAT(bo.tgl_act, '%d-%m-%Y %H:%i:%s') tgl_act, DATE_FORMAT(bo.tgl_act, '%d-%m-%Y') tgl, bo.user_act, peg.username,
							bo.unit_id, u.UNIT_NAME
						  FROM
							a_booking_obat bo 
							INNER JOIN a_obat o 
							  ON o.OBAT_ID = bo.obat_id 
							/*LEFT JOIN billing.b_pelayanan p 
							  ON p.id = bo.no_kunjungan 
							LEFT JOIN billing.b_ms_pasien mp 
							  ON mp.id = p.pasien_id */
							LEFT JOIN a_user peg 
							  ON peg.kode_user = bo.user_act
							INNER JOIN a_unit u
							  ON u.UNIT_ID = bo.unit_id) AS t1
						WHERE 0=0 {$funit} {$filter} /* {$ftgl} */
						ORDER BY {$sorting}";
			//	echo $sql."<br>";
				
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
				$i=($page-1)*$perpage;
				while ($rows=mysqli_fetch_array($rs)){
					$i++;
			?>
			<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
				<td class="tdisikiri"><?php echo $i; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['tgl_act']; ?></td>
				<td class="tdisi" align="left"><?php echo $rows['nama']; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
				<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['username']; ?></td>
				<!--td class="tdisi" align="center"><?php //echo ($rows['stat']==1)? "Bukan Pasien RS" : "Pasien RS"; ?></td-->
				<!--td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik untuk menghapus list booking" onClick="hapusBook('<?php //echo $rows['bookID']?>')"></td-->
			</tr>
			<?php
				}
			?>
			<tr> 
				<td colspan="5" align="left" class="noborder">
					<div align="left" class="textpaging">
						&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?>
					</div>
				</td>
				<td colspan="5" align="right" class="noborder"> 
					<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
					<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
					<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
					<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
				</td>
			</tr>
		</table>
	</form>
</div>