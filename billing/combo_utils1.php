<?php
include("koneksi/konek.php");
$val=explode(",",$_REQUEST['value']);
$lang=false;
$all = '';
$loop=$_REQUEST['loop1'];
$cabang_id = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1;

if($loop==1)
{
$query1 = "SELECT * FROM b_ms_kamar WHERE id = ".$val[0]."";
$rquery1 = mysql_query($query1);
$dquery1 = mysql_fetch_array($rquery1);
//echo $query1."<br>".$dquery1['jumlah_tt']."<br>";
	for($ii=1;$ii<=$dquery1['jumlah_tt'];$ii++)
	{
		//echo $sql_bed="SELECT * FROM b_tindakan_kamar tk WHERE kamar_id=$val[0] AND tgl_out IS NULL AND no_bed=$ii";
		$sql_bed="SELECT * FROM
	b_tindakan_kamar tk 
	INNER JOIN b_pelayanan p 
	ON p.id = tk.pelayanan_id 
	INNER JOIN b_kunjungan k 
	ON k.id = p.kunjungan_id 
WHERE tk.kamar_id=$val[0] AND tk.tgl_out IS NULL AND tk.aktif = 1 AND k.pulang = 0 AND p.dilayani = 1  AND tk.no_bed=$ii";
		$rs=mysql_query($sql_bed);
		if (mysql_num_rows($rs)==0){
		?>
		<option value="<? echo $ii;?>" lang="0"><? echo $ii;?></option>
		<?
		}
	}
}

