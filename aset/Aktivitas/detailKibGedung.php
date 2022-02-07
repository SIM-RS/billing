<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
include("../koneksi/konek.php");
$idseri = $_GET["id_kib"];
$barang_opener="par=idbarang*kodebarang*namabarang";
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =   $_SERVER['REMOTE_ADDR'];

    switch($act) {
        case 'Save':
          
            $idbarang           = $_POST["idbarang"];
            $lokasi           	= $_POST["lokasi"];
            $noseri         	= $_POST["noseri"]; 
            $kond      			= $_POST["kond"];
            $bertingkat         = $_POST["bertingkat"];
            $beton         		= $_POST["beton"];    
            $luas_lantai        = $_POST["luas_lantai"];    
            $tglsert            = $_POST["tglsert"];
			$tglsert=explode('-',$tglsert);
			$tglsert=$tglsert[2]."-".$tglsert[1]."-".$tglsert['0'];
            $no_dok           	= $_POST["no"];
            $luas_tanah    		= $_POST["luas_tanah"];
            $status_tanah       = $_POST["status_tanah"];
			$kode_tanah         = $_POST["kode_tanah"];
            $cara_perolehan     = $_POST["cara_perolehan"];
            $harga         		= $_POST["harga"]; 
            $ket      			= $_POST["ket"];
            
            
            $query =    "update as_seri2 set idbarang='$idbarang', noseri='$noseri',asalusul='$cara_perolehan', kondisi='$kond', harga_perolehan='$harga' where idseri='$idseri'";
            $rs = mysql_query($query);
            $res = mysql_affected_rows();
            
            if($res >= 0) {
               $query = "update kib03 set bertingkat='$bertingkat', beton='$beton', luas_lantai='$luas_lantai', alamat='$lokasi', 
						  dok_tgl='$tglsert', dok_no='$no_dok', status_hak='$status_tanah', luas_tanah='$luas_tanah', kode_tanah='$kode_tanah', ket='$ket' where idseri='$idseri' ";
                $rs = mysql_query($query);
                $res = mysql_affected_rows()+$res;
                if($res > 0) {
                    $hasil = 'Data berhasil diubah.';
                }
                else if($res == 0){
                    $hasil = 'Data tidak ada yang berubah.';
                }
                else{
                    $hasil = 'Data gagal diubah, periksa kembali input anda.';
                }
                echo "<script>alert('$hasil');</script>";
            }
            break;
        case 'Delete':
            $query = "delete from as_seri where idseri = ".$id_kib_seri[1];
        
            $rs = mysql_query($query);
            $res = mysql_affected_rows();
            if($res > 0) {
                echo "<script>alert('Data berhasil dihapus.');
                        window.location='gedung_data.php';
                </script>";
            }
            else {
                echo "<script>alert('Data gagal dihapus, coba periksa ulang data anda$res.');
                </script>";
            }
            break;
    }
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>KIB Alat/Mesin</title>
    </head>

    <body>
        <div align="center">
            <?php
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
            if(isset($idseri ) && $idseri != '') {
                $par .= "&id_kib=$idseri ";
            }
            
           $sqlmsn = "SELECT kib03.*,
					as_ms_barang.namabarang,as_ms_barang.kodebarang,as_ms_barang.tipe,
					as_seri2.noseri,as_seri2.kondisi,as_seri2.harga_perolehan,as_seri2.asalusul,
					as_ms_unit.namaunit,as_ms_unit.kodeunit,as_ms_barang.idbarang,
					as_lokasi.namalokasi
					FROM as_seri2
					INNER JOIN kib03 ON kib03.idseri = as_seri2.idseri
					INNER JOIN as_ms_barang ON as_ms_barang.idbarang = as_seri2.idbarang
					LEFT JOIN as_ms_unit ON as_ms_unit.idunit = as_seri2.ms_idunit
					left JOIN as_lokasi ON as_lokasi.idlokasi = as_seri2.ms_idlokasi
					WHERE as_seri2.idseri = $idseri 
					AND as_ms_barang.tipe=1 
					AND as_ms_barang.kodebarang LIKE '03%'";
            $dtmsn = mysql_query($sqlmsn);
            $rwmsn = mysql_fetch_array($dtmsn);
			$beton=$rwmsn['beton'];
			$bertingkat=$rwmsn['bertingkat'];
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
                        <button class="Enabledbutton" id="backbutton" onClick="backTo();" title="Back" style="cursor:pointer">
                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Back to List
                        </button>
                        <button class="EnabledButton" id="editButton" name="editButton" onClick="action(this.title)" title="Edit" style="cursor:pointer">
                            <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Edit Record
                        </button>
                        <button class="DisabledButton" id="saveButton" onClick="action(this.title)" title="Save" style="display: none;cursor:pointer">
                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Save Record
                        </button>
                        <button class="Disabledbutton" id="undobutton" disabled onClick="location='detailKibGedung.php<?php echo $par; ?>'" title="Cancel / Refresh" style="cursor:pointer">
                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                            Undo/Refresh
                        </button>

                    </td>
                </tr>
            </table>
            <div id="div_view" align="center" style="display: <?php echo $vis_view;?>">
                <table width="625" id="table_view" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Gedung dan Tanah - Detail :.</td>
                    </tr>
                    <tr>
                        <td width="127" class="label">&nbsp;Kode Barang</td>
                        <td width="490" class="content">&nbsp;
                            <?php echo $rwmsn['kodebarang'];?>                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn['namabarang'];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No Seri</td>
                        <td class="content">&nbsp;
                            <?php echo str_pad($rwmsn['noseri'],4,"0",STR_PAD_LEFT);?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rwmsn["kondisi"]) {
                                case B : echo "Baik";
                                    break;
                                case KB : echo "Kurang Baik";
                                    break;
                                case RB : echo "Rusak Berat";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="label">&nbsp;Kontruksi</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rwmsn["bertingkat"]) {
                                case '0' : echo "Tidak Bertingkat";
                                    break;
                                case '1' : echo "Bertingkat";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Beton</td>
                        <td class="content">&nbsp;
                            <?php
                            switch ($rwmsn["beton"]) {
                                case '0' : echo "Tidak Beton";
                                    break;
                                case '1' : echo "Beton";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lantai(M2)</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["luas_lantai"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Alamat</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["alamat"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dokumen Tanggal</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["dok_tgl"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dokumen No</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["dok_no"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Tanah(M2)</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["luas_tanah"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Status Tanah</td>
                        <td class="content">&nbsp;
                           <?php echo $rwmsn["status_hak"];?>
                        </td>
                    </tr>
                     <tr>
                        <td class="label">&nbsp;Kode Tanah</td>
                        <td class="content">&nbsp;
                           <?php echo $rwmsn["luas_tanah"];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn["asalusul"];?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga Perolehan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn['harga_perolehan'];?>
                        </td>
                    </tr>
                    <tr>
                         <td class="label">&nbsp;Keterangan</td>
                        <td class="content">&nbsp;
                            <?php echo $rwmsn['ket'];?>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div id="div_edit" align="center" style="display: <?php echo $vis_edit;?>">
                <form name="form1" id="form1" action="" method="post">
                    <input name="act" id="act" type="hidden" />
                    <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                       <tr>
                        <td colspan="2" class="header">.: Kartu Inventaris Barang : Gedung dan Tanah - Detail :.</td>
                    </tr>
					<tr>
						<td class="label">&nbsp;Unit Kerja</td>
						<td class="content" colspan="2">&nbsp;
						<input type="text" id="kodeunit" name="kodeunit" size="25" class="txtunedited" readonly="true" value="<?php echo $rwmsn['kodeunit'] ?>">
						&nbsp;-&nbsp;<input type="text" id="namaunit" name="namaunit" class="txtunedited" readonly="true" size="50" value="<?php echo $rwmsn['namaunit'] ?>"></td>
					</tr>
                    <tr>
                        <td class="label">&nbsp;Kode Barang</td>
                        <td class="content">&nbsp;
                        <input id="kodebarang" name="kodebarang" class="txtunedited" readonly value="<?php echo $rwmsn['kodebarang'];?>" size="24" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Nama Barang</td>
                        <td class="content">&nbsp;
                        	<input name="idbarang" type="hidden" id="idbarang" value="<?php echo $rwmsn["idbarang"];?>">
                        	<input name="namabarang" type="text" class="txtunedited" readonly id="namabarang" value="<?php echo  $rwmsn["namabarang"]; ?>" size="50" maxlength="50" >
                            <img alt="tree" title='Struktur tree kode barang' style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('tree_kibgedung.php?<?php echo $barang_opener; ?>',800,500,'msma',true)"> 
                        </td>
                    </tr>
					<tr>
                        <td class="label">&nbsp;Lokasi/Alamat</td>
                        <td class="content">&nbsp;
                            <input type="text" id="lokasi" name="lokasi" class="txtunedited" size="70" value="<?php echo $rwmsn['alamat'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;No Seri</td>
                        <td class="content">&nbsp; <input type="text" id="noseri" name="noseri"size="20" class="txtunedited" value="<?php echo $rwmsn['noseri'];?>">
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;I. UNIT BARANG</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Kondisi</td>
                        <td class="content">&nbsp;
                            <select id="kond" name="kond" class="txt">
								<option value="B" <?php if($kond=='B') echo 'selected' ?>>Baik</option>
								<option value="KB" <?php if($kond=='KB') echo 'selected' ?>>Kurang Baik</option>
								<option value="RB" <?php if($kond=='RB') echo 'selected' ?>>Rusak Berat</option>
							</select>
                            
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="label">&nbsp;Kontruksi</td>
                        <td class="content">&nbsp;
                          <select id="bertingkat" name="bertingkat" class="txt">
						  	<option value="1" <?php if($bertingkat==1) echo 'selected' ?>>Bertingkat</option>
							<option value="0" <?php if($bertingkat==0) echo 'selected' ?>>Tidak Bertingkat</option>
						  </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Beton</td>
                        <td class="content">&nbsp;
                            <select id="beton" name="beton" class="txt">
								<option value="1" <?php if($beton==1) echo 'selected' ?>>Ya</option>
								<option value="0" <?php if($beton==0) echo 'selected' ?>>Tidak</option>
							</select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Lantai(M2)</td>
                        <td class="content">&nbsp;
                            <input type="text" id="luas_lantai" name="luas_lantai" class="txtunedited" size="20" value="<?php echo $rwmsn['luas_lantai'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dokumen Tanggal</td>
                        <td class="content">&nbsp;
                            <input type="text" id="tglsert" name="tglsert" class="txt" size="20" value="<?php echo date("d-m-Y"); ?>">
	<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsert'),depRange);" />	
	<font color="#666666"><em>(dd-mm-yyyy)</em></font> 
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Dokumen No</td>
                        <td class="content">&nbsp;
                            <input type="text" id="no" name="no" class="txt" size="20" value="<?php echo $rwmsn['dok_no'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Luas Tanah(M2)</td>
                        <td class="content">&nbsp;
                             <input type="text" id="luas_tanah" name="luas_tanah" class="txtunedited" size="20" value="<?php echo $rwmsn['luas_tanah'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Status Tanah</td>
                        <td class="content">&nbsp;
                         <select id="status_tnah" name="status_tanah" class="txt">
						 <?php 
						 $sql=mysql_query("select st from status_tanah order by urut");
						 while($row=mysql_fetch_array($sql)){
						 ?>
						 	<option value="<?php echo $row['st'] ?>"<?php if($status_tanah==$row['st']) echo'selected' ?>><?php echo $row['st'] ?></option>
							<?php } ?>
						 </select>
                        </td>
                    </tr>
                     <tr>
                        <td class="label">&nbsp;Kode Tanah</td>
                        <td class="content">&nbsp;
                           <input type="text" id="kode_tanah" name="kode_tanah" size="20" class="txt" value="<?php echo $rwmsn['kode_tanah'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="header2">&nbsp;II. PENGADAAN</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Cara Perolehan</td>
                        <td class="content">&nbsp;
							<select id="cara_perolehan" name="cara_perolehan" class="txt">
                           <?php 
						   $query=mysql_query("select keterangan from as_ms_jenistransaksi order by nourut");
						   while($rw=mysql_fetch_array($query)){
						   ?>
						   <option value="<?php echo $rw['keterangan'] ?>"<?php if($cara_perolehan==$rw['keterangan']) echo'selected' ?>><?php echo $rw['keterangan'] ?></option>
						   <?php } ?>
						   </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;Harga Perolehan</td>
                        <td class="content">&nbsp;
                            <input type="text" id="harga" name="harga" class="txtunedited" size="30" value="<?php echo $rwmsn['harga_perolehan'] ?>">
                        </td>
                    </tr>
                    
                    <tr>
                         <td class="label">&nbsp;Keterangan</td>
                        <td class="content">&nbsp;
                            <input type="text" id="ket" name="ket" size="80" class="txtunedited" value="<?php echo $rwmsn['ket'] ?>">
                        </td> 
                    </tr>
                    </table>
                </form>
            </div>
                        <table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
	
          		<input type="hidden" name="act" value="<?php echo $act;?>">
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
        var arrRange=depRange=[];
        function action(choose){
            switch(choose){
                case 'Edit':
                    document.getElementById('undobutton').disabled = false;
                    document.getElementById('div_view').style.display = 'none';
                    document.getElementById('div_edit').style.display = '';
                    document.getElementById('saveButton').style.display = '';
                    document.getElementById('editButton').style.display = 'none';
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
                location='gedung_data.php';
            }else{
                location='<?php echo $_REQUEST['from']."?unit=".$_REQUEST['unit']."&lokasi=".$_REQUEST['lokasi']."&namaunit=".$_REQUEST['namaunit']."&namalokasi=".$_REQUEST['namalokasi']."&baris=".$_REQUEST['baris'];?>';
            }
        }
    </script>
</html>
