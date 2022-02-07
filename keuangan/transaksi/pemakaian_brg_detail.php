<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];

//include("../koneksi/konek.php");
function rupiah($angka)
{
$rupiah="";
$rp=strlen($angka);
while ($rp>3)
{
$rupiah = ".". substr($angka,-3). $rupiah;
$s=strlen($angka) - 3;
$angka=substr($angka,0,$s);
$rp=strlen($angka);
}
$rupiah = "" . $angka . $rupiah . "";
return $rupiah;
}

if(isset($_GET['id']) && $_GET['id'] != '') {
    $terima_po = explode('|', $_GET['id']);
    //echo $_GET['id'];
}
if($_GET['id'] != '' && isset($_GET['id']) && $_GET['act'] == 'detail') {
    $sql = "Select msk_id,satuan_unit,harga_unit,sisa from $dbaset.as_masuk
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
    $qry='SELECT tgl_transaksi,kode_transaksi FROM $dbaset.as_keluar, $dbaset.as_lokasi
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
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pemakaian Bahan :.</title>
	 </head>
    <?php
    //include("../koneksi/konek.php");
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <style type="text/css">
            .tbl
            { font-family:Arial, Helvetica, sans-serif;
              font-size:12px;}
            </style>
            <script type="text/JavaScript">
                var arrRange = depRange = [];
            </script>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <div align="center"><?php //include("../header.php");?></div>
			 <div align="center">
            <table width="820" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td valign="top" align="center">
					<div class="popup" id="divPop" style="width:820px; display:none">
                     <table border="0" width="820" cellpadding="0" cellspacing="2" bgcolor="#FFFBF0">
                <tr>
                    <td colspan="10" height="20">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" style="font-size:16px;" colspan="15">PEMAKAIAN BAHAN DETAIL</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <form id="form1" name="form1" action="" method="post" onSubmit="save()">
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="data_submit" name="data_submit" value="" />
                    <tr>
                        <td width="3%">&nbsp;</td>
                        <td width="16%">No Pengeluaran</td>
                        <td width="24%">&nbsp;:&nbsp;
                      <input id="txtNoPen"  name="txtNoPen" value='<?php echo $noterima; ?>' <?php if($_GET['act'] == 'edit') echo 'readonly'?> class="txtcenter" size="20" /></td>
                        <td width="2%">&nbsp;</td>
                        <td width="1%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="12%">&nbsp;Peruntukan</td>
                        <td width="33%">:&nbsp;&nbsp;
                             <input type="text" size="35" id="txtUntuk" name="txtUntuk" class="txtinput" value="<?php echo (($_GET['act'] == 'detail')?$peruntukan:$po_rekanan[2]);?>" <?php if($_GET['act'] == 'detail') echo 'readonly'?>/>
                       
                      </td>  <?php
                            
                            
                            /*echo $cmbNoPo;
                            $val="";
                            $nopo="";
                            $disabled="";
                             if(strlen($_GET['id'])>0)$nopo=explode("|",$_GET['id']);
                             if(strlen($_GET['no_po'])>0)$nopo=explode("|",$_GET['no_po']);
                             if($nopo!="")$val= $nopo[0]." / ".$nopo[1];
                             if($act!="add")$disabled="disabled";                             
                            
                            
                            <input type="text" value="<?php echo $val;?>" <?php echo $disabled; ?> size="35" name="txtNoPo" id="txtNoPo"  class="txtinput" onKeyUp="suggest(event,this);" autocomplete="off"/></td>
                        */?><td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="3%">&nbsp;</td>
                        <td width="16%">Tgl Pengeluaran</td>
                        <td width="24%">&nbsp;:&nbsp;
                            <input id="txtTgl" name="txtTgl" value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" readonly size="20" class="txtcenter"/>&nbsp;
                      </td>
                        <td width="2%">&nbsp;</td>
                        <td width="1%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="12%">&nbsp;</td>
                        <td width="33%">&nbsp;&nbsp;                        </td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama Penerima</td>
                        <td>&nbsp;:&nbsp;
                            <input type="text" id="txtPenerima" name="txtPenerima" class="txtinput" value="<?php echo (($_GET['act'] == 'detail')?$petugas_rtp:$po_rekanan[4]);?>" <?php if($_GET['act'] == 'detail') echo 'readonly'?>/></td>
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
                            <input type="text" id="txtPetGud" name="txtPetGud" class="txtinput" value="<?php echo (($_GET['act'] == 'detail')?$petugas_gudang:$po_rekanan[3]);?>" <?php if($_GET['act'] == 'detail') echo 'readonly'?>/>
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
						<td colspan="10">&nbsp;</td>
					</tr>
                    <tr>
						<td>&nbsp;</td>
                        <td colspan="9">
						<div id="gridbox1" style="width:800px; height:200px; display:block; background-color:white; overflow:hidden;"></div>
                        <div id="halaman" style="width:800px;"></div></td>
						
                    </tr>
                   <tr>
                        <td>&nbsp;</td>

                        <td colspan="4" align="right">&nbsp;
                            </td>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='pemakaian_brg.php'" class="popup_closebox" style="cursor: pointer">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;
                                Tutup
                                &nbsp;&nbsp;&nbsp;&nbsp
			    </button>
			</td>
                        <td>&nbsp;</td>
                    </tr>
                </form>
                <tr>
                    <td colspan="10">
                        <?php
                        //include '../footer.php';
                        ?>                    </td>
                </tr>
            </table>
			</div>
            
        <script language="javascript">
		
           
		var po1=new DSGridObject("gridbox1");
		po1.setHeader(".: DAFTAR PEMAKAIAN BAHAN :.");
        po1.setColHeader("No,Kode Barang,Nama Barang,Satuan,Harga Satuan,Jumlah Bahan,Total");
        po1.setIDColHeader(",kodebarang,namabarang,satuan,harga_satuan,jumlah_keluar,");
        po1.setColWidth("50,100,200,100,100,100,");
        po1.setCellAlign("center,center,left,center,right,center,right");
        po1.setCellHeight(20);
        po1.setImgPath("../icon");
        po1.setIDPaging("halaman");
        //po1.attachEvent("onRowDblClick","ambilData");
       // po1.baseURL("pemakaian_brg_detil_util.php?no_gd="+document.getElementById('txtNoPen').value+"&no_gd="+document.getElementById('txtTgl').value);
       // po1.Init();
		//alert("pemakaian_brg_detil_util.php?no_gd="+document.getElementById('txtNoPen').value+"&no_gd="+document.getElementById('txtTgl').value);
		//alert("pemakaian_brg_detil_util.php");
			</script>
            		 
									                       