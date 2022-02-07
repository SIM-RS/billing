<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'ID';
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


$act		= $_REQUEST['act']; // Jenis Aksi //echo $act;
$id			= $_REQUEST['id'];
$nama		= $_REQUEST['nama'];
$alamat		= $_REQUEST['alamat'];
$asal		= $_REQUEST['asal'];
$telepon	= $_REQUEST['telepon'];
$isaktif	= $_REQUEST['isaktif'];

switch ($act){
	case "Tambah":
			$sql="insert into ms_dokter_luar (nama,alamat,telepon,asal,aktif) values('$nama','$alamat','$telepon','$asal','$isaktif')";
			$rs=mysql_query($sql);
		break;
	case "Simpan":
			$sql="update ms_dokter_luar set nama='$nama',alamat='$alamat',asal = '$asal',telepon = '$telepon', aktif=$isaktif where id = $id";
			$rs=mysql_query($sql);
		break;
	case "Hapus":
		$sql="delete from ms_dokter_luar where id = '$id'";
		$rs=mysql_query($sql);
		//echo $sql;
		break;
}

// query the database
$status = $_REQUEST['status'];
//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "select * from ms_dokter_luar WHERE $where and aktif='$status'";
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
    $idobj="<input type='hidden' id='idext$i' value='$obj[id]|$obj[nama]|$obj[alamat]|$obj[telepon]|$obj[asal]|$obj[aktif]' />";
	if ($obj['aktif']==1) $ch = "<font color='#0033CC'>Aktif</font>"; else {$ch ="<font color='#FF0000'>Tidak Aktif</font>";}
    $arr[$i]=array('no'=>($no).$idobj,'nama'=>$obj["nama"],'alamat'=>$obj["alamat"],'telepon'=>$obj["telepon"],'asal'=>$obj["asal"],'aktif'=>$ch);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';