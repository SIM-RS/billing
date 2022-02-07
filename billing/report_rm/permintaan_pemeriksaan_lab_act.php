<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_noForm=addslashes($_REQUEST['txt_noForm']);
	$tgl_terima=tglSQL($_REQUEST['tgl_terima']);
	$jam_terima=$_REQUEST['jam_terima'];
//	$penyakit='';
	
	$isi_chk=$_REQUEST['isi_chk'];	
	
	$idUsr=$_REQUEST['idUsr'];
	
/*	for($i=0;$i<=5;$i++){
		$penyakit.=$isi_chk[$i].',';
		}*/

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql="INSERT INTO b_form_pemeriksaan_lab (
  pelayanan_id,
  kunjungan_id,
  no_formulir,
  tgl_terima,
  jam_terima,
  isi,
  tgl_act,
  user_act
) 
VALUES
  (
    '$idPel',
    '$idKunj',
	'$txt_noForm',
	'$tgl_terima',
	'$jam_terima',	'$isi_chk[0],$isi_chk[1],$isi_chk[2],$isi_chk[3],$isi_chk[4],$isi_chk[5],$isi_chk[6],$isi_chk[7],$isi_chk[8],$isi_chk[9],$isi_chk[10],$isi_chk[11],$isi_chk[12],$isi_chk[13],$isi_chk[14],$isi_chk[15],$isi_chk[16],$isi_chk[17],$isi_chk[18],$isi_chk[19],$isi_chk[20],$isi_chk[21],$isi_chk[22],$isi_chk[23],$isi_chk[24],$isi_chk[25],$isi_chk[26],$isi_chk[27],$isi_chk[28],$isi_chk[29],$isi_chk[30],$isi_chk[31],$isi_chk[32],$isi_chk[33],$isi_chk[34],$isi_chk[35],$isi_chk[36],$isi_chk[37],$isi_chk[38],$isi_chk[39],$isi_chk[40],$isi_chk[41],$isi_chk[42],$isi_chk[43],$isi_chk[44],$isi_chk[45],$isi_chk[46],$isi_chk[47],$isi_chk[48],$isi_chk[49],$isi_chk[50],$isi_chk[51],$isi_chk[52],$isi_chk[53],$isi_chk[54],$isi_chk[55],$isi_chk[56],$isi_chk[57],$isi_chk[58],$isi_chk[59],$isi_chk[60],$isi_chk[61],$isi_chk[62],$isi_chk[63],$isi_chk[64],$isi_chk[65],$isi_chk[66],$isi_chk[67],$isi_chk[68],$isi_chk[69],$isi_chk[70],$isi_chk[71],$isi_chk[72],$isi_chk[73],$isi_chk[74],$isi_chk[75],$isi_chk[76],$isi_chk[77],$isi_chk[78],$isi_chk[79],$isi_chk[80],$isi_chk[81],$isi_chk[82],$isi_chk[83],$isi_chk[84],$isi_chk[85],$isi_chk[86],$isi_chk[87],$isi_chk[88],$isi_chk[89],$isi_chk[90],$isi_chk[91],$isi_chk[92],$isi_chk[93],$isi_chk[94],$isi_chk[95],$isi_chk[96],$isi_chk[97],$isi_chk[98],$isi_chk[99],$isi_chk[100],$isi_chk[101],$isi_chk[102],$isi_chk[103],$isi_chk[104],$isi_chk[105],$isi_chk[106],$isi_chk[107],$isi_chk[108],$isi_chk[109],$isi_chk[110],$isi_chk[111],$isi_chk[112],$isi_chk[113],$isi_chk[114],$isi_chk[115],$isi_chk[116],$isi_chk[117],$isi_chk[118],$isi_chk[119],$isi_chk[120],$isi_chk[121],$isi_chk[122],$isi_chk[123],$isi_chk[124],$isi_chk[125],$isi_chk[126],$isi_chk[127],$isi_chk[128],$isi_chk[129],$isi_chk[130],$isi_chk[131],$isi_chk[132],$isi_chk[133],$isi_chk[134],$isi_chk[135],$isi_chk[136],$isi_chk[137],$isi_chk[138],$isi_chk[139],$isi_chk[140],$isi_chk[141],$isi_chk[142],$isi_chk[143],$isi_chk[144],$isi_chk[145],$isi_chk[146],$isi_chk[147],$isi_chk[148],$isi_chk[149],$isi_chk[150],$isi_chk[151],$isi_chk[152],$isi_chk[153],$isi_chk[154],$isi_chk[155],$isi_chk[156],$isi_chk[157],$isi_chk[158],$isi_chk[159],$isi_chk[160],$isi_chk[161],$isi_chk[162],$isi_chk[163],$isi_chk[164],$isi_chk[165],$isi_chk[166],$isi_chk[167],$isi_chk[168],$isi_chk[169],$isi_chk[170],$isi_chk[171],$isi_chk[172],$isi_chk[173],$isi_chk[174],$isi_chk[175],$isi_chk[176],$isi_chk[177],$isi_chk[178],$isi_chk[179],$isi_chk[180],$isi_chk[181],$isi_chk[182],$isi_chk[183],$isi_chk[184],$isi_chk[185],$isi_chk[186]',
    CURDATE(),
    '$idUsr'
  );
