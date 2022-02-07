<?php
include('../../inc/koneksi.php');
if ($_REQUEST['type']=='grid')
{
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'tl.listcid,tl.listtype,tl.listnumber';
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
$where = '';
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

if(empty($_REQUEST['unitid']) || $_REQUEST['unitid']=='0' || $_REQUEST['unitid']=='')
{
	$unit="";
}else{
	$unit=" AND tl.listunit=".$_REQUEST['unitid'];
}

if(empty($_REQUEST['tipe']) || $_REQUEST['tipe']=='0' || $_REQUEST['tipe']=='')
{
	$tipe="";
}else{
	$tipe=" AND tl.listcid=".$_REQUEST['tipe'];
}

//Tampil Data
$query = "SELECT listid,listnumber,IF(listtype=1,'Kritik','Saran') listtype, listket,IF(listadd=0,'Tidak','Ya') listadd, 
			 IF(listaktif=1,'Aktif','Non Aktif') listaktif,
			 (SELECT MAX(listnumber) FROM rspelindo_saran.`tb_list` WHERE listunit=tl.`listunit` AND listcid=tl.`listcid` AND tl.listtype=`listtype`) maxnumber
			 FROM rspelindo_saran.`tb_list` tl
			WHERE 0 = 0".$unit.$tipe.$where;
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
    $idobj="<input type='hidden' id='idext$i' value='$obj[listid]|$obj[listket]' />";
	$image=($obj['listnumber']=='1'?null:"<img src='../../images/top.png' width='14' height='14' title='up' style='cursor:pointer;'>")."\t".
	($obj['listnumber']==$obj['maxnumber']?null:"<img src='../../images/bottom.png' width='14' height='14' title='down' style='cursor:pointer;'>");
    $arr[$i]=array('NO'=>($no).$idobj,'listtype'=>$obj["listtype"],'listket'=>$obj["listket"],'listadd'=>$obj["listadd"],'listaktif'=>$obj["listaktif"],'action'=>$image);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';	
}elseif ($_REQUEST['type']=='CRUD')
{
	if($_REQUEST['act']=='add')
	{
		$sqls="SELECT IFNULL(MAX(listnumber)+1,1) listnumber FROM rspelindo_saran.`tb_list` WHERE listcid=".$_REQUEST['listcid']." AND listtype=".$_REQUEST['listtype'];
		$rs=mysql_query($sqls);
		$rows=mysql_fetch_array($rs);
		$listnumber=$rows['listnumber'];
		$listadd=isset($_REQUEST['listadd'])?$_REQUEST['listadd']:'0';
		$sql="insert into rspelindo_saran.tb_list (`listnumber`,`listket`,`listunit`,`listcid`,`listtype`,`listadd`)
			VALUES (".$listnumber.",'".$_REQUEST['listket']."','".$_REQUEST['listunit']."','".$_REQUEST['listcid']."','".$_REQUEST['listtype']."','".$listadd."')";
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
		$sql="delete from rspelindo_saran.tb_list where listid='".$_REQUEST['id']."'";
		mysql_query($sql);
		echo "sukses";
	}
}elseif ($_REQUEST[type]=='ajaxoption'){
	$sql="SELECT tc.complainket, tc.complainid
	FROM rspelindo_saran.`tb_complain` tc WHERE tc.`complainunit`=".$_REQUEST['id']." AND tc.`complainlevel`=1;";
	$rs=mysql_query($sql);
	if ($_REQUEST[form]=='0')
		$option="<option value=\"0\">-- Semua Jenis List --</option>";
	else
		$option="<option value=\"0\">-- Pilih Jenis Komplain --</option>";
	while($row=mysql_fetch_array($rs))
	{
		$option.="<option value=\"".$row['complainid']."\">".$row['complainket']."</option>";
	}
	echo $option;
}
?>