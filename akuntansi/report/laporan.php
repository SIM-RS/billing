<?php 
include "../sesi.php";
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s="01-01-".substr($th,6,4);
$cbln=(substr($tgl_s,3,1)=="0")?substr($tgl_s,4,1):substr($tgl_s,3,2);
$cthn=substr($tgl_s,6,4);
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$th;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$th=explode("-",$th);
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];

if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}

$id=$_REQUEST["id"];
$it=$_REQUEST["it"];
$iunit=$_REQUEST["iunit"];
if ($iunit==""){
	$iunit=$idunit."|".$usrname;
}else{
	$usrname=explode("|",$iunit);
	$usrname=$usrname[1];
}

$dsp_view="none";
$dsp_export="table-row";
$tampilback=0;

//laba rugi

$ta_lr=$_REQUEST['ta_lr'];

if ($ta_lr=="") $ta_lr=$th[2];

$bulan_l=$_REQUEST["bulan_lr"];
$bulan_lr=explode("|",$bulan_l);
$bulan_lr=$bulan_lr[0];
$nama_bulan=$bulan_lr[1];
if ($bulan_lr==""){
	$bulan_lr=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$a=1;
// end laba rugi

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Transaksi Jurnal</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>

<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<div align="center">
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
  	<input name="idma" id="idma" type="hidden" value="">
  	<input name="parent_lvl" id="parent_lvl" type="hidden" value="">
  	<input name="ccrvpbfumum" id="ccrvpbfumum" type="hidden" value="">
  	<input name="idccrvpbfumum" id="idccrvpbfumum" type="hidden" value="">
  	<input name="cc_islast" id="cc_islast" type="hidden" value="">
  	<input name="islast" id="islast" type="hidden" value="1">
    <input name="all_unit" id="all_unit" type="hidden" value="0">
	<input name="tgl2" id="tgl2" type="hidden" value="0">
<div id="input" style="display:block">
<?php if ($it=="1"){
$lnk="'../report/journal_print.php?&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&cuser='+cuser.value"; //decyber not_fix
?>
	  <p class="jdltable">Laporan Jurnal Keuangan</p>
      <table width="400" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <!--tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php //echo strtoupper($username); ?></td>
        </tr-->
        <tr> 
          <td width="70">Periode</td>
          <td width="10">:</td>
          <td><input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d2" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            &nbsp;&nbsp;&nbsp;s/d: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s2" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />          </td>
        </tr>
        <tr>
          <td>User Entry</td>
          <td>:</td>
          <td><select name="cuser" id="cuser" class="txtinput">
        	<option value="0">ALL USER</option>
        <?php 
		$sql="SELECT * FROM user_master WHERE kategori=2";
		$rs=mysql_query($sql);
		while ($rows=mysql_fetch_array($rs)){
		?>
        	<option value="<?php echo $rows['kode_user']; ?>"><?php echo strtoupper($rows['username']); ?></option>
        <?php 
		}
		?>
	      </select></td>
        </tr>
      </table>
<?php }elseif ($it=="2"){
	$lnk="'../report/bukubesar_print.php?idma='+idma.value+'&kode_ma='+kode_ma.value+'&bulan='+bulan.value+'&ta='+ta.value+'&idunit=$iunit&cislast='+islast.value+'&ccrvpbfumum='+ccrvpbfumum.value+'&idccrvpbfumum='+idccrvpbfumum.value+'&cc_islast='+cc_islast.value";
	$qstr_ma="par=idma*kode_ma*ma*islast*ccrvpbfumum*idccrvpbfumum*cc_islast";
	$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
?>
	  <p class="jdltable">Laporan Buku Besar</p>
      <table width="600" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr> 
          <td>Kode Akun</td>
          <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="16" maxlength="20" readonly="true" value="<?php echo $kode_ma; ?>" /> 
            <input type="button" name="Button" value="..." onclick="OpenWnd('../report/tree_ma_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)" />
          </td>
        </tr>
        <tr> 
          <td>Nama Akun</td>
          <td>:</td>
          <td><textarea name="ma" cols="55" rows="2" readonly="true" id="ma"><?php echo $ma; ?></textarea></td>
        </tr>
        <tr> 
          <td>Bulan</td>
          <td width="10">:</td>
          <td><select name="bulan" id="bulan">
              <option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
              <option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
              <option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
              <option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
              <option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
              <option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
              <option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
              <option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
              <option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
              <option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
              <option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
              <option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td width="10">:</td>
          <td><select name="ta" id="ta">
              <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
        </tr>
      </table>
<?php }elseif ($it=="3"){
	$dsp_view="table-row";
	$dsp_export="block";
	$lnk="'../report/lap_neraca_xls.php?tgl2='+tgl2.value+'&bln1='+bln1.value+'&ta1='+ta1.value+'&bln2='+bln2.value+'&ta2='+ta2.value";
	$lnk_view="'../report/lap_neraca.php?tgl2='+tgl2.value+'&bln1='+bln1.value+'&ta1='+ta1.value+'&bln2='+bln2.value+'&ta2='+ta2.value+'&sak_sap='+sak_sap.value";
?>
	  <p class="jdltable">Laporan Neraca Keuangan</p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr style="display:none"> 
          <td>Jenis</td>
          <td width="12">:</td>
          <td><select name="sak_sap" id="sak_sap">
              <option value="0">SAK</option>
              <option value="1">SAP</option>
            </select></td>
        </tr>
        <tr> 
          <td>Periode</td>
          <td width="12">:</td>
          <td><select name="periode" id="periode" onchange="document.getElementById('per2').style.display=this.value;if (this.value=='block') document.getElementById('tgl2').value='1'; else document.getElementById('tgl2').value='0';">
              <option value="none">1 Periode</option>
              <option value="block">2 Periode</option>
            </select></td>
        </tr>
        <tr> 
          <td width="70">Bulan</td>
          <td>:</td>
          <td width="168"><select name="bln1" id="bln1">
              <option value="1|JANUARI"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
              <option value="2|PEBRUARI"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
              <option value="3|MARET"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
              <option value="4|APRIL"<?php if ($bulan=="4") echo " selected";?>>April</option>
              <option value="5|MEI"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
              <option value="6|JUNI"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
              <option value="7|JULI"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
              <option value="8|AGUSTUS"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
              <option value="9|SEPTEMBER"<?php if ($bulan=="9") echo " selected";?>>September</option>
              <option value="10|OKTOBER"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
              <option value="11|NOPEMBER"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
              <option value="12|DESEMBER"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
            </select></td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td>:</td>
          <td><select name="ta1" id="ta1">
              <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td colspan="3">
		  <div id="per2" style="display:none">
		  	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="txtinput">
                <tr> 
                  <td width="70" height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td width="168" height="25">dan</td>
                </tr>
                <tr> 
                  <td>Bulan</td>
                  <td>:</td>
                  <td><select name="bln2" id="bln2">
					  <option value="1|JANUARI"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
					  <option value="2|PEBRUARI"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
					  <option value="3|MARET"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
					  <option value="4|APRIL"<?php if ($bulan=="4") echo " selected";?>>April</option>
					  <option value="5|MEI"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
					  <option value="6|JUNI"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
					  <option value="7|JULI"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
					  <option value="8|AGUSTUS"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
					  <option value="9|SEPTEMBER"<?php if ($bulan=="9") echo " selected";?>>September</option>
					  <option value="10|OKTOBER"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
					  <option value="11|NOPEMBER"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
					  <option value="12|DESEMBER"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
                    </select> </td>
                </tr>
                <tr> 
                  <td>Tahun</td>
                  <td width="12">:</td>
                  <td><select name="ta2" id="ta2">
                      <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
                      <option value="<?php echo $i; ?>"<?php if ($i==($ta-1)) echo " selected";?>><?php echo $i; ?></option>
                      <?php }?>
                    </select> </td>
                </tr>
              </table>
			</div>
		  </td>
        </tr>
      </table>
	  
<?php }elseif ($it=="19"){
	$dsp_view="table-row";
	$dsp_export="block";
	$lnk="'../report/lapLR_Rekap.php?excel=excel&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value";
	$lnk_view="'../report/lapLR_Rekap.php?bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value";
?>
	  <p class="jdltable">Laporan Rakap Rugi Laba</p>
	  
	  <table width="502" border="0" cellspacing="0" cellpadding="0" class="txtinput">
            <tr>
              <td width="140" height="31" align="left">Jenis Beban </td>
              <td colspan="2" align="left">:</td>
              <td width="339" align="left"><select name="jbeban" id="jbeban">
                <option value="0"<?php if ($jbeban=="0") echo " selected";?>>Menurut Pusat Pelayanan</option>
                <option value="1"<?php if ($jbeban=="1") echo " selected";?>>Menurut Jenis</option>
              </select></td>
            </tr>
            <tr>
              <td align="left">Bulan </td>
              <td colspan="2" align="left">:</td>
              <td align="left"><select name="bulan_lr" id="bulan_lr">
                <option value="1|JANUARI"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|PEBRUARI"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|MARET"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|APRIL"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|MEI"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|JUNI"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|JULI"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|AGUSTUS"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|SEPTEMBER"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|OKTOBER"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|NOPEMBER"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|DESEMBER"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                </select>&nbsp;&nbsp;
			  
				<select name="ta_lr" id="ta_lr">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
				<option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select></td>
        </tr>
      </table>
<?php }elseif ($it=="20"){
	$dsp_view="table-row";
	$dsp_export="block";
	$lnk="'../report/lapLR_Detail.php?excel=excel&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value";
	$lnk_view="'../report/lapLR_Detail.php?bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value";
?>
	   <p class="jdltable">Laporan Detail Rugi Laba</p>
	  
	  <table width="502" border="0" cellspacing="0" cellpadding="0" class="txtinput">
            <tr>
              <td width="140" height="37" align="left">Jenis Beban </td>
              <td colspan="2" align="left">:</td>
              <td width="339" align="left"><select name="jbeban" id="jbeban">
                <option value="0"<?php if ($jbeban=="0") echo " selected";?>>Menurut Pusat Pelayanan</option>
                <option value="1"<?php if ($jbeban=="1") echo " selected";?>>Menurut Jenis</option>
              </select></td>
            </tr>
            <tr>
              <td align="left">Bulan </td>
              <td colspan="2" align="left">:</td>
              <td align="left"><select name="bulan_lr" id="bulan_lr">
                 <option value="1|JANUARI"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|PEBRUARI"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|MARET"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|APRIL"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|MEI"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|JUNI"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|JULI"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|AGUSTUS"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|SEPTEMBER"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|OKTOBER"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|NOPEMBER"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|DESEMBER"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                </select>&nbsp;&nbsp;
			  
				<select name="ta_lr" id="ta_lr">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
				<option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select></td>
        </tr>
      </table>
<?php }elseif ($it=="4"){
	
$sak_sap=$_REQUEST["sak_sap"];
if ($sak_sap=="") $sak_sap="1";
if ($sak_sap=="1"){
  $jdl_lap="Laporan Arus Kas";
  $tbl_lap="lap_arus_kas";
}else{
  $jdl_lap="Laporan Arus Kas";
  //$tbl_lap="lap_lak_sap";
  $tbl_lap="lap_arus_kas";
}
$lnk="'../report/arus_kas_excell.php?sak_sap=".$sak_sap."&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
  <p class="jdltable"><?php echo $jdl_lap; ?></p>
    <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
      <tr>
        <td width="60">Periode</td>
        <td width="12">:</td>
        <td valign="middle">
          <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
          <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
          &nbsp;&nbsp;s/d&nbsp;&nbsp;
          <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
          <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=4&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
          <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
          Lihat</button> 
        </td>
      </tr>
    </table><br />
    <div>

    <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
      <tr>
        <td width="30" align="center">No</td>
        <td align="center">Uraian</td>
        <td width="100" align="center">Nilai Debit</td>
        <td width="100" align="center">Nilai Kredit</td>
        <td width="100" align="center">Total Nilai</td>
      </tr>
      <?php 
    $subtot=array(15);
    $no_urut_lvl1=array('I','II','III','IV','V','VI','VII','VIII');
    //echo "no_urut_lvl1-5=".$no_urut_lvl1[4];
    //echo ord("a");
    for ($i=0;$i<14;$i++) $subtot[$i]=0;
    $sql="SELECT * FROM $tbl_lap ORDER BY kode";
    $rs=mysql_query($sql);
    $tmpkel=0;$tmpkat=0;
    $cno_urut1=0;$cno_urut2=0;
    while ($rows=mysql_fetch_array($rs)){
      // $ckode=$rows["kode_ma_sak"];
      $ckodeDebit=$rows["debit"];
      $ckodeKredit=$rows["kredit"];
      $ckode_label=$rows["kode_label"];
      $cbr=$rows["br"];
      $cinduk=$rows["id"];
      $cformula=str_replace(" ","",$rows["formula"]);
      $ckelompok=$rows["kelompok"];
      $cdk=$rows["d_k"];
      $ckategori=$rows["kategori"];
      $ctype=$rows["type"];
      $nilaiDebit=($ckelompok==0)?"":"-"; //untuk nilai debit
      $nilaiKredit=($ckelompok==0)?"":"-"; //untuk nilai kredit
      $nilaiTotal=($ckelompok==0)?"":"-"; //untuk nilai kredit
      $clevel=$rows["level"];
      
      //$cbr=0;
      //if ($ckategori==2 && $clevel==3){
      //  $cbr=1;
      //}
      
      if ($clevel==1){
        $cno_urut1++;
        $clblNoUrut=$no_urut_lvl1[$cno_urut1-1];
        $cno_urut2=0;
        $cno_urut3=96;
      }elseif ($clevel==2){
        $cno_urut2++;
        $clblNoUrut=$cno_urut2;
        $cno_urut3=96;
      }else{
        if ($ckategori==1 || $ckategori==3){
          $cno_urut3++;
          $clblNoUrut=chr($cno_urut3);
        }else{
          $clblNoUrut="";
          //$cbr=1;
        }
      }

      if ($ckodeDebit!="" || $ckodeKredit!=""){
      if ($ckodeDebit!=""){
        $ckodear=explode(",",$ckodeDebit);
        $cstr="";
        if (($rows["id"]==9) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodear);$i++){
            if ($ckodear[$i]=='2110102'){
              $cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
            }else{
              $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
            }
          }
        }elseif(($rows["id"]==10) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodear);$i++){
            if ($ckodear[$i]=='2110102'){
              $cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
            }else{
              $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
            }
          }
        }else{
          for ($i=0;$i<count($ckodear);$i++){
            $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
          }
        }
        $cstr=substr($cstr,0,strlen($cstr)-4);
        //echo $cstr."<br>";
        //if ($ckelompok==1 or $ckelompok==4){
          if ($ctype==0){
            $sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4"; //decyber_arus_kas
          }else{
            $sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";//decyber_arus_kas
          }
        // }
        //echo $sql."<br>";
        /*if ($ckode=='411'){
          echo $sql."<br>";
        }*/
        $rs1=mysql_query($sql);
        if ($rows1=mysql_fetch_array($rs1)){
          $nilaiD = $rows1["NILAI"];
          $nilaiDebit=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
          if ($nilaiDebit!="-"){
            $subtotD[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }
        
        // PERHITUNGAN NILAI KREDIT

        if ($ckodeKredit!=""){

        $ckodearK=explode(",",$ckodeKredit);
        $cstrK="";
        if (($rows["id"]==9) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodearK);$i++){
            if ($ckodearK[$i]=='2110102'){
              $cstrK .="(MA_KODE LIKE '".$ckodearK[$i]."%' AND FK_LAST_TRANS=357) OR ";
            }else{
              $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
            }
          }
        }elseif(($rows["id"]==10) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodearK);$i++){
            if ($ckodearK[$i]=='2110102'){
              $cstrK .="(MA_KODE LIKE '".$ckodearK[$i]."%' AND FK_LAST_TRANS<>357) OR ";
            }else{
              $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
            }
          }
        }else{
          for ($i=0;$i<count($ckodearK);$i++){
            $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
          }
        }
        $cstrK=substr($cstrK,0,strlen($cstrK)-4);
        //echo $cstrK."<br>";
        //if ($ckelompok==1 or $ckelompok==4){
        // if ($cdk=='K'){
          if ($ctype==0){
            $sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstrK)) AS t4"; //decyber_arus_kas
          }else{
            $sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1' ) AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstrK)) AS t4"; //decyber_jurnal
          }
              // }
        //echo $sql."<br>";
        /*if ($ckode=='411'){
          echo $sql."<br>";
        }*/
        $rs1=mysql_query($sql);
        if ($rows1=mysql_fetch_array($rs1)){
          $nilaiK = $rows1["NILAI"];
          $nilaiKredit=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
          if ($nilaiKredit!="-"){
            $subtotK[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }        
          // $nilaiTotal=($nilaiDebit=="-" && $nilaiKredit=="-")?"-":number_format($nilaiDebit-$nilaiKredit,2,",",".");
          // echo $nilaiDebit;
        // if($nilaiDebit=="-" && $nilaiKredit=="-"){
      if ($ckodeDebit!="" && $ckodeKredit!=""){
          $nilaiTotal = ($nilaiD=="-" && $nilaiK=="-")?"-":number_format($nilaiD+$nilaiK,2,",",".");
        }elseif($ckodeDebit!="" && $ckodeKredit==""){
          $nilaiTotal = ($nilaiD=="-")?"-":number_format($nilaiD,2,",",".");
        }elseif($ckodeDebit=="" && $ckodeKredit!=""){
          // echo $nilaiK;
          $nilaiTotal = ($nilaiK=="-")?"-":number_format($nilaiK,2,",",".");
      }
        // }else{
        //   $nilaiTotal = "-";
        // }

      }else{
        if ($ckategori==2){
          $cform=array();
          $j=0;
          for ($i=0;$i<strlen($cformula);$i++){
            if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
              $cform[$j]=substr($cformula,$i,1);
              $j++;
            }
          }
          // var_dump($cform);
          // echo "count=".count($cform)."<br>";
          $cdata=str_replace("-",",",$cformula);
          $cdata=str_replace("+",",",$cdata);
          $cdata=explode(",",$cdata);
          $cnilaiD=$subtotD[$cdata[0]-1];
          $cnilaiK=$subtotK[$cdata[0]-1];
          //echo $cnilai."<br>";
          for ($i=1;$i<count($cdata);$i++){
            $cnilaiD=($cform[$i-1]=="-")?($cnilaiD-$subtotD[$cdata[$i]-1]):($cnilaiD+$subtot[$cdata[$i]-1]);
            $cnilaiK=($cform[$i-1]=="-")?($cnilaiK-$subtotK[$cdata[$i]-1]):($cnilaiK+$subtot[$cdata[$i]-1]);
            //echo $subtot[$cdata[$i]-1]."<br>";
          }
          if ($cnilaiD<0 && $cnilaiK<0){
            $nilaiDebit="(".number_format(abs($cnilaiD),2,",",".").")";
            $nilaiKredit="(".number_format(abs($cnilaiK),2,",",".").")";
            $nilaiTotal = "(".number_format(abs($cnilaiD+$cnilaiK),2,",",".").")";
          }else{
            $nilaiDebit=number_format($cnilaiD,2,",",".");
            $nilaiKredit=number_format($cnilaiK,2,",",".");
            $nilaiTotal=number_format($cnilaiD+$cnilaiK,2,",",".");
          }
          // $nilaiTotal=number_format($cnilaiD-$cnilaiK,2,",",".");
        }elseif ($ckategori==3){
          $sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn) AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '1.1.01%'";//decyber_arus_kas
          // echo $sql."<br>";
          $rs1=mysql_query($sql);
          if ($rows1=mysql_fetch_array($rs1)){
            if ($rows1["NILAI"]<0)
              $nilai="(".number_format(abs($rows1["NILAI"]),2,",",".").")";
            else
              $nilai=number_format($rows1["NILAI"],2,",",".");
            $subtot[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }
      //echo $ckategori."<br>";
    ?>
      <tr>
        <td width="30" align="center"><?php echo $ckode_label; ?></td>
        <td align="left">&nbsp;<?php echo $rows["uraian"]; ?></td>
        <?php if ($ckodeDebit=="" or $nilaiDebit=="-"){?>
          <td width="100" align="right"><?php echo $nilaiDebit; ?></td>
          <?php }else{?>
            <td width="100" align="right"><a href="?f=../report/arus_kas_detail.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&kodema=<?php echo $ckodeDebit; ?>&kelompok=<?php echo $ckelompok; ?>&type=<?php echo $ctype; ?>&cinduk=<?php echo $cinduk; ?>&ckel=<?php echo $rows["uraian"].' Debit'; ?>&cdk=<?php echo $cdk; ?>"><?php echo $nilaiDebit; ?></a></td>
      <?php }?>

      <?php if ($ckodeKredit=="" or $nilaiKredit=="-"){?>
          <td width="100" align="right"><?php echo $nilaiKredit; ?></td>
          <?php }else{?>
            <td width="100" align="right"><a href="?f=../report/arus_kas_detail.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&kodema=<?php echo $ckodeKredit; ?>&kelompok=<?php echo $ckelompok; ?>&type=<?php echo $ctype; ?>&cinduk=<?php echo $cinduk; ?>&ckel=<?php echo $rows["uraian"].' Kredit'; ?>&cdk=<?php echo $cdk; ?>"><?php echo $nilaiKredit; ?></a></td>
      <?php }?>

    <td width="100" align="right"><?php echo $nilaiTotal; ?></td>
    </tr>
    <!-- <td><?php
echo $nilaidebit;
echo $nilaikredit;
echo $nilaikredit- $nilaidebit;
    ?>
    </td> -->
      <?php 
    if ($cbr==1){
  ?>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
  <?php
    }
  }
  ?>
    </table>
    </div>
	<?php 
	}elseif ($it=="5"){
		$sak_sap=$_REQUEST["sak_sap"];
		if ($sak_sap=="") $sak_sap="1";
		if ($sak_sap=="1"){
			$jdl_lap="Laporan Rugi Laba";
			$tbl_lap="lap_arus_kas";
		}else{
			$jdl_lap="Laporan Rugi Laba";
			$tbl_lap="lap_lak_sap";
			
		}
		
		$tipe=$_REQUEST["tipe"];
		$ma_kode=$_REQUEST["ma_kode"];
		if ($sak_sap=="1"){
	?>
      	<?php 
			if ($tipe=="detail"){
				$lnk="'../report/operasional_excell_detail.php?sak_sap=".$sak_sap."&tipe=detail&ma_kode=$ma_kode&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value";
			
				$tampilback=1;
				$sql="SELECT * FROM ma_sak WHERE MA_KODE='$ma_kode'";
				//echo $sql."<br>";
				$rsMa=mysql_query($sql);
				$rwMa=mysql_fetch_array($rsMa);
				$clvl=$rwMa["MA_LEVEL"]+1;
	  	?>
      		<p class="jdltable">Laporan Rugi Laba : <?php echo $rwMa["MA_NAMA"]; ?></p>
          	<table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
			<tr>
              <td colspan="3" align="center">Bulan :
                <select name="bulan_lr" id="bulan_lr">
                <option value="1|Januari"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                </select>&nbsp;&nbsp;
			  
			  <select name="ta_lr" id="ta_lr">
                <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
                <option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
                <?php }?>
                </select>
&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
              </tr>
            <tr style="display:none"> 
              <td width="60">Periode</td>
              <td width="12">:</td>
              <td valign="middle"> 
                <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                &nbsp;&nbsp;s/d&nbsp;&nbsp;
                <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                Lihat</button> 
              </td>
            </tr>
          	</table><br />
              <table width="800" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                <tr>
                  <td width="50" align="center">No</td>
                  <td align="center">Uraian</td>
                  <td width="160" align="center"><?php if($bulan_lr < 3){ echo '1'."-".$ta_lr; }else{ echo '1'."-".$ta_lr." Sdg ".($bulan_lr-1)."-".$ta_lr ;} ?> </td>
				  <td width="160" align="center"><?php echo $bulan_lr."-".$ta_lr;?></td>
                </tr>
                <?php 
					$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=$clvl AND MA_KODE like '$ma_kode%'";
					$rsMa=mysql_query($sql);
					$j=1;
					$stot=0;
					while ($rwMa=mysql_fetch_array($rsMa)){
					
					$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
						//decyber_arus_kas
						$rsNilai=mysql_query($sql);
						$rwNilai=mysql_fetch_array($rsNilai);
						$stot+=$rwNilai["nilai"];
						$stot2+=$rwNilai["nilai2"];
				?>
                <tr>
                  <td align="center"><?php echo $rwMa["MA_KODE"]; ?></td>
				  
                  <?php 
				  		if (($rwNilai["nilai"]>0) && ($rwMa["MA_ISLAST"]==0)){
				  ?>
                  <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rwMa["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rwMa["MA_NAMA"]; ?></a></td>
                  <?php 
				  		}else{
				  ?>
                  <td align="left">&nbsp;<?php echo $rwMa["MA_NAMA"]; ?></td>
                  <?php 
				  	}
				  ?>
                  <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai"],2,",","."); ?></td>
				  <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai2"],2,",","."); ?></td>
                </tr>
                <?php 
					}
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Subtotal :</td>
                  <td align="right">&nbsp;<?php echo number_format($stot,2,",","."); ?></td>
				  <td align="right">&nbsp;<?php echo number_format($stot2,2,",","."); ?></td>
                </tr>
              </table>
      	<?php 
			}else{
				$lnk="'../report/operasional_excell.php?sak_sap=".$sak_sap."&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value";
	  	?>
	  		<p class="jdltable">Laporan Rugi Laba</p>
          	<table width="599" border="0" cellspacing="0" cellpadding="0" class="txtinput">
            <tr>
              <td colspan="3" align="center">Bulan :
                <select name="bulan_lr" id="bulan_lr">
                <option value="1|Januari"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                </select>&nbsp;&nbsp;
			  
			  <select name="ta_lr" id="ta_lr">
                <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
                <option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
                <?php }?>
                </select>
&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
              </tr>
            <tr style="display:none">
              <td width="112">Periode</td>
              <td width="22">:</td>
              <td width="366" valign="middle"> 
                <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                &nbsp;&nbsp;s/d&nbsp;&nbsp;
                <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                Lihat</button> </td>
            </tr>
          	</table>
          	<br />
          	<div>
              <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                <tr>
                  <td width="30" align="center">No</td>
                  <td align="center">Uraian</td>
                  <td width="160" align="center"><?php if($bulan_lr < 3){ echo '1'."-".$ta_lr; }else{ echo '1'."-".$ta_lr." Sdg ".($bulan_lr-1)."-".$ta_lr ;} ?> </td>
				  <td width="160" align="center"><?php echo $bulan_lr."-".$ta_lr;?></td>
                </tr>
                <tr>
                  <td align="center">4.1</td>
                  <td align="left">&nbsp;Pendapatan Pelayanan RS PHCM</td>
                  <td align="right">&nbsp;</td>
				   <td align="right">&nbsp;</td>
                </tr>
                <?php 
                $sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '4.1%'";
				//echo $sql."<br>";
                $rs=mysql_query($sql);
                $i=0;
                $stotOp=0;
                $stotBiayaOp=0;
				$stotBiayaOTL=0;
				$stotBiayaPO=0;
                while ($rw=mysql_fetch_array($rs)){
                    $i++;
                    $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					UNION
					SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
                    $rs1=mysql_query($sql);
                    $rw1=mysql_fetch_array($rs1);
                    $stotOp+=$rw1["nilai"];
					$stotOp2+=$rw1["nilai2"];
                ?>
                <tr>
                  <td width="30" align="center"><?php echo $rw["MA_KODE"]; ?></td>
				  
				  
                 
				  
				   <?php 
                  if ( (($rw1["nilai"]>0) && ($rw["MA_ISLAST"]==0)) or (($rw1["nilai2"]>0) && ($rw["MA_ISLAST"]==0)) ){
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rw["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $rw["MA_NAMA"]; ?></a></td>
                  <?php 
                  }else{
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<?php echo $rw["MA_NAMA"]; ?></td>
                  <?php 
                  }
                  ?>
				  
				   <td width="160" align="right"> <?php echo number_format($rw1["nilai"],2,",","."); ?></td>
			
				   <td width="160" align="right"> <?php echo number_format($rw1["nilai2"],2,",","."); ?></td>
				
				  
				  
                </tr>
                <?php 
                }
                ?>
                <tr>
                  <td width="30" align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH : </td>
                  <td width="160" align="right"><?php echo number_format($stotOp,2,",","."); ?></td>
				  <td width="160" align="right"><?php echo number_format($stotOp2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td width="30" align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td width="160" align="right">&nbsp;</td>
				  <td width="160" align="right">&nbsp;</td>
                </tr>
                <?php 
				$kodeMaOp="810";
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$cma_id=$rwB["MA_ID"];
				?>
                <tr>
                  <td width="30" align="center"><?php echo $kodeMaOp; ?></td>
                  <td align="left">&nbsp;Biaya Pelayanan RS PHCM</td>
                  <td width="160" align="right">&nbsp;</td>
                </tr>
                <?php 
				$kodeMaUmum="826";
				$kodeMaBPOKawaka="831";
				$kodeMaBPOUmum="832";
				$kodeMaBPOKeu="833";
				$kodeMaBPOTeknik="834";
				//decyber_not_fix
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT = '$cma_id' ORDER BY MA_KODE";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				while ($rwB=mysql_fetch_array($rsB)){
					$kode_MA_BPO=$rwB["MA_KODE"];
					$kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
					$nama_MA_BPO=$rwB["MA_NAMA"];
					
					$sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
					
					
					$rsBPOSub=mysql_query($sqlBPOSub);
					$rwBPOSub=mysql_fetch_array($rsBPOSub);
					$biayaBPO=$rwBPOSub["nilai"];
					$biayaBPO2=$rwBPOSub["nilai2"];
					$stotBiayaOp +=$biayaBPO;
					$stotBiayaOp2 +=$biayaBPO2;
				?>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BPO; ?></td>

				   <?php 
                  if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp<?php echo $nama_MA_BPO; ?></td>
                  <?php 
                  }
                  ?>
                  <td width="160" align="right"><?php echo number_format($biayaBPO,2,",","."); ?></td>
                  <td width="160" align="right"><?php echo number_format($biayaBPO2,2,",","."); ?></td>
               
                </tr>
                <?php 
				}
				?>
                <tr>
                  <td width="30" align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH : </td>
                  <td width="160" align="right"><?php echo number_format($stotBiayaOp,2,",","."); ?></td>
				  <td width="160" align="right"><?php echo number_format($stotBiayaOp2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php 
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BOp=$rwB["MA_KODE_KP"];
				
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaUmum'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BUmum=$rwB["MA_KODE_KP"];
				
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKawaka'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BKaWaka=$rwB["MA_KODE_KP"];
				
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOUmum'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BPOUmum=$rwB["MA_KODE_KP"];
				
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKeu'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BPOKeu=$rwB["MA_KODE_KP"];
				
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOTeknik'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$kode_MA_BPOTeknik=$rwB["MA_KODE_KP"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
				
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaUmum=$rw1["nilai"];
				$biayaUmum2=$rw1["nilai2"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOKaWaka=$rw1["nilai"];
				$biayaBPOKaWaka2=$rw1["nilai2"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOUmum=$rw1["nilai"];
				$biayaBPOUmum2=$rw1["nilai2"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOKeu=$rw1["nilai"];
				$biayaBPOKeu2=$rw1["nilai2"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOTeknik=$rw1["nilai"];
				$biayaBPOTeknik2=$rw1["nilai2"];
				
				$stotBiayaOTL +=$biayaUmum;
				$stotBiayaOTL2 +=$biayaUmum2;
				$stotBiayaPO=$biayaBPOKaWaka+$biayaBPOUmum+$biayaBPOKeu+$biayaBPOTeknik;
				$stotBiayaPO2=$biayaBPOKaWaka2+$biayaBPOUmum2+$biayaBPOKeu2+$biayaBPOTeknik2;
				$stotBOTL_BPO=$stotBiayaOTL+$stotBiayaPO;
				$stotBOTL_BPO2=$stotBiayaOTL2+$stotBiayaPO2;
				$totalBiayaOp=$stotBiayaOp+$stotBOTL_BPO;
				$totalBiayaOp2=$stotBiayaOp2+$stotBOTL_BPO2;
				$LB_Op=$stotOp-$totalBiayaOp;
				$LB_Op2=$stotOp2-$totalBiayaOp2;
				$lblLB_Op=($LB_Op<0)?"(".number_format(abs($LB_Op),2,",",".").")":number_format($LB_Op,2,",",".");
				$lblLB_Op2=($LB_Op2<0)?"(".number_format(abs($LB_Op2),2,",",".").")":number_format($LB_Op2,2,",",".");
                ?>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BUmum; ?></td>
				 
				   <?php 
                  if ($biayaUmum>0 || $biayaUmum2>0){
                  ?>
                  <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaUmum; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya OTL</a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;Biaya OTL</td>
                  <?php 
                  }
                  ?>
			
                   <td width="160" align="right"><?php echo number_format($biayaUmum,2,",","."); ?></td>
                   <td width="160" align="right"><?php echo number_format($biayaUmum2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
				  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Biaya Penunjang Operasi (BPO)</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BKaWaka; ?></td>
				
				  <?php 
                  if ($biayaBPOKaWaka>0 || $biayaBPOKaWaka2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOKawaka; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Ka/Waka RSPM</a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Ka/Waka RSPM</td>
                  <?php 
                  }
                  ?>
				  
				  
                 <td width="160" align="right"><?php echo number_format($biayaBPOKaWaka,2,",","."); ?></td>
                 
                 <td width="160" align="right"><?php echo number_format($biayaBPOKaWaka2,2,",","."); ?></td>
                 
                </tr>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BPOUmum; ?></td>
				 
				   <?php 
                  if ($biayaBPOUmum>0 || $biayaBPOUmum2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOUmum; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Umum</a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Umum</td>
                  <?php 
                  }
                  ?>
				  
                 <td width="160" align="right"><?php echo number_format($biayaBPOUmum,2,",","."); ?></td>
                 
                 <td width="160" align="right"><?php echo number_format($biayaBPOUmum2,2,",","."); ?></td>
               
                </tr>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BPOKeu; ?></td>
				  
				   <?php 
                  if ($biayaBPOKeu>0 || $biayaBPOKeu2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOKeu; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Keuangan</a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Keuangan</td>
                  <?php 
                  }
                  ?>
				  
                  <td width="160" align="right"><?php echo number_format($biayaBPOKeu,2,",","."); ?></td> 
                  <td width="160" align="right"><?php echo number_format($biayaBPOKeu2,2,",","."); ?></td>
                 
                 
                </tr>
                <tr>
                  <td width="30" align="center"><?php echo $kode_MA_BPOTeknik; ?></td>
				   <?php 
                  if ($biayaBPOTeknik>0 || $biayaBPOTeknik2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOTeknik; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Teknik</a></td>
                  <?php 
                  }else{
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Teknik</td>
                  <?php 
                  }
                  ?>
                 
                 <td width="160" align="right"><?php echo number_format($biayaBPOTeknik,2,",","."); ?></td>     
                 <td width="160" align="right"><?php echo number_format($biayaBPOTeknik2,2,",","."); ?></td>
                 
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH (BOTL + BPO) : </td>
                  <td align="right"><?php echo number_format($stotBOTL_BPO,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($stotBOTL_BPO2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH BIAYA OPERASI : </td>
                  <td align="right"><?php echo number_format($totalBiayaOp,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($totalBiayaOp2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI OPERASI : </td>
                  <td align="right"><?php echo $lblLB_Op; ?></td>
				  <td align="right"><?php echo $lblLB_Op2; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php 				
				$kodePend_Dluar="791";
				$kodeBiaya_Dluar="891";
				$kodePos_Dluar="901";
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
				//decyber_arus_kas
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
				$Pend_DLuarUsaha=$rw1["nilai"];
				$Pend_DLuarUsaha2=$rw1["nilai2"];
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";
				//decyber_arus_kas
				
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
				$Biaya_DLuarUsaha=$rw1["nilai"];
				$Biaya_DLuarUsaha2=$rw1["nilai2"];
                
               	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag'
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr AND j.flag = '$flag') t ";//decyber_arus_kas
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
				$Pos_DLuarUsaha=$rw1["nilai"];
				$Pos_DLuarUsaha2=$rw1["nilai2"];
				
				$SelPendBiaya_DLuar = $Pend_DLuarUsaha - $Biaya_DLuarUsaha;
				$SelPendBiaya_DLuar2 = $Pend_DLuarUsaha2 - $Biaya_DLuarUsaha2;
				$LR_SblmPajak = $LB_Op + $SelPendBiaya_DLuar - $Pos_DLuarUsaha;
				$LR_SblmPajak2 = $LB_Op2 + $SelPendBiaya_DLuar2 - $Pos_DLuarUsaha2;
				$lblSelPendBiaya_DLuar=($SelPendBiaya_DLuar<0)?"(".number_format(abs($SelPendBiaya_DLuar),2,",",".").")":number_format($SelPendBiaya_DLuar,2,",",".");
				$lblSelPendBiaya_DLuar2=($SelPendBiaya_DLuar2<0)?"(".number_format(abs($SelPendBiaya_DLuar2),2,",",".").")":number_format($SelPendBiaya_DLuar2,2,",",".");
				$lblLR_SblmPajak=($LR_SblmPajak<0)?"(".number_format(abs($LR_SblmPajak),2,",",".").")":number_format($LR_SblmPajak,2,",",".");
				$lblLR_SblmPajak2=($LR_SblmPajak2<0)?"(".number_format(abs($LR_SblmPajak2),2,",",".").")":number_format($LR_SblmPajak2,2,",",".");
                ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;PENDAPATAN / BIAYA DILUAR USAHA</td>
                  <td align="right">&nbsp;</td>
				  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><?php echo $kodePend_Dluar; ?></td>
                  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($Pend_DLuarUsaha2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td align="center"><?php echo $kodeBiaya_Dluar; ?></td>
                  <td align="left">&nbsp;&nbsp;&nbsp;BIAYA DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($Biaya_DLuarUsaha2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
				  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;SELISIH PEND / BIAYA DILUAR USAHA : </td>
                  <td align="right"><?php echo $lblSelPendBiaya_DLuar; ?></td>
				   <td align="right"><?php echo $lblSelPendBiaya_DLuar2; ?></td>
                </tr>
                <tr>
                  <td align="center"><?php echo $kodePos_Dluar; ?></td>
                  <td align="left">&nbsp;POS-POS DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha,2,",","."); ?></td>
				   <td align="right"><?php echo number_format($Pos_DLuarUsaha2,2,",","."); ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI SEBELUM PAJAK : </td>
                  <td align="right"><?php echo $lblLR_SblmPajak; ?></td>
				  <td align="right"><?php echo $lblLR_SblmPajak2; ?></td>
                </tr>
              </table>
    </div>
		<?php
			}
		}else{
			if ($tipe=="detail"){
				$lnk="'../report/operasional_excell_detail.php?sak_sap=".$sak_sap."&tipe=detail&ma_kode=$ma_kode&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
			
				$tampilback=1;
				$sql="SELECT * FROM ma_sak WHERE MA_KODE='$ma_kode'";
				//echo $sql."<br>";
				$rsMa=mysql_query($sql);
				$rwMa=mysql_fetch_array($rsMa);
				$clvl=$rwMa["MA_LEVEL"]+1;
		?>
                <p class="jdltable">Laporan Operasional SAP : <?php echo $rwMa["MA_NAMA"]; ?></p>
                <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
                <tr> 
                  <td width="60">Periode</td>
                  <td width="12">:</td>
                  <td valign="middle"> 
                    <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                    <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                    &nbsp;&nbsp;s/d&nbsp;&nbsp;
                    <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                    <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
                    <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                    Lihat</button> 
                  </td>
                </tr>
                </table><br />
                  <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                    <tr>
                      <td width="30" align="center">No</td>
                      <td align="center">Uraian</td>
                      <td width="160" align="center">Nilai</td>
					  
                    </tr>
                <?php 
					$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=$clvl AND MA_KODE like '$ma_kode%'";
					$rsMa=mysql_query($sql);
					$j=1;
					$stot=0;
					while ($rwMa=mysql_fetch_array($rsMa)){
						$sql="SELECT ABS(IFNULL(SUM(j.KREDIT-j.DEBIT),0)) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						$rsNilai=mysql_query($sql);
						$rwNilai=mysql_fetch_array($rsNilai);
						$stot+=$rwNilai["nilai"];
				?>
                    <tr>
                      <td align="center"><?php echo $j++; ?></td>
                      <?php 
                            if (($rwNilai["nilai"]>0) && ($rwMa["MA_ISLAST"]==0)){
                      ?>
                      <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rwMa["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rwMa["MA_NAMA"]; ?></a></td>
                      <?php 
                            }else{
                      ?>
                      <td align="left">&nbsp;<?php echo $rwMa["MA_NAMA"]; ?></td>
                      <?php 
                            }
                      ?>
                      <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai"],2,",","."); ?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td align="left">&nbsp;Subtotal :</td>
                      <td align="right">&nbsp;<?php echo number_format($stot,2,",","."); ?></td>
                    </tr>
                  </table>
		<?php
			}else{
				$lnk="'../report/operasional_excell.php?sak_sap=".$sak_sap."&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
		?>
                <p class="jdltable">Laporan Operasional SAP</p>
                <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
                <tr>
                  <td width="60">Periode</td>
                  <td width="12">:</td>
                  <td valign="middle"> 
                    <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                    <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                    &nbsp;&nbsp;s/d&nbsp;&nbsp;
                    <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                    <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
                    <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                    Lihat</button> 
                  </td>
                </tr>
                </table><br />
                <div>
                  <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                    <tr>
                      <td width="30" align="center">No</td>
                      <td align="center">Uraian</td>
                      <td width="160" align="center">Nilai</td>
                    </tr>
                    <?php
					$subtot=array(15);
					for ($i=0;$i<14;$i++) $subtot[$i]=0;
					$sql="SELECT * FROM lap_lo_sap ORDER BY kode";
					$rs=mysql_query($sql);
					$tmpkel=0;$tmpkat=0;
					while ($rows=mysql_fetch_array($rs)){
						$ckode=$rows["kode_ma_sak"];
						$cinduk=$rows["id"];
						$cformula=str_replace(" ","",$rows["formula"]);
						$ckelompok=$rows["kelompok"];
						$cdk=$rows["d_k"];
						$ckategori=$rows["kategori"];
						$ctype=$rows["type"];
						$nilai=($ckelompok==0)?"":"-";
						if ($ckode!=""){
							$ckodear=explode(",",$ckode);
							$cstr="";
							/*if (($rows["id"]==9) && ($sak_sap=="1")){
								for ($i=0;$i<count($ckodear);$i++){
									if ($ckodear[$i]=='2110102'){
										$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
									}else{
										$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
									}
								}
							}elseif(($rows["id"]==10) && ($sak_sap=="1")){
								for ($i=0;$i<count($ckodear);$i++){
									if ($ckodear[$i]=='2110102'){
										$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
									}else{
										$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
									}
								}
							}else{*/
								for ($i=0;$i<count($ckodear);$i++){
									$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
								}
							//}
							$cstr=substr($cstr,0,strlen($cstr)-4);
							//echo $cstr."<br>";
							//if ($ckelompok==1 or $ckelompok==4){
							if ($cdk=='K'){
								if ($ctype==0){
									/*$sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
			(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
			(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
			WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
			WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
			WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
									$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
								}else{
									/*$sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
			(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
			(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
			WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
			WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
			WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
									$sql="SELECT IFNULL(SUM(j.KREDIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
								}
							}else{
								if ($ctype==0){
									/*$sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
			(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
			(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
			WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
			WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
			WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
									$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
								}else{
									/*$sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
			(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
			(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
			WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
			WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
			WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
									$sql="SELECT IFNULL(SUM(j.DEBIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
								}
							}
							//echo $sql."<br>";
							/*if ($ckode=='411'){
								echo $sql."<br>";
							}*/
							$rs1=mysql_query($sql);
							if ($rows1=mysql_fetch_array($rs1)){
								$nilai=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
								if ($nilai!="-"){
									$subtot[$ckelompok-1] +=$rows1["NILAI"];
								}
							}
						}else{
							if ($ckategori==2){
								$cform=array();
								$j=0;
								for ($i=0;$i<strlen($cformula);$i++){
									if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
										$cform[$j]=substr($cformula,$i,1);
										$j++;
									}
								}
								//echo "count=".count($cform)."<br>";
								$cdata=str_replace("-",",",$cformula);
								$cdata=str_replace("+",",",$cdata);
								$cdata=explode(",",$cdata);
								$cnilai=$subtot[$cdata[0]-1];
								//echo $cnilai."<br>";
								for ($i=1;$i<count($cdata);$i++){
									$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]-1]):($cnilai+$subtot[$cdata[$i]-1]);
									//echo $subtot[$cdata[$i]-1]."<br>";
								}
								if ($cnilai<0) 
									$nilai="(".number_format(abs($cnilai),2,",",".").")";
								else
									$nilai=number_format($cnilai,2,",",".");
							}elseif ($ckategori==3){
								$sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn AND flag = '$flag') AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '111%'";//decyber_arus_kas
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								if ($rows1=mysql_fetch_array($rs1)){
									if ($rows1["NILAI"]<0)
										$nilai="(".number_format(abs($rows1["NILAI"]),2,",",".").")";
									else
										$nilai=number_format($rows1["NILAI"],2,",",".");
									$subtot[$ckelompok-1] +=$rows1["NILAI"];
								}
							}
						}
					?>
                        <tr>
                          <td align="center"><?php echo (strlen($rows["no"])==1)?$rows["no"]:""; ?></td>
                          <?php if ($ckode=="" or $nilai=="-" or $nilai==0){?>
                          <td align="left">&nbsp;<?php echo $rows["uraian"]; ?></td>
                          <?php }else{?>
                          <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $ckode; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rows["uraian"]; ?></a></td>
                          <?php }?>
                          <td align="right"><?php echo $nilai; ?></td>
                        </tr>
					<?php
					}
					?>
                  </table>
		<?php
			}
		}
	}elseif ($it=="6"){
 		$lnk="'../report/BKU_excell.php?tglAwal='+tgl_s.value+'&tglAkhir='+tgl_d.value+'&tipe_trans='+cmbTipeTrans.value";
 	?>
 		<table width="502" border="0" cellspacing="2" cellpadding="0" class="txtinput">
        <!--tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php //echo strtoupper($username); ?></td>
        </tr-->
        <tr>
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="20" colspan="3" align="center"><b>Laporan BKU </b> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="361">&nbsp;</td>
        </tr>
        <tr> 
          <td width="70">Periode</td>
          <td width="10">:</td>
          <td><input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d2" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            &nbsp;&nbsp;&nbsp;s/d: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s2" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
            <input type="button" name="Submit" value="Tampilkan" onclick="bku()" /></td>
        </tr>
        <tr>
          <td>Tipe Transaksi</td>
          <td>:</td>
          <td><select id="cmbTipeTrans" name="cmbTipeTrans" class="txtinput">
                        <option value="0">SEMUA</option>
                        <option value="1">Penerimaan</option>
                        <option value="2">Pengeluaran</option>
						</select></td>
        </tr>
      	</table>
	  <script>
	  function bku(){
	  var a = document.getElementById('tgl_s').value;
	  var b = document.getElementById('tgl_d').value;
	  window.location='../unit/main.php?f=../report/BKU.php&tglAwal='+a+'&tglAkhir='+b+'&cmbTipeTrans='+document.getElementById('cmbTipeTrans').value;
	  }
	  </script>
 <?
 }

elseif ($it=="7"){
 $lnk="'../report/Re_Ang_excell.php?cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value";
 $mon = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
 ?>
 <table width="370" border="0" cellspacing="2" cellpadding="0" class="txtinput">
        <!--tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php //echo strtoupper($username); ?></td>
        </tr-->
        <tr>
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="20" colspan="3" align="center"><b>Laporan Realisasi Anggaran</b> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="273">&nbsp;</td>
        </tr>
        <tr> 
          <td width="78">Periode</td>
          <td width="11">:</td>
          <td>
		  <select id="cmbBln" name="cmbBln">
		  <?
		  for($i=1;$i<=12;$i++)
		  {
		  ?>
		  <option value="<?=$i;?>"><?=$mon[$i];?></option>
		  <? 
		  }
		  ?>
          </select>
		  <select id="cmbThn" name="cmbThn">
		  <?
		  $y = date("Y");
		  for($i=$y;$i>=($y-10);$i--)
		  {
		  ?>
		  <option value="<?=$i;?>"><?=$i;?></option>
		  <? 
		  }
		  ?>
          </select>
		  <input type="button" name="Submit2" value="Tampilkan" onclick="ra()" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><label></label></td>
        </tr>
    </table>
	  <script>
	  function ra(){
	  var a = document.getElementById('cmbBln').value;
	  var b = document.getElementById('cmbThn').value;
	  window.location='../unit/main.php?f=../report/Re_Ang&cmbBln='+a+'&cmbThn='+b;
	  }
	  </script>
 <?
 } else if($it == 8) {
	 $lnk="'../report/lap_silpa_sap_excell.php?tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
		<p class="jdltable">Laporan SILPA SAP</p>
		<table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr>
		  <td width="60">Periode</td>
		  <td width="12">:</td>
		  <td valign="middle"> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			&nbsp;&nbsp;s/d&nbsp;&nbsp;
			<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=8&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
			Lihat</button> 
		  </td>
		</tr>
		</table><br />
		<div>
		  <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
			<tr>
			  <td width="30" align="center">No</td>
			  <td align="center">Uraian</td>
			  <td width="160" align="center">Nilai</td>
			</tr>
			<?php
			$subtot=array(15);
			for ($i=0;$i<14;$i++) $subtot[$i]=0;
			$sql="SELECT * FROM lap_silpa_sap ORDER BY kode";
			$rs=mysql_query($sql);
			$tmpkel=0;$tmpkat=0;
			while ($rows=mysql_fetch_array($rs)){
				$ckode=$rows["kode_ma_sak"];
				$cinduk=$rows["id"];
				$cformula=str_replace(" ","",$rows["formula"]);
				$ckelompok=$rows["kelompok"];
				$cdk=$rows["d_k"];
				$ckategori=$rows["kategori"];
				$ctype=$rows["type"];
				$nilai=($ckelompok==0)?"":"-";
				if ($ckode!=""){
					$ckodear=explode(",",$ckode);
					$cstr="";
					/*if (($rows["id"]==9) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}elseif(($rows["id"]==10) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}else{*/
						for ($i=0;$i<count($ckodear);$i++){
							$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
						}
					//}
					$cstr=substr($cstr,0,strlen($cstr)-4);
					//echo $cstr."<br>";
					//if ($ckelompok==1 or $ckelompok==4){
					if ($cdk=='K'){
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}else{
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}
					//echo $sql."<br>";
					/*if ($ckode=='411'){
						echo $sql."<br>";
					}*/
					$rs1=mysql_query($sql);
					if ($rows1=mysql_fetch_array($rs1)){
						$nilai=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
						if ($nilai!="-"){
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}else{
					if ($ckategori==2){
						$cform=array();
						$j=0;
						for ($i=0;$i<strlen($cformula);$i++){
							if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
								$cform[$j]=substr($cformula,$i,1);
								$j++;
							}
						}
						//echo "count=".count($cform)."<br>";
						$cdata=str_replace("-",",",$cformula);
						$cdata=str_replace("+",",",$cdata);
						$cdata=explode(",",$cdata);
						$cnilai=$subtot[$cdata[0]-1];
						//echo $cnilai."<br>";
						for ($i=1;$i<count($cdata);$i++){
							$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]-1]):($cnilai+$subtot[$cdata[$i]-1]);
							//echo $subtot[$cdata[$i]-1]."<br>";
						}
						if ($cnilai<0) 
							$nilai="(".number_format(abs($cnilai),2,",",".").")";
						else
							$nilai=number_format($cnilai,2,",",".");
					}elseif ($ckategori==3){
						$sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn AND flag = '$flag') AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '111%'";//decyber_arus_kas _not_fix
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						if ($rows1=mysql_fetch_array($rs1)){
							if ($rows1["NILAI"]<0)
								$nilai="(".number_format(abs($rows1["NILAI"]),2,",",".").")";
							else
								$nilai=number_format($rows1["NILAI"],2,",",".");
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}
			?>
				<tr>
				  <td align="center"><?php echo (strlen($rows["no"])==1)?$rows["no"]:""; ?></td>
				  <?php if ($ckode=="" or $nilai=="-" or $nilai==0){?>
				  <td align="left">&nbsp;<?php echo $rows["nama"]; ?></td>
				  <?php }else{?>
				  <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $ckode; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rows["nama"]; ?></a></td>
				  <?php }?>
				  <td align="right"><?php echo $nilai; ?></td>
				</tr>
			<?php
			}
			?>
		</table>
		
		
		
		<!--table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
		  <td width="60">Periode</td>
		  <td width="12">:</td>
		  <td valign="middle"> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			&nbsp;&nbsp;s/d&nbsp;&nbsp;
			<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=8&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
			Lihat</button> 
		  </td>
		</tr>
		</table><br />
		<table width="500" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
			<thead>
				<tr>
					<td align="center" width="33" style="font-weight:bold;">No</td>
					<td align="center" width="240" style="font-weight:bold;">Uraian</td>
					<td align="center" width="121" style="font-weight:bold;">Nilai</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$sql = "select * from lap_silpa_sap order by kode";
				$hasil = mysql_query($sql);
				$no = 1;
				while ($t = mysql_fetch_row($hasil)){
			?>  	
					<tr>
					  <td align="center" width="33"><?php echo $no++; ?></td>
					  <td align="left" width="250">&nbsp;<?php echo $t['2'];?></td>
					  <td align="right" width="150">&nbsp;</td>
					</tr>
			<?php
				
				}
			?>
			</tbody>
		</table-->
<?php
 } else if($it == 9) {
	 $lnk="'../report/lap_lra_sap_excell.php?tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
		<p class="jdltable">Laporan LRA SAP</p>
		<table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr>
		  <td width="60">Periode</td>
		  <td width="12">:</td>
		  <td valign="middle"> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			&nbsp;&nbsp;s/d&nbsp;&nbsp;
			<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=9&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
			Lihat</button> 
		  </td>
		</tr>
		</table><br />
		<div>
		  <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
			<tr>
			  <td width="30" align="center">No</td>
			  <td align="center">Uraian</td>
			  <td width="160" align="center">Nilai</td>
			</tr>
			<?php
			$subtot=array(15);
			for ($i=0;$i<14;$i++) $subtot[$i]=0;
			$sql="SELECT * FROM lap_lra_sap ORDER BY kode";
			$rs=mysql_query($sql);
			$tmpkel=0;$tmpkat=0;
			while ($rows=mysql_fetch_array($rs)){
				$ckode=$rows["kode_ma_sak"];
				$cinduk=$rows["id"];
				$cformula=str_replace(" ","",$rows["formula"]);
				$ckelompok=$rows["kelompok"];
				$cdk=$rows["d_k"];
				$ckategori=$rows["kategori"];
				$ctype=$rows["type"];
				$nilai=($ckelompok==0)?"":"-";
				if ($ckode!=""){
					$ckodear=explode(",",$ckode);
					$cstr="";
					/*if (($rows["id"]==9) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}elseif(($rows["id"]==10) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}else{*/
						for ($i=0;$i<count($ckodear);$i++){
							$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
						}
					//}
					$cstr=substr($cstr,0,strlen($cstr)-4);
					//echo $cstr."<br>";
					//if ($ckelompok==1 or $ckelompok==4){
					if ($cdk=='K'){
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}else{
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}
					//echo $sql."<br>";
					/*if ($ckode=='411'){
						echo $sql."<br>";
					}*/
					$rs1=mysql_query($sql);
					if ($rows1=mysql_fetch_array($rs1)){
						$nilai=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
						if ($nilai!="-"){
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}else{
					if ($ckategori==2){
						$cform=array();
						$j=0;
						for ($i=0;$i<strlen($cformula);$i++){
							if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
								$cform[$j]=substr($cformula,$i,1);
								$j++;
							}
						}
						//echo "count=".count($cform)."<br>";
						$cdata=str_replace("-",",",$cformula);
						$cdata=str_replace("+",",",$cdata);
						$cdata=explode(",",$cdata);
						$cnilai=$subtot[$cdata[0]-1];
						//echo $cnilai."<br>";
						for ($i=1;$i<count($cdata);$i++){
							$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]-1]):($cnilai+$subtot[$cdata[$i]-1]);
							//echo $subtot[$cdata[$i]-1]."<br>";
						}
						if ($cnilai<0) 
							$nilai="(".number_format(abs($cnilai),2,",",".").")";
						else
							$nilai=number_format($cnilai,2,",",".");
					}elseif ($ckategori==3){
						$sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn AND flag = '$flag') AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '111%'"; //decyber_not_fix
						//echo $sql."<br>";//decyber_arus_kas
						$rs1=mysql_query($sql);
						if ($rows1=mysql_fetch_array($rs1)){
							if ($rows1["NILAI"]<0)
								$nilai="(".number_format(abs($rows1["NILAI"]),2,",",".").")";
							else
								$nilai=number_format($rows1["NILAI"],2,",",".");
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}
			?>
				<tr>
				  <td align="center"><?php echo (strlen($rows["no"])==1)?$rows["no"]:""; ?></td>
				  <?php if ($ckode=="" or $nilai=="-" or $nilai==0){?>
				  <td align="left">&nbsp;<?php echo $rows["nama"]; ?></td>
				  <?php }else{?>
				  <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $ckode; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rows["nama"]; ?></a></td>
				  <?php }?>
				  <td align="right"><?php echo $nilai; ?></td>
				</tr>
			<?php
			}
			?>
		</table>
		
		
		<!--table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
		  <td width="60">Periode</td>
		  <td width="12">:</td>
		  <td valign="middle"> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			&nbsp;&nbsp;s/d&nbsp;&nbsp;
			<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=9&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
			Lihat</button> 
		  </td>
		</tr>
		</table><br />
		<table width="960" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
			<thead>
				<tr>
					<td align="center" width="33" style="font-weight:bold;">No</td>
					<td align="center" width="240" style="font-weight:bold;">Uraian</td>
					<td align="center" width="121" style="font-weight:bold;">Catatan Nomor</td>
					<td align="center" width="115" style="font-weight:bold;">Anggaran</td>
					<td align="center" width="151" style="font-weight:bold;">Realisasi TW 1</td>
					<td align="center" width="157" style="font-weight:bold;">Realisasi Sd. TW 1</td>
					<td align="center" width="186" style="font-weight:bold;">Sisa Anggaran</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$sql = "select * from lap_lra_sap order by kode";
				$hasil = mysql_query($sql);
				$no = 1;
				while ($t = mysql_fetch_row($hasil)){
			?>  	
					<tr>
					  <td align="center" width="33"><?php echo $t['2'];?></td>
					  <td align="left" width="240">&nbsp;<?php echo $t['3'];?></td>
					  <td align="center" width="121">&nbsp;</td>
					  <td align="center" width="115">&nbsp;</td>
					  <td align="center" width="151">&nbsp;</td>
					  <td align="center" width="157">&nbsp;</td>
					  <td align="center" width="186">&nbsp;</td>
					</tr>
			<?php
				$no++;
				}
			?>
			</tbody>
		</table-->
<?php
 } else if($it == 10) {
	 $lnk="'../report/lap_lre_sap_excell.php?tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
		<p class="jdltable">Laporan Ekuitas SAP</p>
		
		<table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr>
		  <td width="60">Periode</td>
		  <td width="12">:</td>
		  <td valign="middle"> 
			<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
			<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			&nbsp;&nbsp;s/d&nbsp;&nbsp;
			<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
			<input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=10&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
			<img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
			Lihat</button> 
		  </td>
		</tr>
		</table><br />
		<div>
		  <table width="700" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
			<tr>
			  <td width="30" align="center">No</td>
			  <td align="center">Uraian</td>
			  <td width="160" align="center">Nilai</td>
			</tr>
			<?php
			$subtot=array(15);
			for ($i=0;$i<14;$i++) $subtot[$i]=0;
			$sql="SELECT * FROM lap_lpe_sap ORDER BY kode";
			$rs=mysql_query($sql);
			$tmpkel=0;$tmpkat=0;
			while ($rows=mysql_fetch_array($rs)){
				$ckode=$rows["kode_ma_sak"];
				$cinduk=$rows["id"];
				$cformula=str_replace(" ","",$rows["formula"]);
				$ckelompok=$rows["kelompok"];
				$cdk=$rows["d_k"];
				$ckategori=$rows["kategori"];
				$ctype=$rows["type"];
				$nilai=($ckelompok==0)?"":"-";
				if ($ckode!=""){
					$ckodear=explode(",",$ckode);
					$cstr="";
					/*if (($rows["id"]==9) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}elseif(($rows["id"]==10) && ($sak_sap=="1")){
						for ($i=0;$i<count($ckodear);$i++){
							if ($ckodear[$i]=='2110102'){
								$cstr .="(ma.MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
							}else{
								$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
							}
						}
					}else{*/
						for ($i=0;$i<count($ckodear);$i++){
							$cstr .="ma.MA_KODE LIKE '".$ckodear[$i]."%' OR ";
						}
					//}
					$cstr=substr($cstr,0,strlen($cstr)-4);
					//echo $cstr."<br>";
					//if ($ckelompok==1 or $ckelompok==4){
					if ($cdk=='K'){
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.KREDIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}else{
						if ($ctype==0){
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}else{
							/*$sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
	(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
	(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($cstr)) AS t4";*/
							$sql="SELECT IFNULL(SUM(j.DEBIT),'-') AS NILAI FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ($cstr) AND j.flag = '$flag' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";//decyber_arus_kas
						}
					}
					//echo $sql."<br>";
					/*if ($ckode=='411'){
						echo $sql."<br>";
					}*/
					$rs1=mysql_query($sql);
					if ($rows1=mysql_fetch_array($rs1)){
						$nilai=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],2,",",".");
						if ($nilai!="-"){
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}else{
					if ($ckategori==2){
						$cform=array();
						$j=0;
						for ($i=0;$i<strlen($cformula);$i++){
							if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
								$cform[$j]=substr($cformula,$i,1);
								$j++;
							}
						}
						//echo "count=".count($cform)."<br>";
						$cdata=str_replace("-",",",$cformula);
						$cdata=str_replace("+",",",$cdata);
						$cdata=explode(",",$cdata);
						$cnilai=$subtot[$cdata[0]-1];
						//echo $cnilai."<br>";
						for ($i=1;$i<count($cdata);$i++){
							$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]-1]):($cnilai+$subtot[$cdata[$i]-1]);
							//echo $subtot[$cdata[$i]-1]."<br>";
						}
						if ($cnilai<0) 
							$nilai="(".number_format(abs($cnilai),2,",",".").")";
						else
							$nilai=number_format($cnilai,2,",",".");
					}elseif ($ckategori==3){
						$sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn AND j.flag = '$flag') AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '111%'";//decyber_arus_kas
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						if ($rows1=mysql_fetch_array($rs1)){
							if ($rows1["NILAI"]<0)
								$nilai="(".number_format(abs($rows1["NILAI"]),2,",",".").")";
							else
								$nilai=number_format($rows1["NILAI"],2,",",".");
							$subtot[$ckelompok-1] +=$rows1["NILAI"];
						}
					}
				}
			?>
				<tr>
				  <td align="center"><?php echo (strlen($rows["no"])==1)?$rows["no"]:""; ?></td>
				  <?php if ($ckode=="" or $nilai=="-" or $nilai==0){?>
				  <td align="left">&nbsp;<?php echo $rows["nama"]; ?></td>
				  <?php }else{?>
				  <td align="left">&nbsp;<a href="?f=../report/laporan.php&it=5&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $ckode; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rows["nama"]; ?></a></td>
				  <?php }?>
				  <td align="right"><?php echo $nilai; ?></td>
				</tr>
			<?php
			}
			?>
		</table>
		

			<?php
				$sql = "select * from lap_lpe_sap order by kode";
				$hasil = mysql_query($sql);
				$no = 1;
				while ($t = mysql_fetch_row($hasil)){
			?>  	
					<tr>
					  <td align="center" width="33"><?php echo $t['2'];?></td>
					  <td align="left" width="240">&nbsp;<?php echo $t['3'];?></td>
					  <td align="center" width="121">&nbsp;</td>
					  <td align="center" width="115">&nbsp;</td>
					  <td align="center" width="151">&nbsp;</td>
					</tr>
			<?php
				$no++;
				}
			?>
			</tbody>
		</table-->
		
<!---- TAMBAHAN ISMAIL --->			
		
<?php }elseif ($it=="11"){
	$jdl_lap="Laporan JKM";
	$lnk="'../report/jkm_excell.php?tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="60">Periode</td>
          <td width="12">:</td>
          <td valign="middle">
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=11&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button>
			
          </td>
        </tr>
      </table><br />
      <div>

      <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
        <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
          <td width="30" align="center">No</td>
          <td width="103" align="center"> Tanggal </td>
          <td width="124" align="center">No Bukti</td>
          <td width="305" align="center">Uraian</td>
          <td width="106" align="center">Nilai</td>
        </tr>
   <?php 
 //    $sql=" SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit FROM jurnal a 
 // INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 // WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.`D_K`='D' AND  b.`MA_KODE` LIKE '1.1.01%' AND a.flag = '$flag'";//decyber_arus_kas
 //query filter baru sesuai tipe dan flag yg berisi, untuk mengindari transaksi dr gudang
   //mellydecyber

    $sql=" SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.`D_K`='D' AND  b.`MA_KODE` LIKE '1.1.01%' AND a.flag = '$flag' AND a.`TIPE_JURNAL` IN (1,0)";
   $sql1=mysql_query($sql);
   	
	$i=1;
   while ($rows=mysql_fetch_array($sql1)){
   
   ?>
       
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center"><?=$i++ ?> </td>
         
          <td align="center"><?php echo $rows['tanggal']; ?></td>
        
          <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
          <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
          <td width="106" align="right"><?php echo number_format($rows['debit'],2,",","."); ?></td>
        </tr>
		 
		<? $total +=$rows['debit'];  }?>
		
		<tr bgcolor="#FFFFFF" style="font-weight:bold;">
          <td colspan="4" align="right">Jumlah : </td>
          <td align="right"><?php echo number_format($total,2,",","."); ?></td>
        </tr>
      </table>
      </div>		
		
<?php }elseif ($it=="12"){
	$jdl_lap="Laporan JKK";
	$lnk="'../report/jkk_excell.php?tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="60">Periode</td>
          <td width="12">:</td>
          <td valign="middle">
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=12&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button> 
          </td>
        </tr>
      </table><br />
      <div>

      <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
        <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
          <td width="30" align="center">No</td>
          <td width="103" align="center"> Tanggal </td>
          <td width="124" align="center">No Bukti</td>
          <td width="305" align="center">Uraian</td>
          <td width="106" align="center">Nilai</td>
        </tr>
   <?php 
    $sql=" SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.kredit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.`D_K`='K' AND  b.`MA_KODE` LIKE '1.1.01%' AND a.flag = '$flag' AND a.`TIPE_JURNAL` IN (2)";

 //penambahan untuk tipe jurnal 2, yaitu JKK mellydecyber//decyber_arus_kas
   $sql1=mysql_query($sql);
   	
	$i=1;
   while ($rows=mysql_fetch_array($sql1)){
   
   ?>
       
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center"><?=$i++ ?> </td>
         
          <td align="center"><?php echo $rows['tanggal']; ?></td>
        
          <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
          <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
          <td width="106" align="right"><?php echo number_format($rows['kredit'],2,",","."); ?></td>
        </tr>
		 
		<? $total +=$rows['kredit'];  }?>
		
		<tr bgcolor="#FFFFFF" style="font-weight:bold;">
          <td colspan="4" align="right">Jumlah : </td>
          <td align="right"><?php echo number_format($total,2,",","."); ?></td>
        </tr>
      </table>
      </div>
<?php }elseif ($it=="16"){
	$jdl_lap="Laporan JRR";
		$lnk="'../report/jrr_excell.php?tipe=3&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="60">Periode</td>
          <td width="12">:</td>
          <td valign="middle">
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=16&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button> 
          </td>
        </tr>
      </table><br />
      <div>

      <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
        <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
          <td width="30" align="center">No</td>
          <td width="103" align="center"> Tanggal </td>
          <td width="124" align="center">No Bukti</td>
          <td width="305" align="center">Uraian</td>
          <td width="106" align="center">Debit</td>
		  <td width="106" align="center">Kredit</td>
        </tr>
   <?php 
    $sql="SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit,a.kredit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.TIPE_JURNAL=3 AND a.flag = '$flag' AND NO_KW NOT LIKE '%JP%'";//decyber_arus_kas
 
   $sql1=mysql_query($sql);
   	
	$i=1;
   while ($rows=mysql_fetch_array($sql1)){
   
   ?>
       
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center"><?=$i++ ?> </td>
         
          <td align="center"><?php echo $rows['tanggal']; ?></td>
        
          <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
          <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
		  <td width="106" align="right"><?php echo number_format($rows['debit'],2,",","."); ?></td>
          <td width="106" align="right"><?php echo number_format($rows['kredit'],2,",","."); ?></td>
        </tr>
		 
		<? $total_d +=$rows['debit'];
		 $total_k +=$rows['kredit'];
		  }?>
		
		<tr bgcolor="#FFFFFF" style="font-weight:bold;">
          <td colspan="4" align="right">Jumlah : </td>
          <td align="right"><?php echo number_format($total_d,2,",","."); ?></td>
		  <td align="right"><?php echo number_format($total_k,2,",","."); ?></td>
        </tr>
      </table>
      </div>	

  <?php }elseif ($it=="21"){
    $jdl_lap="Laporan Jurnal Penjualan";
      $lnk="'../report/jp_excell.php?tipe=3&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
  ?>
      <p class="jdltable"><?php echo $jdl_lap; ?></p>
        <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
          <tr>
            <td width="60">Periode</td>
            <td width="12">:</td>
            <td valign="middle">
              <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
              <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
              &nbsp;&nbsp;s/d&nbsp;&nbsp;
              <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
              <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=21&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
              <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
              Lihat</button> 
            </td>
          </tr>
        </table><br />
        <div>

        <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
          <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
            <td width="30" align="center">No</td>
            <td width="103" align="center"> Tanggal </td>
            <td width="124" align="center">No Bukti</td>
            <td width="305" align="center">Uraian</td>
            <td width="106" align="center">Debit</td>
        <td width="106" align="center">Kredit</td>
          </tr>
     <?php 
      $sql="SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit,a.kredit FROM jurnal a 
   INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
   WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.flag = '$flag' AND a.TIPE_JURNAL=3 AND NO_KW LIKE '%JP%'";
   
     $sql1=mysql_query($sql);
      
    $i=1;
     while ($rows=mysql_fetch_array($sql1)){
     
     ?>
         
          <tr bgcolor="#FFFFFF">
            <td width="30" align="center"><?=$i++ ?> </td>
           
            <td align="center"><?php echo $rows['tanggal']; ?></td>
          
            <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
            <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
        <td width="106" align="right"><?php echo number_format($rows['debit'],2,",","."); ?></td>
            <td width="106" align="right"><?php echo number_format($rows['kredit'],2,",","."); ?></td>
          </tr>
       
      <? $total_d +=$rows['debit'];
       $total_k +=$rows['kredit'];
        }?>
      
      <tr bgcolor="#FFFFFF" style="font-weight:bold;">
            <td colspan="4" align="right">Jumlah : </td>
            <td align="right"><?php echo number_format($total_d,2,",","."); ?></td>
        <td align="right"><?php echo number_format($total_k,2,",","."); ?></td>
          </tr>
        </table>
        </div>  

  <?php }elseif ($it=="17"){
	$jdl_lap="Laporan JRR Penjualan Obat";
		$lnk="'../report/jrr_excell.php?tipe=4&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="60">Periode</td>
          <td width="12">:</td>
          <td valign="middle">
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=17&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button> 
          </td>
        </tr>
      </table><br />
      <div>

      <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
        <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
          <td width="30" align="center">No</td>
          <td width="103" align="center"> Tanggal </td>
          <td width="124" align="center">No Bukti</td>
          <td width="305" align="center">Uraian</td>
          <td width="106" align="center">Debit</td>
		  <td width="106" align="center">Kredit</td>
        </tr>
   <?php 
    $sql="SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit,a.kredit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.TIPE_JURNAL=4 AND a.flag = '$flag'";//decyber_arus_kas
   $sql1=mysql_query($sql);
   	
	$i=1;
   while ($rows=mysql_fetch_array($sql1)){
   
   ?>
       
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center"><?=$i++ ?> </td>
         
          <td align="center"><?php echo $rows['tanggal']; ?></td>
        
          <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
          <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
		  <td width="106" align="right"><?php echo number_format($rows['debit'],2,",","."); ?></td>
          <td width="106" align="right"><?php echo number_format($rows['kredit'],2,",","."); ?></td>
        </tr>
		 
		<? $total_d +=$rows['debit'];
		 $total_k +=$rows['kredit'];
		  }?>
		
		<tr bgcolor="#FFFFFF" style="font-weight:bold;">
          <td colspan="4" align="right">Jumlah : </td>
          <td align="right"><?php echo number_format($total_d,2,",","."); ?></td>
		  <td align="right"><?php echo number_format($total_k,2,",","."); ?></td>
        </tr>
      </table>
      </div>	


<?php }elseif ($it=="18"){
	$jdl_lap="Laporan JRR Pembelian Pemborongan";
	$lnk="'../report/jrr_excell.php?tipe=5&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value";
?>
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr>
          <td width="60">Periode</td>
          <td width="12">:</td>
          <td valign="middle">
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/laporan.php&it=18&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button> 
          </td>
        </tr>
      </table><br />
      <div>

      <table width="700" cellspacing="0" cellpadding="2" class="bodyText12" border="1" style="border-collapse:collapse" >
        <tr style="font-weight:bold; color:#FFFFFF" bgcolor="#339900" >
          <td width="30" align="center">No</td>
          <td width="103" align="center"> Tanggal </td>
          <td width="124" align="center">No Bukti</td>
          <td width="305" align="center">Uraian</td>
          <td width="106" align="center">Debit</td>
		  <td width="106" align="center">Kredit</td>
        </tr>
   <?php 
     $sql="SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.debit,a.kredit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.TIPE_JURNAL=5 AND a.flag = '$flag'";//decyber_arus_kas
//  echo $sql;
   $sql1=mysql_query($sql);
   	
	$i=1;
   while ($rows=mysql_fetch_array($sql1)){
   
   ?>
       
        <tr bgcolor="#FFFFFF">
          <td width="30" align="center"><?=$i++ ?> </td>
         
          <td align="center"><?php echo $rows['tanggal']; ?></td>
        
          <td width="124" align="left"><?php echo $rows['no_kw']; ?></td>
          <td width="305" align="left"><?php echo $rows['uraian']; ?></td>
		  <td width="106" align="right"><?php echo number_format($rows['debit'],2,",","."); ?></td>
          <td width="106" align="right"><?php echo number_format($rows['kredit'],2,",","."); ?></td>
        </tr>
		 
		<? $total_d +=$rows['debit'];
		 $total_k +=$rows['kredit'];
		  }?>
		
		<tr bgcolor="#FFFFFF" style="font-weight:bold;">
          <td colspan="4" align="right">Jumlah : </td>
          <td align="right"><?php echo number_format($total_d,2,",","."); ?></td>
		  <td align="right"><?php echo number_format($total_k,2,",","."); ?></td>
        </tr>
      </table>
      </div>	

<!---- END TAMBAHAN ISMAIL --->		
		
		
<?php
 } else if ($it=="31"){
	$lnk="'../report/rekap_biaya_perbulan_rekap.php?cmbThn='+ta.value+'&cmbBln='+bulan.value";
?>
	<p class="jdltable">Biaya Berdasarkan Jenis Transaksi</p>
	<table width="200" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
			<td>Bulan</td>
			<td width="10">:</td>
			<td>
				<select name="bulan" id="bulan">
					<option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
					<option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
					<option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
					<option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
					<option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
					<option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
					<option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
					<option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
					<option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
					<option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
					<option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
					<option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
				</select>
			</td>
		</tr>
		<tr> 
			<td>Tahun</td>
			<td width="10">:</td>
			<td>
				<select name="ta" id="ta">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
					<option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select>
			</td>
		</tr>
	</table>		
<?php
 } else if ($it=="13"){
	$lnk="'../report/rekap_biaya_perbulan.php?cmbThn='+ta.value+'&cmbBln='+bulan.value";
?>
	<p class="jdltable">Biaya Berdasarkan Jenis Transaksi</p>
	<table width="200" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
			<td>Bulan</td>
			<td width="10">:</td>
			<td>
				<select name="bulan" id="bulan">
					<option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
					<option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
					<option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
					<option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
					<option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
					<option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
					<option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
					<option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
					<option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
					<option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
					<option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
					<option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
				</select>
			</td>
		</tr>
		<tr> 
			<td>Tahun</td>
			<td width="10">:</td>
			<td>
				<select name="ta" id="ta">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
					<option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select>
			</td>
		</tr>
	</table>
<?php
 } else  if ($it=="14") {
	$lnk="'../report/jurnal_penjualan_new.php?cmbThn='+ta.value+'&cmbBln='+bulan.value";
?>
	<p class="jdltable">Buku Jurnal Penjualan</p>
	<table width="200" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
			<td>Bulan</td>
			<td width="10">:</td>
			<td>
				<select name="bulan" id="bulan">
					<option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
					<option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
					<option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
					<option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
					<option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
					<option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
					<option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
					<option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
					<option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
					<option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
					<option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
					<option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
				</select>
			</td>
		</tr>
		<tr> 
			<td>Tahun</td>
			<td width="10">:</td>
			<td>
				<select name="ta" id="ta">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
					<option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select>
			</td>
		</tr>
	</table>
<?php
 } else  if ($it=="15") {
	$lnk="'../report/saldo_uang_muka.php?cmbThn='+ta.value+'&cmbBln='+bulan.value";
?>
	<p class="jdltable">Saldo Uang Muka</p>
	<table width="200" border="0" cellspacing="0" cellpadding="0" class="txtinput">
		<tr> 
			<td>Bulan</td>
			<td width="10">:</td>
			<td>
				<select name="bulan" id="bulan">
					<option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
					<option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
					<option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
					<option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
					<option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
					<option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
					<option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
					<option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
					<option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
					<option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
					<option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
					<option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
				</select>
			</td>
		</tr>
		<tr> 
			<td>Tahun</td>
			<td width="10">:</td>
			<td>
				<select name="ta" id="ta">
				<?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
					<option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
				<?php }?>
				</select>
			</td>
		</tr>
	</table>
	
	
<?php } ?>
<br/>
<button style="display:<?php echo $dsp_view; ?>" type="button" onclick="window.open(<?php echo $lnk_view; ?>)"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" align="absmiddle" />&nbsp; 
                Lihat</button>
				<!-- <?=$lnk;//decyber?> -->
        <BUTTON style="display:<?php echo $dsp_export; ?>" type="button" onClick="window.open(<?php echo $lnk; ?>);">
		
		
		<IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle"/>&nbsp;<strong>Export ke File Excell</strong></BUTTON> 
		
		   
        <?php 
		if ($tampilback==1){
		?>
        <BUTTON type="button" onClick="history.back();"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle" />&nbsp;<strong>Kembali</strong></BUTTON>
        <?php 
		}
		?>
</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>