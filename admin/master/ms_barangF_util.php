<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 50;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'kodebarang';
$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;


// GridFilters sends filters as an Array if not json encoded
if (is_array($filters)) {
    $encoded = false;
} else {
    $encoded = true;
    $filters = json_decode($filters);
}

// initialize variables
$where = ' 0 = 0 ';
$qs = '';

// loop through filters sent by client
if (is_array($filters)) {
    for ($i=0;$i<count($filters);$i++){
        $filter = $filters[$i];

        // assign filter data (location depends if encoded or not)
        if ($encoded) {
            $field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;
        } else {
            $field = $filter['field'];
            $value = $filter['data']['value'];
            $compare = isset($filter['data']['comparison']) ? $filter['data']['comparison'] : null;
            $filterType = $filter['data']['type'];
        }

        switch($filterType){
            case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; Break;
            case 'list' :
                if (strstr($value,',')){
                    $fi = explode(',',$value);
                    for ($q=0;$q<count($fi);$q++){
                        $fi[$q] = "'".$fi[$q]."'";
                    }
                    $value = implode(',',$fi);
                    $qs .= " AND ".$field." IN (".$value.")";
                }else{
                    $qs .= " AND ".$field." = '".$value."'";
                }
            Break;
            case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
            case 'numeric' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
                    case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
                    case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
                }
            Break;
            case 'date' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
                }
            Break;
        }
    }
    $where .= $qs;
}



if(isset($_REQUEST['status_obat']))
{
	$status_obat = $_REQUEST['status_obat'];
	$status = "and isbrg_aktif='$status_obat'";
}

// query the database

//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "SELECT a.*, a_pabrik.PABRIK, a_kelas.KLS_NAMA, aoj.obat_jenis,aog.golongan,aok.kategori 
	From ms_barang as a 
	LEFT JOIN $rspelindo_db_apotek.a_pabrik ON a.PABRIK_ID = a_pabrik.PABRIK_ID
	LEFT JOIN $rspelindo_db_apotek.a_kelas ON a.KLS_ID = a_kelas.KLS_ID 
	LEFT JOIN $rspelindo_db_apotek.a_obat_kategori aok ON a.OBAT_KATEGORI=aok.id 
	LEFT JOIN $rspelindo_db_apotek.a_obat_golongan aog ON a.OBAT_GOLONGAN=aog.kode 
	LEFT JOIN $rspelindo_db_apotek.a_obat_jenis aoj ON a.OBAT_KELOMPOK=aoj.obat_jenis_id  WHERE $where and a.tipe = '3' $status"; //echo $query;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir; //echo $query;
}
$query2 =$query. " LIMIT ".$start.",".$count;

$rs = mysql_query($query2);
$total = mysql_num_rows(mysql_query($query));

$arr = array();

$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs)){
   /* $idobj="<input type='hidden' id='idext$i' value='$obj[idbarang]|$obj[kepemilikan_id]|$obj[nama]|$obj[alamat]|$obj[telp]|$obj[fax]|$obj[kontak]|$obj[kelompok_pasien]|$obj[diskon]|$obj[caktif]' />";*/
   $arfvalue="act2*-*edit*|*obat_id*-*".$obj['idbarang']."*|*obat_kode*-*".$obj['kodebarang']."*|*obat_nama*-*".$obj['namabarang']."*|*obat_dosis*-*".$obj['OBAT_DOSIS']."*|*obat_satuan_kecil*-*".$obj['OBAT_SATUAN_KECIL']."*|*obat_bentuk*-*".$obj['OBAT_BENTUK']."*|*kls_id*-*".$obj['KLS_ID']."*|*kls_nama*-*".$obj['KLS_NAMA']."*|*obat_kategori*-*".$obj['OBAT_KATEGORI']."*|*jenis_obat*-*".$obj['OBAT_KELOMPOK']."*|*obat_golongan*-*".$obj['OBAT_GOLONGAN']."*|*obat_isaktif*-*".$obj['isbrg_aktif']."*|*id_paten*-*".$obj['ID_PATEN']."*|*kode_paten*-*".$obj['KODE_PATEN'];
   
    $idobj3="<input type='hidden' id='idextabc$i' value='$arfvalue' />";
	if($obj['HABIS_PAKAI']==1){$x= "Ya";}else{$x= "Tidak";}
	
    $arr[$i]=array('NO'=>($no).$idobj3,'kodebarang'=>$obj["kodebarang"],'namabarang'=>$obj["namabarang"],'satuan'=>$obj["OBAT_SATUAN_KECIL"],'bentuk'=>$obj["OBAT_BENTUK"],'kelas'=>$obj["KLS_NAMA"],'kategori'=>$obj["kategori"],'jenis'=>$obj["obat_jenis"],'gol'=>$obj["golongan"],'pakai'=>$x);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';