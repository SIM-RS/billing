<?php
//$_SESSION['userId']='22';
//include("koneksi/konek.php");
//$user_idx = $_SESSION["iduser"];
$user_idx = mysqli_real_escape_string($konek,$_SESSION["iduser"]);
?>

<link type="text/css" href="../menu.css" rel="stylesheet" />
<!--<script type="text/javascript" src="menu.js"></script>
-->
<!--<script type="text/javascript" src="../menu.js"></script>-->

<style type="text/css">
    * { margin:0;
        padding:0;
    }
    div#menu { margin:5px auto; }
    div#copyright {
        font:11px 'Trebuchet MS';
        color:#fff;
        text-indent:30px;
        padding:40px 0 0 0;
    }
    div#menu { margin:0px auto; }
    div#copyright {
        font:11px 'Trebuchet MS';
        color:#222;
        text-indent:30px;
        padding:140px 0 0 0;
    }
    div#copyright a { color:#eee; }
    div#copyright a:hover { color:#222; }
</style>

<div>
    <table height="60" bgcolor="#4a5155">
        <div id="menu">
            <ul class="menu">
               <?
			   
	$q = "select distinct b.* from a_group_akses as a 
	inner join a_menu as b on b.id=a.menu_id
	inner join a_group_user c on c.group_id=a.group_id  
	where c.user_id='$user_idx' and b.mn_level=0 order by b.mn_kode";
	$s = mysqli_query($konek,$q); 
	// echo $q;
	$j = mysqli_num_rows($s);
	while($d=mysqli_fetch_array($s))
	{
		
		$level_anak = $d['mn_level']+1;

		echo "<li><a href='$d[mn_url]' class='parent'><span>$d[mn_kode] $d[mn_menu]</span></a>";
		echo "<ul>";
		cek_anak($d['mn_kode'],$level_anak,$user_idx);
		echo "</ul>";
		
	}

	// echo "<li class='last'><a href='#' onclick='log_out()'><span>Logout</span></a></li>";
	echo "<li class='last'><a href='http://".$_SERVER["HTTP_HOST"]."/simrs-pelindo/portal.php' ><span>Portal</span></a></li>";
	
	function cek_anak($kode,$level,$user_idx)
	{
		global $konek;
		$q = "select distinct b.* from a_group_akses as a 
		inner join a_menu as b on b.id=a.menu_id
		inner join a_group_user c on c.group_id=a.group_id 
		where c.user_id='$user_idx' and b.mn_kode like '$kode%' and b.mn_level='$level'  order by b.mn_kode"; 
		// echo $q;
	//	$s = mysqli_query($konek,$q);
		$s=mysqli_query($konek, $q) ;
		$j = mysqli_num_rows($s);
		if($j==0)
		{
			//$d=mysqli_fetch_array($ss);
			//echo "<li><a href='$d[mn_url]'><span>$d[mn_kode] $d[mn_menu]</span></a></li>";
		}
		else
		{
			while($d=mysqli_fetch_array($s))
			{
				$level_anak = $d['mn_level']+1;
				$qq = "select distinct b.* 
				from a_group_akses as a 
				inner join a_menu as b on b.id=a.menu_id
				inner join a_group_user c on c.group_id=a.group_id 
				where c.user_id='$user_idx' 
				and b.mn_kode like '$d[mn_kode]%' 
				and b.mn_level='$level_anak' 
				order by b.mn_kode"; 
				// echo $qq;
				$ss = mysqli_query($konek,$qq);
				$jj = mysqli_num_rows($ss);
				
				
				if($jj==0)
				{
					echo "<li><a href='$d[mn_url]'><span>$d[mn_kode] $d[mn_menu]</span></a></li>";
				}
				else
				{

					echo "<li><a href='$d[mn_url]' class='parent'><span>$d[mn_kode] $d[mn_menu]</span></a>";
					echo "<ul>";
					cek_anak($d['mn_kode'],$level_anak,$user_idx);
					echo "</ul>";
					echo "</li>";
				}
			
			}
		}
	}
	?>
			<!--li><a href="../portal.php" class="parent"><span>07 Portal</span></a></li-->
            </ul>
        </div>
        <div id="copyright" style="display:none;">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    </table>
