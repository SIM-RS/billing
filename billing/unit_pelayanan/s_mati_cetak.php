<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$tmpm=$_REQUEST['tmpm'];
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
$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  mp.no_ktp,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex,
  mk.nama kelas,
  GROUP_CONCAT(md.nama) AS diag,
  GROUP_CONCAT(md.kode) AS icdx,
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
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kab_id) nmKab,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn,
  k.umur_bln,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bpek.nama AS kerjaan,
  DATE_FORMAT(p.tgl_act, '%d %M %Y') tglawal,
  DATE_FORMAT(p.tgl_act, '%H:%i') jamawal,
  DATE_FORMAT(bkel.tgl_act, '%d %M %Y') tglmati,
  DATE_FORMAT(bkel.tgl_act, '%H:%i') jammati,
  peg3.nama dktrmati,
  bagm.agama,
  bkel.tmpm,
  bkel.numat,
  bkel.npp,
  bkel.jp,
  bkel.sbbmati,
  bkel.kukre,
  bkel.jedi,
  bkel.almt,
  bkel.berket,
  bkel.nokber
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  LEFT JOIN b_ms_agama bagm
    ON bagm.id = mp.agama 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
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
  INNER JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  INNER JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
WHERE k.id='$idKunj' AND p.id='$idPel' AND bkel.cara_keluar like '%Meninggal%'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Surat Keterangan Meninggal :.</title>
    </head>
    <body style="margin-top:0px" onLoad="gantiUmur();">
        <table width="600" style="font:tahoma;" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:12px; border:1px solid #000;" align="center"><table border="0">
                  <tr>
                    <td style="font:26px bold tahoma" height="100" width="316">RS PELINDO I</td>
                    <td width="272"><table border="0">
  <tr>
    <td style="border:1px solid #000;font:16px bold tahoma;" height="50" width="266">SURAT KETERANGAN MENINGGAL</td>
  </tr>
