<?php
include '../sesi.php';
include '../koneksi/konek.php';
// is valid users

/*if (!isset($_SESSION['userid'])) {
		Header("Location: login.html");
		exit;
   	}

	// check for user type
	if (isset($_SESSION['SIA_AUTH_TYPE'])) {
		if ($_SESSION['SIA_AUTH_TYPE']!="A" and $_SESSION['SIA_AUTH_TYPE']!="P"  and $_SESSION['SIA_AUTH_TYPE']!="F" and $_SESSION['SIA_AUTH_TYPE']!="M") {
			Header("Location: login.html");
			exit;
		}
	}
$canRead = true;
$canInsert = true;

include("dbconn.inc.php");

  $tableName = "in_barang";
  $tableTitle = ".: Data Kode Barang :.";

   $r_level1 = $_POST["level1"];
   $str1 = "SELECT substring(idbarang,1,1) || ' - ' || namabarang,idbarang from $schema.in_barang where level=1 order by idbarang";
   $rsl = $conn->Execute($str1);
   if (!$rsl->EOF)
		 $list1 = $rsl->GetMenu2("level1",$r_level1,true,false,0," class=ControlStyleSmall onChange=\"doFilter(1);\"");

   $r_level2 = $_POST["level2"];
   $str2 = "SELECT substring(idbarang,3,2) || ' - ' || namabarang,idbarang from $schema.in_barang where level=2 and substring(idbarang,1,1)=substring('$r_level1',1,1) order by idbarang";
   $rs2 = $conn->Execute($str2);
   if (!$rs2->EOF)
		 $list2 = $rs2->GetMenu2("level2",$r_level2,true,false,0," class=ControlStyleSmall onChange=\"doFilter(2);\"");

    $r_level3 = $_POST["level3"];
   $str3 = "SELECT substring(idbarang,6,2) || ' - ' || namabarang,idbarang from $schema.in_barang where level=3 and substring(idbarang,1,4)=substring('$r_level2',1,4) order by idbarang";
   $rs3 = $conn->Execute($str3);
   if (!$rs3->EOF)
		 $list3 = $rs3->GetMenu2("level3",$r_level3,true,false,0," class=ControlStyleSmall onChange=\"doFilter(3);\"");

      $r_level4 = $_POST["level4"];
   $str4 = "SELECT substring(idbarang,9,2) || ' - ' || namabarang,idbarang from $schema.in_barang where level=4 and substring(idbarang,1,7)=substring('$r_level3',1,7) order by idbarang";
   $rs4 = $conn->Execute($str4);
   if (!$rs4->EOF)
		 $list4 = $rs4->GetMenu2("level4",$r_level4,true,false,0," class=ControlStyleSmall onChange=\"doFilter(4);\"");

       $r_level5 = $_POST["level5"];
   $str5 = "SELECT substring(idbarang,12,3) || ' - ' || namabarang,idbarang from $schema.in_barang where level=5 and substring(idbarang,1,10)=substring('$r_level4',1,10) order by idbarang";
   $rs5 = $conn->Execute($str5);
   if (!$rs5->EOF)
		 $list5 = $rs5->GetMenu2("level5",$r_level5,true,false,0," class=ControlStyleSmall onChange=\"doFilter(5);\"");
   if ($r_level5!="") {
   		$strNama = "SELECT namabarang from $schema.in_barang where idbarang='$r_level5'";
		$c_namabarang = $conn->GetOne($strNama);
   }*/

?>

