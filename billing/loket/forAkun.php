<?php
//////////////untuk akuntansi.jurnal
function forAkun($act,$par,$tipe,$asal,$noBil,$jnsLayanan,$tmpLayanan,$statusPas) {
    //forAkun('add',$tarif_perda.'|'.$tarif_pk($tarif_kso&$tarif_pasien),$tipe); --> kiriman dari registrasi add
    //forAkun('edit',$tarif_perda.'|'.$tarif_pk($tarif_kso&$tarif_pasien),$tipe); --> kiriman dari registrasi edit
    //forAkun('del',$no_billing.'|'.$jenis_layanan.'|'.$unit_id.'|'.$kso_id.'|'.$biaya_perda.'|'.$biaya_pk,$tipe); --> kiriman dari registrasi del
    //$act = aksi yang dilakukan
    //$par = parameter yang dikirim untuk diproses
    //$tipe = merupakan jenis aksi yang akan dilakukan
    //, ex. reg = aksi (add,edit,del) pada akuntansi.jurnal tiap kali ada masukan dari registrasi pasien.
    $par = explode('|',$par);
    /*$noBil = $_REQUEST['noBil'];
    $jnsLayanan = $_REQUEST['jnsLayanan'];
    $tmpLayanan = $_REQUEST['tmpLayanan'];
    $statusPas = $_REQUEST['statusPas'];*/
    if($act == 'del' && count($par) > 1){
	   $noBil = $par[0];
	   $jnsLayanan = $par[1];
	   $tmpLayanan = $par[2];
	   $statusPas = $par[3];
    }
    else{
	   $tarip = $tarif_perda = $par[0];
	   $tarif_kso = $par[1];
	   $tarif_pasien = $par[2];
    }
    
    switch($act) {
        case 'edit':
		  /*$temp = explode('|',get_bcde($jnsLayanan.'|'.$tmpLayanan.'|'.$statusPas));
		  //$b.'|'.$c.'|'.$de.'|'.$uraian
		  $f_temp = explode('|',get_f($tipe.'|'.$statusPas.'|'.$tmpLayanan));
		  $f = explode(chr(1),$f_temp[0]);
		  for($i=0; $i<count($f); $i++){
			 $abcdef = '1'.$temp[0].$temp[1].$temp[2].$f[$i];*/
			 $sql = "delete from akuntansi.jurnal where no_kw = '$noBil'";
			 $rs = mysql_query($sql);
		  //}
		  forAkun('add',$tarif_perda.'|'.$tarif_kso.'|'.$tarif_pasien,$tipe,$asal,$noBil,$jnsLayanan,$tmpLayanan,$statusPas);
		  break;
        case 'add':
            if($tarip > 0) {
                $abcdef = "1";
                //        a b c d e f
                //        a = pendapatan (1)
                //        b = jenis layanan (b_ms_unit.kode_ak)
                //        c = jenis pasien (b_ms_kso.kode_jenis_ak)
                //        d e = tempat layanan (b_ms_unit.kode_ak) [dua digit]
                //        f = 'a' -> untuk registrasi loket, pendapatan tindakan,dll umum / kso -> kejadian tiap ada tindakan
                //        f = 'b' -> untuk registrasi loket pasien kso, biaya perda > biaya kso
                //        f = 'c' -> untuk registrasi loket pasien kso, biaya perda < biaya kso
			 // 		 --b & c hanya insert jika terjadi selisih antara tarif perda & tarif kso
                //        f = 'd' -> untuk pembayaran dari pasien umum -> kejadian bila membayar
			 //		 f = 'f' -> untuk pembayaran dari pasein kso, yang bayar kso / pasien -> kejadian bila membayar
			 
			 //get_bcde return value -> $b.'|'.$c.'|'.$de.'|'.$uraian
			 $temp = explode('|',get_bcde($jnsLayanan.'|'.$tmpLayanan.'|'.$statusPas));
			 $b = $temp[0];
			 $c = $temp[1];
			 $de = $temp[2];
			 $uraian = $temp[3];
			 
			 $temp = explode('|',get_f($tipe.'|'.$statusPas.'|'.$tmpLayanan.'|'.$tarif_perda.'|'.$tarif_kso.'|'.$tarif_pasien));
			 $f = explode(chr(1),$temp[0]);
			 $uraian = explode(chr(1),$temp[1]);
			 for($i=0; $i<count($f); $i++){
				$abcdef = '1'.$b.$c.$de.$f[$i];
				$tarip_dikirim = $tarip;
				$tarif_kso_dikirim = $tarif_kso;
				$tarif_pasien_dikirim = $tarif_pasien;
				if($statusPas != 1 && $tarif_kso > 0){
				    if($f[$i] == 'a'){
					   $tarip_dikirim = $tarip;
					   $tarif_kso_dikirim = $tarip;
					   $tarif_pasien_dikirim = 0;
				    }
				    else if($f[$i] == 'b'){
					   $tarip_dikirim = abs($tarip-$tarif_kso);
					   $tarif_kso_dikirim = abs($tarip-$tarif_kso);
					   $tarif_pasien_dikirim = 0;
				    }
				    else if($f[$i] == 'c'){
					   $tarip_dikirim = abs($tarif_kso-$tarip);
					   $tarif_kso_dikirim = abs($tarif_kso-$tarip);
					   $tarif_pasien_dikirim = 0;
				    }
				}
				insert_toJurnal($noBil,$tarip_dikirim,$abcdef,$uraian[$i],$statusPas,$asal,$tarif_kso_dikirim,$tarif_pasien_dikirim,$tmpLayanan);
			 }
			 
			 /*insert_toJurnal($abcdef,$tarip,$jnsLayanan,$tmpLayanan);
                $temp = explode('|',get_abcdef($jnsLayanan,$tmpLayanan));
                $b = $temp[0];
                $de = $temp[1];
                $uraian = $temp[2];*/
            }
            break;
        case 'del':
		  /*$temp = explode('|',get_bcde($jnsLayanan.'|'.$tmpLayanan.'|'.$statusPas));
		  //$b.'|'.$c.'|'.$de.'|'.$uraian
		  $f_temp = explode('|',get_f($tipe.'|'.$statusPas.'|'.$tmpLayanan));
		  $f = explode(chr(1),$f_temp[0]);
		  for($i=0; $i<count($f); $i++){*/
			 //$abcdef = '1'.$temp[0].$temp[1].$temp[2].$f[$i];
			 $sql = "delete from akuntansi.jurnal where no_kw = '$noBil'";
			 $rs = mysql_query($sql);
		  //}
		  /*
		  $abcdef = '';
            $sql = "delete from akuntansi.jurnal where no_kw = '$par' and no_trans = '$abcdef'";
            $rs = mysql_query($sql);*/
            break;
    }
    /////////////selesai
}

