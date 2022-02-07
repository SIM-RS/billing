<?php
session_start();
include '../../koneksi/konek.php';
$idPel=( $_REQUEST['idPel'] !="" && isset($_REQUEST['idPel']) ? $_REQUEST['idPel'] : "0" );
$idKunj=($_REQUEST['idKunj']!="" && isset($_REQUEST['idKunj']) ? $_REQUEST['idKunj'] : "0" );
if($_GET['excel']=="yes"){

    header("Content-type: application/vnd.ms-excel");
    header("Content--Disposition:attachment; filename='hasil_radiologi.xls'");

}


function getAlamatGambar(){

    

    $index = lastIndexOf($_SERVER[SCRIPT_NAME],"/");
    $folder = substr($_SERVER[SCRIPT_NAME], 0,$index+1);

    return getProtokol().$_SERVER[SERVER_NAME].$folder;

}


function getProtokol(){
    $protokol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://' );
    return $protokol;
}

function lastIndexOf($string,$item){  
    $index=strpos(strrev($string),strrev($item));  
    if ($index){  
        $index=strlen($string)-strlen($item)-$index;  
        return $index;  
    }  
        else  
        return -1;  
}  



$sqlPas="SELECT no_rm,mp.nama nmPas,mp.alamat, mp.rt,mp.rw,mp.sex,mk.nama kelas,md.nama as diag,peg.nama as dokter,
kso.nama nmKso,CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(p.tgl_act,'%H:%i')) tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, mp.desa_id,mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, k.kso_id,k.kso_kelas_id,p.kelas_id,un.nama nmUnit
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
left join b_ms_unit un on un.id=p.unit_id_asal
left join b_diagnosa diag on diag.kunjungan_id=k.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
left join b_ms_pegawai peg on peg.id = diag.user_id
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="<?php echo getProtokol().$_SERVER['SERVER_NAME']."/simrs/billing/theme/print.css" ?>" />
        <title>.: Rincian Hasil Radiologi :.</title>
        <style type="text/css">
            img.makezoom:hover{
                border: 1px solid #555;
                box-shadow: 1px 2px 2px #888;
                padding:0px;
            }
            img.makezoom{
                margin:3px;
                padding:1px;
            }


        </style>
    </head>
    <body style="margin-top:0px">
        <table width="1026" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi" style="margin-left:10px;">
          <!--DWLayoutTable-->
            <tr>
                <td height="85" colspan="2" style="font-size:14px">
                    <b>
		<?=$_SESSION['namaP']?><br />
		Instalasi Laboratorium Klinik<br />
		<?=$_SESSION['alamatP']?> Telepon <?=$_SESSION['tlpP']?><br/></b>&nbsp;                </td>
                <td width="127"></td>
            </tr>
            <tr>
                <td width="732" height="5"></td>
                <td width="167" ></td>
                <td></td>
            </tr>
            <tr>
              <td height="30" colspan="3" align="center" valign="top" style="font-weight:bold;font-size:13px">
              <u>&nbsp;Rincian Hasil Radiologi Pasien&nbsp;</u>                </td>
          </tr>
            
            <tr class="kwi">
                <td height="108" colspan="3" valign="top">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                      <!--DWLayoutTable-->
                        <tr>
                            <td width="112" height="18" style="font-size:12px">No RM</td>
                            <td width="20" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="619" valign="top" style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                          <td width="102" valign="top" style="font-size:12px">Tgl Periksa</td>
                      <td width="22" align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td width="151" valign="top" style="font-size:12px">&nbsp;<?php echo $rw['tgljam'];?></td>
                        </tr>
                        
                        <tr>
                            <td height="18" style="font-size:12px">Nama Pasien </td>
                            <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td valign="top" style="font-size:12px">Unit </td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo $rw['nmUnit'];?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Alamat</td>
                            <td align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td valign="top" style="font-size:12px">Diagnosa</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['diag']);?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Kel. / Desa</td>
                          <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>                            
                        </tr>
                        <tr>
                            <td height="18"><span style="font-size:12px">RT / RW</span></td>
                          <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          <td valign="top" style="font-size:12px">Status Pasien</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmKso'])?></td>
                        </tr>
                        <tr>
                            <td height="18" style="font-size:12px">Jenis Kelamin </td>
                            <td align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo (strtolower($rw['sex'])=='l'?'Laki - Laki':'Perempuan');?></td>
                            <td valign="top" style="font-size:12px">Hak Kelas</td>
                            <td align="center" valign="top" style="font-weight:bold;font-size:12px">:</td>
                            <td valign="top" style="font-size:12px">&nbsp;<?php echo $rw['kelas'];?></td>
                        </tr>
                        <tr>
                          <td height="0"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                    </table></td>
            </tr>
            <tr class="kwi">
                <td height="74" colspan="3" valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <!--DWLayoutTable-->
                        <tr height="20">
    						<td align="center" width="20" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">No</td>
    						<td width="538" align="center" style="border:#000000 solid 1px; font-weight:bold;font-size:12px">Tindakan</td>
                            <td align="center" width="123" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td>
                            <td align="center" width="195" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Dokter</td>
                            <td align="center" width="150" style="border:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Hasil Radiologi</td>
                        </tr>

