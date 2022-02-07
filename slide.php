<link rel="stylesheet" href="include/nivoslider/themes/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="include/nivoslider/nivo-slider.css" type="text/css" media="screen" />

<script type="text/javascript" src="include/nivoslider/jquery.nivo.slider.js"></script>
<script type="text/javascript">
$(function() {
	$('#slider').nivoSlider();
});
</script>
<style>
.slider-wrapper { 
	width: 500px; 
	margin: 0 auto;
}
</style>

<div class="slider-wrapper theme-light">
		<div id="slider" class="nivoSlider">
			<?php
			$dir = opendir('include/nivoslider/imgslide/');
			while($file = readdir($dir)) {
				if($file != "." && $file != ".." && stristr(strtolower($file),'.jpg')){
					?>
					<img src="include/nivoslider/imgcropper.php?img=<?=$file?>&d=05000280" title="#caption<?=str_replace('.jpg','',$file)?>" />
					<?php
				}
			}
			closedir($dir);
			?>
		</div>
		<?php
		$dir = opendir('include/nivoslider/imgslide/');
		while($file = readdir($dir)) {
			if($file != "." && $file != ".." && stristr(strtolower($file),'.txt')){
				?>
				<div id="caption<?=str_replace('.txt','',$file)?>" class="nivo-html-caption">
					<strong><?=str_replace('.txt','',str_replace('_',' ',$file))?></strong><br/>
					<span style="font-size:12px;">
					<?php
					$fh = fopen('include/nivoslider/imgslide/'.$file, 'r');
					$dt = fread($fh, filesize('include/nivoslider/imgslide/'.$file));
					fclose($fh);
					echo $dt;
					?>
					</span>
				</div>
				<?php
			}
		}
		closedir($dir);
		?>
	</div>

</div>