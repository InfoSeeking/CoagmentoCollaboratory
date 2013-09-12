<?php
	require_once('../../core/Connection.class.php');
	
	//This sign up DEMO allows recruiting individual participants, dyads, and triads.
	//This is just a template
?>
<html>
<head>
	<title>
    	Coagmento Collaboratory - LAB STUDY TITLE
    </title>
<script src="js/functions.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

</style>
</head>
<body>
<div id="signupForm" align="center">
	<h3>Lab Study Title</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="body" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li><strong>Welcome Message</strong><li>
				<li>This is a study signup form. <strong>All the fields are required (other than comments)</strong>.</li>
				<li>Text ... </li>
				<li>Text ... </li>
				<li>Text ... </li>
				</ul>
				</td>
			</tr>
			<tr bgcolor="CDEB8B">				
				<td colspan=2><strong>Step-1: Select the study</strong></td>
			</tr>	
			<tr>
				<td colspan=2><div style="display: none; background: Red; text-align:center;" id="alertStudy"><strong>You Must Select One Study</strong></div></td>
			</tr>
			<tr>
				<td>
					<select id="selectStudyMenu" onchange="selectStudy(this);">
						<option value="">Pick a Study</option>
						<option value="3">Group-of-three Study</option>
						<option value="2">Pairs Study</option>
						<option value="1">Individual Study</option>
					</select>
				</td>
			</tr>
			<tr>
			<td width=50% valign="top">
<!-- 
	Triads registration
-->	
				<div id="triad" style="display: none;">
					<table>
						<tr>
							<td>
								<ul>						
									<li>This study requires a <em>team of three</em>.</li>
									<li>ADD STUDY DESCRIPTION</li>
								</ul>
							</td>
						</tr>
					</table>						
								
					<p><strong>Check here to read recruitment details </strong><input type="checkbox" name="viewInstructionsCheckTriad" id="viewInstructionsCheckTriad" onclick="viewDetailsTriad(this)" /></p>
					<br />
					<div id="TduplicateEmail" style="display: none; background: Red; text-align:center;">Emails for each participant must be distinct</div>					
					<br />		
					<div style="display: none; background: #F2F2F2; text-align:center; border-style:solid; width:70%; border-color:blue; padding:25px;" id="triadStudyDetails">
	 					<table class="body" width="100%">
							<tr>	
								<td>
									<p>ADD RECRUITMENT DETIALS,</p>
								</td>
							</tr>	
	  					</table>
					</div>				
					<table>
							<tr><th colspan=2>Participant-1 details</th></tr>
							<tr><td>First name</td><td> <input type="text" size=25 id="s1" name="TfirstName1" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" size=25 id="s2" name="TlastName1" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" size=25 id="s3" name="Temail1" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s4" name="TreEmail1" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="Tenglish1"><input type="radio" id="s5" name="Tenglish1" value="0" />No  <input type="radio" id="s6" name="Tenglish1" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="Tsex1"><input type="radio" id="s7" name="Tsex1" value="F" />Female  <input type="radio" id="s8" name="Tsex1" value="M" />Male</div></td></tr>
							<tr><td><br /></td></tr>
							<tr><th colspan=2>Participant-2 details</th></tr>
							<tr><td>First name</td><td> <input type="text" id="s9" size=25 name="TfirstName2" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" id="s10" size=25 name="TlastName2" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" id="s11" size=25 name="Temail2" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s12" name="TreEmail2" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="Tenglish2"><input type="radio" id="s13" name="Tenglish2" value="0" />No  <input type="radio" id="s14" name="Tenglish2" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="Tsex2"><input type="radio" id="s15" name="Tsex2" value="F" />Female  <input type="radio" id="s16" name="Tsex2" value="M" />Male</div></td></tr>
							<tr><th colspan=2>Participant-3 details</th></tr>
							<tr><td>First name</td><td> <input type="text" id="s17" size=25 name="TfirstName3" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" id="s18" size=25 name="TlastName3" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" id="s19" size=25 name="Temail3" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s20" name="TreEmail3" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="Tenglish3"><input type="radio" id="s21" name="Tenglish3" value="0" />No <input type="radio" id="s22" name="Tenglish3" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="Tsex3"><input type="radio" id="s23" name="Tsex3" value="F" />Female  <input type="radio" id="s24" name="Tsex3" value="M" />Male</div></td></tr>
						</table>
						<p>Briefly, describe a project that you three have worked together in the past, or are working on now.</p>
						<textarea name="TpastCollab" id="s50" cols=40 rows=3></textarea>						
			</div>
			</td>
		</tr>

<!-- 
	Dyads registration
