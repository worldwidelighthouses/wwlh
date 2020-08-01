<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');

	$Name = $_GET['name'];
	$NumberImages = $_GET['numberImages'];
	
	$FirstSetNumber = 1;
	$SecondSetNumber = 2; 
	
	$uploading = $_POST['Uploading'];
	
	if($uploading  == "true")
	{
		$FirstSetNumber = $_POST['FirstSetNumber'];
		$SecondSetNumber = $_POST['SecondSetNumber'];

		$Name = $_POST['Name'];
		$NumberImages = $_POST['NumberImages'];
		
		function connectToDatabase()
		{
			mysql_connect("worldwidelighthouses.fatcowmysql.com", "ww_lighthouses11", "14c@rtmeldr1ve41"); 
			mysql_select_db("light_information") or die(mysql_error());
		}
		connectToDatabase();
		
		$query = mysql_query('SELECT * FROM Lighthouses WHERE Name="'.$Name.'"') or die(mysql_error());

		$PageType = mysql_result($query, 0, "PageType");
		
			$TypeFolder = "lighthouses";
		
		$folderLocation = "../resources/images/".$TypeFolder."/".str_replace(" ", "-", $Name)."/";
		if(!file_exists($folderLocation))
		{
			mkdir($folderLocation, 0777);
		}	
		
		function findFileExtension($filename) 
		{ 
			 $filename = strtolower($filename) ; 
			 $exts = split("[/\\.]", $filename) ; 
			 $n = count($exts)-1; 
			 $exts = $exts[$n]; 
			 return $exts; 
		}	 


		 //Thumbnail 1
		 $thumbnail1Extension = findFileExtension($_FILES['Thumbnail1']['name']);
		 $thumbnail1Name = str_replace(" ", "-", $name)."-Thumbnail-".$FirstSetNumber.".".$thumbnail1Extension;
		 $thumbnail1Location = $folderLocation.$thumbnail1Name;
		 $URLThumbnail1 = str_replace("../", "http://www.worldwidelighthouses.com/", $thumbnail1Location);
		 		 
		 if(!move_uploaded_file($_FILES['Thumbnail1']['tmp_name'], $thumbnail1Location))
		 { 
			echo("Canny Move Thumbnail ".$FirstSetNumber);
		 } 
		 
		 //Thumbnail 2
		 $thumbnail2Extension = findFileExtension($_FILES['Thumbnail2']['name']);
		 $thumbnail2Name = str_replace(" ", "-", $name)."-Thumbnail-".$SecondSetNumber.".".$thumbnail2Extension;
		 $thumbnail2Location = $folderLocation.$thumbnail2Name;
		 $URLThumbnail2 = str_replace("../", "http://www.worldwidelighthouses.com/", $thumbnail2Location);
		 
		 if(!move_uploaded_file($_FILES['Thumbnail2']['tmp_name'], $thumbnail2Location))
		 { 
			echo("Canny Move Thumbnail ".$SecondSetNumber);
		 } 
		 
		 //Large Image 1
		 $LargeImage1Extension = findFileExtension($_FILES['LargeImage1']['name']);
		 $LargeImage1Name = str_replace(" ", "-", $name)."-LargeImage-".$FirstSetNumber.".".$LargeImage1Extension;
		 $LargeImage1Location = $folderLocation.$LargeImage1Name;
		 $URLLargeImage1 = str_replace("../", "http://www.worldwidelighthouses.com/", $LargeImage1Location);
		 
		 if(!move_uploaded_file($_FILES['LargeImage1']['tmp_name'], $LargeImage1Location))
		 { 
			echo("Canny Move Large ".$FirstSetNumber);
		 } 
		 
		 //Large Image 2
		 $LargeImage2Extension = findFileExtension($_FILES['LargeImage2']['name']);
		 $LargeImage2Name = str_replace(" ", "-", $name)."-LargeImage-".$SecondSetNumber.".".$LargeImage2Extension;
		 $LargeImage2Location = $folderLocation.$LargeImage2Name;
		 $URLLargeImage2 = str_replace("../", "http://www.worldwidelighthouses.com/", $LargeImage2Location);
		 
		 if(!move_uploaded_file($_FILES['LargeImage2']['tmp_name'], $LargeImage2Location))
		 { 
			echo("Canny Move Large ".$SecondSetNumber);
		 }
					 
		 $FirstSetNumber = $FirstSetNumber + 2;
		 $SecondSetNumber = $SecondSetNumber + 2;
			
		 $ThumbnailImagesJSONfromDB = mysql_result($query, 0, "SmallImages");
		 $LargeImagesJSONfromDB = mysql_result($query, 0, "LargeImages");
  	 
		 //Thumbnails
		 if(empty($ThumbnailImagesJSONfromDB))
		 {
		 	$ThumbnailsDeJSONed = array();
		 	$ThumbnailsDeJSONed[] = $URLThumbnail1;
		 	$ThumbnailsDeJSONed[] = $URLThumbnail2;
		 }
		 else
		 {
		 	$ThumbnailsDeJSONed = json_decode($ThumbnailImagesJSONfromDB);
		 	$ThumbnailsDeJSONed[] = $URLThumbnail1;
		 	$ThumbnailsDeJSONed[] = $URLThumbnail2;
		 }
		 $ThumbsForDB = json_encode($ThumbnailsDeJSONed);
		 
		 //Large
		 if(empty($LargeImagesJSONfromDB))
		 {
		 	$LargeDeJSONed = array();
		 	$LargeDeJSONed[] = $URLLargeImage1;
		 	$LargeDeJSONed[] = $URLLargeImage2;
		 }
		 else
		 {
		 	$LargeDeJSONed = json_decode($LargeImagesJSONfromDB);
		 	$LargeDeJSONed[] = $URLLargeImage1;
		 	$LargeDeJSONed[] = $URLLargeImage2;
		 }
		 $LargeForDB = json_encode($LargeDeJSONed);	
		 	 
		 mysql_query("UPDATE Lighthouses SET SmallImages='".$ThumbsForDB."', LargeImages='".$LargeForDB."' WHERE Name='".$Name."'") or die(mysql_error()); 
	}
		
	if($SecondSetNumber > $NumberImages)
	{	
		$content = '<h2 class="greenTitle">Upload Complete</h2><div class="greenTextbox"><p>All Images Uploaded.</p></div>';	 
	}
	else
	{ 
		//Image Upload Form
		$content = '
			<h2 class="greenTitle">Upload Thumbnails</h2>
			<div class="greenTextbox">
				<form method="post" enctype="multipart/form-data" method="http://www.worldwidelighthouses.com/Admin/Admin_Thumbnails.php">
					<label for="Thumbnail1">Thumbnail '.$FirstSetNumber.'</label>
					<input type="file" name = "Thumbnail1" id="Thumbnail1">
					
					<label for="LargeImage1">Large Image '.$FirstSetNumber.'</label>
					<input type="file" name = "LargeImage1" id="LargeImage1">
					
					
					<label for="Thumbnail2">Thumbnail '.$SecondSetNumber.'</label>
					<input type="file" name = "Thumbnail2" id="Thumbnail2">
					
					<label for="LargeImage2">Large Image '.$SecondSetNumber.'</label>
					<input type="file" name = "LargeImage2" id="LargeImage2">
					
					<input type="hidden" name="Uploading" value="true">
					<input type="hidden" name="Name" value="'.$Name.'">
					<input type="hidden" name="NumberImages" value="'.$NumberImages.'">
					<input type="hidden" name="FirstSetNumber" value="'.$FirstSetNumber.'">
					<input type="hidden" name="SecondSetNumber" value="'.$SecondSetNumber.'">
					
					<input type="submit" value="Upload Images">
				</form>
			</div>
		';
	}
	
	//Mobile Front Page
	if(mobile_device_detect(true,true,true,true,true,true,true,false,false))
	{
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
						<script src="../resources/js/desktop.js"></script>
						</body>';
			}
				//Remove all whitespace from code. Making it smaller
				
				$pageCode = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $pageCode);
				$pageCode = trim($pageCode);
				echo $pageCode;	
?>