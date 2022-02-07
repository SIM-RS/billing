<?php
include '../sesi.php';
include "../koneksi/konek.php";
$user=$_SESSION['userid'];
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '$def_loc';
        </script>";
}
if(isset($_GET['no_po']) && $_GET['no_po'] != '') {
    $no_po = $_GET['no_po'];
    $po_rekanan = explode('|', $no_po);
}
if(isset($_GET['id']) && $_GET['id'] != '') {
    $terima_po = explode('|', $_GET['id']);
}
if($_REQUEST['tgl']!="")$tgl=$_REQUEST['tgl']; else $tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $txtNoPen = cekNull($_POST['txtNoPen']);
    
    $txtIdBarang = cekNull($_POST['txtIdBarang']);    
    $txtTgl = tglSQL($_POST['txtTgl']);
    $txtTotal = cekNull($_POST['txtTotal']);
    $cmbNoPo = cekNull(explode('|', $_POST['cmbNoPo']));
    $txtNoPo = cekNull($_POST['txtNoPo']);    
    $txtFaktur = cekNull($_POST['txtFaktur']);
    $tglFaktur = cekNull(tglSQL($_POST['txtTglFaktur']));
    $tglTempoBayar = cekNull(tglSQL($_POST['txtTglTempoBayar']));
    $data_submit = explode('*|*',$_POST['data_submit']);
    $user_act = $_SESSION['userid'];
    $user_id = $_SESSION['id_user'];
    $txtPengirim = cekNull($_POST['txtPengirim']);
    $PetGud = cekNull($_POST['txtPetGud']);
    
    if($act == 'add') {
        for($i=0; $i<count($data_submit)-1; $i++) {
            $penerimaan = true;
            $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);//chkItem.value
            $chkItem2 = $data_fill[1];//chkItem.checked
            $satuan = $data_fill[2];//txtSatuan
            $qty_per_kemasan = 1;
            $h_satuan = $data_fill[3];//txtHrgSatuan
            $id=$data_fill[4];
            $txtIdBarang=$data_fill[6];
            $txtUraian=$data_fill[7];
	    
            if($penerimaan == 'true') {
                $query = "insert into as_masuk (po_id,tgl_act,tgl_terima,no_gudang,tgl_faktur,no_faktur,barang_id,msk_uraian,jml_msk,satuan_unit,harga_unit,pengirim,penerima,sisa,exp_bayar) values
                    ('$id', now(), '$txtTgl', '$txtNoPen','$tglFaktur','$txtFaktur','$txtIdBarang','$txtUraian','1','$satuan','$h_satuan','$txtPengirim','$PetGud','1','$tglTempoBayar')";
                //echo $query ."<br>";
                $sukses=mysql_query($query);
				$qPo="update as_po set qty_terima='".$qty_per_kemasan."',STATUS='1' where id='$id'";				
				mysql_query($qPo);
						
						if($sukses){
							$qMasuk="SELECT m.msk_id,m.tgl_terima,m.no_gudang,m.barang_id,m.jml_msk,mr.namarekanan,m.harga_unit FROM as_masuk m
						INNER JOIN as_po p ON p.id=m.po_id
						INNER JOIN as_ms_rekanan mr ON mr.idrekanan=p.vendor_id where m.no_gudang='$txtNoPen' and tgl_terima='$txtTgl'
						and m.barang_id='$txtIdBarang' order by m.po_id desc limit 1";
							
							$rsMasuk=mysql_query($qMasuk);
							$rwMasuk=mysql_fetch_array($rsMasuk);
							//echo "qmasuk = ".$qMasuk."<br>";
							
							$qKstok="select jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc limit 1";
							$rsKstok=mysql_query($qKstok);
							$rwKstok=mysql_fetch_array($rsKstok);
							$jmlSisa=($rwKstok['jml_sisa']=='')?'0':$rwKstok['jml_sisa'];
							$nilaiSisa=($rwKstok['nilai_sisa']=='')?'0':$rwKstok['nilai_sisa'];
							//echo "qkstok = ".$qKstok."<br>";
							
							if($rsMasuk && $rsKstok){
								$qStok="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
								,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe) 
								values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa."','".$rwMasuk['jml_msk']."','0',(jml_awal+jml_masuk-jml_keluar),
								'".$nilaiSisa."','".$rwMasuk['jml_msk']*$rwMasuk['harga_unit']."','0',(nilai_awal+nilai_masuk-nilai_keluar),'".$rwMasuk['namarekanan']."','0')";
								mysql_query($qStok);
								//echo "qstok = ".$qStok."<br>";
							}
						
				}
						mysql_free_result($rsMasuk);
						mysql_free_result($rsKstok);
					}
				}
			$qw = "select msk_id,barang_id,jml_msk,harga_unit,substr(kodebarang,2,1) as kodebarang,year(tgl_terima) as thn 
			from as_masuk m inner join as_ms_barang b on b.idbarang=m.barang_id where no_gudang ='$txtNoPen'";
			$ha = mysql_query($qw);
			while($da = mysql_fetch_array($ha)){
				$sql = "insert into as_seri2 (msk_id,thn_pengadaan,idbarang,jenis_kib,nilaibuku,harga_perolehan) values('$da[msk_id]','$da[thn]','$da[barang_id]','$da[kodebarang]','$da[harga_unit]','$da[harga_unit]')";
				mysql_query($sql);
				switch($da['kodebarang']){
				case '1':
				$idseri = mysql_fetch_array(mysql_query("select idseri from as_seri2 order by idseri desc limit 1"));
				$sql = mysql_query("insert into kib01 (idseri) values('$idseri[0]')");
				break;
				case '3':
				$idseri = mysql_fetch_array(mysql_query("select idseri from as_seri2 order by idseri desc limit 1"));
				$sql = mysql_query("insert into kib03 (idseri) values('$idseri[0]')");
				break;
				case '4':
				$idseri = mysql_fetch_array(mysql_query("select idseri from as_seri2 order by idseri desc limit 1"));
				$sql = mysql_query("insert into kib04 (idseri) values('$idseri[0]')");
				break;
				case '6':
				$idseri = mysql_fetch_array(mysql_query("select idseri from as_seri2 order by idseri desc limit 1"));
				$sql = mysql_query("insert into kib06 (idseri) values('$idseri[0]')");
				break;
				}
			}
			
				header('location:penerimaanATB_detil.php');
			}
			else if($act == 'edit') {
				for($i=0; $i<count($data_submit)-1; $i++) {
					$status_terima = '';
					$data_fill = explode('*-*',$data_submit[$i]);
					$chkItem1 = explode('|',$data_fill[0]);//chkItem.value
					$chkItem2 = $data_fill[1];//chkItem.checked
					$qty_satuan = $data_fill[2];//txtJmlSatuan
					$satuan = $data_fill[3];//txtSatuan
					$qty_per_kemasan = $data_fill[4];//txtJmlPerKemasan
					$h_satuan = $data_fill[5];//txtHrgSatuan
					$id=$data_fill[5];
					$poid=$data_fill[7];
					$txtIdBarang=$data_fill[8];
					$txtJmlDiterima=$data_fill[9];
					$txtUraian=$data_fill[10];
				   
					$sMsk="select jml_msk from as_masuk where po_id='$poid' and no_gudang='$txtNoPen'";
					$rsMsk=mysql_query($sMsk);
					$rwMsk =mysql_fetch_array($rsMsk);
				   
				$query = "update as_masuk set tgl_act=now(),tgl_terima='".$txtTgl."',tgl_faktur='$tglFaktur',no_faktur='$txtFaktur',barang_id='$txtIdBarang',msk_uraian='$txtUraian',jml_msk='$qty_per_kemasan',satuan_unit='$satuan',harga_unit='$h_satuan',pengirim='$txtPengirim',penerima='$PetGud',sisa='$qty_per_kemasan',exp_bayar='$tglTempoBayar' 
					where po_id='$poid' and no_gudang='$txtNoPen'";            
					$sukses=mysql_query($query);            
					
					
					$qPo="update as_po set qty_terima='".(($txtJmlDiterima-$rwMsk['jml_msk'])+$qty_per_kemasan)."',STATUS=IF(qty_satuan=qty_terima,1,0) where id='$poid'";			
					mysql_query($qPo);
					
					//echo $query ."<br>";
					if($sukses){
						$qMasuk="SELECT m.msk_id,m.tgl_terima,m.no_gudang,m.barang_id,m.jml_msk,mr.namarekanan,m.harga_unit FROM as_masuk m
					INNER JOIN as_po p ON p.id=m.po_id
					INNER JOIN as_ms_rekanan mr ON mr.idrekanan=p.vendor_id where m.no_gudang='$txtNoPen' and tgl_terima='$txtTgl'
					and m.barang_id='$txtIdBarang' order by m.po_id desc limit 1";                    
							
					$rsMasuk=mysql_query($qMasuk);
							$rwMasuk=mysql_fetch_array($rsMasuk);
							//echo "qmasuk = ".$qMasuk."<br>";
							
							$qKstok="select jml_masuk,jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc, stok_id desc  limit 1";
							$rsKstok=mysql_query($qKstok);
							$rwKstok=mysql_fetch_array($rsKstok);
							$jmlSisa=($rwKstok['jml_sisa']=='')?'0':$rwKstok['jml_sisa'];
							$nilaiSisa=($rwKstok['nilai_sisa']=='')?'0':$rwKstok['nilai_sisa'];
							
							$tipe='4';//tipe edit
							$qStok="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
							,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe) 
							values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa."','0','".$rwKstok['jml_masuk']."',(jml_awal+jml_masuk-jml_keluar),
							'".$nilaiSisa."','0','".$rwKstok['jml_masuk']*$rwMasuk['harga_unit']."',(nilai_awal+nilai_masuk-nilai_keluar),'".$rwMasuk['namarekanan']."','$tipe')";
							$sukses1=mysql_query($qStok);
							if($sukses1){
								if($qty_per_kemasan!='0'){
									$qKstok2="select jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc, stok_id desc  limit 1";
									$rsKstok2=mysql_query($qKstok2);
									$rwKstok2=mysql_fetch_array($rsKstok2);
									$jmlSisa2=($rwKstok2['jml_sisa']=='')?'0':$rwKstok2['jml_sisa'];
									$nilaiSisa2=($rwKstok2['nilai_sisa']=='')?'0':$rwKstok2['nilai_sisa'];
									
									$qStok2="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
									,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe) 
									values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa2."','$qty_per_kemasan','0',(jml_awal+jml_masuk-jml_keluar),
									'".$nilaiSisa2."','".$qty_per_kemasan*$rwMasuk['harga_unit']."','0',(nilai_awal+nilai_masuk-nilai_keluar),'".$rwMasuk['namarekanan']."','$tipe')";
									mysql_query($qStok2);
								}
							}                    
            }
           
            mysql_free_result($rsMasuk);
            mysql_free_result($rsKstok);
            mysql_free_result($rsKstok2);                
        }
    }
}

