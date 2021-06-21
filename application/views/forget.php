<div class="container">
    <div class="col-4 offset-4">
		<?php echo form_open(base_url().'reset/send'); ?>
			<h2 class="text-center">Enter your email address.</h2>       
            <div class="form-group">
				<input type="email" class="form-control" placeholder="Email" required="required" name="email">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Confirm</button>
			</div>
		<?php echo form_close(); ?>
        <?php echo $error; ?>
	</div>
</div>