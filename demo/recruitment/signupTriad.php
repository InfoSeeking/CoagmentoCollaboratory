<?php
	require_once('../../core/Connection.class.php');
	//require_once('core/Base.class.php');
?>
<html>
<head>
<title>Sign Up</title>
</head>
<body>
<?php
if (
	   (isset($_POST['slot'])) && 
	   (isset($_POST['TfirstName1'])) && 
	   (isset($_POST['TlastName1'])) && 
	   (isset($_POST['TfirstName2'])) && 
	   (isset($_POST['TlastName2'])) && 
	   (isset($_POST['Temail1'])) &&  
	   (isset($_POST['Temail2'])) && 
   	   (isset($_POST['Tenglish1'])) && 
	   (isset($_POST['Tenglish2'])) && 
   	   (isset($_POST['Tsex1'])) && 
	   (isset($_POST['Tsex2'])) &&
	   (isset($_POST['TfirstName3'])) && 
	   (isset($_POST['TlastName3'])) &&
	   (isset($_POST['Temail3'])) &&
	   (isset($_POST['Tenglish3'])) && 
		(isset($_POST['Tsex3'])) &&
		(isset($_POST['TpastCollab'])) &&
	   (isset($_POST['comments'])) 
	   ) 	   
	{  
		$slotID = $_POST['slot'];
				
		$connection = Connection::getInstance();			
		$cQuery = "SELECT count(*) as num FROM slots WHERE slotID=:slotID AND available=1";

		$cParams = array(':slotID' => $slotID);
		$cResults = $connection->execute($cQuery,$cParams);
		$cLine = $cResults->fetch(PDO::FETCH_ASSOC);
		$available = $cLine['num'];
		
		if ($available) 
		{
					
			//Blocking slot so that anyone else can take it
			$query = "UPDATE slots SET available=0 WHERE slotID=:slotID";
			$params = array(':slotID' => $slotID);
			$results = $connection->execute($query,$params);
		
		
			//required to retrieve time, date, and timestamp
			//$base = new Base();
			
			$comments = addslashes($_POST['comments']);
			$query = "SELECT day, date, time FROM slots WHERE slotID=:slotID";
			$results = $connection->execute($query,$params);
			$line = $results->fetch(PDO::FETCH_ASSOC);
			$slotDay = $line['day'];
			$slotDate = $line['date'];
			$slotTime = $line['time'];
						
			//ADDING PARTICIPANTS
			$firstName1 = stripslashes($_POST['TfirstName1']);
			$lastName1 = stripslashes($_POST['TlastName1']);
			$email1 = $_POST['Temail1'];
			$english1 = $_POST['Tenglish1'];
			$sex1 = $_POST['Tsex1'];
			$firstName2 = stripslashes($_POST['TfirstName2']);
			$lastName2 = stripslashes($_POST['TlastName2']);
			$email2 = $_POST['Temail2'];
			$english2 = $_POST['Tenglish2'];
			$sex2 = $_POST['Tsex2'];
			$firstName3 = stripslashes($_POST['TfirstName3']);
			$lastName3 = stripslashes($_POST['TlastName3']);
			$email3 = $_POST['Temail3'];
			$english3 = $_POST['Tenglish3'];
			$sex3 = $_POST['Tsex3'];			
			$pastCollab = $_POST['TpastCollab'];				
			$comments = stripslashes($_POST['comments']);
			$time = "11:25:20";//$base->getTime();
			$date = "2013-04-10";//$base->getDate();
			$timestamp = "1365607520";//$base->getTimestamp();

			$query = "INSERT INTO registrations (studyID, comments, slotID, date, time, timestamp,pastCollab) 
			          VALUES('3',:comments,:slotID,:date,:time,:timestamp,:pastCollab)";

			$params = array(':comments' => $comments, ':slotID'=>$slotID, ':date'=>$date, ':time'=>$time, ':timestamp'=>$timestamp, ':pastCollab'=>$pastCollab);
            $results = $connection->execute($query,$params);			
			
			$registrationID = $connection->getLastID();
			
			$query = "INSERT INTO recruits (registrationID, firstName, lastName, email, english, sex) 
			          VALUES(:registrationID,:firstName,:lastName,:email,:english,:sex)";
			
			$params = array(':registrationID' => $registrationID, ':firstName' => $firstName1, ':lastName'=>$lastName1, ':email'=>$email1, ':english'=>$english1, ':sex'=>$sex1);
			$results = $connection->execute($query,$params);
			$params = array(':registrationID' => $registrationID, ':firstName' => $firstName2, ':lastName'=>$lastName2, ':email'=>$email2, ':english'=>$english2, ':sex'=>$sex2);
			$results = $connection->execute($query,$params);
			$params = array(':registrationID' => $registrationID, ':firstName' => $firstName3, ':lastName'=>$lastName3, ':email'=>$email3, ':english'=>$english3, ':sex'=>$sex3);
			$results = $connection->execute($query,$params);
			
			//$recruitsID = $connection->getLastID();
			
			//ADDING USERS		
			$username1 = strtolower($firstName1).'1'.$registrationID;
			$username2 = strtolower($firstName2).'2'.$registrationID;
			$username3 = strtolower($firstName2).'3'.$registrationID;
			$passwd1 = sha1(strtolower($lastName1));
			$passwd2 = sha1(strtolower($lastName2));
			$passwd3 = sha1(strtolower($lastName3));
			
			$query = "INSERT INTO users (projectID, username, password, study) VALUES (:registrationID,:username,:passwd,'2')";
			
			$params = array(':registrationID' => $registrationID, ':username'=>$username1, ':passwd'=>$passwd1);
			$results = $connection->execute($query,$params);
			$params = array(':registrationID' => $registrationID, ':username'=>$username2, ':passwd'=>$passwd2);
			$results = $connection->execute($query,$params);
			$params = array(':registrationID' => $registrationID, ':username'=>$username3, ':passwd'=>$passwd3);
			$results = $connection->execute($query,$params);
			
			//SEND NOTIFICATION EMAIL TO RESEARCHER											
			// Creating an email
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Researcher Name <rgonzal@gmail.com>' . "\r\n";  //Change Researcher name
	
			$subject = "Study Name";
			$message = "Hello,<br/><br/>Thank you for your interest in taking part in our lab study. The details of your participation are given below.<br/><br/>";
			$message .= "<strong>Your name:</strong> $firstName1 $lastName1<br/>";
			$message .= "<strong>Time:</strong> $slotDay, $slotDate, $slotTime<br/>";
			$message .= "<strong>Place:</strong> ADD LOCATION <br/><br/>";			
			$message .= "Additional study details ... <br/><br/>";
			$message .= "Contact information ... <br/>";
				

			mail ('rgonzal@gmail.com', $subject, $message, $headers);
			mail ($email1, $subject, $message, $headers);

			// Web Notification	
			echo "<table>\n";
			echo "<tr><td><br/><br/></td></tr>\n";
			echo "<tr><td align=left>Thank you for submitting your request for participating in this study. Please note down the day and the time for your participation as indicated below. An email is sent to you with this confirmation. If you do not receive this email in an hour or have any further question about this study, feel free to <a href=\"mailto:soulierlaure@gmail.com?subject=Study inquiry\">contact us</a>.<hr/></td></tr>\n";
			echo "<tr><td><strong>Participant information</strong></td></tr>\n";
			echo "<tr><td>First name: $firstName1</td></tr>\n";
			echo "<tr><td>Last name: $lastName1</td></tr>\n";
			echo "<tr><td>Email: $email1</td></tr>\n";
			echo "<tr><td>Sex: $sex1</td></tr>\n";
			echo "<tr><td>Is English your native language: $english1</td></tr>\n";
			echo "<tr><td><br/><strong>Selected time slot:</strong> $slotDay, $slotDate, $slotTime</td></tr>\n";
			echo "<tr><td><br/><strong>Comments:</strong> $comments</td></tr>\n";						
			echo "<tr><td><hr/>You can close this window now or navigate away. We will contact you soon!</td></tr>\n";
			echo "</table>\n";
		} // if ($available)
		else 
		{
			//echo "<tr><td>Looks like the slot that you selected just got taken! Please <a href=\"signup.php\">try again</a>.<br/>If you continue seeing this message, please <a href=\"mailto:soulierlaure@gmail.com?subject=Study inquiry\">contact us</a>.</td></tr>\n";
			echo "<input type=\"button\" value=\"Go Back\" onClick=\"javascript:history.go(-1)\" />";
			echo "<p>Looks like the slot that you selected just got taken! Please click the button below to return to the sign up form<br/>If you continue seeing this message, please <a href=\"mailto:soulierlaure@gmail.com?subject=Study inquiry\">contact us</a>.</p>\n";
		}
	} // if empty fields
	else
	{
		echo "<p>You forgot to complete one or more required values. Please click the button below to return to the sign up form</p>\n";
		echo "<input type=\"button\" value=\"Go Back\" onClick=\"javascript:history.go(-1)\" />";
	}
?>
<br/>
</body>
</html>
