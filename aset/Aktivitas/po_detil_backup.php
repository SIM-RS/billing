<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
date_default_timezone_set("Asia/Jakarta");
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
$tgl_sql = gmdate('Y-m-d',mktime(date('H')+7));
if(isset($_POST['act']) && $_POST['act'] != '') {
    $tgl_po = tglSQL($_POST["tgl"]);
    $fdata = $_POST["fdata"];
    $jenis_surat=$_POST["jenis_surat"];
    $no_po = $_POST["no_po"];
    $utk_unit_id=$_POST["utk_unit_id"];
    $vendor_id = $_POST["vendor_id"];
    $judul = $_POST['judul'];
    $exp_kirim = tglSQL($_POST["exp_kirim"]);
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
    
    $act = $_POST['act'];
    //echo $act;
    if ($act == "edit") {
        $fdata = explode('**', $fdata);
        if(count($fdata) > 1) {
            $add_new = false;
            for($i=0; $i<count($fdata); $i++) {
                $data = explode('|', $fdata[$i]);
                if($data[8] != '' && isset($data[8])) {
                    $id .= $data[8].'|';

                    $query = "update as_po set ms_barang_id = '$data[0]', jenis_surat = '$jenis_surat', vendor_id = '$vendor_id', no_po = '$no_po', tgl_po = '$tgl_po', judul='$judul', exp_kirim = '$exp_kirim'
                            , satuan = '$data[2]', qty_satuan = '$data[1]', harga_satuan = '$data[3]',subtotal='$data[4]',total='$data[5]', unit_id = '$data[6]', uraian = '$data[7]'
                            where id = '$data[8]'";
                    //, harga_beli_total = '$data[4]'
                    mysql_query($query);
                }
                else {
                    if($add_new == true) {
                        $query_add .= ', ';
                    }
                    else {
                        $add_new = true;
                        $query_add = '';
                    }
                    $query_add .= "('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$exp_kirim','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]')";
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
                mysql_query($queryDel);
            }
            if($add_new == true) {
                $query_add = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,exp_kirim,qty_satuan,satuan,harga_satuan,subtotal,total,unit_id,uraian) values ".$query_add;
                //echo $query_add;
                //,harga_beli_total
                $rs = mysql_query($query_add);
                $err = mysql_error();
                if (isset ($err) && $err != '')
                    echo "<script> alert('" . $err . "'); </script>";
            }
        }
        else {
            $data = explode('|', $fdata[0]);
            //data[9]=id,kalau kosong (tidak ditemukan id pada parameter yang dikirim,berarti data sebelumnya dengan no_po tersebut dihapus)
            if($data[8] == '' || !isset($data[8])) {
                $query = "delete from as_po where no_po = '$no_po'";
                mysql_query($query);

                $query = "insert into as_po (ms_barang_id,jenis_surat,vendor_id,no_po,tgl_po,judul,exp_kirim,qty_satuan,satuan,harga_satuan,subtotal,total,unit_id,uraian) values ";
                $query .= " ('$data[0]','$jenis_surat','$vendor_id','$no_po','$tgl_po','$judul','$exp_kirim','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]')";
                //,harga_beli_total,'$data[4]'
                //echo $query;
            }
            else {
                $query = "delete from as_po where no_po = '$no_po' and id <> '$data[8]'";
                mysql_query($query);
                
                $query = "update as_po set ms_barang_id = '$data[0]', jenis_surat = '$jenis_surat', vendor_id = '$vendor_id', no_po = '$no_po', tgl_po = '$tgl_po',judul='$judul', exp_kirim = '$exp_kirim'
                        , qty_satuan = '$data[1]', satuan = '$data[2]', harga_satuan = '$data[3]', subtotal='$data[4]', total='$data[5]', unit_id='$data[6]', unit_id='$data[7]'
                        where id = '$data[8]'";
                //, harga_beli_total = '$data[4]'
            }
            if($query != '' && isset($query)) {
                $rs = mysql_query($query);
                //echo '<br>'.$query;
            }
        }
        $err = mysql_error();
        if (isset($err) && $err != '')
            echo "<script> alert('" . $err . "'); </script>";
        else
            header("location:http://".$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI']."");
            //echo $_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'];
    }
    //pemecahan variabel untuk edit -> add/edit*********************************************************
    //pecah belum dicek,karena ada trouble pengiriman data saat dikurangi / ditambah
    else { // Insert Record
        $fdata = explode('**', $fdata);
        $query = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,qty_satuan,satuan,harga_satuan,subtotal,total,unit_id,uraian,exp_kirim,tgl_act) values ";
        //harga_beli_total
        if(count($fdata) > 1) {
            for($i=0; $i<count($fdata); $i++) {
                $data = explode('|', $fdata[$i]);
                if($i > 0) {
                    $query .= ', ';
                }
                $query .= " ('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$exp_kirim','$t_updatetime')";
            }
        }
        else {
            $data = explode('|', $fdata[0]);
            $query .= " ('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$exp_kirim','$t_updatetime')";
        }
        //echo $query;
        $rs = mysql_query($query);
        $err = mysql_error();
        if (isset ($err) && $err != '')
            echo "<script> alert('" . $err . "'); </script>";
        //echo $query;

    }

    //echo "idtransaksi=".$_POST['idtransaksi'].",refno=".$_POST['refno'].",kodeunit=".$_POST['kodeunit'].",kodelokasi=".$_POST['kodelokasi'].",buktino=".$_POST['buktino'].",tgltransaksi=".$_POST['tgltransaksi'].",tglpembukuan=".$_POST['tglpembukuan'].",tok=".$_POST['tok'].",nosk=".$_POST['nosk'].",sumberdana=".$_POST['sumberdana'].",tglsk=".$_POST['tglsk'].",void=".$_POST['void'].",refidrekanan=".$_POST['refidrekanan'].",namarekanan=".$_POST['namarekanan'].",namaunit=".$_POST['namaunit'].",idunit=".$_POST['idunit'].",idlokasi=".$_POST['idlokasi']."";
    //echo "idbarang=".$_POST['idbarang'].",=".",kodebarang=".$_POST['kodebarang'].",qtytransaksi=".$_POST['qtytransaksi'].",satuan=".$_POST['satuan'].",hargasatuan=".$_POST['hargasatuan'].",kurs=".$_POST['kurs'].",nilaikurs=".$_POST['nilaikurs'].",dasarharga=".$_POST['dasarharga'].",kondisi=".$_POST['kondisi']."";
}

