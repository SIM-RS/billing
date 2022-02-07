<?php
include("../koneksi/konek.php");
include("../sesi.php");
//include 'forAkun.php';
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$grd = $_REQUEST["grd"];
$dataArr = $_REQUEST['dataArr'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id desc";
$sorting=$_REQUEST["sorting"];
$saringan=$_REQUEST["saringan"];
$filter=$_REQUEST["filter"];
//===============================

//=================================================================

$diagAwal = $_REQUEST['diagAwal'];
if ($diagAwal=="") $diagAwal=0;
$kodeppk = $_REQUEST['kodeppk'];
$namaPKSO = $_REQUEST['namaPKSO'];
if ($namaPKSO=="") $namaPKSO=$nama;

$sqlRef = "select * from b_ms_reference where stref = 22";
$rsRef = mysql_query($sqlRef);
$rowRef = mysql_fetch_array($rsRef);
$ref = $rowRef['nama'];
$sqlRef = "select * from b_ms_reference where stref = 25";
$rsRef = mysql_query($sqlRef);
$rowRef = mysql_fetch_array($rsRef);
$loketRet = $rowRef['aktif'];
$noreg1 = $_REQUEST['noreg1'];
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
    // echo $rows['no_rm']."|".$rows['nama'];
    return;
}

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

$statusProses='';