<html>
    <head>
        <title>PickBarang</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <META http-equiv="Page-Enter" CONTENT="RevealTrans(Duration=0.1,Transition=12)">
        <link href="../default.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            BODY, TD {font-family:Verdana; font-size:7pt}
        </style>
    </head>
    <body bgcolor=#CCCCCC style="border-width:0px">
        <form name="form1" id="form1" method="post" action="">
            <table border=0 cellspacing=0 cellpadding="4" class="GridStyle" width="420">
                <tr>
                    <td class="header" colspan="2" align="center">
                        Pilih Barang
                    </td>
                </tr>
                <tr>
                    <td height="28" class="label">Golongan</td>
                    <td height="28" class="content">
                        <select id="level1" name="level1" class="txt" onChange="form1.submit();">
                            <option value=""></option>
                            <?php
                            $r_level1 = $_POST["level1"];
                            $query = "SELECT concat(substring(idbarang,1,1),' - ',namabarang) as namabarang,idbarang from as_ms_barang where level=1 order by idbarang";
                            $rs = mysql_query($query);
                            while($row = mysql_fetch_array($rs)) {
                                ?>
                            <option value="<?php echo $row['idbarang'];?>" <?php if($row['idbarang'] == $r_level1){echo 'selected';}?>><?php echo $row['namabarang'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="28" class="label">Bidang</td>
                    <td height="28" class="content">
                        <select id="level2" name="level2" class="txt" onChange="form1.submit();">
                            <option value=""></option>
                        <?php
                        $r_level2 = $_POST["level2"];
                        $query = "SELECT concat(substring(idbarang,3,2),' - ',namabarang) as namabarang,idbarang from as_ms_barang where level=2 and substring(idbarang,1,1)=substring('$r_level1',1,1) order by idbarang";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['idbarang'];?>" <?php if($row['idbarang'] == $r_level2){echo 'selected';}?>><?php echo $row['namabarang'];?></option>
                                <?php
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="28" class="label">Kelompok</td>
                    <td height="28" class="content">
                        <select id="level3" name="level3" class="txt" onChange="form1.submit();">
                            <option value=""></option>
                        <?php
                        $r_level3 = $_POST["level3"];
                        $query = "SELECT concat(substring(idbarang,6,2),' - ',namabarang) as namabarang,idbarang from as_ms_barang where level=3 and substring(idbarang,1,4)=substring('$r_level2',1,4) order by idbarang";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['idbarang'];?>" <?php if($row['idbarang'] == $r_level3){echo 'selected';}?>><?php echo $row['namabarang'];?></option>
                                <?php
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="28" class="label">Sub Kelompok</td>
                    <td height="28" class="content">
                        <select id="level4" name="level4" class="txt" onChange="form1.submit();">
                            <option value=""></option>
                        <?php
                        $r_level4 = $_POST["level4"];
                        $query = "SELECT concat(substring(idbarang,9,2),' - ',namabarang) as namabarang,idbarang from as_ms_barang where level=4 and substring(idbarang,1,7)=substring('$r_level3',1,7) order by idbarang";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['idbarang'];?>" <?php if($row['idbarang'] == $r_level4){echo 'selected';}?>><?php echo $row['namabarang'];?></option>
                                <?php
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="28" class="label">Sub Sub Kel. </td>
                    <td height="28" class="content">
                        <select id="level5" name="level5" class="txt" onChange="form1.submit();">
                            <option value=""></option>
                        <?php
                        $r_level5 = $_POST["level5"];
                        $query = "SELECT concat(substring(idbarang,12,3),' - ',namabarang) as namabarang,idbarang from as_ms_barang where level=5 and substring(idbarang,1,10)=substring('$r_level4',1,10) order by idbarang";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)){
                            ?>
                            <option value="<?php echo $row['idbarang'];?>" <?php if($row['idbarang'] == $r_level5){echo 'selected';}?>><?php echo $row['namabarang'];?></option>
                                <?php
                        }
                        ?>
                        </select>
                        <?php 
                        if ($r_level5!="") {
                            $query = "SELECT namabarang from as_ms_barang where idbarang='$r_level5'";
                            
                        } ?>
                    </td>
                </tr>
                <tr class="label">
                    <td width="76" class="footer">
                        <input name="f_idbarang" type="text" class="ControlStyleSmall" value="<?php echo $r_level5 ?>" size="15" maxlength="14">
                    </td>
                    <td width="230" class="footer">
                        <input name="f_namabarang" type="text" class="ControlStyleSmall" size="50" maxlength="50" value="<?php echo $c_namabarang ?>">
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="2"><input name="button" type="button"  class="ControlStyle" onClick="goEdit()" value="OK">
                        &nbsp;<input name="button2" type="button"  class="ControlStyle" onClick="window.close();" value="Cancel"></td>
                </tr>
            </table>
        </form>

    </body>

    <script type="text/javascript" language="JavaScript">

        function goEdit() {
            self.opener.document.form1.idbarang.value = document.form1.f_idbarang.value;
            self.opener.document.form1.namabarang.value = document.form1.f_namabarang.value;
            window.close();
        }


        function doFilter(sender) {
            if (sender<5)
                if (cForm.level5) cForm.level5.value = "";
            if (sender<4)
                if (cForm.level4) cForm.level4.value = "";
            if (sender<3)
                if (cForm.level3) cForm.level3.value = "";
            if (sender<2)
                if (cForm.level2) cForm.level2.value = "";
            document.all.submit.click();
        }

    </script>

</html>
