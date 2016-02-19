<img src="http://nachobirthday.appstudev.com/assets/images/n.png" alt="" width="250"><br>
Welcome to <?php echo $site_name; ?>,

<h5>Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below. Make sure you keep them safe.
Follow this link to login on the site:</h5>

<?php echo site_url('/login/'); ?>

<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>

<?php /* Your password: <?php echo $password; ?>

*/ ?>

Have fun!
The <?php echo $site_name; ?> Team 