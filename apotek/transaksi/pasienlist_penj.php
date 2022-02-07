<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
	<style type="text/css">
		#pasienlist_penj td{
			padding:3px;
		}
	</style>
    <table id="pasienlist_penj" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $aOpt=$_REQUEST["aOpt"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  if ($aOpt=="1"){
	  	//$sql="select NO_PASIEN, NAMA_PASIEN from a_penjualan WHERE UNIT_ID=$idunit and NAMA_PASIEN like '$aKeyword%' group by NO_PASIEN,NAMA_PASIEN";
		
		$sql_ = "SELECT 
				  ap.NO_PASIEN,
				  ap.NAMA_PASIEN,
				  ap.NO_KUNJUNGAN,
				  DATE_FORMAT(p.tgl_act,'%d-%m-%Y') tglIn,
				  p.tgl_masuk,
				  u.nama
				FROM
				  a_penjualan ap
				INNER JOIN $dbbilling.b_pelayanan p
				   ON p.id = ap.NO_KUNJUNGAN
				INNER JOIN $dbbilling.b_ms_unit u
				   ON p.unit_id = u.id
				WHERE ap.UNIT_ID = '{$idunit}' 
				  AND ap.NAMA_PASIEN LIKE '{$aKeyword}%' 
				GROUP BY ap.NO_PASIEN,
				  ap.NAMA_PASIEN";
		
		$sql = "SELECT p.id NO_KUNJUNGAN, ap.NAMA_PASIEN NAMA_PASIEN, u.nama unit, 
					   DATE_FORMAT(p.tgl_act,'%d-%m-%Y') tglIn, mp.no_rm NO_PASIEN
				FROM $dbbilling.b_pelayanan p
				INNER JOIN $dbbilling.b_kunjungan k
				   ON k.id = p.kunjungan_id
				INNER JOIN $dbbilling.b_ms_pasien mp
				   ON mp.id = k.pasien_id
				INNER JOIN $dbbilling.b_ms_unit u
				   ON p.unit_id = u.id
				INNER JOIN a_penjualan ap
				   ON ap.NO_KUNJUNGAN = p.id
				WHERE ap.UNIT_ID = '{$idunit}'
				  AND ap.NAMA_PASIEN LIKE '{$aKeyword}%' 
				GROUP BY p.id, ap.UNIT_ID
				ORDER BY p.tgl_act DESC";
	  } else {
	  	//$sql="select NO_PASIEN, NAMA_PASIEN from a_penjualan WHERE UNIT_ID=$idunit and NO_PASIEN = '$aKeyword' group by NO_PASIEN,NAMA_PASIEN";
		
		$sql_ = "SELECT 
				  ap.NO_PASIEN,
				  ap.NAMA_PASIEN,
				  ap.NO_KUNJUNGAN,
				  DATE_FORMAT(p.tgl_act,'%d-%m-%Y') tglIn,
				  p.tgl_masuk,
				  u.nama
				FROM
				  a_penjualan ap
				INNER JOIN $dbbilling.b_pelayanan p
				   ON p.id = ap.NO_KUNJUNGAN
				INNER JOIN $dbbilling.b_ms_unit u
				   ON p.unit_id = u.id
				WHERE ap.UNIT_ID = '{$idunit}' 
				  AND ap.NO_PASIEN = '{$aKeyword}' 
				GROUP BY ap.NO_PASIEN,
				  ap.NAMA_PASIEN";
				  
		$sql = "SELECT p.id NO_KUNJUNGAN, mp.nama NAMA_PASIEN, u.nama unit, 
					   DATE_FORMAT(p.tgl_act,'%d-%m-%Y') tglIn, mp.no_rm NO_PASIEN
				FROM $dbbilling.b_pelayanan p
				INNER JOIN $dbbilling.b_kunjungan k
				   ON k.id = p.kunjungan_id
				INNER JOIN $dbbilling.b_ms_pasien mp
				   ON mp.id = k.pasien_id
				INNER JOIN $dbbilling.b_ms_unit u
				   ON p.unit_id = u.id
				INNER JOIN a_penjualan ap
				   ON ap.NO_KUNJUNGAN = p.id
				WHERE ap.UNIT_ID = '{$idunit}'
				  AND ap.NO_PASIEN = '{$aKeyword}' 
				GROUP BY p.id, ap.UNIT_ID
				ORDER BY p.tgl_act DESC";
	  }
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $Jrs=mysqli_num_rows($rs);
	  //echo $Jrs;
	  if($Jrs<1)
	  {
		if ($aOpt=="1")
		{
	  	$sql="select distinct NO_PASIEN, NAMA_PASIEN, NO_KUNJUNGAN, '&nbsp;' as unit, DATE_FORMAT(tgl_act, '%d-%m-%Y') tglIn  from a_penjualan WHERE UNIT_ID=$idunit and NAMA_PASIEN like '$aKeyword%' group by id";
		}else{
	  	$sql="select distinct NO_PASIEN, NAMA_PASIEN, NO_KUNJUNGAN, '&nbsp;' as unit, DATE_FORMAT(tgl_act, '%d-%m-%Y') tglIn  from a_penjualan WHERE UNIT_ID=$idunit and NO_PASIEN like '$aKeyword%' group by id";  
		}
		$rs=mysqli_query($konek,$sql);
	  }	
	  
	  //echo $sql;
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue=$no."*|*".$rows['NAMA_PASIEN']."*|*".$rows['NO_PASIEN']."*|*".$rows['NO_KUNJUNGAN']."*|*".$rows['unit']."*|*".$rows['tglIn'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		$namapas=$rows['NAMA_PASIEN'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80" align="center">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
        <td class="tdisi" width="200" align="left"><?php echo $namapas; ?></td>
        <td class="tdisi" width="100" align="left"><?php echo $rows['unit']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['tglIn']; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>