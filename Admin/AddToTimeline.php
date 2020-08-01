<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');

	for ($i = 1; $i <= 31; $i++)
	{
		if($i < 10)
		{
			$i = "0".$i;
		}
 	   	$DayOptions = $DayOptions.'<option value="'.$i.'">'.$i.'</option>';
	}

	$content = '	<div class="greenTextbox">
					<form name="pageCreateEdit" enctype="multipart/form-data" action="http://www.worldwidelighthouses.com/Admin/AddToTimeline_Backend.php" method="post">
					
					<label for="EventTitle">Name:</label><br>
					<input type="text" name="Title" id="EventTitle"><br><br>
					
					<label for="EventImage">Image:</label><br>
					<input type="file" name="Thumbnail" id="EventImage"><br><br>
					
					<label for="EventWriteUp">Write Up:</label><br>
					<input type="text" name="WriteUp" id="EventWriteUp"><br><br>
					
					<label for="EventLink">Link:</label><br>
					<input type="url" name="Link" id="EventLink"><br><br>
					
					<label for="Day">Day:</label><br>
					<select name="Day" id="Day">
						'.$DayOptions.'
					</select><br><br>
					
					<label for="Month">Month:</label><br>
					<select name="Month">
						<option value="01">January</option>
						<option value="02">Feburary</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select><br><br>				
					
					<label for="Year">Year:</label><br>
					<input type="number" maxlength="4" name="Year" id="Year"><br><br>	
					
					<input type="submit" value="Add">
				</form>
				</div>
				';

	//Mobile Front Page
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false))
	{
			$pagecode = '<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="../resources/css/mobilePageLayout.css">
							<title>Add Timeline Event | Worldwide Lighthouses</title>
						</head>
						<body>
							<header> 
								<h1 id="logo"><a href="http://www.worldwidelighthouses.com">WWLH</a></h1>
								<form method="GET" action="http://www.worldwidelighthouses.com/Search/search.php">
									<input type="hidden" name="search" value="1"> 
									<input type="search" placeholder="Search" name="query" id="query">
									<input type="submit" value="Go">
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
								'.$content.'
							</article>
							<footer>
								<h3>Like this? Join our newsletter</h3>
								<form method="post" action="http://www.worldwidelighthouses.com/Newsletter/Join.php">
									<input type="email" name="email" placeholder="Enter your email address">
									<input type="submit" value="Sign up!"> 
								</form>
									<p><a href="About">About | </a> <a href="Contact">Contact | </a><a href="Use-Our-Media">Use our Media</a>
								<button id="toTop">Back To Top</button>
								<p>&#169; Worldwide Lighthouses '.date('Y').'</p>
							</footer>
							<script async src="../resources/js/mobile.js"></script>
						</body>';
	}
	
	//Desktop Version
	
	else {
		$pageCode =
		'<!DOCTYPE HTML>
				<html lang="en-GB">
					<head>	
						<meta name="author" content="Worldwide Lighthouses">
						<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
						<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
						<link rel="stylesheet" href="../resources/css/desktopPageLayout.css">
						<title>Add Timeline Event | Worldwide Lighthouses</title>
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
							'.$content.'
							</article>
							<footer>
								<div id="links">
									<ul>
										<li><a href="About/Index.php">About</a></li>
										<li><a href="Contact/Index.php">Contact</a></li>
										<li><a href="Use-Our-Media/Index.php">Use our Media</a></li>
										<li><a href="Social/Index.php">Social</a></li>
										<li id="toTop"><a href="#header">Back to Top</a></li>
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
			}
				//Remove all whitespace from code. Making it smaller
				
	if ($ajax == '1') {
		$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
		$content = trim($content);
		echo $content.'<script>document.title="English Lighthouses | Worldwide Lighthouses";</script>';
	}
	else {			
		$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
		$pageCode = trim($pageCode);
		echo $pageCode;
	}	
?>