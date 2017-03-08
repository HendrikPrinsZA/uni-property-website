<?php
	if (!isset($_SESSION)) 
	{
		session_start();
	}
	$option = 99;
	if(isset($_GET['linkOption']))
	{
		$option = $_GET['linkOption'];
	}
	
	if(!isset($_SESSION['linkOption']))
	{
		// user didnt choose link...All,friend,cat etc.
		$_SESSION['linkOption'] = 0;
	} else
	{
		// user chooses link...All,friend,cat etc.
		$_SESSION['linkOption'] = $option;
	}
?>

<!DOCTYPE html>
<head>
	
	<meta charset="utf-8">
	<title>&#x2605; HouseBook &#x2605;</title>
	<meta name="description" content="IMY 220 project 2011">
	<meta name="author" content="Hendrik Prinsloo">
	<link rel="stylesheet" href="css/style.css">

	<?php
		$action = 0;//Get the action. Ex: nav from pages
		if (!isset($_GET["action"]) || empty($_GET["action"])) { 
			$action = 0;
		} else 
		{ 
			$action = $_GET["action"];
			if ($action==99)
			{
				if (isset($_SESSION)) 
				{
					session_destroy();
				}
				header("location: index.php");
			}
		} 
		//Set up connection string
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die ('Could not connect: ' . mysql_error());
		}
		mysql_select_db("dbmain", $con);
	?>
	
	
</head>
<body>
	<!--start header -->
	<div id="header-container">
		<header class="wrapper">
			<?php 
				echo "<a id='notification' name='notification' style='text-align:right;'>";
				if ($action==50)
					echo "Notification: Property succesfully registered!";
				else if ($action==51)
					echo "Notification: Property not registered!";
				else if ($action==52)
					echo "Notification: Request sent!";
				else if ($action==53)
					echo "Notification: Request failed because it has already been made!";
				else if ($action==54)
					echo "Notification: Link not deleted!";
				else if ($action==55)
					echo "Notification: Link deleted!";
				else if ($action==56)
					echo "Notification: User not deleted!";
				else if ($action==57)
					echo "Notification: User deleted!";
				else if ($action==58)
					echo "Notification: Comment not deleted!";
				else if ($action==59)
					echo "Notification: Comment deleted!";
				else if ($action==60)
					echo "Notification: Rating not reset!";
				else if ($action==61)
					echo "Notification: Rating reset!";
				else if ($action==62)
					echo "Notification: Upgrade not done!";
				else if ($action==63)
					echo "Notification: User upgraded to admin!";
				else if ($action==64)
					echo "Notification: Account not deleted!";
				else if ($action==65)
					echo "Notification: Account deleted!";
				else if ($action==66)//                               ===INTERNAL ERROR===
					echo "Notification: Internal error!";
				else if ($action==67)
					echo "Notification: Avatar succesfully updated!";
				else if ($action==68)
					echo "Notification: Avatar not updated, please check file type and try again!";
				echo "</a>";
			?>
			<div id="logo"> <img src="images/newLogo.png" alt="Logo here" width="180" height="178"> </div>
			<!--start navigation -->
			<nav></nav>
		</header>
	</div>
	<!--end header -->
	<div id="nav">
		<div class="button"><a href="index.php">Home</a></div>
		<div class="button"><a href="index.php?action=2&linkOption=1">Houses</a></div>
		<div class="button"><a href="index.php?action=2&linkOption=1">Inbox</a></div>
		<div class="button"><a href="index.php?action=2&linkOption=1">Bank</a></div>
	</div>
	<!--end navigation -->
	
	<!--start main content -->
	<div id="main" class="wrapper">
		<div style="position:relative;" id="container" name="container">
			<?php 
				if ($action==0 || $action==98 || ($action>49 && $action<70))
					include('pages/home.php');
				else if ($action==10)
					include('pages/register.php');
				else if ($action==1)
					include('pages/friends.php');
				else if ($action==2)
					include('pages/links.php');
				else if ($action==3)
					include('pages/postlink.php');
				else if ($action==5)
					include('pages/search.php');
				else if ($action==6)
					include('pages/userAdmin.php');
				else if ($action==7)
					include('pages/request.php');
				else if ($action==8)
					include('pages/delete.php');
				else if ($action==9)//Change avatar
					include('pages/avatar.php');
				else if ($action==25)
					include('pages/link.php');
				else
					echo "error";
			?>
		</div>
		<aside>
			<hr>
			<?php
				//Check if user is logged in
				//session_start(); 		
				if(!isset($_SESSION['userName']))
				{
					// session not logged in so display form
					echo "<p><span class='big'>L</span>og in</p>
					<form novalidate='novalidate' id='theForm' name='theForm' method='post' action='pages/login.php'>
						<table>
							<tr>
								<td>
									<p>Username:</p>
									<p><input type='text' name='username' id='username' autofocus='autofocus' placeholder='Your username' value='a'/></p>
								</td>
							</tr>
							<tr>
								<td>
									<p>Password:</p>
									<p><input type='password' name='passW' id='passW' placeholder='Your password' value='a'/></p>
								</td>
							</tr>
						</table>";
						if ($action==98)
						{
							Print "<p><span class='error'>Username or password incorrect</span></p>";
						}
					echo "<input type='submit' value='Log in' id='submitButton' name='submitButton'/> <a id='register' name='register' class='btn' href='index.php?action=10'>Register</a>
					</form>
					<hr>";
				} else
				{
					// session logged 
					Print "<p><span class='big'>L</span>ogged in as " . $_SESSION['userName']."</p>";
					include('pages/user.php');
					Print "<a id='Log_out' name='Log_out' class='btn' href='index.php?action=99'>LOG OUT</a>";
					echo
					"<form id='theForm' name='theForm' method='post' action='index.php?action=9'>
						<input name='userName' type='hidden' id='userName' value='".$_SESSION['userName']."'/>
						<input name='delete' type='hidden' id='delete' value='true'>
						<input type='submit' value='Change my avatar' id='submitButton' name='submitButton'/>
					</form>";
					echo
					"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
						<input name='userName' type='hidden' id='userName' value='".$_SESSION['userName']."'/>
						<input name='delete' type='hidden' id='delete' value='true'>
						<input type='submit' value='Delete my account' id='submitButton' name='submitButton'/>
					</form>";
					Print "</br><hr>";
				}
			?>
		</aside> 
		
		
	</div>
	<div id="footer-container">
			<footer class="wrapper">
			<a href="http://freehtml5templates.com">Free HTML5 Templates</a>
			</footer>
	</div>
	
	
	
<!-- Free template distributed by http://freehtml5templates.com -->
</body>

</html>