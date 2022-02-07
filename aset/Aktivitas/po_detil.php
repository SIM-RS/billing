<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
{
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
date_default_timezone_set("Asia/Jakarta");
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
$tgl_sql = gmdate('Y-m-d',mktime(date('H')+7));
$parobt = "";
if(isset($_POST['act']) && $_POST['act'] != '') 
{
    $tgl_po = tglSQL($_POST["tgl"]);
    $fdata = $_POST["fdata"];
    $jenis_surat=$_POST["jenis_surat"];
    $no_po = $_POST["no_po"];
    $utk_unit_id=$_POST["utk_unit_id"];
    $vendor_id = $_POST["vendor_id"];
    $judul = $_POST['judul'];
    $exp_kirim = tglSQL($_POST["exp_kirim"]);
    $t_updatetime = date("Y-m-d H:i:s");
	$pemb=$_POST['user'];
	$veri=$_POST['veri'];
	$totSel=$_POST['totSel'];
    
	$obatid = $_POST['obatid'];
	$txtUraian = $_POST['txtUraian'];
	$txtJml = $_POST['txtJml'];
	$txtTotal = $_POST['txtTotal'];
	$satuan = $_POST['satuan'];
	$txtNilai = $_POST['txtNilai'];
	$txtunit = $_POST['txtunit'];
	$id = $_POST['id'];
	//print_r($txtNilai);
	
    $act = $_POST['act'];
    //echo $act;
    if ($act == "edit") 
	{
		$jumlahData = (count($obatid)-1);
		for($loop=0;$loop <= (count($id)-1); $loop++){
			if($id[$loop]!=''){
				if($id[$loop+1] != ''){
					$notDel .= $id[$loop].',';
				} else {
					$notDel .= $id[$loop];
				}
			}
		}
		//echo $notDel;
		$queryDel = "DELETE FROM as_po WHERE id NOT IN ({$notDel}) AND no_po = '$no_po'";
		//echo $queryDel;
		$qDel = mysql_query($queryDel);
		$queryIns = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan ,uraian,exp_kirim,tgl_act,pembuat,verifikator) values ";
		$ins = 0;
		for($loop=0;$loop <= $jumlahData;$loop++){
			//echo $obatid[$loop].'-'.$txtUraian[$loop].'-'.$txtJml[$loop].'-'.$satuan[$loop].'-'.$txtNilai[$loop].'-'.$txtunit[$loop].'<br />';
			if($id[$loop]==''){
				$qty = str_replace('.','',$txtJml[$loop]);
				$hargaSatuan = str_replace('.','',$txtNilai[$loop]);
				$subtotal = $hargaSatuan * $qty;
				//echo $qty." * ".$hargaSatuan." = ".$subtotal."<br />";
				$queryIns .= " ('".$obatid[$loop]."','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','".$txtJml[$loop]."','".$satuan[$loop]."','"
							.str_replace('.','',$txtNilai[$loop])."','$subtotal','$totSel','".$txtunit[$loop]."','"
							.$txtUraian[$loop]."','$exp_kirim','$t_updatetime','$pemb','$veri')";
				if($loop != $jumlahData){
					$queryIns .= ', ';
				}
				$ins += 1;
			} else {
				$qty = str_replace('.','',$txtJml[$loop]);
				$hargaSatuan = str_replace('.','',$txtNilai[$loop]);
				$subtotal = $hargaSatuan * $qty;
				//echo $qty." * ".$hargaSatuan." = ".$subtotal."<br />";
				$sqlUpdate = "UPDATE as_po SET
								ms_barang_id = '".$obatid[$loop]."',
								vendor_id = '$vendor_id',
								jenis_surat = '$jenis_surat',
								no_po = '$no_po',
								tgl_po = '$tgl_po',
								judul = '$judul',
								qty_satuan = '".$txtJml[$loop]."',
								satuan = '".$satuan[$loop]."',
								harga_satuan = '".str_replace('.','',$txtNilai[$loop])."',
								subtotal = '$subtotal',
								total = '$totSel',
								peruntukan = '".$txtunit[$loop]."',
								uraian = '".$txtUraian[$loop]."',
								exp_kirim = '$exp_kirim',
								tgl_act = '$t_updatetime',
								pembuat = '$pemb',
								verifikator = '$veri'
							WHERE id = '".$id[$loop]."'";
				//echo $sqlUpdate.'<br />';
				$qUpdate = mysql_query($sqlUpdate);
			}
		}
		if($ins!=0){
			//echo $queryIns;
			$qInsert = mysql_query($queryIns);
		}
		
		$err = mysql_error();
        if (isset($err) && $err != ''){
            echo "<script> alert('" . $err . "'); </script>";
        } else {
			echo "<script> alert('Data berhasil diupdate');
			window.location='http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."'; </script>";
            //header("location:http://".$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI']."");
		}
			
        /* $fdata = explode('**', $fdata);
        if(count($fdata) > 1) 
		{
            $add_new = false;
            for($i=0; $i<count($fdata); $i++) 
			{
                $data = explode('|', $fdata[$i]);
                if($data[8] != '' && isset($data[8])) //iry "jika id_barang ada, berarti mengalami update ";
				{
                    $id .= $data[8].'|';

                   $query = "update as_po set ms_barang_id = '$data[0]', jenis_surat = '$jenis_surat', vendor_id = '$vendor_id', no_po = '$no_po', tgl_po = '$tgl_po', judul='$judul', exp_kirim = '$exp_kirim'
                            , satuan = '$data[2]', qty_satuan = '$data[1]', harga_satuan = '$data[3]',subtotal='$data[4]',total='$data[5]', peruntukan = '$data[6]', uraian = '$data[7]', pembuat='$pemb', verifikator='$veri'
                            where id = '$data[8]'";
                    //, harga_beli_total = '$data[4]'
					//echo "$query <br>";
                    mysql_query($query);
                }
                else //iry "jika id_barang kosong, berarti mengalami add ";
				{
                    if($add_new == true) 
					{
                        $query_add .= ', ';
                    }
                    else 
					{
                        $add_new = true;
                        $query_add = '';
                    }
                    $query_add .= "('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$exp_kirim','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$pemb','$veri')";
                    //,'$data[4]'
                }
            }
            $query = "select id from as_po where no_po = '$no_po'";
            $rs = mysql_query($query);
            $res = mysql_affected_rows();
            $id = explode('|',$id);
            if($res > count($id)-1) 
			{
                $tmp = '';
                for($i=0; $i<count($id)-1; $i++) 
				{
                    if($i>0) 
					{
                        $tmp .= ', ';
                    }
                    $tmp .= $id[$i];
                }
                $queryDel = "delete from as_po where no_po = '$no_po' and tgl_po = '$tgl_po' and id not in ($tmp)"; //echo  $queryDel;
              	mysql_query($queryDel);
            }
            if($add_new == true) 
			{
               $query_add = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,exp_kirim,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan,uraian,pembuat,verifikator) values ".$query_add;
                $rs = mysql_query($query_add);
                $err = mysql_error();
                if (isset ($err) && $err != '')
                    echo "<script> alert('" . $err . "'); </script>";
            }
        }
        else 
		{
            /* $data = explode('|', $fdata[0]);
            if($data[8] == '' || !isset($data[8])) 
			{
                $query = "delete from as_po where no_po = '$no_po' and tgl_po = '$tgl_po'"; //echo $query;
                //mysql_query($query);

                $query = "insert into as_po (ms_barang_id,jenis_surat,vendor_id,no_po,tgl_po,judul,exp_kirim,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan,uraian,pembuat,verifikator) values ";
                $query .= " ('$data[0]','$jenis_surat','$vendor_id','$no_po','$tgl_po','$judul','$exp_kirim','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$pemb','$veri')";
            }
            else 
			{
                $query = "delete from as_po where no_po = '$no_po' and tgl_po = '$tgl_po' and id <> '$data[8]'"; //echo $query;
               	//mysql_query($query);
                
                $query = "update as_po set ms_barang_id = '$data[0]', jenis_surat = '$jenis_surat', vendor_id = '$vendor_id', no_po = '$no_po', tgl_po = '$tgl_po',judul='$judul', exp_kirim = '$exp_kirim'
                        , qty_satuan = '$data[1]', satuan = '$data[2]', harga_satuan = '$data[3]', subtotal='$data[4]', total='$data[5]', peruntukan='$data[6]', unit_id='$data[7]', pembuat='$pemb', verifikator='$veri'
                        where id = '$data[8]'";
            }
            if($query != '' && isset($query)) 
			{
				//echo $query;
               $rs = mysql_query($query);
            }
			for($loop=0;$loop <= (count($obatid)-1);$loop++){
				echo $obatid[$loop].'-'.$txtUraian[$loop].'-'.$txtJml[$loop].'-'.$satuan[$loop].'-'.$txtNilai[$loop].'-'.$txtunit[$loop].'<br />';
			}
			
        }
        $err = mysql_error();
        if (isset($err) && $err != '')
            echo "<script> alert('" . $err . "'); </script>";
        else
            header("location:http://".$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'].""); */
            //echo $_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'];
    //pemecahan variabel untuk edit -> add/edit*********************************************************
    //pecah belum dicek,karena ada trouble pengiriman data saat dikurangi / ditambah
	} else { 
		// Insert Record
		$query = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan ,uraian,exp_kirim,tgl_act,pembuat,verifikator) values ";
		for($loop=0;$loop <= (count($obatid)-1);$loop++){
			//echo $obatid[$loop].'-'.$txtUraian[$loop].'-'.$txtJml[$loop].'-'.$satuan[$loop].'-'.$txtNilai[$loop].'-'.$txtunit[$loop].'<br />';
			$qty = str_replace('.','',$txtJml[$loop]);
			$hargaSatuan = str_replace('.','',$txtNilai[$loop]);
			$subtotal = $hargaSatuan * $qty;
			$query .= " ('".$obatid[$loop]."','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','".$txtJml[$loop]."','".$satuan[$loop]."','".str_replace('.','',$txtNilai[$loop])."','$subtotal','$totSel','".$txtunit[$loop]."','".$txtUraian[$loop]."','$exp_kirim','$t_updatetime','$pemb','$veri')";
			if($loop != (count($obatid)-1)){
				$query .= ', ';
			}
		}//echo $query;
        /* $fdata = explode('**', $fdata);
		//echo $fdata;
        $query = "insert into as_po (ms_barang_id,vendor_id,jenis_surat,no_po,tgl_po,judul,qty_satuan,satuan,harga_satuan,subtotal,total,peruntukan ,uraian,exp_kirim,tgl_act,pembuat,verifikator) values ";
        //harga_beli_total
        if(count($fdata) > 1) 
		{
            for($i=0; $i<count($fdata); $i++) 
			{
                $data = explode('|', $fdata[$i]);
                if($i > 0) 
				{
                    $query .= ', ';
                }
                $query .= " ('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$exp_kirim','$t_updatetime','$pemb','$veri')";
            }
        }
        else 
		{
            $data = explode('|', $fdata[0]);
            $query .= " ('$data[0]','$vendor_id','$jenis_surat','$no_po','$tgl_po','$judul','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$exp_kirim','$t_updatetime','$pemb','$veri')";
        }
        //echo $query*/
        $rs = mysql_query($query);
        $err = mysql_error();
        if (isset ($err) && $err != '')
		{
            echo "<script> alert('" . $err . "'); </script>";
        }
		else
		{
           	echo "<script> alert('Data berhasil disimpan');window.location='po.php'; </script>";
        }
        //echo $query;

    }

    //echo "idtransaksi=".$_POST['idtransaksi'].",refno=".$_POST['refno'].",kodeunit=".$_POST['kodeunit'].",kodelokasi=".$_POST['kodelokasi'].",buktino=".$_POST['buktino'].",tgltransaksi=".$_POST['tgltransaksi'].",tglpembukuan=".$_POST['tglpembukuan'].",tok=".$_POST['tok'].",nosk=".$_POST['nosk'].",sumberdana=".$_POST['sumberdana'].",tglsk=".$_POST['tglsk'].",void=".$_POST['void'].",refidrekanan=".$_POST['refidrekanan'].",namarekanan=".$_POST['namarekanan'].",namaunit=".$_POST['namaunit'].",idunit=".$_POST['idunit'].",idlokasi=".$_POST['idlokasi']."";
    //echo "idbarang=".$_POST['idbarang'].",=".",kodebarang=".$_POST['kodebarang'].",qtytransaksi=".$_POST['qtytransaksi'].",satuan=".$_POST['satuan'].",hargasatuan=".$_POST['hargasatuan'].",kurs=".$_POST['kurs'].",nilaikurs=".$_POST['nilaikurs'].",dasarharga=".$_POST['dasarharga'].",kondisi=".$_POST['kondisi']."";
}

