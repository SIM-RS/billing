<?php 
// Koneksi =================================
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$tglSkrg2=gmdate('Y-m-d',mktime(date('H')+7));
//$th=explode("-",$tglSkrg);
$th=explode("-",mysqli_real_escape_string($konek,$tglSkrg));
$tgla="01-".$th[1]."-".$th[2];
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);

if ($ta=="") $ta=$th[2];
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$id=$_REQUEST['id'];
//$id=array(mysqli_real_escape_string($konek,$_REQUEST['id']));
$no_penjualan=$_REQUEST['no_penjualan'];

//$no_penjualan=mysqli_real_escape_string($konek,$_REQUEST['no_penjualan']);
// $av_registry_id=$_REQUEST['av_registry_id'];
//$no_pasien=$_REQUEST["no_pasien"];//if($no_pasien=="") $no_pasien=0;
$no_pasien=mysqli_real_escape_string($konek,$_REQUEST['no_pasien']);
//$nama_pasien=$_REQUEST['nama_pasien']; //if($nama_pasien=="") $nama_pasien=0;
$nama_pasien=mysqli_real_escape_string($konek,$_REQUEST['nama_pasien']);
//$no_pelayanan=$_REQUEST['pelayananID'];
$no_pelayanan=mysqli_real_escape_string($konek,$_REQUEST['pelayananID']);
//$nama_pasien1=str_replace("\'","'",$nama_pasien);
$nama_pasien1=str_replace('\"','"',$nama_pasien);

//echo "pos=".strpos($nama_pasien1,"'")."<br>";
//$no_retur=$_REQUEST['no_retur'];
$obat_id=$_REQUEST['obat_id'];
//$obat_id=array(mysqli_real_escape_string($konek,$_REQUEST['obat_id']));
$pb=mysqli_real_escape_string($konek,$_GET['pbf']);
if($pb==""){$pbf_id=0;}else{$pbf_id=$pb;}
//$no_retur=$_REQUEST['no_retur'];
$no_retur=mysqli_real_escape_string($konek,$_REQUEST['no_retur']);
//$tgl_s=$_REQUEST['tgl_s'];
$tgl_s=mysqli_real_escape_string($konek,$_REQUEST['tgl_s']);
	$s=explode("-",$tgl_s);
	$tgl_se=trim($s[2])."-".trim($s[1])."-".trim($s[0]);
//$tgl_d=$_REQUEST['tgl_d'];
$tgl_d=mysqli_real_escape_string($konek,$_REQUEST['tgl_d']);
	$d=explode("-",$tgl_d);
	$tgl_de=trim($d[2])."-".trim($d[1])."-".trim($d[0]);
$qty_satuan=$_REQUEST['qty_satuan'];
//$qty_satuan=array(mysqli_real_escape_string($konek,$_REQUEST['qty_satuan']));
//$idPel=$_REQUEST['idPel'];
$idPel=mysqli_real_escape_string($konek,$_REQUEST['idPel']);
//$alasan = $_REQUEST['alasan'];
$alasan=mysqli_real_escape_string($konek,$_REQUEST['alasan']);
$status=1;
//====================================================================

//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="c.OBAT_NAMA ASC,a.ID DESC";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST['act']);
//echo $act."<br>";

//echo $_REQUEST['tot_ret']." | ".$_REQUEST['ada_ret'];
//die();
//print_r($qty_satuan);

$tgllll=gmdate('d-m-Y',mktime(date('H')+7));
$thhhh=explode("-",$tgllll);
$blnNow = $thhhh[1];
$thnNow = $thhhh[2];

