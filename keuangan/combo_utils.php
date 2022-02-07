<?php
include("koneksi/konek.php");
$val = explode(",",$_REQUEST['value']);
$lang = false;
switch($_REQUEST['id']) {
	case 'cmbTransaksi':
		$wil = '';
		$all = 'false';
        $sql = "SELECT id,nama FROM k_ms_transaksi WHERE tipe=".$val[0]." ORDER BY nama";
        break;
	
	case 'cmbKso':
		$wil = '';
		$all = 'false';
        $sql = "SELECT id, nama FROM ".$dbbilling.".b_ms_kso WHERE aktif=1 ORDER BY nama";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
	
	case 'cmbKsoNonUmum':
		$wil = '';
		$all = 'false';
		$lang = true;
        $sql = "SELECT id, nama, nama AS lang FROM ".$dbbilling.".b_ms_kso WHERE aktif=1 AND id <> '1' ORDER BY nama";
        break;

	case 'cmbKsoAll':
		$wil = '';
		$all = 'true';
        $sql = "SELECT id, nama FROM ".$dbbilling.".b_ms_kso WHERE aktif=1 ORDER BY nama";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
    
	case 'cmbKso0':
		$wil = '';
		$all = 'true';
        $sql = "SELECT id, nama FROM ".$dbbilling.".b_ms_kso WHERE aktif=1 ORDER BY nama";
        break;
    
	case 'cmbKso_f':
		$wil = '';
		$all = 'false';
        $sql = "SELECT am.idmitra as id, kso.nama FROM ".$dbbilling.".b_ms_kso kso inner join ".$dbapotek.".a_mitra am on kso.kode = am.kode_mitra WHERE kso.aktif=1 ORDER BY kso.nama";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
    
	case 'cmbKsoAll_f':
		$wil = '';
		$all = 'true';
        $sql = "SELECT am.idmitra as id, kso.nama FROM ".$dbbilling.".b_ms_kso kso inner join ".$dbapotek.".a_mitra am on kso.kode = am.kode_mitra WHERE kso.aktif=1 ORDER BY kso.nama";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
		
	case 'cmbSup':
		$wil = '';
		$all = 'true';
		$sql = "SELECT PBF_ID as id, PBF_NAMA as nama FROM ".$dbapotek.".a_pbf ORDER BY PBF_NAMA";
		break;
		
	case 'cmbJnsLay':
		$wil = '';
		$all = 'false';
		$sql = "SELECT id, nama FROM ".$dbbilling.".b_ms_unit u where aktif=1 and kategori = 2 and level=1 ORDER BY nama";
		break;
		
	case 'cmbJnsLayCCRV':
		$wil = '';
		$all = 'false';
		$sql = "SELECT id,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE level=1 ORDER BY kode";
		break;

	case 'cmbTemLay':
		$wil = '';
		$all = 'false';
		$sql = "select id, nama from ".$dbbilling.".b_ms_unit where aktif=1 and parent_id='$val[0]' order by nama";
		break;

	case 'cmbTemLayCCRV':
		$wil = '';
		$all = 'false';
		$sql = "SELECT id,kode,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=".$val[0];
		$rs1=mysql_query($sql);
		$rw1=mysql_fetch_array($rs1);
		$parentKd=$rw1["kode"];
		$sql = "SELECT id,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE islast=1 AND kode LIKE '".$parentKd."%' ORDER BY kode";
		break;

	case 'cmbTemLayWLang':
		$wil = '';
		$all = 'false';
		$lang = 'true';
		$sql = "select id, nama, inap as lang from ".$dbbilling.".b_ms_unit where aktif=1 and parent_id='$val[0]' order by nama";
		break;
	
	case 'cmbJnsPend':
		$wil = '';
		$all = 'true';
		if($val[0] == '') $val[0] = 1;
		$sql = "SELECT id, nama FROM k_ms_transaksi WHERE aktif=1 AND tipe = '$val[0]' ORDER BY id";
		break;
	
	case 'cmbJnsPeng':
		$wil = '';
		$all = 'false';
		$sql = "SELECT id, nama FROM k_ms_transaksi WHERE aktif=1 AND tipe = 2 ORDER BY id";
		break;
		
	case 'cmbBar':
		$wil = '';
		$all = 'false';
		$sql = "select idrekanan as id, namarekanan as nama from ".$dbaset.".as_ms_rekanan order by nama";
		break;
		
	case 'cmbKlaim':
		$waktu = explode('||',$val[1]);
		//print_r($waktu);
		if($waktu[0] == 'Harian'){
			$tglAwal = explode('-',$waktu[3]);
			$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
			$tglAkhir2 = $tglAwal2;
			$fwaktu = "AND k.tgl = '$tglAwal2' ";
			$fwaktut = "AND kt.tgl = '$tglAwal2' ";
		}else if($waktu[0] == 'Bulanan'){
			$bln = $waktu[4];
			$thn = $waktu[5];
			$cbln = ($bln<10)?"0".$bln:$bln;
			$fwaktu = "AND month(k.tgl) = '$bln' AND year(k.tgl) = '$thn' ";
			$fwaktut = "AND month(kt.tgl) = '$bln' AND year(kt.tgl) = '$thn' ";
			$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
			$tglAwal2="$thn-$cbln-01";
		}else{
			$tglAwal = explode('-',$waktu[1]);
			$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
			$tglAkhir = explode('-',$waktu[2]);
			$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
			$fwaktu = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
			$fwaktut = "AND kt.tgl between '$tglAwal2' and '$tglAkhir2' ";
		}
		$kso = $val[0];
		$qKso = "";
		if($kso == 0){
			$wkso = "";
		} else {
			$wkso = " AND k.kso_id = '{$kso}'";
		}
		if($val[2] == 'pengajuanKlaim'){
			$sql = "SELECT 
					  k.id, k.tgl, DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_, k.no_bukti, k.kso_id,
					  kso.nama, k.nilai, k.verifikasi 
					FROM
					  k_klaim k 
					  INNER JOIN $dbbilling.b_ms_kso kso 
						ON k.kso_id = kso.id 
					WHERE 0=0 {$wkso}";
					//{$fwaktu}
		} else {
			$sql = "SELECT
				  kt.id, kt.klaim_id, kt.verifikasi, kt.posting, k.kso_id, kt.tgl,
				  DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl_klaim, DATE_FORMAT(kt.tgl,'%d-%m-%Y') AS tgl_,
				  k.no_bukti no_pengajuan, kt.no_bukti, kso.nama, k.nilai nilai_pengajuan, kt.nilai
				FROM k_klaim_terima kt
				  INNER JOIN k_klaim k
					ON kt.klaim_id = k.id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON k.kso_id = kso.id
				WHERE 0=0 {$wkso}";
		}
		break;
		
	case 'cmbKasir2':
        $wil = '';
		$all = 'true';
        $sql = "SELECT b_ms_unit.id, b_ms_unit.nama FROM $dbbilling.b_ms_unit 
				WHERE b_ms_unit.kategori = 4 AND b_ms_unit.level = 2";
        break;
		
	case 'nmKsr':
		$wil = '';
		$all = 'true';
		$fKasir="";
		if ($val[0]<>"0"){
			$fKasir="AND b_ms_unit.id = ".$val[0]."";
		}
		$sql = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM $dbbilling.b_ms_pegawai 
			INNER JOIN $dbbilling.b_ms_pegawai_unit ON b_ms_pegawai.id = b_ms_pegawai_unit.ms_pegawai_id
			INNER JOIN $dbbilling.b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id
			WHERE b_ms_unit.kategori=4 $fKasir
			GROUP BY b_ms_pegawai.nama
			ORDER BY b_ms_pegawai.nama";
		break;
}
$rs=mysql_query($sql);
if($all == 'true'){
	?>
	<option value='0'>SEMUA</option>
	<?php
}

