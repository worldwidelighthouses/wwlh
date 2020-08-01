<?php
	$ajax = $_POST['AJAX'];
	$ID = $_POST['Name'];
	
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');
	
	//If IE
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        $html5Shiv = '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
    else
        $html5Shiv = '';
	
	if(empty($ID))
	{
		$content = '
		<h2 class="greenTitle">Create Page</h2>
		<div class="greenTextbox">
		<h3>Basics</h3>
		<form name="pageCreateEdit" enctype="multipart/form-data" action="http://www.worldwidelighthouses.com/Admin/Admin_backend.php" method="post">
			<label for="LightName">Name:</label>
			<input type="text" name="LightName" id="LightName" required="required">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
	
			<label for="PageType">Page Type</label>
			<select name="PageType" id="PageType">
				<optgroup label="English">
					<option value="englandtrinityhouse">Trinity House Lighthouse</option>
					<option value="englandprivate">Privately Owned Lighthouse</option>
					<option>Trinity House Lightship</option>
					<option>Privately Owned Lightship</option>
				</optgroup>
<optgroup label="Welsh">
              <option value="walestrinityhouse">Trinity House Lighthouse</option>
              <option value="walesprivate">Privately Owned Lighthouse</option>
</optgroup>
<optgroup label="Ireland">
              <option value="irelandCIL">CIL</option>
              <option value="irelandprivate">Privately Owned Lighthouse</option>
</optgroup>
				<optgroup label="Scottish">
					<option value="scotlandNLB">Northern Lighthouse Board Lighthouse</option>
					<option value="scotlandprivate">Privately Owned Lighthouse</option>
					<option>Privately Owned Lightship</option>
				</optgroup>
				<optgroup label="French">
					<option>Bureau des Phares et Balises Lighthouse</option>
					<option>Privately Owned Lighthouse</option>
					<option>Bureau des Phares et Balises Lightship</option>
					<option>Privately Owned Lightship</option>
				</optgroup>
				<optgroup label="Switzerland">
					<option>Privately Owned Lighthouse</option>
				</optgroup>
			</select>
			<h3>Images</h3>
			<label for="MainPagePicture">Main Page Picture</label>
			<input type="file" name="MainPagePicture" id="MainPagePicture" required="required">
			
			<label for="ThumbnailImage">Thumbnail Image</label>
			<input type="file" name="ThumbnailImage" id="ThumbnailImage" required="required">
			
			<h3>Sidebar Information</h3>
			<label for="DateEstablished">Established</label>
			<input type="number" maxlength="4" name="DateEstablished" id="DateEstablished">
			
			<label for="DateCurrentLighthouseBuilt">Current Lighthouse Built</label>
			<input type="number" maxlength="4" name="DateCurrentLighthouseBuilt" id="DateCurrentLighthouseBuilt">
			
			<label for="DateElectrified">Electrified</label>
			<input type="number" maxlength="4" name="DateElectrified" id="DateElectrified">
			
			<label for="DateAutomated">Automated</label>
			<input type="number" maxlength="4" name="DateAutomated" id="DateAutomated">
			
			<label for="DateDecomissioned">Decomissioned</label>
			<input type="number" maxlength="4" name="DateDecomissioned" id="DateDecomissioned">
			
			<label for="DateDemolished">Demolished</label>
			<input type="number" maxlength="4" name="DateDemolished" id="DateDemolished">
			
			<label for"Height">Height</label>
			<input type="text" id="Height" name="Height">
			
			<label for="Operator">Operator</label>
			<input type="text" name="Operator" id="Operator">
			
			<label for="Designer">Designer</label>
			<input type="text" name="Designer" id="Designer">
			
			<label for="URLVideo">Video Link</label>
			<input type="url" name="URLVideo" id="URLVideo">
			
			<label for="URLAudio">Audio Link</label>
			<input type="url" name="URLAudio" id="URLAudio">
			
			<h3>Light Information</h3>
			<table>
				<tr>
					<td>Light Name</td>
					<td>Distance</td>
					<td>Arc Start</td>
					<td>Arc End</td>
				</tr>
				<tr>
					<td><input type="text" name="Color1"></td>
					<td><input type="number" name="Distance1" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart1" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd1" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color2"></td>
					<td><input type="number" name="Distance2" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart2" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd2" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color3"></td>
					<td><input type="number" name="Distance3" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart3" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd3" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color4"></td>
					<td><input type="number" name="Distance4" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart4" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd4" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color5"></td>
					<td><input type="number" name="Distance5" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart5" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd5" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color6"></td>
					<td><input type="number" name="Distance6" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart6" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd6" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color7"></td>
					<td><input type="number" name="Distance7" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart7" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd7" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color8"></td>
					<td><input type="number" name="Distance8" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart8" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd8" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color9"></td>
					<td><input type="number" name="Distance9" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart9" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd9" maxlength="3" size="3">&#176;</td>
				</tr>
				<tr>
					<td><input type="text" name="Color10"></td>
					<td><input type="number" name="Distance10" maxlength="2" size="2"> Nautical Miles</td>
					<td><input type="number" name="ArcStart10" maxlength="3" size="3">&#176;</td>
					<td><input type="number" name="ArcEnd10" maxlength="3" size="3">&#176;</td>
				</tr>
			</table>
			
			<label for="WriteUp"><h3>Write Up</h3></label>
			<textarea name="WriteUp" id="WriteUp"></textarea>
			
			<label for="NumberOfThumbnails"><h3>Number Of Thumbnails</h3></label>
			<input type="number" name="NumberOfThumbnails" id="NumberOfThumbnails">
					
			<input type="submit" value="Upload Page and Images">
		</form>
		</div>';
	}
	else
	{
		function ConnectToDB()
		{
			$link = mysql_connect('worldwidelighthouses.fatcowmysql.com', 'ww_lighthouses11', '14c@rtmeldr1ve41'); 
			
			if (!$link) 
			{ 
				die('Could not connect: ' . mysql_error()); 
			}
			  
			mysql_select_db(light_information);
		}
		ConnectToDB();
		
		$thisLight = mysql_query("SELECT * FROM `Lighthouses` WHERE `ID`=".$ID) or die(mysql_error());
		
		$Name = mysql_result($thisLight, 0, "Name");
		$thisType = mysql_result($thisLight, 0, "PageType");
		$MainPagePicture = mysql_result($thisLight, 0, "MainPicture");
		$Thumbnail = mysql_result($thisLight, 0, "Thumbnail");
		$Established = mysql_result($thisLight, 0, "DateEstablished");
		$CurrentLighthouseBuilt = mysql_result($thisLight, 0, "DateCurrentLighthouseBuilt");
		
		$DateAutomated = mysql_result($thisLight, 0, "DateAutomated");
		$Height = mysql_result($thisLight, 0, "Height");
		$Operator = mysql_result($thisLight, 0, "Operator");
		$Designer = mysql_result($thisLight, 0, "Designer");
		$URLVideo = mysql_result($thisLight, 0, "URLVideo");
		$URLAudio = mysql_result($thisLight, 0, "URLAudio");
		$WriteUp = mysql_result($thisLight, 0, "WriteUp");
		
		$SmallImages = mysql_result($thisLight, 0, "SmallImages");
		$SmallImages = json_decode($SmallImages);
		
		$NumberImages = 0;
		foreach($SmallImages as &$Value)
		{
			$NumberImages++;
		}
		
		
		$content = '
			<h2 class="greenTitle">Edit the '.$Name.' Page</h2>
			<div class="greenTextbox">
			<h3>Basics</h3>
			<form name="pageCreateEdit" enctype="multipart/form-data" action="http://www.worldwidelighthouses.com/Admin/Admin_backend.php" method="post">
				<label for="LightName">Name:</label>
				<input type="text" name="LightName" id="LightName" required="required" value="'.$Name.'">
				<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
		
				<label for="PageType">Page Type</label>
				<select name="PageType" id="PageType">
					<option value="'.$thisType.'">Current Selection</option>
					<optgroup label="English">
						<option value="englandtrinityhouse">Trinity House Lighthouse</option>
						<option value="englandprivate">Privately Owned Lighthouse</option>
						<option>Trinity House Lightship</option>
						<option>Privately Owned Lightship</option>
					</optgroup>
					<optgroup label="Scottish">
						<option>Northern Lighthouse Board Lighthouse</option>
						<option>Privately Owned Lighthouse</option>
						<option>Privately Owned Lightship</option>
					</optgroup>
					<optgroup label="French">
						<option>Bureau des Phares et Balises Lighthouse</option>
						<option>Privately Owned Lighthouse</option>
						<option>Bureau des Phares et Balises Lightship</option>
						<option>Privately Owned Lightship</option>
					</optgroup>
					<optgroup label="Switzerland">
						<option>Privately Owned Lighthouse</option>
					</optgroup>
					<optgroup label="Wales">
						<option
						<option>Privately Owned Lighthouse</option>
					</optgroup>
					<optgroup label="Ireland">
						<option>Privately Owned Lighthouse</option>
					</optgroup>

				</select>
				<h3>Images</h3>
				<label for="MainPagePicture">Main Page Picture</label>
				<img src="'.$MainPagePicture.'">
				<input type="file" name="MainPagePicture" id="MainPagePicture" required="required">
				
				<label for="ThumbnailImage">Thumbnail Image</label>
				<img src="'.$Thumbnail.'">
				<input type="file" name="ThumbnailImage" id="ThumbnailImage" required="required">
				
				<h3>Sidebar Information</h3>
				<label for="DateEstablished">Established</label>
				<input type="number" maxlength="4" name="DateEstablished" id="DateEstablished" value="'.$Established.'">
				
				<label for="DateCurrentLighthouseBuilt">Current Lighthouse Built</label>
				<input type="number" maxlength="4" name="DateCurrentLighthouseBuilt" id="DateCurrentLighthouseBuilt" value="'.$CurrentLighthouseBuilt.'">
				
				<label for="DateElectrified">Electrified</label>
				<input type="number" maxlength="4" name="DateElectrified" id="DateElectrified" value="'.$CurrentLighthouseBuilt.'">
				
				<label for="DateAutomated">Automated</label>
				<input type="number" maxlength="4" name="DateAutomated" id="DateAutomated" value="'.$DateAutomated.'">
				
				<label for="DateDecomissioned">Decomissioned</label>
				<input type="number" maxlength="4" name="DateDecomissioned" id="DateDecomissioned" value="'.$Decomissioned.'">
				
				<label for="DateDemolished">Demolished</label>
				<input type="number" maxlength="4" name="DateDemolished" id="DateDemolished" value="'.$Demolished.'">
				
				<label for"Height">Height</label>
				<input type="text" id="Height" name="Height" value="'.$Height.'">
				
				<label for="Operator">Operator</label>
				<input type="text" name="Operator" id="Operator" value="'.$Operator.'">
				
				<label for="Designer">Designer</label>
				<input type="text" name="Designer" id="Designer" value="'.$Designer.'">
				
				<label for="URLVideo">Video Link</label>
				<input type="url" name="URLVideo" id="URLVideo" value="'.$URLVideo.'">
				
				<label for="URLAudio">Audio Link</label>
				<input type="url" name="URLAudio" id="URLAudio" value="'.$URLAudio.'">
				
				<h3>Light Information</h3>
				<table>
					<tr>
						<td>Light Name</td>
						<td>Distance</td>
						<td>Arc Start</td>
						<td>Arc End</td>
					</tr>
					<tr>
						<td><input type="text" name="Color1"></td>
						<td><input type="number" name="Distance1" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart1" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd1" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color2"></td>
						<td><input type="number" name="Distance2" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart2" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd2" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color3"></td>
						<td><input type="number" name="Distance3" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart3" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd3" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color4"></td>
						<td><input type="number" name="Distance4" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart4" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd4" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color5"></td>
						<td><input type="number" name="Distance5" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart5" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd5" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color6"></td>
						<td><input type="number" name="Distance6" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart6" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd6" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color7"></td>
						<td><input type="number" name="Distance7" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart7" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd7" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color8"></td>
						<td><input type="number" name="Distance8" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart8" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd8" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color9"></td>
						<td><input type="number" name="Distance9" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart9" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd9" maxlength="3" size="3">&#176;</td>
					</tr>
					<tr>
						<td><input type="text" name="Color10"></td>
						<td><input type="number" name="Distance10" maxlength="2" size="2"> Nautical Miles</td>
						<td><input type="number" name="ArcStart10" maxlength="3" size="3">&#176;</td>
						<td><input type="number" name="ArcEnd10" maxlength="3" size="3">&#176;</td>
					</tr>
				</table>
				
				<label for="WriteUp"><h3>Write Up</h3></label>
				<textarea name="WriteUp" id="WriteUp">'.$WriteUp.'</textarea>
				
				<input type="hidden" name="EditType" value="Edit">
				<input type="hidden" name="EditID" value="'.$ID.'">
				<label for="NumberOfThumbnails"><h3>Number Of Thumbnails</h3></label>
				<input type="number" name="NumberOfThumbnails" id="NumberOfThumbnails" value="'.$NumberImages.'">
						
				<input type="submit" value="Upload Page and Images">
			</form>
			</div>';
	}
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
							<link rel="stylesheet" href="../resources/css/mobilePageLayout.css">
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
						<title>Welcome | Worldwide Lighthouses</title>
						<style>
							article label, article textarea
							{
								display:block;
								width:98%;			
							}
							textarea
							{
								height:200px;
							}
							table input[type=number]
							{
								width:60px;
							}
							td
							{
								padding:5px;
							
							}
						</style>

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