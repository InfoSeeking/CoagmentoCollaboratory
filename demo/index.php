<?php
	 session_start();
	 require_once('../core/User.class.php');
	 require_once('../core/Session.class.php');
	 require_once("../core/Stage.class.php");
	 require_once("../core/Action.class.php");
	 
	if (($_POST['userName'])&&(!Session::getInstance()->isSessionActive())){
		//user is trying to log in
		$userName = $_POST['userName'];
		$password = sha1($_POST['password']);
		$localDate = $_POST['clientDate'];
		$localTime = $_POST['clientTime'];
		$localTimeStamp = $_POST['clientTimestamp'];
		try
		{
			$user = User::login($userName,$password);
			if ($user!=null)
			{
				$s = Session::getInstance();
				$s->userName = $user->getUserName();
				$s->userID = $user->getUserID();
				//save login action
				$a = new Action("login", $userName);
				$a->setLocalDate($localDate);
				$a->setLocalTime($localTime);
				$a->setLocalTimestamp($localTimeStamp);
				$a->save();
				echo "A session has been created";
			}
			else
				echo "User name and password do not match or user does not exist";
		}
		catch(Exception $e)
		{
			echo "An unexcepted error has occurred Code".$e->getCode();
		}
	}

	if (!Session::isSessionActive()):
?>
<html>
	<head>
		<title>Login</title>
	<head>	
	<body>
		<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="main.js"></script>
		<form action="index.php" method="post" class="addTimestamps">	
			<label>Username</label><input type="text" name="userName" size=20 /><br/>
			<label>Password</label><input type="password" name="password" size=20 /><br/>
			<input type="submit" value="Submit"/>
		</form>	
	</body>
</html>
<?php
	else:
?>
<html>
	<head>
		<title>Manage</title>
	<head>	
	<body>
		<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="main.js"></script>
		<p>Welcome <?php echo Session::getInstance()->userName; ?></p>
		<form class="addTimestamps" action="logout.php">
			<input type="submit" value="Logout"/>
		</form>
		<h1>Manage Data</h1>
		<h2>Snippets</h2>
		<h2>Bookmarks</h2>
	</body>
</html>
<?php
	endif;
?>
