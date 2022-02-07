<?php
/*
detailPenerimaan.php ini adalah file yang berfungsi sebagai insert data dan update data dari file penerimaanPO.php.
Pada file detailPenerimaan.php ini terdiri dari 2 bagian yaitu tampilan form interface dan program pengolahan databasenya.
Pada file ini memakai metode post dalam penyimpanan data melalui form dengan action file ini sendiri.
Dan perlu diperhatikan juga bahwa penerimaanPO.php mengirimkan beberapa parameter ke file ini melaui metode GET.
Proses:
A. insert database aset dengan tabel:
    - as_masuk
    - as_kstok
    - as_po
B. proses insert:
    1. Dimulai dengan memasukkan data ke tabel as_masuk.
    2. Meng-update qty_terima pada tabel as_po sesuai dengan jml_msk pada tabel as_masuk.
    3. Memeriksa jumlah qty_satuan dan qty_terima, jika sama maka update kolom status pada tabel as_po dengan 1 jika tidak sama 0.
    4. Kemudian Mengambil msk_id yang baru saja dimasukkan pada tabel as_masuk.
    5. Mengambil jumlah sisa dan nilai sisa terakhir (sebelumnya) dari tabel as_kstok dengan barang id yang sama, karena akan digunakan dalam penyimpanan
        jumlah awal dan nilai awal pada tabel as_kstok.
    6. Insert data ke tabel as_kstok.
C. proses update:
    1. Update data pada tabel as_masuk berdasarkan no_po dan no_gudang.
    2. Meng-update qty_terima pada tabel as_po sesuai dengan jml_msk pada tabel as_masuk.
    3. Memeriksa jumlah qty_satuan dan qty_terima, jika sama maka update kolom status pada tabel as_po dengan 1 jika tidak sama 0.
    4. Kemudian Mengambil msk_id dan data yang diperlukan dari as_masuk.
    5. Mengambil jumlah sisa dan nilai sisa terakhir (sebelumnya) dari tabel as_kstok dengan barang id yang sama, karena akan digunakan dalam penyimpanan
        jumlah awal dan nilai awal pada tabel as_kstok.
    6. Insert ke as_kstok dimana jumlah keluar diisi dengan jumlah masuk dari as_masuk yang telah diambil sebelumnya.
    7. Mengambil sisa lagi seperti no. 5.
    8. Insert ke as_kstok dimana jumlah masuk diisi sesuai dengan input user.
D. Pengcekan Tanggal
	1. Ketika merubah tanggal, mengecek apakah no gudang sudah ada ap tidak jika ada no gudang +1 jika tidak ada langsung defaultnya 0001
*/
session_start();
include "../koneksi/konek.php";
$user=$_SESSION['userid'];
$ta= date('Y');
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
{
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '$def_loc';
        </script>";
}
if(isset($_GET['no_po']) && $_GET['no_po'] != '') 
{
    $no_po = $_GET['no_po'];
    $po_rekanan = explode('|', $no_po);
}
if(isset($_GET['id']) && $_GET['id'] != '') 
{
    $terima_po = explode('|', $_GET['id']);
}
if($_REQUEST['tgl']!="")$tgl=$_REQUEST['tgl']; else $tgl = gmdate('d-m-Y',mktime(date('H')+7));
$th = explode('-', $tgl);
if(isset($_POST['act']) && $_POST['act'] != '') 
{
    $act = $_POST['act'];
	$tahunPem = $_POST['tahunPem'];
    $txtNoPen = cekNull($_POST['txtNoPen']);
    $txtIdBarang = cekNull($_POST['txtIdBarang']);    
    $txtTgl = tglSQL($_POST['txtTgl']);
    $txtTotal = cekNull($_POST['txtTotal']);
    $cmbNoPo = cekNull(explode('|', $_POST['cmbNoPo']));
	//$cmbNoPo = $terima_po[1];
    $txtNoPo = cekNull($_POST['txtNoPo']);    
    $txtFaktur = cekNull($_POST['txtFaktur']);
    $tglFaktur = cekNull(tglSQL($_POST['txtTglFaktur']));
    $tglTempoBayar = cekNull(tglSQL($_POST['txtTglTempoBayar']));
    $data_submit = explode('*|*',$_POST['data_submit']);
    $user_act = $_SESSION['userid'];
    $user_id = $_SESSION['id_user'];
    $txtPengirim = cekNull($_POST['txtPengirim']);
    $PetGud = cekNull($_POST['txtPetGud']);
    
    if($act == 'add') 
	{
        for($i=0; $i<count($data_submit)-1; $i++) 
		{
            $penerimaan = true;
            $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);//chkItem.value
            $chkItem2 = $data_fill[1];//chkItem.checked
            $qty_satuan = $data_fill[2];//txtJmlSatuan
            $satuan = $data_fill[3];//txtSatuan
            $qty_per_kemasan = $data_fill[4];//txtJmlPerKemasan
            $h_satuan = $data_fill[5];//txtHrgSatuan
            $id=$data_fill[13]; //po_id
            $txtIdBarang=$data_fill[8];
            $txtJmlDiterima=$data_fill[9];
            $txtUraian=$data_fill[10];
			$tipe = $data_fill[11];
			$kib = $data_fill[12];
	    
            if($penerimaan == 'true') 
			{
				if($qty_per_kemasan!=0) //yg diinput hanya kolom "jumlah diterima sekarang " yg pengisian nilainya tidak sama dengan 0
				{
					/*proses 1.*/
					$query = "insert into as_masuk (po_id,tgl_act,tgl_terima,no_gudang,tgl_faktur,no_faktur,barang_id,msk_uraian,jml_msk,satuan_unit,harga_unit,pengirim,penerima,sisa,exp_bayar) values
						('$id', now(), '$txtTgl', '$txtNoPen','$tglFaktur','$txtFaktur','$txtIdBarang','$txtUraian','$qty_per_kemasan','$satuan','$h_satuan','$txtPengirim','$PetGud','$qty_per_kemasan','$tglTempoBayar')";
					$sukses=mysql_query($query);
					$msk_id = mysql_insert_id();
					
					$query = "select max(noseri) as maks from as_seri2 where idbarang = '{$txtIdBarang}' and thn_pengadaan = '{$tahunPem}'";
					$noseriq = mysql_fetch_array(mysql_query($query));
					$query;
					if($noseriq['maks'] != ""){
						$noseri = $noseriq['maks']+1;
					} else {
						$noseri = 1;
					}
					// proses masuk ke as_seri2
					
					for($loop = 1; $loop <= $qty_per_kemasan; $loop++){
						if($tipe==1){
							$querySeri = "INSERT INTO as_seri2(idseri, msk_id, idbarang, jenis_kib, asalusul, ms_idunit, noseri, thn_pengadaan)
									VALUES (NULL, '{$msk_id}', '{$txtIdBarang}', '{$kib}', 'Pembelian', NULL, '{$noseri}', '{$tahunPem}')";
							mysql_query($querySeri);
							$idseri = mysql_insert_id();
							$noseri += 1;
							if($kib <= 06){
								$tableKIB = 'kib'.$kib;
								/*switch($kbi){
									case '01':
										$isian = "(idseri) value ('{$idseri}')";
										break;
									case '02':
										$isian = "(idseri) value ('{$idseri}')";
										break;
									case '03':
										$isian = "(idseri) value ('{$idseri}')";
										break;
									case '02':
										$isian = "(idseri) value ('{$idseri}')";
										break;
									case '02':
										$isian = "(idseri) value ('{$idseri}')";
										break;
									case '02':
										$isian = "(idseri) value ('{$idseri}')";
										break;
								} */
								//echo "<br /><br />";
								$queryKIB = "insert into {$tableKIB}(idseri) value('{$idseri}')";
								mysql_query($queryKIB);
							}
						}
					}
					
					/*proses 2&3.*/
					$qPo="update as_po set qty_terima='".($txtJmlDiterima+$qty_per_kemasan)."',STATUS=IF(qty_satuan='".($txtJmlDiterima+$qty_per_kemasan)."',1,0) where id='$id'";			
					mysql_query($qPo);
				
					if($sukses)
					{
						/*proses 4.*/
						$qMasuk="SELECT m.msk_id,m.tgl_terima,m.no_gudang,m.barang_id,m.jml_msk,mr.namarekanan,m.harga_unit FROM as_masuk m
						INNER JOIN as_po p ON p.id=m.po_id
						INNER JOIN as_ms_rekanan mr ON mr.idrekanan=p.vendor_id where m.no_gudang='$txtNoPen' and tgl_terima='$txtTgl'
						and m.barang_id='$txtIdBarang' order by m.po_id desc limit 1";
						//echo $qMasuk."<br />";
						$rsMasuk=mysql_query($qMasuk);
						$rwMasuk=mysql_fetch_array($rsMasuk);
						
						/*proses 5.*/
						$qKstok="select jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc limit 1";
						//echo $qKstok."<br />";
						$rsKstok=mysql_query($qKstok);
						$rwKstok=mysql_fetch_array($rsKstok);
						$jmlSisa=($rwKstok['jml_sisa']=='')?'0':$rwKstok['jml_sisa'];
						$nilaiSisa=($rwKstok['nilai_sisa']=='')?'0':$rwKstok['nilai_sisa'];
						
						
						if($rsMasuk && $rsKstok)
						{
							/*proses 6.*/
							$qStok="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
							,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe,koreksi) 
							values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa."','".$rwMasuk['jml_msk']."','0',(jml_awal+jml_masuk-jml_keluar),
							'".$nilaiSisa."','".$rwMasuk['jml_msk']*$rwMasuk['harga_unit']."','0',(nilai_awal+nilai_masuk-nilai_keluar),'Penerimaan PO - ".$rwMasuk['namarekanan']."','0','+')";
							//echo $qStok."<br />";
							mysql_query($qStok);
						}
                         
                /*
                    $sHbsPakai="SELECT LEFT(kodebarang,2) as kode,tipe,namabarang FROM as_ms_barang WHERE idbarang='".$rwMasuk['barang_id']."'";
                    //echo "<br>";
                    $rsHbsPakai=mysql_query($sHbsPakai);
                    $rwHbsPakai=mysql_fetch_array($rsHbsPakai);
                    $fkTrans = '';
                    //echo "kode:".$rwHbsPakai['kode']."<br>";
                    if($rwHbsPakai['tipe']=='1'){
                        switch($rwHbsPakai['kode']){
                            case "01":
                                $fkTrans = '27a';
                                break;
                            case "02":
                                $fkTrans = '27a';
                                break;
                            case "03":
                                $fkTrans = '27a';
                                break;
                            case "04":
                                $fkTrans = '28a';
                                break;
                            case "05":
                                $fkTrans = '28a';
                                break;
                            case "06":
                                $fkTrans = '28a';
                                break;                            
                        }
                     }   
					elseif($rwHbsPakai['tipe']=='2'){
                        switch($rwHbsPakai['kode']){
                            case "01":
                                $fkTrans = '24a';
                                break;
                            case "02":
                                $fkTrans = '24a';
                                break;
                            case "08":
                                $fkTrans = '24a';
                                break;
                            case "03":
                                $fkTrans = '28a';
                                break;
                            case "04":
                                $fkTrans = '28a';
                                break;
                            case "05":
                                $fkTrans = '26a';
                                break;
                            case "06":
                                $fkTrans = '23a';
                                break;
                            case "07":
                                $fkTrans = '25a';
                                break;
                     }
					}
                        $qDetail="select fk_ma_sak,dk FROM akuntansi.detil_transaksi dt
                                INNER JOIN akuntansi.jenis_transaksi jt ON dt.fk_jenis_trans=jt.JTRANS_ID
                                INNER JOIN akuntansi.ma_sak ms ON ms.MA_ID=dt.fk_ma_sak
                                where JTRANS_KODE='$fkTrans'";
			
			//echo $qDetail;
                        $rsDetail=mysql_query($qDetail);
                        
                        $D = $rwMasuk['jml_msk']*$rwMasuk['harga_unit'];
                        						
                        $sNoTrans="select max(no_trans)+1 as no from akuntansi.jurnal";
                        $rsNoTrans=mysql_query($sNoTrans);
                        $rwNoTrans=mysql_fetch_array($rsNoTrans);
                        while($rwDetail=mysql_fetch_array($rsDetail)){
                            $iJurnal="insert into akuntansi.jurnal (no_trans,fk_sak,tgl,no_bukti,uraian,debit,kredit,tgl_act,d_k,fk_trans,fk_iduser,no_kw) values ('".$rwNoTrans['no']."','".$rwDetail['fk_ma_sak']."','$tglFaktur','".$noFaktur."','Pembelian Inventaris ".$rwHbsPakai['namabarang']."',";
                            if ($rwDetail['fk_ma_sak']=='3816'){
                                $K = $D*(10/110);
                            }
                            elseif ($rwDetail['fk_ma_sak']=='185'){
                                $K = $D*(100/110);
                            }
                            $iJurnal.=($rwDetail['dk']=='D')?"'".$D."','0'":"'0','".$K."'";
                            $iJurnal.=",now(),'".$rwDetail['dk']."','$fkTrans','17','".$rwMasuk['msk_id']."')";
                            if(!mysql_query($iJurnal)){
                                echo mysql_error();
                                echo $iJurnal."<br>";
                            }
                            //echo $iJurnal."<br>";
                        }
                    }
                    //echo "fkTrans:".$fkTrans."<br>";
                    //echo "fkSak:".$fkSak."<br>";
		*/
					
					}
				
				
                mysql_free_result($rsMasuk);
                mysql_free_result($rsKstok);
				}//punya nya if($qty_per_kemasan!=0)
            }
        }
        //header("location:penerimaanPO_detil.php?act=add&no_po=$no_po");
		echo "<script>alert('penerimaan PO berhasil!');</script>";
    }
    else if($act == 'edit') 
	{
        for($i=0; $i<count($data_submit)-1; $i++) 
		{
            $status_terima = '';
            $data_fill = explode('*-*',$data_submit[$i]);
            $chkItem1 = explode('|',$data_fill[0]);//chkItem.value
            $chkItem2 = $data_fill[1];//chkItem.checked
            $qty_satuan = $data_fill[2];//txtJmlSatuan
            $satuan = $data_fill[3];//txtSatuan
            $qty_per_kemasan = $data_fill[4];//txtJmlPerKemasan
            $h_satuan = $data_fill[5];//txtHrgSatuan
            $id=$data_fill[6];
			$msk_id=$data_fill[6];
            $poid=$data_fill[7];
            $txtIdBarang=$data_fill[8];
            $txtJmlDiterima=$data_fill[9];
            $txtUraian=$data_fill[10];
			$tipe = $data_fill[11];
			$kib = $data_fill[12];
           
            $sMsk="select jml_msk, sisa from as_masuk where po_id='$poid' and no_gudang='$txtNoPen'";
            $rsMsk = mysql_query($sMsk);
            $rwMsk = mysql_fetch_array($rsMsk);
           
	  /*1.*/
			$query = "update as_masuk set tgl_act=now(),tgl_terima='".$txtTgl."',tgl_faktur='$tglFaktur',no_faktur='$txtFaktur',barang_id='$txtIdBarang',msk_uraian='$txtUraian',jml_msk='$qty_per_kemasan',satuan_unit='$satuan',harga_unit='$h_satuan',pengirim='$txtPengirim',penerima='$PetGud',sisa='$qty_per_kemasan',exp_bayar='$tglTempoBayar' 
            where po_id='$poid' and no_gudang='$txtNoPen'";  //echo "$query<br>";          
            $sukses=mysql_query($query);            
            $totalNow = ($txtJmlDiterima-$rwMsk['jml_msk'])+$qty_per_kemasan;
			//echo $totalNow.'----'.$txtJmlDiterima.'-------'.$tipe.'<br /><br />';
			if($tipe == 1){
				$diffTot = 0;
				if($txtJmlDiterima > $totalNow){ // Delete data apabila jml total diterima sekarang lebih kecil dari total diterima sebelumnya
					$diffTot = $txtJmlDiterima-$totalNow;
					//echo $txtJmlDiterima.">".$totalNow."--------------------------------------<br /><br />";
					$tableKib = 'kib'.$kib;
					switch($kib){
						case '1':
							$filter = 'AND k.luas IS NULL';
							break;
						case '2':
							$filter = 'AND k.merk IS NULL';
							break;
						case '3':
							$filter = 'AND k.bertingkat IS NULL';
							break;
						case '4':
							$filter = 'AND k.konstruksi IS NULL';
							break;
						case '5':
							$filter = 'AND k.buku_judul IS NULL';
							break;
						case '6':
							$filter = 'AND k.fisik_bangunan IS NULL';
							break;
					}
					$sUpDel = "SELECT
								  GROUP_CONCAT(t1.seriid) idseri
								FROM (
									SELECT m.msk_id, m.po_id, s.idseri AS seriid, s.idbarang, s.noseri, s.jenis_kib, k.*
									FROM as_masuk m
									INNER JOIN as_po po
									  ON po.id = m.po_id
									INNER JOIN as_seri2 s
									  ON s.msk_id = m.msk_id
									INNER JOIN $tableKib k
									  ON k.idseri = s.idseri
									WHERE m.po_id ='$poid' AND m.barang_id = '$txtIdBarang' /* $filter */
									ORDER BY s.noseri DESC
									LIMIT $diffTot) as t1";
					//echo $sUpDel.'<br /><br />';
					$queryUpDel = mysql_query($sUpDel);
					$data = mysql_fetch_array($queryUpDel);
					$idseri = $data['idseri'];
					$sDelSeri = "DELETE FROM as_seri2 WHERE idseri IN ($idseri)";
					$sDelKib = "DELETE FROM $tableKib WHERE idseri IN ($idseri)";
					mysql_query($sDelSeri);
					mysql_query($sDelKib);
					//echo $sDelSeri.' ----------------- '.$sDelKib.'<br /><br />';
				} elseif($txtJmlDiterima < $totalNow){
					//$tableKib = 'kib'.$kib;
					$diffTot = $totalNow-$txtJmlDiterima;
					$query = "select max(noseri) as maks from as_seri2 where idbarang = '{$txtIdBarang}' and thn_pengadaan = '{$tahunPem}'";
					$noseriq = mysql_fetch_array(mysql_query($query));
					$query;
					if($noseriq['maks'] != ""){
						$noseri = $noseriq['maks']+1;
					} else {
						$noseri = 1;
					}
					
					for($loop=1;$loop <= $diffTot; $loop++){
						$querySeri = "INSERT INTO as_seri2(idseri, msk_id, idbarang, jenis_kib, asalusul, ms_idunit, noseri, thn_pengadaan)
									VALUES (NULL, '{$msk_id}', '{$txtIdBarang}', '{$kib}', 'Pembelian', NULL, '{$noseri}', '{$tahunPem}')";
						//echo $querySeri."<br /><br />";
						mysql_query($querySeri);
						$idseri = mysql_insert_id();
						$noseri += 1;
						if($kib <= 06){
							$tableKIB = 'kib'.$kib;
							/*switch($kbi){
								case '01':
									$isian = "(idseri) value ('{$idseri}')";
									break;
								case '02':
									$isian = "(idseri) value ('{$idseri}')";
									break;
								case '03':
									$isian = "(idseri) value ('{$idseri}')";
									break;
								case '02':
									$isian = "(idseri) value ('{$idseri}')";
									break;
								case '02':
									$isian = "(idseri) value ('{$idseri}')";
									break;
								case '02':
									$isian = "(idseri) value ('{$idseri}')";
									break;
							}*/
							//echo "<br /><br />";
							$queryKIB = "insert into {$tableKIB}(idseri) value('{$idseri}')";
							//echo $queryKIB."<br /><br />";
							mysql_query($queryKIB);
						}
					}
				}
			}
  /*2 & 3.*/
			$qPo="update as_po set qty_terima='".(($txtJmlDiterima-$rwMsk['jml_msk'])+$qty_per_kemasan)."',STATUS=IF(qty_satuan=qty_terima,1,0) where id='$poid'";
			//echo $qPo;		
            mysql_query($qPo);
            //echo $query ."<br>";
            if($sukses)
			{
                $qMasuk="SELECT m.msk_id,m.tgl_terima,m.no_gudang,m.barang_id,m.jml_msk,mr.namarekanan,m.harga_unit FROM as_masuk m
				INNER JOIN as_po p ON p.id=m.po_id
				INNER JOIN as_ms_rekanan mr ON mr.idrekanan=p.vendor_id where m.no_gudang='$txtNoPen' and tgl_terima='$txtTgl'
				and m.barang_id='$txtIdBarang' order by m.po_id desc limit 1";                    
				//echo $qMasuk."<br />";
		   		$rsMasuk=mysql_query($qMasuk);
                $rwMasuk=mysql_fetch_array($rsMasuk);
                    //echo "qmasuk = ".$qMasuk."<br>";
                    
				$qKstok="select jml_masuk,jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc, stok_id desc  limit 1";
				//echo $qKstok."<br />";
				$rsKstok=mysql_query($qKstok);
				$rwKstok=mysql_fetch_array($rsKstok);
				$jmlSisa=($rwKstok['jml_sisa']=='')?'0':$rwKstok['jml_sisa'];
				$nilaiSisa=($rwKstok['nilai_sisa']=='')?'0':$rwKstok['nilai_sisa'];
				
				$tipe='4';//tipe edit
				$qStok="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
				,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe,koreksi) 
				values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa."','0','".$rwKstok['jml_masuk']."',(jml_awal+jml_masuk-jml_keluar),
				'".$nilaiSisa."','0','".$rwKstok['jml_masuk']*$rwMasuk['harga_unit']."',(nilai_awal+nilai_masuk-nilai_keluar),'Editing Penerimaan PO - ".$rwMasuk['namarekanan']."','$tipe','-')";
				//echo $qStok."<br />";
				$sukses1=mysql_query($qStok);
				if($sukses1){
					if($qty_per_kemasan!='0'){
						$qKstok2="select jml_sisa,nilai_sisa from as_kstok where barang_id='".$rwMasuk['barang_id']."' order by waktu desc, stok_id desc  limit 1";
						//echo $qKstok2."<br />";
						$rsKstok2=mysql_query($qKstok2);
						$rwKstok2=mysql_fetch_array($rsKstok2);
						$jmlSisa2=($rwKstok2['jml_sisa']=='')?'0':$rwKstok2['jml_sisa'];
						$nilaiSisa2=($rwKstok2['nilai_sisa']=='')?'0':$rwKstok2['nilai_sisa'];
						
						$qStok2="insert into as_kstok (waktu,barang_id,msk_id,jml_awal,jml_masuk,jml_keluar,jml_sisa
						,nilai_awal,nilai_masuk,nilai_keluar,nilai_sisa,ket,tipe,koreksi) 
						values (now(),'".$rwMasuk['barang_id']."','".$rwMasuk['msk_id']."','".$jmlSisa2."','$qty_per_kemasan','0',(jml_awal+jml_masuk-jml_keluar),
						'".$nilaiSisa2."','".$qty_per_kemasan*$rwMasuk['harga_unit']."','0',(nilai_awal+nilai_masuk-nilai_keluar),'Editing Penerimaan PO - ".$rwMasuk['namarekanan']."','$tipe','+')";
						//echo $qStok2."<br />";
						mysql_query($qStok2);
					}
				}                 
            }
            /*
             $sHbsPakai="SELECT LEFT(kodebarang,2) as kode FROM as_ms_barang WHERE tipe=2 and idbarang='".$rwMasuk['barang_id']."'";
            //echo "<br>";
            $rsHbsPakai=mysql_query($sHbsPakai);
            $rwHbsPakai=mysql_fetch_array($rsHbsPakai);
            $fkTrans = '';
            //echo "kode:".$rwHbsPakai['kode']."<br>";
            switch($rwHbsPakai['kode']){
                case "01":
                    $fkTrans = '10042';
                    break;
                case "02":
                    $fkTrans = '10042';
                    break;
                case "08":
                    $fkTrans = '10042';
                    break;
                case "03":
                    $fkTrans = '10054';
                    break;
                case "04":
                    $fkTrans = '10054';
                    break;
                case "05":
                    $fkTrans = '10050';
                    break;
                case "06":
                    $fkTrans = '10032';
                    break;
                case "07":
                    $fkTrans = '10046';
                    break;
            }
            
            $qDetail="select fk_ma_sak,dk from akuntansi.detil_transaksi where fk_jenis_trans='$fkTrans'";
            $rsDetail=mysql_query($qDetail);            
            while($rwDetail=mysql_fetch_array($rsDetail)){
                $uJurnal="update akuntansi.jurnal set debit=";
                $uJurnal.=($rwDetail['dk']=='D')?"'".$rwMasuk['jml_msk']*$rwMasuk['harga_unit']."'":"'0'";
                $uJurnal.=",kredit=";
                $uJurnal.=($rwDetail['dk']=='K')?"'".$rwMasuk['jml_msk']*$rwMasuk['harga_unit']."'":"'0'";
                $uJurnal.=",tgl_act=now(),d_k='".$rwDetail['dk']."' where fk_sak='".$rwDetail['fk_ma_sak']."' and no_bukti='".$txtFaktur."' and fk_trans='$fkTrans'";
               
                if(!mysql_query($uJurnal)){
                    echo mysql_error();
                    echo $uJurnal."<br>";
                }                
            
	    */
	    
            mysql_free_result($rsMasuk);
            mysql_free_result($rsKstok);
            //mysql_free_result($rsKstok2);
			      
        }
    }echo "<script>alert('Edit penerimaan PO berhasil!');</script>";   
}

