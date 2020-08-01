<?php	
	// Grab post data
	
	//Type of Edit
	$editType = $_POST['EditType'];
	$editID = $_POST['EditID'];	
	
	//BASICS
	$name = $_POST['LightName'];
	$pageType = $_POST['PageType'];
	
	//SideBar
	$established = $_POST['DateEstablished'];	
	$currentLighthouseBuilt = $_POST['DateCurrentLighthouseBuilt'];
	$electrified = $_POST['DateElectrified'];
	$automated = $_POST['DateAutomated'];
	$decommissioned = $_POST['DateDecommissioned'];
	$demolished = $_POST['DateDemolished'];
	$operator = $_POST['Operator'];
	$designer = $_POST['Designer'];
	$URLVideo = $_POST['URLVideo'];
	$URLAudio = $_POST['URLAudio'];
	$NumberImages = $_POST['NumberOfThumbnails'];
	$height = $_POST['Height'];
	
	//LIGHT INFORMATION
	$i = 1;
	
	$lightInformationColour = array();
	$lightInformationDistance = array();
	$lightInformationArcStart = array();
	$lightInformationArcEnd = array();
	
	while($i <= 10)
	{	
		$colourValue = $_POST["Color".$i];		
		$lightInformationColour[] = $colourValue;

		$distanceValue = $_POST["Distance".$i];
		$lightInformationDistance[] = $distanceValue;
		
		$arcStartValue = $_POST["ArcStart".$i];
		$lightInformationArcStart[] = $arcStartValue;
	
		$arcFinishValue = $_POST["ArcEnd".$i];
		$lightInformationArcEnd[] = $arcFinishValue;
		
		$i++;	
	}	
	unset($value);
	unset($i);
		
	$i = 0;
	$allLightInformation = array();
	while($i <= 9)
	{
		$allLightInformation[$i]["Colour"] = $lightInformationColour[$i];
		$allLightInformation[$i]["Distance"] = $lightInformationDistance[$i];
		$allLightInformation[$i]["ArcStart"] = $lightInformationArcStart[$i];
		$allLightInformation[$i]["ArcEnd"] = $lightInformationArcEnd[$i];
		$i++;
	}
	$rangesJSON = json_encode($allLightInformation);
	
	if($editType == "Edit")
	{
		//We're editing an already created page, lets grab the information we already have on it.
		ConnectToDB();
		$query = "Select * From Lighthouses WHERE ID=".$editID;
		$result = mysql_query($query);
	}
	
	//Allowed File Extensions
	$allowedExtensions = array("png", "jpg", "gif");

	function isAllowedExtension($fileName)
	{
	  global $allowedExtensions;
	  return in_array(end(explode(".", $fileName)), $allowedExtensions);
	}	

	
	//Move Uploaded Files to Correct Place
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
	 if($editType != "Edit" || ($editType == "Edit" && !empty($_FILES['ThumbnailImage'])))
	 {
		 $thumbnailExtension = findFileExtension($_FILES['ThumbnailImage']['name']);
		 $thumbnailName = str_replace(" ", "-", $name)."-Thumbnail.".$thumbnailExtension;
		 $thumbnailLocation = "../resources/images/thumbnails/".$thumbnailName;
		 $URLThumbnail = str_replace("../", "http://www.worldwidelighthouses.com/", $thumbnailLocation);
		 
		 if(!move_uploaded_file($_FILES['ThumbnailImage']['tmp_name'], $thumbnailLocation))
		 { 
			die("Issue uploading the Thumbnail Image. It is required, please try again.");
		 }
	 } 
	 
 	 //Main Picture
 	 if($editType != "Edit" || ($editType == "Edit" && !empty($_FILES['MainPagePicture'])))
	 {
		 $mainPictureExtension = findFileExtension($_FILES['MainPagePicture']['name']);
		 $mainPictureName = str_replace(" ","-",$name)."-Main-Picture.".$mainPictureExtension;
		 $mainPictureLocation = "../resources/images/main-page-pictures/".$mainPictureName;
		 $URLMainPagePicture = str_replace("../","http://www.worldwidelighthouses.com/",$mainPictureLocation);
		 if(!move_uploaded_file($_FILES['MainPagePicture']['tmp_name'], $mainPictureLocation))
		 {
			die("Issue uploading the main page picture. It is required, please try again.");
		 }
	 }
	    
	//Add HTML Paragraphs to the Write Up
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
	
	$WriteUp = nl2p($WriteUp, false, false);
	
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
	if($editType == "Edit")
	{
		//Edit the existing page, selecting it by its ID number
		mysql_query(
			"UPDATE Lighthouses SET 
			    LastestUpdate='".date("Y-m-d H:i:s")."', 
			    Name='".$name."', 
			    PageType='".$pageType."',
			    Thumbnail='".$URLThumbnail."', 
			    MainPicture='".$URLMainPagePicture."', 
			    DateEstablished='".$established."', 
			    DateCurrentLighthouseBuilt='".$currentLighthouseBuilt."', 
			    DateAutomated='".$automated."', 
			    DateElectrified='".$electrified."', 
			    Height='".$height."', 
			    Ranges='".$rangesJSON."', 
			    Operator = '".$operator."', 
			    Designer='".$designer."', 
			    URLVideo='".$URLVideo."', 
			    URLAudio='".$URLAudio."', 
			    WriteUp='".$WriteUp."' 
			WHERE ID=".$editID) or die(mysql_error());  
	}
	else
	{
		//Create a new page
		mysql_query("INSERT INTO  `Lighthouses` (`PageCreated` ,  `LastestUpdate` ,  `Name` ,  `PageType` ,  `Thumbnail` ,  `MainPicture` ,  `DateEstablished` ,  `DateCurrentLighthouseBuilt` ,  `DateAutomated` ,  `DateElectrified` ,  `Height` ,  `Ranges` ,  `Operator` , `Designer` ,  `URLVideo` ,  `URLAudio` ,  `WriteUp`) VALUES ('".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$name."',  '".$pageType."',  '".$URLThumbnail."',  '".$URLMainPagePicture."',  '".$established."',  '".$currentLighthouseBuilt."',  '".$automated."', '".$electrified."',  '".$height."',  '".$rangesJSON."',  '".$operator."',  '".$designer."',  '".$URLVideo."',  '".$URLAudio."',  '".$WriteUp."')") or die(mysql_error());
	}
	mysql_close();
	
	header("Location: http://www.worldwidelighthouses.com/Admin/Admin_Thumbnails.php?name=".$name."&numberImages=".$NumberImages);
?>