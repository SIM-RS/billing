<?php
include("../inc/koneksi.php");
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 1000;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

$modul_id=$_REQUEST['idModul'];
$group_id=$_REQUEST['idGroup'];
$pegawai_id=$_REQUEST['pegawai_id'];
$data=$_REQUEST['data'];
if($_REQUEST['act']=='kanan'){
	$fdata=explode("|",$data);
	for($i=0;$i<count($fdata)-1;$i++){
		$cek = "select * from ms_group_petugas where ms_group_id='$group_id' and ms_pegawai_id='$fdata[$i]'";
		$qcek = mysql_query($cek);
		if(mysql_num_rows($qcek)==0){
			$sql = "insert into ms_group_petugas (ms_group_id,ms_pegawai_id) values ('$group_id','$fdata[$i]')";
			mysql_query($sql);
		}
	}
}
else if($_REQUEST['act']=='kiri'){
   $fdata=explode("|",$data);
	for($i=0;$i<count($fdata)-1;$i++){
		$sql = "delete from ms_group_petugas where ms_group_id='$group_id' and ms_pegawai_id='$fdata[$i]'";
		mysql_query($sql);
	}
}

$grd=$_REQUEST['grd'];
$action=$_REQUEST['action'];
$user=$_REQUEST['user'];
$pass=$_REQUEST['pass'];
$IdPeg=$_REQUEST['idPeg'];
if($grd==2){
	if($action='add'){
		if($pass==''){
			$sql = "update $rspelindo_db_billing.b_ms_pegawai set USER_NAME='$user' where PEGAWAI_ID='".$IdPeg."'";
		}
		else{
			$sql = "update $rspelindo_db_billing.b_ms_pegawai set USER_NAME='$user',PWD=PASSWORD('$pass') where PEGAWAI_ID='".$IdPeg."'";
		}
		$kur = mysql_query($sql);
	}
}

// GridFilters sends filters as an Array if not json encoded
if (is_array($filters)) {
    $encoded = false;
} else {
    $encoded = true;
    $filters = json_decode($filters);
}

// initialize variables
$where = '0=0';
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
            case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; break;
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
            break;
            case 'boolean' : $qs .= " AND ".$field." = ".($value); break;
            case 'numeric' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = ".$value; break;
                    case 'lt' : $qs .= " AND ".$field." < ".$value; break;
                    case 'gt' : $qs .= " AND ".$field." > ".$value; break;
                }
            break;
            case 'date' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; break;
                    case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; break;
                    case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; break;
                }
            break;
        }
    }
    $where .= $qs;
}

// query the database

if($grd==1){
	$query = "select * from (SELECT p.id PEGAWAI_ID,username user_name,p.NAMA,pj.Nama as nama_jenis FROM $rspelindo_db_billing.b_ms_pegawai p LEFT JOIN (SELECT a.* FROM ms_group_petugas a INNER JOIN ms_group b ON b.id=a.ms_group_id WHERE b.modul_id=".$modul_id.") gp ON p.id=gp.ms_pegawai_id 
	
	 LEFT JOIN rspelindo_billing.b_ms_pegawai_jenis pj 
      ON p.`pegawai_jenis` = pj.`id` 
	  
	WHERE gp.id IS NULL) as tbl1 where ".$where." ORDER BY tbl1.NAMA";
	//echo $query."<br>";
}
else if($grd==2){
	$query = "select * from (SELECT 
		  p.id PEGAWAI_ID,
		  p.username user_name,
		  p.NAMA 
		FROM
		  $rspelindo_db_billing.b_ms_pegawai p 
		  INNER JOIN ms_group_petugas mgp 
			ON p.id = mgp.ms_pegawai_id 
		WHERE mgp.ms_group_id='".$group_id."') as tbl2 where ".$where." ORDER BY tbl2.NAMA";
}


//echo $query."<br>";

//$query = "SELECT p.PEGAWAI_ID,user_name,p.NAMA FROM pegawai p".$where;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir;
}
//$query2 =$query. " LIMIT ".$start.",".$count;
$query2 =$query;
//echo $query2;
$rs = mysql_query($query2);//echo mysql_error();
//$total = mysql_num_rows($rs);
$total = 1;

$arr = array();
/*while($obj = mysql_fetch_object($rs)) {
    $arr[] = $obj;//echo $arr[0];
}*/

if($grd==1){
	$i=0;
	$no=1+$start;
	while($obj=mysql_fetch_array($rs)){
		$idobj="<input type='hidden' style='cursor:pointer' id='idext$i' value='$obj[PEGAWAI_ID]|$obj[user_name]|$obj[NAMA]' />";
		$chek="<input type='checkbox' style='cursor:pointer' value='$obj[PEGAWAI_ID]' id='cekbok_$i' />";
		$arr[$i]=array('CEK'=>$chek,'NO'=>($no).$idobj,'user_name'=>$obj["user_name"],'NAMA'=>$obj["NAMA"],'NAMA_JENIS'=>$obj["nama_jenis"]);
		$i++;
		$no++;
	}
}
else if($grd==2){
	$i=0;
	$no=1+$start;
	while($obj=mysql_fetch_array($rs)){
		$idobj="<input type='hidden' id='idexts$i' value='$obj[PEGAWAI_ID]|$obj[user_name]|$obj[NAMA]' />";
		$setting="<img src='../images/key.png' align='absmiddle' title='Setting Password' width='23' style='cursor:pointer' onclick='popup1($i)' /><span style='font-style:italic; text-decoration:underline; color:#0000FF; cursor:pointer;vertical-align:text-top' onClick='popup1($i)'>Set Password</span>";
		//$setting="sdfds";
		$chek="<input type='checkbox' style='cursor:pointer' value='$obj[PEGAWAI_ID]' id='cekbok2_$i' />";
		if(is_null($obj['user_name'])){
			$arr[$i]=array('CEK'=>$chek,'NO'=>($no).$idobj,'user_name'=>"<font color='#FF0000'>".$obj['user_name']."</font>",'NAMA'=>"<font color='#FF0000'>".$obj["NAMA"]."</font>",'SETTING'=>$setting);
		}
		else {
			$arr[$i]=array('CEK'=>$chek,'NO'=>($no).$idobj,'user_name'=>"<font color='#00CF00'>".$obj['user_name']."</font>",'NAMA'=>"<font color='#00CF00'>".$obj["NAMA"]."</font>",'SETTING'=>$setting);
		}
		$i++;
		$no++;
	}
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';
?>

