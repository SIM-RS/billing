<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
$barang_opener="par=idbarang*kodebarang*namabarang";
if(isset($_POST['act']) && $_POST['act'] != '') {
    $idtransaksi= $_POST["idtransaksi"];
    if(!isset($idtransaksi) || $idtransaksi == '') {
        $idtransaksi = -1;
    }
    if ($idtransaksi==-1) {
        $tok= $_POST["tok"];
        $idunit= $_POST["idunit"];
        $idlokasi= $_POST["idlokasi"];
        $idjenistrans= $_POST["idjenistrans"];
        $idbarang= $_POST["idbarang"];
        $qtytransaksi= $_POST["qtytransaksi"];
        $hargasatuan= $_POST["hargasatuan"];
        $idcurr= $_POST["kurs"];
        $nilaikurs= $_POST["nilaikurs"];
        $kondisi= $_POST["kondisi"];
        // Security Management
        if ($_SESSION["usertype"]!="A" and $_SESSION['usertype']=="P")
            $idunit= $_SESSION["refidunit"];
    }
    $tgltransaksi= tglSQL($_POST["tgltransaksi"]);
    $tglpembukuan= tglSQL($_POST["tglpembukuan"]);
    $refno= $_POST["refno"];
    $nosk= $_POST["nosk"];
    $tglsk= tglSQL($_POST["tglsk"]);
    $buktino= $_POST["buktino"];
    $kepemilikan= $_POST["kepemilikan"];
    $namabarang= $_POST["namabarang"];
    $idsatuan= $_POST["satuan"];
    $catatankhusus= $_POST["catatankhusus"];
    $void= $_POST["void"];
    $t_userid= $_SESSION["userid"];
    $t_updatetime= date("Y-m-d H:i:s");
    $t_ipaddress=  $_SERVER['REMOTE_ADDR'];

    // INSERT OR UPDATE SQL -------------------------
    $act = $_POST["act"];
    if ($act == "add") {
        // Insert Record
        echo $query = "insert into as_transaksi (tok,idunit,idlokasi,idjenistrans,tgltransaksi,tglpembukuan,refno,nosk,tglsk,buktino,kepemilikan
                    ,idsatuan,catatankhusus,void,t_userid,t_updatetime,t_ipaddress) values
                    ('$tok','$idunit','$idlokasi','$idjenistrans','$tgltransaksi','$tglpembukuan','$refno','$nosk','$tglsk','$buktino','$kepemilikan'
                    ,'$idsatuan','$catatankhusus','$void','$t_userid','$t_updatetime','$t_ipaddress')";
        //$rs = mysql_query($query);
        //$err = mysql_error();
        if(isset($err) && $err != '') {
            echo "<script> alert('" . $err . "'; </script>";
        }
    }
    else if($act == 'edit') {
        if ($idtransaksi!=-1) { // Update Record
            echo $query = "update as_transaksi set tgltransaksi = '$tgltransaksi',tglpembukuan = '$tglpembukuan',refno = '$refno',nosk = '$nosk',tglsk = '$tglsk',buktino = '$buktino',kepemilikan = '$kepemilikan'
                    ,idsatuan = '$idsatuan',catatankhusus = '$catatankhusus', void = '$void',t_userid = '$t_userid', t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress'
                    where idtransaksi = $idtransaksi";
            //$rs = mysql_query($query);
            //$err = mysql_error();
            if(isset($err) && $err != '') {
                echo "<script> alert('" . $err . "'; </script>";
            }
        }
        else {
            echo 'no id';
        }
    }

    //echo "idtransaksi=".$_POST['idtransaksi'].",refno=".$_POST['refno'].",kodeunit=".$_POST['kodeunit'].",kodelokasi=".$_POST['kodelokasi'].",buktino=".$_POST['buktino'].",tgltransaksi=".$_POST['tgltransaksi'].",tglpembukuan=".$_POST['tglpembukuan'].",tok=".$_POST['tok'].",nosk=".$_POST['nosk'].",sumberdana=".$_POST['sumberdana'].",tglsk=".$_POST['tglsk'].",void=".$_POST['void'].",refidrekanan=".$_POST['refidrekanan'].",namarekanan=".$_POST['namarekanan'].",namaunit=".$_POST['namaunit'].",idunit=".$_POST['idunit'].",idlokasi=".$_POST['idlokasi']."";
    //echo "idbarang=".$_POST['idbarang'].",=".",kodebarang=".$_POST['kodebarang'].",qtytransaksi=".$_POST['qtytransaksi'].",satuan=".$_POST['satuan'].",hargasatuan=".$_POST['hargasatuan'].",kurs=".$_POST['kurs'].",nilaikurs=".$_POST['nilaikurs'].",dasarharga=".$_POST['dasarharga'].",kondisi=".$_POST['kondisi']."";
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Detil Perubahan</title>
    </head>
    <body>
        <script type="text/javascript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <?php
        include '../header.php';

        $act = $_GET['act'];
        $par = "act=$act";
        if($act == 'edit') {
            $idperubahan = $_GET['idperubahan'];
            $par .= "&idperolehan=$idperubahan";
            echo $query = "SELECT h.idtransaksi, h.idjenistrans, j.keterangan as namajenistrans, h.idunit, m.namaunit, h.idlokasi, h.tgltransaksi, h.tglpembukuan, h.tok, h.refno, h.nosk, h.tglsk, h.buktino, h.kepemilikan, h.refidrekanan, h.idbarang, b.namabarang, k.qtytransaksi, h.idsatuan, k.hargasatuan, h.dasarharga, h.totalamount, h.idcurr, h.nilaikurs, h.asalbarang, h.tahunproduksi, h.merk, h.ukuran, h.spesifikasi, h.kondisi, h.catatankhusus, h.void
                        FROM as_transaksi h inner join as_ms_unit m on h.idunit=m.idunit inner join as_ms_jenistransaksi j on j.idjenistrans=h.idjenistrans
                        inner join as_ms_barang b on h.idbarang = b.idbarang left join as_kib k on h.idtransaksi = k.idtransaksi
                         WHERE h.idtransaksi=$idperubahan";

            /*idtransaksi,idjenistrans,at.idunit,kodeunit,at.idlokasi as at_idlokasi,DATE_FORMAT(tgltransaksi,'%d-%m-%Y') as tgltransaksi
                        ,DATE_FORMAT(tglpembukuan,'%d-%m-%Y') as tglpembukuan, tok,refno,nosk,tglsk,buktino,kepemilikan,refidrekanan
                        ,at.idbarang as at_idbarang,at.idsatuan as at_idsatuan,dasarharga,totalamount,idcurr,nilaikurs,asalbarang,tahunproduksi
                        ,merk,ukuran,spesifikasi,kondisi,catatankhusus,void,at.t_userid as at_userid,at.t_updatetime as at_updatetime
                        ,at.t_ipaddress as at_ipaddress,numx1,kodetanah,ab.idbarang,kodebarang,namabarang,tipebarang , au.level as levelunit
                        , ab.level as levelbarang,mru,statuskode,metodedepresiasi,stddepamt,stddeppct,lifetime,nilairesidu,akunaset,akundep,akunakdep
                        ,akundisloss,akundisgain ,akunmaintenance,akunlease,ab.t_userid,ab.t_updatetime,ab.t_ipaddress,ab.idsatuan*/
            $rs = mysql_query($query);
            $rows = mysql_fetch_array($rs);
        }
        else {
            $idperubahan = -1;
        }
        ?>
        <div align="center">
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>

                </tr>
                <tr>
                    <td align="center">
                        <table width="753" cellpadding="4" cellspacing="0" align="center">
                            <tr>
                                <td height="30" colspan="4" valign="bottom" align="right">
                                    <button class="Enabledbutton" id="backbutton" onClick="location='penghapusan.php'" title="Back" style="cursor:pointer">
                                        <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                        Back to List
                                    </button>
                                    <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                        <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                                    </button>
                                    <button class="Disabledbutton" id="undobutton" onClick="location='detailPenghapusan.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                        <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Undo/Refresh
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <form id="form1" name="form1" action="" onSubmit="return ValidateForm('idunit,idlokasi,idbarang,namabarang','Ind');" method="post">
                            <table width="753" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                <tr>
                                    <td height="25" colspan="4" align="center" class="header">
                                        .:Transaksi Penghapusan:.
                                    </td>
                                </tr>
                                <tr>
                                    <td width="88" class="label">ID Trans </td>
                                    <td width="246" class='content'>
                                        <input name="idtransaksi" type="text" class="txtunedited" readonly id="idtransaksi" tabindex="1" value="<?php echo $rows["idtransaksi"]; ?>" size="10" maxlength="10" >
                                        <font size=1 color=gray><i>(auto)</i></font>
                                    </td>
                                    <td width="94" class="sublabel">No Ref/SPM</td>
                                    <td width="269" class='content'>
                                        <input name="refno" type="text" class="txt" id="refno" tabindex="10" value="<?php echo $rows["refno"]; ?>" size="40" maxlength="50">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Unit &amp; Lokasi </td>
                                    <td class='content'>
                                        <input name="idunit" type="text" class="txtunedited" readonly id="idunit" tabindex="2" value="<?php echo $rows["idunit"]; ?>" size="10" maxlength="15" >
                                        -
                                        <input name="idlokasi" type="text" class="txtunedited" readonly id="idlokasi" tabindex="3" value="<?php echo $rows["idlokasi"]; ?>" size="10" maxlength="10" >
                                        <?php if ($idperubahan==-1) { ?>
                                        &nbsp;<img alt="daftar" title='daftar ruangan' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="OpenWnd('lv_ruang.php?idunit='+document.getElementById('idunit').value,410,300,'Lokasi',true)">
                                            <?php } ?>
                                    </td>
                                    <td class="sublabel">No. Bukti/BA </td>
                                    <td class='content'><input name="buktino" type="text" class="txt" id="buktino" tabindex="11" value="<?php echo $rows["buktino"]; ?>" size="40" maxlength="50"></td>
                                </tr>
                                <tr>
                                    <td class="label">Tgl Hapus </td>
                                    <td class='content'><input name="tgltransaksi" type="text" class="txt" readonly id="tgltransaksi" tabindex="4" value="<?php echo date("d-m-Y",strtotime($rows["tgltransaksi"])); ?>" size="15" maxlength="15" >
                                        <?php if ($idperubahan==-1) { ?>
                                        <img alt="tanggal transaksi" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgltransaksi'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                            <?php } ?>
                                    </td>
                                    <td class="sublabel">Tgl Pembukuan </td>
                                    <td class='content'><input name="tglpembukuan" type="text" class="txt" readonly id="tglpembukuan" tabindex="12" value="<?php echo date("d-m-Y",strtotime($rows["tglpembukuan"])); ?>" size="15" maxlength="15">
                                        <img alt="tanggal pembukuan" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglpembukuan'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">T / K</td>
                                    <td class='content'>
                                        <select name="tok" class="txt" id="tok" tabindex="5">
                                            <option value="K" >Kurang</option>
                                        </select>
                                        <select id="idjenistrans" name="idjenistrans" class="txt">
                                            <option value=""></option>
                                            <?php
                                            $query = "SELECT idjenistrans,keterangan FROM as_ms_jenistransaksi where substring(idjenistrans,1,1)='3'";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $row['idjenistrans']; ?>"><?php echo $row['keterangan'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td class="sublabel">No SK Hapus </td>
                                    <td class='content'>
                                        <input name="nosk" type="text" class="txt" id="nosk" tabindex="13" value="<?php echo $rows["nosk"]; ?>" size="40" maxlength="50">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Status</td>
                                    <td class='content'><?php if ($idperubahan!=-1) { ?>
                                        <select name="void" class="txt" id="void" tabindex="8">
                                            <option value="0" <?php if ($rows["void"]==0) echo "selected"; ?>>Aktif</option>
                                            <option value="1" <?php if ($rows["void"]!=0) echo "selected"; ?>>Void</option>
                                        </select>
                                            <?php } else { ?>
                                        <input type="hidden" id="void" name="void" value="0">
                                        Aktif
                                            <?php } ?>
                                    </td>
                                    <td class="sublabel">Tgl SK Hapus</td>
                                    <td class='content'><input name="tglsk" type="text" class="txt" readonly id="tglsk" tabindex="14" value="<?php if ($rows["tglsk"]) echo date("d/m/Y",strtotime($rows["tglsk"])); ?>" size="15" maxlength="15">
                                        <img alt="tanggal sk" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsk'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table border=0 cellspacing=0 cellpadding="4" class="GridStyle" width="750" bgcolor="#EDF1FE">
                                <tr>
                                    <td height=20 class="header" colspan="3" align="center">
                                        .: Detail Barang :.
                                    </td>
                                </tr>
                                <tr>
                                    <td width="129" class="label">Barang</td>
                                    <td width="96" class='content'>
                                        <input name="idbarang" type="text" class="txtunedited" readonly id="idbarang" value="<?php echo $rows["idbarang"]; ?>" size="16" maxlength="14" >
                                        <input type="hidden" id="kodebarang">
                                    </td>
                                    <td width="493" class='content'>
                                        <input name="namabarang" type="text" class="txtunedited" readonly id="namabarang" value="<?php echo $rows["namabarang"]; ?>" size="50" maxlength="50">
                                        <?php
                                        if ($idperubahan==-1) { ?>
                                        &nbsp;
                                        <img alt="daftar kode barang" title='daftar kode barang' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="setThing('view1');"><!--+document.getElementById('').value-->
                                        <img alt="daftar kode barang 2" title='daftar kode barang 2' style="cursor:pointer" border=0 src="../images/view_list.gif" align="absbottom" onClick="setThing('view2');"><!--+document.getElementById('').value-->
                                        <img alt="struktur tree kode barang" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="setThing('view3');">
                                            <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Qty</td>
                                    <td class='content'><input name="qtytransaksi" type="text" class="txt" id="qtytransaksi" value="<?php echo $rows["qtytransaksi"]; ?>" size="16" maxlength="6" style="text-align:right" <?php echo $styleRO  ?>></td>
                                    <td class='content'>
                                        <select id="satuan" name="satuan" class="txt">
                                            <option value=""></option>
                                            <?php
                                            $query = "select idsatuan from as_ms_satuan order by nourut";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                echo "<option value='".$row['idsatuan']."' ";
                                                if($row['idsatuan'] == $rows['idsatuan']) {
                                                    echo 'selected';
                                                }
                                                echo " >".$row['idsatuan']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Nilai Lelang</td>
                                    <td class='content'><input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rows["hargasatuan"]; ?>" size="16" maxlength="15" style="text-align:right" <?php echo $styleRO  ?>>      </td>
                                    <td class='content'>
                                        <select name="kurs" id="kurs" class="txt">
                                            <?php
                                            $query = "SELECT idcurr,namacurr FROM as_ms_curr";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $row['idcurr'];?>" <?php if($row['idcurr'] == $rows['idcurr']) echo 'selected';?>><?php echo $row['namacurr'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        Kurs
                                        <input name="nilaikurs" type="text" class="txt" id="nilaikurs" value="<?php if ($idperubahan==-1) echo "1"; else echo round($rows["nilaikurs"],0); ?>" size="10" maxlength="15" style="text-align:right" <?php echo $styleRO  ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Keterangan</td>
                                    <td colspan="2" class='content'><input name="catatankhusus" type="text" class="txt" id="catatankhusus" tabindex="11" value="<?php echo $rows["catatankhusus"]; ?>" size="75" maxlength="255"></td>
                                </tr>
                            </table>
                            <input type="hidden" name="act" value="<?php echo $act;?>">
                        </form>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function setThing(act){
            if((document.getElementById('idunit').value == '' || document.getElementById('idunit').value == null) && ((document.getElementById('idlokasi').value == '' || document.getElementById('idlokasi').value == null))){
                alert('Pilih Unit dan Lokasi terlebih dahulu.');
                return;
            }
            var idunit = document.getElementById('idunit').value;
            var idlokasi = document.getElementById('idlokasi').value;
            switch(act){
                case 'view1':
                    OpenWnd('lv_barang.php?idunit='+idunit+'&idlokasi='+idlokasi,410,300,'Barang',true)
                    break;
                case 'view2':
                    OpenWnd('lv_pickbarang.php?idunit='+idunit+'&idlokasi='+idlokasi,600,300,'Pick Barang',true);
                    break;
                case 'view3':
                    OpenWnd('thing_tree.php?idunit='+idunit+'&idlokasi='+idlokasi+'&<?php echo $barang_opener; ?>',800,500,'msma',true)
                    break;
                }
            }
            function save(){
                if(ValidateForm('idunit,idlokasi,idbarang,namabarang','Ind') == true){
                    //,idjenistrans,qtytransaksi,hargasatuan,nilaikurs
                    document.form1.submit();
                }
            }
    </script>
</html>