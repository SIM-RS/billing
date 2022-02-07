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
$ksoId = $_REQUEST['ksoId'];
?>    
<table id="tblTindakan" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="100" class="tblheaderkiri"> Penjamin </td>
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
    
    if ($findAll != 'true') {
        $filter = "AND (mt.nama LIKE '%$aKeyword%' OR mt.kode LIKE '%$aKeyword%')";
    }
    
    if ($penunjang==1) {
        $getParentUnitAsal = "select u.parent_id,kategori from b_pelayanan p
		inner join b_ms_unit u on p.unit_id_asal=u.id
		where p.id='$pelayananId'";
        //echo $getParentUnitAsal."<br>";
        $rsGetParentUnitAsal = mysql_query($getParentUnitAsal);
        $rwGetParentUnitAsal = mysql_fetch_array($rsGetParentUnitAsal);
        if ($rwGetParentUnitAsal['parent_id']==50) {
            $tambahan=" AND tk.ms_kelas_id='9'";
        } elseif ($rwGetParentUnitAsal['parent_id']==44) {
            $tambahan=" AND tk.ms_kelas_id='$kelasId'";
        } elseif ($rwGetParentUnitAsal['kategori']==1) {
            $tambahan=" AND tk.ms_kelas_id='$kelasId'";
        } elseif ($unitId==47 || $unitId==63) {
            $tambahan=" AND tk.ms_kelas_id='$kelasId'";
        } elseif ($rw['parent_id']==57 && $kelasId>4 && $kelasId<10) {
            $tambahan=" AND tk.ms_kelas_id='9'";
        } else {
            $tambahan=" AND tk.ms_kelas_id='1'";
        }
    } elseif ($rw['parent_id']<>94 && $unitId<>48 && $unitId<>112) {	//Selain IPIT,ICU IGD, ROI IGD
        $tambahan=" AND tk.ms_kelas_id='$kelasId'";
    }
    //echo $allKelas."  - ".$tambahan;
    if ($allKelas=="1") {
        $tambahan="";
    }
    
// 	$sql="select * from (select * from (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama as kelas,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind,mt.ak_ms_unit_id
// FROM b_ms_tindakan mt
// INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
// INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id
// INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
// INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
// INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
// WHERE mt.aktif = 1 AND tk.kso_id = '$ksoId' AND tu.ms_unit_id='".$unitId."' ".$tambahan." ".$filter." order by mt.nama) as t1
// ) as gab
// union
// SELECT mt.id, mt.unit_id, mt.kode, mt.nama, '$kelasId' ms_kelas_id, '0' tarip, '0' tarip_askes, mt.id ms_tindakan_id, tk.id idtk, (SELECT nama
// FROM
//   b_ms_kelas
// WHERE id = '1') kelas ,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind,mt.ak_ms_unit_id
// FROM `b_ms_tindakan` mt
// INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
// INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
// INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
// WHERE mt.`ext_tind`=1 ".$filter."
// ";

if ($ksoId == 63 && $unitId == 232) {
    /**
     * @author ismul
     * jika pasien dari klinik krakatau dan dia pelayanan yang diberikan adalah lab pcr
     *
     * maka akan mencari biaya tindakan berdasarkan id kso yang terdapat pada klinik
     *
     * bukan berdasarkan id yang terdapat pada rs.di rs klinik krakatau di jadikan kso
     * jika pasien yang berasal dari klinik melakukan tindakan pcr
     *
     */

    /**
     * Get id pasien kliniknya
     */
    $sqlGetIdPasienKlinik = "SELECT id_pasien_klinik FROM b_pasien_klinik_pcr WHERE id_pasien_rs = {$pasienId} ORDER BY id DESC LIMIT 1";
    $query = mysql_query($sqlGetIdPasienKlinik);
    $fetch = mysql_fetch_assoc($query);

    /**
     * Lalu cari kso pasien yang terdapat pada klinik berdasarkan id
     */

    $sqlGetKsoIdPasienKlinik = "SELECT kso_id FROM b_ms_kso_pasien WHERE pasien_id = {$fetch['id_pasien_klinik']}";
    $query = mysql_query($sqlGetKsoIdPasienKlinik);
    $ksoIdPasienKlinik = mysql_fetch_assoc($query);

    $ksoId = $ksoIdPasienKlinik['kso_id'];
}
    /**
     * @author Melli
     * Ganti Query Dimana Query Tidak menampilkan tindakan yang berkaitan, selain dari KSO
     */
    $sql="SELECT * FROM (SELECT * from (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama as kelas,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind,mt.ak_ms_unit_id, p.nama as penjamin, tk.manual AS manu
	FROM b_ms_tindakan mt
	INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
	INNER JOIN b_ms_kso p ON tk.kso_id = p.id
	INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
	INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
	WHERE mt.aktif = 1 AND tk.kso_id = '{$ksoId}' AND tu.ms_unit_id='".$unitId."' ".$tambahan." ".$filter." order by mt.nama) as t1
	) as gab";
    $rs=mysql_query($sql);
    $jml=mysql_num_rows($rs);

    if ($jml == 0 && $tambahan != "") {
        //JIKA KSO ID ATAU PENJAMIN BELUM DI SETUP, MAKA DEFAULT TARIF AMBIL DI TARIF UMUM
        $sql="SELECT * from (SELECT * from (SELECT mt.id, mt.unit_id, mt.kode, mt.nama, tk.ms_kelas_id, tk.tarip, tk.tarip_askes, tk.ms_tindakan_id, tk.id AS idtk,k.nama as kelas,kl.nama AS kelompok,kla.nama AS klasifikasi,mt.ext_tind,mt.ak_ms_unit_id, p.nama as penjamin, tk.manual AS manu
			FROM b_ms_tindakan mt
			INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
			INNER JOIN b_ms_kso p ON tk.kso_id = p.id
			INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id=tk.id
			INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
			INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id=kl.id
			INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id
			WHERE mt.aktif = 1 AND (tk.kso_id = '1' OR tk.kso_id = '{$ksoId}') AND tu.ms_unit_id= '".$unitId."' ".$filter." order by mt.nama) as t1
			) as gab";
        $rs=mysql_query($sql);
    }

    $i = 0;
    
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $arfvalue=$rows['idtk']."*|*".$rows['nama']."*|*".$rows["kode"]."*|*".$rows["tarip"]."*|*".$rows["id"]."*|*".$rows['kelas']."*|*".$rows['tarip_askes']."*|*".$rows['ext_tind']."*|*".$rows['ak_ms_unit_id']."*|*".$rows['manu']; ?>
	<tr id="lstTind<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetTindakan(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td>
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['penjamin']; ?></td>
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
		<td class="tdisi" width="80" align="center">&nbsp;<?php echo $rows['kelas']; ?></td>
		<td class="tdisi" width="100" align="center">&nbsp;<?php echo $rows['klasifikasi']; ?></td>
		<td class="tdisi" width="100" align="center">&nbsp;<?php echo $rows['kelompok']; ?></td>
		<td class="tdisi" width="60" align="right">&nbsp;<?php echo number_format($rows['tarip'], 0, ',', '.'); ?></td>
	</tr>
	<?php
    }
    mysql_free_result($rs);
    ?>	
</table>
<?php
mysql_close($konek);
?>