";
		$ex=mysql_query($sql); //echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				echo mysql_error();
				}
	break;
	case 'edit':
		$sql="UPDATE b_form_pemeriksaan_lab SET
	pelayanan_id='$idPel',
  kunjungan_id='$idKunj', 
  no_formulir='$txt_noForm',
  tgl_terima='$tgl_terima',
  jam_terima='$jam_terima',
  isi='$isi_chk[0],$isi_chk[1],$isi_chk[2],$isi_chk[3],$isi_chk[4],$isi_chk[5],$isi_chk[6],$isi_chk[7],$isi_chk[8],$isi_chk[9],$isi_chk[10],$isi_chk[11],$isi_chk[12],$isi_chk[13],$isi_chk[14],$isi_chk[15],$isi_chk[16],$isi_chk[17],$isi_chk[18],$isi_chk[19],$isi_chk[20],$isi_chk[21],$isi_chk[22],$isi_chk[23],$isi_chk[24],$isi_chk[25],$isi_chk[26],$isi_chk[27],$isi_chk[28],$isi_chk[29],$isi_chk[30],$isi_chk[31],$isi_chk[32],$isi_chk[33],$isi_chk[34],$isi_chk[35],$isi_chk[36],$isi_chk[37],$isi_chk[38],$isi_chk[39],$isi_chk[40],$isi_chk[41],$isi_chk[42],$isi_chk[43],$isi_chk[44],$isi_chk[45],$isi_chk[46],$isi_chk[47],$isi_chk[48],$isi_chk[49],$isi_chk[50],$isi_chk[51],$isi_chk[52],$isi_chk[53],$isi_chk[54],$isi_chk[55],$isi_chk[56],$isi_chk[57],$isi_chk[58],$isi_chk[59],$isi_chk[60],$isi_chk[61],$isi_chk[62],$isi_chk[63],$isi_chk[64],$isi_chk[65],$isi_chk[66],$isi_chk[67],$isi_chk[68],$isi_chk[69],$isi_chk[70],$isi_chk[71],$isi_chk[72],$isi_chk[73],$isi_chk[74],$isi_chk[75],$isi_chk[76],$isi_chk[77],$isi_chk[78],$isi_chk[79],$isi_chk[80],$isi_chk[81],$isi_chk[82],$isi_chk[83],$isi_chk[84],$isi_chk[85],$isi_chk[86],$isi_chk[87],$isi_chk[88],$isi_chk[89],$isi_chk[90],$isi_chk[91],$isi_chk[92],$isi_chk[93],$isi_chk[94],$isi_chk[95],$isi_chk[96],$isi_chk[97],$isi_chk[98],$isi_chk[99],$isi_chk[100],$isi_chk[101],$isi_chk[102],$isi_chk[103],$isi_chk[104],$isi_chk[105],$isi_chk[106],$isi_chk[107],$isi_chk[108],$isi_chk[109],$isi_chk[110],$isi_chk[111],$isi_chk[112],$isi_chk[113],$isi_chk[114],$isi_chk[115],$isi_chk[116],$isi_chk[117],$isi_chk[118],$isi_chk[119],$isi_chk[120],$isi_chk[121],$isi_chk[122],$isi_chk[123],$isi_chk[124],$isi_chk[125],$isi_chk[126],$isi_chk[127],$isi_chk[128],$isi_chk[129],$isi_chk[130],$isi_chk[131],$isi_chk[132],$isi_chk[133],$isi_chk[134],$isi_chk[135],$isi_chk[136],$isi_chk[137],$isi_chk[138],$isi_chk[139],$isi_chk[140],$isi_chk[141],$isi_chk[142],$isi_chk[143],$isi_chk[144],$isi_chk[145],$isi_chk[146],$isi_chk[147],$isi_chk[148],$isi_chk[149],$isi_chk[150],$isi_chk[151],$isi_chk[152],$isi_chk[153],$isi_chk[154],$isi_chk[155],$isi_chk[156],$isi_chk[157],$isi_chk[158],$isi_chk[159],$isi_chk[160],$isi_chk[161],$isi_chk[162],$isi_chk[163],$isi_chk[164],$isi_chk[165],$isi_chk[166],$isi_chk[167],$isi_chk[168],$isi_chk[169],$isi_chk[170],$isi_chk[171],$isi_chk[172],$isi_chk[173],$isi_chk[174],$isi_chk[175],$isi_chk[176],$isi_chk[177],$isi_chk[178],$isi_chk[179],$isi_chk[180],$isi_chk[181],$isi_chk[182],$isi_chk[183],$isi_chk[184],$isi_chk[185],$isi_chk[186]',
  tgl_act=CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_form_pemeriksaan_lab WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>