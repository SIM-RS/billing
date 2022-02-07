<?
include('../../koneksi/konek.php');
include("../../sesi.php");
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'"; //$idPel
$dP=mysql_fetch_array(mysql_query($sqlP));

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->
    
        <title>.:FORMULIR TATA TERTIB PASIEN RAWAT INAP:.</title>
        <style>
        body{background:#FFF;}
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
    </style>
</head>

<body onload="">
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>

<div id="tampil_input" align="center" style="display:none">
    <form action="" method="get" name="tata_tertib" id="tata_tertib">
    	<input type="hidden" id="act" name="act" value="hapus" /> 
		<input type="hidden" id="id" name="id" />
    <BR>
        <center><table width="1065" style="border:1px solid #000; border-collapse:collapse;">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th scope="col">&nbsp;</th>
            <th colspan="6" rowspan="3" scope="col">PEMERINTAH KOTA MEDAN<br />RUMAH SAKIT PELINDO I</th>
            <th colspan="6" rowspan="3" scope="col" style="border:1px solid #000;">TATA TERTIB<br />PASIEN RAWAT INAP <BR />( REGULATION INPATIENT )</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <td colspan="14" style="border-top:#000 1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td width="17">&nbsp;</td>
            <td width="26">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="154">&nbsp;</td>
            <td width="16">&nbsp;</td>
            <td width="316">&nbsp;</td>
            <td width="89">&nbsp;</td>
            <td width="80">&nbsp;</td>
            <td width="75">&nbsp;</td>
            <td width="90">&nbsp;</td>
            <td width="48">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="25">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Nama Pasien / <em>Patient Name</em></td>
            <td>:</td>
            <td> <?=$dP['nama'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">No. RM</td>
            <td>:</td>
            <td><?=$dP['no_rm'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Ruang &amp; Kelas / <em>Rom &amp; Class</em></td>
            <td>:</td>
            <td><?=$dP['nm_kls'];  ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Tanggal Masuk Rawat Inap</td>
            <td>:</td>
            <? 
			$waktu = $dP['tgl_act'];
			$tanggal = explode(" ",$waktu);
			$tgl = tglSQL($tanggal[0]);
			?>
            <td><?=$tgl; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="13">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="12">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>I.</strong></td>
            <td colspan="5"><strong>Kondisi Pelayanan / <em>Condition of Service</em></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="9">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td colspan="10" rowspan="2"><div align="justify">Pasien tersebut diatas setuju untuk dilakukan perawatan rawat inap di RS Pelindo I / <em>Patieny is listed above to perform inpatient care at RS Pelindo I.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="10" rowspan="3"><div align="justify">Selama dalam perawatan di RS Pelindo I pasien diwajibkan menggunakan sarana dan prasarana yang tersedia di Rumah Sakit seperti pemeriksaan laboratorium, radiologi, farmasi dan sebagainya.<em>/ During the hospitalization, patieny is obligated to use RS Pelindo I Hospital facilities,eg: laboratory examination, radiology, pharmacy, etc.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="10" rowspan="3"><div align="justify">Selama dalam perawatan di RS Pelindo I, pasien dianjurkan untuk tidak mengenakan atau menyimpan barang-barang berharga. kehilangan atau kerusakan barang bukan menjadi tanggung jawab Rumah Sakit.<em>/ During hospitalization, patient is advised not to bring and wear valuables. Therefore the hospital is not reliable for any lost or damage of patient's valuables.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>4.</td>
            <td colspan="10" rowspan="3"><div align="justify">Pasien bertanggung jawab atas kerusakan atau kehilangan barang milik RS Pelindo I yang disebabkan oleh kelalaian pasien/keluarga pasien.<em>/ Patient will be responsible for any damage or lost of hospital's property due to patient/relative of patient negligence.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>5.</td>
            <td colspan="10" rowspan="5"><div align="justify">Barang-barang yang diperboehkan untuk dibawa kedalam kamar perawatan adalah barang-barang keperluan pasien, barang bawaan pribadi berupa peralatan tidur (Bantal, kasur, tikar, dsb) dan peralatan selain yang telah disediakan oleh pihak rumah sakit tidak diperkenankan untuk dibawa ke dalam kamar perawatan.<em>/ Belongings that are allowed to be brought into the patient's room are only those of imfortance to the patient However, bad equipment (pillow, matterss, mat, etc) &amp; others equipment which are not provided by the hospital are prohibited to be broughy from outside into the patients room.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>II.</strong></td>
            <td colspan="3"><strong>Pembayaran / <em>Payent</em></strong><em></em></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td colspan="10" rowspan="3"><div align="justify">Pasien diwajibkan membayar uang muka pada saat registrasi rawat inap. Jumlah uang muka yang dibayar sesuai dengan kebijakan yang berlaku di RS Pelindo I./<em> Patient is obligated to pay deposit admission. The deposite amount to be paid is in accordance with the regulations of RS Pelindo I</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="10" rowspan="3"><div align="justify">Bila pasien belum dapat memenuhi kewajiban pembayaran deposit, maka rumah sakit memberikan tenggang waktu selama 1 x 24 jam terhitung setelah registrasi rawat inap untuk menyelesaikan pembayaran uang muka./<em> If the patient could not settle the deposit upon admission, the deposit has to be settled within 24 hours after admission.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10" rowspan="4"><div align="justify">Selama pasien dirawat, rumah sakit akan membuat tagihan uang muka berjalan, apabila total biaya perawatan telah mencapai 90% dari total uang muka yang telah dibayarkan pasien./<em> During hospitalization the hospital will send a deposit invoice if the total cost of treatment has reached 90% of the deposit.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>4.</td>
            <td colspan="10" rowspan="4"><div align="justify">Pasien yang biaya perawatan di tanggung oleh pihak ketiga (<em>Insurance</em>/Perusahaan) wajib memberikan surat jaminan kepada RS Pelindo I selambat-lambatnya dalam jangka waktu 1 x 24 jam setelah registrasi rawat inap. Selama rumah sakit belum menerima surat jaminan, maka pasien akan diberlakukan sebagai pasien pribadi./ <em>Patient who financed by third party (employer, company, or insurance) must provide a letter of guarantee to the hospital at the latest within 24 hours after admission. Before receiving the letter of guarantee. the patient is considered as a self pay and he/she has to sign a of consent that he/she will pay the hospital bill, if the third party does not provide the letter of guarantee.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>5.</td>
            <td colspan="10" rowspan="3"><div align="justify">Sebelum dilakukan tindakan operasi, pasien wajib membayar deposit sebesar perkiraan biaya operasi. Keterlambatan dapat menunda pelaksanaan operasi.<em>/ Before the procedure of surgeon taken, patient is obligated to pay deposit at the amount of the cost estimation of the procedure. Delay upon settlig the deposit will cancel the procedure.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10" rowspan="6"><div align="justify">Selama masa perawatan pasien dapat berpindah kelas apabila kamar yang diinginkan tersedia. Bila pasien pindah kelas setelah menjalani operasi, tindakan atau perawatan di ICU ke kelas lebih tinggi, maka biaya yang dikeluarkan sebelumnya akan disesuaikan dengan kelas yang baru./ During hospitalization if the patient, desired to change room and if the room are available. If the patient moves to another room with higher rate after having a procedure or stay in ICU the hospital bill will be adjusted to higher rates according to the new room rate chosen.</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>6.</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>7.</td>
            <td colspan="10" rowspan="5"><div align="justify">Bila pasien pindah kamar dari perawatan umum ke ICU maka biaya kamar yang dikenakan hari itu adalah biaya kamar ICU, bila pasien meninggalkan kamar ICU sebelum Pk. 12.00 WIB, makan pasien akan dikenakan biaya perawatan bangsal pada hari itu. Sedangkan bila perpindahan dari ICU ke bangsal melewati Pk. 12.00 WIB, maka pasien akan dikenakan biaya perawatan ICU./ Room charge for the day patient leaves ward to ICU room charge, if the patient leaves ICU to ward before 12 pm, the charge would be room charge, however if the patient leaves ICU after 12 pm, the room charge for the day is ICU room charge.</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10" rowspan="5"><div align="justify">Butir 2,3 dan 5 wajib dilunasi dalam waktu 1 x 24 jam sejak tagihan / surat pemberitahuan diterima, dan apabila sampai dengan batas waktu yang ditentukan diatas RS Pelindo I belum menerima pembayaran, maka pihak Rumah Sakit berhak melakukan tindakan sebagai berikut :/<em> Details of 2,3 and 5 have to be repaid in 24 hours since the bill/letter of notification is received, and when it came to the time limit spesified in the RS Pelindo I have not received payment, then the hospital is entitled to take action as follews :</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>8.</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify">&bull;</div></td>
            <td colspan="9" rowspan="2"><div align="justify">Obat yang diresepkan harus dibeli sendiri di Farmasi RS Pelindo I dan dibayar tunai./ <em>Prescribed drug must be purchased at RS Pelindo I pharmacy and paid in cash.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify">&bull;</div></td>
            <td colspan="9" rowspan="2"><div align="justify">Pemeriksaan penunjang medis lainya harus dibayar tunai./<em> Examination of other medical support (Labboratory, Radiology, etc) must be paid in cash.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify">&bull;</div></td>
            <td colspan="9"><div align="justify">Memindahkan pasien ke ruang perawatan kelas 3 (Tiga)./<em> Transfering patient to the treatment area class 3.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify">&bull;</div></td>
            <td colspan="9"><div align="justify">Merujuk pasien ke rumah sakit lain./ <em>Refer patient to other hospitals.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10"><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>9.</td>
            <td colspan="10" rowspan="2">RS Pelindo I akan menarik biaya administrasi dan service yang besarnya sesuai dengan kebijakan yang berlaku./<em> RS Pelindo I will charge an administrative and service fee in accardance with the prevalling polices.</em></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>10.</td>
            <td colspan="10" rowspan="4"><div align="justify">Rumah Sakit akan memberikan perincian/detil biaya penggunaan pasien selama dirawat setelah dilakukan pelunasan. Rumah Sakit hanya mengeluarkan satu kali invoice asli dan tidak bisa mengeluarkan invoice manual, kecuali bila sistem informasi Rumah Sakit terganggu fungsinya./<em> The hospital will give a detail of invoice of the patient during hospitalization after bill has been settled. The hospital only release one true copy of the invoice, a manual invoice will not be produced, unless there is a problem with the hospital system.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="10"><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>11.</td>
            <td colspan="10" rowspan="4">Biaya perawatan pasien harus dilunasi pada saat pasien meninggalkan rumah sakit. Pelunasan hanya dapat dilakukan dengan pembayaran tunai atau dengan kartu kredit. Kami tidak menerima pembaran dengan menggunakan giro/chek./ <em>The hospital bill must be paid upon discharge. payment can be made only by cash or credit card and the hospital does not received payment with any kind of personal check.</em></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>III.</strong></td>
            <td colspan="3"><strong>Perawatan / Treatment</strong></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td colspan="10" rowspan="2"><div align="justify">RS Pelindo I mempunyai wewenang untuk memindahkan pasien kekamar lain sesuai dengan kelas perawatan./ <em>RS Pelindo I has the authority to transfer patient to other rooms in accardance with its treatment class.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="10" rowspan="2"><div align="justify">Staf medis RS Pelindo I berwenang untuk melakukan tindakan pertolongan medis pada keadaan kegawatan untuk menolong jiwa pasien./<em> RS Pelindo I staff authorized to give medical life saving to the emergenciens situation.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>IV.</strong></td>
            <td colspan="3"><strong>Pemualangan Pasien / </strong></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td colspan="9"><div align="justify">Harus sepengetahuan atau seizin dokter yang merawat./ <em>Should the knowledge or permisson of the treating doctor.</em></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="10" rowspan="3"><div align="justify">Diluar ketentuan tersebut, pasien dinyatakan pulang atas permintaan sendiri dan pasien/keluarganya diminta untuk menandatangani formulir pulang atas permintaan sendiri./<em> Excluding the provisions, the patient is avowed to go home, based on his / her own demand and also his / her family request.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="10" rowspan="4"><div align="justify">Batas waktu kepulangan pasien adalah pk. 12.00 WIB. kepulangan sebelum pk. 12.00 WIB, tidak dikenakan biaya dan tidak disediakan makan siang. Kepualangan pasien setelah pk 15.00 WIB maka pasien dikenakan biaya setengah hari./<em> Time of discharge is 12 pm. It a patient is discharge before 12 pm, additional room cost will not be charge and lunch meal is not available. If a patient is discharge after 15 pm. The hospital will charge half day room rate.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td><div align="justify"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>4.</td>
            <td colspan="10" rowspan="3"><div align="justify">Toleransi waktu akan diberikan sampai dengan pk 15.00 WIB pada waktu pasien menunggu kunjungan terakhir dokter. Bila pasien pulang setelah pk. 18.00 WIB maka akan dikenakan biaya sebesar satu hari biaya kamar./ <em>Late-check out is until 15 pm in case waiting for last doctor visit. The hospital will charge full day room for check-out after 18 pm.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="12" rowspan="5">Yang bertanda tangan di bawah ini menerangkan bahwa telah membaca syarat-syarat diatas, menerima satu buah salinanya dan setuju terikat di bawahnya, jika yang bertanda tangan di bawah ini bukan pasien yang bersangkutan, maka ia menjamin bahwa ia mendapat kuasa dari pasien untuk menerima syarat-syarat tersebut, atas nama pasien./ <em>The undersigned certifies that he/she has read the after going condition, received a copy therefore and agrees to be bound thereunder, Where the undersigned is other than the patient the undersigned warrants that he/she has the patient's authority to accept there fore going condition on be half of the patient.</em></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Medan, <? echo date("j F Y");?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>A.</td>
            <td colspan="5">Disetujui oleh pasien / Agreed by patient</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="12">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">(_______________________________)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center">Tanda Tangan / Signature</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>B. </td>
            <td colspan="5">Disetujui oleh Penjamin / Agreed by guarantor</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">Saya / <em>I, Myself</em></td>
            <td>:</td>
            <td><label for="nama"></label>
            <input name="nama" type="text" id="nama" size="35" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">No. Identitas / <em>Id No</em></td>
            <td>:</td>
            <td><input name="no_id" type="text" id="no_id" size="35" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">Beralamat di / <em>Of</em></td>
            <td>:</td>
            <td rowspan="3"><label for="a"></label>
            <textarea name="alamat" id="alamat" cols="45" rows="5"></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">No Telp / Phone Number</td>
            <td>:</td>
            <td><input name="telp" type="text" id="telp" size="35" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="11" rowspan="2"><div align="justify">Setuju untuk bertanggung jawab atas rekening pasien dan patuh kepada persyaratan di atas./ <em>Here be agree to be jointly and severally liable for the patien's account observance of the above condotions.</em></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">(_______________________________)</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center">Tanda Tangan / Signature</div></td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">
             	<center>
             	  &nbsp;
             	</center> 
             </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></center>
    </form>
    <p>
  <input type="button" name="simpen" id="simpen" class="tblTambah" value="Simpan" onclick="simpan();document.getElementById('tampil_input').style.display='none'"/>
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="bersihkan()" class="tblBatal"/>
</p>
</div>	

<div id="tampil_data" align="center">

<p>&nbsp;</p>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" class="tblTambah" onclick="document.getElementById('tampil_input').style.display='block';document.getElementById('simpen').lang='simpan';document.getElementById('tata_tertib').reset();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" class="tblTambah" onclick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu yang akan diedit.')}else{document.getElementById('tampil_input').style.display='block';return};ambilData();" />
                      
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>    
                  </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style=" height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>

</div>
</body>
</html>

<script>


function cetak(){
	var rowid = document.getElementById("id").value;
		if(rowid==""){
			var rowidx =a.getRowId(a.getSelRow()).split('|');
			rowid=rowidx[0];
			alert('Pilih data yang akan di cetak');
		 }
	window.open("37.tatatertib_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
	
		
}

function goFilterAndSort(abc){
	if (abc=="gridbox"){
		//alert('filter cak');
		rek.loadURL("37.tatatertib_util.php?id_pelayanan=<?=$idPel?>&kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
} 

function ambilData(){
	var sisipan=rek.getRowId(rek.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	$('#nama').val(rek.cellsGetValue(rek.getSelRow(),3));
	$('#no_id').val(rek.cellsGetValue(rek.getSelRow(),6));
	$('#alamat').val(rek.cellsGetValue(rek.getSelRow(),4));
	$('#telp').val(rek.cellsGetValue(rek.getSelRow(),5));
	
	document.getElementById('simpen').lang='update';
}



function bersihkan(){
	document.getElementById('tata_tertib').reset();
	document.getElementById('tampil_input').style.display='none';
}

 var rek=new DSGridObject("gridbox");
        rek.setHeader(".:PENJAMIN PASIEN:.");
        rek.setColHeader("NO,NAMA PASIEN, PENJAMIN,ALAMAT,TELEPON,NO IDENTITAS,TGL INPUT,PENGGUNA");
        rek.setIDColHeader(",nama,nama_tt,alamat,telp,no_identitas,tgl_act,dr_rujuk");
        rek.setColWidth("25,130,100,100,100,100,100,100");
        rek.setCellAlign("center,left,center,center,center,left,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("37.tatatertib_util.php?id_pelayanan=<?=$idPel?>&kode=true&saring=");
        rek.Init();
		

function simpan(){
	var act = document.getElementById('simpen').lang;
	var id = $('#id').val();
	var id_pasien ='<?=$dP['id'];?>';		
	var nama = $('#nama').val();
	var no_id = $('#no_id').val();
	var alamat = $('#alamat').val();
	var telp = $('#telp').val();
	
	rek.loadURL("37.tatatertib_util.php?kode="+true+"&act="+act+"&id="+id+"&nama="+nama+"&no_id="+no_id+"&alamat="+alamat+"&telp="+telp+"&id_pasien="+id_pasien+"&id_pelayanan="+'<?=$idPel ;?>'+"&id_user="+'<?=$dP['id_user'];?>','','GET');
	bersihkan();
}		

function hapus(){
	if(document.getElementById('id').value == '' || document.getElementById('id').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ?'))
			var act =document.getElementById('simpen').lang='hapus';
			var id = $('#id').val();
			//alert("32.hasilanamnesadiet_util.php?kode="+true+"&act="+act+"&id="+id,'','GET');
			rek.loadURL("37.tatatertib_util.php?kode="+true+"&act="+act+"&id="+id+"&id_pelayanan="+'<?=$idPel; ?>','','GET');
			
	}
} 

</script>