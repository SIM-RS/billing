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
    $r_kodebrg=$_POST["kodebarang"];
    $idtransaksi = $_POST["idtransaksi"];
//		if ($r_idtransaksi==-1) {
    $tok = $_POST["tok"];
    $idunit = $_POST["idunit"];
    $kodeunit = $_POST['kodeunit'];
    $kodelokasi = $_POST['kodelokasi'];
    $idlokasi = $_POST["idlokasi"];
    $idjenistrans = $_POST["idjenistrans"];
    $idbarang = $_POST["idbarang"];
    $idcurr = $_POST["kurs"];
    $nilaikurs = $_POST["nilaikurs"];
    $kondisi = $_POST["kondisi"];
	
    $tgltransaksi = tglSQL($_POST["tgltransaksi"]);
    $tglpembukuan = tglSQL($_POST["tglpembukuan"]);
    $refno = $_POST["refno"];
    $nosk = $_POST["nosk"];
    $tglsk = tglSQL($_POST["tglsk"]);
    $buktino = $_POST["buktino"];
    $kepemilikan = $_POST["kepemilikan"];
    $refidrekanan = $_POST["refidrekanan"];
    $namarekanan = $_POST["namarekanan"];
    $dasarharga = $_POST["dasarharga"];
//		$namabarang = $_POST["namabarang"];
    $idsatuan = $_POST["satuan"];
    $tahunproduksi = $_POST["tahunproduksi"];
    $asalbarang = $_POST["asalbarang"];
    $merk = $_POST["merk"];
    $ukuran = $_POST["ukuran"];
    $spesifikasi = $_POST["spesifikasi"];
    $catatankhusus = $_POST["catatankhusus"];
    $void = $_POST["void"];
    $t_userid = $_SESSION["userid"];
    $t_updatetime = date("Y-m-d H:i:s");
    $t_ipaddress =  $_SERVER['REMOTE_ADDR'];
