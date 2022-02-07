<?php
include '../sesi.php';
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
	$id = $_GET['id'];

	
	$idseri = $_POST['idseri'];
	$nilai_awal = $_POST['nilai_awal'];
	$nilai_perubahan = $_POST['nilai_perubahan'];
	$nilai_akhir = $_POST['nilai_akhir'];
	$tk = $_POST['tk'];
	$jns = $_POST['jns'];
	$dc = $_POST['dc'];
	$ket = $_POST['ket'];
	$tgl = tglSQL($_POST['tgl']);
	$peng = explode("-",$tgl);
	$user = $_SESSION['id_user'];
	$ip = $_SERVER["REMOTE_ADDR"];
	$act = $_POST['act'];
if($act=='add'){
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Nilai Detil','insert into as_nilai values('',$idseri,$nilai_awal,$nilai_perubahan,$nilai_akhir,$tgl,$tk,$jns,$ket,$dc,$user,$ip,sysdate())','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns);
	
	$sql = "insert into as_nilai values('','$idseri','$nilai_awal','$nilai_perubahan','$nilai_akhir','$tgl','$tk','$jns','$ket','$dc','$user','$ip',sysdate())";
	$r = mysql_query($sql);
	$sql1 = "update as_seri2 set nilaibuku = '$nilai_akhir' where idseri = '$idseri'";
	mysql_query($sql1);
	if($r){
		echo "<script>alert('data berhasil di inputkan');window.location='nilai_dt.php'</script>";
	}else{
	echo "<script>alert('data gagal Diinputkan');</script>";
	}
	}else if($act=='edit'){
	
	$sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Nilai Detil','update as_nilai set 
	idseri = $idseri,nilai_awal=$nilai_awal,nilai_perubahan=$nilai_perubahan,nilai_akhir = $nilai_akhir,tgl_perubahan=$tgl,TK=$tk,jenis=$jns,keterangan=$ket,dokumen=$dc,update_by=$user,update_from=$ip where id=$id','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns1);
	
	$sql = "update as_nilai set 
	idseri = '$idseri',
	nilai_awal='$nilai_awal',
	nilai_perubahan='$nilai_perubahan',
	nilai_akhir = '$nilai_akhir',
	tgl_perubahan='$tgl',
	TK='$tk',
	jenis='$jns',
	keterangan='$ket',
	dokumen='$dc',
	update_by='$user',
	update_from='$ip'
	where id='$id'";
	$qw = mysql_query($sql);
	$sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Nilai Buku as_seri2','update as_seri2 set nilaibuku = $nilai_akhir where idseri = $idseri','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns1);
	$sql1 = "update as_seri2 set nilaibuku = '$nilai_akhir' where idseri = '$idseri'";
	$qw = mysql_query($sql1);
	//tre
	if($qw){
		echo "<script>alert('data berhasil dirubah');window.location='nilai_detail.php?act=edit&id=$id'</script>";
	}else{
		echo "<script>alert('data gagal dirubah');</script>";
	}
	}
	
	
	$act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $par .= "&id=$id";
                $query = "select * from as_nilai a inner join as_ms_barang b on a.idseri=b.idbarang and a.id  = '".$id."'";
                $rs = mysql_query($query);
                $row = mysql_fetch_array($rs);
            }