switch (strtolower($_REQUEST['act'])) {
    case "tambahpcr" :
            for($i = 0; $i < sizeof($dataArr); $i++){
                $idPasien = $dataArr[$i]['idPasien'];
                $idKunj = $dataArr[$i]['idKunj'];
                $noRm = $dataArr[$i]['noRm'];
                $noKTP = $dataArr[$i]['noKTP'];
                $noBil = $dataArr[$i]['noBil'];
                $nama = addslashes($dataArr[$i]['nama']); 
                $namaOrtu = addslashes($dataArr[$i]['namaOrtu']); 
                $namaSuTri = addslashes($dataArr[$i]['namaSuTri']);
                $gender = $dataArr[$i]['gender']; 
                $pend = $dataArr[$i]['pend']; 
                $pek = $dataArr[$i]['pek'];
                $agama = $dataArr[$i]['agama'];
                $tglLhr = tglSQL($dataArr[$i]['tglLhr']); 
                $thn = $dataArr[$i]['thn']; 
                $bln = $dataArr[$i]['bln']; 
                $hari = $dataArr[$i]['hari']; 
                $tglKun = tglSQL($dataArr[$i]['tglKun']); 
                $alamat = addslashes($dataArr[$i]['alamat']);
                $telp = $dataArr[$i]['telp'];
                $rt = $dataArr[$i]['rt'];
                $rw = $dataArr[$i]['rw'];
                $asalMsk = $dataArr[$i]['asalMsk']; 
                $prop = $dataArr[$i]['prop']; 
                $ket = $dataArr[$i]['ket']; 
                $kab = $dataArr[$i]['kab']; 
                $statusPas = $dataArr[$i]['statusPas']; 
                $kec = $dataArr[$i]['kec']; 
                $tglSJP = tglSQL($dataArr[$i]['tglSJP']);
                $desa = $dataArr[$i]['desa']; 
                $noSJP = $dataArr[$i]['noSJP']; 
                $jnsLayanan = $dataArr[$i]['jnsLayanan']; 
                $tmpLayanan = $dataArr[$i]['tmpLayanan']; 
                $kelas = $dataArr[$i]['kelas'];
                $retribusi = $dataArr[$i]['retribusi'];
                $tarip = $dataArr[$i]['tarip'];
                $penjamin = $dataArr[$i]['penjamin']; 
                $noAnggota = $dataArr[$i]['noAnggota']; 
                $hakKelas = $dataArr[$i]['hakKelas']; 
                $statusPenj = $dataArr[$i]['statusPenj'];
                $inap = $dataArr[$i]['inap'];
                $kamar = $dataArr[$i]['kamar'];
                $asal = $dataArr[$i]['asal'];
                $userLog = $dataArr[$i]['userLog'];
                $darah = $dataArr[$i]['darah'];
                $puskesmas = $dataArr[$i]['pusk'];
                $kw = $dataArr[$i]['kw'];
                $cabang = ($dataArr[$i]['cabang'] > 0) ? $dataArr[$i]['cabang'] : 1 ;
                $userId=$dataArr[$i]['userId'];

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
                        // echo "0".chr(5).chr(4).chr(5)."Sudah Ada";
                        $databalik = [
                            'status' => 0,
                            'Messages' => 'Pasien sudah ada',
                        ];
                        echo json_encode($databalik);
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
                    // echo $sqlPelayanan . '--- Pasien';
                    $exeQuery = mysql_query($sqlUpdateStatusPasien);
                    if($exeQuery) $statusProses = "Berhasil";
                    else $statusProses = "Error";
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
                    if($query) $statusProses = "Berhasil";
                    else $statusProses = "Error";
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
            // echo $sqlKunj . '--- Kunjungan';
            $rsKunj=mysql_query($sqlKunj);
            if($rsKunj) $statusProses = "Berhasil";
            else $statusProses = "Error";
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
                $sqlPelayanan="INSERT INTO b_pelayanan (no_antrian,jenis_kunjungan,pasien_id,unit_id_asal,kunjungan_id,jenis_layanan,unit_id,kso_id,kelas_id,tgl,dilayani,tgl_act,user_act,dokter_tujuan_id,type_dokter_tujuan,flag) VALUES ((fGetMaxNo_Antrian({$tmpLayanan},'{$tglKun}')),'".$cJenisKunj."',{$idPasien},'{$asal}','".$idKunj."',{$jnsLayanan},{$tmpLayanan},{$statusPas},{$kelas},'{$tglKun}',0,NOW(),{$userId},'".$dataArr[$i]['dokter_id']."','".$dataArr[$i]['dokterPengganti']."','{$flag}')";
                // echo $sqlPelayanan . '--- Pelayanan';
                $exeQuery = mysql_query($sqlPelayanan);
                if($exeQuery) $statusProses = "Berhasil";
                else $statusProses = "Error";
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
            
                        if($tarip == 0) {
                            //insert Retribusi ke b_tindakan
                            $sqlRetribusi="insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,ak_ms_unit_id,ak_akun_utip,jenis_kunjungan,kunjungan_id,pelayanan_id,kso_id,kso_kelas_id,kelas_id,tgl,biaya,biaya_pasien,biaya_utip,biaya_kso,bayar,bayar_kso,bayar_pasien,lunas,user_id,type_dokter,tgl_act,user_act,unit_act,flag) values('".$idTindAdm."','".$tmpLayanan."','".$ak_ms_unit_id."','$ak_akun_utip','".$cJenisKunj."','".$idKunj."',".$idPel.",'".$statusPas."','".$hakKelas."','$kelas','$tglKun',".$tarip.",'$beban_pasien','$tarip_utip','$beban_kso',".$bayar.",'$bayar_kso','$bayar_pasien','$lunas','".$dataArr[$i]['dokter_id']."','".$dataArr[$i]['dokterPengganti']."',NOW(),$userId,$asal,'$flag')";
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

                $sqlCatatPasien = "INSERT INTO b_pasien_klinik_pcr(id_pasien_klinik,no_rm_pasien_klinik,tanggal_act,user_id,id_pasien_rs,id_pelayanan,id_kunjungan,status,id_pelayanan_klinik,id_kunjungan_klinik) VALUES ({$dataArr[$i]['id_pasien_klinik']},'".$dataArr[$i]['no_rm_pasien_klinik']."',now(),{$userId},{$idPasien},{$idPelayanan},{$idKunj},1,{$dataArr[$i]['id_pelayanan_klinik']},{$dataArr[$i]['id_kunjungan_klinik']})";
                // echo $sqlCatatPasien . '--- Klinik Pcr';
                $exeQuery = mysql_query($sqlCatatPasien);
                if($exeQuery) $statusProses = "Berhasil";
                else $statusProses = "Error";
            }else{
                $statusProses = "Error";
            }



            }
        break;
    
    default:
        // code...
        break;
}

if($statusProses == "Berhasil"){
    $databalik = [
        'status' => 1,
        'Messages' => 'Berhasil memasukan data pasien',
    ];
    echo json_encode($databalik);
}else{
    $databalik = [
        'status' => 0,
        'Messages' => 'Berhasil memasukan data pasien',
    ];
    echo json_encode($databalik);
}

?>