//else {
if($_GET['no_po'] != '' && isset($_GET['no_po'])) {
    $sql = "select vendor_id,uraian,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,judul,date_format(exp_kirim,'%d-%m-%Y') as exp_kirim, sum(lain2) as lain2,jenis_surat
                from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                where no_po = '".$_GET['no_po']."' order by id asc";
    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) {
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $tgl = $rows1['tgl'];
        $exp_kirim = $rows1['exp_kirim'];
        $vendor_id = $rows1['vendor_id'];
        $judul = $rows1['judul'];
        $lain2 = round($rows1['lain2'])<$rows1['lain2']?$rows1['lain2']+1:round($rows1['lain2']);
        $no_po = $rows1['no_po'];
        mysql_free_result($rs1);
    }
}
else {
    $sql="select no_po from as_po s where month(s.tgl_po)=$th[1] and year(s.tgl_po)=$th[2] order by no_po desc limit 1";
    $rs1=mysql_query($sql);
    if ($rows1=mysql_fetch_array($rs1)) {
        $no_po=$rows1["no_po"];
        $ctmp=explode("/",$no_po);
        $dtmp=$ctmp[2]+1;
        $ctmp=$dtmp;
        $ctmp=sprintf("%04d",$ctmp);
        //for ($i=0; $i<(4-strlen($dtmp)); $i++)
        //    $ctmp = "0".$ctmp;
        $no_po = "PO/$th[2]-$th[1]/$ctmp";
    }
    else {
        $no_po = "PO/$th[2]-$th[1]/0001";
    }
}
//}
$qry="select * from as_ms_satuan order by nourut";
$exe=mysql_query($qry);
$sel="";
$i=0;
while($show=mysql_fetch_array($exe)) {
    $sel .="sel.options[$i] = new Option('".$show['idsatuan']."', '".$show['idsatuan']."');";
    $i++;
}

