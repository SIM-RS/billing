<?php
	include('sesi.php');
	include("koneksi/konek.php");
	$date_now = gmdate('Y-m-d');
	
	if($_SESSION['userId']=='732'){
		$date_now = gmdate('Y-m-d');
		$sql = "SELECT user_act
				FROM b_login_user_log
				WHERE DATE(tgl_act) = '{$date_now}'
					AND user_act <> 732
				GROUP BY user_act";
		$query = mysql_query($sql);
		$login = $logout = array();
		$idIn = $idOut = array();
		while($data = mysql_fetch_array($query)){
			$sql2 = "SELECT `type`, user_act, id_log
					FROM b_login_user_log
					WHERE user_act = '".$data['user_act']."'
					ORDER BY tgl_act DESC
					LIMIT 1";
			$query2 = mysql_query($sql2);
			$subdata = mysql_fetch_array($query2);
			if($subdata['type'] == 1){
				$login[] = $subdata['user_act'];
				$idIn[] = $subdata['id_log'];
			} else {
				$logout[] = $subdata['user_act'];
				$idOut[] = $subdata['id_log'];
			}
		}
		//print_r($idOut);
		/* echo "User Online hari ini : <a class='links' target='_blank' href='list_user.php?log=".implode(',',$login)."'><b>".count($login)." Pegawai</b></a><br />";
		echo "User Log Out hari ini : <a class='links' target='_blank' href='list_user.php?out=".implode(',',$logout)."'><b>".count($logout)." Pegawai</b></a>"; */
		//echo $_SERVER['REMOTE_ADDR'];
		//gethostbyaddr($_SERVER['REMOTE_ADDR']);
		function get_client_ip(){
			  /* $ipaddress = '';
			  if (getenv('HTTP_CLIENT_IP'))
				  $ipaddress = getenv('HTTP_CLIENT_IP');
			  else if(getenv('HTTP_X_FORWARDED_FOR'))
				  $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			  else if(getenv('HTTP_X_FORWARDED'))
				  $ipaddress = getenv('HTTP_X_FORWARDED');
			  else if(getenv('HTTP_FORWARDED_FOR'))
				  $ipaddress = getenv('HTTP_FORWARDED_FOR');
			  else if(getenv('HTTP_FORWARDED'))
				  $ipaddress = getenv('HTTP_FORWARDED');
			  else if(getenv('REMOTE_ADDR'))
				  $ipaddress = getenv('REMOTE_ADDR');
			  else
				  $ipaddress = 'UNKNOWN';

			  return $ipaddress;  */
			  
				$ipaddress = '';
				if ($_SERVER['HTTP_CLIENT_IP'])
					$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
				else if($_SERVER['HTTP_X_FORWARDED_FOR'])
					$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
				else if($_SERVER['HTTP_X_FORWARDED'])
					$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
				else if($_SERVER['HTTP_FORWARDED_FOR'])
					$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
				else if($_SERVER['HTTP_FORWARDED'])
					$ipaddress = $_SERVER['HTTP_FORWARDED'];
				else if($_SERVER['REMOTE_ADDR'])
					$ipaddress = $_SERVER['REMOTE_ADDR'];
				else
					$ipaddress = 'UNKNOWN';
			 
				return $ipaddress;
		}
		//echo get_client_ip();
		//echo getenv('COMPUTERNAME');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>List Pegawai</title>
	<script type="text/javascript" src="jquery-min.js" />
	<script type="text/javascript">
		function getData(){
		
		}
	</script>
	<style type="text/css">
		table{
			border-collapse:collapse;
			width:100%;
		}
		caption{
			font-size:18px;
			font-weight:bold;
			padding:5px 0px 10px 0px;
			color:white;
		}
		td, th{
			border:1px solid #AADFEB;
			padding:5px;
			color:white;
		}
		body, html {
			height: 100%;
			margin: 0;
			-webkit-font-smoothing: antialiased;
			font-weight: 100;
			background: #aadfeb;
			text-align: center;
			font-family: helvetica;
		}

		.tabs input[type=radio] {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}
		.tabs {
			width: 980px;
			float: none;
			list-style: none;
			position: relative;
			padding: 0;
			margin: 25px auto;
		}
		.tabs li{
			float: left;
		}
		.tabs label {
			display: block;
			padding: 10px 20px;
			border-radius: 2px 2px 0 0;
			color: #08C;
			font-size: 24px;
			font-weight: normal;
			font-family: 'Lily Script One', helveti;
			background: rgba(255,255,255,0.2);
			cursor: pointer;
			position: relative;
			top: 8px;
			-webkit-transition: all 0.2s ease-in-out;
			-moz-transition: all 0.2s ease-in-out;
			-o-transition: all 0.2s ease-in-out;
			transition: all 0.2s ease-in-out;
		}
		.tabs label:hover {
			background: rgba(255,255,255,0.5);
			top: 3px;
		}

		[id^=tab]:checked + label {
			background: #08C;
			color: white;
			top: 3px;
		}

		[id^=tab]:checked ~ [id^=tab-content] {
			display: block;
		}
		.tab-content{
			z-index: 2;
			display: none;
			text-align: left;
			width: 100%;
			font-size: 14px;
			line-height: 140%;
			padding-top: 10px;
			background: #08C;
			padding: 15px;
			color: white;
			position: absolute;
			top: 53px;
			left: 0;
			box-sizing: border-box;
			-webkit-animation-duration: 0.5s;
			-o-animation-duration: 0.5s;
			-moz-animation-duration: 0.5s;
			animation-duration: 0.5s;
		}
		.clear{
			clear:both;
		}
		#parent{
			width:1000px;
			margin:10px auto;
		}
		#parent h1{
			text-align:left;
			margin:0px;
			padding:0px 10px;
			font-size:26px;
		}
		#parent h2{
			text-align:left;
			margin:0px;
			padding:0px 10px;
			font-size:22px;
		}
	</style>
