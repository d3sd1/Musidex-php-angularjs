<?php
require('../kernel/core.php');
if(@$_GET['userKey'] != null AND $db->query('SELECT id FROM users WHERE id="'.@$_GET['userKey'].'"')->num_rows != 0)
{
	//personalized songs for the user
}
else
{
	$songs = $db->query('SELECT id,name,albumId FROM topSongs ORDER BY playTimes DESC LIMIT '.$config['default.index.songList']);
	echo '[';
	$iSongs = 0;
	while($song = $songs->fetch_array())
	{
		if($iSongs != 0)
		{
			echo ',';
		}
		$albumInfo = $db->query('SELECT name,artistId FROM albums WHERE id='.$song['albumId'])->fetch_array();
		$artistInfo = $db->query('SELECT name,keyname FROM artists WHERE id='.$albumInfo['artistId'])->fetch_array();
		echo '{
		"url_name": "'.$artistInfo['keyname'].'",
		"artist": "'.$artistInfo['name'].'",
		"song": "'.$song['name'].'",
		"album": "'.$albumInfo['name'].'",
		"genre": ["Rock","Hard rock","Heavy Metal"]
		}';
		$iSongs++;
	}
	echo ']';
}
?>