$act = 'add';
if(isset($_GET['act'])) {
    $act = $_GET['act'];
}
if($_GET['id'] != '' && isset($_GET['id']) && $_GET['act'] == 'edit') {
  $sql = "SELECT * FROM as_masuk pe 
	    INNER JOIN as_po po ON pe.po_id = po.id
	    INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
	    where no_po = '".$terima_po[1]."' and pe.no_faktur='".$terima_po[0]."'";

    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $noGudang = $rows1['no_gudang'];
        $noFaktur = $rows1['no_faktur'];        
        $tgl = tglSQL($rows1['tgl_terima']);
        $tglFaktur = tglSQL($rows1['tgl_faktur']);
        $pengirim = $rows1['pengirim'];
        $penerima = $rows1['penerima'];
        $po_rekanan[2] = $rows1['namarekanan'];
        $po_rekanan[3] = $rows1['exp_kirim'];
        $tglTempoBayar = tglSQL($rows1['exp_bayar']);
        mysql_free_result($rs1);
    }

    $cmbNoPo = "<select name='cmbNoPo' disabled class='txtcenter' id='cmbNoPo' onchange='set()'>";
    $qry = "SELECT distinct po.no_po, vendor_id, rek.namarekanan,po.exp_kirim
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
			inner join as_ms_barang b on b.idbarang = po.ms_barang_id
            where po.status = 0 AND po.ms_barang_id in 
			(select idbarang from as_ms_barang where kodebarang like '01%' or kodebarang like '03%' 
			or kodebarang like '04%' or kodebarang like '06%' and tipe='1')
            and po.no_po = '".$terima_po[1]."' order by po.tgl_po desc,po.no_po desc";
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim']."'
        title='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim']."'";
        if($rows1['namarekanan']==$show['namarekanan']){
            $cmbNoPo .=" selected ";
        }
        $cmbNoPo .=">".$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
        //po_rekanan menggunakan array untuk mengikuti po_rekanan yang sebelumnya sudah dibuat & digunakan
       
    }
    $cmbNoPo .= "</select>";
   $txtNoPo = $rows1['no_po'];
    if($terima_po[1]=='-'){
    	$cmbNoPo='';
    	}
}
else {
	date_default_timezone_set("Asia/Jakarta");
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
	$tglcek=$_REQUEST['tgl'];
	$tglc=explode("-",$tglcek);
	$sqlcek="select no_gudang from as_masuk where no_gudang ='GDM/$th[2]-$th[1]/0001' ";
	$rs=mysql_query($sqlcek);
	if(mysql_num_rows($rs)>0){
		$sql="select no_gudang from as_masuk where month(tgl_terima)='$th[1]' and year(tgl_terima)='$th[2]' order by no_gudang desc limit 1";
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)) {
			$noGudang=$rows1["no_gudang"];
			$ctmp=explode("/",$noGudang);
			$dtmp=$ctmp[2]+1;
			$ctmp=$dtmp;
			$ctmp=sprintf("%04d",$ctmp);
			//for ($i=0; $i<(4-strlen($dtmp)); $i++)
			//    $ctmp = "0".$ctmp;
			$noGudang = "GDM/$th[2]-$th[1]/$ctmp";
		}
		else {
			$noGudang = "GDM/$th[2]-$th[1]/0001";
		}
	}else{
		$noGudang = "GDM/$th[2]-$th[1]/0001";
	}
    $cmbNoPo = "<select name='cmbNoPo' class='txtcenter' id='cmbNoPo' onchange='set()'>
        <option value='' class='txtcenter'>Pilih PO</option>";
    $qry="SELECT distinct po.no_po, vendor_id, rek.namarekanan,po.exp_kirim
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
			inner join as_ms_barang b on b.idbarang = po.ms_barang_id
            where po.status = 0 AND po.ms_barang_id in 
			(select idbarang from as_ms_barang where kodebarang like '01%' or kodebarang like '03%' 
			or kodebarang like '04%' or kodebarang like '06%' and tipe='1')
             order by po.tgl_po desc,po.no_po desc";
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim']."' ";
        if($show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'] == $no_po)
            $cmbNoPo .= 'selected';

        $cmbNoPo .= " >"
                .$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
    }
    $cmbNoPo .= "</select>";
}

