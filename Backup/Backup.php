<?php
	//This here PHP Application backs up worldwide lighthouses to a zip folder.
	
	//First things first, lets make a .zip folder using the current date and time as a file name
	$zipFolderFileName = "Worldwide-Lighthouses-Backup-at-".date("d-F-Y--g-ia").".zip";
	echo $zipFolderFileName;
	
	//Send the whole root of the web server to the new zip
	$folders = array("Admin", "Buoys", "Daymarks", "Fog-Signals", "Glossary", "Lighthouses", "Lightships", "Scripts");
	
	foreach($folders as &$folder)
	{
		Zip("../".$folder, $folder.".zip");	
	}
	//Zip("../resources/css", "Resources/CSS.zip");
	
	mkdir($zipFolderName);
	
	foreach($folders as &$folder)
	{
		if (copy($folder.".zip", $zipFolderName."/".$folder.".zip")) 
		{
		  unlink($folder.".zip");
		}
	}
	
	//Function to [recursively] Zip a directory in PHP
	function Zip($source, $destination)
	{
	    if (!extension_loaded('zip') || !file_exists($source)) 
	    {
	        return false;
	    }
	
	    $zip = new ZipArchive();
	    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) 
	    {
	        return false;
	    }
	
	    $source = str_replace('\\', '/', realpath($source));
	
	    if (is_dir($source) === true)
	    {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
	
	        foreach ($files as $file)
	        {
	            $file = str_replace('\\', '/', realpath($file));
	
	            if (is_dir($file) === true)
	            {
	                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
	            }
	            else if (is_file($file) === true)
	            {
	                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
	            }
	        }
	    }
	    else if (is_file($source) === true)
	    {
	        $zip->addFromString(basename($source), file_get_contents($source));
	    }
	
	    return $zip->close();
	}
	
	echo 'You can now download all worldwide lighthouses content from <a href="'.$zipFolderFileName.'">here</a>';
?>