switch ($act){
	case "save":
	//$ada_ret = $_REQUEST['ada_ret'];
	$ada_ret=mysqli_real_escape_string($konek,$_REQUEST['ada_ret']);
	//$tot_ret = $_REQUEST['tot_ret'];
	$tot_ret=mysqli_real_escape_string($konek,$_REQUEST['tot_ret']);
	//$no_jual = $_REQUEST['no_jual'];
	$no_jual=mysqli_real_escape_string($konek,$_REQUEST['no_jual']);
	
	if($ada_ret == '1'){
		$ada_ret = $ada_ret;
	} else {
		$ada_ret = 0;
	}
	
	$cekNo = "select MAX(nomor) NO_RETUR from a_no_retur_log WHERE tahun = YEAR(NOW())";
	$qcekNo = mysqli_query($konek,$cekNo);
	$dcekNo = mysqli_fetch_array($qcekNo);
	$sql = "select MAX(CAST(no_retur AS UNSIGNED)) AS NO_RETUR from a_return_penjualan 
			where no_retur<>0 AND YEAR(tgl_retur) = YEAR(NOW())";
	$rs=mysqli_query($konek,$sql);
	$rows=mysqli_fetch_array($rs);
	$cNo_Retur=$rows['NO_RETUR'];
	
	if ((int)substr($cNo_Retur,0,-6)==$idunit){
		$cNo_Retur = substr($cNo_Retur,-6); //substr($cNo_Retur,1,(strlen($cNo_Retur)-1));
	}
	
	if(!empty($dcekNo['NO_RETUR'])){
		if(((int)$dcekNo['NO_RETUR']) > ((int)$cNo_Retur)){
			$nokw=(int)$dcekNo["NO_RETUR"]+1;
		} else if(((int)$dcekNo['NO_RETUR']) < ((int)$cNo_Retur)){
			$nokw=(int)$cNo_Retur+1;
		} else {
			$nokw=(int)$dcekNo["NO_RETUR"]+1;
		}
	} else {
		$nokw=(int)$cNo_Retur+1;
	}
	
	$updateNO = "insert into a_no_retur_log(nomor,unit_id,tahun) value('{$nokw}','$idunit',YEAR(NOW()))";
	$qNO = mysqli_query($konek,$updateNO) or die (mysqli_error($konek));
	$idNomor = mysqli_insert_id($konek);
	
	$sqlNomor = "select nomor from a_no_retur_log where id = '{$idNomor}'";
	$qNomor = mysqli_query($konek,$sqlNomor);
	$dNomor = mysqli_fetch_array($qNomor);
	
	if(!empty($dNomor['nomor'])){
		$nokw = (int)$dNomor['nomor'];
	} else {
		$nokw = 1;
	}
	
	$nokwstr=(string)$nokw;
	if (strlen($nokwstr)<6){
		for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
	}else{
		$nokw=$nokwstr;
	}
	
	$nokw=$idunit.$nokw;
	
	$no_retur = $nokw;
	
	for ($i = 0; $i < count($qty_satuan); $i++){
	 	//echo $qty_satuan[$i]."<BR>";
		$sql="SELECT SQL_NO_CACHE a.* 
			FROM a_penjualan a 
			INNER JOIN a_penerimaan b ON a.PENERIMAAN_ID=b.ID 
			WHERE /* a.UNIT_ID=$idunit 
			  AND */
			   a.NO_PENJUALAN='$no_penjualan[$i]' 
			  AND b.OBAT_ID=$obat_id[$i] 
			  AND a.QTY_JUAL>a.QTY_RETUR 
			  AND a.NAMA_PASIEN = '{$nama_pasien}'
			  AND a.NO_PASIEN = '{$no_pasien}'
			  AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de' ORDER BY ID DESC";
	//	echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$cjml=$qty_satuan[$i];
		//echo $cjml."<br />";
		$ok="false";
		$tcharga = 0;
		while (($rows=mysqli_fetch_array($rs))&&($ok=="false")){
			$deff = mysqli_fetch_array(mysqli_query($konek,"select ".$rows["QTY_JUAL"]."-".$rows["QTY_RETUR"]." cqty"));
			$cqty=$deff['cqty'];//($rows["QTY_JUAL"])-($rows["QTY_RETUR"]);
			$cidp=$rows["ID"];
			$pidp=$rows["PENERIMAAN_ID"];
			$ppn = $rows['PPN'];
			//echo $rows["QTY_JUAL"]."-".$rows["QTY_RETUR"]."<br />";
			//echo "$cqty dohkah<br />";
			$minUtang = $ppn_nilai = 0;
			if ($cqty>=$cjml){
				//echo "$cqty >= $cjml <br/>";
				$ok="true";
				//$hSatuanO = $rows["HARGA_SATUAN"];
				//echo $rows["DIJAMIN"]." | ".$rows["HARGA_PX"];
				if($rows["HARGA_PX"] != "0" && $rows["DIJAMIN"] == '1'){
					$ppn_nilai = floor($rows["HARGA_PX"]*($ppn/100));
					$minUtang = floor($rows["HARGA_PX"]+$ppn_nilai)*$cjml;
				} else if($rows["DIJAMIN"] == '0'){
					$ppn_nilai = floor($rows["HARGA_SATUAN"]*($ppn/100));
					$minUtang = floor($rows["HARGA_SATUAN"]+$ppn_nilai)*$cjml;
				}
				$charga=floor(((100-$rows["BIAYA_RETUR"])/100)*($rows["HARGA_SATUAN"]+$ppn_nilai)*$cjml);
		
				$sql="update a_penjualan 
					SET USER_ID_RETUR=$iduser,
						NO_RETUR='$no_retur',
						TGL_RETUR=NOW(),
						SHIFT_RETUR=$shift, 
						QTY_RETUR=QTY_RETUR+$cjml,
						QTY=QTY-$cjml
					WHERE ID=$cidp";
				//echo "<br />".$sql." | 1<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="INSERT INTO a_return_penjualan(idpenjualan,unit_id_return,userid_retur,no_retur,shift_retur,
													tgl_retur,qty_retur,nilai,nilai_balik_px,balik_uang,alasan,ppn,ppn_nilai) 
					VALUES($cidp,$idunit,$iduser,'$no_retur',$shift,NOW(),$cjml,$charga,$minUtang,'$ada_ret','$alasan','$ppn','$ppn_nilai')";
				//echo "<br />".$sql." | 1<br>";
						$rs1=mysqli_query($konek,$sql);
			} else {
				//echo "$cjml-$cqty adadad<br />";
				$deff = mysqli_fetch_array(mysqli_query($konek,"select ".$cjml."-".$cqty." cqty"));
				//echo "select ".$cjml."-".$cqty." cqty aaaaaa<br />";
				$cjml = $deff['cqty']; //(($cjml)-($cqty));
				//echo $cjml." adadadadadad<br>";
				//echo $rows["DIJAMIN"]." | ".$rows["HARGA_PX"];
				if($rows["HARGA_PX"] != "0" && $rows["DIJAMIN"] == '1'){
					$ppn_nilai = floor($rows["HARGA_PX"]*($ppn/100));
					$minUtang = floor($rows["HARGA_PX"]+$ppn_nilai)*$cqty;
				} else if($rows["DIJAMIN"] == '0'){
					$ppn_nilai = floor($rows["HARGA_SATUAN"]*($ppn/100));
					$minUtang = floor($rows["HARGA_SATUAN"]+$ppn_nilai)*$cqty;
				}
				$charga=floor(((100-$rows["BIAYA_RETUR"])/100)*($rows["HARGA_SATUAN"]+$ppn_nilai)*$cqty);
			
				
				$sql="update a_penjualan 
						SET USER_ID_RETUR=$iduser,
							NO_RETUR='$no_retur',
							TGL_RETUR=NOW(),
							SHIFT_RETUR=$shift,
							QTY_RETUR=QTY_RETUR+$cqty,
							QTY=QTY-$cqty
						WHERE ID=$cidp";
				// echo "<br />".$sql."<br>";
						$rs1=mysqli_query($konek,$sql);
				$sql="INSERT INTO a_return_penjualan(idpenjualan,unit_id_return,userid_retur,no_retur,shift_retur,
													tgl_retur,qty_retur,nilai,nilai_balik_px,balik_uang,alasan,ppn,ppn_nilai) 
					VALUES($cidp,$idunit,$iduser,'$no_retur',$shift,NOW(),$cqty,$charga,$minUtang,'$ada_ret','$alasan','$ppn','$ppn_nilai')";
				//echo "<br />".$sql."<br>";
						$rs1=mysqli_query($konek,$sql);
			}
			$tcharga += $minUtang;
		}
		
		$sUp = "update a_penjualan
				SET 
					UTANG = CASE WHEN UTANG <> 0 THEN FLOOR(UTANG-{$tcharga}) WHEN UTANG = 0 THEN 0 END
				 WHERE /* UNIT_ID = '{$idunit}'
				  AND */ NO_PENJUALAN = '{$no_jual}'
				  AND NO_PASIEN = '{$no_pasien}'
				  AND NAMA_PASIEN = '{$nama_pasien}'
				  AND TGL BETWEEN '$tgl_se' AND '$tgl_de'";
		$qUp = mysqli_query($konek,$sUp);
		//echo $sUp;
	}
	
	break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par,opt){
	var keywords=par.value;
	//document.getElementById('divobat').innerHTML='';
	//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
		document.getElementById('divobat').innerHTML='';
		//btnReturn.disabled = false;
	}else{
		/* btnReturn.disabled = true;
		isiantbl.innerHTML = ""; */
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if(key == 27){
			document.getElementById('divobat').style.display='none';
			fKeyEnt=false;
		} else if (key == 38 || key == '40'){
			var tblRow=document.getElementById('pasienlist_penj').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			var tgl_d = document.getElementById('tgl_d').value;
			var tgl_s = document.getElementById('tgl_s').value;
			if ((fKeyEnt==false) && (keywords.length>2)){
				RowIdx=0;
				fKeyEnt=true;
				
				
				Request('../transaksi/pasienlist_rtr.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt+'&tgl_d='+tgl_d+'&tgl_s='+tgl_s, 'divobat', '', 'GET' );
			
				
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			}else{
				if (RowIdx>0){
					if (fKeyEnt==true){
						fSetObat(document.getElementById(RowIdx).lang);
						fKeyEnt=false;
					//}else{
					//	fKeyEnt=false;
					}
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			//RowIdx=0;
			fKeyEnt=false;
			/*Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt, 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';*/
		}
	}
}

function replaceall(str,replace,with_this)
{
	var str_hasil ="";
	var temp;

	for(var i=0;i<str.length;i++) // not need to be equal. it causes the last change: undefined..
	{
		if (str[i] == replace)
		{
			temp = with_this;
		}
		else
		{
			temp = str[i];
		}

		str_hasil += temp;
	}

	return str_hasil;
}

//ajax save and get data
var rowKe = "";
function getRequestObject2(){
    var o = null;
    if(window.XMLHttpRequest){
        o = new XMLHttpRequest();
    }else if(window.ActiveXObject){
        try{
            o = new ActiveXObject('Msxml2.XMLHTTP');
        }catch(e1){
            try{
                o = new ActiveXObject('Microsoft.XMLHTTP');
            }catch(e2){

            }
        }
    }
    return o;
}

function request2(method, adress, sendData, callback, act){
	//alert(rowKe);
    var o = getRequestObject2();
    var async = (callback!==null);
	var balik = 0;
    if(method === 'GET'){
        if(sendData!=null){adress+="?"+sendData;}
        o.open(method, adress, async);
        o.send(null);
    }else if(method === 'POST'){
        o.open(method, adress, async);
        o.setRequestHeader('Content-Type' , 'application/x-www-form-urlencoded');
        o.send(sendData);
    }
    if(async){
        o.onreadystatechange = function (){
            if(o.readyState==4&&o.status==200){
				//document.getElementById("hasilSementara").innerHTML = o.responseText;
				if(callback!=undefined && typeof(callback)=='function'){
					callback(o.responseText);
				}
            }else if(o.readyState==4&&o.status!=200){
                //Error
				req[pos].xmlhttp.abort();
            }
        };
    }
	/* if(balik == 1){
		return false;
	} */
    if(async){
		return ;
	} else {
		return o.responseText;
	}
}

//end ajax save and get data

function fSetObat(par){
	//btnReturn.disabled = true;
	isiantbl.innerHTML = "";
	var tpar=par;
	var cdata;
	var tbl = document.getElementById('tblJual');
	var tds;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	cdata=tpar.split("*|*");
	document.forms[0].no_jual.value=cdata[6];
	document.forms[0].nama_pasien.value=cdata[1];
	document.forms[0].no_pasien.value=cdata[2];
	document.forms[0].pelayananID.value=cdata[3];
	document.forms[0].kso_id.value=cdata[7];
	// document.forms[0].av_registry_id.value=cdata[9];
	//document.forms[0].tgl_s.value=cdata[5];
	document.getElementById('isianTpel').innerHTML=cdata[4];
	document.getElementById('isianSpx').innerHTML=cdata[8];
	
	document.getElementById('divobat').style.display='none';
}

Number.prototype.formatN = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
var iur_px = 0;
function fHitungRetur(par){
	var tbl = document.getElementById('tblRetur');
	var tds,i,p,q,s;
	i=par.parentNode.parentNode.rowIndex;
	tds = tbl.rows[i].getElementsByTagName('td');
	p=tds[4].innerHTML;
	/* p=p.replace(".","");
	p=p.replace(",","."); */
	p = replaceall(p,'.','');
	p = replaceall(p,',','.');
	s=tds[3].innerHTML;
	
	var tmpIur = tds[7].childNodes[1].value.split('|');
	var harga_px = tmpIur[0]*1;
	var dijamin = tmpIur[1];
	var ppn = tmpIur[2]*1;
	var ppn_nilai = tmpIur[3]*1;
	
	if(ppn_nilai > 0){
		var nilai_ppn = harga_px*(ppn/100);
		harga_px = harga_px+nilai_ppn;
	}
	
	if(harga_px > 0 && dijamin == '1'){
		iur_px += parseFloat(par.value)*harga_px;
	} else if(dijamin == '0') {
		iur_px += parseInt(p)*parseFloat(par.value);
	}
	
	//alert(harga_px+" ++ "+dijamin);
	//alert(p+'|'+s+'|'+par.value);
	tds[10].innerHTML=FormatNum(parseInt(p)*parseFloat(par.value)*((100-parseFloat(s))/100),0);
	q=0;
	for (var k=1;k<tbl.rows.length-1;k++){
		tds = tbl.rows[k].getElementsByTagName('td');
		q=q+parseFloat(tds[10].innerHTML);
	}
	
	tds = tbl.rows[tbl.rows.length-1].getElementsByTagName('td');
	tds[0].innerHTML="Total = "+FormatNum(q,0);
	document.getElementById('nominal').innerHTML=iur_px.formatN(2,3,'.',',');
	document.getElementById('tot_ret').value=FormatNum(q,0);
	//alert(iur_px);
}

function fChecked(par){
var tbl = document.getElementById('tblRetur');
var i = par.parentNode.parentNode.rowIndex;
var tds = tbl.rows[i].getElementsByTagName('td');
var q;
	/* var qty_ret = tds[7].childNodes[0].value;
	var tmpIur = tds[7].childNodes[1].value.split('|');
	var harga_px = tmpIur[0];
	var dijamin = tmpIur[1];
	var min_ret = parseFloat(qty_ret)*harga_px;
	alert(mit_ret+" ++ "+qty_ret); */
	
	tds[10].innerHTML='0';
	document.getElementById('qty_satuan'+(i-1).toString()).value='0';
	q=0;
	iur_px = 0;
	for (var k=1;k<tbl.rows.length-1;k++){
		tds = tbl.rows[k].getElementsByTagName('td');
		q=q+parseFloat(tds[10].innerHTML);
		var qty_ret = tds[7].childNodes[0].value;
		var tmpIur = tds[7].childNodes[1].value.split('|');
		var harga_px = tmpIur[0];
		var dijamin = tmpIur[1];
		if(harga_px > 0 && dijamin == '1'){
			iur_px += parseFloat(qty_ret)*harga_px;
		} else if(dijamin == '0') {
			iur_px += parseFloat(tds[10].innerHTML);
		}
		//alert(iur_px+" ++ "+qty_ret);
	}
	//alert(iur_px);
	tds = tbl.rows[tbl.rows.length-1].getElementsByTagName('td');
	tds[0].innerHTML="Total = "+FormatNum(q,0);
	document.getElementById('nominal').innerHTML=iur_px.formatN(2,3,'.',',');
	document.getElementById('tot_ret').value=FormatNum(q,0);
}

function fSubmit(){
var tbl = document.getElementById('tblRetur');
var tds,i,p,q,s;
var chk=false;
	//alert(document.forms[0].pilihobat.length);
	if(document.forms[0].alasan.value == '0'){
		alert('Pilih Terlebih Dahulu Alasan Retur Anda!');
		return false;
	}
	if (document.forms[0].pilihobat.length){
		for (i=0;i<document.forms[0].pilihobat.length;i++){
			if (document.forms[0].pilihobat[i].checked){
				chk=true;
				tds = tbl.rows[i+1].getElementsByTagName('td');
				p=tds[9].innerHTML;
				//alert(p);
				/* p = replaceall(p,'.','');
				p = replaceall(p,',','.'); */
				dd = document.getElementById('qty_satuan'+i.toString()).value;
				if (parseFloat(dd)>parseFloat(p)){
					alert('Jumlah Item Obat Yang diReturn Lebih Besar dr Sisa Stock');
					document.getElementById('qty_satuan'+i.toString()).focus();
					return false;
				}
				
				if(dd == '0'){
					alert('Maaf QTY Return Tidak Boleh 0 (nol)!');
					return false;
				}
			}
		}
	}else{
		if (document.forms[0].pilihobat.checked){
			chk=true;
			tds = tbl.rows[1].getElementsByTagName('td');
			p=tds[9].innerHTML;
			/* p = replaceall(p,'.','');
			p = replaceall(p,',','.'); */
			dd = document.getElementById('qty_satuan0').value;
			if (parseFloat(dd)>parseFloat(p)){
				alert('Jumlah Item Obat Yang diReturn Lebih Besar dr Sisa Stock');
				return false;
			}
			
			if(dd == '0'){
				alert('Maaf QTY Return Tidak Boleh 0 (nol)!');
				return false;
			}
		}
	}
	//alert(parseFloat(dd)+">"+parseFloat(p));
	if (chk){
		//alert('Submit');
		//document.getElementById('btnReturn').disabled=true;
		//alert(cara_bayar.value+'||'+kso_id.value+'||'+kronis.value);
		if((cara_bayar.value == '2' || cara_bayar.value == '4') /* && dijamin.value == '0' */ && kronis.value == '0'){ //kso_id.value != '88'
			var act = "cek";
			var urlBook = "../transaksi/retjual_utils.php";
			var data = "&act="+act+"&carabayar"+cara_bayar.value+"&no_pasien="+no_pasien.value+'&no_pelayanan='+pelayananID.value+"&tgl_s="+tgl_s.value+"&tgl_d="+tgl_d.value; // "av_registry_id="+av_registry_id.value+
			request2("GET", urlBook, data, function(hasil){
				switch(hasil){
					case 'ada':
						document.getElementById('ada_ret').value = "1";
						Modus('buka');
						break;
					case 'kosong':
						document.forms[0].submit();
						break;
					case 'gagal':
						var hasil2 = hasil.split('|');
						alert('Gagal Melakukan Pengecekan Data! ['+hasil[1]+']');
						breakl
				}
			}, act);
		} else if(cara_bayar.value == '1'){
			document.getElementById('ada_ret').value = "1";
			Modus('buka');
		} /* else if(cara_bayar.value == '2' && dijamin.value == '1'){ //kso_id.value == '88'
			//document.forms[0].submit();
		} */ else {
			document.forms[0].submit();
		}
		//document.forms[0].submit();
	}else{
		alert('Pilih Item Obat Yang diReturn Terlebih Dahulu !');
		return false;
	}
}

function lanjutkan(){
	document.forms[0].submit();
}

function noJual(e,par,opt){
	var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==13){
			//alert(keywords);
			var tgl_d = document.getElementById('tgl_d').value;
			var tgl_s = document.getElementById('tgl_s').value;
			location='?f=../transaksi/detil_retur_penjualan&no_jual='+keywords+'&idunit=<?php echo $idunit; ?>&tgl_d='+tgl_d+'&tgl_s='+tgl_s;
			/* if ((fKeyEnt==false) && (keywords.length>2)){
				RowIdx=0;
				fKeyEnt=true;
				Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt, 'divobat', '', 'GET' );
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			}else{
				if (RowIdx>0){
					if (fKeyEnt==true){
						fSetObat(document.getElementById(RowIdx).lang);
						fKeyEnt=false;
					//}else{
					//	fKeyEnt=false;
					}
				}
			} */
		}
	}
}
</script>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<?php 
$cstr="";
for ($i = 0; $i < count($no_penjualan); $i++)
{
	//echo strpos($cstr,$no_penjualan[$i])."<br>";
	//echo $cstr."--".$no_penjualan[$i]."<br>";
	if (strpos($cstr,$no_penjualan[$i])<=0) $cstr .="|".$no_penjualan[$i];
}
?>
<style>
	.modalDialog {
		position: fixed;
		font-family: Arial, Helvetica, sans-serif;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: rgba(0,0,0,0.8);
		visibility: hidden;
		opacity:0;
		-webkit-transition: opacity 400ms ease-in;
		-moz-transition: opacity 400ms ease-in;
		transition: opacity 400ms ease-in;
	}

	.modalDialog > div {
		width: 400px;
		position: relative;
		margin: 10% auto;
		padding: 5px 20px 13px 20px;
		border-radius: 10px;
		background: #fff;
		border:10px solid #000;
		z-index:20;
	}

	.close {
		background: #606061;
		color: #FFFFFF;
		line-height: 25px;
		position: absolute;
		right: -12px;
		text-align: center;
		top: -10px;
		width: 24px;
		text-decoration: none;
		font-weight: bold;
		-webkit-border-radius: 12px;
		-moz-border-radius: 12px;
		border-radius: 12px;
		-moz-box-shadow: 1px 1px 3px #000;
		-webkit-box-shadow: 1px 1px 3px #000;
		box-shadow: 1px 1px 3px #000;
	}

	.close:hover { background: #00d9ff; }

.rc-button, .rc-button:visited {
    -moz-user-select: none;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(center top , #f5f5f5, #f1f1f1);
    border: 1px solid #dcdcdc;
    border-radius: 3px;
    color: #444;
    cursor: default;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    height: 24px;
    min-width: 46px;
    padding: 0 8px;
    text-align: center;
    transition: all 0.218s ease 0s;
}
.rc-button-submit, .rc-button-submit:visited {
    background-color: #4d90fe;
    background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed);
    border: 1px solid #3079ed;
    color: #fff;
    text-shadow: 0 1px rgba(0, 0, 0, 0.1);
}
.rc-button:hover {
    background-color: #f6f6f6;
    background-image: -moz-linear-gradient(center top , #f6f6f6, #f1f1f1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
	cursor:pointer;
}
.rc-button-submit:hover {
	cursor:pointer;
    background-color: #357ae8;
    background-image: -moz-linear-gradient(center top , #4d90fe, #357ae8);
    border: 1px solid #2f5bb7;
    color: #fff;
    text-shadow: 0 1px rgba(0, 0, 0, 0.3);
}
</style>
<script type="text/javascript">
	function Modus(par){
		switch(par){
			case 'tutup':
				/* document.getElementById('modal').style.visibility = 'hidden';
				document.getElementById('modal').style.opacity = '0'; */
				
				document.getElementById('tutupRet').style.display = "none";
				document.getElementById('lanjutRet').style.display = "none";
				document.getElementsByClassName('modalDialog')[0].style.opacity = '0';
				document.getElementsByClassName('modalDialog')[0].style.visibility = 'hidden';
				//location='#close';
				break;
			case 'buka':
				document.getElementsByClassName('modalDialog')[0].style.opacity = "1";
				document.getElementsByClassName('modalDialog')[0].style.visibility = 'visible';
				document.getElementById('tutupRet').style.display = "inline-block";
				document.getElementById('lanjutRet').style.display = "inline-block";
				/* document.getElementById('modal').style.visibility = 'visible';
				document.getElementById('modal').style.opacity = '1'; */
				//location='#openModal';
				break;
		}
	}
</script>
<div id="openModal" class="modalDialog">
	<div>
		<h2>Perhatian!</h2>
		<p>Penjualan ini memiliki pembayaran, Silahkan melakukan pengembalian uang sebesar <b>Rp <span id="nominal" style="font-weight:bold;" ></span></b> kepada pasien</p>
		<input type="button" value="Simpan" onclick="lanjutkan();" class="rc-button rc-button-submit" name="lanjutRet" id="lanjutRet">
		<input type="button" value="Batal" onclick="Modus('tutup');" class="rc-button" name="tutupRet" id="tutupRet">
	</div>
</div>
<?php if($act=="save"){?>
<p align="center"> <b>Retur Penjualan Dengan No.Retur <?php echo $no_retur; ?> 
  telah dilakukan</b><br>
  <br>
<select name="cetak" id="cetak" onChange="">
	<?php
	$cstr=substr($cstr,1,strlen($cstr)-1);
	$no_penjualan=explode("|",$cstr);
	for ($i = 0; $i < count($no_penjualan); $i++){
		if ($no_pasien!=""){
			$sql="SELECT DISTINCT TGL FROM a_penjualan WHERE NO_PENJUALAN='$no_penjualan[$i]' /*AND UNIT_ID=$idunit*/ AND NO_PASIEN='$no_pasien' AND TGL BETWEEN '$tgl_se' AND '$tgl_de' and NAMA_PASIEN='$nama_pasien1'";
		}else{
			$sql="SELECT DISTINCT TGL FROM a_penjualan WHERE NO_PENJUALAN='$no_penjualan[$i]' /*AND UNIT_ID=$idunit*/ AND TGL BETWEEN '$tgl_se' AND '$tgl_de' and NAMA_PASIEN='$nama_pasien1'";
		}
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $tglrtr=$rows1['TGL']; else $tglrtr="0000-00-00";
	?>
	<option value="<?php echo $no_penjualan[$i];?>" lang="<?php echo $tglrtr; ?>"><?php echo $no_penjualan[$i];?></option>
	<?php } ?>
</select>
<BUTTON type="button" onClick="NewWindow('../newreport/kwi_retur_new.php?no_retur=<?php echo $no_retur; ?>&no_penjualan='+cetak.value+'&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $no_pasien; ?>&tgl='+cetak.options[cetak.selectedIndex].lang,'name','600','500','yes');return false"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak Retur</BUTTON>
<BUTTON type="button" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;</BUTTON>
<!--button type="button" onclick="pengembalianU()" name="pengembalianUang" id="pengembalianUang">Pengembalian Uang</button-->
<script type="text/javascript">
	function pengembalianU(){
		location = '?f=../transaksi/balik_uang.php&no_retur=<?php echo $no_retur; ?>&no_penjualan='+cetak.value+'&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $no_pasien; ?>&tgl='+cetak.options[cetak.selectedIndex].lang;
	}
</script>
</p>
<?php 
//==Jika Dalam keadaan Disimpan berakhir===	
}else{
	//$sql="select NO_RETUR from a_penjualan where NO_RETUR<>0 order by NO_RETUR desc limit 1";
	$cekNo = "select MAX(nomor) NO_RETUR from a_no_retur_log WHERE tahun = YEAR(NOW())";
	$qcekNo = mysqli_query($konek,$cekNo);
	$dcekNo = mysqli_fetch_array($qcekNo);
	$sql = "select MAX(CAST(no_retur AS UNSIGNED)) AS NO_RETUR from a_return_penjualan where no_retur<>0 AND YEAR(tgl_retur) = YEAR(NOW())";
	$rs=mysqli_query($konek,$sql);
	$rows=mysqli_fetch_array($rs);
	
	$cNo_Retur=$rows['NO_RETUR'];
	
	if ((int)substr($cNo_Retur,0,-6)==$idunit){
		$cNo_Retur = substr($cNo_Retur,-6); //substr($cNo_Retur,1,(strlen($cNo_Retur)-1));
	}
	
	if(!empty($dcekNo['NO_RETUR'])){
		if(((int)$dcekNo['NO_RETUR']) > ((int)$cNo_Retur)){
			$nokw=(int)$dcekNo["NO_RETUR"]+1;
		} else if(((int)$dcekNo['NO_RETUR']) < ((int)$cNo_Retur)){
			$nokw=(int)$cNo_Retur+1;
		} else {
			$nokw=(int)$dcekNo["NO_RETUR"]+1;
		}
	} else {
		$nokw=(int)$cNo_Retur+1;
	}
	
	$nokwstr=(string)$nokw;
	if (strlen($nokwstr)<6){
		for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
	}else{
		$nokw=$nokwstr;
	}
	
	$nokw=$idunit.$nokw;
	
	$nortr = $nokw;
?>
<style type="text/css">
	#kiri, #kanan{
		float:left;
		width:55%;
		padding:10px;
		font-size:12px;
	}
	#kanan{
		width:40%;
	}
	#kanan table{
		font-size:12px;
		font-weight:bold;
	}
	#kanan table td{
		padding:3px;
	}
	#clear{
		clear:both;
	}
	.inputan{
		border:0px;
		background:#EAF0F0;
		font-weight:bold;
		letter-spacing:2px;
	}
