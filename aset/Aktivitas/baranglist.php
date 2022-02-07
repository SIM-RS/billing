<?php
include '../sesi.php';
include("../koneksi/konek.php");
?>
<table id="tblObat" border="0" cellpadding="1" cellspacing="0">    
    <?php
    $tipe=$_GET["tipe"];
    $aKeyword=$_GET["aKeyword"];
	$aKeyOPname=$_GET["aKeywords"];
    $no=$_GET["no"];
	$cmbfilter=$_GET['cmbIventaris'];
    $act = $_GET['act'];
    if($act == 'pemakaian') {
		
        $sql="select ms_barang_id,kodebarang,namabarang,kodeparent,sum(qty_stok) as qty_stok,harga_beli_satuan
            from as_penerimaan ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang
            where trim(ab.namabarang) like '%$aKeyword%'
            group by ap.ms_barang_id
            ORDER BY ab.namabarang";
        //echo $sql;
        $rs=mysql_query($sql);
        $arfvalue="";
        $i=0;
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
            $arfvalue = $no."*|*".$rows['ms_barang_id']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['qty_stok']."*|*".$rows['harga_beli_satuan'];
			
            $obat = $rows['kodebarang']." - ".$rows['namabarang'].", stok = ".$rows['qty_stok'];
            ?>
    <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="500"align="left"><?php echo $obat; ?></td>
    </tr>
            <?php
        }
    }
    else if($act == 'opname') {
         $sql=" select idbarang,kodebarang,namabarang,idsatuan,kodeparent
            from as_ms_barang 
            where trim(namabarang) like '$aKeyOPname%' and tipe = '$tipe'
            ORDER BY namabarang ";
        //echo $sql;
        $rs=mysql_query($sql);
        $arfvalue="";
        $i=0;
        while ($rows=mysql_fetch_array($rs)) {
			
		$sql1="SELECT namabarang FROM as_ms_barang WHERE kodebarang='".$rows['kodeparent']."'";
		$r=mysql_query($sql1);
		while($ro=mysql_fetch_array($r)){
			$d=$ro[0];	
		}
				
	$stok_data="SELECT jml_sisa FROM as_kstok WHERE barang_id='".$rows['idbarang']."' ORDER BY waktu DESC LIMIT 1";
	$a="SELECT harga_unit FROM as_masuk WHERE barang_id='".$rows['idbarang']."' ORDER BY tgl_terima DESC LIMIT 1";
 	$query=mysql_query($stok_data);
	$r=mysql_query($a);
	$row=mysql_fetch_array($query);
	$row1=mysql_fetch_array($r);
            $i++;

            $arfvalue = $rows['idbarang']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan']."*|*".$row['jml_sisa']."*|*".$row1['harga_unit'];
            $obat = $rows['kodebarang']." - ".$rows['namabarang']."&nbsp;-&nbsp;".$d;
            ?>
    <tr id="<?php echo $i; ?>" height="20" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="500" align="left"><?php echo $obat; ?></td>
    </tr>
            <?php
        }
    }
    else {
        
      $sql="SELECT DISTINCT idbarang,kodebarang,namabarang,idsatuan,T2.jml_sisa,islast
		FROM as_ms_barang br LEFT JOIN 
		(SELECT * FROM (SELECT stok_id,barang_id,jml_sisa FROM as_kstok ORDER BY STOK_ID DESC) T1
		GROUP BY T1.barang_id) AS T2
		ON br.idbarang=T2.barang_id
		WHERE namabarang LIKE '%$aKeyword%' and tipe=$cmbfilter ORDER BY jml_sisa LIMIT 50";
		
        //echo $sql;
        $rs=mysql_query($sql);
        $arfvalue="";
        $i=0;
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
				$arfvalue = $no."*|*".$rows['idbarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan']."*|*".$rows['kodebarang'];
				$obat = $rows['kodebarang']." - ".$rows['namabarang'];
				$jml_sisa = $rows['jml_sisa'];
			
			if($rows['islast']>0){
				$arfvalue = $no."*|*".$rows['idbarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan']."*|*".$rows['kodebarang'];
				$obat = $rows['kodebarang']." - ".$rows['namabarang'];
				$jml_sisa = $rows['jml_sisa'];
			}else{
				 $arfvalue="";
			}
            ?>
    <tr id="<?php echo $i; ?>" height="50" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="500" align="left"><?php echo $obat; ?></td>
	<td class="tdisikiri" width="80" align="right">&nbsp;<?php echo $jml_sisa; ?></td>
    </tr>
            <?php
        }
    }
    ?>
</table>
<?php
mysql_close($konek);
?>