//else {
if($_GET['no_po'] != '' && isset($_GET['no_po'])) 
{
    	$sql = "select vendor_id,uraian,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,pembuat,verifikator,judul,date_format(exp_kirim,'%d-%m-%Y') as exp_kirim, sum(lain2) as lain2,jenis_surat
                from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                where no_po = '".$_GET['no_po']."' order by id asc";
    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) 
	{
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $tgl = $rows1['tgl'];
        $exp_kirim = $rows1['exp_kirim'];
        $vendor_id = $rows1['vendor_id'];
        $judul = $rows1['judul'];
        $lain2 = round($rows1['lain2'])<$rows1['lain2']?$rows1['lain2']+1:round($rows1['lain2']);
        $no_po_awal = $rows1['no_po'];
		
		$sql = "select jns_id from as_jenis_surat";
        $rsJ = mysql_query($sql);
		while($jenis = mysql_fetch_array($rsJ)){
			$jSurat[] = $jenis['jns_id'].'.';
		}
		$no_po = str_replace($jSurat,'',$no_po_awal);
        mysql_free_result($rs1);
    }
}
else 
{
   /*	$sql="select no_po from as_po s where month(s.tgl_po)=$th[1] and year(s.tgl_po)=$th[2] order by id desc limit 1"; //echo $sql;
    $rs1=mysql_query($sql);
    if($rows1=mysql_fetch_array($rs1)) 
	{
        $no_po=$rows1["no_po"];
        $ctmp=explode("/",$no_po);
        $dtmp=$ctmp[1]+1;
        $ctmp=$dtmp;
        $ctmp=sprintf("%04d",$ctmp);
        //for ($i=0; $i<(4-strlen($dtmp)); $i++)
        //    $ctmp = "0".$ctmp;
        $no_po = "027/".$ctmp."/404.6.8/".$th[2];
    }
    else 
	{
    	
        $no_po = "027/0001/404.6.8/".$th[2];
    }*/
	
}
//}
$qry="select * from as_ms_satuan order by nourut";
$exe=mysql_query($qry);
$sel="";
$i=0;
while($show=mysql_fetch_array($exe)) 
{
    $sel .="sel.options[$i] = new Option('".$show['idsatuan']."', '".$show['idsatuan']."');";
    $i++;
}