</style>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 700px; width:495px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center"> 
	<?php 
		//$no_jual = $_REQUEST['no_jual'];
		$no_jual = mysqli_real_escape_string($konek,$_REQUEST['no_jual']);
		//$IdUnit = $_REQUEST['idunit'];
		$IdUnit = mysqli_real_escape_string($konek,$_REQUEST['idunit']);
		//$tgl_d = $_REQUEST['tgl_d'];
		$tgl_d = mysqli_real_escape_string($konek,$_REQUEST['tgl_d']);
		//$tgl_s = $_REQUEST['tgl_s'];
		$tgl_s = mysqli_real_escape_string($konek,$_REQUEST['tgl_s']);
		
		$tgl_dTmp = explode('-',$tgl_d);
		$tgl_sTmp = explode('-',$tgl_s);
		
		$tmp_tglD = $tgl_dTmp[2].'-'.$tgl_dTmp[1].'-'.$tgl_dTmp[0];
		$tmp_tglS = $tgl_sTmp[2].'-'.$tgl_sTmp[1].'-'.$tgl_sTmp[0];
		
		//$no_pasien = $_REQUEST['no_pasien'];
		$no_pasien = mysqli_real_escape_string($konek,$_REQUEST['no_pasien']);
		if($no_pasien != ""){
			$pasien = "AND ap.NO_PASIEN = '{$no_pasien}'";
			$pasien2 = "AND a.NO_PASIEN = '{$no_pasien}'";
		} else {
			$pasien = "";
			$pasien2 = "";
		}
		
		$fnamaPas = '';
		if($nama_pasien1 != ''){
			$fnamaPas = "AND ap.NAMA_PASIEN='{$nama_pasien1}'";
		}
		if($no_jual != ""){
			$getJual = "SELECT ap.NAMA_PASIEN, ap.NO_KUNJUNGAN, ap.NO_PASIEN, ap.RUANGAN, u.UNIT_NAME, ap.CARA_BAYAR,
								ap.KSO_ID, m.NAMA/* , ap.KRONIS, ap.DIJAMIN */
						FROM a_penjualan ap
						LEFT JOIN a_unit u
						   ON u.UNIT_ID = ap.RUANGAN
						left JOIN a_mitra m
						   ON m.IDMITRA = ap.KSO_ID
						WHERE ap.NO_PENJUALAN = '{$no_jual}'
							{$fnamaPas}
						  /* AND ap.UNIT_ID = '{$IdUnit}' */
						  AND ap.TGL_ACT BETWEEN '{$tmp_tglS} 00:00:00' AND '{$tmp_tglD} 23:59:59'
						  /* DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y') BETWEEN '{$tgl_s}' AND '{$tgl_d}' */
						  {$pasien}
						GROUP BY ap.NO_PASIEN";
			// echo $getJual;
			$qgetJual = mysqli_query($konek,$getJual);
			$dgetJual = mysqli_fetch_array($qgetJual);
			
			$nama_pasien1 = $dgetJual['NAMA_PASIEN'];
			$no_pasien = $dgetJual['NO_PASIEN'];
			$noKunj = $dgetJual['NO_KUNJUNGAN'];
			$ruang = $dgetJual['UNIT_NAME'];
			$kso_nama = $dgetJual['NAMA'];
			$kso_id = $dgetJual['KSO_ID'];
			$carabayar = $dgetJual['CARA_BAYAR'];
			$kronis = $dgetJual['KRONIS'];
			$dijamin = $dgetJual['DIJAMIN'];
		}
	?>
  <div id="input" style="display:block">
    <p class="jdltable">Detil Retur Penjualan </p>
	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="retur_penjualan_id" id="retur_penjualan_id" type="hidden" value="">
	<input name="cara_bayar" id="cara_bayar" type="hidden" value="<?php echo $carabayar; ?>">
	<input name="page" id="page" type="hidden" value="">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<input type="hidden" name="tot_ret" id="tot_ret" value=""/>
	<input type="hidden" name="ada_ret" id="ada_ret" value=""/>
	<input type="hidden" name="kso_id" id="kso_id" value="<?php echo $kso_id; ?>"/>
	<input type="hidden" name="kronis" id="kronis" value="<?php echo $kronis; ?>"/>
	<div id="outer" >
		<div id="kiri">
			<table width="100%" border="0" align="center" style="margin-left:45px;" cellpadding="0" cellspacing="0" class="txtinput">
				<tr>
					<td height="25">Data mulai tgl </td>
					<td>:</td>
					<td width="320" >
						<input name="tgl_s" id="tgl_s" size="11" maxlength="10" readonly value="<?php if($_GET['tgl_s']<>"") echo $tgl_s;else echo $tgla;?>" class="txtcenter" />
						<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
						&nbsp; s/d &nbsp;
						<input name="tgl_d" id="tgl_d" size="11" maxlength="10" readonly value="<?php if($_GET['tgl_d']<>"") echo $tgl_d;else echo $tglSkrg;?>" class="txtcenter" />
						<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
					</td>
				</tr>
				<tr >
					<td width="100">No. Penjualan</td>
					<td width="12">:</td>
					<td colspan="2" >
						<input name="no_jual" id="no_jual" class="txtinput" size="10" value="<?php echo $no_jual; ?>" onKeyUp="noJual(event,this,3)" type="text">
						
					</td>
				</tr>
				<tr>
					<td height="25">No. Retur</td>
					<td>:</td>
					<td colspan="2" ><input name="no_retur" id="no_retur" size="10" value="<? echo $nortr; ?>" class="txtinput" type="text" readonly><!--input name="av_registry_id" id="av_registry_id" class="txtinput" size="10" value="<?php // echo $av_registry_id; ?>" type="hidden"--></td>
				</tr>
				<tr>
					<td height="25">No. Rekam Medis</td>
					<td>:</td>
					<td colspan="2" ><input name="no_pasien" id="no_pasien" size="10" value="<?php echo $no_pasien; ?>" class="txtinput" type="text" onKeyUp="suggest(event,this,2);" autocomplete="off"></td>
				</tr>
				<tr>
					<td width="100">Nama Pasien</td>
					<td width="12">:</td>
					<td colspan="2"><input name="nama_pasien" size="38" id="nama_pasien" value="<?php echo $nama_pasien1; ?>" <?php //if (strpos($nama_pasien1,'"')>0) echo "value='".$nama_pasien1."'"; else echo 'value="'.$nama_pasien1.'"'; ?> class="txtinput" onKeyUp="suggest(event,this,1);" autocomplete="off"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
					  <input type="button" value="&raquo; PROSES" name="checkbox" onClick="if(pelayananID.value != ''){ location='?f=../transaksi/detil_retur_penjualan.php&no_jual='+no_jual.value+'&nama_pasien='+nama_pasien.value+'&no_pasien='+no_pasien.value+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&idPel='+pelayananID.value+'&unit='+isianTpel.innerHTML+'&idunit=<?php echo $idunit; ?>'; 
					  } else {
						alert('Silahkan Pilih Pasien Terlebih Dahulu!');
						return false;
					  }">
					  <?php // '&av_registry_id='+av_registry_id.value+ ?>
					</td>
				</tr>
			</table>
		</div>
		<div id="kanan" align="left">
			<table>
				<tr>
					<td>No. Kunjungan</td>
					<td>:</td>
					<td><input type="text" class="inputan" value="<?php echo $noKunj?>" name="pelayananID" id="pelayananID" size="10" readonly /></td>
				</tr>
				<tr>
					<td>Tempat Layanan</td>
					<td>:</td>
					<td id="isianTpel"><?php echo $ruang?></td>
				</tr>
				<tr>
					<td>Status Px</td>
					<td>:</td>
					<td id="isianSpx"><?php echo $kso_nama?></td>
				</tr>
				<tr><td colspan="3" >&nbsp;<input type="hidden" name="dijamin" id="dijamin" value="<?php echo $dijamin; ?>" /></td></tr>
				<tr>
					<td>Alasan Retur</td>
					<td>:</td>
					<td>
						<select name="alasan" id="alasan">
							<option value="0">-- Pilih Alasan --</option>
							<?php 
								$sAlRet = "select * from a_alasan_retur_penjualan order by id";
								$qAlRet = mysqli_query($konek,$sAlRet);
								$jm = mysqli_num_rows($qAlRet);
								if($jm > 0){
									while($dataA = mysqli_fetch_array($qAlRet)){
										echo "<option value='".$dataA['id']."'>".$dataA['alasan']."</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>	  
	<div id="clear"></div>
      <table id="tblRetur" width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<thead>
        <tr class="headtable"> 
          <td width="80" height="25" class="tblheaderkiri" id="TGL" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td width="80" class="tblheader" id="NO_PENJUALAN" onClick="ifPop.CallFr(this);">No. Penjualan </td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama Obat </td>
          <td width="100" class="tblheader">Biaya Return (%)</td>
          <td width="80" class="tblheader">Harga Satuan</td>
          <td width="40" class="tblheader">Qty Jual </td>
          <td width="40" class="tblheader">Qty Sdh Return</td>
          <td colspan="2" class="tblheader">Qty Return </td>
          <td width="47" class="tblheader">Qty</td>
          <td width="90" class="tblheader">Subtotal Return</td>
          <!--td><input name="checkSedoyo" type="checkbox" value="" onClick="fCheckAll(checkSedoyo,pilihobat)"></td-->
        </tr>
		</thead>
		<tbody id="isiantbl">
        <?php
			if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  		}
	  		if ($sorting=="") $sorting=$defaultsort;
			if($no_jual != ""){
				
				
			$sql = "SELECT a.TGL, a.NO_PENJUALAN, b.OBAT_ID,  a.JENIS_PASIEN_ID, a.BIAYA_RETUR, a.HARGA_SATUAN,
					SUM(a.QTY_JUAL) AS QTY_JUAL, SUM(a.QTY_RETUR) AS QTY_RETUR,
					SUM(a.QTY_JUAL)-SUM(a.QTY_RETUR) AS QTY, c.OBAT_ID, c.OBAT_NAMA, a.HARGA_SATUAN HARGA_PX, a.PPN_NILAI, a.PPN
					/* , a.DIJAMIN  */
					FROM a_penjualan a 
					INNER JOIN a_penerimaan b ON a.PENERIMAAN_ID = b.ID 
					INNER JOIN a_obat c ON b.OBAT_ID = c.OBAT_ID 
					WHERE  a.NAMA_PASIEN ='$nama_pasien1' 
					  AND a.TGL BETWEEN '{$tgl_se}' AND '{$tgl_de}'".$filter." 
					/* AND a.NO_KUNJUNGAN = '{$noKunj}'*/
					/* AND a.NO_PENJUALAN = '{$no_jual}'*/
					/* AND a.NAMA_PASIEN = '{$nama_pasien1}' */
					  {$pasien2}
					GROUP BY c.OBAT_ID, a.NO_PENJUALAN, c.OBAT_NAMA 
					ORDER BY ".$sorting;
			// echo $sql."<br>";
			$exe=mysqli_query($konek,$sql);
			$i=0;
			while ($show=mysqli_fetch_array($exe)){
				$ngitung=$i++;
				//$cbiaya=$show["BIAYA_RETUR"];
           ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <input type="hidden" name="id[]" id="id<?php echo $ngitung; ?>" value="<?php echo $show['ID'];?>" disabled="disabled">
          <td class="tdisikiri"> <?php echo date("d/m/Y",strtotime($show['TGL'])); ?> </td>
          <td class="tdisi"><?php echo $show['NO_PENJUALAN']; ?></td>
          <input type="hidden" name="no_penjualan[]" id="no_penjualan<?php echo $ngitung; ?>" value="<?php echo $show['NO_PENJUALAN'];?>" disabled="disabled">
          <td class="tdisi"><?php echo $show['OBAT_NAMA'];?> <input type="hidden" name="obat_id[]" id="obat_id<?php echo $ngitung; ?>" value="<?php echo $show['OBAT_ID'];?>" disabled="disabled"></td>
          <td class="tdisi"><?php echo $show['BIAYA_RETUR']; ?></td>
		  <?php
			$harga_satuan = $show['HARGA_SATUAN'];
			$ppn = $show['PPN'];
			$ppn_nilai = $show['PPN_NILAI'];
			
			if($ppn_nilai > 0){
				$ppn_harga = $harga_satuan*($ppn/100);
				$harga_satuan += $ppn_harga;
			}
			
		  ?>
          <td class="tdisi" align="right"><?php echo number_format($harga_satuan,0,",","."); ?></td>
          <td class="tdisi"><?php echo $show['QTY_JUAL'];?></td>
          <td class="tdisi"><?php echo $show['QTY_RETUR'];?></td>
          <td width="47" align="right" class="tdisi"><input name="qty_satuan[]" size="5" class="txtcenter" id="qty_satuan<?=$ngitung?>" value="0" disabled="disabled" onKeyUp="fHitungRetur(this)" autocomplete="off"><input type="hidden" name="harga_px[]" id="harga_px<?=$ngitung?>" value="<?php echo $show['HARGA_PX']."|".$show['DIJAMIN']."|".$show['PPN']."|".$show['PPN_NILAI'];?>" /></td>
          <td width="40" class="tdisi"><input name="pilihobat" type="checkbox" value="" onClick="if (this.checked==true){document.getElementById('id<?=$ngitung;?>').disabled='';document.getElementById('no_penjualan<?=$ngitung;?>').disabled='';document.getElementById('obat_id<?=$ngitung;?>').disabled='';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='';}else{fChecked(this);document.getElementById('id<?=$ngitung;?>').disabled='disabled'; document.getElementById('no_penjualan<?=$ngitung;?>').disabled='disabled';document.getElementById('obat_id<?=$ngitung;?>').disabled='disabled';document.getElementById('qty_satuan<?=$ngitung;?>').disabled='disabled';}"> 
          </td>
          <td class="tdisi"><?php echo $show['QTY'];?></td>
          <td class="tdisi" align="right" style="padding-right:5px;">0</td>
        </tr>
        <? 
			$hartot=$hartot+($show['HARGA_SATUAN']*$show['QTY_RETUR']);
			//echo "<br>".$hartot."<br>";
			}
			}
			?>
		</tbody>
		<tfoot>
			<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
			  <td class="tdisikiri" colspan="11" align="right" style="padding-right:5px;"> 
				<b>Total = 0</b> </td>
			</tr>
		</tfoot>
      </table>
      <p align="center">
        <!--BUTTON type="button" onClick="if(ValidateForm('nama_pasien','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;</BUTTON-->
        <BUTTON id="btnReturn" type="button" onClick="if(ValidateForm('nama_pasien','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;</BUTTON>
         <BUTTON type="reset" onClick="location='?f=../transaksi/retur_penjualan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
    </form>
  </div>
</div>
<?php } 
mysqli_close($konek);
?>