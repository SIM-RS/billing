<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idPasien=$_REQUEST['idPasien'];
$page=$_REQUEST["page"]; 
if (isset($_REQUEST['tgl1'])){
	$tgl1_a=$_REQUEST['tgl1'];
	$tgl2_a=$_REQUEST['tgl2'];
	$tmp = explode("-",$tgl1_a);
	$tmp1 = explode("-",$tgl2_a);
	$tgl1 = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tgl2 = $tmp1[2].'-'.$tmp1[1].'-'.$tmp1[0];
}else{
	$tgl2_a=gmdate('d-m-Y',mktime(date('H')+7));
	$tmp1 = explode("-",$tgl2_a);
	$tgl2 = $tmp1[2].'-'.$tmp1[1].'-'.$tmp1[0];
	$sql_d="SELECT DATE_SUB('$tgl2',INTERVAL 1 MONTH) tgl_lalu";
	//echo $sql_d."<br>";
	$rs_d=mysql_query($sql_d);
	$rw_d=mysql_fetch_array($rs_d);
	$tgl1=$rw_d['tgl_lalu'];
	
	$tmp = explode("-",$tgl1);
	$tgl1_a = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
}

$qPasien="select p.no_rm,p.nama,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='".$idPasien."'";
//echo $qPasien."<br>";
$rsPasien=mysql_query($qPasien);
$rwPasien=mysql_fetch_array($rsPasien);
$date_now=gmdate('d-m-Y',mktime(date('H')+7));