function get_bcde($par){
    //$jnsLayanan.'|'.$tmpLayanan.'|'.$statusPas
    $par = explode('|',$par);
    $sql = "select uj.kode_ak as kode_ak_uj, ut.kode_ak as kode_ak_ut, ut.nama
                    from b_ms_unit uj
                    inner join b_ms_unit ut on uj.id = ut.parent_id
                    where uj.id = '".$par[0]."' and ut.id = '".$par[1]."'";
    $rs = mysql_query($sql);
    $row = mysql_fetch_array($rs);
    $b = $row['kode_ak_uj'];
    $de = $row['kode_ak_ut'];

    $sql = "select kode_jenis_ak from b_ms_kso where id = '".$par[2]."'";
    $rs = mysql_query($sql);
    $row = mysql_fetch_array($rs);
    $c = $row['kode_jenis_ak'];
    mysql_free_result($rs);
    
    return $b.'|'.$c.'|'.$de;
}

function get_f($par){
    $f = '';
    //$par[0] = tipe tindakan, $par[1] = kso
    $par = explode('|',$par);
    //$par[0] = tipe
    //$par[1] = kso
    //$par[2] = unit_id
    //$par[3] = tarif perda
    //$par[4] = tarif kso
    //$par[5] = tarif pasien
    $sql = "select nama
                    from b_ms_unit
                    where id = '".$par[2]."'";
    $rsU = mysql_query($sql);
    $rowU = mysql_fetch_array($rsU);
    if($par[0] == 'reg'){
	   $f = 'a';
	   $uraian = "Pendaftaran Loket: ".$rowU['nama']."";
	   if($par[1] == 1){//umum
		  $f .= chr(1).'d';
		  $uraian .= chr(1)."Pembayaran Loket: ".$rowU['nama']."";
	   }
	   else{//kso
		  if(isset($par[3]) && $par[3]!=$par[4] && $par[4] > 0){
			 $sqlK = "select nama from b_ms_kso where id = '".$par[1]."'";
			 $rsK = mysql_query($sqlK);
			 $rowK = mysql_fetch_array($rsK);
			 if($par[3] > $par[4]){
				$f .= chr(1).'b';
				$uraian .= chr(1)."Pendapatan: selisih tarif (lebih) - ".$rowU['nama']." - ".$rowK['nama']."";
			 }
			 else{
				$f .= chr(1).'c';
				$uraian .= chr(1)."Pendapatan: selisih tarif (kurang) - ".$rowU['nama']." - ".$rowK['nama']."";
			 }
			 mysql_free_result($rsK);
		  }
	   }
    }
    else if($par[0] == 'pay'){
	   if($par[1] == 1){
		  $f = 'd';
	   }
	   else{
		  $f = 'f';
	   }
	   $uraian = "Pembayaran Unit: ".$rowU['nama']."";
    }
    else if($par[0] == 'tind'){
	   $f = 'a';
	   $uraian = "Tindakan Unit: ".$rowU['nama']."";
	   if($par[1] != 1){//kso
		  if(isset($par[3]) && $par[3]!=$par[4] && $par[4] > 0){
			 $sqlK = "select nama from b_ms_kso where id = '".$par[1]."'";
			 $rsK = mysql_query($sqlK);
			 $rowK = mysql_fetch_array($rsK);
			 if($par[3] > $par[4]){
				$f .= chr(1).'b';
				$uraian .= chr(1)."Tindakan: selisih tarif (lebih) - ".$rowU['nama']." - ".$rowK['nama']."";
			 }
			 else{
				$f .= chr(1).'c';
				$uraian .= chr(1)."Tindakan: selisih tarif (kurang) - ".$rowU['nama']." - ".$rowK['nama']."";
			 }
		  }
	   }
    }
    return $f.'|'.$uraian;
}

