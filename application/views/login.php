<?php include 'includes/header.php'?> 
<div id="status">
</div>
<div class="row">
		<div class="three columns"> 
		
		</div>
		<div class="six columns">
			<div class="panel login-box">
				<div class="panel-heading">
					<h3>Login</h3>
				</div>
				<div class="panel-body">
				<a href="javascript:checkLoginState()">           
					<img src="<?php echo base_url();?>assets/images/fb.png" class="img-responsive center-block">
				</a>
				<p class="big-text text-center">OR</p>
				<ul>
				  <li class="field">
				    <input class="input" type="email" placeholder="Email" />
				  </li>
				  <li class="field">
				    <input class="input" type="password" placeholder="Password" />
				  </li>
				  <li class="field">
					<label class="checkbox checked" for="check1">
				    <input name="checkbox[]" id="check1" value="1" type="checkbox" checked="checked">
				    <span></span> Remember me
					</label>
				 </li>
				</ul>
				<p>Forgot your password? <a href="#">Click here</a> <a class="pull-right medium btn btn-default" href="#">LOGIN</a></p>
				<p class="text-center">Not a member? <a href="register.php">Register</a></p>
				</div>
			</div>
		</div>
		<div class="three columns">
		
		</div>

</div>
<?php include 'includes/footer.php'?>