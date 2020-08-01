<?php	
	//Set Headers
	$Title = $_GET['Title'];
	$Title = str_replace('-',' ',$Title);
	$ajax = $_POST['AJAX'];
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');
	#FUNCTIONS
	#Connect To Database
	function connectToDatabase()
	{
		mysql_connect("worldwidelighthouses.fatcowmysql.com", "ww_lighthouses11", "14c@rtmeldr1ve41"); 
		mysql_select_db("light_information") or die(mysql_error());
	}
	connectToDatabase();
	//If IE	
	//If IE
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        $html5Shiv = '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
    else
        $html5Shiv = '';

	#nl2p
	function nl2p($string, $line_breaks = true, $xml = true){
		// Remove existing HTML formatting to avoid double-wrapping things
		$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true)
			return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
		else 
			return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
	}
 
	#Get information
	//Select Record
	$query = 'SELECT * FROM `Lighthouses` WHERE Name="'.$Title.'"';
	$data = mysql_query ($query) or die (mysql_error());
	if(mysql_num_rows($data) === 0){
			$Title = str_replace(" ", "-", $Title);
			$query = 'SELECT * FROM `Lighthouses` WHERE Name="'.$Title.'"';
			$data = mysql_query ($query) or die (mysql_error());
			if(mysql_num_rows($data) === 0)
			{
				header('Location:http://www.worldwidelighthouses.com');
				exit;			
			}
	}
	//Get Records Data
	$TypeOfPage=mysql_result($data, 0,"PageType");
	$Established=mysql_result($data, 0,"DateEstablished");
	$CurrentLighthouseBuilt=mysql_result($data, 0, "DateCurrentLighthouseBuilt");
	$Height=mysql_result($data, 0,"Height");
	$Automated=mysql_result($data, 0,"DateAutomated");
	$Electrified=mysql_result($data, 0,"DateElectrified");
	$Range=mysql_result($data, 0, "Ranges");
	$Operator=mysql_result($data,0 , "Operator");
	$writeUp=mysql_result($data,0,"Writeup");
	$mainPagePictureURL=mysql_result($data,0,"MainPicture");
	$VideoLink=mysql_result($data,0,"URLVideo");
	$AudioLink=mysql_result($data,0,"URLAudio");
	$Designer = mysql_result($data,0,"Designer");
	$SmallImages = mysql_result($data, 0, "SmallImages");
	$LargeImages = mysql_result($data, 0, "LargeImages");
	
	
	$LargeImagesArray = json_decode($LargeImages);
	$SmallImagesArray = json_decode($SmallImages);
	
	$LightName = str_replace(' Lighthouse', '',$Title);
	$LightName = str_replace(' ','-',$LightName);
	#Process Information
	//What colour should the page be?
	switch ($TypeOfPage){
	case $TypeOfPage==="walestrinityhouse";
		$colour = 'gold';
		$type = 'Trinity-House-Owned';
		break;
	
	case $TypeOfPage==="walesprivate";
		$colour = 'blue';
		$type = 'Privately-Owned';
		break;
	}
	//Should Information if it Isnt Blank
	//Make text data NFC compliant by making spaces into %20's.
	$DesignerNFC = str_replace(' ','%20',$Designer);
	$OperatorNFC = str_replace(' ','%20',$Operator);
	$TitleNFC = str_replace(' ','%20', $Title);
		
	if($Established != 0)
	{
		$Established = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Established&amp;Data='.$Established.'">Established: '.$Established.'</a></p>';
	}
	else
	{
		$Established = "";
	}

	if($CurrentLighthouseBuilt != 0)
	{
		$CurrentLighthouseBuilt = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=CurrentLighthouseBuilt&amp;Data='.$CurrentLighthouseBuilt.'">Current Lighthouse Built: '.$CurrentLighthouseBuilt.'</a></p>';
	}
	else
	{
		$CurrentLighthouseBuilt = "";
	}
	
	if($Height != 0){
		//Make height into feet, and then display the feet in 2 decimal place format. 
		$heightInFeet = $Height / 0.3048;
		$heightInFeet = round($heightInFeet,2);
		$Height = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Height&amp;Data='.$Height.'">Height: '.$Height.' Metres ('.$heightInFeet.' Feet)</a></p>';
	}
	else
	{
		$Height = "";
	}
	
	//Show Ranges
	$DeJSONedRanges = json_decode($Range, true);
	
	unset($Value);
	$Range = "<h3>Light Information</h3><hr>";
	foreach($DeJSONedRanges as &$Value)
	{
		if($Value["Colour"] != "")
		{
			$Range = $Range.'<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Range&amp;Data='.$Value["Distance"].'">'.$Value["Colour"].': '.$Value["Distance"]." Nautical Miles";
			if($Value["ArcStart"] != "" && $Value["ArcEnd"] != "")
			{
				$Range = $Range." Between (".$Value["ArcStart"]."&deg;) and (".$Value["ArcEnd"]."&deg;)";
			}
			$Range = $Range."</a></p>";
		}
	}
	Unset($Value);


	if($Designer != ''){$Designer = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Designer&amp;Data='.$DesignerNFC.'">Designer: '.$Designer.'</a></p>';}
	if($Automated != 0){
		if($Automated === '9999'){$Automated = 'Never Automated';}
		$Automated = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Automated&amp;Data='.$Automated.'">Automated: '.$Automated.'</a></p>';
	}
	else
	{
		$Automated = "";
	}
	
	if($Electrified != 0){
		if($Electrified === '9999'){$Electrified = 'Never Electrified';}
		$Electrified = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Electrified&amp;Data='.$Electrified.'">Electrified: '.$Electrified.'</a></p>';
	}
	else
	{
		$Electrified = "";	
	}	
	if($Operator != ''){
		$Operator = '<p><a href="http://www.worldwidelighthouses.com/Find-Similar.php?RefPage='.$TitleNFC.'&amp;Attribute=Operator&amp;Data='.$OperatorNFC.'">Operator: '.$Operator.'</a></p>';		
	}

	//Should We Show Media?
	if ($VideoLink != 'None' || $AudioLink != 'None'){
		if($VideoLink != ''){
			$VideoLink = '<a href="'.$VideoLink.'"><img src="http://www.worldwidelighthouses.com/resources/layout-resources/play-'.$colour.'.png" alt="Play Video"><br>Video</a>';
		}	
		if($AudioLink != ''){
			$AudioLink = '<a href="'.$AudioLink.'"><img src="http://www.worldwidelighthouses.com/resources/layout-resources/play-'.$colour.'.png" alt="Play Audio"><br>Audio</a>';
		}
		if(mobile_device_detect(true,true,true,true,true,true,true,false,false))
		{
			if($AudioLink != '' || $VideoLink != '')
			{		
				$mediaBox = '<div class="'.$colour.'Textbox"><h3>Media</h3><hr>'.$VideoLink.$AudioLink.'</div>';
			}
		}
		else {
			if($AudioLink != '' || $VideoLink != '')
			{		
				$mediaBox = '<div class="'.$colour.'Textbox"><h3>Media</h3><hr>'.$VideoLink.$AudioLink.'</div>';
			}
		}
	}	
	//Make the writeUp HTML
	$writeUp = nl2p($writeUp,false);
	
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false)){
		#Mobile Version of Site
			#Optimize Images
				//Main Image
					$mainPagePictureLocal = str_replace('http://www.worldwidelighthouses.com/','../../',$mainPagePictureURL);
					$mobileMainPagePictureURL = str_replace('Main-Page-Pictures/','Main-Page-Pictures/Mobile-Versions/',$mainPagePictureLocal);
						if(!file_exists($mobileMainPagePictureURL)) {
							$mainPageImage = Wideimage::load($mainPagePictureURL)->resize(290)-> saveToFile($mobileMainPagePictureURL,6);
						}
				//Thumbnails
						/*$i = 0;
						while($NumberOfThumbnails > $i) {
							$i++;
							$Thumbnail = 'Thumbnail'.$i;
							$ThumbnailURL = mysql_result($data,0,$Thumbnail); 
								$localThumbnailURL = str_replace('http://www.worldwidelighthouses.com/','../../',$ThumbnailURL);
								$mobileThumbnailURL = str_replace('Mini/','Mini/Mobile-Version/',$localThumbnailURL);
								if(!file_exists($mobileThumbnailURL)){
									$miniFolderLocation = 'Images/Lighthouses/'.$LightName.'/Mini'; 
									$mobileThumbsLocation = $miniFolderLocation.'/Mobile-Version';
									if(!file_exists($miniFolderLocation)){
										mkdir($miniFolderLocation,0777);
										mkdir($mobileThumbsLocation,0777);
									}
									if(!file_exists($mobileThumbsLocation)){
										mkdir($mobileThumbsLocation,0777);	
									}
								$thumbnail = Wideimage::load($ThumbnailURL)->resize(290)->saveToFile($mobileThumbnailURL,6);
								}
							$thumbnailCode .= '<li><img src="'.$mobileThumbnailURL.'" width="290" height="134" alt="'.$Title.' Lighthouse - Thumbnail '.$i.'"></li>';
						}
						if($NumberOfThumbnails != 0) {
							$thumbnailCode = '<ul id="thumbnails">'.$thumbnailCode.'</ul>';	
						}
						*/
			#Mobile HTML5 Code
			$content = '		<a href="English-Lighthouses.php" id="button">&#171; Back to English Lighthouses</a>
								<h2 class="'.$colour.'Title">'.$Title.' Lighthouse</h2>
								<div id="mainImage"><img src="'.$mobileMainPagePictureURL.'" alt="'.$Title.'" width="290px" height="270"></div>
								<div id="Sidebar">
								<div class="'.$colour.'Sidebox">
									<h3>Information</h3>
									<hr>
									'.$Established.$CurrentLighthouseBuilt.$Height.$Automated.$Electrified.$Operator.$Designer.'								</div>
								'.$mediaBox.'
								</div>
								<div class="'.$colour.'Sidebox">
									'.$Range.'
								</div>
	
								<div class="'.$colour.'Textbox">'.$writeUp.'</div>
								'.$thumbnailCode;
								
			$pageCode = '
				<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="../../../resources/css/mobilePageLayout.css">
							<title>'.$Title.' Lighthouse | Worldwide Lighthouses</title>
						</head>
						<body>
							<header> 
								<h1 id="logo"><a href="http://www.worldwidelighthouses.com">WWLH</a></h1>
								<form method="GET" action="http://www.worldwidelighthouses.com/Search.php">
									<input type="hidden" name="search" value="1"> 
									<input type="search" placeholder="Search" name="query" id="query">
									<input type="submit" value="Go">
								</form>
							</header>
							<nav>
								<ul>
									<li id="home"><a href="http://www.worldwidelighthouses.com/V8/Index.php"><p>Home</p></a></li>
									<li id="lighthouses"><a href="http://www.worldwidelighthouses.com/V8/Lighthouses/Index.php"><p>Lighthouses</p></a></li>
									<li id="lightships"><a href="http://www.worldwidelighthouses.com/V8/Lightships/Index.php"><p>Lightships</p></a></li>
									<li id="fog-signals"><a href="http://www.worldwidelighthouses.com/V8/Fog-Signals/Index.php"><p>Fog Signals</p></a></li>
									<li id="daymarks"><a href="http://www.worldwidelighthouses.com/V8/Daymarks/Index.php"><p>Daymarks</p></a></li>
									<li id="buoys"><a href="http://www.worldwidelighthouses.com/V8/Buoys/Index.php"><p>Buoys</p></a></li>
									<li id="glossary"><a href="http://www.worldwidelighthouses.com/V8/Glossary/Index.php"><p>Glossary</p></a></li>
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
									<p><a href="http://www.worldwidelighthouses.com/V8/About/Index.php">About | </a> <a href="http://www.worldwidelighthouses.com/V8/Contact/Index.php">Contact | </a><a href="http://www.worldwidelighthouses.com/V8/Use-Our-Media/Index.php">Use our Media</a>
								<button id="toTop">Back To Top</button>
								<p>&#169; Worldwide Lighthouses '.date('Y').'</p>
							</footer>
							<script async src="http://www.worldwidelighthouses.com/V8/resources/js/mobile.js"></script>
						</body>
			';
	}
		#DESKTOP
		else {	
			if(!empty($SmallImagesArray))
			{
				$thumbnailCode = "<ul>";
				$i = 0;
				foreach($SmallImagesArray as &$Value)
				{
					$thumbnailCode = $thumbnailCode.'<li><a href="'.$LargeImagesArray[$i].'" target="_blank"><img width="430" height="200" alt="'.$Title.' Lighthouse - Thumbnail '.$i.'" src="'.$Value.'"></a></li>';
					$i++;	
				}
				$thumbnailCode = $thumbnailCode."</ul>";
			}
			$content = '<h2 class="'.$colour.'Title">'.$Title.' Lighthouse</h2>
						<div id="mainImage"><img src="'.$mainPagePictureURL.'" alt="'.$Title.'" width="597" height="557"></div>
						<div class="'.$colour.'Sidebox">
							<h3>General Information</h3>
							<hr>
							'.$Established.$CurrentLighthouseBuilt.$Height.$Automated.$Electrified.$Operator.$Designer.'
						</div>
						<div class="'.$colour.'Sidebox">
							'.$Range.'
						</div>
						<div class="'.$colour.'Textbox">'.$writeUp.'</div>
						'.$mediaBox.$thumbnailCode;
			
			$pageCode = '
			<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<link rel="stylesheet" href="../../../resources/css/desktopPageLayout.css">
							'.$html5Shiv .'
							<title>'.$Title.' Lighthouse | Worldwide Lighthouses</title>
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
									<li id="home"><a href="../../../Index.php"><p>Home</p></a></li>
									<li id="lighthouses"><a href="../../../Lighthouses/Index.php"><p>Lighthouses</p></a></li>
									<li id="lightships"><a href="../../../Lightships/Index.php"><p>Lightships</p></a></li>
									<li id="fog-signals"><a href="../../../Fog-Signals/Index.php"><p>Fog Signals</p></a></li>
									<li id="daymarks"><a href="../../../Daymarks/Index.php"><p>Daymarks</p></a></li>
									<li id="buoys"><a href="../../../Buoys/Index.php"><p>Buoys</p></a></li>
									<li id="glossary"><a href="../../../Glossary/Index.php"><p>Glossary</p></a></li>
								</ul>
							</nav>
							<article>
							'.$content.'
							</article>
							<footer>
								<div id="links">
									<ul>
										<li><a href="../../../Contact">Contact</a></li>
										<li><a href="../../../Use-Our-Media">Use our Media</a></li>
									</ul>
								</div>
								<div id="newsletterSignup">
									<form method="post" action="http://www.worldwidelighthouses.com/Newsletter/Join.php">
										<input type="email" name="email" placeholder="Enter your email address">
										<input type="submit" value="Sign up!"> 
									</form>
								</div>
								<p>&#169; Worldwide Lighthouses 2011</p>
							</footer>
							'.$html5Shiv.'
						<script src="../../../resources/js/desktop.js"></script>
						</body>
			';	
	}
			//Remove all whitespace from code. Making it smaller AND echo code dependent on AJAX
			if ($ajax == '1') {
				$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
				$content = trim($content);
				echo $content.'<script>document.title="'.$Title.' Lighthouse | Worldwide Lighthouses";</script>';
				}
			else {			
				$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
				$pageCode = trim($pageCode);
				echo $pageCode;
			}	
?>	