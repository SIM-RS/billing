<?php
include('../inc/koneksi.php');
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

$modul_id = $_REQUEST['modul'];

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
//=========CRUD=============
	$act=$_REQUEST['act'];
	$isi=$_REQUEST['isi'];
	$dt=explode("|",$isi);
		  if($act=='simpan'){
			  $cek="select * from ms_group where kode='$dt[0]' and nama='$dt[1]' and ket='$dt[2]' and modul_id='$modul_id'";
			  $qcek=mysql_query($cek);
			  if(mysql_num_rows($qcek)==0){
				  $sql="INSERT INTO ms_group(id,modul_id,kode,nama,ket,aktif) 
					  VALUES ( NULL,'$modul_id','$dt[0]','$dt[1]','$dt[2]','$dt[3]')";
				  $sql=mysql_query($sql);
			  }
			  
		  }elseif($act=='update'){
			  $sql="UPDATE ms_group SET kode='$dt[0]',nama='$dt[1]',ket='$dt[2]',aktif='$dt[3]' WHERE id='$dt[4]'";
			  $sql=mysql_query($sql);
		  }elseif($act=='hapus'){
			  $mid=$_REQUEST['mid'];
			  $sql="DELETE FROM ms_group WHERE id='$mid'";
			  echo $sql;
			  $sql=mysql_query($sql);
			  
		  }
//Tampil Data
$query = "SELECT g.`id`,g.`kode`,g.`nama`,g.`ket`,g.`aktif` `status` FROM ms_group g
		RIGHT JOIN ms_modul m ON g.`modul_id` = m.`id` WHERE m.`id` = '$modul_id' AND".$where;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir;
}
$query2 =$query. " LIMIT ".$start.",".$count;

$rs = mysql_query($query2);echo mysql_error();
$total = mysql_num_rows(mysql_query($query));

$arr = array();
/*while($obj = mysql_fetch_object($rs)) {
    $arr[] = $obj;//echo $arr[0];
}*/
$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs)){
    $idobj="<input type='hidden' id='idext$i' value='$obj[id]|$obj[kode]|$obj[nama]|$obj[ket]|$obj[status]' />";
	if($obj['status']=='1'){
		$status = 'Aktif';
	}
	else if($obj['status']=='0'){
		$status = 'Non Aktif';
	}
    $arr[$i]=array('NO'=>($no).$idobj,'KODE'=>$obj["kode"],'NAMA'=>$obj["nama"],'KET'=>$obj["ket"],'STATUS'=>$status);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';