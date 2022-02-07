<?php

include_once "koneksi.php";

class Antrian_model extends Koneksi {
    private $table = "auth_antrian";

    public function getNomorAntrianBaru($unit_id, $tanggal){
        $sql = "SELECT 
            IFNULL(MAX(no_antrian) + 1, 1) as max_no_antrian 
            FROM `auth_antrian` 
            WHERE tanggal_periksa = '{$tanggal}' AND unit_id = '{$unit_id}'";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        return $data['max_no_antrian'];
    }

    public function getTotalPasien($unit_id, $tanggal, $polieksekutif = null, $only_jkn = true){
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE unit_id = '{$unit_id}' AND tanggal_periksa = '{$tanggal}'";
        // if($polieksekutif != null) $sql .= " AND poli_eksekutif = '{$polieksekutif}'";
        if($only_jkn)
            $sql .= "  AND nomor_referensi IS NOT NULL";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        return (int)$data['total'];
    }

    public function sudahTerlayani($unit_id, $tanggal, $polieksekutif = null, $only_jkn = true){
        $sql = "SELECT IFNULL(MAX(no_antrian), 0) AS antriansudahterlayani 
            FROM auth_antrian 
            WHERE tanggal_periksa = '{$tanggal}' AND unit_id = '{$unit_id}' AND sudah_dilayani = 1";
        // if($polieksekutif != null) $sql .= " AND poli_eksekutif = '{$polieksekutif}'";
        if($only_jkn)
            $sql .= "  AND nomor_referensi IS NOT NULL";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        return (int)$data['antriansudahterlayani'];
    }

    public function getLastUpdateRekap($unit_id, $tanggal, $polieksekutif = null, $only_jkn = true){
        $sql = "SELECT IFNULL(MAX(UNIX_TIMESTAMP(created_date)), 0) as last_update FROM {$this->table} WHERE unit_id = '{$unit_id}' AND tanggal_periksa = '{$tanggal}'";
        // if($polieksekutif != null) $sql .= " AND poli_eksekutif = '{$polieksekutif}'";
        if($only_jkn)
            $sql .= "  AND nomor_referensi IS NOT NULL";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        return (int)$data['last_update'];
    }

