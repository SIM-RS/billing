<?
$header='
<style media="all" type="text/css">@import "#css_path#";</style>
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="#include_path#" media="screen"/>
	<![endif]-->
';
$tag1_top = 
'<div class="wrapper1">
	<div class="wrapper"  style="width:#wrapper_width#px;">
		<div class="nav-wrapper">
			<div class="nav-left"></div>
			<div class="nav">
				<ul id="navigation" style="width:#ul_width#px";>
';
$tag1_bottom=	'
			   	</ul>
			</div>
			<div class="nav-right"></div>
		<br><br>
	 </div>
	</div>
</div>
';
$tag2_top = 	' 
					<li class="#">
						<a href="#link#" target="#target#">
							<span class="menu-left"></span>
							<span class="menu-mid">#title#</span>
							<span class="menu-right"></span>
						</a>
';
$tag2_bottom =	'					</li>
';
$tag3_top=		'	            	   	<div class="sub">
			   				<ul>
';
$tag3_bottom=	'			   				</ul>
';
$tag4=			'         			   					<li>
									<a href="#link#" target="#target#">#title#</a>
								</li>
';

$image_array = array('content_bg.png','content_bottom.png','main_bottom_bg.png','main_top_bg.png','menu_left.gif','menu_left.png','menu_mid.gif',
					'menu_mid.png','menu_right.gif','menu_right.png','nav_bg.png','nav_left.png','nav_right.png','nav-bg.png','nav-left-bg.gif',
					'nav-right-bg.gif','split.png','submenu_bg.png','submenu_bottom.png','submenu_top.png');

$include_array = array('ie6.css');
/**
		<div class="content">
			<p>&nbsp;</p>
			<p>&nbsp;</p>

		</div>
		<div class="content-bottom"></div>
**/
?>