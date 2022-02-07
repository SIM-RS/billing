<?php
    use yii\helpers\Html;

include '../function/form.php';
    include '../../koneksi/konek.php';
    include 'funct.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $i = 1;

  if (isset($_REQUEST['id'])) {
      $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_edukasi_tindakan_anestesi_sedasi WHERE id = '{$_REQUEST['id']}'"));
      $arr_data = explode("|", $data['data']);
  }

  if (isset($_REQUEST['idx'])) {
      date_default_timezone_set("Asia/Jakarta");
      $tgl_act = date('Y-m-d H:i:s');
      $str = "";
      $q = mysql_real_escape_string($_REQUEST['i']);

      for ($e=1; $e < $q; $e++) {
          $data = mysql_real_escape_string($_REQUEST["data_{$e}"]);
          if ($data != "") {
              $str .= $data;
              $str .= "|";
          } else {
              $str .= "#";
              $str .= "|";
          }
      }

      $data = [
          'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
          'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
          'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
          'data' => $str
      ];

      $hasil = mysql_query("UPDATE rm_edukasi_tindakan_anestesi_sedasi 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
            id_user = '{$data['id_user']}',
			data = '{$data['data']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      
      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
		.inv {
			background-color: transparent;
			border :none;
			cursor :default;
		}
		td {
			padding:5px;
		}
		.row {
			margin-bottom:8px;
		}
		.newline {
			padding-left: 30px;
		}
		@media print {
			.foot {page-break-after: always;}
		}
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/ppdf.js"></script>
</head>

<body id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 21.8 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:15px">
					<div class="col-9">
						<table>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><?= $dataPasien["nama"]; ?></td>
							</tr>
							<tr>
								<td>Tgl. Lahir</td>
								<td>:</td>
								<td><?= $dataPasien["tgl_lahir"]; ?></td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td>:</td>
								<td><?= $dataPasien["no_rm"]; ?></td>
							</tr>
						</table>
					</div>

					<div class="col-3">
						<table>
							<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							<tr>
								<td>
									<?php if ($dataPasien["sex"] == "L"): ?>
										L
									<?php else: ?>
										P
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<hr class="bg-dark" style="margin-top:-1px">
		<div style="height:5px;background-color:black;width:100%;margin-top:-12px;margin-bottom:10px"></div><br>
		<center><h2>EDUKASI TINDAKAN ANESTESI DAN SEDASI</h2></center>
<?php if (isset($_REQUEST['id'])): ?>
  <form action="" method="POST">
	<input type="hidden" name="idx" value="<?= $_REQUEST['id']; ?>">
<?php else:?>
  <form action="utils.php" method="POST">
<?php endif; ?>

	<input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
	<input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
	<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
	<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
<br>

        <?php
        include("../../koneksi/konek.php");
        $idKunj = $_REQUEST['idKunj'];
        $idPel = $_REQUEST['idPel'];

        $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
        $idPasien = $sql['pasien_id'];

        $qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
        from b_ms_pasien p
        left join b_ms_wilayah w on w.id=p.desa_id
        left join b_ms_wilayah i on i.id=p.kec_id
        left join b_ms_wilayah l on l.id=p.kab_id
        left join b_ms_wilayah a on a.id=p.prop_id where p.id='" . $idPasien . "' ";
        $rsPasien = mysql_query($qPasien);
        $rwPasien = mysql_fetch_array($rsPasien);
        ?>
        <p align="center">
            <strong> </strong>
        </p>
        <p>
            <strong>ANESTESIA</strong>
            <strong> UMUM (AU) </strong>
        </p>
        <p>
            AU adalah teknik pembiusan dengan bius total dimana pasien tidak sadar,
            tidak dapat dirangsang dan tidak merasakan sakit. Obat bius untuk AU berupa
            obat yang disuntikkan kedalam pembuluh darah atau zat anestesi yang dapat
            dihirup/dihisap, terutama pada bayi/anak. Lama kerja obat disesuaikan
            dengan lama operasi. Sesuai dengan kebutuhan operasi dan kondisi pasien,
            teknik ini akan mempengaruhi kemampuan untuk mempertahankan patensi jalan
            nafas, terjadi depresi fungsi pernafasan spontan atau depresi fungsi otot.
            Sehingga pasien sering memerlukan pemasangan alat pernafasan untuk
            mempertahakan patensi jalan napas dan pemberian nafas bantu.
        </p>
        <center>
            <table cellspacing="0" cellpadding="0" border="1">
                <tbody>
                    <tr>
                        <td width="189" valign="top">
                            <p>
                                <strong>KELEBIHAN</strong>
                            </p>
                        </td>
                        <td width="198" valign="top">
                            <p>
                                <strong>KEKURANGAN</strong>
                            </p>
                        </td>
                        <td width="317" valign="top">
                            <p>
                                <strong>KOMPLIKASI/EFEK SAMPING</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="189" valign="top">
                            <p>
                                · Dari awal pembiusan pasien sudah tidak sadar, tidak
                                merasakan nyeri, teknik dan lama pembiusan bisa disesuaikan
                                dengan lama operasI
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                        </td>
                        <td width="198" valign="top">
                            <p>
                                · Pasca bedah pasien harus sadar penuh sebelum bisa diberi
                                minum.
                            </p>
                            <p>
                                · Obat bius yang diberikan dapat memiliki efek keseluruh
                                tubuh termasuk ke aliran pembuluh janin dalam kandungan.
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                        </td>
                        <td width="317" valign="top">
                            <p>
                                · Mual muntah, menggigil, pusing, mengantuk, sakit
                                tenggorokan
                            </p>
                            <p>
                                · Aspirasi yaitu masuknya isi lambung kejalan nafas/paru.
                            </p>
                            <p>
                                · Kesulitan pemasangan alat/pipa pemafasan yang tidak
                                terduga sebelumnya
                            </p>
                            <p>
                                · Alergi/hipersensitif terhadap obat (sangat jarang), mulai
                                derajat ringan hingga berat/fatal.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
        <p>
            <strong> </strong>
        </p>
        <p>
            <strong>ANESTESIA SPINAL/EPIDURAL </strong>
        </p>
        <p>
            · Anestesia spinal/epidural adalah pembiusan yang hanya meliputi daerah
            perut ke bawah (perut sampai ujung kaki) dengan pasien tetap sadar tanpa
            merasakan nyeri. Bila pasien menginginkan untuk tidur maka dokter dapat
            rnemberi obat tidur/penenang melalui suntikan. Obat bius yang dipakai
            adalah obat bius lokal (Anestesi Lokal<em>) </em>dan bisa ditambah dengan
            obat lain yang bisa menambah kekuatan obat maupun rnenambah lama kerja obat
            bius lokal. Untuk anestesia spinal, obat bius lokal tersebut disuntikkan
            dengan jarum yang sangat kecil di celah tulang belakang di daerah punggung.
        </p>
        <p>
            · Untuk anestesia epidural didaerah punggung penyuntikan didahului dengan
            pemberian obat bius lokal dan melalui jarum epidural yang disuntikan di
            celah tulang belakang akan dimasukkan selang kecil kearah pinggiran tulang
            belakang, yang berfungsi untuk menyalurkan obat ke sekitar saraf yang ada
            dipinggiran tulang belakang.
        </p>
        <p>
            · Pada kedua teknik diatas, penyuntikan dilakukan pada pasien dalam keadaan
            posisi duduk membungkuk atau miring kesalah satu sisi dengan kedua tungkai
            dilipat ke perut dan kepala menunduk. Pada waktu penyuntikan obat, akan
            terasa hangat dipunggung. Setelah obat masuk ke tulang belakang, pada
            awalnya akan merasakan kesemutan pada tungkai, lama kelamaan akan terasa
            berat pada kedua tungkai dan pada akhirnya kedua tungkai tidak dapat
            digerakkan, seolah-olah tungkainya hilang. Pada awalnya dibagian perut
            pasien masih bisa merasakan sentuhan, gosokan, dan tarikan, tapi lama
            kelamaan akan tidak merasakan apa-apa lagi. Hilang rasa ini bisa
            berlangsung kira-kira 2 sampai 3 jam sesuai jenis obat anestesi lokal yang
            digunakan.
        </p>
        <center>
            <br>
            <table cellspacing="0" cellpadding="0" border="1">
                <tbody>
                    <tr>
                        <td width="217" valign="top">
                            <p>
                                <strong>KELEBIHAN</strong>
                            </p>
                        </td>
                        <td width="142" valign="top">
                            <p>
                                <strong>KEKURANGAN</strong>
                            </p>
                        </td>
                        <td width="345" valign="top">
                            <p>
                                <strong>KOMPLIKASI/EFEK SAMPING</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="217" valign="top">
                            <p>
                                · Jumlah obat yang diberikan sedikit sekali (untuk epidural
                                jumlah obat lebih banyak)
                            </p>
                            <p>
                                · Obat bius tidak masuk ke dalam sirkulasi ari-ari/rahim
                                sehingga baik untuk operasi besar
                            </p>
                            <p>
                                · Obat bius tidak mempengaruhi organ lain dalam tubuh
                            </p>
                            <p>
                                · Bisa ditambahkan obat penghilang rasa sakit yang bisa
                                bertahan hingga 24 jam pasca bedah (untuk epidural bisa
                                ditambah terus obat anti sakit sesuai kebutuhan)
                            </p>
                            <p>
                                · Bila tidak mual/muntah pasca bedah bisa langsung minum
                                tanpa harus menunggu flatus (buang angin)
                            </p>
                            <p>
                                · Lebih aman untuk pasien yang tidak puasa/operasi darurat
                            </p>
                        </td>
                        <td width="142" valign="top">
                            <p>
                                · Pasca bedah harus berbaring, tidak boleh duduk/bangun
                                selama 6 jam
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                        </td>
                        <td width="345" valign="top">
                            <p>
                                · Efek samping pasca bedah yang sering adalah mual/muntah,
                                gatal-gatal terutama di daerah wajah, semua bisa diatasi
                                dengan obat-obatan.
                            </p>
                            <p>
                                · Efek samping yang jarang adalah sakit kepala dibagian
                                depan atau belakang kepala pada hari ke-2 <em>/</em> ke-3 <em> </em>terutama pada waktu mengangkat kepala dan
                                menghilang 5 sampai 7 hari. Bila tidak menghilang maka akan
                                dilakukan tindakan khusus berupa pemberian darah pasien
                                pada tempat suntikan semula.
                            </p>
                            <p>
                                · Efek samping lain berupa kesulitan buang air kecil.
                            </p>
                            <p>
                                · Alergi hipersensitif terhadap obat, mulai derajat ringan
                                hingga berat/fatal.
                            </p>
                            <p>
                                · Gangguan pernafasan mulai dari ringan (terasa
                                pernafasannya agak berat) sampai berat (henti nafas)
                            </p>
                            <p>
                                · Kelumpuhan atau kesemutan/rasa baal ditungkai yang
                                memanjang, bersifat sementara dan bisa sembuh kembali.
                            </p>
                            <p>
                                · Untuk epidural bisa terjadi kejang bila obat masuk
                                kedalam pembuluh darah.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
        <p>
            <a name="_GoBack"></a>
        </p>
        <p>
            <strong>BLOK</strong>
            <strong> PERIFER</strong>
        </p>
        <p>
            Blok Perifer adalah teknik pembiusan yang hanya melibatkan sebagian tubuh
            saja (misalnya Iengan atas atau bawah, tangan, tungkai, kaki dan
            sebagainya). Teknik ini dilakukan dengan menyuntikkan obat bius lokal
            didaerah sekitar saraf yang mensyarafi bagian tubuh yang akan dioperasi.
        </p>
        <center>
            <br><br><br><br>
            <table cellspacing="0" cellpadding="0" border="1">
                <tbody>
                    <tr>
                        <td width="189" valign="top">
                            <p>
                                <strong>KELEBIHAN</strong>
                            </p>
                        </td>
                        <td width="180" valign="top">
                            <p>
                                <strong>KEKURANGAN</strong>
                            </p>
                        </td>
                        <td width="336" valign="top">
                            <p>
                                <strong>KOMPLIKASI/EFEK SAMPING</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="189" valign="top">
                            <ul>
                                <li>
                                    Bangun dan sadar akan lingkungan
                                </li>
                                <li>
                                    Bernafas secara spontan
                                </li>
                            </ul>
                            <p>
                                · Hilangnya sensasi pada lokasi yang terkena blok
                            </p>
                            <p>
                                · Dapat berkomunikasi dengan staf anestesi dan bedah
                            </p>
                        </td>
                        <td width="180" valign="top">
                            <p>
                                · Merasakan sedikit nyeri pada lokasi saraf yang akan
                                disuntik
                            </p>
                            <p>
                                · Kadang bila syaraf sudah terkena maka akan terasa seperti
                                kesetrum dibagian rubuh yang akan dioperasi
                            </p>
                            <ul>
                                <li>
                                    Rasa baal yang menetap
                                </li>
                            </ul>
                        </td>
                        <td width="336" valign="top">
                            <p>
                                · Rasa kesemutan dan atau gangguan bergerak (motorik) yang
                                berkepanjangan tetapi bersifat sementara
                            </p>
                            <ul>
                                <li>
                                    Pendarahan dibawah kulit (hematom)
                                </li>
                                <li>
                                    Tertusuknya lapisan paru
                                </li>
                            </ul>
                            <p>
                                · Pembiusan yang tidak kompli (sebagian tubuh terbius)
                            </p>
                            <p>
                                · Reaksi alergi atau hipersensitif yang ringan hingga berat
                                (fatal)
                            </p>
                            <p>
                                · Kejang bila obat masuk ke dalam pembuluh darah.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
        </center>
        <p>
            <strong>SEDASI</strong>
            <strong> SEDANG </strong>
            <strong>DAN</strong>
            <strong> DALAM</strong>
        </p>
        <p>
            <strong> </strong>
        </p>
        <p>
            Teknik sedasi dengan memasukkan obat secara oral, penyuntikkan ke pembuluh
            darah, penyuntikan ke otot atau obat diberikan melalui jalur lain, seperti
            supositoria.
        </p>
        <p>
            <strong>Sedasi Sedang. </strong>
        </p>
        <p>
            Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien
            mengantuk, tetapi masih memiliki respon terhadap rangsangan verbal, dapat
            diikuti atau tidak diikuti oleh rangsangan tekan yang ringan dan pasien
            masih dapat menjaga patensi jalan nafasnya sendiri. Pada sedasi moderat
            terjadi perubahan ringan dari respon pernafasan namun fungsi kerja jantung
            serta pembuluh darah masih tetap dipertahankan dalam keadaan normal. Pada
            sedasi moderat dapat diikuti gangguan orientasi lingkungan serta gangguan
            fungsi motorik ringan sampai sedang.
        </p>
        <p>
            <strong>Sedasi Dalam </strong>
        </p>
        <p>
            Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien
            mengantuk, tidur, serta tidak mudah dibangunkan tetapi masih memberikan
            respon terhadap rangsangan berulang atau rangsangan nyeri. Respon
            pernafasan sudah mulai terganggu dimana nafas spontan sudah mulai tidak
            adekuat dan pasien tidak dapat mempertahankan patensi dari jalan nafasnya
            (mengakibatkan hilangnya sebagian atau seluruh refleks protektif jalan
            nafas). Sedasi dalam dapat berpengaruh terhadap fungsi kerja jantung dan
            pembuluh darah terutama pada pasien sakit berat, sehingga tindakan sedasi
            dalam membutuhkan alat monitoring yang lebih lengkap dari sedasi ringan
            maupun sedasi moderat.
        </p>
        <center>
            <table cellspacing="0" cellpadding="0" border="1">
                <tbody>
                    <tr>
                        <td width="142" valign="top">
                            <p>
                                <strong>KELEBIHAN</strong>
                            </p>
                        </td>
                        <td width="170" valign="top">
                            <p>
                                <strong>KEKURANGAN</strong>
                            </p>
                        </td>
                        <td width="392" valign="top">
                            <p>
                                <strong>KOMPLIKASI/EFEK SAMPING</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="142" valign="top">
                            <ul>
                                <li>
                                    Obat diberikan secara bertahap
                                </li>
                            </ul>
                            <p>
                                · Selama tindakan pasien dalam keadaan mengantuk dan tidur.
                            </p>
                            <p>
                                · Obat yang diberikan dapat memiliki efek amnesia.
                            </p>
                        </td>
                        <td width="170" valign="top">
                            <p>
                                · Pasca sedasi pasien harus sadar penuh sebelum bisa diberi
                                minum
                            </p>
                            <p>
                                · Sampai 24 jam pasca sedasi pasien tidak diperbolehkan
                                mengendarai mobil, mengoperasikan mesin dan menandatangani
                                dokumen penting yang bersifat legal.
                            </p>
                        </td>
                        <td width="392" valign="top">
                            <p>
                                · Oleh karena tindakan sedasi merupakan rangkaian proses
                                dinamik dan dapat berubah, maka sedasi ringan ataupun
                                moderat bisa bergeser menjadi sedasi dalam
                            </p>
                            <p>
                                · Efek samping pasca sedasi dapat berupa: mual Imuntah,
                                menggigil, pusing, mengantuk, yang bisa diatasi dengan
                                obat-obatan
                            </p>
                            <p>
                                · Alergi/hipersensitif terhadap obat (sangat jarang), mulai
                                derajat ringan hingga berat/fatal.
                            </p>
                            <p>
                                · Beresiko pada pasien yang tidak puasa,bisa terjadi
                                aspirasi yaitu masuknya isi lambung ke jalan nafas/paru.
                            </p>
                            <p>
                                · Pada sedasi dalam terdapat kemungkinan pemasangan alat
                                atau pipa pernafasan
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
        <p>
            <strong>ANESTESIA TOPIKAL</strong>
        </p>
        <p>
            Anestesi Topikal adalah teknik pembiusan yang hanya melibatkan bagian tubuh
            tertentu saja (misalnya mata, gusi, dll). Teknik pembiusan dilakukan dengan
            memberikan obat bius tetes/ spray/ jelly pada bagian tubuh yang akan
            dibius. Efek bius berlangsung kira-kira 15-30 menit tergantung jenis obat
            yang dipakai.
        </p>
        <p>
            <strong>Komplikasi : </strong>
            Jarang
        </p>
        <p>
            Saya yang bertanda tangan di bawah ini telah membaca atau dibacakan
            keterangan diatas dan telah dijelaskan terkait dengan prosedur anestesia
            dan sedasi yang akan dilakukan terhadap: diri saya sendiri/istri/suami/
            anak/ayah/ibu *)
        </p>
        <?php
        $pasien = mysql_fetch_assoc(mysql_query("SELECT * FROM b_ms_pasien WHERE id = '$idPasien'"));
        $tanggal = new DateTime($pasien['tgl_lahir']);

        // tanggal hari ini
        $today = new DateTime('today');

        // tahun
        $y = $today->diff($tanggal)->y;
        ?>
        <ul>
            <li>
                Nama :
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
            </li>
            <li>
                Umur/Jenis Kelamin : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> tahun, &nbsp;
                <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
            </li>
            <li>
                Alamat :
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
            </li>
            <li>
                No. Telp :
                <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
            </li>
        </ul>
        <p>
            *) coret yang tidak perlu
        </p>
        <div style="float:right;">
            <p>
                Medan, 
				<?=input($arr_data[$i-1], "data_{$i}", "date", "", "height:20px;", "");$i++;?>
            </p>
            <p>
                Jam 
				<?=input($arr_data[$i-1], "data_{$i}", "time", "", "height:20px;", "");$i++;?>
            </p>
            <b>Pihak yang dijelaskan,
                <br><br>
                <br><br>
                ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )</b>
        </div>
        <br><br><br>
        <p><b>
                Dokter yang menjelaskan,
                <br><br>
                <br><br>
                ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )

            </b></p>

    </div>
    </div>
        <!-- <center>
            <div class='container'>
                <div class='btn-group'>
                    <button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
                    <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
                    <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
                </div>
        </center> -->
    </div>
    </div>
	
</div>
<input type="hidden" name="i" value="<?=$i;?>">
<?php if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
	&nbsp;
<?php elseif (isset($_REQUEST['id'])): ?>
	<button type="submit" class="btn btn-primary">Ganti</button>
	</form>
<?php else:?>
	<button type="submit" class="btn btn-success">Simpan</button>
	</form>
<?php endif; ?>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: "RM 21.10 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>
	</script>
</body>

</html>