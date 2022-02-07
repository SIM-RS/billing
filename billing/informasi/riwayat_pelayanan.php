<?php
	session_start();
	include("../koneksi/konek.php");
	include("../sesi.php");
    $KunjunganId = $_REQUEST['idKunj'];
    $PasienId = $_REQUEST['idPas'];
?>
<title>.: Riwayat Pelayanan Pasien :.</title>
<table width="950" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
  	<td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
  </tr>
  <tr>
    <td style="text-align:center; text-transform:uppercase; font-size:14px; font-weight:bold;" height="50">riwayat Tindakan pasien</td>
  </tr>
  <tr>
    <td>
        <table border="0" cellpadding="4" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;" width="90%" align="center">
            <?php
                $sqlPas = "SELECT b_ms_pasien.no_rm, b_ms_pasien.nama, DATE_FORMAT(b_ms_pasien.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
                            b_kunjungan.umur_thn, b_kunjungan.umur_bln, b_ms_pasien.sex, b_ms_pasien.alamat, b_ms_pasien.rw, b_ms_pasien.rt,
                            (SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.desa_id) AS desa,
                            (SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.kec_id) AS kec,
                            (SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.kab_id) AS kab
                            FROM b_ms_pasien
                            INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id
                            WHERE b_ms_pasien.id='".$PasienId."' AND b_kunjungan.id='".$KunjunganId."'";
                $rsPas = mysql_query($sqlPas);
                $rwPas = mysql_fetch_array($rsPas);
            ?>
            <tr>
                <td width="12%">No RM</td>
                <td width="20%">:&nbsp;<?php echo $rwPas['no_rm'];?></td>
                <td width="10%">Nama</td>
                <td width="33%">:&nbsp;<?php echo $rwPas['nama']?></td>
                <td width="5%">L/P</td>
                <td width="20%">:&nbsp;<?php echo $rwPas['sex']?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:&nbsp;<?php echo $rwPas['tgl_lahir'];?></td>
                <td rowspan="2" valign="top">Alamat</td>
                <td colspan="3">:&nbsp;<?php echo $rwPas['alamat'].", Rt/Rw: ".$rwPas['rw']."/".$rwPas['rt']?></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:&nbsp;<?php echo $rwPas['umur_thn']."thn ".$rwPas['umur_bln']."bln"?></td>
                <td colspan="3">&nbsp;<?php echo "Desa: ".$rwPas['desa']." Kec: ".$rwPas['kec']." Kab: ".$rwPas['kab'];?></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
        <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;" align="center">
            <tr>
                <td width="30%" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:center;">TINDAKAN</td>
                <td style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:center;">PELAKSANA</td>
                <td width="80" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:center;">TANGGAL</td>
                <td width="15%" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:center;">KSO</td>
                <td width="70" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:right; padding-right:10px;">TARIF<br />PERDA</td>
                <td width="70" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:right; padding-right:10px;">BIAYA<br>KSO</td>
                <td width="70" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:right; padding-right:10px;">BIAYA<BR />PASIEN</td>
                <!--td width="10%" style="border-top:1px solid #999999; border-bottom:1px solid #999999; font-weight:bold; text-align:right; padding-right:10px;">BAYAR<BR />PASIEN</td-->
            </tr>
                <?php
					$sqlStatus = "SELECT DISTINCT kso.id,kso.nama,t.tipe_pendapatan FROM b_tindakan_ak t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_kso kso ON t.kso_id=kso.id
