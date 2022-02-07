<?php 
include("../koneksi/konek.php"); 
$jenis_supplier = $_REQUEST['jenis_supplier'];
$supplier = $_REQUEST['supplier'];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];
$type = $_REQUEST['type'];
$jns = $_REQUEST['jenis_layanan'];
$tglskrg=explode("-",gmdate('d-m-Y',mktime(date('H')+7)));
$tgl1="01-".$tglskrg[1]."-".$tglskrg[2];
$tgl2=$tglskrg[0]."-".$tglskrg[1]."-".$tglskrg[2];
$txtTglAwal=$_REQUEST['txtTglAwal'];
$txtTglAkhir=$_REQUEST['txtTglAkhir'];
$filterKelompokSPK=$_REQUEST['filterKelompokSPK'];
if ($txtTglAwal==""){
	$txtTglAwal=$tgl1;
	$txtTglAkhir=$tgl2;
	$filterKelompokSPK="1";
}
$th[1] = $bln;
$th[2] = $thn;
if($th[1] == ''){
    $th=explode("-",gmdate('d-m-Y',mktime(date('H')+7)));
}

$filter=$_REQUEST['filter'];
$sorting=$_REQUEST['sorting'];
$defaultsort='tgl asc';
if ($filter!=""){
  	$filter=explode("|",$filter);
  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($_REQUEST['filter']=='undefined'){
	$filter="";
}
if ($sorting=="" || $sorting=='undefined'){
	$sorting=$defaultsort;
}

switch($type) {
    case '11'://supplier
		$clspan=4;
		$hdrTgl="Tgl Terima";
		$fclickTrSPK="fsetFaktur(this.lang);";
		if ($filterKelompokSPK=="2"){
			$clspan=6;
			$hdrTgl="Tgl Terima";
			$fclickTrSPK="";
		}
        ?>
<form id="form1">
    <input id="act" name="act" value="save" type="hidden">
    <table border="0" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" id="tbl">
        <tr>
            <td colspan="<?php echo $clspan; ?>">
                <fieldset style="width: 600px;background-color: silver">
                    <!--legend>
                        Bulan<span style="padding-left: 55px; color: silver;">&ensp;</span>Tahun                    </legend>
                    <select id="bln_in" name="bln_in" onchange="filter('in')" class="txtinputreg">
                        <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                        <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                        <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                        <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                        <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                        <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                        <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                        <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                        <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                        <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                        <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                        <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                    </select>&nbsp;&nbsp;
                    <select id="thn_in" name="thn_in" onchange="filter('in')" class="txtinputreg">
                        <?php
                        for ($i=($th[2]-5);$i<($th[2]+5);$i++) {
                            ?>
                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                            <?php
                        }
                        ?>
                    </select-->
                    <input id="txtTglAwal" name="txtTglAwal" readonly size="11" class="txtcenter" type="text" value="<?php echo $txtTglAwal; ?>" />&nbsp;
                                    <input type="button" name="btnTglAwal" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange,filterSPK);"/>
                    &nbsp;&nbsp;s/d&nbsp;&nbsp;
                    <input id="txtTglAkhir" name="txtTglAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $txtTglAkhir; ?>" />&nbsp;
                                    <input type="button" name="btnTglAkhir" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange,filterSPK);"/>&nbsp;&nbsp;&nbsp;&nbsp;Filter&nbsp;
                <select id="filterKelompokSPK" class="txtinput" onchange="filterSPK();">
                	<option value="1"<?php if ($filterKelompokSPK=="1") echo ' selected="selected"';?>>Group By No_SPK&nbsp;</option>
                    <option value="2"<?php if ($filterKelompokSPK=="2") echo ' selected="selected"';?>>Detail By No_Terima&nbsp;</option>
                </select>
                </fieldset>
			</td>
        </tr>
        <tr class="headtable" style="text-align:center; font-weight:bold;" height="30">
            <td class="tblheaderkiri" width="40">No</td>
            <td class="tblheader" width="90"><?php echo $hdrTgl; ?></td>
            <?php 
			if ($filterKelompokSPK=="2"){
			?>
            <td class="tblheader" width="200">No Terima</td>
            <?php 
			}
			?>
            <td id="no_spk" class="tblheader" width="200" onClick="ifPop.CallFr(this);">No SPK</td>
            <td id="tagihan" class="tblheader" width="150" onClick="ifPop.CallFr(this);">Tagihan</td>
            <?php 
			if ($filterKelompokSPK=="2"){
			?>
            <td class="tblheader" width="20"><input type="button" value="  OK  " onclick="fchkTerimaPO_Pilih()" /></td>
            <?php 
			}
			?>
        </tr>
        <?php
		if($jenis_supplier=='1'){
			if ($filterKelompokSPK=="1"){
				$sql="select * from (SELECT t1.PBF_ID,t1.TANGGAL,t1.tgl, t1.noterima, 
t1.nobukti, t1.NO_PO no_po, t1.BATCH no_spk, t1.pbf_nama, SUM(t1.dpp) AS dpp, 
SUM(t1.ppn) AS ppn, SUM(IF(t1.dpp_ppn>10000000,t1.dpp,t1.dpp_ppn)) AS tagihan 
FROM (SELECT a_p.*,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,
a_p.HARGA_KEMASAN*QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA 
FROM (SELECT a.*,b.NO_PO FROM ".$dbapotek.".a_penerimaan a INNER JOIN ".$dbapotek.".a_po b ON a.FK_MINTA_ID=b.ID 
WHERE a.PBF_ID='$supplier' AND a.TIPE_TRANS=0 AND a.BATCH!='' AND a.BATCH!='-' AND a.BATCH IS NOT NULL AND a.BAYAR=1 AND a.TANGGAL BETWEEN '".tglSQL($txtTglAwal)."' AND '".tglSQL($txtTglAkhir)."') a_p 
INNER JOIN ".$dbapotek.".a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
INNER JOIN ".$dbapotek.".a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID) AS t1 GROUP BY t1.BATCH) as tbl ".$filter." order by ".$sorting;
			}else{
				$sql="select * from (SELECT t1.PBF_ID,t1.TANGGAL,t1.tgl, t1.noterima, 
t1.nobukti, t1.NO_PO no_po, t1.BATCH no_spk, t1.pbf_nama, SUM(t1.dpp) AS dpp, 
SUM(t1.ppn) AS ppn, SUM(IF(t1.dpp_ppn>10000000,t1.dpp,t1.dpp_ppn)) AS tagihan 
FROM (SELECT a_p.*,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,
a_p.HARGA_KEMASAN*QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA 
FROM (SELECT a.*,b.NO_PO FROM ".$dbapotek.".a_penerimaan a INNER JOIN ".$dbapotek.".a_po b ON a.FK_MINTA_ID=b.ID 
WHERE a.PBF_ID='$supplier' AND a.TIPE_TRANS=0 AND a.BATCH!='' AND a.BATCH!='-' AND a.BATCH IS NOT NULL AND a.BAYAR=1 AND a.TANGGAL BETWEEN '".tglSQL($txtTglAwal)."' AND '".tglSQL($txtTglAkhir)."') a_p 
INNER JOIN ".$dbapotek.".a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
INNER JOIN ".$dbapotek.".a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID) AS t1 GROUP BY t1.NOTERIMA,t1.BATCH) as tbl ".$filter." order by ".$sorting;
			}
		}else{
			if ($filterKelompokSPK=="1"){
		    	$sql="select * from (SELECT m.po_id,m.no_gudang noterima,p.no_po,p.no_spk,DATE_FORMAT(m.tgl_terima,'%d-%m-%Y') as tgl,sum(m.jml_msk*harga_unit) as tagihan
			FROM ".$dbaset.".as_masuk m
			INNER JOIN ".$dbaset.".as_po p ON p.id=m.po_id			
			WHERE p.vendor_id='$supplier' AND p.no_spk!='' AND p.no_spk!='-' AND p.no_spk IS NOT NULL
			AND m.tgl_terima BETWEEN '".tglSQL($txtTglAwal)."' AND '".tglSQL($txtTglAkhir)."' and m.bayar = 0 and m.posted=1
			group by p.no_spk
			order by m.tgl_terima) as tbl ".$filter." order by ".$sorting;
			}else{
		    	$sql="select * from (SELECT m.po_id,m.no_gudang noterima,p.no_po,p.no_spk,DATE_FORMAT(m.tgl_terima,'%d-%m-%Y') as tgl,sum(m.jml_msk*harga_unit) as tagihan
			FROM ".$dbaset.".as_masuk m
			INNER JOIN ".$dbaset.".as_po p ON p.id=m.po_id			
			WHERE p.vendor_id='$supplier' AND p.no_spk!='' AND p.no_spk!='-' AND p.no_spk IS NOT NULL
			AND m.tgl_terima BETWEEN '".tglSQL($txtTglAwal)."' AND '".tglSQL($txtTglAkhir)."' and m.bayar = 0 and m.posted=1
			group by m.no_gudang,p.no_spk
			order by m.tgl_terima) as tbl ".$filter." order by ".$sorting;
			}
		}
		//echo $sql."<br>";
                $rs = mysql_query($sql);
		//echo mysql_error();
                $no = 1;
                $height = 0;
                while($rw = mysql_fetch_array($rs)) {
                    $arfvalue = $rw['no_po'].'|'.number_format($rw['tagihan'],0,",",".").'|'.$bln.'|'.$thn.'|'.$rw['no_spk'].'|'.$rw['noterima'];
                    ?>
        <tr id="lstDiag<?php echo $no; ?>" lang="<?php echo $arfvalue; ?>" height="20" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?php echo $fclickTrSPK; ?>">
            <td class="tdisikiri" style="text-align:center"><?php echo $no;?></td>
            <td class="tdisi" style="text-align:center"><?php echo $rw['tgl']?></td>
            <?php 
			if ($filterKelompokSPK=="2"){
			?>
            <td class="tdisi" style="text-align:center">&nbsp;<?php echo $rw['noterima']?></td>            
            <?php 
			}
			?>
            <td class="tdisi" style="text-align:center">&nbsp;<?php echo $rw['no_spk']?></td>
            <td id="tdNilaiTerima<?php echo $no;?>" lang="<?php echo $rw['tagihan']; ?>" class="tdisi" style="text-align:right"><?php echo number_format($rw['tagihan'],2,",",".")?>&nbsp;</td>
            <?php 
			if ($filterKelompokSPK=="2"){
			?>
            <td align="center" class="tdisi"><input type="checkbox" id="chkTerimaPO" name="chkTerimaPO" onclick="fchkTerimaPO_Click()" /></td>
            <?php 
			}
			?>
        </tr>
            <?php
            $no++;
			}
			?>
            <?php 
			if ($filterKelompokSPK=="2"){
			?>
        <tr height="30" class="itemtableReq">
            <td colspan="4" class="tdisikiri" style="text-align:right">Subtotal&nbsp;</td>
            <td id="tdSubTot" class="tdisi" style="text-align:right">0,00&nbsp;</td>
            <td class="tdisi" align="center">&nbsp;</td>
        </tr>
            <?php 
			}
			?>
    </table>
