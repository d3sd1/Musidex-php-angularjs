<?php
require('../../kernel/core.php');
$from_angular = json_decode( file_get_contents('php://input') );
if(@$from_angular->artistName != null)
{
	$musidexSessions::setSession('lastartistpage',$from_angular->artistName);
}
?>