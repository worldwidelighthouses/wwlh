<?php
	$ajax = $_POST['AJAX'];
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');
	
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
	
	$content = '
		<h2 class="greenTitle">Daymarks</h2>
		<div class="greenTextbox">
			<p>Select the country for which you are interested in looking at daymarks from. Alternatively you could use the search function in the header to find a specific lighthouse</p>
			<ul class="gallery">
				<li>
					<!--<a href="http://www.worldwidelighthouses.com/Lighthouses/English-Lightships.php">-->
					<img src="http://www.worldwidelighthouses.com/resources/images/thumbnails/england.png" width="149" height="137" alt="English Lightships">
					<br>England</a>
				</li>
				<li>
					<!--<a href="http://www.worldwidelighthouses.com/Lighthouses/Welsh-Lightships.php">-->
					<img src="http://www.worldwidelighthouses.com/resources/images/thumbnails/wales.png" width="149" height="137" alt="Welsh Lightships">
					<br>Wales</a>
				</li>
				<li>
					<!--<a href="http://www.worldwidelighthouses.com/Lighthouses/Scottish-Lightships.php">-->
					<img src="http://www.worldwidelighthouses.com/resources/images/thumbnails/scotland.png" width="149" height="137" alt="Scottish Lightships">
					<br>Scotland</a>
				</li>
			</ul>
		</div>
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
							<title>Daymarks | Worldwide Lighthouses</title>
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
						<title>Daymarks | Worldwide Lighthouses</title>
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
	if ($ajax == '1') {
		$content = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $content);
		$content = trim($content);
		echo $content.'<script>document.title="English Daymarks | Worldwide Lighthouses";</script>';
	}
	else {			
		$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
		$pageCode = trim($pageCode);
		echo $pageCode;
	}	
?>