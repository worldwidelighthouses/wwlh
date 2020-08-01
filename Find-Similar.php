<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');

	$thisPage = $_GET['RefPage'];
	$Attribute = $_GET['Attribute'];
	$Data = $_GET['Data'];
	
	//Connect To Database
	function connectToDatabase()
	{
		mysql_connect("worldwidelighthouses.fatcowmysql.com", "ww_lighthouses11", "14c@rtmeldr1ve41"); 
		mysql_select_db("light_information") or die(mysql_error());
	}
	connectToDatabase();

	switch($Attribute)
	{
		case "Established":
			$SQLAttribute = "DateEstablished";
			break;
		case "CurrentLighthouseBuilt":
			$SQLAttribute = "DateCurrentLighthouseBuilt";
			$Attribute = "Current Lighthouse Built";
			break;
		case "Height";
			$SQLAttribute = "Height";
			break;
		case "Automated":
			$SQLAttribute = "DateAutomated";
			break;
		case "Electrified":
			$SQLAttribute = "DateElectrified";
			break;
		case "Operator":
			$SQLAttribute = "Operator";
			break;
		case "Designer":
			$SQLAttribute = "Designer";
			break;
		default:
			die("Illegal Attribute Value");
			break; 
	}

	$similarLighthouses = mysql_query("SELECT * FROM `Lighthouses` WHERE `".$SQLAttribute."` LIKE ".'"%'.$Data.'%"') or die(mysql_error());
	$numberSimilarLighthouses = mysql_num_rows($similarLighthouses) or die(mysql_error());
		
	//Initial Sections with Titles
	$englandTrinityHouse = '<h2 class="greenTitle">Similar Trinity House Lighthouses</h2>';
	$englandPrivate = '<h2 class="blueTitle">Similar Privately Owned English Lighthouses</h2>';
	
	// Add :
	$Attribute = $Attribute.":";
	
	$i = 0;
	while($i < $numberSimilarLighthouses)
	{
		$thisName = mysql_result($similarLighthouses, $i, "Name") or die(mysql_error());
		$thisPageType = mysql_result($similarLighthouses, $i, "PageType") or die(mysql_error());
		$thisThumbnail = mysql_result($similarLighthouses, $i, "Thumbnail") or die(mysql_error());
		$thisAttribute = mysql_result($similarLighthouses, $i, $SQLAttribute) or die(mysql_error());
		$thisWriteUp = mysql_result($similarLighthouses, $i, "WriteUp") or die(mysql_error());
		$thisWriteUp = str_replace("<p>", "", $thisWriteUp);
		$thisWriteUp = str_replace("</p>", "", $thisWriteUp);
		$thisWriteUp = substr($thisWriteUp, 0, 256)."&#8230;";
		
		if($Attribute == "Designer:")
		{
			$DisplayAttribute = "Designer: ".$thisAttribute;
			
			$thisCLB = mysql_result($similarLighthouses, $i, "DateCurrentLighthouseBuilt");
			
			$thisAttribute = "<br>Built: ".$thisCLB;
		}
		else
		{
			$DisplayAttribute = $Attribute;
		}

		if($thisName != thisPage)
		{		
			switch($thisPageType)
			{
				case "englandtrinityhouse":
					$content = $content.'<div class="greenTextbox search"><a href="http://www.worldwidelighthouses.com/Lighthouses/English-Lighthouses/Trinity-House-Owned/'.$thisName.'"><h2>'.$thisName.'</h2><img src="'.$thisThumbnail.'" alt="'.$thisName.'" class="searchImage"><p class="searchDescription"><em>'.$DisplayAttribute.$thisAttribute.'</em></p><p class="searchDescription">'.$thisWriteUp.'</p></a></div>';	
					break;
				case "englandprivate":
					$content = $content.'<div class="blueTextbox search"><a href="http://www.worldwidelighthouses.com/Lighthouses/English-Lighthouses/Privately-Owned/'.$thisName.'"><h2>'.$thisName.'</h2><img src="'.$thisThumbnail.'" alt="'.$thisName.'" class="searchImage"><p class="searchDescription"><em>'.$DisplayAttribute.$thisAttribute.'</em></p><p class="searchDescription">'.$thisWriteUp.'</p></a></div>';
					break;
				case "scotlandNLB":
					$content = $content.'<div class="goldTextbox search"><a href="http://www.worldwidelighthouses.com/Lighthouses/Scottish-Lighthouses/Northern-Lighthouse-Board-Owned/'.$thisName.'"><h2>'.$thisName.'</h2><img src="'.$thisThumbnail.'" alt="'.$thisName.'" class="searchImage"><p class="searchDescription"><em>'.$DisplayAttribute.$thisAttribute.'</em></p><p class="searchDescription">'.$thisWriteUp.'</p></a></div>';
					break;
				case "scotlandprivate":
					$content = $content.'<div class="blueTextbox search"><a href="http://www.worldwidelighthouses.com/Lighthouses/Scottish-Lighthouses/Privately-Owned/'.$thisName.'"><h2>'.$thisName.'</h2><img src="'.$thisThumbnail.'" alt="'.$thisName.'" class="searchImage"><p class="searchDescription"><em>'.$DisplayAttribute.$thisAttribute.'</em></p><p class="searchDescription">'.$thisWriteUp.'</p></a></div>';
					break;
			}
		}
		
		unset($thisCLB);
		unset($thisAttribute);
		
		$i++;
	}
	
	$Attribute = str_replace(":", "", $Attribute);	
	if($content == "")
	{
		$content = '<h2 class="greenTitle">No Similar Lighthouses...</h2><div class="greenTextbox"><p>No other Lighthouses, Lightships, Fog Signals or Daymarks were similar to '.$thisPage.' for '.$Attribute.'</p></div>';
	}
	else
	{
		$content = '<h2 class="greenTitle">Aids To Navigation with Similar/The Same '.$Attribute.' as '.$RefPage.'</h2>'.$content;
	}

	//Echo Code	
		if(mobile_device_detect(true,true,true,true,true,true,true,false,false)){
		$content = '<h2 class="greenTitle">Welcome to WWLH Mobile</h2>
					<p>Welcome to Worldwide Lighthouses Mobile, here are some pages you might be interested in:</p>
					<ul id="index">
						<li>Lighthouses</li>
						<li>Lightships</li>
						<li>Fog Signals</li>
						<li>Day Marks</li>
						<li>Buoys</li>
						<li>Glossary</li>
						<li><a href="Lighthouses/English-Lighthouses.php?Title=Beachy%20Head%20Lighthouse&amp;Ajax=1">Bogus link</a></li>
					</ul>					
		';
		$pagecode = '<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="../resources/css/mobilePageLayout.css">
							<title>Aids to Navigation with Similar '.$Attribute.' to '.$thisPage.' | Worldwide Lighthouses</title>
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
						<title>Aids to Navigation with Similar '.$Attribute.' to '.$thisPage.' | Worldwide Lighthouses</title>
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
			}
				//Remove all whitespace from code. Making it smaller
				
				$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
				$pageCode = trim($pageCode);
				echo $pageCode;	

?>