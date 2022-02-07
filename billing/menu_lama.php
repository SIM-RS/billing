<style>
	.tab
	{
		font-family: arial, verdana, san-serif; 
		font-size: 14px;
	}
	.asd
	{
		text-decoration: none; 
		font-family: arial, verdana, san-serif; 
		font-size: 13px; color: #4234ff;
	}
</style>

<script language=javascript>
window.onerror = null;
var bName = navigator.appName;
var bVer = parseInt(navigator.appVersion);
var IE4 = (bName == "Microsoft Internet Explorer" && bVer >= 4);
var menuActive = 0;
var menuOn = 0;
var onLayer;
var timeOn = null;

function showLayer(layerName,aa)
{
	var x =document.getElementById(aa);
	var tt =findPosX(x);
	//alert(tt);
	var ww =findPosY(x)+50;

	if (timeOn != null) 
	{
		clearTimeout(timeOn);
		hideLayer(onLayer);
	}
	if (IE4) 
	{
		var layers = eval('document.all["'+layerName+'"].style');
		//layers.left = tt;
		eval('document.all["'+layerName+'"].style.visibility="visible"');
	}
	else 
	{
		if(document.getElementById)
		{
			var elementRef = document.getElementById(layerName);
			if((elementRef.style)&& (elementRef.style.visibility!=null))
			{
				elementRef.style.visibility = 'visible';
				//elementRef.style.position = 'absolute'
				//elementRef.style.left = tt;
				elementRef.style.top = ww;
			}
		}
	}
	onLayer = layerName
}

function hideLayer(layerName)
{
	if (menuActive == 0)
	{
		if (IE4)
		{
			eval('document.all["'+layerName+'"].style.visibility="hidden"');
		}
		else
		{
			if(document.getElementById)
			{
				var elementRef = document.getElementById(layerName);
				if((elementRef.style)&& (elementRef.style.visibility!=null))
				{
					elementRef.style.visibility = 'hidden';
				}
			}
		}
	}
}

function btnTimer() 
{
	timeOn = setTimeout("btnOut()",600)
}

function btnOut(layerName)
{
	if (menuActive == 0)
	{
		hideLayer(onLayer)
	}
}

var item;
function menuOver(itemName,ocolor)
{
	item=itemName;
	itemName.style.backgroundColor = ocolor; //background color change on mouse over
	clearTimeout(timeOn);
	menuActive = 1
}

function menuOut(itemName,ocolor)
{
	if(item)
	itemName.style.backgroundColor = ocolor;
	menuActive = 0
	timeOn = setTimeout("hideLayer(onLayer)", 100)
}

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
	curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
	curtop += obj.y;
	return curtop;
}

</script>

