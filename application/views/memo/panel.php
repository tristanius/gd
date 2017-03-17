<style type="text/css">
	.panel{
		padding: 3ex;
	}
</style>	
<div class="panel">
	<?php 
		if (isset($mymenu)) {
			echo $mymenu;
			echo "<hr>";
		}
	?>
	<?= $vista ?>
</div>