$qry="select idunit, namaunit from as_ms_unit";
$exe=mysql_query($qry);
$selUnit="";
$i=0;
while($show=mysql_fetch_array($exe)) 
{
    $selUnit .="sel.options[$i] = new Option('".$show['namaunit']."', '".$show['idunit']."');";
    $i++;
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
		<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
		<!--<script type="text/javascript" src="../theme/li/prototype.js"></script>
		<script type="text/javascript" src="../theme/li/effects.js"></script>
		<script type="text/javascript" src="../theme/li/popup.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/li/popup2.js"></script>-->
		
		<style type="text/css">
			.biasa{
				width:100%;
				border:0px;
				background:#CEE7FF;
				text-align:center;
			}
			.biasa:hover{
				background:#8888FF;
			}
			.sub_totalx{
				text-align:right;
			}			
		</style>
        <title>.: PO :.</title>
    </head>
    <body onLoad="set_NO_PO('<?=$_REQUEST['act'];?>'); jQuery('#judul').focus();">
        <?php
		//include("popBrg.php");
        include '../header.php';
        $act = $_GET['act'];
        if($act == '') {
            $act = 'add';
        }
        ?>
        
        <div align="center">
       
            <div id="divbarang" align="left" style="position:absolute; z-index:1; left: 200px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <form name="form1" id="form1" method="post" action="">
                            <input name="act" id="act" type="hidden" value="<?php echo $act;?>">
                            <input name="fdata" id="fdata" type="hidden" value="">
                            <table width="98%" border="0">
                                <tr>
                                    <td>
                                        <div id="input" style="display:block" align="center">
                                            <table width="100%" border="0" cellpadding="1" cellspacing="1" align="center">
                                                <tr height="20">
                                                    <td class="tdlabel">Jenis Surat </td>
                                                    <td colspan="2">:
                                                        <!--input name="jenis_surat" id="jenis_surat" class="txtunedited" size="25" value="" /-->
                                                        <select id="jenis_surat" name="jenis_surat" class='txtinput' onChange="set_NO_PO('<?=$_REQUEST['act'];?>')">
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
                                                        </select>                                                    </td>
                                                </tr>
                                                <tr height="20">
                                                    <td width="176" class="tdlabel">Tanggal&nbsp; </td>
                                                    <td colspan="2">:
                                                        <input name="tgl" type="text" class="txtinput" id="tgl" tabindex="4" value="<?php if(isset($_REQUEST['tglPo']) && $_REQUEST['tglPo'] != '') echo $_REQUEST['tglPo'];else echo date('d-m-Y'); ?>" size="10" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,tes);">                                                  </td>
                                                </tr>
                                                <tr height="20">
                                                    <td class="tdlabel">Nomor</td>
                                                    <td colspan="2">:
														<input name="no_po2" id="no_po2" type="hidden" class="txtinput" size="30" value="<?php echo $no_po;?>" />
                                                        <input name="no_po" id="no_po" class="txtinput" size="30" value="<?php echo $no_po;?>" />
													</td>
                                                </tr>
                                                <tr height="20">
                                                    <td class="tdlabel">Supplier</td>
                                                    <td colspan="2">:
                                                        <select id="vendor_id" class="txtinput" name="vendor_id">
                                                            <?php
                                                            $query = "select idrekanan, namarekanan from as_ms_rekanan";
                                                            $rs = mysql_query($query);
                                                            while($row = mysql_fetch_array($rs)) {
                                                                ?>
                                                            <option value="<?php echo $row['idrekanan'];?>" <?php if($row['idrekanan'] == $vendor_id) echo 'selected';?>><?php echo $row['namarekanan'];?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>                                                    </td>
                                                </tr>
                                                
                                                <tr height="20">
                                                    <td class="tdlabel">Jatuh Tempo Pengiriman </td>
                                                    <td colspan="2">: 
                                                        <input name="exp_kirim" type="text" class="txtinput" id="exp_kirim" tabindex="4" value="<?php if(isset($_REQUEST['tgl_expnya']) && $_REQUEST['tgl_expnya'] != '') echo $_REQUEST['tgl_expnya'];else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('exp_kirim'),depRange);">                                                    </td>
                                                </tr>
                                                
                                                <tr height="20">
                                                    <td class="tdlabel">
							Judul PO                                                    </td>
                                                    <td width="795">
							: 
							  <input type="text" style="text-align:left" name="judul" id="judul" value="<?php echo $judul;?>" class="txtinput" size='75' />                                                  </td>
												  <!--td width="329" align="center"><input type="button" id="ctk" name="ctk" value="Cetak PO" onClick="window.open('cetak_po.php?jns='+jenis_surat.value+'&tgl='+tgl.value+'&nomor='+no_po.value+'&supplier='+vendor_id.value+'&tgl_kirim='+exp_kirim.value+'&jdl='+judul.value+'&no_po=<?php echo $no_po; ?>')"></td-->
                                                </tr>
												<tr height="20">
													<td>Pembuat</td>
													<td>: <input type="text" class="txtunedited" size="12" readonly id="user" name="user" value="<?php echo $_SESSION['userid']?>"></td>
												</tr>
												<tr height="20">
													<td>Verifikator</td>
													<td>: 
													  <input type="text" class="txtinput" id="veri" name="veri" value="<?php echo $rows1['verifikator']?>">
													</td>
												</tr>
												<tr height="20">
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
											  </tr>
                                            </table>
                                        </div>

                                        <div style="width:975px; height: inherit; overflow:auto; ">
                                            
                                            <table id="tblJual" width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                <tr>
                                                    <td colspan="10" align="center" class="jdltable">&nbsp;</td>
                                                </tr>
                                                <tr>
													<td colspan="2">&nbsp;													</td>
                                                    <td colspan="6" align="center" class="jdltable">
                                                        PURCHASE ORDER
                                                        <hr></td>
                                                
                                                    <td colspan="2" align="right" valign="bottom">
                                                  <input type="button" value=" Tambah List PO " onClick="addRowToTable();" style="padding:3px; cursor:pointer" />                                                    </td>
											    </tr>
                                                <tr class="headtable" height=35>
                                                    <td width="19"  class="tblheaderkiri">No</td>
                                                    <td width="72" class="tblheader">Kode Barang</td>
                                                    <td width="150" class="tblheader">Nama Barang</td>
                                                    <td width="117" class="tblheader">Uraian</td>
                                                    <td width="45" class="tblheader">Jml</td>
                                                    <td width="125" class="tblheader">Satuan</td>
                                                    <td class="tblheader" width="73">Harga Satuan</td>
                                                    <!--td width="40" height="25" class="tblheader">Lain-lain</td-->
                                                    <!--td class="tblheader">Sub Total</td-->
                                                    <td width="120" class="tblheader">Total</td>
                                                    <td width="100" align="center" class="tblheader">Peruntukan</td>
                                                    <td width="59" class="tblheader">Proses</td>
                                                </tr>
                                                <?php
                                                if($edit == true) 
												{
                                                    $sql = "select ap.*,id,ms_barang_id,uraian,kodebarang,ap.peruntukan,namabarang,vendor_id,namarekanan,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,satuan,qty_satuan,lain2,harga_satuan,unit_id,ab.idsatuan
                                                        from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                                                        where no_po = '".$_GET['no_po']."' and tgl_po='".tglSQL($_GET['tglPo'])."' order by id asc"; //echo $sql;
                                                    $rs1 = mysql_query($sql);
                                                    $a = 0;
													$i = 1000;
													$increment = 0;
													$totalAll = 0;
                                                    while($rows1 = mysql_fetch_array($rs1)) 
													{
														if($increment==0)
														{
															$idbrg = $rows1['ms_barang_id'];
														}
														else
														{
															$idbrg .= "**".$rows1['ms_barang_id'];
														}
														$totalAll = $rows1['total'];
														$increment++;
														$status = $rows1['status'];
                                                    	$visible = 'visible';
                                                    	$read = '';
                                                    	if($status==1){$visible='hidden';$read='readonly';}
														$hargasatuan = explode(',',number_format($rows1['harga_satuan'], 2, ',', '.'));
														$subtotal = explode(',',number_format(round($rows1['qty_satuan']*$rows1['harga_satuan']+$rows1['lain2']), 2, ',', '.'));
                                                        ?>
                                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                    <td class="tdisikiri" width="19">
														<?php echo ++$a;?>
													</td>
                                                    <td id="kode_<?=$i?>" class="tdisi" align="center"><?php echo $rows1['kodebarang'];?></td>

                                                    <td class="tdisi" align="center">
                                                        <input name="obatid[]" id="obatid_<?=$i?>" type="hidden" value="<?php echo $rows1['ms_barang_id'];?>" size="5">
                                                        <input type="text" name="txtObat[]" id="txtObat_<?=$i?>" class="txtinput" size="20" value="<?php echo $rows1['namabarang'];?>" onKeyUp="list1(event,this,<?=$i?>);" autocomplete="off" />
                                                        <input type="hidden" id="id_<?=$i?>" name="id[]" value="<?php echo $rows1['id'];?>" />                                                  </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="txtUraian[]" id="txtUraian_<?=$i?>" size="15" class="txtinput" value="<?php echo $rows1['uraian'];?>" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="txtJml[]" id="txtJml_<?=$i?>" size="3" <?=$read; ?> class="txtcenter" value="<?php echo $rows1['qty_satuan'];?>"  onKeyUp="hitung_perkalian(<?=$i?>);AddRow(event,this,'txtJml');setDisable(event,this);" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input id="satuan_<?=$i?>" name="satuan[]" class="biasa" value="<?php echo $rows1['idsatuan']; ?>" readonly="readonly" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input name="txtNilai[]" type="text" class="txtright" <?=$read; ?> id="txtNilai_<?=$i?>"
														value="<?php echo $hargasatuan[0];?>"
														onKeyUp="harga(this.value,0,'txtNilai_<?=$i?>');hitung_perkalian(<?=$i?>);AddRow(event,this,'txtNilai');setDisable(event,this);" size="10" autocomplete="off" />                                                    </td>
                                                    <!--td class="tdisi" width="30">
                                                        <input type="text" name="txtLain2" id="txtLain2" size="10" class="txtright" value="<?php echo round ($rows1['lain2']);?>" readonly size="10" autocomplete="off" />
                                                    </td-->
                                                    <!--td class="tdisi" width="30"-->
                                                        <!--input name="txtSubTotal[]" id="txtSubTotal_<?=$i?>" type="hidden" class="txtright"
														value="<?php //echo round($rows1['harga_satuan']+$rows1['lain2']/$rows1['qty_satuan']);?>"
														size="12" readonly="true" />
                                                    <!--/td-->
                                                    <td class="tdisi">
                                                        <input type="text" name="txtTotal[]" id="txtTotal_<?=$i?>" class="biasa sub_totalx" readonly
														value="<?php echo $subtotal[0];?>"
														size="10" autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtTotal')"-->                                                    </td>
                                                    <td class="tdisi">
                                                       <!--input type="hidden" id="utk_unit_id" class="txtinput" value="<?=$rows1['unit_id'];?>" name="utk_unit_id"--> 
                                                                 <?php
                                                                    /* $query = "SELECT idunit, namaunit FROM as_ms_unit where idunit = '".$rows1['unit_id']."' ORDER BY kodeunit ASC";
                                                                    $rs = mysql_query($query);
                                                                    $row = mysql_fetch_array($rs); */
                                                                    ?>
                                                                    <input type="text" value="<?=$rows1["peruntukan"]?>" name="txtunit[]" id="txtunit_<?=$i?>" class="txtinput" size="20"  onKeyUp="" autocomplete="off" />
                                                        <!--img alt="tree" width="18" title='Struktur tree unit'  style="cursor:pointer;visibility:<?=$visible; ?>;" border=0 src="../images/view_tree.gif" align="absbottom" onClick="treeunit(this);"-->                                                    </td>
                                                    <td class="tdisi">
                                                        <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this,<?=$i?>);setDisable('del')}">                                                    </td>
                                                </tr>
                                                        <?php
														$i++;
                                                    }
                                                }
                                                else 
												{ //Ini digunakan untuk tampilan Add
                                                    ?>
                                                
                                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                                    <td class="tdisikiri" width="19">1                                                    </td>
                                                    <td class="tdisi" align="center" id="kode_0">-</td>
                                                    <td class="tdisi" align="center">
													<input name="obatid[]" id="obatid_0" type="hidden" size="4" value="">
                                                    <input type="text" name="txtObat[]" id="txtObat_0" class="txtinput" size="20" onKeyUp="list1(event,this,0);"  autocomplete="off" /><div id="divbarang" align="center" style="z-index:1; width: 751px; left: 419px; top: 588px; height: 300px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>													</td>
                                                     <td class="tdisi">
                                                        <input type="text" name="txtUraian[]" size="15" id="txtUraian_0" class="txtinput" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" name="txtJml[]" id="txtJml_0" class="txtcenter" size="3" onKeyUp="hitung_perkalian(0);AddRow(event,this,'txtJml_0');setDisable(event,this);" autocomplete="off" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input type="text" id="satuan_0" name="satuan[]" class="biasa"  readonly="readonly" />                                                    </td>
                                                    <td class="tdisi">
                                                        <input name="txtNilai[]" type="text" class="txtright" id="txtNilai_0" onKeyUp="harga(this.value,0,'txtNilai_0'); hitung_perkalian(0);AddRow(event,this,'txtNilai_0');setDisable(event,this);" size="10" autocomplete="off" />                                                    </td>
                                                        <input type="hidden" name="txtSubTotal[]" id="txtSubTotal_0" class="txtright" size="10" readonly="true" />
                                                    <!--/td-->
                                                    <td class="tdisi">
                                                        <input type="text" name="txtTotal[]" id="txtTotal_0" class="biasa sub_totalx" size="10" readonly autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtTotal')"-->                                                    </td>
                                                    <td class="tdisi">
                                                    <!--input type="hidden" id="utk_unit_id" class="txtinput" name="utk_unit_id"--> 
                                                    <input type="text" name="txtunit[]" id="txtunit_0" class="txtinput" size="20" onKeyUp="" autocomplete="off" />
                                                        <!--img alt="tree" width="18" title='Struktur tree unit'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="treeunit(this);"-->                                                    </td>
                                                    <td class="tdisi">
                                                        <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this,0);setDisable('del');}">                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                          </table>
							<?php
								//echo $totalAll."<br /><br /><br /><br />";
								$totalAll = explode(',',number_format($totalAll, 2, ',', '.'));
							?>
                            <table width="90%" align="center">
                                <tr>
                                    <td width="88%" class="txtright">Total :</td>
                                    <td id="total" width="11%" align="right" class="txtright"><?=($totalAll[0]!='')?$totalAll[0]:0?>
									</td>
                                    <td width="1%"><input type="hidden" id="totalSeluruh" name="totSel" value="<?=($totalAll[0]!='')?$totalAll[0]:0?>"/>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="center">
                                        <!--button type="button" class="Enabledbutton" id="btnDist" name="btnDist" onClick="activate()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            DISTRIBUSI BIAYA LAIN-LAIN
                                        </button-->
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" title="Save" style="cursor:pointer" onClick="save()">
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
	<script src="../theme/jquery-1.8.3.js"></script>
    <script type="text/javascript" language="javascript">
    	  var js = document.getElementById('jenis_surat').value;
    	  var nopo = document.getElementById('no_po').value;
		  var act = document.getElementById('act').value;
		 
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
		//function riz(){
			//window.location='po_detil.php?cmbIventaris='+document.getElementById('cmbfilter').value;
			//alert(cmbIventaris);
	//	}
		
        function setDisable(ev,par){
            if(ev == 'del'){
                document.getElementById('btnSimpan').disabled = false;
                return;
            }
            else if(isNaN(par.value.split('.').join(''))){
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
        function treebrg(rew){
			 var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=rew.parentNode.parentNode.rowIndex-3;
            }else{
                i=0;
            }
			
			if('<?=$idbrg;?>'!=''){
			
		/*new Popup('pop',null,{modal:true,position:'center',duration:0.5})
		$('pop').popup.show();*/
			Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
			//document.getElementById('ketarangan').value='';

            //OpenWnd('treebrgPO.php?cek=<?=$idbrg;?>&i='+i,800,500,'msma',true);
            }else{
			var databrg='';
			for (var ik=0;ik<document.forms[0].obatid.length;ik++){
                if(ik==0){
				databrg=document.forms[0].obatid[ik].value;
				}else{
				databrg+='**'+document.forms[0].obatid[ik].value;
				}
			}
			Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
				document.getElementById("nmBarang").value='';
			}			
        	}
			function treeunit(par){
			 var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4){
                i=par.parentNode.parentNode.rowIndex-2;
            }else{
                i=0;
            }
          	Popup.showModal('popList',null,null,{'screenColor':'silver','screenOpacity':.6});
				return false;
				document.getElementById("nmBarang").value='';
            		        	
        	}
       /* function suggest(e,par){
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
			
			var cmb1=document.getElementById('cmbfilter').value;
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
                    Request('baranglist.php?aKeyword='+keywords+'&no='+i+'&cmbIventaris='+cmb1 , 'divbarang', '', 'GET' );
                    if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
                    document.getElementById('divbarang').style.display='block';
                }
            }
        }*/
		  function fsetUnit(par){
		  	if(par!=""){
            var cdata=par.split("*|*");
            var tbl = document.getElementById('tblJual');
            var tds;
            if ((cdata[0]*1)==0){
                document.forms[0].utk_unit_id.value=cdata[1];
				alert(cdata[1])
                document.forms[0].txtunit.value=cdata[2];
            }else{
                var w;
                for (var x=0;x<document.forms[0].utk_unit_id.length-1;x++){
                    w=document.forms[0].utk_unit_id[x].value.split('|');
                   
                }
                document.forms[0].utk_unit_id[(cdata[0]*1)-1].value=cdata[1];
                document.forms[0].txtunit[(cdata[0]*1)-1].value=cdata[2];
            }
            }
		  	}
        function fSetObat(par){
		if(par!=""){
            var cdata=par.split("*|*");
            var tbl = document.getElementById('tblJual');
            var tds;
			var baris = tbl.rows.length;
            if ((cdata[0]*1)==0){
					if(baris==4){
						document.forms[0].obatid.value=cdata[1];
						document.forms[0].txtObat.value=cdata[3];
						document.forms[0].satuan.value=cdata[4];
						tds = tbl.rows[3].getElementsByTagName('td');
						}else{
						document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
						document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[3];
						document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[4];
						tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
						}//document.forms[0].txtHarga.value=cdata[4];
                //document.forms[0].satuan.focus();
            }else{
                var w;
               /*  for (var x=0;x<document.forms[0].obatid.length-1;x++){
                    w=document.forms[0].obatid[x].value.split('|');
                    //alert(cdata[1]+'-'+w[0]);
                    if (cdata[1]==w[0]){
                        fKeyEnt=true;
                        alert("Barang Tersebut Sudah Ada");
                        return false;
                    }
                } */
				//alert(cdata[4])
                document.forms[0].obatid[(cdata[0]*1)].value=cdata[1];
                document.forms[0].txtObat[(cdata[0]*1)].value=cdata[3];
                document.forms[0].satuan[(cdata[0]*1)].value=cdata[4];
                tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
                //document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
                document.forms[0].satuan[(cdata[0]*1)-1].focus();
				//alert(cdata[1]);
            }
            tds[1].innerHTML=cdata[2];
            var no_p0 = document.getElementById('no_po').value;
            var no_p = no_p0.split('/');
            if(cdata[2].substring(0,2)=='03'){
						   no_p0 = "011/"+no_p[1]+"/"+no_p[2]+"/"+no_p[3];
            	}
            	document.getElementById('no_po').value = no_p0;
            //tds[3].innerHTML=cdata[3];

            document.getElementById('divbarang').style.display='none';
        }
	}
	<!--==============================================================================================================-->
	
