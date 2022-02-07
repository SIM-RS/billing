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
}
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $txtNoPen = cekNull($_POST['txtNoPen']);
    $txtHrgTtl = cekNull($_POST['txtHrgTtl']);
    $pajak = cekNull($_POST['txtPPN']);
    $txtTgl = cekNull(tglSQL($_POST['txtTgl']));
    $txtDiskon = cekNull($_POST['txtDiskon']);
    $txtTotal = cekNull($_POST['txtTotal']);
    $cmbNoPo = cekNull(explode('|', $_POST['cmbNoPo']));
    $txtHarga = cekNull($_POST['txtHarga']);
    $txtTempo = cekNull($_POST['txtTempo']);
    $txtFaktur = cekNull($_POST['txtFaktur']);
    $data_submit = explode('*|*',$_POST['data_submit']);
    if($act == 'add') {
        for($i=0; $i<count($data_submit)-1; $i++) {
            $penerimaan = false;
            $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);
            $chkItem2 = $data_fill[1];
            $qty_kemasan = $data_fill[2];
            $kemasan = $data_fill[3];
            $h_kemasan = $data_fill[4];
            $qty_per_kemasan = $data_fill[5];
            $qty_satuan = $data_fill[6];
            $satuan = $data_fill[7];
            $h_satuan = $data_fill[8];
            $diskon = $data_fill[9];
            $hid_qty_kemasan = $data_fill[10];
            if($chkItem2 == 'true') {
                $penerimaan = true;
                $status = 1;
                if($qty_kemasan < $hid_qty_kemasan) {
                    $status = 0;
                }
                $status_terima = ", status = $status, qty_kemasan_terima = '$qty_kemasan' ";
            }
            else {

            }
            $user_act = $_SESSION['userid'];
            //$txtNoPen = $_POST[''];

            //txtNoPen txtHrgTtl txtPPN txtTgl txtDiskon txtTotal cmbNoPo txtHarga txtTempo txtFaktur
            $query = "update as_po set kemasan = '$kemasan' $status_terima, harga_kemasan = '$h_kemasan', qty_perkemasan = '$qty_per_kemasan'
                      , qty_satuan = '$qty_satuan', satuan = '$satuan', harga_beli_total = '$txtTotal', harga_beli_satuan = '$h_satuan', diskon = '$diskon'
                      , diskon_total = '$txtDiskon', tgl_j_tempo = ADDDATE('$txtTgl', INTERVAL $txtTempo DAY), hari_j_tempo = $txtTempo
                      , nilai_pajak = '$pajak', user_act = '$user_act', tgl_act = now()
                    where id = '$chkItem1[0]'";
            mysql_query($query);
            //tgl_j_tempo = '$', hari_j_tempo = '$', qty_pakai = '$', qty_satuan_terima = '$', ket = '$', nilai_pajak = '$', jenis = '$', termasuk_ppn = '$', extra_diskon = '$',

            if($penerimaan == 'true') {
                $query = "insert into as_penerimaan (ms_barang_id,fk_minta_id, noterima, suplier_id, user_id_terima, tgl_act, tgl, tgl_j_tempo
                    , hari_j_tempo, qty_kemasan, kemasan, harga_kemasan, qty_per_kemasan, qty_satuan, satuan, nilai_pajak
                    ,harga_beli_total, harga_beli_satuan, diskon, diskon_total, nobukti) values
                    ('$chkItem1[1]', '$chkItem1[0]', '$txtNoPen', '$cmbNoPo[1]', '$user_act', now(), '$txtTgl', ADDDATE('$txtTgl', INTERVAL $txtTempo DAY)
                    , $txtTempo, '$qty_kemasan', '$kemasan', '$h_kemasan', '$qty_per_kemasan', '$qty_satuan', '$satuan', '$pajak'
                    , '$txtTotal', '$h_satuan', '$diskon', '$txtDiskon', '$txtFaktur')";
                mysql_query($query);
                //id_lama = '$', unit_id_kirim, unit_id_terima, nokirim, noterima, nobukti, tgl_terima_act, tgl_terima, qty_stok, qty_retur, extra_diskon, ket, nilai_pajak, jenis, tipe_trans, status
                //user_id_kirim, '$user_act', SUBSTRING(ADDDATE('$txtTgl', INTERVAL $txtTempo DAY),9,2)
            }
        }
        header('location:penerimaanBaru.php');
    }
    else if($act == 'edit') {
        for($i=0; $i<count($data_submit)-1; $i++) {
            $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);
            //$chkItem2 = $data_fill[1];
            $qty_kemasan = $data_fill[2];
            $kemasan = $data_fill[3];
            $h_kemasan = $data_fill[4];
            $qty_per_kemasan = $data_fill[5];
            $qty_satuan = $data_fill[6];
            $satuan = $data_fill[7];
            $h_satuan = $data_fill[8];
            $diskon = $data_fill[9];
            $hid_qty_kemasan = $data_fill[10];
            $user_act = $_SESSION['userid'];

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
        }
    }
}

