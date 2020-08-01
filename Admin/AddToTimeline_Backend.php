<?php
	//Get Libraries
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/mobile_device_detect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Scripts/WideImage/WideImage.php');

	$Title = $_POST['Title'];
	$WriteUp = $_POST['WriteUp'];
	$Link = $_POST['Link'];
	$Year = $_POST['Year'];
	$Month = $_POST['Month'];
	$Day = $_POST['Day'];
	
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
	
	$WriteUp = nl2p($WriteUp, false);
	
	//Get POST Images & Move them.
	function findFileExtension($filename) 
	{ 
	 	$filename = strtolower($filename) ; 
	 	$exts = split("[/\\.]", $filename) ; 
		$n = count($exts)-1; 
		$exts = $exts[$n]; 
		return $exts; 
	}
	
	//Thumbnail
	$thumbnailExtension = findFileExtension($_FILES['Thumbnail']['name']);
	$thumbnailName = str_replace(" ", "-", $Title)."-Thumbnail.".$thumbnailExtension;
	$thumbnailLocation = "../resources/images/timeline-images/".$thumbnailName;
	$ThumbnailURL = str_replace("../", "http://www.worldwidelighthouses.com/", $thumbnailLocation); 
	 
	if(!move_uploaded_file($_FILES['Thumbnail']['tmp_name'], $thumbnailLocation))
	{ 
		die("Canny Move Thumb");
	} 
	
	//Store To Database
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
	mysql_query("INSERT INTO  `Timeline` (  `ID` ,  `DateCreated` ,  `LatestUpdate` ,  `Date` ,  `Title` ,  `Thumbnail` ,  `WriteUp` ,  `Link` ) VALUES ('ID',  '', CURRENT_TIMESTAMP ,  '".$Year."-".$Month."-".$Day."',  '".$Title."',  '".$ThumbnailURL."',  '".$WriteUp."',  '".$Link."')") or die(mysql_error());
	mysql_close();	
?>