$act = 'add';
if(isset($_GET['act'])) 
{
    $act = $_GET['act'];
}
if($_GET['id'] != '' && isset($_GET['id']) && $_GET['act'] == 'edit') 
{
   $sql = "SELECT * FROM as_masuk pe 
	    INNER JOIN as_po po ON pe.po_id = po.id
	    INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
	    where no_gudang = '".$terima_po[0]."' and no_po = '".$terima_po[1]."' and pe.no_faktur='".$terima_po[2]."'"; //echo $sql;

    $rs1 = mysql_query($sql);
    $res = mysql_affected_rows();
    if($res > 0) 
	{
        $edit = true;
        $rows1 = mysql_fetch_array($rs1);
        $noGudang = $rows1['no_gudang'];
        $noFaktur = $rows1['no_faktur'];        
        $tgl = tglSQL($rows1['tgl_terima']);
        $tglFaktur = tglSQL($rows1['tgl_faktur']);
        $pengirim = $rows1['pengirim'];
        $penerima = $rows1['penerima'];
        $po_rekanan[2] = $rows1['namarekanan'];
        $po_rekanan[3] = $rows1['exp_kirim'];
		$po_rekanan[4] = $rows1['tgl_po'];
        $tglTempoBayar = tglSQL($rows1['exp_bayar']);
        mysql_free_result($rs1);
    }

   /*  $cmbNoPo = "<select name='cmbNoPo' disabled class='txtcenter' id='cmbNoPo' onchange='set()'>";
    $qry = "SELECT distinct po.no_po, vendor_id, rek.namarekanan,po.exp_kirim,tgl_po
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
			inner join as_ms_barang b on b.idbarang = po.ms_barang_id
            where po.status = 0 AND po.ms_barang_id not in 
			(select idbarang from as_ms_barang where kodebarang like '01%' or kodebarang like '03%' 
			or kodebarang like '04%' or kodebarang like '06%' and tipe='1')
            and po.no_po = '".$terima_po[1]."' order by po.tgl_po desc,po.no_po desc";
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) 
	{
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po']."'title='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po']."'";
        if($rows1['namarekanan']==$show['namarekanan'])
		{
           $cmbNoPo .=" selected ";
        }
        $cmbNoPo .=">".$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
        //po_rekanan menggunakan array untuk mengikuti po_rekanan yang sebelumnya sudah dibuat & digunakan
       
    }
    $cmbNoPo .= "</select>";
    $txtNoPo = $rows1['no_po'];
    if($terima_po[1]=='-')
	{
    	$cmbNoPo='';
    } */
}
else 
{
	date_default_timezone_set("Asia/Jakarta");
	$tgl = gmdate('d-m-Y',mktime(date('H')+7));
	$th = explode('-', $tgl);
	$tglcek=$_REQUEST['tgl'];
	$tglc=explode("-",$tglcek);
	$sqlcek="select no_gudang from as_masuk where no_gudang ='GDM/$th[2]-$th[1]/0001' ";
	$rs=mysql_query($sqlcek);
	if(mysql_num_rows($rs)>0)
	{
		$sql="select no_gudang from as_masuk where month(tgl_terima)='$th[1]' and year(tgl_terima)='$th[2]' order by no_gudang desc limit 1";
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)) 
		{
			$noGudang=$rows1["no_gudang"];
			$ctmp=explode("/",$noGudang);
			$dtmp=$ctmp[2]+1;
			$ctmp=$dtmp;
			$ctmp=sprintf("%04d",$ctmp);
			//for ($i=0; $i<(4-strlen($dtmp)); $i++)
			//    $ctmp = "0".$ctmp;
			$noGudang = "GDM/$th[2]-$th[1]/$ctmp";
		}
		else 
		{
			$noGudang = "GDM/$th[2]-$th[1]/0001";
		}
	}
	else
	{
		$noGudang = "GDM/$th[2]-$th[1]/0001";
	}
    /* $cmbNoPo = "<select name='cmbNoPo' class='txtcenter' id='cmbNoPo' onchange='set()'>
        		<option value='' class='txtcenter'>Pilih PO</option>";
    $qry="SELECT distinct po.no_po, vendor_id, rek.namarekanan,po.exp_kirim,po.tgl_po
            FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
			inner join as_ms_barang b on b.idbarang = po.ms_barang_id
            where po.status = 0 AND po.ms_barang_id not in 
			(select idbarang from as_ms_barang where kodebarang like '01%' or kodebarang like '03%' 
			or kodebarang like '04%' or kodebarang like '06%' and tipe='1')order by po.tgl_po desc,po.no_po desc";
    $exe=mysql_query($qry);
    while($show=mysql_fetch_array($exe)) 
	{
        $cmbNoPo .= "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po']."' ";
        if($show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po'] == $no_po)
            $cmbNoPo .= 'selected';

        $cmbNoPo .= " >"
                .$show['no_po'].' - '.$show['namarekanan']
                ."</option>";
    }
    $cmbNoPo .= "</select>"; */
}

