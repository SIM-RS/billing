<?php
include '../sesi.php';
include("../koneksi/konek.php");
?>
<table id="tblObat" border="0" cellpadding="1" cellspacing="0">    
    <?php
    $tipe=$_GET["tipe"];
    $aKeyword=$_GET["aKeyword"];
    $no=$_GET["no"];
		//$sqlcek="select ";
        $sql="SELECT tgl_transaksi,kode_transaksi,k.no_gd,u.namaunit,l.namalokasi, petugas_gudang, petugas_unit,concat(tgl_transaksi,' / ',kode_transaksi) as bon FROM as_keluar k
	    LEFT JOIN as_ms_unit u ON u.idunit=k.unit_id
	    LEFT JOIN as_lokasi l ON l.idlokasi=k.lokasi_id
	    WHERE (stt = 0 OR stt=1)  and concat(tgl_transaksi,' / ',kode_transaksi) LIKE '%$aKeyword%' and stt !=1
        GROUP BY tgl_transaksi,kode_transaksi
	    ORDER BY tgl_transaksi desc,kode_transaksi desc limit 50";
        /*$sql="SELECT tgl_transaksi,kode_transaksi,concat(tgl_transaksi,' / ',kode_transaksi) as 'bon' FROM as_keluar, as_lokasi
        WHERE concat(tgl_transaksi,' / ',kode_transaksi) LIKE '%$aKeyword%'
	    GROUP BY tgl_transaksi,kode_transaksi
	    ORDER BY tgl_transaksi DESC,kode_transaksi DESC limit 50";*/
        
        /*$sql="SELECT DISTINCT idbarang,kodebarang,namabarang,idsatuan,T2.jml_sisa
		FROM as_ms_barang br LEFT JOIN 
		(SELECT * FROM (SELECT stok_id,barang_id,jml_sisa FROM as_kstok ORDER BY STOK_ID DESC) T1
		GROUP BY T1.barang_id) AS T2
		ON br.idbarang=T2.barang_id
		WHERE namabarang LIKE '%$aKeyword%' ORDER BY jml_sisa LIMIT 50";*/
		
        //echo $sql;
        $rs=mysql_query($sql);
        $arfvalue="";
        $i=0;
        while ($rows=mysql_fetch_array($rs)) {
            $i++;

            $arfvalue = $rows['tgl_transaksi'].'|'.$rows['kode_transaksi'].'|'.$rows['namaunit'].' - '.$rows['namalokasi'].'|'.$rows['petugas_gudang'].'|'.$rows['petugas_unit'].'|'.$rows['no_gd'];
            //$obat = $rows['kodebarang']." - ".$rows['namabarang'];
			//$jml_sisa = $rows['jml_sisa'];
            ?>
    <tr id="<?php echo $i; ?>" height="20" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="set2(this.lang);">        
	<td class="tdisikiri" width="300" align="left">&nbsp;<?php echo $rows['bon']; ?></td>
    </tr>
            <?php
        }
    
    ?>
</table>
<?php
mysql_close($konek);
?>