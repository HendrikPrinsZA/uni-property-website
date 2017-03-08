<!DOCTYPE html>
<head>
	<?php
		$data = mysql_query("SELECT COUNT(USER_ID) AS user_sum FROM user") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$nmrUsers = $info['user_sum'];
		
		$data = mysql_query("SELECT COUNT(LINK_ID) AS user_sum FROM link") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$nmrLinks = $info['user_sum'];
	?>
</head>
	
<body>
	<div id="enter">
		<h1> Welcome to HouseBook</h1>
		<h3>&quot;  Where you can browse for your new dreamhouse  &quot;</h3>
		<div class="banner" id="slower">
		</div>
		
		<div style="padding-top: 300px;">
			<h1>Introduction</h1>
			<p><span class="big">H</span>ousebook is an online realestate agency where you can browse for houses currently on the
			market or display the house you want to sell.
			</p>
			
			<h1>Site statistics</h1>
			<p><span class="big">T</span>he community currently has <?php echo $nmrUsers?> users and a collection of <?php echo $nmrLinks?> houses
			</p>
		</div>
		
	</div>
<body>