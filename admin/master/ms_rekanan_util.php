<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'id';
$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'DESC';
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

$id = $_REQUEST['id'];
$kategori = $_REQUEST['kategori'];
$kode = $_REQUEST['kode'];
$nama = $_REQUEST['nama'];
$tipe = $_REQUEST['tipe'];
$alamat = $_REQUEST['alamat'];
$telp = $_REQUEST['telp'];
$hp = $_REQUEST['hp'];
$email = $_REQUEST['email'];
$fax = $_REQUEST['fax'];
$kodepos = $_REQUEST['kodepos'];
$kota = $_REQUEST['kota'];
$negara = $_REQUEST['negara'];
$kontak = $_REQUEST['kontak'];
$status = $_REQUEST['status'];

switch(strtolower($_REQUEST['act']))
{
			case 'tambah':		
				$sqlTambah="insert into ms_rekanan (kategori,koderekanan,namarekanan,idtipesupplier,alamat,telp,kodepos,hp,fax,email,kota,negara,contactperson,status)
					values('$kategori','$kode','$nama','$tipe','$alamat','$telp','$kodepos','$hp','$fax','$email','$kota','$negara','$kontak','$status')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'hapus':
				$sqlHapus="delete from ms_rekanan where idrekanan='".$_REQUEST['id']."'";
				mysql_query($sqlHapus);
				break;
			case 'simpan':
				$sqlSimpan = "UPDATE ms_rekanan SET koderekanan='$kode',namarekanan='$nama',idtipesupplier='$tipe',alamat='$alamat',telp='$telp',kodepos='$kodepos',hp='$hp',fax='$fax',email='$email',kota='$kota',negara='$negara',contactperson='$kontak',status='$status' WHERE idrekanan='".$_REQUEST['id']."'";	 //echo $sqlSimpan;
				$rs=mysql_query($sqlSimpan); //echo $sqlSimpan;
				break;
}

// query the database

//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "SELECT a.*,if(`status`=1,'Aktif','Tidak Aktif') status2,b.id as idx,b.idtipesupplier,b.keterangan
                FROM ms_rekanan as a
                INNER JOIN ms_rekanan_tipe b ON b.idtipesupplier=a.idtipesupplier WHERE $where AND a.kategori='$kategori'"; //echo $query;
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
    $idobj="<input type='hidden' id='idext$i' value='$obj[idrekanan]|$obj[koderekanan]|$obj[namarekanan]|$obj[idtipesupplier]|$obj[alamat]|$obj[telp]|$obj[kodepos]|$obj[hp]|$obj[fax]|$obj[email]|$obj[kota]|$obj[negara]|$obj[contactperson]|$obj[status]' />";
	if ($obj['status']==1) $ch = "checked"; else {$ch ="";}
    $arr[$i]=array('NO'=>($no).$idobj,'koderekanan'=>$obj["koderekanan"],'namarekanan'=>$obj["namarekanan"],'keterangan'=>$obj["keterangan"],'alamat'=>$obj["alamat"],'telp'=>$obj["telp"],'fax'=>$obj["fax"],'contactperson'=>$obj["contactperson"],'status'=>"<input type=checkbox $ch />");
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';