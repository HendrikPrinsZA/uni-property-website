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
	} else
	{
		// session logged
		$userName = $_SESSION['userName'];
		
		$data = mysql_query("SELECT USER_ID FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$userID = $info['USER_ID'];
	}
	
	
	if(!isset($_SESSION['linkOption']))
	{
		// session not logged in
		$option = 99;
	} else
	{
		// session logged 
		$option = $_SESSION['linkOption'];
	}
	
	if(isset($_POST['form']) && $_POST['form']=='true')
	{	
		if (isset($_POST['userID']) && $_POST['userID']!=0)
		{
			$name = $_POST["name"];
			$category = $_POST["categories"];
			$desc = $_POST["comment"];		
			$userID = $_POST['userID'];
			
			if ((strlen($name)<1) || (strlen($desc)<1))
			{
				echo "<h1>Input was incorrect</h1><br/>";
				echo "<h2>Click <a href='queries.php?number=2' target='container'>here</a> to try again</h2>";
			} else
			{
				// insertion to link table
				$sql = "INSERT INTO link(LINK_DESC,LINK_CAT_ID,USER_ID,LINK_NAME) VALUES('$desc',$category,$userID,'$name')";
				if (!mysql_query($sql,$con))
				{
					die;
					header("location: index.php?action=51");
				} else
				{
					$link_id = mysql_insert_id( $con );
					$sql = "INSERT INTO rating(RATING_ID, RATING_SCORE, RATING_TOTAL) VALUES ($link_id, 0, 0)";
					if (!mysql_query($sql,$con))
					{
						die;
						header("location: index.php?action=51");
					}	
					
					if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 200000))
					{
						if (file_exists("upload/houses/$link_id.jpg"))
						{
							//The file exists so it should be removed
							unlink("upload/houses/$link_id.jpg");
						}
						if (file_exists("upload/houses/$link_id.gif"))
						{
							//The file exists so it should be removed
							unlink("upload/houses/$link_id.gif");
						}
						if ($_FILES["file"]["type"] == "image/gif")
							$pic = $link_id.".gif";
						else if (($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))
							$pic = $link_id.".jpg";
						move_uploaded_file($_FILES["file"]["tmp_name"],"upload/houses/" . $pic);
						
						$sql = "UPDATE link SET link.LINK_PIC_LOCATION='$pic' WHERE (link.LINK_ID='$link_id')";
						if (!mysql_query($sql,$con))
						{
							header("location: ../index.php?action=66");
							die;
						}else
						{
							header("location: ../index.php?action=50");
						}	
					}
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Post House </title>
		<link rel="stylesheet" href="css/postlink.css">
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
							<li><a href="#" target="container">My links</a></li>
							<?php
								$var1 = mysql_query("SELECT * FROM category") 
								or die(mysql_error());
								while($info = mysql_fetch_array( $var1 )) 
								{ 
									Print "<li><a";
									Print " id=".$info['CAT_ID']." title='".$info['CAT_Description']."' href='#'>".$info['CAT_NAME']."</a>"; 
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
		
			<div>
				<br/><br/>
				<?php
					echo "	<div id='stylized' class='myform'></br></br>
							<form id='theform' name='theform' method='post' action='pages/postlink.php' enctype='multipart/form-data'><br/>
								<h1>Register a new Property</h1><br/>
								<p>Please ensure that your information is accurate</p><br/></br>

								<label>Property Name<br/>
								<span class='small'>Add Property Name</span><br/>
								</label><br/>
								<input type='text' name='name' id='name' required/><br/></br>

								<label>Property Type:<br/>
								<span class='small'>Add category</span><br/>
								</label><br/><br/>
								<select name='categories'>
								";
								$var1 = mysql_query("SELECT * FROM category") 
								or die(mysql_error());
								while($info = mysql_fetch_array( $var1 )) 
								{ 
									Print "<option";	
									Print " value=".$info['CAT_ID']." title='".$info['CAT_Description']."'>".$info['CAT_NAME']."</td>"; 
									Print "</option>";
								} 		
			echo				"</select><br/></br>
			
			
								<label>Rent or Sell?:<br/>
								<span class='small'>Select option</span><br/>
								</label><br/><br/>
								<select name='rentOrSale'>
									<option value=0 title='Sale'>For Sale</option>
									<option value=1 title='Rent'>To Rent</option>
								</select><br/></br>
								
								<label>Price?  R<br/>
								<span class='small'>Speculated value</span><br/>
								</label><br/>
								<input type='text' name='price' id='price' required/><br/></br>
								
								<label>Description<br/>
								<span class='small'>Add a valid address</span><br/>
								</label><br/>
									<textarea name='comment' id='comment' required></textarea><br />
								<br/></br>

								<label for='file'>Attach photo:</label>
								<input type='file' name='file' id='file' />
								<input type='hidden' value=$userID id='userID' name='userID'/>
								<input name='form' type='hidden' id='form' value='true'>
								<input type='submit' value='Register Property'/><br/>
								<div class='spacer'></div><br/></br>
							</form><br/>
						</div></br>";
				?>
			</div>
		</div>
	</body>
</html>