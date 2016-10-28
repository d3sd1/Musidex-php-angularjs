<?php
session_start();
$config = parse_ini_file('config.conf');
require('class/database.php');
/* Language */
switch(@substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))
{
	case 'es':
	$lang = json_decode(utf8_encode(file_get_contents(__DIR__ .'/../kernel/langs/es.json')),true);
	break;
	default:
	$lang = json_decode(utf8_encode(file_get_contents(__DIR__ .'/../kernel/langs/'.$config['default.lang'].'.json')),true);
	break;
}