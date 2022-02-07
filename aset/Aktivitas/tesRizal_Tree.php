<?
include '../sesi.php';
include("../koneksi/konek.php");
/* fungsi ini akan terus di looping secara rekursif agar dapat menampilkan menu dengan format tree (pohon)
 * dengan kedalaman jenjang yang tidak terbatas */
function loop($data,$parent){
  if(isset($data[$parent])){ // jika ada anak dari menu maka tampilkan
	/* setiap menu ditampilkan dengan tag <ul> dan apabila nilai $parent bukan 0 maka sembunyikan element 
	 * karena bukan merupakan menu utama melainkan sub menu */
	$str = '<ul parent="'.$parent.'" style="display:'.($parent>0?'none':'').'">'; 
	foreach($data[$parent] as $value){
	  /* variable $child akan bernilai sebuah string apabila ada sub menu dari masing-masing menu utama
	   * dan akan bernilai negatif apabila tidak ada sub menu */
	  $child = loop($data,$value->id); 
	  $str .= '<li>';
	  /* beri tanda sebuah folder dengan warna yang mencolok apabila terdapat sub menu di bawah menu utama 	  	   
	   * dan beri juga event javascript untuk membuka sub menu di dalamnya */
	  $str .= ($child) ? '<a href="javascript:openTree('.$value->id.')"><img src="../images/tree_expand.gif" id="img'.$value->id.'" border="0"></a>' : '<img src="../images/tree_leaf.gif">';
	  $str .= '<a href="'.$value->url.'">'.$value->name.'</a></li>';
	  if($child) $str .= $child;
	}
	$str .= '</ul>';
	return $str;
  }else return false;	  
}
// tampilkan menu di sortir berdasar id dan parent_id agar menu ditampilkan dengan rapih
$query = mysql_query('select * from as_ms_unit order by kodeunit');
$data = array();
while($row = mysql_fetch_object($query)){
  $data[$row->kodeunit][] = $row; // simpan data dari databae ke dalam variable array 3 dimensi di PHP
}
echo loop($data,0); // lakukan looping menu utama
?>
<script language="javascript">
function openTree(id){
  	// ambil semua tag <ul> yang mengandung attribut parent = id dari link yang dipilih
  	var elm = $('ul[@parent='+id+']'); 
  	if(elm != undefined){ // jika element ditemukan
  	  if(elm.css('display') == 'none'){ // jika element dalam keadaan tidak ditampilkan
  	    elm.show(); // tampilkan element 	  	
  	    $('#img'+id).attr('src','../images/tree_expand.gif'); // ubah gambar menjadi gambar folder sedang terbuka
  	  }else{
  	  	elm.hide(); // sembunyikan element
  	    $('#img'+id).attr('src','../images/tree_leaf.gif'); // ubah gambar menjadi gambar folder sedang tertutup
  	  }
	}
  }
</script>

