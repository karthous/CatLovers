<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CatLovers</title>
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v10.0" nonce="Z5ZwIHtT"></script>
<div id="container">
	<div class="container">
    	<div class="col-4 offset-4">
			<h2 class="text-center">Latest videos</h2>
		</div>
	</div>
	<div class="container">
    	<div class="col-3 offset-1">
			<?php if (is_array($video_list)): ?>
				<?php foreach ($video_list as $video): ?>
					<div class="row">
						<div class="col-4 offset-7">
						<img src="<?php echo base_url().substr(strstr($video['imagepath'],"uploads"), 0, -4)."_w.jpg"; ?>" alt="cover image" width=512 height=384/>
						</div>
						<div class="col-4 offset-7">
						<a href="<?php echo base_url(); ?>detail/<?php echo $video['id']; ?>" > 
							<h3><?php echo $video['title']; ?></h3>
						</a>
						</div>
					</div>
				<?php endforeach;?>
			<?php else: ?>
                <p>No videos found.<p>
            <?php endif ;?>
		</div>
	</div>
</div>
<div class="col-1 mx-auto">
	<div class="fb-share-button" data-href="https://infs3202-22b8b2b7.uqcloud.net/myproject/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Finfs3202-22b8b2b7.uqcloud.net%2Fmyproject%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
</div>
</body>
</html>