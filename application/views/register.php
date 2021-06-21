<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'register/check_register'); ?>
				<h2 class="text-center">Register</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password1">
					</div>
                    <div class="form-group">
						<input type="password" class="form-control" placeholder="Enter The Password Again" required="required" name="password2">
					</div>
                    <div class="form-group">
						<input type="email" class="form-control" placeholder="Email" required="required" name="email">
					</div>
                    <div class="form-group">
						<input type="tel" class="form-control" placeholder="Phone" required="required" name="tel">
					</div>
					<div class="form-group">
						<?php echo $image; ?>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter the captcha above" required="required" name="captcha">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Register</button>
					</div>
				    
			<?php echo form_close(); ?>
	</div>
</div>