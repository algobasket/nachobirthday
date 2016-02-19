<h2><img src="http://nachobirthday.appstudev.com/assets/images/n.png" alt="" width="250"></h2><br>
Hi<?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

<h5>You have changed your email address for <?php echo $site_name; ?>.
Follow this link to confirm your new email address:</h5>

<?php echo site_url('/reset_email/'.$user_id.'/'.$new_email_key); ?>

<h5>Your new email: <?php echo $new_email; ?>.You received this email, because it was requested by a <?php echo $site_name; ?> user. If you have received this by mistake, please DO NOT click the confirmation link, and simply delete this email. After a short time, the request will be removed from the system.</h5> 


Thank you,
The <?php echo $site_name; ?> Team 