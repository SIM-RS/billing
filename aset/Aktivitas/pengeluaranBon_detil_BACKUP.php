<?php
include '../sesi.php';
include "../koneksi/konek.php";
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
	$no_po = $_GET['id'];
    //echo $_GET['id'];
}
date_default_timezone_set("Asia/Jakarta");
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    //echo $_POST['data_submit']."<br/>";
    $data_submit = explode('*|*',$_POST['data_submit']);
    $txtNoPen = cekNull($_POST['txtNoPen']);
    $txtTgl = tglSQL($_POST['txtTgl']);
    $penerima = cekNull($_POST['txtPenerima']);
    $petugas_gudang = cekNull($_POST['txtPetGud']);
    $user_act = $_SESSION['userid'];
    $user_id = $_SESSION['id_user'];
    $unit_terima = $_SESSION['refidunit'];
    if($act == 'add') {
        for($i=0; $i<count($data_submit)-1; $i++) {
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);
            $idklr = $chkItem1[0];
            $idbarang = $chkItem1[1];
            $kodebrg = $data_fill[2];
            $namabrg = $data_fill[3];
            $satuanbrg = $data_fill[4];
            $jumlahbon = $data_fill[5];
			$jmlKluar=$data_fill[6];
			$jmladj = $data_fill[7];
			
			$jmlk = $jmladj+$jmlKluar;
			//$txtNoPen=$data_fill[7];
            //echo "<br>";
				
            $quKeluar = "UPDATE as_keluar SET tgl_gd='$txtTgl',no_gd='$txtNoPen',jumlah_keluar='$jmlk',petugas_gudang='$petugas_gudang' WHERE klr_id='$idklr'";
            mysql_query($quKeluar);

            $qsMasuk = "SELECT * FROM as_masuk WHERE sisa>0 AND barang_id = '$idbarang' ORDER BY msk_id";
            $rsMasuk = mysql_query($qsMasuk);
            $jmlKeluar = $jmladj;
            while($rwMasuk = mysql_fetch_array($rsMasuk)) {
                $jml=0;

                if($jmlKeluar>=$rwMasuk['sisa']) {
                    $jmlKeluar-=$rwMasuk['sisa'];
                    $jml = $rwMasuk['sisa'];
                }
                else if($jmlKeluar<$rwMasuk['sisa']) {
                    $jml = $jmlKeluar;
                    $jmlKeluar = 0;
                }
                $nilai = $rwMasuk['harga_unit'];
                $qiOperasi = "INSERT INTO as_operasi (klr_id,msk_id,waktu_opr,barang_id,jml,satuan,harga_satuan,subtotal)
		values('$idklr','".$rwMasuk['msk_id']."',now(),'$idbarang','$jml','".$rwMasuk['satuan_unit']."','".$rwMasuk['harga_unit']."','".($jml*$rwMasuk['harga_unit'])."')";
                mysql_query($qiOperasi);
            }
            mysql_free_result($rsMasuk);
            $qsOperasi = "SELECT SUM(subtotal) as hargatotal FROM as_operasi WHERE klr_id='$idklr' AND barang_id='$idbarang'";
            $rsOperasi = mysql_query($qsOperasi);
            $rwOperasi = mysql_fetch_array($rsOperasi);
            $hargaTotal = $rwOperasi['hargatotal'];
            //mysql_free_result($rsOperasi);

            $quKeluar1 = "UPDATE as_keluar SET nilai='$hargaTotal',stt='1' WHERE klr_id='$idklr'";
            mysql_query($quKeluar1);

            $qsKeluar2 = "select klr_id,jml_klr,nilai,k.unit_id,barang_id,lokasi_id,satuan,mu.namaunit,jumlah_keluar
						from as_keluar k inner join as_ms_unit mu on k.unit_id=mu.idunit where  klr_id='$idklr'";
            //echo "<br>";
            $rsKeluar2 = mysql_query($qsKeluar2);
            $rwKeluar2 = mysql_fetch_array($rsKeluar2);

            $qKstok="select jml_masuk,jml_sisa,nilai_sisa from as_kstok where barang_id='".$idbarang."' order by waktu desc, stok_id desc  limit 1";
            $rsKstok=mysql_query($qKstok);
            $rwKstok=mysql_fetch_array($rsKstok);
            $jmlSisa=($rwKstok['jml_sisa']=='')?'0':$rwKstok['jml_sisa'];
            $nilaiSisa=($rwKstok['nilai_sisa']=='')?'0':$rwKstok['nilai_sisa'];

            $tipe='1';//tipe keluar
            $qStok="insert into as_kstok (waktu,barang_id,klr_id,jml_awal,jml_keluar,jml_sisa
		    ,nilai_awal,nilai_keluar,nilai_sisa,ket,tipe) 
		    values (now(),'".$rwKeluar2['barang_id']."','".$rwKeluar2['klr_id']."','".$jmlSisa."','".$rwKeluar2['jumlah_keluar']."',(jml_awal+jml_masuk-jml_keluar),
		    '".$nilaiSisa."','".$rwKeluar2['nilai']."',(nilai_awal+nilai_masuk-nilai_keluar),'".$rwKeluar2['namaunit']."','$tipe')";
            $sukses1=mysql_query($qStok);

            /*echo $sMasuk="SELECT m.tgl_faktur,m.no_faktur,k.kode_transaksi,p.vendor_id FROM as_keluar k
		    INNER JOIN as_operasi o ON o.klr_id=k.klr_id
		    INNER JOIN as_masuk m ON m.msk_id=o.msk_id
		    INNER JOIN as_po p ON p.id=m.po_id
		    where k.klr_id='".$rwKeluar2['klr_id']."'";
            $rMasuk=mysql_query($sMasuk);
            $wMasuk=mysql_fetch_array($rMasuk);

           $iTrans="INSERT INTO as_transaksi (idunit,idlokasi,tgltransaksi,tok,refno,buktino,refidrekanan,idbarang,idsatuan,dasarharga,totalamount,idcurr,nilaikurs,aktifasi) VALUES
	    ('".$rwKeluar2['unit_id']."','".$rwKeluar2['lokasi_id']."','".$wMasuk['tgl_faktur']."','T','".$wMasuk['kode_transaksi']."','".$wMasuk['no_faktur']."','".$wMasuk['vendor_id']."', '$idbarang','".$rwKeluar2['satuan']."','0','".$rwKeluar2['jml_klr']."','IDR','1','0')";

            //mysql_query($iTrans);

            $sTrans = "select max(idtransaksi) as id from as_transaksi where idunit='".$rwKeluar2['unit_id']."' and idlokasi='".$rwKeluar2['lokasi_id']."' and buktino='".$wMasuk['no_faktur']."'";
            $rTrans = mysql_query($sTrans);
            $wTrans = mysql_fetch_array($rTrans);

            $tglPengadaan = explode("-",$wMasuk['tgl_faktur']);
            $thnPengadaan = $tglPengadaan[0];
				*/
				 $tglPengadaan = explode("-",$txtTgl);
            $thnPengadaan = $tglPengadaan[0];				
				$kdbrg = "select kodebarang from as_ms_barang where idbarang = '$idbarang'";
				$rkdbrg = mysql_query($kdbrg);
				$wkdbrg = mysql_fetch_array($rkdbrg);
				$kib = substr($wkdbrg[0],0,2);
				if($kib[0]==0){
						 $kib = $kib[1];					
					}
				for($k=0;$k<$jumlahbon;$k++){
           $sSeri = "SELECT noseri FROM as_seri2 where idbarang='$idbarang' and thn_pengadaan='$thnPengadaan'  ORDER BY noseri DESC LIMIT 1";
            $rSeri = mysql_query($sSeri);
            $wSeri = mysql_fetch_array($rSeri);

            $iSeri="INSERT INTO as_seri2 (harga_perolehan,nilaibuku,ms_idunit,ms_idlokasi,noseri,thn_pengadaan,idbarang,jenis_kib)VALUES
		    ('$nilai','$nilai','".$rwKeluar2['unit_id']."','".$rwKeluar2['lokasi_id']."','".($wSeri['noseri']+1)."','".$thnPengadaan."','".$idbarang."','".$kib."')";
            mysql_query($iSeri);
            $id = mysql_query("select idseri from as_seri2 order by idseri desc limit 1");
            $idseri = mysql_fetch_array($id);
            $tbl_kib = "kib".substr($wkdbrg[0],0,2);
            mysql_query("insert into $tbl_kib (idseri) values('".$idseri[0]."')");
            }
        }
        header('location:pengeluaranBon_detil.php');
    }
    else if($act == 'edit') {
        for($i=0; $i<count($data_submit)-1; $i++) {
            // $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);
            $kodebarang = $data_fill[0];
            $namabarang = $data_fill[1];
            $satuan = $data_fill[2];
            $jumlahbon = $data_fill[3];
            /*  //$chkItem2 = $data_fill[1];
            $qty_kemasan = $data_fill[2];
            $kemasan = $data_fill[3];
            $h_kemasan = $data_fill[4];
            $qty_per_kemasan = $data_fill[5];
            $qty_satuan = $data_fill[6];
            $satuan = $data_fill[7];
            $h_satuan = $data_fill[8];
            $diskon = $data_fill[9];
            $hid_qty_kemasan = $data_fill[10];
            $hid_qty_kemasan_terima = cekNull($data_fill[11]);

            $query = "update as_po set kemasan = '$kemasan', harga_kemasan = '$h_kemasan', nilai_pajak = '$pajak'
                      , qty_satuan = '$qty_satuan', satuan = '$satuan', harga_beli_total = '$txtTotal', diskon = '$diskon'
                      , diskon_total = '$txtDiskon', tgl_j_tempo = ADDDATE('$txtTgl', INTERVAL $txtTempo DAY), hari_j_tempo = $txtTempo
                      , user_act = '$user_act', tgl_act = now()
                    where id = '$chkItem1[1]'"; 
            mysql_query($query);

           $query = "update as_penerimaan set tgl_act = now(), tgl_j_tempo = ADDDATE('$txtTgl', INTERVAL $txtTempo DAY), nilai_pajak = '$pajak'
                    , hari_j_tempo = $txtTempo, kemasan = '$kemasan', harga_kemasan = '$h_kemasan', diskon_total = '$txtDiskon', nobukti = '$txtFaktur'
                    , qty_satuan = '$qty_satuan', satuan = '$satuan', harga_beli_total = '$txtTotal', harga_beli_satuan = '$h_satuan', diskon = '$diskon'
                    where id = $chkItem1[0]"; 
            mysql_query($query);
            //, user_id_terima = '$user_act'*/
        }
    }
}

