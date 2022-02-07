<?php
session_start();
include '../inc/koneksi.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../inc/menu/menu.js"></script> 
</head>

<body>
	
<div id="wrapper">
        <div id="header">
			<?php include("../inc/header.php");?>
        </div>
            
		<div id="topmenu">
                 <?php include("../inc/menu/menu.php"); ?>
        </div>
            
<div id="content">
			
<center>
<iframe height="72" width="130" name="sort" id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<style>
input[type='text'],select,textarea{
padding:3px 4px;
border:1px solid #999999;
}
</style>
		
<table width="1000" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
	<td align="center">
		<font size="3"><b>.: Daftar Master Tree Unit :.</b></font>
	</td>
                    
 </tr>
<tr>
<td align="right" bgcolor="#FFFFFF"><span style="align:right"><button value="Tambah data" onClick="location='ms_unit_detail.php?origin=pindah&act=add'" style="cursor:pointer"> Tambah Data <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" />&nbsp;
                   </button></span>&nbsp;&nbsp;</td>                
                </tr>
                <form action="" method="get" id="form1" name="form1">
                    <tr bgcolor="whitesmoke">
                        <td nowrap colspan="">
                            <input type="hidden" name="act" id="act" value="edit" />
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="origin" id="origin" value="treeUnit" />
                            <?php
                            // Detail Data Parameters
                            if (isset($_REQUEST["p"])) {
                                $_SESSION['itemtree.filter'] = $_REQUEST["p"];
                                $p = $_SESSION['itemtree.filter'];
                            }
                            else {
                                if (isset($_SESSION['itemtree.filter']))
                                    $p = $_SESSION['itemtree.filter'];
                            }
							
                            /*********************************************/
                            /*  Read text file with tree structure       */
                            /*********************************************/

                            /*********************************************/
                            /* read file to $tree array                  */
                            /* tree[x][0] -> tree level                  */
                            /* tree[x][1] -> item text                   */
                            /* tree[x][2] -> item link                   */
                            /* tree[x][3] -> link target                 */
                            /* tree[x][4] -> last item in subtree        */
                            /*********************************************/
                            //$tree=array();
                            $canRead = true;
                            $maxlevel=0;
                            $cnt=0;
                           $strSQL = "select * from ms_unit order by kodeunit";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $mpkode=trim($rows['kodeunit']);
                                $level = explode('.',$rows['kodeunit']);
                                $lvl = count($level);
                                $tree[$cnt][0]= $lvl;
                               // $islast = $rows["islast"];
                 
                                $tree[$cnt][1]= $rows["kodeunit"]." - ".$rows["namaunit"];
								$allval = $rows['idunit']."*|*".$rows['kodeunit']."*|*".$rows['namaunit'];
                                if ($lvl > 0)
                                    $tree[$cnt][2]= "ms_unit_detail.php?origin=pindah&act=edit&id=".$rows['idunit'];
                               
                                else
                                    $tree[$cnt][2] = null;

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
												$cnt++;                                			
                            }
                            mysql_free_result($rs);
							//$PATH_INFO=
                            $tree_img_path="../images";
                            include("../theme/treemenu.inc.php");

                            ?>
                        </td>
                    </tr>
                </form>
	<tr bgcolor="whitesmoke">
		<td align="center"><button class="Enabledbutton" id="backbutton" onClick="location='ms_unit.php'" title="Back" style="cursor:pointer">
		   <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />  Back to List</button></td>
	</tr>
		
<tr><td>&nbsp;</td></tr>
</table>
</td>
</tr>
<tr>
	<td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
</tr>
</table>
</div>
<div id="footer">
	<?php
		$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
			pgw_jabatan.id, pgw_jabatan.jbt_id,
			ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
			FROM rspelindo_hcr.pegawai
			INNER JOIN rspelindo_hcr.pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
			LEFT JOIN rspelindo_hcr.ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
			WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
		$i=0;
		$pegawai='';
		$jabatan='';
		while($row = mysql_fetch_array($query)){
			if($i==0)
				$pegawai = $row['nama'];
			if($i>0)
				$jabatan .= ", ";
			$jabatan .= $row['nama_jabatan'];	
			$i++; 
		}
	?>
	<div style="float:left;">Nama: <span style="color:yellow"><?php echo $pegawai;?></span></div>
	<div style="float:right;"> <span style="color:yellow;"><?=$jabatan?></span> : Jabatan</div>
</div>

</div>
<div id="tempor" style="display:none"></div>
</body>
</html>
<script language="javascript">

</script>

