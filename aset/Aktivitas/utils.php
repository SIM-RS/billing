<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$sorting1=$_REQUEST["sorting"];
$filter1=$_REQUEST["filter"];
$sorting3=$_REQUEST["sorting"];
$filter3=$_REQUEST["filter"];
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_GET['bln'] and $_GET['ta']<>'')$filter2="where MONTH(tgl_po)=".$_GET['bln']." AND YEAR(tgl_po)=".$_GET['ta']; else $filter2="where MONTH(tgl_po)=$bln AND YEAR(tgl_po)=$thn";
$filter_bon="where MONTH(k.tgl_transaksi)=".$_GET['bln']." AND YEAR(k.tgl_transaksi)=".$_GET['ta']; if($_GET['bln'] and $_GET['ta']=='') $filter_bon="where MONTH(k.tgl_transaksi)=$bln AND YEAR(k.tgl_transaksi)=$thn";
$pilihan = $_REQUEST['pilihan'];
$defaultsort = 'id';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$idunit=$_SESSION["userid"];
$bln=$_REQUEST['bln'];
if ($bln=="")
    $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$thn=$_REQUEST['thn'];
if ($thn=="")
    $thn=$th[2];
$minta_id=$_REQUEST['minta_id'];
$idRekanan = $_REQUEST['idRekanan'];
$tglFilter = tglSQL($_REQUEST['tglTagihan']);
//utils.php?pilihan=opname&tglTagihan=03-03-2011&act=Tambah_opname&id=&qty=10&harga=50002154&barang_id=4499&usr_id=1
$usr_id = $_REQUEST['usr_id'];
$barang_id = $_REQUEST['barang_id'];
$qty = $_REQUEST['qty'];
$harga = $_REQUEST['harga'];
$id = $_REQUEST['id'];
$satuan = $_REQUEST['satuan'];
$tgl1=$_REQUEST['tgl'];
$tgl1=explode("-",$tgl1);
$tgl1=$tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
/*$tanah = $_REQUEST["tanah"];
$perolehan = $_REQUEST["perolehan"];*/

//===============================
//echo strtolower($_REQUEST['act']);

