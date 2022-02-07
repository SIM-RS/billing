<?php 
session_start();
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

switch(strtolower($_REQUEST['act']))
{
			case 'tambah':		
				
				$forms = $_REQUEST['barangAset'];
				$fields = array('t_userid', 't_updatetime', 't_ipaddress');
				$datas = array($_SESSION['user_id'], 'now()', "'{$_SERVER['REMOTE_ADDR']}'");
				
				foreach ($forms as $key => $val)
				{
					$fields[] = $key;
					$datas[] = "'{$val}'";
				}
				
				$field = implode(',', $fields);
				$data = implode(',', $datas);
				
				$sql = "insert into ms_barang ({$field}) values ({$data})";
				mysql_query($sql);
				
				break;
			case 'hapus':
				$sqlHapus="delete from ms_barang where idbarang='".$_REQUEST['idbarang']."'";
				mysql_query($sqlHapus);
				break;
			case 'simpan':
				
				$idbarang = $_REQUEST['idbarang'];
				$forms = $_REQUEST['barangAset'];
				
				$isbrg_aktif = 0;
				if (isset($forms['isbrg_aktif']))
					$isbrg_aktif = 1;
					
				$sets = array(
					"isbrg_aktif = {$isbrg_aktif}", 
					"t_userid = '{$_SESSION['user_id']}'", 
					't_updatetime = now()', 
					"t_ipaddress = '{$_SERVER['REMOTE_ADDR']}'"
				);
				
				foreach ($forms as $key => $val)
				{
					$sets[] = "{$key} = '{$val}'";
				}
				
				$set = implode(',', $sets);
				
				$sql = "update ms_barang set {$set} where idbarang = {$idbarang}";
				mysql_query($sql);
				
				break;
}

// query the database

//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "select * from (SELECT * FROM ms_barang where tipe = '".$_GET['tipe']."') as q1 WHERE ".$where;
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
    $idobj="<input type='hidden' id='idext$i' 
		value='$obj[idbarang]|$obj[kodebarang]|$obj[namabarang]|$obj[idsatuan]|$obj[kemasan]|$obj[tipebarang]|$obj[level]|$obj[metodedepresiasi]|$obj[stddepamt]|$obj[lifetime]|$obj[akunaset]|$obj[akunpengadaan]|$obj[akunpemakaian]|$obj[akunhapus]|$obj[isbrg_aktif]' />";
	if ($obj['isbrg_aktif']==1) $ch = "checked"; else {$ch ="";}
    $arr[$i]=array('NO'=>($no).$idobj,'kodebarang'=>$obj["kodebarang"],'namabarang'=>$obj["namabarang"],'kemasan'=>$obj["kemasan"],'idsatuan'=>$obj["idsatuan"],'level'=>$obj["level"],'aktif'=>"<input type=checkbox $ch />");
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';