switch($_REQUEST['id']) {
	case "loketCabang":
		$all = 'false';
		$_REQUEST['all'] = 0;
		$cabang = ($_REQUEST['value'] > 0) ? $_REQUEST['value'] : 1 ;
		$sql = "SELECT * FROM b_ms_unit mu WHERE mu.kategori=1 AND mu.level=2 AND mu.aktif=1 and cabang_id = {$cabang}";
		break;
	case "listcabang":
		$all = ($_REQUEST['all'] != '' && $_REQUEST['all'] == 1) ? 'true' : 'false';
		$cabang = ($_REQUEST['value'] > 0) ? $_REQUEST['value'] : 1 ;
		$sql = "select id, nama from b_profil where aktif = 1";
		break;
	case 'cmbPerawat':
		/*
		$sql="SELECT 
			  mp.id,
			  mp.nama 
			FROM
			  (SELECT 
				* 
			  FROM
				$dbaskep.ask_ms_group_akses 
			  WHERE ms_menu_id = 10 
				AND ms_group_id <> 4) AS t 
			  INNER JOIN $dbaskep.ask_ms_group_petugas mgp 
				ON t.ms_group_id = mgp.ms_group_id 
			  INNER JOIN b_ms_pegawai mp 
				ON mgp.ms_pegawai_id = mp.id
			  INNER JOIN b_ms_pegawai_unit mpu
				ON mpu.ms_pegawai_id = mp.id
			WHERE nama <> '' 
			  AND username <> '' AND mpu.unit_id=".$val[0];
		*/
		$sql="SELECT b.id,b.nama
               FROM b_ms_pegawai b 
               inner join b_ms_pegawai_unit u on b.id=u.ms_pegawai_id
               where u.unit_id='".$val[0]."' and b.spesialisasi_id=0 order by b.nama";
		break;
	case 'PenyebabKecelakaan':
		$sql="SELECT id,CONCAT(kode,' - ',nama) nama FROM b_ms_diagnosa WHERE islast=1 AND dg_kode='".$val[0]."' AND aktif=1";
		break;
	case 'cmbTmpInap':
		$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 1 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		break;
	case 'cmbDokDPJP':
        $wil='';
        /*$sql="SELECT b.id,b.nama
               FROM b_ms_pegawai b 
               inner join b_ms_pegawai_unit u on b.id=u.ms_pegawai_id
               where u.unit_id='".$val[0]."' and b.spesialisasi_id<>0 and b.aktif=1 order by b.nama";*/
        $sql="SELECT
				  b.id,
				  b.nama,
				  b.spesialisasi_id,
				  b.spesialisasi
				FROM b_ms_pegawai b
				  INNER JOIN b_ms_pegawai_unit u
					ON b.id = u.ms_pegawai_id
				WHERE u.unit_id = '".$val[0]."'
					AND b.aktif = 1
					AND b.spesialisasi_id NOT IN(0,10,71,129,137,182)
				ORDER BY b.nama";
		break;
	case 'kelIdlab':
		$wil='';
        $sql="select id,nama_kelompok as nama from b_ms_kelompok_lab";
		break;
	case 'JnsLayananOK':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_unit WHERE id=62";
        break;
	case 'TmpLayananOK':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_unit WHERE parent_id=".$val[0]." OR id IN(47) ORDER BY nama";
        break;
	case 'cmbTmpLayStokOpname':
        $wil='';
        $lang=true;
        $sql="SELECT distinct u.kode as id,u.nama FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
               where ms_pegawai_id='".$val[0]."') as t1
               inner join b_ms_unit u on t1.unit_id=u.id
               where u.parent_id='".$val[1]."' and u.aktif=1 order by nama";
        break;
	case 'cmbJnsLayStokView':
        $wil='';
        $lang=true;
		$sql="SELECT * FROM (SELECT DISTINCT m.id,m.nama,m.inap,m.nama AS urut FROM (SELECT DISTINCT b.unit_id FROM b_ms_pegawai_unit b
			WHERE ms_pegawai_id=".$val[0].") AS t1
			INNER JOIN b_ms_unit u ON t1.unit_id=u.id
			INNER JOIN b_ms_unit m ON u.parent_id=m.id 
			WHERE m.kategori=2 
			UNION
			SELECT 'far','FARMASI',0,'1' AS urut) AS gab
			ORDER BY urut";
        break;
	case 'cmbTmpLayStokView':
        $wil='';
        $lang=true;
		if($val[1]=='far'){
			$sql="SELECT UNIT_ID AS id,UNIT_NAME AS nama, 0 AS inap FROM $dbapotek.a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE<>4 AND UNIT_TIPE<>7 AND UNIT_ISAKTIF=1";
		}
		else{
        	$sql="SELECT distinct au.UNIT_ID as id,u.nama FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
               where ms_pegawai_id='".$val[0]."') as t1
               inner join b_ms_unit u on t1.unit_id=u.id
			   INNER JOIN $dbapotek.a_unit au ON au.unit_billing=u.id
               where u.parent_id='".$val[1]."' and u.aktif=1 order by nama";
		}
        break;
	case 'JnsLayanan15':
        $wil='';
        $sql="select id,nama from b_ms_unit where kategori=2 and aktif=1 and level=1";
        break;
	case 'TmpLayanan15':
        $wil='';
		if($val[0]==27){
			$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 1 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		}
		else{
        	$sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." order by nama";
		}
        break;
	case 'cmbTempatLayananM':
		$wil='';
		$lang=true;
		if($val[0]==1){
		$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 0 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		}
		elseif($val[0]==3){
		$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 1 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		}else{
			$sql="SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND parent_id=44 ORDER BY nama";
		}
		break;
    case 'detailKIA':
		$sql="SELECT id,detail as nama FROM b_ms_kia_detail WHERE kia_id=".$_REQUEST['value'];
		break;
	case 'jnskasus':
		$sql="SELECT id,kasus as nama FROM b_ms_maternal_perinatal WHERE tipe=".$_REQUEST['value'];
		break;
    case 'Pendidikan':
        //$wil='Pendidikan';
		$wil='';
        $sql="select id,nama from b_ms_pendidikan where aktif=1 order by nama ";
        break;
    case 'Pekerjaan':
        //$wil='Pekerjaan';
		$wil='';
        $sql="select id,nama from b_ms_pekerjaan where aktif=1 order by nama ";
        break;
    case 'cmbProp':
        //$wil='Propinsi';
		$wil='';
        $sql="select id,nama from b_ms_wilayah where level=1 order by nama";
        break;
    case 'cmbKab':
        //$wil='Kabupaten';
		$wil='';
        $sql="select id,nama from b_ms_wilayah where level=2 and parent_id=".$val[0]." order by nama";
        break;
    case 'cmbKec':
        //$wil='Kecamatan';
		$wil='';
        $sql="select id,nama from b_ms_wilayah where level=3 and parent_id=".$val[0]." order by nama";
        break;
    case 'cmbDesa':
        //$wil='Desa';
		$wil='';
        $sql="select id,nama from b_ms_wilayah where level=4 and parent_id=".$val[0]." order by nama";
        break;
    case 'AslMasuk':
        $wil='Rujukan';
        $sql="select id,nama from b_ms_asal_rujukan where aktif=1";
        break;
	case 'cmbPusk':
        $wil='-- Puskesmas --';
        $sql="select id,nama from b_ms_daftar_puskesmas where aktif=1";
        break;
	case 'cmbRSasal':
        $wil='-- Rumah Sakit --';
        $sql="select id,nama from b_ms_asal_rumahsakit where aktif=1";
        break;
    case 'asalLoket':
        $sql = "SELECT u.id,u.nama FROM b_ms_pegawai_unit b inner join b_ms_unit u on b.unit_id = u.id where ms_pegawai_id = '$val[0]' and kategori = 1";
        break;
    case 'userLog':
		$sql = "SELECT distinct p.id,p.nama FROM b_ms_pegawai p inner join b_ms_pegawai_unit b on p.id = b.ms_pegawai_id inner join b_ms_unit u on b.unit_id = u.id inner join b_ms_group_petugas gp on p.id = gp.ms_pegawai_id where unit_id = '$val[0]' and kategori = 1 and ms_group_id <> 10";
	break;
    case 'StatusPas':
        $wil='';
        $sql="select id,nama from b_ms_kso where id>2 AND aktif = 1 ORDER BY nama";
        break;
	case 'StatusPasJamkesmas':
        $wil='';
        $sql="select id,nama from b_ms_kso where id>1 AND nama LIKE 'JAMKESMAS%' OR nama LIKE 'UMUM'  AND aktif = 1 ORDER BY nama";
        break;
	case 'StatusPasAskes':
        $wil='';
        $sql="select id,nama from b_ms_kso where id>1 AND nama LIKE 'ASKES%' AND aktif = 1 ORDER BY nama";
        break;
    case 'StatusPas0':
        $wil='';
        $sql="select id,nama from b_ms_kso where aktif = 1 ORDER BY nama";
        break;
    case 'cakupan':
        $wil = '';
        $sql = "select id, nama from b_ms_unit where kategori = 2 and aktif =1 and level = 1 ORDER BY nama";
        break;
    case 'JnsLayanan':
        $wil='';
        $sql="select id,nama from b_ms_unit where /*kategori=2 and*/ aktif=1 and level=1 and id not in (165,166)";
        break;
	 case 'JnsLayananKonDok':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_unit WHERE kategori=2 AND aktif=1 AND LEVEL=1 AND id IN (1)";
        break;
    case 'JnsLayanan_sjp':
        $wil='';
        $sql="select id,nama from b_ms_unit where id in (1,44,57,60,64,66,27) and kategori=2 and aktif=1 and level=1";
        break;
     case 'JnsLayananTanpaInap':
        $wil='';
        $sql="select id,nama from b_ms_unit where kategori=2 and aktif=1 and inap=0 and level=1";
        break;
	case 'JnsLayananKonsul':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_unit WHERE (kategori=2 OR kategori=5) AND aktif=1 AND LEVEL=1 AND id IN (SELECT DISTINCT parent_id FROM b_ms_unit WHERE inap=0 AND LEVEL=2) AND (cabang_id = {$cabang_id} or penunjang = 1)";
		break;
	case 'JnsLayananRujuk':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_unit WHERE (kategori=2 OR kategori=5) AND penunjang = 0 AND aktif=1 AND LEVEL=1 AND id IN (SELECT DISTINCT parent_id FROM b_ms_unit WHERE inap=0 AND LEVEL=2)";
		break;
    case 'JnsLayananJln':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE kode=01";
		break;
    case 'JnsLayananDenganInap':
        $wil='';
        $lang=true;
        $sql="select id,nama,inap as lang from b_ms_unit where kategori=2 and inap=1 and aktif=1 and level=1 and cabang_id = {$cabang_id}";
        break;
    case 'JnsLayananInapSajaPerPegawai':
        $wil='';
        $lang=true;
        $sql="SELECT distinct m.id,m.nama,m.inap as lang FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
					where ms_pegawai_id=".$val[0].") as t1
					inner join b_ms_unit u on t1.unit_id=u.id
					inner join b_ms_unit m on u.parent_id=m.id
                              where m.inap=1";
        break;
    case 'JnsLayananBukanInapPerPegawai':
        $wil='';
        $lang=true;
        $sql="SELECT distinct m.id,m.nama,m.inap as lang FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
					where ms_pegawai_id=".$val[0].") as t1
					inner join b_ms_unit u on t1.unit_id=u.id
					inner join b_ms_unit m on u.parent_id=m.id
                              where m.inap=0 order by nama";
        break;
    case 'JnsLayananBukanInapPerPegawaiKategori2':
        $wil='';
        $lang=true;
        $sql="SELECT distinct m.id,m.nama,m.inap as lang FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
					where ms_pegawai_id=".$val[0].") as t1
					inner join b_ms_unit u on t1.unit_id=u.id
					inner join b_ms_unit m on u.parent_id=m.id
                    where m.inap=0 and m.kategori=2 order by nama";
        break;
    case 'JnsLayananReg':
        $wil='';
        $sql="select id,nama from b_ms_unit where id<>'27' and kategori = 2 and aktif=1 and level=1";
        break;
    case 'JnsLayananRegByLoket':
        $wil='';
        $sql="SELECT DISTINCT mu1.id,mu1.nama FROM b_ms_unit_loket mul INNER JOIN b_ms_unit mu ON mul.id_unit_layanan=mu.id 
