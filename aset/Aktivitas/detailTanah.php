<?php
include '../sesi.php';
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
date_default_timezone_set("Asia/Jakarta");
$tgl1=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl1);
$bulan=$_REQUEST['bulan'];
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th[2];
//==========================================================

include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
        window.location='$def_loc';
        </script>";
}
$id_kib_seri = explode('|',$_GET['id_kib']);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST["act"];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
    if ($act=="Save") {
		$unit=$_POST['unit'];
		$seri=$_POST['seri'];
        $lokasi=$_POST['lokasi'];
		$namabarang=$_POST['idbarang'];
		$asal=$_POST['asal'];
		$almt=$_POST['almt'];
		$luas=$_POST['luas'];
		$seri=$_POST['noseri'];
		$hakTanah=$_POST['hakTanah'];
		$tglsert=$_POST['tglsert'];
		$tglsert=explode('-',$tglsert);
		$tglsert=$tglsert[2]."-".$tglsert[1]."-".$tglsert['0'];
		$nosert=$_POST['nosert'];
		$pengguna=$_POST['pengguna'];
		$ket=$_POST['ket'];
		$ta=$_POST['ta'];
		$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Kib Tanah','UPDATE as_seri2 SET  idbarang=$namabarang, asalusul=$asal, noseri=$seri, thn_pengadaan=$ta WHERE idseri=$id_kib_seri[0]','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns);
		$query = "UPDATE as_seri2 SET  idbarang='$namabarang', asalusul='$asal', noseri='$seri', thn_pengadaan='$ta' WHERE idseri='$id_kib_seri[0]'";
		$rs = mysql_query($query);
		$res2 = mysql_affected_rows();
		$sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Kib Tanah','UPDATE kib01 SET luas=$luas, alamat=$almt, hak_tanah=$hakTanah, sertifikat_tgl=$tglsert, sertifikat_no=$nosert, penggunaan=$pengguna, ket=$ket WHERE idseri=$id_kib_seri[0]','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns1);
		$query = "UPDATE kib01 SET luas='$luas', alamat='$almt', hak_tanah='$hakTanah', sertifikat_tgl='$tglsert', sertifikat_no='$nosert', penggunaan='$pengguna', ket='$ket' WHERE idseri='$id_kib_seri[0]'";

$rs = mysql_query($query);
        $res = mysql_affected_rows();
        if($res2 >= 0) {
            echo "<script>
                alert('Berhasil mengubah data.');
                window.location = 'tanah.php';
                </script>";
        }
        else {
            echo "<script>
                alert('Terdapat kesalahan. $res');
                </script>";
        }
    }
	  else if($act == 'Delete') {
        $query = "delete from as_seri2 where idseri = ".$id_kib_seri[0];
		$rs = mysql_query($query);
        $query="delete from kib01 where idseri = ".$id_kib_seri[0];
        $rs = mysql_query($query);
        $res = mysql_affected_rows();
        if($res >=0) {
            echo "<script>
                alert('Berhasil menghapus data.');
                window.location = 'tanah.php';
                </script>";
        }else {
            echo "<script>
                alert('Terdapat kesalahan. $res');
                </script>";
        }
    }
}

?>
<?php
$barang_opener="par=idbarang*kodebarang*namabarang";
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
		<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <title>KIB Tanah</title>
    </head>

    <body>
        <div align="center">
            <?php
			//include('baranglist_tanah.php');
            include("../header.php");
            $act = $_GET['act'];
            if($act == 'edit') {
                $vis_view = 'none';
                $vis_edit = '';
            }
            else {
                $vis_view = '';
                $vis_edit = 'none';
            }
            $par = "?act=$act";
            if(isset($id_kib_seri[0]) && $id_kib_seri[0] != '') {
                $par .= "&id_kib=$id_kib_seri[0]";
            }

        $sqltnh = "SELECT
					u.kodeunit,
					u.namaunit,
					s.ms_idunit,
					s.ms_idlokasi,
					s.idbarang,
					b.kodebarang,
					b.namabarang,
					s.noseri,
					s.asalusul,
					l.namalokasi,
					k.luas,
					k.alamat,
					k.hak_tanah,
					k.sertifikat_tgl,
					k.sertifikat_no,
					k.penggunaan,
					k.ket,
					s.thn_pengadaan
				  FROM as_seri2 s
					INNER JOIN as_ms_barang b
					  ON s.idbarang = b.idbarang
					LEFT JOIN as_ms_unit u
					  ON s.ms_idunit = u.idunit
					left JOIN as_lokasi l
					  ON s.ms_idlokasi = l.idlokasi
					INNER JOIN kib01 k
					  ON s.idseri = k.idseri
                    WHERE k.idseri = '".$id_kib_seri[0]."' and s.idseri = '".$id_kib_seri[0]."'";
            $dttnh = mysql_query($sqltnh);
            $rwtnh = mysql_fetch_array($dttnh);
            ?>
            <div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>

  </tr>
  <tr>
