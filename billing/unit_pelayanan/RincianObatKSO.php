<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include ("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$tipe=$_REQUEST['tipe'];
$for=$_REQUEST['for'];
$all = $_REQUEST['all'];
$idUser=$_REQUEST['idUser'];
//----------------------------------
if ($inap=="1" || $all == 'true'){
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(k.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(k.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP,k.tgl as tglKunj,mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id=$idKunj AND p.id=$idPel";
}else{
	$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas, 
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP,k.tgl as tglKunj, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id 
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
WHERE k.id='$idKunj' AND p.id='$idPel'";
}
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$ksoid=$rw['kso_id'];
$tglKunj=$rw['tglKunj'];
if ($inap=="1"){
	$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl),'%d-%m-%Y %H:%i') tgljam FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY p.id LIMIT 1";
	//echo $sql."<br>";
	$rsInap=mysql_query($sql);
	if (mysql_num_rows($rsInap)>0){
		$rwInap=mysql_fetch_array($rsInap);
		$tglIn=$rwInap['tgljam'];
		$sql="SELECT DATE_FORMAT(IFNULL(tk.tgl_out,NOW()),'%d-%m-%Y %H:%i') tglP FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND mu.inap=1 ORDER BY tk.id DESC LIMIT 1";
		//echo $sql."<br>";
		$rsInap=mysql_query($sql);
		$rwInap=mysql_fetch_array($rsInap);
		$tglOut=$rwInap['tglP'];
	}else{
		$tglIn=$rw['tgljam'];
		$sql="SELECT DATE_FORMAT(IFNULL(tgl_krs,tgl),'%d-%m-%Y %H:%i') tglP FROM b_pelayanan WHERE kunjungan_id='$idKunj' ORDER BY id DESC LIMIT 1";
		$rsInap=mysql_query($sql);
		$rwInap=mysql_fetch_array($rsInap);
		$tglOut=$rwInap['tglP'];
	}
}else{
	$tglIn=$rw['tgljam'];
	$tglOut=$rw['tglP'];
}

$sql="SELECT * FROM b_ms_kelas WHERE id=(SELECT kelas_id FROM b_pelayanan WHERE id='$idPel')";
//echo $sql."<br>";
$rs=mysql_query($sql);
$rw1=mysql_fetch_array($rs);

$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);
$kls=$rw1['nama'];
//echo $kls."<br>";