INNER JOIN b_ms_unit mu1 ON mu.parent_id=mu1.id WHERE /*mu1.id<>'27' AND*/ mul.id_loket=$val[0] AND mu.aktif=1 and mu.kategori = 2 order by mu1.nama desc ";
        break;
    case 'JnsLayananFull':
        $wil='';
        $sql="select id,nama from b_ms_unit where aktif=1 and kategori = 2 and level=1";
        break;
    case 'JnsLayananFullByLoket':
        $wil='';
        $sql="SELECT DISTINCT mu1.id,mu1.nama FROM b_ms_unit_loket mul INNER JOIN b_ms_unit mu ON mul.id_unit_layanan=mu.id 
INNER JOIN b_ms_unit mu1 ON mu.parent_id=mu1.id WHERE mul.id_loket=$val[0] AND mu.aktif=1 and mu.kategori = 2";
        break;
    case 'JnsLayananWAll':
        $wil='';
        $sql="SELECT 0 as id,'SEMUA' as nama UNION (select id,nama from b_ms_unit where aktif=1 and kategori = 2 and level=1)";
        break;
	case 'JnsLayananIgd':
        $wil='';
        $sql="select id,nama from b_ms_unit where id=44 and aktif=1 and level=1";
        break;
	case 'TmpLayananIgd':
        $wil='';
        $sql="select id, nama from b_ms_unit where aktif=1 and id=45 and parent_id=".$val[0]." order by nama";
        break;
    case 'TmpLayanan':
        $wil='';
        $sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." order by nama";
		/*
		if($val[0]==27){
			$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 1 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		}
		else{
        	$sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." order by nama";
		}
		*/
        break;
	case 'TmpLayananKonDok':
        $wil='';
        $sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." order by nama";
		break;
    case 'TmpLayanan_sjp':
	
        $wil='';
		$lang=true;
        $sql="select inap as lang,id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." /*and kodeAskes is not null*/ order by nama";
        break;
    case 'TmpLayanan_sjpByReg':
        $wil='';
        //$sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0]." and kodeAskes is not null order by nama";
        $sql="SELECT DISTINCT mu.id,mu.nama FROM b_ms_unit_loket mul INNER JOIN b_ms_unit mu ON mul.id_unit_layanan=mu.id 
WHERE mu.parent_id=".$val[0]." AND mul.id_loket=".$val[1]." AND mu.aktif=1 AND mu.kategori = 2 ORDER BY nama";
        break;
    case 'TmpLayananDenganSemua':
        $wil='';
	   if($val[0] == 0){
		  $sql="SELECT 0 as id,'SEMUA' as nama";
	   }
	   else{
		  $sql="SELECT 0 as id,'SEMUA' as nama UNION (SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND parent_id=".$val[0]." ORDER BY nama)";
	   }
        break;
    case 'TmpLayananDenganInap':
        $wil='';
        $lang=true;
        $sql="select id, nama, inap as lang from b_ms_unit where aktif=1 and parent_id=".$val[0]." ORDER BY nama";
        break;
    case 'TmpLayananDenganInapByReg':
        $wil='';
        $lang=true;
        $sql="SELECT DISTINCT mu.inap as lang,mu.id,mu.nama FROM b_ms_unit_loket mul INNER JOIN b_ms_unit mu ON mul.id_unit_layanan=mu.id 
