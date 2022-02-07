<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include '../koneksi/konek.php';
$sql="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id IN (10,45,46)";
$rs=mysql_query($sql);
$disableHapus="true";
if ((mysql_num_rows($rs)>0) && ($backdate!="0")){
	$disableHapus="false";
}

$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$b = date('m');
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <head>
        <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon" />
        <title>List Permintaan Darah</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
    </head>
    <body>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            include "../header1.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tr>
                    <td width="504" height="30" style="padding-left:20px;">&nbsp;FORM PERMINTAAN DARAH</td>
					<?php 
					$qAkses = "SELECT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42)";
					$rsAkses = mysql_query($qAkses);
					if(mysql_num_rows($rsAkses)>1){
					?>
                    <td width="460" align="right"><input id="txtIdPasien" name="txtIdPasien" type="hidden"/></td>
					<?php }?>
                    <td width="36">
                     
                    </td>
                </tr>
            </table>
            <!--div id="div_tes"></div-->
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                  <td height="25">&nbsp;</td>
                  <td colspan="2">Bulan&nbsp;:&nbsp;<select name="bulan" id="bulan" class="txtinput" onChange="ganti()">
              <option value="1" class="txtinput">Januari</option>
              <option value="2" class="txtinput">Pebruari</option>
              <option value="3" class="txtinput">Maret</option>
              <option value="4" class="txtinput">April</option>
              <option value="5" class="txtinput">Mei</option>
              <option value="6" class="txtinput">Juni</option>
              <option value="7" class="txtinput">Juli</option>
              <option value="8" class="txtinput">Agustus</option>
              <option value="9" class="txtinput">September</option>
              <option value="10" class="txtinput">Oktober</option>
              <option value="11" class="txtinput">Nopember</option>
              <option value="12" class="txtinput">Desember</option>
            </select> 
			<span class="txtinput">Tahun : </span> 
            <select name="ta" id="ta" class="txtinput" onChange="ganti()">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select>
            &nbsp;Status dilayani :&nbsp;
            <select class="txtinput" id="status" name="status" onChange="ganti()">
            	<option value="0" class="txtinput">Belum</option>
                <option value="1" class="txtinput">Sudah</option>
            </select></td>
                </tr>
                <tr>
                    <td colspan="3" height="235" align="center">
                        <div id="gridbox" style="width:950px; height:500px; background-color:white; overflow:hidden;"></div>
                  <div id="paging" style="width:950px;"></div>                    </td>
                </tr>
            </table>
        </div> 
    </body>
<script type="text/JavaScript" language="JavaScript">
    	
function goFilterAndSort(grd){
	if (grd=="gridbox"){
   
		a.loadURL("permintaan_darah_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog=0&asal="+document.getElementById('asal').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
	}
}
	
var g=new DSGridObject("gridbox");
g.setHeader(" ",false);
g.setColHeader("No.,Tanggal,No. Permintaan,No. Pemakaian,Nama Pasien,Dokter,Tempat Layanan,Nama KSO,Kode,Darah,QTY");
g.setIDColHeader(",pu.tgl,pu.no_minta,pm.no_bukti,ps.nama,pg.nama,u.nama,kso.nama,,,");
g.setColWidth("40,100,150,150,150,250,130,180,100,100,100");
g.setCellAlign("center,center,center,center,left,left,left,left,center,left,center");
g.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
g.setCellHeight(20);
g.setImgPath("../icon");
g.setIDPaging("paging");
g.attachEvent("onRowClick","getID");
document.getElementById('bulan').selectedIndex = '<?php echo $b-1; ?>';
g.baseURL("permintaan_darah_utils.php?bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&status="+document.getElementById('status').value);
g.Init();

function ganti(){
	var bulan = document.getElementById('bulan').value;
	var tahun = document.getElementById('ta').value;
	var status = document.getElementById('status').value;
	g.loadURL("permintaan_darah_utils.php?bulan="+bulan+"&tahun="+tahun+"&status="+status,"","GET");
}

function onload(){
	document.getElementById('bulan').selectedIndex = '<?php echo $b-1; ?>';
}	
</script>
</html>
<?php 
mysql_close($konek);
?>