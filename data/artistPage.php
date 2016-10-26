<?php
require('../kernel/core.php');
if($_GET['name'] == null || $db->query('SELECT id FROM artists WHERE keyname="'.$_GET['name'].'"')->num_rows == 0)
{
	echo null;
}
else
{
	$artistData = $db->query('SELECT id,keyname,name,genres FROM artists WHERE keyname="'.$_GET['name'].'"')->fetch_array();
	/* Genres */
	$artistGenres = explode(';',$artistData['genres']);
	$artistGenresStr = null; $i = 0;
	foreach($artistGenres as $genre)
	{
		if($i != 0)
		{
			$artistGenresStr .= ',';
		}
		$artistGenresStr .= '"'.$genre.'"';
		$i++;
	}
	/* Albums */
	$artistAlbums = $db->query('SELECT id,name FROM albums WHERE artistId='.$artistData['id']);
	$artistAlbumsStr = null;
	$iAlbums = 0;
	while($album = $artistAlbums->fetch_array())
	{
		$iSongs = 0;
		$albumSongs = $db->query('SELECT id,name FROM songs WHERE albumId='.$album['id']);
		$albumSongsStr = null;
		while($song = $albumSongs->fetch_array())
		{
			if($iSongs != 0)
			{
				$albumSongsStr .= ',';
			}	
			$albumSongsStr .= '{
				"image": "data/images/'.$artistData['keyname'].'/'.$album['name'].'/cover.jpg",
				"artist": "'.$artistData['name'].'",
				"url": "data/songs/'.$artistData['keyname'].'/'.$album['name'].'/'.$song['name'].'.mp3",
				"displayName": "'.$song['name'].'",
				"type": "audio/mpeg"
			  }';
			  $iSongs++;
		}
		if($iAlbums != 0)
		{
			$artistAlbumsStr .= ',';
		}
		$artistAlbumsStr .= '{
        "album_name": "'.$album['name'].'",
        "album_image": "data/images/'.$artistData['keyname'].'/'.$album['name'].'/cover.jpg",
        "album_release": "April 2010",
        "songs": [
          '.$albumSongsStr.'
        ]
      }';
	  $iAlbums++;
	}
	echo '[
  {
    "url_name": "'.$artistData['keyname'].'",
    "name": "'.$artistData['name'].'",
    "banner": "data/images/'.$artistData['keyname'].'/banner.jpg",
    "image": "data/images/'.$artistData['keyname'].'/cover.jpg",
    "genre": [
      '.$artistGenresStr.'
    ],
    "albums": [
      '.$artistAlbumsStr.'
    ]
  }
]';
}
?>