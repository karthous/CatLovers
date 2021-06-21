<div class="container">
    <div class="col-4 offset-4">
		<?php echo form_open(base_url().'login/check_login'); ?>
			<h2 class="text-center">Login</h2>       
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Username" required="required" name="username">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Password" required="required" name="password">
			</div>
			<div class="form-group">
				<?php echo $error; ?>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Log in</button>
			</div>
			<div class="clearfix">
				<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
			</div>    
		<?php echo form_close(); ?>
		<div class="text-center">
		<a href="<?php echo base_url(); ?>reset"> Forget Password? </a>
		</div>
		<div class="text-center">
			<a href="https://github.com/login/oauth/authorize?client_id=6a95c3a7dd8a121b0eac">Login with GitHub</a>
		</div>
	</div>
</div>