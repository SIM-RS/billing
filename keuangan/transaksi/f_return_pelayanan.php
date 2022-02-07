<?php
session_start();
$userId = $_SESSION['id'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include ("../koneksi/konek.php");
?>
<html>
    <head>
        <title>Form Return Pelayanan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
       
        <style>
            .tepi{
                border:#000000 1px solid;             
            }
            .isi{
                border:#000000 1px solid;
                cursor:pointer;                
            }
            .header{
                border:#000000 1px solid;
                background-color:#a3fcb0;
                font-size:10px;
            }
            .tindBok{
                height:25px;
                width:200px;
                font-size:10px;
            }
            .tglBox{
                cursor: pointer;
                text-align:center;
                font-size:10px;
            }    
			.filed{
				border:2px #10476B outset;-moz-border-radius:10px;
				padding:20px;
				background-repeat:repeat-x;
			}
        </style>
        <!--<script>
		$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
			});
		});
		</script>-->
    </head>
    <body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>

    <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="form_header" align="center">
<?php
include("../header.php");
?>
<iframe id="frame1" frameborder="0" width="1000px" height="675px" style="overflow:hidden" src="return_pelayanan.php"></iframe>
</div>
<?php include("../laporan/report_form.php");?>
</body>
</html>
<script>
var arrRange=depRange=[];
function setIframe(px){
	//alert(px);
	document.getElementById('frame1').style.height=px;
}
var th_skr = "<?php echo $date_skr[2];?>";
var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
var fromHome='<?php echo $fromHome ?>';
</script>
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
<?php
mysql_close($konek);
?>