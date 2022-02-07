<?php
include('../../inc/koneksi.php');
if ($_REQUEST['type']=='grid')
{
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'mu.kodeunit';
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

//Tampil Data
$query = "SELECT tc.`complainid`, tc.`complainket`, mu.`namaunit`, tc.`complaintype`, tc.`complainaktif`
		FROM rspelindo_saran.`tb_complain` tc
		INNER JOIN rspelindo_hcr.`ms_unit` mu ON
		mu.`idunit` = tc.`complainunit`
		WHERE tc.`complainlevel`=1 AND tc.`complainaktif`=1
		AND".$where;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir;
}
$query2 =$query. " LIMIT ".$start.",".$count;

$rs = mysql_query($query2);echo mysql_error();
$total = mysql_num_rows(mysql_query($query));

$arr = array();

$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs)){
    $idobj="<input type='hidden' id='idext$i' value='$obj[complainid]|$obj[namaunit]|$obj[complainket]|$obj[complaintype]|$obj[complainaktif]' />";
	if($obj['complainaktif']=='1'){
		$status = 'Aktif';
	}
	else if($obj['complainaktif']=='0'){
		$status = 'Non Aktif';
	}
    $arr[$i]=array('NO'=>($no).$idobj,'namaunit'=>$obj["namaunit"],'complainket'=>$obj["complainket"],'complaintype'=>$obj["complaintype"],'complainaktif'=>$status);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';	
}elseif ($_REQUEST['type']=='CRUD')
{
	if($_REQUEST['act']=='add')
	{
		$sql="insert into rspelindo_saran.tb_complain (`complainkode`,`complainket`,`complainunit`,`complaintype`,complainlevel)
			VALUES ((SELECT IFNULL(LPAD(MAX(tc.complainkode)+1,2,'0'),'01') FROM rspelindo_saran.`tb_complain` tc WHERE tc.complainlevel=1 AND tc.complainunit=".$_REQUEST['complainunit']."),'".$_REQUEST['complainket']."','".$_REQUEST['complainunit']."','".$_REQUEST['complaintype']."','1')";
		mysql_query($sql);
		echo "sukses";
	}elseif($_REQUEST['act']=='read'){
		$sql="SELECT complainid, complainket, complainunit, complaintype FROM rspelindo_saran.`tb_complain` WHERE complainid=".$_REQUEST['id'];
		$rs=mysql_query($sql);
		$rows=mysql_fetch_row($rs);
		echo implode('||',$rows);
	}elseif($_REQUEST['act']=='update'){
		$sql="update rspelindo_saran.tb_complain set complainket='".$_REQUEST['complainket']."', complainunit ='".$_REQUEST['complainunit']."', complaintype='".$_REQUEST['complaintype']."' where complainid='".$_REQUEST['complain_id']."'";
		mysql_query($sql);
		echo "sukses";
	}elseif($_REQUEST['act']=='delete'){
		$sql="delete from rspelindo_saran.tb_complain where complainid='".$_REQUEST['id']."'";
		mysql_query($sql);
		echo "sukses";
	}
}
?>