<?php 
include("../koneksi/konek.php");
$tglskrg=explode("-",gmdate('d-m-Y',mktime(date('H')+7)));
$tgl1="01-".$tglskrg[1]."-".$tglskrg[2];
$tgl2=$tglskrg[0]."-".$tglskrg[1]."-".$tglskrg[2];
$txtTglAwal=$_REQUEST['txtTglAwal'];
$txtTglAkhir=$_REQUEST['txtTglAkhir'];
$kso=$_REQUEST['kso'];

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

$sql="SELECT * FROM k_klaim WHERE kso_id=$kso AND tstatus=0";
$rs=mysql_query($sql);
?>
<form id="form1">
    <input id="act" name="act" value="save" type="hidden">
    <table border="0" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" id="tbl">
        <tr class="headtable" style="text-align:center; font-weight:bold;" height="30">
            <td class="tblheaderkiri" width="40">No</td>
            <td class="tblheader" width="90">Tgl Pengajuan</td>
            <td class="tblheader" width="200">No Pengajuan</td>
            <td id="tagihan" class="tblheader" width="150" onClick="ifPop.CallFr(this);">Nilai Pengajuan</td>
            <!--td class="tblheader" width="20"><input type="button" value="  OK  " onclick="fchkTerimaPO_Pilih()" /></td-->
        </tr>
<?php 
$no=0;
while ($rw=mysql_fetch_array($rs)){
	$no++;
	$arfvalue=$rw['id']."|".$rw['no_bukti']."|".$rw['nilai'];
?>
        <tr id="lstDiag<?php echo $no; ?>" lang="<?php echo $arfvalue; ?>" height="20" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fPilihNoPengajuanKlik(this);">
            <td class="tdisikiri" style="text-align:center"><?php echo $no;?></td>
            <td class="tdisi" style="text-align:center"><?php echo tglSQL($rw['tgl']);?></td>
            <td class="tdisi" style="text-align:center">&nbsp;<?php echo $rw['no_bukti']?></td>
            <td id="tdNilaiTerima<?php echo $no;?>" lang="<?php echo $rw['nilai']; ?>" class="tdisi" style="text-align:right"><?php echo number_format($rw['nilai'],2,",",".")?>&nbsp;</td>
            <!--td align="center" class="tdisi"><input type="checkbox" id="chkTerimaPO" name="chkTerimaPO" onclick="fchkTerimaPO_Click()" /></td-->
        </tr>
<?php 
}
?>
        <!--tr height="30" class="itemtableReq">
            <td colspan="4" class="tdisikiri" style="text-align:right">Subtotal&nbsp;</td>
            <td id="tdSubTot" class="tdisi" style="text-align:right">0,00&nbsp;</td>
            <td class="tdisi" align="center">&nbsp;</td>
        </tr-->
    </table>
</form>
<?php
mysql_close($konek);
?>