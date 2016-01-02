<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Ronel!!</title>

</head>
<body>

<div id="container">
	<h1>members</h1>

	<div id="body">

<?php

echo "<pre>";

print_r( $this->session->all_userdata() );
echo "</pre>";

?>
	
<a href='<?php echo base_url()."main/logout" ?>'> Logout </a>


	</div>

	

</div>

</body>
</html>