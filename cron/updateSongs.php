<?php
$url = 'http://musicbrainz.org/ws/1/track/'.'d615590b-1546-441d-9703-b3cf88487cbd'."?type=xml&inc=";
	  
           
	   $xml = simplexml_load_file($url);
	   if($xml === false){
	   	throw new Exception("Unable to load XML file. URL: ".$url);
	   }
	   $track = $this->parseTrackXML($xml->track);
	   return $track;
?>