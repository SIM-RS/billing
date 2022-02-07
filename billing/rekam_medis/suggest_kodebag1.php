<?
include("../sesi.php");
?>
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
FROM bank_darah.bd_penerimaan pn
  INNER JOIN bank_darah.bd_ms_darah d
    ON pn.ms_darah_id = d.id
  INNER JOIN bank_darah.bd_ms_gol_darah mgd
    ON pn.gol_darah_id = mgd.id
  INNER JOIN bank_darah.bd_ms_rhesus r
    ON r.id = pn.rhesus_id
WHERE pn.status = 1
    AND pn.qty_stok > 0 $goldar
     AND d.kode like '%$keyword%' GROUP BY d.kode";
	
$sql2="";
	$queri=mysql_query($sql);
	$arfvalue="";
	$i=0;
	if(mysql_num_rows($queri))
	while($data=mysql_fetch_array($queri)){
		
		$arfvalue=$no."|".$data['id']."|".$data['kode_bag']."|".$data['id_darah']."|".$data['kode']."|".$data['darah']."|".$data['id_gol_darah']."|".$data['golongan']."|".$data['biaya']."|".$data['biaya_askes']."|".$data['id_resus']."|".$data['rhesus']; 
		$i++;
?>
<tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>"  class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="ValNamaBag(this.lang);">
        <td class="tdisi" width="70" align="center"><?=$data['kode']?></td>
        <td class="tdisi" width="150" align="left"><?=$data['darah']?></td>
        <td class="tdisi" width="50" align="center"><?=$data['golongan']?></td>
        <td class="tdisi" width="100" align="center"><?=$data['rhesus']?></td>
        <td class="tdisi" width="100" align="right"><?php echo 'biaya='.number_format($data['biaya'],0,",",".")?></td>
        <td class="tdisi" width="100" align="right"><?php echo 'askes='.number_format($data['biaya_askes'],0,",",".")?></td>
      </tr>
   <?php
	}
	else
		echo " Tidak ada data ";
   ?>
</table>