WHERE mu.parent_id=".$val[0]." AND mul.id_loket=".$val[1]." AND mu.aktif=1 AND mu.kategori = 2 ORDER BY nama";
        break;
	case 'JnsLayananInapSaja':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE inap = 1 AND kategori = 2 AND level = 1 AND aktif = 1";
		break;
	case 'JnsLayananPav':
		$wil = '';
		$lang = true;
		$sql = "SELECT id, nama FROM b_ms_unit WHERE id = 50 AND aktif = 1";
		break;
    case 'TmpLayananInapSaja':
        $wil='';
        $lang=true;
		//if($val[0]==27){
			//$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = 1 AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		//}
		//else{
        	$sql="select id, nama, inap as lang from b_ms_unit where aktif=1 and parent_id=".$val[0]." and inap=1 ORDER BY nama";
        //}
        break;
	
    case 'TmpLayananGroupInap':
        $wil='';
        $lang=true;

        	$sql="select id, nama,'1' as lang from b_ms_group_kamar where aktif=1 ORDER BY nama";
        //}
        break;
    case 'TmpLayananBukanInap':
        $wil='';
        $lang=true;
        $sql="select id, nama, inap as lang from b_ms_unit where aktif=1 and parent_id=".$val[0]." and inap=0 ORDER BY nama";
        break;
	case 'JnsLayananInap':
		$wil = '';
		$sql = "SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND penunjang=0 AND kategori=2 AND level=1";
		break;
    case 'TmpLayananInap':
		$wil = '';
		$sql = "SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND parent_id=".$val[0]." AND inap=0 AND penunjang=0 ORDER BY nama ";
		break;
    case 'TmpLayMedik':
		$wil = '';
		$sql = "SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND id IN (58,59,61,65) ORDER BY nama ";
		break;
	case 'cmbTempatLayanan':
		$wil='';
		$lang=true;
		if($val[0]==0 || $val[0]==1){
		
		$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.inap = ".$val[0]." AND b_ms_unit.penunjang = 0 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		
		}else{
			$sql="SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.penunjang = 1 AND b_ms_unit.aktif = 1 AND b_ms_unit.level = 2 AND b_ms_unit.kategori = 2";
		}
		break;
    case 'TmpLayananJln':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE aktif=1 and parent_id=".$val[0]." ORDER BY nama";
		break;
    case 'TmpLayananJalan':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE inap=0 and aktif=1 and parent_id=".$val[0]." ORDER BY nama";
		break;
    case 'TmpLayananPav':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE aktif=1 and parent_id=".$val[0]." and inap = '0' ORDER BY nama";
		break;
    case 'TmpLayananPavInap':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE aktif=1 and parent_id=".$val[0]." and inap = '1' ORDER BY nama";
		break;
    case 'TmpLayananPsi':
        $wil='';
        $sql="select id, nama from b_ms_unit where aktif=1 and id='12' and parent_id=".$val[0]." order by nama";
        break;
    case 'kamar':
        $lang = true;
        $sql = "select distinct mk.id,mk.nama,kt.tarip as lang from b_ms_kamar mk inner join b_ms_kamar_tarip kt on mk.id = kt.kamar_id
                where mk.unit_id = $val[0] and mk.aktif = 1 and kt.kelas_id = $val[1] ORDER BY mk.nama";
				
        $rs = mysql_query($sql);
        if(mysql_num_rows($rs) == 0){
           $sql = "select 0 as id, '-' as nama, 0 as lang";
        }
        break;
    case 'cmbKasir':
        $wil='';
        $sql="SELECT p.id, p.nama FROM b_ms_pegawai p
            INNER JOIN b_ms_group_petugas gp ON gp.ms_pegawai_id = p.id
            INNER JOIN b_ms_group g ON gp.ms_group_id = g.id
            WHERE (g.id = 6 OR g.id = 9 OR g.id = 11 OR g.id = 19 OR g.id = 31)
            GROUP BY p.nama
            ORDER BY p.nama";
        break;
	case 'comboKasir':
		$wil='';
		$sql = "SELECT id, nama FROM b_ms_unit WHERE b_ms_unit.parent_id = '80' AND LEVEL = '2' AND aktif = '1' AND jenis_layanan = 0";
		break;
	case 'cmbNmKasir':
		$wil='';
		$sql = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai.id = b_ms_pegawai_unit.ms_pegawai_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id WHERE b_ms_unit.id = ".$val[0]." AND b_ms_unit.aktif = '1' GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
		break;
    case 'cmbKelas':
        $wil='';
        $sql="select id,nama from b_ms_kelas where aktif=1";
        break;
    case 'HakKelas':
        $wil='';
        $sql="select id,nama from b_ms_kelas where aktif=1 and id in (1,2,3,4,5,6,7,8,9)";
        break;
    case 'HakKelasSJP':
        $wil='';
        $sql="select id,nama from b_ms_kelas where aktif=1 and id in (2,3)";
        break;
    case 'cmbKelasKamar':
		$def_kls="SELECT default_kelas FROM b_ms_unit WHERE id = $val[0]";
		$q_def_kls=mysql_query($def_kls);
		$rw_def_kls=mysql_fetch_array($q_def_kls);
		if($rw_def_kls['default_kelas']!=1)
			$_REQUEST['defaultId']=$rw_def_kls['default_kelas'];
        
        $wil='';
		$lang = true;
		$sql="SELECT DISTINCT mk.id,mk.nama,kt.tarip FROM b_ms_kamar_tarip kt INNER JOIN b_ms_kelas mk ON kt.kelas_id = mk.id
INNER JOIN b_ms_kamar k ON kt.kamar_id=k.id WHERE k.unit_id = $val[0] AND k.aktif=1 ORDER BY mk.id";
        break;
    case 'cmbKelasKamarJamkesmas':
        $wil='';
		$lang = true;
		$sql="SELECT DISTINCT mk.id,mk.nama,kt.tarip FROM b_ms_kamar_tarip kt INNER JOIN b_ms_kelas mk ON kt.kelas_id = mk.id