//if()
$noPOb = explode('|',$_GET['no_po']);
$tglPOb = explode('-',$noPOb[4]);
?>
<style type="text/css">
#scrollable {
width:972px;
overflow:auto;
height:300;
whitespace:nowrap;
}
</style>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script type="text/javascript" src="jquery-1.7.1.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Penerimaan Baru :.</title>
		<style type="text/css">
			.biasa{
				border:0;
				background:#CEE7FF;
			}
			.biasa:hover{
				background:#8888FF;
			}
		</style>
    </head>
    <body>
        <div align="center">
            <?php
			//echo $terima_po[1].'-----------------------------------------';
            include("../header.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table border="0" width="1000" cellpadding="0" cellspacing="2" bgcolor="#FFFBF0">
                <tr>
                    <td colspan="10" height="20">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" style="font-size:16px;" colspan="15">PENERIMAAN PO</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <form id="form1" name="form1" action="" method="post">
                    <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
                    <input type="hidden" id="data_submit" name="data_submit" value="<?php echo $_POST['data_submit'];?>" />
                    <input type="hidden" id="txtNoPo" name="txtNoPo" value="<?php echo $txtNoPo;?>" />
                    
                    <input type="hidden" id="noGudang" name="noGudang" value="<?php echo $terima_po[0];?>" />
                    <input type="hidden" id="noPo" name="noPo" value="<?php if($act=='add')echo $po_rekanan[0];else echo $terima_po[1];?>" />
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="11%">&nbsp;No Penerimaan</td>
                        <td width="17%">&nbsp;:&nbsp;
                      <input id="txtNoPen" name="txtNoPen" value='<?php echo $noGudang; ?>' class="txtcenter" size="18" <?php if($_GET['act'] == 'edit') echo 'readonly'?>/></td>
                        <td width="6%">&nbsp;</td>
                        <td colspan="5">
						<?php
							if(isset($tglPOb[0]) && $tglPOb[0] != ''){
								$tahunNow = $tglPOb[0];
							} elseif($tglPOb[0] == '') {
								$tahunNow = date('Y');
							}
							if(isset($tglPOb[1]) && $tglPOb[1] != ''){
								$bulanNow = $tglPOb[1];
							} elseif($tglPOb[1] == '') {
								$bulanNow = date('m');
							}
							if($terima_po[1]!=''){
								echo "&nbsp;No PO  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;".$terima_po[1];
							} else {
						?>
							Bulan : <?=$terima_po[1]?>
							<select name="bulanPO" class='txtinput' id="bulanPO" onChange="loadPO('bulan',this.value,'<?=$noPOb[0]?>')">
								<option value="1" <?=($bulanNow==1)?'selected':''?> >Januari</option>
								<option value="2" <?=($bulanNow==2)?'selected':''?> >Ferbruari</option>
								<option value="3" <?=($bulanNow==3)?'selected':''?> >Maret</option>
								<option value="4" <?=($bulanNow==4)?'selected':''?> >April</option>
								<option value="5" <?=($bulanNow==5)?'selected':''?> >Mei</option>
								<option value="6" <?=($bulanNow==6)?'selected':''?> >Juni</option>
								<option value="7" <?=($bulanNow==7)?'selected':''?> >Juli</option>
								<option value="8" <?=($bulanNow==8)?'selected':''?> >Agustus</option>
								<option value="9" <?=($bulanNow==9)?'selected':''?> >September</option>
								<option value="10" <?=($bulanNow==10)?'selected':''?> >Oktober</option>
								<option value="11" <?=($bulanNow==11)?'selected':''?> >November</option>
								<option value="12" <?=($bulanNow==12)?'selected':''?> >Desember</option>
							</select>&nbsp;&nbsp;&nbsp;
							Tahun :
							<select name="tahunPO" id="tahunPO" class='txtinput' onChange="loadPO('tahun',this.value,'<?=$noPOb[0]?>')">
								<?php
									for($tahunList = $tahunNow; $tahunList >= ($tahunNow-5); $tahunList--){
										$select = ($tahunList == $tahunNow)?'selected':'';
										echo "<option value='$tahunList' $select >$tahunList</option>";
									}
								?>
							</select>	
							<br />
							<br />
							<div id="DaftarPO" style="margin-left:10px;">
								<?php //include('listPO.php'); ?>
							</div>
						<?php
							}
						?>
						</td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="11%">&nbsp;Tgl Penerimaan</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtTgl" name="txtTgl" readonly value="<?php if(isset($tgl) ) echo $tgl; else echo $date_now;?>" size="10" class="txtcenter"/>&nbsp;
                            <?php
                             if($act != 'edit') { 
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,cek); " />
                      <?php
                            }
                            ?>                        </td>
                        <td width="6%">&nbsp;</td>
                        <td colspan="5">&nbsp;Supplier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;: &nbsp;<?php echo $po_rekanan[2];?></td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;No Faktur</td>
                      <td width="17%">&nbsp;:&nbsp;
                        <input id="txtFaktur" name="txtFaktur" value="<?php echo $noFaktur; ?>" <?php if($act == 'edit') { echo " readonly ";}?> class="txtcenter" size="15" />
                      <td>&nbsp;</td>
                        <td colspan="5">&nbsp;Jatuh Tempo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo tglSQL($po_rekanan[3]);?>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="11%">&nbsp;Tgl Faktur</td>
                        <td width="17%">&nbsp;:&nbsp;
                            <input id="txtTglFaktur" name="txtTglFaktur" value="<?php if(isset($tglFaktur) ) echo $tglFaktur; else echo $date_now;?>" readonly size="10" class="txtcenter"/>&nbsp;
                            <?php
                            if($act != 'edit') {
                                ?>
                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTglFaktur'),depRange);" />
                      <?php
                            }
                            ?>                        </td>
                        <td width="6%">&nbsp;</td>
                        <td colspan="5">
						<?php
							$tahun = explode('-',$po_rekanan[4]);
							$tahunPem = $tahun[0];
						?>
						<input type="hidden" name="tahunPem" value="<?php echo $tahunPem; ?>"/>
						&nbsp;Tgl PO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo tglSQL($po_rekanan[4]);?>                     </td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;Pengirim</td>
                      <td width="17%">&nbsp;:&nbsp;
                        <input id="txtPengirim" name="txtPengirim" class="txtinput" size="15" value="<?php echo isset($pengirim)?$pengirim:"";?>" />
                      <td>&nbsp;</td>
                        <td colspan="5"> &nbsp;Jatuh Tempo Bayar :&nbsp;
                          <input id="txtTglTempoBayar" name="txtTglTempoBayar" value="<?php if(isset($tglTempoBayar) ) echo $tglTempoBayar; else echo $date_now;?>" readonly size="10" class="txtcenter"/>
                      &nbsp; <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('txtTglTempoBayar'),depRange);" /> </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;Petugas Gudang</td>
                      <td width="17%">&nbsp;:&nbsp;
                        <input id="txtPetGud" name="txtPetGud" value="<?php echo $user?>" readonly class="txtinput" size="15" />
                      <td>&nbsp;</td>
                        <td colspan="5" align="right">
							<input type="button" id="barcode" name="barcode" value="Cetak Barcode" onClick="cetakbarcode();"  />
						</td>
                        <td>&nbsp;</td>
                    </tr>                   
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="8" align="center">
                            <table id="tblpenerimaan" width="950" border="0" cellpadding="1" cellspacing="0" style="table-layout:fixed">
                                <tr class="headtable">
                                  <td width="25" height="50" class="tblheaderkiri">No</td>
                                  <td id="kodebarang" width="25" class="tblheader">
                                      <input type="checkbox" name="chkAll" id="chkAll" value="" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> onClick="fCheckAll(this,'chkItem');/*HitunghDiskonTot();*/HitunghTot();" style="cursor:pointer" title="Pilih Semua" /></td>
                                  <td width="75" class="tblheader" id="namabarang">Kode Barang</td>
                                  <td id="qty_kemasan" width="140" class="tblheader"><p>Nama Barang</p></td>
                                  <td id="uraian" width="50" class="tblheader"><p>Uraian</p></td>
                                  <td id="kemasan" width="50" class="tblheader">Satuan</td>
                                  <td width="50" class="tblheader">Jumlah Pesan</td>
                                  <td width="65" class="tblheader">Peruntukan</td>
                                  <td width="65" class="tblheader">Jumlah Diterima Sebelumnya</td>
                                  <td width="65" class="tblheader">Jumlah Diterima Sekarang</td>
                                  <td width="75" class="tblheader">Harga Satuan</td>
                                  <td colspan="2" width="85" class="tblheader" style="">Sub Total</td>
                              </tr>
							  <tr>
							  <td colspan="13">
							  <div id="scrollable">
							  <table cellpadding="0" cellspacing="0" style="table-layout:fixed;" width="950">
                                <?php
								function cekData($idbarang,$no_po,$tglCek,$msk_id){
									$tglCek2 = explode('-',$tglCek);
									$tahunCek = $tglCek2[0];
									$bulanCek = $tglCek2[1];
									$sql = " SELECT jml_msk, sisa FROM as_masuk WHERE msk_id = '{$msk_id}' AND barang_id = '{$idbarang}' ";
									/* $sql = "SELECT
											((SELECT IF(SUM(m.jml_msk) IS NULL, 0, SUM(m.jml_msk))
											FROM as_masuk m
											WHERE m.barang_id = '{$idbarang}'
											  AND po_id <> 0) - (SELECT IF(SUM(kel.jml_klr) IS NULL,0,SUM(kel.jml_klr))
											FROM as_keluar kel
											WHERE kel.barang_id = '{$idbarang}'
											)) AS sisa,

											(SELECT IF(SUM(ma.jml_msk) IS NULL, 0, SUM(ma.jml_msk))
											FROM as_masuk ma
											INNER JOIN as_po po
											  ON po.id = ma.po_id
											WHERE ma.barang_id = '{$idbarang}'
											  AND YEAR(ma.tgl_act) = '{$tahunCek}'
											  AND MONTH(ma.tgl_act) = '{$bulanCek}'
											  AND po.no_po = '{$no_po}') AS jmlMasuk"; */
									//echo $sql.'<br /><br />';
									$dataCek = mysql_fetch_array(mysql_query($sql));
									if($dataCek['sisa'] != $dataCek['jml_msk']){
										return 'disabled';
									}
								}
                                if(isset($_GET['act']) && $_GET['act'] == 'edit' || isset($no_po)) 
								{
                                    if($_GET['act'] == 'edit') 
									{
                                       $sql = "select b.tipe, q1.*,namabarang,kodebarang,u.* from
                                                (SELECT pe.*, po.no_po, qty_satuan,po.peruntukan, satuan,harga_satuan,po.qty_terima,po.unit_id
                                                FROM as_masuk pe inner join as_po po on pe.po_id = po.id
                                                where pe.no_gudang = '$terima_po[0]' and po.no_po = '$terima_po[1]'
                                                order by pe.msk_id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.barang_id
                                                left join as_ms_unit u on q1.unit_id = u.idunit";
                                        //no_po, tgl, tgl_j_tempo, hari_j_tempo, qty_kemasan, qty_kemasan_terima, kemasan, harga_kemasan, qty_perkemasan, qty_satuan, qty_pakai, qty_satuan_terima, satuan, harga_beli_total, harga_beli_satuan, diskon, extra_diskon, diskon_total, ket, nilai_pajak, jenis, termasuk_ppn, status, user_act, tgl_act
                                    }
                                    else 
									{
                                        if($no_po != '') 
										{
                                           $sql = "select b.tipe, q1.*, q1.uraian as msk_uraian,q1.peruntukan,b.namabarang,b.kodebarang,u.* from (SELECT *
                                                FROM as_po po
                                                where po.no_po = '$po_rekanan[0]' and status = 0 and po.tgl_po='$po_rekanan[4]'
                                                order by po.id) as q1
                                                INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id
                                                left join as_ms_unit u on q1.unit_id = u.idunit";
                                        }
                                    }
                                    //echo $sql;
                                    $rs=mysql_query($sql);
                                    $i=0;
                                    $tot=0;
                                    while ($rows=mysql_fetch_array($rs)) 
									{
										$tipe = cekNull($rows['tipe']);
                                        $id = cekNull($rows['msk_id']);
                                        $poid = cekNull($rows['po_id']);
										$poid2 = cekNull($rows['id']);
                                        $idbarang = cekNull($rows['barang_id']);
                                        $kodebarang = cekNull($rows['kodebarang']);
                                        $namabarang = cekNull($rows['namabarang']);
                                        $uraian = $rows['msk_uraian'];
                                        $subtotal = cekNull($rows['subtotal']);
                                        $total = cekNull($rows['total']);
                                        $exp_kirim = $rows['exp_kirim'];
                                        $satuan = $rows['satuan'];
                                        $kemasan = $rows['kemasan'];  
                                        $namaunit = $rows['peruntukan'];   
                                        $qty_kemasan = cekNull($rows['qty_kemasan']);
                                        $qty_terima=cekNull($rows['qty_terima']);
                                        $qty_kemasan_terima = cekNull($rows['jml_msk']);
                                        $qty_satuan = cekNull($rows['qty_satuan']);
										$kib = explode('.',$kodebarang);
                                        //jika act bukan edit, maka isi qty_kemasan_terima = database
                                        if($_GET['act'] != 'edit')
										{
                                            $qty_kemasan_terima = 0;//($qty_terima!=0)?(cekNull($rows['qty_satuan'])-$qty_terima):cekNull($rows['qty_satuan']);
                                            $idbarang=cekNull($rows['ms_barang_id']);
                                            $uraian = $rows['uraian'];
											$diss = '';
                                        } else {
											$diss = cekData($idbarang,$po_rekanan[0],$po_rekanan[4],$id);
										}
                                        $harga_kemasan = cekNull($rows['harga_kemasan']);
                                        //$harga_satuan = cekNull($rows['harga_satuan']);
									   	if($_GET['act'] == 'add') 
										{
                                        	$harga_satuan = cekNull($rows['harga_satuan']); 
										}
										if($_GET['act'] == 'edit') 
										{
                                        	$harga_satuan = cekNull($rows['harga_unit']); 
										}
                                        $sub_tot = cekNull(($qty_kemasan-$qty_kemasan_terima)*$harga_kemasan);
                                        
                                        $diskon = cekNull($rows['diskon']);
                                        ?>
                                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                                    <td width="25" class="tdisikiri"><?php echo ++$i; ?></td>
                                    <td width="25" class="tdisi" align="center">
                                        <input type="checkbox" name="chkItem" id="chkItem" class="chkItem" <?php if($_GET['act'] == 'edit') echo 'checked disabled';?> value="<?php echo $id.'|'.$idbarang; ?>" onClick="/*HitunghDiskonTot();*/ HitunghTot();" />
									</td>
                                    <td width="75" class="tdisi" align="center" style="word-wrap: break-word">                                        
										  <input type="hidden" id='tipe' name="tipe" value="<?php echo $tipe; ?>" size="1" readonly />
										  <input type="hidden" id='kib' name="kib" value="<?php echo $kib[0]; ?>" size="1" readonly />
                                          <input id="txtId" name="txtId" type="hidden" readonly="readonly" value="<?php echo $id; ?>" />
                                          <input id="txtPoId" name="txtPoId" type="hidden" readonly="readonly" value="<?php echo $poid; ?>" />
										  <input id="txtPoId2" name="txtPoId2" type="hidden" readonly="readonly" value="<?php echo $poid2; ?>" />
                                          <input id="txtIdBarang" name="txtIdBarang" type="hidden"  readonly="readonly" value="<?php echo $idbarang; ?>" />
                                          <?php echo $kodebarang; ?>
									</td>
                                    <td width="140" class="tdisi" align="left">&nbsp;                                        
                                        <?php echo $namabarang; ?>
									</td>
									<td width="50" class="tdisi" align="center"><?php echo $uraian; ?>&nbsp;
										<input id="txtUraian" name="txtUraian" type="hidden" class="txtcenter biasa" size="5" readonly="readonly" value="<?php echo $uraian; ?>" />
									</td>
									<td width="50" class="tdisi" align="center"><?php echo $satuan; ?>&nbsp;
										<input id="txtSatuan" name="txtSatuan" type="hidden" class="txtcenter biasa" size="5" readonly="readonly" value="<?php echo $satuan; ?>" />
									</td>
									<td width="50" class="tdisi" align="center"><?php echo $qty_satuan; ?>&nbsp;
										<input id="txtJmlSatuan" name="txtJmlSatuan" type="hidden" class="txtcenter biasa" size="5" readonly="readonly" value="<?php echo $qty_satuan; ?>" />
									</td>
									<td width="65" class="tdisi" align="center"><?php echo $namaunit; ?>&nbsp;
										<input id="unit" name="unit" type="hidden" class="txtcenter biasa" size="8" readonly="readonly" value="<?php echo $namaunit; ?>" />
									</td>
									<td width="65" class="tdisi" align="center"><?php echo $qty_terima; ?>&nbsp;
										<input id="txtJmlDiterima" name="txtJmlDiterima" type="hidden" class="txtcenter biasa" size="8" readonly="readonly" value="<?php echo $qty_terima; ?>" />
									</td>
									<td width="65" class="tdisi" align="center">
										<input id="txtJmlPerKemasan" name="txtJmlPerKemasan" <?php echo $diss;?> type="text" class="txtcenter" value="<?php echo $qty_kemasan_terima; ?>" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);" size="8" />
										<input id="diterima_sblmnya" name="diterima_sblmnya" type="hidden" readonly="true" class="txtcenter" value="<?php echo $qty_kemasan_terima; ?>" size="3" />
									</td>
									<td width="75" class="tdisi" align="center">
										<input id="txtHrgSatuan" size="8" <?php echo $diss;?> name="txtHrgSatuan" type="text" class="txtright" value="<?php echo number_format($harga_satuan,0,",","."); ?>"  onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);zxc(this);"/>
									</td>
									<td colspan="2" width="85" class="tdisi" align="center"><span id="totBaru<?php echo $i-1; ?>" ><?php echo number_format($qty_kemasan_terima*$harga_satuan,0,",","."); ?></span>&nbsp;
									<input id="txtSubTotal" size="12" name="txtSubTotal" type="hidden" class="txtright biasa" readonly="readonly" value="<?php echo number_format($qty_kemasan_terima*$harga_satuan,0,",","."); ?>" />
									</td>
                                </tr>
                                        <?php
                                        $tot+=($qty_kemasan_terima*$harga_satuan);
                                    }
                                    mysql_free_result($rs);
                                }
                                ?>
								</table>
								</div>								</tr>
								</td>
                            </table>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td width="10%" align="center">TOTAL</td>
                      <td width="14%" align="center"><div align="left">:
                        <input id="txtTotal" class="txtright" align="right" value="<?php echo number_format($tot,0,",",".");?>" readonly name="txtTotal" size="15" />
                      </div></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="6" align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="4" align="right">
                            <button type="button" onClick="if (ValidateForm('txtFaktur,txtPengirim,txtPetGud','ind')){kirim();}" style="cursor: pointer">
                                <img alt="save" src="../icon/save.gif" border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>                        </td>
                        <td colspan="4" align="left">&nbsp;
                            <button type="reset" onClick="location='penerimaanPO.php'" style="cursor: pointer">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;                            </button>                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </form>
                <tr>
                    <td colspan="10">
                        <?php
                        include '../footer.php';
                        ?>                    </td>
                </tr>
            </table>
    </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>

    <script type="text/javascript" language="javascript">
		jQuery(document).ready(function(){
			jQuery("#DaftarPO").load('listPO.php?no_po=<?=$noPOb[0]?>&tahun=<?=$tglPOb[0]?>&bulan=<?=$tglPOb[1]?>');
		});
		
		function viewPO(par){
			var nopo = par.split('|');
			var x = screen.width/2 - 1000/2;
			var y = screen.height/2 - 600/2;
			//alert(nopo[0]+" - "+nopo[4]);
			window.open('viewPO.php?nopo='+nopo[0]+'&tgl='+nopo[4],'_blank',"height=550,width=980,left="+x+",top="+y);
		}
		
		function loadPO(par,isi,no_po){
			var bulan = jQuery('#bulanPO').val();
			var tahun = jQuery('#tahunPO').val();
			var url = '';
			if(par == 'bulan'){
				urlPar = '?tahun='+tahun+'&bulan='+isi+'&no_po='+no_po;
			} else if(par == 'tahun'){
				urlPar = '?tahun='+isi+'&bulan='+bulan+'&no_po='+no_po;
			}
			jQuery("#DaftarPO").load('listPO.php'+urlPar);
		}
		
        var arrRange=depRange=[];
		function cek(){
			var tgl=document.getElementById('txtTgl').value;
			//location="../Aktivitas/penerimaanPO_detil.php?tgl="+tgl; 
		}
        function cetakbarcode(){
            var tgl=document.getElementById('txtTgl').value;
            if(document.getElementById('act').value=="add"){
                window.open('barcode.php?opt=add&tgl='+tgl+'&no_po='+document.getElementById('noPo').value);
            }else{
                window.open('barcode.php?opt=edit&tgl='+tgl+'&no_gudang='+document.getElementById('noGudang').value+'&no_po='+document.getElementById('noPo').value);
            }
        }
        function kirim(){
            var data_submit = '';            
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    data_submit += document.forms[0].chkItem[i].value //0
						+'*-*'+document.forms[0].chkItem[i].checked //1
                        +'*-*'+document.forms[0].txtJmlSatuan[i].value //2
                        +'*-*'+document.forms[0].txtSatuan[i].value //3               
                        +'*-*'+document.forms[0].txtJmlPerKemasan[i].value //4
                        +'*-*'+ValidasiText(document.forms[0].txtHrgSatuan[i].value) //5
                        +'*-*'+document.forms[0].txtId[i].value //6
                        +'*-*'+document.forms[0].txtPoId[i].value //7
                        +'*-*'+document.forms[0].txtIdBarang[i].value //8
                        +'*-*'+document.forms[0].txtJmlDiterima[i].value //9
                        +'*-*'+document.forms[0].txtUraian[i].value //10
						+'*-*'+document.forms[0].tipe[i].value //11
						+'*-*'+document.forms[0].kib[i].value //12
						+'*-*'+document.forms[0].txtPoId2[i].value //13
                        +'*|*';
                }                
            }
            else{
                data_submit = document.forms[0].chkItem.value
					+'*-*'+document.forms[0].chkItem.checked
                    +'*-*'+document.forms[0].txtJmlSatuan.value
                    +'*-*'+document.forms[0].txtSatuan.value
                    +'*-*'+document.forms[0].txtJmlPerKemasan.value                        
                    +'*-*'+ValidasiText(document.forms[0].txtHrgSatuan.value)
                    +'*-*'+document.forms[0].txtId.value
                    +'*-*'+document.forms[0].txtPoId.value
                    +'*-*'+document.forms[0].txtIdBarang.value
                    +'*-*'+document.forms[0].txtJmlDiterima.value
                    +'*-*'+document.forms[0].txtUraian.value 
					+'*-*'+document.forms[0].tipe.value
					+'*-*'+document.forms[0].kib.value
					+'*-*'+document.forms[0].txtPoId2.value //13
                    +'*|*';
            }
            document.forms[0].data_submit.value = data_submit;
            document.getElementById('form1').submit();
        }
        
        function fCheckAll(chkAll,chkItem)
		{
			//$("#chkItem").attr('checked',true);
            if(chkAll.checked)
			{
				$(".chkItem").attr('checked',true);
                /*if(document.forms[0].chkItem.length)
				{*/
                    for(var i=0; i<$("#chkItem").length; i++)
					{
                        //document.forms[0].chkItem[i].checked=true;
						//$(".chkItem").attr('checked',true);
                        HitungSubTotal(i);
                    }
                /*}*/
            }
			else
			{
				$(".chkItem").attr('checked',false);
                /*if(document.forms[0].chkItem.length)
				{*/
                    for(var i=0; i<$("#chkItem").length; i++)
					{
                        //document.forms[0].chkItem[i].checked=false;
                        HitungSubTotal(i);
                    }
                /*}*/
            }
            HitunghTot();
           /* if(chkAll.checked)
			{
                if(document.forms[0].chkItem.length)
				{
                    for(var i=0; i<document.forms[0].chkItem.length; i++)
					{
                        document.forms[0].chkItem[i].checked=true;
                        HitungSubTotal(i);
                    }
                }
            }
			else
			{
                if(document.forms[0].chkItem.length)
				{
                    for(var i=0; i<document.forms[0].chkItem.length; i++)
					{
                        document.forms[0].chkItem[i].checked=false;
                        HitungSubTotal(i);
                    }
                }
            }
            HitunghTot();*/
        }

        function cekVal(line){
            if(document.forms[0].chkItem.length){
                //alert(document.forms[0].qty_kemasan[line].value+'>'+document.forms[0].hid_qty_kemasan[line].value);
                var qty_kemasan = parseInt(document.forms[0].qty_kemasan[line].value);
                var hid_qty_kemasan = parseInt(document.forms[0].hid_qty_kemasan[line].value);
                if(qty_kemasan > hid_qty_kemasan){
                    alert('Jumlah item yang diterima lebih besar dari aslinya.');
                    document.forms[0].qty_kemasan[line].value = document.forms[0].hid_qty_kemasan[line].value;
                    HitungQtySatuan(line);
                    HitungSubTotal(line);
                    HitungDiskon(line);
                }
            }
            else{
                if(document.forms[0].qty_kemasan.value > document.forms[0].hid_qty_kemasan.value){
                    alert('Jumlah item yang diterima lebih besar dari aslinya.');
                    document.forms[0].qty_kemasan.value = document.forms[0].hid_qty_kemasan.value;
                    HitungQtySatuan();
                    HitungSubTotal();
                    HitungDiskon();
                }
            }
        }

        function HitungDiskon(line,which){
            if (document.forms[0].chkItem.length){
                var sub_tot = document.forms[0].sub_tot[line].value;
                if(which == 1){
                    var diskon = document.forms[0].diskon[line].value;
                    document.forms[0].diskon_rp[line].value = sub_tot*diskon/100;
                }
                else{
                    var diskon_rp = document.forms[0].diskon_rp[line].value;
                    document.forms[0].diskon[line].value = diskon_rp*100/sub_tot;
                }
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var sub_tot = document.forms[0].sub_tot.value;
                if(which == 1){
                    var diskon = document.forms[0].diskon.value;
                    document.forms[0].diskon_rp.value = sub_tot*diskon/100;
                }
                else{
                    var diskon_rp = document.forms[0].diskon_rp.value;
                    document.forms[0].diskon.value = diskon_rp*100/sub_tot;
                }
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

//        function HitungSubTotal(line)
//		{alert('tesstt');
//            var qty_kemasan,h_kemasan;
//            if(document.forms[0].chkItem.length)
//			{
//                qty_kemasan = document.forms[0].qty_kemasan[line].value;
//                h_kemasan = document.forms[0].h_kemasan[line].value;
//                document.forms[0].sub_tot[line].value = qty_kemasan*h_kemasan;
//            }
//            else{
//                qty_kemasan = document.forms[0].qty_kemasan.value;
//                h_kemasan = document.forms[0].h_kemasan.value;
//                document.forms[0].sub_tot.value = qty_kemasan*h_kemasan;
//            }
//        }

        function HitungHargaSatuan(line){
            if (document.forms[0].chkItem.length){
                var qty_per_kemasan = document.forms[0].qty_per_kemasan[line].value;
                var h_kemasan = document.forms[0].h_kemasan[line].value;
                document.forms[0].h_satuan[line].value = (h_kemasan/qty_per_kemasan).toFixed(2);
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var qty_per_kemasan = document.forms[0].qty_per_kemasan.value;
                var h_kemasan = document.forms[0].h_kemasan.value;
                document.forms[0].h_satuan.value = (h_kemasan/qty_per_kemasan).toFixed(2);
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

        function HitungQtySatuan(line){
            if (document.forms[0].chkItem.length){
                var qty_kemasan = document.forms[0].qty_kemasan[line].value;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan[line].value;
                document.forms[0].qty_satuan[line].value = qty_kemasan*qty_per_kemasan;
                if(document.forms[0].chkItem[line].checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else{
                var qty_kemasan = document.forms[0].qty_kemasan.value;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan.value;
                document.forms[0].qty_satuan.value = qty_kemasan*qty_per_kemasan;
                if(document.forms[0].chkItem.checked){
                    HitunghDiskonTot();
                    HitunghTot();
                }
            }
        }

        function HitunghDiskonTot(){
            var tmp = 0;
            if(document.forms[0].chkItem.length){
                for(var i=0; i<document.forms[0].chkItem.length; i++){
                    if(document.forms[0].chkItem[i].checked){
                        //alert(document.forms[0].diskon_rp[i].value);
                        tmp += ValidasiText(document.forms[0].diskon_rp[i].value)*1;
                    }
                }
            }
            else{
                tmp = document.forms[0].diskon_rp.value;
            }
            document.forms[0].txtDiskon.value = FormatNumberFloor(parseInt(tmp),".");
        }

        function HitunghTot(){
            var tmp = 0;
            if(document.forms[0].chkItem.length)
			{
                for(var i=0; i<document.forms[0].chkItem.length; i++)
				{
                    if(document.forms[0].chkItem[i].checked){
                        tmp += ValidasiText(document.forms[0].txtSubTotal[i].value)*1;
                    }
                }
            }
            else
			{
				if(document.forms[0].chkItem.checked)
				{
               		tmp = ValidasiText(document.forms[0].txtSubTotal.value)*1;
				}
            }
           
            document.forms[0].txtTotal.value =FormatNumberFloor(parseInt(tmp),".");
        }

        function set()
        {
            var nopo = document.getElementById('cmbNoPo').value;
            //alert(nopo);          
            //alert("detailPenerimaan.php?act=<?php echo $act;?>&no_po="+nopo);
            window.location = "penerimaanPO_detil.php?act=<?php echo $act;?>&no_po="+nopo;
        }
        
        function bandingkan(kiri,kanan){
            if(!isNaN(kiri) && !isNaN(kanan)){                
                if(parseFloat(kiri)>parseFloat(kanan)){
                    return "lebih besar";
                }
                else if(parseFloat(kiri)<parseFloat(kanan)){
                    return "lebih kecil";
                }
                else if(parseFloat(kiri)==parseFloat(kanan)){
                    return "sama";
                }
            }
            else{
                alert('Isilah Dengan Angka!');
            }
        }
	
		
        function HitungSubTotal(line){//alert('tes');
            if (document.forms[0].chkItem.length)
			{                
                var h_kemasan = document.forms[0].txtHrgSatuan[line].value;
                var qty_satuan = document.forms[0].txtJmlSatuan[line].value*1;
				var qty_satuan_terima = document.forms[0].txtJmlDiterima[line].value*1;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan[line].value*1;
				//var totalTerima = qty_satuan_terima+qty_per_kemasan;
				
				//alert(totalTerima);
				<?
				if($_REQUEST['act']=='edit')
				{
				?>
					var diterima_sblmnya =  document.forms[0].diterima_sblmnya[line].value*1;
					var yg_diterima_selain_brg_ini =  qty_satuan_terima-diterima_sblmnya; //alert(yg_diterima_selain_brg_ini);
					var sisa = qty_satuan-yg_diterima_selain_brg_ini;
					
					if(qty_per_kemasan > qty_satuan)
					{
						alert('Tidak boleh melebihi jumlah pesan! jumlah pesan = '+qty_satuan);
						document.forms[0].txtJmlPerKemasan[line].value='';
					}
					else if(qty_per_kemasan > sisa)
					{
						alert('Tidak boleh melebihi jumlah sisa! total yang sudah diterima selain barang ini = '+yg_diterima_selain_brg_ini);
						document.forms[0].txtJmlPerKemasan[line].value='';
					}
					else
					{
						//var qty_per_kemasan = ValidasiText(qty_per_kemasan);
						var h_kemasan = ValidasiText(h_kemasan);
						var sub_tot = h_kemasan*qty_per_kemasan;
						
						document.forms[0].txtSubTotal[line].value = FormatNumberFloor(parseInt(sub_tot),".");
						jQuery('#totBaru'+line).html(FormatNumberFloor(parseInt(sub_tot),"."));
					}
				<?
				}
				else if($_REQUEST['act']=='add')
				{
				?>	var sisa = qty_satuan-qty_satuan_terima;
					if(qty_per_kemasan > sisa)
					{
						if(qty_satuan_terima==0)
						{
							alert('Tidak boleh melebihi jumlah pesan! jumlah pesan = '+qty_satuan);
						}
						else
						{
							alert('Tidak boleh melebihi jumlah sisa! jumlah sisa='+sisa);
						}
						document.forms[0].txtJmlPerKemasan[line].value='';
					}
					else
					{
						//var qty_per_kemasan = ValidasiText(qty_per_kemasan);
						var h_kemasan = ValidasiText(h_kemasan);
						var sub_tot = h_kemasan*qty_per_kemasan;
						
						document.forms[0].txtSubTotal[line].value = FormatNumberFloor(parseInt(sub_tot),".");
						jQuery('#totBaru'+line).html(FormatNumberFloor(parseInt(sub_tot),"."));
					}
				<?	
				}
				?>
                /*if(totalTerima > qty_satuan)
				{
                    alert('Tidak boleh melebihi jumlah pesan! ('+qty_satuan+')('+qty_per_kemasan+')');
                    document.forms[0].txtJmlPerKemasan[line].value='';
                }*/
                
                if(document.forms[0].chkItem[line].checked)
				{
                    //HitunghDiskonTot();
                    HitunghTot();
                }
            }
            else
			{
                var h_kemasan = document.forms[0].txtHrgSatuan.value;
                var qty_satuan = document.forms[0].txtJmlSatuan.value*1;
                var qty_per_kemasan = document.forms[0].txtJmlPerKemasan.value*1;
				var qty_satuan_terima = document.forms[0].txtJmlDiterima.value*1;
				var totalTerima = qty_satuan_terima+qty_per_kemasan;
				//alert(totalTerima+','+qty_satuan);
				<?
				if($_REQUEST['act']=='edit')
				{
				?>
					var diterima_sblmnya =  document.forms[0].diterima_sblmnya.value*1;
					var yg_diterima_selain_brg_ini =  qty_satuan_terima-diterima_sblmnya; //alert(yg_diterima_selain_brg_ini);
					var sisa = qty_satuan-yg_diterima_selain_brg_ini;
					
					if(qty_per_kemasan > qty_satuan)
					{
						alert('Tidak boleh melebihi jumlah pesan! jumlah pesan = '+qty_satuan);
						document.forms[0].txtJmlPerKemasan.value='';
					}
					else if(qty_per_kemasan > sisa)
					{
						alert('Tidak boleh melebihi jumlah sisa! total yang sudah diterima selain barang ini = '+yg_diterima_selain_brg_ini);
						document.forms[0].txtJmlPerKemasan.value='';
					}
					else
					{
						//var qty_per_kemasan = ValidasiText(qty_per_kemasan);
						var h_kemasan = ValidasiText(h_kemasan);
						var sub_tot = h_kemasan*qty_per_kemasan;
						
						document.forms[0].txtSubTotal.value = FormatNumberFloor(parseInt(sub_tot),".");
						jQuery('#totBaru'+line).html(FormatNumberFloor(parseInt(sub_tot),"."));
					}
				<?
				}
				else if($_REQUEST['act']=='add')
				{
				?>	var sisa = qty_satuan-qty_satuan_terima;
					if(qty_per_kemasan > sisa)
					{
						if(qty_satuan_terima==0)
						{
							alert('Tidak boleh melebihi jumlah pesan! jumlah pesan = '+qty_satuan);
						}
						else
						{
							alert('Tidak boleh melebihi jumlah sisa! jumlah sisa='+sisa);
						}
						document.forms[0].txtJmlPerKemasan.value='';
					}
					else
					{
						//var qty_per_kemasan = ValidasiText(qty_per_kemasan);
						var h_kemasan = ValidasiText(h_kemasan);
						var sub_tot = h_kemasan*qty_per_kemasan;
						
						document.forms[0].txtSubTotal.value = FormatNumberFloor(parseInt(sub_tot),".");
						jQuery('#totBaru'+line).html(FormatNumberFloor(parseInt(sub_tot),"."));
					}
				<?	
				}
				?>
               /* if(qty_per_kemasan > qty_satuan)
				{
                    alert('Tidak boleh melebihi jumlah pesan!');
                    document.forms[0].txtJmlPerKemasan.value='';
                }
                else
				{
					//var qty_per_kemasan = ValidasiText(qty_per_kemasan);
					var h_kemasan = ValidasiText(h_kemasan);
					var sub_tot = h_kemasan*qty_per_kemasan;
					
                    document.forms[0].txtSubTotal.value = FormatNumberFloor(parseInt(sub_tot),".");
					jQuery('#totBaru'+line).html(FormatNumberFloor(parseInt(sub_tot),"."));
                }*/
				
               	if(document.forms[0].chkItem.checked)
			   	{                    
                    HitunghTot();
                }
            }
        }
		
		function zxc(par)
		{
			var r=par.value;
			while (r.indexOf(".")>-1){
				r=r.replace(".","");
			}
			var nilai=FormatNumberFloor(parseInt(r),".");
			if(nilai=='NaN'){
				par.value = '';
			}
			else{
				par.value = nilai;
			}	
			//var xxx = ValidasiText(nilai);alert(xxx);
		}
		
		function ValidasiText(p){
			var tmp=p;
			while (tmp.indexOf('.')>0){
				tmp=tmp.replace('.','');
			}
			while (tmp.indexOf(',')>0){
				tmp=tmp.replace(',','.');
			}
			return tmp;
		}
    </script>
</html>
