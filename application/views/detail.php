<div id="container">
    <div class="col-4 offset-4">
		<?php echo $error;?>
		<?php if (is_array($info_list)): ?>
			<ul>
				<?php foreach ($info_list as $info): ?>
					<li>
						<h3><?php echo $info['title']; ?></h3>
						<video width="800" height="640" controls>
							<source  src="<?php echo base_url().strstr($info['videopath'],"uploads"); ?>" type="video/mp4">
						</video>
						<?php echo form_open(base_url().'detail/favorite'); ?>
							<div class="form-group">
								<input type="hidden" name="title" value="<?php echo $title ?>" />
							</div>
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $id ?>" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Favorite</button>
							</div>
						<?php echo form_close(); ?>
					</li>
				<?php endforeach;?>
            </ul>
		<?php else: ?>
        	<p>No videos found.<p>
        <?php endif ;?>
		<a href="<?php echo base_url(); ?>comment/<?php echo $id; ?>" > 
			<h3>Comments</h3>
		</a>
	</div>
</div>

</body>
</html>