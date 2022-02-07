<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'PABRIK_ID';
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


$act=$_REQUEST['act']; // Jenis Aksi //echo $act;
$pabrik_id=$_REQUEST['pabrik_id'];
$kode_pabrik=$_REQUEST['kode_pabrik'];
$pabrik=$_REQUEST['pabrik'];
$isaktif=$_REQUEST['isaktif'];

switch ($act){
	case "Tambah":
			$sql="insert into ms_pabrik(PABRIK_ID,KODE_PABRIK,PABRIK,ISAKTIF) values('','$kode_pabrik','$pabrik',$isaktif)";
			echo $sql;
			$rs=mysql_query($sql);
		break;
	case "Simpan":
			$sql="update ms_pabrik set KODE_PABRIK='$kode_pabrik',PABRIK='$pabrik',ISAKTIF=$isaktif where PABRIK_ID=$pabrik_id";
			//echo $sql;
			$rs=mysql_query($sql);
		break;
	case "Hapus":
		$sql="delete from ms_pabrik where PABRIK_ID=$pabrik_id";
		$rs=mysql_query($sql);
		//echo $sql;
		break;
}

// query the database
$status = $_REQUEST['status'];
//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "select * from ms_pabrik WHERE $where and isaktif='$status'";
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
    $idobj="<input type='hidden' id='idext$i' value='$obj[PABRIK_ID]|$obj[KODE_PABRIK]|$obj[PABRIK]|$obj[ISAKTIF]' />";
	if ($obj['ISAKTIF']==1) $ch = "checked"; else {$ch ="";}
    $arr[$i]=array('NO'=>($no).$idobj,'KODE_PABRIK'=>$obj["KODE_PABRIK"],'PABRIK'=>$obj["PABRIK"],'ISAKTIF'=>"<input type=checkbox $ch onclick='return false' />");
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';