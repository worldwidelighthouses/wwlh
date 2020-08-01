<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');

	function ConnectToDB()
	{
		$link = mysql_connect('worldwidelighthouses.fatcowmysql.com', 'ww_lighthouses11', '14c@rtmeldr1ve41'); 
		if (!$link) 
		{ 
	    	die('Could not connect: ' . mysql_error()); 
	    }    
		mysql_select_db(light_information);
	}
	function nl2p($string, $line_breaks = true, $xml = true)
	{
	    // Remove existing HTML formatting to avoid double-wrapping things
	    $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
	    
	    // It is conceivable that people might still want single line-breaks
	    // without breaking into a new paragraph.
	    if ($line_breaks == true)
	        return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
	    else 
	        return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
	}  
	ConnectToDB();
	
	$TimelineEvents = array();
	
	$allTimelineEvents = mysql_query("SELECT * FROM Timeline ORDER BY Date ASC") or die(mysql_error());
	$numberTimelineEvents = mysql_num_rows($allTimelineEvents);
	
	$i = 0;
	while($i < $numberTimelineEvents)
	{
		$Date = mysql_result($allTimelineEvents, $i, "Date");
		$Title = mysql_result($allTimelineEvents, $i, "Title");
		$WriteUp = mysql_result($allTimelineEvents, $i, "WriteUp");
		$Link = mysql_result($allTimelineEvents, $i, "Link");
		$Thumbnail = mysql_result($allTimelineEvents, $i, "Thumbnail");
		
		$dateTime = new DateTime($Date);
		$TimelineEvents[$i]["Date"] = $dateTime->format('F j, Y');
		$TimelineEvents[$i]["Title"] = $Title;
		$TimelineEvents[$i]["WriteUp"] = $WriteUp;
		$TimelineEvents[$i]["Link"] = $Link;
		$TimelineEvents[$i]["Thumbnail"] = $Thumbnail;
		
		$i++;		
	}
	
	unset($i);
	unset($Title);
	unset($WriteUp);
	unset($Link);
	unset($Thumbnail);
	unset($Date);
	
	$i = 0;
	foreach($TimelineEvents as &$Value)
	{
		if(!empty($TimelineEvents[$i]["Title"]))
		{
			$Title = '<h2>'.$TimelineEvents[$i]["Title"].'</h2>';
		}
		if(empty($TimelineEvents[$i]["Link"]))
		{
			$Link = '#'.$i;
		}
		else
		{
			$Link = $TimelineEvents[$i]["Link"];
		}
		if(!empty($TimelineEvents[$i]["Thumbnail"]))
		{
			$Thumbnail = '<img src="'.$TimelineEvents[$i]["Thumbnail"].'" width="149" height="137">';
		}
		$WriteUp = str_replace("<p>", '<p class="searchDescription"><em>'.$TimelineEvents[$i]["Date"].'</em><br>', $TimelineEvents[$i]["WriteUp"]);
		$TimelineCode = $TimelineCode.'<div class="greenTextbox search" id="#'.$i.'"><a  href="'.$Link.'">'.$Title.$Thumbnail.$Date.$WriteUp.'</a></div>';
		
		unset($Title);
		unset($WriteUp);
		unset($Link);
		unset($Thumbnail);
		unset($Date);

		$i++;
	}
	
		$content = '<h2 class="greenTitle">The Lighthouse Timeline</h2>'.$TimelineCode;
	
		if(mobile_device_detect(true,true,true,true,true,true,true,false,false))
		{
		$pagecode = '<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="resources/css/mobilePageLayout.css">
							<title>Timeline | Worldwide Lighthouses</title>
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
									<li id="home"><a href="Index.php"><p>Home</p></a></li>
									<li id="lighthouses"><a href="Lighthouses/Index.php"><p>Lighthouses</p></a></li>
									<li id="lightships"><a href="Lightships/Index.php"><p>Lightships</p></a></li>
									<li id="fog-signals"><a href="Fog-Signals/Index.php"><p>Fog Signals</p></a></li>
									<li id="daymarks"><a href="Daymarks/Index.php"><p>Daymarks</p></a></li>
									<li id="buoys"><a href="Buoys/Index.php"><p>Buoys</p></a></li>
									<li id="glossary"><a href="Glossary/Index.php"><p>Glossary</p></a></li>
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
							<script async src="resources/js/mobile.js"></script>
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
						<title>Timeline | Worldwide Lighthouses</title>
					</head>	
					<body>
							<header>
								<h1><a href="http://www.worldwidelighthouses.com">Worldwide Lighthouses</a></h1>
								<form method="get" action="http://www.worldwidelighthouses.com/Search.php">
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
									<li id="home"><a href="Index.php"><p>Home</p></a></li>
									<li id="lighthouses"><a href="Lighthouses/Index.php"><p>Lighthouses</p></a></li>
									<li id="lightships"><a href="Lightships/Index.php"><p>Lightships</p></a></li>
									<li id="fog-signals"><a href="Fog-Signals/Index.php"><p>Fog Signals</p></a></li>
									<li id="daymarks"><a href="Daymarks/Index.php"><p>Daymarks</p></a></li>
									<li id="buoys"><a href="Buoys/Index.php"><p>Buoys</p></a></li>
									<li id="glossary"><a href="Glossary/Index.php"><p>Glossary</p></a></li>
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
						<script src="resources/js/desktop.js"></script>
						</body>';
			}	
			$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
			$pageCode = trim($pageCode);
			echo $pageCode;	
?>