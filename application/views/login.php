<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Ronel!!</title>

</head>
<body>

<div id="container">
	<h1>Login</h1>

	<div id="body">
		
<?php

echo form_open('main/login_validation');

echo validation_errors();

echo "<p> Email: ";
echo form_input('email');
echo "</p> ";

echo "<p> Password: ";
echo form_password('password');
echo "</p> ";


echo "<p> ";
echo form_submit('login_submit', 'login!');

echo "</p> ";




echo form_close();


?>
	

	<a href= '<?php echo base_url(). "main/signup"; ?>' > sign up!</a>	
	</div>

	

</div>

</body>
</html>