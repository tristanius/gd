    <link href="<?php echo base_url("assets/estilo-gestion.css"); ?>" 
          rel="stylesheet" type="text/css">
    <div class="menu-lat">
		<ul>
		<?php
		foreach ($menu as $item) {
			?>
			<li>
				<a href="<?php echo $item[2] ?>"  ?>
					<span <?php echo $item[0]?> ></span> <?php echo $item[1] ?>
				</a>
			</li>
			<?php
		}
		?>
		</ul>
	</div>