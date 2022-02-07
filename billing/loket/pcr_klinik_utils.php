<?php
require_once '../koneksi/konek.php';
$grd = $_REQUEST['grd'];
$page = $_REQUEST["page"];
$defaultsort = "kode";
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
$id_pasien = $_REQUEST['idPasien'];

if($_REQUEST['filter'] != ''){
$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
$filterSql = " AND {$filter[0]} LIKE '%{$filter[1]}%'";
}

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
switch ($grd) {
	case 'getData':
		$sql = "SELECT
            p.*,
            bp.unit_id_asal,
            u2.nama AS LOKET,
            bp.unit_id,
            u.nama AS tempat_layanan,
            bk.jenis_layanan,
            u3.nama AS Jenis_Layanan,
            k.id AS id_kso,
            k.nama AS nama_kso,
            kel.nama AS kelas,
            bk.id AS id_kunjungan,
            bp.id AS id_pelayanan,
            bk.umur_thn,
            bk.umur_bln,
            bk.kel_umur,
            bk.umur_hr,
            bk.ket,
            bk.tgl,
            bk.tgl_sjp,
            (SELECT no_anggota FROM b_ms_kso_pasien WHERE pasien_id = p.id ) no_anggota,
            (SELECT st_anggota FROM b_ms_kso_pasien WHERE pasien_id = p.id) status_anggota,
            (SELECT nama FROM b_ms_wilayah WHERE id = p.prop_id) prop,
            (SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) kab,
            (SELECT nama FROM b_ms_wilayah WHERE id = p.kec_id) kec,
            (SELECT nama FROM b_ms_wilayah WHERE id = p.desa_id) desa
        FROM
            b_ms_pasien AS p
            INNER JOIN b_pelayanan AS bp ON p.id = bp.pasien_id
            INNER JOIN b_kunjungan AS bk ON bp.kunjungan_id = bk.id
            INNER JOIN ( SELECT id, nama FROM b_ms_unit ) AS u ON u.id = bp.unit_id
            INNER JOIN ( SELECT id, nama FROM b_ms_unit ) AS u2 ON u2.id = bp.unit_id_asal
            INNER JOIN ( SELECT id, nama FROM b_ms_unit ) AS u3 ON u3.id = bk.jenis_layanan
            INNER JOIN b_ms_kso k ON bp.kso_id = k.id
            INNER JOIN b_ms_kelas kel ON kel.id = bp.kelas_id 
        WHERE
            bp.unit_id = 238 
            AND bp.unit_id_asal = 191 
            AND bk.jenis_layanan = 215
            {$filterSql}
        ORDER BY
            bp.id DESC,
            bk.id DESC";	
		break;
    case 'getDataHasil' :
        $sql = "SELECT h.*,p.nama FROM b_hasil_pcr h INNER JOIN b_ms_pasien p ON h.id_pasien = p.id WHERE h.id_pasien = {$id_pasien} ORDER BY h.id DESC";
        echo $sql;
        break;
}
//paginatiaon
$query = mysql_query($sql);
$jumlahData = mysql_num_rows($query);

if($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if($page > 1) $bpage = $page - 1; else $bpage = 1;
if($page < $totalpage) $npage = $page + 1; else $npage = $totalpage;

$sql = $sql . " LIMIT $totalPage,$perpage";
$query = mysql_query($sql);
$i = ($page - 1) * $perpage;

$data = $totalpage.chr(5);
switch ($grd) {
    case 'getData':
            while($rows = mysql_fetch_assoc($query)){
                $sqlCek = "SELECT * FROM b_pasien_klinik_pcr WHERE id_pasien_klinik = {$rows['id']} AND id_pelayanan_klinik = {$rows['id_pelayanan']} AND id_kunjungan_klinik = {$rows['id_kunjungan']}";
                $execute = mysql_query($sqlCek);
                if(mysql_num_rows($execute) > 0){
                    continue;
                }else{
                    $i++;
                    $dataarr = "";
                    foreach ($rows as $key => $val) {
                        $dataarr.= $key.'|'. ($val == '' ? '-' : $val).'||';
                    }
                    $button = '<button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#dataPasienRsCekFromPcr" value="'.$dataarr.'" onclick="listPasienKlinikToRs(this.value)">Cek Pasien</button>';
                    $button .= '<button class="btn btn-sm btn-warning ml-2" type="button" value="'.$dataarr.'" onclick="pilihPasienPcrBelumTerdaftar(this.value)">Pilih Pasien Belum Terdaftar</button>';
                    $data .= $dataarr.chr(3).$i.chr(3).$rows['nama'].chr(3).$rows['tempat_layanan'].chr(3).$rows['nama_kso'].chr(3).$button.chr(6);
                }
            }
        break;
    
    case 'getDataHasil':
        while($rows = mysql_fetch_assoc($query)){
                $i++;
                $dataarr = "";
                foreach ($rows as $key => $val) {
                    $dataarr.= $key.'|'. ($val == '' ? '-' : $val).'||';
                }
                
                $kategori = "";
                
                if($rows['kategori'] == 1) $kategori = "Swab Biasa";
                else $kategori = "Swab Anti Gen";
                
                $data .= $dataarr.chr(3).$i.chr(3).$rows['nama'].chr(3).$rows['dokter_pengirim'].chr(3).$rows['tanggal_swab'].chr(3).$kategori.chr(3).$rows['status_cek_pcr'].chr(6);
            }
        break;
}

if($data != $totalpage.chr(5)){
	$data = substr($data, 0,strlen($data) - 1);
	// $data = str_replace('"', '\"', $data);
}

mysql_free_result($query);

echo $data;
?>