<?php
/*
detailPenerimaan.php ini adalah file yang berfungsi sebagai insert data dan update data dari file penerimaanPO.php.
Pada file detailPenerimaan.php ini terdiri dari 2 bagian yaitu tampilan form interface dan program pengolahan databasenya.
Pada file ini memakai metode post dalam penyimpanan data melalui form dengan action file ini sendiri.
Dan perlu diperhatikan juga bahwa penerimaanPO.php mengirimkan beberapa parameter ke file ini melaui metode GET.
Proses:
A. insert database aset dengan tabel:
    - as_masuk
    - as_kstok
    - as_po
B. proses insert:
    1. Dimulai dengan memasukkan data ke tabel as_masuk.
    2. Meng-update qty_terima pada tabel as_po sesuai dengan jml_msk pada tabel as_masuk.
    3. Memeriksa jumlah qty_satuan dan qty_terima, jika sama maka update kolom status pada tabel as_po dengan 1 jika tidak sama 0.
    4. Kemudian Mengambil msk_id yang baru saja dimasukkan pada tabel as_masuk.
    5. Mengambil jumlah sisa dan nilai sisa terakhir (sebelumnya) dari tabel as_kstok dengan barang id yang sama, karena akan digunakan dalam penyimpanan
        jumlah awal dan nilai awal pada tabel as_kstok.
    6. Insert data ke tabel as_kstok.
C. proses update:
    1. Update data pada tabel as_masuk berdasarkan no_po dan no_gudang.
    2. Meng-update qty_terima pada tabel as_po sesuai dengan jml_msk pada tabel as_masuk.
    3. Memeriksa jumlah qty_satuan dan qty_terima, jika sama maka update kolom status pada tabel as_po dengan 1 jika tidak sama 0.
    4. Kemudian Mengambil msk_id dan data yang diperlukan dari as_masuk.
    5. Mengambil jumlah sisa dan nilai sisa terakhir (sebelumnya) dari tabel as_kstok dengan barang id yang sama, karena akan digunakan dalam penyimpanan
        jumlah awal dan nilai awal pada tabel as_kstok.
    6. Insert ke as_kstok dimana jumlah keluar diisi dengan jumlah masuk dari as_masuk yang telah diambil sebelumnya.
    7. Mengambil sisa lagi seperti no. 5.
    8. Insert ke as_kstok dimana jumlah masuk diisi sesuai dengan input user.
*/
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
}
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $txtNoPen = cekNull($_POST['txtNoPen']);
    
    $txtIdBarang = cekNull($_POST['txtIdBarang']);    
    $txtTgl = tglSQL($_POST['txtTgl']);
    $txtTotal = cekNull($_POST['txtTotal']);
    $cmbNoPo = cekNull(explode('|', $_POST['cmbNoPo']));
    $txtFaktur = cekNull($_POST['txtFaktur']);
    $tglFaktur = cekNull(tglSQL($_POST['txtTglFaktur']));
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
            $qty_satuan = $data_fill[2];//txtJmlSatuan
            $satuan = $data_fill[3];//txtSatuan
            $qty_per_kemasan = $data_fill[4];//txtJmlPerKemasan
            $h_satuan = $data_fill[5];//txtHrgSatuan
            $id=$data_fill[6];
            $txtIdBarang=$data_fill[8];
            if($penerimaan == 'true') {
                $query = "insert into as_masuk (po_id,tgl_act,tgl_terima,no_gudang,tgl_faktur,no_faktur,barang_id,jml_msk,satuan_unit,harga_unit,pengirim,penerima,sisa) values
                    ('$id', now(), '$txtTgl', '$txtNoPen','$tglFaktur','$txtFaktur','$txtIdBarang','$qty_per_kemasan','$satuan','$h_satuan','$txtPengirim','$PetGud','$qty_per_kemasan')";
                //echo $query ."<br>";
                $sukses=mysql_query($query);
                
                //$qPo="update as_po set qty_terima='$qty_per_kemasan' where id='$id'";
				$qPo="update as_po set qty_terima='$qty_per_kemasan',STATUS=IF(qty_satuan='$qty_per_kemasan',1,0) where id='$id'";
				
                mysql_query($qPo);
                
                /*$qPo2="select qty_satuan,qty_terima from as_po where id='$id'";
                $rsPo2=mysql_query($qPo2);
                $rwPo2=mysql_fetch_array($rsPo2);
                
                if($rwPo2['qty_satuan']==$rwPo2['qty_terima']){
                    $qPo3="update as_po set status='1' where id='$id'";                    
                }
                else{
                    $qPo3="update as_po set status='0' where id='$id'";
                }
                mysql_query($qPo3);
                mysql_free_result($rsPo2);
				*/
				
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
                if(mysql_error()!=''){
                    echo "ERROR: ".mysql_error()."<br>";
                }
                mysql_free_result($rsMasuk);
                mysql_free_result($rsKstok);                
            }
        }
        header('location:detailPenerimaan.php');
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
            $id=$data_fill[6];
            $poid=$data_fill[7];
            $txtIdBarang=$data_fill[8];

           
  $query = "update as_masuk set tgl_act=now(),tgl_terima='".$txtTgl."',tgl_faktur='$tglFaktur',no_faktur='$txtFaktur',barang_id='$txtIdBarang',jml_msk='$qty_per_kemasan',satuan_unit='$satuan',harga_unit='$h_satuan',pengirim='$txtPengirim',penerima='$PetGud',sisa='$qty_per_kemasan'                
            where po_id='$poid' and no_gudang='$txtNoPen'";            
            $sukses=mysql_query($query);
            
            $qPo="update as_po set qty_terima='$qty_per_kemasan' where id='$poid'";
            mysql_query($qPo);
            
            $qPo2="select qty_satuan,qty_terima from as_po where id='$poid'";
            $rsPo2=mysql_query($qPo2);
            $rwPo2=mysql_fetch_array($rsPo2);
            
            if($rwPo2['qty_satuan']==$rwPo2['qty_terima']){
                $qPo3="update as_po set status='1' where id='$poid'";
                
            }else{
                $qPo3="update as_po set status='0' where id='$poid'";
            }
            mysql_query($qPo3);
            mysql_free_result($rsPo2);
            
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
            if(mysql_error()!=''){
                echo "ERROR: ".mysql_error()."<br>";
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
    $sql = "select * from as_masuk pe inner join as_po po on pe.po_id = po.id
                where no_gudang = '".$terima_po[0]."' and no_po = '".$terima_po[1]."'";

    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $noGudang = $rows1['no_gudang'];
        $noFaktur = $rows1['no_faktur'];        
        $tgl = tglSQL($rows1['tgl_terima']);
        $tgl_faktur = tglSQL($rows1['tgl_faktur']);
        $pengirim = $rows1['pengirim'];
        $penerima = $rows1['penerima'];        
        mysql_free_result($rs1);
    }

    $cmbNoPo = "<select name='cmbNoPo' disabled class='txtcenter' id='cmbNoPo' onchange='set()'>";
    $qry = "SELECT distinct po.no_po, vendor_id, rek.namarekanan
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
            where po.no_po = '".$terima_po[1]."'";
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan']."' >"
                .$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
        //po_rekanan menggunakan array untuk mengikuti po_rekanan yang sebelumnya sudah dibuat & digunakan
        $po_rekanan[2] = $show['namarekanan'];
    }
    $cmbNoPo .= "</select>";
}
else {
    $sql="select no_gudang from as_masuk order by msk_id desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $noGudang=$rows1["no_gudang"];
        $ctmp=explode("/",$noGudang);
        $dtmp=$ctmp[3]+1;
        $ctmp=$dtmp;
        for ($i=0; $i<(4-strlen($dtmp)); $i++)
            $ctmp = "0".$ctmp;
        $noGudang = "GD/RCV/$th[2]-$th[1]/$ctmp";
    }
    else {
        $noGudang = "GD/RCV/$th[2]-$th[1]/0001";
    }

    $cmbNoPo = "<select name='cmbNoPo' class='txtcenter' id='cmbNoPo' onchange='set()'>
        <option value='' class='txtcenter'>Pilih PO</option>";
    $qry='SELECT distinct po.no_po, vendor_id, rek.namarekanan
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
            where po.status = 0';
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) {
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan']."' ";
        if($show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'] == $no_po)
            $cmbNoPo .= 'selected';

        $cmbNoPo .= " >"
                .$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
    }
    $cmbNoPo .= "</select>";
}
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
                    <td align="center" style="font-size:16px;" colspan="15">PENERIMAAN PO</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <form id="form1" name="form1" action="" method="post">
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="data_submit" name="data_submit" value="<?php echo $_POST['data_submit'];?>" />
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;No Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtNoPen" name="txtNoPen" value='<?php echo $noGudang; ?>' class="txtcenter" size="20" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/></td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5">&nbsp;No PO  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        <?php
                            echo $cmbNoPo;
                            ?></td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Tgl Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtTgl" name="txtTgl" value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                            if($act != 'edit') {
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);" />
                                <?php
                            }
                            ?>                        </td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5">&nbsp;Supplier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;: &nbsp;<?php echo $po_rekanan[2];?></td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;No Faktur</td>
                      <td width="18%">&nbsp;:&nbsp;
                        <input id="txtFaktur" name="txtFaktur" value="<?php echo $noFaktur; ?>" class="txtcenter" size="15" />
                      <td>&nbsp;</td>
                        <td colspan="5">&nbsp;Jatuh Tempo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $exp_kirim;?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Tgl Faktur</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtTglFaktur" name="txtTglFaktur" value="<?php if(isset($tglFaktur) ) echo $tglFaktur; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                            if($act != 'edit') {
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTglFaktur'),depRange);" />
                                <?php
                            }
                            ?>
                        </td>
                        <td width="8%">&nbsp;</td>
                        <td colspan="5">&nbsp;</td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;Pengirim</td>
                      <td width="18%">&nbsp;:&nbsp;
                        <input id="txtPengirim" name="txtPengirim" class="txtinput" size="15" value="<?php echo isset($pengirim)?$pengirim:"";?>" />
                      <td>&nbsp;</td>
                        <td colspan="5"></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;Petugas Gudang</td>
                      <td width="18%">&nbsp;:&nbsp;
                        <input id="txtPetGud" name="txtPetGud" value="<?php echo isset($penerima)?$penerima:"";?>" class="txtinput" size="15" />
                      <td>&nbsp;</td>
                        <td colspan="5"></td>
                        <td>&nbsp;</td>
                    </tr>                   
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="8" align="center">
                            <table id="tblpenerimaan" width="100%" border="0" cellpadding="1" cellspacing="0">
                                <tr class="headtable">
                                    <td width="44" height="25" class="tblheaderkiri">No</td>
                                    <td id="kodebarang" width="31" class="tblheader">
                                      <input type="checkbox" name="chkAll" id="chkAll" value="" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> onClick="fCheckAll(this,'chkItem');/*HitunghDiskonTot();*/HitunghTot();" style="cursor:pointer" title="Pilih Semua" />                                    </td>
                                  <td width="66" class="tblheader" id="namabarang">Kode Barang</td>
                                  <td id="qty_kemasan" width="184" class="tblheader">
                                    <p>Nama Barang</p></td>
                                  <td id="kemasan" width="78" class="tblheader">Satuan</td>
                                    <td width="84" class="tblheader">Jumlah Pesan</td>
                                     <td width="81" class="tblheader">Jumlah Telah Diterima</td>
                                  <td width="81" class="tblheader">Jumlah Diterima</td>
                                    <td width="153" class="tblheader">Harga Satuan</td>
                                  <td width="179" class="tblheader">Sub Total</td>
                              </tr>
                                <?php
                                if(isset($_GET['act']) && $_GET['act'] == 'edit' || isset($no_po)) {
                                    if($_GET['act'] == 'edit') {
                                        $sql = "select q1.*,namabarang,kodebarang from
                                                (SELECT pe.*, po.no_po, qty_satuan, satuan,harga_satuan,po.qty_terima
                                                FROM as_masuk pe inner join as_po po on pe.po_id = po.id
                                                where pe.no_gudang = '$terima_po[0]' and po.no_po = '$terima_po[1]'
                                                order by pe.msk_id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.barang_id";
                                        //no_po, tgl, tgl_j_tempo, hari_j_tempo, qty_kemasan, qty_kemasan_terima, kemasan, harga_kemasan, qty_perkemasan, qty_satuan, qty_pakai, qty_satuan_terima, satuan, harga_beli_total, harga_beli_satuan, diskon, extra_diskon, diskon_total, ket, nilai_pajak, jenis, termasuk_ppn, status, user_act, tgl_act
                                    }
                                    else {
                                        if($no_po != '') {
                                            $sql = "select q1.*,b.namabarang,b.kodebarang from (SELECT *
                                                FROM as_po po
                                                where po.no_po = '$po_rekanan[0]' and status = 0
                                                order by po.id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id";
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
                                        $subtotal = cekNull($rows['subtotal']);
                                        $total = cekNull($rows['total']);
                                        $exp_kirim = $rows['exp_kirim'];
                                        $satuan = $rows['satuan'];
                                        $kemasan = $rows['kemasan'];     
                                        $qty_kemasan = cekNull($rows['qty_kemasan']);
                                        $qty_kemasan_terima = cekNull($rows['jml_msk']);
                                        $qty_satuan = cekNull($rows['qty_satuan']);
                                        //jika act bukan edit, maka isi qty_kemasan_terima = database
                                        if($_GET['act'] != 'edit'){
                                            $qty_kemasan_terima = cekNull($rows['qty_satuan']);
                                            $idbarang=cekNull($rows['ms_barang_id']);
                                        }
                                        $qty_terima=cekNull($rows['qty_terima']);
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
                                          <?php echo $kodebarang; ?>
                                        </td>
                                    <td class="tdisi" align="center">                                        
                                        <?php echo $namabarang; ?></td>
                                    <td class="tdisi" align="center">
                                    <input id="txtSatuan" name="txtSatuan" type="text" class="txtcenter" size="7" readonly="readonly" value="<?php echo $satuan; ?>" />                                    
                                    </td>
                                <td class="tdisi" align="center">
                                <input id="txtJmlSatuan" name="txtJmlSatuan" type="text" class="txtcenter" size="7" readonly="readonly" value="<?php echo $qty_satuan; ?>" />
                                      
                                    </td>
                                <td class="tdisi" align="center">
                                    <input id="txtJmlDiterima" name="txtJmlDiterima" type="text" class="txtcenter" size="7" readonly="readonly" value="<?php echo $qty_terima; ?>" />
                                </td>
                                    <td class="tdisi" align="center">
                                        <input id="txtJmlPerKemasan" name="txtJmlPerKemasan" type="text" class="txtcenter" value="<?php echo $qty_kemasan_terima; ?>" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);" size="7" />
                                    </td>
                                    <td class="tdisi" align="center">
                                    <input id="txtHrgSatuan" name="txtHrgSatuan" type="text" class="txtright"readonly="readonly" value="<?php echo $harga_satuan; ?>" />
                                    </td>
                                    <td class="tdisi" align="center">
                                    <input id="txtSubTotal" name="txtSubTotal" type="text" class="txtright" readonly="readonly" value="<?php echo $qty_satuan*$harga_satuan; ?>" />
                                    </td>
                                </tr>
                                        <?php
                                        $tot+=($qty_satuan*$harga_satuan);
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
                            <button type="button" onClick="if (ValidateForm('txtFaktur,txtPengirim,txtPetGud','ind')){kirim();}" style="cursor: pointer">
                                <img alt="save" src="../icon/save.gif" border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
                        </td>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='penerimaanPO.php'" style="cursor: pointer">
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

        function kirim(){
            var data_submit = '';            
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    data_submit += document.forms[0].chkItem[i].value+'*-*'+document.forms[0].chkItem[i].checked
                        +'*-*'+document.forms[0].txtJmlSatuan[i].value
                        +'*-*'+document.forms[0].txtSatuan[i].value
                        +'*-*'+document.forms[0].txtJmlPerKemasan[i].value                        
                        +'*-*'+document.forms[0].txtHrgSatuan[i].value
                        +'*-*'+document.forms[0].txtId[i].value
                        +'*-*'+document.forms[0].txtPoId[i].value
                        +'*-*'+document.forms[0].txtIdBarang[i].value
                        +'*|*';
                }                
            }
            else{
                data_submit = document.forms[0].chkItem.value+'*-*'+document.forms[0].chkItem.checked
                    +'*-*'+document.forms[0].txtJmlSatuan.value
                    +'*-*'+document.forms[0].txtSatuan.value
                    +'*-*'+document.forms[0].txtJmlPerKemasan.value                        
                    +'*-*'+document.forms[0].txtHrgSatuan.value
                    +'*-*'+document.forms[0].txtId.value
                    +'*-*'+document.forms[0].txtPoId.value
                    +'*-*'+document.forms[0].txtIdBarang.value
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
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan[line].value;
                document.forms[0].qty_satuan[line].value = qty_kemasan*qty_per_kemasan;
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var qty_kemasan = document.forms[0].qty_kemasan.value;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan.value;
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
                        tmp += document.forms[0].txtSubTotal[i].value*1;
                    }
                }
            }
            else{
                tmp = document.forms[0].txtSubTotal.value;
            }
           
            document.forms[0].txtTotal.value =tmp;
        }

        function set()
        {
            var nopo = document.getElementById('cmbNoPo').value;
            //alert(nopo);          
            //alert("detailPenerimaan.php?act=<?php echo $act;?>&no_po="+nopo);
            window.location = "detailPenerimaan.php?act=<?php echo $act;?>&no_po="+nopo;
        }
        
        function bandingkan(kiri,kanan){
            if(!isNaN(kiri) && !isNaN(kanan)){
                if(kiri>kanan){
                    return "lebih besar";
                }
                else if(kiri<kanan){
                    return "lebih kecil";
                }
                else if(kiri==kanan){
                    return "sama";
                }
            }
            else{
                alert('Isilah Dengan Angka!');
            }
        }
        function HitungSubTotal(line){
            if (document.forms[0].chkItem.length){                
                var h_kemasan = document.forms[0].txtHrgSatuan[line].value;
                var qty_satuan = document.forms[0].txtJmlSatuan[line].value;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan[line].value;
                if(bandingkan(qty_satuan,qty_per_kemasan)=='lebih kecil'){
                    alert('Tidak boleh melebihi jumlah pesan!');
                    document.forms[0].txtJmlPerKemasan[line].value='';
                }
                else{
                    document.forms[0].txtSubTotal[line].value = h_kemasan*qty_per_kemasan;
                }
                if(document.forms[0].chkItem[line].checked){
                    //HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var h_kemasan = document.forms[0].txtHrgSatuan.value;
                var qty_satuan = document.forms[0].txtJmlSatuan.value;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan.value;
                 if(bandingkan(qty_satuan,qty_per_kemasan)=='lebih kecil'){
                    alert('Tidak boleh melebihi jumlah pesan!');
                    document.forms[0].txtJmlPerKemasan.value='';
                }
                else{
                    document.forms[0].txtSubTotal.value = h_kemasan*qty_per_kemasan;
                }
               if(document.forms[0].chkItem.checked){                    
                    HitunghTot();
                }
            }
        }
    </script>
</html>