$act = 'add';
if(isset($_GET['act'])) {
    $act = $_GET['act'];
}
if($_GET['id'] != '' && isset($_GET['id']) && $_GET['act'] == 'edit') {
    $sql = "select distinct noterima,nobukti,pe.harga_beli_total,pe.diskon_total,pe.hari_j_tempo,date_format(pe.tgl, '%d-%m-%Y') as tgl,pe.nilai_pajak
                from as_penerimaan pe inner join as_po po on pe.fk_minta_id = po.id
                where noterima = '".$terima_po[0]."' and no_po = '".$terima_po[1]."'";

    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $noterima = $rows1['noterima'];
        $nobukti = $rows1['nobukti'];
        $pajak = $rows1['nilai_pajak'];
        $total = $rows1['harga_beli_total'];
        $diskon_total = $rows1['diskon_total'];
        $tgl = $rows1['tgl'];
        $tgl_j_tempo = $rows1['hari_j_tempo'];
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
    $sql="select noterima from as_penerimaan order by id desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $noterima=$rows1["noterima"];
        $ctmp=explode("/",$noterima);
        $dtmp=$ctmp[3]+1;
        $ctmp=$dtmp;
        for ($i=0; $i<(4-strlen($dtmp)); $i++)
            $ctmp = "0".$ctmp;
        $noterima = "GD/RCV/$th[2]-$th[1]/$ctmp";
    }
    else {
        $noterima = "GD/RCV/$th[2]-$th[1]/0001";
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
                    <input type="hidden" id="data_submit" name="data_submit" value="" />
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;No Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtNoPen" readonly name="txtNoPen" value='<?php echo $noterima; ?>' class="txtcenter" size="20" /></td>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Harga Total</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtHrgTtl" name="txtHrgTtl" align="right" value="<?php echo $total-$pajak+$diskon_total; ?>" readonly class="txtright" size="15"/>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="8%">&nbsp;PPN (10%)</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtPPN" name="txtPPN" align="right" value="<?php if(isset($pajak)) echo $pajak; else echo 0; ?>" readonly class="txtright" size="15" />
                        </td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Tgl Penerimaan</td>
                        <td width="18%">&nbsp;:&nbsp;
                            <input id="txtTgl" class="txtcenter" name="txtTgl" value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                            if($act != 'edit') {
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);" />
                                <?php
                            }
                            ?>
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="10%">&nbsp;Diskon Total</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtDiskon" class="txtright" align="right" value="<?php if(isset($diskon_total)) echo $diskon_total; else echo 0; ?>" readonly name="txtDiskon" size="15" />
                        </td>
                        <td width="5%">&nbsp;</td>
                        <td width="8%">&nbsp;TOTAL</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtTotal" class="txtright" align="right" value="<?php if(isset($total)) echo $total; else echo 0; ?>" readonly name="txtTotal" size="15" />
                        </td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;No PO
                            &nbsp;:&nbsp;
                            <?php
                            echo $cmbNoPo;
                            ?>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;Harga Diskon</td>
                        <td>&nbsp;:&nbsp;
                            <input id="txtHarga" class="txtright" name="txtHarga" value="<?php if(!isset($total) || !isset($pajak)) echo 0; else echo $total-$pajak; ?>" readonly align="right" size="15" />
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;Jatuh Tempo</td>
                        <td>&nbsp;:&nbsp;
                            <input id="txtTempo" name="txtTempo" class="txtright" size="9" value="<?php if(!isset($tgl_j_tempo)) echo 0; else echo $tgl_j_tempo; ?>" />&nbsp;Hari
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;No Faktur</td>
                        <td>&nbsp;:&nbsp;
                            <input id="txtFaktur" name="txtFaktur" value="<?php echo $nobukti; ?>" class="txtcenter" size="15" />
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;Supplier</td>
                        <td>&nbsp;:&nbsp;
                            <?php echo $po_rekanan[2];?>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
                                    <td width="30" height="25" class="tblheaderkiri">No</td>
                                    <td id="kodebarang" width="20" class="tblheader">
                                        <input type="checkbox" name="chkAll" id="chkAll" value="" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> onClick="fCheckAll(chkAll,chkItem);HitunghDiskonTot();HitunghTot();" style="cursor:pointer" title="Pilih Semua" />
                                    </td>
                                    <td id="namabarang" class="tblheader">Nama Barang</td>
                                    <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
                                    <td id="kemasan" width="50" class="tblheader">Kemasan</td>
                                    <td width="40" class="tblheader">Harga Kemasan </td>
                                    <td width="40" class="tblheader">Isi / Ke masan</td>
                                    <td width="40" class="tblheader">Qty Satuan </td>
                                    <td width="50" class="tblheader">Satuan</td>
                                    <td width="50" class="tblheader">Harga Satuan </td>
                                    <td width="60" class="tblheader">Sub Total </td>
                                    <td width="30" class="tblheader">Disk (%) </td>
                                    <td width="50" class="tblheader">Diskon (Rp) </td>
                                </tr>
                                <?php
                                if(isset($_GET['act']) && $_GET['act'] == 'edit' || isset($no_po)) {
                                    if($_GET['act'] == 'edit') {
                                        $sql = "select q1.*,namabarang from
                                                (SELECT pe.*, po.id as po_id, vendor_id, no_po, qty_kemasan_terima, qty_perkemasan, qty_pakai, qty_satuan_terima, termasuk_ppn
                                                FROM as_penerimaan pe inner join as_po po on pe.fk_minta_id = po.id
                                                where pe.noterima = '$terima_po[0]' and po.no_po = '$terima_po[1]'
                                                order by pe.id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id";
                                        //no_po, tgl, tgl_j_tempo, hari_j_tempo, qty_kemasan, qty_kemasan_terima, kemasan, harga_kemasan, qty_perkemasan, qty_satuan, qty_pakai, qty_satuan_terima, satuan, harga_beli_total, harga_beli_satuan, diskon, extra_diskon, diskon_total, ket, nilai_pajak, jenis, termasuk_ppn, status, user_act, tgl_act
                                    }
                                    else {
                                        if($no_po != '') {
                                            $sql = "select q1.*,namabarang from (SELECT *
                                                FROM as_po po
                                                where po.no_po = '$po_rekanan[0]' and status = 0
                                                order by po.id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id";
                                        }
                                    }
                                    //po.id,ms_barang_id,kemasan,qty_kemasan,harga_kemasan,harga_beli_total
                                    $rs=mysql_query($sql);
                                    $i=0;
                                    while ($rows=mysql_fetch_array($rs)) {
                                        $id = cekNull($rows['id']);
                                        $idbarang = cekNull($rows['ms_barang_id']);
                                        $namabarang = cekNull($rows['namabarang']);
                                        $satuan = $rows['satuan'];
                                        $kemasan = $rows['kemasan'];
                                        $qty_kemasan = cekNull($rows['qty_kemasan']);
                                        $qty_kemasan_terima = 0;
                                        //jika act bukan edit, maka isi qty_kemasan_terima = database
                                        if($_GET['act'] != 'edit')
                                            $qty_kemasan_terima = cekNull($rows['qty_kemasan_terima']);
                                        //jika act = edit,maka isi id (penerimaan) ditambahkan id po. tapi kalo act = add isi id = id po
                                        else
                                            $id .= '|'.cekNull($rows['po_id']);
                                        $harga_kemasan = cekNull($rows['harga_kemasan']);
                                        $harga_beli_satuan = cekNull($rows['harga_beli_satuan']);
                                        $sub_tot = cekNull(($qty_kemasan-$qty_kemasan_terima)*$harga_kemasan);
                                        $qty_satuan = cekNull($rows['qty_satuan']);
                                        $diskon = cekNull($rows['diskon']);
                                        ?>
                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                    <td class="tdisikiri"><?php echo ++$i; ?></td>
                                    <td class="tdisi" align="center">
                                        <input type="checkbox" name="chkItem" id="chkItem" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> value="<?php echo $id.'|'.$idbarang; ?>" onClick="HitunghDiskonTot();HitunghTot();" />
                                    </td>
                                    <td class="tdisi" align="left">
                                        <!--input name="idbarang" type="hidden" value="< ?php echo $idbarang; ?>" /-->
                                                <?php echo $namabarang; ?>
                                    </td>
                                    <td class="tdisi" align="center">
                                        <input type="hidden" id="hid_qty_kemasan" name="hid_qty_kemasan" value="<?php echo $qty_kemasan-$qty_kemasan_terima; ?>" />
                                        <input name="qty_kemasan" type="text" id="qty_kemasan" <?php if($_GET['act'] == 'edit') echo 'disabled';?> class="txtright" size="3" value="<?php echo $qty_kemasan-$qty_kemasan_terima; ?>" onKeyUp="cekVal(<?php echo ($i-1); ?>);HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" />
                                    </td>
                                    <td class="tdisi" align="center">
                                        <select id="kemasan" name="kemasan" class="txtcenter">
                                                    <?php
                                                    $qry="select * from as_ms_satuan order by nourut";
                                                    $exe=mysql_query($qry);
                                                    while($show=mysql_fetch_array($exe)) {
                                                        ?>
                                            <option value="<?php echo $show['idsatuan']; ?>" <?php if($kemasan == $show['idsatuan']) echo 'selected';?>><?php echo $show['idsatuan']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                    <td class="tdisi" align="right">
                                        <input name="h_kemasan" type="text" class="txtright" id="h_kemasan" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);HitungDiskon(<?php echo ($i-1); ?>,1);" value="<?php echo $harga_kemasan; ?>" size="8" />
                                    </td>
                                    <td class="tdisi" align="center">
                                        <input name="qty_per_kemasan" type="text" class="txtright" id="qty_per_kemasan" <?php if($act == 'edit') echo 'disabled'; ?> onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="<?php echo $qty_satuan/$qty_kemasan;?>" size="3" />
                                    </td>
                                    <td class="tdisi" align="center">
                                        <input name="qty_satuan" type="text" class="txtright" id="qty_satuan" onKeyUp="" value="<?php echo $qty_satuan; ?>" size="5" readonly />
                                    </td>
                                    <td class="tdisi" align="center">
                                        <select id="satuan" name="satuan" class="txtcenter">
                                                    <?php
                                                    $qry="select * from as_ms_satuan order by nourut";
                                                    $exe=mysql_query($qry);
                                                    while($show=mysql_fetch_array($exe)) {
                                                        ?>
                                            <option value="<?php echo $show['idsatuan']; ?>" <?php if($satuan == $show['idsatuan']) echo 'selected';?>><?php echo $show['idsatuan']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                    <td class="tdisi" align="right">
                                        <input name="h_satuan" type="text" class="txtright" id="h_satuan" onKeyUp="" value="<?php echo $harga_beli_satuan;?>" size="7" readonly />
                                    </td>
                                    <td class="tdisi" align="right">
                                        <input name="sub_tot" type="text" class="txtright" id="sub_tot" value="<?php echo $sub_tot; ?>" size="8" readonly />
                                    </td>
                                    <td class="tdisi" align="center">
                                        <input name="diskon" type="text" class="txtright" id="diskon" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,1);" value="<?php echo $diskon; ?>" size="3" />
                                    </td>
                                    <td class="tdisi" align="right">
                                        <input name="diskon_rp" type="text" class="txtright" id="diskon_rp" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,2);" value="<?php echo (($sub_tot*$diskon)/100); ?>" size="7" />
                                    </td>
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
                            <button type="button" onClick="if (ValidateForm('txtFaktur,txtTempo','ind')){kirim();}">
                                <img alt="save" src="../icon/save.gif" border="0" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;
                            </button>
                        </td>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='penerimaanPO.php'">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </form>
                <tr>
                    <td colspan="10">
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
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
                    data_submit += document.forms[0].chkItem[i].value+'*-*'+document.forms[0].chkItem[i].checked+'*-*'+document.forms[0].qty_kemasan[i].value
                        +'*-*'+document.forms[0].kemasan[i].value+'*-*'+document.forms[0].h_kemasan[i].value+'*-*'+document.forms[0].qty_per_kemasan[i].value
                        +'*-*'+document.forms[0].qty_satuan[i].value+'*-*'+document.forms[0].satuan[i].value+'*-*'+document.forms[0].h_satuan[i].value
                        +'*-*'+document.forms[0].diskon[i].value+'*-*'+document.forms[0].hid_qty_kemasan[i].value+'*|*';
                }
            }
            else{
                data_submit = document.forms[0].chkItem.value+'*-*'+document.forms[0].chkItem.checked+'*-*'+document.forms[0].qty_kemasan.value
                    +'*-*'+document.forms[0].kemasan.value+'*-*'+document.forms[0].h_kemasan.value+'*-*'+document.forms[0].qty_per_kemasan.value
                    +'*-*'+document.forms[0].qty_satuan.value+'*-*'+document.forms[0].satuan.value+'*-*'+document.forms[0].h_satuan.value
                    +'*-*'+document.forms[0].diskon.value+'*-*'+document.forms[0].hid_qty_kemasan.value+'*|*';
            }
            document.forms[0].data_submit.value = data_submit;
            document.getElementById('form1').submit();
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

        function set()
        {
            var nopo = document.getElementById('cmbNoPo').value;
            //alert("utils.php?pilihan=penerimaanbaru&nopo="+nopo);
            window.location = "penerimaanBaru.php?act=<?php echo $act;?>&no_po="+nopo;
        }
    </script>
</html>
