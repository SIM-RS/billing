<?php 


include("../../sesi.php");
include '../../koneksi/konek.php';



function getData($pdf, $where, $data, $table, $tgl_act, $file, $printFile, $nama_rm, $printGet, $editFile = "", $editParam = "")
{
    $dataRM = mysql_query("SELECT
				$data
			FROM
				$table
			WHERE
				$where
	");

    if ($dataRM) {
        while ($row = mysql_fetch_assoc($dataRM)) {
            echo "<tr>";

				echo "<td>";
					echo $row[$tgl_act];
				echo "</td>";

				echo "<td class='text-left'>";
					echo $nama_rm;
				echo "</td>";

				echo "<td>";
					if ($pdf == "noPDF") {
    					echo "<a class='btn btn-primary' target='_blank' href='../{$file}/{$printFile}?{$printGet}={$row['id']}&idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}'>Cetak / Cetak PDF</a>";
					} else {
                        echo "<a class='btn btn-primary' target='_blank' href='../{$file}/{$printFile}?{$printGet}={$row['id']}&idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}'>Cetak</a> 
						<a class='btn btn-primary' target='_blank' href='{$file}/{$printFile}?pdf={$row['id']}&idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}'>Cetak PDF</a>";
                    }

                    echo "<a class='ml-1 btn btn-primary' target='_blank' href='../{$file}/{$editFile}?${editParam}={$row['id']}&idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}&tmpLay={$_REQUEST['tmpLay']}&idUser={$_REQUEST['idUser']}'>Edit</a>";
					

				echo "</td>";

            echo "</tr>";
        }
    } else {
        return false;
    }
}

function getAllIdPel($id) {
	$arrData = [];
	$dataPel = mysql_query("SELECT id FROM b_pelayanan WHERE kunjungan_id = '${id}'");

	while ($ids = mysql_fetch_assoc($dataPel)) {
		array_push($arrData, $ids['id']);
	}
	return $arrData;
}


function getRm8($idKunj, $pdf, $file, $printFile, $name, $printGet) {
	$myArray = [];

	foreach (getAllIdPel($idKunj) as $value) {
		$dataRM = mysql_query("SELECT id, tgl_act FROM rspelindo_askep.ask_soap WHERE pelayanan_id = '${value}'");

		while ($ids = mysql_fetch_assoc($dataRM)) {
			$arr = [
				'id' => $ids['id'],
				'tgl_act' => $ids['tgl_act'],
				'pelayanan' => $value,
			];
			array_push($myArray, $arr);
		}
	}
	
	if (count($myArray) > 0) {
		echo "<tr>";

			echo "<td>";
				echo "~";
			echo "</td>";

			echo "<td class='text-left'>";
				echo $name;
			echo "</td>";

			echo "<td>";

					echo "<a class='btn btn-primary' target='_blank' href='../{$file}/{$printFile}?{$printGet}={$row['id']}&idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}'>Cetak / Cetak PDF</a>";
					
			echo "</td>";

        echo "</tr>";
	}

}

 ?>