</form>
        <?php
        break;
    case '12'://cleaning service
        break;
    case '13'://jasa pengelolaan taman
    /*<form id='form1'>
				<table width="450" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
					<tr>
						<td width="225" style="padding-left:10px;font-weight:bold">Nilai</td>
						<td>:</td>
						<td><input type="text" id="nilaiJPT" name="nilaiJPT" style="text-align:right; background-color:#CCCCCC"/></td>
					</tr>
				</table>
			</form>*/
        break;
    case '8'://gaji pns
    case '9'://pdam
    case '10'://listrik
    case '14'://perjalanan dinas
    case '15'://listrik
    case '17'://jasa medis
    case '18'://gaji non-pns
        /*
<form id='form1'>
    <table id="table_inside" width="700" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
        <?php
        $sql = "select id, nama from $dbbilling.b_ms_unit where aktif=1 and parent_id='$jns' order by nama";
                $rs = mysql_query($sql);
                while($row = mysql_fetch_array($rs)) {
                    ?>
        <tr>
            <td height='20' width="205" style="padding-left:155px;font-weight:bold">
            <?php
            $height += 20;
                            echo $row['nama'];
                            ?>
            </td>
            <td>:</td>
            <td>
                <input type="text" id="nilaiJM" name="nilaiJM" class="txtright"/>
            </td>
        </tr>
            
        }
                ?>
    </table>
</form>
        <?php
        echo chr(3).$height;*/
        break;
}
mysql_close($konek);
?>