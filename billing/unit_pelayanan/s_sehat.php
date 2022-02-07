<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$jml=$_REQUEST['jml'];
$jns1=$_REQUEST['jns1'];
if($jns1=="Istirahat")
{
	$jns1="Istirahat";
}else{
	$jns1="Kerja RIngan";
}
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}
$idUser=$_REQUEST['idUser'];
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
/*$sqlPas="SELECT DISTINCT
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE mp.sex WHEN 'P' THEN 'Perempuan' ELSE 'Laki - Laki' END AS sex,
  mk.nama kelas,
  md.nama AS diag,
  peg.nama AS dokter,
  kso.nama nmKso,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn, k.id, p.id, mp.nama_satuan, bmp.nama as nm_pangkat, DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1, DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL $jml DAY),'%d %M %Y') AS tgl2, mp.nip
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_ms_pangkat bmp
    ON mp.pangkat_id = bmp.id
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_tindakan bmt
    ON k.id = bmt.kunjungan_id AND p.id = bmt.pelayanan_id
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  INNER JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
  LEFT JOIN b_ms_unit un 
    ON un.id = p.unit_id
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id  
WHERE k.id='$idKunj' AND p.id='$idPel'";*/
$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan/F' 
    ELSE 'Laki - Laki/M' 
  END AS sex,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  p.no_lab,
  DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  DATE_FORMAT(
    DATE_ADD(CURDATE(), INTERVAL 2 DAY),
    '%d %M %Y'
  ) AS tgl2,
  bpek.nama AS kerjaan,
  a.tb tb,
  a.bb bb,
  a.nadi nadi,
  a.rr pernapasan,
  a.TENSI,
  a.TENSI_DIASTOLIK,
  dok.nama nama_dokter
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id
  LEFT JOIN anamnese a
    ON a.PEL_ID=p.id
 LEFT JOIN b_ms_pegawai  dok on p.dokter_tujuan_id=dok.id
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Surat Keterangan Sehat :.</title>
    </head>
    <body style="margin-top:0px">
        <table width="600" border="1" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse">
		<tr>
		<td>
        <table width="600" border="0" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse">
            <tr>
                <td colspan="2" style="font-size:12px; border:1px solid #000;" align="center"><table border="0">
                  <tr>
                    <td style="font:26px bold tahoma" height="100" width="350"><?=$_SESSION['namaP']?></td>
                    <td><table border="0">
  <tr>
    <td style="border:1px solid #000;font:17px bold tahoma;" height="50" width="250">SURAT KETERANGAN SEHAT</td>
  </tr>
</table>
</td>
  </tr>
                </table>
				</td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr>
                <td height="40" colspan="2" align="left" style="font-size:13px">
                Saya, dokter  <strong><?=$_SESSION['namaP']?></strong>, menyatakan bahwa :</br>
                <i>I, doctor of <strong><?=$_SESSION['namaP']?></strong>, hereby certify that </i>:&nbsp;
				</td>
            </tr>
            <tr>
                <td height="10" colspan="2" align="left" style="font-size:13px">&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                            <td width="11%" style="font-size:12px">Nama </br> <i>Name</i></td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo $rw['nmPas'];?></td>
                            <td width="10%" style="font-size:12px">&nbsp;</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="30%" style="font-size:12px">&nbsp;</td>
                    </tr>
					<tr><td>&nbsp;</td></tr>
                    <tr>
                            <td width="11%" style="font-size:12px">Alamat </br> <i> Address</i></td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px" colspan="4">&nbsp;<?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?>, Desa <?php echo $rw['nmDesa'];?>, Kecamatan <?php echo $rw['nmKec'];?></td>
                            <!--<td width="10%" style="font-size:12px">Unit</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['nmUnit'];?></td>-->
                    </tr>                   
					<tr><td>&nbsp;</td></tr>
                    <tr>
                            <td width="11%" style="font-size:12px">Pekerjaan </br> <i>Occupation</i></td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px" colspan="4">&nbsp;<?php echo $rw['kerjaan'];?></td>
                            <!--<td width="10%" style="font-size:12px">No. RM</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>-->
                    </tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
					<td colspan="6">
<table width="99%" border="" style="border:1px solid #000000; border-collapse:collapse">
<tr>
    <td style="font-size:12px"><div align="center">Tgl. lahir/ </br>
          <i>Date of Birth</i></div></td>
<td style="font-size:12px"><div align="center">Tinggi badan/ </br>
          <i>Height</i></div></td>
<td style="font-size:12px"><div align="center">Berat badan/ </br>
          <i>Weight</i></div></td>
<td style="font-size:12px"><div align="center">Jenis kelamin/ </br>
          <i>Sex</i></div></td>
  </tr>
  <tr>
    <td height="40" style="font-size:12px"><div align="center"><?php echo $rw['tgl_lahir']; ?> </div></td>
    <td style="font-size:12px"><div align="center"><?php echo $rw['tb']; ?> cm</div></td>
    <td style="font-size:12px"><div align="center"><?php echo $rw['bb']; ?> Kg</div></td>
    <td style="font-size:12px"><div align="center"><?php echo $rw['sex']; ?></div></td>
  </tr>