INNER JOIN b_ms_kamar k ON kt.kamar_id=k.id WHERE k.unit_id = $val[0] AND (mk.id=4 OR mk.id=37) AND k.aktif=1";
		$rsJmlKls=mysql_query($sql);
		if (mysql_num_rows($rsJmlKls)<=0){
			$sql="SELECT DISTINCT mk.id,mk.nama,kt.tarip FROM b_ms_kamar_tarip kt INNER JOIN b_ms_kelas mk ON kt.kelas_id = mk.id
INNER JOIN b_ms_kamar k ON kt.kamar_id=k.id WHERE k.unit_id = $val[0] ORDER BY mk.id";
		}
        break;
    case 'cmbKelasPasien':
        $wil='';
        if($val[2] == 0){
			$sql = "select * from b_ms_unit where id = '$val[0]'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			if($row['penunjang'] == '1'){
				$sql = "select id,nama from b_ms_kelas where id in (1,5,6,7,8,9)";
			}
			else if($val[1] == '50' || $val[1] == '132'){
				$sql = "select id,nama from b_ms_kelas where id = 9";
			}
			else{
				$sql = "select id,nama from b_ms_kelas where id = 1";
			}
        }
        else {
            //$sql = "select distinct mk.id,mk.nama from b_ms_kamar_tarip kt inner join b_ms_kelas mk on kt.kelas_id = mk.id where unit_id = $val[0]";
			$sql = "SELECT DISTINCT mk.id,mk.nama FROM b_ms_kamar_tarip kt INNER JOIN b_ms_kelas mk ON kt.kelas_id = mk.id
INNER JOIN b_ms_kamar kamar ON kt.kamar_id=kamar.id
WHERE kamar.unit_id = $val[0] AND kamar.aktif=1";
        }
        break;
    case 'cmbKelasPasienJamkesmas':
        $wil='';
        if($val[2] == 0){
			$sql = "select * from b_ms_unit where id = '$val[0]'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			if($row['penunjang'] == '1'){
				$sql = "select id,nama from b_ms_kelas where id in (1,5,6,7,8,9)";
			}
			else if($val[1] == '50'){
				$sql = "select id,nama from b_ms_kelas where id = 9";
			}
			else{
				$sql = "select id,nama from b_ms_kelas where id = 1";
			}
        }
        else {
            $sql = "select distinct mk.id,mk.nama from b_ms_kamar_tarip kt inner join b_ms_kelas mk on kt.kelas_id = mk.id
                    where unit_id = $val[0] AND (mk.id=4 OR mk.id=31)";
			$rsJmlKls=mysql_query($sql);
			if (mysql_num_rows($rsJmlKls)<=0){
            	$sql = "select distinct mk.id,mk.nama from b_ms_kamar_tarip kt inner join b_ms_kelas mk on kt.kelas_id = mk.id
                    where unit_id = $val[0]";
			}
        }
        break;
    case 'Retribusi':
         $wil='';
        $lang = true;
        if($val[0]!='27' && $val[0]!='44' && $val[0]!='50' && $val[0]!='132') {
          //bukan inap, bukan darurat, bukan pavilyun
		$idKlsTind = " inner join b_ms_tindakan_kelas tk on tk.ms_tindakan_id = b.id
			    inner join b_ms_tindakan_unit tu on tu.ms_tindakan_kelas_id = tk.id
			    where klasifikasi_id = 11 and tu.ms_unit_id = '$val[1]'";
			//	echo $idKlsTind;
		//$idKlsTind = " and id='2362'"; //Spesialis
        }
        else if($val[0]=='44') {
	    //$wil = '-';
            $idKlsTind = " inner join b_ms_tindakan_kelas tk on tk.ms_tindakan_id = b.id
			    inner join b_ms_tindakan_unit tu on tu.ms_tindakan_kelas_id = tk.id
                            where klasifikasi_id=11 and tu.ms_unit_id = '$val[1]'"; //IGD
				//echo $idKlsTind;
        }
        else if($val[0]=='50' || $val[0]=='132') {
            $idKlsTind = " inner join b_ms_tindakan_kelas tk on tk.ms_tindakan_id = b.id
			    inner join b_ms_tindakan_unit tu on tu.ms_tindakan_kelas_id = tk.id
                            where klasifikasi_id=101 and tu.ms_unit_id = '$val[1]'"; //PAVILYUN
							//echo $idKlsTind;
        }
        $sql="SELECT distinct b.id,b.nama,tk.tarip as lang FROM b_ms_tindakan b $idKlsTind and b.id<>1918 ORDER BY nama asc";
		//echo $sql;
		$rs = mysql_query($sql);
		if(mysql_num_rows($rs) == 0){
			$sql = "select '0' as id, '-' as nama, 0 as lang";
		}
        break;
    case 'cmbAgama':
        $wil='';
        $sql="select id,agama as nama from b_ms_agama where aktif=1";
        break;
	case 'cmbKw':
        $wil='';
        $sql="select id,nama as nama from b_ms_kewarganegaraan where status=1";
        break;
    case 'cmbGroup':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_group WHERE aktif = 1 ORDER BY nama";
        break;
    case 'cmbKlasi':
        $wil='';
        $sql="select id,nama from b_ms_klasifikasi where aktif=1";
        break;
    case 'cmbKelompok':
        $wil='';
	   $all = 'true';
        $sql="select id,nama from b_ms_kelompok_tindakan where aktif=1 and ms_klasifikasi_id='".$val[0]."'";
        break;
    case 'cmbKelTin':
        $wil='';
        $sql="select id,nama from b_ms_kelompok_tindakan where aktif=1 and ms_klasifikasi_id='".$val[0]."' order by nama asc";
        break;
    case 'cmbTmpLay':
        $wil='';
        $lang=true;
       echo $sql="SELECT distinct u.id,u.nama,inap as lang FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
               where ms_pegawai_id='".$val[0]."') as t1
               inner join b_ms_unit u on t1.unit_id=u.id
               where u.parent_id='".$val[1]."' and u.aktif=1 order by nama";
        break;
    case 'cmbDokPengganti':
	 	$wil='';
		$sql="SELECT id,nama FROM b_ms_pegawai WHERE spesialisasi_id=62 and aktif = 1 ORDER BY nama";
	break;
	case 'cmbDokRegPengganti':
	 	$wil='';
		if($val[0]=='45'){
			$wil='-';
		}
		$sql="SELECT id,nama FROM b_ms_pegawai WHERE spesialisasi_id=62 and aktif = 1 ORDER BY nama";
	break;
	 case 'cmbDokReg':
        $wil='';
		if($val[0]=='45'){
			$wil='-';
		}
        $sql="SELECT t1.id, CONCAT(t1.nama,' (',t1.jml_p,'/',t1.jml_pD,')') AS nama FROM
		(SELECT b.id,b.nama, (SELECT COUNT(*) AS jml
		FROM b_pelayanan 
		WHERE tgl = '".tglSQL($val[1])."' 
		AND dokter_tujuan_id = b.id AND unit_id = '".$val[0]."') AS jml_p, (SELECT IFNULL(SUM(dilayani),0)
		FROM b_pelayanan 
		WHERE tgl = '".tglSQL($val[1])."' 
		AND dokter_tujuan_id = b.id AND unit_id = '".$val[0]."') AS jml_pD
		FROM b_ms_pegawai b 
		INNER JOIN b_ms_pegawai_unit u ON b.id=u.ms_pegawai_id
        INNER JOIN b_jadwal_dokter jd
          ON b.id = jd.dokter_id
		WHERE u.unit_id='".$val[0]."' AND b.spesialisasi_id<>0 AND b.aktif = 1 AND b.`pegawai_jenis`=8 
          AND jd.tgl = '".tglSQL($val[1])."'
          AND (jd.mulai < DATE_FORMAT(NOW(),'%H:%i:00'))
          AND (jd.selesai > DATE_FORMAT(NOW(),'%H:%i:00'))
		ORDER BY b.nama) AS t1";
		$rsC=mysql_query($sql);
		if (mysql_num_rows($rsC)<=0){
			$sql="SELECT t1.id, CONCAT(t1.nama,' (',t1.jml_p,'/',t1.jml_pD,')') AS nama FROM
	(SELECT b.id,b.nama, (SELECT COUNT(*) AS jml
	FROM b_pelayanan 
	WHERE tgl = '".tglSQL($val[1])."' 
	AND dokter_tujuan_id = b.id AND unit_id = '".$val[0]."') AS jml_p, (SELECT IFNULL(SUM(dilayani),0)
	FROM b_pelayanan 
	WHERE tgl = '".tglSQL($val[1])."' 
	AND dokter_tujuan_id = b.id AND unit_id = '".$val[0]."') AS jml_pD
	FROM b_ms_pegawai b 
	INNER JOIN b_ms_pegawai_unit u ON b.id=u.ms_pegawai_id
	WHERE u.unit_id='".$val[0]."' AND b.spesialisasi_id<>0 AND b.aktif = 1 AND b.`pegawai_jenis`=8 ORDER BY b.nama) AS t1";
		}
        break;
    case 'cmbDok':
        $wil='';
        $sql="SELECT b.id,b.nama
               FROM b_ms_pegawai b 
               inner join b_ms_pegawai_unit u on b.id=u.ms_pegawai_id
               where u.unit_id='".$val[0]."' and b.spesialisasi_id<>0 and aktif = 1 order by b.nama";
        break;
	case 'cmbDokRadiologi':
        $wil='';
        $sql="SELECT b.id,b.nama
               FROM b_ms_pegawai b 
               inner join b_ms_pegawai_unit u on b.id=u.ms_pegawai_id
               where u.unit_id='".$val[0]."' and b.spesialisasi_id=56 and aktif = 1 order by b.nama";
        break;
	case 'cmbDiagRes':
        $wil='';
        $sql="SELECT * FROM (SELECT d.diagnosa_id AS id,d.ms_diagnosa_id,md.kode,md.nama,d.pelayanan_id,d.user_id,p.nama AS dokter,d.primer,IF(d.primer=1,'Utama','Sekunder') AS utama,d.akhir,IF(d.akhir=1,'Ya','Tidak') AS d_akhir,d.klinis,IF(d.klinis=1,'Ya','Tidak') AS d_klinis, d.type_dokter, md.dg_kode, bmu.nama AS nm_unit
	FROM b_diagnosa d 
	INNER JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
	INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
	INNER JOIN b_ms_pegawai p ON p.id = d.user_id
	INNER JOIN b_ms_unit bmu ON pl.unit_id = bmu.id
	WHERE d.kunjungan_id = '".$val[0]."') AS gab
	UNION
	SELECT * FROM (SELECT d.diagnosa_id AS id,d.ms_diagnosa_id,'-' AS nm1,d.diagnosa_manual,d.pelayanan_id,d.user_id,p.nama AS dokter,d.primer,IF(d.primer=1,'Utama','Sekunder') AS utama,d.akhir,IF(d.akhir=1,'Ya','Tidak') AS d_akhir,d.klinis,IF(d.klinis=1,'Ya','Tidak') AS d_klinis, d.type_dokter, '-' AS nm12, bmu.nama AS nm_unit
	FROM b_diagnosa d 
	INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
	INNER JOIN b_ms_pegawai p ON p.id = d.user_id
	INNER JOIN b_ms_unit bmu ON pl.unit_id = bmu.id
	WHERE d.kunjungan_id = '".$val[0]."' AND diagnosa_manual IS NOT NULL) AS gab";
        break;
	case 'cmbDokVisite':
        $wil='';
        $sql="SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_tindakan INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id=b_tindakan.user_id WHERE b_tindakan.pelayanan_id='".$val[0]."' AND (b_ms_tindakan.klasifikasi_id=13 OR b_ms_tindakan.klasifikasi_id=14) GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
        break;
    case 'cmbDokPav':
        $wil='';
        $sql="SELECT DISTINCT p.id,p.nama FROM b_ms_pegawai p
