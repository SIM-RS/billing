<?php
$userId=$_GET['userId'];
include("../koneksi/konek.php");
//include 'forAkun.php';
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id desc";
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];
//===============================

//=================================================================
$idPasien = $_REQUEST['idPasien'];
$idKunj = $_REQUEST['idKunj'];
$noRm = $_REQUEST['noRm'];
$noKTP = $_REQUEST['noKTP'];
$noBil = $_REQUEST['noBil'];
$nama = $_REQUEST['nama']; 
$namaOrtu = $_REQUEST['namaOrtu']; 
$namaSuTri = $_REQUEST['namaSuTri'];
$gender = $_REQUEST['gender']; 
$pend = $_REQUEST['pend']; 
$pek = $_REQUEST['pek'];
$agama = $_REQUEST['agama'];
$tglLhr = tglSQL($_REQUEST['tglLhr']); 
$thn = $_REQUEST['thn']; 
$bln = $_REQUEST['bln']; 
$hari = $_REQUEST['hari']; 
$tglKun = tglSQL($_REQUEST['tglKun']); 
$alamat = $_REQUEST['alamat'];
$telp = $_REQUEST['telp'];
$rt = $_REQUEST['rt'];
$rw = $_REQUEST['rw'];
$asalMsk = $_REQUEST['asalMsk']; 
$prop = $_REQUEST['prop']; 
$ket = $_REQUEST['ket']; 
$kab = $_REQUEST['kab']; 
$statusPas = $_REQUEST['statusPas']; 
$kec = $_REQUEST['kec']; 
$tglSJP = tglSQL($_REQUEST['tglSJP']);
$desa = $_REQUEST['desa']; 
$noSJP = $_REQUEST['noSJP']; 
$jnsLayanan = $_REQUEST['jnsLayanan']; 
$tmpLayanan = $_REQUEST['tmpLayanan']; 
$kelas = $_REQUEST['kelas']; 

$retribusi = $_REQUEST['retribusi'];
$tarip = $_REQUEST['tarip'];
$penjamin = $_REQUEST['penjamin']; 
$noAnggota = $_REQUEST['noAnggota']; 
$hakKelas = $_REQUEST['hakKelas']; 
$statusPenj = $_REQUEST['statusPenj'];

$diagAwal = $_REQUEST['diagAwal'];
if ($diagAwal=="") $diagAwal=0;
$kodeppk = $_REQUEST['kodeppk'];
$namaPKSO = $_REQUEST['namaPKSO'];
if ($namaPKSO=="") $namaPKSO=$nama;

$inap = $_REQUEST['inap'];
$kamar = $_REQUEST['kamar'];
$asal = $_GET['asal'];
$userLog = $_GET['userLog'];
$sqlRef = "select * from b_ms_reference where stref = 22";
$rsRef = mysql_query($sqlRef);
$rowRef = mysql_fetch_array($rsRef);
$ref = $rowRef['nama'];
$sqlRef = "select * from b_ms_reference where stref = 25";
$rsRef = mysql_query($sqlRef);
$rowRef = mysql_fetch_array($rsRef);
$loketRet = $rowRef['aktif'];
$noreg1 = $_REQUEST['noreg1'];
$darah = $_REQUEST['darah'];
$puskesmas = $_REQUEST['pusk'];
$kw = $_REQUEST['kw'];
$cabang = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1 ;
mysql_free_result($rsRef);

//tarif pake f = untuk reference/acuan prosentase yang dimasukan ke b_tindakan_komponen
//tarip pake p = variabel dengan isi kiriman dari form registrasi,yang berupa nilai tindakan/retribusi
$tarif=",b.tarip";
if($ref=='1') {
    $tarif=",b.tarip_prosen*".($tarip/100);
}

//query untuk mengambil data no bill, bila tidak ada data maka no bill diset data terkecil (1)
//query belum diaktifkan karena tipe tabel no_billing di tabel b_kunjungan bigint,query ini apa digunakan waktu update?
//=================================================================

if($_REQUEST['forKonfirmasi'] == 'true'){
	$sql = "SELECT no_rm, nama FROM b_ms_pasien WHERE id = '".$_REQUEST['fPasienID']."'";
	$query = mysql_query($sql);
	$rows = mysql_fetch_array($query);
	echo $rows['no_rm']."|".$rows['nama'];
	return;
}

