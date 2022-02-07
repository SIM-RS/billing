<?php	
//include("../koneksi/konek.php");

	  // Detail Data Parameters
	  if (isset($_REQUEST["p"])) {
		  $_SESSION['itemtree.filter'] = $_REQUEST["p"];
		  $p = $_SESSION['itemtree.filter'];	
	  }
	  else
	  {
		  if ($_SESSION['itemtree.filter'])
		  $p = $_SESSION['itemtree.filter'];
	  }
	
	  $canRead = true;
	  $include_del = 1;
	  $maxlevel=0;
	  $cnt=0;
	  
	  $strSQL = "SELECT 
	  id,
	  kode,
	  nama,
	  level,
	  parent_id,
	  parent_kode,
	  islast,
	  IF(surveilance = 1, 'Ya', 'Tidak') AS surveilance,
	  IF(aktif = 1, 'Aktif', 'Tidak') AS aktif,
	  dg_kode,md.kdg_id,mdg.kdg_nama,
	  (SELECT 
	  DG_NAMA 
	  FROM
		b_ms_diagnosa_gol WHERE DG_KODE = md.dg_kode) AS gol 
	FROM
	  b_ms_diagnosa md left join b_ms_diagnosa_gambar mdg on md.kdg_id=mdg.kdg_id order by md.kode";
	  
	  //$strSQL = "select * from b_ms_diagnosa order by kode";
	  $rs = mysql_query($strSQL);

        //bikin halaman        
        $sql=$strSQL;
        
        $jmldata=mysql_num_rows($rs);
         
         $tpage=($page-1)*$perpage;
         if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
         if ($page>1) $bpage=$page-1; else $bpage=1;
         if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
         $sql=$sql." limit $tpage,$perpage";
         //end of bikin halaman
         
         //echo $sql."<br/>";
         $rs=mysql_query($sql);
        
	  while ($rows=mysql_fetch_array($rs)){
			 $c_level = $rows["level"];
			 $pkode=trim($rows['parent_kode']);
			 $mkode=trim($rows['kode']);
			 $txtGol=trim($rows['gol']);
			 $dg_kode=trim($rows['dg_kode']);
			 $kdg_id=trim($rows['kdg_id']);
			 $koding=$rows['kode'];
			 
			 $chkAktif=($rows['aktif']==1)?'true':'false';
			 if ($pkode!=""){
			 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
					$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode))); //+1 karena ada titik di kode
				//else
				//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			 }
			
			/*
			$sql="SELECT 
			  id,
			  kode,
			  nama,
			  level,
			  parent_id,
			  parent_kode,
			  islast,
			  IF(surveilance = 1, 'Ya', 'Tidak') AS surveilance,
			  IF(aktif = 1, 'Aktif', 'Tidak') AS aktif,
			  dg_kode,
			  (SELECT 
				DG_NAMA 
			  FROM
				b_ms_diagnosa_gol 
			  WHERE DG_KODE = md.dg_kode) AS gol 
			FROM
			  b_ms_diagnosa md where md.kode='$koding'";
			  //echo "<br>";
	 
	         //$sql = "select * from b_ms_diagnosa where id=".$rows['parent_id'];
			 $rs1=mysql_query($sql)or die(mysql_error()); 
			 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
			 */
			 $tree[$cnt][0]= $c_level;
			 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];
		//	$rr=$rows["nama"];
			 //echo $rr;*/
			  
			 $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$koding."*|*txtDiag*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*cmbSur*-*".$rows['surveilance']."*|*isAktif*-*".$chkAktif."*|*txtGol*-*".$txtGol."*|*dg_kode*-*".$dg_kode."*|*cmbKodeAlert*-*".$kdg_id."*|*act1*-*Edit";
			 $arfvalue=str_replace('"',chr(3),$arfvalue);
			 $arfvalue=str_replace("'",chr(5),$arfvalue);
			 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
			 //pembatas fungsi ini fungsi untuk delete
			 $arfvaluex="txtId*-*".$rows1['id']."*|*txtKode*-*".$koding."*|*txtDiag*-*".$rows1['nama']."*|*txtParentLvl*-*".($rows1['level']-1)."*|*txtLevel*-*".$rows1['level']."*|*txtParentId*-*".$rows1['parent_id']."*|*txtParentKode*-*".$rows1['parent_kode']."*|*cmbSur*-*".$rows1['surveilance']."*|*isAktif*-*".$chkAktif."*|*txtGol*-*".$txtGol."*|*dg_kode*-*".$dg_kode."*|*cmbKodeAlert*-*".$kdg_id."*|*act1*-*Edit";
			 $arfvaluex=str_replace('"',chr(3),$arfvaluex);
			 $arfvaluex=str_replace("'",chr(5),$arfvaluex);
			 $arfvaluex=str_replace(chr(92),chr(92).chr(92),$arfvaluex);
			 
			 
			 if ($c_level>0)
				 //$tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');";
				 $tree[$cnt][2]= "javascript:Editing();fSetValue(window,'".$arfvalue."');";
			 else
				 $tree[$cnt][2] = null;
	
			 $tree[$cnt][3]= "";
			 $tree[$cnt][4]= 0;
			 $tree[$cnt][5]=($rows['islast']==1)?$rows['id']:0;
			 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
			 $tree[$cnt][6]=$rows['aktif'];
			 
			 $tree[$cnt][7]="javascript:hapuswes();fSetValue(window,'".$arfvaluex."');";
			 if ($tree[$cnt][0] > $maxlevel) 
				$maxlevel=$tree[$cnt][0];    
			 $cnt++;
		}
		mysql_free_result($rs);
		
	$tree_img_path="../images";
	include("../theme/treemenu.inc.php");
	
      
	?>     
    
    