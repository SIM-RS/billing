<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') {
    $tgl = tglSQL($_POST["txtTgl"]);
    $fdata = $_POST["fdata"];
    $nokirim = $_POST["nokirim"];
    $unit = $_POST["unit"];
    $t_id_user = $_SESSION['id_user'];
    $t_userid = $_SESSION["userid"];
    $t_unitid = $_SESSION["refidunit"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
    
    $act = $_POST['act'];
    if ($act == "edit") {/*
        $fdata = explode('**', $fdata);
        if(count($fdata) > 1) {
            $add_new = false;
            for($i=0; $i<count($fdata); $i++) {
                $data = explode('|', $fdata[$i]);
                if($data[5] != '' && isset($data[5])) {
                    $id .= $data[5].'|';
                    
                    $query = "update as_po set ms_barang_id = '$data[0]', unit = '$unit', nokirim = '$no_po', tgl = '$tgl', satuan = '$data[1]'
                            , qty_kemasan = '$data[2]', harga_kemasan = '$data[3]'
                            where id = '$data[5]'";
                    //, harga_beli_total = '$data[4]'
                    //mysql_query($query);
                }
                else {
                    if($add_new == true) {
                        $query_add .= ', ';
                    }
                    else {
                        $add_new = true;
                        $query_add = '';
                    }
                    $query_add .= "('$data[0]','$vendor_id','$no_po','$tgl','$data[1]','$data[2]','$data[3]')";
                    //,'$data[4]'
                }
            }
            $query = "select * from as_po where no_po = '$no_po'";
            $rs = mysql_query($query);
            $res = mysql_affected_rows();
            $id = explode('|',$id);
            if($res > count($id)-1) {
                $tmp = '';
                for($i=0; $i<count($id)-1; $i++) {
                    if($i>0) {
                        $tmp .= ', ';
                    }
                    $tmp .= $id[$i];
                }
                $queryDel = "delete from as_po where no_po = '$no_po' and id not in ($tmp)";
                //mysql_query($queryDel);
            }
            if($add_new == true) {
                $query_add = "insert into as_po (ms_barang_id,vendor_id,no_po,tgl,satuan,qty_kemasan,harga_kemasan) values ".$query_add;
                //,harga_beli_total
                //$rs = mysql_query($query_add);
                $err = mysql_error();
                if (isset ($err) && $err != '')
                    echo "<script> alert('" . $err . "'); </script>";
            }
        }
        else {
            $data = explode('|', $fdata[0]);
            if($data[5] == '' || !isset($data[5])) {
                $query = "insert into as_po (ms_barang_id,vendor_id,no_po,tgl,satuan,qty_kemasan,harga_kemasan) values ";
                $query .= " ('$data[0]','$vendor_id','$no_po','$tgl','$data[1]','$data[2]','$data[3]')";
                //,harga_beli_total,'$data[4]'
            }
            else {
                $query = "delete from as_po where no_po = '$no_po' and id <> '$data[5]'";
                //mysql_query($query);
                $query = "update as_po set ms_barang_id = '$data[0]', vendor_id = '$vendor_id', no_po = '$no_po', tgl = '$tgl', satuan = '$data[1]'
                        , qty_kemasan = '$data[2]', harga_kemasan = '$data[3]'
                        where id = '$data[5]'";
                //, harga_beli_total = '$data[4]'
            }
            if($query != '' && isset($query)) {
                //$rs = mysql_query($query);
                //echo '<br>'.$query;
            }
        }
        $err = mysql_error();
        if (isset($err) && $err != '')
            echo "<script> alert('" . $err . "'); </script>";*/
    }
    else { // Insert Record
        $fdata = explode('**', $fdata);
        $more_than_one = 0;
        if(count($fdata) > 1) {
            for($i=0; $i<count($fdata); $i++) {
                $data = explode('|', $fdata[$i]);
                $finish = false;
                $qSel = "select id, ms_barang_id, id_lama, fk_minta_id, suplier_id
                    , unit_id_kirim, unit_id_terima, user_id_kirim, nokirim, noterima, nobukti, tgl_act, tgl, tgl_terima_act, tgl_terima
                    , tgl_j_tempo, hari_j_tempo, qty_kemasan, kemasan, harga_kemasan
                    , qty_per_kemasan, qty_satuan, satuan, qty_stok, qty_retur, harga_beli_total
                    , harga_beli_satuan, diskon, extra_diskon, diskon_total
                    , ket, nilai_pajak, jenis, tipe_trans, status
                    from as_penerimaan where ms_barang_id = '$data[0]' and status=1 and qty_stok > 0 and unit_id_terima = $t_unitid";
                $rsSel = mysql_query($qSel);
                while(($rowSel = mysql_fetch_array($rsSel)) && $finish == false) {
                    if($rowSel['qty_stok'] >= $data[3]) {
                        if($more_than_one == 1) {
                            $inSel .= ', ';
                        }
                        $finish = true;
                        $query = "update as_penerimaan set qty_stok = qty_stok-$data[3] where id = '".$rowSel['id']."'";
                        mysql_query($query);
                        $inSel .= "(null,'".$rowSel['ms_barang_id']."','".$rowSel['id']."','".$rowSel['fk_minta_id']."','".$rowSel['suplier_id']."'
                        , '$t_unitid', '$unit', '$t_id_user','$nokirim','".$rowSel['noterima']."','".$rowSel['nobukti']."', now(),'$tgl', null, null
                        , '".$rowSel['tgl_j_tempo']."', '".$rowSel['hari_j_tempo']."', '".$rowSel['qty_kemasan']."', '".$rowSel['kemasan']."', '".$rowSel['harga_kemasan']."'
                        , '".$rowSel['qty_per_kemasan']."', '$data[3]', '".$rowSel['satuan']."', '$data[3]', '".$rowSel['qty_retur']."', '".$rowSel['harga_beli_total']."'
                        , '".$rowSel['harga_beli_satuan']."', '".$rowSel['diskon']."', '".$rowSel['extra_diskon']."', '".$rowSel['diskon_total']."'
                        , '".$rowSel['ket']."', '".$rowSel['nilai_pajak']."', '".$rowSel['jenis']."', 1, 1)";
                    }
                    else {
                        if($more_than_one == 0) {
                            $more_than_one = 1;
                        }
                        else {
                            $inSel .= ', ';
                        }
                        $query = "update as_penerimaan set qty_stok = 0 where id = '".$rowSel['id']."'";
                        mysql_query($query);
                        $inSel .= "(null,'".$rowSel['ms_barang_id']."','".$rowSel['id']."','".$rowSel['fk_minta_id']."','".$rowSel['suplier_id']."'
                        , '$t_unitid', '$unit', '$t_id_user', '$nokirim', '".$rowSel['noterima']."','".$rowSel['nobukti']."', now(), '$tgl', null, null
                        , '".$rowSel['tgl_j_tempo']."', '".$rowSel['hari_j_tempo']."', '".$rowSel['qty_kemasan']."', '".$rowSel['kemasan']."', '".$rowSel['harga_kemasan']."'
                        , '".$rowSel['qty_per_kemasan']."', '".$rowSel['qty_stok']."', '".$rowSel['satuan']."', '".$rowSel['qty_stok']."', '".$rowSel['qty_retur']."', '".$rowSel['harga_beli_total']."'
                        , '".$rowSel['harga_beli_satuan']."', '".$rowSel['diskon']."', '".$rowSel['extra_diskon']."', '".$rowSel['diskon_total']."'
                        , '".$rowSel['ket']."', '".$rowSel['nilai_pajak']."', '".$rowSel['jenis']."', 1, 1)";
                        $data[3] = $data[3]-$rowSel['qty_stok'];
                    }
                }
            }
        }
        else {
            $data = explode('|', $fdata[0]);
            $finish = false;
            $qSel = "select id, ms_barang_id, id_lama, fk_minta_id, suplier_id
                , unit_id_kirim, unit_id_terima, user_id_kirim, nokirim, noterima, nobukti, tgl_act, tgl, tgl_terima_act, tgl_terima
                , tgl_j_tempo, hari_j_tempo, qty_kemasan, kemasan, harga_kemasan
                , qty_per_kemasan, qty_satuan, satuan, qty_stok, qty_retur, harga_beli_total
                , harga_beli_satuan, diskon, extra_diskon, diskon_total
                , ket, nilai_pajak, jenis, tipe_trans, status
                from as_penerimaan where ms_barang_id = '$data[0]' and status=1 and qty_stok > 0 and unit_id_terima = $t_unitid";
            $rsSel = mysql_query($qSel);
            while(($rowSel = mysql_fetch_array($rsSel)) && $finish == false) {
                if($rowSel['qty_stok'] >= $data[3]) {
                    if($more_than_one == 1) {
                        $inSel .= ', ';
                    }
                    $finish = true;
                    $query = "update as_penerimaan set qty_stok = qty_stok-$data[3] where id = '".$rowSel['id']."'";
                    mysql_query($query);
                    $inSel .= "(null,'".$rowSel['ms_barang_id']."','".$rowSel['id']."','".$rowSel['fk_minta_id']."','".$rowSel['suplier_id']."'
                    , '$t_unitid', '$unit', '$t_id_user','$nokirim','".$rowSel['noterima']."','".$rowSel['nobukti']."', now(),'$tgl', null, null
                    , '".$rowSel['tgl_j_tempo']."', '".$rowSel['hari_j_tempo']."', '".$rowSel['qty_kemasan']."', '".$rowSel['kemasan']."', '".$rowSel['harga_kemasan']."'
                    , '".$rowSel['qty_per_kemasan']."', '$data[3]', '".$rowSel['satuan']."', '$data[3]', '".$rowSel['qty_retur']."', '".$rowSel['harga_beli_total']."'
                    , '".$rowSel['harga_beli_satuan']."', '".$rowSel['diskon']."', '".$rowSel['extra_diskon']."', '".$rowSel['diskon_total']."'
                    , '".$rowSel['ket']."', '".$rowSel['nilai_pajak']."', '".$rowSel['jenis']."', 1, 1)";
                }
                else {
                    if($more_than_one == 0) {
                        $more_than_one = 1;
                    }
                    else {
                        $inSel .= ', ';
                    }
                    $query = "update as_penerimaan set qty_stok = 0 where id = '".$rowSel['id']."'";
                    mysql_query($query);
                    $inSel .= "(null,'".$rowSel['ms_barang_id']."','".$rowSel['id']."','".$rowSel['fk_minta_id']."','".$rowSel['suplier_id']."'
                    , '$t_unitid', '$unit', '$t_id_user', '$nokirim', '".$rowSel['noterima']."','".$rowSel['nobukti']."', now(), '$tgl', null, null
                    , '".$rowSel['tgl_j_tempo']."', '".$rowSel['hari_j_tempo']."', '".$rowSel['qty_kemasan']."', '".$rowSel['kemasan']."', '".$rowSel['harga_kemasan']."'
                    , '".$rowSel['qty_per_kemasan']."', '".$rowSel['qty_stok']."', '".$rowSel['satuan']."', '".$rowSel['qty_stok']."', '".$rowSel['qty_retur']."', '".$rowSel['harga_beli_total']."'
                    , '".$rowSel['harga_beli_satuan']."', '".$rowSel['diskon']."', '".$rowSel['extra_diskon']."', '".$rowSel['diskon_total']."'
                    , '".$rowSel['ket']."', '".$rowSel['nilai_pajak']."', '".$rowSel['jenis']."', 1, 1)";
                    $data[3] = $data[3]-$rowSel['qty_stok'];
                }
            }
        }
        $inSel = "insert into as_penerimaan (id, ms_barang_id, id_lama, fk_minta_id, suplier_id
                    , unit_id_kirim, unit_id_terima, user_id_kirim, nokirim, noterima, nobukti, tgl_act, tgl, tgl_terima_act, tgl_terima
                    , tgl_j_tempo, hari_j_tempo, qty_kemasan, kemasan, harga_kemasan
                    , qty_per_kemasan, qty_satuan, satuan, qty_stok, qty_retur, harga_beli_total
                    , harga_beli_satuan, diskon, extra_diskon, diskon_total
                    , ket, nilai_pajak, jenis, tipe_trans, status) values ".$inSel;
        $rs = mysql_query($inSel);
        $err = mysql_error();
        if (isset ($err) && $err != '')
            echo "<script> alert('" . $err . "'); </script>";
        //echo $query;
    }
    header("location:".$_SERVER['REQUEST_URI']."");
    //echo "<script>window.location='".$_SERVER['REQUEST_URI']."';</script>";
}

