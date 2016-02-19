<img src="http://nachobirthday.appstudev.com/assets/images/n.png" alt="" width="250"><br>
Hi<?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

<h5>Forgot your password, huh? No big deal.
To create a new password, just follow this link:</h5>

<?php echo site_url('/reset_password/'.$user_id.'/'.$new_pass_key); ?>


<h5>You received this email, because it was requested by a <?php echo $site_name; ?> user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.</h5>


Thank you,
The <?php echo $site_name; ?> Team