INNER JOIN b_tindakan t ON t.user_id=p.id
INNER JOIN b_pelayanan l ON l.id=t.pelayanan_id
INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
	   INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
	   INNER JOIN b_ms_unit u ON u.id=l.unit_id
	   INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
	   WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($val[0])."' AND '".tglSQL($val[1])."') 
	   GROUP BY k.id) AS t1 ON t1.id=l.kunjungan_id
WHERE (t.tgl BETWEEN '".tglSQL($val[0])."' AND '".tglSQL($val[1])."') AND (t1.jml>0)
UNION 
SELECT DISTINCT p.id,p.nama FROM b_ms_pegawai p
INNER JOIN b_tindakan_dokter_anastesi da ON da.dokter_id=p.id
INNER JOIN b_tindakan t ON t.id=da.tindakan_id
INNER JOIN b_pelayanan l ON l.id=t.pelayanan_id
INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
	   INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
	   INNER JOIN b_ms_unit u ON u.id=l.unit_id
	   INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
	   WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($val[0])."' AND '".tglSQL($val[1])."') 
	   GROUP BY k.id) AS t1 ON t1.id=l.kunjungan_id
WHERE (t.tgl BETWEEN '".tglSQL($val[0])."' AND '".tglSQL($val[1])."') AND (t1.jml>0) ORDER BY nama";
        break;
	case 'cmbDokJns':
        $wil='';
	if($val[0]==0){  $fPel = "b_ms_unit.parent_id = '".$val[0]."' ";
	}else{
	    $fPel = "b_ms_unit.id = '".$val[0]."'";
	}
        $sql="SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai
			INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id
			INNER JOIN b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id
			WHERE $fPel
			AND b_ms_pegawai.spesialisasi_id <> 0 
			GROUP BY b_ms_pegawai.id
			ORDER BY b_ms_pegawai.nama";
        break;
    case 'cmbRS':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_tujuan_rujukan";
        break;
    case 'cmbKamar':
        $wil='';
        $lang = true;
        
		/*
		$sql = "select distinct mk.id,mk.nama,kt.tarip as lang from b_ms_kamar mk inner join b_ms_kamar_tarip kt on mk.id = kt.kamar_id
                where mk.unit_id = $val[0] and mk.aktif = 1 and kt.kelas_id = $val[1]";
		*/
		$sql = "SELECT 
			  k.id,
			  k.nama,
			  kt.tarip as lang
			FROM
			  b_ms_kamar k 
			  INNER JOIN b_ms_kamar_tarip kt 
				ON kt.kamar_id = k.id 
			WHERE k.unit_id = $val[0] 
			  AND kt.kelas_id = $val[1] 
			  AND k.aktif = 1
			  AND k.id NOT IN 
			  (SELECT 
				tbl1.kamar_id 
			  FROM
				(SELECT 
				  tk.kamar_id,
				  COUNT(tk.id) AS jml 
				FROM
				  b_tindakan_kamar tk 
				  INNER JOIN b_pelayanan p 
					ON p.id = tk.pelayanan_id 
				  INNER JOIN b_kunjungan k 
					ON k.id = p.kunjungan_id 
				WHERE tk.aktif = 1 
				  AND k.pulang = 0 
				  AND tk.tgl_out IS NULL  
				  AND p.dilayani = 1 
				GROUP BY tk.kamar_id,p.unit_id ) AS tbl1 
				INNER JOIN 
				  (SELECT 
					mk.id,
					(mk.jumlah_tt + mk.jumlah_tt_b) AS kuota 
				  FROM
					b_ms_kamar mk 
				  WHERE mk.unit_id = $val[0] 
					AND mk.aktif = 1) AS tbl2 
				  ON tbl1.kamar_id = tbl2.id 
			  WHERE tbl1.jml >= tbl2.kuota) ORDER BY k.nama";
		//echo $sql."<br>";
        $rs = mysql_query($sql);
        if(mysql_num_rows($rs) == 0){
           $sql = "select 0 as id, '-' as nama, 0 as lang";
        }
        //$sql="SELECT id,nama FROM b_ms_kamar where unit_id='".$val[0]."' and kelas_id='".$val[1]."'";
        break;
    case 'cmbKom':
        $wil='';
        $sql="SELECT id,nama FROM b_ms_komponen where aktif=1 ";
        break;
	case 'cmbJnsPenunjang':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE penunjang = '1' AND LEVEL = 1";
		break;
	case 'cmbTmpPenunjang':
		$wil='';
		$sql="SELECT id, nama FROM b_ms_unit WHERE parent_id = ".$val[0]." ";
		break;
    case 'cmbJnsMak':
        $wil='';
        $sql="SELECT nama as id,nama FROM b_ms_reference where stref=14 and aktif=1 ";
        break;
    case 'cmbCaraKeluar':
        $wil='';
        //$sql="SELECT nama as id,nama FROM b_ms_cara_keluar where aktif=1 and nama<>'".$val[0]."'";
		$sql="SELECT 
			  id,
			  nama 
			FROM
			  (SELECT 
				nama AS id,
				nama,
				IF(nama = 'APS', CONCAT('z', nama), nama) temp 
			  FROM
				b_ms_cara_keluar 
			  WHERE aktif = 1 
				AND nama <> '".$val[0]."') AS tbl 
			ORDER BY temp";
        break;
		case 'cmbKeadaanKeluar':
        $wil='';
        //$sql="SELECT nama as id,nama FROM b_ms_cara_keluar where aktif=1 and nama<>'".$val[0]."'";
		$sql="SELECT a.nama as id,a.nama
