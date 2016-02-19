Welcome to <?php echo $site_name; ?>,

<h5>Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below, make sure you keep them safe.
To verify your email address, please follow this link:</h5>

<?php echo site_url('/activate/'.$user_id.'/'.$new_email_key); ?>


<h5>Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.</h5>
<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>
<?php if (isset($password)) { /* ?>

Your password: <?php echo $password; ?>
<?php */ } ?>



Have fun!
The <?php echo $site_name; ?> Team 