    public function simpanAntrianBaru($nomorkartu, $nik, $notelp, $tanggalperiksa, $kodepoli, $nomorreferensi, $jenisreferensi, $jenisrequest, $polieksekutif){
        date_default_timezone_set("Asia/Jakarta");
        /**
         * Escaping string
         */
        $nomorkartu = mysqli_escape_string($this->koneksi, $nomorkartu);
        $nik = mysqli_escape_string($this->koneksi, $nik);
        $notelp = mysqli_escape_string($this->koneksi, $notelp);
        $tanggalperiksa = mysqli_escape_string($this->koneksi, $tanggalperiksa);
        $kodepoli = mysqli_escape_string($this->koneksi, $kodepoli);
        $nomorreferensi = mysqli_escape_string($this->koneksi, $nomorreferensi);
        $jenisreferensi = mysqli_escape_string($this->koneksi, $jenisreferensi);
        $jenisrequest = mysqli_escape_string($this->koneksi, $jenisrequest);
        $polieksekutif = mysqli_escape_string($this->koneksi, $polieksekutif);

        $response = [
            "metadata" => [
                "message" => "Ok",
                "code" => 200
            ]    
        ];

        // Begin Validate
        if(!$this->validateDate($tanggalperiksa)){
            $response["metadata"]["message"] = "Invalid date format.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if(strtotime(date('Y-m-d')) > strtotime($tanggalperiksa)){
            $response["metadata"]["message"] = "Tanggal yang diambil telah lewat.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if($jenisrequest !== '1' && $jenisrequest !== '2'){
            $response["metadata"]["message"] = "Invalid jenis request.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if($jenisreferensi !== '1' && $jenisreferensi !== '2'){
            $response["metadata"]["message"] = "Invalid jenis referensi.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if(!is_numeric($nomorkartu) || strlen($nomorkartu) !== 13){
            $response["metadata"]["message"] = "Nomor Kartu Invalid.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        $sql = "SELECT COUNT(*) as jumlah FROM auth_antrian WHERE nomor_referensi = '{$nomorreferensi}'";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);

        if((int)$data['jumlah'] > 0){
            $response["metadata"]["message"] = "Nomor referensi telah digunakan.";
            $response["metadata"]["code"] = 401;
            return $response;
        }
        // End Validate


        /**
         * Cek jika UNIT_ID telah di setup
         * Agar dapat diarahkan ke unit yang ada di rs
         */
        $sql = "SELECT unit_id, namapoli, estimasi, is_operasi, minim_hari FROM jkn_poli WHERE kodepoli = '{$kodepoli}' AND unit_id IS NOT NULL AND estimasi IS NOT NULL AND ket_tindakan IS NOT NULL";
        $query = mysqli_query($this->koneksi, $sql);
        if(mysqli_num_rows($query) == 0){
            $response["metadata"]["message"] = "Invalid request! poli tidak tersedia di rumah sakit.";
            $response["metadata"]["code"] = 401;
            return $response;
        }
        $data = mysqli_fetch_assoc($query);
        $unit_id = $data['unit_id'];
        $namapoli = $data['namapoli'];
        $estimasipoli = (int)$data['estimasi']; // Dalam menit

        if($data['is_operasi'] != '1' && date('D', strtotime($tanggalperiksa)) === 'Sun'){
            $response["metadata"]["message"] = "Tidak ada jadwal praktek pada hari dituju.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if($data['is_operasi'] == '1' && strtotime($tanggalperiksa) < strtotime(date("Y-m-d") . " +" . $data['minim_hari'] . " days")){
            $response["metadata"]["message"] = "Anda harus memilih minimal {$data['minim_hari']} hari dari sekarang.";
            $response["metadata"]["code"] = 401;
            return $response;
        }        

        $total_pasien_hariini = $this->getTotalPasien($unit_id, $tanggalperiksa, null, false);
        $sudah_terlayani = $this->sudahTerlayani($unit_id, $tanggalperiksa, null, false);
        
        /**
         * Simpan data antrian
         */
        $no_antrian = $this->getNomorAntrianBaru($unit_id, $tanggalperiksa);
        $now_timestamp = gmdate('Y-m-d H:i:s', mktime(date('H') + 7));
        $sql = "INSERT INTO {$this->table}(
                    nomor_kartu, no_antrian, 
                    unit_id, nik, 
                    no_telp, tanggal_periksa, tanggal_booking, 
                    nomor_referensi, jenis_referensi, 
                    jenis_request, poli_eksekutif,
                    kodepoli, created_date) 
                VALUES('{$nomorkartu}', '{$no_antrian}', 
                    '{$unit_id}', '{$nik}', 
                    '{$notelp}', '{$tanggalperiksa}', '{$tanggalperiksa}', 
                    '{$nomorreferensi}', '{$jenisreferensi}', 
                    '{$jenisrequest}', '{$polieksekutif}',
                    '{$kodepoli}', NOW())";
        $query = mysqli_query($this->koneksi, $sql);

        // Format nomor antrian dengan 4 digit 0
        $f_no_antrian = str_pad($no_antrian, 4, '0', STR_PAD_LEFT);

        // Pengetesan
        // echo date("d-m-Y H:i:s.U") . "<br>";
        // echo $total_pasien_hariini . " - " . $sudah_terlayani;
        // $jam = (round(microtime(true) * 1000) + ($total_pasien_hariini - $sudah_terlayani) * $estimasipoli * (60 * 1000)) / 1000;
        // echo date("d-m-Y H:i:s.U", $jam);

        /**
         * Buat kode booking dengan format  3 digit kode poli, 4 digit tahun, 
         *                                  2 digit bulan, 2 digit tanggal, sisanya nomor_antrian
         */
        $tahun = date("Y");
        $bulan = date("m");
        $tanggal = date("d");
        $kodebooking = $kodepoli . $tahun . $bulan . $tanggal . $f_no_antrian;
        $response["response"]["nomorantrean"] = $kodepoli . $f_no_antrian;
        $response["response"]["kodebooking"] = $kodebooking;
        $response["response"]["jenisantrean"] = (int)$jenisrequest;

        $begin_milisecond = ((date("Y-m-d") === $tanggalperiksa && strtotime($tanggalperiksa . " +7hours") < round(microtime(true) * 1000)) ? round(microtime(true) * 1000) : strtotime($tanggalperiksa . " +7hours") * 1000);

        $response["response"]["estimasidilayani"] = ($begin_milisecond + ($total_pasien_hariini - $sudah_terlayani) * $estimasipoli * (60 * 1000));
        $response["response"]["namapoli"] = $namapoli;
        $response["response"]["namadokter"] = "";
        return $response;
    }