function cekBayar($idTindakan){
	$sTindakan = "select bayar, lunas from b_tindakan where id = '{$idTindakan}'";
	$qTindakan = mysql_query($sTindakan);
	$data = mysql_fetch_array($qTindakan);
	
	$hasil = array('bayar'=>$data['bayar'], 'lunas'=>$data['lunas']);
	return $hasil;
}

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'jamkeskah':
        $query = "SELECT k.id
    FROM b_kunjungan k
    inner join b_pelayanan pl on k.id = pl.kunjungan_id
    INNER JOIN b_ms_pasien p ON k.pasien_id=p.id
    INNER JOIN b_ms_unit u ON pl.jenis_layanan=u.id
    INNER JOIN b_ms_kso s ON k.kso_id=s.id
    inner join b_tindakan_kamar tk on tk.pelayanan_id = pl.id
    WHERE k.id='$idKunj' order by pl.id limit 1";
        $rs = mysql_query($query);
        $res = mysql_num_rows($rs);
        echo $res;
        mysql_free_result($rs);
        return;
        break;
    case 'inapkah':
        $query = "select inap from b_ms_unit where id = ".$_GET['id'];
        $rs = mysql_query($query);
        $row = mysql_fetch_array($rs);
        echo $row['inap'];
        mysql_free_result($rs);
        return;
        break;
    case 'getnorm':
    //$query = "select max(no_rm)+1 as no_rm from b_ms_pasien";
        $query="select ifnull(max(no_rm)+1,1) as next_no_rm from b_ms_pasien where length(no_rm)=8 and cabang_id = '{$cabang}'";
        $rs = mysql_query($query);
        $row = mysql_fetch_array($rs);
        $noRm=$row['next_no_rm'];
        if ($noRm=="10000000") {
            $query="select ifnull(max(no_rm)+1,1) as next_no_rm from b_ms_pasien where length(no_rm)=8 and cabang_id = '{$cabang}'";
            $rs = mysql_query($query);
            $row = mysql_fetch_array($rs);
            $noRm=$row['next_no_rm'];
        }else {
            if (strlen($noRm)<8) {
                for ($i=strlen($noRm);$i<8;$i++) {
                    $noRm="0".$noRm;
                }
            }
        }
        //echo $row['no_rm'];
        printf("%07s",$noRm);
        mysql_free_result($rs);
        return;
        break;
    case 'getnobilling':
        $sqlBil = "select ifnull(max(no_billing)+1,1) as no_billing from b_kunjungan";
        $rsBil = mysql_query($sqlBil);
        $rowBil = mysql_fetch_array($rsBil);
        echo $rowBil['no_billing'];
        mysql_free_result($rsBil);
        return;
        break;
    case 'getkamar':
        $kunjungan_id = $_GET['kunjungan_id'];
        $sql = "select kamar_id
                from b_tindakan_kamar
                where id =
                (select min(k.id)
                from b_tindakan_kamar k inner join b_pelayanan p on k.pelayanan_id = p.id
                where kunjungan_id = '$kunjungan_id')";
        $rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        echo $row['kamar_id'];
        mysql_free_result($rs);
        return;
        break;
    case 'tambah':
    //$rs=mysql_query("select * from b_ms_pasien where id='".$idPasien."' limit 0,10");
        if($idPasien=="") {
            $query="select * from b_ms_pasien where no_rm='".$noRm."' and cabang_id = '{$cabang}' limit 0,10";
            $rs = mysql_query($query);
            if (mysql_num_rows($rs)<=0) {
                if (strlen($noRm)<8) {
                    for ($i=strlen($noRm);$i<8;$i++) {
                        $noRm="0".$noRm;
                    }
                }
            }else {
                $query="select ifnull(max(no_rm)+1,1) as next_no_rm from b_ms_pasien where length(no_rm)=8 and cabang_id = '{$cabang}'";
                $rs = mysql_query($query);
                $row = mysql_fetch_array($rs);
                $noRm=$row['next_no_rm'];
                if ($noRm=="10000000") {
                    $query="select ifnull(max(no_rm)+1,1) as next_no_rm from b_ms_pasien where length(no_rm)=8 and cabang_id = '{$cabang}'";
                    $rs = mysql_query($query);
                    $row = mysql_fetch_array($rs);
                    $noRm=$row['next_no_rm'];
                }
                else {
                    if (strlen($noRm)<8) {
                        for ($i=strlen($noRm);$i<8;$i++) {
                            $noRm="0".$noRm;
                        }
                    }
                }
            }
            mysql_free_result($rs);
			
            $sqlTambah="insert into b_ms_pasien (no_rm,no_ktp,nama,sex,agama,tgl_lahir,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,telp,pendidikan_id,pekerjaan_id,nama_ortu,nama_suami_istri,user_act,tgl_act,gol_darah,id_kw,cabang_id) values('$noRm','$noKTP','$nama','$gender','$agama','$tglLhr','$alamat','$rt','$rw','$desa','$kec','$kab','$prop','$telp','$pend','$pek','$namaOrtu','$namaSuTri','$userId','$tglact','$darah','$kw',$cabang)";
            $rs=mysql_query($sqlTambah);
            $sqlCek="select max(id) as id from b_ms_pasien where user_act='$userId' and cabang_id = '{$cabang}'";
            $rsCek=mysql_query($sqlCek);
            $rw=mysql_fetch_array($rsCek);
            $idPasien=$rw['id'];
            $isBaru=1;
			//echo $sqlTambah;
        }
        else {
			if ($inap == 0){
				$sql="SELECT p.id FROM b_pelayanan p 
						INNER JOIN b_kunjungan k 
							ON p.kunjungan_id=k.id 
						   AND k.cabang_id = '{$cabang}' 
						WHERE p.pasien_id='$idPasien' 
						  AND p.unit_id='$tmpLayanan' 
						  AND p.jenis_layanan<>'44' 
						  AND p.tgl='$tglKun'";
			}else{
				$sql="SELECT p.id FROM b_pelayanan p 
						INNER JOIN b_kunjungan k 
							ON p.kunjungan_id=k.id 
						   AND k.cabang_id = '{$cabang}' 
						WHERE p.pasien_id='$idPasien' 
						  AND p.unit_id='$tmpLayanan'
						  AND k.pulang='0'";
			}
			//echo $sql."<br>";
			$rsChk=mysql_query($sql);
			if (mysql_num_rows($rsChk)>0){
				echo "0".chr(5).chr(4).chr(5)."SudahAda";
				mysql_free_result($rsChk);
				return;
			}
			
            $sqlUpdate="update b_ms_pasien set nama='$nama',sex='$gender',agama='$agama',tgl_lahir='$tglLhr',alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',telp='$telp',".(($pend=='0')?'':"pendidikan_id='$pend',").(($pek=='0')?'':"pekerjaan_id='$pek',")."nama_ortu='$namaOrtu',nama_suami_istri='$namaSuTri',no_ktp='$noKTP', gol_darah='$darah', id_kw='$kw' 
			where id=$idPasien AND cabang_id = '{$cabang}'";
            //echo $sqlUpdate."<br>";
            mysql_query($sqlUpdate);
            $isBaru=0;
        }

        $sqlCekKso="select * from b_ms_kso_pasien where pasien_id=$idPasien";
        //echo $sqlCekKso."<br>";
        $rsCekKso=mysql_query($sqlCekKso);
        if(mysql_num_rows($rsCekKso)==0) {
            $sqlGetKso="select id,kode from b_ms_kso where id=$statusPas";
            //echo $sqlGetKso."<br>";
            $rsGetKso=mysql_query($sqlGetKso);
            $rwGetKso=mysql_fetch_array($rsGetKso);

            $sqlInsertKso="insert into b_ms_kso_pasien(kso_id,pasien_id,kelas_id,kodepenjamin,no_anggota,st_anggota,nama_peserta,kode_ppk,kodepersonel,tgl_act)
			values ($statusPas,$idPasien,$hakKelas,'".$rwGetKso['kode']."','$noAnggota','$statusPenj','$namaPKSO','$kodeppk',$userId,'$tglact')";
            //echo $sqlInsertKso."<br>";
            $rsInsertKso=mysql_query($sqlInsertKso);
            mysql_free_result($rsGetKso);
        }elseif($statusPas=="4" && $kodeppk!=""){
			$sqlUpdateKso="update b_ms_kso_pasien set kso_id=$statusPas,kelas_id=$hakKelas,no_anggota='$noAnggota',st_anggota='$statusPenj',nama_peserta='$namaPKSO',kode_ppk='$kodeppk' where pasien_id=$idPasien";
			//echo $sqlUpdateKso."<br>";
			$rsUpdateKso=mysql_query($sqlUpdateKso);
		}
        mysql_free_result($rsCekKso);

        if($thn==0 || $thn == 1) {
            $tglNow=explode(' ',$tglact);
            $query = "SELECT DATEDIFF('$tglNow[0]','$tglLhr') AS selisih";
            $rs = mysql_query($query);
            $row = mysql_fetch_array($rs);
            if($row['selisih'] < 29) {
                $filterKelUmur = "206";
            }
            else if($row['selisih'] < 365) {
                $filterKelUmur="207";
            }
            else {
                $filterKelUmur = '208';
            }
            mysql_free_result($rs);
        }
        elseif($thn>=1 && $thn<=4) {
            $filterKelUmur="208";
        }
        elseif($thn>=5 && $thn<=14) {
            $filterKelUmur="209";
        }
        elseif($thn>=15 && $thn<=24) {
            $filterKelUmur="210";
        }
        elseif($thn>=25 && $thn<=44) {
            $filterKelUmur="211";
        }
        elseif($thn>=45 && $thn<=64) {
            $filterKelUmur="212";
        }
        else {
            $filterKelUmur="213";
        }

        $sqlBil = "select IFNULL(MAX(no_billing)+1,1) as no_billing from b_kunjungan";
        $rsBil = mysql_query($sqlBil);
        $rowBil = mysql_fetch_array($rsBil);
        $noBil = $rowBil['no_billing'];
        mysql_free_result($rsBil);
		
		$strNoSJP="'$noSJP'";
		if ($statusPas==53 && $tglKun>"2011-08-31"){
			$strNoSJP="fGetMaxNoJPersal('$tglKun')";
		}
		if ($statusPas==46){
			$strNoSJP="fGetMaxNoJamkesda('$tglKun')";
		}
		
        $sqlKunj="insert into b_kunjungan (no_billing,loket_id,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,retribusi,tgl,umur_thn,umur_bln,umur_hr,kel_umur,kelas_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,status_penj,nama_peserta,diag_awal,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,isbaru,tgl_act,user_act,no_reg,cabang_id) values ('$noBil','$asal',$idPasien,$asalMsk,'$ket',$jnsLayanan,$tmpLayanan,'$retribusi','$tglKun','$thn','$bln','$hari','".$filterKelUmur."','$kelas','$statusPas','$hakKelas','$tglSJP',$strNoSJP,'$noAnggota','$statusPenj','$namaPKSO','$diagAwal',$pend,$pek,'$alamat','$rt','$rw','$desa','$kec','$kab','$prop',$isBaru,NOW(),$userId,'$noreg1',{$cabang})";
       //echo $sqlKunj."<br>";
        $rsKunj=mysql_query($sqlKunj);
		if (mysql_affected_rows()>0){
			$sqlGetKunj="select max(id) as id, unit_id from b_kunjungan where pasien_id=$idPasien and user_act=$userId and cabang_id = '{$cabang}'";
			//echo $sqlGetKunj."<br>";
			$rsGetKunj=mysql_query($sqlGetKunj);
			$rwGetKunj=mysql_fetch_array($rsGetKunj);
			$kunjungan_id=$rwGetKunj['id'];
			$mcu_id=$rwGetKunj['unit_id'];
			$idKunj=$kunjungan_id;
			
			if($mcu_id==189){
			
			$sqlPelayanan="insert into b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan) values 
			((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$mcu_id','".$rwGetKunj['id']."',$jnsLayanan,'2',$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."'),
			((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$mcu_id','".$rwGetKunj['id']."',$jnsLayanan,'156',$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."'),
			((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$mcu_id','".$rwGetKunj['id']."',$jnsLayanan,'17',$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."'),
			((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$mcu_id','".$rwGetKunj['id']."',$jnsLayanan,'61',$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."'),
			((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$mcu_id','".$rwGetKunj['id']."',$jnsLayanan,'58',$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."')";
			mysql_query($sqlPelayanan);
			//echo $sqlPelayanan;
						
			}
			
			/* Save asal rujukan/masuk Puskesmas/RS */
			$sqlAR = "insert into b_asal_masuk_kunjungan(idKunj, puskesmas, rumahsakit, tgl_act, user_act) value ({$idKunj},'{$puskesmas}','{$rumahsakit}', NOW(), {$userId})";
			$queryAR = mysql_query($sqlAR);
			
			$cJenisKunj=1;
			if ($inap == 1){
				$cJenisKunj=3;
			}else if ($jnsLayanan=="44"){
				$cJenisKunj=2;
			}
			
			$sqlPelayanan="insert into b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan) values ((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$asal','".$rwGetKunj['id']."',$jnsLayanan,$tmpLayanan,$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."')";
			//echo $sqlPelayanan."<br>";
			mysql_query($sqlPelayanan);
			if (mysql_errno()==0){
				$sqlGetpel="select max(id) as id from b_pelayanan where kunjungan_id='".$rwGetKunj['id']."' and user_act=$userId";
				//echo $sqlGetpel."<br>";
				$rsGetPel=mysql_query($sqlGetpel);
				$rwGetPel=mysql_fetch_array($rsGetPel);
				//$tarif_akun = 0;
				if($inap == 0) {
					$sqlGetTin="SELECT a.*,b.`ak_ms_unit_id` FROM b_ms_tindakan_kelas a
INNER JOIN b_ms_tindakan b ON a.`ms_tindakan_id`=b.`id`		
					where a.ms_tindakan_id='$retribusi' and a.ms_kelas_id=$kelas";
					//echo $sqlGetTin;
					$rsGetTin=mysql_query($sqlGetTin);
					$rwGetTin=mysql_fetch_array($rsGetTin);
					$beban_kso = 0;
					$beban_pasien = 0;
					$bayar_pasien = 0;
					$bayar_kso = 0;
					$bayar = 0;
					$lunas = 0;
		
					if($statusPas == 4) {
						$sqlGetTin = "select nilai
							from b_ms_kso_paket_detail pd inner join b_ms_kso_paket kp on kp.id=pd.kso_paket_id
							where pd.ms_tindakan_id = '$retribusi' and kp.kso_id = 4";
						//echo $sqlGetTin."<br>";
						$rsGetRetKSO=mysql_query($sqlGetTin);
						if(mysql_num_rows($rsGetRetKSO) > 0) {
							$rwGetRetKSO=mysql_fetch_array($rsGetRetKSO);
							$beban_kso = $rwGetRetKSO['nilai'];
							//$bayar = 0;
							//$lunas = 0;
						}
						else {
							//$beban_kso = 0;
							$beban_pasien = $tarip;
							if ($loketRet==1){
								$bayar = $tarip;
								$bayar_pasien = $tarip;
								$lunas = 1;
							}
						}
						mysql_free_result($rsGetRetKSO);
					}
					else if($statusPas == '1') {
						$beban_pasien = $tarip;
						if ($loketRet==1){
							$bayar = $tarip;
							$bayar_pasien = $tarip;
							$lunas = 1;
						}
					}
					else {
						$beban_kso = $tarip;
						//$bayar = 0;
						//$lunas = 0;
					}
		
					//if ($jnsLayanan!="44"){
					if($tarip != 0) {
						//insert ke tindakan komponen
						$sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) values('".$rwGetTin['id']."','".$tmpLayanan."','".$rwGetTin['ak_ms_unit_id']."','".$cJenisKunj."','".$rwGetKunj['id']."',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun',".$tarip.",'$beban_pasien','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
						//echo $sqlRetribusi."<br>";
						mysql_query($sqlRetribusi);
							if (mysql_errno()==0){
								$getIdTind="select max(id) as id from b_tindakan where pelayanan_id='".$rwGetPel['id']."' and kunjungan_id='".$rwGetKunj['id']."' and user_act=$userId";
								//echo $getIdTind."<br/>";
								$rsIdTind=mysql_query($getIdTind);
								$rwIdTind=mysql_fetch_array($rsIdTind);
				
								$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind['id']."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b 
								inner join b_ms_komponen k on b.ms_komponen_id=k.id
								where b.ms_tindakan_kelas_id='".$rwGetTin['id']."'";
								//echo $sqlTambah."<br>";
								mysql_query($sqlTambah);
							}else{
								$statusProses='Error';
							}
					} 

					
						 
						 if($retribusi==1315 || $retribusi==1316){
						  
						 //Insert Retribusi SKD
						 		$sqlR = "SELECT b.`tarip` tarip_ret ,b.id as ms_tindakan_kelas_id, a.* FROM b_ms_tindakan a
									INNER JOIN `b_ms_tindakan_kelas` b ON a.`id`=b.`ms_tindakan_id`
									INNER JOIN `b_ms_tindakan_unit` c ON c.`ms_tindakan_kelas_id`=b.`id`
									WHERE c.`ms_unit_id`='$tmpLayanan' AND a.`kel_tindakan_id`=66";
									//echo $sqlR;
									$sqlR1=mysql_query($sqlR);
									$sqlR2=mysql_fetch_array($sqlR1);
									$taripR = $sqlR2['tarip_ret'];
									$KlsIdR = $sqlR2['ms_tindakan_kelas_id'];
									
									if($statusPas==1){
										$BiayaRP = $taripR;
										$BiayaRK = 0;
									}else{
										$BiayaRP = 0;
										$BiayaRK = $taripR;
									}
									
								  $sqlRet="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) values('".$KlsIdR."','".$tmpLayanan."','".$sqlR2['ak_ms_unit_id']."','".$cJenisKunj."','".$rwGetKunj['id']."',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun',".$taripR.",'$BiayaRP','$BiayaRK','0','0','0','0','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
							//echo $sqlRetribusi."<br>";
							mysql_query($sqlRet);
							
								if (mysql_errno()==0){
									$getIdTindR="select max(id) as id from b_tindakan where pelayanan_id='".$rwGetPel['id']."' and kunjungan_id='".$rwGetKunj['id']."' and user_act=$userId";
									//echo $getIdTind."<br/>";
									$rsIdTindR=mysql_query($getIdTindR);
									$rwIdTindR=mysql_fetch_array($rsIdTindR);
					
									$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTindR['id']."',k.id,k.nama ,$taripR,b.tarip_prosen FROM b_ms_tindakan_komponen b 
									inner join b_ms_komponen k on b.ms_komponen_id=k.id
									where b.ms_tindakan_kelas_id='".$KlsIdR."'";
									//echo $sqlTambah."<br>";
									mysql_query($sqlTambah);
								}else{
									$statusProses='Error';
								}
						 
						 
						 //END Insert Retribusi SKD
						 
						 }else{
						 
						 		//START insert tindakan konsultasi
								$sqlKonsul = "SELECT b.`tarip` tarip_konsul ,b.id as ms_tindakan_kelas_id, a.* FROM b_ms_tindakan a
												INNER JOIN `b_ms_tindakan_kelas` b ON a.`id`=b.`ms_tindakan_id`
												INNER JOIN `b_ms_tindakan_unit` c ON c.`ms_tindakan_kelas_id`=b.`id`
												WHERE c.`ms_unit_id`='$tmpLayanan' AND a.id<>840 AND a.`kel_tindakan_id`=151";
								//echo $sqlKonsul;
								$sqlKonsul1=mysql_query($sqlKonsul);
								$sqlKonsul2=mysql_fetch_array($sqlKonsul1);
								$taripKonsul = $sqlKonsul2['tarip_konsul'];
								$KlsIdKonsul = $sqlKonsul2['ms_tindakan_kelas_id'];
									
								
									
										if($taripKonsul != 0) { 
									   
											if($statusPas==1){
												$BiayaKonsulP = $taripKonsul;
												$BiayaKonsulK = 0;
											}else{
												$BiayaKonsulP = 0;
												$BiayaKonsulK = $taripKonsul;
											}
											
											$sqlKOnsultasi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) values('".$KlsIdKonsul."','".$tmpLayanan."','".$sqlKonsul2['ak_ms_unit_id']."','".$cJenisKunj."','".$rwGetKunj['id']."',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun',".$taripKonsul.",'$BiayaKonsulP','$BiayaKonsulK','0','0','0','0','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
									//	echo $sqlKOnsultasi."<br>";
										mysql_query($sqlKOnsultasi);
											if (mysql_errno()==0){
												$getIdTind1="select max(id) as id from b_tindakan where pelayanan_id='".$rwGetPel['id']."' and kunjungan_id='".$rwGetKunj['id']."' and user_act=$userId";
												//echo $getIdTind."<br/>";
												$rsIdTind1=mysql_query($getIdTind1);
												$rwIdTind1=mysql_fetch_array($rsIdTind1);
								
												$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind1['id']."',k.id,k.nama ,$taripKonsul,b.tarip_prosen FROM b_ms_tindakan_komponen b 
												inner join b_ms_komponen k on b.ms_komponen_id=k.id
												where b.ms_tindakan_kelas_id='".$KlsIdKonsul."'";
											//	echo $sqlTambah."<br>";
												mysql_query($sqlTambah);
											}else{
												$statusProses='Error';
											}
									
									} 
						 //END insert tindakan konsultasi
						 
						 
						 
						 }
					
					
		
					if($statusPas==1 && $tarip != '0' && $loketRet==1 && $statusProses!='Error') {
						$sqlRetribusi = "insert into b_bayar
								(kunjungan_id,kasir_id,nobukti,tgl,dibayaroleh,ket,tagihan,nilai,keringanan,titipan,tgl_act,user_act,titipan_terpakai,tipe)
								values
								('".$rwGetKunj['id']."','$asal','$noBil','$tglKun','$nama','','$tarip','$tarip',0,0,now(),'$userId',0,0)";
						mysql_query($sqlRetribusi);
						if (mysql_errno()==0){
							$sqlGetIdBayar = "select max(id) as id from b_bayar where kunjungan_id='".$rwGetKunj['id']."' and user_act = '$userId'";
							$rsGetIdBayar = mysql_query($sqlGetIdBayar);
							$rowGetIdBayar = mysql_fetch_array($rsGetIdBayar);
			
							$sqlRetribusi = "insert into b_bayar_tindakan (bayar_id,tindakan_id,nilai) values ('".$rowGetIdBayar['id']."', '".$rwIdTind['id']."', '$tarip')";
							mysql_query($sqlRetribusi);
							//mysql_free_result($rsIdTind);
							mysql_free_result($rsGetIdBayar);
						}else{
							$statusProses='Error';
						}
					}
					//}
					mysql_free_result($rsGetTin);
					//$tarif_akun = $tarip;
				}
				else {
					$sqlCekInap="SELECT mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.id=".$rwGetPel['id'];
					$rsCekIsInap=mysql_query($sqlCekInap);
					$rwCekIsInap=mysql_fetch_array($rsCekIsInap);
					if ($rwCekIsInap["inap"]==1){
						$sqlKamar = "SELECT kode,nama,tarip,kelas_id FROM b_ms_kamar mk INNER JOIN b_ms_kamar_tarip mkt ON mk.id=mkt.kamar_id WHERE mk.id = '$kamar' AND mkt.kelas_id='$kelas'";
						//echo $sqlKamar."<br>";
						$rsKamar = mysql_query($sqlKamar);
						$rowKamar = mysql_fetch_array($rsKamar);
			
						$beban_kso = 0;
						$beban_pasien = 0;
			
						$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id' and cabang_id = '{$cabang}'";
						//echo $sqlCekStat."<br>";
						$rsCekStat = mysql_query($sqlCekStat);
						$rowCekStat = mysql_fetch_array($rsCekStat);
						//echo $rowCekStat['kso_id']."<br>";
						if($rowCekStat['kso_id'] == 1) {
							$beban_pasien = $rowKamar['tarip'];
						}
						else {
							$beban_kso = $rowKamar['tarip'];
						
								if($jnsLayanan != '94' && $tmpLayanan!='48' && $tmpLayanan!='112') {
									$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
									$rsHp = mysql_query($sqlHp);
									if(mysql_num_rows($rsHp) > 0) {
										$rowHp = mysql_fetch_array($rsHp);
										$beban_kso = $rowHp['jaminan'];
									}else{
										$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$tmpLayanan."' AND kelas_id = '".$rowCekStat['kso_kelas_id']."'";
										$rsBKso = mysql_query($sqlBKso);
										if (mysql_num_rows($rsBKso) > 0){
											$rowBKso = mysql_fetch_array($rsBKso);
											if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
												$beban_kso = $rowBKso['tarip'];
											}
										}else{
											$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$rowCekStat['kso_kelas_id']."'";
											$rsBKso = mysql_query($sqlBKso);
											if (mysql_num_rows($rsBKso) > 0){
												$rowBKso = mysql_fetch_array($rsBKso);
												if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
													$beban_kso = $rowBKso['tarip'];
												}
											}
										}
										mysql_free_result($rsBKso);
									}
									//echo "kso=".$rowCekStat['kso_id'].",hak_kelas=".$rowCekStat['kso_kelas_id'].",kelas=".$kelasnya;
									if (($rowCekStat['kso_id']==4) && ($rowCekStat['kso_kelas_id']==3) && ($kelas==2)){
										$beban_pasien = 100000;
									}elseif(($biaya > $beban_kso) && ($rowCekStat['kso_kelas_id'] != $kelas)) {
										$beban_pasien = $biaya-$beban_kso;
									}
								}
								else {
									$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '10' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
									$rsHp = mysql_query($sqlHp);
									if(mysql_num_rows($rsHp) > 0) {
										$rowHp = mysql_fetch_array($rsHp);
										$beban_kso = $rowHp['jaminan'];
									}
								}
							// ============================================
						}
			
						$sqlKamar = "insert into b_tindakan_kamar (pelayanan_id, unit_id_asal, kso_id, tgl_in, kamar_id, kode, nama, tarip, beban_pasien, beban_kso, kelas_id,aktif)
								values ('".$rwGetPel['id']."','".$asal."','".$statusPas."', CONCAT('$tglKun',' ',CURRENT_TIME()), '$kamar', '".$rowKamar['kode']."', '".$rowKamar['nama']."', '".$rowKamar['tarip']."', '$beban_pasien', '$beban_kso', '".$rowKamar['kelas_id']."','0')";
						//echo $sqlKamar."<br>";
						$rsKamar = mysql_query($sqlKamar);
						if (mysql_errno()>0){
							$statusProses='Error';
						}
	
						//mysql_free_result($rsKamar);
					}
				}
			}else{
				//echo "2";
				$statusProses='Error';
			}
		}else{
			//echo "3";
			$statusProses='Error';
		}

        /*if($tarip>0 && $inap == 0){
		  $tarif_perda = $tarip;
		  $tarif_pk = $beban_kso.'|'.$beban_pasien;
		  
		  //forAkun('add',$tarif_perda.'|'.$tarif_pk,'reg',$asal,$noBil.'.'.$asal,$jnsLayanan,$tmpLayanan,$statusPas);
	   }*/
        break;
    case 'hapus':
        $sqlCek = "select * from b_pelayanan where kunjungan_id = '$idKunj' and dilayani = 1";
        //echo $sqlCek."<br>";
        $rsCek = mysql_query($sqlCek);

        if(mysql_num_rows($rsCek) <= 0) {
            $sql = "select 
				concat(no_billing,'.',k.loket_id) as no_billing,
				k.jenis_layanan,
				k.unit_id,
				k.kso_id
				from b_kunjungan k
				inner join b_pelayanan p on k.id = p.kunjungan_id
				where k.id = '$idKunj'
				order by p.id asc
				limit 1";
            $rs = mysql_query($sql);
            $row = mysql_fetch_array($rs);
            $no_billing = $row['no_billing'];
            $jenis_layanan = $row['jenis_layanan'];
            $unit_id = $row['unit_id'];
            $kso_id = $row['kso_id'];
            $biaya_perda = $row['biaya'];
            $biaya_pk = $row['biaya_pk'];

			//if ($loketRet==1){
				$sqlHapusBayar = "delete from b_bayar_tindakan where bayar_id = (select id from b_bayar where kunjungan_id = '$idKunj')";
				mysql_query($sqlHapusBayar);
	
				$sqlHapusBayar = "delete from b_bayar where kunjungan_id = '$idKunj'";
				mysql_query($sqlHapusBayar);
			//}

            $sqlHapusBayar = "delete from b_tindakan_kamar where pelayanan_id in (select id from b_pelayanan where kunjungan_id = '$idKunj')";
            mysql_query($sqlHapusBayar);

            $sqlHapusPel="delete from b_pelayanan where kunjungan_id='".$idKunj."'";
            mysql_query($sqlHapusPel);

            $sqlHapus="delete from b_kunjungan where id='".$idKunj."'";
            mysql_query($sqlHapus);
		  //echo $no_billing.'|'.$jenis_layanan.'|'.$unit_id.'|'.$kso_id.'|'.$biaya_perda.'|'.$biaya_pk;
            //forAkun('del',$no_billing.'|'.$jenis_layanan.'|'.$unit_id.'|'.$kso_id.'|'.$biaya_perda.'|'.$biaya_pk,'reg',$asal,$no_billing.'.'.$asal,$jenis_layanan,$unit_id,$kso_id);
        }
        break;
    case 'simpan':
        $prev_inap = $_GET['prev_inap'];
        $prev_retribusi = $_GET['prev_retribusi'];
		$prev_tmpLayanan = $_GET['prev_tmpLayanan'];
        $prev_stat = $_GET['prev_stat'];
        $statusPenj = $_GET['statusPenj'];
		

        if($thn==0 || $thn == 1) {
            $tglNow=explode(' ',$tglact);
            $query = "SELECT DATEDIFF('$tglNow[0]','$tglLhr') AS selisih";
            $rs = mysql_query($query);
            $row = mysql_fetch_array($rs);
            if($row['selisih'] < 29) {
                $filterKelUmur = "206";
            }
            else if($row['selisih'] < 365) {
                $filterKelUmur="207";
            }
            else {
                $filterKelUmur = '208';
            }
            mysql_free_result($rs);
        }
        elseif($thn>=1 && $thn<=4) {
            $filterKelUmur="208";
        }
        elseif($thn>=5 && $thn<=14) {
            $filterKelUmur="209";
        }
        elseif($thn>=15 && $thn<=24) {
            $filterKelUmur="210";
        }
        elseif($thn>=25 && $thn<=44) {
            $filterKelUmur="211";
        }
        elseif($thn>=45 && $thn<=64) {
            $filterKelUmur="212";
        }
        else {
            $filterKelUmur="213";
        }

        $sqlUpdate="update b_ms_pasien set no_ktp='$noKTP',nama='$nama',sex='$gender',agama='$agama',tgl_lahir='$tglLhr',alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',telp='$telp',pendidikan_id='$pend',pekerjaan_id='$pek',nama_ortu='$namaOrtu',nama_suami_istri='$namaSuTri',user_act=$userId,tgl_act='$tglact',gol_darah='$darah',id_kw='$kw' where id=$idPasien and cabang_id = '{$cabang}'";
		//$sqlUpdate."<br>";
        mysql_query($sqlUpdate);
		if (mysql_errno()==0){
			if ($statusPas!="1" && $statusPas!="39" && $statusPas!="46") {
				$sqlUpdateKso="SELECT * FROM b_ms_kso_pasien WHERE pasien_id='$idPasien'";
				//echo $sqlUpdateKso."<br>";
				$rsUpdateKso=mysql_query($sqlUpdateKso);
				if (mysql_num_rows($rsUpdateKso)>0) {
					$sqlUpdateKso="update b_ms_kso_pasien set kso_id=$statusPas,kelas_id=$hakKelas,no_anggota='$noAnggota',st_anggota='$statusPenj',nama_peserta='$namaPKSO' where pasien_id=$idPasien";
					//echo $sqlUpdateKso."<br>";
					$rsUpdateKso=mysql_query($sqlUpdateKso);
				}else {
					$sqlUpdateKso="INSERT INTO b_ms_kso_pasien(kso_id,pasien_id,kelas_id,no_anggota,st_anggota,nama_peserta,kode_ppk)
					VALUES($statusPas,$idPasien,$hakKelas,'$noAnggota','$statusPenj','$namaPKSO','$kodeppk')";
					//echo $sqlUpdateKso."<br>";
					$rsInKso=mysql_query($sqlUpdateKso);
				}
			}
	
			$sqlGetTin="select IFNULL(MIN(id),0) as id from b_tindakan where kunjungan_id=$idKunj";
			//echo $sqlGetTin."<br>";
			$rsGetTin=mysql_query($sqlGetTin);
			$rwGetTin=mysql_fetch_array($rsGetTin);
	
			$sqlGetpel = "select id,dilayani from b_pelayanan where kunjungan_id = '$idKunj' and dilayani=1";
			//"select min(id) as id from b_pelayanan where kunjungan_id = $idKunj";
			// echo $sqlGetpel."<br>";
			$rsGetPel=mysql_query($sqlGetpel);
	
			//data hanya bisa diubah jika belum dilayani
			if(mysql_num_rows($rsGetPel)<=0) {
				/*$sqlGetpel = "select min(id) as id, from b_pelayanan where kunjungan_id = '$idKunj'";*/
				$sqlGetpel="SELECT id,unit_id FROM b_pelayanan WHERE kunjungan_id = '$idKunj' ORDER BY id LIMIT 1";
				// echo $sqlGetpel."<br>";
				$rsGetPel2=mysql_query($sqlGetpel);
				$rwGetPel=mysql_fetch_array($rsGetPel2);
	
				$sqlGetStat = "select * from b_kunjungan where id = '$idKunj' and cabang_id = '{$cabang}'";
				// echo $sqlGetStat."<br>";
				$rsGetStat = mysql_query($sqlGetStat);
				$rowGetStat = mysql_fetch_array($rsGetStat);
				
				$strNoSJP="'$noSJP'";
				if ($statusPas==6 && $rowGetStat["kso_id"]!=53 && $tglKun>"2011-08-31"){
					$strNoSJP="fGetMaxNoJPersal('$tglKun')";
				}
				if ($statusPas==6 && $rowGetStat["kso_id"]!=46){
					$strNoSJP="fGetMaxNoJamkesda('$tglKun')";
				}
				
	
				/*$sqlSimpan="update b_kunjungan set pasien_id=$idPasien,asal_kunjungan=$asalMsk,ket='$ket',jenis_layanan=$jnsLayanan,unit_id=$tmpLayanan,retribusi='$retribusi',tgl='$tglKun',umur_thn='$thn',umur_bln='$bln',kelas_id='$kelas',kso_id=$statusPas,kso_kelas_id='$hakKelas',tgl_sjp='$tglSJP',no_sjp='$noSJP',no_anggota='$noAnggota',status_penj='$statusPenj',nama_peserta='$namaPKSO',pendidikan_id=$pend,pekerjaan_id=$pek,alamat='$alamat',rt='$rt',rw='$rw',desa_id=$desa,kec_id=$kec,kab_id=$kab,prop_id=$prop,kel_umur='$filterKelUmur' where id=$idKunj";*/
				$sqlSimpan="update b_kunjungan set pasien_id=$idPasien,asal_kunjungan=$asalMsk,ket='$ket',jenis_layanan=$jnsLayanan,unit_id=$tmpLayanan,retribusi='$retribusi',tgl='$tglKun',umur_thn='$thn',umur_bln='$bln',umur_hr='$hari',kelas_id='$kelas',kso_id=$statusPas,kso_kelas_id='$hakKelas',tgl_sjp='$tglSJP',no_sjp=$strNoSJP,no_anggota='$noAnggota',status_penj='$statusPenj',nama_peserta='$namaPKSO',pendidikan_id=$pend,pekerjaan_id=$pek,alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',kel_umur='$filterKelUmur',no_reg='$noreg1' where id=$idKunj and cabang_id = '{$cabang}'";
				// echo $sqlSimpan."<br>";
				$rs=mysql_query($sqlSimpan);
				if (mysql_errno()==0){
				
					$sqlAR = "update b_asal_masuk_kunjungan
								set puskesmas = '{$puskesmas}', 
									rumahsakit = '{$rumahsakit}',
									tgl_act = NOW(),
									user_act = {$userId}
								where idKunj = {$idKunj}";
					// echo $sqlAR;
					$queryAR = mysql_query($sqlAR);
				
					$cJenisKunj=1;
					if ($inap == '1'){
						$cJenisKunj=3;
					}else if ($jnsLayanan=="44"){
						$cJenisKunj=2;
					}
					
					if ($rwGetPel['unit_id']!=$tmpLayanan){
						$sqlPel = "update b_pelayanan set no_antrian=(fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),jenis_kunjungan='".$cJenisKunj."',jenis_layanan = $jnsLayanan, unit_id = $tmpLayanan,kso_id='$statusPas',kelas_id = $kelas, tgl = '$tglKun', dokter_tujuan_id = '".$_REQUEST['dokter_id']."', type_dokter_tujuan = '".$_REQUEST['dokterPengganti']."' where id = '".$rwGetPel['id']."'";
					}else{
						$sqlPel = "update b_pelayanan set kso_id='$statusPas',kelas_id = $kelas, tgl = '$tglKun', dokter_tujuan_id = '".$_REQUEST['dokter_id']."', type_dokter_tujuan = '".$_REQUEST['dokterPengganti']."' where id = '".$rwGetPel['id']."'";
					}
					// echo $sqlPel."<br>";
					mysql_query($sqlPel);
					if (mysql_errno()==0){
						//dicek inap atau tidak
						if($inap == '0') {
							$sqlGetRet ="SELECT a.*,b.`ak_ms_unit_id` FROM b_ms_tindakan_kelas a
INNER JOIN b_ms_tindakan b ON a.`ms_tindakan_id`=b.`id`
							
							where a.ms_tindakan_id='$retribusi' and a.ms_kelas_id=$kelas";
							// echo $sqlGetRet."<br>";
							$rsGetRet =mysql_query($sqlGetRet);
							$rwGetRet =mysql_fetch_array($rsGetRet);
							//dibandingkan dengan data sebelumnya apakah sama (misal jika sebelumnya inap,diganti menjadi non-inap),kalo data tidak sama, yang sebelumnya dihapus,insert data ke tabel lain
							//ambil data dari b_ms_tindakan_kelas untuk insert ke b_tindakan
			
							$beban_kso = 0;
							$beban_pasien = 0;
							$bayar_pasien = 0;
							$bayar_kso = 0;
							$bayar = 0;
							$lunas = 0;
							// echo $statusPas."<br>";
							if($statusPas == 4) {
								$sqlGetTin = "select nilai
									from b_ms_kso_paket_detail pd inner join b_ms_kso_paket kp on kp.id=pd.kso_paket_id
									where pd.ms_tindakan_id = '$retribusi' and kp.kso_id = 4";
								// echo $sqlGetTin."<br>";
								$rsGetRetKSO=mysql_query($sqlGetTin);
								if(mysql_num_rows($rsGetRetKSO) > 0) {
									$rwGetRetKSO=mysql_fetch_array($rsGetRetKSO);
									$beban_kso = $rwGetRetKSO['nilai'];
									$bayar = 0;
									$lunas = 0;
								}
								else {
									$beban_kso = 0;
									$beban_pasien = $tarip;
									if ($loketRet==1){
										$bayar_pasien = $tarip;
										$bayar = $tarip;
										$lunas = 1;
									}
								}
								mysql_free_result($rsGetRetKSO);
							}
							else if($statusPas == '1') {
								$beban_pasien = $tarip;
								if ($loketRet==1){
									$bayar = $tarip;
									$bayar_pasien = $tarip;
									$lunas = 1;
								}
							}
							else {
								$beban_kso = $tarip;
								$bayar = 0;
								$lunas = 0;
							}
							// echo "previnap=".$prev_inap."<br>";
							if($prev_inap == '0') {
								//dicek apakah retribusi sama dengan data sebelumnya,bila data sama maka tidak melakukan update
								if($retribusi != $prev_retribusi) {
									if($tarip == 0) {//=========Jika Tarip =0 --> data sebelumnya dihapus===========
										if ($rwGetTin['id']!="") {
											$sqlRetribusi = "delete from b_tindakan where id = '".$rwGetTin['id']."'";
											// echo $sqlRetribusi."<br>";
											$rs = mysql_query($sqlRetribusi);
			
											//hapus data b_tindakan_komponen kemudian insert data ke b_tindakan_komponen untuk updatenya
											$sqlRetribusi = "delete from b_tindakan_komponen where tindakan_id = '".$rwGetTin['id']."'";
											// echo $sqlRetribusi."<br>";
											mysql_query($sqlRetribusi);
			
											if ($prev_stat=="1") {
												$sqlRetribusi = "DELETE FROM b_bayar WHERE kunjungan_id='$idKunj'";
												// echo $sqlRetribusi."<br>";
												mysql_query($sqlRetribusi);
			
												$sqlRetribusi = "DELETE FROM b_bayar_tindakan WHERE tindakan_id='".$rwGetTin['id']."' AND tipe=0";
												// echo $sqlRetribusi."<br>";
												mysql_query($sqlRetribusi);
											}
										}
									}
									else {
										//update data b_tindakan
										$sqlRetribusi="update b_tindakan set jenis_kunjungan='".$cJenisKunj."',kso_id='$statusPas',kso_kelas_id='$hakKelas',ms_tindakan_kelas_id='".$rwGetRet['id']."',ak_ms_unit_id='".$rwGetRet['ak_ms_unit_id']."',biaya=".$tarip.",biaya_kso='$beban_kso',biaya_pasien='$beban_pasien',
										/* bayar='$bayar',bayar_pasien='$bayar_pasien',lunas='$lunas', */
										user_id = '".$_REQUEST['dokter_id']."',type_dokter = '".$_REQUEST['dokterPengganti']."' where id=".$rwGetTin['id'];
										// echo $sqlRetribusi."<br>";
										mysql_query($sqlRetribusi);
										if (mysql_errno()==0){
											//hapus data b_tindakan_komponen kemudian insert data ke b_tindakan_komponen untuk updatenya
											$sqlRetribusi = "delete from b_tindakan_komponen where tindakan_id = '".$rwGetTin['id']."'";
											// echo $sqlRetribusi."<br>";
											mysql_query($sqlRetribusi);
				
											$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwGetTind['id']."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b
														inner join b_ms_komponen k on b.ms_komponen_id=k.id
														where b.ms_tindakan_kelas_id='".$rwGetRet['id']."'";
											// echo $sqlTambah."<br>";
											mysql_query($sqlTambah);
				
											if ($prev_stat!="1" && $statusPas=="1" && $loketRet==1) {
												$sqlRetribusi = "insert into b_bayar(kunjungan_id,kasir_id,nobukti,tgl,dibayaroleh,ket,tagihan,nilai,keringanan,titipan,tgl_act,user_act,titipan_terpakai,tipe) values('".$idKunj."','$asal','$noBil','$tglKun','$nama','','$tarip','$tarip',0,0,now(),'$userId',0,0)";
												// echo $sqlRetribusi."<br>";
												mysql_query($sqlRetribusi);
												if (mysql_errno()==0){
													$sqlGetIdBayar = "select max(id) as id from b_bayar where kunjungan_id='".$idKunj."' and user_act = '$userId'";
													// echo $sqlGetIdBayar."<br>";
													$rsGetIdBayar = mysql_query($sqlGetIdBayar);
													$rowGetIdBayar = mysql_fetch_array($rsGetIdBayar);
					
													$sqlRetribusi = "insert into b_bayar_tindakan (bayar_id,tindakan_id,nilai) values ('".$rowGetIdBayar['id']."', '".$rwGetTin['id']."', '$tarip')";
													// echo $sqlRetribusi."<br>";
													mysql_query($sqlRetribusi);
													if (mysql_errno()>0){
														echo "6";
														$statusProses='Error';
													}
													mysql_free_result($rsGetIdBayar);
												}else{
													echo "7";
													$statusProses='Error';
												}
											}
										}else{
											echo "8";
											$statusProses='Error';
										}
									
									}
									
									
									
									
									
									
								}else {
								
										//UPDATE TINDAKAN KONNSULTASI ; 
										
											//START insert tindakan konsultasi
											
											$sqlhapus="DELETE a FROM b_tindakan_komponen a
														INNER JOIN b_tindakan b
														ON a.tindakan_id=b.id
														INNER JOIN `b_ms_tindakan_kelas` c  ON b.`ms_tindakan_kelas_id` = c.`id`
														INNER JOIN `b_ms_tindakan` d ON c.ms_tindakan_id=d.`id`
														WHERE b.kunjungan_id='$idKunj' AND d.kel_tindakan_id=151";
											//echo $sqlhapus;
											$sqlhapus1=mysql_query($sqlhapus);
											
											$sqlhapus2="DELETE b FROM b_tindakan b
											INNER JOIN `b_ms_tindakan_kelas` c  ON b.`ms_tindakan_kelas_id` = c.`id`
											INNER JOIN `b_ms_tindakan` d ON c.ms_tindakan_id=d.`id`
											WHERE b.kunjungan_id='$idKunj' AND d.kel_tindakan_id=151";
											//echo $sqlhapus2;
											$sqlhapus3=mysql_query($sqlhapus2);
											
											$sqlKonsul = "SELECT b.`tarip` tarip_konsul ,b.id as ms_tindakan_kelas_id, a.* FROM b_ms_tindakan a
															INNER JOIN `b_ms_tindakan_kelas` b ON a.`id`=b.`ms_tindakan_id`
															INNER JOIN `b_ms_tindakan_unit` c ON c.`ms_tindakan_kelas_id`=b.`id`
															WHERE c.`ms_unit_id`='$tmpLayanan' AND a.id<>840 AND a.`kel_tindakan_id`=151";
										//	echo $sqlKonsul;
											$sqlKonsul1=mysql_query($sqlKonsul);
											$sqlKonsul2=mysql_fetch_array($sqlKonsul1);
											$taripKonsul = $sqlKonsul2['tarip_konsul'];
											$KlsIdKonsul = $sqlKonsul2['ms_tindakan_kelas_id'];
											
											//echo  $sqlKonsul2['tarip']."aaaaaaaaaaaaaaaaaaa";
											
												if($taripKonsul != 0){
												
														if($statusPas==1){
															$BiayaKonsulP = $taripKonsul;
															$BiayaKonsulK = 0;
														}else{
															$BiayaKonsulP = 0;
															$BiayaKonsulK = $taripKonsul;
														}
														
														$sqlKOnsultasi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) values('".$KlsIdKonsul."','".$tmpLayanan."','".$sqlKonsul2['ak_ms_unit_id']."','".$cJenisKunj."','".$idKunj."',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun',".$taripKonsul.",'$BiayaKonsulP','$BiayaKonsulK','0','0','0','0','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
												//	echo $sqlKOnsultasi."<br>";
													mysql_query($sqlKOnsultasi);
														if (mysql_errno()==0){
															$getIdTind1="select max(id) as id from b_tindakan where pelayanan_id='".$rwGetPel['id']."' and kunjungan_id='".$idKunj."' and user_act=$userId";
															echo $getIdTind."<br/>";
															$rsIdTind1=mysql_query($getIdTind1);
															$rwIdTind1=mysql_fetch_array($rsIdTind1);
											
															$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind1['id']."',k.id,k.nama, $taripKonsul,b.tarip_prosen FROM b_ms_tindakan_komponen b 
															inner join b_ms_komponen k on b.ms_komponen_id=k.id
															where b.ms_tindakan_kelas_id='".$KlsIdKonsul."'";
														//	echo $sqlTambah."<br>";
															mysql_query($sqlTambah);
														}else{
															$statusProses='Error';
														}
												
												}
											
											//END insert tindakan konsultasi
							
										//END UPDATE TINDAKAN KONNSULTASI ; 
								
								
										
									//update data b_tindakan
									$sqlRetribusi="update b_tindakan set jenis_kunjungan='".$cJenisKunj."',kso_id='$statusPas',kso_kelas_id='$hakKelas',ms_tindakan_kelas_id='".$rwGetRet['id']."',biaya=".$tarip.",biaya_kso='$beban_kso',biaya_pasien='$beban_pasien',ak_ms_unit_id='".$rwGetRet['ak_ms_unit_id']."',
									/* bayar='$bayar',bayar_pasien='$bayar_pasien',lunas='$lunas', */
									user_id = '".$_REQUEST['dokter_id']."',type_dokter = '".$_REQUEST['dokterPengganti']."' where id=".$rwGetTin['id'];
									//echo $sqlRetribusi."<br>";
									mysql_query($sqlRetribusi);
									
									
									if (mysql_errno()==0){
										if ($prev_stat!="1" && $statusPas=="1" && $loketRet==1) {
											$sqlRetribusi = "insert into b_bayar(kunjungan_id,kasir_id,nobukti,tgl,dibayaroleh,ket,tagihan,nilai,keringanan,titipan,tgl_act,user_act,titipan_terpakai,tipe) values('".$idKunj."','$asal','$noBil','$tglKun','$nama','','$tarip','$tarip',0,0,now(),'$userId',0,0)";
											// echo $sqlRetribusi."<br>";
											mysql_query($sqlRetribusi);
											if (mysql_errno()==0){
												$sqlGetIdBayar = "select max(id) as id from b_bayar where kunjungan_id='".$idKunj."' and user_act = '$userId'";
												// echo $sqlGetIdBayar."<br>";
												$rsGetIdBayar = mysql_query($sqlGetIdBayar);
												$rowGetIdBayar = mysql_fetch_array($rsGetIdBayar);
												$sqlRetribusi = "insert into b_bayar_tindakan (bayar_id,tindakan_id,nilai) values ('".$rowGetIdBayar['id']."', '".$rwGetTin['id']."', '$tarip')";
												// echo $sqlRetribusi."<br>";
												mysql_query($sqlRetribusi);
												if (mysql_errno()>0){
													echo "9";
													$statusProses='Error';
												}
												mysql_free_result($rsGetIdBayar);
											}else{
												echo "10";
												$statusProses='Error';
											}
										}elseif($prev_stat=="1" && $statusPas!="1") {
											$sqlRetribusi = "DELETE FROM b_bayar WHERE kunjungan_id='".$idKunj."'";
											// echo $sqlRetribusi."<br>";
											mysql_query($sqlRetribusi);
											$sqlRetribusi = "DELETE FROM b_bayar_tindakan WHERE tindakan_id='".$rwGetTin['id']."' AND tipe=0";
											// echo $sqlRetribusi."<br>";
											mysql_query($sqlRetribusi);
										}
									}else{
										echo "11";
										$statusProses='Error';
									}
								}
							}
							else {
								//data tindakan kamar dihapus terlebih dahulu 
								$sqlKamar = "delete from b_tindakan_kamar where pelayanan_id = '".$rwGetPel['id']."'";
								//echo "kamar=".$sqlKamar."<br>";
								mysql_query($sqlKamar);
			
								if($tarip != 0) {
									//insert data retribusi ke b_tindakan
									$sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act) values('".$rwGetRet['id']."','".$tmpLayanan."','".$rwGetRet['ak_ms_unit_id']."','".$cJenisKunj."','$idKunj',".$rwGetPel['id'].",'".$statusPas."','".$hakKelas."','$tglKun',".$tarip.",'$beban_pasien','$beban_kso',".$tarip.",'$bayar_pasien','$lunas','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal)";
									//echo $sqlRetribusi."<br>";
									mysql_query($sqlRetribusi);
									if (mysql_errno()==0){
										//select data dari b_tindakan untuk insert ke b_tindakan_komponen
										$getIdTind="select max(id) as id from b_tindakan where pelayanan_id='".$rwGetPel['id']."' and kunjungan_id='$idKunj' and user_act=$userId";
										//echo $getIdTind."<br/>";
										$rsIdTind=mysql_query($getIdTind);
										$rwIdTind=mysql_fetch_array($rsIdTind);
				
										//insert ke tindakan komponen
										$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind['id']."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b
													inner join b_ms_komponen k on b.ms_komponen_id=k.id
													where b.ms_tindakan_kelas_id='".$rwGetRet['id']."'";
										mysql_query($sqlTambah);
										
										mysql_free_result($rsIdTind);
									}else{
										echo "12";
										$statusProses='Error';
									}
								}
							}
							mysql_free_result($rsGetRet);
						}
						else {
							//select data dari b_ms_kamar untuk insert ke b_tindakan_kamar
							//$sqlKamar = "select kode,nama,tarip,kelas_id from b_ms_kamar where id = '$kamar'";
							$sqlKamar ="SELECT * FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_kamar mk ON mkt.kamar_id=mk.id WHERE mkt.kamar_id='$kamar' AND mkt.kelas_id='$kelas'";
							//echo $sqlKamar."<br/>";
							$rsKamar = mysql_query($sqlKamar);
							if ($rowKamar = mysql_fetch_array($rsKamar)){
								//cek apakah data sebelumnya juga inap atau tidak,kalo inap update,kalo tidak inap, data sebelumnya dihapus dulu setelahnya baru insert ke b_tindakan_kamar
								if ($inap == $prev_inap) {
									$beban_kso = 0;
									$beban_pasien = 0;
				
									$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$idKunj'";
									$rsCekStat = mysql_query($sqlCekStat);
									$rowCekStat = mysql_fetch_array($rsCekStat);
				
									if($rowCekStat['kso_id'] == 1) {
										$beban_pasien = $rowKamar['tarip'];
									}
									else {
										$beban_kso = $rowKamar['tarip'];
									
										if($jnsLayanan != '94' && $tmpLayanan!='48' && $tmpLayanan!='112') {
											$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
											$rsHp = mysql_query($sqlHp);
											if(mysql_num_rows($rsHp) > 0) {
												$rowHp = mysql_fetch_array($rsHp);
												$beban_kso = $rowHp['jaminan'];
											}else{
												$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$tmpLayanan."' AND kelas_id = '".$rowCekStat['kso_kelas_id']."'";
												$rsBKso = mysql_query($sqlBKso);
												if (mysql_num_rows($rsBKso) > 0){
													$rowBKso = mysql_fetch_array($rsBKso);
													if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
														$beban_kso = $rowBKso['tarip'];
													}
												}else{
													$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$rowCekStat['kso_kelas_id']."'";
													$rsBKso = mysql_query($sqlBKso);
													if (mysql_num_rows($rsBKso) > 0){
														$rowBKso = mysql_fetch_array($rsBKso);
														if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
															$beban_kso = $rowBKso['tarip'];
														}
													}
												}
												mysql_free_result($rsBKso);
											}
											//echo "kso=".$rowCekStat['kso_id'].",hak_kelas=".$rowCekStat['kso_kelas_id'].",kelas=".$kelasnya;
											if (($rowCekStat['kso_id']==4) && ($rowCekStat['kso_kelas_id']==3) && ($kelas==2)){
												$beban_pasien = 100000;
											}elseif(($biaya > $beban_kso) && ($rowCekStat['kso_kelas_id'] != $kelas)) {
												$beban_pasien = $biaya-$beban_kso;
											}
										}
										else {
											$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '10' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
											$rsHp = mysql_query($sqlHp);
											if(mysql_num_rows($rsHp) > 0) {
												$rowHp = mysql_fetch_array($rsHp);
												$beban_kso = $rowHp['jaminan'];
											}
										}
										// ========================
									}
				
									$sqlKamar = "update b_tindakan_kamar set unit_id_asal='".$asal."',kso_id='".$statusPas."',tgl_in = CONCAT('".$tglKun."',' ',CURRENT_TIME()), kamar_id = '$kamar', kode = '".$rowKamar['kode']."', nama = '".$rowKamar['nama']."'
									, tarip = '".$rowKamar['tarip']."',beban_pasien='".$beban_pasien."',beban_kso='".$beban_kso."', kelas_id = '".$kelas."' where pelayanan_id = '".$rwGetPel['id']."'";
									//echo $sqlKamar."<br>";
									$rsKamar = mysql_query($sqlKamar);
									if (mysql_errno()>0){
										echo "13";
										$statusProses='Error';
									}
								}
								else {
									$sqlRetribusi = "delete from b_tindakan where id = '".$rwGetTin['id']."'";
									mysql_query($sqlRetribusi);
									$sqlRetribusi = "delete from b_tindakan_komponen where tindakan_id = '".$rwGetTin['id']."'";
									mysql_query($sqlRetribusi);
				
									if ($prev_stat=="1") {
										$sqlRetribusi = "DELETE FROM b_bayar_tindakan WHERE bayar_id=(SELECT DISTINCT id FROM b_bayar WHERE kunjungan_id='".$idKunj."')";
										mysql_query($sqlRetribusi);
										$sqlRetribusi = "DELETE FROM b_bayar WHERE kunjungan_id='".$idKunj."'";
										mysql_query($sqlRetribusi);
									}
									
									$sqlCekInap="SELECT mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.id=".$rwGetPel['id'];
									$rsCekIsInap=mysql_query($sqlCekInap);
									$rwCekIsInap=mysql_fetch_array($rsCekIsInap);
									if ($rwCekIsInap["inap"]==1){
										$beban_kso = 0;
										$beban_pasien = 0;
					
										$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '".$idKunj."'";
										$rsCekStat = mysql_query($sqlCekStat);
										$rowCekStat = mysql_fetch_array($rsCekStat);
					
										if($statusPas == "1") {
											$beban_pasien = $rowKamar['tarip'];
										}
										else {
											$beban_kso = $rowKamar['tarip'];
										
											if($jnsLayanan != '94' && $tmpLayanan!='48' && $tmpLayanan!='112') {
												$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
												$rsHp = mysql_query($sqlHp);
												if(mysql_num_rows($rsHp) > 0) {
													$rowHp = mysql_fetch_array($rsHp);
													$beban_kso = $rowHp['jaminan'];
												}else{
													$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$tmpLayanan."' AND kelas_id = '".$rowCekStat['kso_kelas_id']."'";
													$rsBKso = mysql_query($sqlBKso);
													if (mysql_num_rows($rsBKso) > 0){
														$rowBKso = mysql_fetch_array($rsBKso);
														if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
															$beban_kso = $rowBKso['tarip'];
														}
													}else{
														$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$rowCekStat['kso_kelas_id']."'";
														$rsBKso = mysql_query($sqlBKso);
														if (mysql_num_rows($rsBKso) > 0){
															$rowBKso = mysql_fetch_array($rsBKso);
															if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
																$beban_kso = $rowBKso['tarip'];
															}
														}
													}
													mysql_free_result($rsBKso);
												}
												//echo "kso=".$rowCekStat['kso_id'].",hak_kelas=".$rowCekStat['kso_kelas_id'].",kelas=".$kelasnya;
												if (($rowCekStat['kso_id']==4) && ($rowCekStat['kso_kelas_id']==3) && ($kelas==2)){
													$beban_pasien = 100000;
												}elseif(($biaya > $beban_kso) && ($rowCekStat['kso_kelas_id'] != $kelas)) {
													$beban_pasien = $biaya-$beban_kso;
												}
											}
											else {
												$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '10' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
												$rsHp = mysql_query($sqlHp);
												if(mysql_num_rows($rsHp) > 0) {
													$rowHp = mysql_fetch_array($rsHp);
													$beban_kso = $rowHp['jaminan'];
												}
											}
											// ===========================================
										}
					
										$sqlKamar = "insert into b_tindakan_kamar (pelayanan_id, unit_id_asal, kso_id,tgl_in, kamar_id, kode, nama, tarip, beban_pasien, beban_kso, kelas_id)
												values ('".$rwGetPel['id']."','".$asal."','".$statusPas."', CONCAT('$tglKun',' ',CURRENT_TIME()), '$kamar', '".$rowKamar['kode']."', '".$rowKamar['nama']."', '".$rowKamar['tarip']."', '$beban_pasien', '$beban_kso', '".$rowKamar['kelas_id']."')";
										mysql_query($sqlKamar);
										if (mysql_errno()>0){
											echo "5";
											$statusProses='Error';
										}
										mysql_free_result($rsCekStat);
									}
								}
							}else{
								//echo "asdas=".mysql_errno();
								//$statusProses='Error';
							}
						}
					}else{
						echo "3";
						$statusProses='Error';
					}
				}else{
					echo "2";
					$statusProses='Error';
				}
	
				/*if($tarip>0 && $inap == 0){
					$tarif_perda = $tarip;
					$tarif_pk = $beban_kso.'|'.$beban_pasien;
					//forAkun('edit',$tarif_perda.'|'.$tarif_pk,'reg',$asal,$noBil.'.'.$asal,$jnsLayanan,$tmpLayanan,$statusPas);
				}*/
	
				mysql_free_result($rsGetStat);
				mysql_free_result($rsGetTin);
			}
		}else{
			echo "1";
			$statusProses='Error';
		}
        break;
}