-->	
	<tr>
			<td width=50% valign="top">	
				<div id="dyad" style="display: none;">
					<table>
						<tr>
							<td>
								<ul>						
									<li>This study requires a <em>team of two</em>.</li>
									<li>ADD STUDY DESCRIPTION</li>
								</ul>
							</td>
						</tr>
					</table>						
								
					<p><strong>Check here to read recruitment details </strong><input type="checkbox" name="viewInstructionsCheckDyad" id="viewInstructionsCheckDyad" onclick="viewDetailsDyad(this)" /></p>
					<br />
					<div id="DduplicateEmail" style="display: none; background: Red; text-align:center;">Emails for each participant must be distinct</div>	
					<br />
					<div style="display: none; background: #F2F2F2; text-align:center; border-style:solid; width:70%; border-color:blue; padding:25px;" id="dyadStudyDetails">
	 					<table class="body" width="100%">
							<tr>	
								<td>
									<p>ADD RECRUITMENT DETIALS,</p>
								</td>
							</tr>	
	  					</table>
					</div>				
					<table>
							<tr><th colspan=2>Participant-1 details</th></tr>
							<tr><td>First name</td><td> <input type="text" size=25 id="s1" name="DfirstName1" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" size=25 id="s2" name="DlastName1" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" size=25 id="s3" name="Demail1" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s4" name="DreEmail1" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="Denglish1"><input type="radio" id="s5" name="Denglish1" value="0" />No  <input type="radio" id="s6" name="Denglish1" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="Dsex1"><input type="radio" id="s7" name="Dsex1" value="F" />Female  <input type="radio" id="s8" name="Dsex1" value="M" />Male</div></td></tr>
							<tr><td><br /></td></tr>
							<tr><th colspan=2>Participant-2 details</th></tr>
							<tr><td>First name</td><td> <input type="text" id="s9" size=25 name="DfirstName2" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" id="s10" size=25 name="DlastName2" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" id="s11" size=25 name="Demail2" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s12" name="DreEmail2" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="Denglish2"><input type="radio" id="s13" name="Denglish2" value="0" />No  <input type="radio" id="s14" name="Denglish2" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="Dsex2"><input type="radio" id="s15" name="Dsex2" value="F" />Female  <input type="radio" id="s16" name="Dsex2" value="M" />Male</div></td></tr>
						</table>
						<p>Briefly, describe a project that you two have worked together in the past, or are working on now.</p>
						<textarea name="DpastCollab" id="s51" cols=40 rows=3></textarea>							
			</div>
			</td>
		</tr>			
<!-- 
	Individual registration
-->
	<tr>
		<td>
				<div id="single" style="display: none;">
					<table>
						<tr>
							<td>
								<ul>						
									<li>This study requires a <em>single participant</em>.</li>
								</ul>
							</td>
						</tr>
					</table>						
								
					<p><strong>Check here to read recruitment details </strong><input type="checkbox" name="viewInstructionsCheckSingle" id="viewInstructionsCheckSingle" onclick="viewDetailsSingle(this)" /></p>
					<br />					
					<div style="display: none; background: #F2F2F2; text-align:center; border-style:solid; width:70%; border-color:blue; padding:25px;" id="singleStudyDetails">
	 					<table class="body" width="100%">
							<tr>	
								<td>
									<p>ADD RECRUITMENT DETIALS,</p>
								</td>
							</tr>	
	  					</table>
					</div>				
					<table>
							<tr><th colspan=2>Participant details</th></tr>
							<tr><td>First name</td><td> <input type="text" id="s18" size=25 name="firstName" value="" /></td></tr>
							<tr><td>Last name</td><td> <input type="text" id="s19" size=25 name="lastName" value="" /></td></tr>
							<tr><td>Email</td><td> <input type="text" id="s20" size=25 name="email" value="" /></td></tr>
							<tr><td>Confirm Email:</td><td> <input type="text" size=25 id="s21" name="reEmail" value="" /></td></tr>
							<tr><td>Is English your native language?</td><td><div id="english"><input type="radio" id="s22" name="english" value="0" />No  <input type="radio" id="s23" name="english" value="1" />Yes</div></td></tr>
							<tr><td>Sex</td><td><div id="sex"><input type="radio" id="s24" name="sex" value="F" />Female  <input type="radio" id="s25" name="sex" value="M" />Male</div></td></tr>
						</table>
			</div>
			</td>
		</tr>			
		
