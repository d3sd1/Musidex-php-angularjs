<?php
require('../../kernel/core.php');
if(isset($_POST)){
	$errors = null;
	if(!isset($_POST['loginFormEmail']) or $_POST['loginFormEmail'] == null or strlen($_POST['loginFormEmail']) > 200 or !filter_var($_POST['loginFormEmail'], FILTER_VALIDATE_EMAIL) or $db->query('SELECT id FROM users WHERE email="'.$_POST['loginFormEmail'].'"')->num_rows == 0)
	{
		$errors .= 'EMAIL|||'.$lang['notify.login.emailNotFound'];
    }
	else
	{
		$email = $_POST['loginFormEmail'];
	}
	
	if(!isset($_POST['loginFormPassword']) or $_POST['loginFormPassword'] == null)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		$errors .= 'PASSWORD|||'.$lang['notify.login.passwordNotSent'];
    }
	else
	{
		$password = $_POST['loginFormPassword'];
	}
	$securimage = new Securimage();
	if(!isset($_POST['loginFormCaptcha']) or $_POST['loginFormCaptcha'] == null)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		$errors .= 'CAPTCHA|||'.$lang['notify.login.captchaNotSent'];
    }
	elseif($securimage->check($_POST['loginFormCaptcha']) == false)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		$errors .= 'CAPTCHA|||'.str_replace(array('{attemptNum}','{attemptLimit}'),array(sessionManager::getSession('securimage_code_attempts'),Securimage::$maxAttemptsPerCaptcha),$lang['notify.login.attempt']);
		if(sessionManager::getSession('securimage_code_attempts') > Securimage::$maxAttemptsPerCaptcha)
		{
			$errors = 'BOT_DETECTED';
		}
	}
	if($errors == null)
	{
		if($db->query('SELECT id FROM users WHERE email="'.$_POST['loginFormEmail'].'" AND password="'.sha1($_POST['loginFormPassword']).'"')->num_rows == 0)
		{
			$errors = 'PASSWORD|||'.$lang['notify.login.passwordNotMatch'];
		}
	}
        if($errors != null){
			echo 'ERROR:::'.$errors;
    }else{
		$musidexSessions::setCookie('email',$email);
		$musidexSessions::setCookie('time',time());
		$userData = $db->query('SELECT image,name,id FROM users WHERE email="'.$_POST['loginFormEmail'].'" AND password="'.sha1($_POST['loginFormPassword']).'"')->fetch_row();
		echo 'SUCCESS:::'.$musidexTemplate::loggedInUserMenu(str_replace('{*url*}',URL,$userData[0]),$userData[1],$userData[2]).':::'.$musidexTemplate::loggedInHeaderContent();
   }
}
?>