$qKunj="select k.id,k.tgl,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."' ORDER BY k.tgl DESC";
//echo $qKunj."<br>";
$rsKunj=mysql_query($qKunj);
$jmldata=mysql_num_rows($rsKunj);
$perpage=10;
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$totpage=2;
?>
<html>
    <head>
        <title>Rekam Medis Pasien</title>
        <style>
            .withline{
                border:1px solid #000000;
            }
            .noline{
                border:none;
            }
            .tableHeader{
                font:10 bold;
                border:1px solid #000000;
                text-align:center;
            }
            .tableContent{
                font:10 sans-serif normal;
                border:1px solid #000000;
                padding-left:5px;
            }
        </style>
    </head>
    <body>
    <script type="text/JavaScript">
            var arrRange = depRange = [];
    </script>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <table width="100%" align="center" cellpadding=0 cellspacing=0>
            <tr>
                <td class="noline" colspan="2" style="font:12 sans-serif normal"><?=$namaRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"><?=$alamatRS?> </td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold">Telepon <?=$tlpRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"><?=$kotaRS?></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" style="font:small sans-serif bold"></td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" colspan="4" align="center" style="font:14 sans-serif bolder;text-transform:uppercase;font-weight:bold">Riwayat Pasien</td>
            </tr>
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    No RM 
                </td>
                <td class="noline">&nbsp;:</td>
                <td class="noline">&nbsp;<?php echo $rwPasien['no_rm'];?></td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    Nama Pasien
                </td>
                <td class="noline">&nbsp;:</td>
                <td class="noline">&nbsp;<?php echo $rwPasien['nama'];?></td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline"  style="font:12 sans-serif bolder;">
                    Alamat  
                </td>
                <td class="noline">&nbsp;:</td>
                <td class="noline">&nbsp;<?php echo $rwPasien['alamat']." RT.".$rwPasien['rt']." RW.".$rwPasien['rw']." Desa/Kel.".$rwPasien['desa']." Kec.".$rwPasien['kec']." Kab.".$rwPasien['kab'];?></td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr height="40">
                <td class="noline"><input type="checkbox" id="pil1" name="pil1" <? if(!isset($_REQUEST['tgl1'])) echo "checked";?> onClick="cPil(this,pil2);">Halaman 
                <!--&nbsp;
                <input id="txtAwal" name="txtAwal" readonly size="11" class="txtcenter" type="text" value="<?php $tgl1_a; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAwal'),depRange,'');"/>
				&nbsp; S/d &nbsp;
                <input id="txtAkhir" name="txtAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl2_a; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAkhir'),depRange,'');"/> &nbsp;<input type="button" name="btnTampil" value="Tampilkan" class="txtcenter" onClick="tampil();"/-->
                </td>
                <td class="noline">&nbsp;:</td>
                <td class="noline">&nbsp;<input id="txtHal" name="txtHal" min="1" max="<?php echo $totpage; ?>" step="1" class="txtcenter" style="width:70" type="number" value="1" />&nbsp;dari&nbsp;<?php echo $totpage; ?>&nbsp;&nbsp;&nbsp;<input type="button" name="btnTampil" id="bPil1" value="Tampilkan" class="txtcenter" onClick="tampil();"/></td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr height="40">
                <td class="noline"><input type="checkbox" id="pil2" name="pil2" onClick="cPil(this,pil1);" <? if(isset($_REQUEST['tgl1'])) echo "checked";?>>Periode
                <!--&nbsp;
                <input id="txtAwal" name="txtAwal" readonly size="11" class="txtcenter" type="text" value="<?php $tgl1_a; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAwal'),depRange,'');"/>
				&nbsp; S/d &nbsp;
                <input id="txtAkhir" name="txtAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl2_a; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAkhir'),depRange,'');"/> &nbsp;<input type="button" name="btnTampil" value="Tampilkan" class="txtcenter" onClick="tampil();"/-->
                </td>
                <td class="noline">&nbsp;:</td>
                <td class="noline">&nbsp; <input disabled id="txtAwal" name="txtAwal" readonly size="11" class="txtcenter" type="text" value="<?php 
				if(!isset($_REQUEST['tgl1']))
				{
					echo $date_now;
				}else{
					echo $_REQUEST['tgl1'];
				}
				?>" />&nbsp;<input disabled type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAwal'),depRange,'');" id="tgl1"/>
				&nbsp; S/d &nbsp;
                <input disabled id="txtAkhir" name="txtAkhir" readonly size="11" class="txtcenter" type="text" value="<?php if(!isset($_REQUEST['tgl2'])) {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $_REQUEST['tgl2'];
                                        }
                                        ?>" />&nbsp;<input disabled type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtAkhir'),depRange,'');" id="tgl2"/> &nbsp;<input disabled type="button" name="btnTampil" id="bPil2" value="Tampilkan" class="txtcenter" onClick="tampil_P();"/></td>
                <td class="noline">&nbsp;</td>
            </tr>
            
            <tr>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
                <td class="noline">&nbsp;</td>
            </tr>
            <tr>
                <td class="noline" align="center" colspan="4">
                    <table class="withline" width="100%" cellpadding=0 cellspacing=0>
                        <tr>
                            <td width="3%" class="tableHeader"><strong>No</strong></td>
                            <td width="8%" class="tableHeader"><strong>Kunjungan</strong></td>
                            <td width="25%" class="tableHeader"><strong>Tindakan</strong></td>
                            <td width="20%" class="tableHeader"><strong>Diagnosa</strong></td>
                            <td width="20%" class="tableHeader"><strong>Obat</strong></td>
                            <td width="15%" class="tableHeader"><strong>SOAPIER</strong></td>
                            <td width="15%" class="tableHeader"><strong>ANAMNESIS</strong></td>
                            <td width="15%" class="tableHeader"><strong>Status Keluar</strong></td>
                        </tr>
                        <?php
						/*if(!isset($_REQUEST['tgl1']))
						{
							$qKunj="select k.id,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."'  AND (MONTH(k.tgl_act)=MONTH(NOW()) OR MONTH(k.tgl_act)=MONTH(NOW())-1) ORDER BY k.tgl_act DESC";	
						}else{*/
							//$qKunj="select k.id,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."' AND tgl BETWEEN '$tgl1' AND '$tgl2' ORDER BY k.tgl_act DESC";	
						//}
						
						$qKunj=$qKunj." limit $tpage,$perpage";
						
						if(isset($_REQUEST['tgl1']))
						{
							$qKunj="select k.id,k.tgl_act from b_kunjungan k where k.pasien_id='".$idPasien."' AND tgl BETWEEN '$tgl1' AND '$tgl2' ORDER BY k.tgl_act DESC";
						}
						
						//echo $qKunj."<br>";
						$rsKunj=mysql_query($qKunj);
						
                        $nox=($page-1)*$perpage;
                        $tempUnit='';
						$tempTgl='';
                        $tempUnit2='';
                        $tempUnit3='';
                        $tempName = '';
						$nox += 1;
                        while($rwKunj=mysql_fetch_array($rsKunj)) {
                            $tanggal=explode(" ",$rwKunj['tgl_act']);
                            ?>
                        <tr>
                            <td class="tableContent" align="center"><?php echo $nox;?></td>
                            <td class="tableContent" align="center" valign="middle"><?php echo tglSQL($tanggal[0])." ".$tanggal[1];?>&nbsp;</td>
                            <td class="tableContent" align="left" valign="top" style="font-size:13px">
                                    <?php
									$i = 0;
									$y = 0;
                                    /* $qTind="SELECT p.id AS p_id, u.id AS id_unit,u.nama AS unit,mt.nama AS tindakan,IF(u_asal.kategori <> 1,n.nama,'') AS rujuk_dari
                                      ,IF(u_asal.kategori <> 1,p.tgl,'') AS tgl_rujuk
                                      ,IF(bp.nama IS NOT NULL,CONCAT('<br/>Dokter:&nbsp;',bp.nama),'') AS nm_dokter,
                                      IF(bp2.nama IS NOT NULL,CONCAT('<br/>Petugas:&nbsp;',bp2.nama,'<br/>'),'') AS nm_user
                                            FROM (SELECT * FROM b_tindakan t WHERE t.kunjungan_id='".$rwKunj['id']."') AS t1
                                            INNER JOIN b_pelayanan p ON p.id=t1.pelayanan_id
                                            INNER JOIN b_ms_unit u ON u.id=p.unit_id
                                            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
                                            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id
                                            INNER JOIN b_ms_unit u_asal ON p.unit_id_asal = u_asal.id
                                            LEFT JOIN b_ms_unit n ON n.id=p.unit_id_asal
                                            LEFT JOIN b_ms_pegawai bp ON bp.id = t1.user_id
                                            LEFT JOIN b_ms_pegawai bp2 ON bp2.id= t1.user_act
                                            ORDER BY unit"; */
									$qTind = "
										SELECT 
										  p.id AS p_id,
										  u.id AS id_unit,
										  u.nama AS unit,
										  /* GROUP_CONCAT(mt.nama SEPARATOR '<br/>- ') AS tindakan, */
										  GROUP_CONCAT(CONCAT(mt.nama,'*|*',p.id) SEPARATOR '|||') AS tindakan,
										  IF(u_asal.kategori <> 1, n.nama, '') AS rujuk_dari,
										  IF(u_asal.kategori <> 1, p.tgl, '') AS tgl_rujuk,
										  bp.id,
										  IF(bp.nama IS NOT NULL,bp.nama,'') AS dokter,
										  bp2.id,
										  IF(bp2.nama IS NOT NULL,bp2.nama,'') AS petugas 
										FROM
										  (SELECT 
											* 
										  FROM
											b_tindakan t 
										  WHERE t.kunjungan_id = '".$rwKunj['id']."') AS t1 
										  INNER JOIN b_pelayanan p 
											ON p.id = t1.pelayanan_id 
										  INNER JOIN b_ms_unit u 
											ON u.id = p.unit_id 
										  INNER JOIN b_ms_tindakan_kelas tk 
											ON tk.id = t1.ms_tindakan_kelas_id 
										  INNER JOIN b_ms_tindakan mt 
											ON mt.id = tk.ms_tindakan_id 
										  INNER JOIN b_ms_unit u_asal 
											ON p.unit_id_asal = u_asal.id 
										  LEFT JOIN b_ms_unit n 
											ON n.id = p.unit_id_asal 
										  LEFT JOIN b_ms_pegawai bp 
											ON bp.id = t1.user_id 
										  LEFT JOIN b_ms_pegawai bp2 
											ON bp2.id = t1.user_act 
										GROUP BY u.id, bp.id, bp2.id
										ORDER BY unit
									";
									//echo $qTind."<br>";
                                    $rsTind=mysql_query($qTind);
									$tmpDokter="";
                                    while($rwTind=mysql_fetch_array($rsTind)) {
									$qcGal = "SELECT id FROM b_upload_rm where id_pelayanan = $rwTind[p_id]";
									$execQcGal=mysql_query($qcGal);
									$jmlCGal=mysql_num_rows($execQcGal);
									
									if($jmlCGal>0)
									{
										$nUnitBar = "<span style=\"color:#00F; cursor:pointer;\" onclick=\"tampil1('$rwTind[p_id]')\" title=\"klik untuk melihat galery\"><b>$rwTind[unit]</b></span>";
									}else{
										$nUnitBar = "<span><b>$rwTind[unit]</b></span>";
									}
										//echo ++$jo;
                                        if((($tempUnit!=$rwTind['unit']) || ($tempTgl!=$rwTind['tgl_rujuk'])) && ($rwTind['id_unit']!=58 && $rwTind['id_unit']!=59)) {
                                            $tempUnit=$rwTind['unit'];
											$tempTgl = $rwTind['tgl_rujuk'];
							?>
									<?php
											echo $nUnitBar.(($rwTind['rujuk_dari']!='')?" (Dirujuk dari: ".$rwTind['rujuk_dari']:'').(($rwTind['tgl_rujuk']!='')?" tanggal: ".tglSQL($rwTind['tgl_rujuk']).")":'');
										}else{
											if($tempUnit!=$rwTind['unit']){
												$tempUnit=$rwTind['unit'];
												echo $nUnitBar."<br>";
												$border ='style="border:1px solid #000; padding:2px;"';
												?>
                                                <table style="border-collapse:collapse; border:1px solid #000; font-size:13px;" cellpadding=0 cellspacing=0>
                                                <tr>
                                                    <td <?php echo $border; ?> align="center">Tanggal</td>
                                                    <td <?php echo $border; ?> align="center">Unit Asal</td>
                                                    <td <?php echo $border; ?> align="center">Dokter</td>
                                                    <td <?php echo $border; ?> align="center">Petugas</td>
                                                    <td <?php echo $border; ?> align="center">Detil</td>
                                                </tr>
                                                <?
													$quLabN = "SELECT DISTINCT p.id AS pelayanan_id,p.kunjungan_id, 
																IF(u_asal.kategori <> 1, DATE_FORMAT(p.tgl,'%d-%m-%Y'), '') AS tgl_rujuk,
																IF(u_asal.kategori <> 1, u_asal.nama, '') AS rujuk_dari,
																IF(bp.nama IS NOT NULL, bp.nama, '') AS dokter,
																bp2.id,
																IF(bp2.nama IS NOT NULL, bp2.nama, '') AS petugas, u_asal.nama
																FROM b_pelayanan P 
																INNER JOIN (SELECT * FROM b_tindakan t WHERE t.kunjungan_id = '".$rwKunj['id']."') AS t1 ON p.id = t1.pelayanan_id 
																INNER JOIN b_ms_unit u_asal ON p.unit_id_asal = u_asal.id
																LEFT JOIN b_ms_pegawai bp ON bp.id = t1.user_id 
																LEFT JOIN b_ms_pegawai bp2 ON bp2.id = t1.user_act 
																WHERE p.kunjungan_id = '".$rwKunj['id']."' AND p.unit_id = 58;";
													$execLabN = mysql_query($quLabN);
													while($daLabN = mysql_fetch_array($execLabN))
													{
														?>
                                                        <tr>
                                                        	<td <?php echo $border; ?> align="center"><?=$daLabN['tgl_rujuk']?></td>
                                                            <td <?php echo $border; ?> align="center"><?=$daLabN['rujuk_dari']?></td>
                                                            <td <?php echo $border; ?> align="center"><?=$daLabN['dokter']?></td>
                                                            <td <?php echo $border; ?> align="center"><?=$daLabN['petugas']?></td>
                                                            <td <?php echo $border; ?> align="center"><span onClick="viewLabN('<?=$daLabN['pelayanan_id']?>','<?=$daLabN['kunjungan_id']?>')" style="color:#03F; cursor:pointer;">Detil</span></td>
                                                       </tr>
                                                        <?
													}
												?>
                                                </table>
                                                <?
											}
										}
									?>
									<?php 
										if(($tmpDokter != $rwTind['dokter']) && ($rwTind['id_unit']!=58 && $rwTind['id_unit']!=59)){
											$tmpDokter = $rwTind['dokter'];
											echo "<br />- <b>Dokter</b> : ".$rwTind['dokter']."<br />"; 
										}
										/* if($tmpDokter != $rwTind['petugas']){
											$tmpDokter = $rwTind['petugas']; */
										if(($rwTind['id_unit']!=58 && $rwTind['id_unit']!=59))
										{
											echo "&nbsp; * <b>Petugas</b> : ".$rwTind['petugas']."<br />"; 
										}
										//}
									?>
										<div class="kanann" style="margin-left:1px; margin-bottom:5px;">
									<?php
										if($rwTind['id_unit']==58 || $rwTind['id_unit']==59){
											
											
											
										}else{
											$tindakan = explode('|||',$rwTind['tindakan']);
										}
										//echo "- ".$rwTind['tindakan'];
										$no = 1;
										echo "<ol style='margin-top:5px; margin-left:-20px; padding-right:5px;'>";
										if($rwTind['id_unit']!=58 && $rwTind['id_unit']!=59) // -> untuk mempersingkat riwayat lab
										{
										foreach($tindakan as $val){
											$isi = explode('*|*',$val);
											//$no++.
											echo '<li>'.$isi[0]."<br />";
											if($rwTind['id_unit']==58 || $rwTind['id_unit']==59){
												$sqlP = "SELECT a.*, CONCAT(b.normal1,'-',b.normal2) AS normal FROM b_hasil_lab a
												INNER JOIN  b_ms_normal_lab b ON a.id_normal = b.id WHERE id_pelayanan = $isi[1]
												limit $i,1";
												$rsqlP = mysql_query($sqlP);
												while($dsqlP = mysql_fetch_array($rsqlP))
												{
													$i++;
												?>
													&nbsp;&nbsp;Normal Lab : &nbsp;<? echo $dsqlP['normal'];?>
													<br />&nbsp;&nbsp;Hasil Lab : &nbsp;<? echo $dsqlP['hasil'];?>
												<?
												}
											} elseif ($rwTind['id_unit']==61){
												$sqlP = "SELECT * FROM b_hasil_rad WHERE pelayanan_id = $isi[1] limit $y,1";
												$rsqlP = mysql_query($sqlP);
												while($dsqlP = mysql_fetch_array($rsqlP))
												{
													$y++;
													?>
													&nbsp;&nbsp;Hasil Radiologi : &nbsp;<? echo $dsqlP['hasil'];?>
													<?
												}
											}
											echo '</li>';
										}
										echo "</ol>";
									?>
										</div>
									<?php
									}
									}
									?>
                                <!--ul style="list-style-position:inside;list-style-type:square;padding-left:2px;">
                                                <?php
                                                //echo '<b>'.$rwTind['unit'].'</b>'.(($rwTind['rujuk_dari']!='')?" (Dirujuk dari: ".$rwTind['rujuk_dari']:'').(($rwTind['tgl_rujuk']!='')?" tanggal: ".tglSQL($rwTind['tgl_rujuk']).")":'')?>
                                    <li><?php //echo $rwTind['tindakan'];?><?php //echo $rwTind['nm_dokter'];?><?php //echo $rwTind['nm_user'];?></li>
                                                <?php
                                            //}
                                            //else {
                                                ?>
                                    <li><?php //echo $rwTind['tindakan'];?><?php //echo $rwTind['nm_dokter'];?><?php //echo $rwTind['nm_user'];?></li>
                                                <?php
                                            //}
                                        ?>
                                        <? 
											/* if($rwTind['id_unit']==58 || $rwTind['id_unit']==59)
											{
												$sqlP = "SELECT a.*, CONCAT(b.normal1,'-',b.normal2) AS normal FROM b_hasil_lab a
												INNER JOIN  b_ms_normal_lab b ON a.id_normal = b.id WHERE id_pelayanan = $rwTind[p_id]
												limit $i,1";
												$rsqlP = mysql_query($sqlP);
												while($dsqlP = mysql_fetch_array($rsqlP))
												{
													$i++;
												?>
                                                	&nbsp;Normal Lab : &nbsp;<? echo $dsqlP['normal'];?>
	                                                &nbsp;Hasil Lab : &nbsp;<? echo $dsqlP['hasil'];?>
                                                <?
												}
											}elseif($rwTind['id_unit']==61){
												$sqlP = "SELECT * FROM b_hasil_rad WHERE pelayanan_id = $rwTind[p_id] limit $y,1";
												$rsqlP = mysql_query($sqlP);
												while($dsqlP = mysql_fetch_array($rsqlP))
												{
													$y++;
													?>
                                                     &nbsp;Hasil Radiologi : &nbsp;<? echo $dsqlP['hasil'];?>
                                                    <?
												}
											} */
									//}
									$tempUnit = '';
										?>
                                     </li>
								</ul-->
                                    &nbsp;
                            </td>
                            <td class="tableContent" align="left" valign="top" style="font-size:13px">
                                    <?php
                                   /* echo $qDiag="select d.diagnosa_id,u.nama as unit,IF(md.nama IS NULL, d.diagnosa_manual, md.nama) as diagnosa,IF(bp.nama IS NOT NULL,CONCAT('<br/>Dokter:&nbsp;',bp.nama),'') AS nm_dokter,
                                      IF(bp2.nama IS NOT NULL,CONCAT('<br/>Petugas:&nbsp;',bp2.nama,'<br/>'),'') AS nm_user, l.unit_id from b_diagnosa d
                                    LEFT join b_ms_diagnosa md on md.id=d.ms_diagnosa_id
                                    inner join b_pelayanan l on l.id=d.pelayanan_id
                                    inner join b_ms_unit u on u.id=l.unit_id
									LEFT JOIN b_ms_pegawai bp ON bp.id = d.user_id
                                    LEFT JOIN b_ms_pegawai bp2 ON bp2.id= d.user_act
                                    where l.kunjungan_id='".$rwKunj['id']."'
                                        order by unit"; */
									$qDiag = "SELECT 
												  d.diagnosa_id,
												  l.unit_id ,
												  u.nama AS unit,
												  GROUP_CONCAT(IF( md.nama IS NULL, d.diagnosa_manual, md.nama) SEPARATOR '|||') AS diagnosa2,
												  GROUP_CONCAT(
													CONCAT(IF(
													  md.nama IS NULL,
													  d.diagnosa_manual,
													  md.nama
													),'-|-',IFNULL(md2.kode,md.kode)) SEPARATOR '|||'
												  ) AS diagnosa,
												  bp.id,
												  IF( bp.nama IS NOT NULL, bp.nama, '' ) AS dokter,
												  bp2.id,
												  IF( bp2.nama IS NOT NULL, bp2.nama, '') AS petugas
												FROM
												  b_diagnosa d 
												  LEFT JOIN b_ms_diagnosa md 
													ON md.id = d.ms_diagnosa_id 
												  INNER JOIN b_diagnosa_rm dr
													ON dr.diagnosa_id = d.diagnosa_id
												  INNER JOIN b_ms_diagnosa md2
													ON md2.id = dr.ms_diagnosa_id
												  INNER JOIN b_pelayanan l 
													ON l.id = d.pelayanan_id 
												  INNER JOIN b_ms_unit u 
													ON u.id = l.unit_id 
												  LEFT JOIN b_ms_pegawai bp 
													ON bp.id = d.user_id 
												  LEFT JOIN b_ms_pegawai bp2 
													ON bp2.id = d.user_act 
												WHERE l.kunjungan_id = '".$rwKunj['id']."' 
												GROUP BY u.id, bp.id, bp2.id
												ORDER BY unit";
									//echo $qDiag."<br/>";
                                    $rsDiag=mysql_query($qDiag);
									$tmpDokter2 = '';
                                    while($rwDiag=mysql_fetch_array($rsDiag)) {
                                        if($tempUnit2!=$rwDiag['unit']) {
                                            $tempUnit2=$rwDiag['unit'];
											echo '<b>'.$rwDiag['unit'].'</b>';
										}
										
										if($tmpDokter2 != $rwDiag['dokter']){
											$tmpDokter2 = $rwDiag['dokter'];
											echo "<br />- <b>Dokter</b> : ".$rwDiag['dokter']."<br />"; 
										}
										echo "&nbsp; * <b>Petugas</b> : ".$rwDiag['petugas']."<br />"; 
							?>
										<div class="kanann" style="margin-left:20px; margin-bottom:5px;">
										<?php
											$tindakan = explode('|||',$rwDiag['diagnosa']);
											echo "<ol style='margin-top:5px; margin-left:-20px;'>";
											foreach($tindakan as $val){
												$hasil = explode('-|-',$val);
												echo '<li>['.$hasil[1]."] ".$hasil[0]."</li>";
											}
										?>
										</div>
								<?php
									}
								?>
                            <!--ul style="list-style-position:inside;list-style-type:square;padding-left:2px;">
                                        <?php
                                        //echo '<b>'.$rwDiag['unit'].'</b>';
                                        ?>
                            <li><?php //echo $rwDiag['diagnosa'];?><?php //echo $rwDiag['nm_dokter'];?><?php //echo $rwDiag['nm_user'];?></li>
                                        <?php
                                    /* }
                                    else { */
                                        ?>
                            <li><?php //echo $rwDiag['diagnosa'];?><?php //echo $rwDiag['nm_dokter'];?><?php //echo $rwDiag['nm_user'];?></li>
                                        <?php
                                
                                $tempUnit2 = '';
                                ?>
							</ul-->
                            &nbsp;
                    </td>
                    <td class="tableContent" align="left" valign="top" style="font-size:13px">
                            <?php
                            /*$qObat = "SELECT $dbbilling.b_resep.obat_id, $dbbilling.b_resep.kunjungan_id, qty, $dbapotek.a_obat.OBAT_NAMA,ap.unit_name,
                                    (SELECT $dbbilling.u.nama FROM $dbbilling.b_ms_unit u inner join $dbbilling.b_pelayanan p on p.unit_id=u.id WHERE $dbbilling.b_resep.id_pelayanan = $dbbilling.p.id) AS unit
                                    FROM $dbbilling.b_resep
                                    INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID = $dbbilling.b_resep.obat_id
                                    inner join $dbapotek.a_unit ap on b_resep.apotek_id = ap.unit_id
                                    WHERE $dbbilling.b_resep.kunjungan_id = '".$rwKunj['id']."' order by unit,unit_name";*/
$qObat = "SELECT 
  a.obat_id,
  a.kunjungan_id,
  a.penjualan_id,
  a.ket_dosis,
  a.qty,
  apb.QTY_JUAL,
  IFNULL(b.OBAT_NAMA,a.obat_manual) AS OBAT_NAMA,
  ap.unit_name,
  (SELECT 
    $dbbilling.u.nama 
  FROM
    $dbbilling.b_ms_unit u 
    INNER JOIN $dbbilling.b_pelayanan p 
      ON p.unit_id = u.id 
  WHERE a.id_pelayanan = $dbbilling.p.id) AS unit,
  IFNULL(IF(a.penjualan_id = 0,'tru',IF(a.obat_id=(SELECT $dbapotek.a_penerimaan.OBAT_ID idobat2 FROM $dbapotek.a_penjualan
  INNER JOIN $dbapotek.a_penerimaan
    ON $dbapotek.a_penerimaan.ID = $dbapotek.a_penjualan.PENERIMAAN_ID
  INNER JOIN $dbapotek.a_obat a2
    ON a2.OBAT_ID = $dbapotek.a_penerimaan.OBAT_ID
  WHERE $dbapotek.a_penjualan.ID = a.penjualan_id AND $dbapotek.a_penjualan.NO_KUNJUNGAN = a.id_pelayanan),'true',(SELECT a2.OBAT_NAMA idobat2 FROM $dbapotek.a_penjualan
  INNER JOIN $dbapotek.a_penerimaan
    ON $dbapotek.a_penerimaan.ID = $dbapotek.a_penjualan.PENERIMAAN_ID
  INNER JOIN $dbapotek.a_obat a2
    ON a2.OBAT_ID = $dbapotek.a_penerimaan.OBAT_ID
  WHERE $dbapotek.a_penjualan.ID = a.penjualan_id AND $dbapotek.a_penjualan.NO_KUNJUNGAN = a.id_pelayanan))),'true') obat_apotek
FROM
  $dbbilling.b_resep a
  LEFT JOIN $dbapotek.a_obat b
    ON b.OBAT_ID = a.obat_id and a.kunjungan_id = '".$rwKunj['id']."'
  INNER JOIN $dbapotek.a_unit ap 
    ON a.apotek_id = ap.unit_id
  LEFT JOIN $dbapotek.a_penjualan apb ON a.penjualan_id = apb.ID
  LEFT JOIN $dbapotek.a_penerimaan apn ON apb.PENERIMAAN_ID = apn.ID AND apn.OBAT_ID = a.obat_id	
WHERE a.kunjungan_id = '".$rwKunj['id']."' 
ORDER BY unit,
  unit_name";
							//echo $qObat."<br/><br/>";
							$rsObat = mysql_query($qObat);
                            while($rwObat = mysql_fetch_array($rsObat)) {
								if($rwObat['qty']==$rwObat['QTY_JUAL']){
									$JmlLayani="";
								}else{
									$JmlLayani="<span style='color:#F00;'>($rwObat[QTY_JUAL])</span>";
								}
								
                                if($tempUnit3!=$rwObat['unit']) {
                                    $tempUnit3=$rwObat['unit'];
                                    ?>
                    <ul style="list-style-position:inside; list-style-type:square; padding-left:2px;">
                        <?php
                        echo '<b>'.$rwObat['unit'].'</b>';
                        if(strcmp($tempName,$rwObat['unit_name']) != 0)
                            echo '<br><i>- '.$rwObat['unit_name'].'</i><br>';
                        ?>
                        <li style="padding-left: 10px"><?php echo $rwObat['OBAT_NAMA'].' <br />(Jumlah : '.$rwObat['qty'].' '.$JmlLayani.') <br> '.$rwObat['ket_dosis'].''; if($rwObat['obat_apotek']=='tru'){echo '';}else if($rwObat['obat_apotek']!='true'){echo ' [Obat Diubah]';}?></li>
                        <?php if($rwObat['obat_apotek']=='tru'){echo '';}else if($rwObat['obat_apotek']!='true'){ ?>
                    	<li style="padding-left: 10px; color:#F00;"><?php echo $rwObat['obat_apotek'];?></li>
                                <?php }
                            }
                            else {
                                if(strcmp($tempName,$rwObat['unit_name']) != 0)
                                    echo '<br><i>- '.$rwObat['unit_name'].'</i><br>';
                                ?>
                    <li style="padding-left: 10px"><?php echo $rwObat['OBAT_NAMA'].' <br />(Jumlah : '.$rwObat['qty'].' '.$JmlLayani.' ) <br> '.$rwObat['ket_dosis'].''; if($rwObat['obat_apotek']=='tru'){echo '';}else if($rwObat['obat_apotek']!='true'){echo ' [Obat Diubah]';}?></li>
                    <?php if($rwObat['obat_apotek']=='tru'){echo '';}else if($rwObat['obat_apotek']!='true'){ ?>
                    <li style="padding-left: 10px; color:#F00;"><?php echo $rwObat['obat_apotek'];?></li>
                                <?php }
                            }
                        $tempName = $rwObat['unit_name'];
                        }
                        $tempUnit3 = '';
                        ?>
                    &nbsp;
            </td>
            <td class="tableContent" align="center" valign="top">
				<?php
					$qsoap="SELECT IF(a.ket_S = ' ','&nbsp', a.ket_S) AS ket_S, IF(a.ket_O = ' ','&nbsp', a.ket_O) AS ket_O, IF(a.ket_A = ' ','&nbsp', a.ket_A) AS ket_A
					, IF(a.ket_P = ' ','&nbsp', a.ket_P) AS ket_P, IF(a.ket_I = ' ','&nbsp', a.ket_I) AS ket_I, IF(a.ket_E = ' ','&nbsp', a.ket_E) AS ket_E
					, IF(a.ket_R = ' ','&nbsp', a.ket_R) AS ket_R FROM $dbaskep.ask_soap a INNER JOIN b_pelayanan b ON a.pelayanan_id = b.id
					INNER JOIN b_kunjungan ab ON b.kunjungan_id = ab.id
					WHERE ab.id = '".$rwKunj['id']."' ORDER BY a.tgl";
					// echo $qsoap."<br/>";
                    $rsqsoap=mysql_query($qsoap);
					$jmlSOAP = mysql_num_rows($rsqsoap);
					if($jmlSOAP > 0){
					$border ='style="border:1px solid #000; padding:2px;"';
				?>
                <table style="border-collapse:collapse; border:1px solid #000; font-size:13px;" cellpadding=0 cellspacing=0 >
                	<tr>
                    	<td <?php echo $border; ?> align="center">S</td>
                        <td <?php echo $border; ?> align="center">O</td>
                        <td <?php echo $border; ?> align="center">A</td>
                        <td <?php echo $border; ?> align="center">P</td>
                        <td <?php echo $border; ?> align="center">I</td>
                        <td <?php echo $border; ?> align="center">E</td>
                        <td <?php echo $border; ?> align="center">R</td>
                    </tr>
                    <?
                    while($rwrsqsoap=mysql_fetch_array($rsqsoap)) {
                        ?>
                        <tr>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_S'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_O'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_A'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_P'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_I'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_E'];?></td>
                            <td <?php echo $border; ?> align="center"><?=$rwrsqsoap['ket_R'];?></td>
                        </tr>
                        <?
                    }
					?>
                </table>
				<?php } ?>&nbsp;
            </td>
            <td class="tableContent" align="left" valign="top">
			<?php
				$i = 1;
				/*$queryAnam = "SELECT a.*, DATE_FORMAT(a.TGL,'%d-%m-%Y %H:%i') AS tgltok, p.nama AS dokter
									FROM anamnese a 
								INNER JOIN b_ms_pegawai p ON p.id = a.PEGAWAI_ID 
								WHERE a.PASIEN_ID = '".$idPasien."' AND snurs = 0 AND DATE_FORMAT(a.TGL,'%Y-%m-%d') = '".$tanggal[0]."'";*/
				$queryAnam = "SELECT a.*, DATE_FORMAT(a.TGL,'%d-%m-%Y %H:%i') AS tgltok, p.nama AS dokter
									FROM anamnese a 
								INNER JOIN b_ms_pegawai p ON p.id = a.PEGAWAI_ID 
								WHERE a.KUNJ_ID = '".$rwKunj['id']."' AND snurs = 0";
				//echo $queryAnam."<br/>";
				$execAnam = mysql_query($queryAnam);
				$jmlA = mysql_num_rows($execAnam);
				if($jmlA > 0){
					$border ='style="border:1px solid #000; padding:2px;"';
			?>
                    <table style="border-collapse:collapse; border:1px solid #000; font-size:13px;" cellpadding=0 cellspacing=0>
                	<tr>
                    	<td <?php echo $border; ?> align="center">No</td>
                        <td <?php echo $border; ?> align="center">Tanggal</td>
                        <td <?php echo $border; ?> align="center">Dokter</td>
                        <td <?php echo $border; ?> align="center">Detil</td>
                    </tr>
                    <?
						while($dtAnam = mysql_fetch_array($execAnam))
						{
							?>
                            <tr>
                                <td <?php echo $border; ?> align="center"><?=$i?></td>
                                <td <?php echo $border; ?> align="center"><?=$dtAnam['tgltok']?></td>
                                <td <?php echo $border; ?> align="center"><?=$dtAnam['dokter']?></td>
                                <td <?php echo $border; ?> align="center"><span onClick="viewResume('<?=$dtAnam['ANAMNESE_ID']?>')" style="color:#03F; cursor:pointer;">Detil</span></td>
                            </tr>
                            <?
							$i++;
						}
					?>
                    </table>
				<?php } ?>
                &nbsp;
            </td>
             <td class="tableContent" align="left" valign="top">
                    <?php
                    $qKeluar="select p.cara_keluar,p.keadaan_keluar from b_pasien_keluar p
                                    where p.kunjungan_id='".$rwKunj['id']."'";
                    //echo $qKeluar."<br/>";
					$rsKeluar=mysql_query($qKeluar);
                    while($rwKeluar=mysql_fetch_array($rsKeluar)) {
                        echo "cara keluar: ".$rwKeluar['cara_keluar']."<br> keadaan keluar: ".$rwKeluar['keadaan_keluar'];
                    }
                    ?>
                &nbsp;
            </td>
        </tr>
            <?php
            $nox++;
        }
        ?>
        <tr>
    <td class="noline" colspan="8" align="center"><button id="save" style="cursor:pointer" onClick="window.open('../rekam_medis/ms_galeri.php?idpasien=<?=$_REQUEST['idPasien']?>&idKunj=<?=$_REQUEST['idKunj']?>&idPel=<?=$_REQUEST['idPel']?>','_blank');" value="simpan" name="save" type="button">