?>

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Detail Perubahan Nilai</title>
    </head>

    <body onLoad="setValEdit()">
        <div align="center">
            <?php
            include("../header.php");
            
            ?>
			<script>
			var arrRange=depRange=[];
			</script>
            <div align="center">
			<iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='nilai_dt.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='nilai_detail.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" height="28" class="header">.: Data Perubahan Nilai :.</td>
                                </tr>
                                <form action="" id="form1" name="form1" method="post" onSubmit="return ValidateForm('idseri,namabarang)">
                                    <tr>
                                        <td width="25%" height="20" class="label">&nbsp;Nama Barang</td>
                                        <td width="75%" class="content">&nbsp;
                                            <input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
											<input type="hidden" name="idseri" id="idseri" value="<?php echo $idbarang;?>" />
                                            <input name="namabarang" type="text" size="50" class="txtmustfilled" id="namabarang" value="<?php echo $rows["namabarang"]; ?>" maxlength="10" style="text-transform:uppercase;" />
                                        &nbsp;
										<input type="button" value="Pilih barang" onClick="OpenWnd('nilai_brgGrid.php?<?php echo $qstr_ma_sak; ?>',800,400,'msma',true)" />
										</td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Nilai</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nilai Awal</td>
                                        <td class="content">&nbsp;
                                            <input name="nilai_awal" type="text" onKeyUp="sum()" class="txt" id="nilai_awal" value="<?php echo $rows["nilai_awal"]; ?>" size="20" maxlength="100" />
                                            
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nilai Perubahan</td>
                                        <td class="content">&nbsp;
                                            <input name="nilai_perubahan" type="text" onKeyUp="sum()" class="txt" id="nilai_perubahan" value="<?php echo $rows["nilai_perubahan"]; ?>" size="20" maxlength="15" />
                                            
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nilai Akhir</td>
                                        <td class="content">&nbsp;
                                            <input name="nilai_akhir" type="text" class="txt" id="nilai_akhir" value="<?php echo $rows["nilai_akhir"]; ?>" size="20" maxlength="15" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Detail Keterangan</td>
                                    </tr>
									<tr>
                                        <td height="20" class="label">&nbsp;Tanggal Perubahan</td>
                                        <td class="content">&nbsp;
                                           <input name="tgl" type="text" class="txtmustfilled" id="tgl" tabindex="4" value="<?php echo date('d-m-Y'); ?>" size="25" maxlength="15" readonly/>
                                                        <img alt="calender" style="cursor:pointer" height="17"  width="17" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);">
										   </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Jenis T/K</td>
                                        <td class="content">&nbsp;
                                           <select class="txt" name="tk" id="tk">
										   <option value="t">T</option>
										   <option value="k">K</option>
										   </select>
										   </td>
                                    </tr>
									<tr>
                                        <td height="20" class="label">&nbsp;Jenis Perubahan</td>
                                        <td class="content">&nbsp;
                                           <select class="txt" name="jns" id="jns">
										   <option value="1">Perbaikan</option>
										   <option value="2">Penyusutan</option>
										   <option value="3">Penghapusan</option>
										   </select>
										   </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Dokumen</td>
                                        <td class="content">&nbsp;
                                            <textarea id="dc" name="dc" class="txt" style="width:300px"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Keterangan</td>
                                        <td class="content">&nbsp;
                                            <textarea id="ket" name="ket" class="txt" style="width:300px"></textarea>
                                        </td>
                                    </tr>
                                </form>
                                <tr>
                                    <td colspan="2" class="header2">&nbsp;</td>
                                </tr>
                            </table>
                            <?php
                            include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
	<script>
	
		function setValEdit(){
			document.getElementById("idseri").value = '<?=$row['idseri'];?>';
			document.getElementById("namabarang").value = '<? echo $row['namabarang'];?>';
			document.getElementById("nilai_awal").value = '<?=$row['nilai_awal'];?>';
			document.getElementById("nilai_perubahan").value = '<?=$row['nilai_perubahan'];?>';
			document.getElementById("nilai_akhir").value = '<?=$row['nilai_akhir'];?>';
			document.getElementById("tk").value = '<?=$row['TK'];?>';
			document.getElementById("jns").value = '<?=$row['jenis'];?>';
			document.getElementById("dc").value = '<?=$row['dokumen'];?>';
			document.getElementById("ket").value = '<?=$row['keterangan'];?>';
			document.getElementById("tgl").value = '<?=tglSQL($row['tgl_perubahan']); ?>';
		}
		function setNilai(a){
			var a = a.split("|");
			document.getElementById("idseri").value = a[0];
			document.getElementById("namabarang").value = a[2];
		}
		//var b =0;
		function sum(){
		
		var b = parseInt(document.getElementById("nilai_awal").value)+parseInt(document.getElementById("nilai_perubahan").value);
		//alert(b);
		if(b*0!=0) b=0;
		document.getElementById("nilai_akhir").value = b;
		}
		function save(){
			form1.submit();
		}
	</script>