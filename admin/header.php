<?php 
	//session_start();
	$baseurl = "http://".$_SERVER["SERVER_NAME"]."/simrs-pelindo/include";
	$rooturl = "http://".$_SERVER["SERVER_NAME"]."/simrs-pelindo/";
	//if(!isset($_SESSION["username"])) header("location:".$baseurl."/index.php?err=7");
	
//include("../koneksi/konek.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="shortcut icon" href="<?php echo $rooturl?>/images/favicon.gif">
<link rel="STYLESHEET" type="text/css" href="<?php echo $baseurl?>/theme/default.css">
<link rel="STYLESHEET" type="text/css" href="<?php echo $baseurl?>/theme/mod.css">
<link rel="STYLESHEET" type="text/css" href="<?php echo $baseurl?>/calendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/codebase/dhtmlxtree.css">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords"    content="" />
<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/tab-view.css" />
<script  src="<?php echo $baseurl?>/calendar.js"></script>
<script  src="<?php echo $baseurl?>/theme/js/dsgrid.js"></script>
<script  src="<?php echo $baseurl?>/theme/js/mod.js"></script>
<script  src="<?php echo $baseurl?>/theme/js/ajax.js"></script>
<script src="<?php echo $baseurl?>/codebase/dhtmlxcommon.js"></script>
<script src="<?php echo $baseurl?>/codebase/dhtmlxtree.js"></script>  
<script>window.dhx_globalImgPath="<?php echo $baseurl?>/theme/calendar/imgs/";</script>

<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/ext/resources/css/ext-all.css" />

    <!-- overrides to base library -->
<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/ext/examples/ux/gridfilters/css/GridFilters.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/ext/examples/ux/gridfilters/css/RangeMenu.css" />

<!-- page specific -->


<link rel="stylesheet" type="text/css" href="<?php echo $baseurl?>/ext/resources/css/yourtheme.css" />

<!-- ** Javascript ** -->
<!-- ExtJS library: base/adapter -->
<script type="text/javascript" src="<?php echo $baseurl?>/ext/adapter/ext/ext-base.js"></script>

<!-- ExtJS library: all widgets -->
<script type="text/javascript" src="<?php echo $baseurl?>/ext/ext-all.js"></script>

<!-- overrides to base library -->

<!-- extensions -->
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/menu/RangeMenu.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/menu/ListMenu.js"></script>

<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/GridFilters.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/Filter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/StringFilter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/DateFilter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/ListFilter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/NumericFilter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/ux/gridfilters/filter/BooleanFilter.js"></script>

<!-- page specific -->

<script type="text/javascript" src="<?php echo $baseurl?>/ext/examples/grid-filtering/grid-filter-local.js"></script>