<div class="container">
    <div class="col-4 offset-4">
        <h2 class="text-center">Edit Profile</h2>
            <?php echo form_open(base_url().'editProfile/update_profile'); ?>
				<h2 class="text-center">Register</h2>       
					<div class="form-group">
                        <p>Username:&nbsp;<?php echo $username; ?></p>
					</div>
                    <div class="form-group">
                        <p>Email:&nbsp;</p>
                        <input type="email" class="form-control" placeholder="New email address" required="required" name="email">
					</div>
                    <div class="form-group">
                        <p>Tel:&nbsp;</p>
                        <input type="tel" class="form-control" placeholder="New phone number" required="required" name="tel">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update</button>
					</div>
				    
			<?php echo form_close(); ?>

    </div>
</div>