<!--
			<tr height="25">
                    <td align="left" colspan="7" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($rwKel["nama_kelompok"]); ?></b></i></td>
                    <td></td>
			</tr>
			<tr height="25">
                    <td align="left" colspan="7" style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid" >&nbsp;<i><b><?php echo strtoupper($spasi.$dt1["nama_kelompok"]); ?></b></i></td>
                    <td style="padding-left:10px;font-size:12px;border-bottom:1px solid;border-top:1px solid">&nbsp;</td>
			</tr>
-->
			<?php
				$sql ="SELECT hr.*,mp.nama from b_hasil_rad hr INNER JOIN b_ms_pegawai mp 
			ON mp.id = hr.user_id WHERE pelayanan_id = '".$_REQUEST['idPel']."'";

                //echo $sql;
				$rs=mysql_query($sql);
				while($dt = mysql_fetch_array($rs)){
					$no++;
			?>
			<tr height="25" <?php echo ($_GET['excel']=="yes"?"rowspan='2'":""); ?> >
                    <td align="center" style="font-size:12px;" ><?=$no;?></td>
                    <td align="left" style="padding-left:35px;font-size:12px" >&nbsp;<?php echo $spasi.$dt["hasil"]; ?></td>
                    <td align="center" style="font-size:12px"><?php echo date("d - M - Y", strtotime($dt['tgl']))?></td>
                    <td align="center" style="font-size:12px"><?php echo $dt['nama']?></td>
                    <td align="center" style="font-size:12px">
                        <a target='_blank' onClick="OpenWnd('<?php echo getAlamatGambar().'gb.php?id='.$dt['id'];?>',800,500,'msma',true)" style='cursor:pointer'>
                        <img alt='zoom' class='makezoom' <?php echo ($_GET['excel']=="yes"?"width='60' height='60'":"width='100' height='100'"); ?> src='foto_radiologi.php?id=<?=$dt['id'];?>' ></a>                    </td>
			</tr>
			<?
				}
			?>
				</table></td>
		    </tr>
            <tr class="kwi">
              <td height="28">&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
			 
            <tr class="kwi">
			<?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			?>
                <td height="92" valign="top" style="font-weight:bold;font-size:12px"><br/></td>
                <td colspan="2" align="center" valign="top" style="font-weight:bold;font-size:12px">Sidoarjo, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>
				  <!--Penanggungjawab
                    <br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $pegawai;?> )-->
				  Petugas
                    <br/>
                    &nbsp;<br/>
                    &nbsp;<br/>
                    &nbsp;<br/>
                ( <?php echo $rt[0];?> )</td>
            </tr>
            <tr id="trTombol">
                <td height="24" colspan="3" align="center" valign="top" class="noline">
            
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=yes';"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>                
            
                </td>
            </tr>
        </table>
<script type="text/JavaScript">

            
function OpenWnd(tujuan,pWidth,pHeight,WindowName,args) {
      var features = "toolbar=false,menubar=false,status=false,resizeable=false,scrollbars=yes";
      var left = new Number((window.screen.width - pWidth) / 2);
      var top = new Number((window.screen.height - pHeight) / 2);
      features += ",width=" + pWidth.toString() + "px";
      features += ",left=" + left.toString() + "px";
      features += ",height=" + pHeight.toString() + "px";
      features += ",top=" + top.toString() + "px";
      window.open(tujuan, WindowName, features);        
}

function cetak(tombol){
    tombol.style.visibility='collapse';
    if(tombol.style.visibility=='collapse'){
        if(confirm('Anda Yakin Mau Mencetak Rician hasil Laboratorium ?')){
            setTimeout('window.print()','1000');
            setTimeout('window.close()','2000');
        }
        else{
            tombol.style.visibility='visible';
        }

    }
}
</script>