switch(strtolower($_REQUEST['act'])) {
    case 'cek_opname':
        $sql = "select opname_id from as_opname where barang_id = '".$barang_id."' and tgl= '".$tgl1."'";
        $rs = mysql_query($sql);
        echo mysql_num_rows($rs);
        mysql_free_result($rs);
        mysql_close($konek);
        return;
        break;
    case 'tambah_opname':
       //$sql = "select sum(sisa) sisa from as_masuk where barang_id = '$barang_id'";
        $sql="select jml_sisa from as_kstok where barang_id = '$barang_id' order by stok_id desc limit 1";
		$rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        $sd = $row['jml_sisa'];
        if($sd == ''){
            $sd = 0;
        }
        $adj = $qty-$sd;
        $par = $tglFilter.'*,*'.$barang_id.'*,*'.$adj.'*,*'.$satuan.'*,*'.$harga;
        for_opname($adj,$par);
		 $sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Stok Opname','insert into as_opname (tgl, tgl_act, usr_id, barang_id, stok_data, stok_opname, stok_adj, aharga) values
            (".$tglFilter.", now(), $usr_id, $barang_id, $sd, $qty, $adj, $harga)','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
					
         $sql = "insert into as_opname (tgl, tgl_act, usr_id, barang_id, stok_data, stok_opname, stok_adj, aharga) values
            ('".$tglFilter."', now(), '$usr_id', '$barang_id', '$sd', '$qty', '$adj', '$harga')";
			
			if ($adj>0) {
			 $sql1="insert into as_kstok (jml_masuk,jml_sisa) values('$adj',$qty) ";
			}
			else {
			 $sql1="insert into as_kstok (jml_keluar,jml_sisa) values('$adj',$qty) ";
			}
			
        mysql_query($sql);
		 mysql_query($sql1);
        break;
    case 'update_opname':
        $sql = "select sum(sisa) sisa from as_masuk where barang_id = '$barang_id'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        $sd = $row['sisa'];
        if($sd == ''){
            $sd = 0;
        }
		$sd;
        $adj = $sd-$qty;
        $par = $tglFilter.'*,*'.$barang_id.'*,*'.$adj.'*,*'.$satuan.'*,*'.$harga;
        for_opname($adj,$par);
        
			$sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Stok Opname','update as_opname set usr_id = $usr_id, barang_id = $barang_id, stok_opname = $qty, stok_data = $sd, stok_adj = $adj, aharga = $harga where opname_id = $id','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns1);
		
          $sql = "update as_opname set usr_id = '$usr_id', barang_id = '$barang_id', stok_opname = '$qty', stok_data = '$sd', stok_adj = '$adj', aharga = '$harga' where opname_id = '$id'";
        mysql_query($sql);
        break;
    /*case 'hapus_opname':
        $sql = "delete from as_opname where opname_id = '".$id."'";
        //$sql = "insert into as_opname (tgl, tgl_act, usr_id, barang_id, stok_data, stok_opname, stok_adj, aharga) values
//            ('".$tglFilter."', now(), '$usr_id', '$barang_id', '0', '0', '0', '$harga')";
        mysql_query($sql);
        break;*/
    case 'hapus_perolehan':
        $sqlHapus = "update as_transaksi set void=1 where idtransaksi='".$_REQUEST['idperolehan']."'";
        mysql_query($sqlHapus);
        /*if(mysql_affected_rows() > 0) {
            echo "<script> alert('Sukses : VOID telah dilakukan'); </script>";
        }*/
        break;
		case 'hapus_opnameinv':
		$sqlIns4="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete OPname Inventaris Ke Inv_opname','delete from inv_opname where opname_id = $_REQUEST[opname_id]','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns4);
        $sqlHapus1 = "delete from inv_opname where opname_id = ".$_REQUEST['opname_id']."";
        mysql_query($sqlHapus1);
        break;
    case 'hapus_pemakaian':
        $sqlRecover = "select id_lama,qty_stok from as_penerimaan where id = '".$_GET['id']."'";
        $rs = mysql_query($sqlRecover);
        if(mysql_affected_rows() > 0) {
            $row = mysql_fetch_array($rs);
            $sqlRecover = "update as_penerimaan set qty_stok = qty_stok+".$row['qty_stok']." where id = ".$row['id_lama'];
            mysql_query($sqlRecover);
            $sqlHapus = "delete from as_penerimaan where id = ".$_GET['id'];
            mysql_query($sqlHapus);
            /*if(mysql_affected_rows()>0) {
                echo "<script>alert('Data berhasil dihapus.');</script>";
            }*/
        }
        break;
	case 'tagihan':
		$sqlCek = "SELECT kwi FROM as_po WHERE no_po = '".$_REQUEST['noPo']."' ";
		$rsCek=mysql_query($sqlCek);
			if(mysql_num_rows($rsCek['kwi'])==0){
				$sqlTambah="UPDATE as_po SET kwi = '1' WHERE no_po = '".$_REQUEST['noPo']."'";
				$rs=mysql_query($sqlTambah);
			}
			echo $sqlCek;
			echo $sqlTambah;
		break;
	
}

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