FROM `b_ms_keadaan_keluar` a
INNER JOIN `b_ms_cara_keluar` b ON b.`id`=a.`id_cara_keluar` 
WHERE b.`nama`='".$val[0]."'";
        break;
    case 'cmbPelaksana':
        $wil='';
        $sql="SELECT peg.id, peg.nama
                FROM b_ms_pegawai peg
                INNER JOIN b_ms_pegawai_unit pu ON pu.ms_pegawai_id = peg.id
                WHERE pu.unit_id = ".$val[0];
        break;
    case 'cmbApotek':
        $wil='';
        $sql = "SELECT u.UNIT_ID as id, u.UNIT_NAME as nama FROM $dbapotek.a_unit u WHERE u.UNIT_TIPE=2 AND u.UNIT_ISAKTIF=1";
        break;
	case 'cmbApotek_ruangan':
        $wil='';
		/*
        $sql = "SELECT au.UNIT_ID AS id, 'DEPO' AS nama FROM $dbapotek.a_unit au WHERE au.unit_billing = ".$val[0]." AND au.UNIT_ISAKTIF=1
				UNION
				SELECT u.UNIT_ID AS id, u.UNIT_NAME AS nama FROM $dbapotek.a_unit u WHERE u.UNIT_TIPE=2 AND u.UNIT_ISAKTIF=1";
		*/
		$sql = "SELECT u.UNIT_ID as id, u.UNIT_NAME as nama FROM $dbapotek.a_unit u WHERE u.UNIT_TIPE=2 AND u.UNIT_ISAKTIF=1";
        break;
    case 'cmbKsr':
        $wil = '';
        $sql = "SELECT DISTINCT mp.id,mp.nama
            FROM b_ms_pegawai_unit pu INNER JOIN b_ms_unit mu ON pu.unit_id=mu.id
            INNER JOIN b_ms_pegawai mp ON pu.ms_pegawai_id=mp.id
            WHERE mp.spesialisasi_id=0 AND mu.kategori=4
            AND (mu.jenis_layanan=".$val[0]." OR mu.jenis_layanan=0) ORDER BY mp.nama";
        break;
	case 'cmbKasir2':
        $wil = '';
        $sql = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit 
				WHERE b_ms_unit.kategori = 4 AND b_ms_unit.level = 2";
        break;
	case 'nmKsr':
		$wil = '';
		$sql = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai 
			INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai.id = b_ms_pegawai_unit.ms_pegawai_id
			INNER JOIN b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id
			WHERE b_ms_unit.id = ".$val[0]."
			GROUP BY b_ms_pegawai.nama
			ORDER BY b_ms_pegawai.nama";
		break;
    case 'cmbKasusIGD':
        $wil = '';
        $sql = "SELECT id,nama FROM b_ms_reference where stref=19";
        break;
    case 'cmbEmergency':
        $wil = '';
        $sql = "SELECT id,nama FROM b_ms_reference where stref=20";
        break;
    case 'cmbKondisiPasien':
        $wil = '';
        $sql = "SELECT id,nama FROM b_ms_reference where stref=21";
        break;
    case 'JnsLayanan3':
        $wil='';
        $sql="select id,nama from b_ms_unit where id = '27'";
        break;
    case 'TmpLayanan3':
        $wil='';
        $sql="select id, nama from b_ms_unit where aktif=1 and parent_id=".$val[0];
        break;
	case 'JnsLayNonInap':
		$wil='';
		$sql="SELECT id,nama FROM b_ms_unit WHERE LEVEL=1 AND inap!=1 AND aktif=1 AND kategori=2";
		break;
	case 'cmbDokSemua':
        $wil='';
		
		$sql="SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai
			INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id
			INNER JOIN b_ms_unit ON b_ms_unit.id = b_ms_pegawai_unit.unit_id
			WHERE b_ms_pegawai.spesialisasi_id <> 0 $fDok
			GROUP BY b_ms_pegawai.id
			ORDER BY b_ms_pegawai.nama";
		break;
    case 'JnsLayananBaru':
        $wil='';
        $sql="select id,nama from b_ms_unit where kategori=2 and aktif=1 and level=1";
        break;
	case 'TmpLayananBaru':
        $wil='';
		if($val[0]==0){  
			$fPel = "";
		}else{
			$fPel = "and parent_id=".$val[0]."";
		}
        $sql="select id, nama from b_ms_unit where aktif=1 AND kategori=2 $fPel order by nama";
        break;
	case 'cmbIsiDataRM':
        $wil='';
		/*if($val[0]==0){  
			$fPel = "";
		}else{
			$fPel = "and parent_id=".$val[0]."";
		}*/
        $sql="select id, nama from b_ms_isi_data_rm where aktif=1 AND stref=1 order by id";
        break;
}
//echo $sql."<br>";
if($loop!=1)
{
$rs=mysql_query($sql);
if($wil!='') {
    if($_REQUEST['id'] == 'AslMasuk') {
        ?>
<option value="">-<?php echo $wil;?>-</option>
        <?php
    }
    else {
        ?>
<option value="0" lang="0"><?php echo $wil;?></option>
        <?php
    }
}
if($_REQUEST["all"]==1 || $all == 'true') {
    ?>
<option value="0">SEMUA</option>
    <?php
}
if($_REQUEST['id']=="StatusPas") {
    ?>
<option value="1" label="UMUM"<?php if ($_REQUEST['defaultId']=="2") echo " selected";?>>UMUM</option>
<option value="2" label="JPKMKT"<?php if ($_REQUEST['defaultId']=="2") echo " selected";?>>JPKMKT</option>
    <?php
}
while($rw=mysql_fetch_array($rs)) {
    if($lang==true) {
        ?>
<option value="<?php echo $rw['id'];?>" label="<?php echo $rw['nama'];?>" lang="<?php echo $rw['lang'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
        <?php
    }else {
        ?>
<option value="<?php echo $rw['id'];?>" label="<?php echo $rw['nama'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
        <?php
    }
}
if ($_REQUEST['id']=="Retribusi"){
	if ($val[1]=="16" || $val[1]=="52" || $val[0]=="132"){
?>
<option value="3168" lang="0">-</option>
<?php
	}
}
}




mysql_free_result($rs);
mysql_close($konek);
?>