$qry="select idunit, namaunit from as_ms_unit";
$exe=mysql_query($qry);
$selUnit="";
$i=0;
while($show=mysql_fetch_array($exe)) {
    $selUnit .="sel.options[$i] = new Option('".$show['namaunit']."', '".$show['idunit']."');";
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
        <title>.: PO :.</title>
    </head>
    <body>
        <?php
        include '../header.php';
        $act = $_GET['act'];
        if($act == '') {
            $act = 'add';
        }
        ?>
        <div align="center">
            <div id="divbarang" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <form name="form1" id="form1" method="post" action="" onSubmit="save()">
                            <input name="act" id="act" type="hidden" value="<?php echo $act;?>">
                            <input name="fdata" id="fdata" type="hidden" value="">
                            <table width="99%" border="0">
                                <tr>
                                    <td>
                                        <div id="input" style="display:block" align="center">
                                            <table width="80%" border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td class="tdlabel">Jenis Surat </td>
                                                    <td>:
                                                        <!--input name="jenis_surat" id="jenis_surat" class="txtunedited" size="25" value="" /-->
                                                        <select id="jenis_surat" name="jenis_surat" class='txt'>
                                                            <?php
                                                            $sql = "select jns_id,jns from as_jenis_surat";
                                                            $rsJ = mysql_query($sql);
                                                            while($rowJ = mysql_fetch_array($rsJ)){
                                                                echo "<option value='".$rowJ['jns_id']."' ";
                                                                if($rowJ['jns_id'] == $rows1['jenis_surat']){
                                                                    echo "selected";
                                                                }
                                                                echo " >".$rowJ['jns']."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="140" class="tdlabel">Tanggal&nbsp; </td>
                                                    <td width="343">:
                                                        <input name="tgl" type="text" class="txtunedited" id="tgl" tabindex="4" value="<?php if(isset($tgl) && $tgl != '') echo $tgl;else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="tdlabel">Nomor</td>
                                                    <td>:
                                                        <input name="no_po" id="no_po" class="txt" size="25" value="<?php echo $no_po;?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="tdlabel">Supplier</td>
                                                    <td>:
                                                        <select id="vendor_id" class="txt" name="vendor_id">
                                                            <?php
                                                            $query = "select idrekanan, namarekanan from as_ms_rekanan";
                                                            $rs = mysql_query($query);
                                                            while($row = mysql_fetch_array($rs)) {
                                                                ?>
                                                            <option value="<?php echo $row['idrekanan'];?>" <?php if($row['idrekanan'] == $vendor_id) echo 'selected';?>><?php echo $row['namarekanan'];?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <!--tr>
                                                  <td class="tdlabel">Untuk</td>
                                                  <td>: <select id="utk_unit_id" class="txt" name="utk_unit_id">
                                                            < ?php
                                                            $query = "select idunit, namaunit from as_ms_unit";
                                                            $rs = mysql_query($query);
                                                            while($row = mysql_fetch_array($rs)) {
                                                                ?>
                                                            <option value="< ?php echo $row['idunit'];?>" < ?php if($row['idunit'] == $utk_unit_id) echo 'selected';?>>< ?php echo $row['namaunit'];?></option>
                                                                < ?php
                                                            }
                                                            ?>
                                                        </select>
						    </td>
                                                </tr-->
                                                <tr>
                                                    <td class="tdlabel">Jatuh Tempo Pengiriman </td>
                                                    <td>
							: 
                                                        <input name="exp_kirim" type="text" class="txtunedited" id="exp_kirim" tabindex="4" value="<?php if(isset($exp_kirim) && $exp_kirim != '') echo $exp_kirim;else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('exp_kirim'),depRange);">
                                                    </td>
                                                </tr>
                                                <!--tr>
                                                    <td class="tdlabel">
							Biaya Lain-Lain
                                                    </td>
                                                    <td>
							: <input type="text" style="text-align:right" name="others" id="others" value="<?php echo $lain2;?>" onKeyUp="setDisable(event,this)" class="txt" size='15' />
                                                    </td>
                                                </tr-->
                                                <tr>
                                                    <td class="tdlabel">
							Judul PO
                                                    </td>
                                                    <td>
							: <input type="text" style="text-align:left" size=110 name="judul" id="judul" value="<?php echo $judul;?>" class="txt" size='15' />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div style="width:950px; height: inherit; overflow:auto; ">
                                            <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                <tr>
                                                    <td colspan="11" align="center" class="jdltable"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="10" align="center" class="jdltable">
                                                        PURCHASE ORDER</td>
                                                    <td align="right" valign="bottom">
                                                        <input type="button" value="+" onClick="addRowToTable();" />
                                                    </td>
                                                </tr>
                                                <tr class="headtable">
                                                    <td width="20" height="25" class="tblheaderkiri">No</td>
                                                    <td width="100" height="25" class="tblheader">Kode Barang</td>
                                                    <td height="25" class="tblheader">Nama Barang</td>
                                                    <td width="100" height="25" class="tblheader">Uraian</td>
                                                    <td width="40" height="25" class="tblheader">Jml</td>
                                                    <td width="40" height="25" class="tblheader">Satuan</td>
                                                    <td class="tblheader">Harga Satuan</td>
                                                    <!--td width="40" height="25" class="tblheader">Lain-lain</td-->
                                                    <!--td class="tblheader">Sub Total</td-->
                                                    <td width="40" height="25" class="tblheader">Total</td>
                                                    <td height="25" class="tblheader">Peruntukan</td>
                                                    <td width="30" height="25" class="tblheader">Proses</td>
                                                </tr>
                                                <?php
                                                if($edit == true) {
                                                    $sql = "select id,ms_barang_id,uraian,kodebarang,namabarang,vendor_id,namarekanan,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,satuan,qty_satuan,lain2,harga_satuan,unit_id,ab.idsatuan
                                                        from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                                                        where no_po = '$no_po' order by id asc";
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
                                                        <input type="text" name="txtObat" class="txtinput" size="40" value="<?php echo $rows1['namabarang'];?>" onKeyUp="suggest(event,this);" autocomplete="off" />
                                                        <input type="hidden" id="id" name="id" value="<?php echo $rows1['id'];?>" />
                                                    </td>
                                                    <td class="tdisi" width="30">
                                                        <input type="text" name="txtUraian" id="txtUraian" class="txtinput" value="<?php echo $rows1['uraian'];?>" autocomplete="off" />
                                                    </td>
                                                    <td class="tdisi" width="30">
                                                        <input type="text" name="txtJml" id="txtJml" class="txtcenter" value="<?php echo $rows1['qty_satuan'];?>" size="6" onKeyUp="AddRow(event,this,'txtJml');setDisable(event,this);" autocomplete="off" />
                                                    </td>
                                                    <td class="tdisi">
                                                        <input id="satuan" name="satuan" class="txtinput" value="<?php echo $rows1['idsatuan']; ?>" readonly="readonly" class="txtinput" />                                                                      
                                                    </td>
                                                    <td class="tdisi" width="30">
                                                        <input name="txtNilai" type="text" class="txtright" id="txtNilai" value="<?php echo $rows1['harga_satuan'];?>" onKeyUp="AddRow(event,this,'txtNilai');setDisable(event,this);" size="10" autocomplete="off" />
                                                    </td>
                                                    <!--td class="tdisi" width="30">
                                                        <input type="text" name="txtLain2" id="txtLain2" class="txtright" value="<?php echo round ($rows1['lain2']);?>" readonly size="10" autocomplete="off" />
                                                    </td-->
                                                    <!--td class="tdisi" width="30"-->
                                                        <input name="txtSubTotal" id="txtSubTotal" type="hidden" class="txtright" value="<?php echo round ($rows1['harga_satuan']+$rows1['lain2']/$rows1['qty_satuan']);?>" size="12" readonly="true" />
                                                    <!--/td-->
                                                    <td class="tdisi" width="30">
                                                        <input type="text" name="txtTotal" id="txtTotal" class="txtright" readonly value="<?php echo round ($rows1['qty_satuan']*$rows1['harga_satuan']+$rows1['lain2']);?>" size="10" autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtTotal')"-->
                                                    </td>
                                                    <td class="tdisi">
                                                        <select id="utk_unit_id" class="txtinput" name="utk_unit_id">
                                                                    <?php
                                                                    $query = "SELECT idunit, namaunit FROM as_ms_unit ORDER BY kodeunit ASC";
                                                                    $rs = mysql_query($query);
                                                                    while($row = mysql_fetch_array($rs)) {
                                                                        ?>
                                                            <option value="<?php echo $row['idunit'];?>" <?php if($rows1['unit_id'] == $row['idunit']) echo 'selected';?>><?php echo $row['namaunit'];?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </td>
                                                    <td class="tdisi">
                                                        <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}">
                                                    </td>
                                                </tr>
                                                        <?php
                                                    }
                                                }
                                                else {
                                                    ?>
                                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                    <td class="tdisikiri" width="25">1
                                                    </td>
                                                    <td class="tdisi" align="center">-</td>
                                                    <td class="tdisi" align="left">
                                                        <input name="obatid" type="hidden" value="">
                                                        <input type="text" name="txtObat" class="txtinput" size="40" onKeyUp="suggest(event,this);" autocomplete="off" />
                                                    </td>
                                                     <td class="tdisi" width="30">
                                                        <input type="text" name="txtUraian" id="txtUraian" class="txtinput" autocomplete="off" />
                                                    </td>
                                                    <td class="tdisi" width="30">
                                                        <input type="text" name="txtJml" id="txtJml" class="txtcenter" size="6" onKeyUp="AddRow(event,this,'txtJml');setDisable(event,this);" autocomplete="off" />
                                                    </td>
                                                    <td class="tdisi">
                                                        <input id="satuan" name="satuan" class="txtinput" value="<?php echo $rows1['idsatuan']; ?>" readonly="readonly" class="txtinput" />
                                                    </td>
                                                    <td class="tdisi" width="30">
                                                        <input name="txtNilai" type="text" class="txtright" id="txtNilai" onKeyUp="AddRow(event,this,'txtNilai');setDisable(event,this);" size="10" autocomplete="off" />
                                                    </td>
                                                    <!--td class="tdisi" width="30">
                                                        <input type="text" name="txtLain2" id="txtLain2" class="txtright" size="10" readonly="true" />
                                                    </td-->
                                                    <!--td class="tdisi" width="30"-->
                                                        <input name="txtSubTotal" id="txtSubTotal" type="hidden" class="txtright" size="12" readonly="true" />
                                                    <!--/td-->
                                                    <td class="tdisi" width="30">
                                                        <input type="text" name="txtTotal" id="txtTotal" class="txtright" size="10" readonly autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtTotal')"-->
                                                    </td>
                                                    <td class="tdisi">
                                                        <select id="utk_unit_id" class="txtinput" name="utk_unit_id">
                                                                <?php
                                                                $query = "SELECT idunit, namaunit FROM as_ms_unit ORDER BY kodeunit ASC";
                                                                $rs = mysql_query($query);
                                                                while($row = mysql_fetch_array($rs)) {
                                                                    ?>
                                                            <option value="<?php echo $row['idunit'];?>" <?php if($rows1['idunit'] == $utk_unit_id) echo 'selected';?>><?php echo $row['namaunit'];?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                    <td class="tdisi">
                                                        <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del');}">
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table width="90%" align="center">
                                <tr>
                                    <td width="88%" class="txtright">Total :</td>
                                    <td id="total" width="11%" align="right" class="txtright">0</td>
                                    <td width="1%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="center">
                                        <!--button type="button" class="Enabledbutton" id="btnDist" name="btnDist" onClick="activate()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            DISTRIBUSI BIAYA LAIN-LAIN
                                        </button-->
                                        <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button type="reset" class="Enabledbutton" id="backbutton" onClick="location='po.php'" title="Back" style="cursor:pointer">
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
        /*
        function activate(){
            if(isNaN(document.getElementById('others').value) && document.getElementById('others').value != ''){
                alert('Biaya lain-lain hanya bisa diisi dengan angka.');
                document.getELementById('others').value = 0;
            }

            if (document.form1.txtSubTotal.length){
                for(var i=0; i<document.form1.txtSubTotal.length; i++){
                    //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
                    document.form1.txtSubTotal[i].value=(document.form1.txtNilai[i].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
                }
                var cStot=0;
                for (var i=0;i<document.form1.txtSubTotal.length;i++){
                    //alert(document.form1.txtSubTot[i].value);
                    document.form1.txtTotal[i].value=(document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1);
                    cStot +=(document.form1.txtTotal[i].value*1);
                }
                document.getElementById('total').innerHTML=cStot;
            }
            else{
                document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1);
                //(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
                document.form1.txtTotal.value = (document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
                document.getElementById('total').innerHTML = document.form1.txtTotal.value;
            }

            var totAll = document.getElementById('total').innerHTML;
            //var others = document.getElementById('others').value;
            var lain2, tmp, total = 0;
            //jml = a
            //harga = b 
            //total = c
            //lain2 = x
            //subtotal = b+((a*b/c)*x/a)
            //total = subtotal * a
            if(document.form1.txtSubTotal.length){
                var rowCount = document.form1.txtSubTotal.length;
                for(var i=0; i<rowCount; i++){
                    var nilai = (document.forms[0].txtNilai[i].value*1);
                    var jml = (document.forms[0].txtJml[i].value*1);
                    lain2 = (others*(nilai*jml)/totAll).toString().split('.');
                    if(lain2[1] != undefined){
                        lain2 = lain2[0]+'.'+lain2[1].substr(0, 2);
                    }
                    else{
                        lain2 = lain2[0];
                    }
                    lain2 = parseFloat(lain2);
                    document.forms[0].txtLain2[i].value = lain2;
                    //document.forms[0].txtSubTotal[i].value = nilai+lain2/(nilai*jml);
                    tmp = (nilai+lain2/jml).toString().split('.');
                    if(tmp[1] != undefined){
                        tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                    }
                    else{
                        tmp = tmp[0];
                    }
                    tmp = parseFloat(tmp);
                    document.forms[0].txtSubTotal[i].value = tmp;
                    tmp = (nilai*jml+lain2).toString().split('.');
                    if(tmp[1] != undefined){
                        tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                    }
                    else{
                        tmp = tmp[0];
                    }
                    tmp = parseFloat(tmp);
                    document.forms[0].txtTotal[i].value = tmp;
                    total += nilai*jml+lain2;
                }
                tmp = Math.round(total);
                total = tmp<total?total+1:tmp;
                document.getElementById('total').innerHTML = total;
            }
            else{
                var nilai = (document.getElementById('txtNilai').value*1);
                var jml = (document.getElementById('txtJml').value*1);
                lain2 = others*(jml*nilai)/totAll;
                document.form1.txtLain2.value = lain2;
                document.form1.txtTotal.value = nilai*jml+lain2;
                //document.getElementById('txtSubTotal').value = nilai+lain2/(nilai*jml);
                document.getElementById('txtSubTotal').value = nilai+lain2/jml;
                document.getElementById('total').innerHTML = nilai*jml+lain2;
            }
            document.getElementById('btnSimpan').disabled = false;
        }*/

        function setDisable(ev,par){
            if(ev == 'del'){
                document.getElementById('btnSimpan').disabled = true;
                return;
            }
            else if(isNaN(par.value)){
                alert('Input harus berupa angka.');
                //document.getElementById('btnSimpan').disabled = true;
            }
            var listNum = '8,46,96,97,98,99,100,101,102,103,104,105,110';
            listNum = listNum.split(',');
            for(var i=0; i<listNum.length; i++){
                if(ev.which == listNum[i]){
                    //document.getElementById('btnSimpan').disabled = true;
                    break;
                }
            }
        }
        
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
                }
                else if (key==13){
                    if (RowIdx>0){
                        if (fKeyEnt==false){
                            fSetObat(document.getElementById(RowIdx).lang);
                        }else{
                            fKeyEnt=false;
                        }
                    }
                }
                else if (key!=27 && key!=37 && key!=39){
                    RowIdx=0;
                    fKeyEnt=false;
                    Request('baranglist.php?aKeyword='+keywords+'&no='+i , 'divbarang', '', 'GET' );
                    if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
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
                document.forms[0].txtObat.value=cdata[2];
                document.forms[0].satuan.value=cdata[3];
                tds = tbl.rows[3].getElementsByTagName('td');
                //document.forms[0].txtHarga.value=cdata[4];
                //document.forms[0].satuan.focus();
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
                document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
                document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[3];
                tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
                //document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
                document.forms[0].satuan[(cdata[0]*1)-1].focus();
            }
            tds[1].innerHTML=cdata[4];
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
                el.id = 'obatid';
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
                el.id = 'txtObat';
                el.setAttribute('OnKeyUp', "suggest(event,this);");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
            }
            el.type = 'text';
            //el.id = 'txtObat'+(iteration-1);
            el.size = 40;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            // right cell
            cellRight = row.insertCell(3);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtUraian';
                el.id = 'txtUraian';                
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtUraian" autocomplete="off" />');
            }
            el.type = 'text';
            //el.size = 6;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            // right cell
            cellRight = row.insertCell(4);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtJml';
                el.id = 'txtJml';
                el.setAttribute('onKeyUp', "AddRow(event,this,'txtJml');setDisable(event,this);");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this);setDisable(event,this);" autocomplete="off" />');
            }
            el.type = 'text';
            el.size = 6;
            el.className = 'txtcenter';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            if(!isIE){
                cellRightSel = row.insertCell(5);
                sel = document.createElement('input');
                sel.name = 'satuan';
                sel.id = 'satuan';
                sel.setAttribute('readonly',"readonly");
                sel.className = "txtinput";
            }
            else{
                sel.document.createElement('<input name="satuan" id="satuan" readonly="readonly" />');
            }

            cellRightSel.className = 'tdisi';
            cellRightSel.appendChild(sel);
                        

                        /*  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
                         */
                        // right cell
                        cellRight = row.insertCell(6);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtNilai';
                            el.id = 'txtNilai';
                            el.setAttribute('onKeyUp', "AddRow(event,this,'txtNilai');setDisable(event,this);");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input name="txtNilai" onKeyUp="AddRow(event,this);setDisable(event,this);" autocomplete="off" />');
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        /*// right cell
                        cellRight = row.insertCell(6);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtLain2';
                            el.id = 'txtLain2';
                            el.setAttribute('readonly', "true");
                        }else{
                            el = document.createElement('<input name="txtLain2" readonly="true" />');
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);
                        */

                        // right cell
                        //cellRight = row.insertCell(7);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtSubTotal';
                            el.id = 'txtSubTotal';
                            el.setAttribute('readonly', "true");
                        }else{
                            el = document.createElement('<input name="txtSubTotal" readonly="true" />');
                        }
                        el.type = 'hidden';
                        el.size = 12;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        // right cell
                        cellRight = row.insertCell(7);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtTotal';
                            el.id = 'txtTotal';
                            el.setAttribute('readonly', "true");
                            //el.setAttribute('onKeyUp', "AddRow(event,this,'txtTotal')");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input name="txtTotal" readonly autocomplete="off" />');// onKeyUp="AddRow(event,this)"
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        cellRightSel = row.insertCell(8);
                        sel = document.createElement('select');
                        sel.name = 'utk_unit_id';
                        sel.id = 'utk_unit_id';
                        sel.className = "txtinput";
                        //sel.id = 'selRow'+iteration;
