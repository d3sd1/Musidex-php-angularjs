<?php
require('../../kernel/core.php');
if(USER_LOGGED_IN == true)
{
	if(!empty(@$_GET['id']) && is_numeric(@$_GET['id']))
	{
		if($db->query('SELECT id FROM artists WHERE id="'.$_GET['id'].'"')->num_rows > 0)
		{
			if($db->query('SELECT id FROM usersFollowingArtist WHERE userId="'.$userId.'" AND artistId="'.$_GET['id'].'"')->num_rows == 0) //Follow artist
			{
				$db->query('INSERT INTO usersFollowingArtist (userId,artistId) VALUES ("'.$userId.'","'.$_GET['id'].'")') or die($db->error);
				echo $lang['artist.follow.following'].':'.str_replace('{name}',$db->query('SELECT name FROM artists WHERE id="'.$_GET['id'].'"')->fetch_row()[0],$lang['artist.follow.followingNotify']).':success:btn btn-primary';
			}
			else //Unfollow artist
			{
				$db->query('DELETE FROM usersFollowingArtist WHERE userId="'.$userId.'" AND artistId="'.$_GET['id'].'"') or die($db->error);
				echo $lang['artist.follow.notfollowing'].':'.str_replace('{name}',$db->query('SELECT name FROM artists WHERE id="'.$_GET['id'].'"')->fetch_row()[0],$lang['artist.follow.unfollowingNotify']).':error:btn btn-default';
			}
		}
		else
		{
			echo $lang['artist.follow.errorfollowing'].':'.$lang['artist.follow.errorfollowingNotify'].':error';
		}
	}
	else
	{
		echo $lang['artist.follow.errorfollowing'].':'.$lang['artist.follow.errorfollowingNotify'].':error';
	}
}
else
{
	echo $lang['artist.follow.errorfollowing'].':'.$lang['artist.follow.errorfollowingNotify'].':error';
}
?>