//p.unit_id_terima = '$idunit' AND
//.$filter." ORDER BY ".$sorting
switch($pilihan) {
    case 'opname':
       $sql = "select opname_id, date_format(tgl,'%d-%m-%Y') tgl, barang_id, stok_data, stok_opname, stok_adj, aharga, namabarang, kodebarang, idsatuan, tipe
                from as_opname ao inner join as_ms_barang ab on ao.barang_id = ab.idbarang
                where tgl = '$tglFilter' $filter";
        break;
        
    case 'rekanan':
	  
			 $sql = "select * from as_ms_rekanan order by namarekanan ";    
    break;
    case 'perolehan':
    /*$sql = "select at.idtransaksi,refno,kodeunit,kodelokasi,buktino,date_format(tgltransaksi,'%d-%m-%Y') as tgltransaksi
            ,date_format(tglpembukuan,'%d-%m-%Y') as tglpembukuan,tok,idjenistrans,nosk,date_format(tglsk,'%d-%m-%Y') as tglsk
            ,void,at.refidrekanan,namarekanan,kodebarang,namabarang,totalamount,at.idsatuan,at.dasarharga,idcurr,nilaikurs,kondisi,at.idunit
            ,namaunit,at.idlokasi,at.idbarang,idsumberdana,qtytransaksi,hargasatuan
            from as_transaksi at inner join as_ms_unit au on at.idunit = au.idunit
            inner join as_ms_barang ab on at.idbarang = ab.idbarang
            left join as_lokasi al on at.idlokasi = al.idlokasi
            left join as_ms_rekanan ar on at.refidrekanan = ar.idrekanan
            left join as_kib ak on at.idtransaksi = ak.idtransaksi";*/
          $sql = "SELECT at.idtransaksi,kodeunit,date_format(tgltransaksi,'%d-%m-%Y') as tgltransaksi,tok,idjenistrans,kodebarang,namabarang,totalamount,namalokasi,refno,qtytransaksi
                FROM as_transaksi at inner join as_ms_unit au on at.idunit=au.idunit
                inner join as_kib ak on at.idtransaksi = ak.idtransaksi
                left join as_lokasi l on at.idlokasi=l.idlokasi
                inner join as_ms_barang ab on at.idbarang = ab.idbarang where void = 0 $filter";
        break;
		case 'opnameInv':
		
		if ($filter1!="") {
    	$filter1=explode("|",$filter1);
    	$filter1=" WHERE ".$filter1[0]." like '%".$filter1[1]."%'";
		}
		if ($sorting1=="") {
            $sorting1='as_ms_barang.kodebarang,inv_opname.noseri';
        }
		
		$sql = "SELECT
			  inv_opname.*,
			  as_ms_barang.idbarang,
			  as_ms_barang.kodebarang,
			  as_ms_barang.namabarang,
			  as_ms_jenistransaksi.idjenistrans,
			  as_ms_jenistransaksi.keterangan,
			  u.namaunit,al.namalokasi,
			  u.kodeunit
			FROM inv_opname
			  INNER JOIN as_ms_barang
				ON as_ms_barang.idbarang = inv_opname.idbarang
			  INNER JOIN as_ms_jenistransaksi
				ON as_ms_jenistransaksi.idjenistrans = inv_opname.idjenistrans
			  LEFT JOIN as_ms_unit u ON inv_opname.idunit=u.idunit
			  LEFT JOIN as_lokasi al ON inv_opname.idlokasi=al.idlokasi $filter1 order by $sorting1";
		break;
		
		case 'kibGedung' :
		if ($filter3!="") {
    	$filter3=explode("|",$filter3);
    	$filter3=" AND ".$filter3[0]." like '%".$filter3[1]."%'";
		}
		if ($sorting3=="") {
            $sorting3='idseri';
        }

		$sql = "SELECT kib03.*,
		as_ms_barang.namabarang,as_ms_barang.kodebarang,as_ms_barang.tipe,
		as_seri2.noseri,as_seri2.kondisi,as_seri2.harga_perolehan,
		as_ms_unit.namaunit,
		as_lokasi.namalokasi
		FROM as_seri2
		INNER JOIN kib03 ON kib03.idseri = as_seri2.idseri
		INNER JOIN as_ms_barang ON as_ms_barang.idbarang = as_seri2.idbarang
		INNER JOIN as_ms_unit ON as_ms_unit.idunit = as_seri2.ms_idunit
		INNER JOIN as_lokasi ON as_lokasi.idlokasi = as_seri2.ms_idlokasi
		WHERE as_ms_barang.tipe=1 AND as_ms_barang.kodebarang LIKE '03%' $filter3 ORDER BY $sorting3";
		
		
		break;
    case 'ruang_tree':
        $r_idunit = $_GET['idunit'];
        $unit = '';
        if(isset($r_idunit) && $r_idunit != '') {
            $unit = " where idunit=$r_idunit ";
        }
        $sql = "select idlokasi,kodelokasi,namalokasi,idgedung,idunit from as_lokasi $unit order by kodelokasi";
        break;
	case 'lokasi_tree':
	 	$sql = "select idlokasi,kodelokasi,namalokasi from as_lokasi";
    	 break;
    case 'barang_tree':
        $sql = "select t.idbarang,kodebarang,namabarang,noseri
            from as_transaksi t inner join as_ms_barang b on t.idbarang = b.idbarang
            inner join as_seri s on t.idtransaksi = s.idtransaksi
            inner join as_kib k on t.idtransaksi = k.idtransaksi
            where idunit = '".$_GET['idunit']."'";
        break;
    case 'po':
      /*  $sql = "select id, ms_barang_id, vendor_id, namarekanan, no_po, date_format(tgl_po,'%d-%m-%Y') as tgl, qty_satuan, satuan, harga_beli_total, harga_beli_satuan
                from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang inner join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                $filter
                ORDER BY $sorting";
	  */
            $sql = "SELECT po.id,date_format(tgl_po,'%d-%m-%Y') as tgl_po,judul,no_po,namarekanan,date_format(exp_kirim,'%d-%m-%Y') exp_kirim,kodebarang,namabarang,satuan,qty_satuan, SUM(qty_satuan*harga_satuan)  AS biaya, SUM(lain2)  AS biaya_lain2
                            FROM as_po po INNER JOIN as_ms_barang brg 
                            ON po.ms_barang_id=brg.idbarang INNER JOIN as_ms_rekanan rek ON po.vendor_id=rek.idrekanan                 
                            $filter2 $filter group by no_po
            ORDER BY $sorting";
    //,tipebarang,qty_kemasan,qty_kemasan_terima
				 //echo $sql;
        break;
    case 'bon':
		$sorting_bon="k.tgl_transaksi,k.kode_transaksi"; if ($sorting=="") $sorting_bon=$sorting;
	  		$sql = "SELECT k.klr_id, k.tgl_transaksi,k.kode_transaksi,namaunit,namalokasi,k.petugas_rtp,k.petugas_unit, k.stt
					FROM as_keluar k INNER JOIN as_ms_barang b ON k.barang_id=b.idbarang 
					LEFT JOIN as_ms_unit u ON k.unit_id=u.idunit
					LEFT JOIN as_lokasi l ON k.lokasi_id=l.idlokasi               
					$filter_bon $filter
                	GROUP BY k.tgl_transaksi,k.kode_transaksi ORDER BY $sorting_bon";
			/*$sql="SELECT k.klr_id, k.tgl_transaksi,k.kode_transaksi,namaunit,namalokasi,k.petugas_rtp,k.petugas_unit, k.stt
					FROM as_keluar k INNER JOIN as_ms_barang b ON k.barang_id=b.idbarang 
					LEFT JOIN as_ms_unit u ON k.unit_id=u.idunit
					LEFT JOIN as_lokasi l ON k.lokasi_id=l.idlokasi               
					$filter_bon $filter
                	GROUP BY k.tgl_transaksi,k.kode_transaksi ORDER BY $sorting_bon";*/
				 //echo $sql;
        	break;    
	case 'penerimaanpo':
        $sql = "select distinct p.id as poid,m.tgl_terima,m.no_gudang,p.no_po,m.no_faktur,r.namarekanan 
from as_masuk m inner join as_po p on m.po_id=p.id
inner join as_ms_rekanan r on r.idrekanan=p.vendor_id
where year(m.tgl_terima)=$thn and month(m.tgl_terima)=$bln
group by m.tgl_terima,m.no_gudang
order by m.tgl_terima,m.no_gudang";
        
        //".$filter."
        break;
		
	case 'penerimaan_po':
		$sql = "select msk.tgl_terima,msk.no_gudang, po.no_po,msk.no_faktur,rek.namarekanan
				from as_masuk msk inner join as_po po on msk.po_id=po.id
				inner join as_ms_barang brg on msk.barang_id=brg.idbarang
				inner join as_ms_rekanan rek on rek.idrekanan=po.vendor_id
				where year(msk.tgl_terima)=2010 and month(msk.tgl_terima)=12
				group by msk.tgl_terima,msk.no_gudang
				order by msk.tgl_terima,msk.no_gudang"	;
			break;
    case 'pemakaian':
        $sql = "select id, ms_barang_id, kodebarang, namabarang, id_lama, fk_minta_id, suplier_id, namaunit
            , unit_id_terima, nokirim, date_format(tgl,'%d-%m-%Y') as tgl, satuan, qty_satuan
            from as_penerimaan ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang
            inner join as_ms_unit au on ap.unit_id_terima = au.idunit
        where tipe_trans = 1 and status = 1 AND MONTH(ap.tgl)=$bln AND YEAR(ap.tgl)=$thn order by ".$sorting;
        break;
		
	case 'keluarbon' :
		$sql = "SELECT k.klr_id,k.tgl_gd AS tglkel,k.no_gd AS no_kel,k.tgl_transaksi AS tgl_transaksi,
                        k.kode_transaksi AS kode_transaksi,l.namalokasi,u.namaunit, k.petugas_gudang, k.petugas_unit 
                        FROM as_keluar k INNER JOIN as_operasi o ON k.klr_id=o.klr_id 
                        LEFT JOIN as_lokasi l ON l.idlokasi=k.lokasi_id 
                        LEFT JOIN as_ms_unit u ON u.idunit=k.unit_id
                        WHERE  MONTH(k.tgl_gd)=$bln AND YEAR(k.tgl_gd)=$thn
			GROUP BY k.tgl_gd,k.no_gd,k.lokasi_id
			ORDER BY k.tgl_gd,k.no_gd,l.namalokasi";
		break;
	 case 'tagihan':
	 $filternm=$_REQUEST['filternm'];
	 if ($filternm!="") {
		$filternm=explode("|",$filternm);
		$filternm=" WHERE ".$filternm[0]." like '%".$filternm[1]."%'";
		}
	 if ($sorting=="") {
            $sorting='id';
        }
	 	if($_REQUEST['idRekanan']!=0) $fRekan = "as_ms_rekanan.idrekanan = '".$idRekanan."' AND";
		 $sql = "SELECT t.id, t.namarekanan, t.tglPo, t.no_po, t.tglFaktur, 
		 t.no_faktur, t.tglTerima, t.no_gudang, t.tglExp, t.jml, t.harga, 
		 t.aharga, sum((100/110)*t.aharga) AS dpp, sum((10/110)*t.aharga) AS ppn, t.kwi 
		 FROM (SELECT as_masuk.po_id as id, as_ms_rekanan.namarekanan, 
		 DATE_FORMAT(as_po.tgl_po,'%d-%m-%Y') AS tglPo, as_po.no_po, 
		 DATE_FORMAT(as_masuk.tgl_faktur,'%d-%m-%Y') AS tglFaktur, as_masuk.no_faktur, 
		 DATE_FORMAT(as_masuk.tgl_terima,'%d-%m-%Y') AS tglTerima, as_masuk.no_gudang,  
		 DATE_FORMAT(as_masuk.exp_bayar,'%d-%m-%Y') AS tglExp, as_masuk.jml_msk AS jml, 
		 as_masuk.harga_unit AS harga, as_masuk.jml_msk*as_masuk.harga_unit AS aharga, 
		 as_po.kwi FROM as_masuk 
		 INNER JOIN as_po ON as_masuk.po_id = as_po.id 
		 INNER JOIN as_ms_rekanan ON as_ms_rekanan.idrekanan = as_po.vendor_id 
		 WHERE $fRekan as_masuk.exp_bayar <= '".$tglFilter."') AS t $filternm GROUP BY t.no_po,t.no_gudang,t.no_faktur order by $sorting ";
		break; 
	case 'dataInventaris';
		$sql = "SELECT * FROM as_seri2 s INNER JOIN as_ms_barang br ON s.idbarang = br.idbarang
					inner join as_ms_unit u on s.ms_idunit = u.idunit
					LEFT JOIN kib01 a on a.idseri = s.idseri
					LEFT JOIN kib02 b on b.idseri = s.idseri
					LEFT JOIN kib03 c on c.idseri = s.idseri
					LEFT JOIN kib04 d on d.idseri = s.idseri
					LEFT JOIN kib05 e on e.idseri = s.idseri
					LEFT JOIN kib06 f on f.idseri = s.idseri
                WHERE br.tipe=1 ".(($_REQUEST['lokasi']=='')?" ":" AND s.ms_idlokasi = '".$_REQUEST['lokasi']."'");
		break;
    /*
    case 'penerimaanbaru':
        $sql = "SELECT po.id, po.ms_barang_id, b.namabarang AS namaobat,
            po.qty_kemasan, po.kemasan, po.harga_kemasan,
            po.qty_satuan, po.satuan, po.harga_beli_satuan, po.harga_beli_total AS subtotal,
            po.diskon
            FROM as_po po
            INNER JOIN as_ms_barang b ON b.idbarang = po.ms_barang_id
            WHERE po.no_po = '".$_REQUEST['nopo']."'
            WHERE b.tipe = 2 ".$filter." ORDER BY ".$sorting;
        break;
    case 'perubahan':
        $sql = 'select idtransaksi, tgltransaksi, tok, at.idunit, at.idlokasi, namalokasi, idjenistrans, at.idbarang, refno, void, kodebarang, namabarang
            from as_transaksi at inner join as_ms_barang ab on at.idbarang=ab.idbarang
            left join as_lokasi al on at.idlokasi=al.idlokasi';
        break;
    case 'penghapusan':
        $sql = "select idtransaksi, date_format(tgltransaksi,'%d-%m-%Y') as tgltransaksi, tok, idunit, idlokasi, idjenistrans, t.idbarang, namabarang, kodebarang, refno, nosk, void  from as_transaksi t inner join as_ms_barang b on t.idbarang = b.idbarang";
        // Security Management
        if ($_SESSION['SIA_AUTH_TYPE']!="A") {
            if ($_SESSION['usertype']=="P")
                $sql .= " where idunit='" . $_SESSION["refidunit"] . "'";
            if ($_SESSION['usertype']=="F")
                $sql .= " where (idunit='" . $_SESSION["refidunit"] . "' or idunit in (select idunit from as_ms_unit where parentunit='" . $_SESSION["refidunit"] . "'))";
        }
        else
            $sql .= " where (1=1) ";

        $sql .= " and (substring(idjenistrans,1,1)='3') ";
        break;*/
}
//echo $sql."<br>";
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