<table valign=top cellpadding=0 cellspacing=0 width=1000 border=0 align="center">
	<tr>
		<td width="75%" height="30" style="background-color:#0033BB; color:#FFFFFF; font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif">&nbsp;Sistem Informasi Manajemen Rumah Sakit</td>
		<td width="25%" style="background-color:#0033BB" align="right"><a href="index.php"><img src="icon/cancel.gif" width="32"></a>&nbsp;</td>
	</tr>
	<tr>
		<td style="background-color:#80ABB5">
			<table align=center class=tab width="100%">
				<tr>
					<td id=0 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu0",'0')>
						<img src="images/home_02.gif">
					</td>
					<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
					<td id=1 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu1",'1')>
						<img src="images/home_03.gif">
					</td>
					<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
					<td id=2 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu2",'2')>
						<img src="images/home_04.gif">
					</td>
					<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
					<td id=3 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu3",'3')>
						<img src="images/home_05.gif">
					</td>
					<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
					<td id=4 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu4",'4')>
						<img src="images/home_06.gif">
					</td>
					<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
					<td id=5 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu5",'5')>
						<img src="images/home_07.gif">
					</td>
				</tr>
			</table>

			<div id=Menu0 style="position: absolute; left: 168; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/tmpt_layanan.php"> &nbsp;Tempat Layanan&nbsp;</a> &nbsp;&nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/pelaksana_layanan.php"> &nbsp;Pelaksana Layanan&nbsp;</a> &nbsp;&nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td id="6" align="left" onclick='showLayer("Menu6","6")' class="asd"> &nbsp;Tarif&nbsp; &nbsp;&nbsp;<img src="icon/arrows.gif" /></td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/penjamin.php"> &nbsp;Penjamin&nbsp;</a> &nbsp;&nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td id="7" align="left" onclick='showLayer("Menu7","7")' class="asd"> &nbsp;Referensi Medik&nbsp; &nbsp;&nbsp;<img src="icon/arrows.gif" /></td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="master/ref_gizi.php"> &nbsp;Referensi Gizi&nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align=left><a class=asd href="master/ref_umum.php"> &nbsp;Referensi Umum&nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align=left><a class=asd href="master/ref_wilayah_prof.php"> &nbsp;Referensi Wilayah&nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
				</table>
			</div>
			<div id=Menu1 style="position: absolute; left: 316; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="setting/aplikasi.php"> &nbsp;Aplikasi &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href=""> &nbsp;Petugas/Operator</a></td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="#"> &nbsp;Ganti Password &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td>
						<td id="8" align=left class="asd" onclick='showLayer("Menu8","8")'> &nbsp;Tema &nbsp; &nbsp; &nbsp;<img src="icon/arrows.gif" />
						</td>
					</tr>
				</table>
			</div>
			<div id=Menu2 style="position: absolute; left: 441; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="loket/registrasi.php"> &nbsp;Registrasi/Kunjungan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="unit_pelayanan/koreksi.php"> &nbsp;Koreksi/Pindah Tempat Tidur &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="unit_pelayanan/tindakan.php"> &nbsp;Tindakan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="unit_pelayanan/diagnosa.php"> &nbsp;Medik &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="pembayaran/pembayaran.php"> &nbsp;Pembayaran &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="unit_pelayanan/lain-lain.php"> &nbsp;Lain-Lain &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
				</table>
			</div>
			<div id=Menu3 style="position: absolute; left: 591; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/kasir.php"> &nbsp;Kasir &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/tempat_layanan.php"> &nbsp;Tempat Layanan &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/rekam_medik.php"> &nbsp;Rekam Medik &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/pelaksana_layanan.php"> &nbsp;Pelaksana Layanan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/keuangan.php"> &nbsp;Keuangan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/manajemen.php"> &nbsp;Manajemen &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="laporan/penjamin.php"> &nbsp;Penjamin &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
				</table>
			</div>
			<div id=Menu4 style="position: absolute; left: 723; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/kunjungan.php"> &nbsp;Kunjungan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/riwayat_kunj.php"> &nbsp;Riwayat Kunjungan &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/pelaksana_lay.php"> &nbsp;Pelaksana Layanan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/tarif.php"> &nbsp;Tarif &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="#"> &nbsp;Kamar &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/pasien_sdh_plng.php"> &nbsp;Pasien Sudah Pulang &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/pasien_blm_plng.php"> &nbsp;Pasien Belum Pulang &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/kinerja_petugas.php"> &nbsp;Kinerja Petugas &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="informasi/aktifitas_petugas.php"> &nbsp;Aktifitas Petugas &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
				</table>
			</div>
			<div id=Menu5 style="position: absolute; left: 868; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="antrian/kunjungan.php"> &nbsp;Kunjungan &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="antrian/medik_pasien.php"> &nbsp;Medik Pasien &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="antrian/pembayaran.php"> &nbsp;Pembayaran &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="antrian/penunjang.php"> &nbsp;Permintaan Penunjang &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
					<tr height=25 onmouseout=menuOut(this,'#80ABB5') onmouseover=menuOver(this,'#FFFFFF')>
						<td bgcolor=#00FF00>&nbsp; &nbsp;</td><td align=left>
							<a class=asd href="antrian/status_medik.php"> &nbsp;Status Medik Pasien &nbsp;</a> &nbsp; &nbsp;
						</td>
					</tr>
				</table>
			</div>
			
			<div id=Menu6 style="position: absolute; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/pendukung_tarif.php"> &nbsp;Pendukung Tarif &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/tarif1.php"> &nbsp;Tarif &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_Dist_komp.php"> &nbsp;Setting Distribusi Komponen &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_kls_tamb.php"> &nbsp;Setting Kelas Tambahan &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_tarif_tmpt_lay.php"> &nbsp;Setting Tarif Tempat Layanan &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_klasifikasi_penunjang.php"> &nbsp;Setting Klasifikasi Penunjang &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_tarif_tindakan.php"> &nbsp;Setting Tarif Tindakan Harian &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
				</table>
			</div>
			
			<div id=Menu7 style="position: absolute; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/diagnosis1.php"> &nbsp;Diagnosis &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/set_diagnosis.php"> &nbsp;Setting Diagnosis Tempat Layanan &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href="master/kasus1.php"> &nbsp;Kasus &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
				</table>
			</div>
			
			<div id=Menu8 style="position: absolute; border: 1px solid #00FF00; visibility:hidden; z-ndex: 1">
				<table bgcolor=#80ABB5 cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href=""> &nbsp;Warna &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
					<tr height="25" onmouseout="menuOut(this,'#80ABB5')" onmouseover="menuOver(this,'#FFFFFF')">
						<td bgcolor="#00FF00">&nbsp; &nbsp;</td>
						<td align="left"><a class="asd" href=""> &nbsp;Gambar &nbsp;</a> &nbsp; &nbsp;</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
