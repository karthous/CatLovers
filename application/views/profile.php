<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="col-4 offset-4">
        <h2 class="text-center">Profile</h2>
        <div>
            <ul>
			    <li>
                    <p>Username:&nbsp;<?php echo $username; ?></p>
			    </li>
                <li>
                    <p>Email:&nbsp;<?php echo $email; ?></p>
			    </li>
                <li>
                    <p>Email Verified:&nbsp;<?php if ($status == 0) {echo "no";} else if ($status == 1) {echo "yes";}; ?></p>
                    <a href="<?php echo base_url(); ?>profile/verify"> Verify </a>
			    </li>
                <li>
                    <p>Tel:&nbsp;<?php echo $tel; ?></p>
			    </li>
                <?php echo $error; ?>
                <a href="<?php echo base_url(); ?>editProfile"> Edit </a>
            </ul>
		</div>
    </div>
</div>
