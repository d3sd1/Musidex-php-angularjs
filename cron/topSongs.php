<?php
require('../kernel/core.php');
$limitTopSongs = $config['default.index.songList'];
$db->query('TRUNCATE TABLE topSongs');
$topRankedSongs = $db->query('SELECT id,name,albumId,playTimes FROM songs ORDER BY playTimes DESC LIMIT '.$limitTopSongs);
$rank = 1; //Start range for ranking. Default should be 1.
while($rankedSong = $topRankedSongs->fetch_array())
{
	$db->query('INSERT INTO topSongs (albumId,name,playTimes,rank) VALUES ("'.$rankedSong['albumId'].'","'.$rankedSong['name'].'","'.$rankedSong['playTimes'].'",'.$rank.')') or die($db->error);
	$rank++;
}
?>