<?php
echo $selUnit;
?>
                //  sel.options[0] = new Option('text zero', 'value0');
                //  sel.options[1] = new Option('text one', 'value1');
                cellRightSel.className = 'tdisi';
                cellRightSel.appendChild(sel);


                // right cell
                cellRight = row.insertCell(9);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del");setDisable("del")}"/>');
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
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }

    function AddRow(e,par,el){
        var key;
        //alert(document.form1.txtLain2.length);
        if(window.event) {
            key = window.event.keyCode;
        }
        else if(e.which) {
            key = e.which;
        }
        //alert(key);
        if (key==13){
            addRowToTable();
        }
        else{
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
            //alert(par.id);
            /*if(document.form1.txtLain2.length){
                //var i=par.parentNode.parentNode.rowIndex;
                //alert(par[i-2].id);
                var tbl = document.getElementById('tblJual');
                var jmlRow = tbl.rows.length;
                var i;
                if (jmlRow > 4){
                    i=par.parentNode.parentNode.rowIndex-2;
                }else{
                    i=0;
                }

                //document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
                //alert(document.getElementById(el[i-2]).id);
                if(document.forms[0].txtJml[i-1].id == el || document.forms[0].txtNilai[i-1].id == el){
                    HitungSubTot(par);
                }
                if(document.forms[0].txtJml[i-1].id == el || document.forms[0].txtTotal[i-1].id == el){
                    //HitungSatuan(par);
                }
            }
            else{*/
                if(par.id=='txtJml' || par.id=='txtNilai'){
                    HitungSubTot(par);
                }
                if(par.id=='txtJml' || par.id=='txtTotal'){
                    //HitungSatuan(par);
                }
            //}
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
            var cStot=0,tmp;
            for (var i=0;i<document.form1.txtSubTotal.length;i++){
                //var lain2 = (document.form1.txtLain2[i].value*1)==0||(document.form1.txtLain2[i].value*1)==''?0:(document.form1.txtLain2[i].value*1);
                //alert(document.form1.txtSubTot[i].value);
                //tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)+lain2).toString();
                tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)).toString();
                tmp = tmp.split('.');
                if(tmp[1] != undefined){
                    tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                }
                else{
                    tmp = tmp[0];
                }
                tmp = parseFloat(tmp);
                document.form1.txtTotal[i].value=tmp;
                cStot +=(document.form1.txtTotal[i].value*1);
            }
            tmp = Math.round(cStot)<cStot?Math.round(cStot)+1:Math.round(cStot);
            document.getElementById('total').innerHTML=tmp;
            //alert(cStot);
        }
        else{
            document.form1.txtTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
            document.getElementById('total').innerHTML=document.form1.txtTotal.value;
        }
        if('<?php echo $edit;?>' == true){
            document.getElementById('btnSimpan').disabled = false;
        }
    }

    function HitungSubTot(par){
        //var tbl = document.getElementById('tblJual');
        //alert(i);
        if (document.form1.txtSubTotal.length){
            //var i=par.parentNode.parentNode.rowIndex;
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
            //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
            document.form1.txtSubTotal[i-1].value=(document.form1.txtNilai[i-1].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
        }else{
            document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1)//(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
        }
        HitungTot();
    }

    function HitungSatuan(par){
        //var tbl = document.getElementById('tblJual');
        var i=par.parentNode.parentNode.rowIndex;
        //alert(document.form1.txtLain2.length);
        if (document.form1.txtLain2.length){
            document.form1.txtLain2[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtTotal[i-3].value*1);
        }else{
            document.form1.txtLain2.value=(document.form1.txtJml.value*1)*(document.form1.txtTotal.value*1);
        }
        HitungTot();
    }

    function save(){
        var cdata='';
        var ctemp;
        if (document.forms[0].no_po.value==""){
            alert('Isikan No PO Terlebih Dahulu !');
            document.forms[0].no_po.focus();
            return false;
        }
        if (document.forms[0].obatid.length){
            for (var i=0;i<document.forms[0].obatid.length;i++){
                ctemp=document.forms[0].obatid[i].value;//.split('|');
                if (document.forms[0].obatid[i].value==""){
                    alert('Pilih Barang Terlebih Dahulu !');
                    document.forms[0].txtObat[i].focus();
                    return false;
                }
                cdata += ctemp+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].satuan[i].value+'|'+document.forms[0].txtNilai[i].value+'|'+document.forms[0].txtSubTotal[i].value+'|'+document.forms[0].txtTotal[i].value+'|'+document.forms[0].utk_unit_id[i].value+'|'+document.forms[0].txtUraian[i].value;
               
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
                alert('Pilih Obat Terlebih Dahulu !');
                document.forms[0].txtObat.focus();
                return false;
            }
            ctemp=document.forms[0].obatid.value;//.split('|');
            cdata=ctemp+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].satuan.value+'|'+document.forms[0].txtNilai.value+'|'+document.forms[0].txtSubTotal.value+'|'+document.forms[0].txtTotal.value+'|'+document.forms[0].utk_unit_id.value+'|'+document.forms[0].txtUraian.value;
            if("<?php echo $edit;?>" == true){
                cdata += '|'+document.forms[0].id.value;
            }
        }
        //ms_barang_id,vendor_id,no_po,tgl,satuan,qty_satuan,harga_satuan
        //satuan,qty_satuan,harga_satuan
        document.forms[0].fdata.value=cdata;
        //alert(document.forms[0].fdata.value);
        document.forms[0].submit();
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
    }
    if('<?php echo $edit;?>' == true){
        HitungTot();
    }
    </script>
</html>