<img width="25" align="absmiddle" height="25" src="../icon/gallery.gif">
 Lihat Galery
</button></td>
		</tr>
    </table>
</td>
</tr>
<tr>
    <td class="noline">&nbsp;</td>
    <td class="noline">&nbsp;</td>
    <td class="noline">&nbsp;</td>
    <td class="noline"></td>
</tr>
<!--tr id="trTombol">            
    <td colspan="4" class="noline" align="center">
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
    </td>
</tr-->
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak Rekam Medis ini?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }
	
	function tampil1(a){
		window.open('../rekam_medis/ms_galeri_new.php?idpasien=<?=$_REQUEST['idPasien']?>&idKunj=<?=$_REQUEST['idKunj']?>&idPel='+a,'_blank');
	}

	function viewResume(a)
	{
		window.open("resumemedis.php?idKunj=<?=$_REQUEST['idKunj']?>&idPel=<?=$_REQUEST['idPel']?>&idPasien=<?=$_REQUEST['idPasien']?>&id_anamnesa="+a);
	}
	
	function viewLabN(a,b)
	{
		window.open("hasil_laborat.php?idKunj="+b+"&idPel="+a);
	}
	
	function cPil(a,b)
	{
		//alert(b);
		a.checked = true;
		b.checked = false;
		
		if(document.getElementById("pil1").checked == true)
		{
			document.getElementById("txtHal").disabled = false;
			document.getElementById("bPil1").disabled = false;
			document.getElementById("txtAwal").disabled = true;
			document.getElementById("tgl1").disabled = true;
			document.getElementById("tgl2").disabled = true;
			document.getElementById("txtAkhir").disabled = true;
			document.getElementById("bPil2").disabled = true;
			document.getElementById("pil2").checked == false;
		}else{
			document.getElementById("txtHal").disabled = true;
			document.getElementById("bPil1").disabled = true;
			document.getElementById("txtAwal").disabled = false;
			document.getElementById("tgl1").disabled = false;
			document.getElementById("tgl2").disabled = false;
			document.getElementById("txtAkhir").disabled = false;
			document.getElementById("bPil2").disabled = false;
			document.getElementById("pil1").checked == false;
		}
	}
	
	function tampil()
	{
		//var tgl1 = document.getElementById("txtAwal").value;
		//var tgl2 = document.getElementById("txtAkhir").value;
		var page = document.getElementById("txtHal").value;
		//alert(tgl1+"\n"+tgl2)
		//window.location = 'rekamMedis.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idPasien=<?=$idPasien?>&tgl1='+tgl1+'&tgl2='+tgl2+'&page='+page;
		window.location = 'rekamMedis.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idPasien=<?=$idPasien?>&page='+page;
	}
	
	function tampil_P()
	{
		var tgl1 = document.getElementById("txtAwal").value;
		var tgl2 = document.getElementById("txtAkhir").value;
		//alert(tgl1+"\n"+tgl2)
		window.location = 'rekamMedis.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idPasien=<?=$idPasien?>&tgl1='+tgl1+'&tgl2='+tgl2;
	}
</script>
<?php 
mysql_close($konek);
?>