</head>
<body>
<div id="parent">
	<h1><?php echo $namaRS; ?></h1>
	<h2><?php echo $alamatRS; ?></h2>
	<h2><?php //echo ; ?></h2>
	<ul class="tabs">
        <li>
          <input type="radio" checked name="tabs" id="tab1" >
          <label for="tab1">User Online</label>
          <div id="tab-content1" class="tab-content animated fadeIn">
			<?php
				$jmlLog = count($login);
				if($jmlLog>0){
					$sql = "SELECT 
							  l.id_log, l.user_act, l.type, DATE_FORMAT(MAX(l.tgl_act),'%d-%m-%Y %H:%i') tgl, p.nama, l.ip, l.pcname
							FROM
							  b_login_user_log l
							INNER JOIN b_ms_pegawai p
							   ON p.id = l.user_act
							WHERE DATE(l.tgl_act) = '{$date_now}' /* CURDATE() */ 
							  AND l.id_log in (".implode(',',$idIn).")
							  AND l.type = '1'
							GROUP BY l.user_act";
					$query = mysql_query($sql);
			?>
			<table>
				<caption>
					Daftar Pegawai Online
				</caption>
				<col width="15px"/>
				<col />
				<col width="180px"/>
				<thead>
					<tr>
						<th align="center">NO</th>
						<th align="center">Nama Pegawai</th>
						<th align="center">Log In Terakhir</th>
						<!--th align="center">IP</th>
						<th align="center">PCName</th-->
					</tr>
				</thead>
				<tbody>
				<?php				
					$i = 1;
					while($data = mysql_fetch_object($query)){
				?>
					<tr>
						<td align="center"><?php echo $i++; ?></td>
						<td><?php echo $data->nama; ?></td>
						<td align="center"><?php echo $data->tgl; ?></td>
						<!--td align="center"><?php echo $data->ip; ?></td>
						<td><?php echo $data->pcname; ?></td-->
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>
			<?php } else {
				echo "<h2 style='text-align:center;'>Tidak Terdapat User Online untuk hari ini, kecuali Admin</h2>";
			} ?>
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab2">
          <label for="tab2">User Log Out</label>
          <div id="tab-content2" class="tab-content animated fadeIn">
			<?php
				$jmlLogout = count($logout);
				if($jmlLogout>0){
					$sqlOut = "SELECT 
							  l.id_log, l.user_act, l.type, DATE_FORMAT(MAX(l.tgl_act),'%d-%m-%Y %H:%i') tgl, p.nama, l.ip, l.pcname
							FROM
							  b_login_user_log l
							INNER JOIN b_ms_pegawai p
							   ON p.id = l.user_act
							WHERE DATE(l.tgl_act) = '{$date_now}' /* CURDATE() */ 
							  AND l.id_log in (".implode(',',$idOut).")
							  AND l.type = '0'
							GROUP BY l.user_act";
					$queryOut = mysql_query($sqlOut);
			?>
			<table>
				<caption>
					Daftar Pegawai Log Out
				</caption>
				<col width="15px"/>
				<col />
				<col width="180px"/>
				<thead>
					<tr>
						<th align="center">NO</th>
						<th align="center">Nama Pegawai</th>
						<th align="center">LogOut Terakhir</th>
						<!--th align="center">IP</th>
						<th align="center">PCName</th-->
					</tr>
				</thead>
				<tbody>
				<?php				
					$i = 1;
					while($dataOut = mysql_fetch_object($queryOut)){
				?>
					<tr>
						<td align="center" align="center"><?php echo $i++; ?></td>
						<td><?php echo $dataOut->nama; ?></td>
						<td align="center"><?php echo $dataOut->tgl; ?></td>
						<!--td align="center"><?php echo $dataOut->ip; ?></td>
						<td><?php echo $dataOut->pcname; ?></td-->
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>
			<?php } else {
				echo "<h2 style='text-align:center;'>Tidak Terdapat User Online untuk hari ini, kecuali Admin</h2>";
			} ?>
          </div>
        </li>
        <!--li>
          <input type="radio" name="tabs" id="tab3">
          <label for="tab3">Detail</label>
          <div id="tab-content3" class="tab-content animated fadeIn">
			<?php
				
			?>
          </div>
        </li-->
	</ul>
</div>
<?php 
	}
?>
<div class="clear"></div>
<div id="user">
	
</div>
</body>
</html>