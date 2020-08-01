<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	//Functions
        function connectToDatabase()
	{
		mysql_connect("worldwidelighthouses.fatcowmysql.com", "ww_lighthouses11", "14c@rtmeldr1ve41"); 
		mysql_select_db("light_information") or die(mysql_error());
	}
        function makeOverview($resultOverview){
		$resultOverview = substr($resultOverview, 0, 200);
		$resultOverview = $resultOverview.'&#8230;';
		return $resultOverview;	
	}
	function getColour($typeOfPage){
		switch ($typeOfPage){
			case $typeOfPage=="englandtrinityhouse" || $typeOfPage=="welshtrinityhouse"|| $typeOfPage=="channelislandstrinityhouse" || $typeOfPage =='englandtrinityfogsignal';
				$colour = 'green';
				break;
			
			case $typeOfPage=="franceprivate" || $typeOfPage=="channelislandsprivate" || $typeOfPage=="scottishprivate" || $typeOfPage=="welshprivate" || $typeOfPage=="englandprivate" || $typeOfPage=='englandprivatelightship' || $typeOfPage == 'englandprivatefogsignal';
				$colour = 'blue';
				break;
				
			case $typeOfPage=="norway" || $typeOfPage=="switzerland" || $typeOfPage=="englandtrinityhouselightship" || $typeOfPage == 'lightshipfogsignal';
				$colour = 'red';
				break;
			
			case $typeOfPage=="francelb";
				$colour = 'black';
				break;		
			
			case $typeOfPage=="northernlighthouseboard";
				$colour = 'gold';
				break;
			}
		return $colour;
	}
	function getURL($typeOfPage, $pageName){
		switch($typeOfPage){
			case $typeOfPage == 'englandtrinityhouse';
				$URL = 'Lighthouses/English-Lighthouses/Trinity-House-Owned/'.$pageName;
				break;
			case $typeOfPage == 'welshtrinityhouse';
				$URL = 'Lighthouses/Welsh-Lighthouses/Trinity-House-Owned/'.$pageName;
				break;
			case $typeOfPage == 'channelislandstrinityhouse';
				$URL = 'Lighthouses/Channel-Island-Lighthouses/Trinity-House-Owned/'.$pageName;
				break;			
			case $typeOfPage == 'englandtrinityfogsignal';
				$URL = 'Fog-Signals/English-Fog-Signals/Trinity-House-Owned/'.$pageName;
				break;
			case $typeOfPage == 'franceprivate';
				$URL = 'Lighthouses/French-Lighthouses/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'channelislandsprivate';
				$URL = 'Lighthouses/Channel-Island-Lighthouses/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'scottishprivate';
				$URL = 'Lighthouses/Scottish-Lighthouses/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'welshprivate';
				$URL = 'Lighthouses/Welsh-Lighthouses/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'englandprivate';
				$URL = 'Lighthouses/English-Lighthouses/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'englandprivatelightship';
				$URL = 'Lightships/English-Lightships/Privately-Owned/'.$pageName;
				break;	
			case $typeOfPage == 'englandprivatefogsignal';
				$URL = 'Fog-Signals/English-Fog-Signals/Privately-Owned/'.$pageName;
				break;
			case $typeOfPage == 'norway';
				$URL = 'Lighthouses/Norwegian-Lighthouses/'.$pageName;
				break;
			case $typeOfPage == 'switzerland';
				$URL = 'Lighthouses/Swiss-Lighthouses/'.$pageName;
				break;
			case $typeOfPage == 'englandtrinityhouselightship';
				$URL = 'Lightships/English-Lightships/Trinity-House-Owned/'.$pageName;
				break;
			case $typeOfPage == 'lightshipfogsignal';
				$URL = 'Fog-Signals/Lightship-Fog-Signals/'.$pageName;
				break;
			case $typeOfPage == 'francelb';
				$URL = 'Lighthouses/French-Lighthouses-Board-Owned/'.$pageName;
				break;
			case $typeOfPage == 'northernlighthouseboard';
				$URL = 'Lighthouses/Scottish-Lighthouses/Northern-Lighthouse-Board-Owned/'.$pageName;
				break;
		}
		return $URL;
	}
	//GET Variables
	$query = $_GET['query'];
	//Default Query is All
	$typeOfQuery = $_GET['type'];
	if ($typeOfQuery == ''){
		$typeOfQuery = 'all';
	}
	$query = trim($query);
	//If the user didn't enter a query then make them search again
	if($query === '' || $query === ' ') {
		$title = "Search Error | Worldwide Lighthouses";
		$content ='
				<h2 class="greenTitle">Search Error</h2>
				<div class="greenTextbox">
				<p>Looks like you didn\'t enter a query in the search bar before submitting. Have another go!</p>
								<form method="get" action="http://www.worldwidelighthouses.com/Search.php" style="display:block; margin:auto; text-align:center; width:500px;">
									<input type="search" name="query" required placeholder="Search Worldwide Lighthouses" style="border-radius:10px; width:200px;">
									 <select name="type">
										<option value="all">Everything</option>
										<option value="lighthouseName">Lighthouses</option>
										<option value="lightshipName">Lightships</option>
										<option value="fogsignalName">Fog Signals</option>
										<option value="daymarkName">Daymarks</option>
										<option value="designerName">Designers</option>
									</select>
									<input type="submit" value="Search" />
								</form>
				</div>
		';	
	}
	//If the user did enter a search term then conduct the search
	else {
		$title = 'Search for '.$query.' | Worldwide Lighthouses';
		connectToDatabase();
		## Lighthouse Match ####################################################################################
		if ($typeOfQuery === 'lighthouseName' || $typeOfQuery === 'all') {
			$lightName = mysql_query("SELECT Name, Thumbnail, WriteUp, PageType FROM Lighthouses WHERE Name LIKE'".'%'.$query.'%'."'") or die(mysql_error());			
			$numberLighthouses = mysql_num_rows($lightName);
			if ($numberLighthouses != 0) {
				$i = 0;
				while($i < $numberLighthouses){
					$resultPageName = mysql_result($lightName,$i,"Name");
					$resultPicture = mysql_result($lightName,$i,"Thumbnail");
					$resultOverview = mysql_result($lightName,$i,"WriteUp");
					$resultOverview = makeOverview($resultOverview);
					$resultTypeOfPage = mysql_result($lightName,$i,"PageType");
					$colour = getColour($resultTypeOfPage);
					$url = getURL($resultTypeOfPage,$resultPageName);
					$matchLighthouse .= '<div class="'.$colour.'Textbox search"><a href="'.$url.'"><h2>'.$resultPageName.'</h2><img src="'.$resultPicture.'" width="150" height="137" class="searchImage" alt="'.$resultPageName.'"><p class="searchDescription">'.$resultOverview.'</p></a></div>';
					$i++;
				}
			}
		}
		## /Lighthouse Match ###################################################################################
		
		## Lightship Match #####################################################################################
		/*
		if ($typeOfQuery === 'lightshipName' || $typeOfQuery === 'all') {
			$lightshipName = mysql_query("SELECT Name, Thumbnail, WriteUp, PageType FROM Lightships WHERE Name LIKE'".'%'.$query.'%'."'") or die(mysql_error());			
			$numberLightships = mysql_num_rows($lightshipName);
			if ($numberLightships != 0) {
				$i = 0;
				while($i < $numberLightships){
					$resultPageName = mysql_result($lightshipName,$i,"Name");
					$resultPicture = mysql_result($lightshipName,$i,"Thumbnail");
					$resultOverview = mysql_result($lightshipName,$i,"WriteUp");
					$resultOverview = makeOverview($resultOverview);
					$resultTypeOfPage = mysql_result($lightshipName,$i,"PageType");
					$colour = getColour($resultTypeOfPage);
					$url = getURL($resultTypeOfPage,$resultPageName);
					$matchLightship .= '<div class="'.$colour.'Textbox search"><a href="'.$url.'"><h2>'.$resultPageName.'</h2><img src="'.$resultPicture.'" width="150" height="137" class="searchImage" alt="'.$resultPageName.'"><p class="searchDescription">'.$resultOverview.'</p></a></div>';
					$i++;
				}
			}
		}
		*/
		## /Lightship Match ####################################################################################
		
		## Fog Signal Match ####################################################################################
		/*
		if ($typeOfQuery === 'fogsignalName' || $typeOfQuery === 'all') {
			$fogSignalName = mysql_query("SELECT Name, Thumbnail, WriteUp, PageTypeFROM `Fog-Signals` WHERE Name LIKE'".'%'.$query.'%'."'") or die(mysql_error());			
			$numberFogSignals = mysql_num_rows($fogSignalName);
			if ($numberFogSignals != 0) {
				$i = 0;
				while($i < $numberFogSignals){
					$resultPageName = mysql_result($fogSignalName,$i,"Name");
					$resultPicture = mysql_result($fogSignalName,$i,"Thumbnail");
					$resultOverview = mysql_result($fogSignalName,$i,"WriteUp");
					$resultOverview = makeOverview($resultOverview);
					$resultTypeOfPage = mysql_result($fogSignalName,$i,"TypeOfPage");
					$colour = getColour($resultTypeOfPage);
					$url = getURL($resultTypeOfPage,$resultPageName);
					$matchFogSignal .= '<div class="'.$colour.'Textbox search"><a href="'.$url.'"><h2>'.$resultPageName.'</h2><img src="'.$resultPicture.'" width="150" height="137" class="searchImage" alt="'.$resultPageName.'"><p class="searchDescription">'.$resultOverview.'</p></a></div>';
					$i++;
				}
			}
		}
		*/
		## /Fog Signal Match #####################################################################################
		
		## Daymark Match #########################################################################################
		/*
		if ($typeOfQuery === 'daymarkName' || $typeOfQuery === 'all') {
			$daymarkName = mysql_query("SELECT Name, Thumbnail, WriteUp, PageType FROM `Daymarks` WHERE Name LIKE'".'%'.$query.'%'."'") or die(mysql_error());			
			$numberDaymarks = mysql_num_rows($daymarkName);
			if ($numberDaymarks != 0) {
				$i = 0;
				while($i < $numberDaymarks){
					$resultPageName = mysql_result($daymarkName,$i,"Name");
					$resultPicture = mysql_result($daymarkName,$i,"Thumbnail");
					$resultOverview = mysql_result($daymarkName,$i,"WriteUp");
					$resultOverview = makeOverview($resultOverview);
					$resultTypeOfPage = mysql_result($daymarkName,$i,"PageType");
					$colour = getColour($resultTypeOfPage);
					$url = getURL($resultTypeOfPage,$resultPageName);
					$matchDaymark .= '<div class="'.$colour.'Textbox search"><a href="'.$url.'"><h2>'.$resultPageName.'</h2><img src="'.$resultPicture.'" width="150" height="137" class="searchImage" alt="'.$resultPageName.'"><p class="searchDescription">'.$resultOverview.'</p></a></div>';
					$i++;
				}
			}
		}
		*/
		## /Daymark Match ########################################################################################
		
		## Prep Content ##########################################################################################
			$searchResults = $matchLighthouse.$matchLightship.$matchFogSignal.$matchDaymark;
			$numberResults = $numberLighthouses + $numberLightships + $numberFogSignals + $numberDaymarks;
			
			if ($numberResults == 0) {
				$content = '<h2 class="greenTitle">No results for '.$query.'</h2>
							<div class="greenTextbox"><p>Sorry, we couldn\'t find any results for your query. Try another search term.</p></div>';
			}
			else {
				if ($numberResults == 1){$resultOrResults = 'result';} else {$resultOrResults = 'results';}
				$content = '<h2 class="greenTitle">'.$numberResults.' '.$resultOrResults.' for '.$query.' </h2>'.$searchResults;
			}
		##########################################################################################################
	}	
		
	#Make Page Code
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false)){
		$pageCode = '<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="resources/css/mobilePageLayout.css">
							<title>'.$title.' | Worldwide Lighthouses</title>
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
	else {
		$pageCode =
		'<!DOCTYPE HTML>
				<html lang="en-GB">
					<head>	
						<meta name="author" content="Worldwide Lighthouses">
						<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
						<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
						<link rel="stylesheet" href="resources/css/desktopPageLayout.css">
						<title>'.$title.'</title>
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
									<form method="post" action="http://www.worldwidelighthouses.com/V8/Sign-Up.php">
										<input type="email" name="email" placeholder="Enter your email address" required>
										<input type="submit" value="Sign up!"> 
									</form>
								<p>&#169; Worldwide Lighthouses 2011</p>
								</div>
							</footer>
						'.$html5Shiv.'
						<script src="resources/js/desktop.js"></script>
						</body>';
	}
			//Remove all whitespace from code. Making it smaller AND echo code dependent on AJAX
			if ($ajax == '1') {
				$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
				$content = trim($content);
				echo $content.'<script>document.title="'.$title.'";</script>';
			}
			else {			
				$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
				$pageCode = trim($pageCode);
				echo $pageCode;
			}	
?>
	