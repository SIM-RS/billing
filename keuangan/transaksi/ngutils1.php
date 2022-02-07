<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];
//===============================

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="tipenya"; //default sort
    }

	/*
	$sql = "select * from (SELECT 
	  u.id,
	  u.kode,
	  u.nama,
	  u.parent_id,
	  (SELECT 
		nama 
	  FROM
		$dbakuntansi.ak_ms_unit 
	  WHERE id = u.parent_id) AS parent 
	FROM
	  $dbakuntansi.ak_ms_unit u 
	WHERE islast = 1 
	ORDER BY u.kode) as tbl $filter";
	*/
	
	$jtrans_kode = $_REQUEST['jtrans_kode'];
	$sql = "SELECT 
	  *,
	  detil_transaksi.fk_jenis_trans AS Expr1,
	  ma_sak.MA_KODE AS MA_SAK_KODE,
	  ma_sak.MA_NAMA AS MA_SAK_NAMA,
	  jenis_transaksi.JTRANS_NAMA AS Expr4,
	  jenis_transaksi.JTRANS_ID AS Expr5,
	  detil_transaksi.fk_ma_sak AS Expr6,
	  detil_transaksi.dk AS Expr7,
	  detil_transaksi.id_detil_trans AS Expr8,
	  ak_ms_beban_jenis.kode as kodeBebanJenis,ak_ms_beban_jenis.nama as namaBebanJenis
	FROM
	  $dbakuntansi.detil_transaksi 
	  INNER JOIN $dbakuntansi.jenis_transaksi 
		ON detil_transaksi.fk_jenis_trans = jenis_transaksi.JTRANS_ID 
	  INNER JOIN $dbakuntansi.ma_sak 
		ON detil_transaksi.fk_ma_sak = ma_sak.MA_ID 
	  LEFT JOIN $dbakuntansi.ak_ms_beban_jenis ON detil_transaksi.fk_ms_beban_jenis = ak_ms_beban_jenis.id
	WHERE jenis_transaksi.JTRANS_KODE LIKE '$jtrans_kode%' AND ma_sak.MA_KODE NOT LIKE '101%'
	ORDER BY detil_transaksi.id_detil_trans";

    //echo $sql."<br>";
    $rs=mysql_query($sql);    
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    //$sql=$sql." limit $tpage,$perpage";

    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

	while ($rows=mysql_fetch_array($rs)) {
		
		switch ($rows["cc_rv_kso_pbf_umum"]){
			case 0:
				if (($arfvalue=='edit') && (count($arCC_RV_PBF_UMUM_ID)>$cnt)){
					if ($arCC_RV_PBF_UMUM_ID[$cnt]>0){
						$psql="SELECT * FROM ak_ms_unit WHERE id=".$arCC_RV_PBF_UMUM_ID[$cnt];
						//echo $psql."<br>";
						$rsCC=mysql_query($psql);
						$rwCC=mysql_fetch_array($rsCC);
						$idCC=$rwCC["id"];
						//$ketCC=$rwCC["nama"];
						$namasak1=$rwCC["nama"];
						$kdmacc=$rwCC["kode"];
					}
				}
				break;
			case 1:
				if (($arfvalue=='edit') && ($rows["id_cc_rv_kso_pbf_umum"]==0)){
					if ($arCC_RV_PBF_UMUM_ID[$cnt]>0){
						$psql="SELECT * FROM $dbakuntansi.ak_ms_unit WHERE id=".$arCC_RV_PBF_UMUM_ID[$cnt];
					}else{
						$psql="SELECT * FROM $dbakuntansi.ak_ms_unit WHERE id='".$rows["id_cc_rv_kso_pbf_umum"]."'";
					}
				}else{
					$psql="SELECT * FROM $dbakuntansi.ak_ms_unit WHERE id='".$rows["id_cc_rv_kso_pbf_umum"]."'";
				}
				//echo $psql."<br>";
				$rsCC=mysql_query($psql);
				$rwCC=mysql_fetch_array($rsCC);
				$idCC=$rwCC["id"];
				$idparentCC=$rwCC["parent_id"];
				$ketCC=$rwCC["nama"];
				$kdmacc=$rwCC["kode"];
				break;
			case 2:
				$psql="SELECT * FROM $dbbilling.b_ms_kso WHERE id='".$rows["id_cc_rv_kso_pbf_umum"]."'";
				//echo $psql."<br>";
				$rsCC=mysql_query($psql);
				$rwCC=mysql_fetch_array($rsCC);
				$idCC=$rwCC["id"];
				$ketCC=$rwCC["nama"];
				$kdmacc=$rwCC["kode_ak"];
				break;
			case 3:
				$psql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID='".$rows["id_cc_rv_kso_pbf_umum"]."'";
				//echo $psql."<br>";
				$rsCC=mysql_query($psql);
				$rwCC=mysql_fetch_array($rsCC);
				$idCC=$rwCC["PBF_ID"];
				$ketCC=$rwCC["PBF_NAMA"];
				$kdmacc=$rwCC["PBF_KODE_AK"];
				break;
			case 4:
				$psql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan='".$rows["id_cc_rv_kso_pbf_umum"]."'";
				//echo $psql."<br>";
				$rsCC=mysql_query($psql);
				$rwCC=mysql_fetch_array($rsCC);
				$idCC=$rwCC["idrekanan"];
				$ketCC=$rwCC["namarekanan"];
				$kdmacc=$rwCC["koderekanan"];
				break;
		}
		
		if ($rows['MA_ISLAST']==1){ 
			$kdma=$rows['MA_SAK_KODE'];
			$idsak=$rows['Expr6'];
			$namasak=$rows['MA_SAK_NAMA'];
			if ($rows['CC_RV_KSO_PBF_UMUM']==0){
				$namasak1=$namasak;
			}else{
				//$namasak1="";
				if ($ketCC!="") $namasak1=$ketCC;
			}
	  	}else{
			if ($_GET[arfvalue]=='edit'){
				$kdma=$arkdma[$cnt].$kdmacc;
				$idsak=$aridsak[$cnt];
				$namasak=$arnamasak[$cnt];
				$namasak1=$namasak;
				if ($ketCC!="") $namasak1=$ketCC;
			}else{
				$kdma="";
				$idsak="";
				$namasak="";
			}
		}
		// ==========================================
		/*if ($idCC!=0 && $ketCC!=""){
			$keterangan = $ketCC;
		}else{
			if ($fk_TipeTrans==0){
				if ($rows['MA_ISLAST']==1) 
					$keterangan = $rows['JTRANS_NAMA']; 
				else 
					$keterangan = $rows['JTRANS_NAMA']."<br>(".$rows['MA_SAK_NAMA'].")";
			}
		}*/
		
		$keterangan = $rows['namaBebanJenis'];
		
		$pilihAnak = "<img src='../icon/view_tree.gif' align='absmiddle' style='cursor:pointer' onclick='bukaWindow($rows[MA_SAK_KODE])' />";
		
		$id_beban_jenis = $rows["fk_ms_beban_jenis"];
		$id_ak_ms_unit = $idCC;
		$idparent_ak_ms_unit = $idparentCC;
		$id_ma_sak = $rows['MA_ID'];
		$sisip = $id_ma_sak."^".$id_ak_ms_unit."^".$id_beban_jenis;
		$i++;
		$nilai = "<input type='text' id='nilai_".$id_ma_sak."^".$id_ak_ms_unit."^".$id_beban_jenis."' lang='$idparent_ak_ms_unit*$id_ak_ms_unit*$id_ma_sak*$id_beban_jenis' size='22' style='text-align:right' onkeyup='zxc(this);setSubTotal()' />";
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$kdma.chr(3).$namasak.chr(3).$keterangan.chr(3).$nilai.chr(6);
	}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
        $dt=str_replace('"','\"',$dt);
    }
    mysql_free_result($rs);
    mysql_close($konek);
    header("Cache-Control: no-cache, must-revalidate" );
    header("Pragma: no-cache" );
    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
        header("Content-type: application/xhtml+xml");
    }else {
        header("Content-type: text/xml");
    }
    echo $dt;
?>