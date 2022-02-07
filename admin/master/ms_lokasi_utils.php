<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'kodelokasi';
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
 
 switch($_REQUEST['act']) 
 {
	case 'hapus':
	$sqlSelect="SELECT * FROM ms_lokasi WHERE idlokasi='".$_REQUEST['id']."'"; //echo $sqlSelect;
	$rs=mysql_query($sqlSelect);
	$row=mysql_fetch_array($rs);
	/*if($row[0]!=''){
		//$upSel="SELECT PARENT_KODE_JABATAN FROM ms_jabatan_pegawai WHERE PARENT_KODE_JABATAN LIKE '%".$row[0]."%'";
		$up="UPDATE ms_jabatan_pegawai set ISLAST_JABATAN=1 WHERE PARENT_KODE_JABATAN='$row[0]'";
		mysql_query($up); 
		
	}*/
		$sqlHapus="DELETE FROM ms_lokasi WHERE idlokasi='".$_REQUEST['id']."'";
        mysql_query($sqlHapus);
		
		$kode_parent = substr($row['kodelokasi'], 0, -3);
		$panjang = strlen($row['kodelokasi']);
		$jum = mysql_fetch_array(mysql_query("select kodelokasi,CHAR_LENGTH(kodelokasi)AS bb from ms_lokasi where kodelokasi like'$kode_parent.%' AND CHAR_LENGTH(kodelokasi)='$panjang' order by kodelokasi")); //echo $cari;
		
		if($jum==0){
		//$upSel="SELECT PARENT_KODE_JABATAN FROM ms_jabatan_pegawai WHERE PARENT_KODE_JABATAN LIKE '%".$row[0]."%'";
		$up="UPDATE ms_lokasi set islast=1 where kodelokasi='$kode_parent'"; //echo $up;
		mysql_query($up); 
		
		}
		
		
        break;
 }

// query the database

//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "SELECT * FROM ms_lokasi WHERE ".$where;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir;
}
$query2 =$query. " LIMIT ".$start.",".$count;
//echo $query2;
$rs = mysql_query($query2);
$total = mysql_num_rows(mysql_query($query));

$arr = array();

$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs)){
    $idobj="<input type='hidden' id='idext$i' value='$obj[idlokasi]' />";
	if ($obj['statuslokasi']==1) $ch = "checked"; else {$ch ="";}
    $arr[$i]=array('NO'=>($no).$idobj,'kodelokasi'=>$obj["kodelokasi"],'namalokasi'=>$obj["namalokasi"],'namapanjang'=>$obj["namapanjang"],'AKTIF'=>"<input type=checkbox $ch />");
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';