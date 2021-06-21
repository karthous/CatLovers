<div id="container">
    <div class="col-4 offset-4">
	</div>
</div>

<div id="container">
    <div class="col-4 offset-4">
		<h3><?php echo "Comments: ".$title; ?></h3>
		<?php if (is_array($info_list)): ?>
			<ul>
				<?php foreach ($info_list as $info): ?>
					<li>
						<h4><?php echo $info['username']; ?></h4>
						<p><?php echo $info['content']; ?></p>
					</li>
				<?php endforeach;?>
				<?php echo $error;?>
            </ul>
		<?php else: ?>
        	<p>No comments found.<p>
        <?php endif ;?>
		<?php echo form_open(base_url().'comment/write'); ?>
			<div class="form-group">
				<input type="hidden" name="video_id" value="<?php echo $id ?>">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Comment content" required="required" name="content">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Submit</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
</body>
</html>