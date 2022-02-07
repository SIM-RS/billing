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
    <title>Bukti Penerimaan Kas Bank</title>
</head>

<body>
    <style>
         

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
        
    </style>

<?php
			$id_posting = $_REQUEST['id_posting'];
            $tanggal_posting = $_REQUEST['tanggal'];
            $statusPosting = $_REQUEST['status_posting'];
			$notrans_kw = $_REQUEST['notrans_kw'];
			//echo "tgl_post=".$tanggal_posting."<br>";
            
            if($statusPosting == 0 && isset($statusPosting)){

                if (isset($id_posting)){
                    $sql = "SELECT j.*, s.MA_ID, s.MA_KODE, s.MA_KODE_KP, s.MA_PARENT_KODE, s.MA_PARENT, 
                            s.MA_NAMA, bj.id, bj.kode, bj.parent_kode, bj.nama,
                                CONCAT(s.MA_KODE_KP, ' ',IFNULL(bj.kode,'')) fullkode
                            FROM $dbakuntansi.jurnal_sem j
                            INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
                            LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj ON bj.id = j.MS_BEBAN_JENIS_ID
                            WHERE j.FK_ID_POSTING = '{$id_posting}' AND j.flag='$flag'
                              /*AND j.TGL_ACT = '{$tanggal_posting}'*/
                              AND j.POSTING = 1
                            ORDER BY j.D_K ASC, s.MA_KODE ASC";
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
                            AND j.NO_KW = '{$tmp_notrans_kw[1]}' AND j.flag='$flag'
                            /*AND j.TGL = '{$tanggal_posting}' AND j.POSTING = 1*/
                            ORDER BY j.D_K ASC, s.MA_KODE ASC";
                }

            }else{
			if (isset($id_posting)){
				$sql = "SELECT j.*, s.MA_ID, s.MA_KODE, s.MA_KODE_KP, s.MA_PARENT_KODE, s.MA_PARENT, 
						s.MA_NAMA, bj.id, bj.kode, bj.parent_kode, bj.nama,
							CONCAT(s.MA_KODE_KP, ' ',IFNULL(bj.kode,'')) fullkode
						FROM $dbakuntansi.jurnal j
						INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
						LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj ON bj.id = j.MS_BEBAN_JENIS_ID
						WHERE j.FK_ID_POSTING = '{$id_posting}' AND j.flag='$flag'
						  /*AND j.TGL_ACT = '{$tanggal_posting}'*/
						  AND j.POSTING = 1
						ORDER BY j.D_K ASC, s.MA_KODE ASC";
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
						AND j.NO_KW = '{$tmp_notrans_kw[1]}' AND j.flag='$flag'
						/*AND j.TGL = '{$tanggal_posting}' AND j.POSTING = 1*/
						ORDER BY j.D_K ASC, s.MA_KODE ASC";
            }
        }
			//echo $sql.";<br>";//decyber
			$query = mysql_query($sql);
			$dataKosong = true;
			$alamat = "Medan";
			//$kepada = "Dr. YUSMARDIANNIE, M. Kes";
			$kepada = "NADLIN, S.E";
			$uraian = $nobukti = "";
			$total = array();
			$arrData = array();
			if($query && mysql_num_rows($query) > 0){
				while($data = mysql_fetch_object($query)){
					$arrData[$data->D_K][$data->fullkode] += ($data->D_K == 'D' ? $data->DEBIT : $data->KREDIT);
					
					if($data->D_K == 'D'){
						$total['debit'] += $data->DEBIT;
					} else {
						$total['kredit'] += $data->KREDIT;
					}
					
					$uraian = $data->URAIAN;
					$nobukti = $data->NO_BUKTI;
					//$tgl_Post = tglSQL($data->TGL_ACT);
					$tgl_Post = tglSQL($data->TGL);
				}
				$dataKosong = false;
			}
		?>

    <!-- START TABLE SATU -->
    <table width="1038" height="258" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3"><img src="../images/logo_br.png" width="300" height="55" align="left" />
                <p align="right"  <?php if(empty($nobukti)){ echo 'style="margin-right:150px"'; }else{ echo '';} ?>><b>NO. BUKTI : </b> <?php echo $nobukti; ?></p>
            </td>
        </tr>
        <tr align="center">
            <td colspan="2">
                <p style="font-size:20px;"><u>BUKTI PENERIMAAN KAS - BANK</u></p>
                <p style="font-size:16px; font-weight:bold"><?php echo $title_tgl; ?>
            </td>
        </tr>

        <tr>
            <td width="515" align="right">CURRENCY : IDR &nbsp;</td>
        </tr>
        <tr style="vertical-align:top">
            <td height="40">
                <div class="box" style="border: 1px solid black; padding: 8px;">
                    <table class="table1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

                        <tr style="vertical-align:top">
                            <td width="25">1. </td>
                            <td width="350">Pemegang Kas Harap Menerima Uang Sebesar </td>
                            <td>:</td>
                            <td>Rp <?php echo number_format($total['debit'],0,",","."); ?>,-</td>
                            <td></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">2. </td>
                            <td width="350">Terbilang</td>
                            <td>:</td>
                            <td><?php echo ucwords(terbilang($total['debit'])); ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">3. </td>
                            <td width="350">Dari</td>
                            <td>:</td>
                            <td><?php echo $namaRS; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">4. </td>
                            <td width="350">Alamat</td>
                            <td>:</td>
                            <td><?php echo $alamatRS; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">5. </td>
                            <td width="350">Uraian</td>
                            <td>:</td>
                            <td><?php echo $uraian; ?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td width="25">6. </td>
                            <td width="350">Bukti Pendukung</td>
                            <td>:</td>
                            <td>Terlampir</td>
                        </tr>

                    </table>
                </div>
                <!-- END TABLE SATU -->

                <!-- START TABLE DUA -->
                <p style="font-size:16px; font-weight:bold" align="center">KODE DAN NAMA REKENING</p>

                <table class="table2" width="1030" border="0" cellpadding="0" cellspacing="0"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; ">
                    <tr align="center" style="background:#ECECEC;">
                        <td width="25" class="tblheaderkiri">No.</td>
                        <td width="500" class="tblheader">KODE REKENING</td>
                        <td class="tblheader">DEBET BUKU JURNAL</td>
                        <td class="tblheaderkanan">KREDIT BUKU JURNAL</td>
                    </tr>
                    <!-- tbody -->
                    <?php
                        if($dataKosong == false){
                            $no = 1;
                            // while($data = mysql_fetch_object($query)){
                            foreach($arrData as $DK => $val){
                                foreach($val as $key => $data){
                                    $debit = ($DK == 'D' ? number_format($data,0,",",".") : '-');
                                    $kredit = ($DK == 'K' ? number_format($data,0,",",".") : '-');
                                    
                                    echo "<tr>";
                                    echo "<td class='tdisikiri'>".$no++.".</td>";
                                    echo "<td class='tdisi'>".$key."</td>"; //."."." ".$data->nama
                                    echo "<td class='tdisi'>Rp ".$debit."</td>";
                                    echo "<td class='tdisi'>Rp ".$kredit."</td>";
                                    echo "</tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='6' class='nodata' align='center'></td></tr>";
                        }
                    ?>
                    <tr>
                        <td class="tdisikiri"></td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp</td>
                        <td class="tdisi">Rp</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri"></td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp</td>
                        <td class="tdisi">Rp</td>
                    </tr>
                    <tr>
                        <td class="tdisikiri"></td>
                        <td class="tdisi"></td>
                        <td class="tdisi">Rp</td>
                        <td class="tdisi">Rp</td>
                    </tr>

                    <!-- #tbody -->
                    <!-- tfoot -->
                    <tr>
                        <td class="tblfooterkiri" colspan="2" align="right">Jumlah</td>
                        <td class="tblfooter">Rp <?php echo number_format($total['debit'],0,",","."); ?></td>
                        <td class="tblfooter">Rp <?php echo number_format($total['kredit'],0,",","."); ?></td>
                    </tr>
                    <!-- #tfoot -->
                </table>
                <!-- END TABLE DUA -->

                <!-- START TABLE TIGA -->
                <table width="1030" class="table3"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:15px;">
                    <tr align="center">
                        <td rowspan="3">Tahapan</td>
                        <td colspan="4">PROSES</td>
                        <!-- ttd -->
                        <td rowspan="6"><br>Belawan, .... .......................... <?= date(Y);?><br>
                            RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN<br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b>NADLIN, SE</b></td>
                    </tr>
                    <tr>
                        <td width="50px">Tgl</td>
                        <td width="50px">Prf</td>
                        <td width="50px">Tgl</td>
                        <td width="50px">Prf</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Pembuat</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Verifikasi</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center">PEMBUKUAN</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="4" align="center">
                            <b>UANG TELAH DITERIMA OLEH : </b><br><br><br><br>
                            (........................................................................)</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>   
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center"><b>K E T E R A N G A N</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-right:none;">a. Status Posting</td>
                        <td style="border-left:none; border-right:none;" >:</td>
                        <td style="border-left:none;">-</td>
                        <td rowspan="2" align="center">
                            <b> c. Paraf Petugas Posting </b><br><br><br><br>
                            (........................................................................)</td>
                    </tr>
                    <tr>
                    <td colspan="3" style="border-right:none;">b. Tanggal Posting</td>
                        <td style="border-left:none; border-right:none;">:</td>
                        <td style="border-left:none;">-</td>
                    </tr>
                </table>
                <!-- END TABLE TIGA -->



            <a>Jurnal JKM</a>
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