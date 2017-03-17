<html>
	<?php $this->load->view("principal/head")?>
	<body>

		<?php $this->load->view("principal/header")?>
		
		<hr class="hr-termo">

		<?php echo $vista ?>

        <hr>
        <?php $this->load->view('principal/user_reg', array()); ?>
		<hr class="hr-gray">
		<?php $this->load->view("principal/footer") ?>
	</body>
</html>