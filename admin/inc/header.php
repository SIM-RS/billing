<?php 
	//session_start();
	$baseurl = "http://".$_SERVER["SERVER_NAME"]."/simrs-pelindo/include";
	$rooturl = "http://".$_SERVER["SERVER_NAME"]."/simrs-pelindo/admin";
	//if(!isset($_SESSION["username"])) header("location:".$baseurl."/index.php?err=7");
	
//include("../koneksi/konek.php");
?>
<link rel="STYLESHEET" type="text/css" href="<?php echo $rooturl?>/theme/mod.css">
<link href="<?php echo $rooturl?>/css/style.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="<?php echo $rooturl?>/js/jquery-1.7.2x.js"></script>-->
<link type="text/css" href="<?php echo $rooturl?>/inc/menu/menu.css" rel="stylesheet" />
				
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<link rel="STYLESHEET" type="text/css" href="../theme/codebase/dhtmlxtabbar.css">
<script language="JavaScript" src="../theme/js/combo-utils.js"></script>
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script  src="../theme/codebase/dhtmlxcommon.js"></script>
<script  src="../theme/codebase/dhtmlxtabbar.js"></script>
<!-- <script type="text/javascript" src="../jqueryx.js"></script>-->
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!--====================popup======================================-->
<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
<script type="text/javascript" src="../theme/li/prototype.js"></script>
<script type="text/javascript" src="../theme/li/effects.js"></script>
<script type="text/javascript" src="../theme/li/popup.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>

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