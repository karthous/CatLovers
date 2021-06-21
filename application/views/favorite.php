<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Favorite</title>
</head>
<body>
<div id="container">
    <div class="col-4 offset-4">
        <h2 class="text-center">Favorite folder</h2>
		<?php echo $error;?>
        <?php if (is_array($favorites)): ?>
		    <ul>
			    <?php foreach ($favorites as $favorite): ?>
				    <li>
						<div>
							<a href="<?php echo base_url(); ?>detail/<?php echo $favorite['id']; ?>" >
					    		<h3><?php echo $favorite['title']; ?></h3>
							</a>
							<?php echo form_open(base_url().'favorite/favorite'); ?>
								<div class="form-group">
									<input type="hidden" name="title" value="<?php echo $favorite['title'] ?>" />
								</div>
							
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Favorite</button>
								</div>
							<?php echo form_close(); ?>
							<p class="text-center">------------------</p>
						</div>
				    </li>
			    <?php endforeach;?>
            </ul>
	    <?php else: ?>
            <p>Your favorite folder is empty.<p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>