function insert_toJurnal($noBil,$tarip,$abcdef,$uraian,$kso,$unitPel,$bebanKso,$bebanPas,$unit_id){
    $sql = "SELECT dt.dk,dt.fk_jenis_trans,dt.id_detil_trans,ms.ma_islast,ms.ma_kode,ms.ma_id
    FROM akuntansi.jenis_transaksi jt
    inner join akuntansi.detil_transaksi dt on dt.fk_jenis_trans = jt.jtrans_id
    inner join akuntansi.ma_sak ms on ms.ma_id = dt.fk_ma_sak
    where jt.jtrans_kode = '$abcdef'";
   $rs = mysql_query($sql);
   $k=0;
//   echo $bebanPas.'//////////////'.$bebanKso.'/////////////'.$tarip;
   while($row = mysql_fetch_array($rs)) {
	   $eksekusi = true;
	  $debet = 0;
	  $kredit = 0;
	  $dk = $row['dk'];
	  $fk_trans = $row['fk_jenis_trans'];
	  $fk_last_trans = $row['id_detil_trans'];
	  if($row['ma_islast'] == 1) {
		 $ma_id = $row['ma_id'];
		 if($dk == 'D'){
			 $debet = $tarip;
		 }
		 else{
			 $kredit = $tarip;
		 }
	  }
	  else {
	   $a = substr($abcdef,5,1);
	   if($a == 'a'){
		  //$c = substr($abcdef,2,1);
		  if($kso == 1){
			 /*$sqlKS = "select kode_ak from b_ms_kso where id = $kso";
			 $rsKS = mysql_query($sqlKS);
			 $rowKS = mysql_fetch_array($rsKS);
			 $kode_ak = $rowKS['kode_ak'];*/
                $sqlKS = "select ifnull(unit_ak,kode_ak) as kode_ak from b_ms_unit where id = $unit_id";
			 $rsKS = mysql_query($sqlKS);
			 $rowKS = mysql_fetch_array($rsKS);
			 $kode_ak = $rowKS['kode_ak'];
                if($dk == 'D'){
                     $debet = $tarip;
                }
                else{
                     $kredit = $tarip;
                }
		  }
		  else{//kso
			 if(substr($row['ma_kode'],strlen($row['ma_kode'])-2,2) == '02' && $dk == 'D'){
				//Beban pasien (02)
				if($bebanPas > 0){
				    if($dk == 'D'){
					    $debet = $bebanPas;
				    }
				    else{
					    $kredit = $bebanPas;
				    }
				    
				    $sqlKS = "select kode_ak from b_ms_kso where id = $kso";
				    $rsKS = mysql_query($sqlKS);
				    $rowKS = mysql_fetch_array($rsKS);
				    $kode_ak = $rowKS['kode_ak'];
				}
				else{
				    $eksekusi = false;
				}
			 }
			 else if(substr($row['ma_kode'],strlen($row['ma_kode'])-2,2) == '03' && $dk == 'D'){
				//Beban kso (03)
                    if($bebanKso > 0){
                        if($dk == 'D'){
                             $debet = $bebanKso;
                        }
                        else{
                             $kredit = $bebanKso;
                        }
                        
                        $sqlKS = "select kode_ak from b_ms_kso where id = $kso";
                        $rsKS = mysql_query($sqlKS);
                        $rowKS = mysql_fetch_array($rsKS);
                        $kode_ak = $rowKS['kode_ak'];
                    }
                    else{
                        $eksekusi = false;
                    }
			 }
			 else if($dk == 'K'){
				//Beban kso (03)
				$kredit = $tarip;
				
				$sqlKS = "select ifnull(unit_ak,kode_ak) as kode_ak from b_ms_unit where id = $unit_id";
				$rsKS = mysql_query($sqlKS);
				$rowKS = mysql_fetch_array($rsKS);
				$kode_ak = $rowKS['kode_ak'];
			 }
			 else{
				$eksekusi = false;
			 }
			 
		  }
	   }
	   else if($a == 'b'){
		  //Beban kso (03)
		  if($dk == 'D'){
			  $debet = $bebanKso;
		  }
		  else{
			  $kredit = $bebanKso;
		  }
		  
		  $sqlKS = "select kode_ak from b_ms_kso where id = $kso";
		  $rsKS = mysql_query($sqlKS);
		  $rowKS = mysql_fetch_array($rsKS);
		  $kode_ak = $rowKS['kode_ak'];
    
	   }
	   else if($a == 'c'){
		  //Beban kso (03)
		  if($dk == 'D'){
			  $debet = $bebanKso;
		  }
		  else{
			  $kredit = $bebanKso;
		  }
		  
		  $sqlKS = "select kode_ak from b_ms_kso where id = $kso";
		  $rsKS = mysql_query($sqlKS);
		  $rowKS = mysql_fetch_array($rsKS);
		  $kode_ak = $rowKS['kode_ak'];
		  
	   }
	   else if($a == 'd'){
		  if($kso == 1){
			 if($dk == 'D'){
				 $debet = $tarip;
			 }
			 else{
				 $kredit = $tarip;
			 }
			 
			 $sqlKS = "select kode_ak from b_ms_unit where id = $unitPel";
			 $rsKS = mysql_query($sqlKS);
			 $rowKS = mysql_fetch_array($rsKS);
			 $kode_ak = $rowKS['kode_ak'];
		  }
		  else{
			 $eksekusi = false;
		  }
	   }
	   else if($a == 'e'){
		  if($kso == 1){
			 if($dk == 'D'){
				 $debet = $tarip;
			 }
			 else{
				 $kredit = $tarip;
			 }
			 
			 $sqlKS = "select kode_ak from b_ms_unit where id = $unitPel";
			 $rsKS = mysql_query($sqlKS);
			 $rowKS = mysql_fetch_array($rsKS);
			 $kode_ak = $rowKS['kode_ak'];
		  }
		  else{
			 $eksekusi = false;
		  }
	   }
	   else if($a == 'f'){
		  if(substr($row['ma_kode'],strlen($row['ma_kode'])-2,2) == '02'){
			 //Beban pasien (02)
			 if($bebanPas > 0){
				if($dk == 'D'){
					$debet = $tarip;
				}
				else{
					$kredit = $tarip;
				}
				
				$debet = $bebanPas;
				
				$sqlKS = "select kode_ak from b_ms_kso where id = $kso";
				$rsKS = mysql_query($sqlKS);
				$rowKS = mysql_fetch_array($rsKS);
				$kode_ak = $rowKS['kode_ak'];
			 }
			 else if(substr($row['ma_kode'],strlen($row['ma_kode'])-2,2) == '03'){
				$eksekusi = false;
			 }
			 else{
				if($dk == 'D'){
				    $debet = $tarip;
			    }
			    else{
				    $kredit = $tarip;
			    }
			    
			    $sqlKS = "select kode_ak from b_ms_unit where id = $unitPel";
			    $rsKS = mysql_query($sqlKS);
			    $rowKS = mysql_fetch_array($rsKS);
			    $kode_ak = $rowKS['kode_ak'];

				$eksekusi = false;
			 }
		  }
		  else{
			 $eksekusi = false;
		  }
		  if($dk == 'D'){
			 $sqlKS = "select kode_ak from b_ms_unit where id = $unitPel";
		  }
		  else if($dk == 'K'){
			 $k++;
			 if($k>1){
				$eksekusi = false;
			 }
			 $sqlKS = "select kode_ak from b_ms_kso where id = $kso";
		  }
		  $rsKS = mysql_query($sqlKS);
		  $rowKS = mysql_fetch_array($rsKS);
		  $kode_ak = $rowKS['kode_ak'];
	   }
		 $sql = "select ma_id from akuntansi.ma_sak where ma_kode = '".$row['ma_kode'].""."$kode_ak'";
		 $rs_sak = mysql_query($sql);
		 $row_sak = mysql_fetch_array($rs_sak);
		 $ma_id = $row_sak['ma_id'];
	  }
	  $sql = "select no_trans,no_kw from akuntansi.jurnal where no_trans = (select max(no_trans) from akuntansi.jurnal)";
	  $rsx = mysql_query($sql);
	  $rowx = mysql_fetch_array($rsx);
	  if($rowx['no_kw'] == $noBil){
		 $notrans = $rowx['no_trans'];
	  }
	  else{
		 $notrans = $rowx['no_trans']+1;
	  }
	  if($eksekusi == true){
		  $sql = "insert into akuntansi.jurnal (no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,jenis,fk_trans,fk_last_trans,status)
		  values ($notrans,'$ma_id',curdate(),'$noBil','$uraian',$debet,$kredit,now(),16,'$dk',0,'$fk_trans','$fk_last_trans',0)";
		  mysql_query($sql);
	  }
   }
    mysql_free_result($rs);
}
?>
