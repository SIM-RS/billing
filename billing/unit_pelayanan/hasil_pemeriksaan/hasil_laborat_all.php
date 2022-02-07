<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$acc=$_REQUEST['acc'];
$idKunj=$_REQUEST['idKunj'];
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}

$sqlHasil="SELECT *,DATE_FORMAT(tgl_act,'%d-%m-%Y %H:%i') tglHasil 
			FROM b_hasil_lab 
			WHERE id_kunjungan='$idKunj' 
				AND verifikasi2=1 
				AND id_pelayanan='$idPel' 
				AND id_tpa=0 
			ORDER BY id DESC";
$rsHasil=mysql_query($sqlHasil);
$tglHasil="";
if (mysql_num_rows($rsHasil)>0){
	$rwHasil=mysql_fetch_array($rsHasil);
	$tglHasil=$rwHasil["tglHasil"];
}

$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas,md.nama as diag,peg.nama as dokter,
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.no_lab,p.kelas_id,un.nama nmUnit
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
left join b_ms_unit un on un.id=p.unit_id_asal
left join b_diagnosa diag on diag.kunjungan_id=k.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
left join b_ms_pegawai peg on peg.id = diag.user_id
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$jmlTot = mysql_num_rows($rs1);
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Hasil Laboratorium :.</title>
    </head>
    <body style="margin-top:0px">
     <?
		if($jmlTot > 0)
		{
	?>
        <table width="1026" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi" style="margin-left:10px;">
          <!--DWLayoutTable-->
            <tr>
                <td height="85" colspan="2" style="font-size:14px"><b><?=$_SESSION['namaP']?><br />
		Instalasi Laboratorium Klinik<br />
		<?=$_SESSION['alamatP']?> Telepon <?=$_SESSION['tlpP'] ?><br/></b>&nbsp;                </td>
                <td width="127"></td>
            </tr>
            <tr>
                <td width="732" height="5" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
                <td width="167" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
                <td style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr>
              <td height="30" colspan="3" align="center" valign="top" style="font-weight:bold;font-size:13px">
              <u>&nbsp;Rincian Hasil Laboratorium Pasien&nbsp;</u>                </td>
          </tr>
            
            <tr class="kwi">
                <td height="108" colspan="3" valign="top">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                      <!--DWLayoutTable-->
                        <tr>
                            <td width="112" height="18" style="font-size:12px">No RM (No Lab)</td>
                            <td width="20" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="619" valign="top" style="font-size:12px">&nbsp;<?php echo $rw['no_rm']." (".$rw['no_lab'].")";?></td>
                          <td width="90" valign="top" style="font-size:12px">Unit</td>
                      <td width="22" align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td width="200" valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo $rw['nmUnit'];?></td>
                        </tr>
                        
                        <tr>
                            <td height="18" valign="top" style="font-size:12px">Nama Pasien </td>
                            <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td valign="top" style="font-size:12px">Dokter</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:capitalize;">&nbsp;<?php echo strtolower($rw['dokter']);?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Alamat</td>
                            <td align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td valign="top" style="font-size:12px">Status Pasien</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Kel. / Desa</td>
                          <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          <td valign="top" style="font-size:12px">Hak Kelas</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo $rw['kelas'];?></td>
                        </tr>
                        <tr>
                            <td height="18"><span style="font-size:12px">RT / RW</span></td>
                          <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td valign="top" style="font-size:12px">Tgl Periksa</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Jenis Kelamin </td>
                            <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px;text-transform:uppercase;">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <td valign="top" style="font-size:12px">Tgl Hasil</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo $tglHasil;?></td>
                        </tr>
                        <tr>
                          <td height="18" style="font-size:12px"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td align="center" style="font-weight:bold;font-size:12px"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td valign="top" style="font-size:12px"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td valign="top" style="font-size:12px">Diagnosa</td>
                          <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                          <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['diag']);?></td>
                        </tr>
                        <tr>
                          <td height="0"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
              </table></td>
            </tr>
            <tr class="kwi">
                <td height="74" colspan="3" valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <!--DWLayoutTable-->
                        <tr>
						<td align="center" width="20" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">No</td>
						<td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">Jenis Pemeriksaan</td>
                            <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Metode</td>
                            <!--td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td-->
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Hasil</td>
                           <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Normal</td>
                            <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Keterangan</td>
                        </tr>
			<?php
			$sqlc="SELECT d.id,d.nama_kelompok,c.nama,b.metode,IF(b.normal2='',b.normal1,CONCAT(b.normal1,' - ',b.normal2)) AS normal,