<td align="center">
            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr>
                    <td height="30" colspan="2" valign="bottom" align="right">
                        <button class="Enabledbutton" id="backbutton" onClick="backTo()" title="Back" style="cursor:pointer">
                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Back to List
                        </button>
                        <button class="EnabledButton" id="editButton" name="editButton" onClick="action(this.title)" title="Edit" style="cursor:pointer"><!--location='editMesin.php?id_kib=<-?php echo $id_kib_seri[0];?>'-->
                            <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Edit Record
                        </button>
                        <button class="DisabledButton" id="saveButton" onClick="action(this.title)" title="Save" style="display: none;cursor:pointer">
                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Save Record
                        </button>
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailTanah.php<?php echo $par?>'" title="Cancel / Refresh" style="cursor:pointer">
                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Undo/Refresh
                        </button>
                        
                    </td>
                </tr>
            </table>
            <div id="div_view" style="display: <?php echo $vis_view;?>">
                <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Tanah - Detail :.</td>
                    </tr>
                    <tr>
                        <td width="40%" class="label">&nbsp;Unit Kerja</td>
                        <td width="60%" class="content">&nbsp; <?php echo $rwtnh['kodeunit']; ?> &nbsp;-&nbsp;
                            <?php echo $rwtnh['namaunit'];?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang - Seri</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['kodebarang']?>&nbsp;&nbsp;-&nbsp;<?php echo str_pad($rwtnh['noseri'],4,"0",STR_PAD_LEFT); ?></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['namabarang'];?>                        </td>
                    </tr>
					<tr>
						<td class="label">&nbsp;Asal Barang</td>
						<td class="content">&nbsp; <?php echo $rwtnh['asalusul'] ?></td>
					</tr>
					<tr>
						<td class="label">&nbsp;Lokasi</td>
						<td class="content">&nbsp; <?php echo $rwtnh['alamat'] ?></td>
					</tr>
					<tr>
						<td class="label">&nbsp;Luas Tanah</td>
						<td class="content">&nbsp; <?php echo $rwtnh['luas'] ?> M2</td>
					</tr>
					
                    <tr>
                        <td class="label">&nbsp;Hak Tanah</td>
                        <td class="content">&nbsp;
							<?php
							$hak=array('HPK'=>'Hak Pakai','HPH'=>'Hak Pengelolahan');
							 echo $hak[$rwtnh['hak_tanah']];?>                        </td>
                    </tr>
                    <tr>
						<td class="label">&nbsp;Sertifikat Tgl</td>
						<td class="content">&nbsp; <?php echo $rwtnh['sertifikat_tgl'] ?></td>
					</tr>
					<tr>
						<td class="label">&nbsp;No Sertifikat</td>
						<td class="content">&nbsp; <?php echo $rwtnh['sertifikat_no'] ?></td>
					</tr>
					<tr>
						<td class="label">&nbsp;Penggunaan</td>
						<td class="content">&nbsp; <?php echo $rwtnh['penggunaan'] ?></td>
					</tr>
					<tr>
						<td class="label">&nbsp;Keterangan</td>
						<td class="content">&nbsp;<?php echo $rwtnh['ket'] ?></td>
					</tr>
                    <tr>
                        <td class="label">&nbsp;Tahun Pengadaan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwtnh['thn_pengadaan'];?>                        </td>
                    </tr>
                </table>
          </div>
            <div id="div_edit" style="display: <?php echo $vis_edit;?>;">
                <form id="form1" name="form1" action="" method="post">
                    <table width="650" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                        <tr>
                            <td height="25" colspan="3" align="center" class="header">
                                .: Kartu Inventaris Barang : Tanah - Detail :.                            </td>
                        </tr>
                        <tr>
                            <td class="label">Unit</td>
                            <td width="504" class="content"><input type="text" id="kdunit" class="txtunedited" name="kdunit" readonly size="15" value="<?php echo $rwtnh['kodeunit'] ?>">&nbsp;-&nbsp;<input type="text" id="unit" name="unit" class="txtunedited" readonly size="20" value="<?php echo $rwtnh['namaunit'] ?>"></td>
                        </tr>
                        <tr>
                            <td width="134" class="label">Kode Barang</td>
                          <td colspan="2" class="content"><input type="text" id="kodebarang" class="txtunedited" size="15" name="kodebarang" readonly value="<?php echo $rwtnh['kodebarang'] ?>"> </td></tr>
                        <tr>
                            <td class="label"> Nama Barang </td>
							
                            <td class="content"><input id="idbarang" type="hidden" name="idbarang" value="<?php echo $rwtnh['idbarang'] ?>"><input type="text" id="namabarang" name="namabarang" value="<?php echo $rwtnh['namabarang']?>" class="txtunedited" size="50">&nbsp;<img alt="tree" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('tanah_barang_tree.php?<?php echo $barang_opener; ?>',800,500,'msma',true)"> </td>
                        </tr>
						<tr>
							<td class="label">&nbsp;No Seri</td>
							<td class="content"><input type="text" id="noseri" name="noseri" class="txtunedited" size="20" value="<?php echo  $rwtnh['noseri']?>"></td>
						</tr>
						<tr>
							<td class="label">Asal Barang</td>
							<td class="content"><select id="asal" name="asal" class="txt">
						<?php 
						$sql=mysql_query("select keterangan from as_ms_jenistransaksi order by nourut");
						while($rwasal=mysql_fetch_array($sql)){
						?>
						<option value="<?php echo $rwasal['keterangan'] ?>"<?php if($asal==$rwasal['keterangan']) echo 'selected'?>><?php echo $rwasal['keterangan'] ?></option>
						<?php } ?>
						</select></td>
						</tr>
                       <tr>
					   		<td class="label">Lokasi</td>
					   		<td class="content"><input type="text" id="almt" name="almt" class="txtunedited" size="70" value="<?php echo $rwtnh["alamat"]; ?>"></td>
					   </tr>
					   <tr>
					   		<td class="label">Luas Tanah</td>
							<td class="content"><input type="text" id="luas" name="luas" size="20" class="txtunedited" value="<?php echo $rwtnh['luas'] ?>"> M2</td>
					   </tr>
					   <tr>
					   		<td class="label">Hak Tanah</td>
					   		<td class="content"><select id="hakTanah" name="hakTanah" class="txt">
							<option value="HPK" <?php if($hakTanah=='HPK') echo 'selected' ?>>Hak Pakai</option>
							<option value="HPH" <?php if($hakTanah=='HPH') echo 'selected' ?>>Hak Pengelolahan</option>
							</select></td>
					   </tr>
					   <tr>
					   		<td class="label">Sertifikat Tgl</td>
					   		<td class="content"><input type="text" id="tglsert" name="tglsert" class="txt" size="20" value="<?php echo date("d-m-Y",strtotime($rwtnh["sertifikattgl"])); ?>">
							<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsert'),depRange);" />
                                <font color="#666666"><em>(dd-mm-yyyy)</em></font> <input type="button" id="tglReset" name="tglReset" value="Reset Tgl" onClick="resettgl()"></td>
					   </tr>
					   <tr>
							<td class="label">No Serifikat</td>
							<td class="content"><input type="text" id="nosert" name="nosert" class="txtunedited" size="20" value="<?php echo $rwtnh['sertifikat_no'] ?>"></td>
					   </tr>
					   <tr>
							<td class="label">Penggunaan</td>
							<td class="content"><input type="text" id="pengguna" name="pengguna" size="20" class="txtunedited" value="<?php echo $rwtnh['penggunaan'] ?>"></td>
					   </tr>
					   <tr>
					   		<td class="label">Keterangan</td>
							<td class="content"><input type="text" id="ket" name="ket" class="txtunedited" size="50" value="<?php echo $rwtnh['ket'] ?>"></td>
					   </tr>
                        <tr>
                            <td valign="top" class="label">Tahun Pengadaan </td>
                            <td class="content"><input type="text" id="ta" name="ta" class="txtunedited" value="<?php echo $rwtnh['thn_pengadaan'] ?>" size="10"></td>
                        </tr>
						<input type="hidden" id="act" name="act" />
                    </table>
              </form>
            </div>
            <table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
        </div>
    </body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <script type="text/javascript" language="javascript">
	function resettgl(){
	document.getElementById('tglsert').value='';
	//alert('aaa');
	}
        var arrRange=depRange=[];
        function action(choose){
            switch(choose){
                case 'Edit':
                    document.getElementById('undobutton').disabled = false;
                    //document.getElementById('deleteButton').disabled = true;
                    document.getElementById('div_view').style.display = 'none';
                    document.getElementById('div_edit').style.display = '';
                    document.getElementById('saveButton').style.display = '';
                    document.getElementById('editButton').style.display = 'none';
                    break;
                case 'Delete':
                    if(confirm("Yakin akan menghapus data ini?")){
                        document.getElementById('act').value = choose;
                        document.getElementById('form1').submit();
                    }
                    break;
                case 'Save':
                    document.getElementById('act').value = choose;
                    document.getElementById('form1').submit();
                    break;
            }
        }
        function backTo(){
            if('<?php echo $_REQUEST['from']?>' == '')
            {
                location='tanah.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
        
    </script>
</html>