</div>
<!-- script untuk otomatis updaate *decyber--> 
<?php
$q = "SELECT bulan
FROM a_rpt_mutasi
ORDER BY OBAT_ID
DESC LIMIT 1";
$s = mysqli_query($konek,$q); //echo $q;
$j = mysqli_num_rows($s);
$d=mysqli_fetch_array($s);
?>
<!-- Variabel untuk menyimpan data waktu *decyber -->
	<input type='hidden' id='cekbln' value='<?php echo $d[bulan]; ?>'>
	<input type='hidden' id='hariIni' value='<?php echo gmdate('d',mktime(date('H')+7)); ?>'>
	<input type='hidden' id='bulanIni' value='<?php echo gmdate('m',mktime(date('H')+7))-1; ?>'>
	<input type='hidden' id='tahunIni' value='<?php echo gmdate('Y',mktime(date('H')+7)); ?>'>
<script>
function newXMLRequest() {
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}	
}

function XMLCloseMonth(vUrl){
var XMLProc=new newXMLRequest();

  if (XMLProc.xmlhttp) {
    XMLProc.xmlhttp.open("GET" , vUrl, true);
	XMLProc.xmlhttp.onreadystatechange = function() {
		if (typeof(XMLProc) != 'undefined' && XMLProc.xmlhttp.readyState == 4) {
			if (XMLProc.xmlhttp.status == 200 || XMLProc.xmlhttp.status == 304) {
				//GetId(vTarget).innerHTML = XMLProc.xmlhttp.responseText;
				document.getElementById("wait").innerHTML="<span class=\"jdltable\">Proses Close Month Stok Obat : Selesai</span>";
				//document.getElementById("wait").innerHTML="<span class=\"jdltable\">Proses Close Month Stok Obat : Selesai</span><br/>"+XMLProc.xmlhttp.responseText;
			}else{
				XMLProc.xmlhttp.abort();
			}
		}
	}
	
	if (window.XMLHttpRequest) {
	  XMLProc.xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  XMLProc.xmlhttp.send();
	}
  }
  return false;
} 
$("document").ready(function()
	{
		//kode dbwah sni
		var cekbln=document.getElementById('cekbln').value;
		var hari=document.getElementById('hariIni').value;
		var bulan=document.getElementById('bulanIni').value;
		if(hari==01){
			if(cekbln == bulan){/* jika bulan yg ad pada database, sama tidak dengan bulan sekarang, 
				jika sama maka query tidak dilakukan karena, sudah di run sebelumnya *decyber */
			}else{
				if(bulan==0){
				bulan = '12'; /* jikan bulan sama dengan 0 atau januari,
				 maka value brubah jadi 12 dan tahun berkurang 1 *decyber */
				var tahun=document.getElementById('tahunIni').value;
				tahun = tahun - 1;
				}else{
					var tahun=document.getElementById('tahunIni').value;
				}
				var hari=document.getElementById('hariIni').value;
				var cunitapotek='12'; //unit untuk apotek
				var cunitgudang='7'; //unit untuk gudang
				var enCM='<?php echo $enableCM; ?>';
				var admin = '1';
				if(admin == 1){
					enCM = 1;
				}
				if (enCM=='1'){
					//query djalankan
					XMLCloseMonth("../transaksi/tutupbuku_utils.php?bulan="+bulan+"&ta="+tahun+"&cunit="+cunitapotek);
					XMLCloseMonth("../transaksi/tutupbuku_utils.php?bulan="+bulan+"&ta="+tahun+"&cunit="+cunitgudang);
				}else{
					alert("Proses Close Month Tidak Diperlukan Lagi Karena Sudah Dilakukkan Secara Otomatis Oleh Server !");
				}
			}
		}

	});
	// <!-- script untuk otomatis updaate -->
function log_out()
{
	if (confirm('Anda Yakin Ingin Logout?')){location='../logout.php';}
}
</script>