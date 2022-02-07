<?php
include("../../koneksi/konek.php");
		$qIns = "SELECT id, nama FROM b_ms_instansi";
		$sIns = mysql_query($qIns);
		while($wIns = mysql_fetch_array($sIns)){

echo "<option value=".$wIns['id'].">".$wIns['nama']."</option>";

		}
?>