<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Custom Grid Filters</title>

    <!-- ** CSS ** -->
    <!-- base library -->
    <link rel="stylesheet" type="text/css" href="../../resources/css/ext-all.css" />

    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="../ux/gridfilters/css/GridFilters.css" />
    <link rel="stylesheet" type="text/css" href="../ux/gridfilters/css/RangeMenu.css" />

    <!-- page specific -->
    <link rel="stylesheet" type="text/css" href="../shared/examples.css" />

	<link rel="stylesheet" type="text/css" href="../../resources/css/yourtheme.css" />

    <!-- ** Javascript ** -->
    <!-- ExtJS library: base/adapter -->
    <script type="text/javascript" src="../../adapter/ext/ext-base.js"></script>

    <!-- ExtJS library: all widgets -->
    <script type="text/javascript" src="../../ext-all.js"></script>

    <!-- overrides to base library -->

    <!-- extensions -->
	<script type="text/javascript" src="../ux/gridfilters/menu/RangeMenu.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/menu/ListMenu.js"></script>
	
	<script type="text/javascript" src="../ux/gridfilters/GridFilters.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/Filter.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/StringFilter.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/DateFilter.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/ListFilter.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/NumericFilter.js"></script>
	<script type="text/javascript" src="../ux/gridfilters/filter/BooleanFilter.js"></script>

    <!-- page specific -->
    <script type="text/javascript" src="../shared/examples.js"></script>
	<script type="text/javascript" src="grid-filter-local.js"></script>

</head>
<body>
    <h1>Custom Grid Filters Example (local filtering)</h1>
    <p>This example demonstrates a custom Grid Filter Extension.</p>
    <p>Note that the js is not minified so it is readable. See <a href="grid-filter-local.js">grid-filter-local.js</a>.</p>

	<div id="grid-example" style="margin: 10px;"></div>
    <div id="gridbox" ></div><input type="button" onclick="a.reload()" value="tes" />
    <script  type="text/javascript">
    
    Ext.onReady(function (){
   
        a = new extGrid("gridbox");        
        a.setTitle(".: Master User :.");
        a.setHeader("NIP,Nama User,Username,Password,ID_BAGIAN,ID_KATEGORI");
        a.setColId("NIP,NAMA,USER_NAMA,PASSWORD,ID_BAGIAN,ID_KATEGORI");
        a.setColType("string,string,string,string,string,string")
        a.baseURL("grid-filter.php");                                    
        a.init();
        
            
    });
    </script>
</body>
</html>