switch($pilihan) {
    case 'opname':
        while($rows = mysql_fetch_array($rs)){
            $i++;
            //opname_id, date_format(tgl,'%d-%m-%Y') tgl, barang_id, stok_data, stok_opname, stok_adj, aharga, namabarang
            $dt .= $rows['opname_id'].'*|*'.$rows['barang_id'].'*|*'.$rows['tipe'].'*|*'.$rows['aharga'].chr(3).number_format($i,0,',','').chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['idsatuan'].chr(3).$rows['stok_data'].chr(3).$rows['stok_opname'].chr(3).$rows['stok_adj'].chr(6);
        }
        break;
    case 'penerimaanpo':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows['poid'].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows['tgl_terima']).chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['no_faktur'].chr(3).$rows['namarekanan'].chr(6);
        }
        break;
    case 'penerimaanbaru':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows['id'].chr(3).number_format($i,0,",","").chr(3).$rows[''].chr(3).$rows['namaobat'].chr(3).$rows[''].chr(3).$rows['qty_kemasan'].chr(3).$rows['kemasan'].chr(3).$rows['harga_kemasan'].chr(3).$rows[''].chr(3).$rows['qty_satuan'].chr(3).$rows['satuan'].chr(3).$rows['harga_beli_satuan'].chr(3).$rows['subtotal'].chr(3).$rows['diskon'].chr(3).$rows[''].chr(6);
        }
        break;
    case 'perolehan':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idtransaksi"].chr(3).$rows["kodeunit"].chr(3).$rows["tgltransaksi"].chr(3).$rows["tok"].chr(3).$rows["idjenistrans"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["qtytransaksi"].chr(3).$rows["refno"].chr(3).$rows["namalokasi"].chr(6);
        }
        break;
		 case 'opnameInv':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["opname_id"].chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["kodebarang"].chr(3).str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT).chr(3).$rows["namabarang"].chr(3).$rows["ket"].chr(3).$rows["thn_beli"].chr(3).$rows["keterangan"].chr(3).number_format($rows["harga_perolehan"],0,',','.').chr(3).number_format($rows["harga_skr"],0,',','.')."&nbsp;".chr(3)."&nbsp;".$rows["namaunit"].chr(3).$rows["namalokasi"].chr(6);
        }
        break;
		case 'kibGedung' :
		while ($rows = mysql_fetch_array($rs)) {
			$i++;
			$dt.=$rows["idseri"].chr(3).$i.chr(3).$rows["dok_tgl"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["alamat"].chr(3).$rows["harga_perolehan"].chr(3).$rows["ket"].chr(6);
		}
		break;
    case 'ruang_tree':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            if($unit == '') {
                $dt.=$rows["idlokasi"].'|'.$rows['idunit'].chr(3).$rows["kodelokasi"].chr(3).$rows["namalokasi"].chr(3).$rows["idgedung"].chr(6);
            }
            else {
                $dt.=$rows["idlokasi"].chr(3).$rows["kodelokasi"].chr(3).$rows["namalokasi"].chr(3).$rows["idgedung"].chr(6);
            }
        }
        break;
		case 'lokasi_tree':
		while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idlokasi'];
		$i++;
		$dt.=$id.chr(3).$rows['kodelokasi'].chr(3).$rows['namalokasi'].chr(6);
	}
	break;
    case 'barang_tree':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows['idbarang'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['noseri'].chr(6);
        }
        break;
    case 'rekanan':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idrekanan"].chr(3).$rows["koderekanan"].chr(3).$rows["namarekanan"].chr(3).$rows["ket"].chr(3).$rows["alamat"].chr(3).$rows["contactperson"].chr(3).$rows["status"].chr(6);
        }
        break;
    case 'po':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
			
            //$dt .= $rows['id'].chr(3).$i.chr(3).$rows['tgl_po'].chr(3).$rows['no_po'].chr(3).$rows['judul'].chr(3).$rows['namarekanan'].chr(3).$rows['exp_kirim'].chr(3).$rows['biaya'].chr(6);
			$dt .= $rows['id'].chr(3).$i.chr(3).$rows['tgl_po'].chr(3).$rows['no_po'].chr(3).$rows['judul'].chr(3).$rows['namarekanan'].chr(3).$rows['exp_kirim'].chr(3).number_format($rows['biaya'],0,",",".").chr(6);
        }
        break;
    case 'bon':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows['klr_id'].chr(3).$i.chr(3).tglSQL($rows['tgl_transaksi']).chr(3).$rows['kode_transaksi'].chr(3).$rows['namaunit'].chr(3).$rows['namalokasi'].chr(3).$rows['petugas_rtp'].chr(3).$rows['petugas_unit'].chr(3).$rows['status'].chr(6);
        }
        break;   
    case 'pemakaian':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows['id'].chr(3).$i.chr(3).$rows['tgl'].chr(3).$rows['nokirim'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['satuan'].chr(3).$rows['namaunit'].chr(3).$rows['qty_satuan'].chr(6);
        }
        break;
    case 'keluarbon':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows['klr_id']."*|*".$rows['petugas_gudang']."*|*".$rows['petugas_unit'].chr(3).$i.chr(3).tglSQL($rows["tglkel"]).chr(3).$rows["no_kel"].chr(3).tglSQL($rows["tgl_transaksi"]).chr(3).$rows["kode_transaksi"].chr(3).$rows["namaunit"]." - ".$rows["namalokasi"].chr(6);
        }
        break;
    case 'tagihan':
		while($rows = mysql_fetch_array($rs)){
			$i++;
			$dt .= $rows['id'].chr(3).$i.chr(3).$rows['namarekanan'].chr(3).$rows['tglPo'].chr(3).$rows['no_po'].chr(3).$rows['tglFaktur'].chr(3).$rows['no_faktur'].chr(3).$rows['no_gudang'].chr(3).$rows['tglTerima'].chr(3).number_format($rows['dpp'],0,",",".").chr(3).number_format($rows['ppn'],0,",",".").chr(3).$rows['tglExp'].chr(3).$rows[''].chr(3).$rows['kwi'].chr(6);
		}
		break;
    case 'dataInventaris':
		while($rows = mysql_fetch_array($rs)){
			$i++;
                        $qlok="select kodelokasi,namalokasi from as_lokasi where idlokasi='".$rows['ms_idlokasi']."'";
                        $rlok=mysql_query($qlok);
                        $wlok=mysql_fetch_array($rlok);
                       $sisipan=$rows['ms_idunit']."|".$rows['ms_idlokasi']."|".$wlok['namalokasi'];
                       $k = $rows["kondisi"];
                       if($k=='B') $k= "Baik";
                       if($k=='RR') $k = "Rusak Ringan";
                       if($k=='RB') $k = "Rusak Berat";
                       if($k=='TB') $k = "Tidak Berfungsi";
						if($k=='KB') $k = "Kurang Baik";
			$dt .= $rows['idseri']."*".$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows['namaunit'].chr(3).$rows['kodebarang'].chr(3).str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT).chr(3).$rows['namabarang'].chr(3).$k.chr(3).$rows['thn_pengadaan'].chr(3).$rows['asalusul'].chr(3).number_format($rows['harga_perolehan'],0,",",".").chr(3).number_format($rows['nilaibuku'],0,",",".").chr(6);
		}
		break;
    /*case 'perubahan':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idtransaksi"].chr(3).$rows["idtransaksi"].chr(3).$rows["idunit"].chr(3).$rows["tgltransaksi"].chr(3).$rows["tok"].chr(3).$rows["idjenistrans"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["refno"].chr(3).$rows["lokasi"].chr(3).$rows["void"].chr(6);
        }
        break;
    case 'penghapusan':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idtransaksi"].chr(3).$rows["idtransaksi"].chr(3).$rows["tgltransaksi"].chr(3).$rows["tok"].chr(3).$rows["idjenistrans"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["refno"].chr(3).$rows["nosk"].chr(3).$rows["void"].chr(6);
        }
        break;*/
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