</table>
</td>
                  </tr>
                </table></td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-size:13px">
                <strong>KETERANGAN MENINGGAL</strong></td>
            </tr>
            <tr class="kwi">
                <td height="10" colspan="2" align="left" style="font-size:13px">
                    
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="1" cellspacing="1">
                    <tr>
                      <td style="font-size:12px" width="35%">No Urut Kematian Bulan ini</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td width="27%" style="font-size:12px" colspan="3"><?php echo $rw['numat']; ?></td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">No Rekam Medik</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['no_rm'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">Kami menerangkan bahwa</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4" >&nbsp;</td>
                    </tr>
					<tr>
                      <td style="font-size:12px">Nama</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['nmPas'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">1. Jenis Kelamin</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['sex'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">2. Umur</td>
					  <?php tglSQL($rows['tgl_lahir'])?></u><input type="hidden" style="text-align:center;" value="<?php tglSQL($rows['tgl_lahir'])?>" class="txtinputreg" name="tgl_lahir" id="tgl_lahir" size="3" tabindex="11"/>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['umur_thn']." thn ".$rw['umur_bln']." bln ";?><label type="text" style="text-align:center;" value="0" class="txtinputreg" name="hari" id="hari" size="3" tabindex="12"></label>&nbsp;hari</td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
					<tr>
                      <td style="font-size:12px">3. Alamat</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td colspan="4" style="font-size:12px"><?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?></td>
                      </tr>
					<tr>
                      <td style="font-size:12px">4. Kelurahan / Desa</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['nmDesa'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
					<tr>
                      <td style="font-size:12px">5. Kecamatan</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['nmKec'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
					<tr>
                      <td style="font-size:12px">6. Kabupaten / Kota</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px"><?php echo $rw['nmKab'];?></td>
                      <td style="font-size:12px">&nbsp;</td>
                      <td align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                      <td style="font-size:12px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">7. No Pokok Penduduk</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php echo $rw['npp']; ?></td>
                    </tr>
					<tr>
                      <td style="font-size:12px">8. No Kartu Penduduk</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php echo $rw['no_ktp']; ?></td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">9. Waktu Meninggal</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php echo "Tgl : ".date('d', strtotime($rw['tglmati']))."&nbsp;&nbsp;"."Bln : ".date('M', strtotime($rw['tglmati']))."&nbsp;&nbsp;"."Thn : ".date('Y', strtotime($rw['tglmati']))."&nbsp;&nbsp;"."Jam : ".$rw['jammati']; ?></td>
                    </tr>
                    <tr>
                      <td style="font-size:12px">10. Tempat Meninggal</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php if($rw['tmpm']==1){echo  "1. RS";}
																   elseif($rw['tmpm']==2){echo  "2. RB";} 
																   elseif($rw['tmpm']==3){echo  "3. Puskesmas";}
																   elseif($rw['tmpm']==4){echo  "4. Rumah";}
																   else {echo "5. Lain-lain";}?></td>
                    </tr>
					<tr>
                      <td style="font-size:12px">11. Alamat Tempat Meninggal</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4">Jl/Gg. <?php echo $rw['almt']; ?></td>
                    </tr>
					<tr>
                      <td style="font-size:12px">12. Waktu Pemeriksaan</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php echo "Tgl : ".date('d', strtotime($rw['tglawal']))."&nbsp;&nbsp;"."Bln : ".date('M', strtotime($rw['tglawal']))."&nbsp;&nbsp;"."Thn : ".date('Y', strtotime($rw['tglawal']))."&nbsp;&nbsp;"."Jam : ".$rw['jamawal']; ?></td>
                    </tr>
					<tr>
                      <td style="font-size:12px">13. Jenis Pemeriksaan</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php if($rw['jp']==1){echo "1. Visum";}
																   elseif($rw['jp']==2){echo "2. Outopsi";}
																   else{echo "3. Tidak Divisum";}?>
					  </td>
                    </tr>
					<tr>
                      <td style="font-size:12px">14. Sebab Kematian</td>
                      <td align="center" style="font-weight:bold;font-size:12px" rowspan="2">:</td>
                      <td style="font-size:12px" colspan="4" rowspan="2"><?php if($rw['sbbmati']==1){echo "1. Sakit";}
																   elseif($rw['sbbmati']==2){echo "2. Bersalin";}
																   elseif($rw['sbbmati']==3){echo "3. Lahir Mati";}
																   elseif($rw['sbbmati']==4){echo "4. Kec L.L";}
																   elseif($rw['sbbmati']==5){echo "5. Kec Industri";}
																   elseif($rw['sbbmati']==6){echo "6. Bunuh Diri";}
																   elseif($rw['sbbmati']==7){echo "7. Pembunuhan/Penganiayaan";}
																   elseif($rw['sbbmati']==8){echo "8. Lain-lain";}
																   else{echo "9. Tidak Dapat Ditentukan";}?>     
					  </td>
					<tr>
                      <td style="font-size:12px" align="center">(Menurut Dokter / Polisi)</td>
                      <td style="font-size:12px" colspan="5">&nbsp;</td>
                    </tr>
                    </tr>
					<tr>
                      <td style="font-size:12px">15. No. Sebab Kematian (ICD X)</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php echo $rw['icdx'];?></td>
                    </tr>
					<tr>
                      <td style="font-size:12px">16. Akan Dikubur / Dikremasi</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php if($rw['kukre']==1){echo "1. Medan";}
																   else{echo "2. Luar Medan";}?>
					  </td>
                    </tr>
					<tr>
                      <td style="font-size:12px">17. Jenazah di(*)</td>
                      <td align="center" style="font-weight:bold;font-size:12px">:</td>
                      <td style="font-size:12px" colspan="4"><?php if($rw['jedi']==1){echo "1. Diawetkan";}
																   else{echo "2. Tidak Diawetkan";}?></td>
                    </tr>
                    <tr>
                            <td colspan="6" style="font-size:12px">&nbsp;</td>
                      </tr>
              </table>	</td>
            </tr>
			 <tr>
                <td colspan="2" >&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			/*$sqlPet = "select nama from b_ms_pegawai where id = $_REQUEST[idUser]";
			//echo $sqlPet;
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);*/
			//echo $pegawai;
			?>
                <td width="603" style="font-size:12px"><br/><br/><br/>Yang Memberi Keterangan / Melapor<br/><br/><br/><br/><br/>(<?php echo $rw['berket'];?>)<br/>
				No. KTP/SIM :&nbsp;&nbsp;<?php echo $rw['nokber'];?>
				<!--Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php //echo $rt[0];?> )--></td>
                <td width="293" style="font-size:12px"><center>
                    Medan, <?php echo gmdate('d F Y',mktime(date('H')+7));?>
                </center><br/>
                <center>Dokter yang Memeriksa</center><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><center>(<strong><?php echo $usr['nama'];?></strong>)</center></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&idUser=<?php echo $idUser; ?>&excel=<?php echo "yes"; ?>';"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Surat Keterangan Meninggal ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			function gantiUmur(){
            var val=document.getElementById('tgl_lahir').value;
			//alert(val);
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');

            var tgl = val.split("-");
            var tahun = tgl[2];
            var bulan = tgl[1];
            var tanggal = tgl[0];
            //alert(tahun+", "+bulan+", "+tanggal);
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            //alert(Y+", "+M+", "+D);
            Y = Y - tahun;
            M = M - bulan;
            D = D - tanggal;
            //M = pad(M+1,2,'0',1);
            //D = pad(D,2,'0',1);
            //alert(Y+", "+M+", "+D);
            if(D < 0){
                M -= 1;
                D = 30+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            //document.getElementById("th").value = Y;
            //document.getElementById("Bln").value = M;
            document.getElementById("hari").innerHTML = D;
            //$("txtHari").value = D;
        }
        </script>
        </script>