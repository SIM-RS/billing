<?php
//include("../../sesi.php");
include("koneksi/konek.php");
$val = explode(",",$_REQUEST['value']);
$lang = false;
switch($_REQUEST['id']) {
	case 'cmbKso':
		$wil = '';
		$all = 'false';
        $sql = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
	
	case 'cmbKsoAll':
		$wil = '';
		$all = 'true';
        $sql = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
    
	case 'cmbKso0':
		$wil = '';
		$all = 'true';
        $sql = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
	   			ORDER BY $dbbilling.b_ms_kso.nama";
        break;
    
	case 'cmbKso_f':
		$wil = '';
		$all = 'false';
        $sql = "SELECT am.idmitra as id, kso.nama FROM $dbbilling.b_ms_kso kso inner join $dbapotek.a_mitra am on kso.kode = am.kode_mitra";
	   // WHERE $dbbilling.b_ms_kso.id <> '1'
        break;
		
	case 'cmbSup':
		$wil = '';
		$all = 'false';
		$sql = "SELECT $dbapotek.a_pbf.PBF_ID as id, $dbapotek.a_pbf.PBF_NAMA as nama FROM $dbapotek.a_pbf ORDER BY $dbapotek.a_pbf.PBF_NAMA";
		break;
		
	case 'cmbJnsLay':
		$wil = '';
		$all = 'false';
		$sql = "SELECT id, nama FROM $dbbilling.b_ms_unit u where aktif=1 and kategori = 2 and level=1 ORDER BY nama";
		break;

	case 'cmbTemLay':
		$wil = '';
		$all = 'false';
		$sql = "select id, nama from $dbbilling.b_ms_unit where aktif=1 and parent_id='$val[0]' order by nama";
		break;

	case 'cmbTemLayWLang':
		$wil = '';
		$all = 'false';
		$lang = 'true';
		$sql = "select id, nama, inap as lang from $dbbilling.b_ms_unit where aktif=1 and parent_id='$val[0]' order by nama";
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
		$sql = "select dbaset.as_ms_rekanan.idrekanan as id, dbaset.as_ms_rekanan.namarekanan as nama from dbaset.as_ms_rekanan order by nama";
		break;
}
$rs=mysql_query($sql);
if($all == 'true'){
	?>
	<option value='0'>SEMUA</option>
	<?php
}
while($rw=mysql_fetch_array($rs)) {
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
}

?>