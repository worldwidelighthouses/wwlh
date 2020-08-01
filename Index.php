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
        $html5Shiv = '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
	//Get number of each type of Light
		connectToDatabase();
#			$fogSignals = mysql_query('SELECT * FROM `Fog-Signals`');
#			$lightships = mysql_query('SELECT * FROM `Lightships`');
			$lighthouses = mysql_query('SELECT * FROM `Lighthouses`');
#				
#				$numberOfFogSignals = mysql_num_rows($fogSignals);
#				$numberOfLightships = mysql_num_rows($lightships);
				$numberOfLighthouses = mysql_num_rows($lighthouses);
#		
					$totalPages = $numberOfFogSignals + $numberOfLighthouses + $numberOfLightships;
	
	//Mobile Front Page
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
							<link rel="stylesheet" href="resources/css/mobilePageLayout.css">
							<title>Welcome | Worldwide Lighthouses</title>
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
								<form method="post" action="http://www.worldwidelighthouses.com/Sign-Up.php">
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
		//Show 5 randomly selected Lighthouses
			#$random = mysql_query('SELECT * FROM `Lighthouses`, `Lightships`, `Fog-Signals` ORDER BY RAND() LIMIT 5') or die(mysql_error());
			#	$i = 0;
				#	while ($i < 5) {
				#		$lightname = mysql_result($random, $i,"Name");
				#		$lightthumb = mysql_result($random, $i,"SelectionImage");
				#		$lightlink = mysql_result($random, $i,"PageLocation");
				#		$lightname = str_replace ('Lighthouse',' ',$lightname);
				#		$randomLights.='<li><a href="'.$lightlink.'"><img src="'.$lightthumb.'" width="150" height="137"><br>'.$lightname.'</a></li>';
					#	$i++;
					#}
					
		//Show the 5 newest updates	
			/*
				$newestSQL = 'SELECT * FROM `Lighthouses`, `Lightships`, `Fog-Signals` ORDER BY dateModified ASC LIMIT 5';
				$newest = mysql_query($newestSQL) or die(mysql_error());
				$i = 0;
					while ($i < 5) {
							$lightname = mysql_result($newest, $i,"Name");
							$lightthumb = mysql_result($newest, $i,"SelectionImage");
							$lightlink = mysql_result($newest, $i,"PageLocation");
							$lightname = str_replace ('Lighthouse',' ',$lightname);
							$newestLights.='<li><a href="'.$lightlink.'"><img src="'.$lightthumb.'"><br>'.$lightname.'</a></li>';
							$i++;
					}	
				*/
		$content = '<h2 class="greenTitle">Welcome to Worldwide Lighthouses</h2>
			   	    <img src="http://www.worldwidelighthouses.com/resources/layout-resources/indexPicture.jpg" width="876" height="439" alt="Welcome">
					<div class="greenTextbox">
						<p>Welcome to Worldwide Lighthouses, the number one website for Lighthouse Facts, Pictures, Information and Videos. To begin using the site hit the links above or choose a randomly selected Lighthouse below, or look at the most recently added to the site.</p>
						<p>We currently have information about and pictures and videos of '.$numberOfLighthouses.' Lighthouses, '.$numberOfLightships.' Lightships and '.$numberOfFogSignals.' Fog Signals - a total of '.$totalPages.' pages!</p>
						<!--<h2>Random Lighthouses, Lightships and Fog Signals</h2>
						<ul class="gallery">
							'.$randomLights.'
						</ul> -->

					</div>
		';
	
		$pageCode =
		'<!DOCTYPE HTML>
				<html lang="en-GB">
					<head>	
						<meta name="author" content="Worldwide Lighthouses">
						<meta name="keywords" content="Lighthouses,Lightships,Trinity House,Fog Signals,Fog Horns,Fresnel">
						<meta name="description" content="Worldwide Lighthouses is the number 1 source of information, pictures and	 videos on the Subject of Lighthouses and Lightships">
						<link rel="stylesheet" href="resources/css/desktopPageLayout.css">
						<title>Welcome | Worldwide Lighthouses</title>
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
									<form method="post" action="http://www.worldwidelighthouses.com/Sign-Up.php">
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
		//Remove all whitespace from code. Making it smaller AND echo code dependent on AJAX
			if ($ajax == '1') {
				$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
				$content = trim($content);
				echo $content.'<script>document.title="Welcome | Worldwide Lighthouses";</script>';
			}
			else {			
				$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
				$pageCode = trim($pageCode);
				echo $pageCode;
			}	
?>