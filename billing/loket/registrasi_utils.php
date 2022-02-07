<?php
$userId=$_REQUEST['userId'];
include("../koneksi/konek.php");
include("../sesi.php");

//include 'forAkun.php';
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id desc";
$sorting=$_REQUEST["sorting"];
$saringan=$_REQUEST["saringan"];
$filter=$_REQUEST["filter"];
//===============================

//=================================================================
$idPasien = $_REQUEST['idPasien'];
$idKunj = $_REQUEST['idKunj'];
$noRm = $_REQUEST['noRm'];
$noKTP = $_REQUEST['noKTP'];
$noBil = $_REQUEST['noBil'];
$nama = addslashes($_REQUEST['nama']); 
$namaOrtu = addslashes($_REQUEST['namaOrtu']); 
$namaSuTri = addslashes($_REQUEST['namaSuTri']);
$gender = $_REQUEST['gender']; 
$pend = $_REQUEST['pend']; 
$pek = $_REQUEST['pek'];
$agama = $_REQUEST['agama'];
$tglLhr = tglSQL($_REQUEST['tglLhr']); 
$thn = $_REQUEST['thn']; 
$bln = $_REQUEST['bln']; 
$hari = $_REQUEST['hari']; 
$tglKun = tglSQL($_REQUEST['tglKun']); 
$alamat = addslashes($_REQUEST['alamat']);
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

$kelompokMcu = $_REQUEST['kelompokMcu'];

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
$asal = $_REQUEST['asal'];
$userLog = $_REQUEST['userLog'];
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

$idPasKlinik = $_REQUEST['id_pasien_klinik'];
$idPelKlinik = $_REQUEST['id_pelayanan_klinik'];
$idKunjKlinik = $_REQUEST['id_kunjungan_klinik'];

function cekBayar($idTindakan){
	$sTindakan = "select bayar, lunas from b_tindakan where id = '{$idTindakan}'";
	$qTindakan = mysql_query($sTindakan);
	$data = mysql_fetch_array($qTindakan);
	
	$hasil = array('bayar'=>$data['bayar'], 'lunas'=>$data['lunas']);
	return $hasil;
}

function no_rm($cabang){
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
    return $noRm;
}

