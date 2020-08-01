<?php
	///<Summary>
	/// This page allows people to contact us. All information is then sent to 3 email addresses
	///
	/// *Danny Browns
	/// *Michael Browns
	/// *Paul Browns
	///</Summary>
	
	
	//Get Post Data
	$senderName = $_POST['senderName'];
	$senderEmailAddress = $_POST['senderEmailAddress'];
	$senderSubject = $_POST['senderSubject'];
	$senderMessage = $_POST['senderMessage'];
	$sending = $_POST['sending'];
	
	if(!empty($sending))
	{
		if(!empty($senderName) && !empty($senderEmailAddress) && !empty($senderSubject) && !empty($senderMessage))
		{
			//We have all the data we need. Send the email.
			$to = "Daniel Brown <dantonybrown@hotmail.co.uk>, Michael Brown <michaelbrown1995@hotmail.co.uk>, Paul Brown <paul@regtransfers.co.uk>";
			$subject = "Message from ".$senderName." - WWLH Contact Us Page - ".$senderSubject;
			$message = '<h1 style="color: green;">'.$senderSubject."</h1><b>Message sent (GMT - 5): </b>".date("g:ia - l jS F Y")."<br><b>Sent by: </b>".$senderName."<br><br><br>".wordwrap($senderMessage, 70);
			
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$senderName.' <'.$senderEmailAddress.'>' . "\r\n";
			
			mail($to, $subject, $message, $headers);
			
			//Inform user that everything is sent
			$warningMessage = "Thanks ".$senderName.", we will reply to your message shortly.";
		}
		else
		{
			//Fields aren't completed. Show form.
			$warningMessage = "You have failed to complete the form. Please ensure that all fields are filled out.";
		}
	}
		
	$pageCode = '		<head>	
						<meta name="author" content="Worldwide Lighthouses">
						<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
						<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
						<link rel="stylesheet" href="../resources/css/desktopPageLayout.css">
						<title>Contact Us | Worldwide Lighthouses</title>
					</head>	
					<body>
							<header>
								<h1><a href="http://www.worldwidelighthouses.com">Worldwide Lighthouses</a></h1>
								<form method="get" action="http://www.worldwidelighthouses.com/V8/Search.php">
									<input type="search" name="query" id="query" required placeholder="Search Worldwide Lighthouses"/>
									 <select id="type" name="type">
										<option value="all">Everything</option>
										<option value="lighthouseName">Lighthouses</option>
										<option value="lightshipName">Lightships</option>
										<option value="fogsignalName">Fog Signals</option>
										<option value="daymarkName">Daymarks</option>
										<option value="designerName">Designers</option>
									</select>
									<input type="submit" value="Search" />
								</form>
							</header>
							<nav>
								<ul>
									<li id="home"><a href="../Index.php"><p>Home</p></a></li>
									<li id="lighthouses"><a href="../Lighthouses/Index.php"><p>Lighthouses</p></a></li>
									<li id="lightships"><a href="../Lightships/Index.php"><p>Lightships</p></a></li>
									<li id="fog-signals"><a href="../Fog-Signals/Index.php"><p>Fog Signals</p></a></li>
									<li id="daymarks"><a href="../Daymarks/Index.php"><p>Daymarks</p></a></li>
									<li id="buoys"><a href="../Buoys/Index.php"><p>Buoys</p></a></li>
									<li id="glossary"><a href="../Glossary/Index.php"><p>Glossary</p></a></li>
								</ul>
							</nav>
							<article>
							<h2 class="greenTitle">Contact Us</h2>
								<div class="greenTextbox">
									'.$warningMessage.'
									<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
										<label for="SenderName">Your Name:</label><br>
										<input type="text" ID="SenderName" Name="senderName" required="required"/><br><br>
										
										<label for="SenderEmail">Your Email Address: (Used for Replying to you):</label><br>
										<input type="email" ID="SenderEmail" Name="senderEmailAddress" required="required"/><br><br>
									
										<label for="SenderSubject">Subject:</label><br>
										<input type="text" ID="SenderSubject" Name="senderSubject" required="required"/><br><br>
										
										<label for="SenderMessage" >Message:</label><br>
										<textarea ID="SenderMessage" Name="senderMessage" style="margin: 2px; height: 168px; width: 870px;" required="required"></textarea><br><br>
										
										<input type="hidden" name="sending" value="1"/>
										<input type="submit" value="Send Email">
									</form>
								</div>
							</article>
							<footer>
								<div id="links">
									<ul>
										<li><a href="Contact/Index.php">Contact</a></li>
										<li><a href="Use-Our-Media/Index.php">Use our Media</a></li>
									</ul>
								</div>
								<div id="newsletterSignup">
									<p>Like this? Sign up for a newsletter</p>
									<form method="post" action="http://www.worldwidelighthouses.com/Newsletter/Join.php">
										<input type="email" name="email" placeholder="Enter your email address">
										<input type="submit" value="Sign up!"> 
									</form>
								<p>&#169; Worldwide Lighthouses 2011</p>
								</div>
							</footer>
						'.$html5Shiv.'
						<script src="../resources/js/desktop.js"></script>
						</body>';
			
			//Remove all whitespace from code. Making it smaller	
			$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
			$pageCode = trim($pageCode);
			echo $pageCode;	

?>

