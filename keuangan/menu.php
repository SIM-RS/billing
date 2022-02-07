<style type="text/css">
	#topMenu{ font-family:Verdana,Arial,Helvetica,sans-serif;  }
	#topMenu ul{ font-size: 12px; list-style: none; margin: 0; padding-left:0; background:#0087ED; }
	#topMenu li{ position:relative; float:left; border-right:1px solid rgba(236, 236, 236, .5); }
	#topMenu a { color: #000000; display: block; line-height: 2.9em; padding: 0 1.2125em; text-decoration: none; }
	#topMenu ul ul { display: none; float: left; margin: 0; position: absolute; top: 2.8em; left: 0; width: 220px; z-index: 500; -moz-box-shadow: 0 3px 3px rgba(0,0,0,0.2); -webkit-box-shadow: 0 3px 3px rgba(0,0,0,0.2); box-shadow: 0 3px 3px rgba(0,0,0,0.2); }
	#topMenu ul ul ul { left: 90%; top: 0px; }
	#topMenu ul ul a { background: #fff; border-bottom: 1px dotted #ddd; color: #0084ff; text-shadow: 0 0px 0px #00a1f3; font-size: 12px; font-weight: normal; height: auto; line-height: 1.4em; padding: 10px 10px; width: 200px; }
	#topMenu li:hover > a,
	#topMenu ul ul :hover > a,
	#topMenu a:focus { -webkit-transition: all 0.4s; -moz-transition: all 0.4s; -ms-transition: all 0.4s; -o-transition: all 0.4s; transition: all 0.4s; font-weight:normal; }
	#topMenu li:hover > a,
	#topMenu a:focus { font-weight:normal; background: #ececec; color: #000000; }
	#topMenu ul li:hover > ul { display: block; -webkit-transition: all 0.4s; -moz-transition: all 0.4s; -ms-transition: all 0.4s; -o-transition: all 0.4s; transition: all 0.4s; }
	.secondary-parent:after{ content: ''; margin-top:5px; float:right; width: 0px; height: 0px; border-style: solid; border-width: 5px 0px 5px 5px; border-color: transparent transparent transparent #0084FF; display: inline-block; vertical-align: middle; }
	#topMenu ul li{
		border-bottom:0.5px solid #efefef;
	}
</style>

<?php
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$date_skr=explode('-',$date_now);
	if ($fromHome=="") $fromHome="0";
	function getChild($parent){
		global $fromHome;
		$sql = "SELECT m.*
				FROM rspelindo_admin.ms_menu m
				INNER JOIN rspelindo_admin.ms_group_akses ga
				   ON ga.ms_menu_id = m.id
				INNER JOIN rspelindo_admin.ms_group g
				   ON g.id = ga.ms_group_id
				INNER JOIN rspelindo_admin.ms_group_petugas gp
				   ON gp.ms_group_id = g.id
				  AND gp.ms_pegawai_id = '".$_SESSION['id']."'
				WHERE m.modul_id = 3
				  AND parent_id = '{$parent}'";
		$query = mysql_query($sql);
		$jml = mysql_num_rows($query);
		if($query && $jml > 0){
			$result = array("status" => true);
			$result['menu'] = "<ul>";
			while($child = mysql_fetch_array($query))
			{
				$tmpurl = str_replace("fromHome", $fromHome, $child['url']);
				if(strpos($child['url'], 'fromHome') !== false)
					$url = "javascript:".$tmpurl;
				else {
					$url = ($child['url'] == '#' ? "#" : "http://".$_SERVER['HTTP_HOST']."/simrs-pelindo/keuangan/".$tmpurl);
				}
				$sub_child = getChild($child['id']);
				$second = ($sub_child['status'] == true) ? 'class="secondary-parent"' : "";
				$result['menu'] .= "<li><a {$second} href='{$url}'>".$child['nama']."</a>";
				$result['menu'] .= ($sub_child['status'] == true) ? $sub_child['menu'] : "";
				$result['menu'] .= "</li>";
			}
			$result['menu'] .= "</ul>";
		}
		return $result;
	}
	
	
	$sql = "SELECT m.*
			FROM rspelindo_admin.ms_menu m
			INNER JOIN rspelindo_admin.ms_modul mo
			   ON mo.id = m.modul_id
			INNER JOIN rspelindo_admin.ms_group_akses ga
			   ON ga.ms_menu_id = m.id
			INNER JOIN rspelindo_admin.ms_group g
			   ON g.id = ga.ms_group_id
			INNER JOIN rspelindo_admin.ms_group_petugas gp
			   ON gp.ms_group_id = g.id
			  AND gp.ms_pegawai_id = '".$_SESSION['id']."'
			WHERE m.modul_id = 3
			  AND parent_id = 0";
	$query = mysql_query($sql);
	if($query && mysql_num_rows($query) > 0){
?>
	<nav id="topMenu">
		<ul>
			<?php
				while($parent = mysql_fetch_array($query))
				{
					$url = ($parent['url'] == '#' ? "#" : "http://".$_SERVER['HTTP_HOST']."/simrs-pelindo/keuangan/".$parent['url']);
					echo "<li><a href='{$url}'>".$parent['nama']."</a>";
					$child = getChild($parent['id']);
					echo ($child['status'] == true) ? $child['menu'] : "";
					// print_r($child);
					echo "</li>";
				}
			?>
			<li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/portal.php">Portal</a></li>
		</ul>
		<ul>

		</ul>

	</nav>
	
<?
	}
?>
