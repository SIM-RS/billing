<?php 
include("../koneksi/konek.php");
$pasienId = $_REQUEST['pasienId'];
$kelasId = $_REQUEST['kelasId'];
$unitId = $_REQUEST['unitId'];
$jenisLay = $_REQUEST['jenisLay'];
$pelayananId = $_REQUEST['pelayananId'];
$inap = $_REQUEST['inap'];
$allKelas = $_REQUEST['allKelas'];
$findAll = $_REQUEST['findAll'];
?>    
<table id="tblTindakan" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="100" class="tblheader"> Tindakan </td>
		<td width="80" class="tblheader"> Kelas </td>
		<td width="80" class="tblheader"> Klasifikasi </td>
		<td width="80" class="tblheader"> Kelompok </td>
		<td width="60" class="tblheader"> Biaya </td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	$tambahan="";
	$sql="SELECT * FROM b_ms_unit WHERE id='".$unitId."'";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$penunjang=$rw['penunjang'];
	
	if($findAll != 'true'){
		$filter = "AND (mt.nama LIKE '%$aKeyword%' OR mt.kode LIKE '%$aKeyword%')";	
	}
	
	if ($penunjang==1){
		$getParentUnitAsal = "select u.parent_id,kategori from b_pelayanan p
		inner join b_ms_unit u on p.unit_id_asal=u.id
		where p.id='$pelayananId'";
		//echo $getParentUnitAsal."<br>";
		$rsGetParentUnitAsal = mysql_query($getParentUnitAsal);
		$rwGetParentUnitAsal = mysql_fetch_array($rsGetParentUnitAsal);
		if ($rwGetParentUnitAsal['parent_id']==50){
			$tambahan=" AND tk.ms_kelas_id='9'";
		}elseif ($rwGetParentUnitAsal['parent_id']==44){
			$tambahan=" AND tk.ms_kelas_id='$kelasId'";
		}elseif ($rwGetParentUnitAsal['kategori']==1){
			$tambahan=" AND tk.ms_kelas_id='$kelasId'";
		}elseif ($unitId==47 || $unitId==63){
			$tambahan=" AND tk.ms_kelas_id='$kelasId'";
		}
		elseif ($rw['parent_id']==57 && $kelasId>4 && $kelasId<10 ){
			$tambahan=" AND tk.ms_kelas_id='9'";
		}
		else{
			$tambahan=" AND tk.ms_kelas_id='1'";
		}
	}elseif ($rw['parent_id']<>94 && $unitId<>48 && $unitId<>112){	//Selain IPIT,ICU IGD, ROI IGD
		$tambahan=" AND tk.ms_kelas_id='$kelasId'";
	}
	//echo $allKelas."  - ".$tambahan;
	if ($allKelas=="1") $tambahan="";
	
	$sql="select * from (select * from (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama as kelas,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind
FROM b_ms_tindakan mt
INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id
INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
WHERE mt.aktif = 1 AND tu.ms_unit_id='".$unitId."' ".$tambahan." ".$filter." order by mt.nama) as t1
) as gab
union
SELECT mt.id, mt.unit_id, mt.kode, mt.nama, '$kelasId' ms_kelas_id, '0' tarip, '0' tarip_askes, mt.id ms_tindakan_id, tk.id idtk, (SELECT nama 
FROM
  b_ms_kelas 
WHERE id = '1') kelas ,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind
FROM `b_ms_tindakan` mt
INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
WHERE mt.`ext_tind`=1 ".$filter."


";
	//echo $sql;
	$rs=mysql_query($sql);
	$jml=mysql_num_rows($rs);
	//echo $jml."<br>";
	if ($jml==0 && $tambahan!=""){
		$sql="select * from (select * from (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama as kelas,kl.nama AS kelompok,kla.nama AS klasifikasi
	FROM b_ms_tindakan mt
	INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
	INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
	INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
	WHERE mt.aktif = 1 AND tu.ms_unit_id='".$unitId."' ".$filter." order by mt.nama) as t1
	) as gab";
	//joker
		/*$sql="SELECT * FROM (SELECT * FROM (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, 
tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama AS kelas,kl.nama AS kelompok 
FROM b_ms_tindakan mt INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id 
INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id 
INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id 
INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id 
WHERE mt.aktif = 1 AND tu.ms_unit_id='".$unitId."' AND (mt.nama LIKE '%$aKeyword%' OR mt.kode LIKE '%$aKeyword%')
UNION
SELECT mrc.CODE id,0 unit_id,mrc.CODE kode,mrc.STR nama,0 ms_kelas_id,0 tarip,
0 tarip_askes,0 ms_tindakan_id,mrc.CODE idtk,'' kelas,'ICD9CM' kelompok
FROM (SELECT * FROM b_ms_tindakan_icd9_unit WHERE ms_unit_id='".$unitId."') ticd9 
INNER JOIN mrconso mrc ON ticd9.ms_icd9=mrc.AUI WHERE (mrc.CODE LIKE '%$aKeyword%' OR mrc.STR LIKE '%$aKeyword%') 
AND mrc.TTY = 'PT') AS t1 ORDER BY nama) AS gab";*/
		//echo $sql;
		$rs=mysql_query($sql);
	}/*else{
		//joker
		$sql="SELECT * FROM (SELECT * FROM (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, 
tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama AS kelas,kl.nama AS kelompok 
FROM b_ms_tindakan mt INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id 
INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id 
INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id 
INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id 
WHERE mt.aktif = 1 AND tu.ms_unit_id='".$unitId."' ".$tambahan." AND (mt.nama LIKE '%$aKeyword%' OR mt.kode LIKE '%$aKeyword%')
UNION
SELECT mrc.CODE id,0 unit_id,mrc.CODE kode,mrc.STR nama,0 ms_kelas_id,0 tarip,
0 tarip_askes,0 ms_tindakan_id,mrc.CODE idtk,'' kelas,'ICD9CM' kelompok
FROM (SELECT * FROM b_ms_tindakan_icd9_unit WHERE ms_unit_id='".$unitId."') ticd9 
INNER JOIN mrconso mrc ON ticd9.ms_icd9=mrc.AUI WHERE (mrc.CODE LIKE '%$aKeyword%' OR mrc.STR LIKE '%$aKeyword%') 
AND mrc.TTY = 'PT') AS t1 ORDER BY nama) AS gab";
		//echo $sql;
		$rs=mysql_query($sql);
	}
*/	//$arfvalue="";
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['idtk']."*|*".$rows['nama']."*|*".$rows["kode"]."*|*".$rows["tarip"]."*|*".$rows["id"]."*|*".$rows['kelas']."*|*".$rows['tarip_askes']."*|*".$rows['ext_tind'];
?>
	<tr id="lstTind<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetTindakan(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td>
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
		<td class="tdisi" width="80" align="center">&nbsp;<?php echo $rows['kelas']; ?></td>
		<td class="tdisi" width="100" align="center">&nbsp;<?php echo $rows['klasifikasi']; ?></td>
		<td class="tdisi" width="100" align="center">&nbsp;<?php echo $rows['kelompok']; ?></td>
		<td class="tdisi" width="60" align="right">&nbsp;<?php echo number_format($rows['tarip'],0,',','.'); ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>
