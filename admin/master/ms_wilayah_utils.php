<?php 

include '../inc/koneksi.php';

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from rspelindo_billing.b_ms_wilayah where kode='".$_REQUEST['kode']."'");
		if(mysql_affected_rows()==0){			
			$sqlTambah="insert into rspelindo_billing.b_ms_wilayah (kode,nama,level,parent_id,parent_kode,aktif)
				values('".$kodebr."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['aktif']."')";
			$rs=mysql_query($sqlTambah);
			echo $sqlTambah;
		}
		break;
	case 'hapus':
		$sqlHapus="delete from rspelindo_billing.b_ms_wilayah where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update rspelindo_billing.b_ms_wilayah set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',level='".$_REQUEST['level']."',
		parent_id='".$_REQUEST['parentId']."',parent_kode='".$_REQUEST['parentKode']."',aktif='".$_REQUEST['aktif']."' where id='".$_REQUEST['id']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

// collect request parameters
$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
$count = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'kode';
$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'ASC';
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

// GridFilters sends filters as an Array if not json encoded
if (is_array($filters)) $encoded = false;
else
{
    $encoded = true;
    $filters = json_decode($filters);
}

// initialize variables
$where = ' 0 = 0 ';
$qs = '';

// loop through filters sent by client
if (is_array($filters))
{
    for ($i = 0; $i < count($filters); $i++)
	{
        $filter = $filters[$i];

        // assign filter data (location depends if encoded or not)
        if ($encoded)
		{
            $field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;
        }
		else
		{
            $field = $filter['field'];
            $value = $filter['data']['value'];
            $compare = isset($filter['data']['comparison']) ? $filter['data']['comparison'] : null;
            $filterType = $filter['data']['type'];
        }

        switch ($filterType)
		{
            case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; break;
            case 'list' :
                if (strstr($value,','))
				{
                    $fi = explode(',',$value);
                    for ($q = 0; $q < count($fi); $q++)
					{
                        $fi[$q] = "'".$fi[$q]."'";
                    }
                    $value = implode(',',$fi);
                    $qs .= " AND ".$field." IN (".$value.")";
                }
				else $qs .= " AND ".$field." = '".$value."'";
				break;
            case 'boolean' : $qs .= " AND ".$field." = ".($value); break;
            case 'numeric' :
                switch ($compare)
				{
                    case 'eq' : $qs .= " AND ".$field." = ".$value; break;
                    case 'lt' : $qs .= " AND ".$field." < ".$value; break;
                    case 'gt' : $qs .= " AND ".$field." > ".$value; break;
                }
				break;
            case 'date' :
                switch ($compare)
				{
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
$sql = "select 
	  id,
	  kode,
	  nama,
	  level,
	  parent_id,
	  parent_kode,
	  if(aktif = 1, 'Aktif', 'Tidak') as aktif 
	from
	  rspelindo_billing.b_ms_wilayah 
	where ".$where;

if ($sort != "") $sql .= " ORDER BY ".$sort." ".$dir; //echo $sql;

$sql2 = $sql. " LIMIT ".$start.",".$count;

$query = mysql_query($sql2);

$total = mysql_num_rows(mysql_query($sql));

$arr = array();

$i = 0;
$no = 1 + $start;
while ($rows = mysql_fetch_array($query))
{
    $idobj = "<input type=\"hidden\" id=\"idext{$i}\" value=\"{$rows['id']}|{$rows['kode']}|{$rows['nama']}|{$rows['level']}|{$rows['parent_id']}|{$rows['parent_kode']}|{$rows['aktif']}\" />";
	
    $arr[$i] = array(
		'no' => ($no).$idobj,
		'kode' => $rows["kode"],
		'nama' => $rows["nama"],
		'level' => $rows["level"],
		'parent_id' => $rows["parent_id"],
		'parent_kode' => $rows["parent_kode"],
		'aktif' => $rows["aktif"]
	);
	
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';