$act = 'add';
if(isset($_GET['act'])) {
    $act = $_GET['act'];
}
if($_GET['id'] != '' && isset($_GET['id']) && $_GET['act'] == 'edit') {
    $sql = "Select msk_id,satuan_unit,harga_unit,sisa from as_masuk
   where barang_id== '".$terima_po[0]."' and sisa>0
   order by tgl_act ";

    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $msk_id = $rows1['msk_id'];
        $satuan_unit = $rows1['satuan_unit'];
        $harga_unit = $rows1['harga_unit'];
        $sisa = $rows1['sisa'];
        mysql_free_result($rs1);
    }

    $cmbNoPo = "<select name='cmbNoPo' disabled class='txtcenter' id='cmbNoPo' onchange='set()'>
        <option value='' class='txtcenter'>Pilih Bon</option>";
    $qry='SELECT tgl_transaksi,kode_transaksi FROM as_keluar, as_lokasi
	    GROUP BY tgl_transaksi,kode_transaksi
	    ORDER BY tgl_transaksi DESC,kode_transaksi DESC';
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['tgl_transaksi'].'|'.$show['kode_transaksi']."' title='".$show['tgl_transaksi'].'|'.$show['kode_transaksi']."' ";
        if($show['tgl_transaksi'].'|'.$show['kode_transaksi'] == $terima_po[0]+'|'+$terima_po[1])
            $cmbNoPo .= 'selected';
        $cmbNoPo .= " >"
                .$show['tgl_transaksi'].' / '.$show['kode_transaksi']
                ."</option>";
    }
    $cmbNoPo .= "</select>";
    $noterima=$terima_po[1];
    $peruntukan=$terima_po[2];
    $tgl=$terima_po[3];
    $petugas_rtp=$terima_po[5];
    $petugas_gudang=$terima_po[4];
}
else {
    $sql="select no_gd from as_keluar where month(tgl_gd)='$th[1]' and year(tgl_gd)='$th[2]'  order by no_gd desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $noterima=$rows1["no_gd"];
        $ctmp=explode("/",$noterima);
        $dtmp=$ctmp[2]+1;
        $ctmp=$dtmp;
        $ctmp=sprintf("%04d",$ctmp);
        //for ($i=0; $i<(4-strlen($dtmp)); $i++)
        //    $ctmp = "0".$ctmp;
        $noterima = "GDK/$th[2]-$th[1]/$ctmp";
    }
    else {
        $noterima = "GDK/$th[2]-$th[1]/0001";
    }

    $cmbNoPo = "<select name='cmbNoPo' class='txtcenter' id='cmbNoPo' onchange='set()'>
        <option value='' class='txtcenter'>Pilih Bon</option>";
    $qry='SELECT tgl_transaksi,kode_transaksi,u.namaunit,l.namalokasi, petugas_gudang, petugas_unit FROM as_keluar k
	    LEFT JOIN as_ms_unit u ON u.idunit=k.unit_id
	    LEFT JOIN as_lokasi l ON l.idlokasi=k.lokasi_id
	    WHERE stt=0 GROUP BY tgl_transaksi,kode_transaksi
	    ORDER BY tgl_transaksi desc,kode_transaksi desc';
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['tgl_transaksi'].'|'.$show['kode_transaksi'].'|'.$show['namaunit'].' - '.$show['namalokasi'].'|'.$show['petugas_gudang'].'|'.$show['petugas_unit']."' ";
        if($show['tgl_transaksi'].'|'.$show['kode_transaksi'].'|'.$show['namaunit'].' - '.$show['namalokasi'].'|'.$show['petugas_gudang'].'|'.$show['petugas_unit'] == $no_po)
            $cmbNoPo .= 'selected';
        $cmbNoPo .= " >"
                .$show['tgl_transaksi'].' / '.$show['kode_transaksi']
                ."</option>";
    }
    $cmbNoPo .= "</select>";
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Pengeluaran Baru :.</title>
    </head>
    <body>
        
        <div align="center">
        <div id="divbon" align="left" style="position:absolute; z-index:1; left: 100px; top: 300px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <?php
            include("../header.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table border="0" width="1000" cellpadding="0" cellspacing="2" bgcolor="#FFFBF0">
                <tr>
                    <td colspan="10" height="20">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" style="font-size:16px;" colspan="15">PENGELUARAN BON</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <form id="form1" name="form1" action="" method="post" onSubmit="save()">
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="data_submit" name="data_submit" value="" />
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="15%">No Pengeluaran</td>
                        <td width="20%">&nbsp;:&nbsp;
                            <input id="txtNoPen"  name="txtNoPen" value='<?php if($po_rekanan[5]==''){echo $noterima;}else{echo $po_rekanan[5];} ?>' <?php if($_GET['act'] == 'edit') echo 'readonly'?> class="txtcenter" size="20" /></td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Bon</td>
                        <td width="30%">&nbsp;:&nbsp;
                            <?php
                            //echo $cmbNoPo;
                            $val="";
                            $nopo="";
                            $disabled="";
                             if(strlen($_GET['id'])>0)$nopo=explode("|",$_GET['id']);
                             if(strlen($_GET['no_po'])>0)$nopo=explode("|",$_GET['no_po']);
                             if($nopo!="")$val= $nopo[0]." / ".$nopo[1];
                             if($act!="add")$disabled="disabled";                             
                            ?>
                            <input type="text" value="<?php echo $val;?>" <?php echo $disabled; ?> size="35" name="txtNoPo" id="txtNoPo"  class="txtinput" onKeyUp="suggest(event,this);" autocomplete="off"/></td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="12%">Tgl Pengeluaran</td>
                        <td width="16%">&nbsp;:&nbsp;
                            <input id="txtTgl" name="txtTgl" readonly value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                          /*   if($act != 'edit') { */
                                ?>
                            <!--img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);" /-->
                                <?php
                           // }
                            ?>                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="17%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="8%">&nbsp;Peruntukan</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input type="text" size="35" id="txtUntuk" name="txtUntuk" class="txtinput" value="<?php echo (($_GET['act'] == 'edit')?$peruntukan:$po_rekanan[2]);?>" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/>
                        </td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama Penerima</td>
                        <td>&nbsp;:&nbsp;
                            <input type="text" id="txtPenerima" name="txtPenerima" class="txtinput" value="<?php echo (($_GET['act'] == 'edit')?$petugas_rtp:$po_rekanan[4]);?>" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Petugas Gudang</td>
                        <td>&nbsp;:&nbsp;
                            <input type="text" id="txtPetGud" name="txtPetGud" class="txtinput" value="<?php echo (($_GET['act'] == 'edit')?$petugas_gudang:$po_rekanan[3]);?>" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8">&nbsp;</td>
						<td align="center">
						<?php if($_GET['act']=='edit'){?>
						<button type="button" id="cetak" name="cetak"Pengeluaran BON" style="cursor: pointer" onClick="window.open('../Aktivitas/pengeluaran_bon.php?&id=<? echo $no_po ?>');""><img alt="cancel" src="../icon/printer.png" border="0" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Preview Pengeluaran Bon </button><?php } ?></td>
						<td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="8" align="center">
                            <table id="tblpenerimaan" width="100%" border="0" cellpadding="1" cellspacing="0">
                                <tr class="headtable">
                                    <td width="40" height="25" class="tblheaderkiri">No</td>
                                    <td id="kodebarang" width="56" class="tblheader">
                                  <input type="checkbox" name="chkAll" id="chkAll" value="" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> onClick="fCheckAll(chkAll,chkItem);HitunghTot();" style="cursor:pointer" title="Pilih Semua" />                                    </td>
                                    <td width="100"  id="kodebarang" class="tblheader">Kode Barang</td>
                                  <td id="namabarang" width="301" class="tblheader"> <p>Nama Barang</p></td>
                                  <td id="uraian" width="146" class="tblheader"> <p>Uraian</p></td>
                                    <td id="satuan" width="70" class="tblheader">Satuan</td>
									<td width="55"  id="jmlKlr" class="tblheader">Jumlah Bon</td>
									<td id="stok" width="52" class="tblheader">Stok</td>
									 <td width="58"  id="jumlahbon" class="tblheader">Jml Yg Sudah Kirim</td>
                                    <td width="58"  id="jumlahbon" class="tblheader">Jml Keluar</td>
                                </tr>
                                <?php
                                if(isset($_GET['act']) && $_GET['act'] == 'edit' || isset($no_po)) {
                                    if($_GET['act'] == 'edit') {
                                        $sql = "SELECT klr_id,k.barang_id,kodebarang,namabarang,jml_klr,satuan,klr_uraian,jumlah_keluar
						FROM as_keluar k INNER JOIN as_ms_barang b 
						ON k.barang_id=b.idbarang
						WHERE tgl_transaksi='".$terima_po[0]."' AND kode_transaksi='".$terima_po[1]."'";                                        
                                    }
                                    else {
                                        if($no_po != '') {
                                             $sql = "SELECT klr_id,k.barang_id,kodebarang,namabarang,jml_klr,k.jumlah_keluar,satuan,klr_uraian
						FROM as_keluar k INNER JOIN as_ms_barang b 
						ON k.barang_id=b.idbarang
						WHERE tgl_transaksi='$po_rekanan[0]' AND kode_transaksi='$po_rekanan[1]'";
						
						
                                        }
                                    }
                                    //po.id,ms_barang_id,kemasan,qty_kemasan,harga_kemasan,harga_beli_total
                                    $rs=mysql_query($sql);
                                    $i=0;
                                    while ($rows=mysql_fetch_array($rs)) { 
									
									 
                                        $id = cekNull($rows['klr_id']);
                                        $idbarang = cekNull($rows['barang_id']);
                                        $kodebarang = cekNull($rows['kodebarang']);
                                        $namabarang = cekNull($rows['namabarang']);
                                        $uraian = cekNull($rows['klr_uraian']);
										$jml_keluar = cekNull($rows['jumlah_keluar']);
                                        $satuan = $rows['satuan'];
                                        $jumlahkeluar = $rows['jml_klr'];
										$sql1="SELECT jml_sisa FROM as_kstok  WHERE barang_id='".$rows['barang_id']."' ORDER BY stok_id DESC limit 1";
										$rs1=mysql_query($sql1);
										$rows1=mysql_fetch_array($rs1);
										$stok=$rows1['jml_sisa'];
										
                                        ?>
                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                    <td class="tdisikiri"><?php echo ++$i; ?></td>
                                    <td class="tdisi" align="center">
                                        <input type="checkbox" name="chkItem" id="chkItem" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> value="<?php echo $id.'|'.$idbarang; ?>" onClick="HitunghTot();" />
                                        <input type="hidden" id="keluar" value="<?php echo $id; ?>"/></td>
                                    <td class="tdisi" align="center"><input type="textbox" size="15" id="kodebarang" readonly value="<?php echo $kodebarang;?>" /> </td>
                                    <td class="tdisi" align="center"><input type="textbox" size="50"id="namabarang" readonly value="<?php echo $namabarang;?>" /></td>
                                    <td class="tdisi" align="center"><input type="textbox" id="uraian" readonly value="<?php echo $uraian;?>" /></td>
                                    <td class="tdisi" align="center"><input type="textbox" size="10" id="satuan" readonly value="<?php echo $satuan;?>" /></td>
									<td class="tdisi" align="center"><input type="textbox" style="text-align:center" size="5" id="jmlKLr" readonly value="<?php echo $jumlahkeluar;?>" /></td>
                                    <td class="tdisi" align="center"><input type="textbox"   style="text-align:center" size="5" id="stok" readonly value="<?php echo $stok;?>" /></td>				
									<td class="tdisi" align="center"><input type="textbox"  style="text-align:center" size="5" id="jumlahkeluar1" onKeyUp="cek(this,<?php echo $i;?>)" value="<?php echo $jml_keluar;?>" readonly /></td>
                                    <td class="tdisi" align="center"><input type="textbox"  style="text-align:center" size="5" id="jumlahkeluar" onKeyUp="cek(this,<?php echo $i;?>)" value="" /></td>
                                </tr>
                                        <?php
                                    }
                                    mysql_free_result($rs);
                                }
                                ?>
                            </table>
			</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>

                        <td colspan="4" align="right">
                            <?php if($_GET['act'] != 'edit') {?>
                            <button type="button" onClick="kirim();" style="cursor: pointer">
                                <img alt="save" src="../icon/save.gif" border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;                            </button>                        </td>
                            <?php }?>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='pengeluaranBon.php'" style="cursor: pointer">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;
                                <?php echo (($_GET['act'] == 'edit')?"Kembali":"Batal");?>
                                &nbsp;&nbsp;&nbsp;&nbsp
			    </button>
			</td>
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
        //HitungQtySatuan(< ?php echo ($i-1); ?>);HitungSubTotal(< ?php echo ($i-1); ?>);HitungDiskon(< ?php echo ($i-1); ?>,1);
        var arrRange=depRange=[];

        function kirim(){
            var data_submit = '';	    	    
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){				
                    if(document.forms[0].chkItem[i].checked==true){
                        data_submit += document.forms[0].chkItem[i].value
                            +'*-*'+document.forms[0].chkItem[i].checked
                            +'*-*'+document.forms[0].kodebarang[i].value
                            +'*-*'+document.forms[0].namabarang[i].value
                            +'*-*'+document.forms[0].satuan[i].value
                            +'*-*'+document.forms[0].jmlKLr[i].value
							+'*-*'+document.forms[0].jumlahkeluar1[i].value
                            +'*-*'+document.forms[0].jumlahkeluar[i].value+'*|*';
                    }
                }
            }
            else{
                if(document.forms[0].chkItem.checked==true){
                    data_submit = document.forms[0].chkItem.value
                        +'*-*'+document.forms[0].chkItem.checked
                        +'*-*'+document.forms[0].kodebarang.value
                        +'*-*'+document.forms[0].namabarang.value
                        +'*-*'+document.forms[0].satuan.value
                        +'*-*'+document.forms[0].jmlKLr.value
						+'*-*'+document.forms[0].jumlahkeluar1.value
                        +'*-*'+document.forms[0].jumlahkeluar.value+'*|*';
                }
            }
			//alert(data_submit);
            document.forms[0].data_submit.value = data_submit;
            if(document.forms[0].data_submit.value!=''){
                document.getElementById('form1').submit();
            }
            else{
                alert("pilih dulu barang yang akan disimpan!");
            }

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

        function HitungDiskon(line,which){
            if (document.forms[0].chkItem.length){
                var sub_tot = document.forms[0].sub_tot[line].value;
                if(which == 1){
                    var diskon = document.forms[0].diskon[line].value;
                    document.forms[0].diskon_rp[line].value = sub_tot*diskon/100;
                }
                else{
                    var diskon_rp = document.forms[0].diskon_rp[line].value;
                    document.forms[0].diskon[line].value = diskon_rp*100/sub_tot;
                }
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var sub_tot = document.forms[0].sub_tot.value;
                if(which == 1){
                    var diskon = document.forms[0].diskon.value;
                    document.forms[0].diskon_rp.value = sub_tot*diskon/100;
                }
                else{
                    var diskon_rp = document.forms[0].diskon_rp.value;
                    document.forms[0].diskon.value = diskon_rp*100/sub_tot;
                }
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

        function HitungSubTotal(line){
            var qty_kemasan,h_kemasan;
            if(document.forms[0].chkItem.length){
                qty_kemasan = document.forms[0].qty_kemasan[line].value;
                h_kemasan = document.forms[0].h_kemasan[line].value;
                document.forms[0].sub_tot[line].value = qty_kemasan*h_kemasan;
            }
            else{
                qty_kemasan = document.forms[0].qty_kemasan.value;
                h_kemasan = document.forms[0].h_kemasan.value;
                document.forms[0].sub_tot.value = qty_kemasan*h_kemasan;
            }
        }

        function HitungHargaSatuan(line){
            if (document.forms[0].chkItem.length){
                var qty_per_kemasan = document.forms[0].qty_per_kemasan[line].value;
                var h_kemasan = document.forms[0].h_kemasan[line].value;
                document.forms[0].h_satuan[line].value = (h_kemasan/qty_per_kemasan).toFixed(2);
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var qty_per_kemasan = document.forms[0].qty_per_kemasan.value;
                var h_kemasan = document.forms[0].h_kemasan.value;
                document.forms[0].h_satuan.value = (h_kemasan/qty_per_kemasan).toFixed(2);
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

        function HitungQtySatuan(line){
            if (document.forms[0].chkItem.length){
                var qty_kemasan = document.forms[0].qty_kemasan[line].value;
                var qty_per_kemasan = document.forms[0].qty_per_kemasan[line].value;
                document.forms[0].qty_satuan[line].value = qty_kemasan*qty_per_kemasan;
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var qty_kemasan = document.forms[0].qty_kemasan.value;
                var qty_per_kemasan = document.forms[0].qty_per_kemasan.value;
                document.forms[0].qty_satuan.value = qty_kemasan*qty_per_kemasan;
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

        function HitunghDiskonTot(){
            var tmp = 0;
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    if(document.forms[0].chkItem[i].checked){
                        //alert(document.forms[0].diskon_rp[i].value);
                        tmp += document.forms[0].diskon_rp[i].value*1;
                    }
                }
            }
            else{
                tmp = document.forms[0].diskon_rp.value;
            }
            document.forms[0].txtDiskon.value = tmp;
        }

        function HitunghTot(){
            var tmp = 0;
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    if(document.forms[0].chkItem[i].checked){
                        tmp += document.forms[0].sub_tot[i].value*1;
                    }
                }
            }
            else{
                tmp = document.forms[0].sub_tot.value;
            }
            document.forms[0].txtHrgTtl.value = tmp;
            var hargaTtl = tmp;
            var diskon = document.forms[0].txtDiskon.value;
            document.forms[0].txtHarga.value = hargaTtl-diskon;
            var ppn = (hargaTtl-diskon)*10/100;
            document.forms[0].txtPPN.value = ppn;
            document.forms[0].txtTotal.value = (hargaTtl-diskon)+ppn;
        }
        var RowIdx;
        var fKeyEnt;
        function suggest(e,par){
            var keywords=par.value;            
            //alert(keywords);
            //alert(par.offsetLeft);
            /*var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }*/
            //alert(jmlRow+'-'+i);
            if(keywords==""){
                document.getElementById('divbon').style.display='none';
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
                }
                else if (key==13){
                    if (RowIdx>0){
                        if (fKeyEnt==false){
                            set2(document.getElementById(RowIdx).lang);
                        }else{
                            fKeyEnt=false;
                        }
                    }
                }
                else if (key!=27 && key!=37 && key!=39){
                    RowIdx=0;
                    fKeyEnt=false;
                    Request('bonlist.php?aKeyword='+keywords, 'divbon', '', 'GET' );
                    if (document.getElementById('divbon').style.display=='none') {fSetPosisi(document.getElementById('divbon'),par);}
                    document.getElementById('divbon').style.display='block';
                }
            }
        }
        function set()
        {
            var nopo = document.getElementById('cmbNoPo').value;
            
            window.location = "pengeluaranBon_detil.php?act=<?php echo $act;?>&no_po="+nopo;
        }
        function set2(lang)
        {
            var nopo = lang;
            
            window.location = "pengeluaranBon_detil.php?act=<?php echo $act;?>&no_po="+nopo;
        }
		function cek(p,inc){
		var val=p.value;
	//	alert(document.forms[0].jumlahkeluar[inc-1].value +" in - "+document.forms[0].jmlKLr[inc-1].value);
		 var nopo = document.getElementById('txtNoPo').value;
		 var txtUntuk = document.getElementById('txtUntuk').value;
		 var txtPenerima = document.getElementById('txtPenerima').value;
		 var wich="no_po";
		  var x = parseInt(document.forms[0].jumlahkeluar[inc-1].value)+parseInt(document.forms[0].jumlahkeluar1[inc-1].value);
		 if (document.getElementById('act').value=='edit')wich="id";
		 if(isNaN(val)){
		 	alert("Inputan harus diisi numeric !");
			location="pengeluaranBon_detil.php?act=<?php echo $act;?>&"+wich+"=<?php echo $no_po; ?>";
			//return;
		 }
		
		 else if(x > parseInt(document.forms[0].jmlKLr[inc-1].value)){
			alert('Jumlah Keluar Tidak Boleh Lebih Besar Dari Jumlah Bon !');
			location="pengeluaranBon_detil.php?act=<?php echo $act;?>&"+wich+"=<?php echo $no_po; ?>";
			} 
		}
    </script>
</html>
