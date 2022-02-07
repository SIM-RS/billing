<?php
include("../inc/koneksi.php");
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'kode';
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
	 switch(strtolower($_REQUEST['act']))
   {
      case 'tambah':
      //for($i=0;$i<(sizeof($id)-1);$i++)
      //{
	    //$sqlCek = "select * from b_ms_pegawai_unit where unit_id='".$id[$i]."' and ms_pegawai_id='".$_REQUEST['idPeg']."'";
	    $sqlCek = "select * from rspelindo_billing.b_ms_pegawai_unit where unit_id='".$_REQUEST['id']."' and ms_pegawai_id='".$_REQUEST['idPeg']."'";
	    $rsCek = mysql_query($sqlCek);
	    if(mysql_num_rows($rsCek)==0)
	    {
		  $sqlTambah = "INSERT INTO rspelindo_billing.b_ms_pegawai_unit (ms_pegawai_id,unit_id) values('".$_REQUEST['idPeg']."','".$_REQUEST['id']."')";
		  $rs=mysql_query($sqlTambah);
		  $res = mysql_affected_rows();
	    }
      //}
      break;
		   
      case 'hapus':
      //$sqlHapus="delete from b_ms_pegawai_unit where id='".$_REQUEST['rowid']."'";
      $sqlHapus="delete from rspelindo_billing.b_ms_pegawai_unit where ms_pegawai_id='".$_REQUEST['idPeg']."' and unit_id = '".$_REQUEST['id']."'";
      $rs=mysql_query($sqlHapus);
      $res = mysql_affected_rows();
      break;   
   }
//Tampil Data
/*$query = "SELECT g.`id`,g.`kode`,g.`nama`,g.`ket`,g.`aktif` `status` FROM a_ms_group g
		RIGHT JOIN a_ms_modul m ON g.`modul_id` = m.`id` WHERE m.`id` = '$modul_id' AND".$where;*/
		
$query = " select * from (SELECT u.id, u.nama, if( t1.id IS NULL , 0, 1 ) AS pil, u.kode
		  FROM rspelindo_billing.b_ms_unit u
		  LEFT JOIN (
		  SELECT *
		  FROM rspelindo_billing.b_ms_pegawai_unit pu
		  WHERE ms_pegawai_id ='".$_REQUEST['idPeg']."'
		  ) AS t1 ON u.id = t1.unit_id
		  WHERE islast =1) as t2 where $where";
		 // echo $query;

if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir;
}
$query2 =$query. " LIMIT ".$start.",".$count; //echo $query2;

$rs = mysql_query($query2);echo mysql_error();
$total = mysql_num_rows(mysql_query($query));

$arr = array();
/*while($obj = mysql_fetch_object($rs)) {
    $arr[] = $obj;//echo $arr[0];
}*/
$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs)){
    $idobj="<input type='hidden' id='idext$i' value='$obj[id]|$obj[pil]' />";
	if($obj['pil']=='1'){
		$chk = "<input type='checkbox' checked='checked' onclick='pilih(this.checked,$obj[id])'/>";
	}
	else if($obj['pil']=='0'){
		$chk = "<input type='checkbox' onclick='pilih(this.checked,$obj[id])'/>";
	}
    $arr[$i]=array('NO'=>($no).$idobj,'pil'=>$chk,'kode'=>$obj["kode"],'nama'=>$obj["nama"]);
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';