if($_REQUEST['id'] == 'cmbKlaim'){
	//if(mysql_num_rows($rs) <= 0){
		echo "<option value='0'>--- Pilih No Bukti Pengajuan ---</option>";
	//}
}

while($rw=mysql_fetch_array($rs)) {
	if($_REQUEST['id'] != 'cmbKlaim'){
		if($lang==true) {
			if (strpos($rw['nama'],'"')){
			?>
				<option value="<?php echo $rw['id'];?>" label='<?php echo $rw['nama'];?>' lang="<?php echo $rw['lang'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
			<?php
			}else{
			?>
				<option value="<?php echo $rw['id'];?>" label="<?php echo $rw['nama'];?>" lang="<?php echo $rw['lang'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
			<?php
			}
		}else {
			if (strpos($rw['nama'],'"')){
			?>
				<option value="<?php echo $rw['id'];?>" label='<?php echo $rw['nama'];?>' <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
			<?php
			}else{
			?>
				<option value="<?php echo $rw['id'];?>" label="<?php echo $rw['nama'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
			<?php
			}
		}
	}else{
		$value = $rw['id']."|".$rw['tgl']."|".$rw['no_bukti']."|".$rw['nilai'];
		$info = ($kso == 0 ? $rw['nama']." " : "")."[ ".$rw['no_bukti']." - ".$rw['tgl_']."]"." : Rp ".number_format($rw['nilai'],2,',','.');
		?>
			<option value="<?php echo $value;?>" label='<?php echo $rw['nama'];?>' <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>>
				<?php echo $info;?>
			</option>
		<?php
	}
}

?>