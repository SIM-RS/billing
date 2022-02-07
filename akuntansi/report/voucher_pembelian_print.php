<?php
session_start();
	include("../sesi.php");
	include("../koneksi/konek.php");

	$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
	$wktnow=gmdate('H:i:s',mktime(date('H')+7));
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	$kso = $_REQUEST['cmbKsoRep'];
	$cwaktu = $waktu;
	$waktu = "Bulanan";
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND j.TGL = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $tmpBln = explode('|',$_REQUEST['cmbBln']);
		$bln = $tmpBln['0'];
        $thn = $_REQUEST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
		$waktu = " AND MONTH(j.TGL) = '$bln' AND YEAR(j.TGL) = '$thn' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND j.TGL between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Bukti Jurnal Pembelian</title>
</head>

<body>
    <style>
        #table_buktipendukung td, .table1_tdkiri {
            border: none;
        }

        .table1 td {
            padding: 3px;
        }

        .table3 {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table3 td,
        .table3 th {
            border: 1px solid black;
            padding: 8px;
        }


        .table3 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        tr a {
            text-decoration: none;
            color: #000000;
        }

        .tblheaderkiri {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: none;
            border-bottom: 1px solid #003520;
            border-left: 1px solid #003520;
            font-weight: bold;
        }

        .tblheaderkanan {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .tblheader {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: none;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .tblfooterkiri {
            padding: 8px;
            border: 1px solid #003520;
            font-weight: bold;
        }

        .tblfooter {
            padding: 8px;
            border-top: 1px solid #003520;
            border-right: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-left: none;
            font-weight: bold;
        }

        .jumlah {
            border-top: 1px dashed #003520;

            border-bottom: 1px dashed #003520;
            border-right: 1px solid #203C42;

        }

        .tdisi {
            padding-top: 8px;
            padding-right: 8px;
            padding-left: 8px;
            border-top: none;
            border-right: 1px solid #203C42;
            border-left: none;
            /*font-size: 11px;
            /*text-align: left;*/
        }

        .tdisikiri {
            padding-left: 8px;
            border-top: none;
            border-right: 1px solid #203C42;
            border-left: 1px solid #203C42;
        }

        .tdisibawah {
            border-top: 1px solid #003520;
            border-bottom: 1px solid #003520;
            border-right: 1px solid #003520;
        }

        #noborder {
            border-bottom:none; border-top:none; border-right:none; border-left:none;
        }

        #noborderkiri{
            border-bottom:none; border-top:none; border-right:none;
        }

        #judul{ text-align:center; width:60%; font-size:18px; font-weight:bold;  }
    </style>

<?php 
			$id_posting = $_REQUEST['id_posting'];
			$tanggal_posting = $_REQUEST['tanggal'];
            $notrans_kw = $_REQUEST['notrans_kw'];
            $statusPosting = $_REQUEST['status_posting'];
            
            if($statusPosting == 0 && isset($statusPosting)){

                if (isset($id_posting)){
                    $sql = "SELECT j.*,s.*,pbf.PBF_NAMA  
                            FROM $dbakuntansi.jurnal_sem j
                            INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
                              LEFT JOIN $dbapotek.a_pbf pbf
                                ON j.PBF_ID = pbf.PBF_ID
                            WHERE j.FK_ID_AK_POSTING = '{$id_posting}' 
                              /*AND j.TGL_ACT = '{$tanggal_posting}'
                              AND j.POSTING = 1*/
                            ORDER BY D_K, TR_ID";
                }else{
                    $tmp_notrans_kw=explode("|",$notrans_kw);
                    $sql = "SELECT
                              j.*,
                              s.MA_ID,
                              s.MA_KODE,
                              s.MA_KODE_KP,
                              s.MA_PARENT_KODE,
                              s.MA_PARENT,
                              s.MA_NAMA,
                              bj.id,
                              bj.kode,
                              bj.parent_kode,
                              bj.nama,
                              CONCAT(s.MA_KODE_KP, ' ',IFNULL(bj.kode,''))    fullkode
                            FROM $dbakuntansi.jurnal_sem j
                              INNER JOIN $dbakuntansi.ma_sak s
                                ON s.MA_ID = j.FK_SAK
                              LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj
                                ON bj.id = j.MS_BEBAN_JENIS_ID
                            WHERE j.NO_TRANS = '{$tmp_notrans_kw[0]}'
                            AND j.NO_KW = '{$tmp_notrans_kw[1]}'
                            /*AND j.TGL = '{$tanggal_posting}' AND j.POSTING = 1*/
                            ORDER BY j.D_K ASC, s.MA_KODE ASC";
                }

               
                }else{
		
			
			if (isset($id_posting)){
				$sql = "SELECT j.*,s.*,pbf.PBF_NAMA  
						FROM $dbakuntansi.jurnal j
						INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
						  LEFT JOIN $dbapotek.a_pbf pbf
							ON j.PBF_ID = pbf.PBF_ID
						WHERE j.FK_ID_AK_POSTING = '{$id_posting}' 
						  /*AND j.TGL_ACT = '{$tanggal_posting}'
						  AND j.POSTING = 1*/
						ORDER BY D_K, TR_ID";
			}else{
				$tmp_notrans_kw=explode("|",$notrans_kw);
				$sql = "SELECT
						  j.*,
						  s.MA_ID,
						  s.MA_KODE,
						  s.MA_KODE_KP,
						  s.MA_PARENT_KODE,
						  s.MA_PARENT,
						  s.MA_NAMA,
						  bj.id,
						  bj.kode,
						  bj.parent_kode,
						  bj.nama,
						  CONCAT(s.MA_KODE_KP, ' ',IFNULL(bj.kode,''))    fullkode
						FROM $dbakuntansi.jurnal j
						  INNER JOIN $dbakuntansi.ma_sak s
							ON s.MA_ID = j.FK_SAK
						  LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj
							ON bj.id = j.MS_BEBAN_JENIS_ID
						WHERE j.NO_TRANS = '{$tmp_notrans_kw[0]}'
						AND j.NO_KW = '{$tmp_notrans_kw[1]}'
						/*AND j.TGL = '{$tanggal_posting}' AND j.POSTING = 1*/
						ORDER BY j.D_K ASC, s.MA_KODE ASC";
            }
        }
			//echo $sql.";<br>";
			$query = mysql_query($sql);
			$dataKosong = true;
			$uraian = $nokwi = "";
			if($query && mysql_num_rows($query) > 0){				
				$kredit = $debit = array();
				$pbf_nama="";
				while($data = mysql_fetch_object($query)){
					if($data->D_K == "D"){
						$debit['jurnal'][$data->MA_PARENT_KODE] += $data->DEBIT;
						$debit['bantu'][$data->MA_KODE_KP] += $data->DEBIT;
					} else {
						$kredit['jurnal'][$data->MA_PARENT_KODE] += $data->KREDIT;
						$kredit['bantu'][$data->MA_KODE_KP] += $data->KREDIT;
						$kredit['rek_nama'][$data->MA_NAMA] += $data->PBF_NAMA;
						if ($data->PBF_NAMA !="") $pbf_nama = $data->PBF_NAMA;
					}
					$uraian = $data->URAIAN;
					$nokwi = $data->NO_KW;
					$tgl_verif = tglSQL($data->TGL_ACT);
					$no_spk = $data->NO_BUKTI;
				}
				$dataKosong = false;
			}
			
		  	//=====Bilangan setelah koma=====
			$htot = array_sum($debit['jurnal']);
		  	$sakKomane=explode(".",$htot);
		  	$koma=$sakKomane[1];
		  	$koma=terbilang($koma,3);
		  	if($sakKomane[1]<>"") $koma= " Koma ".$koma; else $koma= "";
			
			//$keys = array_keys($kredit['jurnal']);
			$keys = array_keys($kredit['bantu']);
			$rek_nama = array_keys($kredit['rek_nama']);
		?>

    <!-- START TABLE SATU -->
    <table width="1038" height="258" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr style="vertical-align:top">
            <td height="40">
                <div class="box" style="border: 1px solid black; border-bottom:none; padding: 8px;">
                    <table width="1038" class="table1"
                        style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                        <tr>
                            <td colspan="3"><img src="../images/logo_br.png" width="300" height="85" align="left" />
                                <p align="right"><b>NO. ...... / JPB / I</p>
                            </td>
                        </tr>
                        <tr align="center">
                            <td colspan="2">
                                <p id="judul"><u>BUKTI JURNAL PEMBELIAN / PEMBORONGAN</u>
                                </p>
                                <p style="font-size:16px; font-weight:bold"><?php echo $title_tgl; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr style="vertical-align:top">
            <td height="40">
                <div class="box" style="border: 1px solid black; border-top:none; border-bottom:none; padding: 8px;">
                    <table class="table1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

                        <tr style="vertical-align:top">
                            <td width="25">1. </td>
                            <td width="350">Harap dibukukan Hutang sebesar</td>
                            <td>:</td>
                            <td>Rp <?php echo number_format($htot,2,",","."); ?>,-</td>
                            <td></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">2. </td>
                            <td width="350">Terbilang</td>
                            <td>:</td>
                            <td><?php echo ucwords(terbilang($htot)).$koma." Rupiah"; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">3. </td>
                            <td width="350">Nama Rekening</td>
                            <td>:</td>
                            <td><?php echo $rek_nama[0]." (".$pbf_nama.")"; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">4. </td>
                            <td width="350">Nomor Buku Hutang</td>
                            <td>:</td>
                            <td><?php echo $keys[0]; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">5. </td>
                            <td width="350">Uraian</td>
                            <td>:</td>
                            <td><?php echo $uraian; ?></td>
                        </tr>

                    </table>
                </div>
                <!-- END TABLE SATU -->


                <!-- START TABLE DUA -->
                <table width="1030" class="table3" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                        <td colspan="5" style="border-bottom:none;">Bukti Pendukung</td>
                        <td rowspan="12">
                        <?php if($dataKosong == false){ ?>
                            <table width="1030" class="table3" id="table_buktipendukung"
                                style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                                <tr>
                                    <td colspan="2">Nomor dan Nama Rekening</td>
                                </tr>
                                <tr>
                                    <td colspan="2">DEBET Buku Jurnal : </td>
                                </tr>
                                <?php
								// foreach($debit['jurnal'] as $key => $val){
								foreach($debit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='100' align='right'>Rp ".number_format($val,2,",",".")."</td>";
									echo "</tr>";
								}
                                ?>

                                <tr>
                                    <!-- <td colspan="2">DEBET Buku Bantu : </td> -->
                                </tr>
                                <?php
								// foreach($debit['bantu'] as $key => $val){
								// 	echo "<tr>";
								// 	echo "<td width='200'>- &nbsp; ".$key."</td>";
								// 	echo "<td width='100' align='right'>Rp ".number_format($val,2,",",".")."</td>";
								// 	echo "</tr>";
								// }
                                ?>

                                <tr>
                                    <td colspan="2">KREDIT Buku Hutang : </td>
                                </tr>
                                <?php
								// foreach($kredit['jurnal'] as $key => $val){
								foreach($kredit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='100' align='right'>Rp ".number_format($val,2,",",".")."</td>";
									echo "</tr>";
								}
                                ?>

                                <tr>
                                    <!-- <td colspan="2">KREDIT Buku Bantu : </td> -->
                                </tr>
                                <?php
								// foreach($kredit['jurnal'] as $key => $val){
								// foreach($kredit['bantu'] as $key => $val){
								// 	echo "<tr>";
								// 	echo "<td width='200'>- &nbsp; ".$key."</td>";
								// 	echo "<td width='100' align='right'>Rp ".number_format($val,2,",",".")."</td>";
								// 	echo "</tr>";
								// }
                                ?>
                            </table>
                            <?php } else { echo "<h4>Tidak Ada Data!</h4>"; } ?>				</td>
                        </td>
                    </tr>
                    <tr>
                        <td id="noborderkiri">&nbsp;</td>
                        <td colspan="2" id="noborder">Nomor</td>
                        <td colspan="2" id="noborder">Tanggal</td>
                    </tr>

                    <tr>
                        <td id="noborderkiri">Faktur / Kwitansi : </td>
                        <td colspan="2" width="50" id="noborder"><?php echo $nokwi; ?></td>
                        <td colspan="2" id="noborder">............................</td>
                    </tr>

                    <tr>
                        <td id="noborderkiri">SP / SK : </td>
                        <td colspan="2" id="noborder"><?php echo $no_spk; ?></td>
                        <td colspan="2" id="noborder">............................</td>
                    </tr>

                    <tr>
                        <td id="noborderkiri">Kontrak : </td>
                        <td colspan="2" id="noborder">............................</td>
                        <td colspan="2" id="noborder">............................</td>
                    </tr>

                    <tr>
                        <td id="noborderkiri">Bukti Lain-lain : </td>
                        <td colspan="2" id="noborder">............................</td>
                        <td colspan="2" id="noborder">............................</td>
                    </tr>

                    <tr>
                        <td style="border-bottom:none;">Telah Dibukukan</td>
                        <td colspan="2" align="center">Buku Jurnal</td>
                        <td colspan="2" align="center">Buku Bantu</td>
                    </tr>

                    <tr>
                        <td style="border-bottom:none; border-top:none;">Tanggal</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border-bottom:none; border-top:none;">Paraf P</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="5" align="center">BUKTI PROSES KEUANGAN</td>
                    </tr>

                    <tr>
                        <td>Tahapan</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>Pembuat</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>D I</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td rowspan="4" align="center"><br>Belawan, .... .............. <?= date(Y);?><br>
                            PT. PRIMA HUSADA CIPTA MEDAN<br>
                            GENERAL MANAGER KEUANGAN DAN UMUM<br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b>NADLIN, S.E</b></td>
                    </tr>

                    <tr>
                        <td>D II</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>Verifikasi</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>


                    <tr>
                        <td colspan="5" align="center">&nbsp;</td>
                    </tr>

                </table>
                <!-- END TABLE DUA -->

            </td>
            <td>

            </td>
        </tr>
    </table>

    <p id="p_print" align="center"><button type="button"
            onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img
                src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp;
            Cetak</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="window.close();"><img
                src="../icon/back.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Tutup</button></p>
</body>

</html>