WHERE p.kunjungan_id='".$KunjunganId."' ORDER BY t.id,kso.id,t.tipe_pendapatan";
					//echo $sqlStatus."<br>";
                    $rsStatus = mysql_query($sqlStatus);
					while ($rwStatus=mysql_fetch_array($rsStatus)){
				?>
                <tr>
                  <td colspan="7" style="padding-left: 20px; font-weight: bold;text-transform:uppercase" height="28" valign="bottom"><?php echo $rwStatus['nama']." - ".(($rwStatus['tipe_pendapatan']==0)?"Pendapatan":"Pengurang Pendapatan");?></td>
                </tr>
				<?php
						$sqlUn = "SELECT DISTINCT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_pelayanan.id AS pelayanan_id FROM b_ms_unit
	INNER JOIN b_pelayanan ON b_pelayanan.unit_id=b_ms_unit.id INNER JOIN b_tindakan_ak t ON b_pelayanan.id=t.pelayanan_id
	WHERE b_pelayanan.kunjungan_id='".$KunjunganId."' AND t.kso_id='".$rwStatus['id']."' AND t.tipe_pendapatan='".$rwStatus['tipe_pendapatan']."'";
						$rsUn = mysql_query($sqlUn);
						$TtotTindPerda = 0;
						$TtotTindKso = 0;
						$TtotTindPasien = 0;
						while($rwUn = mysql_fetch_array($rsUn)){
                ?>
            <tr>
                <td colspan="7" style="padding-left: 35px; font-weight: bold;" height="28" valign="bottom"><?php echo $rwUn['nama'];?></td>
            </tr>
			<?php
					
						$totTindPerda = 0;
						$totTindKso = 0;
						$totTindPasien = 0;
					
					if($rwUn['inap']=='1'){
						$sqlKmr = "SELECT DATE_FORMAT(b_tindakan_kamar_ak.tgl_in,'%d-%m-%Y') AS tgl_in, b_ms_kso.nama, 
                                    IF(b_tindakan_kamar_ak.status_out=0,IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,1,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*(b_tindakan_kamar_ak.tarip), 
                                    IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,0,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*(b_tindakan_kamar_ak.tarip)) AS perda, 
                                    IF(b_tindakan_kamar_ak.status_out=0,IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,1,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*b_tindakan_kamar_ak.beban_kso, 
                                    IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,0,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*b_tindakan_kamar_ak.beban_kso) AS kso,
                                    IF(b_tindakan_kamar_ak.status_out=0,IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,1,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*b_tindakan_kamar_ak.beban_pasien, 
                                    IF(DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in)=0,0,
                                    DATEDIFF(IFNULL(b_tindakan_kamar_ak.tgl_out,NOW()),b_tindakan_kamar_ak.tgl_in))*b_tindakan_kamar_ak.beban_pasien) AS pasien,
                                    b_tindakan_kamar_ak.bayar_pasien,IF(b_tindakan_kamar_ak.tipe_pendapatan=1,'Pengurang','Pendapatan') AS tipe FROM b_tindakan_kamar_ak 
                                    INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan_kamar_ak.kso_id 
                                    WHERE b_tindakan_kamar_ak.pelayanan_id='".$rwUn['pelayanan_id']."' AND b_tindakan_kamar_ak.kso_id='".$rwStatus['id']."' AND b_tindakan_kamar_ak.tipe_pendapatan='".$rwStatus['tipe_pendapatan']."'";
						$rsKmr = mysql_query($sqlKmr);
						while($rwKmr = mysql_fetch_array($rsKmr)){
			?>
			<tr>
				<td style="padding-left:50px; font-weight:bold;">Kamar</td>
				<td align="center">&nbsp;</td>
				<td align="center"><?php echo $rwKmr['tgl_in'];?></td>
				<td align="center"><?php echo $rwKmr['nama'];?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwKmr['perda'],0,",",".");?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwKmr['kso'],0,",",".");?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwKmr['pasien'],0,",",".");?></td>
				<!--td style="text-align:right; padding-right:5px;visibility:collapse"><?php echo number_format($rwKmr['bayar_pasien'],0,",",".");?></td-->
			</tr>
                    <?php
							$totTindPerda = $totTindPerda + $rwKmr['perda'];
							$totTindKso = $totTindKso + $rwKmr['kso'];
							$totTindPasien = $totTindPasien + $rwKmr['pasien'];
						}
					}
                    $sqlTind = "SELECT b_tindakan_ak.b_tindakan_id,b_tindakan_ak.kso_id,b_ms_tindakan.id, b_ms_tindakan.nama, b_ms_pegawai.nama AS pelaksana, b_ms_kso.nama AS namakso, (b_tindakan_ak.biaya*b_tindakan_ak.qty) AS perda, 
                                    (b_tindakan_ak.biaya_kso*b_tindakan_ak.qty) AS kso, (b_tindakan_ak.biaya_pasien*b_tindakan_ak.qty) AS pasien,
                                    b_tindakan_ak.bayar_pasien,b_tindakan_ak.tipe_pendapatan,DATE_FORMAT(b_tindakan_ak.tgl,'%d-%m-%Y') AS tgl, b_tindakan_ak.tgl_act,IF(b_tindakan_ak.tipe_pendapatan=1,'Pengurang','Pendapatan') AS tipe 
                                    FROM b_pelayanan INNER JOIN b_tindakan_ak ON b_tindakan_ak.pelayanan_id=b_pelayanan.id 
                                    INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan_ak.ms_tindakan_kelas_id 
                                    INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id 
                                    LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id=b_tindakan_ak.user_id 
                                    LEFT JOIN b_ms_kso ON b_ms_kso.id=b_tindakan_ak.kso_id WHERE b_pelayanan.id='".$rwUn['pelayanan_id']."' AND b_tindakan_ak.kso_id='".$rwStatus['id']."' AND b_tindakan_ak.tipe_pendapatan='".$rwStatus['tipe_pendapatan']."'";						
                        $rsTind = mysql_query($sqlTind);
                        while($rwTind = mysql_fetch_array($rsTind)){
							$bayar=$rwTind['bayar_pasien'];
							/*if ($rwTind['tipe_pendapatan']==0 && $rwTind['pasien']>0){
								//$bayar=0;
								//$sql="SELECT bt.* FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id WHERE bt.tindakan_id=".$rwTind['b_tindakan_id']." AND bt.tipe=0 AND b.tgl_act>='".$rwTind['tgl_act']."'";
								$sql="SELECT * FROM b_tindakan_ak WHERE b_tindakan_id=".$rwTind['b_tindakan_id']." AND tipe_pendapatan=1 AND kso_id=".$rwTind['kso_id']." AND bayar_pasien>0";
								$rsBayar=mysql_query($sql);
								if ($rwBayar=mysql_fetch_array($rsBayar)) $bayar=$rwBayar["bayar_pasien"];
							}*/
                    ?>
            <tr>
                <td style="padding-left: 50px;"><?php echo $rwTind['nama'];?></td>
				<td align="center"><?php echo $rwTind['pelaksana']?></td>
				<td align="center"><?php echo $rwTind['tgl']?></td>
				<td align="center"><?php echo $rwTind['namakso'];?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwTind['perda'],0,",",".");?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwTind['kso'],0,",",".");?></td>
				<td style="text-align:right; padding-right:5px;"><?php echo number_format($rwTind['pasien'],0,",",".");?></td>
				<!--td style="text-align:right; padding-right:5px;visibility:collapse"><?php echo number_format($bayar,0,",",".");?></td-->
			</tr>
            <!--tr>
                <td colspan="7" style="padding-left: 100px;"><?php echo $rwTind['pelaksana']?></td>
            </tr-->
            <?php
                       
 						$totTindPerda = $totTindPerda + $rwTind['perda'];
						$totTindKso = $totTindKso + $rwTind['kso'];
						$totTindPasien = $totTindPasien + $rwTind['pasien'];
				}
			?>
            <tr height="28" valign="top">
                <td colspan="4" align="center" style="border-top:1px solid #999999;"><b>SUB TOTAL</b></td>
				<td style="border-top:1px solid #999999; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($totTindPerda,0,",",".")?></td>
				<td style="border-top:1px solid #999999; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($totTindKso,0,",",".")?></td>
				<td style="border-top:1px solid #999999; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($totTindPasien,0,",",".")?></td>
				<!--td style="border-top:1px solid #999999; font-weight:bold; text-align:right; padding-right:5px;">&nbsp;</td-->
			</tr>
			<?php
					$TtotTindPerda += $totTindPerda;
                    $TtotTindKso += $totTindKso;
                    $TtotTindPasien += $totTindPasien;
					}
						
                //}
            ?>
            <tr height="28" valign="middle">
                <td colspan="4" align="center" style="border-top:1px solid #0000FF;text-transform:uppercase"><b>TOTAL <?php echo $rwStatus['nama']." - ".(($rwStatus['tipe_pendapatan']==0)?"Pendapatan":"Pengurang Pendapatan"); ?></b></td>
				<td style="border-top:1px solid #0000FF; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($TtotTindPerda,0,",",".")?></td>
				<td style="border-top:1px solid #0000FF; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($TtotTindKso,0,",",".")?></td>
				<td style="border-top:1px solid #0000FF; font-weight:bold; text-align:right; padding-right:5px;"><?php echo number_format($TtotTindPasien,0,",",".")?></td>
				<!--td style="border-top:1px solid #0000FF; font-weight:bold; text-align:right; padding-right:5px;">&nbsp;</td-->
			</tr>
            <?php 
			}
			?>
        </table>
    </td>
  </tr>
</table>