//if()
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Penerimaan Baru :.</title>
    </head>
    <body>
        <div align="center">
            <?php
            include("../header.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table border="0" width="1000" cellpadding="0" cellspacing="2" bgcolor="#FFFBF0">
                <tr>
                    <td colspan="10" height="20">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" style="font-size:16px;" colspan="15">PENERIMAAN ASET TAK BERGERAK</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <form id="form1" name="form1" action="" method="post">
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="data_submit" name="data_submit" value="<?php echo $_POST['data_submit'];?>" />
                    <input type="hidden" id="txtNoPo" name="txtNoPo" value="<?php echo $txtNoPo;?>" />
                    
                    <input type="hidden" id="noGudang" name="noGudang" value="<?php echo $terima_po[0];?>" />
                    <input type="hidden" id="noPo" name="noPo" value="<?php if($act=='add')echo $po_rekanan[0];else echo $terima_po[1];?>" />
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;No Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtNoPen" name="txtNoPen" value='<?php echo $noGudang; ?>' class="txtcenter" size="20" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/></td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5">&nbsp;
								<?php
								if($terima_po[1]!='-'){ ?>                        
                        No PO  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        <?php
                        }	
                            echo $cmbNoPo;
                            
                            ?></td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Tgl Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtTgl" name="txtTgl" readonly value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" size="10" class="txtcenter"/>&nbsp;
                            <?php
                             if($act != 'edit') { 
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,cek); " />
                                <?php
                            }
                            ?>                        </td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5">&nbsp;Supplier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;: &nbsp;<?php echo $po_rekanan[2];?></td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;No BATB</td>
                      <td width="18%">&nbsp;:&nbsp;
                        <input id="txtFaktur" name="txtFaktur" value="<?php echo $noFaktur; ?>" <?php if($act == 'edit') { echo " readonly ";}?> class="txtcenter" size="15" />
                      <td>&nbsp;</td>
                        <td colspan="5">&nbsp;Jatuh Tempo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo tglSQL($po_rekanan[3]);?>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Tgl BATB</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtTglFaktur" name="txtTglFaktur" value="<?php if(isset($tglFaktur) ) echo $tglFaktur; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                            if($act != 'edit') {
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTglFaktur'),depRange);" />
                                <?php
                            }
                            ?>                        </td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5"></td>
						<td width="3%">&nbsp;</td>
                    </tr>
                    
                                     
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="8" align="center">
                            <table id="tblpenerimaan" width="100%" border="0" cellpadding="1" cellspacing="0">
                                <tr class="headtable">
                                    <td width="44" height="50" class="tblheaderkiri">No</td>
                                    <td id="kodebarang" width="31" class="tblheader">
                                      <input type="checkbox" name="chkAll" id="chkAll" value="" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> onClick="fCheckAll(this,'chkItem');HitunghTot();" style="cursor:pointer" title="Pilih Semua" />                                    </td>
                                  <td width="100" class="tblheader" id="namabarang">Kode Barang</td>
                                  <td id="qty_kemasan" width="250" class="tblheader">
                                    <p>Nama Barang</p></td>
                                  <td id="uraian" width="200" class="tblheader">
                                    <p>Uraian</p></td>
                                  <td id="kemasan" width="78" class="tblheader">Satuan</td>
                                    <td width="84" class="tblheader">Peruntukan</td>
                                  <td width="100" class="tblheader">Sub Total</td>
                              </tr>
                                <?php
                                if(isset($_GET['act']) && $_GET['act'] == 'edit' || isset($no_po)) {
                                    if($_GET['act'] == 'edit') {
                                       $sql = "select q1.*,namabarang,kodebarang,u.* from
                                                (SELECT pe.*, po.no_po, qty_satuan,po.peruntukan, satuan,harga_satuan,po.qty_terima,po.unit_id
                                                FROM as_masuk pe inner join as_po po on pe.po_id = po.id
                                                where pe.no_faktur = '$terima_po[0]' and po.no_po = '$terima_po[1]'
                                                order by pe.msk_id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.barang_id
                                                left join as_ms_unit u on q1.unit_id = u.idunit";
                                        //no_po, tgl, tgl_j_tempo, hari_j_tempo, qty_kemasan, qty_kemasan_terima, kemasan, harga_kemasan, qty_perkemasan, qty_satuan, qty_pakai, qty_satuan_terima, satuan, harga_beli_total, harga_beli_satuan, diskon, extra_diskon, diskon_total, ket, nilai_pajak, jenis, termasuk_ppn, status, user_act, tgl_act
                                    }
                                    else {
                                        if($no_po != '') {
                                           $sql = "select q1.*,q1.uraian as msk_uraian,q1.peruntukan,b.namabarang,b.kodebarang,u.* from (SELECT *
                                                FROM as_po po
                                                where po.no_po = '$po_rekanan[0]' and status = 0
                                                order by po.id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id
                                                left join as_ms_unit u on q1.unit_id = u.idunit";
                                        }
                                    }
                                    
                                    $rs=mysql_query($sql);
                                    $i=0;
                                    $tot=0;
                                    while ($rows=mysql_fetch_array($rs)) {
                                        $id = cekNull($rows['id']);
                                        $poid = cekNull($rows['po_id']);
                                        $idbarang = cekNull($rows['barang_id']);
                                        $kodebarang = cekNull($rows['kodebarang']);
                                        $namabarang = cekNull($rows['namabarang']);
                                        $uraian = cekNull($rows['msk_uraian']);
                                        $subtotal = cekNull($rows['subtotal']);
                                        $total = cekNull($rows['total']);
                                        $exp_kirim = $rows['exp_kirim'];
                                        $satuan = $rows['satuan'];
                                        $kemasan = $rows['kemasan'];  
                                        $namaunit = $rows['peruntukan'];   
                                        $qty_kemasan = cekNull($rows['qty_kemasan']);
                                        $qty_terima=cekNull($rows['qty_terima']);
                                        $qty_kemasan_terima = cekNull($rows['jml_msk']);
                                        $qty_satuan = cekNull($rows['qty_satuan']);
                                        //jika act bukan edit, maka isi qty_kemasan_terima = database
                                        if($_GET['act'] != 'edit'){
                                            $qty_kemasan_terima = 0;//($qty_terima!=0)?(cekNull($rows['qty_satuan'])-$qty_terima):cekNull($rows['qty_satuan']);
                                            $idbarang=cekNull($rows['ms_barang_id']);
                                            $uraian = cekNull($rows['uraian']);
                                        }
                                        
                                        $harga_kemasan = cekNull($rows['harga_kemasan']);
                                        $harga_satuan = cekNull($rows['harga_satuan']);
                                        $sub_tot = cekNull(($qty_kemasan-$qty_kemasan_terima)*$harga_kemasan);
                                        
                                        $diskon = cekNull($rows['diskon']);
                                        ?>
                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                    <td class="tdisikiri"><?php echo ++$i; ?></td>
                                    <td class="tdisi" align="center">
                                        <input type="checkbox" name="chkItem" id="chkItem" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> value="<?php echo $id.'|'.$idbarang; ?>" onClick="/*HitunghDiskonTot();*/ HitunghTot();" />                                    </td>
                                    <td class="tdisi" align="center">                                        
                                            <input id="txtId" name="txtId" type="hidden" readonly="readonly" value="<?php echo $id; ?>" />
                                          <input id="txtPoId" name="txtPoId" type="hidden" readonly="readonly" value="<?php echo $poid; ?>" />
                                          <input id="txtIdBarang" name="txtIdBarang" type="hidden"  readonly="readonly" value="<?php echo $idbarang; ?>" />
                                          <?php echo $kodebarang; ?>                                        </td>
                                    <td class="tdisi" align="center">                                        
                                        <?php echo $namabarang; ?></td>
                                    <td class="tdisi" align="center">
                                    <input id="txtUraian" name="txtUraian" type="text" class="txtcenter" size="30" readonly="readonly" value="<?php echo $uraian; ?>" />                                    </td>
                                    <td class="tdisi" align="center">
                                    <input id="txtSatuan" name="txtSatuan" type="text" class="txtcenter" size="20" readonly="readonly" value="<?php echo $satuan; ?>" />                                    </td>
                                  <td class="tdisi" align="center">
                                <input id="unit" name="unit" type="text" class="txtcenter" size="15" readonly="readonly" value="<?php echo $namaunit; ?>" />                                    </td>
                            <td class="tdisi" align="center">
							<input id="txtHrgSatuan" size="15" name="txtHrgSatuan" type="hidden" class="txtright" readonly="readonly" value="<?php echo $harga_satuan; ?>" />
                            <input id="txtSubTotal1" size="15" name="txtSubTotal1" type="text" class="txtright" readonly="readonly" value="<?php echo number_format($harga_satuan,0,',','.'); ?>" />
							<input id="txtSubTotal" size="15" name="txtSubTotal" type="hidden" class="txtright" readonly="readonly" value="<?php echo $harga_satuan; ?>" />
							</td>
                                </tr>
                                        <?php
                                        $tot+=($qty_kemasan_terima*$harga_satuan);
                                    }
                                    mysql_free_result($rs);
                                }
                                ?>
                            </table>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td width="11%" align="center">TOTAL</td>
                      <td width="12%" align="center"><div align="left">:
                        <input id="txtTotal" class="txtright" align="right" value="<?php echo $tot;?>" readonly name="txtTotal" size="15" />
                      </div></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="4" align="right">
                            <button type="button" onClick="if (ValidateForm('txtFaktur','ind')){kirim();}" style="cursor: pointer">
                                <img alt="save" src="../icon/save.gif" border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>                        </td>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='penerimaanATB.php'" style="cursor: pointer">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;                            </button>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </form>
                <tr>
                    <td colspan="10">
                        <?php
                        include '../footer.php';
                        ?>                    </td>
                </tr>
            </table>
    </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>

    <script type="text/javascript" language="javascript">
       
        var arrRange=depRange=[];
		function numberFormat(nStr){
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1))
    x1 = x1.replace(rgx, '$1' + '.' + '$2');
  return x1 + x2;
}
		function cek(){
			var tgl=document.getElementById('txtTgl').value;
			//location="../Aktivitas/penerimaanPO_detil.php?tgl="+tgl; 
		}
        function cetakbarcode(){
            var tgl=document.getElementById('txtTgl').value;
            if(document.getElementById('act').value=="add"){
                window.open('barcode.php?opt=add&tgl='+tgl+'&no_po='+document.getElementById('noPo').value);
            }else{
                window.open('barcode.php?opt=edit&tgl='+tgl+'&no_gudang='+document.getElementById('noGudang').value+'&no_po='+document.getElementById('noPo').value);
            }
        }
        function kirim(){
            var data_submit = '';            
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    data_submit += document.forms[0].chkItem[i].value
						+'*-*'+document.forms[0].chkItem[i].checked
                        +'*-*'+document.forms[0].txtSatuan[i].value  
                        +'*-*'+document.forms[0].txtHrgSatuan[i].value
                        +'*-*'+document.forms[0].txtId[i].value
                        +'*-*'+document.forms[0].txtPoId[i].value
                        +'*-*'+document.forms[0].txtIdBarang[i].value
                        +'*-*'+document.forms[0].txtUraian[i].value
                        +'*|*';
                }                
            }
            else{
                data_submit = document.forms[0].chkItem.value
					+'*-*'+document.forms[0].chkItem.checked
                    +'*-*'+document.forms[0].txtSatuan.value                      
                    +'*-*'+document.forms[0].txtHrgSatuan.value
                    +'*-*'+document.forms[0].txtId.value
                    +'*-*'+document.forms[0].txtPoId.value
                    +'*-*'+document.forms[0].txtIdBarang.value
                    +'*-*'+document.forms[0].txtUraian.value 
                    +'*|*';
            }
            document.forms[0].data_submit.value = data_submit;
            document.getElementById('form1').submit();
        }
        
        function fCheckAll(chkAll,chkItem){
            if(chkAll.checked){
                if(document.forms[0].chkItem.length){
                    for(var i=0; i<document.forms[0].chkItem.length; i++){
                        document.forms[0].chkItem[i].checked=true;
                        HitungSubTotal(i);
                    }
                }
            }else{
                if(document.forms[0].chkItem.length){
                    for(var i=0; i<document.forms[0].chkItem.length; i++){
                        document.forms[0].chkItem[i].checked=false;
                        HitungSubTotal(i);
                    }
                }
            }
            HitunghTot();
        }

        function cekVal(line){
            if(document.forms[0].chkItem.length){
                //alert(document.forms[0].qty_kemasan[line].value+'>'+document.forms[0].hid_qty_kemasan[line].value);
                var qty_kemasan = parseInt(document.forms[0].qty_kemasan[line].value);
                var hid_qty_kemasan = parseInt(document.forms[0].hid_qty_kemasan[line].value);
                if(qty_kemasan > hid_qty_kemasan){
                    alert('Jumlah item yang diterima lebih besar dari aslinya.');
                    document.forms[0].qty_kemasan[line].value = document.forms[0].hid_qty_kemasan[line].value;
                    HitungQtySatuan(line);
                    HitungSubTotal(line);
                    HitungDiskon(line);
                }
            }
            else{
                if(document.forms[0].qty_kemasan.value > document.forms[0].hid_qty_kemasan.value){
                    alert('Jumlah item yang diterima lebih besar dari aslinya.');
                    document.forms[0].qty_kemasan.value = document.forms[0].hid_qty_kemasan.value;
                    HitungQtySatuan();
                    HitungSubTotal();
                    HitungDiskon();
                }
            }
        }


         

        function HitunghTot(){
            var tmp = 0;
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    if(document.forms[0].chkItem[i].checked){
                        tmp += document.forms[0].txtSubTotal[i].value*1;
                    }
                }
            }
            else{
                tmp = document.forms[0].txtSubTotal.value;
            }
           
            document.forms[0].txtTotal.value =numberFormat(tmp);
        }

        function set()
        {
            var nopo = document.getElementById('cmbNoPo').value;
            //alert(nopo);          
            //alert("detailPenerimaan.php?act=<?php echo $act;?>&no_po="+nopo);
            window.location = "penerimaanATB_detil.php?act=<?php echo $act;?>&no_po="+nopo;
        }
        
        function bandingkan(kiri,kanan){
            if(!isNaN(kiri) && !isNaN(kanan)){                
                if(parseFloat(kiri)>parseFloat(kanan)){
                    return "lebih besar";
                }
                else if(parseFloat(kiri)<parseFloat(kanan)){
                    return "lebih kecil";
                }
                else if(parseFloat(kiri)==parseFloat(kanan)){
                    return "sama";
                }
            }
            else{
                alert('Isilah Dengan Angka!');
            }
        }
	
        function HitungSubTotal(line){
            if (document.forms[0].chkItem.length){                
                
                if(document.forms[0].chkItem[line].checked){
                    //HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                
               if(document.forms[0].chkItem.checked){                    
                    HitunghTot();
                }
            }
        }
    </script>
</html>
