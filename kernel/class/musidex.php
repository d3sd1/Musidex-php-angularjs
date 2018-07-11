<?php
$musidex = new musidex();
$musidexSessions = new sessionManager();
$musidexLogin = new login();
$musidexTemplate = new template();
define('sessionHashRSA1', 9990454949);
define('sessionHashRSA2', 9990450271);
define('URL','http://'.$config['domain']);
if(isset($_SERVER['DOCUMENT_ROOT']))
{
	define('HOME',$_SERVER['DOCUMENT_ROOT']);
}
else
{
	define('HOME',null); //Cron, pc, bot
	die();
}
class musidex
{
	public static function hashProfileIdUrl($n) //Hash codifier and decodifier at same time
	{
		return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
	}
	public static function formatKeyname($str)
	{
		return str_replace(' ',null,strtolower($str));
	}
}
class login extends musidex
{
	public static function isLogged()
	{
		if(sessionManager::issetCookie(('email')))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
class sessionManager extends musidex
{
	public static function setSession($sessionName, $sessionValue)
	{
		$_SESSION[sessionManager::crypt('encrypt',$sessionName)] = sessionManager::crypt('encrypt', $sessionValue);
	}
	public static function delSession($sessionName)
	{
		unset($_SESSION[$sessionName]);
	}
	public static function getSession($sessionName)
	{
		return sessionManager::crypt('decrypt', $_SESSION[sessionManager::crypt('encrypt',$sessionName)]);
	}
	public static function issetSession($sessionName)
	{
		if(isset($_SESSION[sessionManager::crypt('encrypt',$sessionName)]) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public static function setCookie($sessionName, $sessionValue)
	{
		global $config;
		if(empty($_COOKIE[$sessionName]))
		{
			setcookie(sessionManager::crypt('encrypt', $sessionName),sessionManager::crypt('encrypt', $sessionValue),time()+60*60*24*30*12,"/",$config['domain'],false,true);
		}
		else
		{
			unset($_COOKIE[$sessionName]);
			setcookie(sessionManager::crypt('encrypt', $sessionName),sessionManager::crypt('encrypt', $sessionValue),time()+60*60*24*30*12,"/",$config['domain'],false,true);
		}
	}
	public static function getCookie($sessionName)
	{
		return $_COOKIE[sessionManager::crypt('encrypt',$sessionName)];
	}
	public static function delCookie($sessionName)
	{
		global $config;
		setcookie(sessionManager::crypt('encrypt', $sessionName),null,0,"/",$config['domain'],false,true);
	}
	public static function issetCookie($sessionName)
	{
		if(isset($_COOKIE[sessionManager::crypt('encrypt',$sessionName)]) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public static function crypt($action, $string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
}
class template extends musidex
{
	public static function loggedInUserMenu($userImage,$userName,$userId)
	{
		return '<div class="nav-user-menu sidebar-nav-content" id="navigationHeaderUserMenu">
			<ul class="sidebar-nav-menu" data-highlight-active>
			  <li id="user-menu" class="nav-item">
				<div class="actions">
				  <a class="action-btn" href="'.URL.'/#/logout">
					<i class="action-icon fa fa-sign-out"></i>
				  </a>
				</div>
				<a class="nav-link profile" href="#/profile/'.musidex::hashProfileIdUrl($userId).'">
				  <img src="'.$userImage.'" alt="" class="img20_20 img-circle">
				  <span class="label helper-tooltip-measured">'.$userName.'</span>
				</a>

			  </li>
			</ul>
      </div>';
	}
	public static function loggedOutHeaderSignIn() //HAS TO BE WITH " AND NEVER WITH ' ON THE RETURN AND ON A SINGLE LANE
	{
		return '<li><a href="'.URL.'/#/login"><i class="fa fa-sign-in color-default"></i></a></li>';
	}
	public static function loggedInHeaderContent()
	{
		return '<li>
		  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-bell color-default"></i>
		  </a>

		  <div class="dropdown-menu pull-right with-arrow panel panel-default">
			<div class="panel-heading">
			  You have 2 notifications.
			</div>
			<ul class="list-group">
			  <li class="list-group-item">
				<a href="javascript:;" class="media">
										<span class="pull-left media-icon">
											<span class="circle-icon sm bg-info"><i class="fa fa-comment-o"></i></span>
										</span>

				  <div class="media-body">
					<span class="block">Jane sent you a message</span>
					<span class="text-muted">3 hours ago</span>
				  </div>
				</a>
			  </li>
			  <li class="list-group-item">
				<a href="javascript:;" class="media">
										<span class="pull-left media-icon">
											<span class="circle-icon sm bg-danger"><i class="fa fa-comment-o"></i></span>
										</span>

				  <div class="media-body">
					<span class="block">Lynda sent you a mail</span>
					<span class="text-muted">9 hours ago</span>
				  </div>
				</a>
			  </li>
			</ul>
			<div class="panel-footer">
			  <a href="javascript:;">Show all messages.</a>
			</div>
		  </div>
		</li>
	  <li><a href="javascript:;" data-ng-click="actions.toggleChat()" tooltip-placement="left" tooltip="Toggle chat" tooltip-append-to-body="true">
		  <i class="fa fa-comments-o color-default"></i>
		</a>
	  </li>';	
	}
}
if($musidexLogin::isLogged() === true)
{
	define('USER_LOGGED_IN',true);
	$userInfo = $db->query('SELECT id,name,email,image FROM users WHERE email="'.sessionManager::crypt('decrypt',sessionManager::getCookie('email')).'"')->fetch_row();
	$userId = $userInfo[0];
	$userName = $userInfo[1];
	$userEmail = $userInfo[2];
	$userImage = str_replace('{*url*}',URL,$userInfo[3]);
}
else
{
	define('USER_LOGGED_IN',false);
}