//echo "(".$_POST["idsumberdana"].")";
    $r_idtransaksi = $_GET['idperolehan'];
    if(!isset($_GET['idperolehan'])) {
        $r_idtransaksi = -1;
    }
    $act = $_POST['act'];
    if ($act == "edit") {
        if ($r_idtransaksi!=-1) { // Update Record
            $query = "update as_transaksi set refno='$refno',buktino='$buktino',tgltransaksi='$tgltransaksi'
                        ,tglpembukuan='$tglpembukuan',tok='$tok',idjenistrans='$idjenistrans',nosk='$nosk',tglsk='$tglsk'
                        ,void='$void',refidrekanan='$refidrekanan',idsatuan='$idsatuan',dasarharga='$dasarharga'
                        ,idcurr='$idcurr',nilaikurs='$nilaikurs',kondisi='$kondisi',idunit='$idunit'
                        ,idlokasi='$idlokasi',idbarang='$idbarang'
                        ,t_userid='".$_SESSION['userid']."',t_updatetime='now()',t_ipaddress='".$_SERVER['REMOTE_ADDR']."'
                        where idtransaksi = $r_idtransaksi";
            //,totalamount,kodeunit='$kodeunit',kodelokasi='$kodelokasi',namarekanan='$namarekanan'
            $rs = mysql_query($query);
            $err = mysql_error();
            if (isset($err) && $err != '')
                echo "<script> alert('" . $err . "'); </script>";
            else {
                $qtytransaksi = $_POST["qtytransaksi"];
                $hargasatuan = $_POST["hargasatuan"];
                $idsumberdana = $_POST["sumberdana"];
				$idsumberdana = $_POST["noseri"];

                $query = "select qtytransaksi,hargasatuan,idsumberdana from as_kib where idtransaksi=$r_idtransaksi";
                $rs = mysql_query($query);
                if(mysql_affected_rows() > 0) {
					$query = "update as_kib set qtytransaksi='$qtytransaksi',hargasatuan='$hargasatuan',idsumberdana='$idsumberdana',t_userid='".$_SESSION['userid']."',t_updatetime='now()',t_ipaddress='".$_SERVER['REMOTE_ADDR']."' where idtransaksi='$r_idtransaksi'";
                }
                else {
                    $query = "insert into as_kib (qtytransaksi,hargasatuan,idsumberdana,t_userid,t_updatetime,t_ipaddress) values ('$qtytransaksi','$hargasatuan','$idsumberdana','".$_SESSION['userid']."','now()','".$_SERVER['REMOTE_ADDR']."')";
                }
                $rs = mysql_query($query);
                $err = mysql_error();
                if (isset($err) && $err != '') {
                    echo '<script> alert(" '.htmlentities($err).' "); </script>';
                }
                else {
                    $query = "select max(noseri) as noseri from as_seri where idtransaksi = $r_idtransaksi";
                    $rs = mysql_query($query);
                    $row = mysql_fetch_array($rs);
                    $noseri = $row['noseri'];
                    if($qtytransaksi > $noseri) {
                        $sisa = $qtytransaksi-$noseri;
                        $idtransaksi=$r_idtransaksi;
                        for ($i=1;$i<=$sisa;$i++) {
                            $noseri++;
                            //echo $record1["noseri"]."<br>";
                            $query = "insert into as_seri (idtransaksi,ms_unitid,noseri,t_userid,t_updatetime,t_ipaddress) values ('$idtransaksi','$idunit','$noseri','".$_SESSION['userid']."','now()','".$_SERVER['REMOTE_ADDR']."')";
                            $rs = mysql_query($query);
                            $err = mysql_error();
                            if (isset($err) && $err != '')
                                echo "<script> alert('" . $err . "'); </script>";
                        }
                    }
                    else if($qtytransaksi < $noseri) {
                        $query = "delete from as_seri where noseri >= $noseri and idtransaksi = '".$idtransaksi."'";
                        $rs = mysql_query($query);
                        $err = mysql_error();
                        if (isset($err) && $err != '')
                            echo "<script> alert('" . $err . "'); </script>";
                    }
                    //redirect to perolehan.php
                    echo "<script>window.location = 'perolehan.php';</script>";

                }
            }
        }
        else {
            echo 'no id';
        }
    }
    else { // Insert Record
       $query = "insert into as_transaksi (refno,buktino,tgltransaksi
                        ,tglpembukuan,tok,idjenistrans,nosk,tglsk
                        ,void,refidrekanan,idsatuan,dasarharga
                        ,idcurr,nilaikurs,kondisi,idunit,idlokasi,idbarang,t_userid,t_updatetime,t_ipaddress) values
                        ('$refno','$buktino','$tgltransaksi'
                        ,'$tglpembukuan','$tok','$idjenistrans','$nosk','$tglsk'
                        ,'$void','$refidrekanan','$idsatuan','$dasarharga'
                        ,'$idcurr','$nilaikurs','$kondisi','$idunit','$idlokasi','$idbarang','".$_SESSION['userid']."','now()','".$_SERVER['REMOTE_ADDR']."')";
        //,totalamount,kodeunit,,'$kodeunit',kodelokasi,'$kodelokasi',namarekanan,'$namarekanan'
        $rs = mysql_query($query);
        $err = mysql_error();
        if (mysql_affected_rows()>0) {
            // Change mode to Update
            $query = "select max(idtransaksi) as idtransaksi from as_transaksi";
            $rs = mysql_query($query);
            $row = mysql_fetch_array($rs);

            $r_idtransaksi = $row['idtransaksi'];

            $qtytransaksi = $_POST["qtytransaksi"];
            $hargasatuan = $_POST["hargasatuan"];
            $idsumberdana = $_POST["sumberdana"];

			for ($i=1;$i<=$qtytransaksi;$i++) {
                //echo $record1["noseri"]."<br>";
              $query = "insert into as_seri (idtransaksi,ms_idunit,noseri,t_userid,t_updatetime,t_ipaddress) values ('$r_idtransaksi','$idunit','$i','".$_SESSION['userid']."','now()','".$_SERVER['REMOTE_ADDR']."')";
                $rs = mysql_query($query);
                $err = mysql_error();
                if (isset($err) && $err != '')
                    echo "<script> alert('" . $err . "'); </script>";
            }
			
         $query = "insert into as_kib (idtransaksi,qtytransaksi,hargasatuan,idsumberdana,t_userid,t_updatetime,t_ipaddress) values ('$r_idtransaksi','$qtytransaksi','$hargasatuan','$idsumberdana','".$_SESSION['userid']."','now()','".$_SERVER['REMOTE_ADDR']."')";
            $rs = mysql_query($query);
            $err = mysql_error();
            if (isset ($err) && $err != '')
                echo "<script> alert('" . $err . "'); </script>";

            $idtransaksi=$r_idtransaksi;
            
        }
        else {
            echo "<script> alert('" . $err . "'); </script>";
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
<title>Detil Perolehan</title>
</head>
<body>
<?php
        include '../header.php';
        $act = $_GET['act'];
        $par = "act=$act";
        if($act == 'edit') {
            $idperolehan = $_GET['idperolehan'];
            $par .= "&idperolehan=$idperolehan";
            $query = "select at.idtransaksi,refno,kodeunit,namalokasi,namaunit,kodelokasi,buktino,date_format(tgltransaksi,'%d-%m-%Y') as tgltransaksi
                        ,date_format(tglpembukuan,'%d-%m-%Y') as tglpembukuan,tok,idjenistrans,nosk,date_format(tglsk,'%d-%m-%Y') as tglsk
                        ,void,at.refidrekanan,namarekanan,kodebarang,namabarang,totalamount,at.idsatuan,at.dasarharga,idcurr,nilaikurs,kondisi,at.idunit
                        ,namaunit,at.idlokasi,at.idbarang,idsumberdana,qtytransaksi,ak.hargasatuan
                        from as_transaksi at inner join as_ms_unit au on at.idunit = au.idunit
                        inner join as_ms_barang ab on at.idbarang = ab.idbarang
                        left join as_lokasi al on at.idlokasi = al.idlokasi
                        left join as_ms_rekanan ar on at.refidrekanan = ar.idrekanan
                        left join as_kib ak on at.idtransaksi = ak.idtransaksi
                        where at.idtransaksi = $idperolehan ";
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
        ?>
<div>
  <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><table width="900" cellpadding="4" cellspacing="0" align="center">
          <tr>
            <td height="30" colspan="4" valign="bottom" align="right"><button class="Enabledbutton" id="backbutton" onClick="location='perolehan.php'" title="Back" style="cursor:pointer"> <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" /> Back to List </button>
              <!--button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                        <img alt="back" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
                                    </button-->
              <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer"> <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" /> Save Record </button>
              <button class="Disabledbutton" id="undobutton" onClick="location='detailPerolehan.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer"> <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" /> Undo/Refresh </button>
              <!--button class="Enabledbutton" id="deletebutton" onClick="goDelete()" title="Delete" style="cursor:pointer;">
                                        <img alt="delete" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
                                    </button-->
            </td>
          </tr>
        </table>
        <form id="form1" name="form1" action="" onSubmit="return ValidateForm('kodeunit,tgltransaksi,tglpembukuan,idbarang,namabarang','Ind');" method="post">
          <table width="900" cellspacing=0 cellpadding="4" align="center" bgcolor="#EDF1FE">
            <tr>
              <td height="25" colspan="4" align="center" class="header"> .: Transaksi Perolehan :. </td>
            </tr>
            <tr>
              <td width="88" class="label">ID Trans </td>
              <td width="246" class="contright"><input name="idtransaksi" type="text" class="txtunedited" readonly id="idtransaksi" tabindex="1" value="<?php echo $rows["idtransaksi"]; ?>" size="10" maxlength="10">
                <font size=1 color=gray><i>(auto)</i></font> </td>
              <td width="94" class="sublabel">No. PO</td>
              <td width="269" class="contright"><input name="refno" type="text" class="txt" id="refno" tabindex="10" value="<?php echo  $rows["refno"]; ?>" size="40" maxlength="50">
              </td>
            </tr>
            <tr>
              <td class="label">Unit &amp; Ruangan</td>
              <td class="contright"><input name="namaunit" type="text" class="txtunedited" readonly id="namaunit" tabindex="2" value="<?php echo  $rows["namaunit"]; ?>" size="10" maxlength="15">
                 <input type="hidden" id="kodeunit" name="kodeunit" value="<?php echo  $rows["kodeunit"]; ?>" >
                <!--input type="button" class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('tmpt_layanan_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)" /-->
                <img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('unit_tree.php?<?php echo $unit_opener; ?>',800,500,'msma',true)" />
						<input type="hidden" id="kodelokasi" name="kodelokasi" value="<?php echo  $rows["kodelokasi"]; ?>" >                
                <input name="namalokasi" type="text" class="txtunedited" readonly id="namalokasi" tabindex="3" value="<?php echo  $rows["namalokasi"]; ?>" size="10" maxlength="10">
                &nbsp;<img alt="search" title='daftar ruangan' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="OpenWnd('lv_ruang.php?idunit='+document.getElementById('idunit').value+'&namaunit='+document.getElementById('namaunit').value,410,300,'msma',true)"> </td>
              <td class="sublabel">No. Faktur</td>
              <td class="contright"><input name="buktino" type="text" class="txt" id="buktino" tabindex="11" value="<?php echo  $rows["buktino"]; ?>" size="40" maxlength="50">
              </td>
            </tr>
            <tr>
              <td class="label">Tgl Perolehan</td>
              <td class="contright"><input name="tgltransaksi" type="text" class="txtunedited" readonly id="tgltransaksi" tabindex="4" value="<?php echo $rows["tgltransaksi"]; ?>" size="15" maxlength="15">
                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgltransaksi'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font> </td>
              <td class="sublabel">Tgl Pembukuan </td>
              <td class="contright"><input name="tglpembukuan" type="text" class="txtunedited" readonly id="tglpembukuan" tabindex="12" value="<?php echo  $rows["tglpembukuan"]; ?>" size="15" maxlength="15">
                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglpembukuan'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font> </td>
            </tr>
            <tr>
              <td class="label">T / K</td>
              <td class="contright"><select name="tok" class="txt" id="tok" tabindex="5">
                  <option value="T" <?php if ($rows["tok"]=="T") echo "selected"; ?>>Tambah</option>
                </select>
                <select name="idjenistrans" id="idjenistrans" class="txt">
                  <option value=""></option>
                  <?php
                                            $query = "SELECT idjenistrans,keterangan FROM as_ms_jenistransaksi order by nourut";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                ?>
                  <option value="<?php echo $row['idjenistrans'];?>" <?php if($row['idjenistrans'] == $rows['idjenistrans']) echo 'selected';?>><?php echo $row['keterangan'];?></option>
                  <?php
                                            }
                                            ?>
                </select>
              </td>
              <td class="sublabel">No SK </td>
              <td class="contright"><input name="nosk" type="text" class="txt" id="nosk" tabindex="13" value="<?php echo  $rows["nosk"]; ?>" size="40" maxlength="50">
              </td>
            </tr>
            <tr>
              <td class="label">Sumber Dana </td>
              <td class="contright"><select name="sumberdana" id="sumberdana" class="txt">
                  <option value=""></option>
                  <?php
                                            $query = "select idsumberdana,keterangan from as_ms_sumberdana order by nourut";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                ?>
                  <option value="<?php echo $row['idsumberdana'];?>" <?php if($row['idsumberdana'] == $rows['idsumberdana']) {
                                                    echo 'selected';
                                                        }?>><?php echo $row['keterangan'];?></option>
                  <?php
                                                    }
                                                    ?>
                </select>
              </td>
              <td class="sublabel">Tgl SK </td>
              <td class="contright"><input name="tglsk" type="text" class="txtunedited" readonly id="tglsk" tabindex="14" value="<?php echo $rows["tglsk"]; ?>" size="15" maxlength="15" >
                <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsk'),depRange);"> <font size=1 color=gray><i>(dd-mm-yyyy)</i></font> </td>
            </tr>
            <tr>
              <td class="label">Status</td>
              <td class="contright"><?php if (isset($rows["idtransaksi"])) { ?>
                  <select name="void" class="txt" id="void" tabindex="8">
                    <option value="0" <?php if ($rows["void"]==0) echo "selected"; ?>>Aktif</option>
                    <option value="1" <?php if ($rows["void"]!=0) echo "selected"; ?>>Void</option>
                  </select>
                  <?php
                                        }
                                        else {
                                            echo "<input type='hidden' name='void' value=0 id='void'>";
                                            echo 'Aktif';
                                        } ?>
              </td>
              <td class="sublabel">ID Rekanan</td>
              <td class="contright"><input name="refidrekanan" type="text" class="txtunedited" readonly id="refidrekanan" tabindex="15" value="<?php echo  $rows["refidrekanan"]; ?>" size="10" maxlength="15" >
                <img alt="cari" title='daftar rekanan / vendor' style="cursor:pointer" border=0 src="../images/lookup.gif" align="absbottom" onClick="OpenWnd('lv_rekanan.php',560,300,'msma',true)"> </td>
            </tr>
            <tr>
              <td colspan="2" valign="top" bgcolor="#FFFFCC" class="label">&nbsp;</td>
              <td valign="top" class="sublabel">Nama Rekanan </td>
              <td valign="top" class="contright"><input name="namarekanan" type="text" class="txt" id="namarekanan" tabindex="16" value="<?php echo  $rows["namarekanan"]; ?>" size="40" maxlength="50">
              </td>
            </tr>
          </table>
          <br>
          <table cellspacing=0 cellpadding="4" align="center" width="900" bgcolor="#EDF1FE">
            <tr>
              <td height=20 class="header" colspan="3" align="center"> .: Detail Barang :. </td>
            </tr>
            <tr>
              <td class="label" width="129">Barang</td>
              <td class="contright" width="96"><input name="kodebarang" type="text" class="txtunedited" readonly id="kodebarang" value="<?php echo  $rows["kodebarang"]; ?>" size="16" maxlength="14" >
              </td>
              <td class="contright" width="493"><input name="namabarang" type="text" class="txtunedited" readonly id="namabarang" value="<?php echo  $rows["namabarang"]; ?>" size="50" maxlength="50" >
                <img alt="tree" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('thing_tree.php?<?php echo $barang_opener; ?>',800,500,'msma',true)"> </td>
            </tr>
            <tr>
              <td class="label">Qty</td>
              <td class="contright"><input name="qtytransaksi" type="text" class="txt" id="qtytransaksi" value="<?php echo  $rows["qtytransaksi"]; ?>" size="16" maxlength="6" style="text-align:right">
              </td>
              <td class="contright"><select name="satuan" id="satuan" class="txt">
                  <option value=""></option>
                  <?php
                                            $query = "select idsatuan from as_ms_satuan order by nourut";
                                            $rs = mysql_query($query);
                                            while($row = mysql_fetch_array($rs)) {
                                                ?>
                  <option value="<?php echo $row['idsatuan'];?>" <?php if($row['idsatuan'] == $rows['idsatuan']) echo 'selected';?>><?php echo $row['idsatuan'];?></option>
                  <?php
                                            }
                                            ?>
                </select>
              </td>
            </tr>
            <tr>
              <td class="label">Harga Satuan </td>
              <td class="contright"><input name="hargasatuan" type="text" class="txt" id="hargasatuan" value="<?php echo $rows["hargasatuan"]; ?>" size="16" maxlength="15" style="text-align:right">
              </td>
              <td class="contright"><select name="kurs" id="kurs" class="txt">
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
                <input name="nilaikurs" type="text" class="txt" id="nilaikurs" value="<?php if (!isset($rows["idtransaksi"])) echo "1"; else echo round($rows["nilaikurs"],0); ?>" size="10" maxlength="15" style="text-align:right">
              </td>
            </tr>
            <tr>
              <td class="label">Dasar Harga </td>
              <td class="contright" colspan="2" ><select name="dasarharga" class="txt" id="dasarharga" >
                  <option value="0" <?php if ($rows["dasarharga"]==0) echo "selected"; ?>>0 - Perolehan</option>
                  <option value="1" <?php if ($rows["dasarharga"]==1) echo "selected"; ?>>1 - Taksiran</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class="label">Kondisi Perolehan</td>
              <td class="contright" colspan="2"><!--?php if (!isset($idperolehan) && $act != 'edit') { ?-->
                <select name="kondisi" class="txt" id="kondisi">
                  <option value="B" <?php if ($rows["kondisi"]=="B") echo "selected"; ?>>B - Baik</option>
                  <option value="RR" <?php if ($rows["kondisi"]=="RR") echo "selected"; ?>>RR - Rusak Ringan</option>
                  <option value="RB" <?php if ($rows["kondisi"]=="RB") echo "selected"; ?>>RB - Rusak Berat</option>
                  <option value="TB" <?php if ($rows["kondisi"]=="TB") echo "selected"; ?>>TB - Tidak Berfungsi</option>
                </select>
                <!--?php } else {
                                        switch ($rows["kondisi"]) {
                                            case "B" :
                                                echo "<font color=Green><b>Baik</b></font>";
                                                break;
                                            case "RR" :
                                                echo "<font color=#FF5F55><b>Rusak Ringan</b></font>";
                                                break;
                                            case "RB" :
                                                echo "<font color=Red><b>Rusak Berat</b></font>";
                                                break;
                                            case "TB" :
                                                echo "<font color=Gray><b>Tidak Berfungsi</b></font>";
                                                break;
                                        }
                                    }
                                    ?-->
              </td>
            </tr>
            <tr valign=center>
              <td  class="footer" align="right" colspan="3">&nbsp;</td>
            </tr>
          </table>
          <input type="hidden" name="act" value="<?php echo $act;?>">
          <input name="idunit" type="hidden" id="idunit" value="<?php echo  $rows['idunit']; ?>">
          <input name="namaunit" type="hidden" id="namaunit" value="<?php echo  $rows['namaunit']; ?>">
          <input name="idlokasi" type="hidden" id="idlokasi" value="<?php echo  $rows['idlokasi']; ?>">
          <input name="idbarang" type="hidden" id="idbarang" value="<?php echo  $rows['idbarang']; ?>">
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
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden"></iframe>
<script type="text/javascript" language="javascript">
        var arrRange=depRange=[];
        function save(){
        //	alert(document.getElementById('idunit').value); 
            if(ValidateForm('kodeunit,tgltransaksi,tglpembukuan,idbarang,namabarang','Ind') == true){
                //,idjenistrans,qtytransaksi,hargasatuan,nilaikurs
						               
                document.form1.submit();
            }
        }
    </script>
</html>
