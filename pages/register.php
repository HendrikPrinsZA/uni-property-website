<!DOCTYPE html>
<html> 
<head> 
<title>Personal INFO</title> 
	<?php
		$passError = false;
		$userError = false;
		$emailError = false;
		$reg = false;
	?>
	<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="js/registration.js"></script>
	<link rel="stylesheet" href="./css/reg.css" type="text/css" media="screen" charset="utf-8"/>
</head> 
<body> 
<?PHP
if(isset($_POST['form']) && $_POST['form']=='true')
{	
	$userName = $_REQUEST["username"];
	$theName = $_REQUEST["theName"];
	$theSurname = $_REQUEST["surname"];
	$email = $_REQUEST["emailAddress"];
	$pass = $_REQUEST["passW"];
	$pass2 = $_REQUEST["passW2"];
	$birthDate = $_REQUEST["birthDate"];
	$gender = $_REQUEST["gender"];
	
	$con = mysql_connect("localhost","root","");
	if (!$con)
	{
		die ('Could not connect: ' . mysql_error());
	}
	mysql_select_db("dbmain", $con);
	
	if ($pass!=$pass2)
	{
		$passError = true;
	}
	
	$sql = "SELECT * FROM user WHERE (USER_USERNAME='$userName')";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)>0)
	{
		$userError = true;	
	}
	
	$sql = "SELECT * FROM user WHERE (USER_Email='$email')";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)>0)
	{
		$emailError = true;	
	}
	
	if ($passError==false && $userError==false && $emailError==false)
	{
		$reg = true;
		$sql = "INSERT INTO USER(USER_USERNAME,USER_EMAIL,USER_PASSWORD,USER_FN,USER_LN,USER_GENDER,USER_BIRTH,USER_TYPE) VALUES ('$userName',
																									'$email',
																									'$pass',
																									'$theName',
																									'$theSurname',
																									'$gender',
																									'$birthDate',
																									'U')";
		if (!mysql_query($sql,$con))
		{
			Print "<h1>That username or password already exists</h1>";
			Print "<h2>Click <a href='index.php?action=10'>here</a> to try again</h2>";
			die;
		}
		if(!isset($_SESSION['userName']))
		{
			// session not logged in
			session_destroy();
		} else
		{
			session_start();
			session_destroy();
		}
	}
	mysql_close($con);
}
?>
	<?php
	if ($reg==false)
	{
	echo
	"	<div id='enter'>
        <h1> Welcome new user! </h1>
        <form id='theForm' name='theForm' method='post' action='index.php?action=10'>
		<table>
			<tr>
				<td>
					<p>Username:</p>
					<p><input type='text' name='username' id='username' autofocus='autofocus' placeholder='Your username' value='a' onchange='checkUserName()' required/></p>
					<a id='inval_user'><span class='error'>Username already used</span></a>";
					if ($userError==true)
						Print "<p><span class='error'>Username already used</span></p>";
	echo
				"</td>
				<td>
					<p>Email Address:</p>
					<p><input type='email' name='emailAddress' id='emailAddress' placeholder='Eg, me@thePlace.net' value='me@thePlace.net' onchange='checkEmail()' required/></p>
					<a id='inval_email'><span class='error'>Email already used</span></a>";				
					if ($emailError==true)
						Print "<p><span class='error'>Email already used</span></p>";
	echo				
				"</td>
			</tr>
			<tr>
				<td>
					<p>Name:</p><p>
					<input type='text' name='theName' id='theName' placeholder='Your name' value='a' required/></p>		
				</td>
				<td>
					<p>Surname:</p>
					<p><input type='text' name='surname' id='surname' placeholder='Your surname' value='a' required/></p>           
				</td>
			</tr>
			<tr>
				<td>
					<p>Password:</p>
					<p><input type='password' name='passW' id='passW' placeholder='Your password' value='a' required/></p>
				</td>
				<td>
					<p>Confirm Password</p>
					<p><input type='password' name='passW2' id='passW2' placeholder='Your confirmed password' value='a' required/></p>          
				</td>
			</tr>";			
				if ($passError==true)
					Print "<tr><td><p><span class='error'>Passwords must match</span></p></td></tr>";
			
	echo		
			"<tr>
				<td>
					<p>Date of Birth (YYYY-MM-DD)</p>
					<p><input type='date' name='birthDate' id='birthDate' placeholder='YYYY-MM-DD' value='1991-06-23' required/></p>
				</td>
				<td>
					<p>Gender</p>
					<p> M <input type='radio' name='gender' id='gender' value='M' checked='true'/></p>
					<p> F <input type='radio' name='gender' id='gender' value='F'/></p>      
				</td>
			</tr>   
			<tr>
				<td>
					<label for='file'>Avatar:</label>
						<input type='file' name='file' id='file' /> 
				</td>
			</tr>
		</table>
		<input name='form' type='hidden' id='form' value='true'>
		<input type='submit' value='Register' id='submitButton' name='submitButton'/>
        </form>
		</div>";
	} else
	{
		echo"	<div id='enter'>
					<h1> Registration succesful! </h1>
					<p><h2> Welcome $userName! </h2></p><br/>
					<hr/>
					<p><h3>User details:</h3></p><br/>
					
					<h3> Name:       $theName</h3>
					<h3> Surname:    $theSurname</h3>
					<h3> Email:      $email</h3>
					<h3> Birth Date: $birthDate</h3><br/>
					<hr/><br/>
					<h3>Thank you for registering. Please log in and start sharing.</h3><br/>
					<hr/>
				</div>";
	}
	?>	
	<div>
			<a name="USER_NAMES" id="USER_NAMES">
			<?php
            $con = mysql_connect("localhost","root","");
            if (!$con)
            {
                die ('Could not connect: ' . mysql_error());
            }
            mysql_select_db("dbmain", $con);
			$data = mysql_query("SELECT * FROM USER") 
			or die(mysql_error()); 
			while($info = mysql_fetch_array( $data )) 
			{ 
				Print $info['USER_USERNAME'] . ","; 
			} 
            mysql_close($con);
			?>
			</a>
			
			<a name="USER_EMAILS" id="USER_EMAILS">
			<?php
            $con = mysql_connect("localhost","root","");
            if (!$con)
            {
                die ('Could not connect: ' . mysql_error());
            }
            mysql_select_db("dbmain", $con);
			$data = mysql_query("SELECT * FROM USER") 
			or die(mysql_error()); 
			while($info = mysql_fetch_array( $data )) 
			{ 
				Print $info['USER_EMAIL'] . ","; 
			} 
            mysql_close($con);
			?>
			</a>
		</div>
</body>
</html>