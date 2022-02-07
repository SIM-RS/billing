$artmp_id[1]=='3' = array untuk rawat inap
$artmp_id[1]=='2' = array untuk farmasi
$artmp_id[1]=='4' = array untuk lainnya 

Koding untuk layanan..

SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) $cabang $waktu 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id) $cabang $waktu 
								UNION 
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, '0' jumlah, COUNT(p.id) jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) $cabang $waktu2 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, '0' jumlah,COUNT(p.id) jumlah2 
								FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id) $cabang $waktu2 ) t 
								GROUP BY t.typePx

query diatas, diambil berdasarkan id, pada unit_id di tabel b_pelayanan..

jadi, data visite doktor masuk ke dalam b_tindakan, sedangkan data yg ingin dtampilkan diambil di b_pelayanan, tidak balance, karena b_pelayanan mengambil id unitnya, sedangkan visite doktor adalah sebuah tindakan bukan layanan, jadi cara yang terpikir sekrang adalah, menggabung tabel b_pelayanan dan b_tindakan, 

Ternyata setelah di cek kembali IGD adalah Unit bernomorkan = "45"
jadi untuk memunculkannya tinggal menambahkannya

tabel yg dgnukan adalah, b_pelayanan, b_kunjungan, dan untuk tindakan visit di b_tindakan

Membuat Query baru untuk mengambil data dan visite doktor, Umum dan Spesialis

karena dalam satu program hanya memiliki 1 query, maka query akan djalankan dengan IF kondisi jika Klinik Umum, atau Klinik Spesialis?

///////////////////////////////////////

koding IF kondisi yang dijalankan hanya untuk KLinik Umum dan Spesialis
	echo "<td >&nbsp;&nbsp;".$pas."</td>";
							if($col == 'KLINIK UMUM' OR $col == 'KLINIK SPESIALIS' ){
								if($col == 'KLINIK UMUM'){
									// $sqlUmum="SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									// FROM (
									// SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									// FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
									// WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd /*decyber*/ $cabang $waktu 
									// UNION 
									// SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									// FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
									// WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd  /*decyber*/ $cabang $waktu 
									// UNION 
									// SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									// FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
									// WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd $cabang $waktu2 /*decyber*/ 
									// UNION 
									// SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									// FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
									// WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd $cabang $waktu2 )/*decyber*/  t 
									// GROUP BY t.typePx";
									// $sqlUmum1 = mysql_query($sqlUmum);
									// if($sqlUmum1 == FALSE){
									// 	echo mysql_error();
									// }
									// $sqlUmum2 = mysql_fetch_array($sqlUmum1);
									// $jmlUmum = $sqlUmum2['jumlah'];
									// $jmlUmum2 = $sqlUmum2['jumlah2'];

									$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392  /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 $cabang $waktu2 /*decyber*/ 
									UNION 
									SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 $cabang $waktu2 )/*decyber*/  t 
									GROUP BY t.typePx";
									$sqlVisitU1 = mysql_query($sqlVisitU);
									if($sqlVisitU1 == FALSE){
										echo mysql_error();
									}
									$sqlVisitU2 = mysql_fetch_array($sqlVisitU1);
									$jmlUmum = $sqlVisitU2['jumlah'];
									$jmlUmum2 = $sqlVisitU2['jumlah2'];
									echo "<td align='center'>".$jmlUmum2."</td>";
								}elseif($col == 'KLINIK SPESIALIS'){
									$sqlspesial="select COUNT(id) as jmlSpesial from b_tindakan where ms_tindakan_kelas_id = $visitUmum $waktuUmum ";
									$sqlspesial1 = mysql_query($sqlspesial);
									
									$sqlspesial2 = mysql_fetch_array($sqlspesial1);
								$jmlspesial = $sqlspesial2['jmlSpesial'];
									echo "<td align='center'>".$jmlspesial."</td>";
								}
							
							}else{
								echo "<td align='center'>heeei</td>";
							}





ternyata setelah data muncul, penempatan fetchnya salah sehingga hanya muncul yang internal saja

SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
							FROM (
							SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd  /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd $cabang $waktu2 /*decyber*/ 
							UNION 
							SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
							FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
							WHERE k.`kso_id` IN (11,14) AND p.jenis_kunjungan = $igd $cabang $waktu2 )/*decyber*/  t 
							GROUP BY t.typePx



							SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
							FROM (
							SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392  /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
							FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 $cabang $waktu2 /*decyber*/ 
							UNION 
							SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
							FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
							WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = 392 $cabang $waktu2 )/*decyber*/  t 
							GROUP BY t.typePx


							/*
//////////////////////////////////////////////////////////////////////////////////////////
Query Untuk Visitasi Umum, di Klinik Umum
*/