var RowIdx3;
var fKeyEnt3;
//var cmb=document.getElementById("CmbStt").value;

function list1(e,par,urutan){
var keywords=par.value;//alert(keywords);
var i;
var tbl = document.getElementById('tblJual');
var jmlRow = tbl.rows.length; //alert(jmlRow);
if (jmlRow >= 4)
{
	i=par.parentNode.parentNode.rowIndex-1; //alert(i)
}
else
{
	i=0;
}
var nomer=jmlRow-4;
	if(keywords=="")
	{
		document.getElementById('divobat').style.display='none';
		document.getElementById('divbarang').style.display='none';
	}
	else
	{
		var key;
		if(window.event) 
		{
		  key = window.event.keyCode; 
		}
		else if(e.which) 
		{
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40)
		{
			var tblRow=document.getElementById('tblObat').rows.length;
			var jum_record = tblRow-1; //alert(tblRow);
			if (tblRow>0)
			{
				//alert(RowIdx3);
				if (key==38 && RowIdx3>0)
				{
					if(RowIdx3==0)
					{
						
					}
					else if(RowIdx3==1)
					{
						document.getElementById("row_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3-1;
					}
					else
					{
						document.getElementById("row_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3-1;
						document.getElementById("row_"+RowIdx3).className='itemtableMOverReq';
					}
				}
				else if (key==40 && RowIdx3<tblRow)
				{
					//alert('asd');
					if (RowIdx3==0)
					{
						RowIdx3=RowIdx3+1;
						document.getElementById("row_"+RowIdx3).className='itemtableMOverReq';
					}
					else if (RowIdx3==jum_record)
					{
						
					}
					else
					{
						document.getElementById("row_"+RowIdx3).className='itemtableReq';
						RowIdx3=RowIdx3+1;
						document.getElementById("row_"+RowIdx3).className='itemtableMOverReq';
					}
				}
			}
		}
		else if (key==13)
		{
			if (RowIdx3>0)
			{
				if (fKeyEnt3==false)
				{
					set_barang_add(document.getElementById('row_'+RowIdx3).lang);
				}
				else
				{
					fKeyEnt3=false;
				}
			}
		}
		else if (key!=27 && key!=37 && key!=39)
		{
			RowIdx3=0;
			fKeyEnt3=false;
			if (par.value.length>=3)
			{
				var act = '<?=$_REQUEST['act'];?>';
				//var url = 'list_barang_semua.php?aKeyword='+keywords+'&no='+(i-1)+'&act='+act; 
				var url = 'list_barang_semua.php?aKeyword='+keywords+'&no='+urutan+'&act='+act; //alert(url);
				Request(url, 'divbarang', '', 'GET' );
				if (document.getElementById('divbarang').style.display=='none') fSetPosisi(document.getElementById('divbarang'),par);
				document.getElementById('divbarang').style.display='block';
			}
		}
	}
}
function ValNamaBag(par)
{
	if(par!="")
	{
    var cdata=par.split("|");
    var tbl = document.getElementById('tblJual');
    var tds;
    var baris = tbl.rows.length;
    if ((cdata[0]*1)==0)
	{
    	if(baris==4){
    		document.forms[0].obatid.value=cdata[1];
			document.forms[0].txtObat.value=cdata[3];
    		document.forms[0].satuan.value=cdata[4];
    		tds = tbl.rows[3].getElementsByTagName('td');
    	}else{
			document.forms[0].obatid[(cdata[0])].value=cdata[1];
    		document.forms[0].txtObat[(cdata[0])].value=cdata[3];
    		/*document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[4];
    		tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');*/
    	}
    }else{
    	var w;
    	document.forms[0].obatid[(cdata[0])].value=cdata[1];
    	document.forms[0].txtObat[(cdata[0])].value=cdata[3];
    	document.forms[0].satuan[(cdata[0])].value=cdata[4];
    	tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td'); 
    	document.forms[0].satuan[(cdata[0]*1)-1].focus();
    
    }
	tds[1].innerHTML=cdata[2];
    document.getElementById('divobat').style.display='none';
    }
	Popup.hide('popList');
}
	
	<!--==============================================================================================================-->
	var xx=0;
        function addRowToTable()
        {
			xx++;
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
			cellLeft.id = 'kode_'+xx;
			//============================================
            // right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
			//============================================
            //generate obatid
            if(!isIE)
			{
                el = document.createElement('input');
                el.name = 'obatid[]';
                el.id = 'obatid_'+xx;
				el.size = 4;
            }
			else
			{
                el = document.createElement('<input name="obatid[]" id="obatid_"'+xx+'/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true)
			{
                //generate id
                if(!isIE)
				{
                    el = document.createElement('input');
                    el.name = 'id[]';
                    el.id = 'id';
                }
				else
				{
                    el = document.createElement('<input name="id[]" id="id" />');
                }
                el.type = 'hidden';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }
			
			//============================================
            //generate txtobat
            if(!isIE)
			{
               	el = document.createElement('input');
                el.name = 'txtObat[]';
                el.id = 'txtObat_'+xx;
                el.setAttribute('autocomplete', "off");
				el.setAttribute('onKeyUp', "list1(event,this,"+xx+");");
				
            }
			else
			{
                el = document.createElement('<input name="txtObat[]" onKeyUp="list1(event,this,'+xx+');" autocomplete="off" />&nbsp;');
            }
            el.type = 'text';
            el.size = 20;
         
            el.className = 'txtinput';
            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
			//============================================
            // right cell
            cellRight = row.insertCell(3);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtUraian[]';
                el.id = 'txtUraian_'+xx;                
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtUraian[]" autocomplete="off" />');
            }
            el.type = 'text';
            el.size = 15;
            el.className = 'txtinput';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            // right cell
            cellRight = row.insertCell(4);
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txtJml[]';
                el.id = 'txtJml_'+xx;
                el.setAttribute('onKeyUp', "hitung_perkalian("+xx+");AddRow(event,this,'txtJml_"+xx+"');setDisable(event,this);");
                el.setAttribute('autocomplete', "off");
            }else{
                el = document.createElement('<input name="txtJml[]" id="txtJml_'+xx+'" onKeyUp="hitung_perkalian('+xx+');AddRow(event,this,"txtJml_'+xx+'");setDisable(event,this);" autocomplete="off" />');
            }
            el.type = 'text';
            el.size = 3;
            el.className = 'txtcenter';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
            
            if(!isIE){
                cellRightSel = row.insertCell(5);
                sel = document.createElement('input');
                sel.name = 'satuan[]';
                sel.id = 'satuan_'+xx;
                sel.size = 5;
                sel.setAttribute('readonly',"readonly");
                sel.className = "biasa";
            }
            else{
                sel.document.createElement('<input class="biasa" name="satuan[]" id="satuan_'+xx+'" readonly="readonly" />');
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
                            el.name = 'txtNilai[]';
                            el.id = 'txtNilai_'+xx;
                            el.setAttribute('onKeyUp', "harga(this.value,"+xx+",'txtNilai_"+xx+"');hitung_perkalian("+xx+");AddRow(event,this,'txtNilai_"+xx+"');setDisable(event,this);");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input nama="txtNilai[]" id="txtNilai_'+xx+'" onKeyUp="harga(this.value,'+xx+',"txtNilai_'+xx+'");hitung_perkalian('+xx+');AddRow(event,this,"txtNilai_'+xx+');setDisable(event,this);" autocomplete="off" />');
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
                            el.name = 'txtSubTotal[]';
							
                            el.id = 'txtSubTotal_'+xx;
                            el.setAttribute('readonly', "true");
                        }else{
                            el = document.createElement('<input name="txtSubTotal[]" id="txtSubTotal_"'+xx+' readonly="true" />');
                        }
                        el.type = 'hidden';
                        el.size = 5;
                        el.className = 'txtright';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

                        // right cell
                        cellRight = row.insertCell(7);
                        if(!isIE){
                            el = document.createElement('input');
                            el.name = 'txtTotal[]';
                            el.id = 'txtTotal_'+xx;
                            el.setAttribute('readonly', "true");
                            //el.setAttribute('onKeyUp', "AddRow(event,this,'txtTotal')");
                            el.setAttribute('autocomplete', "off");
                        }else{
                            el = document.createElement('<input id="txtTotal_'+xx+'" name="txtTotal[]" class="biasa sub_totalx" readonly autocomplete="off" />');// onKeyUp="AddRow(event,this)"
                        }
                        el.type = 'text';
                        el.size = 10;
                        el.className = 'biasa sub_totalx';

                        cellRight.className = 'tdisi';
                        cellRight.appendChild(el);

             cellRightSel = row.insertCell(8);
                     //   sel = document.createElement('img');
                     //  sel.src = "../images/view_tree.gif"; 
                     //   sel.setAttribute("onclick","treeunit(this);");
                			//sel.border = "0";
                			//sel.width = 17;
                			//sel.style.cursor = "pointer";
            /*if(!isIE){
                el = document.createElement('input');
                el.name = 'txtunit[]';
                el.id = 'txtunit_'+xx;
            }else{
                el = document.createElement('<input name="txtunit[]" id="txtunit_'+xx+'"/>');
            }
            el.type = 'hidden';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);*/

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id[]';
                    el.id = 'id_'+xx;
                }else{
                    el = document.createElement('<input name="id" id="id_'+xx+'" />');
                }
                el.type = 'hidden';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }
             el = document.createElement('input');
                el.name = 'txtunit[]';
                el.id = 'txtunit_'+xx;
                el.size = 20;
                el.setAttribute('autocomplete', "off");
                //el.setAttribute('readonly', "true");
                el.className = 'txtinput';
                //sel.align = "absmiddle";
                cellRightSel.className = 'tdisi';
                
                cellRightSel.appendChild(el);
                //cellRightSel.appendChild(sel);


                // right cell
                cellRight = row.insertCell(9);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this,'+xx+');setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this,'+xx+');setDisable("del");setDisable("del")}"/>');
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

                //document.forms[0].txtObat[iteration-3].focus();
				jQuery('#txtObat_'+xx).focus();

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

    function AddRow(e,par,el)
	{
        var key;
        //alert(document.form1.txtLain2.length);
        if(window.event) 
		{
            key = window.event.keyCode;
        }
        else if(e.which) 
		{
            key = e.which;
        }
        //alert(key);
        if (key==13){
            addRowToTable();
        }
        else
		{
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-2;
            }
			else
			{
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
                if(par.id=='txtJml' || par.id=='txtNilai')
				{
                    HitungSubTot(par);
                }
                if(par.id=='txtJml' || par.id=='txtTotal')
				{
                    //HitungSatuan(par);
                }
            //}
        }
    }

    function removeRowFromTable(cRow,urutan)
	{
        var tbl = document.getElementById('tblJual');
        var jmlRow = tbl.rows.length;
		var jml = document.getElementById('txtJml_'+urutan).value;
		var nilai = document.getElementById('txtNilai_'+urutan).value;
		var jmlSel = document.getElementById('totalSeluruh').value;
		var totaldel = jml*nilai;
		//alert(jml+'-'+nilai+'-'+totaldel);
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                tds[0].innerHTML=i-2;
            }
            delRowTotal(urutan,totaldel,jmlSel);
        }
    }

    function HitungTot()
	{
        if (document.form1.txtSubTotal.length)
		{
            var cStot=0,tmp;
            for (var i=0;i<document.form1.txtSubTotal.length;i++)
			{
                //var lain2 = (document.form1.txtLain2[i].value*1)==0||(document.form1.txtLain2[i].value*1)==''?0:(document.form1.txtLain2[i].value*1);
                //alert(document.form1.txtSubTot[i].value);
                //tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)+lain2).toString();
                tmp = ((document.form1.txtJml[i].value*1)*(document.form1.txtNilai[i].value*1)).toString();
                tmp = tmp.split('.');
                if(tmp[1] != undefined)
				{
                    tmp = tmp[0]+'.'+tmp[1].substr(0,2);
                }
                else
				{
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
        else
		{
            document.form1.txtTotal.value=(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
            document.getElementById('total').innerHTML=document.form1.txtTotal.value;
        }
        if('<?php echo $edit;?>' == true)
		{
            document.getElementById('btnSimpan').disabled = false;
        }
    }

    function HitungSubTot(par)
	{
        //var tbl = document.getElementById('tblJual');
        //alert(i);
        if (document.form1.txtSubTotal.length)
		{
            //var i=par.parentNode.parentNode.rowIndex;
            var tbl = document.getElementById('tblJual');
            var jmlRow = tbl.rows.length;
            var i;
            if (jmlRow > 4)
			{
                i=par.parentNode.parentNode.rowIndex-2;
            }
			else
			{
                i=0;
            }
            //alert((document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1));
            document.form1.txtSubTotal[i-1].value=(document.form1.txtNilai[i-1].value*1);//(document.form1.txtJml[i-1].value*1)*(document.form1.txtNilai[i-1].value*1);
        }
		else
		{
            document.form1.txtSubTotal.value=(document.form1.txtNilai.value*1)//(document.form1.txtJml.value*1)*(document.form1.txtNilai.value*1);
        }
        HitungTot();
    }

    function HitungSatuan(par)
	{
        //var tbl = document.getElementById('tblJual');
        var i=par.parentNode.parentNode.rowIndex;
        //alert(document.form1.txtLain2.length);
        if (document.form1.txtLain2.length)
		{
            document.form1.txtLain2[i-3].value=(document.form1.txtJml[i-3].value*1)*(document.form1.txtTotal[i-3].value*1);
        }
		else
		{
            document.form1.txtLain2.value=(document.form1.txtJml.value*1)*(document.form1.txtTotal.value*1);
        }
        HitungTot();
    }

   /* function save()
	{
        var cdata='';
        var ctemp;
		var obatid = document.forms[0].obatid.length;
		
        if (document.forms[0].no_po.value=="")
		{
            alert('Isikan No PO Terlebih Dahulu !');
            document.forms[0].no_po.focus();
            return false;
        }
		//alert(obatid);
        if (document.forms[0].obatid.length)
		{
            for (var i=0;i<document.forms[0].obatid.length;i++)
			{
                ctemp=document.forms[0].obatid[i].value;//.split('|');
                if (document.forms[0].obatid[i].value=="")
				{
                    alert('Pilih Barang Terlebih Dahulu !');
                    document.forms[0].txtObat[i].focus();
                    return false;
                }
                cdata += ctemp+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].satuan[i].value+'|'+document.forms[0].txtNilai[i].value+'|'+document.forms[0].txtSubTotal[i].value+'|'+document.forms[0].txtTotal[i].value+'|'+document.forms[0].txtunit[i].value+'|'+document.forms[0].txtUraian[i].value;
               //alert(cdata);
                if("<?php echo $edit;?>" == true)
				{
                    cdata += '|'+document.forms[0].id[i].value;
                }
                cdata += '**';
            }
            if (cdata != '')
                cdata=cdata.substr(0,cdata.length-2);
        }
        else
		{
            if (document.forms[0].obatid.value=="")
			{
                alert('Pilih Barang Terlebih Dahulu !');
                document.forms[0].txtObat.focus();
                return false;
            }
            ctemp=document.forms[0].obatid.value;//.split('|');
            cdata=ctemp+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].satuan.value+'|'+document.forms[0].txtNilai.value+'|'+document.forms[0].txtSubTotal.value+'|'+document.forms[0].txtTotal.value+'|'+document.forms[0].txtunit.value+'|'+document.forms[0].txtUraian.value;
            if("<?php echo $edit;?>" == true)
			{
                cdata += '|'+document.forms[0].id.value;
				//alert(cdata);
            }
        }
        //ms_barang_id,vendor_id,no_po,tgl,satuan,qty_satuan,harga_satuan
        //satuan,qty_satuan,harga_satuan
        document.forms[0].fdata.value=cdata;
        //alert(document.forms[0].fdata.value);
        document.forms[0].submit();
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
    }*/
    if('<?php echo $edit;?>' == true)
	{
        HitungTot();
    }
	
	/* function set_NO_PO(act)
	{
		//alert(act);
		if(act=='add')
		{
			var tgl = $('#tgl').val(); 
			var jenis = $('#jenis_surat').val();
			var url =  "get_NO_PO.php?act=add&jenis="+jenis+"&tgl="+tgl;
			jQuery.get(url, function(data)
			{
				
				$('#no_po').val(data);
			});
			
		}
		else if(act=='edit')
		{
			var tgl = $('#tgl').val();
			var jenis = $('#jenis_surat').val(); 
			var no_po = "<?=$_REQUEST['no_po'];?>";
			var x = no_po.split("/");
			var jenis_awal = x[0];
			
			var url = "get_NO_PO.php?act=edit&jenis="+jenis+"&jenis_awal="+jenis_awal+"&no_po="+no_po+"&tgl="+tgl; //alert(url);
			
			jQuery.get(url, function(data)
			{
				//alert(data)
				$('#no_po').val(data);
			});
			
		}
	} */
/*	function set_NO_PO(gap)
	{
		var nopo = document.getElementById('no_po2').value;
		document.getElementById('no_po').value=gap+"."+nopo;
    }*/
	function set_NO_PO(act)
	{
		//alert(act);
		if(act=='add')
		{
			var tgl = jQuery('#tgl').val(); 
			var jenis = jQuery('#jenis_surat').val();
			var url =  "get_NO_PO.php?act=add&jenis="+jenis+"&tgl="+tgl;
			jQuery.get(url, function(data)
			{
				
				jQuery('#no_po').val(data);
			});
			
		}
		else if(act=='edit')
		{
			var tgl = jQuery('#tgl').val();
			var jenis = jQuery('#jenis_surat').val(); 
			var no_po = "<?=$_REQUEST['no_po'];?>";
			var x = no_po.split("/");
			var jenis_awal = x[0];
			
			var url = "get_NO_PO.php?act=edit&jenis="+jenis+"&jenis_awal="+jenis_awal+"&no_po="+no_po+"&tgl="+tgl; //alert(url);
			
			jQuery.get(url, function(data)
			{
				//alert(data)
				jQuery('#no_po').val(data);
			});
			
		}
	}
function set_barang_add(par)
{
	//alert(par);
	if(par!="")
	{
    var cdata=par.split("|");
    var tbl = document.getElementById('tblJual');
    var tds;
    var baris = tbl.rows.length;
	var xx = cdata[0]; //alert(xx)
    if ((cdata[0]*1)==0)
	{
    	if(baris==4)
		{
			//alert('wkwk')
    		/*document.forms[0].obatid_xx.value=cdata[1];
			document.forms[0].txtObat_xx.value=cdata[3];
    		document.forms[0].satuan_xx.value=cdata[4];
    		tds = tbl.rows[3].getElementsByTagName('td');*/
			document.getElementById('kode_'+xx).innerHTML = cdata[2];
			document.getElementById('obatid_'+xx).value = cdata[1];
			document.getElementById('txtObat_'+xx).value = cdata[3];
			document.getElementById('satuan_'+xx).value = cdata[4];
			//document.getElementById('txtNilai_'+xx).value = FormatNumberFloor(parseInt(cdata[5].toString()),".");
			if(cdata[5]==0){
				document.getElementById('txtNilai_'+xx).value = 0;
			} else {
				document.getElementById('txtNilai_'+xx).value = FormatNumberFloor(parseInt(cdata[5].toString()),".");
			}
			
    	}
		else
		{
			/*document.forms[0].obatid[(cdata[0])].value=cdata[1];
    		document.forms[0].txtObat[(cdata[0])].value=cdata[3];*/
			
			document.getElementById('kode_'+xx).innerHTML = cdata[2];
			document.getElementById('obatid_'+xx).value = cdata[1];
			document.getElementById('txtObat_'+xx).value = cdata[3];
			document.getElementById('satuan_'+xx).value = cdata[4];
			//document.getElementById('txtNilai_'+xx).value = FormatNumberFloor(parseInt(cdata[5].toString()),".");
			if(cdata[5]==0){
				document.getElementById('txtNilai_'+xx).value = 0;
			} else {
				document.getElementById('txtNilai_'+xx).value = FormatNumberFloor(parseInt(cdata[5].toString()),".");
			}
    		/*document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[4];
    		tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');*/
    	}
    }
	else
	{
    	document.getElementById('kode_'+xx).innerHTML = cdata[2];
		document.getElementById('obatid_'+xx).value = cdata[1];
		document.getElementById('txtObat_'+xx).value = cdata[3];
		document.getElementById('satuan_'+xx).value = cdata[4];
		if(cdata[5]==0){
			document.getElementById('txtNilai_'+xx).value = 0;
		} else {
			document.getElementById('txtNilai_'+xx).value = FormatNumberFloor(parseInt(cdata[5].toString()),".");
		}
    	//tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
    	//document.forms[0].satuan[(cdata[0]*1)-1].focus();
    
    }
	//tds[1].innerHTML=cdata[2];
    document.getElementById('divbarang').style.display='none';
    }
}

function tes()
{
	var act = $('#act').val();
	 //set_NO_PO();
}
function hitung_perkalian(urutan)
{
	var jml = document.getElementById('txtJml_'+urutan).value;
	var nilai = document.getElementById('txtNilai_'+urutan).value;
	
	var jml1 = jml.replace('.','');
	var nilai1 = nilai.split('.').join('');
	
	var total = jml1*nilai1;
	var totalAll = jQuery('#totalSeluruh').val();
	
	var totalNew = parseFloat(totalAll)+total;
	
	document.getElementById('txtTotal_'+urutan).value=FormatNumberFloor(parseInt(total.toString()),".");
	//document.getElementById('total').innerHTML = FormatNumberFloor(parseInt(totalNew.toString()),".");
	//jQuery('#totalSeluruh').val(totalNew);
	hitung_grand_total();
	
}
function delRowTotal(urutan,totaldel,jmlSel){
	var totalbaru = jmlSel-totaldel;
	
	document.getElementById('total').innerHTML = totalbaru;
	jQuery('#totalSeluruh').val(totalbaru);
}
function hitung_grand_total()
{
	var total = 0;
	$(".sub_totalx").each(function(){ 
		var st = $(this).val().split('.').join('');//alert($(this).val());
		if(st==""){st=0;}
		total += parseFloat(st);
	});
	document.getElementById('total').innerHTML = FormatNumberFloor(parseInt(total.toString()),".");
	jQuery('#totalSeluruh').val(total);
}

function ambilData(tipe,par){
	jQuery('#tblObat').load('dataBarang.php?tipe='+tipe+'&par='+par);
}
function harga(par,urutan,divId){
	//alert(divId);
	var nilai = par.split('.').join('');
	if(nilai!=''){
		document.getElementById(divId).value = FormatNumberFloor(parseInt(nilai.toString()),".");
	} else {
		document.getElementById(divId).value = '';
	}
}

function save()
	{
        var cdata='';
        var ctemp;
        if (document.getElementById('no_po').value=="")
		{
            alert('Isikan No PO Terlebih Dahulu !');
            document.getElementById('no_po').focus();
            return false;
        }
		else if(document.getElementById('judul').value=="")
		{
            alert('Isikan Judul PO Terlebih Dahulu !');
           	document.getElementById('judul').focus();
            return false;
        }
		else if(document.getElementById('veri').value=="")
		{
            alert('Isikan Verifikator Terlebih Dahulu !');
           	document.getElementById('veri').focus();
            return false;
        }
		else
		{
        //ms_barang_id,vendor_id,no_po,tgl,satuan,qty_satuan,harga_satuan
        //satuan,qty_satuan,harga_satuan
        document.forms[0].fdata.value=cdata;
        //alert(document.forms[0].fdata.value);
        document.forms[0].submit();
		}
        //array buat fdata yang dikirim dengan yang ditangkap belum singkron
    }
</script>
</html>