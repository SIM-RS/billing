<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}

$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas,md.nama as diag,peg.nama as dokter,
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id,un.nama nmUnit
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
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Hasil Laboratorium :.</title>
    </head>
    <body style="margin-top:0px">
        <table width="900" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:14px">
                    <b><?=$pemkabRS?><br />
		<?=$namaRS?><br />
		Instalasi Laboratorium Klinik<br />
		<?=$alamatRS?> Telepon <?=$tlpRS?><br/></b>&nbsp;
                </td>
            </tr>
            <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px">
                    <u>&nbsp;Rincian Hasil Laboratorium Pasien&nbsp;</u>
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
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
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
						<td align="center" width="20" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">No</td>
						<td align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">Jenis Pemeriksaan</td>
                            <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Metode</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td>
                            <td align="center" width="100" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Hasil</td>
                           <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Normal</td>
                            <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Keterangan</td>
                        </tr>
			<?php
			$sqlc="SELECT DISTINCT d.* FROM (SELECT * FROM b_hasil_lab WHERE id_pelayanan='$idPel') AS a 
INNER JOIN b_ms_normal_lab b ON a.id_normal=b.id
INNER JOIN b_ms_pemeriksaan_lab c ON b.id_pemeriksaan_lab=c.id
INNER JOIN b_ms_kelompok_lab d ON c.kelompok_lab_id=d.id";
			//echo $sqlc."<br>";
			$rs1=mysql_query($sqlc);
			//echo mysql_error();
			$no=0;
			$spasi="";
			while($dt1 = mysql_fetch_array($rs1)){
				if ($dt1["parent_id"]>0){
					$sql="SELECT * FROM b_ms_kelompok_lab WHERE id='".$dt1["parent_id"]."'";
					$rs=mysql_query($sql);
					$rwKel=mysql_fetch_array($rs);
					$spasi="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			?>
			<tr height="25">
                    <td align="left" colspan="7" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($rwKel["nama_kelompok"]); ?></b></i></td>
            </tr>
			<?php
				}
			?>
			<tr height="25">
                    <td align="left" colspan="7" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($spasi.$dt1["nama_kelompok"]); ?></b></i></td>
            </tr>
			<?php
				$sql = "SELECT c.*,b.metode,DATE_FORMAT(a.tgl_act,'%d-%m-%Y') AS tgl_act,CONCAT(a.hasil,' ',d.nama_satuan) hasilc,
CONCAT(b.normal1,' - ',b.normal2, ' ',d.nama_satuan) normal,a.ket,mp.nama dok 
FROM (SELECT * FROM b_hasil_lab WHERE id_pelayanan='$idPel') AS a 
INNER JOIN b_ms_normal_lab b ON a.id_normal=b.id
INNER JOIN b_ms_pemeriksaan_lab c ON b.id_pemeriksaan_lab=c.id
INNER JOIN b_ms_satuan_lab d ON b.id_satuan=d.id
INNER JOIN b_ms_pegawai mp ON a.user_act=mp.id
WHERE c.kelompok_lab_id='".$dt1['id']."'";
				$rs=mysql_query($sql);
				//echo mysql_error();
				while($dt = mysql_fetch_array($rs)){
					$no++;
					$pegawai=$dt['dok'];
			?>
			<tr height="25">
                    <td align="center" style="font-size:12px;" ><?=$no;?></td>
                    <td align="left" style="padding-left:35px;font-size:12px" >&nbsp;<?php echo $spasi.$dt["nama"]; ?></td>
                    <td align="left" style="font-size:12px"><?php echo $dt['metode']?></td>
                    <td align="center" style="font-size:12px"><?php echo $dt['tgl_act']?></td>
                    <td align="center" style="font-size:12px"><?php echo $dt['hasilc']?></td>
                    <td align="center" style="font-size:12px"><?php echo $dt['normal'];?>&nbsp;</td>
                    <td align="center" style="font-size:12px"><?php echo $dt['ket'];?>&nbsp;</td>
            </tr>
			<?
				}
			}
			?>
					</table>
					</td>
			</tr>
			 <tr>
                <td height="5" colspan="2" style="border-bottom:#000000 double 0.1px; border-top:#000000 solid 0.1px">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi">
			<?php
			echo $sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			?>
                <td width="603" style="font-weight:bold;font-size:12px"><br/>
				Petugas
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rt[0];?> )</td>
                <td width="293" style="font-weight:bold;font-size:12px"><?=$kotaRS?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
				Penanggungjawab
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $pegawai;?> )</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=<?php echo "yes"; ?>';"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
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