//echo "statuserr=".$statusProses."<br>";
if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    //$asalLoket = $_GET['asalLoket'];
    if($_REQUEST['saring']=='true') {
        $saringan=" AND k.tgl = '".tglSQL($_REQUEST['saringan'])."' ";
    }

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }

    if($grd == "true") {
        $user =  " and k.user_act = '$userLog' ";
        if($userLog == 0) {
            $user = "";
        }
		
		$sql="SELECT * FROM (SELECT t1.*,n.nama AS jenis_layanan FROM 
(SELECT k.id,k.pasien_id,p.no_rm,p.no_ktp,k.no_billing,UPPER(p.nama) as nama,p.tgl_lahir,UPPER(p.alamat) as alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.id_kw,
UPPER(p.nama_ortu) as nama_ortu,UPPER(p.nama_suami_istri) as nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp,DATE(k.tgl) AS tgl,k.asal_kunjungan,
k.ket,k.umur_thn,k.umur_bln,k.umur_hr,k.jenis_layanan AS id_jenis_layanan,k.unit_id,u.nama AS tempat_layanan,k.kelas_id,l.nama AS kelas,
k.kso_id,k.kso_kelas_id,tgl_sjp,no_sjp,no_anggota,kso.nama AS nama_kso,k.retribusi,inap,k.dilayani,k.dokter_tujuan_id,k.type_dokter_tujuan,
(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
k.no_reg, p.gol_darah 
FROM (SELECT k.*,pl.dilayani,pl.dokter_tujuan_id,pl.type_dokter_tujuan FROM b_kunjungan k INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id 
WHERE k.loket_id = '$asal' AND pl.unit_id_asal='$asal' ".$saringan.$user.") k 
INNER JOIN b_ms_pasien p ON k.pasien_id=p.id INNER JOIN b_ms_unit u ON k.unit_id=u.id 
INNER JOIN b_ms_kelas l ON k.kelas_id=l.id LEFT JOIN b_ms_kso kso ON kso.id=k.kso_id) AS t1 
INNER JOIN b_ms_unit n ON t1.id_jenis_layanan=n.id) AS gab ".$filter." ORDER BY ".$sorting;
    }
	
    //echo $sql."<br>";
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";
    //echo $sql;

    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
	
	
	
			
        while ($rows=mysql_fetch_array($rs)) {
		
		
		$sqlAR = "select * from b_asal_masuk_kunjungan where idKunj = ".$rows['id'];
			$queryAR = mysql_query($sqlAR);
			while($rowAR = mysql_fetch_array($queryAR)){
				$puskesmas = $rowAR['puskesmas'];
				$rumahsakit = $rowAR['rumahsakit'];
			}
		
            $sisipan = $rows['id']."|".$rows['pasien_id']."|".$rows['no_rm']."|".$rows['no_billing']."|".tglSQL($rows['tgl_lahir'])."|".$rows['alamat']."|".$rows['rt']."|".$rows['rw']."|".$rows['desa_id']."|".$rows['kec_id']."|".$rows['kab_id']."|".$rows['prop_id']."|".$rows['nama_ortu']."|".$rows['nama_suami_istri']."|".$rows['sex']."|".$rows['pendidikan_id']."|".$rows['pekerjaan_id']."|".$rows['agama']."|".$rows['telp'];
            $sisipan .= "|".tglSQL($rows['tgl'])."|".$rows['umur_thn']."|".$rows['umur_bln']."|".$rows['id_jenis_layanan']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['kso_id']."|".tglSQL($rows['tgl_sjp'])."|".$rows['no_sjp']."|".$rows['no_anggota']."|".$rows['asal_kunjungan']."|".$rows['ket']."|".$rows['nama_kso']."|".$rows['retribusi']."|".$rows['kso_kelas_id'].'|'.$rows['inap'].'|'.$rows['no_billing']."|".$rows['dilayani']."|".$rows['no_ktp']."|".$rows['dokter_tujuan_id']."|".$rows['type_dokter_tujuan']."|".$rows['umur_hr']."|".$rows['desa']."|".$rows['kec']."|".$rows['kab']."|".$rows['prop']."|".$rows['no_reg']."|".$rows['gol_darah']."|".$puskesmas."|".$rumahsakit."|".$rows['id_kw'];
            $i++;
			
			$sDokter = "select nama as dokter from b_ms_pegawai where id = '".$rows['dokter_tujuan_id']."'";
			$Dokter = mysql_fetch_array(mysql_query($sDokter));
			
			if($rows['dilayani']==1)
			{
				$dt.=$sisipan.chr(3)."<span style='color:#F00'>".number_format($i,0,",","")."</span>".chr(3)."<span style='color:#F00'>".$rows['no_rm']."</span>".chr(3)."<span style='color:#F00'>".$rows["nama"]."</span>".chr(3)."<span style='color:#F00'>".$rows["nama_kso"]."</span>".chr(3)."<span style='color:#F00'>".$rows["tempat_layanan"]."</span>".chr(3)."<span style='color:#F00'>".$Dokter["dokter"]."</span>".chr(3)."<span style='color:#F00'>".$rows["kelas"]."</span>".chr(3)."<span style='color:#F00'>".$rows["alamat"]." RT. ".$rows["rt"]." RW. ".$rows['rw']."</span>".chr(6);
			}else{
				$dt.=$sisipan.chr(3).$i.chr(3).$rows['no_rm'].chr(3).$rows["nama"].chr(3).$rows["nama_kso"].chr(3).$rows["tempat_layanan"].chr(3).$Dokter["dokter"].chr(3).$rows["kelas"].chr(3).$rows["alamat"]." RT. ".$rows["rt"]." RW. ".$rows['rw'].chr(6);
			}
            //$rows["id"]
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."|".$idKunj."|".$idPasien."|".$tmpLayanan."|".$inap;
        $dt=str_replace('"','\"',$dt);
    }else{
		$dt.=chr(5).strtolower($_REQUEST['act']);
	}

    mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;

?>