<!-- Calendar -->
			<tr bgcolor="CDEB8B">
				<td colspan=2><strong>Step-2: Select a time slot</strong></td>
			</tr>
			<tr bgcolor="CDEB8B">
				<td colspan=2><div style="display: none; background: Red; text-align:center;" id="alertSlot"><strong>You Must Select One Slot. Click in the Weeks Below to Find Available Slots</strong></div></td>
			</tr>
			<tr>
			  <td>
			  
				<?php 
				$query = "SELECT distinct(week), sum(available) av FROM slots group by week having av > 0 order by slotID";
				$connection = Connection::getInstance();
				$results = $connection->execute($query,null);
				
				$previousWeek = "";
				$open = 0;

				$days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
				$starts = array("9","10","11","12","13","14","15","16","17","18","19","20");
				$month = array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
				
				while ($line =  $results->fetch(PDO::FETCH_ASSOC))
				{
					/*$slotID = $line['slotID'];
					$date = strtotime($line['date']);
					$day = $line['day'];
					$time = $line['time'];*/
					$week = $line['week'];
					$weekID = str_replace(" ","",$week);					
				?>
					<br />
					<div class="cursorType" onclick="switchMenu('<?php echo $weekID; ?>');"><strong>- Week of <?php echo $week;?></strong> - Click here to expand or collapse the time slots</div>
					<div style="display: none" id="<?php echo $weekID; ?>" style="text-align:left;">				
					<table border="1">
						<tr>
							<th>date/time</th>
							<th> 9:00 AM </th>
							<th> 10:00 AM </th>
							<th> 11:00 AM </th>
							<th> 12:00 PM </th>
							<th> 13:00 PM </th>
							<th> 14:00 PM </th>
							<th> 15:00 PM </th>
							<th> 16:00 PM </th>
							<th> 17:00 PM </th>
							<th> 18:00 PM </th>
							<th> 19:00 PM </th>
							<th> 20:00 PM </th>							
						</tr>
						
						<?php 
							foreach ($days as &$day)
							{
								echo "<tr>";							
								echo "<td><strong> $day ";
								
								$wquery = "SELECT slotID, day(date) dd, month(date) mm, date, day, time, start, week FROM slots where available = 1 and  day = '$day' and week='$week' order by start";
								
								$wresults = $connection->execute($wquery,null);
								$i=-1;
								$flagHour = 1;
								$wline = NULL;
																
								while (1)
								{																					
									if ($flagHour)
									{
										$flagHour = 0;
										$wline =  $wresults->fetch(PDO::FETCH_ASSOC);
									}
									
									if ($wline)
									{
										$slotID = $wline['slotID'];
										$dd = $wline['dd'];
										$mm = $wline['mm'];									
										$start = $wline['start'];
										$date = $wline['date']; 
										$todaysDate = date("Y-m-d");
										
										if(strtotime($date) >= strtotime($todaysDate)) //DISPLAY ONLY DATES GREATER THAN CURRENT DATE
										{
											if ($i==-1)
											{
												//echo "<td align=\"right\"><strong> $mm/$dd </strong></td>\n";
												echo "($month[$mm] $dd)</strong></td>";
											}

											if ($start==$starts[$i+1])
											{
												echo "<td align=\"center\"><input type=\"radio\" name=\"slot\" value=\"$slotID\" /></td>\n";
												$flagHour = 1;
											}
											else 
												echo "<td bgcolor=\"LightGray\"></td>";
											$i++;												
										}
										else
										{
											if ($start==$starts[$i+1])
											{
												echo "<td bgcolor=\"LightGray\"></td>";
												$i++;
											}							
											$flagHour = 1;
										}									
									}
									else
										break;
								}
								
								if ($i>-1)
									$i++;
								else
									$i=0;
									
								while ($i<count($starts)) 
								{
									echo "<td bgcolor=\"LightGray\"></td>";
									$i++;
								}
								
								echo "</tr>";								
							}
						?>
					</table>				 					
					</div>
					<hr />
				<?php 
					}
				?>		
			  </td>
			</tr>
			<tr>
				<td colspan=2 bgcolor="CDEB8B"><strong>Step-3: Leave any comments you have (optional)</strong></td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<br/>
						Comments (optional): (e.g., if you're going to be a few minutes late or if you have any other requests you want us to consider)
					<br/>
					<textarea name="comments" cols=80 rows=3></textarea>
				</td>
			</tr>
			<tr>
				<td align="center" colspan=2>
					<div style="display: none; background: Red; text-align:center;" id="alertForm"><strong>Please Complete the Fields in Red and Try Again</strong></div>
				</td>
			</tr>
			<tr>
				<td align="center" colspan=2>
					<input type="submit" value="Submit" />
				</td>
			</tr>
		</table>
    </form>
</div>
</body>
</html>