$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum  /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum $cabang $waktu2 /*decyber*/ 
									UNION 
									SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum $cabang $waktu2 )/*decyber*/  t 
									GROUP BY t.typePx";
									$sqlVisitU1 = mysql_query($sqlVisitU);
									// if($sqlVisitU1 == FALSE){
									// 	echo mysql_error();
									// }
									
									$sqlVisitU2 = mysql_fetch_array($sqlVisitU1);
									$jmlUmum = $sqlVisitU2['jumlah'];
									$jmlUmum2 = $sqlVisitU2['jumlah2'];
/*
/////////////////////////////////////////////////////////////////////////////////////////////

Query Untuk Visitasi Klinik Spesial, di Klinik Spesialis
*/

$sqlVisitS = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe  /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe $cabang $waktu2 /*decyber*/ 
									UNION 
									SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe $cabang $waktu2 )/*decyber*/  t 
									GROUP BY t.typePx";
									$sqlVisitS1 = mysql_query($sqlVisitS);
									// if($sqlVisitS1 == FALSE){
									// 	echo mysql_error();
									// }
									
									$sqlVisitS2 = mysql_fetch_array($sqlVisitS1);
									$jmlUmum = $sqlVisitS2['jumlah'];
									$jmlUmum2 = $sqlVisitS2['jumlah2'];


Alhamdulillah Setelah ditinjau ulang, fix membuat sebuah kondisi, dimana pasien internal, akan mengambil query untuk internal, dan kondisi pasien eksternal, mengambil query untuk internal, fix kode yang ditambah 

		if($col == 'KLINIK UMUM' OR $col == 'KLINIK SPESIALIS' ){
								if($col == 'KLINIK UMUM'){
									if($pas == '1. Pasien Internal'){
									$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum $cabang $waktu2 /*decyber*/ 
									)/*decyber*/  t 
									GROUP BY t.typePx";
									}else if($pas == '2. Pasien Eksternal'){
										$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum  /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitUmum $cabang $waktu2 )/*decyber*/  t 
									GROUP BY t.typePx";
									}
									$sqlVisitU1 = mysql_query($sqlVisitU);
									// if($sqlVisitU1 == FALSE){
									// 	echo mysql_error();
									// }
									$sqlVisitU2 = mysql_fetch_array($sqlVisitU1);
									$jmlUmum = $sqlVisitU2['jumlah'];
									$jmlUmum2 = $sqlVisitU2['jumlah2'];
									$jumlah2 += $jmlUmum2;
									$jumlah += $jmlUmum;
								echo "<td align='center'>".number_format($jumlah2,0,",",".")." + ".$jmlUmum2." Asli = ".$jumlah2."</td>";
								echo "<td align='center'>".number_format($jumlah,0,",",".")." + = ".$jmlUmum."  Asli = ".$jumlah."</td>";
								echo "<td align='center'>".number_format($jumlah2 + $jumlah,0,",",".")."</td>";
								}elseif($col == 'KLINIK SPESIALIS'){
									if($pas == '1. Pasien Internal'){
									$sqlVisitS = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe $cabang $waktu2 /*decyber*/ 
									)/*decyber*/  t 
									GROUP BY t.typePx";
									}else if($pas == '2. Pasien Eksternal'){
										$sqlVisitS = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
										FROM (
										SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
										FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
										WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe  /*decyber*/ $cabang $waktu 
										UNION 
										SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
										FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
										WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id = $visitSpe $cabang $waktu2 )/*decyber*/  t 
										GROUP BY t.typePx";
									}
									$sqlVisitS1 = mysql_query($sqlVisitS);
									// if($sqlVisitS1 == FALSE){
									// 	echo mysql_error();
									// }
									
									$sqlVisitS2 = mysql_fetch_array($sqlVisitS1);
									$jmlSpe = $sqlVisitS2['jumlah'];
									$jmlSpe2 = $sqlVisitS2['jumlah2'];
									$jumlah2 += $jmlSpe2;
									$jumlah += $jmlSpe;

								echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah + $jumlah2,0,",",".")."</td>";
								}
							
							}else{
								echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah2 + $jumlah,0,",",".")."</td>";
							}