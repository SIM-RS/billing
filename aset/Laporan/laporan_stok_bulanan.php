<?php
session_start();
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];
date_default_timezone_set("Asia/Jakarta");
$tgl1 = gmdate('d-m-Y',mktime(date('H')+7));
function indonesian_date ($timestamp = '', $date_format = ' j F Y', $suffix = '') {
	if (trim ($timestamp) == '')
	{
			$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
	);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
	);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
}	
switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

	$tahun=$_REQUEST['ta'];
    $jenisBarang = $_POST['cmbJnsBrg'];
    $bulan = $_POST['cmbBln'];
    $namaBulan = array ('','Januari','Februari','Maret','April','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
    $level = ($_POST['level']=='')?1:$_POST['level'];
    $idBarang = $_POST['idBarang'];
    $kodeBarang = $_POST['kodeBarang'];
    $tipe = $_POST['cmbJnsBrg'];

?>
<html>
    <head>
        <title>Laporan Stok Bulanan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../theme/report.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form id="form1" name="form1" action="laporan_stok_bulanan.php" method="post" target="_self">            
    <table width="405" border="0">
      <tr>
        <td width="133"><strong>SKPD</strong></td>
        <td width="162">: <strong>Rumah Sakit Umum Daerah</strong></td>
      </tr>
      <tr>
        <td><strong>KABUPATEN / KOTA</strong></td>
        <td>:<strong> Kabupaten Sidoarjo</strong></td>
      </tr>
      <tr>
        <td><strong>PROPINSI</strong></td>
        <td>:<strong> Jawa Timur</strong></td>
      </tr>
      <tr>
        <td></td>
        <td>
            <input type="hidden" id="cmbJnsBrg" name="cmbJnsBrg" value="<?php echo $jenisBarang;?>"/>
            <input type="hidden" id="cmbBln" name="cmbBln" value="<?php echo $bulan;?>"/>
            <input type="hidden" id="ta" name="ta" value="<?php echo $tahun;?>"/>
            <input type="hidden" id="level" name="level" value="<?php echo $level;?>"/>
            <input type="hidden" id="idBarang" name="idBarang" value="<?php echo $idBarang;?>"/>
            <input type="hidden" id="kodeBarang" name="kodeBarang" value="<?php echo $kodeBarang;?>"/>
        </td>
      </tr>
    </table>
    <p align="center">
        <strong>
            <font size="4" face="Times New Roman, Times, serif">
                LAPORAN STOK BULAN <?php echo strtoupper($namaBulan[$bulan])."&nbsp; TAHUN &nbsp;".$tahun;?>
            </font>
            <br/>
        </strong></p>
   
        
    <table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="100%">
      <tr align="center" valign="middle" bgcolor="#CCCCCC" class="HeaderBW">
        <td rowspan="2" width="3%">No</td>
        <td rowspan="2" width="8%">Kode</td>
        <td rowspan="2" width="20%">Barang</td>
        <td rowspan="2" width="8%">Satuan</td>
        <td colspan="2">Awal Bulan</td>
        <td colspan="2">Penerimaan</td>
        <td colspan="2">Pemakaian</td>
        <td colspan="2">Sisa</td>       
      </tr>
      <tr align="center" valign="middle" bgcolor="#CCCCCC" class="HeaderBW">
        <td width="8%">Jumlah</td>
        <td width="10%">Nilai</td>
        <td width="8%">Jumlah</td>
        <td width="10%">Nilai</td>
        <td width="8%">Jumlah</td>
        <td width="10%">Nilai</td>
        <td width="8%">Jumlah</td>
        <td width="10%">Nilai</td>
      </tr>
      
       <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
            <td height="10"><font size="-2">1</font></td>
            <td height="10"><font size="-2">2</font></td>
            <td height="10"><font size="-2">3</font></td>
            <td height="10"><font size="-2">4</font></td>
            <td height="10"><font size="-2">5</font></td>
            <td height="10"><font size="-2">6</font></td>
            <td height="10"><font size="-2">7</font></td>
            <td height="10"><font size="-2">8</font></td>
            <td height="10"><font size="-2">9</font></td>
            <td height="10"><font size="-2">10</font></td>
				<td height="10"><font size="-2">11</font></td>
            <td height="10"><font size="-2">12</font></td>

        </tr>
       <?php
       if($idBarang=='' || $kodeBarang==''){
            $qBrg="select idbarang,kodebarang,namabarang,tipe,level,idsatuan, islast from as_ms_barang where tipe='$jenisBarang' and level='$level' order by kodebarang";            
       }
       else{        
             $qBrg="select idbarang,kodebarang,namabarang,tipe,level,idsatuan, islast from as_ms_barang where tipe='$jenisBarang' and kodebarang like '$kodeBarang%' and level='$level' order by kodebarang";            
       }
	   //echo '<br>'.$qBrg;
       $rsBrg=mysql_query($qBrg);
        $no=1;
		$tot1 = 0;
		$tot2 = 0;
		$tot3 = 0;
		$tot4 = 0;
		$tot5 = 0;
		$tot6 = 0;
		$tot7 = 0;
		$tot8 = 0;
        while($rwBrg=mysql_fetch_array($rsBrg)){
			 	$kodeBrg = $rwBrg['kodebarang'];
            ?>
            <tr>
             <td align="center"><?php echo $no;?></td>
             <td><?php echo $rwBrg['kodebarang'];?></td>
             <td style="color:<?php echo ($rwBrg['islast']==1)?'#000000':'#020EF7';?>; cursor:pointer;" onClick="showChild('<?php echo $rwBrg['idbarang'];?>','<?php echo $rwBrg['kodebarang'];?>','<?php echo $rwBrg['level'];?>')" ><?php echo $rwBrg['namabarang'];?></td>
             <td align="center"><?php echo $rwBrg['idsatuan'];?></td>
             <?php
             
             	$dr = "select sum(awal_jml) AS awal_jml,sum(awal_nilai) AS awal_nilai from tutup_buku where bln='$bulan' and thn='$tahun' AND barang_id in (select idbarang from as_ms_barang where kodebarang like '".$rwBrg['kodebarang']."%' and level !=1 and tipe='$tipe')";
	//echo "1";
					$drt = "select sum(masuk_jml) AS masuk_jml,sum(keluar_jml) AS keluar_jml,sum(masuk_nilai) AS masuk_nilai,sum(keluar_nilai) AS keluar_nilai from tutup_buku where bln='$bulan' and thn='$tahun' AND barang_id in (select idbarang from as_ms_barang where kodebarang like '".$rwBrg['kodebarang']."%' and level !=1 and tipe='$tipe')";
					$dr1 = mysql_query($dr);
					$dr2 = mysql_fetch_array($dr1);
					$dr1t = mysql_query($drt);
					$dr2t = mysql_fetch_array($dr1t);   
					if($dr2['awal_jml']=='') $dr2['awal_jml']=0;
	if($dr2['awal_nilai']=='') $dr2['awal_nilai']=0;
	if($dr2t['masuk_jml']=='') $dr2t['masuk_jml']=0;
	if($dr2t['masuk_nilai']=='') $dr2t['masuk_nilai']=0;
	if($dr2t['keluar_jml']=='') $dr2t['keluar_jml']=0;
	if($dr2t['keluar_nilai']=='') $dr2t['keluar_nilai']=0;
	$jml_saldo = $dr2['awal_jml']+$dr2t['masuk_jml']-$dr2t['keluar_jml'];
	$nilai_saldo = $dr2['awal_nilai']+$dr2t['masuk_nilai']-$dr2t['keluar_nilai'];        
             ?>
             <td align="right" style="padding-right:10px;"><?php echo $dr2['awal_jml'];?></td>
             <td align="right" style="padding-right:10px;"><?php echo number_format($dr2['awal_nilai'],0,'','.');?></td>
             <td align="right" style="padding-right:10px;"><?php echo $dr2t['masuk_jml'];?></td>
             <td align="right" style="padding-right:10px;"><?php echo number_format($dr2t['masuk_nilai'],0,'','.');?></td>
             <td align="right" style="padding-right:10px;"><?php echo $dr2t['keluar_jml'];?></td>
             <td align="right" style="padding-right:10px;"><?php echo number_format($dr2t['keluar_nilai'],0,'','.');?></td>
             <td align="right" style="padding-right:10px;"><?php echo $jml_saldo;?></td>
             <td align="right" style="padding-right:10px;"><?php echo number_format($nilai_saldo,0,'','.');?></td>
            </tr>
            
            <?php
            $no++;
			$tot1 = $tot1 + $dr2['awal_jml'];
			$tot2 = $tot2 + $dr2['awal_nilai'];
			$tot3 = $tot3 + $dr2t['masuk_jml'];
			$tot4 = $tot4 + $dr2t['masuk_nilai'];
			$tot5 = $tot5 + $dr2t['keluar_jml'];
			$tot6 = $tot6 + $dr2t['keluar_nilai'];
			$tot7 = $tot7 + $jml_saldo;
			$tot8 = $tot8 + $nilai_saldo;
			
        }
		
       ?>
	   
            <tr style="font-weight:bold;">
              <td colspan="3" align="center" height="28">TOTAL</td>
              <td align="center">&nbsp;</td>
              <td align="right" style="padding-right:10px;"><?php echo $tot1;?></td>
              <td align="right" style="padding-right:10px;"><?php echo number_format($tot2,0,",",".");?></td>
              <td align="right" style="padding-right:10px;"><?php echo $tot3;?></td>
              <td align="right" style="padding-right:10px;"><?php echo number_format($tot4,0,",",".");?></td>
              <td align="right" style="padding-right:10px;"><?php echo $tot5;?></td>
              <td align="right" style="padding-right:10px;"><?php echo number_format($tot6,0,",",".");?></td>
              <td align="right" style="padding-right:10px;"><?php echo $tot7;?></td>
              <td align="right" style="padding-right:10px;"><?php echo number_format($tot8,0,",",".");?></td>
            </tr>
    </table>
   
<table width="1000" align="center">
<tr>
	<td colspan="4"><br /></td>
</tr>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center"><strong>Mengetahui,</strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong>Sidoarjo, <?php echo indonesian_date(); ?></strong></td>
</tr>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228"align="center"><strong>DIREKTUR RSUD </strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong>Pengurus Barang</strong></td>
</tr>
<tr>
	<td >&nbsp;</td>
	<td align="center"><strong>KABUPATEN SIDOARJO </strong></td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center"><strong><?php echo $r['dir_nama'] ?></strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['pengurus_nama'] ?></strong></td>
</tr>

<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['dir_nip'] ?></strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['pengurus_nip'] ?></strong></td>
</tr>
</table>
    <div id="divBtn" style="text-align:center;padding-top:30px;">
     <?php
    if($idBarang!='' && $kodeBarang!=''){
        ?>
        
        <input type="button" id="btnBack" name="back" value="Kembali" onClick="hideChild('<?php echo $idBarang;?>','<?php echo substr($kodeBarang,0,-3);?>','<?php echo $level;?>')"/>
        <?php
    }
    ?>
    <input type="button" id="btnPrint" name="btnPrint" value="Cetak" onClick="cetak()"/>
    <input type="button" id="btnClose" name="btnClose" value="Tutup" onClick="window.close()"/>
    </div>
    </form>    
    </body>
    <script type="text/javascript">
        function showChild(id,kode,level){
            document.getElementById("idBarang").value=id;
            document.getElementById("kodeBarang").value=kode;
            document.getElementById("level").value=parseInt(level)+1;
            document.form1.submit();
        }
        function hideChild(id,kode,level){
            document.getElementById("idBarang").value=id;
            document.getElementById("kodeBarang").value=kode;
            document.getElementById("level").value=parseInt(level)-1;
            document.form1.submit();
        }
        function cetak(){
            document.getElementById("divBtn").style.display='none';
            if(document.getElementById("divBtn").style.display='none'){
                if(window.print()){
                    window.close();
                }
            }
        }
    </script>
</html>