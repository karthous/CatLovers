<div class="container">
    <div class="col-4 offset-4">
		<?php echo form_open(base_url().'reset/upt'); ?>
			<h2 class="text-center">Enter new password</h2> 
            <div class="form-group">
                <input type="hidden" class="form-control" name="username" value="<?php echo $username ?>"> 
            </div>
            <div class="form-group">
				<input type="password" class="form-control" placeholder="Password" required="required" name="password">
			</div>
            <div class="form-group">
                <input type="hidden" class="form-control" name="tel" value="<?php echo $tel ?>"> 
            </div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Reset</button>
			</div>
		<?php echo form_close(); ?>
        <?php echo $error; ?>
	</div>
</div>