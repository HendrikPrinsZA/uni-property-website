<?php
	$con = mysql_connect("localhost","root","");
	if (!$con)
	{
		die ('Could not connect: ' . mysql_error());
	}
	mysql_select_db("dbmain", $con);
	
	if(!isset($_SESSION['userName']))
	{
		// session not logged in
		$userID = 0;
		$userType = "none";
	} else
	{
		// session logged
		$userName = $_SESSION['userName'];
		
		$data = mysql_query("SELECT * FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$userID = $info['USER_ID'];
		$userType = $info['USER_TYPE'];
	}
	if(!isset($_SESSION['linkOption']))
	{
		// session not logged in
		$option = 99999999999;
	} else
	{
		// session logged 
		$option = $_SESSION['linkOption'];
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Account </title>
		<link rel="stylesheet" href="css/links.css">
    </head>
    <body>
		<div id="enter">
			<div id="main_menu">
				<ul id="menu">
					<li><a href="#"  name="links" id="links">View Properties</a>
						<ul>
							<li><a href="index.php?action=2&linkOption=1">All Properties</a></li>
							<li><a href="index.php?action=2&linkOption=2">My Properties</a></li>
							<li><a href="index.php?action=2&linkOption=2">For Sale</a></li>
							<li><a href="index.php?action=2&linkOption=2">To Rent</a></li>
							<li><a href="index.php?action=2&linkOption=3">Top Rated</a></li>
						</ul>
					</li>
					<li><a href="#">Categories</a>
						<ul>
							<?php
								$var1 = mysql_query("SELECT * FROM category") 
								or die(mysql_error());
								while($info = mysql_fetch_array( $var1 )) 
								{ 
									Print "<li><a";
									$catID = $info['CAT_ID'];
									$catID = $catID + 2;
									Print " title='".$info['CAT_Description']."' href='index.php?action=2&linkOption=".$catID."'>".$info['CAT_NAME']."</a>"; 
									Print "</li>";
								} 	
							?>
						</ul>
					</li>
					<?php 
						if ($userID>0) 
							echo "	<li><a href='index.php?action=3'  name='nlinks' id='links'>Register new</a>
									</li>"
					?>
				</ul>
			</div>
		
			<div id="links">
				<br/><br/>
				 
				<table width="100%">
					<?php
						if ($option==1)
						{
							print "<th><h1>All links</h1></th>";
							$var1 = mysql_query("SELECT * FROM link,user where link.USER_ID=user.USER_ID") 
							or die(mysql_error());
						} else if ($option==2)
						{
							print "<th><h1>My links</h1></th>";
							$var1 = mysql_query("SELECT * FROM link,user where (link.USER_ID=user.USER_ID) AND (link.USER_ID=$userID)") 
							or die(mysql_error());
						} else if ($option>2 && $option<90)
						{
							$option = $option-2;
							$var1 = mysql_query("SELECT * FROM category WHERE (CAT_ID=$option)") 
							or die(mysql_error());
							$info = mysql_fetch_array( $var1 );
							$catName = $info['CAT_NAME'];
							$catDesc = $info['CAT_Description'];
							
							print "<th><h1>Category: $catName</h1><p>$catDesc</p></th>";
							$var1 = mysql_query("SELECT * FROM link,user where (LINK_CAT_ID=$option) AND (link.USER_ID=user.USER_ID)") 
							or die(mysql_error());
						}
						$num_rows = mysql_num_rows($var1);
						if ($num_rows<1)
						{
							echo "<br/><br/><br/><br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
						} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
						
						$counter = 0;
						while($info = mysql_fetch_array( $var1 )) 
						{ 
							$counter++;
							if ($counter ==2)
							{
								Print "<tr width='100%'>";
							}
							if ($counter % 2!=0)
							{
								Print "<tr width='100%'>";
							}
							Print "<td width='50%'><h3><a href='index.php?action=25&linkOption=".$info['LINK_ID']."'>".$info['LINK_NAME']."</a></h3>";
							Print "<p>".$info['LINK_DESC']."</p>";
							Print "<p> By user:".$info['USER_USERNAME']."</p>";
							if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='linkID' type='hidden' id='linkID' value='".$info['LINK_ID']."'/>
										<input name='link' type='hidden' id='link' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>";
								}
							print "<hr/></td>";
							
							if ($counter % 2==0)
							{
								Print "</tr>";
							}
							if ($counter ==2)
							{
								Print "</tr>";
							}
						} 
						
						//echo $userID."<br/>";
						//echo "linkOption:   ". $option;
						//mysql_close($con);
					?>
				</table>
			</div>
		</div>
	</body>
</html>