//$nokirim = $_GET['nokirim'];

//else {
/*if($_GET['nokirim'] != '' && isset($_GET['nokirim'])) {
    $sql = "select nokirim,date_format(tgl,'%d-%m-%Y') as tgl,unit_id_terima from as_penerimaan s where month(s.tgl)=$th[1] and year(s.tgl)=$th[2] order by id desc limit 1";
    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $tgl = $rows1['tgl'];
        $unit = $rows1['unit_id_terima'];
        $nokirim = $rows1['nokirim'];
        mysql_free_result($rs1);
    }
}
else {*/
    $sql="select nokirim from as_penerimaan s where month(s.tgl)=$th[1] and year(s.tgl)=$th[2] order by id desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $nokirim=$rows1["no_po"];
        $ctmp=explode("/",$nokirim);
        $dtmp=$ctmp[3]+1;
        $ctmp=$dtmp;
        for ($i=0; $i<(4-strlen($dtmp)); $i++)
            $ctmp = "0".$ctmp;
        $nokirim = "GDO/MO/$th[2]-$th[1]/$ctmp";
    }
    else {
        $nokirim = "GDO/MO/$th[2]-$th[1]/0001";
    }
//}
//}
$qry="select * from as_ms_satuan order by nourut";
$exe=mysql_query($qry);
$sel="";
$i=0;
while($show=mysql_fetch_array($exe)) {
    $sel .="sel.options[$i] = new Option('".$show['idsatuan']."', '".$show['idsatuan']."');";
    $i++;
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: PEMAKAIAN :.</title>
    </head>
    <body>
        <?php
        include '../header.php';
        $act = $_GET['act'];
        if($act == '') {
            $act = 'add';
        }
        ?>
        <div>
            <div id="divbarang" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <form name="form1" id="form1" method="post" action="">
                            <input name="act" id="act" type="hidden" value="<?php echo $act;?>">
                            <input name="fdata" id="fdata" type="hidden" value="">
                            <table width="99%" border="0">
                                <tr>
                                    <td align="center">
                                        <div id="input" style="display:block" align="center">
                                            <table width="100%" border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td width="300">&nbsp;</td>
                                                    <td>&nbsp;Tgl Penerimaan</td>
                                                    <td>&nbsp;:&nbsp;
                                                        <input id="txtTgl" class="txtcenter" name="txtTgl" value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                                                        <?php
                                                        if($act != 'edit') {
                                                            ?>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);" />
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;No Kirim</td>
                                                    <td>&nbsp;:&nbsp;
                                                        <input id="nokirim" name="nokirim" class="txtcenter" value="<?php echo $nokirim; ?>" readonly size="21" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;Unit Tujuan</td>
                                                    <td>&nbsp;:&nbsp;
                                                        <select id="unit" name="unit" class="txt" >
                                                            <?php
                                                            $sql = "select idunit, kodeunit, namaunit from as_ms_unit";
                                                            $rs = mysql_query($sql);
                                                            while($row = mysql_fetch_array($rs)) {
                                                                ?>
                                                            <option value="<?php echo $row['idunit']; ?>" <?php if($row['idunit'] == $unit){ echo 'selected';}?> ><?php echo $row['kodeunit'].' - '.$row['namaunit']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
                                            <tr>
                                                <td colspan="8" align="center" class="jdltable"><hr></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="center" class="jdltable">
                                                    PURCHASE ORDER
                                                </td>
                                                <td align="right" valign="bottom">
                                                    <input type="button" value="+" onClick="addRowToTable();" />
                                                </td>
                                            </tr>
                                            <tr class="headtable">
                                                <td width="25" height="25" class="tblheaderkiri">No</td>
                                                <td width="100" height="25" class="tblheader">Kode Barang</td>
                                                <td height="25" class="tblheader">Nama Barang</td>
                                                <td width="90" height="25" class="tblheader">Satuan</td>
                                                <td width="90" height="25" class="tblheader">Stok</td>
                                                <td width="40" height="25" class="tblheader">Jml</td>
                                                <td class="tblheader">Harga Satuan</td>
                                                <td class="tblheader">Sub Total</td>
                                                <td width="30" height="25" class="tblheader">Proses</td>
                                            </tr>
                                            <?php
                                            /*
                                            if($edit == true) {
                                                /*id, ms_barang_id, id_lama, fk_minta_id, suplier_id
                , unit_id_kirim, unit_id_terima, user_id_kirim, nokirim, noterima, nobukti, tgl_act, tgl, tgl_terima_act, tgl_terima
                , tgl_j_tempo, hari_j_tempo, qty_kemasan, kemasan, harga_kemasan
                , qty_per_kemasan, qty_satuan, satuan, qty_stok, qty_retur, harga_beli_total
                , harga_beli_satuan, diskon, extra_diskon, diskon_total
                , ket, nilai_pajak, jenis, tipe_trans, status* /
                                                $sql = "select id, ms_barang_id, kodebarang, namabarang, satuan, qty_stok, qty_satuan, date_format(tgl,'%d-%m-%Y') as tgl
                                                    , harga_beli_satuan
                                                    from as_penerimaan ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang
                                                    where nokirim = '".$nokirim."'";
                                                "select id,ms_barang_id,kodebarang,namabarang,vendor_id,namarekanan,no_po,date_format(tgl,'%d-%m-%Y') as tgl,satuan,qty_kemasan,harga_kemasan
                                                        from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                                                        where nokirim = '$nokirim' order by id asc";
                                                $rs1 = mysql_query($sql);
                                                $i = 0;
                                                while($rows1 = mysql_fetch_array($rs1)) {
                                                    ?>
                                            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                <td class="tdisikiri" width="25">
                                                            <?php echo ++$i;?>
                                                </td>
                                                <td class="tdisi" align="center"><?php echo $rows1['kodebarang'];?></td>
                                                <td class="tdisi" align="left">
                                                    <input name="obatid" type="hidden" value="<?php echo $rows1['ms_barang_id'];?>">
                                                    <input type="text" name="txtObat" class="txtinput" size="75" value="<?php echo $rows1['namabarang'];?>" autocomplete="off" onKeyUp="suggest(event,this);" />
                                                    <input type="hidden" id="id" name="id" value="<?php echo $rows1['id'];?>" />
                                                </td>
                                                <td class="tdisi">
                                                    <select id="satuan" name="satuan" class="txtinput">
                                                                <?php
                                                                $qry="select * from as_ms_satuan order by nourut";
                                                                $exe=mysql_query($qry);
                                                                while($show=mysql_fetch_array($exe)) {
                                                                    ?>
                                                        <option value="<?php echo $show['idsatuan']; ?>" class="txtinput" <?php if($rows1['satuan'] == $show['idsatuan']) echo 'selected';?>><?php echo $show['idsatuan']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                    </select>
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input type="text" name="stok" readonly id="stok" class="txtcenter" value="<?php echo $rows1['qty_stok'];?>" size="6" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input type="text" name="txtJml" id="txtJml" autocomplete="off" class="txtcenter" value="<?php echo $rows1['qty_kemasan'];?>" size="6" onKeyUp="validateNumber(this);AddRow(event,this)" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input name="txtNilai" type="text" class="txtright" id="txtNilai" value="<?php echo $rows1['harga_kemasan'];?>" readonly size="10" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input name="txtSubTotal" id="txtSubTotal" type="text" class="txtright" value="<?php echo $rows1['qty_kemasan']*$rows1['harga_kemasan'];?>" size="12" readonly="true" />
                                                </td>
                                                <td class="tdisi">
                                                    <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
                                                </td>
                                            </tr>
                                                    <?php
                                                }
                                            }
                                            else {*/
                                                ?>
                                            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                <td class="tdisikiri" width="25">1
                                                </td>
                                                <td class="tdisi" align="center">-</td>
                                                <td class="tdisi" align="left">
                                                    <input name="obatid" type="hidden" value="">
                                                    <input type="text" name="txtObat" class="txtinput" size="75" autocomplete="off" onKeyUp="suggest(event,this);" />
                                                </td>
                                                <td class="tdisi">
                                                    <select id="satuan" name="satuan" class="txtinput">
                                                            <?php
                                                            $qry="select * from as_ms_satuan order by nourut";
                                                            $exe=mysql_query($qry);
                                                            while($show=mysql_fetch_array($exe)) {
                                                                ?>
                                                        <option value="<?php echo $show['idsatuan']; ?>" class="txtinput"><?php echo $show['idsatuan']; ?></option>
                                                                <?php }?>
                                                    </select>
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input type="text" name="stok" readonly id="stok" class="txtcenter" value="<?php echo $rows1['qty_stok'];?>" size="6" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input type="text" name="txtJml" id="txtJml" class="txtcenter" autocomplete="off" size="6" onKeyUp="validateNumber(this);AddRow(event,this)" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input name="txtNilai" type="text" class="txtright" id="txtNilai" readonly size="10" />
                                                </td>
                                                <td class="tdisi" width="30">
                                                    <input name="txtSubTotal" id="txtSubTotal" type="text" class="txtright" size="12" readonly="true" />
                                                </td>
                                                <td class="tdisi">
                                                    <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
                                                </td>
                                            </tr>
                                                <?php
                                            //}
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="93%" align="center">
                                <tr>
                                    <td width="88%" class="txtright">Total :</td>
                                    <td id="total" width="11%" align="right" class="txtright">0</td>
                                    <td width="1%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="center">
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button type="reset" class="Enabledbutton" id="backbutton" onClick="location='pemakaianBrg.php'" title="Back" style="cursor:pointer">
                                            <img alt="cancel" src="../icon/cancel.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
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
        var RowIdx;
        var fKeyEnt;
        function suggest(e,par){
            var keywords=par.value;//alert(keywords);
            //alert(par.offsetLeft);
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
            //alert(jmlRow+'-'+i);
            if(keywords==""){
                document.getElementById('divbarang').style.display='none';
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
                }else if (key==13){
                    if (RowIdx>0){
                        if (fKeyEnt==false){
                            fSetObat(document.getElementById(RowIdx).lang);
                        }else{
                            fKeyEnt=false;
                        }
                    }
                }else if (key!=27 && key!=37 && key!=39){
                    RowIdx=0;
                    fKeyEnt=false;
                    Request('baranglist.php?act=pemakaian&aKeyword='+keywords+'&no='+i , 'divbarang', '', 'GET' );
                    if (document.getElementById('divbarang').style.display=='none')
                        fSetPosisi(document.getElementById('divbarang'),par);
                    document.getElementById('divbarang').style.display='block';
                }
            }
        }

        function fSetObat(par){
            var cdata=par.split("*|*");
            var tbl = document.getElementById('tblJual');
            var tds;
            if ((cdata[0]*1)==0){
                document.forms[0].obatid.value=cdata[1];
                document.forms[0].txtObat.value=cdata[3];
                document.forms[0].stok.value = cdata[4];
                document.forms[0].txtNilai.value=cdata[5];
                tds = tbl.rows[3].getElementsByTagName('td');
                //document.forms[0].txtHarga.value=cdata[4];
                document.forms[0].txtJml.focus();
            }else{
                var w;
                for (var x=0;x<document.forms[0].obatid.length-1;x++){
                    w=document.forms[0].obatid[x].value.split('|');
                    //alert(cdata[1]+'-'+w[0]);
                    if (cdata[1]==w[0]){
                        fKeyEnt=true;
                        alert("Barang Tersebut Sudah Ada");
                        return false;
                    }
                }
                document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
                document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[3];
                document.forms[0].stok[(cdata[0]*1)-1].value = cdata[4];
                document.forms[0].txtNilai[(cdata[0]*1)-1].value=cdata[5];
                tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
                //document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
                document.forms[0].txtJml[(cdata[0]*1)-1].focus();
            }
            tds[1].innerHTML=cdata[2];
            //tds[3].innerHTML=cdata[3];

            document.getElementById('divbarang').style.display='none';
        }

        function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblJual');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

            // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);

            // right cell
            var cellRight = row.insertCell(2);
            var el;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'obatid';
            }else{
                el = document.createElement('<input name="obatid"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'hidden';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

            //generate txtobat
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtObat';
                el.setAttribute('OnKeyUp', "suggest(event,this);");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 75;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            cellRightSel = row.insertCell(3);
            sel = document.createElement('select');
            sel.name = 'satuan';
            sel.className = "txtinput";
            //sel.id = 'selRow'+iteration;
<?php
echo $sel;
?>
        //  sel.options[0] = new Option('text zero', 'value0');
        //  sel.options[1] = new Option('text one', 'value1');
        cellRightSel.className = 'tdisi';
        cellRightSel.appendChild(sel);

        /*  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
         */

        //right cell
        cellRight = row.insertCell(4);
        if(!isIE){
            el = document.createElement('input');
            el.name = 'stok';
            el.id = 'stok';
            el.setAttribute('readOnly', true);
        }
        else{
            el = document.createElement("<input name='stok' readonly id='stok' />");
        }
        el.type = 'text';
        el.size = 6;
        el.className = 'txtcenter';
        cellRight.className = 'tdisi';
        cellRight.appendChild(el);

        // right cell
        cellRight = row.insertCell(5);
        if(!isIE){
            el = document.createElement('input');
            el.name = 'txtJml';
            el.setAttribute('onKeyUp', "validateNumber(this);AddRow(event,this)");
            el.setAttribute('autocomplete', "off");
        }else{
            el = document.createElement('<input name="txtJml" onKeyUp="validateNumber(this);AddRow(event,this)" />');
        }
        el.type = 'text';
        el.size = 6;
        el.className = 'txtcenter';

        cellRight.className = 'tdisi';
        cellRight.appendChild(el);

        // right cell
        cellRight = row.insertCell(6);
        if(!isIE){
            el = document.createElement('input');
            el.name = 'txtNilai';
            el.setAttribute('readOnly', true);
        }else{
            el = document.createElement('<input name="txtNilai" />');
        }
        el.type = 'text';
        el.size = 10;
        el.className = 'txtright';

        cellRight.className = 'tdisi';
        cellRight.appendChild(el);

        // right cell
        cellRight = row.insertCell(7);
        if(!isIE){
            el = document.createElement('input');
            el.name = 'txtSubTotal';
            el.setAttribute('readonly', "true");
        }else{
            el = document.createElement('<input name="txtSubTotal" readonly="true" />');
        }
        el.type = 'text';
        el.size = 12;
        el.className = 'txtright';

        cellRight.className = 'tdisi';
        cellRight.appendChild(el);

        // right cell
        cellRight = row.insertCell(8);
        if(!isIE){
            el = document.createElement('img');
            el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
        }else{
            el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
        }
        el.src = '../icon/del.gif';
        el.border = "0";
        el.width = "16";
        el.height = "16";
        el.className = 'proses';
        el.align = "absmiddle";
        el.title = "Klik Untuk Menghapus";

        //  cellRight.setAttribute('class', 'tdisi');
        cellRight.className = 'tdisi';
        cellRight.appendChild(el);

        document.forms[0].txtObat[iteration-3].focus();

        /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'kemasan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
         */
    }

    function validateNumber(par)
    {
        if(isNaN(par.value)){
            alert('Input bukan angka, masukan jumlah dalam angka.');
            if (document.form1.txtSubTotal.length){
                var tbl = document.getElementById('tblJual');
                var jmlRow = tbl.rows.length;
                var i;
                if (jmlRow > 4){
                    i=par.parentNode.parentNode.rowIndex-2;
                }else{
                    i=0;
                }
                document.form1.txtJml[i-1].value = 0;
            }else{
                document.form1.txtJml.value = 0;
            }
        }
    }

    function AddRow(e,par){
        var key;
        if(window.event) {
            key = window.event.keyCode;
        }
        else if(e.which) {
            key = e.which;
        }
        //alert(key);
        if (key==13){
            addRowToTable();
        }else{
            HitungSubTot(par);
        }
    }

    function removeRowFromTable(cRow){
        var tbl = document.getElementById('tblJual');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4){
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++){
                var tds = tbl.rows[i].getElementsByTagName('td');
                tds[0].innerHTML=i-2;
            }
            HitungTot();
        }
    }

    function HitungTot(){
        if (document.form1.txtSubTotal.length){
            var cStot=0;
            for (var i=0;i<document.form1.txtSubTotal.length;i++){
                //alert(document.form1.txtSubTot[i].value);
                cStot +=(document.form1.txtSubTotal[i].value*1);
            }
            document.getElementById('total').innerHTML=cStot;
            //alert(cStot);
        }
        else{
            document.getElementById('total').innerHTML=document.form1.txtSubTotal.value;
        }
    }

    function HitungSubTot(par){
        //alert(par);
        //var tbl = document.getElementById('tblJual');
        var i=par.parentNode.parentNode.rowIndex;
        //alert(i);
        if (document.form1.txtSubTotal.length){
            //alert(document.form1.stok[i-3].value);
            var tmp = document.form1.stok[i-3].value;
            if(parseInt(par.value)>parseInt(tmp)){
                alert('Jumlah yang diminta lebih besar dari jumlah stok.');
                document.form1.txtJml[i-3].value = 0;
            }
            document.form1.txtSubTotal[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtNilai[i-3].value*1);
        }else{
            //alert(tmp+'<'+par.value);
            var tmp = document.form1.stok.value;
            if(parseInt(par.value)>parseInt(tmp)){
                alert('Jumlah yang diminta lebih besar dari jumlah stok.');
                document.form1.txtJml.value = 0;
            }
            document.form1.txtSubTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
        }
        HitungTot();
    }

    function save(){
        var cdata='';
        var ctemp;
        /*if (document.forms[0].no_po.value==""){
            alert('Isikan No PO Terlebih Dahulu !');
            document.forms[0].no_po.focus();
            return false;
        }*/

        if (document.forms[0].obatid.length){
            for (var i=0;i<document.forms[0].obatid.length;i++){
                ctemp=document.forms[0].obatid[i].value;//.split('|');
                if (document.forms[0].obatid[i].value==""){
                    alert('Pilih Barang Terlebih Dahulu !');
                    document.forms[0].txtObat[i].focus();
                    return false;
                }
                cdata += ctemp+'|'+document.forms[0].satuan[i].value+'|'+document.forms[0].stok[i].value+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].txtNilai[i].value+'|'+document.forms[0].txtSubTotal[i].value;
                if("<?php echo $edit;?>" == true){
                    cdata += '|'+document.forms[0].id[i].value;
                }
                cdata += '**';
            }
            if (cdata != '')
                cdata=cdata.substr(0,cdata.length-2);
        }
        else{
            if (document.forms[0].obatid.value==""){
                alert('Pilih Barang Terlebih Dahulu !');
                document.forms[0].txtObat.focus();
                return false;
            }
            ctemp=document.forms[0].obatid.value;//.split('|');
            cdata=ctemp+'|'+document.forms[0].satuan.value+'|'+document.forms[0].stok.value+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].txtNilai.value+'|'+document.forms[0].txtSubTotal.value;
            if("<?php echo $edit;?>" == true){
                cdata += '|'+document.forms[0].id.value;
            }
        }
        //ms_barang_id,vendor_id,no_po,tgl,kemasan,qty_kemasan,harga_kemasan
        //kemasan,qty_kemasan,harga_kemasan
        document.forms[0].fdata.value=cdata;
        document.forms[0].submit();
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
    }
    if('<?php echo $edit;?>' == true){
        HitungTot();
    }
    </script>
</html>