    public function get_booking_peserta($nomorkartu){
        date_default_timezone_set("Asia/Jakarta");
        /**
         * Escaping string
         */
        $nomorkartu = mysqli_escape_string($this->koneksi, $nomorkartu);

        $response = [
            "metadata" => [
                "message" => "Ok",
                "code" => 200
            ]
        ];

        if(!is_numeric($nomorkartu) || strlen($nomorkartu) !== 13){
            $response["metadata"]["message"] = "Nomor Kartu Invalid.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        /***
         * Query
         */
        $sql = "SELECT a.*, YEAR(a.created_date) as tahun, MONTH(a.created_date) as bulan, DAY(a.created_date) as hari, b.namapoli, b.ket_tindakan FROM {$this->table} a LEFT JOIN jkn_poli b ON a.kodepoli = b.kodepoli WHERE a.nomor_kartu = '" . $nomorkartu . "' AND a.sudah_dilayani = 0";
        $query = mysqli_query($this->koneksi, $sql);

        $respon_data = [];

        while($data = mysqli_fetch_assoc($query)){
            // Format nomor antrian dengan 4 digit 0
            $f_no_antrian = str_pad($data['no_antrian'], 4, '0', STR_PAD_LEFT);
            /**
             * Get kode booking dengan format  3 digit kode poli, 4 digit tahun, 
             *                                  2 digit bulan, 2 digit tanggal, sisanya nomor_antrian
             */
            $kodebooking = $data['kodepoli'] . $data['tahun'] . $data['bulan'] . $data['hari'] . $f_no_antrian;

            $respon_data[] = [
                "kodebooking" => $kodebooking,
                "tanggaloperasi" => $data['tanggal_periksa'],
                "jenistindakan" => $data['ket_tindakan'],
                "kodepoli" => $data['kodepoli'],
                "namapoli" => $data['namapoli'],
                "terlaksana" => (int)$data['sudah_dilayani']
            ];
        }

        if(sizeof($respon_data) > 0)
            $response["response"]["list"] = $respon_data;

        return $response;
    }

    public function get_rekap_antrean($kodepoli, $tanggalperiksa, $polieksekutif){
        date_default_timezone_set("Asia/Jakarta");

        $kodepoli = mysqli_escape_string($this->koneksi, $kodepoli);
        $tanggalperiksa = mysqli_escape_string($this->koneksi, $tanggalperiksa);
        $polieksekutif = mysqli_escape_string($this->koneksi, $polieksekutif);

        $response = [
            "metadata" => [
                "message" => "Ok",
                "code" => 200
            ]
        ];

        // Begin Validate
        if(!$this->validateDate($tanggalperiksa)){
            $response["metadata"]["message"] = "Invalid date format.";
            $response["metadata"]["code"] = 401;
            return $response;
        }
        // End Validate

        $sql = "SELECT * FROM jkn_poli WHERE kodepoli = '{$kodepoli}'";
        $query = mysqli_query($this->koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        if(!$data){
            $response["metadata"]["message"] = "Invalid kode poli.";
            $response["metadata"]["code"] = 401;
            return $response;
        }
        if(!$data['unit_id']){
            $response["metadata"]["message"] = "Poli ini tidak tersedia di rumah sakit ini.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        $total_antrean = $this->getTotalPasien($data['unit_id'], $tanggalperiksa, $polieksekutif);
        $sudah_dilayani = $this->sudahTerlayani($data['unit_id'], $tanggalperiksa, $polieksekutif);
        $last_update = $this->getLastUpdateRekap($data['unit_id'], $tanggalperiksa, $polieksekutif);

        // Respond
        $response["response"]["namapoli"] = $data['namapoli'];
        $response["response"]["totalantrean"] = $total_antrean;
        $response["response"]["jumlahterlayani"] = $sudah_dilayani;
        $response["response"]["lastupdate"] = $last_update * 1000;
        return $response;

    }

    public function get_jadwal_operasi($tanggalawal, $tanggalakhir){
        date_default_timezone_set("Asia/Jakarta");
        /**
         * Escaping string
         */
        $tanggalawal = mysqli_escape_string($this->koneksi, $tanggalawal);
        $tanggalakhir = mysqli_escape_string($this->koneksi, $tanggalakhir);

        $response = [
            "metadata" => [
                "message" => "Ok",
                "code" => 200
            ]
        ];
        
        // Begin Validate
        if(!$this->validateDate($tanggalawal) || !$this->validateDate($tanggalakhir)){
            $response["metadata"]["message"] = "Invalid date format.";
            $response["metadata"]["code"] = 401;
            return $response;
        }

        if(strtotime($tanggalawal) > strtotime($tanggalakhir)){
            $response["metadata"]["message"] = "Invalid tanggal! Tanggal awal lebih besar dari tanggal akhir.";
            $response["metadata"]["code"] = 401;
            return $response;
        }
        // End Validate

        /***
         * Query
         */

        // Tambah LIMIT? untuk pagination?
        // Hanya tampilkan yang dari JKN saja (nomor referensi tidak NULL)
        $sql = "SELECT a.*, YEAR(a.created_date) as tahun, MONTH(a.created_date) as bulan, DAY(a.created_date) as hari, b.namapoli, b.ket_tindakan, UNIX_TIMESTAMP(a.created_date) as last_update FROM {$this->table} a LEFT JOIN jkn_poli b ON a.kodepoli = b.kodepoli WHERE a.tanggal_periksa >= '$tanggalawal' AND a.tanggal_periksa <= '$tanggalakhir' AND nomor_referensi IS NOT NULL";
        $query = mysqli_query($this->koneksi, $sql);

        $respon_data = [];

        while($data = mysqli_fetch_assoc($query)){
            // Format nomor antrian dengan 4 digit 0
            $f_no_antrian = str_pad($data['no_antrian'], 4, '0', STR_PAD_LEFT);
            /**
             * Get kode booking dengan format  3 digit kode poli, 4 digit tahun, 
             *                                  2 digit bulan, 2 digit tanggal, sisanya nomor_antrian
             */
            $kodebooking = $data['kodepoli'] . $data['tahun'] . $data['bulan'] . $data['hari'] . $f_no_antrian;

            $respon_data[] = [
                "kodebooking" => $kodebooking,
                "tanggaloperasi" => $data['tanggal_periksa'],
                "jenistindakan" => $data['ket_tindakan'],
                "kodepoli" => $data['kodepoli'],
                "namapoli" => $data['namapoli'],
                "terlaksana" => (int)$data['sudah_dilayani'],
                "nopeserta" => $data['nomor_kartu'] == null ? "" : $data['nomor_kartu'],
                "lastupdate" => (int)$data['last_update'] * 1000
            ];
        }
        if(sizeof($respon_data) > 0)
            $response['response']['list'] = $respon_data;
        return $response;
    }

    // Reference: https://stackoverflow.com/a/19271434
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}