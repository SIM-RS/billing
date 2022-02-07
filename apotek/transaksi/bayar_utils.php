<?php 
session_start();
include("../koneksi/konek.php");
$grd = strtolower($_REQUEST["grd"]);

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$tanggal_bayar=$_REQUEST["tanggal_bayar"];
$act=$_REQUEST['act'];

convert_var($grd,$page,$tanggal_bayar);

/*$klf = $_REQUEST['klf'];
$user_id = $_REQUEST['user_id'];
$mtk_id = $_REQUEST['mtk_id'];
$tnd_id = $_REQUEST['tnd_id'];*/
//===============================

switch(strtolower($act))
{
	case 'bayar':
		
			$n = gmdate('n',mktime(date('H')+7));
			$y = gmdate('y',mktime(date('H')+7));
			$kode_awalnya = "KSR".$n.$y;
			$kkk = "select no_transaksi from b_bayar where no_transaksi like '$kode_awalnya%' order by id desc limit 1";
			$cde = mysqli_num_rows(mysqli_query($konek,$kkk));
			if($cde>0)
			{
				$abc = mysqli_fetch_array(mysqli_query($konek,$kkk));
				$last = substr($abc[0],-4)+1;
				$new_nomor = $kode_awalnya."".sprintf('%04d',$last);
			}
			else
			{
				$new_nomor = $kode_awalnya."0001";
			}
			
			
			//=================================
			
			$statusProses = 'Fine';
			
			
			if ($_REQUEST['tipe'] == "1") // UNTUK TITIPAN/DP
			{
				$sqlTambah = "insert into b_bayar (
					  kunjungan_id,
					  kasir_id,
					  nobukti,
					  tgl,
					  dibayaroleh,
					  tagihan,
					  nilai,
					  jaminan_kso,
					  keringanan,
					  titipan,
					  charge,
					  tgl_act,
					  user_act,
					  tipe,
					  shift,
					  tipe_bayar,
					  uang_bayar,
					  no_transaksi
					) 
					values
					  (
						'".$_REQUEST['idKunj']."',
						'".$_REQUEST['idKasir']."',
						'".$_REQUEST['nobukti']."',
						'".$tgl."',
						'".$_REQUEST['dibayaroleh']."',
						0,
						0,
						0,
						0,
						'".$_REQUEST['nilai']."',
						'$v_charge',
						'$tglact',
						'$userId',
						".$_REQUEST['tipe'].",
						".$_REQUEST['shift'].",'$tipe_byr','$uang_bayar','$new_nomor'
					  )";
					   //echo $sqlTambah;
				$rs = mysqli_query($konek,$sqlTambah);
				if(isset($_REQUEST['update_depo_loket']))
				{
					$sql_depo_loket = "update c_deposit_loket set diterima_kasir=1,tgl_diterima=NOW(),user_act='$userId' where kunjungan_id='".$_REQUEST['idKunj']."'";
					mysqli_query($konek,$sql_depo_loket);
				}
			}
			else if ($_REQUEST['tipe'] == "0") //PEMBAYARAN
			{
					  $sqlTambah = "insert into b_bayar (
					  kunjungan_id,
					  kasir_id,
					  nobukti,
					  tgl,
					  dibayaroleh,
					  tagihan,
					  nilai,
					  jaminan_kso,
					  keringanan,
					  titipan,
					  charge,
					  tgl_act,
					  user_act,
					  tipe,
					  shift,
					  tipe_bayar,
					  uang_bayar,no_transaksi
					) 
					values
					  (
						'".$_REQUEST['idKunj']."',
						'".$_REQUEST['idKasir']."',
						'".$_REQUEST['nobukti']."',
						'".$tgl."',
						'".$_REQUEST['dibayaroleh']."',
						'".$_REQUEST['tagihan']."',
						'".$_REQUEST['nilai']."',
						'".$jaminan_kso."',
						'".$_REQUEST['keringanan']."',
						'0',
						'$v_charge',
						'$tglact',
						'$userId',
						".$_REQUEST['tipe'].",
						".$_REQUEST['shift'].",'$tipe_byr','$uang_bayar','$new_nomor'
					  )";
					 // echo $sqlTambah;
				$rs = mysqli_query($konek,$sqlTambah);
				if (mysqli_errno($konek) == 0)
				{
					
					//Jika ada nilai titipan, memasukkan titipan terpakai
					if($_REQUEST['titipan']>0)
					{
						$get_id = mysql_insert_id();
						$d_tit = mysqli_fetch_array(mysqli_query($konek,"select sum(titipan) total_titipan from b_bayar where kunjungan_id='".$_REQUEST['idKunj']."' and tipe=1"));
						
						
						if($_REQUEST['nilai']==0) //titipan lebih besar daripada tagihan
						{
							$titipan_terpakai = $_REQUEST['tagihan'];
							$q_ins = "insert into b_bayar_titipan_terpakai(bayar_id,kunjungan_id,nilai,shift,kasir_id,user_act,tgl_act,dari)values('$get_id','".$_REQUEST['idKunj']."','$titipan_terpakai','".$_REQUEST['shift']."','".$_REQUEST['idKasir']."','$userId',NOW(),'0')";
							mysqli_query($konek,$q_ins);
											
						}
						else
						{
							$titipan_terpakai = $d_tit['total_titipan'];
							$q_ins = "insert into b_bayar_titipan_terpakai(bayar_id,kunjungan_id,nilai,shift,kasir_id,user_act,tgl_act,dari)values('$get_id','".$_REQUEST['idKunj']."','$titipan_terpakai','".$_REQUEST['shift']."','".$_REQUEST['idKasir']."','$userId',NOW(),'0')";
							mysqli_query($konek,$q_ins);
						
						}
					}
					
					if ($_REQUEST['keringanan'] > 0) // JIKA MEMASUKKAN VOUCHER (keringanan tidak 0)
					{
						if (isset($_REQUEST['chk']))
						{
							//echo count($_REQUEST['terpakai_keringanan']);
							$n=0;
							foreach($_REQUEST['chk'] as $id_voucher)
							{
								$terpakai = str_replace(",","",$_REQUEST['terpakai_keringanan'][$id_voucher]);
								//$q_up = "update b_voucher set terpakai='$terpakai' where id='$id_voucher'";
								$q_up = "insert into b_voucher_pakai(b_voucher_id,terpakai)values('$id_voucher','$terpakai')";
								//echo $q_up;
								mysqli_query($konek,$q_up);
								$n++;
							}
						}
					}
					if ($_REQUEST['titipan'] > 0)
					{
						$sql = "select 
							  * 
							from
							  b_bayar 
							where kunjungan_id = '".$_REQUEST['idKunj']."' 
							  and kasir_id = '".$_REQUEST['idKasir']."' 
							  and titipan_terpakai < titipan 
							  and tipe = 1 
							order by id ";
						$rs = mysqli_query($konek,$sql);
						$titipan = $_REQUEST['titipan'];
						$ok = "false";
						
						while (($rows = mysqli_fetch_array($rs)) && ($ok == "false"))
						{
							$cid = $rows['id'];
							$ctitip = $rows['titipan'] - $rows['titipan_terpakai'];
							if ($titipan <= $ctitip)
							{
								$ok = "true";
								$sql = "update 
									  b_bayar 
									set
									  titipan_terpakai = titipan_terpakai + $titipan 
									where id = $cid";
							}
							else
							{
								$titipan = $titipan - $ctitip;
								$sql = "update 
									  b_bayar 
									set
									  titipan_terpakai = titipan_terpakai + $ctitip 
									where id = $cid";
							}
							//$rs1 = mysqli_query($konek,$sql);
						}
					}
						
					$sqlBayar = "select 
						  * 
						from
						  b_bayar 
						where kunjungan_id = '".$_REQUEST['idKunj']."' 
						  and nobukti = '".$_REQUEST['nobukti']."' 
						  and user_act = $userId 
						order by id desc 
						limit 1";
					$rsBayar = mysqli_query($konek,$sqlBayar);
					echo mysqli_error($konek);
					
					if (mysqli_num_rows($rsBayar) > 0)
					{
						$rwBayar = mysqli_fetch_array($rsBayar);
						$idBayar = $rwBayar['id'];
						
						if ($_REQUEST['jenisKasir'] == '0')
						{
							$idUnitAmbulan = 0;
							$idUnitJenazah = 0;
							$sql = "SELECT * FROM b_ms_reference WHERE stref=26"; //echo $sql;
							$rsRef = mysqli_query($konek,$sql);
							echo mysqli_error($konek);
							if ($rwRef = mysqli_fetch_array($rsRef)) $idUnitAmbulan = $rwRef["nama"];

							$sql = "SELECT * FROM b_ms_reference WHERE stref=27";
							$rsRef = mysqli_query($konek,$sql);
							echo mysqli_error($konek);
							if ($rwRef = mysqli_fetch_array($rsRef)) $idUnitJenazah = $rwRef["nama"];
						
							if ($bayarIGD == "0")
							{
								$sqlTind = "select 
									  t.* 
									from
									  b_tindakan t 
									  inner join b_pelayanan p 
										on t.pelayanan_id = p.id 
									  inner join b_ms_unit mu 
										on p.unit_id = mu.id 
									where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and (
										p.unit_id = 45 
										or p.unit_id_asal = 45
									  ) 
									  and p.unit_id <> $idUnitAmbulan 
									  and p.unit_id <> $idUnitJenazah 
									  and mu.inap = 0 
									  and t.bayar_pasien < (t.biaya_pasien * t.qty) 
									order by t.tgl_act ";
							}
							else if ($bayarIGD == "2")
							{
								$sqlTind = "select 
									  t.* 
									from
									  b_tindakan t 
									  inner join b_pelayanan p 
										on t.pelayanan_id = p.id 
									  inner join b_ms_unit mu 
										on p.unit_id = mu.id 
									where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and p.unit_id = $idUnitAmbulan 
									  and mu.inap = 0 
									  and t.bayar_pasien < (t.biaya_pasien * t.qty) 
									order by t.tgl_act ";
							}
							else if ($bayarIGD == "3")
							{
								$sqlTind = "select 
									  t.* 
									from
									  b_tindakan t 
									  inner join b_pelayanan p 
										on t.pelayanan_id = p.id 
									  inner join b_ms_unit mu 
										on p.unit_id = mu.id 
									where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and p.unit_id = $idUnitJenazah 
									  and mu.inap = 0 
									  and t.bayar_pasien < (t.biaya_pasien * t.qty) 
									order by t.tgl_act ";
							}
							else
							{
								if ($_REQUEST['idKasir'] == 127)
								{
									$sqlTind = "select 
										  t.* 
										from
										  b_tindakan t 
										  inner join b_pelayanan p 
											on t.pelayanan_id = p.id 
										  inner join b_ms_unit mu 
											on p.unit_id = mu.id 
										where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
										  and p.unit_id <> $idUnitAmbulan 
										  and p.unit_id <> $idUnitJenazah 
										  and t.ms_tindakan_kelas_id = 7513 
										  and t.bayar_pasien < (t.biaya_pasien * t.qty) 
										order by t.tgl_act ";
								}
								else
								{
									$sqlTind = "select 
										  t.* 
										from
										  b_tindakan t 
										  inner join b_pelayanan p 
											on t.pelayanan_id = p.id 
										  inner join b_ms_unit mu 
											on p.unit_id = mu.id 
										where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
										  and p.unit_id <> $idUnitAmbulan 
										  and p.unit_id <> $idUnitJenazah 
										  and t.bayar_pasien < (t.biaya_pasien * t.qty) 
										order by t.tgl_act ";
								} //echo $sqlTind;
							}
						}
						else
						{
							$sqlTind = "select 
								  * 
								from
								  b_tindakan 
								where pelayanan_id = '".$_REQUEST['idPel']."' 
								  and (biaya_pasien * qty) > bayar_pasien 
								order by tgl_act ";
						}
						
						$rsTind = mysqli_query($konek,$sqlTind);
						echo mysqli_error($konek);
						$ok = 'true';
						$nilai = $_REQUEST['nilai'] + $_REQUEST['titipan'];
						$keringanan = ($_REQUEST['keringanan'] == "") ? 0 : $_REQUEST['keringanan']; //echo $keringanan;

						while(($rwTind = mysqli_fetch_array($rsTind)) && ($ok == 'true'))
						{
							$tindId = $rwTind['id'];
							$kso_id = $rwTind['kso_id'];
							//$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
							
							$biaya = 0;
							foreach ($formTindakan as $form)
							{
								if ($tindId == $form['id'] 
									&& $form['kamar'] == 0
									&& isset($form['bayar2']))
								{
									$biaya = (integer) $form['bayar2'];
									break;
								}
								if ($tindId == $form['id'] && $form['admin'] == 1)
								{
									$biaya = (integer) $form['bayar2'];
									$upd = "update b_tindakan set biaya='{$form['bayar2']}', biaya_pasien='{$form['bayar2']}' where id={$form['id']}"; 
									//echo $upd;
									mysqli_query($konek,$upd);
									break;
								}
							}
														
							$nilai = $nilai - $biaya;
							if ($nilai >= 0)
							{
								$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai) VALUES('$idBayar','$tindId','$kso_id','$biaya')";
								//echo $sqlIn."<br>1";
								$rsIn = mysqli_query($konek,$sqlIn);
								echo mysqli_error($konek);
								
								if (mysqli_errno($konek) == 0)
								{
									$sqlUp = "UPDATE b_tindakan SET lunas = if((bayar + $biaya) = biaya*qty, 1, 0),bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya 
										 WHERE id = $tindId";
									//echo $sqlUp;
									$rsUp = mysqli_query($konek,$sqlUp);
									echo mysqli_error($konek);
									
									$lunas0 = "UPDATE b_tindakan SET lunas = 1 where id = $tindId and biaya=0 and ms_tindakan_kelas_id<>3719";
									//echo $lunas0;
									$update_0 = mysqli_query($konek,$lunas0);
								}
								else
								{
									$ok = 'false';
									$statusProses = 'Error';
								}
							}
							else
							{
								//$lunas = 0;
								if (($nilai + $keringanan) >= 0)
								{
									//$lunas = 1;
									$keringanan = $keringanan + $nilai;
								}
								$nilai = $nilai + $biaya;
								
								$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai) VALUES('$idBayar','$tindId','$kso_id','$nilai')";
								//echo $sqlIn."<br>2";
								$rsIn = mysqli_query($konek,$sqlIn);
								echo mysqli_error($konek);
								
								if (mysqli_errno($konek) == 0)
								{
									$sqlUp = "UPDATE b_tindakan SET lunas = if((bayar + $nilai) = biaya*qty, 1, 0),bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai" //lunas = $lunas 
										. "  WHERE id = $tindId";
									//echo $sqlUp;
									$rsUp = mysqli_query($konek,$sqlUp);
									echo mysqli_error($konek);
									
									
								}
								else
								{
									$ok = 'false';
									$statusProses = 'Error';
								}
								
								$nilai = 0;
							}
						}
						
						if ($ok == 'true')
						{
							//============ tambahan ==============
							foreach ($formTindakan as $form)
							{
								if ($tindId == $form['id'] 
									&& $form['kamar'] == 0
									&& isset($form['bayar2']))
								{
									$biaya = (integer) $form['bayar2'];
								}
								if ($tindId == $form['id'] && $form['admin'] == 1)
								{
									$biaya = (integer) $form['bayar2'];
											
									$upd = "update b_tindakan set biaya='{$form['bayar2']}', biaya_pasien='{$form['bayar2']}', bayar='{$form['bayar2']}' where id={$form['id']}"; 
									//echo $upd;
									mysqli_query($konek,$upd);
								}
								//echo $form['klf']."aaa";
								if($form['klf']==7 && ($form['bayar2']!=0 or $form['bayar2']!='')) // bayar karcis
								{
									$sql_jaspel = "select JASPEL from $rssh_db_hcr.pegawai where PEGAWAI_ID='$form[user_id]'";
									$tipe_jaspel = mysqli_fetch_array(mysqli_query($konek,$sql_jaspel));
									$jaspelnya = $tipe_jaspel['JASPEL'];
									
									
									$aaa = mysqli_fetch_array(mysqli_query($konek,"select nama from b_ms_komponen where id='$jaspelnya'"));
									$bbb = mysqli_fetch_array(mysqli_query($konek,"SELECT * FROM b_ms_tindakan_komponen WHERE ms_tindakan_kelas_id='$form[mtk_id]' AND ms_komponen_id='$jaspelnya'"));
									if($bbb['tarip']!=0)
									{
										$sql_ins_kmp = "insert into b_tindakan_komponen(tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen)
										values($form[id],'$jaspelnya','$aaa[nama]','$bbb[tarip]','$bbb[tarip_prosen]')";
										mysqli_query($konek,$sql_ins_kmp);
										echo mysqli_error($konek);
									}
								}
							}
							//==================================
							if ($_REQUEST['jenisKasir'] == '0')//sini
							{
								$sqlTind = "insert into b_bayar_tindakan (
									  bayar_id,
									  tindakan_id,
									  kso_id,
									  nilai,
									  tipe
									) 
									select 
									  $idBayar,
									  id,
									  kso_id,
									  0,
									  0 
									from
									  b_tindakan 
									where kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and biaya_pasien = 0 
									  and id not in 
									  (select 
										tindakan_id 
									  from
										b_bayar_tindakan bt 
										inner join b_bayar b 
										  on bt.bayar_id = b.id 
									  where b.kunjungan_id = '".$_REQUEST['idKunj']."' 
										and bt.kso_id <> kso_id) 
									order by tgl_act";
								$rsTind = mysqli_query($konek,$sqlTind);
								echo mysqli_error($konek);
								
								//
								
								
							}
							else
							{
								$sqlTind = "insert into b_bayar_tindakan (
									  bayar_id,
									  tindakan_id,
									  kso_id,
									  nilai,
									  tipe
									) 
									select 
									  $idBayar,
									  id,
									  kso_id,
									  0,
									  0 
									from
									  b_tindakan 
									where kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and pelayanan_id = '".$_REQUEST['idPel']."' 
									  and biaya_pasien = 0 
									order by tgl_act"; 
								$rsTind = mysqli_query($konek,$sqlTind);
								echo mysqli_error($konek);
							}
							//echo $sqlTind."<br>4";
							
							if(($_REQUEST['jenisKasir'] == '0') && ($bayarIGD == "1"))
							{
								$sqlkamar = "select 
									  * 
									from
									  (select 
										b.id,
										b.kso_id,
										if(b.tgl_out is null, 0, 1) as tgl_out,
										if(
										  b.status_out = 0,
										  (
											if(
											  datediff(ifnull(tgl_out, now()), tgl_in) = 0,
											  1,
											  datediff(ifnull(tgl_out, now()), tgl_in)
											)
										  ) * beban_pasien - bayar,
										  (
											if(
											  datediff(ifnull(tgl_out, now()), tgl_in) = 0,
											  0,
											  datediff(ifnull(tgl_out, now()), tgl_in)
											)
										  ) * beban_pasien - bayar
										) as biaya,
										if(
										  b.status_out = 0,
										  (
											if(
											  datediff(ifnull(tgl_out, now()), tgl_in) = 0,
											  1,
											  datediff(ifnull(tgl_out, now()), tgl_in)
											)
										  ),
										  (
											if(
											  datediff(ifnull(tgl_out, now()), tgl_in) = 0,
											  0,
											  datediff(ifnull(tgl_out, now()), tgl_in)
											)
										  )
										) as qty_hari 
									  from
										b_tindakan_kamar b 
										inner join b_pelayanan p 
										  on b.pelayanan_id = p.id 
									  where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
										and beban_pasien > 0 
										and b.aktif = 1) as t 
									where t.biaya > 0";
								$rsKamar = mysqli_query($konek,$sqlkamar);
								echo mysqli_error($konek);

								$isInap = 1;
								while(($rwKamar = mysqli_fetch_array($rsKamar)) && ($ok == 'true'))
								{
									$isInap = 1;
									$tglout = "";
									$tindId = $rwKamar['id'];
									$kso_id = $rwKamar['kso_id'];
									//$biaya = $rwKamar['biaya'];
									
									$biaya = 0;
									foreach ($formTindakan as $form)
									{
										if ($tindId == $form['id'] 
											&& $form['kamar'] == 1 
											&& isset($form['bayar2']))
										{
											$biaya = (integer) $form['bayar2'];
											break;
										}
										
										if ($tindId == $form['id'] && $form['admin'] == 1)
										{
										$biaya = (integer) $form['bayar2'];
										$upd = "update b_tindakan set biaya='{$form['bayar2']}', biaya_pasien='{$form['bayar2']}' where id={$form['id']}"; 
										//echo $upd;
										mysqli_query($konek,$upd);
											break;
										}
									}
									
									$nilai = $nilai - $biaya;
									//echo $nilai;
									$lama_inap = mysqli_num_rows(mysqli_query($konek,"select count(tgl) from b_tindakan_kamar_detail where tindakan_kamar_id='$tindId'"));
									$qx = "SELECT (select count(tgl) from b_tindakan_kamar_detail where tindakan_kamar_id='$tindId')*tarip tk from v_biaya_kamar where id='$tindId'";
									$total_kmr = mysqli_fetch_array(mysqli_query($konek,$qx));
									
									if($nilai >= 0 )
									{
										//if ($rwKamar['tgl_out'] == 0) $tglout = ",tgl_out=now()";
										$tglout = "";
										
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) VALUES('$idBayar','$tindId','$kso_id','$biaya','1')";
										//echo $sqlIn."<br>5";
										$rsIn = mysqli_query($konek,$sqlIn);
										echo mysqli_error($konek);
										
										if (mysqli_errno($konek) == 0)
										{
											$sqlUp = "UPDATE b_tindakan_kamar SET lunas = if((bayar + $biaya) = $total_kmr[0], 1, 0),bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya" //lunas = 1
												. " ".$tglout." WHERE id = $tindId";
											//echo $sqlUp;
											$rsUp = mysqli_query($konek,$sqlUp);
											echo mysqli_error($konek);
										}
										else
										{
											$ok = 'false';
											$statusProses='Error';
										}
									}
									else
									{
										//$lunas=0;
										if (($nilai + $keringanan) >= 0)
										{
											//$lunas = 1;
											//$tglout = ",tgl_out=now()";
											$tglout = "";
											$keringanan = $keringanan + $nilai;
										}
										$nilai = $nilai + $biaya;
										
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) VALUES('$idBayar','$tindId','$kso_id','$nilai','1')";
										//echo $sqlIn."<br>6";
										$rsIn = mysqli_query($konek,$sqlIn);
										echo mysqli_error($konek);
										
										if (mysqli_errno($konek) == 0)
										{
											$sqlUp = "UPDATE b_tindakan_kamar SET lunas = if((bayar + $nilai) = $total_kmr[0], 1, 0),bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai" //lunas = $lunas"
												. "" . $tglout." WHERE id = $tindId";
											//echo $sqlUp."ee";
											$rsUp = mysqli_query($konek,$sqlUp);
											echo mysqli_error($konek);
										}
										else
										{
											$ok = 'false';
											$statusProses='Error';
										}
									}
								}
								
								$sql = "update 
									  b_tindakan_kamar tk 
									  inner join b_pelayanan p 
										on tk.pelayanan_id = p.id set tk.tgl_out = now() 
									where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
									  and tk.aktif = 1 
									  and tk.tgl_out is null";
								$rsIn = mysqli_query($konek,$sql);
								echo mysqli_error($konek);
								
								$sql = "select 
									  k.id 
									from
									  b_kunjungan k 
									  inner join b_pelayanan p 
										on k.id = p.kunjungan_id 
									  inner join b_ms_unit mu 
										on p.unit_id = mu.id 
									where k.id = '".$_REQUEST['idKunj']."' 
									  and mu.inap = 1 
									  and p.dilayani > 0 
									  and k.tgl_pulang is null";
								$rsIn = mysqli_query($konek,$sql);
								echo mysqli_error($konek);
								
								if (mysqli_num_rows($rsIn) > 0)
								{
								}
								
								if ($ok == 'true')
								{
									$sql = "insert into b_bayar_tindakan (
										  bayar_id,
										  tindakan_id,
										  kso_id,
										  nilai,
										  tipe
										) 
										select 
										  $idBayar,
										  b.id,
										  b.kso_id,
										  0,
										  1 
										from
										  b_tindakan_kamar b 
										  inner join b_pelayanan p 
											on b.pelayanan_id = p.id 
										where p.kunjungan_id = '".$_REQUEST['idKunj']."' 
										  and beban_pasien = 0";
										  //echo $sql."<br>7";
									$rsIn = mysqli_query($konek,$sql);
									echo mysqli_error($konek);
								}
							}
						}
					}
					else $statusProses = 'Error';
				}
				else $statusProses = 'Error';
			}
			
							$update_0 = "UPDATE b_tindakan SET lunas = 1 where kunjungan_id = ".$_REQUEST['idKunj']." and biaya=0";
							//echo $update_0."<br>";
							mysqli_query($konek,$update_0);
							
							$q_km = "SELECT id FROM v_biaya_kamar WHERE kunjungan_id = '".$_REQUEST['idKunj']."' AND jml_hr = 0 and lunas = 0 AND (tgl_in IS NULL OR tgl_in='')";
							$s_km = mysqli_query($konek,$q_km);
							while($d_km = mysqli_fetch_array($s_km))
							{
								$update_0 = "UPDATE b_tindakan_kamar SET lunas = 1 where id='$d_km[id]'";
								//echo $update_0."<br>";
								mysqli_query($konek,$update_0);
							}
							
			break;
	case 'hapus':
		$sql = "select nobukti, titipan from b_bayar where id = {$_REQUEST['rowid']}";
		$query = mysqli_query($konek,$sql);
		$row = mysql_fetch_assoc($query);
		$nobukti = $row['nobukti'];
		$titipan = $row['titipan'];
		
		if ($titipan > 0)
		{
			$sql = "update b_bayar set titipan_terpakai = 0 where titipan = '{$titipan}' and nobukti = '{$nobukti}' and tipe = 1";
			//mysqli_query($konek,$sql);
		}
		
		$sqlHapus="delete from b_bayar where id='".$_REQUEST['rowid']."'";
		mysqli_query($konek,$sqlHapus);
		$sqlHapus="UPDATE b_tindakan t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=0 AND bt.nilai>0";
		mysqli_query($konek,$sqlHapus);
		$sqlHapus="UPDATE b_tindakan_kamar t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=1 AND bt.nilai>0";
		mysqli_query($konek,$sqlHapus);
		
		$abc = mysqli_fetch_array(mysqli_query($konek,"SELECT b.`id` FROM b_bayar_tindakan AS a INNER JOIN b_tindakan_komponen AS b ON b.`tindakan_id`=a.`tindakan_id` WHERE bayar_id='".$_REQUEST['rowid']."'"));
		$sql_hapus_komponen = "delete from b_tindakan_komponen where id=$abc[id]";
		mysqli_query($konek,$sql_hapus_komponen);
		
		$sqlHapus="delete from b_bayar_tindakan where bayar_id='".$_REQUEST['rowid']."'";
		mysqli_query($konek,$sqlHapus);
		
		$sqlHapus_titipan="delete from b_bayar_titipan_terpakai where bayar_id='".$_REQUEST['rowid']."'";
		mysqli_query($konek,$sqlHapus_titipan);
		
		$sqlUpdate_titipan_loket="update c_deposit_loket set diterima_kasir=0,tgl_diterima=NULL,user_act=NULL where kunjungan_id='".$_REQUEST['idKunj']."'";
		mysqli_query($konek,$sqlUpdate_titipan_loket);
		
		break;
	case 'simpan':
		$sqlSimpan="update b_bayar set kunjungan_id='".$_REQUEST['idKunj']."',kasir_id='".$_REQUEST['idKasir']."',tgl='".$tgl."',dibayaroleh='".$_REQUEST['dibayaroleh']."',nobukti='".$_REQUEST['nobukti']."',nilai='".$_REQUEST['nilai']."',tgl_act='$tglact',user_act='$userId' where id='".$_REQUEST['idBayar']."'";		
		$rs=mysqli_query($konek,$sqlSimpan);
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	$user=$_SESSION["iduser"];
	$user_byr=" AND aku.`USER_ID`=$user";
	$GroupUser = array(1);
	if(in_array($userGroup, $GroupUser)){
		$user_byr = "";
	}
	
	if(strtolower($grd) == "true")
	{
		
		$sql = "SELECT aku.ID id,DATE_FORMAT(aku.`TGL_BAYAR`,'%d-%m-%Y %H:%i:%s') tanggal, aku.`NO_BAYAR` nobayar, aku.`NORM` norm, ap.`NAMA_PASIEN` namapasien, aku.`TOTAL_HARGA` nilai, au.`username` kasir,
			DATE_FORMAT(aku.`TGL_BAYAR`,'%d-%m-%Y') tanggal_bayar,aku.`USER_ID` iduser, ap.CARA_BAYAR
			FROM a_kredit_utang aku
			LEFT JOIN a_penjualan ap ON (aku.`NORM`=ap.`NO_PASIEN` AND aku.`FK_NO_PENJUALAN`=ap.`NO_PENJUALAN`)
			INNER JOIN a_user au ON aku.`USER_ID` = au.`kode_user`
			WHERE DATE_FORMAT(aku.`TGL_BAYAR`,'%d-%m-%Y')='$tanggal_bayar'
			$user_byr
			GROUP BY nobayar order by id desc ";
	}

	
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	$perpage = 100;
    $jmldata=mysqli_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";
	//echo $sql;

	//echo $sql;
	
	$rs=mysqli_query($konek,$sql);
	$i=($page-1)*$perpage;
	$dt=$totpage.chr(5);
	$sum_nilai = 0;

		while ($rows=mysqli_fetch_array($rs))
		{
			$i++;
			
			$sisipan = $rows["id"]."|".$rows["tanggal"]."|".$rows["nobayar"]."|".$rows["norm"]."|".$rows["namapasien"]."|".$rows["nilai"]."|".$rows["kasir"];
			if($rows["CARA_BAYAR"] <> '1'){
				$no_bukti = "<span lang='".$rows["nobayar"]."' onclick='hapus(this.lang)'> <img src='../icon/hapus.gif'></span>";
			} else {
				$no_bukti = "-";
			}
			$dt.=$sisipan.chr(3).$i.chr(3).$rows["tanggal"].chr(3).$rows["nobayar"].chr(3).$rows["norm"].chr(3).$rows['namapasien'].chr(3).number_format($rows['nilai'],2,",",".").chr(3).$rows['kasir'].chr(3).$no_bukti.chr(6);
			
			$sum_nilai +=$rows["nilai"];
		}//.number_format($i,0,",","")

		 if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*".number_format($sum_nilai,2,",",".");
        $dt=str_replace('"','\"',$dt);
    }
	
		mysqli_free_result($rs);
}
mysqli_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>