function tindakanMcu($id_kunjungan,$statusPas,$hakKelas,$kelas,$tglKun,$flag,$userId,$cJenisKunj,$asal,$kelompokMcu,$idPasien,$jnsLayanan,$mcu_id){
    echo "terpanggil";
    $beban_kso = 0;
    $beban_pasien = 0;
    $bayar_pasien = 0;
    $bayar_kso = 0;
    $bayar = 0;
    $lunas = 0;

    if($statusPas == 1){
        $filterWhere2 = " kso_id = {$statusPas}";
    }else{
        $filterWhere2 = " (kso_id = {$statusPas} XOR kso_id = 1)";
    }

    $sql = "SELECT
				* 
			FROM
				(
				SELECT
					kt.*,
					t.id AS id_ms_tindakan,
					tk.ms_kelas_id,
					tk.tarip,
					t.ak_ms_unit_id,
					tk.ak_akun_utip,
					tk.tarip_utip,
					tk.kso_id
				FROM
					b_ms_mcu_kelompok_tindakan kt
					INNER JOIN ( SELECT * FROM b_ms_mcu_kelompok_tempat_layanan WHERE id_kelompok_mcu = {$kelompokMcu} ) tl ON tl.id_tempat_layanan = kt.id_tmpt_layanan
					LEFT JOIN b_ms_tindakan_kelas tk ON tk.id = kt.id_tindakan_kelas
					LEFT JOIN b_ms_tindakan t ON t.id = tk.ms_tindakan_id 
				WHERE
					kt.id_mcu_kelompok = {$kelompokMcu}
				) AS k 
			WHERE
                {$filterWhere2}";
    echo $sql;
    $query = mysql_query($sql);

    $sqlCek="SELECT nama FROM b_ms_reference b where stref=22";
    $rsCek=mysql_query($sqlCek);
    $rwCek=mysql_fetch_array($rsCek);
    $tmpLayananSebelum = 0;
    $idPel = "";
    while($rows = mysql_fetch_assoc($query)){
        if($rows['id_tmpt_layanan'] != $tmpLayananSebelum){
        $tmpLayananSebelum = $rows['id_tmpt_layanan'];
        $sqlInserPelayanan = "INSERT INTO b_pelayanan (
                                    no_antrian,
                                    jenis_kunjungan,
                                    pasien_id,
                                    unit_id_asal,
                                    kunjungan_id,
                                    jenis_layanan,
                                    unit_id,
                                    kso_id,
                                    kelas_id,
                                    tgl,
                                    dilayani,
                                    tgl_act,
                                    user_act,
                                    dokter_tujuan_id,
                                    type_dokter_tujuan,
                                    flag 
                                )
                                VALUES
                                    (
										(fGetMaxNo_Antrian({$rows['id_tmpt_layanan']},'$tglKun')),
                                        '".$cJenisKunj."',
                                        $idPasien,
                                        '$mcu_id',
                                        '".$id_kunjungan."',
                                        $jnsLayanan,
                                        {$rows['id_tmpt_layanan']},
                                        $statusPas,
                                        $kelas,
                                        '$tglKun',
                                        0,
                                        NOW(),
                                        $userId,
                                        '".$_REQUEST['dokter_id']."',
                                        '".$_REQUEST['dokterPengganti']."',
                                        '$flag'
								)";
        if(mysql_query($sqlInserPelayanan) == false){
            return;
        }
        $idPel = mysql_insert_id();
        }
        if($statusPas == '1') {
        $beban_pasien = $rows['tarip'];
        }
        else {
            $beban_kso = $rows['tarip'];
		}
		
		if($rwCek['nama']=='1') {
			$tarif=",b.tarip_prosen*".($rows['tarip']/100);
		}
		else {
			$tarif=",b.tarip";
		}

         $sqlRetribusi="INSERT INTO b_tindakan (
                            ms_tindakan_kelas_id,
                            ms_tindakan_unit_id,
                            ak_ms_unit_id,
                            ak_akun_utip,
                            jenis_kunjungan,
                            kunjungan_id,
                            pelayanan_id,
                            kso_id,
                            kso_kelas_id,
                            kelas_id,
                            tgl,
                            biaya,
                            biaya_pasien,
                            biaya_utip,
                            biaya_kso,
                            bayar,
                            bayar_kso,
                            bayar_pasien,
                            lunas,
                            user_id,
                            type_dokter,
                            tgl_act,
                            user_act,
                            unit_act,
                            flag 
                        )
                        VALUES
                            (
                                {$rows['id_tindakan_kelas']},
                                {$rows['id_tmpt_layanan']},
                                {$rows['ak_ms_unit_id']},
                                {$rows['ak_akun_utip']},
                                '".$cJenisKunj."',
                                '".$id_kunjungan."',
                                ".$idPel.",
                                '".$statusPas."',
                                '".$hakKelas."',
                                '$kelas',
                                '$tglKun',
                                {$rows['tarip']},
                                '$beban_pasien',
                                {$rows['tarip_utip']},
                                '$beban_kso',
                                ".$bayar.",
                                '$bayar_kso',
                                '$bayar_pasien',
                                '$lunas',
                                '".$rows['dokter_id']."',
                                '".$rows['type_dokter']."',
                                NOW(),
                                $userId,
                            $asal,
                            '$flag')";
    
            mysql_query($sqlRetribusi);
            // echo $sqlRetribusi;
            if (mysql_errno()==0){
                //insert ke b_tindakan_komponen
                $idTindRet=mysql_insert_id();
                $sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindRet."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b 
                inner join b_ms_komponen k on b.ms_komponen_id=k.id
                where b.ms_tindakan_kelas_id= {$rows['id_tindakan_kelas']}";
                //echo $sqlTambah."<br>";
                mysql_query($sqlTambah);
            }else{
                $statusProses='Error';
            }
    }    
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
    WHERE k.id='$idKunj' AND p.flag='$flag' order by pl.id limit 1";
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
			
            $sqlTambah="insert into b_ms_pasien (no_rm,no_ktp,nama,sex,agama,tgl_lahir,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,telp,pendidikan_id,pekerjaan_id,nama_ortu,nama_suami_istri,user_act,tgl_act,gol_darah,id_kw,cabang_id,flag) values('$noRm','$noKTP','$nama','$gender','$agama','$tglLhr','$alamat','$rt','$rw','$desa','$kec','$kab','$prop','$telp','$pend','$pek','$namaOrtu','$namaSuTri','$userId','$tglact','$darah','$kw',$cabang,'$flag')";
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
			
            $sqlUpdate="update b_ms_pasien set nama='$nama',sex='$gender',agama='$agama',tgl_lahir='$tglLhr',alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',telp='$telp',".(($pend=='0')?'':"pendidikan_id='$pend',").(($pek=='0')?'':"pekerjaan_id='$pek',")."nama_ortu='$namaOrtu',nama_suami_istri='$namaSuTri',no_ktp='$noKTP', gol_darah='$darah', id_kw='$kw', flag='$flag'
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

            $sqlInsertKso="insert into b_ms_kso_pasien(kso_id,pasien_id,kelas_id,kodepenjamin,no_anggota,st_anggota,nama_peserta,kode_ppk,kodepersonel,tgl_act,flag)
			values ($statusPas,$idPasien,$hakKelas,'".$rwGetKso['kode']."','$noAnggota','$statusPenj','$namaPKSO','$kodeppk',$userId,'$tglact','$flag')";
            //echo $sqlInsertKso."<br>";
            $rsInsertKso=mysql_query($sqlInsertKso);
            mysql_free_result($rsGetKso);
        }elseif($statusPas=="4" && $kodeppk!=""){
			$sqlUpdateKso="update b_ms_kso_pasien set kso_id=$statusPas,kelas_id=$hakKelas,no_anggota='$noAnggota',st_anggota='$statusPenj',nama_peserta='$namaPKSO',kode_ppk='$kodeppk',flag='$flag' where pasien_id=$idPasien";
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
		
        $sqlKunj="insert into b_kunjungan (no_billing,loket_id,pasien_id,asal_kunjungan,ket,jenis_layanan,unit_id,retribusi,tgl,umur_thn,umur_bln,umur_hr,kel_umur,kelas_id,kso_id,kso_kelas_id,tgl_sjp,no_sjp,no_anggota,status_penj,nama_peserta,diag_awal,pendidikan_id,pekerjaan_id,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,isbaru,tgl_act,user_act,no_reg,cabang_id,flag) values ('$noBil','$asal',$idPasien,$asalMsk,'$ket',$jnsLayanan,$tmpLayanan,'$retribusi','$tglKun','$thn','$bln','$hari','".$filterKelUmur."','$kelas','$statusPas','$hakKelas','$tglSJP',$strNoSJP,'$noAnggota','$statusPenj','$namaPKSO','$diagAwal',$pend,$pek,'$alamat','$rt','$rw','$desa','$kec','$kab','$prop',$isBaru,NOW(),$userId,'$noreg1',{$cabang},'$flag')";
       //echo $sqlKunj."<br>";
        $rsKunj=mysql_query($sqlKunj);
		if (mysql_affected_rows()>0){
			$idKunj=mysql_insert_id();
			//$sqlGetKunj="select max(id) as id, unit_id from b_kunjungan where pasien_id=$idPasien and user_act=$userId and cabang_id = '{$cabang}'";
			$sqlGetKunj="select unit_id from b_kunjungan where id=$idKunj";
			//echo $sqlGetKunj."<br>";
			$rsGetKunj=mysql_query($sqlGetKunj);
			$rwGetKunj=mysql_fetch_array($rsGetKunj);
			//$idKunj=$rwGetKunj['id'];
			$mcu_id=$rwGetKunj['unit_id'];
			//$idKunj=$kunjungan_id;
			
			/* Save asal rujukan/masuk Puskesmas/RS */
			$sqlAR = "insert into b_asal_masuk_kunjungan(idKunj, puskesmas, rumahsakit, tgl_act, user_act,flag) value ({$idKunj},'{$puskesmas}','{$rumahsakit}', NOW(), {$userId}, '$flag')";
			$queryAR = mysql_query($sqlAR);
			
			$cJenisKunj=1;
			if ($inap == 1){
				$cJenisKunj=3;
			}else if ($jnsLayanan=="4"){
				$cJenisKunj=2;
			}
			
			$is_poli_di_jkn = false;
			$sqlCekPoliJKN = "SELECT * FROM rspelindo_auth.jkn_poli WHERE unit_id = '{$tmpLayanan}'";
			$queryCekjkn = mysql_query($sqlCekPoliJKN);
			$dataCekjkn = mysql_fetch_assoc($queryCekjkn);
			if(mysql_num_rows($queryCekjkn)){ // Jika poli terdaftar pada jkn maka tandai
				$is_poli_di_jkn = true;
			}

			if($is_poli_di_jkn){ // Jika dari poli jkn maka no antrian diambil dari tabel antrian
				$no_antrian_jkn = "1";
				$id_antrian_jkn = "";
				if(!isset($_REQUEST['darijkn']) && !isset($_REQUEST['idantrianjkn'])){
					$sqlGetNoAntrian = "SELECT 
					IFNULL(MAX(no_antrian) + 1, 1) as max_no_antrian 
					FROM rspelindo_auth.`auth_antrian` 
					WHERE tanggal_periksa = DATE(NOW()) AND unit_id = '{$tmpLayanan}'";
					$queryGetAntrian = mysql_query($sqlGetNoAntrian);
					$dataGetAntrian = mysql_fetch_assoc($queryGetAntrian);
					$no_antrian_jkn = $dataGetAntrian['max_no_antrian'];

					$sqlAntrian = "INSERT INTO rspelindo_auth.auth_antrian (
						no_antrian, 
						unit_id, nik, tanggal_periksa, 
						kodepoli, created_date, id_pasien) 
					VALUES('{$dataGetAntrian['max_no_antrian']}', '{$tmpLayanan}',
						'$noKTP', DATE(NOW()), '{$dataCekjkn['kodepoli']}', NOW(), '{$idPasien}')";
					mysql_query($sqlAntrian);
					$id_antrian_jkn = mysql_insert_id();
				}else{
					$sqlGetNoAntrian = "SELECT no_antrian, unit_id
					FROM rspelindo_auth.`auth_antrian` 
					WHERE id = '{$_REQUEST['idantrianjkn']}'";
					$queryGetAntrian = mysql_query($sqlGetNoAntrian);
					$dataGetAntrian = mysql_fetch_assoc($queryGetAntrian);
					
					// Lakukan pengecekan jika dia ternyata ganti tempat layanan
					if($dataGetAntrian['unit_id'] != $tmpLayanan){
						// Get no antrian baru
						$sqlGetNoAntrian = "SELECT 
						IFNULL(MAX(no_antrian) + 1, 1) as max_no_antrian 
						FROM rspelindo_auth.`auth_antrian` 
						WHERE tanggal_periksa = DATE(NOW()) AND unit_id = '{$tmpLayanan}'";
						$queryGetAntrian = mysql_query($sqlGetNoAntrian);
						$dataGetAntrian = mysql_fetch_assoc($queryGetAntrian);
						$no_antrian_jkn = $dataGetAntrian['max_no_antrian'];
						
						$sqlAntrian = "INSERT INTO rspelindo_auth.auth_antrian (
							no_antrian, 
							unit_id, nik, tanggal_periksa, 
							kodepoli, created_date, id_pasien) 
						VALUES('{$dataGetAntrian['max_no_antrian']}', '{$tmpLayanan}',
							'$noKTP', DATE(NOW()), '{$dataCekjkn['kodepoli']}', NOW(), '{$idPasien}')";
						mysql_query($sqlAntrian);
						$id_antrian_jkn = mysql_insert_id();

						// System Update ID lama
						// $no_antrian_jkn = $dataGetAntrian['max_no_antrian'];
						// $id_antrian_jkn = $_REQUEST['idantrianjkn'];
						
						// $sqlAntrian = "UPDATE rspelindo_auth.auth_antrian SET unit_id = '{$tmpLayanan}', kode_poli = '{$dataCekjkn['kodepoli']}', no_antrian = '{$no_antrian_jkn}' WHERE id = '{$_REQUEST['idantrianjkn']}'";
						// mysql_query($sqlAntrian);
					}else{
						$no_antrian_jkn = $dataGetAntrian['no_antrian'];
						$id_antrian_jkn = $_REQUEST['idantrianjkn'];
					}
				}
	
				$sqlPelayanan="insert into b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan,flag,id_antrian_jkn) values ('". $no_antrian_jkn ."','".$cJenisKunj."',$idPasien,'$asal','".$idKunj."',$jnsLayanan,$tmpLayanan,$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."','$flag', '{$id_antrian_jkn}')";
			}else{
				$sqlPelayanan="insert into b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan,flag) values ((fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),'".$cJenisKunj."',$idPasien,'$asal','".$idKunj."',$jnsLayanan,$tmpLayanan,$statusPas,$kelas,'$tglKun',0,NOW(),$userId,'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."','$flag')";
			}

			mysql_query($sqlPelayanan);
			
			if (mysql_errno()==0){
				$idPel=mysql_insert_id();
				//============ Jika MCU, konsul ke 5 unit ===============//			
				if($mcu_id == 189){
                    tindakanMcu($idKunj,$statusPas,$hakKelas,$kelas,$tglKun,$flag,$userId,$cJenisKunj,$asal,$kelompokMcu,$idPasien,$jnsLayanan,$mcu_id);
				}
				
				$tarip_utip=0;
				$ak_akun_utip=0;
				
				if($inap == 0) {
					$cSKD="0";
					if ($retribusi == "3078" || $retribusi == "3079"){
						$cSKD=$retribusi;
						$taripSKD=$tarip;
						
						$sqlGetTin = "SELECT 
										b.tarip tarip_ret,
										b.id as ms_tindakan_kelas_id, 
										a.* 
									FROM 
										b_ms_tindakan a
										INNER JOIN b_ms_tindakan_kelas b ON a.id =b.ms_tindakan_id
										INNER JOIN b_ms_tindakan_unit c ON c.ms_tindakan_kelas_id =b.id
									WHERE 
										c.ms_unit_id = {$tmpLayanan} 
										AND a.kel_tindakan_id = 66";

						$rsGetTin=mysql_query($sqlGetTin);
						$rwGetTin=mysql_fetch_array($rsGetTin);
						
						$idTindAdm=$rwGetTin['ms_tindakan_kelas_id'];
						$ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
						$tarip=$rwGetTin['tarip_ret'];

					}else{
						
						$sqlGetTin="SELECT 
										a.*,
										b.ak_ms_unit_id
									FROM 
										b_ms_tindakan_kelas a
										INNER JOIN b_ms_tindakan b ON a.ms_tindakan_id =b.id		
									WHERE 
										a.id = {$retribusi} 
										AND a.ms_kelas_id = {$kelas}";
									
						$rsGetTin=mysql_query($sqlGetTin);
						$rwGetTin=mysql_fetch_array($rsGetTin);

						$idTindAdm=$rwGetTin['id'];
						$ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
						$tarip_utip=$rwGetTin['tarip_utip'];
						$ak_akun_utip=$rwGetTin['ak_akun_utip'];
					}
					
					$beban_kso = 0;
					$beban_pasien = 0;
					$bayar_pasien = 0;
					$bayar_kso = 0;
					$bayar = 0;
					$lunas = 0;
		
					if($statusPas == '1') {
						$beban_pasien = $tarip;
					}
					else {
						$beban_kso = $tarip;
					}
		
					if($tarip != 0) {
						//insert Retribusi ke b_tindakan
						$sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,ak_akun_utip,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_utip,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$idTindAdm."','".$tmpLayanan."','".$ak_ms_unit_id."','$ak_akun_utip','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$tarip.",'$beban_pasien','$tarip_utip','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
						mysql_query($sqlRetribusi);
						if (mysql_errno()==0){
							//insert ke b_tindakan_komponen
							$idTindRet=mysql_insert_id();
							
			
							$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindRet."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b 
							inner join b_ms_komponen k on b.ms_komponen_id=k.id
							where b.ms_tindakan_kelas_id='".$idTindAdm."'";
							//echo $sqlTambah."<br>";
							mysql_query($sqlTambah);
						}else{
							$statusProses='Error';
						}
					} 

                    //Untuk pasien klinik pcr
                    if($idPasKlinik != ''){
                        $sqlPasienKlinikPcr = "INSERT INTO b_pasien_klinik_pcr ( id_pasien_klinik, tanggal_act, user_id, id_pasien_rs, id_kunjungan, id_pelayanan, status, id_pelayanan_klinik, id_kunjungan_klinik )VALUES({$idPasKlinik},now(),{$userId},{$idPasien},{$idKunj},{$idPel},1,{$idPelKlinik},{$idKunjKlinik})";

						$query = mysql_query($sqlPasienKlinikPcr);
                        if($query == false){
                            echo mysql_error($query);
                        }
                    }

					if($retribusi=="3078" || $retribusi=="3079"){
					 	//Insert Biaya SKD
						
						$sqlGetTinSKD="SELECT 
										a.*,
										b.ak_ms_unit_id 
										FROM 
										b_ms_tindakan_kelas a
										INNER JOIN b_ms_tindakan b ON a.ms_tindakan_id = b.id		
										WHERE 
											a.id = {$retribusi} 
											and a.ms_kelas_id= {$kelas}";
											
						$sqlR1=mysql_query($sqlGetTinSKD);
						$sqlR2=mysql_fetch_array($sqlR1);
						$taripR = $taripSKD;
						$KlsIdR = $sqlR2['id'];
						$ak_ms_unit_id=$sqlR2['ak_ms_unit_id'];
						
						if($statusPas==1){
							$BiayaRP = $taripR;
							$BiayaRK = 0;
						}else{
							$BiayaRP = 0;
							$BiayaRK = $taripR;
						}
						
						$sqlRet="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$KlsIdR."','".$tmpLayanan."','".$ak_ms_unit_id."','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$taripR.",'$BiayaRP','$BiayaRK','0','0','0','0','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
						mysql_query($sqlRet);
					
						if (mysql_errno()==0){
							$idTindSKD=mysql_insert_id();
							/*$getIdTindR="select max(id) as id from b_tindakan where pelayanan_id='".$idPel."' and kunjungan_id='".$idKunj."' and user_act=$userId";
							//echo $getIdTind."<br/>";
							$rsIdTindR=mysql_query($getIdTindR);
							$rwIdTindR=mysql_fetch_array($rsIdTindR);*/
			
							$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindSKD."',k.id,k.nama ,$taripR,b.tarip_prosen FROM b_ms_tindakan_komponen b 
							inner join b_ms_komponen k on b.ms_komponen_id=k.id
							where b.ms_tindakan_kelas_id='".$KlsIdR."'";
							//echo $sqlTambah."<br>";
							mysql_query($sqlTambah);
						}else{
							$statusProses='Error';
						}
					 //END Insert Retribusi SKD
					 }
				}
				else {
					$sqlCekInap="SELECT mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.id=".$idPel;
					$rsCekIsInap=mysql_query($sqlCekInap);
					$rwCekIsInap=mysql_fetch_array($rsCekIsInap);
					if ($rwCekIsInap["inap"]==1){
						$sqlKamar = "SELECT kode,nama,tarip,kelas_id FROM b_ms_kamar mk INNER JOIN b_ms_kamar_tarip mkt ON mk.id=mkt.kamar_id WHERE mk.id = '$kamar' AND mkt.kelas_id='$kelas'";
						//echo $sqlKamar."<br>";
						$rsKamar = mysql_query($sqlKamar);
						$rowKamar = mysql_fetch_array($rsKamar);
			
						$beban_kso = 0;
						$beban_pasien = 0;
			
						$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$idKunj' and cabang_id = '{$cabang}'";
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
			
						$sqlKamar = "insert into b_tindakan_kamar (pelayanan_id, unit_id_asal, kso_id, tgl_in, kamar_id, kode, nama, tarip, beban_pasien, beban_kso, kelas_id,aktif,flag)
								values ('".$idPel."','".$asal."','".$statusPas."', CONCAT('$tglKun',' ',CURRENT_TIME()), '$kamar', '".$rowKamar['kode']."', '".$rowKamar['nama']."', '".$rowKamar['tarip']."', '$beban_pasien', '$beban_kso', '".$rowKamar['kelas_id']."','0','$flag')";
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
				$sqlHapusBayar = "delete from b_bayar_tindakan where bayar_id in (select id from b_bayar where kunjungan_id = '$idKunj')";
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

        $sqlUpdate="update b_ms_pasien set no_ktp='$noKTP',nama='$nama',sex='$gender',agama='$agama',tgl_lahir='$tglLhr',alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',telp='$telp',pendidikan_id='$pend',pekerjaan_id='$pek',nama_ortu='$namaOrtu',nama_suami_istri='$namaSuTri',user_act=$userId,tgl_act='$tglact',gol_darah='$darah',id_kw='$kw',flag='$flag' where id=$idPasien and cabang_id = '{$cabang}'";
		//$sqlUpdate."<br>";
        mysql_query($sqlUpdate);
		if (mysql_errno()==0){
			if ($statusPas!="1") {
				$sqlUpdateKso="SELECT * FROM b_ms_kso_pasien WHERE pasien_id='$idPasien'";
				//echo $sqlUpdateKso."<br>";
				$rsUpdateKso=mysql_query($sqlUpdateKso);
				if (mysql_num_rows($rsUpdateKso)>0) {
					$sqlUpdateKso="update b_ms_kso_pasien set kso_id=$statusPas,kelas_id=$hakKelas,no_anggota='$noAnggota',st_anggota='$statusPenj',nama_peserta='$namaPKSO',flag='$flag' where pasien_id=$idPasien";
					//echo $sqlUpdateKso."<br>";
					$rsUpdateKso=mysql_query($sqlUpdateKso);
				}else {
					$sqlUpdateKso="INSERT INTO b_ms_kso_pasien(kso_id,pasien_id,kelas_id,no_anggota,st_anggota,nama_peserta,kode_ppk,flag)
					VALUES($statusPas,$idPasien,$hakKelas,'$noAnggota','$statusPenj','$namaPKSO','$kodeppk','$flag')";
					//echo $sqlUpdateKso."<br>";
					$rsInKso=mysql_query($sqlUpdateKso);
				}
			}
	
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
				$idPel=$rwGetPel["id"];
				$prev_unit_id=$rwGetPel["unit_id"];
	
				//$sqlGetStat = "select * from b_kunjungan where id = '$idKunj' and cabang_id = '{$cabang}'";
				$sqlGetStat = "select * from b_kunjungan where id = '$idKunj'";
				// echo $sqlGetStat."<br>";
				$rsGetStat = mysql_query($sqlGetStat);
				$rowGetStat = mysql_fetch_array($rsGetStat);
				
				$strNoSJP="'$noSJP'";
				/*if ($statusPas==6 && $rowGetStat["kso_id"]!=53 && $tglKun>"2011-08-31"){
					$strNoSJP="fGetMaxNoJPersal('$tglKun')";
				}
				if ($statusPas==6 && $rowGetStat["kso_id"]!=46){
					$strNoSJP="fGetMaxNoJamkesda('$tglKun')";
				}*/
					
				/*$sqlSimpan="update b_kunjungan set pasien_id=$idPasien,asal_kunjungan=$asalMsk,ket='$ket',jenis_layanan=$jnsLayanan,unit_id=$tmpLayanan,retribusi='$retribusi',tgl='$tglKun',umur_thn='$thn',umur_bln='$bln',umur_hr='$hari',kelas_id='$kelas',kso_id=$statusPas,kso_kelas_id='$hakKelas',tgl_sjp='$tglSJP',no_sjp=$strNoSJP,no_anggota='$noAnggota',status_penj='$statusPenj',nama_peserta='$namaPKSO',pendidikan_id=$pend,pekerjaan_id=$pek,alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',kel_umur='$filterKelUmur',no_reg='$noreg1' where id=$idKunj and cabang_id = '{$cabang}'";*/
				$sqlSimpan="update b_kunjungan set pasien_id=$idPasien,asal_kunjungan=$asalMsk,ket='$ket',jenis_layanan=$jnsLayanan,unit_id=$tmpLayanan,retribusi='$retribusi',tgl='$tglKun',umur_thn='$thn',umur_bln='$bln',umur_hr='$hari',kelas_id='$kelas',kso_id=$statusPas,kso_kelas_id='$hakKelas',tgl_sjp='$tglSJP',no_sjp=$strNoSJP,no_anggota='$noAnggota',status_penj='$statusPenj',nama_peserta='$namaPKSO',pendidikan_id=$pend,pekerjaan_id=$pek,alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',kel_umur='$filterKelUmur',no_reg='$noreg1',flag='$flag' where id=$idKunj";
				// echo $sqlSimpan."<br>";
				$rs=mysql_query($sqlSimpan);
				if (mysql_errno()==0){
				
					$sqlAR = "update b_asal_masuk_kunjungan
								set puskesmas = '{$puskesmas}', 
									rumahsakit = '{$rumahsakit}',
									tgl_act = NOW(),
									user_act = {$userId}, flag='{$flag}'
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
						if ($rwGetPel['unit_id']==189){
							$sqlPelayananKonsul="DELETE FROM b_pelayanan WHERE kunjungan_id='$idKunj' AND unit_id IN (2,156,17,61,58)";
							mysql_query($sqlPelayananKonsul);
							//echo $sqlPelayananKonsul."<br>";
						}
						$sqlPel = "update b_pelayanan set no_antrian=(fGetMaxNo_Antrian($tmpLayanan,'$tglKun')),jenis_kunjungan='".$cJenisKunj."',jenis_layanan = $jnsLayanan, unit_id = $tmpLayanan,kso_id='$statusPas',kelas_id = $kelas, tgl = '$tglKun', dokter_tujuan_id = '".$_REQUEST['dokter_id']."', type_dokter_tujuan = '".$_REQUEST['dokterPengganti']."', flag='$flag' where id = '".$idPel."'";
					}else{
						$sqlPel = "update b_pelayanan set kso_id='$statusPas',kelas_id = $kelas, tgl = '$tglKun', dokter_tujuan_id = '".$_REQUEST['dokter_id']."', type_dokter_tujuan = '".$_REQUEST['dokterPengganti']."', flag='$flag' where id = '".$idPel."'";
					}
					//echo $sqlPel."<br>";
					mysql_query($sqlPel);
					if (mysql_errno()==0){
						//if ($rwGetPel['unit_id']!=$tmpLayanan && ){
						//}
						//hapus data b_tindakan_komponen kemudian insert data ke b_tindakan_komponen untuk updatenya
						$sqlGetTin = "delete from b_tindakan_komponen 
								where tindakan_id IN (SELECT id FROM b_tindakan where kunjungan_id=$idKunj)";
						// echo $sqlRetribusi."<br>";
						mysql_query($sqlGetTin);
						$sqlGetTin="DELETE FROM b_tindakan where kunjungan_id=$idKunj";
						//echo $sqlGetTin."<br>";
						$rsGetTin=mysql_query($sqlGetTin);
						$sqlGetTin="DELETE FROM b_tindakan_kamar 
								where pelayanan_id IN (SELECT id FROM b_pelayanan where kunjungan_id=$idKunj)";
						//echo $sqlGetTin."<br>";
						$rsGetTin=mysql_query($sqlGetTin);
						//$rwGetTin=mysql_fetch_array($rsGetTin);
						
						$tarip_utip=0;
						$ak_akun_utip=0;
										
						//dicek inap atau tidak
						if($inap == '0'){
							//=============== SKD ==================//
							$cSKD="0";
							if ($retribusi == "3078" || $retribusi == "3079"){
								$cSKD=$retribusi;
								$taripSKD=$tarip;
								
								$sqlGetTin = "SELECT 
												b.tarip tarip_ret,
												b.id as ms_tindakan_kelas_id, 
												a.* 
											FROM 
												b_ms_tindakan a
												INNER JOIN b_ms_tindakan_kelas b ON a.id =b.ms_tindakan_id
												INNER JOIN b_ms_tindakan_unit c ON c.ms_tindakan_kelas_id =b.id
											WHERE 
												c.ms_unit_id = {$tmpLayanan} 
												AND a.kel_tindakan_id = 66";
		
								$rsGetTin=mysql_query($sqlGetTin);
								$rwGetTin=mysql_fetch_array($rsGetTin);
								
								$idTindAdm=$rwGetTin['ms_tindakan_kelas_id'];
								$ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
								$tarip=$rwGetTin['tarip_ret'];
		
							}else{
								
								$sqlGetTin="SELECT 
												a.*,
												b.ak_ms_unit_id
											FROM 
												b_ms_tindakan_kelas a
												INNER JOIN b_ms_tindakan b ON a.ms_tindakan_id =b.id		
											WHERE 
												a.id = {$retribusi} 
												AND a.ms_kelas_id = {$kelas}";
											
								$rsGetTin=mysql_query($sqlGetTin);
								$rwGetTin=mysql_fetch_array($rsGetTin);
		
								$idTindAdm=$rwGetTin['id'];
								$ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
								$tarip_utip=$rwGetTin['tarip_utip'];
								$ak_akun_utip=$rwGetTin['ak_akun_utip'];
							}
			
							$beban_kso = 0;
							$beban_pasien = 0;
							$bayar_pasien = 0;
							$bayar_kso = 0;
							$bayar = 0;
							$lunas = 0;
							// echo $statusPas."<br>";
							if($statusPas == '1') {
								$beban_pasien = $tarip;
							}
							else {
								$beban_kso = $tarip;
							}
							//dicek apakah retribusi sama dengan data sebelumnya,bila data sama maka tidak melakukan update
							if($tarip == 0) {//=========Jika Tarip =0 
								if ($prev_stat=="1") {			
									//$sqlRetribusi = "DELETE FROM b_bayar_tindakan WHERE tindakan_id='".$rwGetTin['id']."' AND tipe=0";
									$sqlRetribusi = "DELETE FROM b_bayar_tindakan 
												WHERE tindakan_id IN (SELECT id FROM b_bayar WHERE kunjungan_id='$idKunj')";
									// echo $sqlRetribusi."<br>";
									mysql_query($sqlRetribusi);

									$sqlRetribusi = "DELETE FROM b_bayar WHERE kunjungan_id='$idKunj'";
									// echo $sqlRetribusi."<br>";
									mysql_query($sqlRetribusi);
								}
							}
							else {
								//insert Retribusi ke b_tindakan
								$sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,ak_akun_utip,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_utip,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$idTindAdm."','".$tmpLayanan."','".$ak_ms_unit_id."','$ak_akun_utip','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$tarip.",'$beban_pasien','$tarip_utip','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
								//echo $sqlRetribusi."<br>";
								mysql_query($sqlRetribusi);
								if (mysql_errno()==0){
									//insert ke b_tindakan_komponen
									$idTindRet=mysql_insert_id();
					
									$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindRet."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b 
									inner join b_ms_komponen k on b.ms_komponen_id=k.id
									where b.ms_tindakan_kelas_id='".$idTindAdm."'";
									//echo $sqlTambah."<br>";
									mysql_query($sqlTambah);
								}else{
									$statusProses='Error';
								}

								
								if ($retribusi=="3078" || $retribusi=="3079"){
									//Insert Biaya SKD
									$sqlGetTinSKD="SELECT 
										a.*,
										b.ak_ms_unit_id 
										FROM 
										b_ms_tindakan_kelas a
										INNER JOIN b_ms_tindakan b ON a.ms_tindakan_id = b.id		
										WHERE 
											a.id = {$retribusi} 
											and a.ms_kelas_id= {$kelas}";

									$sqlR1=mysql_query($sqlGetTinSKD);
									$sqlR2=mysql_fetch_array($sqlR1);
									$taripR = $taripSKD;
									$KlsIdR = $sqlR2['id'];
									$ak_ms_unit_id=$sqlR2['ak_ms_unit_id'];
									
									if($statusPas==1){
										$BiayaRP = $taripR;
										$BiayaRK = 0;
									}else{
										$BiayaRP = 0;
										$BiayaRK = $taripR;
									}
									
									$sqlRet="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$KlsIdR."','".$tmpLayanan."','".$ak_ms_unit_id."','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$taripR.",'$BiayaRP','$BiayaRK','0','0','0','0','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
									//echo $sqlRetribusi."<br>";
									mysql_query($sqlRet);
								
									if (mysql_errno()==0){
										$idTindSKD=mysql_insert_id();
										/*$getIdTindR="select max(id) as id from b_tindakan where pelayanan_id='".$idPel."' and kunjungan_id='".$idKunj."' and user_act=$userId";
										//echo $getIdTind."<br/>";
										$rsIdTindR=mysql_query($getIdTindR);
										$rwIdTindR=mysql_fetch_array($rsIdTindR);*/
						
										$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindSKD."',k.id,k.nama ,$taripR,b.tarip_prosen FROM b_ms_tindakan_komponen b 
										inner join b_ms_komponen k on b.ms_komponen_id=k.id
										where b.ms_tindakan_kelas_id='".$KlsIdR."'";
										//echo $sqlTambah."<br>";
										mysql_query($sqlTambah);
									}else{
										$statusProses='Error';
									}
								 //END Insert Retribusi SKD
								 }
							}
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
									, tarip = '".$rowKamar['tarip']."',beban_pasien='".$beban_pasien."',beban_kso='".$beban_kso."', kelas_id = '".$kelas."', flag='$flag' where pelayanan_id = '".$rwGetPel['id']."'";
									//echo $sqlKamar."<br>";
									$rsKamar = mysql_query($sqlKamar);
									if (mysql_errno()>0){
										//echo "13";
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
					
										$sqlKamar = "insert into b_tindakan_kamar (pelayanan_id, unit_id_asal, kso_id,tgl_in, kamar_id, kode, nama, tarip, beban_pasien, beban_kso, kelas_id, flag)
												values ('".$rwGetPel['id']."','".$asal."','".$statusPas."', CONCAT('$tglKun',' ',CURRENT_TIME()), '$kamar', '".$rowKamar['kode']."', '".$rowKamar['nama']."', '".$rowKamar['tarip']."', '$beban_pasien', '$beban_kso', '".$rowKamar['kelas_id']."','$flag')";
										mysql_query($sqlKamar);
										if (mysql_errno()>0){
											//echo "5";
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
						//echo "3";
						$statusProses='Error';
					}
				}else{
					//echo "2";
					$statusProses='Error';
				}
	
				/*if($tarip>0 && $inap == 0){
					$tarif_perda = $tarip;
					$tarif_pk = $beban_kso.'|'.$beban_pasien;
					//forAkun('edit',$tarif_perda.'|'.$tarif_pk,'reg',$asal,$noBil.'.'.$asal,$jnsLayanan,$tmpLayanan,$statusPas);
				}*/
	
				//mysql_free_result($rsGetStat);
				//mysql_free_result($rsGetTin);
			}
		}else{
			//echo "1";
			$statusProses='Error';
		}
        break;
        case "tambahpcr" :
            $isbarupcr = 0;
			/**
			 * @author farhanismul
			 * 
             * Cek apakah pasien sudah pernah terdaftar pada rs
             */
            $sqlCekPasienDiRs = "SELECT * FROM b_pasien_klinik_pcr WHERE id_pasien_klinik = {$idPasien}";
            $queryCekPasienDiRs = mysql_query($sqlCekPasienDiRs);
            if(mysql_num_rows($queryCekPasienDiRs) > 0){
                $dataPasienKlinik = mysql_fetch_assoc($queryCekPasienDiRs);
                $sqlPelayanan = "SELECT
                                    p.id 
                                FROM
                                    b_pelayanan p
                                    INNER JOIN b_kunjungan k ON p.kunjungan_id = k.id 
                                    AND k.cabang_id = '{$cabang}' 
                                WHERE
                                    p.pasien_id = {$dataPasienKlinik['id_pasien_rs']} 
                                    AND p.unit_id = '{$tmpLayanan}' 
                                    AND p.jenis_layanan <> '44' 
                                    AND p.tgl = '{$tglKun}'";
                $queryCek = mysql_query($sqlPelayanan);
                if(mysql_num_rows($queryCek) > 0){
                    echo "0".chr(5).chr(4).chr(5)."Sudah Ada";
                    mysql_free_result($queryCek);
                    return;
                }
			   
				/**
                 * Jika ada maka update status pasien
                 * menjadi active
                 */
                $sqlUpdateStatusPasien = "UPDATE b_ms_pasien 
                                            SET nama = '{$nama}',
                                            sex = '{$gender}',
                                            agama = '{$agama}',
                                            tgl_lahir = '{$tglLhr}',
                                            alamat = '{$alamat}',
                                            rt = '{$rt}',
                                            rw = '{$rw}',
                                            desa_id = '{$desa}',
                                            kec_id = '{$kec}',
                                            kab_id = '{$kab}',
                                            prop_id = '{$prop}',
                                            telp = '{$telp}',
                                            ".(($pend=='0')?'':" pendidikan_id = '{$pend}',
                                            ").(($pek=='0')?'':" pekerjaan_id = '{$pek}',
                                            ")." nama_ortu = '{$namaOrtu}',
                                            nama_suami_istri = '{$namaSuTri}',
                                            no_ktp = '{$noKTP}',
                                            gol_darah = '{$darah}',
                                            id_kw = '{$kw}',
                                            flag = '{$flag}' 
                                            WHERE
                                                id = {$dataPasienKlinik['id_pasien_rs']} 
												AND cabang_id = '{$cabang}'";
				echo $sqlPelayanan . '--- Pasien';
                mysql_query($sqlUpdateStatusPasien);
				$isbarupcr = 0;
				$idPasien = $dataPasienKlinik['id_pasien_rs'];
            }else{
				/**
				 * Karena pasien belum terdapaftar di rs maka get no rm terbaru
				 */
                $no_rm = no_rm($cabang);
                
                /*
                 * Cek apakah no rm tersebut sudah ada pada pasien yang lain atau belum
                 */
                $sqlCekNoRm = "SELECT * FROM b_ms_pasien WHERE no_rm = '{$no_rm}' AND cabang_id = {$cabang} LIMIT 0,10";
                $querCekNoRm = mysql_query($sqlCekNoRm);
                if(mysql_num_rows($querCekNoRm) <= 0){
                    if(strlen($no_rm) < 8) {
                        for($i = strlen($no_rm); $i < 8; $i++){
                            $no_rm = "0" . $no_rm;
                        }
                    }
                }else{
					/**
					 * Jika sudah ada yang punya maka increment 1
					 */
                    $sqlNoRm = "SELECT IFNULL(MAX(no_rm)+1,1) as next_no_rm FROM b_ms_pasien WHERE LENGTH(no_rm) = 8 AND cabang_id = {$cabang}";
                    $query = mysql_query($sqlNoRm);
                    $fetch = mysql_fetch_assoc($query);

                    $no_rm = $fetch['next_no_rm'];

                    if($no_rm == "10000000"){
                        $sqlNoRm = "SELECT IFNULL(MAX(no_rm)+1,1) as next_no_rm FROM b_ms_pasien WHERE LENGTH(no_rm) = 8 AND cabang_id = {$cabang}";
                        $query = mysql_query($sqlNoRm);
                        $fetch = mysql_fetch_assoc($query);
                        $no_rm = $fetch['next_no_rm'];
                    }else{
                        if(strlen($no_rm) < 8){
                            for($i = $strlen; $i < 8; $i++){
                                $no_rm = "0". $no_rm;
                            }
                        }
                    }
                }
				/**
				 * Masukan pasien jika ia belum terdaftar pada rumah sakit
				 */
                $sqlTambahPasien = "INSERT INTO b_ms_pasien(no_rm,no_ktp,nama,sex,agama,tgl_lahir,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,telp,pendidikan_id,pekerjaan_id,nama_ortu,nama_suami_istri,user_act,tgl_act,gol_darah,id_kw,cabang_id,flag)VALUES('{$no_rm}','{$noKTP}','${nama}','{$gender}','{$agama}','{$tglLhr}','{$alamat}','{$rt}','{$rw}','{$desa}','{$kec}','{$kab}','{$prop}','{$telp}','{$pend}','{$pek}','{$namaOrtu}','{$namaSuTri}','{$userId}','{$tglact}','{$darah}','{$kw}',{$cabang},'{$flag}')";
				$query = mysql_query($sqlTambahPasien);
                /**
                 * Get id pasien yang baru saja dimasukan untuk dimasukan ke
                 * dalam table kunjungan dan pelayanan
                 */
                $sqlGetIdPasien = "SELECT MAX(id) AS id FROM b_ms_pasien WHERE user_act = {$userId} AND cabang_id = {$cabang}";
                $query = mysql_query($sqlGetIdPasien);
                $fetch = mysql_fetch_assoc($query);
                $idPasien = $fetch['id'];
				$isbarupcr = 1;
            }

			/**
			 * cek apakah pasien tersebut sudah terdaftar idPasien nya
			 * 
			 */
            $sqlKsoPasien = "SELECT * FROM b_ms_kso_pasien WHERE pasien_id = {$idPasien}";
            $queryCekKsoPasien = mysql_query($sqlKsoPasien);
			
			if(mysql_num_rows($queryCekKsoPasien) == 0){
				/**
				 * Jika belum ada cari kso sesuai yang dipilih oleh user
				 * @var $statusPas : berisi kso id
				 */
                $sqlGetKsoPasien = "SELECT id,kode FROM b_ms_kso WHERE id = {$statusPas}";
                $query = mysql_query($sqlGetKsoPasien);
                $fetch = mysql_fetch_assoc($query);

                /**
                 * Masukan ke b_ms_kso_pasien, karena pasien dengan id ini
                 * Kso nya belum tercatat
                 */

                $sqlInsertKsoPasien = "INSERT INTO b_ms_kso_pasien(kso_id,pasien_id,kelas_id,kodepenjamin,no_anggota,st_anggota,nama_peserta,kode_ppk,kodepersonel,tgl_act,flag) VALUES ({$statusPas},{$idPasien},{$hakKelas},'".$rwGetKso['kode']."','{$noAnggota}','{$statusPenj}','{$namaPKSO}','{$kodeppk}',{$userId},'{$tglact}','{$flag}')";
                $queryInsertKso = mysql_query($sqlInsertKsoPasien);
				mysql_free_result($query);
				
            }elseif($statusPas == "4" && $kodeppk != ""){
                $sqlUpdateKso="UPDATE b_ms_kso_pasien SET kso_id=$statusPas,kelas_id=$hakKelas,no_anggota='$noAnggota',st_anggota='$statusPenj',nama_peserta='$namaPKSO',kode_ppk='$kodeppk',flag='$flag' WHERE pasien_id=$idPasien";
                $rsUpdateKso=mysql_query($sqlUpdateKso);
            }
            mysql_free_result($queryCekKsoPasien);

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
		
		/**
		 * Get no billing yang akan digunakan saat pasien sudah checkput
		 */
        $sqlBil = "SELECT IFNULL(MAX(no_billing)+1,1) AS no_billing FROM b_kunjungan";
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
        /**
		 * Sql masukan data table kunjungan
		 * 
		 * @var $idPasien akan dimasukan ke dalam table b_kunjungan
		 */
        $sqlKunj="INSERT INTO b_kunjungan (
                        no_billing,
                        loket_id,
                        pasien_id,
                        asal_kunjungan,
                        ket,
                        jenis_layanan,
                        unit_id,
                        retribusi,
                        tgl,
                        umur_thn,
                        umur_bln,
                        umur_hr,
                        kel_umur,
                        kelas_id,
                        kso_id,
                        kso_kelas_id,
                        tgl_sjp,
                        no_sjp,
                        no_anggota,
                        status_penj,
                        nama_peserta,
                        diag_awal,
                        pendidikan_id,
                        pekerjaan_id,
                        alamat,
                        rt,
                        rw,
                        desa_id,
                        kec_id,
                        kab_id,
                        prop_id,
                        isbaru,
                        tgl_act,
                        user_act,
                        no_reg,
                        cabang_id,
                        flag 
                    )
                    VALUES
                        (
						'{$noBil}',
						'{$asal}',
						$idPasien,
						$asalMsk,
						'{$ket}',
						$jnsLayanan,
						$tmpLayanan,
						'{$retribusi}',
						'{$tglKun}',
						'{$thn}',
						'{$bln}',
						'{$hari}',
						'".$filterKelUmur."',
						'{$kelas}',
						'{$statusPas}',
						'{$hakKelas}',
						'{$tglSJP}',
						$strNoSJP,
						'{$noAnggota}',
						'{$statusPenj}',
						'{$namaPKSO}',
						'{$diagAwal}',
						$pend,
						$pek,
						'{$alamat}',
						'{$rt}',
						'{$rw}',
						'{$desa}',
						'{$kec}',
						'{$kab}',
						'{$prop}',
						{$isbarupcr},
						NOW(),
						$userId,
						'{$noreg1}',
						{$cabang},
						'{$flag}'
					)";
		echo $sqlKunj . '--- Kunjungan';
		$rsKunj=mysql_query($sqlKunj);
		/**
		 * Jika berhasil memasukan data ke dalam table b_kunjungan
		 * 
		 * Lalu akan di lanjutkan untuk memasukan data ke table b_pelayanan
		 */
        if (mysql_affected_rows() > 0){
			/**
			 * @var $idKunj : id dari data kunjungan yang baru saja kita masukan
			 */
            $idKunj=mysql_insert_id();
			
			$sqlGetKunj = "SELECT unit_id FROM b_kunjungan WHERE id = {$idKunj}";
            $rsGetKunj = mysql_query($sqlGetKunj);
			$rwGetKunj = mysql_fetch_array($rsGetKunj);
			
            $mcu_id = $rwGetKunj['unit_id'];
            
            /* Save asal rujukan/masuk Puskesmas/RS */
            $sqlAR = "INSERT INTO b_asal_masuk_kunjungan(idKunj, puskesmas, rumahsakit, tgl_act, user_act,flag) VALUE ({$idKunj},'{$puskesmas}','{$rumahsakit}', NOW(), {$userId}, '{$flag}')";
            $queryAR = mysql_query($sqlAR);
            
            $cJenisKunj=1;
            if ($inap == 1){
                $cJenisKunj=3;
            }else if ($jnsLayanan=="4"){
                $cJenisKunj=2;
            }

			/**
			 * Masukan table b_pelayanan
			 * @function fGetMaxNo_Antrian : digunakan untuk mendapatkan no antrian untuk pasien
			 */
            $sqlPelayanan="INSERT INTO b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan,flag) VALUES ((fGetMaxNo_Antrian({$tmpLayanan},'{$tglKun}')),'".$cJenisKunj."',{$idPasien},'{$asal}','".$idKunj."',{$jnsLayanan},{$tmpLayanan},{$statusPas},{$kelas},'{$tglKun}',0,NOW(),{$userId},'".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."','{$flag}')";
			echo $sqlPelayanan . '--- Pelayanan';
			mysql_query($sqlPelayanan);
            $idPelayanan = mysql_insert_id();
            if (mysql_errno()==0){
                $idPel=mysql_insert_id();
                $tarip_utip=0;
                $ak_akun_utip=0;

                $cSKD="0";
                if ($retribusi == "1315" || $retribusi == "1316"){
                    $cSKD=$retribusi;
                    $taripSKD=$tarip;
                    
                    $sqlGetTin = "SELECT b.`tarip` tarip_ret ,b.id as ms_tindakan_kelas_id, a.* FROM b_ms_tindakan a
                        INNER JOIN `b_ms_tindakan_kelas` b ON a.`id`=b.`ms_tindakan_id`
                        INNER JOIN `b_ms_tindakan_unit` c ON c.`ms_tindakan_kelas_id`=b.`id`
                        WHERE c.`ms_unit_id`='$tmpLayanan' AND a.`kel_tindakan_id`=66";
                    //echo $sqlGetTin;
                    $rsGetTin=mysql_query($sqlGetTin);
                    $rwGetTin=mysql_fetch_array($rsGetTin);
                    $idTindAdm=$rwGetTin['ms_tindakan_kelas_id'];
                    $ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
                    $tarip=$rwGetTin['tarip_ret'];
                }else{
                    $sqlGetTin="SELECT a.*,b.`ak_ms_unit_id` 
                                FROM b_ms_tindakan_kelas a
                                    INNER JOIN b_ms_tindakan b ON a.`ms_tindakan_id`=b.`id`     
                                WHERE a.ms_tindakan_id='$retribusi' and a.ms_kelas_id=$kelas";
                    //echo $sqlGetTin;
                    $rsGetTin=mysql_query($sqlGetTin);
                    $rwGetTin=mysql_fetch_array($rsGetTin);
                    $idTindAdm=$rwGetTin['id'];
                    $ak_ms_unit_id=$rwGetTin['ak_ms_unit_id'];
                    $tarip_utip=$rwGetTin['tarip_utip'];
                    $ak_akun_utip=$rwGetTin['ak_akun_utip'];

                    $beban_kso = 0;
                    $beban_pasien = 0;
                    $bayar_pasien = 0;
                    $bayar_kso = 0;
                    $bayar = 0;
                    $lunas = 0;
        
                    if($statusPas == '1') {
                        $beban_pasien = $tarip;
                    }
                    else {
                        $beban_kso = $tarip;
                    }
        
                    if($tarip != 0) {
                        //insert Retribusi ke b_tindakan
                        $sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,ak_akun_utip,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_utip,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$idTindAdm."','".$tmpLayanan."','".$ak_ms_unit_id."','$ak_akun_utip','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$tarip.",'$beban_pasien','$tarip_utip','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$_REQUEST['dokter_id']."','".$_REQUEST['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
                        //echo $sqlRetribusi."<br>";
                        mysql_query($sqlRetribusi);
                        if (mysql_errno()==0){
                            //insert ke b_tindakan_komponen
                            $idTindRet=mysql_insert_id();
                            $sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$idTindRet."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b 
                            inner join b_ms_komponen k on b.ms_komponen_id=k.id
                            where b.ms_tindakan_kelas_id='".$idTindAdm."'";
                            //echo $sqlTambah."<br>";
                            mysql_query($sqlTambah);
                        }else{
                            $statusProses='Error';
                        }
                    } 
                }

            }
			
			/**
			 * Insert to b_pasiek_klinik pcr
			 * untuk mencatat apakah pasien sudah pernah daftar di rs
			 */

			$sqlCatatPasien = "INSERT INTO b_pasien_klinik_pcr(id_pasien_klinik,no_rm_pasien_klinik,tanggal_act,user_id,id_pasien_rs,id_pelayanan,id_kunjungan,status,id_pelayanan_klinik,id_kunjungan_klinik) VALUES ({$_REQUEST['id_pasien_klinik']},'".$_REQUEST['no_rm_pasien_klinik']."',now(),{$userId},{$idPasien},{$idPelayanan},{$idKunj},1,{$_REQUEST['id_pelayanan_klinik']},{$_REQUEST['id_kunjungan_klinik']})";
			echo $sqlCatatPasien . '--- Klinik Pcr';
			mysql_query($sqlCatatPasien);
        }else{
            $statusProses = "Error";
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
(SELECT tk.tarip tarip_r,k.id,k.pasien_id,p.no_rm,p.no_ktp,k.no_billing,UPPER(p.nama) as nama,p.tgl_lahir,UPPER(p.alamat) as alamat,p.rt,p.rw,p.desa_id,p.kec_id,p.kab_id,p.prop_id,p.id_kw,
UPPER(p.nama_ortu) as nama_ortu,UPPER(p.nama_suami_istri) as nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp,DATE(k.tgl) AS tgl,k.asal_kunjungan,
k.ket,k.umur_thn,k.umur_bln,k.umur_hr,k.jenis_layanan AS id_jenis_layanan,k.unit_id,u.nama AS tempat_layanan,k.kelas_id,l.nama AS kelas,
k.kso_id,k.kso_kelas_id,tgl_sjp,no_sjp,no_anggota,kso.nama AS nama_kso,k.retribusi,inap,k.dilayani,k.dokter_tujuan_id,k.type_dokter_tujuan,
(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
k.no_reg, p.gol_darah 
FROM (SELECT k.*,pl.dilayani,pl.dokter_tujuan_id,pl.type_dokter_tujuan FROM b_kunjungan k INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id 
WHERE k.loket_id = '$asal' AND k.flag='$flag' AND pl.unit_id_asal='$asal' ".$saringan.$user.") k 
INNER JOIN b_ms_pasien p ON k.pasien_id=p.id INNER JOIN b_ms_unit u ON k.unit_id=u.id 
INNER JOIN b_ms_kelas l ON k.kelas_id=l.id LEFT JOIN b_ms_kso kso ON kso.id=k.kso_id
INNER JOIN b_ms_tindakan_kelas tk ON k.retribusi = tk.id) AS t1 
INNER JOIN b_ms_unit n ON t1.id_jenis_layanan=n.id) AS gab ".$filter." ORDER BY ".$sorting;
    }
	
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
		if($rows['retribusi'] == 198) $ms_tindKelas = 199;
		else if($rows['retribusi'] == 1315) $ms_tindKelas = 3078;
		else if($rows['retribusi'] == 1316) $ms_tindKelas = 3079;
		else if($rows['retribusi'] == 829) $ms_tindKelas = 765;
		else $ms_tindKelas = $rows['retribusi'];
		
		$sqlGetTarifRetribusi = mysql_query("SELECT biaya FROM b_tindakan WHERE kunjungan_id = {$rows['id']} AND ms_tindakan_kelas_id = {$ms_tindKelas}");
		
		$fetchTarif = mysql_fetch_assoc($sqlGetTarifRetribusi);
		
		$sqlAR = "select * from b_asal_masuk_kunjungan where idKunj = ".$rows['id'];
			$queryAR = mysql_query($sqlAR);
			while($rowAR = mysql_fetch_array($queryAR)){
				$puskesmas = $rowAR['puskesmas'];
				$rumahsakit = $rowAR['rumahsakit'];
			}
		
            $sisipan = $rows['id']."|".$rows['pasien_id']."|".$rows['no_rm']."|".$rows['no_billing']."|".tglSQL($rows['tgl_lahir'])."|".$rows['alamat']."|".$rows['rt']."|".$rows['rw']."|".$rows['desa_id']."|".$rows['kec_id']."|".$rows['kab_id']."|".$rows['prop_id']."|".$rows['nama_ortu']."|".$rows['nama_suami_istri']."|".$rows['sex']."|".$rows['pendidikan_id']."|".$rows['pekerjaan_id']."|".$rows['agama']."|".$rows['telp'];
            $sisipan .= "|".tglSQL($rows['tgl'])."|".$rows['umur_thn']."|".$rows['umur_bln']."|".$rows['id_jenis_layanan']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['kso_id']."|".tglSQL($rows['tgl_sjp'])."|".$rows['no_sjp']."|".$rows['no_anggota']."|".$rows['asal_kunjungan']."|".$rows['ket']."|".$rows['nama_kso']."|".$rows['retribusi']."|".$rows['kso_kelas_id'].'|'.$rows['inap'].'|'.$rows['no_billing']."|".$rows['dilayani']."|".$rows['no_ktp']."|".$rows['dokter_tujuan_id']."|".$rows['type_dokter_tujuan']."|".$rows['umur_hr']."|".$rows['desa']."|".$rows['kec']."|".$rows['kab']."|".$rows['prop']."|".$rows['no_reg']."|".$rows['gol_darah']."|".$puskesmas."|".$rumahsakit."|".$rows['id_kw']."|".$rows['tarip_r'];
            $i++;
			
			$sDokter = "select nama as dokter from b_ms_pegawai where id = '".$rows['dokter_tujuan_id']."'";
			$Dokter = mysql_fetch_array(mysql_query($sDokter));
			
			if($rows['dilayani']==1)
			{
				$dt.=$sisipan.chr(3)."<span style='color:#F00'>".number_format($i,0,",","")."</span>".chr(3)."<span style='color:#F00'>".$rows['no_rm']."</span>".chr(3)."<span style='color:#F00'>".$rows["nama"]."</span>".chr(3)."<span style='color:#F00'>".$rows["nama_kso"]."</span>".chr(3)."<span style='color:#F00'>".$rows["tempat_layanan"]."</span>".chr(3)."<span style='color:#F00'>".number_format($fetchTarif["biaya"],0,",",".")."</span>".chr(3)."<span style='color:#F00'>".$Dokter["dokter"]."</span>".chr(3)."<span style='color:#F00'>".$rows["kelas"]."</span>".chr(3)."<span style='color:#F00'>".$rows["alamat"]." RT. ".$rows["rt"]." RW. ".$rows['rw']."</span>".chr(6);
			}else{
				$dt.=$sisipan.chr(3).$i.chr(3).$rows['no_rm'].chr(3).$rows["nama"].chr(3).$rows["nama_kso"].chr(3).$rows["tempat_layanan"].chr(3).number_format($fetchTarif["biaya"],0,",",".").chr(3).$Dokter["dokter"].chr(3).$rows["kelas"].chr(3).$rows["alamat"]." RT. ".$rows["rt"]." RW. ".$rows['rw'].chr(6);
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