/*header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}*/
echo $dt;

function for_opname($adj,$par){
    $par = explode('*,*',$par);
    $tglFilter = $par[0];
    $barang_id = $par[1];
    $adj = $par[2];
    $satuan = $par[3];
    $harga = $par[4];
    if($adj >= 0){
        //untuk ke as_masuk
        $sql = "insert into as_masuk (tgl_act,tgl_terima,barang_id,jml_msk,satuan_unit,harga_unit,sisa,adj_opname) values
                (now(), '$tglFilter', '$barang_id', '$adj', '$satuan', '$harga', '$adj', '$adj')";
        mysql_query($sql);

        //untuk ke as_kstok
        $sql = "select jml_sisa, nilai_sisa from as_kstok where barang_id = '$barang_id' order by stok_id desc limit 1";
        $rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        $jml_awal = $row['jml_sisa'];
        if($jml_awal == ''){
            $jml_awal = 0;
        }
        $nilai_awal = $row['nilai_sisa'];
        if($nilai_awal == ''){
            $nilai_awal = 0;
        }
        $sql = "insert into as_kstok (waktu, barang_id, jml_awal, jml_masuk, jml_keluar, jml_sisa, nilai_awal, nilai_masuk, nilai_keluar, nilai_sisa, tipe, ket) values
                (now(), '$barang_id', '$jml_awal', '$adj', 0, '".($jml_awal+$adj)."', '$nilai_awal', '".($harga*$adj)."', 0, '".($nilai_awal+$harga*$adj)."', 0, 'opname')";
        mysql_query($sql);
    }
    else{
        //untuk ke as_masuk
        $tmp_qty = $adj*-1;
        $i = 0;
        while($tmp_qty > 0){
            $sql = "select msk_id, sisa from as_masuk where barang_id = '".$barang_id."' order by msk_id limit $i, 1";
            $rs = mysql_query($sql);
            $row = mysql_fetch_array($rs);
           	$jml = $row['sisa'];
            if($jml>0){
                if($jml>=$tmp_qty){
                    $tmp_jml = $jml - $tmp_qty;
                    $tmp_qty -= $tmp_qty;
                }
                else{
                    $tmp_qty -= $jml;
                    $tmp_jml = 0;//$tmp_qty - $jml;
                }
                $msk_id = $row['msk_id'];
                $sql = "update as_masuk set sisa='$tmp_jml', adj_opname='$adj' where msk_id = '$msk_id'";
                mysql_query($sql);
            }
            mysql_free_result($rs);
            $i++;
        }

        //untuk ke as_kstok
        $adj *= -1;
        $sql = "select jml_sisa, nilai_sisa from as_kstok where barang_id = '$barang_id' order by stok_id desc limit 1";
        $rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        $jml_awal = $row['jml_sisa'];
        $nilai_awal = $row['nilai_sisa'];
        $sql = "insert into as_kstok (waktu, barang_id, jml_awal, jml_masuk, jml_keluar, jml_sisa, nilai_awal, nilai_masuk, nilai_keluar, nilai_sisa, tipe, ket) values
                (now(), '$barang_id', '$jml_awal', 0, '$adj', '".($jml_awal-$adj)."', '$nilai_awal', 0, '".($harga*$adj)."', '".($nilai_awal-$harga*$adj)."', 1, 'opname')";
        mysql_query($sql);
    }
}

?>