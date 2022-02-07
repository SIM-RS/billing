<?php
include("../koneksi/konek.php");

$keyword=$_REQUEST['keyword'];
$no=$_REQUEST['no'];
$gol=$_REQUEST['gol'];
?>
<table id="tblbag" border="0" cellpadding="1" cellspacing="0">

<?php

if($gol=='0'){
	$goldar = " AND pn.gol_darah_id <> $gol ";
}
else{
	$goldar = " AND pn.gol_darah_id = $gol ";
}

$sql="SELECT
  pn.id,
  pn.kode_bag,
  d.id             id_darah,
  d.kode,
  d.darah,
  mgd.id           id_gol_darah,
  mgd.golongan,
  r.id             id_resus,
  r.rhesus,
  d.biaya,
  d.biaya_askes
FROM $dbbank_darah.bd_penerimaan pn
  INNER JOIN $dbbank_darah.bd_ms_darah d
    ON pn.ms_darah_id = d.id
  INNER JOIN $dbbank_darah.bd_ms_gol_darah mgd
    ON pn.gol_darah_id = mgd.id
  INNER JOIN $dbbank_darah.bd_ms_rhesus r
    ON r.id = pn.rhesus_id
WHERE pn.status = 1
    AND pn.qty_stok > 0 $goldar
     AND d.kode like '%$keyword%' GROUP BY d.kode";
	
	$sql="SELECT * FROM $dbbank_darah.bd_ms_darah WHERE tipe=0 AND (kode like '%$keyword%' OR darah like '%$keyword%')";
	
	//$sql2="";
	$queri=mysql_query($sql);
	$arfvalue="";
	$i=0;
	if(mysql_num_rows($queri))
	while($data=mysql_fetch_array($queri)){
		$arfvalue=$no."|".$data['id_penerimaan']."|".$data['kode_bag']."|".$data['id']."|".$data['kode']."|".$data['darah']."|".$data['id_gol_darah']."|".$data['golongan']."|".$data['biaya']."|".$data['biaya_askes']."|".$data['id_resus']."|".$data['rhesus'];
		
		$i++;
?>
<tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>"  class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="ValNamaBag(this.lang);">
        <td class="tdisi" width="70" align="left"><?=$data['kode']?></td>
        <td class="tdisi" width="300" align="left"><?=$data['darah']?></td>
        <td style="display:none" class="tdisi" width="50" align="center"><?=$data['golongan']?></td>
        <td style="display:none" class="tdisi" width="100" align="center"><?=$data['rhesus']?></td>
        <td class="tdisi" width="100" align="right"><?php echo number_format($data['biaya'],0,",",".")?></td>
        <td style="display:none" class="tdisi" width="100" align="right"><?php echo 'askes='.number_format($data['biaya_askes'],0,",",".")?></td>
      </tr>
   <?php
	}
	else
		echo " Tidak ada data ";
   ?>
</table>