</table>

					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" style="font-size:13px">
						Pada pemeriksaan hari ini dinyatakan dalam keadaan Sehat. </br>
						<i>based on my medical examination today, the above mentioned name is physically fit.</i>
					</td>
					</tr>
					<tr>
					<td>&nbsp;
					
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" style="font-size:14px">
						Surat keterangan ini dibuat untuk keperluan : <strong><? echo $jml;?></strong>						
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" style="font-size:11px">
						<i>The certificate is made for the purpose of :</i>
					</td>
					</tr>
					<tr>
					<td colspan="6">&nbsp;
					
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" style="font-size:14px">
					<strong>Keterangan/ <i>Information</i> :</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6">
						<table width="99%" border="1" style="font-size:12px; border-collapse:collapse">
							<tr>
								<td><div align="center">Tekanan darah/ </br> 
								    <i>tensi</i>
								</div></td>
								<td><div align="center">Nadi/ </br> 
								    <i>pulse</i>
								</div></td>
								<td><div align="center">Pernafasan/ </br> 
								    <i>Respiration rate</i>
								</div></td>
							</tr>
							<tr>
								<td height="35"><div align="center">Sistolik : <?php echo $rw['TENSI']?> mmHg<br/>Diastolik : <?php echo $rw['TENSI_DIASTOLIK']?> mmHg 
								</div></td>
								<td><div align="center"><?php echo $rw['nadi']?> X/min</div></td>
								<td><div align="center"><?php echo $rw['pernapasan']?> X/min</div></td>
							</tr>
						</table>
					</td>
					<tr>
					<td>&nbsp;
					
					</td>
					</tr>
					<tr>
					<td colspan="6">
<table width="99%" border="0" style="font-size:12px; border-collapse:collapse; border:1px solid #000000">
  <tr>
    <td width="26%" height="44" style="border-bottom:1px solid #000000"><div align="left">Tanggal Pemeriksaan </br> 
          <i>date of examination</i></div></td>
    <td width="3%" style="border-bottom:1px solid #000000">:</td>
	<td width="71%" style="border-bottom:1px solid #000000"><?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
  </tr>
  <tr>
    <td height="47" style="border-bottom:1px solid #000000"><div align="left">Tanda tangan dokter </br> 
          <i>Doctor's signature</i></div></td>
    <td style="border-bottom:1px solid #000000">:</td>
	<td style="border-bottom:1px solid #000000">&nbsp;</td>
  </tr>
  <tr>
    <td height="43" style="border-bottom:1px solid #000000"><div align="left">Nama Dokter </br>
          <i>Doctor's name</i> </div></td>
    <td style="border-bottom:1px solid #000000">:</td>
	<td style="border-bottom:1px solid #000000"><?php echo $rw['nama_dokter'];?></td>
</tr>
</table>

					</td>
					</tr>
<tr style="font-size:11px">
	<td colspan="4">
	Putih/<i>white</i> : Pasien/ <i>patient</i>
	Merah/<i>red</i> : Rumah Sakit/ <i>Hospital</i>
	</td>					
	<td colspan="2">
	  <div align="right">FORM-MCU-11-00 &nbsp;&nbsp;
	    </div></td>
</tr>
                   <!-- <tr>
                            <td width="11%" style="font-size:12px" colspan="6">&nbsp;</td>
                            <!--<td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>-->
                            <!--<td width="10%" style="font-size:12px">Unit</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['nmUnit'];?></td>
                    </tr>
                    <tr>
                            <!--<td width="11%" style="font-size:12px">Dokter</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['dok_rujuk']);?></td>-->
                            <!--<td width="10%" style="font-size:12px">Tgl Sample</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;</td>-->
                            <!--<td width="10%" style="font-size:12px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
                    </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="10%" style="font-size:12px">Tgl Periksa</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="10%" style="font-size:12px">Unit </td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo $rw['nmUnit'];?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="10%" style="font-size:12px">Diagnosa</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['diag']);?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px">Kel. / Desa</td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td width="10%" style="font-size:12px">Dokter</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['dokter']);?></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:12px">RT / RW</span></td>
                          <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td width="10%" style="font-size:12px">Status Pasien</td>
                            <td width="1%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="30%" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
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
			 <tr>
                <td height="5" colspan="2" >&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			/*$sqlPet = "select nama from b_ms_pegawai where id = $_REQUEST[idUser]";
			//echo $sqlPet;
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);*/
			//echo $pegawai;
			?>
                <td width="603" style="font-weight:bold;font-size:12px"><br/>
               
				<!--Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rt[0];?> )</td>-->
                <!--<td width="293" style="font-size:12px"><center>
                    Medan, <?php echo gmdate('d F Y',mktime(date('H')+7));?>
                </center><br/>
                <center>Dokter yang Memeriksa</center><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><center>(<strong><?php echo $usr['nama'];?></strong>)</center></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>-->
			<table align="center">
			<tr>
			<td>&nbsp;
			
			</td>
			</tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" style="display:none" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=<?php echo "yes"; ?>';"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
		</table>
        <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Surat Keterangan Sehat ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>