if ($kls=="" || $kls==" "){
	$kls="Non Kelas";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Tagihan Pasien :.</title>
    </head>

    <body style="margin-top:0px">
        <table width="1225" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:14px">
                    <b><?=$pemkabRS?><br />
		<?=$namaRS?><br />
		<?=$alamatRS?><br />
		Telepon <?=$tlpRS?><br/></b>&nbsp;
                </td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px">
                    <u>&nbsp;Laporan Rincian Pemakaian Obat&nbsp;</u>
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="11%" style="font-size:12px">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="10%" style="font-size:12px">Tgl Mulai</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $tglIn;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="10%" style="font-size:12px">Tgl Selesai </td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $tglOut;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="10%" style="font-size:12px">Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo strtolower($kls);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Kel. / Desa</td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td width="10%" style="font-size:12px">&nbsp;</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="30%"></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:12px">RT / RW</span></td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td width="10%" style="font-size:12px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Jenis Kelamin </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td width="10%" style="font-size:12px">Hak Kelas</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['kelas'];?></td>
                        </tr>
              </table>	</td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">Nama Obat</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Cara Bayar</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Jumlah</td>
                            <td align="center" width="110" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Biaya</td>
                        </tr>
                        <?php
                        //=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
						if ($tipe=="2") {
                        	$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj') AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.TGL>='$tglKunj'";
                        }elseif ($tipe=="1") {
                        	$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan=3) AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.TGL>='$tglKunj'";
                        }elseif ($tipe=="0") {
                        		$sUnit="SELECT DISTINCT t2.* FROM (SELECT DISTINCT p.id,mu.nama nmUnit,mu.id idUnit,mu.parent_id 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan<>3) AS t2 INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.TGL>='$tglKunj'";
							//}
                        }
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
                        while($rwUnit=mysql_fetch_array($qUnit)) {?>
                        <tr>
                            <td align="left" style="padding-left:25px;font-size:12px"><?php echo $rwUnit['nmUnit']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <?php
							$sKonsul="SELECT DISTINCT ap.NO_PENJUALAN,ap.DOKTER,ac.nama FROM $dbapotek.a_penjualan ap inner join $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.NO_KUNJUNGAN='".$rwUnit['id']."'";
                            //echo $sKonsul."<br>";
                            $qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {
                            	$sTot=0;
								$caraBayar=$rwKonsul["nama"];
							?>
                        <tr>
                            <td align="left" style="padding-left:50px;font-size:12px"><?php echo $rwKonsul['DOKTER']." - ".$rwKonsul['NO_PENJUALAN'];?></td>
                            <td align="center"><?php echo $caraBayar; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                                <?php
									$sObat="SELECT SUM(t2.QTY_JUAL) QTY_JUAL,SUM(t2.QTY_RETUR) QTY_RETUR,ao.OBAT_ID,ao.OBAT_NAMA,DATE_FORMAT(t2.TGL,'%d-%m-%Y') AS TGL,t2.HARGA_SATUAN,
SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN) AS SUBTOTAL 
FROM (SELECT * FROM $dbapotek.a_penjualan WHERE NO_KUNJUNGAN='".$rwUnit['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."') AS t2 
INNER JOIN $dbapotek.a_penerimaan ap ON t2.PENERIMAAN_ID=ap.ID INNER JOIN $dbapotek.a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
GROUP BY ao.OBAT_ID";
                                //echo $sObat."<br>";
                                $qObat=mysql_query($sObat);
                                while($rwObat=mysql_fetch_array($qObat)) {?>
                        <tr>
                            <td align="left" style="padding-left:85px"><?php echo strtolower($rwObat['OBAT_NAMA']);?></td>
                            <td align="center" style="font-size:12px">&nbsp;</td>
                            <td align="center" style="font-size:12px">&nbsp;<?php echo $rwObat['TGL'];?></td>
                            <td align="center" style="font-size:12px">&nbsp;<?php if ($rwObat['QTY_RETUR']>0) echo $rwObat['QTY_JUAL']." - ".$rwObat['QTY_RETUR']; else echo $rwObat['QTY_JUAL'];?></td>
                            <td align="right" style="font-size:12px"><?php if ($for<>"1") echo number_format($rwObat['SUBTOTAL'],0,",",".");?>&nbsp;</td>
                        </tr>
                                    <?php
                                    $sTot+=$rwObat['SUBTOTAL'];
                                }
							?>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px">Sub Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"><?php echo number_format($sTot,0,",",".");?>&nbsp;</td>
                        </tr>
							<?php
								$bTot+=$sTot;
                            }
                        }
						?>
                        <tr>
                            <td align="left" style="padding-left:60px; border-top:#000000 solid 1px; font-size:12px">&nbsp;</td>
                            <td align="center" style="border-top:solid #000000 1px; font-size:12px;">&nbsp;</td>
                            <td align="center" style="border-top:solid #000000 1px; font-size:12px;">&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:12px">Total Biaya&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px; font-size:12px"><?php echo number_format($bTot,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding-left:60px;font-size:12px;" height="2"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"></td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px"></td>
                        </tr>
                    </table>
              </td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi" style="display:none">
                <td width="607">&nbsp;</td>
                <td width="293" style="font-weight:bold;font-size:12px"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
                    Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )</td>
            </tr>
            <tr>
            	<td colspan="2">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-weight:bold;font-size:12px">
                	<tr>
                    	<td width="25%" align="center">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="30%" align="center">&nbsp;</td>
                        <td width="10%">&nbsp;</td>
                        <td width="25%" align="center"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
                    </tr>
                    <tr>
                    	<td align="center">Pasien</td>
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center">Dokter Penanggung Jawab</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="center">(&nbsp;<?php echo strtolower($rw['nmPas']);?>&nbsp;)</td>
                        <?php
                        if ($tipe=="2") {
							$sDok="SELECT 
								  IFNULL(
									(SELECT 
									  pg.nama 
									FROM
									  b_pelayanan p 
									  INNER JOIN b_ms_pegawai pg 
										ON pg.id = p.dokter_id 
									WHERE p.kunjungan_id = '".$idKunj."' 
									  AND p.jenis_kunjungan = 3 
									ORDER BY p.id ASC 
									LIMIT 1), 
									(SELECT 
									  pg.nama 
									FROM
									  b_pelayanan p 
									  INNER JOIN b_tindakan t 
										ON t.pelayanan_id = p.id
									  INNER JOIN b_ms_pegawai pg 
										ON pg.id = t.user_id  
									WHERE p.kunjungan_id = '".$idKunj."' 
									ORDER BY p.id ASC 
									LIMIT 1)
								  ) AS nama";
						}elseif ($tipe=="1") {
							$sDok="SELECT pg.nama FROM b_pelayanan p INNER JOIN b_ms_pegawai pg ON pg.id=p.dokter_id 
							WHERE p.kunjungan_id='".$idKunj."' AND p.jenis_kunjungan=3 ORDER BY p.id ASC LIMIT 1";
						}elseif ($tipe=="0") {
							$sDok="SELECT pg.nama FROM b_pelayanan p 
							INNER JOIN b_tindakan t ON t.pelayanan_id=p.id
							INNER JOIN b_ms_pegawai pg ON pg.id=t.user_id 
							WHERE p.kunjungan_id='".$idKunj."' ORDER BY p.id ASC LIMIT 1";
						}
						$qDok=mysql_query($sDok);
						$rwDok=mysql_fetch_array($qDok);
						?>
                        <td>&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center">(&nbsp;<?php echo $rwDok['nama']?>&nbsp;)</td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <!--input id="btnExpExcl" type="button" value="Export -> Excell" onClick="window.open('RincianTindakanKSOExcell.php?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&idUser=<?php echo $idUser; ?>&inap=<?php echo $inap; ?>&tipe=<?php echo $tipe; ?>&for=<?php echo $for; ?>');"/-->
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
        <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician Pemakaian Obat ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>
    </body>
</html>
<?php 
mysql_close($konek);
?>