<?php 
include '../inc/koneksi.php';
// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 20;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : 'kode';
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


$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM ms_kso";
$rs = mysql_query($sql);
$rw = mysql_fetch_array($rs);

$kodebr = $rw['kode'] + 1;
$kodebr = sprintf("%03d",$kodebr);
$kodebr = "PENJ".$kodebr ;

switch(strtolower($_REQUEST['act']))
{
			case 'tambah':		
				$sqlTambah="insert into ms_kso 

(kode,nama,kepemilikan_id,alamat,telp,fax,kontak,aktif,kelompok_id,diskon,tipe,jamin_obat,keterangan)
					values('".$kodebr."','".$_REQUEST['nama']."','".$_REQUEST['kpid']."','".

$_REQUEST['alamat']."','".$_REQUEST['telp']."','".$_REQUEST['fax']."','".$_REQUEST['kontak']."','".$_REQUEST

['caktif']."','".$_REQUEST['kel_pasien']."','".$_REQUEST['diskon']."','".$_REQUEST['tipe']."','".$_REQUEST

['cjamin']."','".$_REQUEST['keterangan']."')";

				$rs=mysql_query($sqlTambah);
				break;
			case 'hapus':
				$sqlHapus="delete from ms_kso where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
			case 'simpan':
				$sqlSimpan = "UPDATE ms_kso SET nama='".$_REQUEST['nama']."',kepemilikan_id='".

$_REQUEST['kpid']."',alamat='".$_REQUEST['alamat']."',
					telp='".$_REQUEST['telp']."',fax='".$_REQUEST['fax']."',kontak='".$_REQUEST

['kontak']."',aktif='".$_REQUEST['caktif']."',jamin_obat='".$_REQUEST['cjamin']."' 
					,kelompok_id='".$_REQUEST['kel_pasien']."',diskon='".$_REQUEST

['diskon']."',tipe='".$_REQUEST['tipe']."',jamin_obat='".$_REQUEST['cjamin']."',keterangan='".$_REQUEST['keterangan']."'
					WHERE id='".$_REQUEST['id']."'";	 //echo $sqlSimpan;
				$rs=mysql_query($sqlSimpan);
				break;
}

// query the database

//$query = "SELECT * FROM ms_eselon WHERE ".$where."ORDER BY eselon_kode";
$query = "select 
  * 
from
  (select 
    kso.id,
    kso.kepemilikan_id,
    k.NAMA kepemilikan,
	kso.`kelompok_id`,
	akp.kp_nama kelompok_pasien,
    kso.kode,
    kso.nama,
    kso.alamat,
    kso.telp,
    kso.fax,
    kso.kontak,
	kso.diskon,
    kso.aktif caktif,
	kso.jamin_obat cjamin,
	kso.keterangan,
	if(kso.tipe = 1, 'Gesek', 'Reguler') tipe,
    if(kso.aktif = 1, 'Ya', 'Tidak') aktif,
	if(kso.jamin_obat = 1, 'Ya', 'Tidak') jamin,
	kso.tipe as tipe_val 
  from
    ms_kso kso 
    left join $rspelindo_db_apotek.a_kepemilikan k 
      on kso.kepemilikan_id = k.ID 
    left join $rspelindo_db_apotek.a_kelompok_pasien akp 
      on kso.kelompok_id = akp.a_kpid) gab WHERE ".$where;
if ($sort != "") {
    $query .= " ORDER BY ".$sort." ".$dir; //echo $query;
}
$query2 =$query. " LIMIT ".$start.",".$count;

$rs = mysql_query($query2);
$total = mysql_num_rows(mysql_query($query));

$arr = array();

$i=0;
$no=1+$start;
while($obj=mysql_fetch_array($rs))
{
    $idobj="<input type='hidden' id='idext$i' value='$obj[id]|$obj[kepemilikan_id]|$obj[nama]|$obj[alamat]|$obj[telp]|$obj[fax]|$obj[kontak]|$obj[kelompok_id]|$obj[diskon]|$obj[caktif]|$obj[tipe]|$obj[tipe_val]|$obj[cjamin]|$obj[keterangan]' />";
	if ($obj['caktif']==1) $ch = "checked"; else {$ch ="";}
	if ($obj['cjamin']==1) $ch2 = "checked"; else {$ch2 ="";}
	if($obj["tipe_val"]==0){ $tipene = "Reguler";} else if($obj["tipe_val"]==1){ $tipene = "Gesek";} else if($obj

["tipe_val"]==2){ $tipene = "Non Reguler/Gesek";}
    $arr[$i]=array('NO'=>($no).$idobj,'kode'=>$obj["kode"],'nama'=>$obj["nama"],'kepemilikan'=>$obj

["kepemilikan"],'kelompok_pasien'=>$obj["kelompok_pasien"],'alamat'=>$obj["alamat"],'telp'=>$obj["telp"],'fax'=>$obj

["fax"],'kontak'=>$obj["kontak"],'diskon'=>$obj["diskon"].' %','tipe'=>$tipene,'aktif'=>"<input type=checkbox $ch 

/>",'jamin_obat'=>"<input type=checkbox $ch2 />");
    $i++;
    $no++;
}

// return response to client
echo '{"total":"'.$total.'","data":'.json_encode($arr).'}';