a.id_pelayanan,a.tgl_act tglHasil,msl.nama_satuan,a.hasil,a.ket, IFNULL((SELECT nama_kelompok FROM b_ms_kelompok_lab WHERE id = d.`parent_id`),d.nama_kelompok) AS parent 
, IFNULL((SELECT id FROM b_ms_kelompok_lab WHERE id = d.`parent_id`),d.id) AS parentId 
FROM (SELECT * FROM b_hasil_lab WHERE id_kunjungan='$idKunj' AND verifikasi2=1 AND id_pelayanan='$idPel' /*AND 1 = '$acc'*/) AS a 
INNER JOIN b_ms_normal_lab b ON a.id_normal=b.id 
INNER JOIN b_ms_pemeriksaan_lab c ON b.id_pemeriksaan_lab=c.id 
INNER JOIN b_ms_kelompok_lab d ON c.kelompok_lab_id=d.id 
INNER JOIN b_ms_satuan_lab msl ON b.id_satuan=msl.id ORDER BY a.id_pelayanan,c.kode_urut";
			//echo $sqlc."<br>";
			$rs1=mysql_query($sqlc);
			//echo mysql_error();
			$no=0;
			$spasi="";
			$induk="";
			$kelompok="";
			$kelompokId="";
			$parentId=0;
			while($dt1 = mysql_fetch_array($rs1)){
				$no++;
				$normal=$dt1['normal'];
				if ($dt1['nama_satuan']!="" && $dt1['nama_satuan']!="-") $normal.=" ".$dt1['nama_satuan'];
				if ($parentId!=$dt1['parentId']){
					$parentId=$dt1['parentId'];
					$kelompokId=$dt1['id'];
					$kelompok=$dt1['nama_kelompok'];
					if (($kelompokId!=$parentId)){
						$induk=$dt1['parent'];
						$spasi="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						//$cetak=1;
			?>
			<tr height="25">
                    <td align="left" colspan="6" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($induk); ?></b></i></td>
			</tr>
			<tr height="25">
                    <td align="left" colspan="6" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo $spasi.strtoupper($kelompok); ?></b></i></td>
			</tr>
			<?php
					}else{
						$induk=$dt1['parent'];
			?>
			<tr height="25">
                    <td align="left" colspan="6" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($induk); ?></b></i></td>
			</tr>
			<?php
					}
				}
			?>
			<tr height="25">
                    <td align="center" style="font-size:12px;" ><?=$no;?></td>
                    <td align="left" style="padding-left:35px;font-size:12px" >&nbsp;<?php echo $spasi.$dt1["nama"]; ?></td>
                    <td align="center" style="font-size:12px"><?php echo $dt1['metode']?></td>
                    <!--td align="center" style="font-size:12px"><?php echo $dt1['tgl_act']?></td-->
                    <td align="center" style="font-size:12px"><?php echo $dt1['hasil']?></td>
                    <td align="center" style="font-size:12px"><?php echo $normal;?>&nbsp;</td>
                    <td align="center" style="font-size:12px"><?php echo $dt1['ket'];?>&nbsp;</td>
			</tr>
			<?
			}
			?>
				</table></td>
		    </tr>
            <tr class="kwi">
              <td height="28">&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
			 
            <tr class="kwi">
			<?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			?>
                <td height="92" valign="top" style="font-weight:bold;font-size:12px"><br/></td>
                <td colspan="2" align="center" valign="top" style="font-weight:bold;font-size:12px"><?=$_SESSION['kotaP']?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
				  <!--Penanggungjawab
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $pegawai;?> )-->
				  Petugas
                    <br/>
                    &nbsp;<br/>
                    &nbsp;<br/>
                    &nbsp;<br/>
                ( <?php echo $rt[0];?> )</td>
            </tr>
            <tr id="trTombol">
                <td height="24" colspan="3" align="center" valign="top" class="noline">
                    <!--input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=<?php echo "yes"; ?>';"/-->
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>                </td>
            </tr>
        </table>
        <?
				}else{
					echo "Masih dilakukan pemeriksaan....";
				}
			?>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician hasil Laboratorium ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>