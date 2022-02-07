<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=$_REQUEST['tgl'];

$tglPecah = explode('-',$tgl);
$tglSql = $tglPecah[2].'-'.$tglPecah[1].'-'.$tglPecah[0];
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$username=$_REQUEST['user'];
//====================================================================
//Paging,Sorting dan Filter======
$defaultsort="ak.TGL_ACT";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($fkelas=="")) $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else { if (($fkelas=="")&&($fgolongan=="")&&($fjenis=="")) $fkategori=" WHERE o.OBAT_KATEGORI=$kategori"; else $fkategori=" AND o.OBAT_KATEGORI=$kategori";}
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
$f1=$_REQUEST['f1'];
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
?>
<html>
<head>
<title>Laporan Stok Harian Apotek</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<style type="text/css">

.style1 {font-size: 12px}

</style>
</head>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">STOK HARIAN APOTEK<br>TGL : <?php echo $tgl; ?></span></p>
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="33" height="25" class="tblheaderkiri">No</td>
          <td width="494" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <!-- <td class="tblheader" >Expired</td> -->
          <!-- <td class="tblheader" >Batch</td> -->
          <td class="tblheader" >Stok Sebelumnya</td>
          <td class="tblheader" >Stok Terkini</td>
          <!-- <td id="unit20" width="51" class="tblheader" >Harga Beli Satuan</td> -->
          <td id="total" width="42" class="tblheader" >Nilai Total</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	 $sql="SELECT
            q.idobat AS obat_id,
            q.OBAT_NAMA obat,
            q.NAMA kepemilikan,
            q.KEPEMILIKAN_ID,
            SUM( q.unit1 ) AS unit1,
            q.nilai,
            SUM( q.ntotal ) AS ntotal,
            SUM( q.total ) AS total 
          FROM
            (
            SELECT DISTINCT
                p.idobat,
                p.OBAT_NAMA,
                ak.NAMA,
            IF
                ( p.KEPEMILIKAN_ID <> ak.ID OR p.KEPEMILIKAN_ID IS NULL, ak.ID, p.KEPEMILIKAN_ID ) AS KEPEMILIKAN_ID,
            IF
                ( p.KEPEMILIKAN_ID <> ak.ID OR p.unit1 IS NULL, 0, p.unit1 ) AS unit1,
            IF
                ( p.KEPEMILIKAN_ID <> ak.ID OR p.ntotal IS NULL, 0, p.ntotal ) AS ntotal,
            IF
                ( p.KEPEMILIKAN_ID <> ak.ID OR p.nilai_total IS NULL, 0, p.nilai_total ) AS nilai,
            IF
                ( p.KEPEMILIKAN_ID <> ak.ID OR p.total IS NULL, 0, p.total ) AS total 
            FROM
                (
                SELECT
                    o.OBAT_ID AS idobat,
                    o.OBAT_NAMA,
                    v.*,
                    unit1 AS total 
                FROM
                    ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o
                    LEFT JOIN vstokharianapotek AS v ON v.obat_id = o.OBAT_ID
                    LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID 
                ) AS p
                LEFT JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
            ) AS q ".$filter."  
          GROUP BY
            q.idobat,
            q.KEPEMILIKAN_ID 
          ORDER BY
            OBAT_NAMA,
            KEPEMILIKAN_ID";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
      $i=0;
      $total = 0;
	  while ($rows=mysqli_fetch_array($rs)){
          $i++;
          $sqlStok = "SELECT
          q.idobat AS obat_id,
          q.OBAT_NAMA obat,
          q.STOK_BEFOR,
          q.HARGA_BELI_SATUAN,
          ( SELECT EXPIRED FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS EXPIRED,
          ( SELECT BATCH FROM a_penerimaan WHERE OBAT_ID = q.idobat ORDER BY ID DESC LIMIT 1 ) AS BATCH 
      FROM
          (
          SELECT DISTINCT
              p.idobat,
              p.OBAT_NAMA,
              ak.NAMA,
              p.STOK_BEFOR,
              p.HARGA_BELI_SATUAN 
          FROM
              (
              SELECT
                  o.OBAT_ID AS idobat,
                  o.OBAT_NAMA as obat_nama,
                  ak.STOK_BEFOR,
                  ah.HARGA_BELI_SATUAN
              FROM
                  ( SELECT * FROM a_obat WHERE OBAT_ISAKTIF = 1 ) AS o

                  LEFT JOIN a_kelas AS kls ON o.KLS_ID = kls.KLS_ID
                  LEFT JOIN a_harga AS ah ON ah.OBAT_ID = o.OBAT_ID
                  INNER JOIN ( SELECT OBAT_ID, STOK_BEFOR FROM a_kartustok WHERE UNIT_ID = 7 AND TGL_TRANS = '{$tglSql}' ORDER BY TGL_ACT ASC ) AS ak ON ak.OBAT_ID = o.OBAT_ID 
              ) AS p
              JOIN ( SELECT * FROM a_kepemilikan WHERE aktif = 1 ) ak ON 1 = 1 
          )  AS q  WHERE q.idobat = {$rows['obat_id']}
      GROUP BY
          q.idobat 
      ORDER BY
          q.OBAT_NAMA";

          $stok_terkini = mysqli_fetch_array(mysqli_query($konek, $sqlStok));

          if($stok_terkini['STOK_BEFOR'] == '' || $stok_terkini['STOK_BEFOR'] == NULL){
            $stok = $rows['unit1'];
          }else{
            $stok = $stok_terkini['STOK_BEFOR'];
          }

          // $total +=	$rows['HARGA_BELI_SATUAN'] * $stok;
          $nilai = $rows['ntotal'];

	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['obat']; ?></td>
          <!-- <td align="right" class="tdisi"><?php echo $rows['EXPIRED']; ?></td> -->
          <!-- <td align="right" class="tdisi"><?php echo $rows['BATCH']; ?></td> -->
          <td align="right" class="tdisi"><?php echo $stok; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['unit1']; ?></td>
          <!-- <td align="right" class="tdisi"><?php echo number_format($rows['HARGA_BELI_SATUAN'], 0, ',', '.') ?></td> -->
          <td align="right" class="tdisi"><?php echo number_format($nilai, 0, ',', '.'); ?></td>
        </tr>
        <?php  
	  }
    $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
    //echo $sql2."<br>";
    $rs=mysqli_query($konek,$sql2);
    $show=mysqli_fetch_array($rs);
    $jml_tot=$show['jml_tot'];
	  ?>
        <tr> 
          <!-- <td colspan="7"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td> -->
          <td colspan="6" align="right"><span class="style1"><strong>Nilai Total 
            :&nbsp;&nbsp;</strong></span></td>
          <td align="right"><span class="style1"><strong><?php echo number_format($jml_tot,0,",","."); ?></strong></span></td>
        </tr>
      </table>
		<p class='txtinput'  style='padding-right:25px; text-align:right;'>
		<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>
		</p>

    </div>
</form>
</div>
<script>
 window.print();window.close();
</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>