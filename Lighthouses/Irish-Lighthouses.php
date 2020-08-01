<?php
	$ajax = $_POST['AJAX'];
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');
	
	//Functions
	function connectToDatabase()
	{
		mysql_connect("worldwidelighthouses.fatcowmysql.com", "ww_lighthouses11", "14c@rtmeldr1ve41"); 
		mysql_select_db("light_information") or die(mysql_error());
	}
	connectToDatabase();
	
	//If IE
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        $html5Shiv = '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
    else
        $html5Shiv = '';
		
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false)){
		$thumbnailWidth = '80';
		$thumbnailHeight = '76.8';				
	}
	else {
		$thumbnailWidth = '149';
		$thumbnailHeight = '137';	
	}
	
		
	#Make List
	//Trinity House
	$cilLighthouses = mysql_query('SELECT * FROM `Lighthouses` WHERE PageType="irelandCIL" ORDER BY Name ASC') or die(mysql_error());
	$numberOfCILLighthouses = mysql_num_rows($cilLighthouses);
	
	$i=0;
	while($i < $numberOfCILLighthouses) {
		$lightName = mysql_result($cilLighthouses,$i,"Name");
		$hyphenName = str_replace(' ', '-',$lightName);
		$shortName = str_replace('Lighthouse','',$lightName);
		$lightThumbnail = mysql_result($cilLighthouses,$i,"Thumbnail");
		$lightURL = 'http://www.worldwidelighthouses.com/Lighthouses/Irish-Lighthouses/Commision-Irish-Lights/'.$hyphenName;
		$trinityHouseLighthousesHTML .= '<li><a href="'.$lightURL.'"><img src="'.$lightThumbnail.'" width="'.$thumbnailWidth.'" height="'.$thumbnailHeight.'"><br>'.$shortName.'</a></li>';
		$i++;
	}
	
	//Privately Owned
	$privateLighthouses = mysql_query('SELECT * FROM `Lighthouses` WHERE PageType="irelandprivate" ORDER BY Name ASC');
	$numberOfPrivateLighthouses = mysql_num_rows($privateLighthouses);
	
	$i=0;
	while($i < $numberOfPrivateLighthouses) {
		$lightName = mysql_result($privateLighthouses,$i,"Name");
		$hyphenName = str_replace(' ','-',$lightName);
		$shortName = str_replace('Lighthouse','',$lightName);
		$lightThumbnail = mysql_result($privateLighthouses,$i,"Thumbnail");
		$lightURL = 'http://www.worldwidelighthouses.com/Lighthouses/Irish-Lighthouses/Privately-Owned/'.$hyphenName;
		$privateLighthousesHTML .= '<li><a href="'.$lightURL.'"><img src="'.$lightThumbnail.'" width="'.$thumbnailWidth.'" height="'.$thumbnailHeight.'"><br>'.$shortName.'</a></li>';
		$i++;
	}
	
	$content = '
		<h2 class="turquoiseTitle">Irish Lighthouses</h2>
		<div class="turquoiseTextbox"><p>Irelands main lighthouse authority is the Commissioners of Irish Lights, you can see their lighthouses in turquoise. Privately owned scottish lighthouses are in blue.</p></div>
		<h2 class="turquoiseTitle">Commission of Irish Lights Lighthouses</h2>
		<div class="turquoiseTextbox"><ul class="gallery">'.$trinityHouseLighthousesHTML.'</ul></div>
		<h2 class="blueTitle">Privately Owned Lighthouses</h2>
		<div class="blueTextbox"><ul class="gallery">'.$privateLighthousesHTML.'</ul></div>
	';
	
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false)){
		$pageCode = '<!DOCTYPE HTML>
					<html lang="en-GB">
						<head>	
							<meta name="author" content="Worldwide Lighthouses">
							<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
							<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
							<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
							<link rel="stylesheet" href="../resources/css/mobilePageLayout.css">
							<title>Irish Lighthouses | Worldwide Lighthouses</title>
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
									<p><a href="../About/Index.php">About | </a> <a href="Contact/Index.php">Contact | </a><a href="Use-Our-Media/Index.php">Use our Media</a>
								<button id="toTop">Back To Top</button>
								<p>&#169; Worldwide Lighthouses '.date('Y').'</p>
							</footer>
							<script async src="../resources/js/mobile.js"></script>
						</body>';				
	}
	else {
		$pageCode = '<!DOCTYPE HTML>
				<html lang="en-GB">
					<head>	
						<meta name="author" content="Worldwide Lighthouses">
						<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
						<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
						<link rel="stylesheet" href="../resources/css/desktopPageLayout.css">
						<title>Irish Lighthouses | Worldwide Lighthouses</title>
						'.$html5Shiv.'
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
	if ($ajax == '1') {
		$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
		$content = trim($content);
		echo $content.'<script>document.title="Irish Lighthouses | Worldwide Lighthouses";</script>';
	}
	else {			
		$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
		$pageCode = trim($pageCode);
		echo $pageCode;
	}	
?>