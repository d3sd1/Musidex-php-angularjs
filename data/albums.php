<?php
require('../kernel/core.php');
if($_GET['userKey'] != null || $db->query('SELECT id FROM users WHERE id="'.$_GET['userKey'].'"')->num_rows == 0)
{
	echo null;
}
else
{
	$albums = $db->query('SELECT id,name FROM albums ORDER BY playTimes DESC');
	$artistAlbumsStr = null;
	$iAlbums = 0;
	while($album = $albums->fetch_array())
	{
	echo '[
  {
    "url_name": "scorpions",
    "artist": "Scorpions",
    "name": "Love at First Sting",
    "image": "cover.jpg",
    "genre": ["Rock","Hard rock","Heavy Metal"]
  },
  {
    "url_name": "megadeth",
    "artist": "Megadeth",
    "name": "Holy wars... The punishment due",
    "image": "cover.jpg",
    "genre": ["Trash metal","Heavy metal"]
  }
	]';
	}
}
?>